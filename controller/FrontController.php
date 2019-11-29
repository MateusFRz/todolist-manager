<?php

class FrontController {

    /**
     * FrontController constructor.
     */
    public function __construct() {
        $action = Validation::purify($_GET['action']);

        switch ($action) {
            case NULL:
                
                break;
            default:
                //error;
                break;
        }
    }
}