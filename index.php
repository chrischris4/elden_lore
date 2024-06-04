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
    <?php require_once(__DIR__ . '/header.php'); ?>
    
    <div class="bannerContent">
        <div class="bannerOverlay"></div>
        <h1>
            <span class="titlePart">E</span>
            <span class="title">LDEN LOR</span>
            <span class="titlePart">E</span>
        </h1>
        <h2>c'est ici que les sans éclats partagent leurs connaissances concernant l'entre terre</h2>
        <input type="text" class="bannerInput" id="searchInput" placeholder="Rechercher..">
        <img src="https://i.ibb.co/SP9dgs5/8m1e66o7pyka1-1.webp" alt="elden_ring_banner" class="bannerImg">
        <div class="filter">
            <ul>
                <li><a href="#" data-category="all">TOUT</a></li>
                <li><a href="#" data-category="arme">ARMES</a></li>
                <li><a href="#" data-category="boss">BOSS</a></li>
                <li><a href="#" data-category="objet">OBJETS</a></li>
                <li><a href="#" data-category="personnage">PERSONNAGES</a></li>
                <li><a href="#" data-category="pnj">PNJ</a></li>
            </ul>
        </div>
    </div>
    
    <!-- Formulaire de connexion -->
    <?php require_once(__DIR__ . '/login.php'); ?>
    <?php require_once(__DIR__ . '/subscribe.php'); ?>
    
    <div class="allItems">
        <?php foreach (getItems($items) as $item) : ?>
            <article class="item" data-category="<?php echo strtolower($item['category']); ?>">
                <h3><a href="items_read.php?id=<?php echo($item['items_id']); ?>"><?php echo($item['title']); ?></a></h3>
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
    
    <!-- inclusion du bas de page du site -->
    <?php require_once(__DIR__ . '/footer.php'); ?>
    
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const filterLinks = document.querySelectorAll('.filter ul li a');
            const items = document.querySelectorAll('.allItems .item');
    
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
            const searchInput = document.getElementById('searchInput');
    
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
    
            // Affichage du formulaire de connexion
            const loginLink = document.getElementById('loginLink');
            const loginForm = document.getElementById('modalLogin');
            const overlay = document.getElementById('modalOverlay');
    
            loginLink.addEventListener('click', (e) => {
                e.preventDefault();
                loginForm.classList.add('show');
                overlay.classList.add('showOverlay'); // Ajoute la classe 'show'
            });
    
            // Affichage du formulaire de subscribe
            const subLink = document.getElementById('subLink');
            const subForm = document.getElementById('modalSub');
    
            subLink.addEventListener('click', (e) => {
                e.preventDefault();
                subForm.classList.add('show');
                overlay.classList.add('showOverlay'); // Ajoute la classe 'show'
            });
    
            // Fermeture du formulaire de connexion
            const subClose = document.getElementById('subClose');
    
            subClose.addEventListener('click', (e) => {
                e.preventDefault();
                subForm.classList.remove('show');
                overlay.classList.remove('showOverlay');
            });

            const loginClose = document.getElementById('loginClose');
    
            loginClose.addEventListener('click', (e) => {
                e.preventDefault();
                loginForm.classList.remove('show');
                overlay.classList.remove('showOverlay');
            });
        });
    </script>
</body>
</html>
