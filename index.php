<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>

<a href="viewbyupvotes.php"><button>Sort by upvotes</button></a>


<?php $postsArray = postsArrayByDate($pdo); ?>

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
            <?php $currentUser = $_SESSION['user']['id']; ?>
            <?php $userPost = $posts['user_id']; ?>
            <a href="post.php?id=<?php echo $posts['id']; ?>">
                <h1><?php echo $posts['headline']; ?></h1>
            </a>
            <p><?php echo $posts['date']; ?></p>
            <p> <?php echo $posts['username']; ?></p>
            <p><a href="<?php echo $posts['link']; ?>"><?php echo $posts['link']; ?></a></p>
            <p><?php echo $posts['content']; ?></p>
            <a href="post.php?id=<?php echo $posts['id']; ?>">
                <p><?php echo numberOfComments($posts['id'], $pdo)['numberOfComments']; ?> comments</p>
            </a>
            <form action="/app/upvotes.php" class="upvotesForm" method="post" name="upvote">
                <input type="hidden" id="post_id" name="post_id" value="<?php echo $posts['id'] ?>">
                <button type="submit" class="upvoteBtn">
                    <img src="/assets/images/vote.png">
                </button>
            </form>
            <p><?php echo numberOfUpvotes($posts['id'], $pdo)['numberOfUpvotes']; ?></p>
            <p>
                <?php if ($currentUser === $userPost) : ?>
                    <a href="/editpost.php?id=<?php echo $posts['id']; ?>">Edit Post</a>
                <?php endif; ?>
            </p>
        <?php endforeach; ?>
    </section>
</div>

<?php require __DIR__ . '/views/footer.php'; ?>
