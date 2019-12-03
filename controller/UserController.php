<?php


class UserController {


    /**
     * UserController constructor.
     * @param $action
     */
    public function __construct($action) {
        global $errors;

        switch ($action) {
            case "login":
                $this->login();
                break;
            case "signup":
                $this->signup();
                break;
            case "logout":
                $this->logout();
                break;
            case "private":
                $this->privateChecklist();
                break;
            case "profile":
                $this->profile();
                break;
            case "addChecklist":
                $this->addChecklist();
                break;
            case "removeTask":
                $this->removeTask();
                break;
            case "changeTaskState":
               $this->changeTaskState();
               break;
            case "removeChecklist":
               $this->removeChecklist();
               break;
            case "modifyChecklist":
                $this->modifyChecklist();
                break;
            default:
                $errors['user'] = 'You try to access forbidden page !';
                return;
        }
    }

    private function login() {
        global $errors, $successes, $rep;

        if (isset($_REQUEST['email']) && isset($_REQUEST['password'])) {
            $email = Validation::purify($_REQUEST['email']);
            $password = $_REQUEST['password'];

            if (!Validation::isEmail($email)) {
                $errors['badEmail'] = 'Bad email address please retry with good one !';
                return;
            }

            $user = Model::findUserByEmail($email);

            if ($user == null) {
                $errors['userNotExist'] = 'Email doesn\'t exist !';
                return;
            }

            if (!password_verify($password, $user->getPassword())) {
                $errors['badPassword'] = 'Wrong password. Please retry !';
                return;
            }

            $_SESSION['login'] = true;
            $_SESSION['user'] = $user;
            $successes['login'] = 'You have login with success';

            require_once $rep."/view/profile.php";
        } else {
            $errors['missing'] = 'Password or email is missing !';
        }

    }

    private function signup() {
        global $errors, $successes,$rep;

        if (isset($_REQUEST['email']) && isset($_REQUEST['password'])
            && isset($_REQUEST['name']) && isset($_REQUEST['surname'])) {
            $name = Validation::purify($_REQUEST['name']);
            $surname = Validation::purify($_REQUEST['surname']);
            $email = Validation::purify($_REQUEST['email']);
            $password = $_REQUEST['password'];

            $user = Model::findUserByEmail($email);
            if ($user != null) {
                $errors['user   Exist'] = 'Email already exist !';
                return;
            }


            if (!Validation::isAlpha($name))
                $errors['badName'] = 'Bad name !';
            if (!Validation::isAlpha($surname))
                $errors['badSurname'] = 'Bad surname !';
            if (!Validation::isEmail($email))
                $errors['badEmail'] = 'Bad email addres !';
            if (!Validation::isPassword($password))
                $errors['badPassword'] = 'Bad password (Minimum eight characters, at least one uppercase letter, one lowercase letter and one number)';

            if (!empty($errors))
                return;


            $hash = password_hash($password, PASSWORD_DEFAULT);

            Model::insertUser(new User($name, $surname, $email, $hash, uniqid("", true)));

            $successes['register'] = 'You created an account with success';
        } else {
            $errors['missing'] = 'Something is missing in the form !';
        }

        require_once $rep."view/login.php";
    }

    private function logout() {
        global $rep;

        session_destroy();
        unset($_SESSION);

        require_once $rep."/view/login.php";
    }

    private function privateChecklist() {
        global $errors, $rep;

        if (isset($_SESSION['login'])) {
            $user = $_SESSION['user'];

            $checklists = Model::findChecklistByUser($user->getID());
            require_once $rep."view/vue.php";
        } else {
            $errors['denied'] = 'You need to be connect to access this page !';
        }
    }

    private function profile() {
        global $rep;

        require_once $rep."/view/profile.php";
    }

    private function addChecklist() {
        global $errors, $successes, $rep;

        if (!isset($_REQUEST['name'])) {
            $errors['checklistNameND'] = 'Checklist name not define';
            return;
        }

        if (!isset($_REQUEST['tasks'])) {
            $errors['checklistNameND'] = "Task are not define";
            return;
        }

        if (strpos($_REQUEST['tasks'], ';') === false || strpos($_REQUEST['tasks'], '§') === false) {
            $errors['taskError'] = 'Task not correctly define !';
            return;
        }

        $tasks = [];

        $public = 1;
        if (isset($_REQUEST['public'])) $public = 0;

        $name = Validation::purify($_REQUEST['name']);
        $tasksNoParse = Validation::purify($_REQUEST['tasks']);
        $tasksNoParse = rtrim($tasksNoParse, ';');

        $tasksNoParse = explode(';', $tasksNoParse);
        foreach ($tasksNoParse as $taskNP) {
            $task = explode('§', $taskNP);

            $tasks[] = new Task($task[0], $task[1], 0, uniqid("", true));

            $task = [];
        }

        $userID = 0;
        if (isset($_SESSION['login'])) $userID = $_SESSION['user']->getID();

        echo "1 - ".$userID . "</br>";

        Model::insertChecklist(new Checklist($name, $tasks, $public, uniqid("", true)), $userID);

        $successes['checklistAdd'] = 'Checklist added success-fully !';

        //TODO redirection to the good place !
        new VisitorController();
    }

    private function removeChecklist() {
        global $errors;

        if(!isset($_REQUEST['checklistID']) || !Validation::isAlphaNum($_REQUEST['checklistID'])) {
            $errors['checklistIDNV'] = 'Checklist ID is not valid';
            return;
        }

        Model::deleteChecklist($_REQUEST['checklistID']);

        //TODO change this
        new VisitorController();
    }

    private function removeTask() {
        global $errors;

        if(!isset($_REQUEST['taskID']) || !Validation::isAlphaNum($_REQUEST['taskID'])) {
            $errors['taskIDNV'] = 'Task ID is not valid';
            return;
        }

        Model::deleteTask($_REQUEST['taskID']);

        //TODO change this
        new VisitorController();
    }

    private function changeTaskState() {
        global $errors;

        if(!isset($_REQUEST['taskID']) || !Validation::isAlphaNum($_REQUEST['taskID'])) {
            $errors['taskIDNV'] = 'Task ID is not valid';
            return;
        }

        Model::changeTaskState($_REQUEST['taskID']);

        //TODO change this
        new VisitorController();

    }

    private function modifyChecklist() {
        echo "ne fait rien pour le moment !";
    }
}