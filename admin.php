<?php
session_start();

require_once __DIR__. "../function.php";
require_once __DIR__. "../database.php";
require_once __DIR__. "../controllers/GameController.php";
require_once __DIR__. "../controllers/TheLoaiController.php";

KiemTraAdmin(); 

$action = $_GET["action"] ?? "game";

switch ($action):
    case "game":
        $controller = new GameController();
        $controller->admin();
        break;

    case "createGame":
        $controller = new GameController();
        $controller->create();
        break;

    case "updateGame":
        $controller = new GameController();
        $controller->update((int)($_GET["id"] ?? 0));
        break;

    case "deleteGame":
        $controller = new GameController();
        $controller->delete((int)($_GET["id"] ?? 0));
        break;

    case "theloai":
        $controller = new TheLoaiController();
        $controller->index();
        break;

    case "createTheLoai":
        $controller = new TheLoaiController();
        $controller->create();
        break;

    case "updateTheLoai":
        $controller = new TheLoaiController();
        $controller->update((int)($_GET["id"] ?? 0));
        break;

    case "deleteTheLoai":
        $controller = new TheLoaiController();
        $controller->delete((int)($_GET["id"] ?? 0));
        break;

    default:
        $controller = new GameController();
        $controller->admin();
        break;
endswitch;
?>
