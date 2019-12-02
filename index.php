<?php

error_reporting(-1);
ini_set('display_errors', 'On');

require_once __DIR__."/config/config.php";
require_once __DIR__."/config/Autoload.php";

Autoload::charger();

$con = new FrontController();


//require_once "view/signup.php";
