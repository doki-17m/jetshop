const fillABank = $('[name = acc_bank]'),
	fillAAccountNo = $('[name = acc_accountno]'),
	fillAName = $('[name = acc_name]'),
	fillADesc = $('[name = acc_desc]');

//error field form
const errABank = $('#error_acc_bank'),
	errAAccountNo = $('#error_acc_accountno'),
	errAName = $('#error_acc_name');

btnNewAcc.click(function () {
	openModalForm();
	Scrollmodal();
	modalTitle.text('New Courier');
	clearAcc();
	accActive.prop('checked', true);

	const formID = accForm[0]['id'];
	isActive(formID);
	setSave = 'add';
	accBank(setSave, 0);
});

_tableAcc.on('click', 'td:not(:last-child)', function (e) {
	e.preventDefault()
	const formID = accForm[0]['id'];
	const row = _tableAcc.row(this).data();
	ID = row[0]; //index array ID
	var NAME = row[2];
	url = SITE_URL + SHOW + ID;

	openModalForm();
	Scrollmodal();
	modalTitle.html(NAME);
	clearAcc();
	isActive(formID);

	setSave = 'update';

	$.getJSON(url, function (result) {
		accBank(setSave, result.m_bank_id);
		fillABank.val(result.bank);
		fillAAccountNo.val(result.accountno);
		fillAName.val(result.name);
		fillADesc.val(result.description);

		if (result.isactive == active)
			accActive.prop('checked', true),
			readonly(formID, false);
		else
			accActive.prop('checked', false),
			readonly(formID, true);
	});
});

function errFormAcc(data) {
	if (data.error_acc_bank != '')
		errABank.html(data.error_acc_bank),
		fillABank.addClass(isInvalid);

	else
		errABank.html(''),
		fillABank.removeClass(isInvalid);

	if (data.error_acc_accountno != '')
		errAAccountNo.html(data.error_acc_accountno),
		fillAAccountNo.addClass(isInvalid);

	else
		errAAccountNo.html(''),
		fillAAccountNo.removeClass(isInvalid);

	if (data.error_acc_name != '')
		errAName.html(data.error_acc_name),
		fillAName.addClass(isInvalid);

	else
		errAName.html(''),
		fillAName.removeClass(isInvalid);
}

function clearAcc() {
	accForm[0].reset();
	errABank.html('');
	errAAccountNo.html('');
	errAName.html('');
	fillABank.removeClass(isInvalid);
	fillAAccountNo.removeClass(isInvalid);
	fillAName.removeClass(isInvalid);
}

function chkdAcc() { //checked
	fillABank.prop('readonly', true);
	fillAAccountNo.prop('readonly', true);
	fillAName.prop('readonly', true);
	fillADesc.prop('readonly', true);
}

function unchkdAcc() { //unchecked
	fillABank.prop('disabled', false);
	fillAAccountNo.prop('readonly', false);
	fillAName.prop('readonly', false);
	fillADesc.prop('readonly', false);
}

function accBank(set, id) {
	url = SITE_URL + '/showBank';

	$.getJSON(url, function (response) {
		fillABank.empty();
		fillABank.append('<option selected="selected" value="">-- Choose One --</option>');

		$.each(response, function (idx, elem) {
			var bank_id = elem.m_bank_id;
			var bank_name = elem.name;
			if (id == bank_id)
				fillABank.append('<option value="' + bank_id + '" selected="selected">' + bank_name + '</option>');
			else
				fillABank.append('<option value="' + bank_id + '">' + bank_name + '</option>');
		});
	});
}
