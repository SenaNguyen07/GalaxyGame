
<?php
require_once __DIR__ . "/../database.php";
require_once __DIR__ . "/../function.php";

class TaiKhoanController
{
    private $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->getConnection();
    }

    // Kiểm tra quyền nhà phát hành
    private function kiemTraQuyen()
    {
        if (
            !isset($_SESSION["MaTaiKhoan"], $_SESSION["VaiTro"]) ||
            $_SESSION["VaiTro"] !== "nhaphathanh"
        ) {
            header("Location: ../user.php?action=dangnhap");
            exit;
        }
    }

    // Danh sách tài khoản
    public function index()
    {
        $this->kiemTraQuyen();

        $stmt = $this->pdo->query(
            "SELECT MaTaiKhoan, TenDangNhap, HoTen, Email, VaiTro, TrangThai
             FROM TaiKhoan
             ORDER BY MaTaiKhoan DESC"
        );

        $taiKhoans = $stmt->fetchAll(PDO::FETCH_ASSOC);

        require __DIR__ . "/view/danhsach.php";
    }

    // Thêm tài khoản
    public function them()
    {
        $this->kiemTraQuyen();

        $thongBao = "";

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $tenDangNhap = trim($_POST["TenDangNhap"] ?? "");
            $matKhau = $_POST["MatKhau"] ?? "";
            $hoTen = trim($_POST["HoTen"] ?? "");
            $email = trim($_POST["Email"] ?? "");

            if (
                $tenDangNhap === "" ||
                $matKhau === "" ||
                $hoTen === "" ||
                $email === ""
            ) {
                $thongBao = "Vui lòng nhập đầy đủ thông tin.";
            } else {
                $stmt = $this->pdo->prepare(
                    "SELECT COUNT(*) FROM TaiKhoan WHERE TenDangNhap = ?"
                );
                $stmt->execute([$tenDangNhap]);

                if ($stmt->fetchColumn() > 0) {
                    $thongBao = "Tên đăng nhập đã tồn tại.";
                } else {
                    $matKhauHash = password_hash(
                        $matKhau,
                        PASSWORD_DEFAULT
                    );

                    $stmt = $this->pdo->prepare(
                        "INSERT INTO TaiKhoan
                         (TenDangNhap, MatKhau, HoTen, Email, VaiTro, TrangThai)
                         VALUES (?, ?, ?, ?, 'nhaphathanh', 'HoatDong')"
                    );

                    $stmt->execute([
                        $tenDangNhap,
                        $matKhauHash,
                        $hoTen,
                        $email
                    ]);

                    header("Location: taikhoan.php?action=index");
                    exit;
                }
            }
        }

        echo $thongBao;
        echo '<form method="post">
            Tên đăng nhập:
            <input name="TenDangNhap" required><br>

            Mật khẩu:
            <input type="password" name="MatKhau" required><br>

            Họ tên:
            <input name="HoTen" required><br>

            Email:
            <input type="email" name="Email" required><br>

            <button type="submit">Thêm tài khoản</button>
        </form>';
    }

    // Xóa tài khoản
    public function xoa()
    {
        $this->kiemTraQuyen();

        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            http_response_code(405);
            exit("Phương thức không được hỗ trợ.");
        }

        $maTaiKhoan = (int) ($_POST["MaTaiKhoan"] ?? 0);

        // Không cho tự xóa tài khoản đang đăng nhập
        if ($maTaiKhoan === (int) $_SESSION["MaTaiKhoan"]) {
            exit("Không thể xóa tài khoản đang đăng nhập.");
        }

        $stmt = $this->pdo->prepare(
            "DELETE FROM TaiKhoan
             WHERE MaTaiKhoan = ?
             AND VaiTro = 'nhaphathanh'"
        );

        $stmt->execute([$maTaiKhoan]);

        header("Location: taikhoan.php?action=index");
        exit;
    }
}
