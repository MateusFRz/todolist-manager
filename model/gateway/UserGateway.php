<?php

class UserGateway {

    private $db;

    public function __construct(Connection $db) {
        $this->db = $db;
    }

    public function findUserByID($userID) : ?array {
        try {
            $query = 'SELECT id,name,surname,email,password FROM user where id=:id;';

            $this->db->executeQuery($query, array(
                ':id' => [$userID, PDO::PARAM_STR]
            ));

            return $this->db->getResults();
        } catch (PDOException $exception) {
            throw new RuntimeException($exception->getMessage());
        }
    }

    public function findUserByEmail(String $email) : ?array{
        try {
            $query = 'SELECT id,name,surname,email,password FROM user where email=:email;';

            $this->db->executeQuery($query, array(
                ':email' => [$email, PDO::PARAM_STR]
            ));

            return $this->db->getResults();
        } catch (PDOException $exception) {
            throw new RuntimeException($exception->getMessage());
        }
    }

    public function insertUser(User $user) {
        try {
            $query = "INSERT INTO user(id, name, surname, email, password) VALUES (:id, :name, :surname, :email, :hash)";

            $this->db->executeQuery($query, array(
                ':id' => [$user->getID(), PDO::PARAM_STR],
                ':name' => [$user->getName(), PDO::PARAM_STR],
                ':surname' => [$user->getSurname(), PDO::PARAM_STR],
                ':email' => [$user->getEmail(), PDO::PARAM_STR],
                ':hash' => [$user->getPassword(), PDO::PARAM_STR]
            ));
        } catch (PDOException $exception) {
            throw new RuntimeException($exception->getMessage());
        }
    }

    public function deleteUser(String $userID) {
        try {
            $checklists = Model::findChecklistByUser($userID);

            foreach ($checklists as $checklist)
                Model::deleteChecklist($checklist->getID());

            $query = 'DELETE FROM user WHERE id = :id;';
            $this->db->executeQuery($query, array(
                ':id' => [$userID, PDO::PARAM_STR]
            ));
        } catch (PDOException $exception) {
            throw new RuntimeException($exception->getMessage());
        }
    }

}