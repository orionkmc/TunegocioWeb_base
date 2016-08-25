<?php 

class Contact
{
    public function __construct()
    {
        $this->update_pending_contacts();
    }

    function update_pending_contacts()
    {
        global $wpdb;
        date_default_timezone_set('America/Caracas');
        $date = date("Y-m-d H:i:s", time());
        $sql = $wpdb->get_results("SELECT id, date, status FROM  wp_tnw_crm_contact WHERE status IN ('2', '6')", OBJECT);
        foreach ($sql as $key) {
            if ($date >= $key->date && $key->status == 2) {
               $wpdb->get_results("UPDATE wp_tnw_crm_contact SET `status` = '1', `date`= NULL WHERE id = $key->id" );
            }
            elseif ($date >= $key->date && $key->status == 6) {
                $wpdb->get_results("UPDATE wp_tnw_crm_contact SET `status` = '5', `date`= NULL WHERE id = $key->id" );
            }
        }
    }

    public function export_contact()
    {
        global $wpdb;
        $import_contact = $wpdb->get_results( "SELECT u.id, u.user_email, meta_firstname.meta_value AS 'firstname', meta_lastname.meta_value AS 'lastname', u.display_name, u.user_nicename, u.user_registered 
            FROM wp_users AS u 
            LEFT JOIN wp_usermeta AS meta_role ON meta_role.user_id = u.id AND meta_role.meta_key = 'wp_capabilities'
            LEFT JOIN wp_usermeta AS meta_firstname ON meta_firstname.user_id = u.id AND meta_firstname.meta_key = 'first_name' 
            LEFT JOIN wp_usermeta AS meta_lastname ON meta_lastname.user_id = u.id AND meta_lastname.meta_key = 'last_name'", OBJECT);

        foreach ($import_contact as $key) {
            $contacts = $wpdb->get_results(" SELECT id_wp FROM `wp_tnw_crm_contact` WHERE id_wp = $key->id", OBJECT);
            if (empty($contacts)) {
                $wpdb->query("INSERT INTO wp_tnw_crm_contact (name, status, id_wp) VALUES ('$key->user_nicename', '1', '$key->id')");
                $subscriber = $wpdb->get_results('SELECT MAX(id) as id FROM wp_tnw_crm_contact');
                $wpdb->get_results ("INSERT INTO wp_tnw_crm_email (id, email, contact) VALUES ('null', '$key->user_email', '" .$subscriber[0]->id. "')");
                /*$wpdb->query("INSERT INTO wp_tnw_crm_binnacle (  ) VALUES ('')");*/
            }
        }
    }

    public function all()
    {
        global $wpdb;
        $contacts = $wpdb->get_results("SELECT a.name, a.id, b.phone, c.email FROM `wp_tnw_crm_contact` a
            LEFT JOIN `wp_tnw_crm_phone` b ON a.id = b.contact
            LEFT JOIN `wp_tnw_crm_email` c ON a.id = c.contact
            GROUP BY a.id", OBJECT);

        include_once( TNW_PLUGIN_DIR.'view/contacts/all_contacts.php' );
    }

    public function view()
    {
        global $wpdb;
        $menu = array(
            'binacle-panel' => array(
                'title' => 'Comentarios',
                'callback' => 'binacle',
                'status' => 'active',
                'route' => TNW_PLUGIN_DIR. 'view/contacts/binacle.php'
                ),
            'wordpress-panel' => array(
                'title' => 'Wordpress',
                'callback' => 'user_wordpress',
                'status' => '',
                'route' => TNW_PLUGIN_DIR.'view/contacts/user_wordpress.php'
                ),
        );

        $menu = apply_filters( 'tnw_editor_menus', $menu );
        $contacts = $wpdb->get_results("SELECT a.id, a.name, a.id_wp, d.id AS Id_status, d.name AS status, d.icon, d.color
            FROM `wp_tnw_crm_contact` a 
            LEFT JOIN `wp_tnw_crm_status` d ON a.status = d.id 
            WHERE a.id =". $_REQUEST['id'], OBJECT);
        $contact_emails = $wpdb->get_results("SELECT id, email FROM `wp_tnw_crm_email` WHERE contact =". $_REQUEST['id'], OBJECT);
        $contact_phones = $wpdb->get_results("SELECT id, phone FROM `wp_tnw_crm_phone` WHERE contact =". $_REQUEST['id'], OBJECT);
        $all_status = $wpdb->get_results("SELECT * FROM `wp_tnw_crm_status` ", OBJECT);
        date_default_timezone_set('America/caracas');
        include_once( TNW_PLUGIN_DIR.'view/contacts/view_contact.php' );
    }

    public function form_status(){
        global $wpdb;
        global $current_user;

        extract($_POST);
        date_default_timezone_set('America/Caracas');
        $date_time = $date ." ". $hour;
        $date = date("Y-m-d H:i:s", time());
        
        if ( $date_time == " " ) {
            $wpdb->query("UPDATE `wp_tnw_crm_contact` SET `status` = '$status', `date` = NULL WHERE `id` = $contact;");
        }
        else{
            $wpdb->query("UPDATE `wp_tnw_crm_contact` SET `status` = '$status', `date` = '$date_time' WHERE `id` = $contact;");
        }

        if (!empty($comment)) {
            $wpdb->get_results("INSERT INTO {$wpdb->prefix}tnw_crm_comments (id, comment, date, contact, usuario_wp) VALUES ('null', '$comment', '$date', '$contact', '" .$current_user->ID. "')");
        }
    }
}