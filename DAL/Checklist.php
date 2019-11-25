<?php


class Checklist {

    private $name;
    private $tasks;
    private $visibility;

    /**
     * CheckList constructor.
     * @param $name string
     * @param $tasks Task[]
     * @param $visibility bool
     */
    public function __construct(string $name, array $tasks, $visibility) {
        $this->name = $name;
        $this->tasks = $tasks;
        $this->visibility = $visibility;
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
    public function getVisibility() {
        return $this->visibility;
    }

    /**
     * Add a task to checklist tasks
     * @param Task $task
     */
    public function addTask(Task $task) {
        $this->tasks[] = $task;
    }


}