<?php
session_start();

require_once(__DIR__ . '/isConnect.php');
require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/config/databaseconnect.php');
require_once(__DIR__ . '/functions.php');

/**
 * On ne traite pas les super globales provenant de l'utilisateur directement,
 * ces données doivent être testées et vérifiées.
 */
$postData = $_POST;

// Vérification du formulaire soumis
if (
    empty($postData['title'])
    || empty($postData['info_item'])
    || empty($postData['category'])
    || trim(strip_tags($postData['title'])) === ''
    || trim(strip_tags($postData['info_item'])) === ''
    || trim(strip_tags($postData['category'])) === ''
) {
    echo 'Il faut un titre, une description et une categorie pour continuer';
    return;
}

$title = trim(strip_tags($postData['title']));
$info_item = trim(strip_tags($postData['info_item']));
$category = trim(strip_tags($postData['category']));

// Gestion de l'image uploadée
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
$insertItem = $mysqlClient->prepare('INSERT INTO items(title, info_item, author, is_enabled, category, picture) VALUES (:title, :info_item, :author, :is_enabled, :category, :picture)');
$insertItem->execute([
    'title' => $title,
    'info_item' => $info_item,
    'is_enabled' => 1,
    'author' => $_SESSION['LOGGED_USER']['pseudo'],
    'category' => $category,
    'picture' => $picture_path
]);

redirectToUrl('index.php');
?>
