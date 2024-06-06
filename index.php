<?php
session_start();
require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/config/databaseconnect.php');
require_once(__DIR__ . '/variables.php');
require_once(__DIR__ . '/functions.php');

$category = isset($_GET['category']) ? $_GET['category'] : null;
$items = getItems($items, $category);
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elden Lore</title>
    <link rel="stylesheet" href="styles/css/style.css">
    <link rel="stylesheet" href="styles/css/header.css">
    <link rel="stylesheet" href="styles/css/login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
    <!-- inclusion de l'entête du site -->
    <?php if (isset($_SESSION['LOGGED_USER'])) : ?>
    <?php require_once(__DIR__ . '/items_create.php'); ?>
        <?php endif; ?>
        <?php require_once(__DIR__ . '/login.php'); ?>
    <?php require_once(__DIR__ . '/subscribe.php'); ?>

        
    <?php require_once(__DIR__ . '/header.php'); ?>



    <div id="divTest">
    <div class="bannerOverlay"></div>
    <img src="https://i.ibb.co/SP9dgs5/8m1e66o7pyka1-1.webp" alt="elden_ring_banner" class="bannerTest">
    </div>
    <h2 id="headerTitle">
            <span class="titlePart">E</span>
            <span class="title">LDEN LOR</span>
            <span class="titlePart">E</span>
        </h2>
    <div class="bannerContent">
        <h1>
            <span class="titlePart">E</span>
            <span class="title">LDEN LOR</span>
            <span class="titlePart">E</span>
        </h1>
        <h2>c'est ici que les sans éclats partagent leurs connaissances concernant l'entre terre</h2>
        <input type="text" class="bannerInput" id="searchInput" placeholder="Rechercher..">
        <div id="filter">
            <ul>
                <li data-category="all">TOUT</li>
                <li data-category="arme">ARMES</li>
                <li data-category="boss">BOSS</li>
                <li data-category="objet">OBJETS</li>
                <li data-category="personnage">PERSONNAGES</li>
                <li data-category="pnj">PNJ</li>
            </ul>
        </div>
    </div>
    
    <!-- Formulaire de connexion -->
    
    <div id="allItems">
        <?php foreach (getItems($items) as $item) : ?>
            <article class="item" data-category="<?php echo strtolower($item['category']); ?>">
            <div class="articleBackground">
                <img src="https://i.ibb.co/JQWNDhW/dark-texture-watercolor-1.webp" alt="">
            </div>
                <h3><a href="items_read.php?id=<?php echo($item['items_id']); ?>"><?php echo($item['title']); ?></a></h3>
                <img src="https://i.ibb.co/SP9dgs5/8m1e66o7pyka1-1.webp" alt="elden_ring_banner" class="articleImg">

                <div class="articleInfo"><?php echo $item['info_item']; ?></div>
                <div class="authorInfo">
                <div>
                <?php if (isset($_SESSION['LOGGED_USER']) && $item['author'] === $_SESSION['LOGGED_USER']['pseudo']) : ?>
                        <a class="link-warning" href="items_update.php?id=<?php echo($item['items_id']); ?>"><span class="material-symbols-rounded editIcon">edit
</span></a>
                        <a class="link-danger" href="items_delete.php?id=<?php echo($item['items_id']); ?>"><span class="material-symbols-rounded">
delete
</span></a>
<?php endif; ?>
                </div>
                <h4><?php echo displayAuthor($item['author'], $users); ?></h4>
                </div>
            </article>
        <?php endforeach ?>
    </div>
    
    <?php require_once(__DIR__ . '/footer.php'); ?>
    
    <script>
        document.addEventListener('DOMContentLoaded', () => {
//////////////////////////////////////////////FILTERS///////////////////////////
            const filterLinks = document.querySelectorAll('#filter ul li ');
            const items = document.querySelectorAll('#allItems .item');
            const searchInput = document.getElementById('searchInput');
            const filter = document.getElementById('filter');

    
            filterLinks.forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    const category = e.target.getAttribute('data-category');
    
                    items.forEach(item => {
                        if (category === 'all' || item.getAttribute('data-category') === category) {
                            item.classList.remove('hidden');
                        } else {
                            item.classList.add('hidden');
                        }
                    });
                });
            });
    
            // Recherche d'articles par titre
            searchInput.addEventListener('input', () => {
                const searchText = searchInput.value.trim().toLowerCase();
    
                items.forEach(item => {
                    const title = item.querySelector('h3').textContent.trim().toLowerCase();
    
                    if (title.includes(searchText)) {
                        item.classList.remove('hidden');
                    } else {
                        item.classList.add('hidden');
                    }
                });
            });
    
            // Afficher tous les articles après la soumission du formulaire de recherche vide
            searchInput.addEventListener('input', () => {
                if (searchInput.value.trim() === '') {
                    items.forEach(item => {
                        item.classList.remove('hidden');
                    });
                }
            });

