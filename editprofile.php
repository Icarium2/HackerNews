<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>


<form action="/app/users/editprofile.php" 
    method="POST"   
    enctype="multipart/form-data">
    <input type="file" 
    name="file">
    <button type="submit" name="submit">Upload</button>

<?php require __DIR__ . '/views/footer.php'; ?>