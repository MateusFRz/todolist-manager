<?php


class UserController {


    /**
     * UserController constructor.
     * @param $action
     */
    public function __construct($action) {
        global $errors;

        if ($action == 'login') {
            $this->login();
        } elseif ($action == 'signup') {
            $this->signup();
        } elseif ($action == 'logout') {
            $this->logout();
        } else {
            $errors['user'] = 'You try to access forbidden page !';
        }
    }

    private function login() {
        global $errors;

        if (isset($_REQUEST['email']) && isset($_REQUEST['password'])) {
            $email = Validation::purify($_REQUEST['email']);
            $password = $_REQUEST['password'];

            if (!Validation::isEmail($email)) {
                $errors['badEmail'] = 'Bad email address please retry with good one !';
                return;
            }

            $user = Model::findUserByEmail($email);

            if ($user == null) {
                $errors['userNotExist'] = 'Email doesn\'t exist in the database !';
                return;
            }

            if (!password_verify($password, $user->getPassword())) {
                $errors['badPassword'] = 'Wrong password. Please retry !';
                return;
            }

            $_SESSION['login'] = true;
            $_SESSION['user'] = $user;

        } else {
            $errors['missing'] = 'Password or email is missing !';
        }
    }

    private function signup() {

    }

    private function logout() {

    }
}