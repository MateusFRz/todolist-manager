<?php
    require_once "pageContent/header.php";
?>

<body>
    <div class="container">
        <form method="post">
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" name="email" aria-describedby="emailHelp">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password">
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
            <a href="?action=signupPage">Sign up now !</a>
            <input type="hidden" name="action" value="login">
        </form>
    </div>
</body>

<?php
    require_once "pageContent/footer.php";