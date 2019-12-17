<?php


class ChecklistController {

    public static function addChecklist() {
        global $successes;

        $taskName = "";
        $taskDescription = "";
        $checklistName = "";

        if (!Validation::isValid($_REQUEST['taskName'], $taskName) || !Validation::isValid($_REQUEST['taskDesc'], $taskDescription) ||
            !Validation::isValid($_REQUEST['checklistName'], $checklistName))
            throw new InvalidArgumentException('Something wrong while register new checklist', 400);


        if (!Validation::isValid($_REQUEST['private'], $private)) $private = 1;
        else  $private = 0;

        $userID = (Validation::isUser($_SESSION['user']) ? $_SESSION['user']->getID() : 0);

        $task[] = new Task($taskName, $taskDescription, 0, Utils::generatedID());

        Model::insertChecklist(new Checklist($checklistName, $task, $private, Utils::generatedID()), $userID);

        $successes['checklistAdd'] = 'Checklist added success-fully !';

        if($userID != 0)
            UserController::privateChecklist();
        else
            VisitorController::publicPage();
    }

    public static function removeChecklist() {
        global $successes;

        $checklistID = "";

        if (!Validation::isValid($_REQUEST['checklistID'], $checklistID))
            throw new InvalidArgumentException('Checklist ID isn\'t valid', 400);

        Model::deleteChecklist($checklistID);
        $successes['checklistAdd'] = 'Checklist added success-fully !';

        if (Validation::isUser($_SESSION['user']))
            UserController::privateChecklist();
        else
            VisitorController::publicPage();
    }

    public static function modifyChecklist() {
        $checklistID = "";
        $checklistName = "";

        if (!Validation::isValid($_REQUEST['checklistName'], $checklistID) || !Validation::isValid($_REQUEST['checklistID'], $checklistName))
            throw new InvalidArgumentException('Name or ID isn\'t valid', 400);

        Model::updateChecklistByName($checklistID, $checklistName);
        if (Validation::isUser($_SESSION['user']))
            UserController::privateChecklist();
        else
            VisitorController::publicPage();
    }
}