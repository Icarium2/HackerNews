<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>

<?php if (!isset($_SESSION['user'])) : ?>
       <?php redirect('/login.php'); ?>
    <?php endif; ?>
    


<article class="profileWrapper">
    <div class="profile">
        <h1>User</h1>
        <div class="profileImg">
            <img src="/assets/images/placeholder.png" 
            alt="placeholder image">
        </div>
        <div class="bio">
            <h2>Bio</h2>
            <p> In here you read your biography</p>
        </div>
        <div class="postInfo">
            <p>Posts:</p>
            <br>
            <p>Upvotes</p>  
            <br>
            <br>    
        </div>
    </div>
    
    <button class="btn editProfileBtn"><a href="/editprofile.php">EDIT PROFILE</a></button>
    <p>Click this button to edit your account and profile</p>

</article>



<?php require __DIR__ . '/views/footer.php'; ?>