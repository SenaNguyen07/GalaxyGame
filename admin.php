<?php

session_start();

require_once "function.php";
require_once "controllers/GameController.php";

$action = $_GET["action"] ?? "";

$controller = new GameController();

switch ($action):
    case "create":
        $controller->create();
        break;

    case "update":
        $maGame = (int)($_GET["id"] ?? 0);
        $controller->update($maGame);
        break;

    case "delete":
        $maGame = (int)($_GET["id"] ?? 0);
        $controller->delete($maGame);
        break;

    default:
        $controller->index();
        break;
endswitch;
?>