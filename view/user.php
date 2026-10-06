<?php if ($trang == "dangnhap"): ?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="NoiDung" style="max-width:450px">
    <div class="Khung">
        <h2>GalaxyGame - Đăng nhập</h2>

        <?php if ($loi) ThongBao("loi", $loi); ?>

        <form method="post">
            <input class="O" name="TenDangNhap"
                   value="<?= HienThi($tenNho) ?>"
                   placeholder="Tên đăng nhập">

            <input class="O" type="password"
                   name="MatKhau"
                   placeholder="Mật khẩu">

            <button class="Nut" name="dangnhap">
                Đăng nhập
            </button>
        </form>

        <p>Tài khoản mẫu:
            <b>admin / 123456</b> hoặc
            <b>user / 123456</b>
        </p>
    </div>
</div>

</body>
</html>


<?php elseif ($trang == "trangchu"): ?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Trang chủ</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="Thanh">
    <b class="Logo">GalaxyGame</b>
    <a href="user.php?action=trangchu">Trang chủ</a>
    <a href="user.php?action=cuahang">Cửa hàng</a>
    <a href="user.php?action=thuvien">Thư viện</a>
    <a href="user.php?action=yeuthich">Danh sách ước</a>
    <a href="user.php?action=giohang">Giỏ hàng</a>
    <a href="user.php?action=taikhoan">👤 <?= HienThi($_SESSION["HoTen"]) ?></a>
</div>

<div class="NoiDung">

    <div class="Khung">
        <h1>GalaxyGame</h1>
        <p>Trang chủ bài mẫu quản lý và bán game.</p>
    </div>

    <h2>Game mới</h2>

    <div class="Luoi">
        <?php foreach ($games as $g): ?>

        <div class="Game">
            <div class="GameNoiDung">
                <a href="user.php?action=chitiet&MaGame=<?= $g["MaGame"] ?>">
                    <b><?= HienThi($g["TenGame"]) ?></b>
                </a>

                <p><?= DinhDangTien($g["Gia"]) ?></p>
            </div>
        </div>

        <?php endforeach; ?>
    </div>

</div>

</body>
</html>


<?php elseif ($trang == "cuahang"): ?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cửa hàng</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="Thanh">
    <b class="Logo">GalaxyGame</b>
    <a href="user.php?action=trangchu">Trang chủ</a>
    <a href="user.php?action=cuahang">Cửa hàng</a>
    <a href="user.php?action=thuvien">Thư viện</a>
    <a href="user.php?action=yeuthich">Danh sách ước</a>
    <a href="user.php?action=giohang">Giỏ hàng</a>
    <a href="user.php?action=taikhoan">👤 <?= HienThi($_SESSION["HoTen"]) ?></a>
</div>

<div class="NoiDung">

    <div class="Khung">
        <h2>Cửa hàng</h2>

        <form method="get">
            <input type="hidden" name="action" value="cuahang">

            <input class="O"
                   name="timkiem"
                   value="<?= HienThi($tuKhoa) ?>"
                   placeholder="Tìm tên game hoặc thể loại">

            <button class="Nut">Tìm kiếm</button>
        </form>
    </div>

    <div class="Luoi">

        <?php foreach ($games as $g): ?>

        <div class="Game">
            <div class="GameNoiDung">
                <a href="user.php?action=chitiet&MaGame=<?= $g["MaGame"] ?>">
                    <b><?= HienThi($g["TenGame"]) ?></b>
                </a>

                <p>
                    <?= HienThi($g["TenTheLoai"]) ?>
                    ·
                    <?= HienThi($g["TenNhaPhatHanh"]) ?>
                </p>

                <b><?= DinhDangTien($g["Gia"]) ?></b>
            </div>
        </div>

        <?php endforeach; ?>

    </div>

</div>

</body>
</html>


<?php elseif ($trang == "chitiet"): ?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Chi tiết game</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="Thanh">
    <b class="Logo">GalaxyGame</b>
    <a href="user.php?action=cuahang">Cửa hàng</a>
    <a href="user.php?action=giohang">Giỏ hàng</a>
    <a href="user.php?action=thuvien">Thư viện</a>
    <a href="user.php?action=taikhoan">👤 <?= HienThi($_SESSION["HoTen"]) ?></a>
</div>

<div class="NoiDung">

    <div class="Khung">

        <h1><?= HienThi($g["TenGame"]) ?></h1>

        <?php if ($msg) ThongBao("thanhcong", $msg); ?>

        <p>
            Thể loại:
            <?= HienThi($g["TenTheLoai"]) ?>
        </p>

        <p>
            Nhà phát hành:
            <a href="user.php?action=nhaphathanh&MaNhaPhatHanh=<?= $g["MaNhaPhatHanh"] ?>">
                <?= HienThi($g["TenNhaPhatHanh"]) ?>
            </a>
        </p>

        <p><?= HienThi($g["MoTa"]) ?></p>

        <h2><?= DinhDangTien($g["Gia"]) ?></h2>

        <form method="post" class="FormNho">
            <button class="Nut" name="themgiohang">
                Thêm vào giỏ
            </button>
        </form>

        <form method="post" class="FormNho">
            <button class="Nut" name="themyeuthich">
                Thêm danh sách ước
            </button>
        </form>

    </div>

