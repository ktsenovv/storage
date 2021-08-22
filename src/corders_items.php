<?php
include('engine/core.php'); #include <ENGINE>

/*===============================================================================*/

if(isset($_POST['category']))
{
    $query = db_query('SELECT * FROM storage WHERE item_catid="'.$_POST['category'].'"');
    $num_rows = db_num_rows($query);
	$num = 1;
	while($row = db_fetch('assoc', $query))
	{
		$item_names[$num++] = $row['item_name'];
	}
	echo json_encode(array('item_name' => $item_names, 'item_num' => $num_rows));
}
?>