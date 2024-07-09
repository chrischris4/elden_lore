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

if (
    !isset($postData['id'])
    || !is_numeric($postData['id'])
    || empty($postData['title'])
    || empty($postData['info_item'])
    || trim(strip_tags($postData['title'])) === ''
    || trim(strip_tags($postData['info_item'])) === ''
) {
    echo 'Il manque des informations pour permettre l\'édition du formulaire.';
    return;
}

$id = (int)$postData['id'];
$title = trim(strip_tags($postData['title']));
$info_item = trim(strip_tags($postData['info_item']));

$insertItemsStatement = $mysqlClient->prepare('UPDATE items SET title = :title, info_item = :info_item WHERE items_id = :id');
$insertItemsStatement->execute([
    'title' => $title,
    'info_item' => $info_item,
    'id' => $id,
]);

redirectToUrl('index.php');
