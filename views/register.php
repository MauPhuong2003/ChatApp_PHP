<div class="auth-page">
    <div class="auth-container">
        <div class="auth-card">
            <h2>Đăng ký</h2>
            <?php if(isset($error)) : ?>
                <p class="error"><?= htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <form method="post" action="index.php?action=register" enctype="multipart/form-data">
                <label>Tên hiển thị:</label>
                <input type="text" name="username" placeholder="Nhập tên của bạn" required>
                <label>Email:</label>
                <input type="email" name="email" placeholder="Nhập email" required>
                <label>Số điện thoại:</label>
                <input type="tel" name="phone" placeholder="Nhập số điện thoại" required>
                <label>Mật khẩu:</label>
                <input type="password" name="password" placeholder="Nhập mật khẩu" required>
                <label>Xác nhận mật khẩu:</label>
                <input type="password" name="confirm_password" placeholder="Xác nhận mật khẩu" required>
                <label>Avatar:</label>
                <input type="file" name="avatar" accept="image/*">
                <button type="submit" class="auth-btn">Đăng ký</button>
            </form>
            <p class="auth-switch">Đã có tài khoản? <a href="index.php?action=login">Đăng nhập ngay</a></p>
        </div>
    </div>
</div>