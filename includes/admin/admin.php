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
        //JS datetimepicker
        wp_enqueue_script('tnw_crm_jquery.min', TNW_PLUGIN_URL . 'assets/js/jquery/jquery.min.js');
        wp_enqueue_script('tnw_crm_moment', TNW_PLUGIN_URL . 'assets/js/moment/moment.min.js');
        wp_enqueue_script('tnw_crm_bootstrap_transition', TNW_PLUGIN_URL . 'assets/js/bootstrap/transition.js');
        wp_enqueue_script('tnw_crm_bootstrap_collapse', TNW_PLUGIN_URL . 'assets/js/bootstrap/collapse.js');
        wp_enqueue_script('tnw_crm_bootstrap_js', TNW_PLUGIN_URL . 'assets/js/bootstrap/js/bootstrap.min.js');
        wp_enqueue_script('tnw_crm_bootstrap-datetimepicker', TNW_PLUGIN_URL . 'assets/js/bootstrap-datetimepicker/bootstrap-datetimepicker.js');
        wp_enqueue_script('tnw_crm_datetimepicker_es', TNW_PLUGIN_URL . 'assets/js/bootstrap-datetimepicker/es.js');
        

        //JS
        //wp_enqueue_script('tnw_crm_jquery', '//code.jquery.com/jquery-1.12.3.min.js');
        wp_enqueue_script('tnw_crm_data_tables', TNW_PLUGIN_URL . 'assets/js/jquery.dataTables.min.js');
        wp_enqueue_script('tnw_crm_data_tables_bootstrap', 'https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js');
        wp_enqueue_script('tnw_crm_ajax', TNW_PLUGIN_URL . 'assets/js/prueba.js');

        //CSS
        if ( isset( $_REQUEST['page'] ) && $_REQUEST['page'] == 'contacts' ){
            wp_enqueue_style('tnw_crm_bootstrap', TNW_PLUGIN_URL . 'assets/js/bootstrap/css/bootstrap.min.css');
            wp_enqueue_style('tnw_crm_bootstrap-datetimepicker_css', TNW_PLUGIN_URL . 'assets/js/bootstrap/css/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css');
        }
        
        wp_enqueue_style('tnw_crm_datatables_bootstrap', 'https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css');
        wp_enqueue_style('style', TNW_PLUGIN_URL . 'assets/css/style.css');
    }

    function custom_menu_page(){
        add_menu_page( 'TunegocioWeb', 'TunegocioWeb', 'activate_plugins', 'contacts', array($this, 'contacts'),'dashicons-cloud',4);
    }

    function contacts()
    {
        $contacts = new Contact();
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