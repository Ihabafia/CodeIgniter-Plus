$(document).ready(function ()
{

});

/*$.fn.checkSession = (function ()
{
	$.getJSON('/auth/checkSession', function (json, handle)
	{
		if ( json.session == "Expired" )
		{
			window.location.replace("/login");
		}
	});
});*/

$.fn.checkSession = function() {
	$.getJSON('/auth/checkSession', function (json, handle)
	{
		if ( json.session == "Expired" )
		{
			window.location.href = "/login";
		}
	});
};

$.fn.mC = (function (data)
{
	switch (data)
	{
		case 'w':
			return 'alert-warning';
			break;
		case 's':
			return 'alert-success';
			break;
		case 'e':
			return 'alert-danger';
			break;
		case '1':
			return 'text-danger';
			break;
		case '2':
			return 'text-warning';
			break;
		case '3':
			return 'text-primary';
			break;
		case '4':
			return 'text-info';
			break;
		default:
			return 'hidden';
	}
});

$.fn.removeSuccessMessage = function (dur)
{
	dur = dur || 6000;

	var dfd = $.Deferred();
	if ( $('#message').attr('class').indexOf('alert-success') > -1 )
	{
		setTimeout(function ()
		{
			$('#message').slideUp(dur / 3.333);
			setTimeout(function ()
			{
				$('#message').addClass('hidden');
				$('#message').css('display', '');
				$('#message').removeClass('alert-success');
				$('#messageTitle').html('');
				$('#messageBody').html('');
				dfd.resolve();
			}, dur / 2.73);
		}, dur);
	}
	return dfd.promise();
};

$.fn.removeMessage = function (){

	$('#message').addClass('hidden');
	$('#message').css('display', '');
	$('#message').removeClass('alert-success');
	$('#message').removeClass('alert-warning');
	$('#message').removeClass('alert-danger');
	$('#messageTitle').html('');
	$('#messageBody').html('');

};

