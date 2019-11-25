<?php

class ChecklistGateway {

    private $db;
    private $taskGT;

    public function __construct(Connection $db) {
        $this->db=$db;
        $this->taskGT = new TaskGateway($this->db);
    }

    public function findChecklistByUser($userID) {
        $query = 'SELECT id,name,visible FROM checklist where id_user=:id_user;';
        $checklists = [];

        $this->db->executeQuery($query, array(
                            ':id_user' => [$userID, PDO::PARAM_STR]
        ));
        foreach ($this->db->getResults() as $checklist) {
            $tasks = $this->taskGT->findTaskByChecklistID($checklist['id']);
            $checklists[] = new Checklist($checklist['name'], $tasks, $checklist['visible']);
        }
        return $checklists;
    }

    public function updateChecklist($checklistID, Checklist $newChecklist) {
        $query = 'UPDATE checklist SET name=:name, visible=:visibile WHERE id=:id;';
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

    public function deleteChecklist($checklistID) {
        $tasks = $this->taskGT->findTaskByChecklistID($checklistID);
        foreach ($tasks as $task)
            $this->taskGT->deleteTask($task->getID());

        $query = 'DELETE FROM checklist WHERE id = :id;';
        $this->db->executeQuery($query, array(
            ':id' => [$checklistID, PDO::PARAM_INT]
        ));
    }
}