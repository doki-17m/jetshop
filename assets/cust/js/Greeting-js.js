const fillGSk = $('[name = gre_sk]'),
	fillGName = $('[name = gre_name]'),
	fillGDesc = $('[name = gre_desc]');

//error field form
const errGSk = $('#error_gre_sk'),
	errGName = $('#error_gre_name');
	
btnNewGre.click(function () {
	openModalForm();
	Scrollmodal();
	modalTitle.text('New Greeting');
	clearGre();
	greActive.prop('checked', true);
	
	const formID = greForm[0]['id'];
	isActive(formID);

	setSave = 'add';
});

_tableGre.on('click', 'td:not(:last-child)', function (e) {
	e.preventDefault()
	const formID = greForm[0]['id'];
	const row = _tableGre.row(this).data();
	ID = row[0]; //index array ID
	var NAME = row[2];
	url = SITE_URL + SHOW + ID;
	
	openModalForm();
	Scrollmodal();
	modalTitle.html(NAME);
	clearGre();
	isActive(formID);
	
	setSave = 'update';

	$.ajax({
		url: url,
		type: 'GET',
		dataType: 'JSON',
		success: function (result) {
			fillGSk.val(result.value);
			fillGName.val(result.name);
			fillGDesc.val(result.description);

			if (result.isactive == active)
				greActive.prop('checked', true),
				readonly(formID, false);
			else
				greActive.prop('checked', false),
				readonly(formID, true);

		}
	});
});

function errFormGre(data) {
	if (data.error_gre_sk != '')
		errGSk.html(data.error_gre_sk),
		fillGSk.addClass(isInvalid);

	else
		errGSk.html(''),
		fillGSk.removeClass(isInvalid);

	if (data.error_gre_name != '')
		errGName.html(data.error_gre_name),
		fillGName.addClass(isInvalid);

	else
		errGName.html(''),
		fillGName.removeClass(isInvalid);
}

function clearGre() {
	greForm[0].reset();
	errGSk.html(''),
	errGName.html(''),
	fillGSk.removeClass(isInvalid),
	fillGName.removeClass(isInvalid);
}

function chkdGre() { //checked
	fillGSk.prop('readonly', true),
	fillGName.prop('readonly', true),
	fillGDesc.prop('readonly', true);
}

function unchkdGre() { //unchecked
	fillGSk.prop('readonly', false),
	fillGName.prop('readonly', false),
	fillGDesc.prop('readonly', false);
}



