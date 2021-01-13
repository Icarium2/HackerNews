<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>

<?php if (!isset($_SESSION['user'])) : ?>
       <?php redirect('/login.php'); ?>
<?php endif; ?>
<?php $currentUser = userByID($_SESSION['user']['id'], $pdo);?>
<?php $numberOfPosts = postsByCurrentUser($_SESSION['user']['id'], $pdo); ?>
<?php $totalUpvotes = currentUserUpvoted($_SESSION['user']['id'], $pdo); ?>

<article class="profileWrapper">
    <div class="profile">
        <div class="user">
        <h1><?php echo $_SESSION['user']['username']; ?></h1>
        <div class="profileImg">
            <img src="<?php echo '/app/users/uploads/' . $currentUser['avatar'];?>" 
            alt="user-avatar">
        </div>
        </div>
        <div class="bio">
            <h2>Bio</h2>
            </div>
            <p><?php echo $currentUser['bio'] ?></p>
        </div>
        <div class="postInfo">
            <p>Posts:<br><?php echo $numberOfPosts['userPosts']; ?></p>
            
            <br>
            <p>Upvoted:<br><?php echo $totalUpvotes['totalUpvotes']; ?> times </p>  
            <br>
            <br>    
        </div>
    </div>
    <div class="btnContainer">
    <button class="btn editProfileBtn"><a href="/editprofile.php">EDIT PROFILE</a></button>
    <p>Click this button to edit your account and profile</p>
    </div>
</article>
</div>



<?php require __DIR__ . '/views/footer.php'; ?>