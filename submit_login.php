<?php
session_start();
require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/config/databaseconnect.php');
require_once(__DIR__ . '/variables.php');
require_once(__DIR__ . '/functions.php');

// Récupération des données du formulaire
$postData = $_POST;

// Validation du formulaire
if (isset($postData['pseudo']) && isset($postData['password'])) {
    if (empty(trim($postData['pseudo'])) || empty(trim($postData['password']))) {
        $_SESSION['LOGIN_ERROR_MESSAGE'] = 'Il faut un pseudo et un mot de passe pour soumettre le formulaire.';
        header('Location: login.php'); // Redirection vers la page de login
        exit();
    }

    $pseudo = trim(strip_tags($postData['pseudo']));
    $password = trim(strip_tags($postData['password']));

    try {
        // Rechercher l'utilisateur dans la base de données
        $query = $mysqlClient->prepare('SELECT * FROM users WHERE pseudo = :pseudo');
        $query->execute(['pseudo' => $pseudo]);
        $user = $query->fetch();

        // Vérifier si l'utilisateur existe et si le mot de passe est correct
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['LOGGED_USER'] = [
                'pseudo' => $user['pseudo'],
                'user_id' => $user['user_id'],
                'picture' => $user['picture'], // Ajout de la photo dans la session

            ];
            redirectToUrl('index.php');
            exit();
        } else {
            $_SESSION['LOGIN_ERROR_MESSAGE'] = 'Les informations envoyées ne permettent pas de vous identifier.';
            header('Location: /'); // Redirection vers la page de login
            exit();
        }
    } catch (Exception $e) {
        $_SESSION['LOGIN_ERROR_MESSAGE'] = 'Erreur lors de la connexion : ' . $e->getMessage();
        header('Location: /'); // Redirection vers la page de login
        exit();
    }
} else {
    $_SESSION['LOGIN_ERROR_MESSAGE'] = 'Formulaire de connexion invalide.';
    header('Location: /index.php'); // Redirection vers la page de login
    exit();
}


?>
