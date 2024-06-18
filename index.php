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
    
    <div id="allItems">
        <?php foreach ($items as $item) : ?>
            <article class="item" data-category="<?php echo strtolower($item['category']); ?>">
                <div class="articleBackground">
                    <img src="https://i.ibb.co/JQWNDhW/dark-texture-watercolor-1.webp" alt="">
                </div>
                <h3><a href="items_read.php?id=<?php echo($item['items_id']); ?>"><?php echo($item['title']); ?></a></h3>
                <img src="<?php echo($item['picture']); ?>" alt="elden_ring_banner" class="articleImg">
                <div class="articleInfo"><?php echo $item['info_item']; ?></div>
                <div class="authorInfo">
                    <div>
                        <?php if (isset($_SESSION['LOGGED_USER']) && $item['author'] === $_SESSION['LOGGED_USER']['pseudo']) : ?>
                            <a class="link-warning updateLink" href="items_update.php?id=<?php echo($item['items_id']); ?>">
                                <span class="material-symbols-rounded editIcon">edit</span>
                            </a>
                            <a class="link-danger deleteLink" href="items_delete.php?id=<?php echo($item['items_id']); ?>">
                                <span class="material-symbols-rounded">delete</span>
                            </a>
                        <?php endif; ?>
                    </div>
                    <h4><?php echo displayAuthor($item['author'], $users); ?></h4>
                </div>
            </article>
        <?php endforeach ?>
    </div>
    
    <?php require_once(__DIR__ . '/footer.php'); ?>

    <!-- ////////////////////////////////SCRIPT/////////////////////////////////// -->

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const overlay = document.getElementById('modalOverlay');
            const filterLinks = document.querySelectorAll('#filter ul li');
            const items = document.querySelectorAll('#allItems .item');
            const searchInput = document.getElementById('searchInput');
            const filter = document.getElementById('filter');
            const divTest = document.getElementById('divTest');
            const headerTitle = document.getElementById('headerTitle');
            const header = document.getElementById('header');

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

            searchInput.addEventListener('input', () => {
                if (searchInput.value.trim() === '') {
                    items.forEach(item => {
                        item.classList.remove('hidden');
                    });
                }
            });

            <?php if (!isset($_SESSION['LOGGED_USER'])) : ?>
            const loginLink = document.getElementById('loginLink');
            const loginForm = document.getElementById('modalLogin');
            const subLink = document.getElementById('subLink');
            const subForm = document.getElementById('modalSub');
            const subClose = document.getElementById('subClose');
            const loginClose = document.getElementById('loginClose');

            if (loginLink && loginForm) {
                loginLink.addEventListener('click', (e) => {
                    e.preventDefault();
                    document.body.classList.add('no-scroll');
                    loginForm.classList.add('show');
                    overlay.classList.add('showOverlay');
                });
            }

            if (subLink && subForm && subClose) {
                subLink.addEventListener('click', (e) => {
                    e.preventDefault();
                    document.body.classList.add('no-scroll');
                    subForm.classList.add('show');
                    overlay.classList.add('showOverlay');
                });

                subClose.addEventListener('click', (e) => {
                    e.preventDefault();
                    document.body.classList.remove('no-scroll');
                    subForm.classList.remove('show');
                    overlay.classList.remove('showOverlay');
                });
            }

            if (loginClose) {
                loginClose.addEventListener('click', (e) => {
                    e.preventDefault();
                    document.body.classList.remove('no-scroll');
                    loginForm.classList.remove('show');
                    overlay.classList.remove('showOverlay');
                });
            }
            <?php endif; ?>


            window.addEventListener('scroll', () => {
                const scrollY = window.scrollY;

                divTest.classList.toggle('scrolled', scrollY > 50);
                searchInput.classList.toggle('showTitle', scrollY > 325);
                headerTitle.classList.toggle('showTitle', scrollY > 150);
                filter.classList.toggle('showTitle', scrollY > 465);
                header.classList.toggle('showTitle', scrollY > 465);
            });
        });
    </script>
</body>
</html>
