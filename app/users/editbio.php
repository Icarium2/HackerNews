<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['edit-bio'])) {
    $bio = trim(filter_var($_POST['edit-bio'], FILTER_SANITIZE_STRING));
    $usrID = (int) $_SESSION['user']['id'];

    $stmnt = $pdo->prepare('UPDATE users set bio = :bio WHERE id = :id');
    $stmnt->bindParam(':bio', $bio, PDO::PARAM_STR);
    $stmnt->bindParam(':id', $usrID, PDO::PARAM_INT);
    $stmnt->execute();
}

redirect('/../profile.php');
