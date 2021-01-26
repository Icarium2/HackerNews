<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>

<?php $postID = $_GET['id']; ?>


<h2>Edit Post</h2>
<div class="editPostContainer">
    <form action="/app/comments/update.php?id=<?php echo $postID; ?>" method="post">
        <textarea rows="10" cols="30" name="new-comment" id="<?php $postID; ?>"><?php echo getComment($postID, $pdo)['comment']; ?></textarea>
        <br>
        <br>
        <button type="submit">Update</button>
    </form>
</div>
<br><br><br>

<form action="app/comments/delete.php?id=<?php echo getComment($postID, $pdo)['id']; ?>" method="post">
    <div class="form-group">
        <button type="submit" class="btn delete">Delete Comment</button>
    </div>
</form>

<?php require __DIR__ . '/views/footer.php'; ?>
