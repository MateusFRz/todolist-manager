<?php

class ChecklistGateway {

    private $db;

    public function __construct(Connection $db) {
        $this->db = $db;
    }

    public function countByUser(String $userID) : ?array {
        try {
            $query = 'SELECT count(1) FROM checklist WHERE id_user=:id_user';

            $this->db->executeQuery($query, array(
                ':id_user' => [$userID, PDO::PARAM_STR]
            ));

            return $this->db->getResults();
        } catch (PDOException $exception) {
            throw new RuntimeException($exception->getMessage());
        }
    }

    public function countByPublic(bool $public) : ?array {
        try {
            $query = 'SELECT count(1) FROM checklist WHERE visible=:visible';

            $this->db->executeQuery($query, array(
                ':visible' => [$public, PDO::PARAM_BOOL]
            ));

            return $this->db->getResults();
        } catch (PDOException $exception) {
            throw new RuntimeException($exception->getMessage());
        }
    }

    public function findChecklistByUser(String $userID, int $page) : ?array {
        try {
            $offset = 10 * $page;
            $query = 'SELECT id,name,visible FROM checklist where id_user=:id_user order by name limit :offset, 10';

            $this->db->executeQuery($query, array(
                ':id_user' => [$userID, PDO::PARAM_STR],
                ':offset' => [$offset, PDO::PARAM_INT]
            ));

            return $this->db->getResults();
        } catch (PDOException $exception) {
            throw new RuntimeException($exception->getMessage());
        }
    }

    public function findChecklistByPublic(bool $public, int $page) : ?array {
        try {
            $offset = 10 * $page;
            $query = 'SELECT id,name,visible FROM checklist where visible=:visible order by name limit :offset, 10';

            $this->db->executeQuery($query, array(
                ':visible' => [$public, PDO::PARAM_BOOL],
                ':offset' => [$offset, PDO::PARAM_INT]
            ));

            return $this->db->getResults();
        } catch (PDOException $exception) {
            throw new RuntimeException($exception->getMessage());
        }
    }

    public function updateChecklistByName(String $checklistID, String $checklistName) {
        try {
            $query = 'UPDATE checklist SET name=:name WHERE id=:id';

            $this->db->executeQuery($query, array(
                ':name' => [$checklistName, PDO::PARAM_STR],
                ':id' => [$checklistID, PDO::PARAM_STR]
            ));
        } catch (PDOException $exception) {
            throw new RuntimeException($exception->getMessage());
        }
    }

    public function updateChecklist(String $checklistID, Checklist $newChecklist) {
        try {
            $query = 'UPDATE checklist SET name=:name, visible=:visible WHERE id=:id';

            $this->db->executeQuery($query, array(
                ':name' => [$newChecklist->getName(), PDO::PARAM_STR],
                ':visible' => [$newChecklist->isPublic(), PDO::PARAM_BOOL],
                ':id' => [$checklistID, PDO::PARAM_STR]
            ));
        } catch (PDOException $exception) {
            throw new RuntimeException($exception->getMessage());
        }
    }

    public function insertChecklist(Checklist $checklist, String $userID) {
        try {
            $query = 'INSERT INTO checklist(id, name, visible, id_user) VALUES (:id, :name, :visible, :userID)';

            $this->db->executeQuery($query, array(
                ':id' => [$checklist->getId(), PDO::PARAM_STR],
                ':name' => [$checklist->getName(), PDO::PARAM_STR],
                ':visible' => [$checklist->isPublic(), PDO::PARAM_BOOL],
                ':userID' => [$userID, PDO::PARAM_STR]
            ));
        } catch (PDOException $exception) {
            throw new RuntimeException($exception->getMessage());
        }
    }

    public function deleteChecklist(String $checklistID) {
        try {
            $tasks = Model::findTaskByChecklistID($checklistID);

            if (!empty($tasks))
                foreach ($tasks as $task)
                    Model::deleteTask($task->getID());

            $query = 'DELETE FROM checklist WHERE id = :id';
            $this->db->executeQuery($query, array(
                ':id' => [$checklistID, PDO::PARAM_STR]
            ));
        } catch (PDOException $exception) {
            throw new RuntimeException($exception->getMessage());
        }
    }
}