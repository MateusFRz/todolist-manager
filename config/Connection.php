<?php

class Connection extends PDO {

    private $stmt;

    /**
     * Connection constructor.
     * @param $dsn
     * @param $username
     * @param $password
     */
    public function __construct($dsn, $username, $password) {
        parent::__construct($dsn, $username, $password);
        $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * @param string $query
     * @param array $parameters
     * @return bool Returns `true` on success, `false` otherwise
     */
    public function executeQuery(string $query, array $parameters = []): bool {
        $this->stmt = parent::prepare($query);

        foreach ($parameters as $name => $value) {
            $this->stmt->bindValue($name, $value[0], $value[1]);
        }

        return $this->stmt->execute();
    }

    /**
     * @return mixed
     */
    public function getResults() {
        return $this->stmt->fetchall();
    }

}