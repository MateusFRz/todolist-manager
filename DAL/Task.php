<?php

class Task {

    private $name;
    private $description;
    private $done;
    private $id;

    /**
     * Task constructor.
     * @param $id
     * @param $name
     * @param $description
     * @param $done
     */
    public function __construct(String $name, String $description, int $done, String $id) {
        $this->name = $name;
        $this->description = $description;
        $this->id = $id;
        $this->done = ($done == 0 ? false : true);
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
    public function getDescription() : string {
        return $this->description;
    }

    /**
     * @return bool
     */
    public function isDone() : bool {
        return $this->done;
    }

    /**
     * @retrun string
     */
    public function getID() : string {
        return $this->id;
    }

}