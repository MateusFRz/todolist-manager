<?php

class UserController {


    /**
     * UserController constructor.
     * @param $action
     * @throws Exception
     */
    public function __construct($action) {
        global $rep;

        switch ($action) {
            case "login":
                $this->login();
                return;
            case "signup":
                $this->signup();
                break;
            case "logout":
                $this->logout();
                return;
            case "private":
                $this->privateChecklist();
                break;
            case "profile":
                $this->profile();
                return;
            case "signupPage":
                $this->signupPage();
                return;
            case "loginPage":
                $this->loginPage();
                return;
            default:
                throw new Exception("Bad request", 400);
        }

        require_once $rep . "/view/vue.php";
    }

    private static function login() {
        global $successes, $rep, $public;

        $email = "";
        $password = "";

        if (!Validation::isValid($_REQUEST['email'], $email) || !Validation::isValid($_REQUEST['password'], $password)) {
            throw new Exception('Bad email address or password', 400);
        }
        else if (!Validation::isEmail($email)) {
            throw new Exception('Bad email address please retry with good one !', 400);
        }

        $user = Model::findUserByEmail($email);

        if ($user == null || !password_verify($password, $user->getPassword())) {
            throw new Exception('Account not valid', 400);
        }

        $_SESSION['user'] = $user;
        $successes['login'] = 'You have login with success';


        $public = false;
        require_once $rep . "/view/vue.php";
    }

    private function signup() {
        global $successes;

        $name = "";
        $surname = "";
        $email = "";
        $password = "";

        if (!Validation::isValid($_REQUEST['name'], $name) || !Validation::isValid($_REQUEST['surname'], $surname) ||
            !Validation::isValid($_REQUEST['email'], $email) || !Validation::isValid($_REQUEST['password'], $password)) {

            throw new Exception('Something wrong', 400);
        }
        //TODO                                 IL N'Y A PAS DE 'R'
        //TODO J'ai stop ici (Nico) Faire fin du ref(r)actoring dans User, Task
        else if (!Validation::isEmail($email)) {
            throw new Exception('Bad email address please retry with good one !', 400);
        }

        if (isset($_REQUEST['email']) && isset($_REQUEST['password'])
            && isset($_REQUEST['name']) && isset($_REQUEST['surname'])) {
            $name = Validation::purify($_REQUEST['name']);
            $surname = Validation::purify($_REQUEST['surname']);
            $email = Validation::purify($_REQUEST['email']);
            $password = Validation::purify($_REQUEST['password']);

            $user = Model::findUserByEmail($email);
            if ($user != null) {
                throw new Exception('Email already exist !', 400);
            }


            if (!Validation::isAlpha($name))
                throw new Exception('Bad name !', 400);
            if (!Validation::isAlpha($surname))
                throw new Exception('Bad surname !', 400);
            if (!Validation::isEmail($email))
                throw new Exception('Bad email address !', 400);
            if (!Validation::isPassword($password))
                throw new Exception('Bad password (Minimum eight characters, at least one uppercase letter, one lowercase letter and one number)', 400);

            $hash = password_hash($password, PASSWORD_DEFAULT);

            Model::insertUser(new User($name, $surname, $email, $hash, uniqid("", true)));

            $successes['register'] = 'You created an account with success';
        } else {
            throw new Exception('Something is missing in the form !', 400);
        }

        $this->loginPage();
    }

    private function logout() {
        global $rep;

        session_destroy();
        unset($_SESSION);

        require_once $rep . "/view/login.php";
    }

    private function privateChecklist() {
        global $rep, $view, $public;

        if (isset($_SESSION['login'])) {

            $public = false;
            require_once $rep . "view/vue.php";
        } else {
            throw new Exception('You need to be connect to access this page !', 403);
        }
    }

    private function profile() {
        global $rep;

        require_once $rep . "/view/profile.php";
    }


    private function signupPage() {
        global $rep;

        require_once $rep . "/view/signup.php";
    }

    private function loginPage() {
        global $rep;

        require_once $rep . "/view/login.php";
    }
}