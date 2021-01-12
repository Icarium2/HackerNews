<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['edit-email'])) {
    $email = trim(filter_var($_POST['edit-email'], FILTER_SANITIZE_EMAIL));
    $usrID = (int) $_SESSION['user']['id'];
    
    $stmnt = $pdo->prepare('UPDATE users set email = :email WHERE id = :id');
    $stmnt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmnt->bindParam(':id', $usrID, PDO::PARAM_INT);
    $stmnt->execute();
}

redirect('/../profile.php');
