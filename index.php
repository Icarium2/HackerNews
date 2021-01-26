<?php
require __DIR__ . '/app/autoload.php';
require __DIR__ . '/views/header.php';

$postsArray = postsArrayByDate($pdo);

if (loggedIn()) {
    $currentUser = $_SESSION['user']['id'];
}

?>
<a href="viewbyupvotes.php"><button>Sort by upvotes</button></a>
<h1><?php echo $config['title']; ?></h1>
<section class="newPost">
    <button class="btn"><a href="/newpost.php">Create new post</button></a>
</section>
<br>
<br>
<div class="postsWrapper">
    <section class="posts">
        <?php foreach ($postsArray as $posts) : ?>
            <img src="<?php echo '/app/users/uploads/' . $posts['avatar']; ?>" alt="avatar">
            <?php $userPost = $posts['user_id']; ?>
            <a href="post.php?id=<?php echo $posts['id'] ?>&order_by=new">
                <h1><?php echo $posts['headline']; ?></h1>
            </a>
            <p><?php echo $posts['date']; ?></p>
            <h3> <?php echo $posts['username']; ?></h3>
            <p><a href="<?php echo $posts['link']; ?>"><?php echo $posts['link']; ?></a></p>
            <p><?php echo $posts['content']; ?></p>
            <a href="post.php?id=<?php echo $posts['id'] ?>">
                <p><?php echo numberOfComments($posts['id'], $pdo)['numberOfComments']; ?> comments</p>
            </a>
            <div class="upvote post">
                <?php if (loggedIn()) : ?>
                    <button class="upvoteBtn <?= hasUserUpvotedPost($_SESSION['user']['id'], $posts['id'], $pdo) ? "active" : "" ?>" data-id="<?= $posts['id'] ?>">
                        <img src="/assets/images/vote.png">
                    </button>
                <?php else : ?>
                    <button class="upvoteBtn">
                        <img src="/assets/images/vote.png">
                    </button>
                <?php endif; ?>
                <p class="upvotes"><?= fetchNumberOfPostUpvotes($posts['id'], $pdo) ?></p>
            </div>
            <p>
                <?php if (loggedIn() && $currentUser === $userPost) : ?>
                    <a href="/editpost.php?id=<?php echo $posts['id']; ?>">Edit Post</a>
                <?php endif; ?>
            </p>
        <?php endforeach; ?>
    </section>
</div>

<?php require __DIR__ . '/views/footer.php'; ?>
