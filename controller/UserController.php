<?php


class UserController {
/*
 *
1§Lorsqu’on arrive sur l’application, aucun utilisateur n’est connecté, les listes des tâches publiques sont listées.;
2§Le visiteur peut ajouter/supprimer des listes et les tâches publiques sans se connecter.;
3§Il faut créer un espace pour se connecter à l’application (si vous avez du temps, faire une partie inscription également).;
4§Une fois l’utilisateur connecté, il a accès aux listes publiques (comme le visiteur), mais également à ses listes privées.;
5§Toutes les listes de tâches ajoutées par un utilisateur sont privées par défaut afin de simplifier l’application. Il peut bien entendu supprimer ses listes également. Il faut penser à la relation entre les listes de tâches et l’utilisateur en base de données.;
6§Chaque tâche pourra être complétée via une case à cocher, ajoutez un bouton pour valider en dessous de la liste des tâches. Pour les plus téméraires, essayez de compléter/dé-compléter des tâches via des requêtes AJAX à la place du bouton valider (optionnel).;
 * */

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
            case "addTask":
                $this->addTask();
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

        Model::insertChecklist(new Checklist($name, $tasks, $public, uniqid("", true)), $userID);

        $successes['checklistAdd'] = 'Checklist added success-fully !';

        $this->privateChecklist();
    }

    private function removeChecklist() {
        global $errors;

        if(!isset($_REQUEST['checklistID']) || !Validation::isAlphaNum($_REQUEST['checklistID'])) {
            $errors['checklistIDNV'] = 'Checklist ID is not valid';
            return;
        }

        Model::deleteChecklist($_REQUEST['checklistID']);

        //TODO change this
        $errors['TODO'] = 'this feature is not finished';
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
        $errors['TODO'] = 'this feature is not finished';
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
        $errors['TODO'] = 'this feature is not finished';
        new VisitorController();

    }

    private function modifyChecklist() {
        global $errors;

        if((!isset($_REQUEST['name'])) || !Validation::isAlpha($_REQUEST['name'])){
            $errors['taskError']='Task Name is not valid';
        }

        if((!isset($_REQUEST['checklistID'])) || !Validation::isAlphaNum($_REQUEST['checklistID'])){
            $errors['checkError']='Checklist ID is not valid';
        }

        Model::updateChecklistByName($_REQUEST['checklistID'], $_REQUEST['name']);

        //TODO à faire la vue
        new VisitorController();
    }

    private function addTask() {
        global $errors;

        if((!isset($_REQUEST['name'])) || !Validation::isAlpha($_REQUEST['name'])){
            $errors['taskError']='Task Name is not valid';
        }
        if((!isset($_REQUEST['description'])) || !Validation::isAlpha($_REQUEST['description'])){
            $errors['taskError']='Task Description is not valid';
        }
        if((!isset($_REQUEST['checklistID'])) || !Validation::isAlphaNum($_REQUEST['checklistID'])){
            $errors['checkError']='Checklist ID is not valid';
        }

        $task = new Task($_REQUEST['name'], $_REQUEST['description'], false, uniqid("", true));
        Model::insertTask($task, $_REQUEST['checklistID']);

        //TODO faire la vue
        new VisitorController();
    }

}