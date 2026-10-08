<?php

require_once __DIR__ . "/../models/TheLoaiModel.php";
require_once __DIR__ . "/../database.php";
require_once __DIR__ . "/../function.php";

KiemTraAdmin();

class TheLoaiController
{
    private $model;

    public function __construct()
    {
        $database = new Database();
        $this->model = new TheLoaiModel($database->getConnection());
    }

    public function index()
    {
        $theLoais = $this->model->layDanhSach();
        $theLoaiSua = null;
        $loi = "";

        require __DIR__ . "/../view/theloai.php";
    }

    public function create()
    {
        $tenTheLoai = trim($_POST["TenTheLoai"] ?? "");
        $trangThai = $_POST["TrangThai"] ?? "HoatDong";
        $loi = "";

        if ($tenTheLoai == "") {
            $loi = "Tên thể loại không được để trống.";
        }

        if ($loi != "") {
            $theLoais = $this->model->layDanhSach();
            $theLoaiSua = null;

            require __DIR__ . "/../view/theloai.php";
            return;
        }

        $this->model->them($tenTheLoai, $trangThai);

        header("Location: admin.php?action=theloai");
        exit;
    }

    public function update($maTheLoai)
    {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $theLoais = $this->model->layDanhSach();
            $theLoaiSua = $this->model->lay($maTheLoai);
            $loi = "";

            require __DIR__ . "/../view/theloai.php";
            return;
        }

        $tenTheLoai = trim($_POST["TenTheLoai"] ?? "");
        $trangThai = $_POST["TrangThai"] ?? "HoatDong";
        $loi = "";

        if ($tenTheLoai == "") {
            $loi = "Tên thể loại không được để trống.";
        }

        if ($loi != "") {
            $theLoais = $this->model->layDanhSach();
            $theLoaiSua = $this->model->lay($maTheLoai);

            require __DIR__ . "/../view/theloai.php";
            return;
        }

        $this->model->sua(
            $maTheLoai,
            $tenTheLoai,
            $trangThai
        );

        header("Location: admin.php?action=theloai");
        exit;
    }

    public function delete($maTheLoai)
    {
        try {
            $this->model->xoa($maTheLoai);
        } catch (PDOException $e) {
        }

        header("Location: admin.php?action=theloai");
        exit;
    }
}

?>