<?php

require_once __DIR__ . "/../models/GameModel.php";
require_once __DIR__ . "/../database.php";
KiemTraAdmin();
class GameController
{
    private $model;

    public function __construct()
    {
        $db = new Database();
        $this->model = new GameModel($db->getConnection());
    }

    public function index()
    {
        $tuKhoa = trim($_GET["timkiem"] ?? "");

        if ($tuKhoa != "") {
            $games = $this->model->timKiem($tuKhoa);
        } else {
            $games = $this->model->layDanhSach();
        }

        $theLoais = $this->model->layTheLoai();
        $nhaPhatHanhs = $this->model->layNhaPhatHanh();
        $gameSua = null;
        $loi = "";

        require __DIR__ . "/../view/game.php";
    }

    public function create()
    {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $games = $this->model->layDanhSach();
            $theLoais = $this->model->layTheLoai();
            $nhaPhatHanhs = $this->model->layNhaPhatHanh();
            $gameSua = null;
            $loi = "";

            require __DIR__ . "/../view/game.php";
            return;
        }

        $tenGame = trim($_POST["TenGame"] ?? "");
        $maTheLoai = $_POST["MaTheLoai"] ?? "";
        $maNhaPhatHanh = $_POST["MaNhaPhatHanh"] ?? "";
        $gia = $_POST["Gia"] ?? "";
        $moTa = trim($_POST["MoTa"] ?? "");
        $ngayPhatHanh = $_POST["NgayPhatHanh"] ?? "";

        if ($tenGame == "") {
            $loi = "Tên game không được để trống.";
        } elseif ($maTheLoai == "") {
            $loi = "Vui lòng chọn thể loại.";
        } elseif ($maNhaPhatHanh == "") {
            $loi = "Vui lòng chọn nhà phát hành.";
        } elseif ($gia == "" || $gia < 0) {
            $loi = "Giá game không hợp lệ.";
        }

        if ($loi != "") {
            $games = $this->model->layDanhSach();
            $theLoais = $this->model->layTheLoai();
            $nhaPhatHanhs = $this->model->layNhaPhatHanh();
            $gameSua = null;

            require __DIR__ . "/../view/game.php";
            return;
        }

        $this->model->them(
            $tenGame,
            $maTheLoai,
            $maNhaPhatHanh,
            $gia,
            $moTa,
            $ngayPhatHanh
        );

        header("Location: index.php");
        exit;
    }

    public function update($maGame)
    {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $games = $this->model->layDanhSach();
            $theLoais = $this->model->layTheLoai();
            $nhaPhatHanhs = $this->model->layNhaPhatHanh();
            $gameSua = $this->model->layGame($maGame);
            $loi = "";

            require __DIR__ . "/../view/game.php";
            return;
        }

        $tenGame = trim($_POST["TenGame"] ?? "");
        $maTheLoai = $_POST["MaTheLoai"] ?? "";
        $maNhaPhatHanh = $_POST["MaNhaPhatHanh"] ?? "";
        $gia = $_POST["Gia"] ?? "";
        $moTa = trim($_POST["MoTa"] ?? "");
        $ngayPhatHanh = $_POST["NgayPhatHanh"] ?? "";
        $trangThai = $_POST["TrangThai"] ?? "DangBan";

        if ($tenGame == "") {
            $loi = "Tên game không được để trống.";
        } elseif ($maTheLoai == "") {
            $loi = "Vui lòng chọn thể loại.";
        } elseif ($maNhaPhatHanh == "") {
            $loi = "Vui lòng chọn nhà phát hành.";
        } elseif ($gia == "" || $gia < 0) {
            $loi = "Giá game không hợp lệ.";
        }

        if ($loi != "") {
            $games = $this->model->layDanhSach();
            $theLoais = $this->model->layTheLoai();
            $nhaPhatHanhs = $this->model->layNhaPhatHanh();
            $gameSua = $this->model->layGame($maGame);

            require __DIR__ . "/../view/game.php";
            return;
        }

        $this->model->sua(
            $maGame,
            $tenGame,
            $maTheLoai,
            $maNhaPhatHanh,
            $gia,
            $moTa,
            $ngayPhatHanh,
            $trangThai
        );

        header("Location: index.php");
        exit;
    }

    public function delete($maGame)
    {
        try {
            $this->model->xoa($maGame);
        } catch (PDOException $e) {
            // Không xóa được do có dữ liệu liên quan
        }

        header("Location: index.php");
        exit;
    }
}