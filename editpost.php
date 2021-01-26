<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>


<?php $postID = $_GET['id']; ?>
<?php $post = postById($postID, $pdo); ?>

<h2>Edit Post</h2>
<div class="editPostContainer">
    <form action="/app/posts/update.php" method="post">
        <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
        <label for="title">Title</label>
        <br>
        <input type="text" name="headline" id="title" value="<?php echo $post['headline']; ?>" required />
        <br>
        <label for="description">Description</label>
        <br>
        <textarea id="description" name="content" placeholder="description" required>
        <?php echo $post['content']; ?>
        </textarea>
        <br>
        <label for="link">Url</label>
        <br>
        <input type="url" name="link" value="<?php echo $post['link']; ?>" id="link">
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
