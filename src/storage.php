<?php
include('engine/core.php'); #include <ENGINE>
define('PAGE_NAME', 'Storage'); // Define Page Name

/*===============================================================================*/

$id = null; if(isset($_GET['id'])) $id = $_GET['id'];
$mode = null; if(isset($_GET['mode'])) $mode = $_GET['mode'];

if($mode == 'add' && isset($id) && is_numeric($id))
{
	$l = db_fetch('assoc', db_query('SELECT * FROM sorders WHERE sorder_id='.$id));
	
	$query = db_query('SELECT * FROM storage WHERE item_name="'.$l['sorder_name'].'"');
	$item_exist = db_num_rows($query);
	
	db_query('UPDATE sorders SET sorder_added="1" WHERE sorder_name="'.$l['sorder_name'].'"');
	
	if(!$item_exist) db_query('INSERT INTO storage(item_name, item_price, item_amount, item_catid) VALUES("'.$l['sorder_name'].'", "'.$l['sorder_price'].'", "'.$l['sorder_amount'].'", "'.$l['sorder_catid'].'")');
	else
	{
		$l2 = db_fetch('assoc', $query);
		$amount = $l['sorder_amount'] + $l2['item_amount'];
		db_query('UPDATE storage SET item_amount="'.$amount.'" WHERE item_name="'.$l['sorder_name'].'"');
	}
	redirect(0, 'storage.php');
}
else if($mode == 'delete' && isset($id) && is_numeric($id))
{
	db_query('DELETE FROM storage WHERE item_id="'.$id.'"');
	redirect(0, 'storage.php');
}

include('engine/header.php'); #include <HEADER>
?>
<div class="menu">
	<div class="head">Deliveries for acceptance</div>
	<table class="dtable">
		<tr>
			<th>№</th><th>Item</th><th>Price</th><th>Amount</th><th>Category</th><th>Supplier</th><th>Options</th>
		</tr>
<?php			
$query = db_query('SELECT * FROM sorders WHERE sorder_added="0"');
$rows = db_num_rows($query);
while($l = db_fetch('assoc', $query))
{
	$l2 = db_fetch('assoc', db_query('SELECT * FROM categories WHERE category_id='.$l['sorder_catid']));
	$l3 = db_fetch('assoc', db_query('SELECT * FROM suppliers WHERE supplier_id='.$l['sorder_supid']));
	$add = '<a href="?mode=add&id='.$l['sorder_id'].'"><img src="style/images/add.png" width="15px" title="Add to storage"></a>';
	
	echo '<tr><td>'.$l['sorder_id'].'</td><td>'.$l['sorder_name'].'</td><td>'.$l['sorder_price'].'</td><td>'.$l['sorder_amount'].'</td><td>'.$l2['category_name'].'</td><td>'.$l3['supplier_name'].'</td><td>'.$add.'</td></tr>';
}
?>
	</table>
	<?=(!$rows ? 'There are no deliveries yet!' : 'Total deliveries!: '.$rows);?>
</div>
<?php
if($mode == 'edit' && isset($id) && is_numeric($id))
{
	if(isset($_POST['ipost']))
	{		
		$name = $_POST['name'];
		$price = $_POST['price'];
		$amount = $_POST['amount'];
		$category = $_POST['category'];
		
		if(empty($name)) $error_msg['name'] = 'Please, enter name!';
		if(empty($price)) $error_msg['price'] = 'Please, enter price!';
		
		if(empty($amount)) $error_msg['amount'] = 'Please, enter amount!';
		else if(!is_numeric($amount)) $error_msg['amount'] = 'Please, enter only numbers!';
		
		if(!d($error_msg, []))
		{
			db_query('UPDATE storage SET item_name="'.$name.'", item_price="'.$price.'", item_amount="'.$amount.'", item_catid="'.$category.'" WHERE item_id="'.$id.'"');
			redirect(0, 'storage.php');
		}
	}
	else
	{
		$l = db_fetch('assoc', db_query('SELECT * FROM storage WHERE item_id="'.$id.'"'));
		$name = $l['item_name'];
		$price = $l['item_price'];
		$amount = $l['item_amount'];
		$category = $l['item_catid'];
	}
	
	$categories = null;
	$query = db_query('SELECT * FROM categories');
	while($l2 = db_fetch('assoc', $query))
	{
		$categories .= '<option value="'.$l2['category_id'].'" '.($category == $l2['category_id'] ? 'selected="selected"' : '').'>'.$l2['category_name'].'</option>';
	}
?>
<div class="menu">
	<div class="head">Edit item</div>
	<form action="" method="post">
		<table class="dtable">
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
				<td class="right">Price per item [<?=$g_storage_currency;?>] <span class="error">*</span></td><td class="left"><input type="number" name="price" value="<?=$price;?>" step=".01"> <span class="error"><?=d($error_msg['price']);?></span></td>
			</tr>
			<tr>
				<td class="right">Брой <span class="error">*</span></td><td class="left"><input type="number" name="amount" value="<?=$amount;?>" min="1"> <span class="error"><?=d($error_msg['amount']);?></span></td>
			</tr>
		</table>
		<input type="button" value="Back" onclick="window.location = 'storage.php'"><input type="reset" value="Reset"> <input type="submit" name="ipost" value="Edit">
	</form>
</div>
<?php
}
?>
<div class="menu">
	<div class="head"><?=PAGE_NAME;?></div>
	<table class="dtable">
		<tr>
			<th>№</th><th>Item</th><th>Price</th><th>Amount</th><th>Category</th><th>Options</th>
		</tr>
<?php
$query = db_query('SELECT * FROM storage');
$rows = db_num_rows($query);
while($l = db_fetch('assoc', $query))
{
	$l2 = db_fetch('assoc', db_query('SELECT * FROM categories WHERE category_id='.$l['item_catid']));
	
	$edit = '<a href="?mode=edit&id='.$l['item_id'].'"><img src="style/images/edit.png" width="15px" title="Edit"></a>';
	$delete = '<a href="?mode=delete&id='.$l['item_id'].'"><img src="style/images/delete.png" width="15px" title="Delete"></a>';
	echo '<tr><td>'.$l['item_id'].'</td><td>'.$l['item_name'].'</td><td>'.$l['item_price'].' '.$g_storage_currency.'</td><td>'.$l['item_amount'].'</td><td>'.$l2['category_name'].'</td><td>'.$edit.' '.$delete.'</td></tr>';
}
?>
	</table>
	<?=(!$rows ? 'There are no items yet!' : 'Total items: '.$rows);?>
</div>
<?php
include('engine/footer.php'); #include <FOOTER>

/*===============================================================================*/
?>