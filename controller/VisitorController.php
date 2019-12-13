<?php


class VisitorController {

    public static function publicPage() {
        global $rep, $public;

        $public = true;
        require_once $rep."/view/vue.php";
    }
}