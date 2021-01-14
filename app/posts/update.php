<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['headline'], $_POST['content'], $_POST['link'], $_POST['id'])) {
    die(var_dump($_POST));
    $title = trim(filter_var($_POST['edit-title'], FILTER_SANITIZE_STRING));
    $content = trim(filter_var($_POST['edit-description'], FILTER_SANITIZE_SPECIAL_CHARS));
    $url = trim(filter_var($_POST['edit-link'], FILTER_SANITIZE_URL));
    $usr = $_SESSION['user']['id'];
    $date = date("Y-M-D H:i:s");
    $postId = $_GET['id'];
    $stmnt = $pdo->prepare('UPDATE posts SET headline = :headline, content = :content, link = :link, date = :date
    WHERE id = :post_id AND user_id = :user_id');

    if (!$stmnt) {
        die(var_dump($pdo->errorInfo()));
    }

    $stmnt->execute([
        ':headline' => $title,
        ':content' => $content,
        ':link' => $url,
        ':date' => $date,
        ':user_id' => $usr
    
    ]);
}
redirect('/');