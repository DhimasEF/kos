<?php $this->load->view('admin/sidebar'); ?>

<div class="content">
<div class="card">

<h2>Chat : <?= $user->name ?></h2>

<div id="chatBox">

<?php foreach($messages as $m): ?>

    <?php if($m->sender_id == $this->session->userdata('id_user')): ?>
        <div class="me"><?= $m->message ?></div>
    <?php else: ?>
        <div class="user"><?= $m->message ?></div>
    <?php endif; ?>

<?php endforeach; ?>

</div>

<form id="chatForm">

    <input type="hidden" name="id_chat" value="<?= $id_chat ?>">

    <input type="text" name="message" id="msg" placeholder="Tulis balasan..." required>

    <button type="submit">Kirim</button>

</form>

</div>
</div>


<style>
#chatBox{
    height:450px;
    overflow-y:auto;
    border:1px solid #ddd;
    padding:10px;
    margin-bottom:10px;
    background:#fafafa;
}

.me{
    background:#007bff;
    color:#fff;
    padding:10px;
    border-radius:10px;
    margin:5px 0;
    width:fit-content;
    margin-left:auto;
}

.user{
    background:#e4e4e4;
    padding:10px;
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

function loadChat()
{
    $.ajax({
        url:"<?= base_url('admin/load_chat/'.$id_chat) ?>",
        type:"GET",
        dataType:"json",
        success:function(res){

            let html = '';
            let myid = <?= $this->session->userdata('id_user') ?>;

            res.forEach(function(r){

                if(r.sender_id == myid){
                    html += '<div class="me">'+r.message+'</div>';
                }else{
                    html += '<div class="user">'+r.message+'</div>';
                }

            });

            $("#chatBox").html(html);
            $("#chatBox").scrollTop($("#chatBox")[0].scrollHeight);
        }
    });
}

$("#chatForm").submit(function(e){

    e.preventDefault();

    $.ajax({
        url:"<?= base_url('admin/send_message') ?>",
        type:"POST",
        data:$(this).serialize(),
        dataType:"json",
        success:function(res){

            if(res.status){
                $("#msg").val('');
                loadChat();
            }

        }
    });

});

setInterval(loadChat,2000);

loadChat();

</script>