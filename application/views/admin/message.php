<?php $this->load->view('admin/sidebar'); ?>

<div class="content">

    <div class="chat-wrapper">

        <!-- HEADER -->
        <div class="chat-header">
            <div>
                <h2>
                    <i class="fa fa-envelope"></i>
                    Chat Room
                </h2>

                <p>
                    Daftar percakapan pengguna yang masuk ke admin.
                </p>
            </div>

            <div class="chat-status">
                <span class="dot"></span>
                Online
            </div>
        </div>

        <!-- ROOM CARD -->
        <div class="room-card">
            <div id="roomList"></div>
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

.room-card{
    background:#fff;
    border-radius:20px;
    overflow:hidden;
    box-shadow:0 5px 25px rgba(0,0,0,0.08);
}

.room{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:18px;
    padding:18px 20px;
    border-bottom:1px solid #eee;
    text-decoration:none;
    color:#222;
    transition:.3s;
}

.room:last-child{
    border-bottom:none;
}

.room:hover{
    background:#f8fbff;
}

.room-left{
    display:flex;
    align-items:center;
    gap:15px;
    min-width:0;
}

.room-avatar{
    width:52px;
    height:52px;
    border-radius:16px;
    overflow:hidden;
    flex-shrink:0;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
    background:#f5f7fb;
}

.room-avatar img{
    width:100%;
    height:100%;
    object-fit:cover;
    display:block;
}

.room-info{
    min-width:0;
}

.room-info h3{
    margin:0;
    font-size:17px;
    color:#222;
}

.room-info p{
    margin:5px 0 0;
    color:#777;
    font-size:13px;
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
    max-width:520px;
}

.room-right{
    display:flex;
    align-items:center;
    gap:12px;
    flex-shrink:0;
}

.room-time{
    color:#999;
    font-size:12px;
    white-space:nowrap;
}

.badge{
    background:#dc3545;
    color:#fff;
    min-width:24px;
    height:24px;
    padding:0 7px;
    border-radius:999px;
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:12px;
    font-weight:bold;
}

.empty-chat{
    padding:60px 30px;
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

@media(max-width:768px){
    .chat-header{
        flex-direction:column;
        align-items:flex-start;
        gap:15px;
    }

    .room{
        align-items:flex-start;
    }

    .room-info p{
        max-width:220px;
    }

    .room-right{
        flex-direction:column;
        align-items:flex-end;
    }
}
</style>

<script src="<?= base_url('assets/resources/script.js') ?>"></script>

<script>
let lastRoomKey = '';

function escapeHtml(text){
    return $('<div>').text(text ?? '').html();
}

function emptyRoomsHtml(){
    return `
        <div class="empty-chat">
            <i class="fa fa-comment-slash"></i>
            <h3>Belum Ada Chat Masuk</h3>
            <p>Pesan dari pengguna akan tampil di sini.</p>
        </div>
    `;
}

function formatRoomTime(time){
    if(!time){
        return '';
    }

    return escapeHtml(time);
}

function getRoomKey(rooms){
    if(rooms.length <= 0){
        return 'empty';
    }

    return JSON.stringify(rooms.map(function(r){
        return [
            r.id_chat,
            r.id_user,
            r.last_message,
            r.last_time,
            r.unread
        ];
    }));
}

function renderRooms(rooms){
    let html = '';

    if(rooms.length <= 0){
        return emptyRoomsHtml();
    }

    rooms.forEach(function(r){
        const name = escapeHtml(r.name || 'User');
        const lastMessage = escapeHtml(r.last_message || 'Belum ada pesan');
        const lastTime = formatRoomTime(r.last_time);
        const unread = parseInt(r.unread || 0);
        const defaultPhoto = "<?= base_url('assets/img/default.png') ?>";
        const profilePhoto = r.profil_picture
            ? "<?= base_url('assets/uploads/profile/') ?>" + r.profil_picture
            : defaultPhoto;

        html += `
            <a href="<?= base_url('admin/chat/') ?>${r.id_user}" class="room">

                <div class="room-left">
                    <div class="room-avatar">
                        <img src="${profilePhoto}" alt="${name}">
                    </div>

                    <div class="room-info">
                        <h3>${name}</h3>
                        <p>${lastMessage}</p>
                    </div>
                </div>

                <div class="room-right">
                    ${lastTime ? `<span class="room-time">${lastTime}</span>` : ''}
                    ${unread > 0 ? `<span class="badge">${unread}</span>` : ''}
                </div>

            </a>
        `;
    });

    return html;
}

function loadRooms(){
    $.ajax({
        url: "<?= base_url('admin/load_rooms') ?>",
        type: "GET",
        dataType: "json",

        success: function(res){
            const newKey = getRoomKey(res);

            if(newKey === lastRoomKey){
                return;
            }

            lastRoomKey = newKey;
            $('#roomList').html(renderRooms(res));
        }
    });
}

loadRooms();
setInterval(loadRooms, 2000);
</script>