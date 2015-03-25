<?php
/*
Plugin Name: Smart Invoice and Billing Management
Plugin URI: http://www.sherkspear.com/plugins/sc-food-business-calc
Description: Add your clients database and send them invoices through their emails. Manages invoices status and able you to send them reminders.
Version: 1.0
Author: Sherwin Calims
Author URI: http://www.sherkspear.com

------------------------------------------------------------------------
Copyright 2015 SherkSpear

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
*/

/*

  _________.__                  __      _________
 /   _____/|  |__   ___________|  | __ /   _____/_____   ____ _____ _______
 \_____  \ |  |  \_/ __ \_  __ \  |/ / \_____  \\____ \_/ __ \\__  \\_  __ \
 /        \|   Y  \  ___/|  | \/    <  /        \  |_> >  ___/ / __ \|  | \/
/_______  /|___|  /\___  >__|  |__|_ \/_______  /   __/ \___  >____  /__|
        \/      \/     \/           \/        \/|__|        \/     \/
*/


require_once 'database/Install.php';
require_once 'database/Uninstall.php';

require_once 'classes/Menu.php';
require_once 'classes/HelperFunctions.php';
require_once 'classes/Email.php';

// Includes
require_once 'includes/Constants.php';


class SherkInvoice{

   function enable(){
      //Setup menus on the sidebar for admin configuration of webplate...
	  add_action('admin_menu', array('SherkInvoiceMenu', 'setupMenu'));
   }
    
   
   function getBaseDir(){
	   return dirname(__FILE__);
	}

   
   /**
	 * Create table portfolio for the sherk-portfolio plugin
	 */
	function createTablesOnDatabase(){
	   SherkInvoiceInstall::createTables();
	}
	
	function deleteTablesOnDatabase(){
	   SherkInvoiceUninstall::deleteTables();
	}
	
	function addJsScripts(){
	    $sherkinvoice_plugin_url = trailingslashit( get_bloginfo('wpurl') ).PLUGINDIR.'/'. dirname( plugin_basename(__FILE__) );
		wp_enqueue_script('wp_wall_script', $sherkinvoice_plugin_url.'/scripts/datetimepicker.js');
	}
	

} //end of class



//Enable the plugin for the init hook, but only if WP is loaded. Calling this php file directly will do nothing.
if(defined('ABSPATH') && defined('WPINC')) {
    add_action('wp_print_scripts', array("SherkInvoice","addJsScripts"),1000,0);
    add_action("init",array("SherkInvoice","enable"),1000,0);
	//Install tables on the database
	register_activation_hook(dirname(__FILE__) . '/SherkInvoice.php',array('SherkInvoice','createTablesOnDatabase'));
	//Uninstall tables on the database
	//register_deactivation_hook(dirname(__FILE__) . '/SherkInvoice.php',array('SherkInvoice','deleteTablesOnDatabase'));
}





?>
