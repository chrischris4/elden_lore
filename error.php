<?php

function displayAuthor(string $authorEmail, array $users): string
    {
        foreach($users as $user) {
            if ($authorEmail === $user['email']) {
                return $user['full_name'] . '(' . $user['age'] . ' ans)';
            }
        }
        return 'Auteur inconnu';
    }
function isValidItem(array $item): bool
    {
        return $item['is_enabled'];
    }
function getItems(array $items) : array
    {
        $valid_items = [];
        foreach($items as $item) {
            if (isValidItem($item)) {
                $valid_items[] = $item;
            }
        }
    return $valid_items;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Recettes de cuisine : Erreur</title>
    <link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
rel="stylesheet"
>
</head>

<body>
    <div class="container">
        <h1>Liste des recettes de cuisine</h1>
        <?php foreach(getItems($items) as $item) : ?>
        <article>
            <h3><?php echo($item['title']); ?></h3>
            <div><?php echo($item['item']); ?></div>
            <i><?php echo(displayAuthor($item['author'], $users)); ?></i>
        </article>
        <?php endforeach ?>
    </div>
</body>
</html>