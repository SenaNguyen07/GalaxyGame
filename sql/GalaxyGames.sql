CREATE DATABASE IF NOT EXISTS galaxygame_mau CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE galaxygame_mau;

SET FOREIGN_KEY_CHECKS=0;
DROP VIEW IF EXISTS V_GameChoKichHoat;
DROP VIEW IF EXISTS V_DonHangDayDu;
DROP TABLE IF EXISTS HoanTien, DanhSachUoc, ThuVien, ChiTietDonHang, DonHang, ChiTietGioHang, GioHang, GiaoDichVi, Vi, Game, NhaPhatHanh, TheLoai, TaiKhoan;
SET FOREIGN_KEY_CHECKS=1;

CREATE TABLE TaiKhoan (
    MaTaiKhoan INT AUTO_INCREMENT PRIMARY KEY,
    TenDangNhap VARCHAR(50) NOT NULL UNIQUE,
    MatKhau VARCHAR(100) NOT NULL,
    HoTen VARCHAR(100) NOT NULL,
    Email VARCHAR(100) NOT NULL UNIQUE,
    VaiTro ENUM('admin','user') NOT NULL DEFAULT 'user',
    AnhDaiDien VARCHAR(255) NULL,
    TrangThai ENUM('HoatDong','Khoa') NOT NULL DEFAULT 'HoatDong',
    NgayTao DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE TheLoai (
    MaTheLoai INT AUTO_INCREMENT PRIMARY KEY,
    TenTheLoai VARCHAR(100) NOT NULL UNIQUE,
    MoTa VARCHAR(255),
    TrangThai ENUM('HoatDong','Ngung') NOT NULL DEFAULT 'HoatDong'
);

CREATE TABLE NhaPhatHanh (
    MaNhaPhatHanh INT AUTO_INCREMENT PRIMARY KEY,
    TenNhaPhatHanh VARCHAR(150) NOT NULL,
    QuocGia VARCHAR(100),
    Email VARCHAR(100),
    Website VARCHAR(255),
    TrangThai ENUM('HoatDong','Ngung') NOT NULL DEFAULT 'HoatDong'
);

CREATE TABLE Game (
    MaGame INT AUTO_INCREMENT PRIMARY KEY,
    TenGame VARCHAR(150) NOT NULL,
    MaTheLoai INT NOT NULL,
    MaNhaPhatHanh INT NOT NULL,
    Gia DECIMAL(12,2) NOT NULL DEFAULT 0,
    AnhGame VARCHAR(255) NULL,
    MoTa TEXT,
    NgayPhatHanh DATE,
    TrangThai ENUM('DangBan','NgungBan') NOT NULL DEFAULT 'DangBan',
    FOREIGN KEY (MaTheLoai) REFERENCES TheLoai(MaTheLoai),
    FOREIGN KEY (MaNhaPhatHanh) REFERENCES NhaPhatHanh(MaNhaPhatHanh)
);

CREATE TABLE Vi (
    MaVi INT AUTO_INCREMENT PRIMARY KEY,
    MaTaiKhoan INT NOT NULL UNIQUE,
    SoDu DECIMAL(12,2) NOT NULL DEFAULT 0,
    FOREIGN KEY (MaTaiKhoan) REFERENCES TaiKhoan(MaTaiKhoan) ON DELETE CASCADE
);

CREATE TABLE GiaoDichVi (
    MaGiaoDich INT AUTO_INCREMENT PRIMARY KEY,
    MaVi INT NOT NULL,
    LoaiGiaoDich ENUM('NapTien','ThanhToan','HoanTien') NOT NULL,
    SoTien DECIMAL(12,2) NOT NULL,
    NoiDung VARCHAR(255),
    NgayGiaoDich DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (MaVi) REFERENCES Vi(MaVi) ON DELETE CASCADE
);

CREATE TABLE GioHang (
    MaGioHang INT AUTO_INCREMENT PRIMARY KEY,
    MaTaiKhoan INT NOT NULL UNIQUE,
    FOREIGN KEY (MaTaiKhoan) REFERENCES TaiKhoan(MaTaiKhoan) ON DELETE CASCADE
);

CREATE TABLE ChiTietGioHang (
    MaGioHang INT NOT NULL,
    MaGame INT NOT NULL,
    SoLuong INT NOT NULL DEFAULT 1,
    PRIMARY KEY (MaGioHang, MaGame),
    FOREIGN KEY (MaGioHang) REFERENCES GioHang(MaGioHang) ON DELETE CASCADE,
    FOREIGN KEY (MaGame) REFERENCES Game(MaGame)
);

CREATE TABLE DonHang (
    MaDonHang INT AUTO_INCREMENT PRIMARY KEY,
    MaTaiKhoan INT NOT NULL,
    TongTien DECIMAL(12,2) NOT NULL DEFAULT 0,
    TrangThai ENUM('ChoThanhToan','DaThanhToan','DaHuy','HoanTienMotPhan','HoanTienToanBo') NOT NULL DEFAULT 'ChoThanhToan',
    NgayDat DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (MaTaiKhoan) REFERENCES TaiKhoan(MaTaiKhoan)
);

CREATE TABLE ChiTietDonHang (
    MaDonHang INT NOT NULL,
    MaGame INT NOT NULL,
    DonGia DECIMAL(12,2) NOT NULL,
    SoLuong INT NOT NULL DEFAULT 1,
    PRIMARY KEY (MaDonHang, MaGame),
    FOREIGN KEY (MaDonHang) REFERENCES DonHang(MaDonHang) ON DELETE CASCADE,
    FOREIGN KEY (MaGame) REFERENCES Game(MaGame)
);

CREATE TABLE ThuVien (
    MaThuVien INT AUTO_INCREMENT PRIMARY KEY,
    MaTaiKhoan INT NOT NULL,
    MaGame INT NOT NULL,
    MaDonHang INT NOT NULL,
    TrangThaiKichHoat ENUM('ChoKichHoat','DaKichHoat','TuChoi') NOT NULL DEFAULT 'ChoKichHoat',
    NgayKichHoat DATETIME NULL,
    MaAdminKichHoat INT NULL,
    LyDoTuChoi VARCHAR(255) NULL,
    UNIQUE (MaTaiKhoan, MaGame),
    FOREIGN KEY (MaTaiKhoan) REFERENCES TaiKhoan(MaTaiKhoan) ON DELETE CASCADE,
    FOREIGN KEY (MaGame) REFERENCES Game(MaGame),
    FOREIGN KEY (MaDonHang) REFERENCES DonHang(MaDonHang),
    FOREIGN KEY (MaAdminKichHoat) REFERENCES TaiKhoan(MaTaiKhoan)
);

CREATE TABLE DanhSachUoc (
    MaTaiKhoan INT NOT NULL,
    MaGame INT NOT NULL,
    NgayThem DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (MaTaiKhoan, MaGame),
    FOREIGN KEY (MaTaiKhoan) REFERENCES TaiKhoan(MaTaiKhoan) ON DELETE CASCADE,
    FOREIGN KEY (MaGame) REFERENCES Game(MaGame) ON DELETE CASCADE
);

CREATE TABLE HoanTien (
    MaHoanTien INT AUTO_INCREMENT PRIMARY KEY,
    MaDonHang INT NOT NULL,
    MaTaiKhoan INT NOT NULL,
    SoTien DECIMAL(12,2) NOT NULL,
    LyDo VARCHAR(255),
    TrangThai ENUM('ChoXuLy','DaDuyet','TuChoi') NOT NULL DEFAULT 'ChoXuLy',
    NgayYeuCau DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    NgayXuLy DATETIME NULL,
    MaAdminXuLy INT NULL,
    FOREIGN KEY (MaDonHang) REFERENCES DonHang(MaDonHang),
    FOREIGN KEY (MaTaiKhoan) REFERENCES TaiKhoan(MaTaiKhoan),
    FOREIGN KEY (MaAdminXuLy) REFERENCES TaiKhoan(MaTaiKhoan)
);

CREATE VIEW V_DonHangDayDu AS
SELECT d.MaDonHang, d.MaTaiKhoan, tk.TenDangNhap, tk.HoTen,
       d.TongTien, d.TrangThai, d.NgayDat,
       COUNT(ct.MaGame) AS SoGame
FROM DonHang d
JOIN TaiKhoan tk ON d.MaTaiKhoan = tk.MaTaiKhoan
LEFT JOIN ChiTietDonHang ct ON d.MaDonHang = ct.MaDonHang
GROUP BY d.MaDonHang, d.MaTaiKhoan, tk.TenDangNhap, tk.HoTen,
         d.TongTien, d.TrangThai, d.NgayDat;

CREATE VIEW V_GameChoKichHoat AS
SELECT tv.MaThuVien, tv.MaTaiKhoan, tk.TenDangNhap, tk.HoTen,
       tv.MaGame, g.TenGame, tv.MaDonHang, tv.TrangThaiKichHoat,
       tv.NgayKichHoat, tv.LyDoTuChoi
FROM ThuVien tv
JOIN TaiKhoan tk ON tv.MaTaiKhoan = tk.MaTaiKhoan
JOIN Game g ON tv.MaGame = g.MaGame
WHERE tv.TrangThaiKichHoat = 'ChoKichHoat';

INSERT INTO TaiKhoan(TenDangNhap,MatKhau,HoTen,Email,VaiTro) VALUES
('admin','123456','Quản trị viên','admin@gmail.com','admin'),
('user','123456','Nguyễn Văn A','user@gmail.com','user'),
('user2','123456','Trần Thị B','user2@gmail.com','user');

INSERT INTO TheLoai(TenTheLoai,MoTa) VALUES
('Hành động','Game hành động'),
('Nhập vai','Game nhập vai'),
('Chiến thuật','Game chiến thuật'),
('Phiêu lưu','Game phiêu lưu');

INSERT INTO NhaPhatHanh(TenNhaPhatHanh,QuocGia,Email,Website) VALUES
('Galaxy Studio','Việt Nam','galaxy@example.com','https://example.com'),
('ABC Games','Hoa Kỳ','abc@example.com','https://example.com'),
('Demo Soft','Nhật Bản','demo@example.com','https://example.com');

INSERT INTO Game(TenGame,MaTheLoai,MaNhaPhatHanh,Gia,AnhGame,MoTa,NgayPhatHanh) VALUES
('Galaxy Adventure',1,1,120000,'galaxy-adventure.jpg','Game phiêu lưu mẫu cho bài thực hành','2025-05-10'),
('Space Warrior',1,2,180000,'space-warrior.jpg','Game hành động mẫu','2025-06-15'),
('Kingdom Strategy',3,3,150000,'kingdom-strategy.jpg','Game chiến thuật mẫu','2025-07-20'),
('Fantasy World',2,2,200000,'fantasy-world.jpg','Game nhập vai mẫu','2025-08-01');

INSERT INTO Vi(MaTaiKhoan,SoDu) VALUES (1,0),(2,500000),(3,200000);
INSERT INTO GioHang(MaTaiKhoan) VALUES (1),(2),(3);

-- Thư mục uploads có thể để trống; nếu chưa có ảnh, trang PHP sẽ hiện ảnh mặc định.
