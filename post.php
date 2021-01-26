<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>

<?php

if (isset($_GET['id'])) {
    $postId = trim(filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT));
    $post = postById($postId, $pdo);
    $comments = postComments($postId, $pdo);
}
?>

<?php if (loggedIn()) : ?>
    <section class="postContainer">
        <?php $currentUser = $_SESSION['user']['id']; ?>
        <?php $userPost = $post['user_id']; ?>
        <h1><?php echo $post['headline']; ?></h1>
        <img src="<?php echo 'app/users/uploads/' . $post['avatar'] ?>" alt="avatar">
        <p><?php echo $post['username']; ?></p>
        <h2><?php echo $post['content']; ?></h2>
        <h3><?php echo $post['date']; ?></h3>
        <a href="<?php echo $post['link']; ?>"><?php echo $post['link']; ?></a><br>
        <div class="upvote post">
            <button class="upvoteBtn <?= hasUserUpvotedPost($_SESSION['user']['id'], $post['id'], $pdo) ? "active" : "" ?>" data-id="<?= $post['id'] ?>">
                <img src="/assets/images/vote.png">
            </button>
            <p class="upvotes"><?= fetchNumberOfPostUpvotes($post['id'], $pdo) ?></p>
        </div>
        <?php if ($currentUser === $userPost) : ?>
            <a href="/editpost.php?id=<?php echo $post['id']; ?>">Edit Post</a>
        <?php endif; ?>
        <h2>Comment on this post ffs</h2>
        <div class="commentForms">
            <form action="/app/comments/store.php?id=<?php echo $_GET['id']; ?>" method="post">
                <label for="description">New comment</label>
                <br>
                <textarea id="description" name="new-comment" placeholder="description" cols="30" rows="5" required></textarea>
                <br>
                <br>
                <button class="btn" type="submit">Create</button>
                <br>
                <br>
            </form>
        </div>
        <?php if (isset($comments)) : ?>
            <section class="commentSection">
                <?php foreach ($comments as $comment) : ?>
                    <img src="<?php echo '/app/users/uploads/' . $comment['avatar'] ?>" alt="avatar">
                    <p><?php echo $comment['username']; ?></p>
                    <h3><?php echo $comment['comment']; ?></h3>
                    <h4><?php echo $comment['date']; ?></h4>
                    <?php if (loggedIn() && $_SESSION['user']['id'] === $comment['user_id']) : ?>
                        <a href="/editcomment.php?id=<?php echo $comment['id']; ?>">Edit comment</a>
                    <?php endif; ?>
                    <br>
                    <br>
                <?php endforeach; ?>
            </section>
        <?php endif; ?>
    </section>
<?php else : ?>
    <?php redirect('/login.php'); ?>
<?php endif; ?>
<?php require __DIR__ . '/views/footer.php'; ?>
