<?php

include_once __DIR__ . "/controllers/UserController.php";

$controller = new UserController();

$action = $_GET["action"] ?? "trangchu";

switch ($action):
    case "dangnhap":
        $controller->dangNhap();
        break;

    case "dangxuat":
        $controller->dangXuat();
        break;

    case "trangchu":
        $controller->trangChu();
        break;

    case "cuahang":
        $controller->cuaHang();
        break;

    case "chitiet":
        $maGame = (int)($_GET["MaGame"] ?? 0);
        $controller->chiTiet($maGame);
        break;

    case "yeuthich":
        $controller->yeuThich();
        break;

    case "giohang":
        $controller->gioHang();
        break;

    case "taikhoan":
        $controller->taiKhoan();
        break;

    case "naptien":
        $controller->napTien();
        break;

    case "giaodich":
        $controller->giaoDich();
        break;

    case "thanhtoan":
        $controller->thanhToan();
        break;

    case "thuvien":
        $controller->thuVien();
        break;

    case "nhaphathanh":
        $maNhaPhatHanh = (int)($_GET["MaNhaPhatHanh"] ?? 0);
        $controller->nhaPhatHanh($maNhaPhatHanh);
        break;

    default:
        $controller->trangChu();
        break;
endswitch;