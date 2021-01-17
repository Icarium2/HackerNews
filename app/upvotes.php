<?php

declare(strict_types=1);

require __DIR__ . '/autoload.php';

//upvote on click - removes upvote if user has already upvoted the same post
if (loggedIn() && isset($_POST['post_id'])) {
    $stmnt = $pdo->prepare('SELECT upvote FROM upvotes WHERE post_id = :post_id AND user_id = :user_id');
    $usrID = $_SESSION['user']['id'];
    $postID = (int) $_POST['post_id'];
    $upvoted = toggleUpvote($postID, $pdo);
    if ($upvoted) {
        $stmnt = $pdo->prepare('DELETE FROM upvotes WHERE user_id = :user_id AND post_id = :post_id');
    } else {
        $stmnt = $pdo->prepare('INSERT INTO upvotes (user_id, post_id) VALUES (:user_id, :post_id)');
    }
    $stmnt->execute([
        ':user_id' => $usrID,
        ':post_id' => $postID
    ]);
}
redirect('/');