</div>

</body>
</html>


<?php elseif ($trang == "yeuthich"): ?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Danh sách ước</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="Thanh">
    <b class="Logo">GalaxyGame</b>
    <a href="user.php?action=cuahang">Cửa hàng</a>
    <a href="user.php?action=yeuthich">Danh sách ước</a>
    <a href="user.php?action=giohang">Giỏ hàng</a>
</div>

<div class="NoiDung">

    <div class="Khung">

        <h2>Danh sách ước</h2>

        <table class="Bang">
            <tr>
                <th>Game</th>
                <th>Giá</th>
                <th>Thao tác</th>
            </tr>

            <?php foreach ($ds as $g): ?>
            <tr>
                <td>
                    <a href="user.php?action=chitiet&MaGame=<?= $g["MaGame"] ?>">
                        <?= HienThi($g["TenGame"]) ?>
                    </a>
                </td>

                <td><?= DinhDangTien($g["Gia"]) ?></td>

                <td>
                    <a class="Nut"
                       href="user.php?action=yeuthich&giohang=<?= $g["MaGame"] ?>">
                        Thêm vào giỏ
                    </a>

                    <a class="Nut NutDo"
                       href="user.php?action=yeuthich&xoa=<?= $g["MaGame"] ?>">
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


<?php elseif ($trang == "giohang"): ?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Giỏ hàng</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="Thanh">
    <b class="Logo">GalaxyGame</b>
    <a href="user.php?action=cuahang">Cửa hàng</a>
    <a href="user.php?action=thuvien">Thư viện</a>
    <a href="user.php?action=taikhoan">Tài khoản</a>
</div>

<div class="NoiDung">

    <div class="Khung">

        <h2>Giỏ hàng</h2>

        <table class="Bang">
            <tr>
                <th>Ảnh</th>
                <th>Game</th>
                <th>Giá</th>
                <th>Xóa</th>
            </tr>

            <?php foreach ($items as $i): ?>

            <tr>

                <td>
                    <a href="user.php?action=chitiet&MaGame=<?= $i["MaGame"] ?>">
                        <?= HienThi($i["TenGame"]) ?>
                    </a>
                </td>

                <td><?= DinhDangTien($i["Gia"]) ?></td>

                <td>
                    <a class="Nut NutDo"
                       href="user.php?action=giohang&xoa=<?= $i["MaGame"] ?>">
                        Xóa
                    </a>
                </td>
            </tr>

            <?php endforeach; ?>

        </table>

        <h3>Tổng: <?= DinhDangTien($tong) ?></h3>

        <?php if ($items): ?>
            <a class="Nut" href="user.php?action=thanhtoan">
                Thanh toán
            </a>
        <?php endif; ?>

    </div>

</div>

</body>
</html>


<?php elseif ($trang == "taikhoan"): ?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Tài khoản</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="Thanh">
    <b class="Logo">GalaxyGame</b>
    <a href="user.php?action=trangchu">Trang chủ</a>
    <a href="user.php?action=cuahang">Cửa hàng</a>
    <a href="user.php?action=thuvien">Thư viện</a>
    <a href="user.php?action=giohang">Giỏ hàng</a>
    <a href="user.php?action=naptien">Nạp tiền</a>
    <a href="user.php?action=giaodich">Lịch sử ví</a>
    <a href="user.php?action=dangxuat">Đăng xuất</a>
</div>

<div class="NoiDung">

    <div class="Khung">

        <h2>Tài khoản</h2>

        <?php if ($msg) ThongBao("thanhcong", $msg); ?>
        <?php if ($loi) ThongBao("loi", $loi); ?>

        <p>
            Vai trò:
            <?= HienThi($tk["VaiTro"]) ?>
        </p>

        <p>
            Số dư ví:
            <b><?= DinhDangTien($tk["SoDu"]) ?></b>
        </p>

        <form method="post" enctype="multipart/form-data">

            <input class="O"
                   name="HoTen"
                   value="<?= HienThi($tk["HoTen"]) ?>"
                   placeholder="Họ tên">

            <input class="O"
                   name="Email"
                   value="<?= HienThi($tk["Email"]) ?>"
                   placeholder="Email">

            <input class="O"
                   type="file"
                   name="AnhDaiDien">

            <button class="Nut" name="capnhat">
                Lưu
            </button>

        </form>

    </div>

</div>

</body>
</html>


<?php elseif ($trang == "naptien"): ?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nạp tiền</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="Thanh">
    <b class="Logo">GalaxyGame</b>
    <a href="user.php?action=taikhoan">Tài khoản</a>
    <a href="user.php?action=giaodich">Lịch sử ví</a>
</div>

