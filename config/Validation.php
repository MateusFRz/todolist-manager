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
     * a integer
     *
     * @param mixed $value
     * @return boolean
     */
    public static function isInt($value) {
        return filter_var($value, FILTER_VALIDATE_INT);
    }

    /**
     * Validate if the value is
     * a float
     *
     * @param mixed $value
     * @return boolean
     */
    public static function isFloat($value) {
        return filter_var($value, FILTER_VALIDATE_FLOAT);
    }

    /**
     * Validate if the value is
     * a letter of the alphabet
     *
     * @param mixed $value
     * @return boolean
     */
    public static function isAlpha($value) {
        return preg_match("/^[a-zA-Z ]+$/", $value);
    }

    /**
     * Validate if the value is
     * a letter or number
     *
     * @param mixed $value
     * @return boolean
     */
    public static function isAlphaNum($value) {
        return preg_match("/^[a-zA-Z0-9]+$/", $value);
    }

    /**
     * Validate if the value is
     * a url
     *
     * @param mixed $value
     * @return boolean
     */
    public static function isUrl($value) {
        return filter_var($value, FILTER_VALIDATE_URL);
    }

    /**
     * Validate if the value is
     * a uri
     *
     * @param mixed $value
     * @return boolean
     */
    public static function isUri($value) {
        return filter_var($value, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^[A-Za-z0-9-\/_]+$/")));
    }

    /**
     * Validate if the value is
     * true or false
     *
     * @param mixed $value
     * @return boolean
     */
    public static function isBool($value) {
        return is_bool(filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE));
    }

    /**
     * Validate if the value is
     * a e-mail
     *
     * @param mixed $value
     * @return boolean
     */
    public static function isEmail($value) {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    public static function isPassword($password) {
        return filter_var($password, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/"]]);
    }
}