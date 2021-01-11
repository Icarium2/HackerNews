<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>

<?php if (!isset($_SESSION['user'])) : ?>
       <?php redirect('/login.php'); ?>
    <?php endif; ?>
    


<article class="profileWrapper">
    <div class="profile">
        <div class="user">
        <h1>User</h1>
        <div class="profileImg">
            <img src="/assets/images/placeholder.png" 
            alt="placeholder image">
        </div>
        </div>
        <div class="bio">
            <h2>Bio</h2>
            <div class="fullName">
            <h3>First name</h3><br>
            <h3>Last name </h3>
            </div>
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
    <div class="btnContainer">
    <button class="btn editProfileBtn"><a href="/editprofile.php">EDIT PROFILE</a></button>
    <p>Click this button to edit your account and profile</p>
    </div>

</article>



<?php require __DIR__ . '/views/footer.php'; ?>