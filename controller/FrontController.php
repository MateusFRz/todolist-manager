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
                case "addChecklist":
                case "signup":
                    new UserController($action);
                    break;
                case "signupPage" :
                    require_once $rep."/view/signup.php";
                    break;
                case "loginPage":
                    require_once $rep."/view/login.php";
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