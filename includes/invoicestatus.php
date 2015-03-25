<?php 
global $wpdb;

 echo '<style type="text/css" media=screen>';
         include SherkInvoice::getBaseDir().'/scripts/sherkinvoice.css';
 echo '</style>';
 
$action=$_GET['action'];
$id=$_GET['id'];

if($action && $id){
  if($action=='paid'){
    SherkInvoiceHelperFunctions::submitInvoicePaid($id);  
  }elseif ($action=='remind'){
    SherkInvoiceHelperFunctions::submitInvoiceRemind($id);  
  }else{ //cancel
    SherkInvoiceHelperFunctions::submitInvoiceCancel($id);  
  }
}
elseif ($_POST['submit']){
  if($_POST['name'] && $_POST['clientid'] && $_POST['amount'] && $_POST['address'] && $_POST['currency'] && $_POST['fromdate'] && $_POST['todate'] && $_POST['service']){ //check if complete
	SherkInvoiceHelperFunctions::submitInvoice($_POST);  
  }else{ //missing data 
	$txtData=$_POST;
	$msg="<div style='color:red'>Some fields are missed to input values. Please review the fields of the form.</div>";
  }
}

?>

<div id="form-invoice-status">
<?php echo $msg; ?>
<h2>Invoice Status</h2>

<br/><a title="Create an Invoice" href='<?php echo CREATEINVOICELINK ?>'><img alt="Create an Invoice" src="<?php echo WP_PLUGIN_URL ?>/sherkinvoice/files/createinvoice.png" width="50px"/></a><a title="Add Client"  href='<?php echo CREATECLIENTLINK ?>'><img alt="Add Client" src="<?php echo WP_PLUGIN_URL ?>/sherkinvoice/files/addclient.png" width="50px"/></a><br/>
<div id="pending-invoices">


  <?php 
    $invoicedata_reminded=SherkInvoiceHelperFunctions::getTableDataStatus(SHERKINVOICE,'reminded');
	$invoicedata_sent=SherkInvoiceHelperFunctions::getTableDataStatus(SHERKINVOICE,'sent');
	if((count($invoicedata_sent)>0) || (count($invoicedata_reminded)>0)){
  ?> 
   <h3>Not Paid Invoices</h3>

    <table>
     <tr>
	   <th>Id</th>
	   <th>Name</th>
	   <th>Company Name</th>
	   <th>Amount</th>
	   <th>Date Covered</th>
	   <th>Date Sent</th>
	   <th>Action</th>
	 </tr>
  
  <?php
  	
	}else {
  ?>
    <h3>No Unpaid Invoices Yet</h3>
  <?php
  
   }  
	
	if(count($invoicedata_reminded)>0){
     foreach($invoicedata_reminded as $datainv_reminded) {  
  	 $clientdata=SherkInvoiceHelperFunctions::getTableData(SHERKCLIENT , $datainv_reminded['clientid']);
	 ?>
	 <tr id="reminded-invoice">
	   <td><?php echo $datainv_reminded['id'] ?></td>
	   <td><?php echo $datainv_reminded['name'] ?></td>
	   <td><?php echo $clientdata['company'];?></td>
	   <td><?php echo $datainv_reminded['currency'] . " " . $datainv_reminded['amount'] ?></td>
	   <td><?php echo $datainv_reminded['todate'];?></td>
	   <td><?php echo $datainv_reminded['reminddate'];?></td>
	   <td><a href="?page=invoice_status&action=remind&id=<?php echo $datainv_reminded['id'] ?>">Remind Again</a><br/><a href="?page=invoice_status&action=paid&id=<?php echo $datainv_reminded['id']?>">Confirm Paid</a><br/><a href="?page=invoice_status&action=cancel&id=<?php echo $datainv_reminded['id']?>">Cancel Invoice</a></td>
	 </tr>
	<?php } } 
	
	if(count($invoicedata_sent)>0){
     foreach($invoicedata_sent as $datainv_sent) {  
  	 $clientdata=SherkInvoiceHelperFunctions::getTableData(SHERKCLIENT , $datainv_sent['clientid']);
	 ?>
	 <tr id="sent-invoice">
	   <td><?php echo $datainv_sent['id'] ?></td>
	   <td><?php echo $datainv_sent['name'] ?></td>
	   <td><?php echo $clientdata['company'];?></td>
	   <td><?php echo $datainv_sent['currency'] . " " . $datainv_sent['amount'] ?></td>
	   <td><?php echo $datainv_sent['fromdate'] . " - " . $datainv_sent['todate'];?></td>
	   <td><?php echo $datainv_sent['sentdate'];?></td>
	   <td><a href="?page=invoice_status&action=remind&id=<?php echo $datainv_sent['id'] ?>">Remind</a><br/><a href="?page=invoice_status&action=paid&id=<?php echo $datainv_sent['id']?>">Confirm Paid</a><br/><a href="?page=invoice_status&action=cancel&id=<?php echo $datainv_sent['id']?>">Cancel Invoice</a></td>
	 </tr>
	<?php } } ?>
	
   </table>
