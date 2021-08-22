<?php
include('engine/core.php'); #include <ENGINE>
define('PAGE_NAME', 'Clients'); // Define Page Name

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
	$query = db_query('SELECT * FROM clients WHERE client_id="'.$id.'"');
	$l = db_fetch('assoc', $query);
	$name = $l['client_name'];
	$egn = $l['client_egn'];
	$address = $l['client_address'];
	$phone = $l['client_phone'];
	$mol = $l['client_mol'];
	
	$action = 'Edit';
}
else if($mode == 'delete' && isset($id) && is_numeric($id))
{
	db_query('DELETE FROM clients WHERE client_id="'.$id.'"');
	redirect(0, 'clients.php');
}

if(isset($_POST['ipost']))
{
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
		if($mode != 'edit') db_query('INSERT INTO clients(client_name, client_egn, client_address, client_phone, client_mol) VALUES("'.$name.'", "'.$egn.'", "'.$address.'", "'.$phone.'", "'.$mol.'")');
		else db_query('UPDATE clients SET client_name="'.$name.'", client_egn="'.$egn.'", client_address="'.$address.'", client_phone="'.$phone.'", client_mol="'.$mol.'" WHERE client_id="'.$id.'"');
		redirect(0, 'clients.php');
	}
}

include('engine/header.php'); #include <HEADER>
?>
<div class="menu">
	<div class="head"><?=$action;?> client</div>
	<form action="" method="post">
		<table class="dtable">
			<tr>
				<td class="right">Name <span class="error">*</span></td><td class="left"><input type="text" name="name" value="<?=$name;?>"> <span class="error"><?=d($error_msg['name']);?></span></td>
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
		<?=($mode == 'edit' ? '<input type="button" value="Back" onclick="window.location = \'clients.php\'"> ' : null)?><input type="reset" value="Reset"> <input type="submit" name="ipost" value="<?=$action;?>">
	</form>
</div>
<div class="menu">
	<div class="head"><?=PAGE_NAME;?></div>
	<table class="dtable">
		<tr>
			<th>№</th><th>Name</th><th>EGN</th><th>Address</th><th>Phone</th><th>MOL</th><th>Options</th>
		</tr>
<?php
$query = db_query('SELECT * FROM clients');
$rows = db_num_rows($query);
while($l = db_fetch('assoc', $query))
{
	$edit = '<a href="?mode=edit&id='.$l['client_id'].'"><img src="style/images/edit.png" width="15px" title="Edit"></a>';
	$delete = '<a href="?mode=delete&id='.$l['client_id'].'"><img src="style/images/delete.png" width="15px" title="Delete"></a>';
	echo '<tr><td>'.$l['client_id'].'</td><td>'.$l['client_name'].'</td><td>'.$l['client_egn'].'</td><td>'.$l['client_address'].'</td><td>'.$l['client_phone'].'</td><td>'.$l['client_mol'].'</td><td>'.$edit.' '.$delete.'</td></tr>';
}
?>
	</table>
	<?=(!$rows ? 'There are no clients yet!' : 'Total clients: '.$rows);?>
</div>
<?php
include('engine/footer.php'); #include <FOOTER>

/*===============================================================================*/
?>