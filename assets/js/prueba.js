var page_no=0;

jQuery(document).ready(function(){
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

function insert_comment(comment, contact){
    var data = {
        'action': 'insert_comment',
        'comment': comment,
        'contact': contact,
        'page_no': page_no
    };

    jQuery.post("admin-ajax.php", data, function(response) {
        var json = JSON.parse(response);
        console.log(json.data[0].name);
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
