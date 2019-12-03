<?php

require_once "pageContent/header.php";
?>
    <body>
    <div class="container">
        <fieldset disabled>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">ID</span>
                </div>
                <input type="text" class="form-control" value="<?= $_SESSION['user']->getID(); ?>">
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Name</span>
                </div>
                <input type="text" class="form-control" value="<?= $_SESSION['user']->getName(); ?>">
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Surname</span>
                </div>
                <input type="text" class="form-control" value="<?= $_SESSION['user']->getSurname(); ?>">
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">E-mail</span>
                </div>
                <input type="text" class="form-control" value="<?= $_SESSION['user']->getEmail(); ?>">
            </div>
        </fieldset>
    </div>
    </body>
<?php
require_once "pageContent/footer.php";