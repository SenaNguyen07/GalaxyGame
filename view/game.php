<?php
KiemTraAdmin();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Quản lý Game</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="Thanh MenuAdmin">
    <b class="Logo">GalaxyGame</b>
    <a href="QuanTri.php">Tổng quan</a>
    <a href="index.php">Game</a>
    <a href="">Thể loại</a>
    <a href="">NPH</a>
    <a href="">Tài khoản</a>
    <a href="">👤</a>
</div>

<div class="NoiDung">

    <div class="Khung">
        <h2>Quản lý Game</h2>

        <form class="TimKiem" method="get">
            <input
                class="O"
                type="text"
                name="timkiem"
                value="<?= HienThi($_GET["timkiem"] ?? "") ?>"
                placeholder="Tìm tên game">

            <button class="Nut">Tìm kiếm</button>
        </form>

        <?php if (!empty($loi)): ?>
            <?php ThongBao("loi", $loi); ?>
        <?php endif; ?>
    </div>

    <?php if ($gameSua): ?>

    <div class="Khung">
        <h3>Sửa Game</h3>

        <form method="post" action="index.php?action=update&id=<?= $gameSua["MaGame"] ?>">

            <input
                class="O"
                name="TenGame"
                value="<?= HienThi($gameSua["TenGame"]) ?>"
                placeholder="Tên game">

            <select class="O" name="MaTheLoai">
                <?php foreach ($theLoais as $t): ?>
                    <option value="<?= $t["MaTheLoai"] ?>"
                        <?= $gameSua["MaTheLoai"] == $t["MaTheLoai"] ? "selected" : "" ?>>
                        <?= HienThi($t["TenTheLoai"]) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <select class="O" name="MaNhaPhatHanh">
                <?php foreach ($nhaPhatHanhs as $n): ?>
                    <option value="<?= $n["MaNhaPhatHanh"] ?>"
                        <?= $gameSua["MaNhaPhatHanh"] == $n["MaNhaPhatHanh"] ? "selected" : "" ?>>
                        <?= HienThi($n["TenNhaPhatHanh"]) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <input
                class="O"
                type="number"
                name="Gia"
                value="<?= $gameSua["Gia"] ?>"
                placeholder="Giá">

            <input
                class="O"
                type="date"
                name="NgayPhatHanh"
                value="<?= $gameSua["NgayPhatHanh"] ?>">

            <input
                class="O"
                name="MoTa"
                value="<?= HienThi($gameSua["MoTa"]) ?>"
                placeholder="Mô tả">

            <select class="O" name="TrangThai">
                <option value="DangBan"
                    <?= $gameSua["TrangThai"] == "DangBan" ? "selected" : "" ?>>
                    Đang bán
                </option>

                <option value="NgungBan"
                    <?= $gameSua["TrangThai"] == "NgungBan" ? "selected" : "" ?>>
                    Ngừng bán
                </option>
            </select>

            <button class="Nut">Lưu</button>
            <a class="Nut NutXam" href="index.php">Hủy</a>

        </form>
    </div>

    <?php endif; ?>

    <div class="Khung">
        <h3>Thêm Game</h3>

        <form class="FormGame" method="post" action="index.php?action=create">

            <input
                class="O"
                name="TenGame"
                placeholder="Tên game">

            <select class="O" name="MaTheLoai">
                <option value="">-- Chọn thể loại --</option>

                <?php foreach ($theLoais as $t): ?>
                    <option value="<?= $t["MaTheLoai"] ?>">
                        <?= HienThi($t["TenTheLoai"]) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <select class="O" name="MaNhaPhatHanh">
                <option value="">-- Chọn nhà phát hành --</option>

                <?php foreach ($nhaPhatHanhs as $n): ?>
                    <option value="<?= $n["MaNhaPhatHanh"] ?>">
                        <?= HienThi($n["TenNhaPhatHanh"]) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <input
                class="O"
                type="number"
                name="Gia"
                placeholder="Giá">

            <input
                class="O"
                type="date"
                name="NgayPhatHanh">

            <input
                class="O"
                name="MoTa"
                placeholder="Mô tả">

            <button class="Nut">Thêm</button>

        </form>
    </div>

    <div class="Khung">
        <h3>Danh sách Game</h3>

        <table class="Bang">
            <tr>
                <th>Mã</th>
                <th>Tên</th>
                <th>Thể loại</th>
                <th>NPH</th>
                <th>Giá</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>

            <?php foreach ($games as $g): ?>
            <tr>
                <td><?= $g["MaGame"] ?></td>
                <td><?= HienThi($g["TenGame"]) ?></td>
                <td><?= HienThi($g["TenTheLoai"]) ?></td>
                <td><?= HienThi($g["TenNhaPhatHanh"]) ?></td>
                <td><?= DinhDangTien($g["Gia"]) ?></td>

                <td>
                    <?= $g["TrangThai"] == "DangBan" ? "Đang bán" : "Ngừng bán" ?>
                </td>

                <td>
                    <a
                        class="Nut"
                        href="index.php?action=update&id=<?= $g["MaGame"] ?>">
                        Sửa
                    </a>

                    <a
                        class="Nut NutDo"
                        href="index.php?action=delete&id=<?= $g["MaGame"] ?>"
                        onclick="return confirm('Bạn có chắc muốn xóa game này?')">
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