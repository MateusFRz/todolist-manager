<?php


class TaskController {

    public static function addTask() {
        $name = "";
        $description = "";
        $checklistID = "";

        if (!Validation::isValid($_REQUEST['name'], $name) || !Validation::isValid($_REQUEST['description'], $description) ||
            !Validation::isValid($_REQUEST['checklistID'], $checklistID))
            throw new InvalidArgumentException('Something wrong', 403);

        $task = new Task($name, $description, false, uniqid("", true));
        Model::insertTask($task, $checklistID);
    }

    public static function updateTask() {
        $taskID = "";
        $name = "";
        $description = "";

        if (!Validation::isValid($_REQUEST['taskID'], $taskID) || !Validation::isValid($_REQUEST['name'], $name) ||
            !Validation::isValid($_REQUEST['description'], $description))
            throw new InvalidArgumentException('Something wrong', 403);


        $task = new Task($name, $description, false, uniqid("", true));
        Model::updateTask($taskID, $task);
    }

    public static function removeTask() {
        $taskID = "";

        if (!Validation::isValid($_REQUEST['taskID'], $taskID))
            throw new InvalidArgumentException('Something Wrong');

        Model::deleteTask($taskID);
    }

    public static function changeTaskState() {
        $taskID = "";

        if (!Validation::isValid($_REQUEST['taskID'], $taskID))
            throw new InvalidArgumentException('Something Wrong');

        Model::changeTaskState($taskID);
    }
}