<?php
global $public;

$checklists = Model::findChecklistByPublic($public);

require_once "pageContent/header.php";

require_once "pageContent/body.php";

require_once "pageContent/footer.php";