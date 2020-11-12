const fillLUsername = $('[name = lgn_username]'),
	fillLPass = $('[name = lgn_pass]');

const fillCGOldPass = $('[name= chg_oldpass]'),
	fillCGNewPass = $('[name = chg_newpass]'),
	fillCGConfPass = $('[name= chg_confpass]');

const errLUsername = $('#error_lgn_username'),
	errLPass = $('#error_lgn_pass');

const errCGOldPass = $('#error_chg_oldpass'),
	errCGNewPass = $('#error_chg_newpass'),
	errCGConfPass = $('#error_chg_confpass');

fillLUsername.on('keyup', function (e) {
	let value = $(this).val();
	url = CUST_URL + AUTH + '/check_username/' + value;
	if (value)
		$.getJSON(url, function (result) {
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

lgnForm.on('submit', function (e) {
	e.preventDefault();
	url = CUST_URL + AUTH + '/login';
	const formData = $(this).serialize();

	$.ajax({
		url: url,
		type: 'POST',
		data: formData,
		dataType: 'JSON',
		success: function (result) {
			if (result.success)
				lgnForm[0].reset(),
				clearLogin(),
				window.location = CUST_URL;
			else
				clearLogin(),
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
				clearLogin();
			}
		}
	});
});

btnSList.click(function (e) {
	e.preventDefault();
	const formData = chgForm.serialize();
	url = CUST_URL + USER + '/editPassword';

	$.ajax({
		url: url,
		type: 'POST',
		data: formData + '&id=' + ID,
		dataType: 'JSON',
		success: function (result) {

			if (result.success)
				Toast.fire({
					type: 'success',
					title: result.message
				}),
				clearChgPass(),
				modalList.modal('hide');

			if (result.error)
				errFormChg(result)
		}
	});
});

function changePass(id) {
	ID = id;

	url = CUST_URL + USER + '/show/' + ID;
	$.getJSON(url, function (response) {
		var NAME = response.value;
		modalTitle.html(NAME);
		Removemodal();
		openModalList();
		clearChgPass();
	});
}

function errFormChg(data) {
	if (data.error_chg_oldpass != '')
		errCGOldPass.html(data.error_chg_oldpass),
		fillCGOldPass.addClass(isInvalid);
	else
		errCGOldPass.html(''),
		fillCGOldPass.removeClass(isInvalid);

	if (data.error_chg_newpass != '')
		errCGNewPass.html(data.error_chg_newpass),
		fillCGNewPass.addClass(isInvalid);
	else
		errCGNewPass.html(''),
		fillCGNewPass.removeClass(isInvalid);

	if (data.error_chg_confpass != '')
		errCGConfPass.html(data.error_chg_confpass),
		fillCGConfPass.addClass(isInvalid);
	else
		errCGConfPass.html(''),
		fillCGConfPass.removeClass(isInvalid);
}

function clearChgPass() {
	chgForm[0].reset(),
		errCGOldPass.html(''),
		errCGNewPass.html(''),
		errCGConfPass.html(''),
		fillCGOldPass.removeClass(isInvalid),
		fillCGNewPass.removeClass(isInvalid),
		fillCGConfPass.removeClass(isInvalid);
}

function clearLogin() {
	errLPass.html(''),
		errLUsername.html(''),
		fillLPass.removeClass(isInvalid),
		fillLUsername.removeClass(isInvalid),
		fillLUsername.removeClass(isValid);
}
