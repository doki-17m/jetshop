const fillPVName = $('[name = prov_name]'),
	fillPVProvince = $('[name = prov_prov]');

btnNewProv.click(function () {
	url = SITE_URL + CREATE;
	Swal.fire({
		title: 'Get Province From Raja Ongkir',
		type: 'warning',
		showCancelButton: true,
		cancelButtonColor: '#d33',
		confirmButtonText: 'Start',
		cancelButtonText: 'Close',
		showLoaderOnConfirm: true,
		preConfirm: () => {
			return new Promise(function (resolve) {
				$.getJSON(url, function (response) {
						var html = '';
						if (response.includes('NR')) //New Records
							html += '<ol class="alert">' +
							'<li># New Records</li>' +
							'</ol>',
							Swal.fire({
								type: 'success',
								title: 'Process completed successfully',
								html: html
							}),
							reloadTable(LAST_URL);
						else if (response.length > 0)
							$.each(response, function (idx, elem) {
								var province = elem;
								html += '<ol class="alert">' +
									'<li>' + ' # ' + province + '</li>' +
									'</ol>';
							}),
							Swal.fire({
								type: 'success',
								title: 'Process completed successfully',
								html: html
							}),
							reloadTable(LAST_URL);
						else
							Swal.showValidationMessage(
								`Request failed: Data not found`
							),
							resolve(false);
					})
					.fail(function (jqXHR, textStatus, errorThrown) {
						Swal.showValidationMessage(
								`Request failed: Data not found`
							),
							resolve(false);
						console.info(errorThrown)
					});
			});
		},
		allowOutsideClick: () => !Swal.isLoading()
	}).then(result => {
		if (!result.value)
			console.info('Close')
	});
});

_tableProv.on('click', 'td:not(:last-child)', function (e) {
	e.preventDefault()
	const formID = provForm[0]['id'];
	const row = _tableProv.row(this).data();
	ID = row[0]; //index array ID
	var NAME = row[2];
	url = SITE_URL + SHOW + ID;

	openModalForm();
	modalTitle.html(NAME);
	isActive(formID);
	chkdProv();
	setSave = 'update';

	let form = modalForm.find('form');

	$.ajax({
		url: url,
		type: 'GET',
		async: false,
		cache: false,
		dataType: 'JSON',
		beforeSend: function () {
			$('.save_form').attr('disabled', true);
			$('#close_form1').attr('disabled', true);
			$('.close_form').attr('disabled', true);
			loadingForm(form.prop('id'), 'roundBounce');
		},
		complete: function () {
			$('.save_form').removeAttr('disabled');
			$('#close_form1').removeAttr('disabled');
			$('.close_form').removeAttr('disabled');
			hideLoadingForm(form.prop('id'));
		},
		success: function (result) {
			fillPVName.val(result.name);
			fillPVProvince.val(result.province);

			if (result.isactive == active)
				provActive.prop('checked', true),
				readonly(formID, false);
			else
				provActive.prop('checked', false),
				readonly(formID, true);

		}
	});
});

function chkdProv() { //checked
	fillPVName.prop('readonly', true),
		fillPVProvince.prop('readonly', true);
}

const fillCTName = $('[name = city_name]'),
	fillCTCity = $('[name = city_city]'),
	fillCTDist = $('[name = city_type]'),
	fillCTZip = $('[name = city_postal]'),
	fillCTProvince = $('[name = city_province]');

btnNewCity.click(function () {
	url = SITE_URL + CREATE;
	Swal.fire({
		title: 'Get City From Raja Ongkir',
		type: 'warning',
		showCancelButton: true,
		cancelButtonColor: '#d33',
		confirmButtonText: 'Start',
		cancelButtonText: 'Close',
		showLoaderOnConfirm: true,
		preConfirm: () => {
			return new Promise(function (resolve) {
				$.getJSON(url, function (response) {
						var html = '';
						if (response.includes('NR')) //New Records
							html += '<ol class="alert">' +
							'<li># New Records</li>' +
							'</ol>',
							Swal.fire({
								type: 'success',
								title: 'Process completed successfully',
								html: html
							}),
							reloadTable(LAST_URL);
						else if (response.length > 0)
							$.each(response, function (idx, elem) {
								var city = elem;
								html += '<ol class="alert">' +
									'<li>' + ' # ' + city + '</li>' +
									'</ol>';
							}),
							Swal.fire({
								type: 'success',
								title: 'Process completed successfully',
								html: html
							}),
							reloadTable(LAST_URL);
						else
							Swal.showValidationMessage(
								`Request failed: Data not found`
							),
							resolve(false);
					})
					.fail(function (jqXHR, textStatus, errorThrown) {
						Swal.showValidationMessage(
								`Request failed: Data not found`
							),
							resolve(false);
						console.info(errorThrown)
					});
			});
		},
		allowOutsideClick: () => !Swal.isLoading()
	}).then(result => {
		if (!result.value)
			console.info('Close')
	});
});

_tableCity.on('click', 'td:not(:last-child)', function (e) {
	e.preventDefault()
	const formID = cityForm[0]['id'];
	const row = _tableCity.row(this).data();
	ID = row[0]; //index array ID
	var NAME = row[2];
	url = SITE_URL + SHOW + ID;

	openModalForm();
	modalTitle.html(NAME);
	isActive(formID);
	chkdCity();
	setSave = 'update';

	let form = modalForm.find('form');

	$.ajax({
		url: url,
		type: 'GET',
		async: false,
		cache: false,
		dataType: 'JSON',
		beforeSend: function () {
			$('.save_form').attr('disabled', true);
			$('#close_form1').attr('disabled', true);
			$('.close_form').attr('disabled', true);
			loadingForm(form.prop('id'), 'roundBounce');
		},
		complete: function () {
			$('.save_form').removeAttr('disabled');
			$('#close_form1').removeAttr('disabled');
			$('.close_form').removeAttr('disabled');
			hideLoadingForm(form.prop('id'));
		},
		success: function (result) {
			fillCTName.val(result.name);
			fillCTCity.val(result.city);
			fillCTDist.val(result.type);
			fillCTZip.val(result.postal);
			fillCTProvince.val(result.province);

			if (result.isactive == active)
				cityActive.prop('checked', true),
				readonly(formID, false);
			else
				cityActive.prop('checked', false),
				readonly(formID, true);

		}
	});
});

function chkdCity() { //checked
	fillCTName.prop('readonly', true),
		fillCTCity.prop('readonly', true);
	fillCTDist.prop('readonly', true);
	fillCTZip.prop('readonly', true);
	fillCTProvince.prop('readonly', true);
}
