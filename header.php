<div id="header">
    <?php $current_url = $_SERVER['REQUEST_URI'];
    if (strpos($current_url, 'index') === false) : ?>
        <a href="index.php">
            <div class="goBackLink"><span class="material-symbols-rounded">
                    arrow_back
                </span></div>
        </a>
    <?php endif; ?>
    <h2 id="headerTitle">
        <span class="titlePart">E</span>
        <span class="title">LDEN LOR</span>
        <span class="titlePart">E</span>
    </h2>
    <div id="headerNav">
        <?php $current_url = $_SERVER['REQUEST_URI'];
        if (strpos($current_url, 'index') !== false) : ?>
            <li><a class="headerLink" href="#articlesLink">ARTICLES</a></li>
            <li><a class="headerLink" href="#loreLink">LORE</a></li>
        <?php endif; ?>
    </div>

    <div class="userSettings">
        <?php if (isset($_SESSION['LOGGED_USER'])) : ?>
            <img src="<?php echo $_SESSION['LOGGED_USER']['picture']; ?>" alt="Photo de profil" class="profilePicture">
            <ul>
                <li>
                    <a href="items_create.php" id="createLink">AJOUTEZ UN ARTICLE</a>
                </li>
                <li>
                    <a href="logout.php">DECONNEXION</a>
                </li>
            </ul>
        <?php endif; ?>
        <?php if (!isset($_SESSION['LOGGED_USER'])) : ?>

            <span class="material-symbols-rounded userIcon">
                person
            </span>
            <ul>
                <li class="loginLink">
                    <a href="#" id="loginLink">CONNEXION</a>
                </li>
                <li class="subLink">
                    <a href="#" id="subLink">CREE UN COMPTE</a>
                </li>
            </ul>
        <?php endif; ?>
    </div>
    <script>
        const header = document.getElementById('header');
        const headerTitle = document.getElementById('headerTitle');


        document.addEventListener('DOMContentLoaded', function() {
            // Récupère l'URL actuelle
            let currentUrl = window.location.href;

            // Vérifie si l'URL ne contient pas "index"
            if (!currentUrl.includes("index")) {
                // Sélectionne l'élément header par son identifiant
                let header = document.getElementById("header");
                let headerTitle = document.getElementById("headerTitle")

                // Ajoute une classe au header
                headerTitle.classList.add("showTitle")
                header.classList.add("headerStyle");
            }
        });

        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();

                // Défilement fluide vers l'élément ciblé
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>

</div>