<?php

class CheckListGateway {

    private $con;

    public function __construct(Connection $con) {
        $this->con=$con;
    }

    public function findChecklistByUser($userID) {
        $query = 'SELECT * FROM todoUser T, checklist C WHERE id_user = :id_user AND T.id_checklist = C.id ;';
        $this->con->executeQuery($query, array(
                            ':id_user' => [$userID, PDO::PARAM_STR]
        ));
        return $this->con->getResults();
    }

}