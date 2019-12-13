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

        $name = Validation::purify($_REQUEST['name']);
        $description = Validation::purify($_REQUEST['description']);
        $checklistID = Validation::purify($_REQUEST['checklistID']);

        if (empty($name)) {
            $errors['taskNameError'] = 'Invalid name !';
            return;
        }
        if (empty($_REQUEST['description'])) {
            $errors['taskDescriptionError'] = 'Invalid description !';
            return;
        }
        if (empty($_REQUEST['checklistID'])) {
            $errors['checklistIDError'] = 'Invalid checklist !';
            return;
        }

        $task = new Task($name, $description, false, uniqid("", true));
        Model::insertTask($task, $checklistID);
    }

    private function updateTask() {
        global $errors;

        if(!isset($_REQUEST['taskID']) || !Validation::isAlphaNum($_REQUEST['taskID'])) {
            $errors['taskIDNV'] = 'Task ID is not valid';
            return;
        }

        $name = Validation::purify($_REQUEST['name']);
        $description = Validation::purify($_REQUEST['description']);

        if (empty($name)) {
            $errors['taskNameError'] = 'Invalid name !';
            return;
        }
        if (empty($_REQUEST['description'])) {
            $errors['taskDescriptionError'] = 'Invalid description !';
            return;
        }

        $task = new Task($name, $description, false, uniqid("", true));
        Model::updateTask($taskID, $task);
    }

    private function removeTask() {
        global $errors;

        if(!isset($_REQUEST['taskID']) || !Validation::isAlphaNum($_REQUEST['taskID'])) {
            $errors['taskIDNV'] = 'Task ID is not valid';
            return;
        }

        Model::deleteTask($_REQUEST['taskID']);
    }

    private function changeTaskState() {
        global $errors;

        if(!isset($_REQUEST['taskID']) || !Validation::isAlphaNum($_REQUEST['taskID'])) {
            $errors['taskIDNV'] = 'Task ID is not valid';
            return;
        }

        Model::changeTaskState($_REQUEST['taskID']);
    }
}