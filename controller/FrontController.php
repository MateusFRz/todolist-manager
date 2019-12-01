<?php

class FrontController {

    /**
     * FrontController constructor.
     */
    public function __construct() {
        global $rep,$vues;
        $action = NULL;

        if (isset($_REQUEST['action']))
            $action = $_REQUEST['action'];

        try {

            switch ($action) {
                case NULL:
                    new VisitorController();
                    break;
                default:
                    //error action non reconnue
                    break;
            }
        } catch (PDOException $PDOException) {
            //vue erreur
        } catch (Exception $exception) {
            //vue erreur
        }
    }
}