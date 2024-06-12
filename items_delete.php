<?php
session_start();


require_once(__DIR__ . '/isConnect.php');

$getData = $_GET;

if (!isset($getData['id']) || !is_numeric($getData['id'])) {
    echo('Il faut un identifiant pour supprimer la recette.');
    return;
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elden Lore</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
    <link rel="stylesheet" href="styles/css/style.css">
    <link rel="stylesheet" href="styles/css/header.css">
    <link rel="stylesheet" href="styles/css/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>

        <div id="delete">
            <div id="deleteContent">
        <div class="deleteForm">
    <div class="loginForm">
        <a href="/index.php">
    <span class="material-symbols-rounded" id="deleteClose" >
    close
</span>
</a>
        <h1>Supprimer un article</h1>
        <form action="items_post_delete.php" method="POST">
        <div>
                <label for="id" class="form-label">Identifiant de la recette</label>
                <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $getData['id']; ?>">
            </div>
            <button type="submit" class="formBtn">Supprimer</button>
        </form>
</div>
<div class="modalDesign">
            <img class="loginImg" src="https://i.ibb.co/X8hdpTc/Marika-Shatters-The-Ring.webp" alt="">
            </div>
</div>
    </div>

    </body>
    </html>