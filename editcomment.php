<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>

<?php
$postId = $_GET['id'];
$post = postById($postId, $pdo);
$comments = postComments($postId, $pdo);
?>


<article>
    <h4>Edit your comment on <a href="/post.php?id=<?php echo $post['id']; ?>"><?php echo $post['title']; ?>.</a></h4>
    <br>
    <?php foreach ($comments as $comment) : ?>
            <form action="/app/comments/update.php?id=<?php echo $comment['post_id']; ?>&comment-id=<?php echo $comment['id']; ?>" method="post">
                <div class="form-group">
                    <textarea class="form-control" type="text" name="new-comment" rows="5" cols="10" required><?php echo $comment['comment']; ?></textarea>
                </div>
                <button type="submit" class="btn">Edit Comment</button>
            </form>
        </div>
    <?php endforeach; ?>
</article>


<?php require __DIR__ . '/views/footer.php'; ?>