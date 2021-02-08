<?php
require __DIR__ . '/app/autoload.php';
require __DIR__ . '/views/header.php';

if (!loggedIn()) {
    redirect("/login.php");
}

?>

<form action="/app/users/editavatar.php" method="post" enctype="multipart/form-data">
    <label for="file">Upload profile image(jpg, jpeg, png)</label>
    <br>
    <div class="form-group">
        <input type="file" accept=".png, .jpg, .jpeg" name="avatar" placeholder="upload profile image" required>
    </div>
    <button type="submit" class="btn">Upload</button>
</form>
<br>
<br>
<form action="app/users/editbio.php" method="post">
    <label for="bio">Edit Bio</label>
    <div class="form-group">
        <textarea name="edit-bio" cols="30" rows="5"></textarea>
    </div>
    <button type="submit" class="btn">Save</button>
</form>
<form action="app/users/editemail.php" method="post">
    <label for="email">Change email</label>
    <div class="form-group">
        <input class="form-control" type="email" name="edit-email" placeholder="new email" required>
    </div>
    <button type="submit" class="btn">Save</button>
</form>
<h3>Change password</h3>
<form action="app/users/editpassword.php" method="post">
    <div class="form-group">
        <input class="form-control" type="password" name="pwd" id="password" required>
        <small class="form-text text-muted">Current password</small>
        <div class="form-group">
            <input class="form-control" type="password" name="edit-password" id="password" required>
            <small class="form-text text-muted">New Password</small>
        </div>
        <div class="form-group">
            <input class="form-control" type="password" name="confirm-password" id="password" required>
            <small class="form-text text-muted">Confirm New Password</small>
        </div>
        <button type="submit" class="btn">Save changes</button>
    </div>
</form>

<h3>Delete account</h3>
<form action="/app/users/deleteUser.php" method="post">
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
        <label for="password_repeat">Repeat Password</label>
        <input type="password" id="password_repeat" name="password_repeat" required>
        <button type="submit" class="delete">Delete account</button>
    </div>
</form>

<?php require __DIR__ . '/views/footer.php'; ?>
