<?php

require_once(__DIR__ . '/config/databaseconnect.php');


// Récupération des variables à l'aide du client MySQL
$usersStatement = $mysqlClient->prepare('SELECT * FROM users');
$usersStatement->execute();
$users = $usersStatement->fetchAll();

$itemsStatement = $mysqlClient->prepare('SELECT * FROM items');
$itemsStatement->execute();
$items = $itemsStatement->fetchAll();
