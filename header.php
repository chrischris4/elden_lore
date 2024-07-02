<div id="header">
<?php $current_url = $_SERVER['REQUEST_URI']; 
 if (strpos($current_url, 'index') === false) : ?>
                        <a class="goBackLink" href="index.php"><span class="material-symbols-rounded">
arrow_back
</span></a>
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

                <?php if (!isset($_SESSION['LOGGED_USER'])) : ?>
                <div class="userSettings" >
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
    </div>
                <?php endif; ?>
                <?php if (isset($_SESSION['LOGGED_USER'])) : ?>
                <div class="loginWelcome" role="alert">
        <img src="<?php echo $_SESSION['LOGGED_USER']['picture']; ?>" alt="Photo de profil" class="profilePicture">
        <ul>            
        <li class="headerLink">
                        <a href="items_create.php" id="createLink">AJOUTEZ UN ARTICLE</a>
                    </li>
        <li class="headerLink">
                    <a href="logout.php">DECONNEXION</a>
                    </li>
</ul>
    </div>
    <?php endif; ?>


</div>
