<?php


class VisitorController {

    public static function publicPage() {
        global $rep;

        $checklists = Model::findChecklistByPublic(true);
        require_once $rep . "/view/vue.php";
    }
}