<?php $this->load->view('admin/sidebar'); ?>

<div class="content">
<div class="card">

<h2>Chat Room</h2>

<div id="roomList"></div>

</div>
</div>

<style>
.room{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:15px;
    border-bottom:1px solid #eee;
    text-decoration:none;
    color:#000;
}
.room:hover{
    background:#f8f8f8;
}
.room p{
    margin:3px 0 0;
    color:gray;
    font-size:13px;
}
.badge{
    background:red;
    color:#fff;
    min-width:24px;
    height:24px;
    border-radius:50%;
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:12px;
}
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
function loadRooms()
{
    $.ajax({
        url: "<?= base_url('admin/load_rooms') ?>",
        type: "GET",
        dataType: "json",
        success: function(res){

            let html = '';

            if(res.length == 0){
                html = '<p style="color:gray">Belum ada chat masuk</p>';
            }

            res.forEach(function(r){

                html += `
                <a href="<?= base_url('admin/chat/') ?>${r.id_user}" class="room">

                    <div class="left">
                        <b>${r.name}</b>
                        <p>${r.last_message ? r.last_message : 'Belum ada pesan'}</p>
                    </div>

                    <div class="right">
                        ${r.unread > 0 ? `<span class="badge">${r.unread}</span>` : ''}
                    </div>

                </a>
                `;
            });

            $("#roomList").html(html);
        }
    });
}

loadRooms();
setInterval(loadRooms, 2000);
</script>