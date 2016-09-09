<?php
/**
* Plugin Name: TunegocioWeb crm
* Plugin URI: https://localhost
* Description: CRM
* Version: 1.0.0
* Author: orionkmc
* Author URI: http://orionkmc.com
* License: GPL2
*/

class Tnw_Crm
{
    public function __construct()
    {
        $this->define_constants();
        register_activation_hook( __FILE__, array($this,'installation') );
        $this->include_files();
    }

    function define_constants()
    {
        global $wpdb;

        define( 'TNW_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
        define( 'TNW_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
        define( 'TNW_VERSION', '0.0.1' );
    }

    function installation(){
        include_once( TNW_PLUGIN_DIR.'includes/admin/installation.php' );
    }

    private function include_files()
    {
        if (is_admin()) {
            include_once( TNW_PLUGIN_DIR.'includes/admin/admin.php' );
            include_once( TNW_PLUGIN_DIR.'includes/admin/ajax.php' );
            $ajax = new TunegocioWebAjax();
            add_action( 'wp_ajax_edit_data_contact', array( $ajax, 'edit_data_contact' ) );
            add_action( 'wp_ajax_add_data_contact', array( $ajax, 'add_data_contact' ) );
            add_action( 'wp_ajax_remove_data_contact', array( $ajax, 'remove_data_contact' ) );
            add_action( 'wp_ajax_insert_comment', array( $ajax, 'insert_comment' ) );
            add_action( 'wp_ajax_update_status', array( $ajax, 'update_status' ) );
            include_once( TNW_PLUGIN_DIR.'class/contact.class.php' );
        }
    }
}

new Tnw_Crm();
?>