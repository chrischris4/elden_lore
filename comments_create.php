<?php
require_once(__DIR__ . '/isConnect.php');
?>

<form action="comments_post_create.php" method="POST">
        <input class="commentsInput" type="text" name="items_id" value="<?php echo($item['items_id']); ?>" />
    <div class="commentsForm">
        <label for="comment" class="form-label">Postez un commentaire</label>
        <textarea class="commentsInput" placeholder="Soyez respectueux/se, nous sommes humain(e)s." id="comment" name="comment"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Envoyer</button>
</form>