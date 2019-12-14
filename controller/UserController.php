<?php

class UserController {

    public static function login() {
        global $successes, $rep, $public;

        $email = "";
        $password = "";

        if (!Validation::isValid($_REQUEST['email'], $email) || !Validation::isValid($_REQUEST['password'], $password))
            throw new InvalidArgumentException('Bad email address or password', 400);
        if (!Validation::isEmail($email))
            throw new InvalidArgumentException('Bad email address please retry with good one !', 400);


        $user = Model::findUserByEmail($email);

        if ($user == null || !password_verify($password, $user->getPassword()))
            throw new InvalidArgumentException('Account not valid', 400);

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
            !Validation::isValid($_REQUEST['email'], $email) || !Validation::isValid($_REQUEST['password'], $password))
            throw new InvalidArgumentException('Something wrong', 400);

        else if (!Validation::isEmail($email))
            throw new InvalidArgumentException('Bad email address please retry with good one !', 400);

        $user = Model::findUserByEmail($email);

        if ($user != null)
            throw new InvalidArgumentException('Email already exist !', 400);

        if (!Validation::isAlpha($name))
            throw new InvalidArgumentException('Bad name !', 400);
        if (!Validation::isAlpha($surname))
            throw new InvalidArgumentException('Bad surname !', 400);
        if (!Validation::isPassword($password))
            throw new InvalidArgumentException('Bad password (Minimum eight characters, at least one uppercase letter, one lowercase letter and one number)', 400);

        $hash = password_hash($password, PASSWORD_DEFAULT);

        Model::insertUser(new User($name, $surname, $email, $hash, uniqid("", true)));

        $successes['register'] = 'You created an account with success';

        UserController::loginPage();
    }

    public static function logout() {
        global $rep;

        session_destroy();
        unset($_SESSION);
        $_SESSION = array();
        //TODO a changer
        require_once $rep . "/view/login.php";
    }

    public static function privateChecklist() {
        global $rep, $public;

        if (!Validation::isValid($_SESSION['login'], $out))
            throw new InvalidArgumentException('You need to be connect to access this page !', 403);

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