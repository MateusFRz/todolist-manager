<div class="row">



<?php foreach ($checkLists as $checkList): ?>
    <div class="col-md-4">
        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title"><?= $checkList->getName() ?></h5>
                <ul class="list-unstyled">
                    <?php foreach ($checkList->getTasks() as $task): ?>
                    
                    <li><?php echo ($task->isDone() ? "<i class=\"fas fa-check-circle\"></i>" : "<i class=\"fas fa-times-circle\"></i>")
                            . " " . $task->getName() . " - " . $task->getDescription(); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
<?php endforeach; ?>


</div>