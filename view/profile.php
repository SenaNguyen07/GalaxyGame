<?php
KiemTraAdmin();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Thông tin tài khoản Admin</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="Thanh MenuAdmin">
    <b class="Logo">GalaxyGame</b>
    <a href="QuanTri.php">Tổng quan</a>
    <a href="admin.php?action=game">Game</a>
    <a href="admin.php?action=theloai">Thể loại</a>
    <a href="">NPH</a>
    <a href="">Tài khoản</a>
    <a href="user.php?action=profile">👤</a>
</div>

<div class="NoiDung">
    <div class="Khung" style="max-width: 600px; margin: 0 auto;">
        <h2>Thông tin tài khoản</h2>
        
        <table class="Bang" style="margin-bottom: 20px;">
            <tr>
                <th style="width: 40%;">Tiêu chí</th>
                <th>Thông tin</th>
            </tr>
            <tr>
                <td><b>Tên đăng nhập:</b></td>
                <td><?= HienThi($_SESSION["TenDangNhap"] ?? '') ?></td>
            </tr>
            <tr>
                <td><b>Họ và tên:</b></td>
                <td><?= HienThi($_SESSION["HoTen"] ?? '') ?></td>
            </tr>
            <tr>
                <td><b>Email:</b></td>
                <td><?= HienThi($_SESSION["Email"] ?? '') ?></td>
            </tr>
            <tr>
                <td><b>Vai trò:</b></td>
                <td><span class="ThanhCong" style="padding: 2px 8px; border-radius: 4px; font-size: 12px;">
                    <?= HienThi($_SESSION["VaiTro"] ?? '') ?>
                </span></td>
            </tr>
        </table>

        <div style="text-align: right;">
            <a class="Nut NutDo" href="user.php?action=dangxuat" onclick="return confirm('Bạn có chắc chắn muốn đăng xuất?')">
                Đăng xuất tài khoản
            </a>
        </div>
    </div>
</div>

</body>
</html>
