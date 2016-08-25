<?php 
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

final class TunegocioWebAjax {

    function insert_comment(){
        global $wpdb;
        global $current_user;

        date_default_timezone_set('America/Caracas');
        $date = date("Y-m-d H:i:s", time());
        $wpdb->query("INSERT INTO {$wpdb->prefix}tnw_crm_comments (id, comment, date, contact, usuario_wp) VALUES ('null', '". $_POST['comment'] ."', '$date', '". $_POST['contact'] ."', '" .$current_user->ID. "')");

        $coment = $wpdb->get_results("SELECT a.date, a.comment, b.name FROM `wp_tnw_crm_comments` a INNER JOIN wp_tnw_crm_contact b ON a.usuario_wp = b.id_wp WHERE contact = ". $_POST['contact'] ." ORDER BY a.id desc limit 1");
        echo '{"data":',  json_encode($coment),'}';
        die();
    }

    function edit_data_contact(){
        global $wpdb;
        $wpdb->query("UPDATE wp_tnw_crm_". $_POST['type'] ." SET `". $_POST['type'] ."` = '". $_POST['value'] ."' WHERE `id` = ". $_POST['id'] .";");
        die();
    }

    function update_status(){
        global $wpdb;
        $wpdb->query( "UPDATE wp_tnw_crm_contact SET `status` = '". $_POST['status'] ."' WHERE `id` = ". $_POST['contact'] .";" );
        die();
    }
}