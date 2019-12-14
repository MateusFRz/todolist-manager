<?php

class FrontController {

    /**
     * FrontController constructor.
     */
    public function __construct() {
        global $errors, $rep;
        $action = $_REQUEST['action'];

        session_start();

        $actions = array(
            'visitor' => [NULL, 'login', 'signup', 'signupPage', 'loginPage', 'publicPage', 'removeTask', 'addChecklist', 'changeTaskState', 'removeChecklist', 'modifyChecklist', 'addTask', 'updateTask'],
            'user' => ['profile', 'private', 'logout']
        );

        Validation::purify($action);
        try {
            $role=null;

            foreach (array_keys($actions) as $actionKey) {
                $find = array_search($action, $actions[$actionKey]);
                if ($find != null || $find === 0) {
                    $role = $actionKey;
                    break;
                }
            }

            if ($role === "user") {
                if (Validation::isUser($_SESSION['user'])) {
                    switch ($action) {
                        case "profile":
                            UserController::profile();
                            break;
                        case "private":
                            UserController::privateChecklist();
                            break;
                        case "logout":
                            UserController::logout();
                            break;
                    }
                } else
                    throw new Exception('You need to be connected');
            } else if ($role === "visitor") {
                switch ($action) {
                    case NULL:
                    case "publicPage":
                        VisitorController::publicPage();
                        break;
                    case "removeTask":
                        TaskController::removeTask();
                        break;
                    case "addChecklist":
                        TaskController::addTask();
                        break;
                    case "changeTaskState":
                        TaskController::changeTaskState();
                        break;
                    case "updateTask":
                        TaskController::updateTask();
                        break;
                    case "removeChecklist":
                        ChecklistController::removeChecklist();
                        break;
                    case "modifyChecklist":
                        ChecklistController::modifyChecklist();
                        break;
                    case "addTask":
                        ChecklistController::addChecklist();
                        break;
                    case "login":
                        UserController::login();
                        break;
                    case "signup":
                        UserController::signup();
                        break;
                    case "signupPage" :
                        UserController::signupPage();
                        break;
                    case "loginPage":
                        UserController::loginPage();
                        break;
                }
            } else throw new UnexpectedValueException('You try something not valid !', 400);
        } catch (Exception $exception) {
            $errors['exception'] = $exception->getMessage();
        }

        require_once $rep . "/view/vue.php";
    }
}