<?php

class UserController {


    /**
     * UserController constructor.
     * @param $action
     * @throws Exception
     */
    /*
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
*/
    public static function login() {
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

    public static function signup() {
        global $successes;

        $name = "";
        $surname = "";
        $email = "";
        $password = "";

        if (!Validation::isValid($_REQUEST['name'], $name) || !Validation::isValid($_REQUEST['surname'], $surname) ||
            !Validation::isValid($_REQUEST['email'],    $email) || !Validation::isValid($_REQUEST['password'], $password)) {

            throw new Exception('Something wrong', 400);
        }

        else if (!Validation::isEmail($email)) {
            throw new Exception('Bad email address please retry with good one !', 400);
        }

        $user = Model::findUserByEmail($email);

        if ($user != null) {
            throw new Exception('Email already exist !', 400);
        }

        if (!Validation::isAlpha($name))
            throw new Exception('Bad name !', 400);
        if (!Validation::isAlpha($surname))
            throw new Exception('Bad surname !', 400);
        if (!Validation::isPassword($password))
            throw new Exception('Bad password (Minimum eight characters, at least one uppercase letter, one lowercase letter and one number)', 400);

            $hash = password_hash($password, PASSWORD_DEFAULT);

            Model::insertUser(new User($name, $surname, $email, $hash, uniqid("", true)));

            $successes['register'] = 'You created an account with success';

            UserController::loginPage();

    }

    public static function logout() {
        global $rep;

        session_destroy();
        unset($_SESSION);
        //TODO a changer
        require_once $rep . "/view/login.php";
    }

    public static function privateChecklist() {
        global $rep, $view, $public;

        if(!Validation::isValid($_SESSION['login'], $out)) {
            throw new Exception('You need to be connect to access this page !', 403);
        }

        $public = false;
        //TODO a changer
        require_once $rep . "view/vue.php";
    }

    public static function profile() {
        global $rep;
        //TODO a changer
        require_once $rep . "/view/profile.php";
    }


    public static function signupPage() {
        global $rep;
        //TODO a changer
        require_once $rep . "/view/signup.php";
    }

    public static function loginPage() {
        global $rep;
        //TODO a changer
        require_once $rep . "/view/login.php";
    }
}