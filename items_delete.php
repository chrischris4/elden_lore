<?php
session_start();


require_once(__DIR__ . '/isConnect.php');

$getData = $_GET;

if (!isset($getData['id']) || !is_numeric($getData['id'])) {
    echo('Il faut un identifiant pour supprimer la recette.');
    return;
}

?>

<div id="modalOverlay"></div>
        <div id="modalDelete">
        <div class="modalForm">
    <div class="loginForm">
    <span class="material-symbols-rounded" id="deleteClose" >
    close
</span>
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