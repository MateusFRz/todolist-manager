<div class="row">

<?php

foreach($checkLists as $lists):

?>
    <div class="col-md-4">
        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title"><?= $lists->getName() ?></h5>
                    <ul>
                        <?php foreach ($lists as $task): ?>
                        <li><?php echo ($task->isDone() ? "<i class=\"fas fa-check-circle\"></i>" : "<i class=\"fas fa-times-circle\"></i>")
                                . " " . $task->getName() . " - " . $task->getDescription(); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <a href="#" class="card-link">Card link</a>
                <a href="#" class="card-link">Another link</a>
            </div>
        </div>
    </div>
<?php

endforeach;
?>
</div>