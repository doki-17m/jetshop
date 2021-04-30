const fillURUsername = $('[name = usr_username]'),
	fillURRName = $('[name = usr_name]'),
	fillURPass = $('[name = usr_password]'),
	fillUREmail = $('[name = usr_email]'),
	fillURPhone = $('[name = usr_phone]'),
	fillURPhone2 = $('[name = usr_phone2]'),
	fillURAddress = $('[name = usr_address]'),
	fillURBirthday = $('[name = usr_birthday]'),
	fillURGre = $('[name = usr_greeting]'),
	fillURJob = $('[name = usr_job]'),
	fillURDesc = $('[name = usr_desc]');

//error field form
const errURUsername = $('#error_usr_username'),
	errURName = $('#error_usr_name'),
	errURPass = $('#error_usr_password'),
	errUREmail = $('#error_usr_email');

const usrIsSales = $('#usr_issalesrep');

usrGreeting();
usrJob();

btnNewUsr.click(function () {
	openModalForm();
	Scrollmodal();
	Largemodal();
	modalTitle.text('New User');
	clearUsr();
	usrActive.prop('checked', true);
	const formID = usrForm[0]['id'];
	isActive(formID);

	setSave = 'add';
});

_tableUsr.on('click', 'td:not(:last-child)', function (e) {
	e.preventDefault()
	const formID = usrForm[0]['id'];
	const row = _tableUsr.row(this).data();
	ID = row[0]; //index array ID
	var NAME = row[2];
	openModalForm();
	Scrollmodal();
	Largemodal();
	modalTitle.html(NAME);
	clearUsr();
	isActive(formID);
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
			fillURUsername.val(result.value);
			fillURRName.val(result.name);
			// fillURPass.val(result.password);
			fillUREmail.val(result.email);
			fillURPhone.val(result.phone);
			fillURPhone2.val(result.phone2);
			fillURAddress.val(result.address);
			fillURBirthday.val(result.birthday);
			fillURGre.val(result.m_greeting_id).change();
			fillURJob.val(result.m_job_id).change();
			fillURDesc.val(result.description);

			if (result.isactive == active)
				usrActive.prop('checked', true),
				readonly(formID, false);
			else
				usrActive.prop('checked', false),
				readonly(formID, true);

			if (result.issalesrep == active)
				usrIsSales.prop('checked', true);
			else
				usrIsSales.prop('checked', false);
		}
	});
});

function errFormUsr(data) {
	if (data.error_usr_username != '')
		errURUsername.html(data.error_usr_username),
		fillURUsername.addClass(isInvalid);

	else
		errURUsername.html(''),
		fillURUsername.removeClass(isInvalid);

	if (data.error_usr_name != '')
		errURName.html(data.error_usr_name),
		fillURRName.addClass(isInvalid);

	else
		errURName.html(''),
		fillURRName.removeClass(isInvalid);

	if (data.error_usr_password != '')
		errURPass.html(data.error_usr_password),
		fillURPass.addClass(isInvalid);

	else
		errURPass.html(''),
		fillURPass.removeClass(isInvalid);

	if (data.error_usr_email != '')
		errUREmail.html(data.error_usr_email),
		fillUREmail.addClass(isInvalid);

	else
		errUREmail.html(''),
		fillUREmail.removeClass(isInvalid);
}

function clearUsr() {
	usrForm[0].reset();
	errURUsername.html(''),
		errURName.html(''),
		errURPass.html(''),
		errUREmail.html(''),
		fillURGre.val(null).change(),
		fillURJob.val(null).change(),
		fillURUsername.removeClass(isInvalid),
		fillURRName.removeClass(isInvalid),
		fillURPass.removeClass(isInvalid),
		fillUREmail.removeClass(isInvalid);
}

function chkdUsr() { //checked
	fillURUsername.prop('readonly', true),
		fillURRName.prop('readonly', true),
		fillURPass.prop('readonly', true),
		fillUREmail.prop('readonly', true),
		fillURPhone.prop('readonly', true),
		fillURPhone2.prop('readonly', true),
		fillURAddress.prop('readonly', true),
		fillURBirthday.prop('readonly', true),
		fillURGre.prop('disabled', true),
		fillURJob.prop('disabled', true),
		usrIsSales.prop('disabled', true),
		fillURDesc.prop('readonly', true);
}

function unchkdUsr() { //unchecked
	fillURUsername.prop('readonly', false),
		fillURRName.prop('readonly', false),
		fillURPass.prop('readonly', false),
		fillUREmail.prop('readonly', false),
		fillURPhone.prop('readonly', false),
		fillURPhone2.prop('readonly', false),
		fillURAddress.prop('readonly', false),
		fillURBirthday.prop('readonly', false),
		fillURGre.prop('disabled', false),
		fillURJob.prop('disabled', false),
		usrIsSales.prop('disabled', false),
		fillURDesc.prop('readonly', false);
}

function usrGreeting() {
	url = CUST_URL + GREETING + '/showGreeting';

	$.getJSON(url, function (response) {
		fillURGre.append('<option selected="selected" value="">-- Choose One --</option>');
		$.each(response, function (idx, elem) {
			var greeting_id = elem.m_greeting_id;
			var greeting_name = elem.name;
			fillURGre.append('<option value="' + greeting_id + '">' + greeting_name + '</option>');
		});
	});
}

function usrJob() {
	url = CUST_URL + JOB + '/showJob';

	$.getJSON(url, function (response) {
		fillURJob.append('<option selected="selected" value="">-- Choose One --</option>');
		$.each(response, function (idx, elem) {
			var job_id = elem.m_job_id;
			var job_name = elem.name;
			fillURJob.append('<option value="' + job_id + '">' + job_name + '</option>');
		});
	});
}
