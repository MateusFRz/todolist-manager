<?php


class VisitorController {

    /**
     * VisitorController constructor.
     */
    public function __construct(){

        $tabCheck = Model::findChecklistByPublic(true);
    }
}