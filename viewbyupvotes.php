<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>

<a href="index.php"><button>Sort by date</button></a>

<?php $currentUser = userByID($_SESSION['user']['id'], $pdo); ?>
<?php $postsArray = postsArrayByUpvotes($pdo) ;?>       


<h1><?php echo $config['title']; ?></h1>
<section class="newPost">
    <button class="btn"><a href="/newpost.php">Create new post</button></a>
</section>
<br>
<br>
<div class="byUpvoteWrapper">
    <section class="posts">   
        <?php foreach ($postsArray as $posts) : ?>
            <a href="post.php?id=<?php echo $posts['id'];?>">
            <h1><?php echo $posts['headline']; ?></h1>
            </a>
            <p><?php echo $posts['date']; ?></p>
            <h3> <?php echo $posts['username']; ?></h3>
            <p><a href="<?php echo $posts['link']; ?>"><?php echo $posts['link']; ?></a></p>
            <p><?php echo $posts['content']; ?></p>
            <a href="post.php">
            <p><?php echo numberOfComments($posts['id'], $pdo)['numberOfComments']; ?> Comment</p>
            </a>
            <form action="/app/upvotes.php" 
            class="upvotesForm"
            method="post"
            name="upvote">
           <input type="hidden" id="post_id" name="post_id" value="<?php echo $posts['id']?>">
           <button type="submit" class="upvoteBtn">
           <img src="/assets/images/vote.png">
           </button>
        </form> <p><?php echo numberOfUpvotes($posts['id'], $pdo)['numberOfUpvotes']; ?></p>
        <?php endforeach;?>
    </section>
</div>






<?php require __DIR__ . '/views/footer.php'; ?>
