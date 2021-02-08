<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (loggedIn() && isset($_POST['comment-id'], $_POST['post-id'], $_POST['reply'])) {
    $comment = trim(filter_var($_POST['reply'], FILTER_SANITIZE_STRING));
    $date = date("Y-M-D H:i:s");
    $commentId = trim(filter_var($_POST['comment-id'], FILTER_SANITIZE_NUMBER_INT));
    $userId = (int)$_SESSION['user']['id'];
    $postId = trim(filter_var($_POST['post-id'], FILTER_SANITIZE_NUMBER_INT));

    if (empty($comment) || empty($commentId) || empty($userId) || empty($postId)) {
        redirect("/../../replyToComment.php?id=$commentId");
    }

    $stmnt = $pdo->prepare("INSERT INTO comments (comment, date, post_id, user_id, reply)
    VALUES (:comment, :date, :post_id, :user_id, :reply);");
    $stmnt->bindParam(":comment", $comment, PDO::PARAM_STR);
    $stmnt->bindParam(":date", $date, PDO::PARAM_STR);
    $stmnt->bindParam(":reply", $commentId, PDO::PARAM_INT);
    $stmnt->bindParam(":user_id", $userId, PDO::PARAM_INT);
    $stmnt->bindParam(":post_id", $postId, PDO::PARAM_INT);
    $stmnt->execute();

    if (!$stmnt) {
        die(var_dump($pdo->errorInfo()));
    }
}
redirect("/../../post.php?id=$postId&order_by=new");
