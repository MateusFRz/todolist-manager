<?php

class FrontController {

    /**
     * FrontController constructor.
     */
    public function __construct() {
        global $rep,$errors, $successes;
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
                case "signup":
                case "signupPage" :
                case "loginPage":
                    new UserController($action);
                    break;
                default:
                    $errors['action'] = "Action no found !";
                    break;
            }
        } catch (PDOException $PDOException) {
            $errors['pdo'] = $PDOException->getMessage();
        } catch (Exception $exception) {
            $errors['exception'] = $exception->getMessage();
        }

        if (!empty($errors))
            new VisitorController();
    }
}