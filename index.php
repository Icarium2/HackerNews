<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>

<?php $postsArray = postsArray($pdo);?>

<h1><?php echo $config['title']; ?></h1>
<article class="newPost">
    <button class="btn"><a href="/newpost.php">Create new post</button></a>
</article>
<br>
<br>
<div class="postsWrapper">
    <section class="posts"> 




    </section>
</div>






<?php require __DIR__ . '/views/footer.php'; ?>
