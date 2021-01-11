<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>

<h1><?php echo $config['title']; ?></h1>
<article class="newPost">
    <button class="btn"><a href="/newpost.php">Create new post</button></a>
</article>


<div class="postWrapper">
    <div class="postHeadline">
        <a href="/post.php">
           <h2 class="headline">This is the headline</h2>
           <br>
        </a>
    </div>
    <p class="postAuthor">Author of the post</p>
    <div class="postInformation">
        <a href="/post.php">
            <p>comments</p>          
        </a>
        <a href="postUpvotes">
             <p>1042</p>  
        </a>

    

        
        
    </div>
</div>























<?php require __DIR__ . '/views/footer.php'; ?>
