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
{
    $usr = $_SESSION['user']['id'];
    $stmnt = $pdo->prepare('SELECT * FROM upvotes WHERE post_id = :post_id AND user_id = :user_id');

    $stmnt->execute([
        ':user_id' => $usr,
        ':post_id' => $postID
    ]);

    $upvoted = $stmnt->fetch(PDO::FETCH_ASSOC);
    return $upvoted ? true : false;
}

//Gets all posts by current user
function userPosts(int $usrID, PDO $pdo): ?array
{
    $stmnt = $pdo->prepare('SELECT * FROM posts WHERE user_id = :id');
    $stmnt->bindParam(':id', $usrID, PDO::PARAM_INT);
    $stmnt->execute();
    $posts = $stmnt->fetch(PDO::FETCH_ASSOC);
    if ($posts) {
        return $posts;
    }
    return null;
}

//Counts number of posts posted by current session-id
function postsByCurrentUser(int $usrID, object $pdo): array
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
    // $stmnt = $pdo->query('SELECT
    // COUNT(upvotes.post_id) AS upvotes,
    // posts.*,
    // users.username
    // FROM
    // upvotes
    // INNER JOIN posts
    // ON posts.id = upvotes.post_id
    // INNER JOIN users
    // ON posts.user_id = users.id
    // GROUP BY
    // posts.id
    // ORDER BY
    // COUNT(1) DESC
    // LIMIT
    // 15;');
    $stmnt = $pdo->query("SELECT
    p.*,
    COALESCE(v.upvote_count, 0) AS upvotes,
    COALESCE(c.comment_count, 0) AS comments,
    users.username,
    users.avatar
    FROM posts p
    LEFT OUTER JOIN (
        SELECT post_id, COUNT(post_id) AS upvote_count
        FROM upvotes
        GROUP BY post_id
    ) v
    ON p.id = v.post_id
    LEFT OUTER JOIN (
        SELECT post_id, COUNT(post_id) AS comment_count
        FROM COMMENTS
        GROUP BY post_id
    ) c
    ON p.id = c.post_id
    INNER JOIN users
    ON users.id = p.user_id
    ORDER BY upvotes DESC, p.date DESC
    LIMIT 15;");
    $stmnt->execute();

    if (!$stmnt) {
        die(var_dump($pdo->errorInfo()));
    }

    $allPosts = $stmnt->fetchAll(PDO::FETCH_ASSOC);

    return $allPosts;
}


