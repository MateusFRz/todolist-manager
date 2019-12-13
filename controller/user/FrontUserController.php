<?php


class FrontUserController {
/*
1§Lorsqu’on arrive sur l’application, aucun utilisateur n’est connecté, les listes des tâches publiques sont listées.;
2§Le visiteur peut ajouter/supprimer des listes et les tâches publiques sans se connecter.;
3§Il faut créer un espace pour se connecter à l’application (si vous avez du temps, faire une partie inscription également).;
4§Une fois l’utilisateur connecté, il a accès aux listes publiques (comme le visiteur), mais également à ses listes privées.;
5§Toutes les listes de tâches ajoutées par un utilisateur sont privées par défaut afin de simplifier l’application. Il peut bien entendu supprimer ses listes également. Il faut penser à la relation entre les listes de tâches et l’utilisateur en base de données.;
6§Chaque tâche pourra être complétée via une case à cocher, ajoutez un bouton pour valider en dessous de la liste des tâches. Pour les plus téméraires, essayez de compléter/dé-compléter des tâches via des requêtes AJAX à la place du bouton valider (optionnel).;
*/

    /**
     * FrontUserController constructor.
     * @param $action
     * @throws Exception
     */
    public function __construct($action) {
        global $errors;

        switch ($action) {
            case "private":
            case "profile":
            case "signupPage":
            case "loginPage":
            case "login":
            case "signup":
            case "logout":
                new UserController($action);
                break;

            case "removeChecklist":
            case "modifyChecklist":
            case "addChecklist":
                new ChecklistController($action);
                break;

            case "removeTask":
            case "updateTask":
            case "changeTaskState":
            case "addTask":
                new TaskController($action);
                break;

            default:
                throw new Exception('You try to access forbidden page !', 403);
        }
    }
}