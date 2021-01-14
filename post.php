<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>

<?php
$postId = $_GET['id'];
$post = postById($postId, $pdo);
$comments = postComments($postId, $pdo);
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
        <?php if ($currentUser === $userPost) : ?>
            <a href="/editpost.php?id=<?php echo $post['id']; ?>">Edit Post</a>
            <form action="/app/upvotes.php" 
                class="upvotesForm"
                method="post"
                name="upvote">
           <input type="hidden" 
                id="post_id" 
                name="post_id" 
                value="<?php echo $posts['id']?>">
           <button type="submit" class="upvoteBtn">
                <img src="/assets/images/vote.png">
           </button>
           </form> <p><?php echo numberOfUpvotes($post['id'], $pdo)['numberOfUpvotes']; ?></p>
        <?php endif; ?>


        <h2>Comment on this post ffs</h2>
<div class="commentForms">
    <form action="/app/comments/store.php?id=<?php echo $_GET['id'];?>" 
    method="post">
        <label for="description">New comment</label>
        <br>
        <textarea id="description" 
        name="new-comment" 
        placeholder="description" 
        cols="30"
        rows="5"
        required>
        </textarea>
        <br>
        <br>
        <button class="btn" type="submit">Create</button>
        <br>
        <br>

    </form>
</div>
       <section class="commentSection">
        <?php foreach ($comments as $comment) : ?>
            <?php $currentUser = $_SESSION['user']['id']; ?>
            <?php $userComment = $comment['user_id']; ?>
            <img src="<?php echo '/app/users/uploads/' . $comment['avatar']?>" alt="avatar">
            <p><?php echo $comment['username']; ?></p>
            <h3><?php echo $comment['comment']; ?></h3>
            <h4><?php echo $comment['date']; ?></h4>
        
            <?php if ($currentUser === $userPost) : ?>
            <a href="/editcomment.php?id=<?php echo $comment['id']; ?>">Edit comment</a>
            <?php endif; ?>
            <br>
            <br>
           




        <?php endforeach; ?>
    </section>
    </section>




<?php endif; ?>
<?php require __DIR__ . '/views/footer.php'; ?>





