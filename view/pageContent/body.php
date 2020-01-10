<body>
<div class="container">
    <?php
    if (!isset($errors) || !isset($successes))
        require_once "alert.php";

    require_once "taskView.php";
    ?>

</div>
</body>