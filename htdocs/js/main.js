$(function() 
{
	$('.info-questionmark').click (function () 
	{
		var id = $(this).attr('id');
		
		$('#'+ id + '_box').toggle('fast');
		
	});
	
	$('.alpha-separator').click (function () 
	{
		var id = $(this).attr('id');
		
		$(this).toggleClass('alpha-separator-selected');
		
		$('#'+ id + '_block').toggle('fast');
	});

	$('.lnk_author_name').click (function () 
	{
		var author_name = $(this).html();

		$('#hid_author_name').val(author_name);
		
		$("#get_author_data").submit();
	});
	
	$('.lnk_title_name').click (function () 
	{
		var title = $(this).html();

		$('#hid_title_name').val(title);
		
		$("#get_author_data").submit();
	});

//$(".message").fadeOut(10000);


});
