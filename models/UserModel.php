<?php

class UserModel
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
             WHERE TenDangNhap=? AND MatKhau=? AND TrangThai='HoatDong'"
        );
        $stmt->execute([$tenDangNhap, $matKhau]);
        return $stmt->fetch();
    }

    public function layGameMoi()
    {
        $stmt = $this->pdo->query(
            "SELECT * FROM Game
             WHERE TrangThai='DangBan'
             ORDER BY MaGame DESC
             LIMIT 4"
        );
        return $stmt->fetchAll();
    }

    public function layDanhSachGame($tuKhoa)
    {
        $sql = "SELECT g.*,tl.TenTheLoai,nph.TenNhaPhatHanh
                FROM Game g
                JOIN TheLoai tl ON g.MaTheLoai=tl.MaTheLoai
                JOIN NhaPhatHanh nph ON g.MaNhaPhatHanh=nph.MaNhaPhatHanh
                WHERE g.TrangThai='DangBan'
                AND (g.TenGame LIKE ? OR tl.TenTheLoai LIKE ?)
                ORDER BY g.MaGame DESC";

        $stmt = $this->pdo->prepare($sql);
        
        return $stmt->fetchAll();
    }

    public function layGame($maGame)
    {
        $stmt = $this->pdo->prepare(
            "SELECT g.*,tl.TenTheLoai,nph.TenNhaPhatHanh
             FROM Game g
             JOIN TheLoai tl ON g.MaTheLoai=tl.MaTheLoai
             JOIN NhaPhatHanh nph ON g.MaNhaPhatHanh=nph.MaNhaPhatHanh
             WHERE g.MaGame=?"
        );
        $stmt->execute([$maGame]);

        return $stmt->fetch();
    }

    public function themGioHang($maTaiKhoan, $maGame)
    {
        $stmt = $this->pdo->prepare(
            "SELECT MaGioHang FROM GioHang WHERE MaTaiKhoan=?"
        );
        $stmt->execute([$maTaiKhoan]);
        $gh = $stmt->fetch();

        if (!$gh) {
            $this->pdo->prepare(
                "INSERT INTO GioHang(MaTaiKhoan) VALUES(?)"
            )->execute([$maTaiKhoan]);

            $maGioHang = $this->pdo->lastInsertId();
        } else {
            $maGioHang = $gh["MaGioHang"];
        }

        $stmt = $this->pdo->prepare(
            "INSERT INTO ChiTietGioHang(MaGioHang,MaGame)
             VALUES(?,?)
             ON DUPLICATE KEY UPDATE SoLuong=SoLuong+1"
        );

        return $stmt->execute([$maGioHang, $maGame]);
    }

    public function themYeuThich($maTaiKhoan, $maGame)
    {
        $stmt = $this->pdo->prepare(
            "INSERT IGNORE INTO DanhSachUoc(MaTaiKhoan,MaGame)
             VALUES(?,?)"
        );

        return $stmt->execute([$maTaiKhoan, $maGame]);
    }

    public function layYeuThich($maTaiKhoan)
    {
        $stmt = $this->pdo->prepare(
            "SELECT g.*
             FROM DanhSachUoc d
             JOIN Game g ON d.MaGame=g.MaGame
             WHERE d.MaTaiKhoan=?"
        );
        $stmt->execute([$maTaiKhoan]);

        return $stmt->fetchAll();
    }

    public function xoaYeuThich($maTaiKhoan, $maGame)
    {
        $stmt = $this->pdo->prepare(
            "DELETE FROM DanhSachUoc
             WHERE MaTaiKhoan=? AND MaGame=?"
        );

        return $stmt->execute([$maTaiKhoan, $maGame]);
    }

    public function yeuThichSangGioHang($maTaiKhoan, $maGame)
    {
        $this->themGioHang($maTaiKhoan, $maGame);
        return $this->xoaYeuThich($maTaiKhoan, $maGame);
    }

    public function layGioHang($maTaiKhoan)
    {
        $stmt = $this->pdo->prepare(
            "SELECT gh.MaGioHang
             FROM GioHang gh
             WHERE gh.MaTaiKhoan=?"
        );
        $stmt->execute([$maTaiKhoan]);
        $gh = $stmt->fetch();

        if (!$gh) {
            return [
                "MaGioHang" => 0,
                "items" => [],
                "tong" => 0
            ];
        }

        $stmt = $this->pdo->prepare(
            "SELECT ct.*,g.TenGame,g.Gia,g.AnhGame
             FROM ChiTietGioHang ct
             JOIN Game g ON ct.MaGame=g.MaGame
             WHERE ct.MaGioHang=?"
        );
        $stmt->execute([$gh["MaGioHang"]]);
        $items = $stmt->fetchAll();

        $tong = 0;

        foreach ($items as $item) {
            $tong += $item["Gia"] * $item["SoLuong"];
        }

        return [
            "MaGioHang" => $gh["MaGioHang"],
            "items" => $items,
            "tong" => $tong
        ];
    }

    public function xoaGioHang($maGioHang, $maGame)
    {
        $stmt = $this->pdo->prepare(
            "DELETE FROM ChiTietGioHang
             WHERE MaGioHang=? AND MaGame=?"
        );

        return $stmt->execute([$maGioHang, $maGame]);
    }

    public function layTaiKhoan($maTaiKhoan)
    {
        $stmt = $this->pdo->prepare(
            "SELECT tk.*,v.SoDu
             FROM TaiKhoan tk
             LEFT JOIN Vi v ON tk.MaTaiKhoan=v.MaTaiKhoan
             WHERE tk.MaTaiKhoan=?"
        );
        $stmt->execute([$maTaiKhoan]);

        return $stmt->fetch();
    }

    public function capNhatTaiKhoan($maTaiKhoan, $hoTen, $email)
    {
        $stmt = $this->pdo->prepare(
            "UPDATE TaiKhoan
             SET HoTen=?,Email=?
             WHERE MaTaiKhoan=?"
        );

        return $stmt->execute([
            $hoTen,
            $email,
            $maTaiKhoan
        ]);
    }

    public function laySoDu($maTaiKhoan)
    {
        $stmt = $this->pdo->prepare(
            "SELECT SoDu FROM Vi WHERE MaTaiKhoan=?"
        );
        $stmt->execute([$maTaiKhoan]);

        return $stmt->fetch();
    }

    public function napTien($maTaiKhoan, $soTien)
    {
        $this->pdo->beginTransaction();

        try {
            $stmt = $this->pdo->prepare(
                "SELECT MaVi FROM Vi
                 WHERE MaTaiKhoan=?
                 FOR UPDATE"
            );
            $stmt->execute([$maTaiKhoan]);
            $vi = $stmt->fetch();

            if (!$vi) {
                throw new Exception("Không tìm thấy ví.");
            }

            $stmt = $this->pdo->prepare(
                "UPDATE Vi SET SoDu=SoDu+? WHERE MaVi=?"
            );
            $stmt->execute([$soTien, $vi["MaVi"]]);

            $stmt = $this->pdo->prepare(
                "INSERT INTO GiaoDichVi
                 (MaVi,LoaiGiaoDich,SoTien,NoiDung)
                 VALUES(?, 'NapTien', ?, 'Nạp tiền mẫu')"
            );
            $stmt->execute([
                $vi["MaVi"],
                $soTien
            ]);

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    public function layGiaoDich($maTaiKhoan)
    {
        $stmt = $this->pdo->prepare(
            "SELECT gd.*
             FROM GiaoDichVi gd
             JOIN Vi v ON gd.MaVi=v.MaVi
             WHERE v.MaTaiKhoan=?
             ORDER BY gd.MaGiaoDich DESC"
        );
        $stmt->execute([$maTaiKhoan]);

        return $stmt->fetchAll();
    }

    public function thanhToan($maTaiKhoan)
    {
        $cart = $this->layGioHang($maTaiKhoan);
        $items = $cart["items"];
        $tong = $cart["tong"];
        $maGioHang = $cart["MaGioHang"];

        if (!$items) {
            throw new Exception("Giỏ hàng đang trống.");
        }

        $this->pdo->beginTransaction();

        try {
            $stmt = $this->pdo->prepare(
                "SELECT SoDu,MaVi
                 FROM Vi
                 WHERE MaTaiKhoan=?
                 FOR UPDATE"
            );
            $stmt->execute([$maTaiKhoan]);
            $vi = $stmt->fetch();

            if (!$vi || $vi["SoDu"] < $tong) {
                throw new Exception("Số dư không đủ.");
            }

            $stmt = $this->pdo->prepare(
                "INSERT INTO DonHang
                 (MaTaiKhoan,TongTien,TrangThai)
                 VALUES(?,?, 'DaThanhToan')"
            );
            $stmt->execute([$maTaiKhoan, $tong]);

            $maDonHang = $this->pdo->lastInsertId();

            foreach ($items as $item) {
                $stmt = $this->pdo->prepare(
                    "INSERT INTO ChiTietDonHang
                     (MaDonHang,MaGame,DonGia,SoLuong)
                     VALUES(?,?,?,?)"
                );
                $stmt->execute([
                    $maDonHang,
                    $item["MaGame"],
                    $item["Gia"],
                    $item["SoLuong"]
                ]);

                $stmt = $this->pdo->prepare(
                    "INSERT INTO ThuVien
                     (MaTaiKhoan,MaGame,MaDonHang)
                     VALUES(?,?,?)
                     ON DUPLICATE KEY UPDATE
                     MaDonHang=VALUES(MaDonHang)"
                );
                $stmt->execute([
                    $maTaiKhoan,
                    $item["MaGame"],
                    $maDonHang
                ]);
            }

            $stmt = $this->pdo->prepare(
                "UPDATE Vi
                 SET SoDu=SoDu-?
                 WHERE MaVi=?"
            );
            $stmt->execute([$tong, $vi["MaVi"]]);

            $stmt = $this->pdo->prepare(
                "INSERT INTO GiaoDichVi
                 (MaVi,LoaiGiaoDich,SoTien,NoiDung)
                 VALUES(?, 'ThanhToan', ?, ?)"
            );
            $stmt->execute([
                $vi["MaVi"],
                $tong,
                "Thanh toán đơn hàng #".$maDonHang
            ]);

            $stmt = $this->pdo->prepare(
                "DELETE FROM ChiTietGioHang
                 WHERE MaGioHang=?"
            );
            $stmt->execute([$maGioHang]);

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    public function layThuVien($maTaiKhoan)
    {
        $stmt = $this->pdo->prepare(
            "SELECT tv.*,g.TenGame,g.AnhGame
             FROM ThuVien tv
             JOIN Game g ON tv.MaGame=g.MaGame
             WHERE tv.MaTaiKhoan=?
             ORDER BY tv.MaThuVien DESC"
        );
        $stmt->execute([$maTaiKhoan]);

        return $stmt->fetchAll();
    }

    public function layNhaPhatHanh($maNhaPhatHanh)
    {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM NhaPhatHanh
             WHERE MaNhaPhatHanh=?"
        );
        $stmt->execute([$maNhaPhatHanh]);
        $nhaPhatHanh = $stmt->fetch();

        if (!$nhaPhatHanh) {
            return null;
        }

        $stmt = $this->pdo->prepare(
            "SELECT * FROM Game
             WHERE MaNhaPhatHanh=?
             AND TrangThai='DangBan'"
        );
        $stmt->execute([$maNhaPhatHanh]);

        return [
            "nhaPhatHanh" => $nhaPhatHanh,
            "games" => $stmt->fetchAll()
        ];
    }
}