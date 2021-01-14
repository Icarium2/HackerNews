<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';


if (loggedIn()) {
    $id = $_SESSION['user']['id'];
    $postId = $_GET['id'];
    $comment = $_GET['comment-id'];

    $statement = $pdo->prepare('DELETE FROM comments WHERE id = :post_id AND user_id = :user_id');

    $statement->bindParam(':id', $comment, PDO::PARAM_INT);
    $statement->bindParam(':user_id', $id, PDO::PARAM_INT);
    $statement->execute();


}
redirect('/');