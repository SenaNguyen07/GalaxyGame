<?php
session_start();
require "../database.php";
require "../function.php";
// KiemTraAdmin(); ?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Quản trị</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="Thanh MenuAdmin">
        <b class="Logo">GalaxyGame Admin</b>
        <a href="QuanTri.php">Tổng quan</a>
        <a href="admin.php?action=game">Game</a>
        <a href="admin.php?action=theloai">Thể loại</a>
        <a href="">Nhà phát hành</a>
        <a href="">Tài khoản</a>>
        <a href="user.php?action=taikhoan">👤</a>
    </div>
    <div class="NoiDung">
        <div class="Khung">
            <h1>Khu vực quản trị</h1>
            <p>Đây là trang tổng quan bài mẫu. Các trang bên trên thực hiện CRUD, tìm kiếm, upload và kích hoạt game.
            </p>
        </div>
    </div>
</body>

</html>