<!-- Si utilisateur/trice est non identifié(e), on affiche le formulaire -->
<?php if (!isset($_SESSION['LOGGED_USER'])) : ?>
    <div id="modalSub">
        <div class="modalForm">
            <div class="loginForm">
                <span class="material-symbols-rounded" id="subClose">
                    close
                </span>
                <h2>Crée un compte</h2>
                <form action="submit_subscribe.php" method="POST" enctype="multipart/form-data">
                    <!-- si message d'erreur on l'affiche -->
                    <?php if (isset($_SESSION['SUBSCRIBE_ERROR_MESSAGE'])) : ?>
                        <div class="subscribeError" role="alert">
                            <?php echo $_SESSION['SUBSCRIBE_ERROR_MESSAGE'];
                            unset($_SESSION['SUBSCRIBE_ERROR_MESSAGE']); ?>
                        </div>
                    <?php endif; ?>
                    <div class="formSection">
                        <label for="pseudo" class="formLabel">Pseudo</label>
                        <input type="pseudo" class="formControl" id="pseudo" name="pseudo">
                    </div>
                    <div class="formSection">
                        <label for="password" class="formLabel">Mot de passe</label>
                        <input type="password" class="formControl" id="password" name="password">
                    </div>
                    <div class="formSection">
                        <label for="picture" class="formLabel">Image</label>
                        <input type="file" class="formControl" id="picture" name="picture" accept="image/*">
                    </div>
                    <button type="submit" class="formBtn">Création du compte</button>
                </form>
            </div>
            <div class="modalDesign">
                <img class="loginImg" src="https://i.ibb.co/0qv87Jq/Y5-RHNmz-Atc6s-RYw-Zl-Yi-KHAx-N-2.jpg" alt="">
            </div>
        </div>
    </div>
<?php else : ?>
<?php endif; ?>