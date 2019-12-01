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
    public function __construct($id, $name, $description, $done) {
        $this->name = $name;
        $this->description = $description;
        $this->id = $id;
        $this->done = ($done == 0 ? false : true);
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * @return bool
     */
    public function isDone() {
        return $this->done;
    }

    /**
     * @retrun int
     */
    public function getID() {
        return$this->id;
    }

 /*   public function __toString()
    {
       return "Tache: </br>".
           $this->getID() . "</br>".
           $this->getName() . "</br>".
           $this->getDescription() . "</br>".
           $this->isDone() . "</br>";
    }
*/

}