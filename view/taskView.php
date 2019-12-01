<div class="row">
<?php
$rowCount = 0;
$numCols = 3;
foreach ($checkLists as $checklist): ?>
    <div class="col">
        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title"><?= $checklist->getName() ?></h5>
                <ul class="list-unstyled">
                    <?php foreach ($checklist->getTasks() as $task): ?>
                    <li><?php echo ($task->isDone() ? "<i class=\"fas fa-check-circle\"></i>" : "<i class=\"fas fa-times-circle\"></i>")
                            . " " . $task->getName() . " - " . $task->getDescription(); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
<?php
$rowCount++;
if ($rowCount % $numCols == 0) echo "</div></br><div class=\"row\">";
endforeach; ?>
</div>