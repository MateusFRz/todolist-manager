<?php

class Model {

    public function findChecklistByUser($userID) {
        global $dsn, $user, $password;
        $checklists = [];

        $checkGT = new ChecklistGateway(new Connection($dsn, $user, $password));

        $results= $checkGT->findChecklistByUser($userID);

        foreach ($results as $checklist) {
            $tasks = $this->findTaskByChecklistID($checklist['id']);
            $checklists[] = new Checklist($checklist['name'], $tasks, $checklist['visible'], $checklist['id']);
        }

        return $checklists;
    }

    public function findChecklistByPublic($public) {
        global $dsn, $user, $password;
        $checklists = [];

        $checkGT = new ChecklistGateway(new Connection($dsn, $user, $password));

        $result = $checkGT->findChecklistByPublic($public);

        foreach ($result as $checklist) {
            $tasks = $this->findTaskByChecklistID($checklist['id']);
            $checklists[] = new Checklist($checklist['name'], $tasks, $checklist['visible'], $checklist['id']);
        }

        return $checklists;
    }

    public function updateChecklist($checklistID, Checklist $newChecklist) {
        global $dsn, $user, $password;

        $checkGT = new ChecklistGateway(new Connection($dsn, $user, $password));
        $checkGT->updateChecklist($checklistID, $newChecklist);
    }

    public function insertChecklist(Checklist $checklist, $userID) {
        global $dsn, $user, $password;

        $checkGT = new ChecklistGateway(new Connection($dsn, $user, $password));
        $checkGT->insertChecklist($checklist, $userID);
    }

    public function deleteChecklist($checklistID) {
        global $dsn, $user, $password;

        $db = new Connection($dsn, $user, $password);
        $checkGT = new ChecklistGateway($db);
        $taskGT = new TaskGateway($db);

        $checkGT->deleteChecklist($checklistID, $taskGT);
    }

    public function findTaskByID($taskID) {
        global $dsn, $user, $password;

        $taskGT = new TaskGateway(new Connection($dsn, $user, $password));
        $result = $taskGT->findTaskByID($taskID);

        return new Task($taskID, $result['name'], $result['description'], $result['done']);
    }

    public  function findTaskByChecklistID($checklistID) {
        global $dsn, $user, $password;
        $tasks = [];

        $taskGT = new TaskGateway(new Connection($dsn, $user, $password));
        $result = $taskGT->findTaskByChecklistID($checklistID);

        foreach ($result as $task)
            $tasks[] = new Task($task['id'], $task['name'], $task['description'], $task['done']);

        return $tasks;
    }

    public function updateTask($taskID, Task $newTask) {
        global $dsn, $user, $password;

        $taskGT = new TaskGateway(new Connection($dsn, $user, $password));

        $taskGT->updateTask($taskID, $newTask);
    }

    public function insertTask(Task $task, $id_checklist) {
        global $dsn, $user, $password;

        $taskGT = new TaskGateway(new Connection($dsn, $user, $password));

        $taskGT->insertTask($task, $id_checklist);
    }

    public function deleteTask($taskID) {
        global $dsn, $user, $password;

        $taskGT = new TaskGateway(new Connection($dsn, $user, $password));
        $taskGT->deleteTask($taskID);
    }

}