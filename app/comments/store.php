<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// In this file we store/insert new posts in the database.

if (!loggedIn()) {
    redirect('/');
}


if (isset($_POST['new-comment'])) {
    $comment = trim(filter_var($_POST['new-comment'], FILTER_SANITIZE_SPECIAL_CHARS));
    $usr = $_SESSION['user']['id'];
    $date = date("Y-M-D H:i:s");
    $stmnt = $pdo->prepare('INSERT INTO comments (user_id, post_id, comment, date) 
    VALUES (:user_id, :post_id :comment, :date)');

    if (!$stmnt) {
        die(var_dump($pdo->errorInfo()));
    }

    $stmnt->execute([
        ':user_id' => $usr,
        ':comment' => $comment,
        ':date' => $date
    ]);
}

redirect('/post.php');
