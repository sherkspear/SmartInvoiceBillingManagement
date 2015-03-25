<?php


class SherkInvoiceHelperFunctions{

    

    function getAllTableData($table,$lowerlimit=0,$higherlimit=10,$orderby='id',$order='ASC'){
	   global $wpdb;
	   $query_condition=" ORDER BY ". $orderby . " " . $order . " LIMIT " . $lowerlimit . "," .$higherlimit;
	   $data = $wpdb->get_results("SELECT * FROM " . $table . $query_condition,ARRAY_A);
	   return $data;
	}
	
	
	function getDefaultInvoiceValue(){
	   global $wpdb;
	   $data = $wpdb->get_results("SELECT * FROM " . SHERKINVOICE . " ORDER BY id DESC LIMIT 1 " ,ARRAY_A);
	   return $data[0];
	}
	
	
	
	function getTableData($table , $id){
	   global $wpdb;
	   $data = $wpdb->get_results("SELECT * FROM " . $table . " WHERE id=" . $id,ARRAY_A);
	   return $data[0];
	}
	
	function getTableDataStatus($table , $status,$lowerlimit=0,$higherlimit=10,$orderby='id',$order='ASC'){
	   global $wpdb;
	   $query_condition=" ORDER BY ". $orderby . " " . $order . " LIMIT " . $lowerlimit . "," .$higherlimit;
	   $data = $wpdb->get_results("SELECT * FROM " . $table . " WHERE status='" . $status . "'" . $query_condition ,ARRAY_A);
	   return $data;
	}
	
	
	function isIdExisting($table, $id){
	   global $wpdb;
	   $data = $wpdb->get_results("SELECT id FROM " . $table . " WHERE id=" . $id,ARRAY_A);
	   if($data[0]['id']){
	      return true;
	   }else{
	      return false;
	   }
	}
	
	
	function submitClient($post){
	   global $wpdb;
	   if(SherkInvoiceHelperFunctions::isIdExisting(SHERKCLIENT,$post['id'])){
	      $wpdb->update( SHERKCLIENT, array( 'name' => $post['name'], 'email' => $post['email'],'company' => $post['company'], 'address' => $post['address']),array('id'=>$post['id']));

	   }else{
	      $wpdb->insert( SHERKCLIENT, array( 'name' => $post['name'], 'email' => $post['email'],'company' => $post['company'], 'address' => $post['address']) );
	   }
	}
	
	function submitInvoice($post){
	   global $wpdb;	   
	   
	   if(SherkInvoiceEmail::sendInvoice($post)){
	     $wpdb->insert( SHERKINVOICE, array( 'clientid' => $post['clientid'],'name' => $post['name'],'email' => $post['email'], 'phone' => $post['phone'],'address' => $post['address'], 'paypal' => $post['paypal'], 'service' => $post['service'], 'currency' => $post['currency'], 'amount' => $post['amount'], 'fromdate' => $post['fromdate'], 'todate' => $post['todate'], 'message' => $post['message'],'sentdate' => $post['sentdate'],'status'=>'sent'));
	      echo "<div style='color:green'>Invoice is successfully emailed and created.</div>";
	   } else {
	      echo "<div style='color:red'>Invoice is unsuccessfully emailed to your client. Please try again later.</div>";
	   }
	}
	
	function submitInvoicePaid($id){
	  global $wpdb;
	  $wpdb->update( SHERKINVOICE, array('status' => 'paid','paiddate'=> date("d-M-Y")), array('id'=>$id) ); 
	}
	
	function submitInvoiceRemind($id){
	  global $wpdb;
	  $post=SherkInvoiceHelperFunctions::getTableData(SHERKINVOICE , $id);	  
	  if(SherkInvoiceEmail::sendInvoice($post)){
	      $wpdb->update( SHERKINVOICE, array('status' => 'reminded','reminddate' => date("d-M-Y")), array('id' => $id)); 
	      echo "<div style='color:green'>Invoice is successfully emailed and created.</div>";
	   } else {
	      echo "<div style='color:red'>Invoice is unsuccessfully emailed to your client. Please try again later.</div>";
	   }
	}
	
	function submitInvoiceCancel($id){
	  global $wpdb;
	  $wpdb->update( SHERKINVOICE, array('status'=>'cancelled','canceldate'=> date("d-M-Y")), array('id'=>$id) ); 
	}
	
	
	function sherk_redirect($location){
	  echo "<meta http-equiv='refresh' content='0;url=$location' />";
	}
	
	
	/**Sends an email for the next hour**/
	
    function do_this_in_a_minute($post) {
       SherkInvoiceEmail::sendInvoice($post);
    }
    

    // put this line inside a function, 
    // presumably in response to something the user does
    // otherwise it will schedule a new event on every page visit

    

    // time()+3600 = one hour from now.
	
	
	/**End of sends an email for the next hour***/
	
} //end of the class
?>