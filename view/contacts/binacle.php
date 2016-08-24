<?php
    global $wpdb;
    $coments = $wpdb->get_results("SELECT a.*, b.name FROM `wp_tnw_crm_comments` a INNER JOIN wp_tnw_crm_contact b ON a.usuario_wp = b.id_wp WHERE contact = ". $_REQUEST['id'] ." ORDER BY a.id desc");
?>
<br>
<div class="row">
    <div class="col-md-12">
        <p>
            <label for="textarea_comment"> Agregar Comentario </label>
            <textarea name="comment" id="textarea_comment" class="form-control"></textarea>
        </p>
        <input id="contact_comment" type="hidden" name="contact" value="<?= $contacts[0]->id ?>">
        <input type="submit" id="btn_comentario" class="btn btn-primary btn-block" name="form_status" value="Guardar comentario">
    </div>
</div>
<br>
<ul id="Comments-list" class="comments-list comment">
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

