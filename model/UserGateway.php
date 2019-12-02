<?php

class UserGateway {

    private $db;

    public function __construct(Connection $db) {
        $this->db=$db;
    }

    public function findUserByID($userID) {
        $query = 'SELECT id,name,surname,email,password FROM user where id=:id;';

        $this->db->executeQuery($query, array(
            ':id' => [$userID, PDO::PARAM_STR]
        ));
        return $this->db->getResults();
    }

    public function findUserByEmail($email) {
        $query = 'SELECT id,name,surname,email,password FROM user where email=:email;';

        $this->db->executeQuery($query, array(
            ':email' => [$email, PDO::PARAM_STR]
        ));
        return $this->db->getResults();
    }

    public function insertUser(User $user) {
        $query = "INSERT INTO user(name, surname, email, password) VALUES (:name, :surname, :email, :hash)";

        $this->db->executeQuery($query, array(
            ':name' => [$user->getName(), PDO::PARAM_STR],
            ':surname' => [$user->getSurname(), PDO::PARAM_BOOL],
            ':email' => [$user->getEmail(), PDO::PARAM_STR],
            ':hash' => [$user->getPassword(), PDO::PARAM_STR]
        ));
    }

    public function deleteUser($userID) {
        $checklists = Model::findChecklistByUser($userID);

        foreach ($checklists as $checklist)
            Model::deleteChecklist($checklist->getID());

        $query = 'DELETE FROM user WHERE id = :id;';
        $this->db->executeQuery($query, array(
            ':id' => [$userID, PDO::PARAM_INT]
        ));
    }

}