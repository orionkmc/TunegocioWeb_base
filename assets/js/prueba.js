var page_no=0;
var $k = jQuery.noConflict();

$k(document).ready(function(){
    //convierte los datos en input para editar
    $k( document ).on( "click", ".edit", function() {
        email = $k( this ).siblings("span").html();
        type  = $k( this ).siblings("span").data("type");
        id  = $k( this ).siblings("span").data("id");
        
        $k( this ).siblings("span").attr("class", "form-inline");
        html = '<input id="input_edit" class="form-control" name="input_edit" value="'+email+'" autofocus>';
        $k( this ).siblings("span").html(html);
        $k( "input#input_edit" ).focus();
        $k( this ).remove();
    });

    //edita de campos telefono y email. Convierte el input en datos planos
    $k( document ).on( "blur", "input#input_edit", function() {
        value = $k( this ).val();
        if (email != value) {
            edit_data_contact(type, value, id)
        };
        html =  '<span data-type="'+ type +'" data-id="'+ id +'">'+ value +'</span>&nbsp'+
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
        $k( "span.btn" ).attr("class", "btn btn-default");
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
            var status_color       = $k('#'+ id_status_new).data("color");
            var status_icon        = $k('#'+ id_status_new).data("icon");
            var status_status      = $k('#'+ id_status_new).data("status");

            console.log( status_color );
            console.log( status_icon );
            console.log( status_status );
            html = '<a href="#" class="btn '+ status_color +'" data-toggle="modal" data-target="#myModal" style="float: right;">'+
                        '<span class="'+ status_icon +'" aria-hidden="true"></span>'+
                        '<strong> '+ status_status +' </strong>'+
                    '</a>';
                    $k('#icon_status_panel').html(html);
            update_status(status_new, contact);
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
});




function edit_data_contact( type, value, id ){
    var data = {
        'action': 'edit_data_contact',
        'type': type,
        'value': value,
        'id': id
    };
    jQuery.post("admin-ajax.php", data, function(response) {});
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


function update_status(status, contact){
    var data = {
        'action': 'update_status',
        'status': status,
        'contact': contact,
        'page_no': page_no
    };

    jQuery.post("admin-ajax.php", data, function(response) {
        //jQuery('#kua-mare').html(response);
    });
}
