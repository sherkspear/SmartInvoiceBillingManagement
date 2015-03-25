<?php 
global $wpdb;

 echo '<style type="text/css" media=screen>';
         include SherkInvoice::getBaseDir().'/scripts/sherkinvoice.css';
 echo '</style>';

if ($_POST['submit']){
if($_POST['name'] && $_POST['email'] && $_POST['clientid'] && $_POST['amount'] && $_POST['address'] && $_POST['currency'] && $_POST['fromdate'] && $_POST['todate'] && $_POST['service']){ //check if complete
    $_POST['sentdate']=date("d-M-Y");
	SherkInvoiceHelperFunctions::submitInvoice($_POST);  
}else{ //missing data 
	$txtData=$_POST;
	$msg="<div style='color:red'>Some fields are missed to input values. Please review the fields of the form.</div>";
}
}else{
   $txtData=SherkInvoiceHelperFunctions::getDefaultInvoiceValue();
}

$msg= $msg . "<br/><div style='color:red;font-style:italic'>Note: Make sure your client is already added or else you have to add it <a href='". CREATECLIENTLINK ."'>here</a> first.</div>";

$clients=SherkInvoiceHelperFunctions::getAllTableData(SHERKCLIENT);
if(count($clients)<1){
  echo "<div style='color:red;font-style:italic'>Note: Make sure your client is already added before you can create an invoice. Click <a href='". CREATECLIENTLINK ."'>here</a> to add your client.</div>";
?>


<?php
  }else{
?>
 
<div id="form-addclient">
<?php echo $msg; ?>
<h2>Create an Invoice</h2>
<br/><a title="Add Client"  href='<?php echo CREATECLIENTLINK ?>'><img alt="Add Client" src="<?php echo WP_PLUGIN_URL ?>/sherkinvoice/files/addclient.png" width="50px"/></a><a title="Check Invoices Status"  href='<?php echo STATUSINVOICELINK ?>'><img alt="Check Invoices Status" src="<?php echo WP_PLUGIN_URL ?>/sherkinvoice/files/invoicestatus.png" width="50px"/></a><br/>

<form name="createinvoice" id="createinvoice" method="POST" >
   <input type="hidden" name="id" value="<?php echo $txtData['id']; ?>" />
   <table>
      <tr>
	    <td class="labels">Name:</td><td class="fields"><input type="text" name="name" id="name" size="50" value="<?php echo $txtData['name']; ?>"/></td>
	  </tr>
	  <tr>
	    <td class="labels">Email Address:</td><td class="fields"><input type="text" name="email" id="email" size="50" value="<?php echo $txtData['email']; ?>"/></td>
	  </tr>
	  <tr>
	    <td class="labels">Phone:</td><td class="fields"><input type="text" name="phone" id="phone" size="50" value="<?php echo $txtData['phone']; ?>"/></td>
	  </tr>
	  <tr>
	    <td class="labels">Address:</td><td class="fields"><input type="text" name="address" id="address" size="50" value="<?php echo $txtData['address']; ?>"/></td>
	  </tr>
	  <tr>
	    <td class="labels">Paypal Account:</td><td class="fields"><input type="text" name="paypal" id="paypal" size="50" value="<?php echo $txtData['paypal']; ?>"/></td>
	  </tr>
	  
	  <tr>
	    <td class="labels">Select Company:</td><td class="fields">
		   <select style="width:324px;" name="clientid" id="clientid">
	      <?php 
		    $records=SherkInvoiceHelperFunctions::getAllTableData(SHERKCLIENT);
              foreach($records as $data) { ?>
	    <option value="<?php echo $data['id'] ?>"><?php echo $data['name'] . "-". $data['company']; ?></option>
		<?php } ?>
	       </select>
		</td>
	  </tr>
	  <tr>
	    <td class="labels">Service:</td><td class="fields"><input type="text" name="service" id="service" size="50" value="<?php echo $txtData['service']; ?>"/></td>
	  </tr>
	  <tr>
	    <td class="labels">Currency/Amount:</td><td class="fields"><input type="text" name="currency" id="currency" size="10" value="<?php echo $txtData['currency']; ?>"/><input type="text" name="amount" id="amount" size="35" value="<?php echo $txtData['amount']; ?>"/></td>
	  </tr>
	  <tr>
	    <td class="labels">From Date:</td><td class="fields"><input type="text" name="fromdate" id="fromdate" size="35" value="<?php echo $txtData['fromdate']; ?>"/><a href="javascript:NewCal('fromdate','ddmmmyyyy')"><icon class="dashicons-calendar-alt dashicons"></icon></a></td>
	  </tr>
	  <tr>
	    <td class="labels">To Date:</td><td class="fields"><input type="text" name="todate" id="todate" size="35" value="<?php echo $txtData['todate']; ?>"/><a href="javascript:NewCal('todate','ddmmmyyyy')"><icon class="dashicons-calendar-alt dashicons"></icon></a></td>
	  </tr>
	  <tr>
	    <td class="labels">Message:</td><td class="fields">
		  <textarea name="message" rows="15" cols="40"></textarea>
		</td>
	  </tr>
	  <tr><td colspan=2 style="text-align:center"><input type="submit" name="submit" value="Submit"/></td></tr>
   </table>
</form>

</div>

<?php
  }
?>

<div id="form-displayclients">
   
   <div id="developby">Invoice Plugin is Developed by <a target="_blank" href="http://www.sherkspear.com"><img src="<?php echo WP_PLUGIN_URL ?>/sherkinvoice/files/sherkspear.png" width="100px"/></a></div>
   
</div>