////////////////////////////////OPEN FORM//////////////////////////
    
            // Affichage du formulaire de connexion
            <?php if (!isset($_SESSION['LOGGED_USER'])) : ?>
            const loginLink = document.getElementById('loginLink');
            const loginForm = document.getElementById('modalLogin');
            const overlay = document.getElementById('modalOverlay');
    
            loginLink.addEventListener('click', (e) => {
                e.preventDefault();
                document.body.classList.add('no-scroll');
                loginForm.classList.add('show');
                overlay.classList.add('showOverlay'); // Ajoute la classe 'show'
            });
    
            // Affichage du formulaire de subscribe
            const subLink = document.getElementById('subLink');
            const subForm = document.getElementById('modalSub');
    
            subLink.addEventListener('click', (e) => {
                e.preventDefault();
                document.body.classList.add('no-scroll');
                subForm.classList.add('show');
                overlay.classList.add('showOverlay'); // Ajoute la classe 'show'
            });
            <?php endif; ?>


            <?php if (isset($_SESSION['LOGGED_USER'])) : ?>
            const createLink = document.getElementById('createLink');
            const createForm = document.getElementById('modalCreate');
            const overlay = document.getElementById('modalOverlay');
    
            createLink.addEventListener('click', (e) => {
                e.preventDefault();
                document.body.classList.add('no-scroll');
                createForm.classList.add('show');
                overlay.classList.add('showOverlay'); // Ajoute la classe 'show'
            });

//////////////////////////////////////////CLOSE////////////////////////////////

            const createClose = document.getElementById('createClose');
    
            createClose.addEventListener('click', (e) => {
                e.preventDefault();
                document.body.classList.remove('no-scroll');
                createForm.classList.remove('show');
                overlay.classList.remove('showOverlay');
            });
            <?php endif; ?>

    
            // Fermeture du formulaire de connexion
            const subClose = document.getElementById('subClose');
    
            subClose.addEventListener('click', (e) => {
                e.preventDefault();
                document.body.classList.remove('no-scroll');
                subForm.classList.remove('show');
                overlay.classList.remove('showOverlay');
            });

            const loginClose = document.getElementById('loginClose');
    
            loginClose.addEventListener('click', (e) => {
                e.preventDefault();
                document.body.classList.remove('no-scroll');
                loginForm.classList.remove('show');
                overlay.classList.remove('showOverlay');
            });

////////////////////////////////////////SCROLL//////////////////////////////////////////

    const divTest = document.getElementById('divTest');
    const headerTitle = document.getElementById('headerTitle');
    const allItems = document.getElementById('allItems');
    const header = document.getElementById('header');


    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            divTest.classList.add('scrolled');
            searchInput.classList.add('showTitle');
            

        } else {
            divTest.classList.remove('scrolled');
            searchInput.classList.remove('showTitle');
        }
    });

    window.addEventListener('scroll', () => {
        if (window.scrollY > 150) {
            headerTitle.classList.add('showTitle');

        } else {
            headerTitle.classList.remove('showTitle');
        }
    });

    window.addEventListener('scroll', () => {
        if (window.scrollY > 245) {
            searchInput.classList.add('showTitle');

        } else {
            searchInput.classList.remove('showTitle');
        }
    });

//////////////////////////////////FILTER
    window.addEventListener('scroll', () => {
        if (window.scrollY > 377) {
            filter.classList.add('showTitle');

        } else {
            filter.classList.remove('showTitle');
        }
    });

    window.addEventListener('scroll', () => {
        if (window.scrollY > 380) {
            header.classList.add('showTitle');

        } else {
            header.classList.remove('showTitle');
        }
    });
        });
    </script>
</body>
</html>
