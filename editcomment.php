<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>

<?php
$postId = $_GET['id'];
$comments = postComments($postId, $pdo);
?>

<?php foreach ($comments as $comment) : ?>

<h2>Edit comment</h2>
<div class="createPostContainer">
    <form action="/app/comments/update.php?id=<?php echo $_POST['id'];?>" 
    method="post">
        <label for="edit-comment">Edit comment</label>
        <br>
        <input type="text" 
        name="edit-comment" 
        id="edit-comment"/>
        <br>
    
    </form>
</div>


<h2>delete comment</h2>
<form action="/app/comments/delete.php?id=<?php echo $comment['id']; ?>" method="post">
            <div class="form-group">
                <button type="submit" class="btn">Delete Post</button>
        </div>

</form>

<?php endforeach; ?>

<?php require __DIR__ . '/views/footer.php'; ?>