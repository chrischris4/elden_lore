<?php
session_start();
require_once(__DIR__ . '/config/mysql.php');
require_once(__DIR__ . '/config/databaseconnect.php');

$response = ['success' => false, 'message' => ''];

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

            $response['success'] = true;
            $response['message'] = 'Commentaire ajouté avec succès.';
            $response['comment'] = [
                'comment_id' => $newCommentId,
                'comment' => $newComment['comment'],
                'user_id' => (int)$newComment['user_id'],
                'picture' => $newComment['user_picture'],
                'pseudo' => $newComment['pseudo'],
                'created_at' => $newComment['comment_date'],
            ];
        } else {
            $response['message'] = 'Le commentaire ne peut pas être vide.';
        }
    } else {
        $response['message'] = 'Données du formulaire incorrectes.';
    }
} else {
    $response['message'] = 'Utilisateur non authentifié.';
}

header('Content-Type: application/json');
echo json_encode($response);
