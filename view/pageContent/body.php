<body>
<div class="container">
    <?php
    if (!empty($errors) || !empty($successes))
        require_once "alert.php";

    require_once "taskView.php";
    ?>

</div>
</body>