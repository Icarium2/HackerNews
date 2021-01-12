<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>


<form action="/app/users/editavatar.php" 
    method="post"   
    enctype="multipart/form-data">
    <label for="file">Upload profile image(jpg, jpeg, png)</label>
    <br>
    <div class="form-group">
        <input type="file"
        accept=".png, .jpg, .jpeg" 
        name="avatar"
        placeholder="upload profile image"
        required>
    </div>
    <button type="submit" class="btn">Upload</button>
</form>
<br>
<br>
<form action="app/users/editbio.php" 
    method="post">
    <label for="bio">Edit Bio</label>
    <div class="form-group">
        <textarea 
        name="edit-bio" 
        cols="30"
        rows="5"></textarea>
    </div>
    <button type="submit" class="btn">Save</button>
</form>

<form action="app/users/editusername.php" 
    method="post">
    <div class="form-group">
                <label for="username">new username</label><br><br>
                <input class="form-control"
                type="username"
                name="username"
                id="username"
                placeholder="Username"
                required>
    </div><br>
    <button type="submit" class="btn">Save</button>
    <br>
</form>

<form action="app/users/editemail.php" 
    method="post">
    <label for="email">Change email</label>
        <div class="form-group">
            <input class="form-control" 
            type="email" 
            name="edit-email"
            placeholder="new email"
            required>
            
        </div>
        <button type="submit" class="btn">Save</button>
</form>

<h3>Change password</h3>
<form action="app/users/editpassword.php" 
    method="post">
        <div class="form-group">
            <input class="form-control" 
            type="password" 
            name="pwd" 
            id="password"
            required>
            <small class="form-text text-muted">Current password</small>
        <div class="form-group">
            <input class="form-control" 
            type="password" 
            name="edit-password" 
            id="password"
            required>
            <small class="form-text text-muted">New Password</small>
        </div>
        <div class="form-group">
            <input class="form-control" 
            type="password" 
            name="confirm-password" 
            id="password"
            required>
            <small class="form-text text-muted">Confirm New Password</small>
        </div>
        <button type="submit" class="btn">Save changes</button>
</form>




<?php require __DIR__ . '/views/footer.php'; ?>