<?php
include('engine/core.php'); #include <ENGINE>

/*===============================================================================*/

if(isset($_POST['name']))
{
    $query = db_query('SELECT * FROM storage WHERE item_name="'.$_POST['name'].'"');
    $num_rows = db_num_rows($query);
    if($num_rows > 0) {
        $row = db_fetch('assoc', $query);
        echo json_encode(array('item_price' => $row['item_price'], 'item_amount' => $row['item_amount']));
    }
}
?>