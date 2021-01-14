<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>


<?php $postID = $_GET['id']; ?>
<?php $post = postById($postID, $pdo); ?>

<h2>Edit Post</h2>
<div class="createPostContainer">
    <form action="/app/posts/update.php?id=<?php echo $post['id']; ?>" 
        method="post">
        <label for="title">Title</label>
        <br>
        <input type="text" 
        name="edit-title" 
        id="title" 
        required />
        <br>
        <label for="description">Description</label>
        <br>
        <textarea id="description" 
        name="edit-description" 
        placeholder="description" 
        required>
        </textarea>
        <br>
        <label for="link">Url</label>
        <br>
        <input type="link" 
        name="edit-link" 
        id="link">
        <br>
        <br>
        <button type="submit">Update</button>

    </form>
</div>
<br><br><br>

<form action="app/posts/delete.php?id=<?php echo $post['id']; ?>" method="post">
            <div class="form-group">
                <button type="submit" class="btn">Delete Post</button>
        </div>

</form>



<?php require __DIR__ . '/views/footer.php'; ?>