<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// In this file we delete posts in the database.
$usrID = $_SESSION['user']['id'];
$headline = $_POST['headline'];
$content = $_POST['content'];
$link = $_POST['link'];
$postId = $_POST['id'];
$date = date("Y-M-D H:i:s");


$stmnt = $db->prepare("UPDATE posts 
SET headline = :headline, content = :content, link = :link, date = :date WHERE id = :post_id");
$stmnt->bindParam(':headline', $headline);
$stmnt->bindParam(':content', $content);
$stmnt->bindParam(':link', $link);
$stmnt->bindParam(':post_id', $postId);
$stmnt->bindParam(':date', $date);
$stmnt->execute();


redirect('/');