<?php

function displayAuthor(string $authorPseudo, array $users): string
{
    foreach ($users as $user) {
        if ($authorPseudo === $user['pseudo']) {
            return $user['pseudo'];
        }
    }

    return 'Auteur inconnu';
}

function isValidItem(array $item): bool
{
    if (array_key_exists('is_enabled', $item)) {
        $isEnabled = $item['is_enabled'];
    } else {
        $isEnabled = false;
    }

    return $isEnabled;
}

function getItems(array $items, ?string $category = null): array
{
    $valid_items = [];

    foreach ($items as $item) {
        if (isValidItem($item)) {
            if ($category === null || $item['category'] === $category) {
                $valid_items[] = $item;
            }
        }
    }

    return $valid_items;
}


function redirectToUrl(string $url): never
{
    header("Location: {$url}");
    exit();
}