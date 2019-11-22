<?php

class TaskGateway {

    private $con;

    public function __construct(Connection $con) {
        $this->con = $con;
    }

    public function findTask($userID) {

        $query = 'SELECT * FROM `task` WHERE id  = :id;';

        $this->con->execteQuery($query, array(
            ':id' => array($userID, PDO::PARAM_INT)
        ));

        return $this->con->getResults();
    }

    public function insertTask(Task $task,$id_checklist) {
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