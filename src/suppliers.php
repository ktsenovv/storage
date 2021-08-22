<?php
include('engine/core.php'); #include <ENGINE>
define('PAGE_NAME', 'Suppliers'); // Define Page Name

/*===============================================================================*/

$name = null;
$egn = null;
$address = null;
$phone = null;
$mol = null;
$action = 'Add';

$id = null; if(isset($_GET['id'])) $id = $_GET['id'];
$mode = null; if(isset($_GET['mode'])) $mode = $_GET['mode'];

if($mode == 'edit' && isset($id) && is_numeric($id))
{
	$query = db_query('SELECT * FROM suppliers WHERE supplier_id="'.$id.'"');
	$l = db_fetch('assoc', $query);
	$name = $l['supplier_name'];
	$egn = $l['supplier_egn'];
	$address = $l['supplier_address'];
	$phone = $l['supplier_phone'];
	$mol = $l['supplier_mol'];
	$action = 'Edit';
}
else if($mode == 'delete' && isset($id) && is_numeric($id))
{
	db_query('DELETE FROM suppliers WHERE supplier_id="'.$id.'"');
	redirect(0, 'suppliers.php');
}

if(isset($_POST['ipost']))
{
	$error = false;
	$error_msg = array();
	
	$name = $_POST['name'];
	$egn = $_POST['egn'];
	$address = $_POST['address'];
	$phone = $_POST['phone'];
	$mol = $_POST['mol'];
	
	if(empty($name)) $error_msg['name'] = 'Please, enter name!';
	
	if(empty($egn)) $error_msg['egn'] = 'Please, enter EGN!';
	else if(!is_numeric($egn)) $error_msg['egn'] = 'Please, enter only numbers!';
	
	if(empty($address)) $error_msg['address'] = 'Please, enter address!';
	if(empty($phone)) $error_msg['phone'] = 'Please, enter phone!';
	if(empty($mol)) $error_msg['mol'] = 'Please, enter MOL!';
	
	if(!d($error_msg, []))
	{
		if($mode != 'edit') db_query('INSERT INTO suppliers(supplier_name, supplier_egn, supplier_address, supplier_phone, supplier_mol) VALUES("'.$name.'", "'.$egn.'", "'.$address.'", "'.$phone.'", "'.$mol.'")');
		else db_query('UPDATE suppliers SET supplier_name="'.$name.'", supplier_egn="'.$egn.'", supplier_address="'.$address.'", supplier_phone="'.$phone.'", supplier_mol="'.$mol.'" WHERE supplier_id="'.$id.'"');
		redirect(0, 'suppliers.php');
	}
}

include('engine/header.php'); #include <HEADER>
?>
<div class="menu">
	<div class="head"><?=$action;?> supplier</div>
	<form action="" method="post">
		<table class="dtable">
			<tr>
				<td class="right">Name <span class="error">*</span></td><td class="left"><input type="text" name="name" value="<?=$name?>"> <span class="error"><?=d($error_msg['name']);?></span></td>
			</tr>
			<tr>
				<td class="right">EGN <span class="error">*</span></td><td class="left"><input type="text" name="egn" value="<?=$egn;?>"> <span class="error"><?=d($error_msg['egn']);?></span></td>
			</tr>
			<tr>
				<td class="right">Address <span class="error">*</span></td><td class="left"><input type="text" name="address" value="<?=$address;?>"> <span class="error"><?=d($error_msg['address']);?></span></td>
			</tr>
			<tr>
				<td class="right">Phone <span class="error">*</span></td><td class="left"><input type="text" name="phone" value="<?=$phone;?>"> <span class="error"><?=d($error_msg['phone']);?></span></td>
			</tr>
			<tr>
				<td class="right">MOL <span class="error">*</span></td><td class="left"><input type="text" name="mol" value="<?=$mol;?>"> <span class="error"><?=d($error_msg['mol']);?></span></td>
			</tr>
		</table>
		<?=($mode == 'edit' ? '<input type="button" value="Back" onclick="window.location = \'suppliers.php\'"> ' : null)?><input type="reset" value="Reset"> <input type="submit" name="ipost" value="<?=$action;?>">
	</form>
</div>
<div class="menu">
	<div class="head"><?=PAGE_NAME;?></div>
	<table class="dtable">
		<tr>
			<th>№</th><th>Name</th><th>EGN</th><th>Address</th><th>Phone</th><th>MOL</th><th>Options</th>
		</tr>
<?php
$query = db_query('SELECT * FROM suppliers');
$rows = db_num_rows($query);
while($l = db_fetch('assoc', $query))
{
	$edit = '<a href="?mode=edit&id='.$l['supplier_id'].'"><img src="style/images/edit.png" width="15px" title="Edit"></a>';
	$delete = '<a href="?mode=delete&id='.$l['supplier_id'].'"><img src="style/images/delete.png" width="15px" title="Delete"></a>';
	echo '<tr><td>'.$l['supplier_id'].'</td><td>'.$l['supplier_name'].'</td><td>'.$l['supplier_egn'].'</td><td>'.$l['supplier_address'].'</td><td>'.$l['supplier_phone'].'</td><td>'.$l['supplier_mol'].'</td><td>'.$edit.' '.$delete.'</td></tr>';
}
?>
	</table>
	<?=(!$rows ? 'There are no suppliers yet!' : 'Total suppliers: '.$rows);?>
</div>
<?php
include('engine/footer.php'); #include <FOOTER>

/*===============================================================================*/
?>