<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>

<article>
    <h1 class="introduction"><?php echo $config['title']; ?></h1>
    <?php if (isset($_SESSION['user'])) : ?>
        <p>Welcome, <?php echo $_SESSION['user']['username']; ?>!</p>
    <?php endif; ?>
</article>

<div class="contentPostWrapper">
    <div class="contentHeadline">
    <p class="author"></p>
    <img src="" alt="" class="postImg">
        <div class="contentPost">
            <p class="upvotes"></p>       
        
        </div>
    </div>
</div>























<?php require __DIR__ . '/views/footer.php'; ?>
