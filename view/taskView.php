<div class="row">
    <div class="col-md-4">
        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title"><?= $checkLists->getName() ?></h5>
                <ul class="list-unstyled">
                    <?php foreach ($checkLists->getTasks() as $task): ?>

                    <li><?php echo ($task->isDone() ? "<i class=\"fas fa-check-circle\"></i>" : "<i class=\"fas fa-times-circle\"></i>")
                            . " " . $task->getName() . " - " . $task->getDescription(); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>