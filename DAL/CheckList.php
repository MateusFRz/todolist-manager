<?php


class CheckList {

    private $name;
    private $tasks = [];

    /**
     * CheckList constructor.
     * @param $tasks Task[]
     * @param $name string
     */
    public function __construct(string $name, array $tasks) {
        $this->name = $name;
        $this->tasks = $tasks;
    }

    /**
     * Return all tasks of the checklist
     * @return Task[]
     */
    public function getTasks() {
        return $this->tasks;
    }


    /**
     * Add a task to checklist tasks
     * @param Task $task
     */
    public function addTask(Task $task) {
        $this->tasks[] = $task;
    }


}