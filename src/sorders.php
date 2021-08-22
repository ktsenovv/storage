<?php
include('engine/core.php'); #include <ENGINE>
define('PAGE_NAME', 'Orders from suppliers'); // Define Page Name

/*===============================================================================*/

$name = null;
$price = null;
$amount = 1;
$category = null;
$supplier = null;
$action = 'Add';

$id = null; if(isset($_GET['id'])) $id = $_GET['id'];
$mode = null; if(isset($_GET['mode'])) $mode = $_GET['mode'];

if($mode == 'edit' && isset($id) && is_numeric($id))
{
	$query = db_query('SELECT * FROM sorders WHERE sorder_id="'.$id.'"');
	$l = db_fetch('assoc', $query);
	$name = $l['sorder_name'];
	$price = $l['sorder_price'];
	$amount = $l['sorder_amount'];
	$category = $l['sorder_catid'];
	$supplier = $l['sorder_supid'];
	$action = 'Edit';
}
else if($mode == 'delete' && isset($id) && is_numeric($id))
{
	db_query('DELETE FROM sorders WHERE sorder_id="'.$id.'"');
	redirect(0, 'sorders.php');
}

if(isset($_POST['ipost']))
{
	$name = $_POST['name'];
	$price = $_POST['price'];
	$amount = $_POST['amount'];
	$category = $_POST['category'];
	$supplier = $_POST['supplier'];
	
	if(empty($name)) $error_msg['name'] = 'Please, enter name!';
	
	if(empty($price)) $error_msg['price'] = 'Please, enter price!';
	else if(!is_numeric($price)) $error_msg['price'] = 'Please, enter only numbers!';
	
	if(empty($amount)) $error_msg['amount'] = 'Please, enter amount!';
	else if(!is_numeric($amount)) $error_msg['amount'] = 'Please, enter only numbers!';
	
	if(!d($error_msg, []))
	{
		if($mode != 'edit') db_query('INSERT INTO sorders(sorder_name, sorder_price, sorder_amount, sorder_catid, sorder_supid) VALUES("'.$name.'", "'.$price.'", "'.$amount.'", "'.$category.'", "'.$supplier.'")');
		else db_query('UPDATE sorders SET sorder_name="'.$name.'", sorder_price="'.$price.'", sorder_amount="'.$amount.'", sorder_catid="'.$category.'", sorder_supid="'.$supplier.'" WHERE sorder_id="'.$id.'"');
		redirect(0, 'sorders.php');
	}
}

$suppliers = null;
$query = db_query('SELECT * FROM suppliers');
while($l = db_fetch('assoc', $query))
{
	$suppliers .= '<option value="'.$l['supplier_id'].'" '.($supplier == $l['supplier_id'] ? 'selected="selected"' : '').'>'.$l['supplier_name'].'</option>';
}

$categories = null;
$query = db_query('SELECT * FROM categories');
while($l = db_fetch('assoc', $query))
{
	$categories .= '<option value="'.$l['category_id'].'" '.($category == $l['category_id'] ? 'selected="selected"' : '').'>'.$l['category_name'].'</option>';
}

include('engine/header.php'); #include <HEADER>
?>
<div class="menu">
	<div class="head"><?=$action;?> order</div>
	<form action="" method="post">
		<table class="dtable">
			<tr>
				<td class="right">Supplier</td>
				<td class="left">
					<select name="supplier">
						<?=$suppliers;?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="right">Item <span class="error">*</span></td><td class="left"><input type="text" name="name" value="<?=$name;?>"> <span class="error"><?=d($error_msg['name']);?></span></td>
			</tr>
			<tr>
				<td class="right">Category</td>
				<td class="left">
					<select name="category">
						<?=$categories;?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="right">Price per item [<?=$g_storage_currency;?>] <span class="error">*</span></td><td class="left"><input type="number" name="price" value="<?=$price;?>" min="0" step=".01"> <span class="error"><?=d($error_msg['price']);?></span></td>
			</tr>
			<tr>
				<td class="right">Amount <span class="error">*</span></td><td class="left"><input type="number" name="amount" value="<?=$amount;?>" min="1"> <span class="error"><?=d($error_msg['amount']);?></span></td>
			</tr>
		</table>
		<?=($mode == 'edit' ? '<input type="button" value="Back" onclick="window.location = \'sorders.php\'"> ' : null)?><input type="reset" value="Reset"> <input type="submit" name="ipost" value="<?=$action;?>">
	</form>
</div>
<div class="menu">
	<div class="head"><?=PAGE_NAME;?></div>
	<table class="dtable">
		<tr>
			<th>№</th><th>Item</th><th>Price</th><th>Amount</th><th>Category</th><th>Supplier</th><th>Options</th>
		</tr>
<?php
$query = db_query('SELECT * FROM sorders');
$rows = db_num_rows($query);
while($l = db_fetch('assoc', $query))
{
	$l2 = db_fetch('assoc', db_query('SELECT * FROM categories WHERE category_id='.$l['sorder_catid']));
	$l3 = db_fetch('assoc', db_query('SELECT * FROM suppliers WHERE supplier_id='.$l['sorder_supid']));
	$edit = '<a href="?mode=edit&id='.$l['sorder_id'].'"><img src="style/images/edit.png" width="15px" title="Edit"></a>';
	$delete = '<a href="?mode=delete&id='.$l['sorder_id'].'"><img src="style/images/delete.png" width="15px" title="Delete"></a>';
	
	echo '<tr><td>'.$l['sorder_id'].'</td><td>'.$l['sorder_name'].'</td><td>'.$l['sorder_price'].' '.$g_storage_currency.'</td><td>'.$l['sorder_amount'].'</td><td>'.$l2['category_name'].'</td><td>'.$l3['supplier_name'].'</td><td>'.$edit.' '.$delete.'</td></tr>';
}
?>
	</table>
	<?=(!$rows ? 'There are no orders yet!' : 'Total orders: '.$rows);?>
</div>
<?php
include('engine/footer.php'); #include <FOOTER>

/*===============================================================================*/
?>