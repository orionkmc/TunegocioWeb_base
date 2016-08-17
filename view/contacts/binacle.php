<?php
    global $wpdb;
    $coments = $wpdb->get_results("SELECT a.*, b.name FROM `wp_tnw_crm_comments` a INNER JOIN wp_tnw_crm_contact b ON a.usuario_wp = b.id_wp WHERE contact = ". $_REQUEST['id'] ." ORDER BY a.id desc");
?>
<style>
    a.user {
        color: #d65250;
    }

    .lead-desc, .comments-list
    {
        padding: 10px 15px;
    }

    .comments-list {
        margin: 0;
        margin-bottom: 10px
    }

    .comments-list li 
    {
        background: #FFFFFF;
        padding: 2px;
        border-bottom: 1px solid #666;
        list-style-type: none;
        position: relative;
    }
    .comment
    {
        max-height: 400px;
        overflow: auto;
        background: #fff;
        color: #666;
    }
    .comment-list
    {
        background: #F7F7F7;
        padding: 2px;
        border-radius: 4px;
        border-bottom: 1px solid #eee;
        list-style-type: none;
        color: #737373;
        text-align: center;
        font-size: 0.85em;
        color: #666;
    }
</style>
<ul class="comments-list comment">
    <?php foreach($coments as $coment): ?>
        <li>
            <div>
                <div>
                    <a class="user" href="#"><?= $coment->name ?></a>
                    <span class="date">, <?= date("d-m-Y, g:i:s a", strtotime($coment->date)) ?></span>
                </div>
                <div class="text-justify">
                    <?= $coment->comment ?>
                </div>
            </div>
        </li>
    <?php endforeach ?>
</ul>
<div class="comment-list">
    Total Comentarios <?= count($coments) ?>
</div>