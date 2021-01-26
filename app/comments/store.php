<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// In this file we store/insert new posts in the database.

if (!loggedIn()) {
    redirect('/../login.php');
}

if (isset($_POST['new-comment'])) {
    $postID = $_GET['id'];
    $comment = trim(filter_var($_POST['new-comment'], FILTER_SANITIZE_SPECIAL_CHARS));
    $usr = $_SESSION['user']['id'];
    $date = date("Y-M-D H:i:s");
    $stmnt = $pdo->prepare('INSERT INTO comments (comment, date, post_id, user_id)
    VALUES (:comment, :date, :post_id, :user_id)');

    if (!$stmnt) {
        die(var_dump($pdo->errorInfo()));
    }

    $stmnt->execute([
        ':comment' => $comment,
        ':date' => $date,
        ':post_id' => $postID,
        ':user_id' => $usr
    ]);
}

redirect('/post.php?id=' . $postID);
