<?php


class VisitorController {

    /**
     * VisitorController constructor.
     */
    public function __construct(){
        global $rep, $public;

        $public = true;
        require_once $rep."/view/vue.php";
    }
}