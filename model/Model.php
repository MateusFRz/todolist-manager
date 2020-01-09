<?php

class Model {



    public static function countByPublic($public) : ?int {
        global $dsn, $user, $password;

        $checkGT = new ChecklistGateway(new Connection($dsn, $user, $password));

        return $checkGT->countByPublic($public)[0]['count(1)'];
    }

    public static function countByUser($userID) : ?int {
        global $dsn, $user, $password;

        $checkGT = new ChecklistGateway(new Connection($dsn, $user, $password));

        return $checkGT->countByUser($userID)[0]['count(1)'];
    }

    public static function findChecklistByUser($userID) : ?Checklist {
        global $dsn, $user, $password;
        $checklists = [];

        $checkGT = new ChecklistGateway(new Connection($dsn, $user, $password));
        $results = $checkGT->findChecklistByUser($userID);

        if (empty($results))
            return null;


        foreach ($results as $checklist) {
            $tasks = Model::findTaskByChecklistID($checklist['id']);
            $checklists[] = new Checklist($checklist['name'], $tasks, $checklist['visible'], $checklist['id']);
        }

        return $checklists;
    }

    public static function findChecklistByPublic($public) : ?Checklist{
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

    public static function updateChecklistByName($checklistID, $checklistName) {
        global $dsn, $user, $password;

        $checkGT = new ChecklistGateway(new Connection($dsn, $user, $password));
        $checkGT->updateChecklistByName($checklistID, $checklistName);
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

        foreach ($checklist->getTasks() as $task)
            Model::insertTask($task, $checklist->getId());
    }


    public static function deleteChecklist($checklistID) {
        global $dsn, $user, $password;

        $db = new Connection($dsn, $user, $password);
        $checkGT = new ChecklistGateway($db);

        $checkGT->deleteChecklist($checklistID);
    }

    public static function findTaskByID($taskID) : ?Task {
        global $dsn, $user, $password;

        $taskGT = new TaskGateway(new Connection($dsn, $user, $password));
        $result = $taskGT->findTaskByID($taskID);

        if (empty($result))
            return null;

        return new Task($result['name'], $result['description'], $result['done'], $taskID);
    }

    public static function findTaskByChecklistID($checklistID) : ?Task {
        global $dsn, $user, $password;
        $tasks = [];

        $taskGT = new TaskGateway(new Connection($dsn, $user, $password));
        $result = $taskGT->findTaskByChecklistID($checklistID);

        if (empty($result))
            return null;

        foreach ($result as $task)
            $tasks[] = new Task($task['name'], $task['description'], $task['done'], $task['id']);

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

    public static function changeTaskState($taskID) {
        global $dsn, $user, $password;

        $taskGT = new TaskGateway(new Connection($dsn, $user, $password));
        $taskGT->changeTaskState($taskID);
    }

    public static function findUserByID($userID) : ?User {
        global $dsn, $user, $password;

        $userGT = new UserGateway(new Connection($dsn, $user, $password));
        $result = $userGT->findUserByID($userID);

        if (empty($result))
            return null;

        return new User($result['name'], $result['surname'], $result['email'], $result['password'], $result['id']);
    }

    public static function findUserByEmail($email) : ?User {
        global $dsn, $user, $password;

        $userGT = new UserGateway(new Connection($dsn, $user, $password));
        $result = $userGT->findUserByEmail($email);

        if (empty($result))
            return null;

        return new User($result[0]['name'], $result[0]['surname'], $result[0]['email'], $result[0]['password'], $result[0]['id']);

    }

    public static function insertUser(User $userObj) {
        global $dsn, $user, $password;

        $userGT = new UserGateway(new Connection($dsn, $user, $password));

        $userGT->insertUser($userObj);
    }

    public static function deleteUser($userID) {
        global $dsn, $user, $password;

        $userGT = new UserGateway(new Connection($dsn, $user, $password));

        $userGT->deleteUser($userID);
    }
}