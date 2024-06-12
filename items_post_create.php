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


// Faire l'insertion en base
$insertItem = $mysqlClient->prepare('INSERT INTO items(title, info_item, author, is_enabled, category) VALUES (:title, :info_item, :author, :is_enabled, :category)');
$insertItem->execute([
    'title' => $title,
    'info_item' => $info_item,
    'is_enabled' => 1,
    'author' => $_SESSION['LOGGED_USER']['pseudo'],
    'category' => $category,
]);

redirectToUrl('index.php');
?>

