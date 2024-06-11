<?php
session_start();


require_once(__DIR__ . '/isConnect.php');
require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/config/databaseconnect.php');

/**
 * On ne traite pas les super globales provenant de l'utilisateur directement,
 * ces données doivent être testées et vérifiées.
 */
$getData = $_GET;


if (!isset($getData['id']) || !is_numeric($getData['id'])) {
    echo('Il faut un identifiant de recette pour la modifier.');
    return;
}


$retrieveItemStatement = $mysqlClient->prepare('SELECT * FROM items WHERE items_id = :id');
$retrieveItemStatement->execute([
    'id' => (int)$getData['id'],
]);
$item = $retrieveItemStatement->fetch(PDO::FETCH_ASSOC);

// si l'article'n'est pas trouvée, renvoyer un message d'erreur
?>

<?php

require_once(__DIR__ . '/isConnect.php');

?>


<div id="modalOverlay"></div>
        <div id="modalUpdate">
        <div class="modalForm createStyle">
    <div class="loginForm">
    <span class="material-symbols-rounded" id="updateClose" >
    close
</span>
<h1>Mettre à jour <?php echo($item['title']); ?></h1>
<form action="items_post_update.php" method="POST"><div class="formSection">

<div class="formSection">
<label for="id" class="form-label">Identifiant de la recette</label>
<input type="hidden" class="form-control" id="id" name="id" value="<?php echo($getData['id']); ?>">
            </div>
                <label for="category" class="formLabel">Catégorie</label>
                <select class="formSelect" id="category" name="category">
                    <option value="objet">Objet</option>
                    <option value="boss">Boss</option>
                    <option value="personnage">Personnage</option>
                    <option value="pnj">PNJ</option>
                    <option value="arme">Arme</option>
                </select>
            </div>
            <div class="formSection">
                <label for="title" class="formLabel">Titre</label>
                <input type="text" class="formControl" id="title" name="title" aria-describedby="title-help">
            </div>
            <div class="formSection">
                <label for="info_item" class="formLabel">Description</label>
                <textarea class="formControl" placeholder="Seulement du contenu vous appartenant ou libre de droits." id="info_item" name="info_item"></textarea>
            </div>
            <button type="submit" class="formBtn">Mettre à jour</button>
        </form>
</div>
<div class="modalDesign">
            <img class="loginImg" src="https://i.ibb.co/X8hdpTc/Marika-Shatters-The-Ring.webp" alt="">
            </div>
</div>
    </div>