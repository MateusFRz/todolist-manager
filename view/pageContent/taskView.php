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
                <div class="card-header">
                    <form method="post">
                        <h5 class="card-title"><?= $checklist->getName()."\n"?>
                            <button type="submit" class="close text-danger" name="action" value="removeChecklist">
                                <span class="fas fa-times" style="font-size: 20px; padding: 2px;"></span>
                            </button>
                            <button type="submit" class="close text-primary" name="action" value="modifyChecklist">
                                <span class="fas fa-edit" style="font-size: 20px; padding: 2px;"></span>
                            </button>
                            <input type="hidden" name="checklistID" value="<?= $checklist->getID(); ?>">
                        </h5>
                    </form>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <?php foreach ($checklist->getTasks() as $task): ?>
                            <li><?= ($task->isDone() ? "<i class=\"fas fa-check-circle\"></i><strike>" : "<i class=\"fas fa-times-circle\"></i>")
                                    . " " . $task->getName() . " - " . $task->getDescription(); ?></strike>
                                <form method="post" class="text-right">
                                    <button class="btn text-danger btn-sm" type="submit" name="action"
                                            value="removeTask"><i class="fas fa-trash-alt"></i></button>
                                    <button class="btn text-primary btn-lg" type="submit" name="action"
                                            value="changeTaskState"><i class="<?= $task->isDone() ? "fas fa-check-square" : "far fa-square" ?>"></i></button>
                                    <input type="hidden" name="taskID" value="<?= $task->getID(); ?>">
                                </form>
                            </li>
                            <div class="dropdown-divider"></div>
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