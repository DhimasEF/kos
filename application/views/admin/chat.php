<?php $this->load->view('admin/sidebar'); ?>

<div class="content">
    <div class="chat-wrapper">

        <!-- HEADER -->
        <div class="chat-header">
            <div>
                <h2>
                    <i class="fa fa-comments"></i>
                    Chat: <?= $users->name ?>
                </h2>

                <p>
                    Balas percakapan dari pengguna terkait booking, pembayaran, atau informasi kamar.
                </p>
            </div>

            <div class="header-actions">
                <div class="chat-status">
                    <span class="dot"></span>
                    Online
                </div>

                <a href="<?= base_url('admin/message') ?>" class="btn-back">
                    <i class="fa fa-arrow-left"></i>
                    Kembali
                </a>
            </div>
        </div>

        <!-- CHAT CARD -->
        <div class="chat-card">

            <div id="chatBox">

                <?php if (!empty($messages)): ?>

                    <?php foreach ($messages as $m): ?>

                        <?php if ($m->sender_id == $this->session->userdata('id_user')): ?>

                            <div class="msg-wrap me-wrap">
                                <div class="msg me">
                                    <?= nl2br(htmlspecialchars($m->message, ENT_QUOTES, 'UTF-8')) ?>
                                </div>

                                <small>
                                    Admin • <?= !empty($m->sent_at) ? date('d M Y H:i', strtotime($m->sent_at)) : '-' ?>
                                </small>
                            </div>

                        <?php else: ?>

                            <div class="msg-wrap user-wrap">
                                <div class="msg user-msg">
                                    <?= nl2br(htmlspecialchars($m->message, ENT_QUOTES, 'UTF-8')) ?>
                                </div>

                                <small>
                                    <?= $users->name ?> • <?= !empty($m->sent_at) ? date('d M Y H:i', strtotime($m->sent_at)) : '-' ?>
                                </small>
                            </div>

                        <?php endif; ?>

                    <?php endforeach; ?>

                <?php else: ?>

                    <div class="empty-chat">
                        <i class="fa fa-comment-slash"></i>
                        <h3>Belum Ada Percakapan</h3>
                        <p>Belum ada pesan dari pengguna ini.</p>
                    </div>

                <?php endif; ?>

            </div>

            <form id="chatForm">
                <input type="hidden" name="id_chat" value="<?= $id_chat ?>">

                <div class="input-wrap">
                    <input
                        type="text"
                        name="message"
                        id="messageInput"
                        placeholder="Tulis balasan..."
                        autocomplete="off"
                        required>

                    <button type="submit">
                        <i class="fa fa-paper-plane"></i>
                    </button>
                </div>
            </form>

        </div>

    </div>
</div>

<style>
.chat-wrapper{
    display:flex;
    flex-direction:column;
    gap:5px;
}

.chat-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.chat-header h2{
    margin:20px 0 0 0;
    font-size:28px;
}

.chat-header p{
    color:#777;
}

.header-actions{
    display:flex;
    align-items:center;
    gap:12px;
}

.chat-status{
    background:#fff;
    padding:10px 16px;
    border-radius:14px;
    box-shadow:0 5px 20px rgba(0,0,0,0.08);
    display:flex;
    align-items:center;
    gap:10px;
    font-weight:600;
}

.dot{
    width:10px;
    height:10px;
    border-radius:50%;
    background:#28a745;
}

.btn-back{
    background:#007bff;
    color:#fff;
    padding:12px 16px;
    border-radius:12px;
    text-decoration:none;
    font-weight:bold;
    transition:.3s;
}

.btn-back:hover{
    transform:translateY(-2px);
}

.chat-card{
    background:#fff;
    border-radius:20px;
    overflow:hidden;
    box-shadow:0 5px 25px rgba(0,0,0,0.08);
}

#chatBox{
    height:350px;
    overflow-y:auto;
    padding:20px;
    background:linear-gradient(to bottom,#f8fbff,#f4f6fb);
}

.msg-wrap{
    display:flex;
    flex-direction:column;
    margin-bottom:18px;
}

.me-wrap{
    align-items:flex-end;
}

.user-wrap{
    align-items:flex-start;
}

.msg{
    max-width:75%;
    padding:14px 18px;
    border-radius:18px;
    font-size:15px;
    line-height:1.5;
    word-break:break-word;
    box-shadow:0 4px 15px rgba(0,0,0,0.05);
}

.me{
    background:linear-gradient(135deg,#007bff,#0056d2);
    color:#fff;
    border-bottom-right-radius:5px;
}

.user-msg{
    background:#fff;
    color:#333;
    border:1px solid #eee;
    border-bottom-left-radius:5px;
}

.msg-wrap small{
    margin-top:5px;
    color:#888;
    font-size:12px;
}

.empty-chat{
    height:100%;
    display:flex;
    flex-direction:column;
    justify-content:center;
    align-items:center;
    text-align:center;
    color:#888;
}

.empty-chat i{
    font-size:60px;
    margin-bottom:15px;
    color:#ccc;
}

.empty-chat h3{
    margin:0;
    color:#555;
}

.empty-chat p{
    margin-top:8px;
}

#chatForm{
    background:#fff;
    padding:15px;
    border-top:1px solid #eee;
}

