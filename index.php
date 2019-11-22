<?php

//error_reporting(-1);
//ini_set('display_errors', 'On');


//berlin.iut.local <- bdd address

require_once "DAL/CheckList.php";
require_once "DAL/Task.php";
require_once "DAL/Connection.php";

require_once "model/CheckListGateway.php";


$db = new Connection("mysql:host=fr-phonix.fr;dbname=iut", "iut", "password");
$checkListsGT = new CheckListGateway($db);


$tasks = array(
    new Task("tâche 1", "Description 1", false),
    new Task("tâche 2", "Description 2", false),
    new Task("tâche 3", "Description 3", true),
    new Task("tâche 4", "Description 4", false)
);

$checkLists = new CheckList("Ma liste", $tasks);

require_once "view/vue.php";