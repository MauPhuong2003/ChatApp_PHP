<div class="container">
    <h2>Yêu cầu kết bạn nhận được</h2>
    <?php if(empty($requests)): ?>
        <p>Không có yêu cầu kết bạn nào.</p>
    <?php else: ?>
        <ul class="friend-request-list">
            <?php foreach($requests as $req): ?>
                <li>
                    <strong><?php echo htmlspecialchars($req['username']); ?></strong> đã gửi yêu cầu vào <?php echo $req['created_at']; ?>
                    <a href="index.php?action=respondFriendRequest&request_id=<?php echo $req['id']; ?>&response=accept" class="btn-accept">Chấp nhận</a>
                    <a href="index.php?action=respondFriendRequest&request_id=<?php echo $req['id']; ?>&response=reject" class="btn-reject">Từ chối</a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>
