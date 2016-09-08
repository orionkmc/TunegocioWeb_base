var page_no=0;
var $k = jQuery.noConflict();

$k(document).ready(function(){
    //convierte los datos en input para editar
    $k( document ).on( "click", ".edit", function() {
        email = $k( this ).siblings("span").html();
        type  = $k( this ).siblings("span").data("type");
        id    = $k( this ).siblings("span").data("id");
        name  = $k( this ).siblings("span").data("name");
        
        $k( this ).siblings("span").attr("class", "form-inline");
        html = '<input id="input_edit" class="form-control" name="input_edit" value="'+email+'" data-name="'+ name +'" autofocus>';
        $k( this ).siblings("span").html(html);
        $k( "input#input_edit" ).focus();
        $k( this ).remove();
    });

    //edita de campos telefono y email. Convierte el input en datos planos
    $k( document ).on( "keyup", "input#input_edit", function(e) {
        if(e.keyCode == 13)
        {
            value = $k( this ).val();
            if (email != value) {
                edit_data_contact(type, value, id)
            };
            html =  '<span data-type="'+ type +'" data-id="'+ id +'">'+ value +'</span>&nbsp'+
                    '<a href="#" class="edit" onclick="return false;">'+
                        '<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>'+
                    '</a>';
            $k( this ).parent('span').parent('span').html( html );
        }
    });

    //convierte los datos de input a datos planos
    $k( document ).on( "blur", "input#input_edit", function() {
        value = $k( this ).data("name");
        html =  '<span data-type="'+ type +'" data-name="'+ value +'"data-id="'+ id +'">'+ value +'</span>&nbsp'+
                '<a href="#" class="edit" onclick="return false;">'+
                    '<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>'+
                '</a>';
        $k( this ).parent('span').parent('span').html( html );
    });

    //valida q el comentario no este vacio, si no esta vacio inserta
    $k('#btn_comentario').click(function(){
        textarea_comment = $k( "#textarea_comment" ).val();
        if (textarea_comment !== '') {
            html =  '<li>'+
                        '<div>'+
                            '<div>'+
                                '<img src="http://localhost/tunegocioweb/instalaciones_wordpress/wordpress/wp-content/plugins/TunegocioWeb_crm/assets/img/ajax-loader.gif"/>'+
                            '</div>'+
                        '</div>'+
                    '</li>';
            $k('#Comments-list').prepend(html);
            contact = $k( "#contact_comment" ).val();
            insert_comment(textarea_comment, contact);
            $k( "#textarea_comment" ).val('');
        };
    });

    //cambia los colores de estatus en la modal
    $k( document ).on( "click", "span.btn", function() {
        var color = $k( this ).data("color");
        $k( "span.btn" ).attr("class", "btn btn-default reschedule");
        $k( this ).attr("class", "btn "+color);
    });

    //inserta y limpia datos de modal. Cierra modal y actualiza datos
    $k( document ).on( "click", "#submit_modal", function() {
        var textarea_comment_modal = $k('#textarea_comment_modal').val();
        var id_status_new          = $k('input:radio[name=status]:checked').attr("id");
        var status_new             = $k('input:radio[name=status]:checked').val();

        var status                 = $k('#status_contact').val();
        var contact                = $k('#id_contact').val();

        if (status != status_new) {
            var date               = $k('#datetimepicker1').val();
            var status_color       = $k('#'+ id_status_new).data("color");
            var status_icon        = $k('#'+ id_status_new).data("icon");
            var status_status      = $k('#'+ id_status_new).data("status");
            $k('#status_contact').attr("value", status_new );

            html = '<a href="#" class="btn '+ status_color +'" data-toggle="modal" data-target="#myModal" style="float: right;">'+
                        '<span class="'+ status_icon +'" aria-hidden="true"></span>'+
                        '<strong> '+ status_status +' </strong>'+
                    '</a>';
                    $k('#icon_status_panel').html(html);
            update_status(status_new, contact, date);
        };

        if (textarea_comment_modal !== '') {
            html =  '<li>'+
                        '<div>'+
                            '<div>'+
                                '<img src="http://localhost/tunegocioweb/instalaciones_wordpress/wordpress/wp-content/plugins/TunegocioWeb_crm/assets/img/ajax-loader.gif"/>'+
                            '</div>'+
                        '</div>'+
                    '</li>';
            $k('#Comments-list').prepend(html);
            insert_comment(textarea_comment_modal, contact);
            $k('#textarea_comment_modal').val("");
        }

        $k('#myModal').modal("toggle");
    });

    //boton de mas(+) en campos de formularios para agregar un nuevo registro
    $k( document ).on( "click", ".plus", function() {
        type  = $k( this ).data("type");

        html = '<input id="input_add" class="form-control" name="input_add" value="" data-type="'+ type +'" autofocus>';
        $k( this ).parent("span").html(html);
        $k( "input#input_add" ).focus();
    });

    //inserta nuevo phone o email
    $k( document ).on( "keyup", "input#input_add", function(e) {
        if(e.keyCode == 13)
        {
            value = $k( this ).val();
            type  = $k( this ).data("type");
            contact = $k( "#contact_comment" ).val();

            if (value != '') {
                add_data_contact(type, value, contact)
            };
            htmlplus =  '&nbsp<span class="form-inline">'+
                        '<a href="#" class="plus" onclick="return false;" data-type="'+ type +'">'+
                            '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>'+
                        '</a>'+
                    '</span>';
            $k( "input#input_add" ).parent().parent().append(htmlplus);

            html =  '<span data-type="'+ type +'" data-name="'+ value +'" data-id="">'+ value +'</span>&nbsp'+
                    '<a href="#" class="edit" onclick="return false;">'+
                        '<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>'+
                    '</a>';
            $k( this ).parent('span').removeAttr( "class" );
            $k( this ).parent('span').html( html );
        }
    });

    //convierte el input en boton mas(+)
    $k( document ).on( "blur", "input#input_add", function() {
        value = $k( this ).data("name");
        html =  '<a href="#" class="plus" onclick="return false;">'+
                    '<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>'+
                '</a>';
        $k( this ).parent('span').html( html );
    });
});




