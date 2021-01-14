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

//Checks if current user has upvoted post - upvotes if not
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

//Gets all posts by current user
function userPosts (int $usrID, PDO $pdo): array
{
    $stmnt = $pdo->prepare('SELECT * FROM posts WHERE user_id = :id');
    $stmnt->bindParam(':id', $usrID, PDO::PARAM_INT);
    $stmnt->execute();
    $posts = $stmnt->fetch(PDO::FETCH_ASSOC);
    if ($posts) {
        return $posts;
    }
}

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
//Counts number of upvotes on posts by current session user
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


//Getting all posts, and pairing with the usernames of posters, sorting by upvote
function postsArrayByUpvotes(PDO $pdo): array
{
    $stmnt = $pdo->query('SELECT
    COUNT(upvotes.post_id) AS upvotes,
    posts.*,
    users.username
    FROM
    upvotes
    INNER JOIN posts 
    ON posts.id = upvotes.post_id
    INNER JOIN users 
    ON posts.user_id = users.id
    GROUP BY
    posts.id
    ORDER BY
    COUNT(1) DESC
    LIMIT
    15;');
    $stmnt->execute();
    $allPosts = $stmnt->fetchAll(PDO::FETCH_ASSOC);

    return $allPosts;
}


function postComments(int $id, PDO $pdo): array
{
    $statement = $pdo->prepare('SELECT comments.id, comments.post_id, 
            comments.user_id, comments.comment, comments.date, 
            users.avatar, users.username
            FROM comments
            INNER JOIN users
            ON comments.user_id = users.id
            WHERE comments.post_id = :post_id
            ORDER BY comments.id DESC');

    $statement->bindParam(':post_id', $id, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}


function postById(int $id, object $pdo): array
{
    $statement = $pdo->prepare('SELECT posts.id, posts.headline, posts.link, posts.content, posts.user_id, posts.date, users.avatar, users.username
        FROM posts
        INNER JOIN users
        ON posts.user_id = users.id
        WHERE posts.id = :post_id LIMIT 1');

    $statement->bindParam(':post_id', $id, PDO::PARAM_INT);
    $statement->execute();

    $post = $statement->fetch(PDO::FETCH_ASSOC);

    if ($post) {
        return $post;
    }
}




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

