<?php

KiemTraAdmin();

?>

<!DOCTYPE html>

<html>

<head>

    <meta charset="UTF-8">

    <title>Quản lý Thể loại</title>

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
    <a href="">👤</a>

</div>

<div class="NoiDung">

    <div class="Khung">

        <h2>Quản lý Thể loại</h2>

        <?php if (!empty($loi)): ?>

            <?php ThongBao("loi", $loi); ?>

        <?php endif; ?>

    </div>

    <?php if ($theLoaiSua): ?>

    <div class="Khung">

        <h3>Sửa Thể loại</h3>

        <form method="post" action="admin.php?action=updateTheLoai&id=<?= $theLoaiSua["MaTheLoai"] ?>">

            <input
                class="O"
                name="TenTheLoai"
                value="<?= HienThi($theLoaiSua["TenTheLoai"]) ?>"
                placeholder="Tên thể loại">

            <select class="O" name="TrangThai">

                <option value="HoatDong"
                    <?= $theLoaiSua["TrangThai"] == "HoatDong" ? "selected" : "" ?>>
                    Hoạt động
                </option>

                <option value="NgungHoatDong"
                    <?= $theLoaiSua["TrangThai"] == "NgungHoatDong" ? "selected" : "" ?>>
                    Ngừng hoạt động
                </option>

            </select>

            <button class="Nut">Lưu</button>

            <a class="Nut NutXam" href="admin.php?action=theloai">Hủy</a>

        </form>

    </div>

    <?php endif; ?>

    <div class="Khung">

        <h3>Thêm Thể loại</h3>

        <form method="post" action="admin.php?action=createTheLoai">

            <input
                class="O"
                name="TenTheLoai"
                placeholder="Tên thể loại">

            <button class="Nut">Thêm</button>

        </form>

    </div>

    <div class="Khung">

        <h3>Danh sách Thể loại</h3>

        <table class="Bang">

            <tr>

                <th>Mã</th>
                <th>Tên thể loại</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>

            </tr>

            <?php foreach ($theLoais as $t): ?>

            <tr>

                <td><?= $t["MaTheLoai"] ?></td>

                <td><?= HienThi($t["TenTheLoai"]) ?></td>

                <td>
                    <?= $t["TrangThai"] == "HoatDong"
                        ? "Hoạt động"
                        : "Ngừng hoạt động" ?>
                </td>

                <td>

                    <a
                        class="Nut"
                        href="admin.php?action=updateTheLoai&id=<?= $t["MaTheLoai"] ?>">
                        Sửa
                    </a>

                    <a
class="Nut NutDo"
                        href="admin.php?action=deleteTheLoai&id=<?= $t["MaTheLoai"] ?>"
                        onclick="return confirm('Bạn có chắc muốn xóa thể loại này?')">
                        Xóa
                    </a>

                </td>

            </tr>

            <?php endforeach; ?>

        </table>

    </div>

</div>

</body>

</html>
