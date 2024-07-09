<!-- Si utilisateur/trice est non identifié(e), on affiche le formulaire -->
<?php if (!isset($_SESSION['LOGGED_USER'])) : ?>
    <div id="modalOverlay"></div>
    <div id="modalLogin">
        <div class="modalForm">
            <div class="loginForm">
                <span class="material-symbols-rounded" id="loginClose">
                    close
                </span>
                <h2>Connexion</h2>
                <form action="submit_login.php" method="POST">
                    <!-- si message d'erreur on l'affiche -->
                    <?php if (isset($_SESSION['LOGIN_ERROR_MESSAGE'])) : ?>
                        <div class="loginError" role="alert">
                            <?php echo $_SESSION['LOGIN_ERROR_MESSAGE'];
                            unset($_SESSION['LOGIN_ERROR_MESSAGE']); ?>
                        </div>
                    <?php endif; ?>
                    <div class="formSection">
                        <label for="pseudo" class="formLabel">Pseudo</label>
                        <input type="text" class="formControl" id="pseudo" name="pseudo" placeholder="Votre pseudo">
                    </div>
                    <div class="formSection">
                        <label for="password" class="formLabel">Mot de passe</label>
                        <input type="password" class="formControl" id="password" name="password" placeholder="Votre mot de passe">
                    </div>
                    <button type="submit" class="formBtn">Se connecter</button>
                </form>
            </div>
            <div class="modalDesign">
                <img class="loginImg" src="https://i.ibb.co/HrNxbD5/subscribe-1-1.jpg" alt="">
            </div>
        </div>

    </div>
<?php else : ?>
<?php endif; ?>