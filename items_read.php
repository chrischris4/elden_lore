<?php
session_start();

require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/config/databaseconnect.php');

/**
 * On ne traite pas les super globales provenant de l'utilisateur directement,
 * ces données doivent être testées et vérifiées.
 */
$getData = $_GET;

if (!isset($getData['id']) || !is_numeric($getData['id'])) {
    echo('L\'article n\'existe pas');
    return;
}

$getData = $_GET;

// On récupère la recette
$retrieveItemWithCommentsStatement = $mysqlClient->prepare('SELECT r.*, c.comment_id, c.comment, c.user_id,  DATE_FORMAT(c.created_at, "%d/%m/%Y") as comment_date, u.pseudo FROM items r 
LEFT JOIN comments c on c.items_id = r.items_id
LEFT JOIN users u ON u.user_id = c.user_id
WHERE r.items_id = :id 
ORDER BY comment_date DESC');
$retrieveItemWithCommentsStatement->execute([
    'id' => (int)$getData['id'],
]);
$itemWithComments = $retrieveItemWithCommentsStatement->fetchAll(PDO::FETCH_ASSOC);

if ($itemWithComments === []) {
    echo('L\'article n\'existe pas');
    return;
}
$retrieveAverageRatingStatement = $mysqlClient->prepare('SELECT ROUND(AVG(c.review),1) as rating FROM items r LEFT JOIN comments c on r.items_id = c.items_id WHERE r.items_id = :id');
$retrieveAverageRatingStatement->execute([
    'id' => (int)$getData['id'],
]);
$averageRating = $retrieveAverageRatingStatement->fetch();

$item = [
    'items_id' => $itemWithComments[0]['items_id'],
    'title' => $itemWithComments[0]['title'],
    'info_item' => $itemWithComments[0]['info_item'],
    'author' => $itemWithComments[0]['author'],
    'comments' => [],
    'rating' => $averageRating['rating'],
];

foreach ($itemWithComments as $comment) {
    if (!is_null($comment['comment_id'])) {
        $item['comments'][] = [
            'comment_id' => $comment['comment_id'],
            'comment' => $comment['comment'],
            'user_id' => (int) $comment['user_id'],
            'full_name' => $comment['full_name'],
            'created_at' => $comment['comment_date'],
        ];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elden Lore - <?php echo htmlspecialchars($item['title']); ?></title>
    <link rel="stylesheet" href="styles/css/style.css">
    <link rel="stylesheet" href="styles/css/header.css">
    <link rel="stylesheet" href="styles/css/login.css">

</head>
<body>
<h2 id="headerTitle" class="opacity">
        <span class="titlePart">E</span>
        <span class="title">LDEN LOR</span>
        <span class="titlePart">E</span>
    </h2>
    <div class="loginWelcome" role="alert">
        <img src="<?php echo $_SESSION['LOGGED_USER']['picture']; ?>" alt="Photo de profil" class="profilePicture">
        <li class="loggedLink">
                    <a href="logout.php">DECONNEXION</a>
                    </li>
    </div>
    <div id="read">
    <h1><?php echo($item['title']); ?></h1>
        <div id="readContent" class="readContent">
        <?php require_once(__DIR__ . '/header.php'); ?>
        <div class="itemPreview">
        <article class="item preview">
                <div class="articleBackground">
                    <img src="https://i.ibb.co/JQWNDhW/dark-texture-watercolor-1.webp" alt="">
                </div>
                <h3><?php echo($item['title']); ?></h3>
                <img src="https://i.ibb.co/SP9dgs5/8m1e66o7pyka1-1.webp" alt="elden_ring_banner" class="articleImg">
                <div class="articleInfo"><?php echo($item['info_item']); ?></div>
                <div class="authorInfo">
                    <h4><?php echo($item['author']); ?></h4>
                </div>
            </article>
            </div>
            <div class="commentsContainer">
            <div class="comments">
                <?php if ($item['rating'] !== null) : ?>
                    <p><b>Evaluée par la communauté à <?php echo htmlspecialchars($item['rating']); ?> / 5</b></p>
                <?php else : ?>
                    <p><b>Aucune évaluation</b></p>
                <?php endif; ?>
        <hr />
        <h2>Commentaires</h2>
        <?php if ($item['comments'] !== []) : ?>
        <div class="row">
            <?php foreach ($item['comments'] as $comment) : ?>
                <div class="comment">
                    <p><?php echo htmlspecialchars($comment['created_at']); ?></p>
                    <p><?php echo htmlspecialchars($comment['comment']); ?></p>
                    <i>(<?php echo htmlspecialchars($comment['pseudo']); ?>)</i>
                </div>
            <?php endforeach; ?>
        </div>
        <?php else : ?>
        <div class="row">
            <p>Aucun commentaire</p>
        </div>
        <?php endif; ?>
        <hr />
        <?php if (isset($_SESSION['LOGGED_USER'])) : ?>
            <?php require_once(__DIR__ . '/comments_create.php'); ?>
        <?php endif; ?>
        </div>
        </div>
        </div>
    </div>
    <div id="divTest">
        <div class="bannerOverlay z"></div>
        <img src="https://i.ibb.co/SP9dgs5/8m1e66o7pyka1-1.webp" alt="elden_ring_banner" class="bannerTest opacityLow">
    </div>
    <?php require_once(__DIR__ . '/footer.php'); ?>
</body>
</html>
