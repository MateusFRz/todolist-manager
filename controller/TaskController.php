<?php


class TaskController {


    /**
     * TaskController constructor.
     * @param $action
     * @throws Exception
     */
    public function __construct($action) {
        global $rep;

        switch ($action) {
            case "removeTask":
                $this->removeTask();
                break;
            case "updateTask":
                $this->updateTask();
                break;
            case "changeTaskState":
                $this->changeTaskState();
                break;
            case "addTask":
                $this->addTask();
                break;
            default:
                throw new Exception("Bad request", 400);
        }

        require_once $rep . "/view/vue.php";
    }

    private function addTask() {
        global $errors;

        $name = "";
        $description = "";
        $checklistID = "";

        if (!Validation::isValid($_REQUEST['name'], $name) || !Validation::isValid($_REQUEST['description'], $description) ||
            !Validation::isValid($_REQUEST['checklistID'], $checklistID)) {

            throw new Exception('Something wrong', 403);
        }

        $task = new Task($name, $description, false, uniqid("", true));
        Model::insertTask($task, $checklistID);
    }

    private function updateTask() {
        global $errors;

        $taskID = "";
        $name = "";
        $description = "";

        if (!Validation::isValid($_REQUEST['taskID'], $taskID) || !Validation::isValid($_REQUEST['name'], $name) ||
            !Validation::isValid($_REQUEST['description'], $description)) {

            throw new Exception('Something wrong', 403);
        }

        $task = new Task($name, $description, false, uniqid("", true));
        Model::updateTask($taskID, $task);
    }

    private function removeTask() {
        global $errors;

        $taskID = "";

        if (!Validation::isValid($_REQUEST['taskID'], $taskID)) {
            throw new Exception('Something Wrong');
        }

        Model::deleteTask($taskID);
    }

    private function changeTaskState() {
        global $errors;

        $taskID = "";

        if (!Validation::isValid($_REQUEST['taskID'], $taskID)) {
            throw new Exception('Something Wrong');
        }

        Model::changeTaskState($taskID);
    }
}