<script>
    var $j = jQuery.noConflict();
    $j(function () {
        $j('#datetimepicker1').datetimepicker({
            format: 'YYYY-MM-D HH:mm:ss',
            locale: 'es',
            daysOfWeekDisabled: [0, 6]
        });

        $j( document ).on( "click", ".reschedule", function() {
            $j("#reminder").removeClass("hidden");
        });

        $j( document ).on( "click", "#cb_status_1, #cb_status_3, #cb_status_4, #cb_status_5, #cb_status_7, #cb_status_8", function() {
            $j("#reminder").addClass("hidden");
        });
    })
</script>
<div class="panel panel-primary" style="width: 99%; margin-top: 20px;">
    <div class="panel-heading">
        <h4 style="display:inline-block;"><?= $contacts[0]->name ?></h4>
        <span id="icon_status_panel">
            <a href="#" class="btn <?= $contacts[0]->color ?>" data-toggle="modal" data-target="#myModal" style="float: right;">
                <span class="<?= $contacts[0]->icon ?>" aria-hidden="true"></span>
                <strong> <?= strtoupper( $contacts[0]->status )?> </strong>
            </a>
        </span>
    </div>
    <div class="panel-body">
        <span id="result">
            
        </span>
        <div>
            <label for="">Nombre: </label>
            <span>
                <span data-type="contact" data-name="<?= $contacts[0]->name ?>" data-id="<?= $contacts[0]->id ?>"><?= $contacts[0]->name ?></span>
                <a href="#" class="edit" onclick="return false;">
                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                </a>
            </span>
        </div>
        <div>
            <label for="">Email: </label>
            <?php foreach ($contact_emails as $contact_email): ?>
                <span>
                    <span data-type="email" data-name="<?= $contact_email->email ?>" data-id="<?= $contact_email->id ?>"><?= $contact_email->email ?></span>
                    <a href="#" class="edit" onclick="return false;">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>
                </span>
            <?php endforeach ?>
            <span class="form-inline">
                <a href="#" class="plus" onclick="return false;" data-type="email">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </span>
        </div>
        <div>
            <label for="">Telefono: </label>
            <?php foreach ($contact_phones as $contact_phone): ?>
                <span>
                    <span data-type="phone" data-name="<?= $contact_phone->phone ?>" data-id="<?= $contact_phone->id ?>"><?= $contact_phone->phone ?></span>
                    <a href="#" class="edit" onclick="return false;"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                </span>
            <?php endforeach ?>
            <span class="form-inline">
                <a href="#" class="plus" onclick="return false;" data-type="phone">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                </a>
            </span>
        </div>
<br>
        <!-- Nav tabs -->
        <ul class="nav nav-tabs">
            <?php foreach ($menu as $key): ?>
                <li class="<?= $key['status'] ?>"><a href="#<?= $key['callback'] ?>" data-toggle="tab"><?= $key['title'] ?></a></li>
            <?php endforeach ?>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <?php foreach ($menu as $key): ?>
                <div class="tab-pane <?= $key['status'] ?>" id="<?= $key['callback'] ?>">
                    <div class="ticket_filter">
                        <?php include_once( $key['route'] ); ?>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</div>

<!-- ---------------------------------------MODAL--------------------------------------- -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">

                <ul class="status-selection m100">
                    <?php foreach ($statuses_categorys as $category_status): ?>
                        <fieldset>
                            <legend><?= $category_status->name ?></legend>
                            <?php foreach ($all_status as $status): ?>
                                <?php if ( $category_status->id == $status->category): ?>
                                    <label id="label_status_<?= $status->id ?>" for="cb_status_<?= $status->id ?>">
                                        <span id="status_<?= $status->id ?>" class="btn <?= ($contacts[0]->Id_status == $status->id) ? $status->color : 'btn-default'?> reschedule" data-color="<?= $status->color ?>">
                                        <i class="<?= $status->icon ?>"></i> <?= $status->name ?></span>
                                        <input id="cb_status_<?= $status->id ?>" type="radio" name="status" value="<?= $status->id ?>" class="hidden"  <?= ($contacts[0]->Id_status == $status->id) ? 'checked="checked"' : ''?> data-icon="<?= $status->icon ?>" data-status="<?= $status->name ?>" data-color="<?= $status->color ?>">
                                    </label>
                                <?php endif ?>
                            <?php endforeach ?>
                        </fieldset>
                        <br>
                    <?php endforeach ?>
                </ul>

                <div id="reminder" class="reminder-block mb10 hidden">
                    <h4>Re-agendado para el: </h4>
                    <input id="datetimepicker1" type="text" class="form-control" name="kuai" value="">
                </div>

                <hr class="m50">
                <label for="textarea_comment_modal"> Agregar Comentario </label>
                <textarea id="textarea_comment_modal" placeholder="Registre su actividad o un comentario aqui…" class="form-control" name="comment"></textarea>
                <input type="hidden" value="id" name="">
            </div>
            <div class="modal-footer">
                <input id="status_contact" type="hidden" name="status" value="<?= $contacts[0]->Id_status ?>">
                <input id="id_contact" type="hidden" name="id" value="<?= $contacts[0]->id ?>">
                <input id="submit_modal" type="submit" value="Guardar" class="btn btn-primary btn-block">
            </div>
        </div>
    </div>
</div>