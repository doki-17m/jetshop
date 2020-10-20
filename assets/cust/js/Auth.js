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

lgnForm.on('submit', function (e) {
	e.preventDefault();
	url = CUST_URL + AUTH + '/login';
	const formData = $(this).serialize();

	$.ajax({
		url: url,
		type: 'POST',
		data: formData,
		dataType: 'JSON',
		success: function(result) {
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

// $(function(){
	// $("#login").on("submit",function(e){
		// e.preventDefault();
		// var btn = $(".btn-success").html();
		// console.log('test')
		// $(".btn-success").html("<i class='la la-spin la-spinner'></i> Tunggu Sebentar...");
		// $.post("https://panel.bikin.online/ngadimin/auth",$(this).serialize(),function(msg){
		// 	var dt = eval("("+msg+")");
		// 	$(".btn-success").html(btn);
		// 	if(dt.success == true){
		// 		swal.fire("Berhasil!","selamat datang kembali "+dt.name,"success").then(function(){
		// 			window.location.href = "https://panel.bikin.online/ngadimin";
		// 		});
		// 	}else{
		// 		swal.fire("Gagal!","gagal masuk, cek kembali username & password anda","warning");
		// 	}
		// });
	// });
// });


function clearLgn() {
	errLPass.html(''),
	errLUsername.html(''),
	fillLPass.removeClass(isInvalid),
	fillLUsername.removeClass(isInvalid),
	fillLUsername.removeClass(isValid);
}
