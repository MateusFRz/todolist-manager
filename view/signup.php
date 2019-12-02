<?php

require_once "pageContent/header.php";
?>
<body>
    <div class="container">
        <form method="post">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name">
            </div>
            <div class="form-group">
                <label for="surname">Surname</label>
                <input type="text" class="form-control" id="surname">
            </div>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="email" aria-describedby="emailHelp">
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password">
            </div>
            <button type="submit" class="btn btn-primary">Sign up</button>
            <a href="?action=loginPage">Already have an account ?</a>
            <input type="hidden" name="action" value="signup">
        </form>
    </div>

</body>


<?php
require_once "pageContent/footer.php";