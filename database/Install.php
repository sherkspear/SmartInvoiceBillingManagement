<?php

require_once ABSPATH . 'wp-admin/upgrade-functions.php';

class SherkInvoiceInstall{


    function createTables(){
	   global $wpdb;
	   
	   if(!$wpdb->get_var("SHOW TABLES LIKE '".SHERKINVOICE."'") == SHERKINVOICE ) {
	      
		  $sherkinvoice_tables[] = "CREATE TABLE " . SHERKCLIENT . " (
				id INTEGER NOT NULL AUTO_INCREMENT,
				name VARCHAR(255) NOT NULL,
				email VARCHAR(255) NOT NULL,
				company VARCHAR(255) NOT NULL,
				address VARCHAR(255) NOT NULL,
				PRIMARY KEY (id) )" ;
		  
		  $sherkinvoice_tables[] = "CREATE TABLE " . SHERKINVOICE . " (
				id INTEGER NOT NULL AUTO_INCREMENT,
				clientid INTEGER NOT NULL,
				name VARCHAR(255) NOT NULL,
				phone VARCHAR(255) NOT NULL,
				email VARCHAR(255) NOT NULL,
				address VARCHAR(255) NOT NULL,
				paypal VARCHAR(255) NOT NULL,
				service VARCHAR(255) NOT NULL,
				currency VARCHAR(25) NOT NULL,
				amount VARCHAR(255) NOT NULL,
				fromdate VARCHAR(255) NOT NULL,
				todate VARCHAR(255) NOT NULL,
				message VARCHAR(555) NOT NULL,
				status VARCHAR(255) NOT NULL,
				sentdate VARCHAR(255) NOT NULL ,
				reminddate VARCHAR(255) NOT NULL ,
				paiddate VARCHAR(255)  NOT NULL,
				canceldate VARCHAR(255)  NOT NULL,
				PRIMARY KEY (id) )" ;
			
			
			//create tables
			foreach($sherkinvoice_tables as $sherkinvoice_table)
				dbDelta($sherkinvoice_table);	
	   
	   }
	
	}

} //end class


?>