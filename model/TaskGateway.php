<?php

class TaskGateway {

    private $con;

    public function __construct(Connection $con) {
        $this->con = $con;
    }

    public function findTaskByID($taskID) {

        $query = 'SELECT name, description, done FROM `task` WHERE id  = :id;';

        $this->con->executeQuery($query, array(
            ':id' => array($taskID, PDO::PARAM_INT)
        ));
        
        $result = $this->con->getResults()[0];
        return new Task($result['name'], $result['description'], $result['done']);
    }

    public function findTaskByChecklistID($checklistID) {
        $query =  'SELECT name, description, done FROM task WHERE id_checklist=:id_checklist;';
        $tasks=[];

        $this->con->executeQuery($query, array(
            ':id_checklist' => [$checklistID, PDO::PARAM_INT]
        ));

        foreach ($this->con->getResults() as $task)
            $tasks[] = new Task($task['name'], $task['description'], $task['done']);

        return $tasks;
    }

    public function insertTask(Task $task, $id_checklist) {
        $query = 'INSERT INTO task VALUES(:name, :description, :done, :id_checklist);';

        $this->con->executeQuery($query, array(
            ':name' => array($task->getName(), PDO::PARAM_STR),
            ':description' => array($task->getDescription(), PDO::PARAM_STR),
            ':done' => array($task->isDone(), PDO::PARAM_BOOL),
            ':id_checklist' => array($id_checklist, PDO::PARAM_INT)
        ));
    }

    public function deleteTask($id) {
        $query = 'DELETE FROM `task` WHERE id = :id;';

        $this->con->executeQuery($query, array(
            ':id' => array($id, PDO::PARAM_INT)
        ));


    }
}