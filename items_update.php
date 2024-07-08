<?php
session_start();

require_once(__DIR__ . '/isConnect.php');
require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/config/databaseconnect.php');

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

// si l'article n'est pas trouvée, renvoyer un message d'erreur
if (!$item) {
    echo('Article non trouvé.');
    return;
}
?>

<?php require_once(__DIR__ . '/header.php'); ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elden Lore</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/css/style.css">
    <link rel="stylesheet" href="styles/css/header.css">
    <link rel="stylesheet" href="styles/css/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
<h2 id="headerTitle" class="opacity">
    <span class="titlePart">E</span>
    <span class="title">LDEN LOR</span>
    <span class="titlePart">E</span>
</h2>
<div id="update">
    <h1>Mettre à jour <?php echo htmlspecialchars($item['title']); ?></h1>
    <div id="updateContent">
        <div class="updateForm">
            <form action="items_post_update.php" method="POST" enctype="multipart/form-data" id="updateForm">
                <input type="hidden" class="form-control" id="id" name="id" value="<?php echo htmlspecialchars($getData['id']); ?>">
                <div class="formSection">
                    <label for="category" class="formLabel">Catégorie</label>
                    <select class="formSelect" id="category" name="category">
                        <option value="objet" <?php echo $item['category'] == 'objet' ? 'selected' : ''; ?>>Objet</option>
                        <option value="boss" <?php echo $item['category'] == 'boss' ? 'selected' : ''; ?>>Boss</option>
                        <option value="personnage" <?php echo $item['category'] == 'personnage' ? 'selected' : ''; ?>>Personnage</option>
                        <option value="arme" <?php echo $item['category'] == 'arme' ? 'selected' : ''; ?>>Arme</option>
                    </select>
                </div>
                <div class="formSection">
                    <label for="title" class="formLabel">Titre</label>
                    <input type="text" class="formControl" id="title" name="title" aria-describedby="title-help" value="<?php echo htmlspecialchars($item['title']); ?>">
                </div>
                <div class="formSection">
                    <label for="info_item" class="formLabel">Description</label>
                    <textarea class="formControl" placeholder="Seulement du contenu vous appartenant ou libre de droits." id="info_item" name="info_item"><?php echo htmlspecialchars($item['info_item']); ?></textarea>
                </div>
                <div class="formSection">
                    <label for="picture" class="formLabel">Image</label>
                    <input type="file" class="formControl" id="picture" name="picture" accept="image/*">
                </div>
                <button type="submit" class="formBtn">Mettre à jour</button>
            </form>
        </div>
        <div class="itemPreview">
            <article class="item preview">
                <div class="articleBackground">
                    <img src="https://i.ibb.co/JQWNDhW/dark-texture-watercolor-1.webp" alt="">
                </div>
                <h3 id="previewTitle"><?php echo htmlspecialchars($item['title']); ?></h3>
                <img src="<?php echo htmlspecialchars($item['picture']); ?>" alt="elden_ring_banner" class="articleImg" id="previewImage">
                <div class="articleInfo" id="previewDescription"><?php echo htmlspecialchars($item['info_item']); ?></div>
                <div class="authorInfo">
                    <h4><?php echo htmlspecialchars($item['author']); ?></h4>
                </div>
            </article>
        </div>
    </div>
    <div id="divTest">
        <div class="bannerOverlay z"></div>
        <img src="https://i.ibb.co/SP9dgs5/8m1e66o7pyka1-1.webp" alt="elden_ring_banner" class="bannerTest opacityLow">
    </div>
</div>

<?php require_once(__DIR__ . '/footer.php'); ?>

<script>
document.getElementById('title').addEventListener('input', function() {
    document.getElementById('previewTitle').textContent = this.value || 'Title';
});

document.getElementById('info_item').addEventListener('input', function() {
    document.getElementById('previewDescription').textContent = this.value || 'Description';
});

document.getElementById('picture').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImage').src = e.target.result;
        }
        reader.readAsDataURL(file);
    } else {
        document.getElementById('previewImage').src = '<?php echo htmlspecialchars($item['picture']); ?>';
    }
});
</script>
</body>
</html>
