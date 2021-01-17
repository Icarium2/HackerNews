<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// In this file we delete posts in the database.
if (loggedIn()) {
    $id = $_SESSION['user']['id'];
    $postId = $_GET['id'];

    $stmnt = $pdo->prepare('DELETE FROM posts WHERE id = :post_id AND user_id = :user_id');

    $stmnt->bindParam(':post_id', $postId, PDO::PARAM_INT);
    $stmnt->bindParam(':user_id', $id, PDO::PARAM_INT);
    $stmnt->execute();
}
redirect('/');
