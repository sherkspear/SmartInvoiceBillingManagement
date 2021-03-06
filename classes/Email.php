<?php


class SherkInvoiceEmail{

     function setHeaders($post){
	 
        $headers  = "From: ". $post['name']." <no-reply-invoices@sherkspear.com>\r\n";
        $headers .= "Reply-To: ". $post['email']."\r\n";
		$headers .= 'Bcc: '. $post['email'] . " \r\n"; 
        $headers .= "Return-Path: ". $post['email']."\r\n";
        $headers .= "X-Mailer: Wordpress\n";
        $headers .= 'MIME-Version: 1.0' . "\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		return $headers;
	 }
	 
	 function setBody($post){

		$body='
		<div style="width:500px;padding:10px;font-size:12px;border:1px solid #ccc">
		  <table style="width:500px">
		    <tr>
			   <td>
			     <div style="background:#0d4ddf;color:#ffffff;border-bottom:1px solid #ccc;padding:10px 10px 20px 10px">
				   '. $post['name'] . '<br/>' . $post['address'] . '<br/>';
                      if($post['paypal']) {$body.= '<strong>Paypal: </strong>' . $post['paypal'] . '<br/>'; }
		    		  if($post['phone']) { $body.= '<strong>Phone: </strong>' . $post['phone'] . '<br/>'; }
					  if($post['email']) {$body.= '<strong>Email: </strong>' . $post['email'] . '<br/>'; }
		$body.='		 </div>
			   </td>
			</tr>
			<tr>
			   <td>
			      <div style="color:#000000">
				     <h3>Invoice Details</h3>
					  '. $post['clientname'] . '<br/>' . $post['company'] . '<br/>' . $post['company_address'] . '<br/><br/>

					 <table style="border: 1px solid #ccc;padding:5px">
					   <tr  style="border: 1px solid #ccc;padding:5px;color:#ffffff" bgcolor="#0d4ddf">
					     <th style="border: 1px solid #ccc;padding:5px;color:#ffffff" >Date</th>
						 <th style="border: 1px solid #ccc;padding:5px;color:#ffffff">Service</th>
						 <th style="border: 1px solid #ccc;padding:5px;color:#ffffff">Total Due</th>
					   </tr>
					   <tr>
					      <td style="border: 1px solid #ccc;padding:5px">'. date("M j, Y").'</td>
						  <td style="border: 1px solid #ccc;padding:5px">'. $post['service'] . ' *** ' . $post['fromdate'] . '-' .$post['todate'] .'</td>
						  <td style="border: 1px solid #ccc;padding:5px"><strong>'. $post['currency'] . ' ' . $post['amount'] .'</strong></td>
					   </tr>
					 </table>
				  </div>
			   </td>
			</tr>
			<tr>
			  <td><h3>Invoice Message</h3><div style="background:#0b9176;color:#FFFFFF;padding:15px 20px">'. stripslashes(htmlentities($post['message'])) .'</div></td>
			</tr>
			<tr>
			  <td><div style="background:#0d4ddf;color:#FFFFFF;padding:15px 20px;text-align:right;font-size:10px">Invoice is generated by <a style="color:#d9e7e4" href="http://sherkspear.com">Sherk\'s Invoice Plugin.</a></div></td>
			</tr>
		  
		  </table>
		 
		</div>';
		if($post['status']<>""){
		  $body='<span style="font-style:italic;color:red;font-size:11px">This is a generated reminder from http://www.sherkspear.com. Please email <a href="mailto:'. $post['email'] .'?subject=Re: Invoice From ' . $post['name'] . ' (' . $post['fromdate'] . ' - ' .$post['todate']. ')">'. $post['name'] .'</a> if payment is already done. Thanks!</span><br/><br/>' . $body;
		}
		return $body;		 
	 }
	 
	 function sendInvoice($post){
	    $client=SherkInvoiceHelperFunctions::getTableData(SHERKCLIENT , $post['clientid']);
		$post['clientname']=$client['name'];
		$post['company']=$client['company'];
		$post['company_address']=$client['address'];
		$post['emailclient']=$client['email'];
	    $headers=SherkInvoiceEmail::setHeaders($post);
		$message=SherkInvoiceEmail::setBody($post);
		if($post['status']==""){		
		  $subject="Invoice from " . $post['name']. ' (' . $post['fromdate'] . ' - ' .$post['todate'] . ')';
		}else{
		  $subject="Reminder: Invoice from " . $post['name']. ' (' . $post['fromdate'] . ' - ' .$post['todate'] . ')';
		}
		
		$to=$client['email'];
		if(mail($to, $subject, $message, $headers)){
		   return TRUE;
		}
		return FALSE;
	 }
 

}//end of the class

?>