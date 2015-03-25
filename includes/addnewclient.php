<?php 
global $wpdb;

 echo '<style type="text/css" media=screen>';
         include SherkInvoice::getBaseDir().'/scripts/sherkinvoice.css';
 echo '</style>';

$action=$_GET['action'];
$edit_id=$_GET['id'];



if(($edit_id>0) && ($action=='edit')){ //edit mode
   $txtData=SherkInvoiceHelperFunctions::getTableData(SHERKCLIENT,$edit_id);
   if($_POST['name'] && $_POST['email'] && $_POST['company'] && $_POST['address']){ //check if complete
	   SherkInvoiceHelperFunctions::submitClient($_POST);  
	   SherkInvoiceHelperFunctions::sherk_redirect('?page=invoice_add_client');
    }

}else if(($edit_id>0) && ($action=='delete')){
       $wpdb->query("DELETE FROM ". SHERKCLIENT . " WHERE id =" . $edit_id);
       SherkInvoiceHelperFunctions::sherk_redirect('?page=invoice_add_client');

} else { //Submit or add
    if($_POST['name'] && $_POST['email'] && $_POST['company'] && $_POST['address']){ //check if complete
	   SherkInvoiceHelperFunctions::submitClient($_POST);   
	}else{ //missing data 
	   $txtData=$_POST;
	}
				
}

?>

<div id="form-addclient">
<?php if($edit_id>0){ ?>
<h2>Edit Client Details</h2>
<?php } else { ?>
<h2>Add New Client</h2>
<br/><a title="Create an Invoice" href='<?php echo CREATEINVOICELINK ?>'><img alt="Create an Invoice" src="<?php echo WP_PLUGIN_URL ?>/sherkinvoice/files/createinvoice.png" width="50px"/></a><a title="Check Invoices Status"  href='<?php echo STATUSINVOICELINK ?>'><img alt="Check Invoices Status" src="<?php echo WP_PLUGIN_URL ?>/sherkinvoice/files/invoicestatus.png" width="50px"/></a><br/>
<?php } ?>
<form name="addclient" id="addclient" method="POST" >
   <input type="hidden" name="id" value="<?php echo $txtData['id']; ?>" />
   <table>
      <tr>
	    <td class="labels">Name:</td><td class="fields"><input type="text" name="name" id="name" size="50" value="<?php echo $txtData['name']; ?>"/></td>
	  </tr>
	  <tr>
	    <td class="labels">Email:</td><td class="fields"><input type="text" name="email" id="email" size="50" value="<?php echo $txtData['email']; ?>"/></td>
	  </tr>
	  <tr>
	    <td class="labels">Company Name:</td><td class="fields"><input type="text" name="company" id="company" size="50" value="<?php echo $txtData['company']; ?>"/></td>
	  </tr>
	  <tr>
	    <td class="labels">Company Address:</td><td class="fields"><input type="text" name="address" id="address" size="50" value="<?php echo $txtData['address']; ?>"/></td>
	  </tr>
	  <tr><td colspan=2 style="text-align:center"><input type="submit" name="submit" value="Submit"/></td></tr>
   </table>
</form>

</div>



<?php 
  $records=SherkInvoiceHelperFunctions::getAllTableData(SHERKCLIENT);
  if(count($records)>0){
?>	
<div id="form-displayclients">
   <table >
     <tr>
	   <th>Id</th>
	   <th>Name</th>
	   <th>Email</th>
	   <th>Company Name</th>
	   <th>Company Address</th>
	   <th>Action</th>
	 </tr>
<?php
    foreach($records as $data) {
  ?>
	 <tr>
	   <td><?php echo $data['id'] ?></td>
	   <td><?php echo $data['name'] ?></td>
	   <td><?php echo $data['email'] ?></td>
	   <td><?php echo $data['company'] ?></td>
	   <td><?php echo $data['address'] ?></td>
	   <td><a href="?page=invoice_add_client&action=edit&id=<?php echo $data['id'] ?>">Edit</a><a href="?page=invoice_add_client&action=delete&id=<?php echo $data['id']?>">Delete</a></td>
	 </tr>
	<?php } }?>
   </table>
   
   <div id="developby">Invoice Plugin is Developed by <a target="_blank" href="http://www.sherkspear.com"><img src="<?php echo WP_PLUGIN_URL ?>/sherkinvoice/files/sherkspear.png" width="100px"/></a></div>
   
</div>

