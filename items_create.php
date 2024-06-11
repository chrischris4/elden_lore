<?php

require_once(__DIR__ . '/isConnect.php');
?>
        <div id="modalOverlay"></div>
        <div id="modalCreate">
        <div class="modalForm createStyle">
    <div class="loginForm">
    <span class="material-symbols-rounded" id="createClose" >
    close
</span>
        <h1>Ajouter un article</h1>
        <form action="items_post_create.php" method="POST">
        <div class="formSection">
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
            <button type="submit" class="formBtn">Valider</button>
        </form>
</div>
<div class="modalDesign">
            <img class="loginImg" src="https://i.ibb.co/HhMSCNQ/er-radagon-trying-to-repair-the-ring.webp" alt="">
            </div>
</div>
    </div>
