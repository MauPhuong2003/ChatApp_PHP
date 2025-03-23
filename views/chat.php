<?php
// views/chat.php

// Hàm chuyển đổi URL thành thẻ liên kết
function linkify($text) {
    // Escape dữ liệu để đảm bảo an toàn trước khi chuyển đổi
    $text = htmlspecialchars($text);
    return preg_replace('~(https?://[^\s]+)~i', '<a href="$1" target="_blank">$1</a>', $text);
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chat</title>
    <link rel="stylesheet" href="styles.css">
    <!-- Sử dụng FontAwesome cho icon nếu cần -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>
<body>
    <!-- Nút quay về dashboard -->
    <div class="chat-back" style="margin: 20px;">
        <a href="index.php?action=dashboard" class="back-arrow" style="text-decoration: none; color: var(--primary); font-size: 18px; display: inline-flex; align-items: center; transition: color 0.3s;">
            <i class="fas fa-arrow-left" style="margin-right: 8px;"></i>
        </a>
    </div>

    <div class="chat-container">
        <!-- Hiển thị tin nhắn -->
        <div class="chat-box" id="chatBox">
            <?php if(!empty($history)): ?>
                <?php foreach($history as $msg): ?>
                    <div class="chat-message <?= ($msg['from_id'] == $_SESSION['user']['id']) ? 'sent' : 'received'; ?>" data-msgid="<?= $msg['id']; ?>">
                        <!-- Dùng linkify để chuyển URL thành thẻ <a> -->
                        <p><?= linkify($msg['message']); ?></p>
                        <span class="time"><?= $msg['sent_at']; ?></span>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p id="noMessages">Không có tin nhắn nào.</p>
            <?php endif; ?>
        </div>

        <!-- Form gửi tin nhắn -->
        <form id="sendMessageForm" method="post" action="index.php?action=sendMessage" class="chat-form">
            <input type="hidden" name="to_id" value="<?= isset($to_id) ? $to_id : ''; ?>">
            <textarea name="message" placeholder="Nhập tin nhắn của bạn..." required></textarea>
            <button type="submit">Gửi</button>
        </form>
    </div>

    <script>
        // Hàm chuyển đổi URL thành thẻ <a> trong JS cho các tin nhắn mới
        function linkify(text) {
            return text.replace(/(https?:\/\/[^\s]+)/g, '<a href="$1" target="_blank">$1</a>');
        }

        // Endpoint lấy tin nhắn mới cho chat cá nhân
        var chatEndpoint = 'index.php?action=fetchChat&other_id=<?= $to_id ?>';

        // Lấy phần tử chatBox
        const chatBox = document.getElementById('chatBox');

        // Biến theo dõi id tin nhắn cuối cùng đã hiển thị
        let lastMessageId = 0;
        document.querySelectorAll('#chatBox .chat-message').forEach(function(msg) {
            let msgId = parseInt(msg.getAttribute('data-msgid'));
            if(msgId > lastMessageId) {
                lastMessageId = msgId;
            }
        });

        // Hàm cuộn khung chat xuống dưới
        function scrollChat() {
            chatBox.scroll({
                top: chatBox.scrollHeight,
                behavior: 'smooth'
            });
        }

        // Hàm thêm tin nhắn mới vào chatBox
        function appendMessages(messages) {
            // Nếu có thông báo "Không có tin nhắn nào", xóa nó
            const noMsgElem = document.getElementById('noMessages');
            if(noMsgElem) {
                noMsgElem.remove();
            }
            messages.forEach(function(message) {
                let div = document.createElement('div');
                let cls = (message.from_id == <?= $_SESSION['user']['id'] ?>) ? 'sent' : 'received';
                div.className = 'chat-message ' + cls;
                // Gán thuộc tính data-msgid để theo dõi tin nhắn mới
                div.setAttribute('data-msgid', message.id);
                div.innerHTML = `<p>${linkify(message.message)}</p><span class="time">${message.sent_at}</span>`;
                chatBox.appendChild(div);
                lastMessageId = message.id;
            });
        }

        // Hàm lấy tin nhắn mới từ server
        function fetchChat() {
            fetch(chatEndpoint)
              .then(res => res.json())
              .then(data => {
                  // Lọc tin nhắn có id > lastMessageId
                  let newMessages = data.filter(message => parseInt(message.id) > lastMessageId);
                  if(newMessages.length) {
                      appendMessages(newMessages);
                      scrollChat();
                  }
              })
              .catch(err => console.error('Error fetching chat:', err));
        }
        setInterval(fetchChat, 3000);

        // Gửi tin nhắn bằng AJAX
        document.getElementById('sendMessageForm').addEventListener('submit', function(e) {
            e.preventDefault();
            fetch(this.action, { method: 'POST', body: new FormData(this) })
              .then(() => {
                  this.querySelector('textarea[name="message"]').value = '';
                  fetchChat();
              })
              .catch(err => console.error('Error sending message:', err));
        });
    </script>
</body>
</html>
