<div id="header">
    <nav>
            <ul>
                <?php if (!isset($_SESSION['LOGGED_USER'])) : ?>
                    <?php 
                // Obtenir l'URL actuelle
                $current_url = $_SERVER['REQUEST_URI']; 
                // Vérifier si l'URL contient "index"
                if (strpos($current_url, 'index') !== false) : 
                ?>
                    <li class="loginLink">
                        <a href="#" id="loginLink">CONNEXION</a>
                    </li>
                    <li class="subLink">
                        <a href="#" id="subLink">CREE UN COMPTE</a>
                    </li>
                    <?php endif; ?>

                <?php endif; ?>

                <?php if (isset($_SESSION['LOGGED_USER'])) : ?>
                    <?php 
                // Obtenir l'URL actuelle
                $current_url = $_SERVER['REQUEST_URI']; 
                // Vérifier si l'URL contient "index"
                if (strpos($current_url, 'index') !== false) : 
                ?>
                    <li class="createLink">
                        <a href="items_create.php" id="createLink">AJOUTEZ UN ARTICLE</a>
                    </li>
                    <?php endif; ?>
                <?php endif; ?>
                <?php                 $current_url = $_SERVER['REQUEST_URI']; 
 if (strpos($current_url, 'index') === false) : ?>
                    <li class="goBackLink">
                        <a href="index.php">RETOUR</a>
                    </li>
                <?php endif; ?>
            </ul>
    </nav>
</div>
