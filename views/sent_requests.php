<!-- filepath: c:\xampp\htdocs\chat_app\chat_app\views\sent_requests.php -->
<div class="container">
    <h2>Yêu cầu kết bạn đã gửi</h2>
    <?php if(empty($sentRequests)): ?>
        <p>Chưa có yêu cầu kết bạn nào được phản hồi.</p>
    <?php else: ?>
        <ul class="sent-request-list">
            <?php foreach($sentRequests as $req): ?>
                <li>
                    Yêu cầu gửi đến <strong><?= htmlspecialchars($req['username']); ?></strong> vào <?= $req['created_at']; ?> - 
                    <?php if($req['status'] == 0): ?>
                        Chờ phản hồi...
                        <!-- Nút thu hồi gọi action withdrawRequest với request_id -->
                        <a href="index.php?action=withdrawRequest&request_id=<?= htmlspecialchars($req['id']); ?>" style="color: red; font-weight: bold; margin-left: 10px;">[Thu hồi]</a>
                    <?php elseif($req['status'] == 1): ?>
                        Đã chấp nhận
                    <?php else: ?>
                        Đã từ chối
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>