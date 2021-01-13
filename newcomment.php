<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>

<?php
if (!loggedIn()) {
    redirect('/login.php');
}
?>
<h2>New Post</h2>

<div class="commentForms">
    <form action="/app/comments/store.php" 
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
