<?php session_start();
require "database.php";
require "function.php";
KiemTraAdmin(); ?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Quản trị</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="Thanh MenuAdmin"><b class="Logo">GalaxyGame Admin</b><a href="QuanTri.php">Tổng quan</a><a
            href="QuanLyGame.php">Game</a><a href="QuanLyTheLoai.php">Thể loại</a><a href="QuanLyNhaPhatHanh.php">Nhà
            phát hành</a><a href="QuanLyTaiKhoan.php">Tài khoản</a><a href="QuanLyDonHang.php">Đơn hàng</a><a
            href="KichHoatGame.php">Kích hoạt</a><a href="../TaiKhoan.php">👤</a></div>
    <div class="NoiDung">
        <div class="Khung">
            <h1>Khu vực quản trị</h1>
            <p>Đây là trang tổng quan bài mẫu. Các trang bên trên thực hiện CRUD, tìm kiếm, upload và kích hoạt game.
            </p>
        </div>
    </div>
</body>

</html>