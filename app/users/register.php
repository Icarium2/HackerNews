<?php
declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// In this file we register a new user.

if (
    isset($_POST['email'],
     $_POST['username'], 
     $_POST['password'])) {

    $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
    $username = trim(filter_var($_POST['username'], FILTER_SANITIZE_STRING));

    if (emailTaken($email, $pdo)) {

        redirect('/register.php');
    
    }

    if (handleTaken($username, $pdo)) {
        
        redirect('/register.php');
    }

    $pwd= trim(password_hash($_POST['password'], PASSWORD_BCRYPT));
    $firstName = 'First Name';
    $lastName = 'Last Name';

    $stmnt = $pdo->prepare('INSERT INTO users (email, username, password, first_name, last_name) 
    VALUES (:email, :username, :password, :first_name, :last_name)');

    $stmnt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmnt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmnt->bindParam(':password', $pwd, PDO::PARAM_STR);
    $stmnt->bindParam(':first_name', $firstName, PDO::PARAM_STR);
    $stmnt->bindParam(':last_name', $lastName, PDO::PARAM_STR);
    $stmnt->execute();


}

redirect('/login.php');










