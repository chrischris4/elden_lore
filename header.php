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
                    <li>
                        <a href="items_create.php">AJOUTEZ UN ARTICLE !</a>
                    </li>
                    <li>
                        <a href="logout.php">DECONNEXION</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <div class="ost">
        <audio id="audioPlayer" controls>
            <source src="audio/eldenSong.mp3" type="audio/mpeg">
            Votre navigateur ne prend pas en charge l'élément audio.
        </audio>
    </div>
</div>
