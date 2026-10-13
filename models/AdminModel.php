<?php

class AdminModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function dangNhap($tenDangNhap, $matKhau)
    {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM TaiKhoan
             WHERE TenDangNhap = ?
             AND TrangThai = 'HoatDong'"
        );

        $stmt->execute([$tenDangNhap]);
        $user = $stmt->fetch();

        if ($user && $user["MatKhau"] === $matKhau) {
            return $user;
        }

        return false;
    }
}

?>