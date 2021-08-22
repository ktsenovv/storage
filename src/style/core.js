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