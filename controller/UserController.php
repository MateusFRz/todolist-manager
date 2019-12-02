<?php


class UserController {


    /**
     * UserController constructor.
     * @param $action
     */
    public function __construct($action) {
        global $errors, $successes;

        if ($action == 'login') {
            $this->login();
        } elseif ($action == 'signup') {
            $this->signup();
        } elseif ($action == 'logout') {
            $this->logout();
        } elseif ($action == 'private') {
            $this->privateChecklist();
        } else {
            $errors['user'] = 'You try to access forbidden page !';
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

            Model::insertUser(new User($name, $surname, $email, $hash));

            $successes['register'] = 'You have created an account with success';
        } else {
            $errors['missing'] = 'Something is missing in the form !';
        }

        require_once $rep."view/login.php";
    }

    private function logout() {

    }

    private function privateChecklist() {

    }
}