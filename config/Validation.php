<?php


class Validation {

    /**
     * Purify string to remove
     * possible XSS injections
     *
     * @param string $string
     * @return string
     */
    public static function purify($string) {
        $string = htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
        $string = filter_var($string, FILTER_SANITIZE_STRING);
        return $string;
    }

    /**
     * Validate if the value is
     * a letter of the alphabet
     *
     * @param mixed $value
     * @return boolean
     */
    public static function isAlpha($value) : bool {
        return preg_match("/^[a-zA-Z \-]+$/", $value);
    }

    /**
     * Validate if the value is
     * a letter or number
     *
     * @param mixed $value
     * @return boolean
     */
    public static function isAlphaNum($value) : bool {
        return preg_match("/^[a-zA-Z0-9 \-.]+$/", $value);
    }

    /**
     * Validate if the value is
     * a e-mail
     *
     * @param mixed $value
     * @return boolean
     */
    public static function isEmail($value) : bool {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    /**
     * Validate if the value
     * is a valid password
     *
     * @param $password
     * @return boolean
     */
    public static function isPassword($password) : bool {
        return filter_var($password, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/"]]);
    }

    /**
     * Validate if the value
     * is a existing user
     *
     * @param $value
     * @return boolean
     */
    public static function isUser($value) {
        return $value instanceof User;
    }

    /**
     * Validate if the value
     * is not null
     * and purify it
     *
     * @param $value
     * @param $out
     * @return boolean
     */
    public static  function  isValid($value, &$out) : bool {
        if (!empty($value) && $value != "") {
            $out = Validation::purify($value);
            return true;
        }
        return false;
    }
}