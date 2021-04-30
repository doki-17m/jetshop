const fillSRCc = $('[name = sup_code]'),
	fillSRName = $('[name = sup_name]'),
	fillSRGre = $('[name = sup_greeting]'),
	fillSREmail = $('[name = sup_email]'),
	fillSRAddress = $('[name = sup_address]'),
	fillSRPhone = $('[name = sup_phone]'),
	fillSRPhone2 = $('[name = sup_phone2]'),
	fillSRSales = $('[name = sup_sales]'),
	fillSRDesc = $('[name = sup_desc]');

//error field form
const errSRCc = $('#error_sup_code'),
	errSRName = $('#error_sup_name'),
	errSREmail = $('#error_sup_email'),
	errSRAddress = $('#error_sup_address'),
	errSRPhone = $('#error_sup_phone');

supGreeting(); //Show data all greeting

btnNewSup.click(function () {
	openModalForm();
	Largemodal();
	Scrollmodal();
	modalTitle.text('New Supplier');
	clearSup();
	supActive.prop('checked', true);
	formID = supForm[0]['id'];
	isActive(formID);
	setSave = 'add';
});

_tableSup.on('click', 'td:not(:last-child)', function (e) {
	e.preventDefault()
	const formID = supForm[0]['id'];
	const row = _tableSup.row(this).data();
	ID = row[0]; //index array ID
	let NAME = row[3];
	openModalForm();
	Largemodal();
	Scrollmodal();
	modalTitle.html('Supplier : ' + NAME);
	isActive(formID);
	clearSup();
	url = SITE_URL + SHOW + ID;
	setSave = 'update';

	let form = modalForm.find('form');

	$.ajax({
		url: url,
		type: 'GET',
		async: false,
		cache: false,
		dataType: 'JSON',
		beforeSend: function () {
			$('#save_form').attr('disabled', true);
			$('#close_form1').attr('disabled', true);
			$('#close_form').attr('disabled', true);
			loadingForm(form.prop('id'), 'roundBounce');
		},
		complete: function () {
			$('#save_form').removeAttr('disabled');
			$('#close_form1').removeAttr('disabled');
			$('#close_form').removeAttr('disabled');
			hideLoadingForm(form.prop('id'));
		},
		success: function (result) {
			fillSRCc.val(result.value),
				fillSRGre.val(result.m_greeting_id).change(),
				fillSRName.val(result.name),
				fillSREmail.val(result.email),
				fillSRAddress.val(result.address),
				fillSRPhone.val(result.phone),
				fillSRPhone2.val(result.phone2)
			fillSRDesc.val(result.description);

			if (result.isactive == active)
				supActive.prop('checked', true),
				readonly(formID, false);
			else
				supActive.prop('checked', false),
				readonly(formID, true);
		}
	});

});

function errFormSup(data) {
	if (data.error_sup_code != '')
		errSRCc.html(data.error_sup_code),
		fillSRCc.addClass(isInvalid);
	else
		errSRCc.html(''),
		fillSRCc.removeClass(isInvalid);

	if (data.error_sup_name != '')
		errSRName.html(data.error_sup_name),
		fillSRName.addClass(isInvalid);
	else
		errSRName.html(''),
		fillSRName.removeClass(isInvalid);

	if (data.error_sup_email != '')
		errSREmail.html(data.error_sup_email),
		fillSREmail.addClass(isInvalid);
	else
		errSREmail.html(''),
		fillSREmail.removeClass(isInvalid);

	if (data.error_sup_address != '')
		errSRAddress.html(data.error_sup_address),
		fillSRAddress.addClass(isInvalid);
	else
		errSRAddress.html(''),
		fillSRAddress.removeClass(isInvalid);

	if (data.error_sup_phone != '')
		errSRPhone.html(data.error_sup_phone),
		fillSRPhone.addClass(isInvalid);
	else
		errSRPhone.html(''),
		fillSRPhone.removeClass(isInvalid);
}

function clearSup() {
	supForm[0].reset(),
		errSRCc.html(''),
		errSRName.html(''),
		errSREmail.html(''),
		errSRAddress.html(''),
		errSRPhone.html(''),
		fillSRGre.val(null).change(),
		fillSRCc.removeClass(isInvalid),
		fillSRName.removeClass(isInvalid),
		fillSREmail.removeClass(isInvalid),
		fillSRAddress.removeClass(isInvalid),
		fillSRPhone.removeClass(isInvalid);
}

function chkdSup() { //checked
	fillSRCc.prop('readonly', true),
		fillSRGre.prop('disabled', true),
		fillSRName.prop('readonly', true),
		fillSREmail.prop('readonly', true),
		fillSRAddress.prop('readonly', true),
		fillSRPhone.prop('readonly', true),
		fillSRPhone2.prop('readonly', true),
		fillSRSales.prop('disabled', true),
		fillSRDesc.prop('readonly', true);
}

function unchkdSup() { //unchecked
	fillSRCc.prop('readonly', false),
		fillSRGre.prop('disabled', false),
		fillSRName.prop('readonly', false),
		fillSREmail.prop('readonly', false),
		fillSRAddress.prop('readonly', false),
		fillSRPhone.prop('readonly', false),
		fillSRPhone2.prop('readonly', false),
		fillSRSales.prop('disabled', false),
		fillSRDesc.prop('readonly', false);
}

function supGreeting() {
	url = CUST_URL + GREETING + '/showGreeting';

	$.getJSON(url, function (response) {
		fillSRGre.append('<option selected="selected" value="">-- Choose One --</option>');
		$.each(response, function (idx, elem) {
			var greeting_id = elem.m_greeting_id;
			var greeting_name = elem.name;
			fillSRGre.append('<option value="' + greeting_id + '">' + greeting_name + '</option>');
		});
	});
}
