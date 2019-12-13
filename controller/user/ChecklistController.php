<?php


class ChecklistController {


    /**
     * ChecklistController constructor.
     * @param $action
     * @throws Exception
     */
    public function __construct($action) {
        global $rep;

        switch ($action) {
            case "removeChecklist":
                $this->removeChecklist();
                break;
            case "modifyChecklist":
                $this->modifyChecklist();
                break;
            case "addChecklist":
                $this->addChecklist();
                break;
            default:
                throw new Exception("Bad request", 400);
        }

        require_once $rep."/view/vue.php";
    }

    private function addChecklist() {
        global $errors, $successes, $public;

        if (!isset($_REQUEST['name'])) {
            $errors['checklistNameND'] = 'Checklist name not define';
            return;
        }

        if (!isset($_REQUEST['tasks'])) {
            $errors['checklistNameND'] = "Task are not define";
            return;
        }

        $name = Validation::purify($_REQUEST['name']);
        $tasksNoParse = Validation::purify($_REQUEST['tasks']);

        if ($tasksNoParse != $_REQUEST['tasks']) {
            $errors['taskXSSError'] = 'Task not correctly define !';
            return;
        }

        if (strpos($_REQUEST['tasks'], ';') === false || strpos($_REQUEST['tasks'], '§') === false) {
            $errors['taskError'] = 'Task not correctly define !';
            return;
        }

        $tasks = [];

        $public = 1;
        if (isset($_REQUEST['public'])) $public = 0;

        $tasksNoParse = rtrim($tasksNoParse, ';');
        $tasksNoParse = explode(';', $tasksNoParse);

        foreach ($tasksNoParse as $taskNP) {
            $task = explode('§', $taskNP);

            $tasks[] = new Task($task[0], $task[1], 0, uniqid("", true));

            $task = [];
        }

        $userID = 0;
        if (isset($_SESSION['login'])) $userID = $_SESSION['user']->getID();

        Model::insertChecklist(new Checklist($name, $tasks, $public, uniqid("", true)), $userID);

        $successes['checklistAdd'] = 'Checklist added success-fully !';
    }

    private function removeChecklist() {
        global $errors;

        if(!isset($_REQUEST['checklistID']) || !Validation::isAlphaNum($_REQUEST['checklistID'])) {
            $errors['checklistIDNV'] = 'Checklist ID is not valid';
            return;
        }

        Model::deleteChecklist($_REQUEST['checklistID']);
    }

    private function modifyChecklist() {
        global $errors;

        if((!isset($_REQUEST['name'])) || !Validation::isAlpha($_REQUEST['name'])){
            $errors['taskError']='Task Name is not valid';
        }

        if((!isset($_REQUEST['checklistID'])) || !Validation::isAlphaNum($_REQUEST['checklistID'])){
            $errors['checkError']='Checklist ID is not valid';
        }

        Model::updateChecklistByName($_REQUEST['checklistID'], $_REQUEST['name']);
    }
}