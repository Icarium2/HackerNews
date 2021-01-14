<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>




<h2>Edit Post</h2>
<div class="createPostContainer">
    <form action="/app/posts/update.php" 
    method="post">
        <label for="title">Title</label>
        <br>
        <input type="text" 
        name="title" 
        id="title" 
        required />
        <br>
        <label for="description">Description</label>
        <br>
        <textarea id="description" 
        name="description" 
        placeholder="description" 
        required>
        </textarea>
        <br>
        <label for="link">Url</label>
        <br>
        <input type="link" 
        name="link" 
        id="link">
        <br>
        <br>
        <button class="btn" type="submit">Update</button>

    </form>
</div>

<?php require __DIR__ . '/views/footer.php'; ?>