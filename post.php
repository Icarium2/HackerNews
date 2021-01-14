<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>

<h2>Comment on this post ffs</h2>
<div class="commentForms">
    <form action="/app/comments/store.php?id=<?php echo $_GET['id'];?>" 
    method="post">
        <label for="description">New comment</label>
        <br>
        <textarea id="description" 
        name="new-comment" 
        placeholder="description" 
        cols="30"
        rows="5"
        required>
        </textarea>
        <br>
        <br>
        <button class="btn" type="submit">Create</button>

    </form>
</div>

<?php require __DIR__ . '/views/footer.php'; ?>





