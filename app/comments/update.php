<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// In this file we edit new posts in the database.
if (LoggedIn() && isset($_POST['comment-id'])) {
    die(var_dump($_POST));
    $userId = $_SESSION['user']['id'];
    $postId = $_GET['id'];
    $commentId = $_GET['comment-id'];
    $editComment = filter_var($_POST['new-comment'], FILTER_SANITIZE_STRING);

    $statement = $pdo->prepare('UPDATE comments SET content = :content WHERE id = :comment_id AND user_id = :user_id AND post_id = :post_id');

    $statement->bindParam(':content', $editComment, PDO::PARAM_STR);
    $statement->bindParam(':post_id', $postId, PDO::PARAM_INT);
    $statement->bindParam(':comment_id', $commentId, PDO::PARAM_INT);
    $statement->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $statement->execute();


    redirect('/post.php?id=' . $postId);
}