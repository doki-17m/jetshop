const fillUCd = $('[name = uom_code]'),
	fillUName = $('[name = uom_name]'),
	fillUDesc = $('[name = uom_desc]');

//error field form
const errUCd = $('#error_uom_code'),
	errUName = $('#error_uom_name');

btnNewUom.click(function () {
	openModalForm();
	Scrollmodal();
	modalTitle.text('New Uom');
	clearUom();
	uomActive.prop('checked', true);

	const formID = uomForm[0]['id'];
	isActive(formID);

	setSave = 'add';
});

_tableUom.on('click', 'td:not(:last-child)', function (e) {
	e.preventDefault()
	const formID = uomForm[0]['id'];
	const row = _tableUom.row(this).data();
	ID = row[0]; //index array ID
	var NAME = row[2];
	url = SITE_URL + SHOW + ID;

	openModalForm();
	Scrollmodal();
	modalTitle.html(NAME);
	clearUom();
	isActive(formID);

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
			fillUCd.val(result.value);
			fillUName.val(result.name);
			fillUDesc.val(result.description);

			if (result.isactive == active)
				uomActive.prop('checked', true),
				readonly(formID, false);
			else
				uomActive.prop('checked', false),
				readonly(formID, true);

		}
	});
});

function errFormUom(data) {
	if (data.error_uom_code != '')
		errUCd.html(data.error_uom_code),
		fillUCd.addClass(isInvalid);

	else
		errUCd.html(''),
		fillUCd.removeClass(isInvalid);

	if (data.error_uom_name != '')
		errUName.html(data.error_uom_name),
		fillUName.addClass(isInvalid);

	else
		errUName.html(''),
		fillUName.removeClass(isInvalid);
}

function clearUom() {
	uomForm[0].reset();
	errUCd.html(''),
		errUName.html(''),
		fillUCd.removeClass(isInvalid),
		fillUName.removeClass(isInvalid);
}

function chkdUom() { //checked
	fillUCd.prop('readonly', true),
		fillUName.prop('readonly', true),
		fillUDesc.prop('readonly', true);
}

function unchkdUom() { //unchecked
	fillUCd.prop('readonly', false),
		fillUName.prop('readonly', false),
		fillUDesc.prop('readonly', false);
}
