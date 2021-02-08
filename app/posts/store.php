<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// In this file we store/insert new posts in the database.

if (!loggedIn()) {
    redirect('/');
}


if (isset($_POST['title'], $_POST['description'], $_POST['link'])) {
    $title = trim(filter_var($_POST['title'], FILTER_SANITIZE_STRING));
    $content = trim(filter_var($_POST['description'], FILTER_SANITIZE_SPECIAL_CHARS));
    $url = trim(filter_var($_POST['link'], FILTER_SANITIZE_URL));
    $usr = $_SESSION['user']['id'];
    $date = date("Y-M-D H:i:s");
    $stmnt = $pdo->prepare('INSERT INTO posts (user_id, content, headline, link, date)
    VALUES (:user_id, :content, :headline, :link, :date)');

    if (!$stmnt) {
        die(var_dump($pdo->errorInfo()));
    }

    $stmnt->execute([
        ':user_id' => $usr,
        ':content' => $content,
        ':headline' => $title,
        ':link' => $url,
        ':date' => $date
    ]);
}

redirect('/');
