<?php

//error_reporting(-1);
//ini_set('display_errors', 'On');


//berlin.iut.local <- bdd address

require_once "DAL/Checklist.php";
require_once "DAL/Task.php";
require_once "DAL/Connection.php";

require_once "model/TaskGateway.php";
require_once "model/ChecklistGateway.php";


$db = new Connection("mysql:host=localhost;dbname=iut", "iut", "password");
$checkListGT = new ChecklistGateway($db);

$checkLists = $checkListGT->findChecklistByUser(525);

require_once "view/vue.php";
