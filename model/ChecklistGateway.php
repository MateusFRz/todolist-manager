<?php

require_once "TaskGateway.php";

class ChecklistGateway {

    private $con;
    private $taskGT;

    public function __construct(Connection $con) {
        $this->con=$con;
        $this->taskGT = new TaskGateway($this->con);
    }

    public function findChecklistByUser($userID) {
        $query = 'SELECT id,name,visible FROM checklist where id_user=:id_user';
        $checklists = [];

        $this->con->executeQuery($query, array(
                            ':id_user' => [$userID, PDO::PARAM_STR]
        ));
        foreach ($this->con->getResults() as $checklist) {
            $tasks = $this->taskGT->findTaskByChecklistID($checklist['id']);
            $checklists[] = new CheckList($checklist['name'], $tasks);
        }
        return $checklists;
    }

}