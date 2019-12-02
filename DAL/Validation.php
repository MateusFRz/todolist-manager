<?php


class Validation {

    /**
     * Purify string to remove
     * possible XSS injections
     *
     * @param string $string
     * @return string
     */
    public static function purify($string){
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
    public static function isInt($value){
        if(filter_var($value, FILTER_VALIDATE_INT)) return true;
        return false;
    }

    /**
     * Validate if the value is
     * a float
     *
     * @param mixed $value
     * @return boolean
     */
    public static function isFloat($value){
        if(filter_var($value, FILTER_VALIDATE_FLOAT)) return true;
        return false;
    }

    /**
     * Validate if the value is
     * a letter of the alphabet
     *
     * @param mixed $value
     * @return boolean
     */
    public static function isAlpha($value){
        if(filter_var($value, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^[a-zA-Z]+$/")))) return true;
        return false;
    }

    /**
     * Validate if the value is
     * a letter or number
     *
     * @param mixed $value
     * @return boolean
     */
    public static function isAlphaNum($value){
        if(filter_var($value, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^[a-zA-Z0-9]+$/")))) return true;
        return false;
    }

    /**
     * Validate if the value is
     * a url
     *
     * @param mixed $value
     * @return boolean
     */
    public static function isUrl($value){
        if(filter_var($value, FILTER_VALIDATE_URL)) return true;
        return false;
    }

    /**
     * Validate if the value is
     * a uri
     *
     * @param mixed $value
     * @return boolean
     */
    public static function isUri($value){
        if(filter_var($value, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^[A-Za-z0-9-\/_]+$/")))) return true;
        return false;
    }

    /**
     * Validate if the value is
     * true or false
     *
     * @param mixed $value
     * @return boolean
     */
    public static function isBool($value){
        if(is_bool(filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE))) return true;
        return false;
    }

    /**
     * Validate if the value is
     * a e-mail
     *
     * @param mixed $value
     * @return boolean
     */
    public static function isEmail($value){
        if(filter_var($value, FILTER_VALIDATE_EMAIL)) return true;
        return false;
    }
}