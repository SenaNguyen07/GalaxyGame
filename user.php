<?php
session_start();

require_once __DIR__ . "/function.php";
require_once __DIR__ . "/database.php";
require_once __DIR__ . "/controllers/AdminController.php";

$action = $_GET["action"] ?? "dangnhap";
$auth = new AdminController();

switch ($action) {
    case "dangnhap":
        $auth->login();
        break;

    case "profile":
        $auth->profile();
        break;

    case "dangxuat":
        $auth->logout();
        break;

    default:
        $auth->login();
        break;
}