function postComments(int $id, PDO $pdo): ?array
{
    $stmnt = $pdo->prepare('SELECT comments.id, comments.post_id,
            comments.user_id, comments.comment, comments.date,
            users.avatar, users.username
            FROM comments
            INNER JOIN users
            ON comments.user_id = users.id
            WHERE comments.post_id = :post_id
            AND reply IS NULL
            ORDER BY comments.id DESC');
    $stmnt->bindParam(':post_id', $id, PDO::PARAM_INT);
    $stmnt->execute();
    $result = $stmnt->fetchAll(PDO::FETCH_ASSOC);

    if (!$result) {
        return null;
    }
    return $result;
}

function getComment(int $id, PDO $pdo): array
{
    $stmnt = $pdo->prepare('SELECT comments.id, comments.post_id,
            comments.user_id, comments.comment, comments.date
            FROM comments
            WHERE comments.id = :post_id
            ORDER BY comments.id DESC');

    $stmnt->bindParam(':post_id', $id, PDO::PARAM_INT);
    $stmnt->execute();
    return $stmnt->fetchAll(PDO::FETCH_ASSOC)[0];
}

function postById(int $id, object $pdo): array
{
    $stmnt = $pdo->prepare('SELECT posts.id, posts.headline, posts.link, posts.content, posts.user_id, posts.date, users.avatar, users.username
        FROM posts
        INNER JOIN users
        ON posts.user_id = users.id
        WHERE posts.id = :post_id LIMIT 1');

    $stmnt->bindParam(':post_id', $id, PDO::PARAM_INT);
    $stmnt->execute();

    $post = $stmnt->fetch(PDO::FETCH_ASSOC);

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

// Added/modified by Simon

function vertifyPassword(int $userId, string $password, PDO $pdo): bool
{
    $stmnt = $pdo->prepare("SELECT password FROM users WHERE id = :user_id");
    $stmnt->bindParam(":user_id", $userId, PDO::PARAM_INT);
    $stmnt->execute();

    if (!$stmnt) {
        die(var_dump($pdo->errorInfo()));
    }

    $result = $stmnt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $passwordHash = $result['password'];
    } else {
        return false;
    }

    return password_verify($password, $passwordHash);
}

function hasUserUpvotedPost(int $userId, int $postId, PDO $pdo): bool
{
    $stmnt = $pdo->prepare("SELECT * FROM upvotes WHERE post_id = :post_id AND user_id = :user_id");
    $stmnt->bindParam(":post_id", $postId, PDO::PARAM_INT);
    $stmnt->bindParam(":user_id", $userId, PDO::PARAM_INT);
    $stmnt->execute();

    if (!$stmnt) {
        die(var_dump($pdo->errorInfo()));
    }

    $result = $stmnt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        return true;
    }

    return false;
}

function togglePostUpvote(int $userId, int $postId, PDO $pdo): void
{
    if (hasUserUpvotedPost($userId, $postId, $pdo)) {
        $stmnt = $pdo->prepare("DELETE FROM upvotes WHERE user_id = :user_id AND post_id = :post_id");
        $stmnt->bindParam(":user_id", $userId, PDO::PARAM_INT);
        $stmnt->bindParam(":post_id", $postId, PDO::PARAM_INT);
        $stmnt->execute();

        if (!$stmnt) {
            die(var_dump($pdo->errorInfo()));
        }
    } else {
        $stmnt = $pdo->prepare("INSERT INTO upvotes (user_id, post_id) VALUES(:user_id, :post_id)");
        $stmnt->bindParam(":user_id", $userId, PDO::PARAM_INT);
        $stmnt->bindParam(":post_id", $postId, PDO::PARAM_INT);
        $stmnt->execute();

        if (!$stmnt) {
            die(var_dump($pdo->errorInfo()));
        }
    }
}

function fetchNumberOfPostUpvotes(int $postId, PDO $pdo): int
{
    $stmnt = $pdo->prepare("SELECT COUNT(post_id) as 'upvotes' FROM upvotes WHERE post_id = :post_id;");
    $stmnt->bindParam(":post_id", $postId, PDO::PARAM_INT);
    $stmnt->execute();

    if (!$stmnt) {
        die(var_dump($pdo->errorInfo()));
    }

    $result = $stmnt->fetch(PDO::FETCH_ASSOC);

    return (int)$result['upvotes'];
}

function fetchNumberOfCommentUpvotes(int $commentId, PDO $pdo): int
{
    $stmnt = $pdo->prepare("SELECT COUNT(comment_id) as 'upvotes' FROM upvotes WHERE comment_id = :comment_id;");
    $stmnt->bindParam(":comment_id", $commentId, PDO::PARAM_INT);
    $stmnt->execute();

    if (!$stmnt) {
        die(var_dump($pdo->errorInfo()));
    }

    $result = $stmnt->fetch(PDO::FETCH_ASSOC);

    return (int)$result['upvotes'];
}

function hasUserUpvotedComment(int $userId, int $commentId, PDO $pdo): bool
{
    $stmnt = $pdo->prepare("SELECT * FROM upvotes WHERE comment_id = :comment_id AND user_id = :user_id");
    $stmnt->bindParam(":comment_id", $commentId, PDO::PARAM_INT);
    $stmnt->bindParam(":user_id", $userId, PDO::PARAM_INT);
    $stmnt->execute();

    if (!$stmnt) {
        die(var_dump($pdo->errorInfo()));
    }

    $result = $stmnt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        return true;
    }

    return false;
}

function toggleCommentUpvote(int $userId, int $commentId, PDO $pdo): void
{
    if (hasUserUpvotedComment($userId, $commentId, $pdo)) {
        $stmnt = $pdo->prepare("DELETE FROM upvotes WHERE user_id = :user_id AND comment_id = :comment_id");
        $stmnt->bindParam(":user_id", $userId, PDO::PARAM_INT);
        $stmnt->bindParam(":comment_id", $commentId, PDO::PARAM_INT);
        $stmnt->execute();

        if (!$stmnt) {
            die(var_dump($pdo->errorInfo()));
        }
    } else {
        $stmnt = $pdo->prepare("INSERT INTO upvotes (user_id, comment_id) VALUES(:user_id, :comment_id)");
        $stmnt->bindParam(":user_id", $userId, PDO::PARAM_INT);
        $stmnt->bindParam(":comment_id", $commentId, PDO::PARAM_INT);
        $stmnt->execute();

        if (!$stmnt) {
            die(var_dump($pdo->errorInfo()));
        }
    }
}

function postCommentsReplies(int $postId, PDO $pdo): ?array
{
    $stmnt = $pdo->prepare('SELECT comments.id, comments.post_id,
            comments.user_id, comments.comment, comments.date, comments.reply,
            users.avatar, users.username
            FROM comments
            INNER JOIN users
            ON comments.user_id = users.id
            WHERE comments.post_id = :post_id
            AND reply IS NOT NULL;
            ORDER BY comments.id DESC');

    $stmnt->bindParam(':post_id', $postId, PDO::PARAM_INT);
    $stmnt->execute();

    if (!$stmnt) {
        die(var_dump($pdo->errorInfo()));
    }

    return $stmnt->fetchAll(PDO::FETCH_ASSOC);
}

function postCommentsByUpvotes(int $postId, PDO $pdo): ?array
{
    $stmnt = $pdo->prepare(
        "SELECT c.*,
        COALESCE(v.upvote_count, 0) AS upvotes,
        users.username,
        users.avatar
        FROM comments c
        LEFT OUTER JOIN (
            SELECT comment_id, COUNT(comment_id) AS upvote_count
            FROM upvotes
            GROUP BY comment_id
        ) v
        ON c.id = v.comment_id
        INNER JOIN users
        ON users.id = c.user_id
        WHERE c.post_id = :post_id AND c.reply IS NULL
        ORDER BY upvotes DESC, c.date DESC;"
    );
    $stmnt->bindParam(":post_id", $postId, PDO::PARAM_INT);
    $stmnt->execute();

    if (!$stmnt) {
        die(var_dump($pdo->errorInfo()));
    }

    $results = $stmnt->fetchAll(PDO::FETCH_ASSOC);

    if (!$results) {
        return null;
    }

    return $results;
}

function postRepliesByUpvotes(int $postId, PDO $pdo): ?array
{
    $stmnt = $pdo->prepare(
        "SELECT c.*,
        COALESCE(v.upvote_count, 0) AS upvotes,
        users.username,
        users.avatar
        FROM comments c
        LEFT OUTER JOIN (
            SELECT comment_id, COUNT(comment_id) AS upvote_count
            FROM upvotes
            GROUP BY comment_id
        ) v
        ON c.id = v.comment_id
        INNER JOIN users
        ON users.id = c.user_id
        WHERE c.post_id = :post_id AND c.reply IS NOT NULL
        ORDER BY upvotes DESC, c.date DESC;"
    );
    $stmnt->bindParam(":post_id", $postId, PDO::PARAM_INT);
    $stmnt->execute();

    if (!$stmnt) {
        die(var_dump($pdo->errorInfo()));
    }

    $results = $stmnt->fetchAll(PDO::FETCH_ASSOC);

    if (!$results) {
        return null;
    }

    return $results;
}
