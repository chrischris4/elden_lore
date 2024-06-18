<?php
session_start();
require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/config/databaseconnect.php');
require_once(__DIR__ . '/variables.php');
require_once(__DIR__ . '/functions.php');

// Récupération des données du formulaire
$postData = $_POST;

// Vérification du formulaire soumis
if (
    empty($postData['pseudo'])
    || empty($postData['password'])
    || trim(strip_tags($postData['pseudo'])) === ''
    || trim(strip_tags($postData['password'])) === ''
) {
    $_SESSION['SUBSCRIBE_ERROR_MESSAGE'] = 'Il te faut un pseudo et un mot de passe pour continuer';
    header('Location: subscribe.php');
    exit();
}

$pseudo = trim(strip_tags($postData['pseudo']));
$password = trim(strip_tags($postData['password']));

// Hacher le mot de passe
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$target_dir = "uploads/";
$picture_path = null;

if (isset($_FILES['picture']) && $_FILES['picture']['error'] == UPLOAD_ERR_OK) {
    $target_file = $target_dir . basename($_FILES["picture"]["name"]);
    $pictureFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Vérifier si le fichier est une image réelle
    $check = getimagesize($_FILES["picture"]["tmp_name"]);
    if ($check !== false) {
        // Vérifier la taille du fichier (exemple : max 5MB)
        if ($_FILES["picture"]["size"] <= 5000000) {
            // Limiter certains formats de fichier
            if (in_array($pictureFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }

                if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
                    $picture_path = $target_file;
                } else {
                    echo "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
                    return;
                }
            } else {
                echo "Désolé, seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.";
                return;
            }
        } else {
            echo "Désolé, votre fichier est trop volumineux.";
            return;
        }
    } else {
        echo "Le fichier n'est pas une image.";
        return;
    }
} else {
    echo "Aucune image téléchargée.";
}

// Faire l'insertion en base
try {
    $insertItem = $mysqlClient->prepare('INSERT INTO users (pseudo, password, picture) VALUES (:pseudo, :password, :picture)');
    $insertItem->execute([
        'pseudo' => $pseudo,
        'password' => $hashedPassword,
        'picture' => $picture_path,
    ]);

    // Utilisateur bien ajouté
    $_SESSION['LOGGED_USER'] = [
        'pseudo' => $pseudo,
        'picture' => $picture_path,
    ];

    header('Location: index.php');
    exit();
} catch (Exception $e) {
    // Gestion des erreurs
    $_SESSION['SUBSCRIBE_ERROR_MESSAGE'] = 'Erreur lors de la création du compte : ' . $e->getMessage();
    header('Location: subscribe.php');
    exit();
}
?>

<!-- Formulaire d'inscription -->
<?php if (!isset($_SESSION['LOGGED_USER'])) : ?>
    <div id="modalSub">
    <div class="modalForm">
    <span class="material-symbols-rounded" id="subClose">
close
</span>
        <h2>Crée un compte</h2>
        <form action="submit_subscribe.php" method="POST">
            <!-- si message d'erreur on l'affiche -->
            <?php if (isset($_SESSION['SUBSCRIBE_ERROR_MESSAGE'])) : ?>
                <div class="subscribeError" role="alert">
                    <?php echo $_SESSION['SUBSCRIBE_ERROR_MESSAGE'];
                    unset($_SESSION['SUBSCRIBE_ERROR_MESSAGE']); ?>
                </div>
            <?php endif; ?>
            <div class="formSection">
                <label for="pseudo" class="formLabel">Pseudo</label>
                <input type="text" class="formControl" id="pseudo" name="pseudo" placeholder="Votre pseudo">
            </div>
            <div class="formSection">
                <label for="password" class="formLabel">Mot de passe</label>
                <input type="password" class="formControl" id="password" name="password">
            </div>
            <button type="submit" class="formBtn">Envoyer</button>
        </form>
    </div>
    </div>
<?php else : ?>
    <!-- Si utilisateur/trice bien connectée on affiche un message de succès -->
    <div class="loginWelcome" role="alert">
        <h2>Bonjour <?php echo $_SESSION['LOGGED_USER']['pseudo']; ?> et bienvenue sur le site !</h2>
    </div>
<?php endif; ?>
