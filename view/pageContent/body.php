<body>
<?php require_once "navbar.php" ?>

<div class="container">

    <?php
        if (!empty($errors))
            require_once "error.php";
        require_once "taskView.php";
    ?>

</div>
</body>