<?php

session_start();

require_once "function.php";
require_once "controllers/GameController.php";
require_once "controllers/TheLoaiController.php";
require_once "controllers/NhaPhatHanhController.php";
require_once "controllers/TaiKhoanController.php";

$action = $_GET["action"] ?? "";

switch ($action):

    case "createGame":
        $controller = new GameController();
        $controller->create();
        break;

    case "updateGame":
        $controller = new GameController();
        $controller->update((int) ($_GET["id"] ?? 0));
        break;

    case "deleteGame":
        $controller = new GameController();
        $controller->delete((int) ($_GET["id"] ?? 0));
        break;

    case "createTheLoai":
        $controller = new TheLoaiController();
        $controller->create();
        break;

    case "updateTheLoai":
        $controller = new TheLoaiController();
        $controller->update((int) ($_GET["id"] ?? 0));
        break;

    case "deleteTheLoai":
        $controller = new TheLoaiController();
        $controller->delete((int) ($_GET["id"] ?? 0));
        break;

    // case "createNhaPhatHanh":
    //     $controller = new NhaPhatHanhController();
    //     $controller->create();
    //     break;

    // case "updateNhaPhatHanh":
    //     $controller = new NhaPhatHanhController();
    //     $controller->update((int) ($_GET["id"] ?? 0));
    //     break;

    // case "deleteNhaPhatHanh":
    //     $controller = new NhaPhatHanhController();
    //     $controller->delete((int) ($_GET["id"] ?? 0));
    //     break;

    // case "createTaiKhoan":
    //     $controller = new TaiKhoanController();
    //     $controller->create();
    //     break;

    // case "updateTaiKhoan":
    //     $controller = new TaiKhoanController();
    //     $controller->update((int) ($_GET["id"] ?? 0));
    //     break;

    // case "deleteTaiKhoan":
    //     $controller = new TaiKhoanController();
    //     $controller->delete((int) ($_GET["id"] ?? 0));
    //     break;

    // default:
    //     $controller = new GameController();
    //     $controller->admin();
    //     break;

endswitch;

?>