<?php

require_once __DIR__ . "/../models/UserModel.php";
require_once __DIR__ . "/../database.php";
require_once __DIR__ . "/../function.php";

class UserController
{
    private $model;

    public function __construct()
    {
        // Đã xóa session_start() tại đây để tránh lỗi trùng lặp với file user.php
        $database = new Database();
        $this->model = new UserModel($database->getConnection());
    }

    private function kiemTra()
    {
        KiemTraDangNhap();
    }

    public function dangNhap()
    {
        $loi = "";

        if (isset($_POST["dangnhap"])) {
            $ten = trim($_POST["TenDangNhap"] ?? "");
            $matKhau = $_POST["MatKhau"] ?? "";

            $tk = $this->model->dangNhap($ten, $matKhau);

            if ($tk) {
                $_SESSION["MaTaiKhoan"] = $tk["MaTaiKhoan"];
                $_SESSION["HoTen"] = $tk["HoTen"];
                $_SESSION["VaiTro"] = $tk["VaiTro"];

                setcookie("TenDangNhapNho", $ten, time() + 86400 * 30);

                if ($tk["VaiTro"] == "admin") {
                    header("Location: admin.php?action=game");
                } else {
                    header("Location: user.php?action=trangchu");
                }

                exit;
            }

            $loi = "Sai tài khoản, mật khẩu hoặc tài khoản bị khóa.";
        }

        $tenNho = $_COOKIE["TenDangNhapNho"] ?? "";
        $trang = "dangnhap";

        require __DIR__ . "/../view/user.php";
    }

    public function dangXuat()
    {
        session_unset();
        session_destroy();

        setcookie("TenDangNhapNho", "", time() - 3600);

        header("Location: user.php?action=dangnhap");
        exit;
    }

    public function trangChu()
    {
        $this->kiemTra();

        $games = $this->model->layGameMoi();
        $trang = "trangchu";

        require __DIR__ . "/../view/user.php";
    }

    public function cuaHang()
    {
        $this->kiemTra();

        $tuKhoa = trim($_GET["timkiem"] ?? "");
        $games = $this->model->layDanhSachGame($tuKhoa);

        $trang = "cuahang";

        require __DIR__ . "/../view/user.php";
    }

    public function chiTiet($maGame)
    {
        $this->kiemTra();

        $g = $this->model->layGame($maGame);

        if (!$g) {
            die("Không tìm thấy game");
        }

        $msg = "";

        if (isset($_POST["themgiohang"])) {
            $this->model->themGioHang(
                $_SESSION["MaTaiKhoan"],
                $maGame
            );

            $msg = "Đã thêm vào giỏ hàng.";
        }

        if (isset($_POST["themyeuthich"])) {
            $this->model->themYeuThich(
                $_SESSION["MaTaiKhoan"],
                $maGame
            );

            $msg = "Đã thêm vào danh sách ước.";
        }

        $trang = "chitiet";

        require __DIR__ . "/../view/user.php";
    }

    public function yeuThich()
    {
        $this->kiemTra();

        $maTaiKhoan = $_SESSION["MaTaiKhoan"];

        if (isset($_GET["xoa"])) {
            $this->model->xoaYeuThich(
                $maTaiKhoan,
                (int)$_GET["xoa"]
            );

            header("Location: user.php?action=yeuthich");
            exit;
        }

        if (isset($_GET["giohang"])) {
            $this->model->yeuThichSangGioHang(
                $maTaiKhoan,
                (int)$_GET["giohang"]
            );

            header("Location: user.php?action=yeuthich");
            exit;
        }

        $ds = $this->model->layYeuThich($maTaiKhoan);
        $trang = "yeuthich";

        require __DIR__ . "/../view/user.php";
    }

    public function gioHang()
    {
        $this->kiemTra();

        $cart = $this->model->layGioHang(
            $_SESSION["MaTaiKhoan"]
        );

        if (isset($_GET["xoa"])) {
            $this->model->xoaGioHang(
                $cart["MaGioHang"],
                (int)$_GET["xoa"]
            );

            header("Location: user.php?action=giohang");
            exit;
        }

        $items = $cart["items"];
        $tong = $cart["tong"];

        $trang = "giohang";

        require __DIR__ . "/../view/user.php";
    }

    public function taiKhoan()
    {
        $this->kiemTra();

        $id = $_SESSION["MaTaiKhoan"];
        $tk = $this->model->layTaiKhoan($id);

        $msg = "";
        $loi = "";

        if (isset($_POST["capnhat"])) {
            $ho = trim($_POST["HoTen"] ?? "");
            $email = trim($_POST["Email"] ?? "");

            if ($ho == "") {
                $loi = "Họ tên không được để trống.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $loi = "Email không hợp lệ.";
            }

            if (!$loi) {
                $this->model->capNhatTaiKhoan(
                    $id,
                    $ho,
                    $email
                );

                $_SESSION["HoTen"] = $ho;
                $tk = $this->model->layTaiKhoan($id);

                $msg = "Cập nhật tài khoản thành công.";
            }
        }

        $trang = "taikhoan";

        require __DIR__ . "/../view/user.php";
    }

    public function napTien()
    {
        $this->kiemTra();

        $loi = "";
        $msg = "";

        if (isset($_POST["naptien"])) {
            $so = (float)($_POST["SoTien"] ?? 0);

            if ($so <= 0) {
                $loi = "Số tiền phải lớn hơn 0.";
            } else {
                try {
                    $this->model->napTien(
                        $_SESSION["MaTaiKhoan"],
                        $so
                    );

                    $msg = "Nạp tiền thành công.";
                } catch (Exception $e) {
                    $loi = $e->getMessage();
                }
            }
        }

        $vi = $this->model->laySoDu(
            $_SESSION["MaTaiKhoan"]
        );

        $trang = "naptien";

        require __DIR__ . "/../view/user.php";
    }

    public function giaoDich()
    {
        $this->kiemTra();

        $ds = $this->model->layGiaoDich(
            $_SESSION["MaTaiKhoan"]
        );

        $trang = "giaodich";

        require __DIR__ . "/../view/user.php";
    }

    public function thanhToan()
    {
        $this->kiemTra();

        $cart = $this->model->layGioHang(
            $_SESSION["MaTaiKhoan"]
        );

        $items = $cart["items"];
        $tong = $cart["tong"];

        $loi = "";
        $msg = "";

        if (isset($_POST["thanhtoan"])) {
            try {
                $this->model->thanhToan(
                    $_SESSION["MaTaiKhoan"]
                );

                $msg = "Thanh toán thành công. Game đang chờ admin kích hoạt.";

                $items = [];
                $tong = 0;
            } catch (Exception $e) {
                $loi = $e->getMessage();
            }
        }

        $trang = "thanhtoan";

        require __DIR__ . "/../view/user.php";
    }

    public function thuVien()
    {
        $this->kiemTra();

        $ds = $this->model->layThuVien(
            $_SESSION["MaTaiKhoan"]
        );

        $trang = "thuvien";

        require __DIR__ . "/../view/user.php";
    }

    public function nhaPhatHanh($maNhaPhatHanh)
    {
        $this->kiemTra();

        $data = $this->model->layNhaPhatHanh(
            $maNhaPhatHanh
        );

        if (!$data) {
            die("Không tìm thấy nhà phát hành");
        }

        $n = $data["nhaPhatHanh"];
        $games = $data["games"];

        $trang = "nhaphathanh";

        require __DIR__ . "/../view/user.php";
    }
}
?>
