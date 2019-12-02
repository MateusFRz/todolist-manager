<div class="row">
    <?php
    $rowCount = 1;
    $numCols = 3;

    require_once "addChecklist.php";
    if (!empty($checklists)):
        ?>

        <?php foreach ($checklists as $checklist): ?>
        <div class="col-4">
            <div class="card" style="width: 20rem;">
                <div class="card-body">
                    <h5 class="card-title"><?= $checklist->getName() ?></h5>
                    <ul class="list-unstyled">
                        <?php foreach ($checklist->getTasks() as $task): ?>
                            <li><?php echo ($task->isDone() ? "<i class=\"fas fa-check-circle\"></i><strike>" : "<i class=\"fas fa-times-circle\"></i>")
                                    . " " . $task->getName() . " - " . $task->getDescription(); ?></strike></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
        <?php
        $rowCount++;
        if ($rowCount % $numCols == 0) echo "</div></br><div class=\"row\">";
    endforeach;
    endif; ?>
</div>