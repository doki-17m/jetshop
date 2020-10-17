const fillCSk = $('[name = cat_sk]'),
	fillCName = $('[name = cat_name]'),
	fillCDesc = $('[name = cat_desc]');

//error field form
const errCSk = $('#error_cat_sk'),
	errCName = $('#error_cat_name');
	
btnNewCat.click(function () {
	openModalForm();
	Scrollmodal();
	modalTitle.text('New Category');
	clearCat();
	catActive.prop('checked', true);
	
	const formID = catForm[0]['id'];
	isActive(formID);

	setSave = 'add';
});

_tableCat.on('click', 'td:not(:last-child)', function (e) {
	e.preventDefault()
	const formID = catForm[0]['id'];
	const row = _tableCat.row(this).data();
	ID = row[0]; //index array ID
	var NAME = row[2];
	url = SITE_URL + SHOW + ID;
	
	openModalForm();
	Scrollmodal();
	modalTitle.html(NAME);
	clearCat();
	isActive(formID);
	
	setSave = 'update';

	$.ajax({
		url: url,
		type: 'GET',
		dataType: 'JSON',
		success: function (result) {
			fillCSk.val(result.value);
			fillCName.val(result.name);
			fillCDesc.val(result.description);

			if (result.isactive == active)
				catActive.prop('checked', true),
				readonly(formID, false);
			else
				catActive.prop('checked', false),
				readonly(formID, true);

		}
	});
});

function errFormCat(data) {
	if (data.error_cat_sk != '')
		errCSk.html(data.error_cat_sk),
		fillCSk.addClass(isInvalid);

	else
		errCSk.html(''),
		fillCSk.removeClass(isInvalid);

	if (data.error_cat_name != '')
		errCName.html(data.error_cat_name),
		fillCName.addClass(isInvalid);

	else
		errCName.html(''),
		fillCName.removeClass(isInvalid);
}

function clearCat() {
	catForm[0].reset();
	errCSk.html(''),
	errCName.html(''),
	fillCSk.removeClass(isInvalid),
	fillCName.removeClass(isInvalid);
}

function chkdCat() { //checked
	fillCSk.prop('readonly', true),
	fillCName.prop('readonly', true),
	fillCDesc.prop('readonly', true);
}

function unchkdCat() { //unchecked
	fillCSk.prop('readonly', false),
	fillCName.prop('readonly', false),
	fillCDesc.prop('readonly', false);
}
