<?php
KiemTraAdmin();
class GameModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function layDanhSach()
    {
        $sql = "SELECT g.*, tl.TenTheLoai, nph.TenNhaPhatHanh
                FROM Game g
                INNER JOIN TheLoai tl ON g.MaTheLoai = tl.MaTheLoai
                INNER JOIN NhaPhatHanh nph ON g.MaNhaPhatHanh = nph.MaNhaPhatHanh
                ORDER BY g.MaGame DESC";

        return $this->pdo->query($sql)->fetchAll();
    }

    public function timKiem($tuKhoa)
    {
        $sql = "SELECT g.*, tl.TenTheLoai, nph.TenNhaPhatHanh
                FROM Game g
                INNER JOIN TheLoai tl ON g.MaTheLoai = tl.MaTheLoai
                INNER JOIN NhaPhatHanh nph ON g.MaNhaPhatHanh = nph.MaNhaPhatHanh
                WHERE g.TenGame LIKE ?
                ORDER BY g.MaGame DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(["%" . $tuKhoa . "%"]);

        return $stmt->fetchAll();
    }

    public function layGame($maGame)
    {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM Game WHERE MaGame = ?"
        );

        $stmt->execute([$maGame]);

        return $stmt->fetch();
    }

    public function layTheLoai()
    {
        $stmt = $this->pdo->query(
            "SELECT * FROM TheLoai
             WHERE TrangThai = 'HoatDong'
             ORDER BY TenTheLoai"
        );

        return $stmt->fetchAll();
    }

    public function layNhaPhatHanh()
    {
        $stmt = $this->pdo->query(
            "SELECT * FROM NhaPhatHanh
             WHERE TrangThai = 'HoatDong'
             ORDER BY TenNhaPhatHanh"
        );

        return $stmt->fetchAll();
    }

    public function them($tenGame, $maTheLoai, $maNhaPhatHanh, $gia, $moTa, $ngayPhatHanh)
    {
        $sql = "INSERT INTO Game
                (TenGame, MaTheLoai, MaNhaPhatHanh, Gia, MoTa, NgayPhatHanh, TrangThai)
                VALUES (?, ?, ?, ?, ?, ?, 'DangBan')";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $tenGame,
            $maTheLoai,
            $maNhaPhatHanh,
            $gia,
            $moTa,
            $ngayPhatHanh ?: null
        ]);
    }

    public function sua($maGame, $tenGame, $maTheLoai, $maNhaPhatHanh, $gia, $moTa, $ngayPhatHanh, $trangThai)
    {
        $sql = "UPDATE Game
                SET TenGame = ?, MaTheLoai = ?, MaNhaPhatHanh = ?,
                    Gia = ?, MoTa = ?, NgayPhatHanh = ?, TrangThai = ?
                WHERE MaGame = ?";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $tenGame,
            $maTheLoai,
            $maNhaPhatHanh,
            $gia,
            $moTa,
            $ngayPhatHanh ?: null,
            $trangThai,
            $maGame
        ]);
    }

    public function xoa($maGame)
    {
        $stmt = $this->pdo->prepare(
            "DELETE FROM Game WHERE MaGame = ?"
        );

        return $stmt->execute([$maGame]);
    }
}