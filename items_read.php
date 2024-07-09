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

// On récupère l'item
$retrieveItemWithCommentsStatement = $mysqlClient->prepare('SELECT r.*, c.comment_id, c.comment, c.user_id, u.picture AS user_picture, DATE_FORMAT(c.created_at, "%d/%m/%Y") as comment_date, u.pseudo FROM items r 
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

$item = [
    'items_id' => $itemWithComments[0]['items_id'],
    'title' => $itemWithComments[0]['title'],
    'item_picture' => $itemWithComments[0]['picture'],  // Utilisez une clé distincte
    'info_item' => $itemWithComments[0]['info_item'],
    'author' => $itemWithComments[0]['author'],
    'comments' => [],
];

foreach ($itemWithComments as $comment) {
    if (!is_null($comment['comment_id'])) {
        $item['comments'][] = [
            'comment_id' => $comment['comment_id'],
            'comment' => $comment['comment'],
            'user_id' => (int) $comment['user_id'],
            'picture' => $comment['user_picture'],  // Assurez-vous que c'est la photo de l'utilisateur
            'pseudo' => $comment['pseudo'],
            'created_at' => $comment['comment_date'],
        ];
    }
}

// Traitement du formulaire de commentaire
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['LOGGED_USER'])) {
    $postData = $_POST;

    if (
        isset($postData['comment']) &&
        isset($postData['items_id']) &&
        is_numeric($postData['items_id'])
    ) {
        $comment = trim(strip_tags($postData['comment']));
        $itemsId = (int)$postData['items_id'];

        if ($comment !== '') {
            $insertItem = $mysqlClient->prepare('INSERT INTO comments(comment, items_id, user_id) VALUES (:comment, :items_id, :user_id)');
            $insertItem->execute([
                'comment' => $comment,
                'items_id' => $itemsId,
                'user_id' => $_SESSION['LOGGED_USER']['user_id'],
            ]);

            $newCommentId = $mysqlClient->lastInsertId();
            $retrieveComment = $mysqlClient->prepare('SELECT c.comment, c.user_id, u.picture AS user_picture, DATE_FORMAT(c.created_at, "%d/%m/%Y") as comment_date, u.pseudo FROM comments c 
JOIN users u ON u.user_id = c.user_id
WHERE c.comment_id = :comment_id');
            $retrieveComment->execute(['comment_id' => $newCommentId]);
            $newComment = $retrieveComment->fetch(PDO::FETCH_ASSOC);

            $item['comments'][] = [
                'comment_id' => $newCommentId,
                'comment' => $newComment['comment'],
                'user_id' => (int)$newComment['user_id'],
                'picture' => $newComment['user_picture'],
                'pseudo' => $newComment['pseudo'],
                'created_at' => $newComment['comment_date'],
            ];
        }
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
    <link rel="stylesheet" href="styles/css/createUpdateDelete.css">
    <link rel="stylesheet" href="styles/css/login.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
<?php require_once(__DIR__ . '/login.php'); ?>
<?php require_once(__DIR__ . '/subscribe.php'); ?>
<?php require_once(__DIR__ . '/header.php'); ?>

<div id="read">
    <h1><?php echo($item['title']); ?></h1>
    <div id="readContent" class="readContent">
        <div class="itemPreview">
            <article class="item preview">
                <div class="articleBackground">
                    <img src="https://i.ibb.co/JQWNDhW/dark-texture-watercolor-1.webp" alt="">
                </div>
                <h3><?php echo($item['title']); ?></h3>
                <img src="<?php echo htmlspecialchars($item['item_picture']); ?>" class="articleImg"> <!-- Utilisation de la nouvelle clé -->
                <div class="articleInfo"><?php echo($item['info_item']); ?></div>
                <div class="authorInfo">
                    <h4><?php echo($item['author']); ?></h4>
                </div>
            </article>
        </div>
        <div class="commentsContainer">
            <div class="comments">
                <div>
                    <h2>Commentaires</h2>
                    <div class="allComment">
                    <?php if ($item['comments'] !== []) : ?>
                        <?php foreach ($item['comments'] as $comment) : ?>
                            <div class="comment">
                                <div class="commentsPicture">
                                    <img src="<?php echo htmlspecialchars($comment['picture']); ?>" alt="User Picture" class="profilePicture"> <!-- Utilisation de la clé correcte pour l'image utilisateur -->
                                </div>
                                <div class="commentsContent">
                                    <div class="commentsTitle">
                                        <p><?php echo htmlspecialchars($comment['pseudo']); ?></p>
                                        <p><?php echo htmlspecialchars($comment['created_at']); ?></p>
                                    </div>
                                    <p><?php echo htmlspecialchars($comment['comment']); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <div class="row">
                            <p>Aucun commentaire</p>
                        </div>
                    <?php endif; ?>
                    </div>
                </div>
                <?php if (!isset($_SESSION['LOGGED_USER'])) : ?>
                    <div class="logSubLinks">
                        <p>Pour pouvoir ajouter un commentaire</p>
                        <div class="logSubBtns">
                            <button>Se connecter</button>
                            <p>ou</p>
                            <button>Crée un compte</button>
                        </div>

                    </div>

                    <?php endif; ?>
                <?php if (isset($_SESSION['LOGGED_USER'])) : ?>
                    <form id="commentForm" method="POST">
                        <input class="commentsId" type="hidden" name="items_id" value="<?php echo($item['items_id']); ?>" />
                        <div class="commentsForm">
                            <label for="comment" class="form-label">Ajoutez un commentaire...</label>
                            <textarea class="commentsInput" placeholder="Soyez respectueux/se, nous sommes humain(e)s." id="comment" name="comment"></textarea>
                        </div>
                        <button type="submit" class="formBtn">Envoyer</button>
                    </form>
                    <div id="commentMessage"></div>
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

<?php if (isset($_SESSION['LOGGED_USER'])) : ?>
<script>
    <?php if (!isset($_SESSION['LOGGED_USER'])) : ?>
    const overlay = document.getElementById('modalOverlay');
    const loginLink = document.getElementById('loginLink');
    const loginForm = document.getElementById('modalLogin');
    const subLink = document.getElementById('subLink');
    const subForm = document.getElementById('modalSub');
    const subClose = document.getElementById('subClose');
    const loginClose = document.getElementById('loginClose');

    if (loginLink && loginForm) {
        loginLink.addEventListener('click', (e) => {
            e.preventDefault();
            document.body.classList.add('no-scroll');
            loginForm.classList.add('show');
            overlay.classList.add('showOverlay');
        });
    }

    if (subLink && subForm && subClose) {
        subLink.addEventListener('click', (e) => {
            e.preventDefault();
            document.body.classList.add('no-scroll');
            subForm.classList.add('show');
            overlay.classList.add('showOverlay');
        });

        subClose.addEventListener('click', (e) => {
            e.preventDefault();
            document.body.classList.remove('no-scroll');
            subForm.classList.remove('show');
            overlay.classList.remove('showOverlay');
        });
    }

    if (loginClose) {
        loginClose.addEventListener('click', (e) => {
            e.preventDefault();
            document.body.classList.remove('no-scroll');
            loginForm.classList.remove('show');
            overlay.classList.remove('showOverlay');
        });
    }
    <?php endif; ?>
    document.getElementById('commentForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Empêcher l'envoi classique du formulaire

    const formData = new FormData(this);

    fetch('comments_post_create.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erreur réseau.');
        }
        return response.json();
    })
    .then(data => {
        const commentMessage = document.getElementById('commentMessage');
        if (data.success) {
            commentMessage.innerHTML = '<p style="color: green;">' + data.message + '</p>';
            // Ajouter le nouveau commentaire sans recharger la page
            const newComment = `
                <div class="comment">
                    <div class="commentsPicture">
                        <img src="${data.comment.picture}" alt="User Picture" class="profilePicture">
                    </div>
                    <div class="commentsContent">
                        <div class="commentsTitle">
                            <p>${data.comment.pseudo}</p>
                            <p>${data.comment.created_at}</p>
                        </div>
                        <p>${data.comment.comment}</p>
                    </div>
                </div>
            `;
            document.querySelector('.allComment').innerHTML += newComment;
        } else {
            commentMessage.innerHTML = '<p style="color: red;">' + data.message + '</p>';
        }
    })
    .catch(error => {
        document.getElementById('commentMessage').innerHTML = '<p style="color: red;">Une erreur est survenue : ' + error.message + '</p>';
    });
});

</script>
<?php endif; ?>
</body>
</html>
