<?php
require __DIR__ . '/app/autoload.php';
require __DIR__ . '/views/header.php';

if (isset($_GET['id'])) {
    $commentId = trim(filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT));
    $comment = getComment($commentId, $pdo);
    $poster = userById($comment['user_id'], $pdo);
}

?>
<section class="comment">
    <img class="avatar" src="<?php echo '/app/users/uploads/' . $poster['avatar'] ?>" alt="avatar">
    <p><?php echo $poster['username']; ?></p>
    <h3><?php echo $comment['comment']; ?></h3>
    <h4><?php echo $comment['date']; ?></h4>
</section>
<section class="comment-reply">
    <form action="/app/comments/reply.php" method="post" style="display: flex; flex-direction:column;">
        <label for="reply">Reply to <?= $poster['username'] ?></label>
        <textarea id="reply" name="reply" placeholder="reply" cols="30" rows="5" required></textarea>
        <input type="hidden" id="comment-id" name="comment-id" value="<?= $comment['id'] ?>">
        <input type="hidden" id="post-id" name="post-id" value="<?= $comment['post_id'] ?>">
        <button type="submit">Submit reply</button>
    </form>
</section>

<?php
require __DIR__ . '/views/footer.php';
?>
