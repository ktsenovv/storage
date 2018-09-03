<?php
include('configs.php'); #include <CONFIGS>

/*=================================================================================
 [Functions]
=================================================================================*/

// Default
function d(&$item)
{
    return (!empty($item)) ? $item : null;
}

// Function Database Connect
$connect = @mysqli_connect($g_db_server, $g_db_user, $g_db_password, $g_db_name, $g_db_port);
db_query('set names '.$g_db_charset);

// Function Database Disconnect
function db_disconnect()
{
	global $connect;
	if($connect) return mysqli_close($connect);
}

// Function Database Query
function db_query($query)
{
	return mysqli_query($GLOBALS['connect'], $query);
}

// Function Database Fetch Assoc/Array
function db_fetch($type, $query)
{
	if($query == null) return;
	
	switch($type)
	{
		case 'assoc': return mysqli_fetch_assoc($query); break;
		case 'array': return mysqli_fetch_array($query); break;
	}
}

// Function Database Num Rows
function db_num_rows($query)
{
	if($query == null) return;
	
	return mysqli_num_rows($query);
}

// Function Adress Redirect
function redirect($time = 0, $url = '')
{	
	(!$time) ? $time = 'Location: http://' : $time = 'Refresh: '.$time.'; http://';
	(!$url) ? $url = $_SERVER['REQUEST_URI'] : $url = rtrim(dirname($_SERVER['PHP_SELF']), '/\\').'/'.$url;
	(!$time) ? exit(header($time.$_SERVER['HTTP_HOST'].$url)) : header($time.$_SERVER['HTTP_HOST'].$url);
}

/*===============================================================================*/
?>