<?php


class Checklist {

    private $name;
    private $tasks;
    private $public;
    private $id;

    /**
     * Checklist constructor.
     * @param $name
     * @param $tasks
     * @param $public
     * @param $id
     */
    public function __construct($name, $tasks, $public, $id)
    {
        $this->name = $name;
        $this->tasks = $tasks;
        $this->public = ($public == 0 ? false : true);
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }


    /**
     * Return all tasks of the checklist
     * @return Task[]
     */
    public function getTasks() {
        return $this->tasks;
    }

    /**
     * Return checklist name
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Return if checklist is public or not
     * @return bool true -> yes | false -> no
     */
    public function isPublic() {
        return $this->public;
    }

    /**
     * Add a task to checklist tasks
     * @param Task $task
     */
    public function addTask(Task $task) {
        $this->tasks[] = $task;
    }


}