const fillCOCode = $('[name = cou_code]'),
	fillCOName = $('[name = cou_name]'),
	fillCODesc = $('[name = cou_desc]');

//error field form
const errCOCode = $('#error_cou_code'),
	errCOName = $('#error_cou_name');

btnNewCou.click(function () {
	openModalForm();
	Scrollmodal();
	modalTitle.text('New Courier');
	clearCou();
	couActive.prop('checked', true);

	const formID = couForm[0]['id'];
	isActive(formID);

	setSave = 'add';
});

_tableCou.on('click', 'td:not(:last-child)', function (e) {
	e.preventDefault()
	const formID = couForm[0]['id'];
	const row = _tableCou.row(this).data();
	ID = row[0]; //index array ID
	var NAME = row[2];
	url = SITE_URL + SHOW + ID;

	openModalForm();
	Scrollmodal();
	modalTitle.html(NAME);
	clearCou();
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
			fillCOCode.val(result.value);
			fillCOName.val(result.name);
			fillCODesc.val(result.description);

			if (result.isactive == active)
				couActive.prop('checked', true),
				readonly(formID, false);
			else
				couActive.prop('checked', false),
				readonly(formID, true);

		}
	});
});

function errFormCou(data) {
	if (data.error_cou_code != '')
		errCOCode.html(data.error_cou_code),
		fillCOCode.addClass(isInvalid);

	else
		errCOCode.html(''),
		fillCOCode.removeClass(isInvalid);

	if (data.error_cou_name != '')
		errCOName.html(data.error_cou_name),
		fillCOName.addClass(isInvalid);

	else
		errCOName.html(''),
		fillCOName.removeClass(isInvalid);
}

function clearCou() {
	couForm[0].reset();
	errCOCode.html(''),
		errCOName.html(''),
		fillCOCode.removeClass(isInvalid),
		fillCOName.removeClass(isInvalid);
}

function chkdCou() { //checked
	fillCOCode.prop('readonly', true),
		fillCOName.prop('readonly', true),
		fillCODesc.prop('readonly', true);
}

function unchkdCou() { //unchecked
	fillCOCode.prop('readonly', false),
		fillCOName.prop('readonly', false),
		fillCODesc.prop('readonly', false);
}
