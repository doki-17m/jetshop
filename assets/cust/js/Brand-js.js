const fillBSk = $('[name = bra_sk]'),
	fillBName = $('[name = bra_name]'),
	fillBDesc = $('[name = bra_desc]');

//error field form
const errBSk = $('#error_bra_sk'),
	errBName = $('#error_bra_name');

btnNewBra.click(function () {
	openModalForm();
	Scrollmodal();
	modalTitle.text('New Brand');
	clearBra();
	braActive.prop('checked', true);
	const formID = braForm[0]['id'];
	isActive(formID);

	setSave = 'add';
});

_tableBrand.on('click', 'td:not(:last-child)', function (e) {
	e.preventDefault()
	const formID = braForm[0]['id'];
	const row = _tableBrand.row(this).data();
	ID = row[0]; //index array ID
	var NAME = row[2];
	url = SITE_URL + SHOW + ID;

	openModalForm();
	Scrollmodal();
	modalTitle.html(NAME);
	clearBra();
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
			fillBSk.val(result.value);
			fillBName.val(result.name);
			fillBDesc.val(result.description);

			if (result.isactive == active)
				braActive.prop('checked', true),
				readonly(formID, false);
			else
				braActive.prop('checked', false),
				readonly(formID, true);
		}
	});
});

function errFormBra(data) {
	if (data.error_bra_sk != '')
		errBSk.html(data.error_bra_sk),
		fillBSk.addClass(isInvalid);

	else
		errBSk.html(''),
		fillBSk.removeClass(isInvalid);

	if (data.error_bra_name != '')
		errBName.html(data.error_bra_name),
		fillBName.addClass(isInvalid);
	else
		errBName.html(''),
		fillBName.removeClass(isInvalid);
}

function clearBra() {
	braForm[0].reset();
	errBSk.html(''),
		errBName.html(''),
		fillBSk.removeClass(isInvalid),
		fillBName.removeClass(isInvalid);
}

function chkdBra() { //checked
	fillBSk.prop('readonly', true),
		fillBName.prop('readonly', true),
		fillBDesc.prop('readonly', true);
}

function unchkdBra() { //unchecked
	fillBSk.prop('readonly', false),
		fillBName.prop('readonly', false),
		fillBDesc.prop('readonly', false);
}