</div>


<?php 
    $invoicedata_paid=SherkInvoiceHelperFunctions::getTableDataStatus(SHERKINVOICE,'paid');
	if(count($invoicedata_paid)>0){
?>	

<div id="paid-invoices">

<h3>Paid Invoices</h3>

<table>
     <tr>
	   <th>Id</th>
	   <th>Name</th>
	   <th>Company Name</th>
	   <th>Amount</th>
	   <th>Date Covered</th>
	   <th>Date Paid</th>
	 </tr>
    <?php
     foreach($invoicedata_paid as $datainv_paid) {  
  	 $clientdata=SherkInvoiceHelperFunctions::getTableData(SHERKCLIENT , $datainv_paid['clientid']);
	 ?>
	 <tr id="paid-invoice">
	   <td><?php echo $datainv_paid['id'] ?></td>
	   <td><?php echo $datainv_paid['name'] ?></td>
	   <td><?php echo $clientdata['company'];?></td>
	   <td><?php echo $datainv_paid['currency'] . " " . $datainv_paid['amount'] ?></td>
	   <td><?php echo $datainv_paid['fromdate'] . " - " . $datainv_paid['todate'];?></td>
	   <td><?php echo $datainv_paid['paiddate'];?></td>
	 </tr>
	<?php } ?>
	
   </table>
</div>

<?php } ?>


<?php 
    $invoicedata_cancelled=SherkInvoiceHelperFunctions::getTableDataStatus(SHERKINVOICE,'cancelled');
	if(count($invoicedata_cancelled)>0){
?>
	
<div id="cancelled-invoices">

<h3>Cancelled Invoices</h3>

<table>
     <tr>
	   <th>Id</th>
	   <th>Name</th>
	   <th>Company Name</th>
	   <th>Amount</th>
	   <th>Date Covered</th>
	 </tr>
    <?php
     foreach($invoicedata_cancelled as $datainv_cancelled) {  
  	 $clientdata=SherkInvoiceHelperFunctions::getTableData(SHERKCLIENT , $datainv_cancelled['clientid']);
	 ?>
	 <tr id="paid-cancel">
	   <td><?php echo $datainv_cancelled['id'] ?></td>
	   <td><?php echo $datainv_cancelled['name'] ?></td>
	   <td><?php echo $clientdata['company'];?></td>
	   <td><?php echo $datainv_cancelled['currency'] . " " . $datainv_cancelled['amount'] ?></td>
	   <td><?php echo $datainv_cancelled['fromdate'] . " - " . $datainv_cancelled['todate'];?></td>
	 </tr>
	<?php } ?>
	
   </table>
</div>
<?php } ?>


   <div id="developby">Invoice Plugin is Developed by <a target="_blank" href="http://www.sherkspear.com"><img src="<?php echo WP_PLUGIN_URL ?>/sherkinvoice/files/sherkspear.png" width="100px"/></a></div>
   
</div>