.input-wrap{
    display:flex;
    align-items:center;
    gap:15px;
}

#messageInput{
    flex:1;
    border:none;
    background:#f5f7fb;
    padding:16px 18px;
    border-radius:14px;
    outline:none;
    font-size:15px;
    transition:.3s;
}

#messageInput:focus{
    background:#eef4ff;
    box-shadow:0 0 0 4px rgba(0,123,255,0.08);
}

#chatForm button{
    width:55px;
    height:55px;
    border:none;
    border-radius:16px;
    cursor:pointer;
    color:#fff;
    font-size:18px;
    background:linear-gradient(135deg,#007bff,#0056d2);
    transition:.3s;
}

#chatForm button:hover{
    transform:translateY(-2px) scale(1.03);
}

#chatForm button:disabled{
    opacity:.7;
    cursor:not-allowed;
}

#chatBox::-webkit-scrollbar{
    width:7px;
}

#chatBox::-webkit-scrollbar-thumb{
    background:#cfd8e3;
    border-radius:20px;
}

@media(max-width:768px){
    .chat-header{
        flex-direction:column;
        align-items:flex-start;
        gap:15px;
    }

    .header-actions{
        width:100%;
        flex-direction:column;
        align-items:stretch;
    }

    .chat-status,
    .btn-back{
        justify-content:center;
        text-align:center;
    }

    #chatBox{
        height:420px;
        padding:18px;
    }

    .msg{
        max-width:90%;
    }
}
</style>

<script src="<?= base_url('assets/resources/script.js') ?>"></script>

<script>
let lastMessageKey = '';
let forceScrollBottom = true;

function escapeHtml(text){
    return $('<div>').text(text ?? '').html();
}

function formatMessage(text){
    return escapeHtml(text).replace(/\n/g, '<br>');
}

function isNearBottom(){
    const chatBox = $('#chatBox')[0];
    const distance = chatBox.scrollHeight - chatBox.scrollTop - chatBox.clientHeight;

    return distance < 80;
}

function scrollToBottom(){
    const chatBox = $('#chatBox')[0];
    chatBox.scrollTop = chatBox.scrollHeight;
}

function emptyChatHtml(){
    return `
        <div class="empty-chat">
            <i class="fa fa-comment-slash"></i>
            <h3>Belum Ada Percakapan</h3>
            <p>Belum ada pesan dari pengguna ini.</p>
        </div>
    `;
}

function renderChat(messages){
    let html = '';
    let myid = <?= (int) $this->session->userdata('id_user') ?>;
    let userName = <?= json_encode($users->name) ?>;

    if(messages.length <= 0){
        return emptyChatHtml();
    }

    messages.forEach(function(r){
        const message = formatMessage(r.message);
        const time = escapeHtml(r.sent_at ?? '-');

        if(parseInt(r.sender_id) === myid){
            html += `
                <div class="msg-wrap me-wrap">
                    <div class="msg me">${message}</div>
                    <small>Admin • ${time}</small>
                </div>
            `;
        }else{
            html += `
                <div class="msg-wrap user-wrap">
                    <div class="msg user-msg">${message}</div>
                    <small>${escapeHtml(userName)} • ${time}</small>
                </div>
            `;
        }
    });

    return html;
}

function getMessageKey(messages){
    if(messages.length <= 0){
        return 'empty';
    }

    const last = messages[messages.length - 1];

    return messages.length + '-' + last.id_message + '-' + last.sent_at;
}

function loadChat(){
    const shouldStayBottom = forceScrollBottom || isNearBottom();

    $.ajax({
        url: "<?= base_url('admin/load_chat/'.$id_chat) ?>",
        type: "GET",
        dataType: "json",

        success: function(res){
            const newKey = getMessageKey(res);

            if(newKey === lastMessageKey){
                forceScrollBottom = false;
                return;
            }

            lastMessageKey = newKey;

            $('#chatBox').html(renderChat(res));

            if(shouldStayBottom){
                scrollToBottom();
            }

            forceScrollBottom = false;
        }
    });
}

$('#chatForm').submit(function(e){
    e.preventDefault();

    const input = $('#messageInput');
    const submitButton = $('#chatForm button');

    if(input.val().trim() === ''){
        return;
    }

    submitButton.prop('disabled', true);
    forceScrollBottom = true;

    $.ajax({
        url: "<?= base_url('admin/send_message') ?>",
        type: "POST",
        data: $(this).serialize(),
        dataType: "json",

        success: function(res){
            if(res.status){
                input.val('');
                loadChat();
            }
        },

        complete: function(){
            submitButton.prop('disabled', false);
            input.focus();
        }
    });
});

$(document).ready(function(){
    scrollToBottom();
    loadChat();
    setInterval(loadChat, 2000);
});
</script>