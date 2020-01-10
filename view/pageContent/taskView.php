<div class="card-columns">
    <?php

    require_once "addChecklist.php";
    if (isset($checklists)): ?>

        <?php foreach ($checklists as $checklist): ?>
        <div class="card" style="width: 20rem;">
            <div class="card-header">
                <form method="post">
                    <div class="card-title">
                        <ul class="list-unstyled list-group-horizontal">
                            <li>
                                <button type="submit" class="close text-danger" name="action" value="removeChecklist">
                                    <span class="fas fa-times" style="font-size: 20px; padding: 2px;"></span>
                                </button>
                            </li>
                            <li>
                                <button type="submit" class="close text-primary" name="action" value="modifyChecklist"
                                        id="modifyChecklist" style="display:none;">
                                    <span class="fas fa-edit" style="font-size: 20px; padding: 2px;"></span>
                                </button>
                            </li>
                            <li><h5 id="checklistName"><?= $checklist->getName() . "\n" ?></h5></li>
                        </ul>
                        <input type="hidden" name="checklistID" value="<?= $checklist->getID(); ?>">
                    </div>
                </form>
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <?php $tasks = $checklist->getTasks();
                    foreach ($tasks as $task): ?>
                        <li><?= ($task->isDone() ? "<i class=\"fas fa-check-circle\"></i><strike>" : "<i class=\"fas fa-times-circle\"></i>")
                            . " " . $task->getName() . " - " . $task->getDescription(); ?></strike>
                            <form method="post" class="text-right">
                                <button class="btn text-danger btn-sm" type="submit" name="action"
                                        value="removeTask"><i class="fas fa-trash-alt"></i></button>
                                <button class="btn text-primary btn-lg" type="submit" name="action"
                                        value="changeTaskState"><i
                                            class="<?= $task->isDone() ? "fas fa-check-square" : "far fa-square" ?>"></i>
                                </button>
                                <input type="hidden" name="taskID" value="<?= $task->getID(); ?>">
                            </form>
                        </li>
                        <?= array_search($task, $tasks) == array_key_last($tasks) ? "" : "<div class=\"dropdown-divider\"></div>" ?>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="card-footer">
                <form class="small text-right">
                    <div class="form-group">
                        <input type="text" id="name" class="form-control" placeholder="Task name" name="name">
                    </div>
                    <div class="form-group">
                        <textarea rows="3" type="text" id="description" class="form-control" placeholder="Description"
                                  name="description"></textarea>
                    </div>
                    <button class="btn btn-success btn-sm" type="submit">Add</button>
                    <input type="hidden" name="action" value="addTask">
                    <input type="hidden" name="checklistID" value="<?= $checklist->getID(); ?>">
                </form>
            </div>
        </div>
    <?php
    endforeach;
    endif; ?>
</div>

<nav>
    <?php if (!empty($nbPages) && !empty($page)): ?>
    <ul class="pagination justify-content-center">
        <li class="page-item <?= ($nbPages > 1  && $page > 1 ? "" : "disabled") ?>">
            <a class="page-link" href="?page=<?= $page-1 ?>" tabindex="-1">Previous</a>
        </li>

        <?php for ($i = 1; $i <= $nbPages; $i++):
                if ($i == $page): ?>
            <li class="page-item active"><a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a></li>
        <?php else: ?>
            <li class="page-item"><a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a></li>
        <?php endif; endfor;?>

        <li class="page-item <?= ($nbPages > $page ? "" : "disabled") ?>">
            <a class="page-link" href="?page=<?= $page+1 ?>">Next</a>
        </li>
    </ul>
    <?php endif; ?>
</nav>