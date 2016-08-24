var page_no=0;

jQuery(document).ready(function(){
    //edicion
    jQuery( document ).on( "click", ".edit", function() {
        email = jQuery( this ).siblings("span").html();
        type  = jQuery( this ).siblings("span").data("type");
        id  = jQuery( this ).siblings("span").data("id");
        
        jQuery( this ).siblings("span").attr("class", "form-inline");
        html = '<input id="input_edit" class="form-control" name="input_edit" value="'+email+'" autofocus>';
        jQuery( this ).siblings("span").html(html);
        jQuery( "input#input_edit" ).focus();
        jQuery( this ).remove();
    });

    jQuery( document ).on( "blur", "input#input_edit", function() {
        value = jQuery( this ).val();
        if (email != value) {
            edit_data_contact(type, value, id)
        };
        html =  '<span data-type="'+ type +'" data-id="'+ id +'">'+ value +'</span>&nbsp'+
                '<a href="#" class="edit" onclick="return false;">'+
                    '<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>'+
                '</a>';
        jQuery( this ).parent('span').parent('span').html( html );
    });

    //valida q el comentario no este vacio, si no esta vacio inserta
    jQuery('#btn_comentario').click(function(){
        textarea_comment = jQuery( "#textarea_comment" ).val();
        if (textarea_comment !== '') {
            html =  '<li>'+
                        '<div>'+
                            '<div>'+
                                '<img src="http://localhost/tunegocioweb/instalaciones_wordpress/wordpress/wp-content/plugins/TunegocioWeb_crm/assets/img/ajax-loader.gif"/>'+
                            '</div>'+
                        '</div>'+
                    '</li>';
            jQuery('#Comments-list').prepend(html);
            contact = jQuery( "#contact_comment" ).val();
            insert_comment(textarea_comment, contact);
            jQuery( "#textarea_comment" ).val('');
        };
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
        jQuery('#kua-mare').html(response);
        /*var json = JSON.parse(response);
        console.log( json );*/
        /*html =  '<div>'+
                    '<div>'+
                        '<a class="user" href="#">'+ json.data[0].name +'</a>'+
                        '<span class="date">, '+ json.data[0].date +'</span>'+
                    '</div>'+
                    '<div class="text-justify">'+
                        json.data[0].comment
                    +'</div>'+
                '</div>';
        jQuery('ul#Comments-list li:first-child').html(html);*/
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
