<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_FILES['avatar'])) {
    $avatar = $_FILES['avatar'];
    $usrID = (int) $_SESSION['user']['id'];
    $username = $_SESSION['user']['username'];
    $path = __DIR__ . '/../uploads/';
    $fileName = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
    $time = date('ymd');

    $updateAvatar = "/app/uploads/" . $time . '-' . $username . '.' . $fileName;

    $stmnt = $pdo->prepare('UPDATE users SET avatar = :avatar WHERE id = :id');

    
    $stmnt->bindParam('avatar', $updateAvatar, PDO::PARAM_STR);
    $stmnt->bindPAram(':id', $usrID, PDO::PARAM_INT);
    $stmnt->execute();

    move_uploaded_file($avatar['tmp_name'], $path . $updateAvatar);
}

redirect('/');

