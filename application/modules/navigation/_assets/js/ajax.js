$(document).ready(function ()
{
	var url, json = {};

	/***************************************************
	* jQ 		Prepare to Delete a Menu Item		   *
	****************************************************/
	$(".delnav").click(function (event)
	{
		event.preventDefault();

		$(this).checkSession();

		var url = $(this).attr('id').split('-');

		var json = {};

		json.nav_id = url[1]

		$('input[name=id]').val(json.nav_id);

		$('#delNavMod').modal('show');

	});

	$('#delNavBtn').click(function (event)
	{
		event.preventDefault();

		$(this).checkSession();

		$('#messageTitle').text('');
		$('#messageBody').text('');
		$('#message').removeClass('alert-success');
		$('#message').removeClass('alert-danger');
		$('#message').addClass('hidden');
		nId = $('input[name=id]').val();

		doDelete(nId);
		$('#delNavMod').modal('hide');
	});

	/***************************************************
	* Aj 		  Do Delete the Menu Item              *
	****************************************************/
	var doDelete = function (nId)
	{
		$.ajax({
			type    : 'POST',
			url     : '/navigation/navDelete',
			data    : { nav_id: nId },
			dataType: 'json',
			cache   : false,
			timeout : 7000,
			success : function (data)
			{
				window.location.href = "/navigation";
			},
			error   : function (XMLHttpRequest, textStatus, errorThrown)
			{

			},
			complete: function (XMLHttpRequest, status)
			{

			}
		});
	}
});
