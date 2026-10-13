<?php
// controllers/AuthController.php
require_once __DIR__ . "/../database.php";
require_once __DIR__ . "/../function.php";

class AdminController
{
    private $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->getConnection();
    }

    public function login()
    {
        // Nếu đã đăng nhập quyền admin rồi thì chuyển thẳng vào trang quản trị
        if (isset($_SESSION["MaTaiKhoan"]) && $_SESSION["VaiTro"] === "admin") {
            header("Location: QuanTri.php");
            exit;
        }

        $loi = "";
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $tenDangNhap = trim($_POST["TenDangNhap"] ?? "");
            $matKhau = $_POST["MatKhau"] ?? "";

            // Truy vấn kiểm tra tài khoản dữ liệu thuần túy theo DB mẫu của bạn (chưa hash mật khẩu)
            $stmt = $this->pdo->prepare("SELECT * FROM TaiKhoan WHERE TenDangNhap = ? AND TrangThai = 'HoatDong'");
            $stmt->execute([$tenDangNhap]);
            $user = $stmt->fetch();

            if ($user && $user["MatKhau"] === $matKhau) {
                if ($user["VaiTro"] === "admin") {
                    // Lưu toàn bộ thông tin cơ bản vào Session để hiển thị ở Profile
                    $_SESSION["MaTaiKhoan"]  = $user["MaTaiKhoan"];
                    $_SESSION["TenDangNhap"] = $user["TenDangNhap"];
                    $_SESSION["HoTen"]       = $user["HoTen"];
                    $_SESSION["Email"]       = $user["Email"];
                    $_SESSION["VaiTro"]      = $user["VaiTro"];

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
        // Gọi giao diện hiển thị thông tin cá nhân
        require __DIR__ . "/../view/profile.php";
    }

    public function logout()
    {
        // Xóa sạch Session và quay về trang đăng nhập
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();

        header("Location: user.php?action=dangnhap");
        exit;
    }
}
