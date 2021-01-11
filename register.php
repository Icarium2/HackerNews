<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>

<article class="registerContainer">

    <h2>Sign up for a new Hacker News-account</h2>

    <form action="app/users/register.php" method="post">

        <div class="form-group">
            <label for="email">E-mail</label><br><br>
            <input class="form-control" 
            type="email" 
            name="email" 
            id="email" 
            placeholder="E-mail"
            required>
        </div><br>
        
        <div class="form-group">
            <label for="username">Username</label><br><br>
            <input class="form-control"
            type="username"
            name="username"
            id="username"
            placeholder="Username"
            required>
        </div><br>

        <div class="form-group">
            <label for="password">Password</label><br><br>
            <input class="form-control"
            type="password"
            name="password"
            id="password"
            placeholder="Password"
            required>
        </div><br>
        <button type="submit">Register</button>
    </form>
</article>
    
<?php require __DIR__ . '/views/footer.php'; ?>
