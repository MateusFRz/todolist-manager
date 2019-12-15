<?php


class ChecklistController {

    public static function addChecklist() {
        global $successes, $public;

        $taskName = "";
        $taskDescription = "";
        $checklistName = "";

        if (!Validation::isValid($_REQUEST['taskName'], $taskName) || !Validation::isValid($_REQUEST['taskDesc'], $taskDescription) ||
            !Validation::isValid($_REQUEST['checklistName'], $checklistName))
            throw new InvalidArgumentException('Something wrong while register new checklist', 400);

        $public = 0;
        if (!Validation::isValid($_REQUEST['private'], $public)) $public = 1;
        $userID = $_SESSION['user']->getID();

        $task[] = new Task($taskName, $taskDescription, 0, Utils::generatedID());

        Model::insertChecklist(new Checklist($checklistName, $task, $public, Utils::generatedID()), $userID);

        $successes['checklistAdd'] = 'Checklist added success-fully !';
    }

    public static function removeChecklist() {
        $checklistID = "";

        if (!Validation::isValid($_REQUEST['checklistID'], $checklistID))
            throw new InvalidArgumentException('Checklist ID isn\'t valid', 400);

        Model::deleteChecklist($checklistID);
    }

    public static function modifyChecklist() {
        $checklistID = "";
        $checklistName = "";

        if (!Validation::isValid($_REQUEST['checklistName'], $checklistID) || !Validation::isValid($_REQUEST['checklistID'], $checklistName))
            throw new InvalidArgumentException('Name or ID isn\'t valid', 400);

        Model::updateChecklistByName($checklistID, $checklistName);
    }
}