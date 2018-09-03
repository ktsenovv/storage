<?php
include('engine/core.php'); #include <ENGINE>
define('PAGE_NAME', 'Categories'); // Define Page Name

/*===============================================================================*/

$name = null;
$action = 'Add';

$id = null; if(isset($_GET['id'])) $id = $_GET['id'];
$mode = null; if(isset($_GET['mode'])) $mode = $_GET['mode'];

if($mode == 'edit' && isset($id) && is_numeric($id))
{
	$query = db_query('SELECT * FROM categories WHERE category_id="'.$id.'"');
	$l = db_fetch('assoc', $query);
	$name = $l['category_name'];
	
	$action = 'Edit';
}
else if($mode == 'delete' && isset($id) && is_numeric($id))
{
	db_query('DELETE FROM categories WHERE category_id="'.$id.'"');
	redirect(0, 'categories.php');
}

if(isset($_POST['ipost']))
{
	$name = $_POST['name'];
	
	if(empty($name)) $error_msg['name'] = 'Please, enter name!';
	
	if(!d($error_msg, []))
	{
		if($mode != 'edit') db_query('INSERT INTO categories(category_name) VALUES("'.$name.'")');
		else db_query('UPDATE categories SET category_name="'.$name.'" WHERE category_id="'.$id.'"');
		redirect(0, 'categories.php');
	}
}

include('engine/header.php'); #include <HEADER>
?>
<div class="menu">
	<div class="head"><?=$action;?> category</div>
	<form action="" method="post">
		<table class="dtable">
			<tr>
				<td class="right">Name <span class="error">*</span></td><td class="left"><input type="text" name="name" value="<?=$name;?>"> <span class="error"><?=d($error_msg['name']);?></span></td>
			</tr>
		</table>
		<?=($mode == 'edit' ? '<input type="button" value="Back" onclick="window.location = \'categories.php\'"> ' : null)?><input type="reset" value="Reset"> <input type="submit" name="ipost" value="<?=$action;?>">
	</form>
</div>
<div class="menu">
	<div class="head"><?=PAGE_NAME;?></div>
	<table class="dtable">
		<tr>
			<th width="5%">№</th><th width="85%">Name</th><th width="10%">Options</th>
		</tr>
<?php
$query = db_query('SELECT * FROM categories ORDER BY category_id');
$rows = db_num_rows($query);
while($l = db_fetch('assoc', $query))
{
	$edit = '<a href="?mode=edit&id='.$l['category_id'].'"><img src="style/images/edit.png" width="15px" title="Edit" /></a>';
	$delete = '<a href="?mode=delete&id='.$l['category_id'].'"><img src="style/images/delete.png" width="15px" title="Delete" /></a>';
	echo '<tr><td>'.$l['category_id'].'</td><td>'.$l['category_name'].'</td><td>'.$edit.' '.$delete.'</td></tr>';
}
?>
	</table>
	<?=(!$rows ? 'There are no categories yet!' : 'Total categories: '.$rows);?>
</div>
<?php
include('engine/footer.php'); #include <FOOTER>

/*===============================================================================*/
?>