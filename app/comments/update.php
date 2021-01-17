<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// In this file we edit new posts in the database.

if (LoggedIn() && isset($_POST['new-comment'])) {
    $userId = $_SESSION['user']['id'];
    $commentId = $_GET['id'];
    $editComment = filter_var($_POST['new-comment'], FILTER_SANITIZE_STRING);

    $stmnt = $pdo->prepare('UPDATE comments SET comment = :comment WHERE id = :comment_id');
    $stmnt->bindParam(':comment', $editComment, PDO::PARAM_STR);
    $stmnt->bindParam(':comment_id', $commentId, PDO::PARAM_INT);
    $stmnt->execute();

    redirect('/');
}