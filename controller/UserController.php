<?php

class UserController {

    /**
     * Connect an user if
     * he is already on the Data Base
     */
    public static function login() {
        global $successes;

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

        UserController::privateChecklist();
    }

    /**
    * Create and add
    * a User in the Data Base
    */
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

        Model::insertUser(new User($name, $surname, $email, $hash, Utils::generatedID()));

        $successes['register'] = 'You created an account with success';

        UserController::loginPage();
    }

    /**
     * Disconnect the user
     */
    public static function logout() {
        session_destroy();
        session_unset();
        unset($_SESSION);
        $_SESSION = array();

        VisitorController::publicPage();
    }

    /**
     * Call the view for the private Checklist
     */
    public static function privateChecklist() {
        global $rep;

        if (!Validation::isUser($_SESSION['user'])) throw  new RuntimeException("User no valid");

        $nbTotal=Model::countByUser($_SESSION['user']->getID());
        $nbPages = ceil($nbTotal/10);

        if(isset($_REQUEST['page']) && is_int($_REQUEST['page'])){
            $page = $_REQUEST['page'];
            if($page>$nbPages)
                $page=$nbPages;
        } else
            $page = 1;

        $checklists = Model::findChecklistByUser($_SESSION['user']->getID(), $page-1);
        require_once $rep . "view/vue.php";
    }

    /**
     * Call the profile view
     */
    public static function profile() {
        global $rep;
        require_once $rep . "/view/profile.php";
    }

    /**
     * Call the sign up view
     */
    public static function signupPage() {
        global $rep;
        require_once $rep . "/view/signup.php";
    }

    /**
     * call the login view
     */
    public static function loginPage() {
        global $rep;
        require_once $rep . "/view/login.php";
    }
}