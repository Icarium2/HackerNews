<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (loggedIn() && isset($_POST['post_id']) && !empty($_POST['post_id'])) {
    $userId = (int)filter_var($_SESSION['user']['id'], FILTER_SANITIZE_NUMBER_INT);
    $postId = (int)filter_var($_POST['post_id'], FILTER_SANITIZE_NUMBER_INT);
    togglePostUpvote($userId, $postId, $pdo);
    $response = fetchNumberOfPostUpvotes($postId, $pdo);
    header('Content-Type: application/json');
    echo json_encode($response);
}
