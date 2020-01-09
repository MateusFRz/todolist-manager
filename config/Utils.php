<?php


class Utils {

    /**
     * Generate a random ID
     *
     * @return string
     */
    public static function generatedID() : string {
        return uniqid("", true);
    }

}