<div class="NoiDung">

    <div class="Khung">

        <h2>Nạp tiền</h2>

        <p>
            Số dư:
            <b><?= DinhDangTien($vi["SoDu"]) ?></b>
        </p>

        <?php if ($msg) ThongBao("thanhcong", $msg); ?>
        <?php if ($loi) ThongBao("loi", $loi); ?>

        <form method="post">

            <input class="O"
                   type="number"
                   name="SoTien"
                   placeholder="Số tiền">

            <button class="Nut" name="naptien">
                Nạp tiền
            </button>

        </form>

    </div>

</div>

</body>
</html>


<?php elseif ($trang == "giaodich"): ?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lịch sử ví</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="Thanh">
    <b class="Logo">GalaxyGame</b>
    <a href="user.php?action=taikhoan">Tài khoản</a>
    <a href="user.php?action=naptien">Nạp tiền</a>
</div>

<div class="NoiDung">

    <div class="Khung">

        <h2>Lịch sử giao dịch ví</h2>

        <table class="Bang">
            <tr>
                <th>Loại</th>
                <th>Số tiền</th>
                <th>Nội dung</th>
                <th>Ngày</th>
            </tr>

            <?php foreach ($ds as $d): ?>

            <tr>
                <td><?= HienThi($d["LoaiGiaoDich"]) ?></td>
                <td><?= DinhDangTien($d["SoTien"]) ?></td>
                <td><?= HienThi($d["NoiDung"]) ?></td>
                <td><?= HienThi($d["NgayGiaoDich"]) ?></td>
            </tr>

            <?php endforeach; ?>

        </table>

    </div>

</div>

</body>
</html>


<?php elseif ($trang == "thanhtoan"): ?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Thanh toán</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="Thanh">
    <b class="Logo">GalaxyGame</b>
    <a href="user.php?action=giohang">Giỏ hàng</a>
    <a href="user.php?action=taikhoan">Tài khoản</a>
</div>

<div class="NoiDung">

    <div class="Khung">

        <h2>Thanh toán</h2>

        <?php if ($msg) ThongBao("thanhcong", $msg); ?>
        <?php if ($loi) ThongBao("loi", $loi); ?>

        <p>
            Tổng tiền:
            <b><?= DinhDangTien($tong) ?></b>
        </p>

        <?php if ($tong > 0): ?>

        <form method="post">
            <button class="Nut" name="thanhtoan">
                Xác nhận thanh toán
            </button>
        </form>

        <?php else: ?>

        <p>Giỏ hàng trống.</p>

        <?php endif; ?>

    </div>

</div>

</body>
</html>


<?php elseif ($trang == "thuvien"): ?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Thư viện</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="Thanh">
    <b class="Logo">GalaxyGame</b>
    <a href="user.php?action=cuahang">Cửa hàng</a>
    <a href="user.php?action=thuvien">Thư viện</a>
    <a href="user.php?action=giohang">Giỏ hàng</a>
    <a href="user.php?action=taikhoan">Tài khoản</a>
</div>

<div class="NoiDung">

    <div class="Khung">

        <h2>Thư viện</h2>

        <table class="Bang">
            <tr>
                <th>Game</th>
                <th>Trạng thái</th>
                <th>Ngày kích hoạt</th>
            </tr>

            <?php foreach ($ds as $g): ?>

            <tr>
                <td>
                    <a href="user.php?action=chitiet&MaGame=<?= $g["MaGame"] ?>">
                        <?= HienThi($g["TenGame"]) ?>
                    </a>
                </td>

                <td>
                    <?= HienThi($g["TrangThaiKichHoat"]) ?>
                </td>

                <td>
                    <?= HienThi($g["NgayKichHoat"]) ?>
                </td>
            </tr>

            <?php endforeach; ?>

        </table>

    </div>

</div>

</body>
</html>


<?php elseif ($trang == "nhaphathanh"): ?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nhà phát hành</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="Thanh">
    <b class="Logo">GalaxyGame</b>
    <a href="user.php?action=cuahang">Cửa hàng</a>
    <a href="user.php?action=taikhoan">Tài khoản</a>
</div>

<div class="NoiDung">

    <div class="Khung">

        <h2><?= HienThi($n["TenNhaPhatHanh"]) ?></h2>

        <p>
            Quốc gia:
            <?= HienThi($n["QuocGia"]) ?>
        </p>

        <p>
            Email:
            <?= HienThi($n["Email"]) ?>
        </p>

        <p>
            Website:
            <?= HienThi($n["Website"]) ?>
        </p>

    </div>

    <h3>Game của nhà phát hành</h3>

    <div class="Luoi">

        <?php foreach ($games as $g): ?>

        <div class="Game">
            <div class="GameNoiDung">
                <a href="user.php?action=chitiet&MaGame=<?= $g["MaGame"] ?>">
                    <?= HienThi($g["TenGame"]) ?>
                </a>
            </div>

        </div>

        <?php endforeach; ?>

    </div>

</div>

</body>
</html>

<?php endif; ?>