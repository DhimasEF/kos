<?php $this->load->view('user/sidebar'); ?>

<div class="content">
<div class="card">

<h2>Chat Admin</h2>

<div id="chatBox">

<?php if($room): ?>
    <?php foreach($messages as $m): ?>

        <?php if($m->sender_id == $this->session->userdata('id_user')): ?>
            <div class="me"><?= $m->message ?></div>
        <?php else: ?>
            <div class="admin"><?= $m->message ?></div>
        <?php endif; ?>

    <?php endforeach; ?>
<?php else: ?>
    <p style="color:gray">Belum ada percakapan</p>
<?php endif; ?>

</div>

<form id="chatForm">
    <input type="text" name="message" id="messageInput" placeholder="Tulis pesan..." required>
    <button type="submit">Kirim</button>
</form>

</div>
</div>

<style>
#chatBox{
    height:400px;
    overflow-y:auto;
    border:1px solid #ddd;
    padding:10px;
    margin-bottom:10px;
    background:#f9f9f9;
}

.me{
    background:#007bff;
    color:white;
    padding:8px 12px;
    border-radius:10px;
    margin:5px 0;
    text-align:right;
    width:fit-content;
    margin-left:auto;
}

.admin{
    background:#e5e5e5;
    padding:8px 12px;
    border-radius:10px;
    margin:5px 0;
    width:fit-content;
}

#chatForm{
    display:flex;
    gap:10px;
}

#chatForm input{
    flex:1;
    padding:10px;
}

#chatForm button{
    padding:10px 15px;
}
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

$("#chatForm").submit(function(e){
    e.preventDefault();

    $.ajax({
        url:"<?= base_url('user/send_message') ?>",
        type:"POST",
        data:$(this).serialize(),
        dataType:"json",
        success:function(res){

            if(res.status){

                let msg = $("#messageInput").val();

                $("#chatBox").append(
                    '<div class="me">'+msg+'</div>'
                );

                $("#messageInput").val('');
                $("#chatBox").scrollTop($("#chatBox")[0].scrollHeight);

                // reload agar room kebentuk pertama kali
                location.reload();

            }

        }
    });

});

</script>