<?php
include('engine/core.php'); #include <ENGINE>
define('PAGE_NAME', 'Orders for clients'); // Define Page Name

/*===============================================================================*/

$name = null;
$price = null;
$amount = null;
$category = null;
$client = null;

$id = null; if(isset($_GET['id'])) $id = $_GET['id'];
$mode = null; if(isset($_GET['mode'])) $mode = $_GET['mode'];

if($mode == 'delete' && isset($id) && is_numeric($id))
{
	db_query('DELETE FROM corders WHERE corder_id="'.$id.'"');
	redirect(0, 'corders.php');
}

if(isset($_POST['ipost']))
{
	$name = d($_POST['name']);
	$price = $_POST['price'];
	$amount = d($_POST['amount']);
	$client = $_POST['client'];
	
	if(empty($name)) $error_msg['name'] = 'Please, select item!';
	if(empty($price)) $error_msg['price'] = 'Please, enter price!';
	
	if(empty($amount)) $error_msg['amount'] = 'Please, select amount!';
	else if(!is_numeric($amount)) $error_msg['amount'] = 'Please, select valid number!';
	
	if(!d($error_msg, []))
	{
		if($mode != 'edit')
		{
			$l = db_fetch('assoc', db_query('SELECT * FROM storage WHERE item_name="'.$name.'"'));
			$l['item_amount'] -= $amount;
			db_query('UPDATE storage SET item_amount="'.$l['item_amount'].'" WHERE item_name="'.$name.'"');
			db_query('INSERT INTO corders(corder_name, corder_price, corder_amount, corder_catid, corder_cntid) VALUES("'.$name.'", "'.$price.'", "'.$amount.'", "'.$l['item_catid'].'", "'.$client.'")');
		}
		else db_query('UPDATE corders SET corder_name="'.$name.'", corder_price="'.$price.'", corder_amount="'.$amount.'", corder_catid="'.$category.'", corder_cntid="'.$client.'" WHERE corder_id="'.$id.'"');
		redirect(0, 'corders.php');
	}
}

$clients = null;
$query = db_query('SELECT * FROM clients');
while($l = db_fetch('assoc', $query))
{
	$clients .= '<option value="'.$l['client_id'].'" '.($client == $l['client_id'] ? 'selected="selected"' : '').'>'.$l['client_name'].'</option>';
}

$query = db_query('SELECT * FROM storage');
while($l = db_fetch('assoc', $query))
{
	$categories[] = $l['item_catid'];
}

$category = null;
$query = db_query('SELECT * FROM categories');
while($l = db_fetch('assoc', $query))
{
	if(in_array($l['category_id'], $categories)) $category .= '<option value="'.$l['category_id'].'">'.$l['category_name'].'</option>';
}

include('engine/header.php'); #include <HEADER>
?>
<div class="menu">
	<div class="head">Add order</div>
	<form action="" method="post">
		<table class="dtable">
			<tr>
				<td class="right">Client</td>
				<td class="left">
					<select name="client">
						<?=$clients;?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="right">Category</td>
				<td class="left">
					<select name="category" id="category">
						<option value="0" selected disabled>- Select -</option>
						<?=$category;?>
					</select> <span class="error"><?=d($error_msg['category']);?></span>
				</td>
			</tr>
			<tr>
				<td class="right">Item</td>
				<td class="left">
					<select name="name" id="name">
						<option value="0" selected disabled>- Select category first -</option>
					</select> <span class="error"><?=d($error_msg['name']);?></span>
				</td>
			</tr>
			<tr>
				<td class="right">Price per item [<?=$g_project_currency;?>] <span class="error">*</span></td><td class="left"><input type="number" name="price" value="<?=$price;?>" min="0" step=".01"> <span class="error"><?=d($error_msg['price']);?></span></td>
			</tr>
			<tr>
				<td class="right">Amount</td>
				<td class="left">
					<select name="amount" id="amount">
						<option value="0" selected disabled>- Select item first -</option>
					</select>  <span class="error"><?=d($error_msg['amount']);?></span>
				</td>
			</tr>
		</table>
		<input type="reset" value="Reset"> <input type="submit" name="ipost" value="Add">
	</form>
</div>
<div class="menu">
	<div class="head"><?=PAGE_NAME;?></div>
	<table class="dtable">
		<tr>
			<th>№</th><th>Item</th><th>Price</th><th>Amount</th><th>Category</th><th>Client</th><th>Options</th>
		</tr>
<?php
$query = db_query('SELECT * FROM corders ORDER BY corder_id DESC');
$rows = db_num_rows($query);
while($l = db_fetch('assoc', $query))
{
	$l2 = db_fetch('assoc', db_query('SELECT * FROM categories WHERE category_id='.$l['corder_catid']));
	$l3 = db_fetch('assoc', db_query('SELECT * FROM clients WHERE client_id='.$l['corder_cntid']));
	$delete = '<a href="?mode=delete&id='.$l['corder_id'].'"><img src="style/images/delete.png" width="15px" title="Delete"></a>';
	
	echo '<tr><td>'.$l['corder_id'].'</td><td>'.$l['corder_name'].'</td><td>'.$l['corder_price'].' '.$g_project_currency.'</td><td>'.$l['corder_amount'].'</td><td>'.$l2['category_name'].'</td><td>'.$l3['client_name'].'</td><td>'.$delete.'</td></tr>';
}
?>
	</table>
	<?=(!$rows ? 'There are no orders yet!' : 'Total orders: '.$rows);?>
</div>
<?php
include('engine/footer.php'); #include <FOOTER>

/*===============================================================================*/
?>