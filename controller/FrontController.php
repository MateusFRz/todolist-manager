<?php

class FrontController {

    /**
     * FrontController constructor.
     */
    public function __construct() {
        global $errors, $rep;
        $action = NULL;

        session_start();

        if (isset($_REQUEST['action']))
            $action = $_REQUEST['action'];

        try {
            switch ($action) {
                case "publicPage":
                case NULL:
                    new VisitorController();
                    break;
                case "profile":
                case "private":
                case "logout":
                case "login":
                case "removeTask":
                case "addChecklist":
                case "changeTaskState":
                case "removeChecklist":
                case "modifyChecklist":
                case "addTask":
                case "updateTask":
                case "signup":
                case "signupPage" :
                case "loginPage":
                    new FrontUserController($action);
                    break;
                default:
                    throw new Exception('Action no found !', 404);
            }
        } catch (Exception $exception) {
            $errors['exception'] = $exception->getMessage();
        }

        if (!empty($errors))
            require_once $rep . "/view/vue.php";
    }
}