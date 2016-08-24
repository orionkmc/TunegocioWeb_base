<script>
    var $j = jQuery.noConflict();
    $j(function () {
        $j("#example-popover-2").popover({
            html : true,
            placement: 'left',
            template: '<div class="popover-all"> <div class="popover-arrow"></div> <div class="popover-inner"> <h3 class="popover-title">Example</h3> <div class="popover-content"> </div> </div> </div>',
            content: function() {
              return $j("#example-popover-2-content").html();
            },
        });

        $j( document ).on( "click", "#cb_status_2, #cb_status_6", function() {
            html = '<hr class="m50">' +
            '<p class="text-error">¡Nunca pierda un lead! Standby significa Recordatorio.</p>' +
            '<input type="date" name="date" value="">'+
            '<input type="time" name="hour" value="" max="22:30" min="10:00">';
            $j(".reminder").html(html);
        });

        $j( document ).on( "click", "#cb_status_1, #cb_status_3, #cb_status_4, #cb_status_5, #cb_status_7, #cb_status_8", function() {
            $j(".reminder").empty();
        });

        $j('[data-toggle="popover"]').on('hidden.bs.popover', function(){
            $j(".reminder").empty();
        });
    })
</script>
<div class="panel panel-primary" style="width: 99%; margin-top: 20px;">
    <div class="panel-heading">
        <a id="example-popover-2" tabindex="0" class="<?= $contacts[0]->color ?>" role="button" data-toggle="popover" data-trigger="click" style="float: right;">
            <span class="<?= $contacts[0]->icon ?>" aria-hidden="true"></span>
            <strong> <?= strtoupper( $contacts[0]->status )?> </strong>
        </a>
        <a  href="#" class=""></a>
    </div>
    <div class="panel-body">
        <p>
            <div>
                <h3 style="display:inline-block;"><label for="">Nombre: </label></h3> <?= $contacts[0]->name ?>
            </div>
            <div>
                <h3 style="display:inline-block;"><label for="">Email: </label></h3>
                <?php foreach ($contact_emails as $contact_email): ?>
                    <span>
                        <span data-type="email" data-id="<?= $contact_email->id ?>"><?= $contact_email->email ?></span>
                        <a href="#" class="edit" onclick="return false;">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                        </a>
                    </span>
                <?php endforeach ?>
            </div>
            <div>
                <h3 style="display:inline-block;"><label for="">Telefono: </label></h3>
                <?php foreach ($contact_phones as $contact_phone): ?>
                    <span>
                        <span data-type="phone" data-id="<?= $contact_phone->id ?>"><?= $contact_phone->phone ?></span>
                        <a href="#" class="edit" onclick="return false;"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                    </span>
                <?php endforeach ?>
            </div>
            <div id="kua-mare"></div>
        </p>
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
<div id="example-popover-2-content" class="hidden">
    <form action="" method="POST">
        <p class="">Elegir un estatus:</p>
        <div class="btn-group" data-toggle="buttons">
            <?php foreach ($all_status as $status): ?>
                <label id="cb_status_<?= $status->id ?>" class="btn btn-default btn-xs <?= ($status->name == $contacts[0]->status) ? 'active' :'' ?>" for="<?= $status->id ?>">
                    <span class="<?= $status->icon ?>" aria-hidden="true"></span>
                    <input type="radio" name="status" value="<?= $status->id ?>" autocomplete="off" <?= ($status->name == $contacts[0]->status) ? 'checked' :'' ?>> <?= $status->name ?>
                </label>
            <?php endforeach ?>
        </div>
        <div class="reminder" class="reminder-block mb10">
            <?php if($contacts[0]->Id_status == '2' || $contacts[0]->Id_status == '6'): ?>
                <hr class="m50">
                <p class="text-error">¡Nunca pierda un lead! Standby significa Recordatorio.</p>
                <input type="date" name="date" value="<?= date("Y-m-d") ?>" min="<?= date("Y-m-d") ?>">
                <input type="time" name="hour" value="<?= date("H:m") ?>" max="22:30" min="10:00">
            <?php endif ?>
        </div>
        <p>Añadir un comentario sobre este cambio de estatus: </p>
        <span class="muted">(opcional)</span>
        <div class="form-group">
            <textarea class="form-control" name="comment"></textarea>
        </div>
        <input type="hidden" name="contact" value="<?= $contacts[0]->id ?>">
        <input class="btn btn-defaut" type="submit" name="form_status" value="guardar">
    </form>
</div>