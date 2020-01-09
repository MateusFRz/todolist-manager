<?php


class User {

    private $id;
    private $name;
    private $surname;
    private $email;
    private $password;

    /**
     * User constructor.
     * @param $id
     * @param $name
     * @param $surname
     * @param $email
     * @param $password
     */
    public function __construct($name, $surname, $email, $password, $id) {
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getId() : string {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName() : string {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getSurname() : string {
        return $this->surname;
    }

    /**
     * @return string
     */
    public function getEmail() : string {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword() : string {
        return $this->password;
    }

}