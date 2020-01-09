<?php


class VisitorController {

    /**
     * Call the main view
     */
    public static function publicPage() {
        global $rep;

        $checklists = Model::findChecklistByPublic(true);
        require_once $rep . "/view/vue.php";
    }
}