var page_no=0;

jQuery(document).ready(function(){
    add();
    //alert(display_ticket_data.wpsp_ajax_url);
});

function add(){
    var data = {
        'action': 'add',
        'page_no': page_no
    };

    jQuery.post("admin-ajax.php", data, function(response) {
        jQuery('#kuai').html(response);
    });
}