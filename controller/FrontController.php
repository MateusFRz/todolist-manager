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
                            return;
                        case "private":
                            UserController::privateChecklist();
                            return;
                        case "logout":
                            UserController::logout();
                            return;
                    }
                } else
                    throw new Exception('You need to be connected');
            } else if ($role === "visitor") {
                switch ($action) {
                    case NULL:
                    case "publicPage":
                        VisitorController::publicPage();
                        return;
                    case "removeTask":
                        TaskController::removeTask();
                        return;
                    case "addTask":
                        TaskController::addTask();
                        return;
                    case "changeTaskState":
                        TaskController::changeTaskState();
                        return;
                    case "updateTask":
                        TaskController::updateTask();
                        return;
                    case "removeChecklist":
                        ChecklistController::removeChecklist();
                        return;
                    case "modifyChecklist":
                        ChecklistController::modifyChecklist();
                        return;
                    case "addChecklist":
                        ChecklistController::addChecklist();
                        return;
                    case "login":
                        UserController::login();
                        return;
                    case "signup":
                        UserController::signup();
                        return;
                    case "signupPage" :
                        UserController::signupPage();
                        return;
                    case "loginPage":
                        UserController::loginPage();
                        return;
                }
            } else throw new UnexpectedValueException('You try something not valid !', 400);
        } catch (Exception $exception) {
            $errors['exception'] = $exception->getMessage();
        }

        //is the case an error is catch
        VisitorController::publicPage();
    }
}