<?php
    global $wpdb;
    
    $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}tnw_crm_category_status(
        `id`    int(11) NOT NULL AUTO_INCREMENT,
        `name` varchar(100) COLLATE utf8_spanish_ci,
        PRIMARY KEY (id)
    )   ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci");

    $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}tnw_crm_status(
        `id`    int(11) NOT NULL AUTO_INCREMENT,
        `name` varchar(20) COLLATE utf8_spanish_ci,
        `color` varchar(50) COLLATE utf8_spanish_ci,
        `icon` varchar(50) COLLATE utf8_spanish_ci,
        `category` int(11) NOT NULL COLLATE utf8_spanish_ci,
        PRIMARY KEY (id),
        KEY `status` (`category`)
    )   ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci");

    $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}tnw_crm_contact (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `name` varchar(150) COLLATE utf8_spanish_ci,
        `status` int(11) NOT NULL,
        `date` DATETIME NOT NULL,
        `id_wp` varchar(11) NOT NULL,
        PRIMARY KEY (id),
        KEY `status` (`status`)
        )   ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci");

    $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}tnw_crm_phone(
        `id`    int(11) NOT NULL AUTO_INCREMENT,
        `phone` varchar(100) COLLATE utf8_spanish_ci,
        `contact` int(11) NOT NULL,
        PRIMARY KEY (id),
        KEY `contact` (`contact`)
    )   ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci");

    $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}tnw_crm_email(
        `id`    int(11) NOT NULL AUTO_INCREMENT,
        `email` varchar(100) COLLATE utf8_spanish_ci,
        `contact` int(11) NOT NULL,
        PRIMARY KEY (id),
        KEY `contact` (`contact`)
    )   ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci");

    $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}tnw_crm_binnacle(
        `id`    int(11) NOT NULL AUTO_INCREMENT,
        `incidence` varchar(50) COLLATE utf8_spanish_ci,
        `date`  DATETIME,
        `contact` int(11) NOT NULL,
        PRIMARY KEY (id),
        KEY `contact` (`contact`)
    )   ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci");

    $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix}tnw_crm_comments(
        `id`    int(11) NOT NULL AUTO_INCREMENT,
        `comment` text COLLATE utf8_spanish_ci,
        `date`  DATETIME,
        `contact` int(11) NOT NULL,
        `usuario_wp` int(11) NOT NULL,
        PRIMARY KEY (id),
        KEY `contact` (`contact`)
    )   ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci");

    $wpdb->query("ALTER TABLE {$wpdb->prefix}tnw_crm_status ADD FOREIGN KEY (`category`) REFERENCES {$wpdb->prefix}tnw_crm_category_status(`id`) ON DELETE CASCADE ON UPDATE CASCADE;");
    $wpdb->query("ALTER TABLE {$wpdb->prefix}tnw_crm_contact ADD FOREIGN KEY (`status`) REFERENCES {$wpdb->prefix}tnw_crm_status(`id`) ON DELETE CASCADE ON UPDATE CASCADE");
    $wpdb->query("ALTER TABLE {$wpdb->prefix}tnw_crm_phone ADD FOREIGN KEY (`contact`) REFERENCES {$wpdb->prefix}tnw_crm_contact(`id`) ON DELETE CASCADE ON UPDATE CASCADE");
    $wpdb->query("ALTER TABLE {$wpdb->prefix}tnw_crm_email ADD FOREIGN KEY (`contact`) REFERENCES {$wpdb->prefix}tnw_crm_contact(`id`) ON DELETE CASCADE ON UPDATE CASCADE");
    $wpdb->query("ALTER TABLE {$wpdb->prefix}tnw_crm_binnacle ADD FOREIGN KEY (`contact`) REFERENCES {$wpdb->prefix}tnw_crm_contact(`id`) ON DELETE CASCADE ON UPDATE CASCADE");
    $wpdb->query("ALTER TABLE {$wpdb->prefix}tnw_crm_comments ADD FOREIGN KEY (`contact`) REFERENCES {$wpdb->prefix}tnw_crm_contact(`id`) ON DELETE CASCADE ON UPDATE CASCADE");

    $wpdb->query("INSERT INTO `{$wpdb->prefix}tnw_crm_category_status` (`id`, `name`) VALUES 
        (NULL, 'Potenciales'), 
        (NULL, 'Clientes');");

    $wpdb->query(" INSERT INTO `{$wpdb->prefix}tnw_crm_status` (`id`, `name`, `color`, `icon`, `category`) VALUES
        (1, 'hacer ya!',        'btn-danger',  'glyphicon glyphicon-exclamation-sign', '1'),
        (2, 'pendiente',        'btn-info',    'glyphicon glyphicon-time', '1'),
        (3, 'neutral',          'btn-default', 'glyphicon glyphicon-minus', '1'),
        (4, 'perdido',          'btn-sample',  'glyphicon glyphicon-thumbs-down', '1'),
        (5, 'atender ya!',      'btn-success', 'glyphicon glyphicon-exclamation-sign', '2'),
        (6, 'seguimiento',      'btn-warning', 'glyphicon glyphicon-time', '2'),
        (7, 'cliente feliz',    'btn-default', 'glyphicon glyphicon-thumbs-up', '2'),
        (8, 'cliente perdido',  'btn-sample',  'glyphicon glyphicon-thumbs-down', '2'); ");

    /*CREATE TRIGGER user AFTER INSERT ON wp_users
    FOR EACH ROW 
        BEGIN
            INSERT INTO wp_tnw_crm_contact (name, status, id_wp) VALUES (NEW.user_login,'1', NEW.ID);
            INSERT INTO wp_tnw_crm_email (email, contact) VALUES (NEW.user_email, LAST_INSERT_ID( ));
        END;&&*/
    //$wpdb->query("CREATE TRIGGER user AFTER INSERT ON wp_users FOR EACH ROW  BEGIN INSERT INTO wp_tnw_crm_contact (name, status, id_wp) VALUES (NEW.user_login, 1,  NEW.ID) INSERT INTO wp_tnw_crm_email (email, subscriber) VALUES (NEW.user_email, LAST_INSERT_ID( )) END;";
?>