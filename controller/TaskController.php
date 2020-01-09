<?php


class TaskController {

    /**
     * Create and add
     * a Task in the Data Base
     */
    public static function addTask() {
        $name = "";
        $description = "";
        $checklistID = "";

        if (!Validation::isValid($_REQUEST['name'], $name) || !Validation::isValid($_REQUEST['description'], $description) ||
            !Validation::isValid($_REQUEST['checklistID'], $checklistID))
            throw new InvalidArgumentException('Something wrong', 403);

        $task = new Task($name, $description, false, Utils::generatedID());
        Model::insertTask($task, $checklistID);

        if (Validation::isUser($_SESSION['user']))
            UserController::privateChecklist();
        else
            VisitorController::publicPage();
    }

    /**
     * Modify a Checklist
     * and update it in the Data Base
     */
    public static function updateTask() {
        $taskID = "";
        $name = "";
        $description = "";

        if (!Validation::isValid($_REQUEST['taskID'], $taskID) || !Validation::isValid($_REQUEST['name'], $name) ||
            !Validation::isValid($_REQUEST['description'], $description))
            throw new InvalidArgumentException('Something wrong', 403);


        $task = new Task($name, $description, false, Utils::generatedID());
        Model::updateTask($taskID, $task);

        if (Validation::isUser($_SESSION['user']))
            UserController::privateChecklist();
        else
            VisitorController::publicPage();
    }

    /**
     * Delete a
     * Task form the Data Base
     */
    public static function removeTask() {
        $taskID = "";

        if (!Validation::isValid($_REQUEST['taskID'], $taskID))
            throw new InvalidArgumentException('Something Wrong');

        Model::deleteTask($taskID);

        if (Validation::isUser($_SESSION['user']))
            UserController::privateChecklist();
        else
            VisitorController::publicPage();
    }

    /**
     * Change the state
     * of the State
     */
    public static function changeTaskState() {
        $taskID = "";

        if (!Validation::isValid($_REQUEST['taskID'], $taskID))
            throw new InvalidArgumentException('Something Wrong');

        Model::changeTaskState($taskID);

        if (Validation::isUser($_SESSION['user']))
            UserController::privateChecklist();
        else
            VisitorController::publicPage();
    }
}