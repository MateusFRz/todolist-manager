<?php

require_once "pageContent/header.php";
?>
    <body>
    <?php require_once "pageContent/navbar.php"; ?>
    <div class="container">
        <form method="post">
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="email" aria-describedby="emailHelp">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password">
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
            <input type="hidden" name="action" value="login">
        </form>
    </div>
    </body>
<?php
require_once "pageContent/footer.php";