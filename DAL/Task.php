<?php

class Task {

    private string $name, $description;
    private bool $done;

    /**
     * Task constructor.
     * @param $name
     * @param $description
     * @param $done
     */
    public function __construct($name, $description, $done) {
        $this->name = $name;
        $this->description = $description;
        $this->done = $done;
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

}