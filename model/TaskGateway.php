<?php

class TaskGateway {

    private $db;

    public function __construct(Connection $db) {
        $this->db = $db;
    }

    public function findTaskByID($taskID) {

        $query = 'SELECT name, description, done FROM `task` WHERE id  = :id;';

        $this->db->executeQuery($query, array(
            ':id' => [$taskID, PDO::PARAM_INT]
        ));
        
        return $this->db->getResults()[0];
    }

    public function findTaskByChecklistID($checklistID) {
        $query =  'SELECT id, name, description, done FROM task WHERE id_checklist=:id_checklist;';

        $this->db->executeQuery($query, array(
            ':id_checklist' => [$checklistID, PDO::PARAM_INT]
        ));

        return $this->db->getResults();
    }

    public function updateTask($taskID, Task $newTask) {
        $query = 'UPDATE task SET name=:name, description=:desc, done=:done WHERE id=:id;';
        $this->db->executeQuery($query, array(
            ':name' => [$newTask->getName(), PDO::PARAM_STR],
            ':desc' => [$newTask->getDescription(), PDO::PARAM_STR],
            ':done' => [$newTask->isDone(), PDO::PARAM_BOOL],
            ':id' => [$newTask->getID(), PDO::PARAM_INT]
        ));
    }

    public function insertTask(Task $task, $id_checklist) {
        $query = 'INSERT INTO task(name, description, done, id_checklist) VALUES(:name, :description, :done, :id_checklist);';

        $this->db->executeQuery($query, array(
            ':name' => [$task->getName(), PDO::PARAM_STR],
            ':description' => [$task->getDescription(), PDO::PARAM_STR],
            ':done' => [$task->isDone(), PDO::PARAM_BOOL],
            ':id_checklist' => [$id_checklist, PDO::PARAM_INT]
        ));
    }

    public function deleteTask($taskID) {
        $query = 'DELETE FROM `task` WHERE id = :id;';

        $this->db->executeQuery($query, array(
            ':id' => [$taskID, PDO::PARAM_INT]
        ));
    }
}