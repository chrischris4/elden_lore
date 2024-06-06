<?php
session_start();

require_once(__DIR__ . '/isConnect.php');
?>
        <div id="modalOverlay"></div>
        <div id="createModal">
    <div class="modalForm">
    <div class="createForm">
        <h1>Ajouter un article</h1>
        <form action="items_post_create.php" method="POST">
        <div class="mb-3">
                <label for="category" class="form-label">Catégorie de l'article</label>
                <select class="form-select" id="category" name="category">
                    <option value="objet">Objet</option>
                    <option value="boss">Boss</option>
                    <option value="personnage">Personnage</option>
                    <option value="pnj">PNJ</option>
                    <option value="arme">Arme</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">Titre de l'article</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="title-help">
                <div id="title-help" class="form-text">Choisissez un titre percutant !</div>
            </div>
            <div class="mb-3">
                <label for="info_item" class="form-label">Description de l'article</label>
                <textarea class="form-control" placeholder="Seulement du contenu vous appartenant ou libre de droits." id="info_item" name="info_item"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Envoyer</button>
        </form>
</div>
</div>
    </div>
