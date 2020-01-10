<?php


class VisitorController {

    public static function publicPage() {
        global $rep, $errors, $successes;


        $pName = "Public page";

        $nbTotal=Model::countByPublic(true);
        $nbPages = ceil($nbTotal/10);

        if(isset($_REQUEST['page']) && Validation::isInt($_REQUEST['page'])){
            $page = $_REQUEST['page'];
            if($page>$nbPages)
                $page=$nbPages;
        } else
            $page = 1;

        $checklists = Model::findChecklistByPublic(true, $page-1);
        require_once $rep . "/view/vue.php";
    }
}