<?php
/**
 * Created by PhpStorm.
 * User: andilella
 * Date: 29/11/19
 * Time: 16:48
 */

class Model {


    public static function findChecklistByUser($userID) {
        global $dsn, $user, $password;
        $checklists = [];

        $checkGT = new ChecklistGateway(new Connection($dsn, $user, $password));
        $results= $checkGT->findChecklistByUser($userID);

        foreach ($results as $checklist) {
            $tasks = $this->findTaskByChecklistID($checklist['id']);
            $checklists[] = new Checklist($checklist['id'], $checklist['name'], $tasks, $checklist['visible']);
        }

        return $checklists;
    }

    public static function findChecklistByPublic($public) {
        global $dsn, $user, $password;
        $checklists = [];

        $checkGT = new ChecklistGateway(new Connection($dsn, $user, $password));
        $result = $checkGT->findChecklistByPublic($public);

        foreach ($result as $checklist) {
            $tasks = $this->taskGT->findTaskByChecklistID($checklist['id']);
            $checklists[] = new Checklist($checklist['id'], $checklist['name'], $tasks, $checklist['visible']);
        }

        return $checklists;
    }

    public static function updateChecklist($checklistID, Checklist $newChecklist) {
        global $dsn, $user, $password;

        $checkGT = new ChecklistGateway(new Connection($dsn, $user, $password));
        $checkGT->updateChecklist($checklistID, $newChecklist);
    }

    public static function insertChecklist(Checklist $checklist, $userID) {
        global $dsn, $user, $password;

        $checkGT = new ChecklistGateway(new Connection($dsn, $user, $password));
        $checkGT->insertChecklist($checklist, $userID);
    }

    public static function deleteChecklist($checklistID) {
        global $dsn, $user, $password;

        $db = new Connection($dsn, $user, $password);
        $checkGT = new ChecklistGateway($db);
        $taskGT = new TaskGateway($db);

        $checkGT->deleteChecklist($checklistID, $taskGT);
    }

    public static function findTaskByID($taskID) {
        global $dsn, $user, $password;

        $taskGT = new TaskGateway(new Connection($dsn, $user, $password));
        $result = $taskGT->findTaskByID($taskID);

        return new Task($taskID, $result['name'], $result['description'], $result['done']);
    }

    public  static function findTaskByChecklistID($checklistID) {
        global $dsn, $user, $password;
        $tasks = [];

        $taskGT = new TaskGateway(new Connection($dsn, $user, $password));
        $result = $taskGT->findTaskByChecklistID($checklistID);

        foreach ($result as $task)
            $tasks[] = new Task($task['id'], $task['name'], $task['description'], $task['done']);

        return $tasks;
    }


}