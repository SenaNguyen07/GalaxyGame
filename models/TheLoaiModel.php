<?php

class TheLoaiModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function layDanhSach()
    {
        $stmt = $this->pdo->query(
            "SELECT * FROM TheLoai
             ORDER BY MaTheLoai DESC"
        );

        return $stmt->fetchAll();
    }

    public function lay($maTheLoai)
    {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM TheLoai
             WHERE MaTheLoai = ?"
        );

        $stmt->execute([$maTheLoai]);

        return $stmt->fetch();
    }

    public function them($tenTheLoai, $trangThai)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO TheLoai(TenTheLoai, TrangThai)
             VALUES(?, ?)"
        );

        return $stmt->execute([
            $tenTheLoai,
            $trangThai
        ]);
    }

    public function sua($maTheLoai, $tenTheLoai, $trangThai)
    {
        $stmt = $this->pdo->prepare(
            "UPDATE TheLoai
             SET TenTheLoai = ?, TrangThai = ?
             WHERE MaTheLoai = ?"
        );

        return $stmt->execute([
            $tenTheLoai,
            $trangThai,
            $maTheLoai
        ]);
    }

    public function xoa($maTheLoai)
    {
        $stmt = $this->pdo->prepare(
            "DELETE FROM TheLoai
             WHERE MaTheLoai = ?"
        );

        return $stmt->execute([$maTheLoai]);
    }
}