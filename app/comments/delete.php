<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';


if (loggedIn()) {
    $id = $_SESSION['user']['id'];
    $commentID = $_GET['id'];


    $stmnt = $pdo->prepare('DELETE FROM comments WHERE id = :id AND user_id = :user_id');

    $stmnt->bindParam(':id', $commentID, PDO::PARAM_INT);
    $stmnt->bindParam(':user_id', $id, PDO::PARAM_INT);
    $stmnt->execute();

    redirect('/');
}
