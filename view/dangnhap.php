<?php
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập hệ thống</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        
    </style>
</head>
<body>
    <div class="KhungDangNhap">
        <h2>ĐĂNG NHẬP ADMIN</h2>
        
        <?php if (!empty($loi)): ?>
            <div class="ThongBao Loi"><?= htmlspecialchars($loi) ?></div>
        <?php endif; ?>

        <form method="post" action="user.php?action=dangnhap">
            <input class="O" name="TenDangNhap" placeholder="Tên đăng nhập" required autocomplete="off">
            <input class="O" type="password" name="MatKhau" placeholder="Mật khẩu" required>
            <button class="Nut">Đăng nhập</button>
        </form>
    </div>
</body>
</html>
