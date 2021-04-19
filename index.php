<?php
include('engine/core.php'); #include <ENGINE>
define('PAGE_NAME', 'Home'); // Define Page Name

/*===============================================================================*/

include('engine/header.php'); #include <HEADER>
?>
<div class="menu">
	<div class="head"><?=PAGE_NAME;?></div>
	<div style="text-align: justify;">
		Welcome to <?=$g_storage_name;?>. This project is designed to imitate storage of computer shop. You can add, edit and delete suppliers, orders from suppliers, clients, orders from clients and to approve deliveries.
		<br /><br />The following languages are used for the project creation: HTML, CSS, PHP, jQuery and SQL.
	</div>
</div>
<?php
include('engine/footer.php'); #include <FOOTER>

/*===============================================================================*/
?>