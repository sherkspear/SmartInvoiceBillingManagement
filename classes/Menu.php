<?php


class SherkInvoiceMenu {


    function setupMenu(){
	
	   add_menu_page(__('Sherk Invoice Configuration'), __('Create Invoice'), 'manage_options', 'invoice_menu', array(SherkInvoiceMenu,'create_invoice'));
	   add_submenu_page('invoice_menu', __('Add New Client'), __('Add New Client'), 'manage_options', 'invoice_add_client', array(SherkInvoiceMenu,'invoice_add_client'));
	   add_submenu_page('invoice_menu', __('Invoice Status'), __('Invoice Status'), 'manage_options', 'invoice_status', array(SherkInvoiceMenu,'invoice_status'));
	  
	 
	}
	
	
	
	/**
	 * Shows the option page for Add New Client
	 */
	function invoice_add_client(){
	   require_once SherkInvoice::getBaseDir(). '/includes/addnewclient.php';
	}
	
	/**
	 * Shows the option page for Create Invoice
	 */
	function create_invoice(){
	   require_once SherkInvoice::getBaseDir(). '/includes/createinvoice.php';
	}
	
	
	/**
	 * Shows the option page for Invoice Status and Actions
	 */
	function invoice_status(){
	   require_once SherkInvoice::getBaseDir(). '/includes/invoicestatus.php';
	}
	
	

	
} //end of class
	
	
?>