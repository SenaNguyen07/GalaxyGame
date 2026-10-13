
<?php
require_once __DIR__ . "/../database.php";

class TaiKhoan
{
    private $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->getConnection();
    }

    // Lấy tất cả tài khoản
    public function getAll()
    {
        $sql = "SELECT MaTaiKhoan, TenDangNhap, HoTen, Email, VaiTro, TrangThai
                FROM TaiKhoan
                ORDER BY MaTaiKhoan DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy tài khoản theo mã
    public function getById($maTaiKhoan)
    {
        $sql = "SELECT *
                FROM TaiKhoan
                WHERE MaTaiKhoan = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$maTaiKhoan]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy tài khoản theo tên đăng nhập
    public function getByUsername($tenDangNhap)
    {
        $sql = "SELECT *
                FROM TaiKhoan
                WHERE TenDangNhap = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$tenDangNhap]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm tài khoản
    public function insert($tenDangNhap, $matKhau, $hoTen, $email, $vaiTro)
    {
        $sql = "INSERT INTO TaiKhoan
                (TenDangNhap, MatKhau, HoTen, Email, VaiTro, TrangThai)
                VALUES (?, ?, ?, ?, ?, 'HoatDong')";

        $matKhauHash = password_hash($matKhau, PASSWORD_DEFAULT);

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $tenDangNhap,
            $matKhauHash,
            $hoTen,
            $email,
            $vaiTro
        ]);
    }

    // Cập nhật tài khoản
    public function update($maTaiKhoan, $tenDangNhap, $hoTen, $email, $vaiTro, $trangThai)
    {
        $sql = "UPDATE TaiKhoan
                SET TenDangNhap = ?,
                    HoTen = ?,
                    Email = ?,
                    VaiTro = ?,
                    TrangThai = ?
                WHERE MaTaiKhoan = ?";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $tenDangNhap,
            $hoTen,
            $email,
            $vaiTro,
            $trangThai,
            $maTaiKhoan
        ]);
    }

    // Đổi mật khẩu
    public function updatePassword($maTaiKhoan, $matKhauMoi)
    {
        $matKhauHash = password_hash($matKhauMoi, PASSWORD_DEFAULT);

        $sql = "UPDATE TaiKhoan
                SET MatKhau = ?
                WHERE MaTaiKhoan = ?";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $matKhauHash,
            $maTaiKhoan
        ]);
    }

    // Xóa tài khoản
    public function delete($maTaiKhoan)
    {
        $sql = "DELETE FROM TaiKhoan
                WHERE MaTaiKhoan = ?";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([$maTaiKhoan]);
    }
}
