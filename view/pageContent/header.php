<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Check this for you</title>

    <link rel="stylesheet" href="view/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="view/css/bootstrap-grid.min.css"/>
    <link rel="stylesheet" href="view/css/bootstrap-reboot.min.css"/>
    <link rel="stylesheet" href="view/css/style.css"/>

    <script async src="view/js/bootstrap.bundle.min.js"></script>
    <script async src="view/js/bootstrap.min.js"></script>

    <script async src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"/>
</head>


<?php
require_once "navbar.php";

if (!empty($errors) || !empty($successes))
    require_once "alert.php";
?>