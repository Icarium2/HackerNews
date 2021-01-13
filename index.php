<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>

<?php $currentUser = userByID($_SESSION['user']['id'], $pdo); ?>
<?php $postsArray = postsArrayByDate($pdo) ;?>       

<h1><?php echo $config['title']; ?></h1>
<article class="newPost">
    <button class="btn"><a href="/newpost.php">Create new post</button></a>
</article>
<br>
<br>
<div class="postsWrapper">
    <section class="posts">   
        <?php foreach ($postsArray as $posts) : ?>
        
            <h1><?php echo $posts['headline']; ?></h1>
            <h3> <?php echo $posts['username']; ?></h3>
            <h3><?php echo $posts['link']; ?></h3>
            <p><?php echo $posts['content']; ?></p>
            <p><?php echo numberOfUpvotes($posts['id'], $pdo)['numberOfUpvotes']; ?></p>
            <p><?php echo numberOfComments($posts['id'], $pdo)['numberOfComments']; ?></p>
           
            

        <form action="/app/upvotes.php" 
        class="upvotesForm"
        method="post"
        name="upvote">
        <input type="hidden" id="post_id" name="post_id" value="<?php echo $posts['id']?>">
           <button type="submit" class="upvoteBtn">
           <img src="/assets/images/vote.png">
           </button>
        </form>
        <?php endforeach;?>
    </section>
</div>






<?php require __DIR__ . '/views/footer.php'; ?>
