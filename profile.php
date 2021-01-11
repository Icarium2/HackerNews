<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>

<?php if (!isset($_SESSION['user'])) : ?>
       <?php redirect('/login.php'); ?>
    <?php endif; ?>
    


<article class="profile">
    <div class="profileWrapper">
        <h1>Profile</h1>
        <div class="profileImg">
        <div class="bio">


        </div>
        </div>
    </div>
<button class="btn editProfileBtn"><a href="/editprofile.php">EDIT PROFILE</a></button>

</article>



<?php require __DIR__ . '/views/footer.php'; ?>