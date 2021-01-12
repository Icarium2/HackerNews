<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['pwd'], $_POST['edit-password'], $_POST['confirm-password'])) {
    $pwd = trim($_POST['pwd']);
    $editPWD = trim($_POST['edit-password']);
    $confirmPWD= trim($_POST['confirm-password']);
    $usrID = (int) $_SESSION['user']['id'];

    $stmnt = $pdo->prepare('SELECT password FROM users where id = :id');
    $stmnt->bindParam(':id', $usrID, PDO::PARAM_INT);
    $stmnt->execute();
    $usr = $stmnt->fetch(PDO::FETCH_ASSOC);

    if (password_verify($pwd, $usr['password'])) {
        if ($editPWD == $confirmPWD){
            $stmnt = $pdo->prepare('UPDATE users SET password = :password WHERE id = :id');
            $stmnt->bindParam(':password', password_hash($editPWD, PASSWORD_BCRYPT), pdo::PARAM_STR);
            $stmnt->bindParam(':id', $usrID, PDO::PARAM_INT);
            $stmnt->execute();
            $_SESSION['user']['password'] = $editPWD;
        
        }
    }
}

redirect('/../profile.php');