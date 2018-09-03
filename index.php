<?php
include('engine/core.php'); #include <ENGINE>
define('PAGE_NAME', 'Home'); // Define Page Name

/*===============================================================================*/

include('engine/header.php'); #include <HEADER>
?>
<div class="menu">
	<div class="head"><?=PAGE_NAME;?></div>
	<div style="text-align: justify;">
		Welcome to <?=$g_project_name;?>. This project was designed to imitate computer storage. You can add, edit and delete suppliers, orders from suppliers, clients, orders for clients and to approve deliveries. Because this is the first version of the project, it may not work properly!
		<br /><br />The following languages are used for the project creation: HTML, CSS, PHP, jQuery (Javascript library) and SQL.
	</div>
</div>
<?php
include('engine/footer.php'); #include <FOOTER>

/*===============================================================================*/
?>