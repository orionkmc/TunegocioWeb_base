<?php 

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

final class WPTnwCrmAdmin {
    public function __construct() {
        add_action( 'admin_menu', array($this,'custom_menu_page') );
        add_action( 'admin_enqueue_scripts', array( $this, 'loadScripts') );
    }

    function loadScripts(){
        wp_enqueue_script('tnw_crm_jquery', '//code.jquery.com/jquery-1.12.3.min.js');
        wp_enqueue_script('tnw_crm_data_tables', TNW_PLUGIN_URL . 'assets/js/jquery.dataTables.min.js');
        wp_enqueue_script('tnw_crm_bootstrap', TNW_PLUGIN_URL . 'assets/js/bootstrap/js/bootstrap.min.js');
        wp_enqueue_script('wpce_display_ticket', TNW_PLUGIN_URL . 'assets/js/prueba.js');

        wp_enqueue_style('tnw_crm_bootstrap', TNW_PLUGIN_URL . 'assets/js/bootstrap/css/bootstrap.min.css');
        wp_enqueue_style('tnw_crm_datatables', TNW_PLUGIN_URL . 'assets/css/jquery.dataTables.min.css');
        wp_enqueue_style('style', TNW_PLUGIN_URL . 'assets/css/style.css');
    }

    function custom_menu_page(){
        add_menu_page( 'TunegocioWeb', 'TunegocioWeb', 'activate_plugins', 'contacts', array($this, 'contacts'),'dashicons-cloud',4);
    }

    function contacts()
    {
        $contacts = new Contact($array);
        if (isset($_POST['export_contact'])) {
            $contacts->export_contact();
        }

        if (isset($_POST['form_status'])) {
            $contacts->form_status();
        }

        if(!isset($_GET['id'])){
            $contacts->all();
        }
        
        elseif ( isset($_GET['id']) ) {
            $contacts->view();
        }
    }

}

new WPTnwCrmAdmin();