<?php


class VisitorController {

    /**
     * VisitorController constructor.
     */
    public function __construct(){
        global $rep, $errors, $successes;

        $checklists = Model::findChecklistByPublic(true);
        require_once $rep."/view/vue.php";
    }
}