function edit_data_contact( type, value, id ){
    var data = {
        'action': 'edit_data_contact',
        'type': type,
        'value': value,
        'id': id
    };
    jQuery.post("admin-ajax.php", data, function(response) {
        html = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
        '<strong>¡Exelente!</strong> El Registro ha sido modificado con Exito.';

        liData ='<div id="result2" class="alert alert-success alert-dismissible" role="alert" style="display:none;">'+
                '</div>';
        $k(liData).appendTo('#result').slideDown(500);

        $k('#result2').html(html).fadeIn(2000);
        //timing the alert box to close after 5 seconds
        window.setTimeout(function () {
            $k(".alert").fadeTo(500, 0).slideUp(500, function () {
                $k(this).remove();
            });
        }, 3000);
    });
}

function add_data_contact(type, value, contact){
    var data = {
        'action': 'add_data_contact',
        'type': type,
        'value': value,
        'contact': contact,
    };

    jQuery.post("admin-ajax.php", data, function(response) {
        html = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
        '<strong>¡Exelente!</strong> El Registro se ha guardado con Exito.';

        liData ='<div id="result2" class="alert alert-success alert-dismissible" role="alert" style="display:none;">'+
                '</div>';
        $k(liData).appendTo('#result').slideDown(500);

        $k('#result2').html(html).fadeIn(2000);
        //timing the alert box to close after 5 seconds
        window.setTimeout(function () {
            $k(".alert").fadeTo(500, 0).slideUp(500, function () {
                $k(this).remove();
            });
        }, 3000);
    });
}

function insert_comment(comment, contact){
    var data = {
        'action': 'insert_comment',
        'comment': comment,
        'contact': contact,
        'page_no': page_no
    };

    jQuery.post("admin-ajax.php", data, function(response) {
        var json = JSON.parse(response);
        html =  '<div>'+
                    '<div>'+
                        '<a class="user" href="#">'+ json.data[0].name +'</a>'+
                        '<span class="date">, '+ json.data[0].date +'</span>'+
                    '</div>'+
                    '<div class="text-justify">'+
                        json.data[0].comment
                    +'</div>'+
                '</div>';
        jQuery('ul#Comments-list li:first-child').html(html);
    });
}

function update_status(status, contact, date){
    var data = {
        'action' : 'update_status',
        'status' : status,
        'contact': contact,
        'date'   : date,
        'page_no': page_no
    };

    jQuery.post("admin-ajax.php", data, function(response) {});
}