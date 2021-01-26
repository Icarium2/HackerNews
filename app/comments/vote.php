<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (loggedIn() && isset($_POST['comment_id']) && !empty($_POST['comment_id'])) {
    $userId = (int)filter_var($_SESSION['user']['id'], FILTER_SANITIZE_NUMBER_INT);
    $commentId = (int)filter_var($_POST['comment_id'], FILTER_SANITIZE_NUMBER_INT);
    toggleCommentUpvote($userId, $commentId, $pdo);
    $response = fetchNumberOfCommentUpvotes($commentId, $pdo);
    header('Content-Type: application/json');
    echo json_encode($response);
}
