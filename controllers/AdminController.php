<?php

require_once __DIR__ . "/../database.php";
require_once __DIR__ . "/../function.php";
require_once __DIR__ . "/../models/AdminModel.php";

class AdminController
{
    private $model;

    public function __construct()
    {
        $database = new Database();
        $this->model = new AdminModel($database->getConnection());
    }

    public function login()
    {
        if (isset($_SESSION["MaTaiKhoan"]) && $_SESSION["VaiTro"] === "admin") {
            header("Location: QuanTri.php");
            exit;
        }
        $loi = "";

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $tenDangNhap = trim($_POST["TenDangNhap"] ?? "");
            $matKhau = $_POST["MatKhau"] ?? "";
            $user = $this->model->dangNhap($tenDangNhap, $matKhau);

            if ($user) {
                if ($user["VaiTro"] === "admin") {
                    session_regenerate_id(true);

                    $_SESSION["MaTaiKhoan"] = $user["MaTaiKhoan"];
                    $_SESSION["TenDangNhap"] = $user["TenDangNhap"];
                    $_SESSION["HoTen"] = $user["HoTen"];
                    $_SESSION["Email"] = $user["Email"];
                    $_SESSION["VaiTro"] = $user["VaiTro"];

                    header("Location: QuanTri.php");
                    exit;
                } else {
                    $loi = "Tài khoản của bạn không có quyền truy cập quản trị.";
                }
            } else {
                $loi = "Tên đăng nhập hoặc mật khẩu không chính xác.";
            }
        }
        require __DIR__ . "/../view/dangnhap.php";
    }

    public function profile()
    {
        require __DIR__ . "/../view/profile.php";
    }

    public function logout()
    {
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(), "", time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        session_destroy();
        header("Location: user.php?action=dangnhap");
        exit;
    }
}
?>