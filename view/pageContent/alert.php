<?php
    if (!empty($errors)):
    foreach ($errors as $error):
        ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error :</strong> <?= $error ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endforeach;
        endif;
     if (!empty($successes)):
    foreach ($successes as $success): ?>

        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success :</strong> <?= $success ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endforeach;
    endif;