const fillLUsername = $('[name = lgn_username]'),
	fillLPass = $('[name = lgn_pass]');

const errLUsername = $('#error_lgn_username'),
	errLPass = $('#error_lgn_pass');

fillLUsername.on('keyup', function (e) {
	let value = $(this).val();
	url = CUST_URL + AUTH + '/check_username/' + value;
	if (value)
		$.getJSON(url, function(result) {
			if (result)
				errLUsername.empty(),
				fillLUsername.removeClass(isInvalid),
				fillLUsername.addClass(isValid);
			else
				fillLUsername.addClass(isInvalid);
		});
	else
		errLUsername.empty(),
		fillLUsername.removeClass(isValid),
		fillLUsername.removeClass(isInvalid);
});

btnLogin.click(function (e) {
	url = CUST_URL + AUTH + '/login';
	const formData = lgnForm.serialize();

	$.ajax({
		url: url,
		type: 'POST',
		data: formData,
		dataType: 'JSON',
		success: function(result) {
			console.log(result)
			if (result.success)
				lgnForm[0].reset(),
				clearLgn(),
				window.location = CUST_URL;
			else
				clearLgn(),
				Swal.fire({
					type: 'error',
					title: 'Login failed',
					text: 'Wrong username or password'
				});

			if (result.error) {
				if (result.error_lgn_pass != '')
					errLPass.html(result.error_lgn_pass),
					fillLPass.addClass(isInvalid);
				else
					errLPass.html(''),
					fillLPass.removeClass(isInvalid);

				if (result.error_lgn_username !== '')
					errLUsername.html(result.error_lgn_username),
					fillLUsername.addClass(isInvalid);
				else
					errLUsername.html(''),
					fillLUsername.removeClass(isInvalid);

				Swal.fire({
					type: 'warning',
					title: 'Oops...',
					text: 'Required username and password',
					timer: 1000
				});
			} else {
				clearLgn();
			}
		}
	});
});


function clearLgn() {
	errLPass.html(''),
	errLUsername.html(''),
	fillLPass.removeClass(isInvalid),
	fillLUsername.removeClass(isInvalid),
	fillLUsername.removeClass(isValid);
}
