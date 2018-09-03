<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?=$g_project_name.$g_project_split.PAGE_NAME?></title>
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width; initial-scale=1.0">
		<link href="style/style.css" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="style/jquery-3.3.1.min.js"></script>
<script>
$(document).ready(function()
{
	// Navigation
	$("#nav span").click(function()
	{
		$("#nav ul ul").slideUp();
		
		if(!$(this).next().is(":visible"))
		{
			$(this).next().slideDown();
		}
	});
	
	// Dynamic items by category
	$('#category').change(function()
	{
		var catid = $(this).val();
		$.ajax({
			url: 'corders_items.php',
			type: 'POST',
			data: {category: catid},
			dataType: 'json',
			success: function(result)
			{
				$('#name').find('option').remove().end();
				for(var i = 0; i <= result.item_num; i++)
				{
					if(i == 0) $('#name').append('<option value="'+i+'" selected disabled>- Select item -</option>');
					else $('#name').append('<option value="'+result.item_name[i]+'">'+result.item_name[i]+'</option>');
				}
			}
		});
	});
	
	// Dynamic items info
	$('#name').change(function()
	{
		var name = $(this).val();
		$.ajax({
			url: 'corders_items_info.php',
			type: 'POST',
			data: {name: name},
			dataType: 'json',
			success: function(result)
			{
				$('input[name="price"]').val(result.item_price);
				$('input[name="amount"]').val(result.item_amount);
				
				$('#amount').find('option').remove().end();
				for(var i = 0; i <= result.item_amount; i++)
				{
					if(i == 0) $('#amount').append('<option value="'+i+'" selected disabled>- Select amount -</option>');
					else $('#amount').append('<option value="'+i+'">'+i+'</option>');
				}
			}
		});
	});
});
</script>
	</head>
	<body>
		<main>
			<header></header>
			<div id="content">
				<div id="content-left">
					<div id="nav">
						<ul>
							<li><div><a href="index.php">Home</a></div></li>
							<li><div><a href="categories.php">Categories</a></div></li>
							<li><span>Suppliers</span>
								<ul>
									<li><a href="suppliers.php">Suppliers</a></li>
									<li><a href="sorders.php">Orders</a></li>
								</ul>
							</li>
							<li><div><a href="storage.php">Storage</a></div></li>
							<li><span>Clients</span>
								<ul>
									<li><a href="clients.php">Clients</a></li>
									<li><a href="corders.php">Orders</a></li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
				<div id="content-right">