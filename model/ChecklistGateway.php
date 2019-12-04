<?php

class ChecklistGateway {

    private $db;

    public function __construct(Connection $db) {
        $this->db=$db;
    }

    public function findChecklistByUser($userID) {
        $query = 'SELECT id,name,visible FROM checklist where id_user=:id_user';

        $this->db->executeQuery($query, array(
                            ':id_user' => [$userID, PDO::PARAM_STR]
        ));

        return $this->db->getResults();
    }

    public function findChecklistByPublic($public) {
        $query = 'SELECT id,name,visible FROM checklist where visible=:visible';

        $this->db->executeQuery($query, array(
            ':visible' => [$public, PDO::PARAM_BOOL]
        ));

        return $this->db->getResults();
    }

    public function updateChecklistByName($checklistID, $checklistName) {
        $query = 'UPDATE checklist SET name=:name WHERE id=:id';

        $this->db->executeQuery($query, array(
            ':name' => [$checklistName, PDO::PARAM_STR],
            ':id' => [$checklistID, PDO::PARAM_STR]
        ))
    }

    public function updateChecklist($checklistID, Checklist $newChecklist) {
        $query = 'UPDATE checklist SET name=:name, visible=:visible WHERE id=:id';

        $this->db->executeQuery($query, array(
            ':name' => [$newChecklist->getName(), PDO::PARAM_STR],
            ':visible' => [$newChecklist->isPublic(), PDO::PARAM_BOOL],
            ':id' => [$checklistID, PDO::PARAM_STR]
        ));
    }

    public function insertChecklist(Checklist $checklist, $userID) {
        $query = 'INSERT INTO checklist(id, name, visible, id_user) VALUES (:id, :name, :visible, :userID)';
        
        $this->db->executeQuery($query, array(
           ':id' => [$checklist->getId(), PDO::PARAM_STR],
           ':name' => [$checklist->getName(), PDO::PARAM_STR],
           ':visible' => [$checklist->isPublic(), PDO::PARAM_BOOL],
           ':userID' => [$userID, PDO::PARAM_STR]
        ));
    }

    public function deleteChecklist($checklistID) {
        $tasks = Model::findTaskByChecklistID($checklistID);

        if(!empty($tasks))
            foreach ($tasks as $task)
                Model::deleteTask($task->getID());

        $query = 'DELETE FROM checklist WHERE id = :id';
        $this->db->executeQuery($query, array(
            ':id' => [$checklistID, PDO::PARAM_STR]
        ));
    }
}