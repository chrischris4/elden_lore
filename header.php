<div id="header">
    <nav>
        <div>
            <ul>
                <?php if (!isset($_SESSION['LOGGED_USER'])) : ?>
                    <li>
                        <a href="#" id="loginLink">CONNEXION</a>
                    </li>
                    <li>
                        <a href="#" id="subLink">CREE UN COMPTE</a>
                    </li>
                <?php endif; ?>
                <?php if (isset($_SESSION['LOGGED_USER'])) : ?>
                    <li class="loggedLink">
                        <a href="items_create.php" id="createLink">AJOUTEZ UN ARTICLE</a>
                    </li>
                    <li>
                        <a href="logout.php">DECONNEXION</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
</div>
