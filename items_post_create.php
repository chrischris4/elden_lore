<?php
session_start();

require_once(__DIR__ . '/isConnect.php');
require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/config/databaseconnect.php');

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


// Faire l'insertion en base
$insertItem = $mysqlClient->prepare('INSERT INTO items(title, info_item, author, is_enabled, category) VALUES (:title, :info_item, :author, :is_enabled, :category)');
$insertItem->execute([
    'title' => $title,
    'info_item' => $info_item,
    'is_enabled' => 1,
    'author' => $_SESSION['LOGGED_USER']['pseudo'],
    'category' => $category,
]);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elden Lore - Création d'un article</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>
<body class="d-flex flex-column min-vh-100">
    <div class="container">

        <?php require_once(__DIR__ . '/header.php'); ?>
        <!-- MESSAGE DE SUCCES -->
        <h1>Article ajouté avec succés !</h1>

        <div class="card">

            <div class="card-body">
                <h5 class="card-title"><?php echo $title ; ?></h5>
                <p class="card-text"><b>Catégorie</b> : <?php echo $category; ?></p>
                <p class="card-text"><b>Pseudo</b> : <?php echo $_SESSION['LOGGED_USER']['pseudo']; ?></p>
                <p class="card-text"><b>Article</b> : <?php echo $info_item; ?></p>
            </div>
        </div>
    </div>
    <?php require_once(__DIR__ . '/footer.php'); ?>
</body>
</html>