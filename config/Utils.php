<?php


class Utils {

    /**
     * Generate a random ID
     *
     * @return int
     */
    public static function generatedID() : string {
        return uniqid("", true);
    }

}