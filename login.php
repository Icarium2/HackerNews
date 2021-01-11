<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>

<div class="loginContainer">
    <h1>Login</h1>

    <form action="app/users/login.php" method="post">
        <div class="form-group">
            <label for="email">Email<br></label>
            <input class="form-control" type="email" name="email" id="email" placeholder="E-mail" required>
            <small class="form-text text-muted">Please provide your email address.</small>
        </div><!-- /form-group -->
        <br>

        <div class="form-group">
            <label for="password">Password<br></label>
            <input class="form-control" type="password" name="password" id="password" placeholder="password" required>
            <small class="form-text text-muted">Please provide your password (passphrase).</small>
        </div><!-- /form-group -->
       <br><button type="submit" class="btn btn-primary">Login</button>
    </form><br><br>
    <h2>Not a user yet? Sign up <a href="/register.php">here!</a></h2>
<?php require __DIR__ . '/views/footer.php'; ?>
