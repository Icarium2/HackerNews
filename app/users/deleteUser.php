<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (loggedIn() && isset($_POST['password'], $_POST['password_repeat'])) {
    $password = $_POST['password'];
    $passwordRepeat = $_POST['password_repeat'];

    if (empty($password) || empty($passwordRepeat)) {
        redirect('/../../editprofile.php');
    }

    if ($password !== $passwordRepeat) {
        redirect('/../../editprofile.php');
    }

    if (!vertifyPassword((int)$_SESSION['user']['id'], $password, $pdo)) {
        redirect('/../../editprofile.php');
    }

    deleteUser((int)$_SESSION['user']['id'], $pdo);
    redirect('logout.php');
}

redirect('/../../index.php');
