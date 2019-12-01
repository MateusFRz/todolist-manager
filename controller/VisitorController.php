<?php


class VisitorController {

    /**
     * VisitorController constructor.
     */
    public function __construct(){
        global $rep;

        $model = new Model();

        $checkLists = $model->findChecklistByPublic(true);
        require_once $rep."/view/vue.php";
    }
}