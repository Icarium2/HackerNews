<?php

declare(strict_types=1);

function redirect(string $path)
{
    header("Location: ${path}");
    exit;
}

//Logic for extracting data from DB and storing in functions for later use.

//Check session for a logged in user
function loggedIn(): bool
{
    return isset($_SESSION['user']);
}


//Checks if current user has upvoted post - upvotes if no
function toggleUpvote(int $postID, object $pdo): bool
{   $usr = $_SESSION['user']['id'];
    $stmnt = $pdo->prepare('SELECT * FROM upvotes WHERE post_id = :post_id AND user_id = :user_id');
    
    $stmnt->execute([
        ':user_id' => $usr,
        ':post_id' => $postID    
    ]);

    $upvoted = $stmnt->fetch(PDO::FETCH_ASSOC);
    return $upvoted ? true : false;
}


//Counts the number of comments a post has


//Counts number of posts posted by current session-id
function postsByCurrentUser (int $usrID, object $pdo): array
{
    $stmnt = $pdo->prepare('SELECT count(posts.user_id) AS userPosts
    FROM posts INNER JOIN users ON users.id=posts.user_id 
    where user_id = :id');
    $stmnt->bindParam(':id', $usrID, PDO::PARAM_INT);
    $stmnt->execute();
    $usr = $stmnt->fetch(PDO::FETCH_ASSOC);
    if ($usr) {
        return $usr;
    }
}
//Counts number of upvotes on posts by current session-id
function currentUserUpvoted(int $usrID, object $pdo): array
{
    $stmnt = $pdo->prepare('SELECT count(upvotes.user_id) AS totalUpvotes
    FROM upvotes INNER JOIN users ON users.id=upvotes.user_id 
    where user_id = :id');
    $stmnt->bindParam(':id', $usrID, PDO::PARAM_INT);
    $stmnt->execute();
    $usr = $stmnt->fetch(PDO::FETCH_ASSOC);
    if ($usr) {
        return $usr;
    }
}

//Counts number of upvotes a post has
function numberOfUpvotes(int $postID, object $pdo): array
{
    $stmnt = $pdo->prepare('SELECT count(upvotes.post_id) AS numberOfUpvotes
    FROM upvotes INNER JOIN posts ON posts.id=upvotes.post_id
    WHERE post_id = :id');
    $stmnt->bindParam(':id', $postID, PDO::PARAM_INT);
    $stmnt->execute();
    $upvotesNumber = $stmnt->fetch(PDO::FETCH_ASSOC);
    if ($upvotesNumber) {
        return $upvotesNumber;
    }
}

//counts the number of comments a post has 
function numberOfComments(int $postID, object $pdo): array
{
    $stmnt = $pdo->prepare('SELECT count(comments.post_id) AS numberOfComments
    FROM comments INNER JOIN posts ON posts.id=comments.post_id
    WHERE post_id = :id');
    $stmnt->bindParam(':id', $postID, PDO::PARAM_INT);
    $stmnt->execute();
    $commentsNumber = $stmnt->fetch(PDO::FETCH_ASSOC);
    if ($commentsNumber) {
        return $commentsNumber;
    }
}



//Checks database for a user connected to the current id on the session
function userById(int $usrID, object $pdo): array
{
    $stmnt = $pdo->prepare('SELECT * FROM users WHERE id = :id');
    $stmnt->bindParam(':id', $usrID, PDO::PARAM_INT);
    $stmnt->execute();
    $usr = $stmnt->fetch(PDO::FETCH_ASSOC);
    if (!$stmnt) {
        die(var_dump($pdo->errorInfo()));
    }
    if ($usr) {
        return $usr;
    }
}

//Getting all posts, and pairing with the usernames of posters, sorting by date.
function postsArrayByDate(PDO $pdo): array
{
    $stmnt = $pdo->query('SELECT posts.*, users.username, users.avatar FROM posts 
    INNER JOIN users 
    ON posts.user_id = users.id 
    ORDER BY posts.date DESC');
    if (!$stmnt) {
        die(var_dump($pdo->errorInfo()));
    }
    $stmnt->execute();
    $allPosts = $stmnt->fetchAll(PDO::FETCH_ASSOC);

    return $allPosts;
}


/*
//Getting all posts, and pairing with the usernames of posters, sorting by upvotes.
function postsArrayByDate(PDO $pdo): array
{
    $stmnt = $pdo->query('SELECT posts.*, users.username, users.avatar FROM posts 
    INNER JOIN users 
    ON posts.user_id = users.id 
    ORDER BY posts.date DESC');
    if (!$stmnt) {
        die(var_dump($pdo->errorInfo()));
    }
    $stmnt->execute();
    $allPosts = $stmnt->fetchAll(PDO::FETCH_ASSOC);

    return $allPosts;
}
*/



//Logic for the login-system
//Searches database for desired email
function emailTaken(string $email, object $pdo): bool
{
    $stmnt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $stmnt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmnt->execute();
    $email = $stmnt->fetch(PDO::FETCH_ASSOC);

    if ($email) {
        return true;
    }
        return false;
}

//Searches database for desired username
function handleTaken(string $username, object $pdo): bool
{
    $stmnt = $pdo->prepare('SELECT * FROM users WHERE username = :username');
    $stmnt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmnt->execute();

    $user = $stmnt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        return true;
    }
    return false;
}


