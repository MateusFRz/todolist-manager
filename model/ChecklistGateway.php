<?php

class ChecklistGateway {

    private $db;

    public function __construct(Connection $db) {
        $this->db=$db;
    }

    public function findChecklistByUser($userID) {
        $query = 'SELECT id,name,visible FROM checklist where id_user=:id_user;';

        $this->db->executeQuery($query, array(
                            ':id_user' => [$userID, PDO::PARAM_STR]
        ));
        return $this->db->getResults();
    }

    public function findChecklistByPublic($public) {
        $query = 'SELECT id,name,visible FROM checklist where visible=:visible;';

        $this->db->executeQuery($query, array(
            ':visible' => [$public, PDO::PARAM_BOOL]
        ));

        return $this->db->getResults();
    }

    public function updateChecklist($checklistID, Checklist $newChecklist) {
        $query = 'UPDATE checklist SET name=:name, visible=:visible WHERE id=:id;';
        $this->db->executeQuery($query, array(
            ':name' => [$newChecklist->getName(), PDO::PARAM_STR],
            ':visible' => [$newChecklist->getVisibility(), PDO::PARAM_BOOL],
            ':id' => [$checklistID, PDO::PARAM_INT]
        ));
    }

    public function insertChecklist(Checklist $checklist, $userID) {
        $query = "INSERT INTO checklist VALUES (:name, :visible, :userID)";

        $this->db->executeQuery($query, array(
           ':name' => [$checklist->getName(), PDO::PARAM_STR],
           ':visible' => [$checklist->getVisibility(), PDO::PARAM_BOOL],
           ':userID' => [$userID, PDO::PARAM_INT]
        ));
    }

    public function deleteChecklist($checklistID, TaskGateway $taskGT) {
        $tasks = $this->taskGT->findTaskByChecklistID($checklistID);
        foreach ($tasks as $task)
            $this->taskGT->deleteTask($task->getID());

        $query = 'DELETE FROM checklist WHERE id = :id;';
        $this->db->executeQuery($query, array(
            ':id' => [$checklistID, PDO::PARAM_INT]
        ));
    }
}