<?php

class Model {

    public static function findChecklistByUser($userID) {
        global $dsn, $user, $password;
        $checklists = [];

        $checkGT = new ChecklistGateway(new Connection($dsn, $user, $password));
        $results= $checkGT->findChecklistByUser($userID);

        if (empty($result))
            return null;

        foreach ($results as $checklist) {
            $tasks = Model::findTaskByChecklistID($checklist['id']);
            $checklists[] = new Checklist($checklist['name'], $tasks, $checklist['visible'], $checklist['id']);
        }

        return $checklists;
    }

    public static function findChecklistByPublic($public) {
        global $dsn, $user, $password;
        $checklists = [];

        $checkGT = new ChecklistGateway(new Connection($dsn, $user, $password));
        $result = $checkGT->findChecklistByPublic($public);

        if (empty($result))
            return null;

        foreach ($result as $checklist) {
            $tasks = Model::findTaskByChecklistID($checklist['id']);
            $checklists[] = new Checklist($checklist['name'], $tasks, $checklist['visible'], $checklist['id']);
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

        $checkGT->deleteChecklist($checklistID);
    }

    public static function findTaskByID($taskID) {
        global $dsn, $user, $password;

        $taskGT = new TaskGateway(new Connection($dsn, $user, $password));
        $result = $taskGT->findTaskByID($taskID);

        if (empty($result))
            return null;

        return new Task($taskID, $result['name'], $result['description'], $result['done']);
    }

    public static function findTaskByChecklistID($checklistID) {
        global $dsn, $user, $password;
        $tasks = [];

        $taskGT = new TaskGateway(new Connection($dsn, $user, $password));
        $result = $taskGT->findTaskByChecklistID($checklistID);

        if (empty($result))
            return null;

        foreach ($result as $task)
            $tasks[] = new Task($task['id'], $task['name'], $task['description'], $task['done']);

        return $tasks;
    }

    public static function updateTask($taskID, Task $newTask) {
        global $dsn, $user, $password;

        $taskGT = new TaskGateway(new Connection($dsn, $user, $password));

        $taskGT->updateTask($taskID, $newTask);
    }

    public static function insertTask(Task $task, $id_checklist) {
        global $dsn, $user, $password;

        $taskGT = new TaskGateway(new Connection($dsn, $user, $password));

        $taskGT->insertTask($task, $id_checklist);
    }

    public static function deleteTask($taskID) {
        global $dsn, $user, $password;

        $taskGT = new TaskGateway(new Connection($dsn, $user, $password));
        $taskGT->deleteTask($taskID);
    }

    public static function findUserByID($userID) {
        global $dsn, $user, $password;

        $userGT = new UserGateway(new Connection($dsn, $user, $password));
        $result = $userGT->findUserByID($userID);

        if (empty($result))
            return null;

        return new User($result['name'], $result['surname'], $result['email'], $result['password'], $result['id']);
    }

    public static function findUserByEmail($email) {
        global $dsn, $user, $password;

        $userGT = new UserGateway(new Connection($dsn, $user, $password));
        $result = $userGT->findUserByEmail($email);

        if (empty($result))
            return null;

        return new User($result['name'], $result['surname'], $result['email'], $result['password'], $result['id']);
    }

    public static function insertUser(User $user) {
        global $dsn, $user, $password;

        $userGT = new UserGateway(new Connection($dsn, $user, $password));

        $userGT->insertUser($user);
    }

    public static function deleteUser($userID) {
        global $dsn, $user, $password;

        $userGT = new UserGateway(new Connection($dsn, $user, $password));

        $userGT->deleteUser($userID);
    }
}