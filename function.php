<?php

function HienThi($chuoi)
{
    return htmlspecialchars($chuoi ?? "", ENT_QUOTES, "UTF-8");
}

function DinhDangTien($gia)
{
    return number_format((float)$gia, 0, ",", ".") . " VNĐ";
}

function KiemTraDangNhap()
{
    if (!isset($_SESSION["MaTaiKhoan"])) {
        header("Location: user.php?action=dangnhap");
        exit;
    }
}

function KiemTraAdmin()
{
    if (!isset($_SESSION["MaTaiKhoan"]) || $_SESSION["VaiTro"] != "admin") {
        header("Location: user.php?action=dangnhap");
        exit;
    }
}

function TimKiem($tuKhoa)
{
    return "%" . $tuKhoa . "%";
}

function ThongBao($loai, $noiDung)
{
    if ($loai == "thanhcong") {
        $class = "ThanhCong";
    } else {
        $class = "Loi";
    }

    echo '<div class="ThongBao ' . $class . '">' . HienThi($noiDung) . '</div>';
}

?>