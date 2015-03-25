<?php


global $wpdb;

//Table Constants
define('SHERKINVOICEVERSION','1.0.1');
define('SHERKINVOICEUSER',$wpdb->prefix . 'sherkinvoiceuser');
define('SHERKCLIENT', $wpdb->prefix . 'sherkclient');
define('SHERKINVOICE', $wpdb->prefix . 'sherkinvoice');
define('CREATEINVOICELINK', get_option('home') .'/wp-admin/admin.php?page=invoice_menu');
define('CREATECLIENTLINK', get_option('home') .'/wp-admin/admin.php?page=invoice_add_client');
define('STATUSINVOICELINK', get_option('home') .'/wp-admin/admin.php?page=invoice_status');

?>