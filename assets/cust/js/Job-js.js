const fillJSk = $('[name = job_sk]'),
	fillJName = $('[name = job_name]'),
	fillJDesc = $('[name = job_desc]');

//error field form
const errJSk = $('#error_job_sk'),
	errJName = $('#error_job_name');

btnNewJob.click(function () {
	openModalForm();
	Scrollmodal();
	modalTitle.text('New Job');
	clearJob();
	jobActive.prop('checked', true);
	const formID = jobForm[0]['id'];
	isActive(formID);

	setSave = 'add';
});

_tableJob.on('click', 'td:not(:last-child)', function (e) {
	e.preventDefault()
	const formID = jobForm[0]['id'];
	const row = _tableJob.row(this).data();
	ID = row[0]; //index array ID
	var NAME = row[2];
	url = SITE_URL + SHOW + ID;

	openModalForm();
	Scrollmodal();
	modalTitle.html(NAME);
	clearJob();
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
			fillJSk.val(result.value);
			fillJName.val(result.name);
			fillJDesc.val(result.description);

			if (result.isactive == active)
				jobActive.prop('checked', true),
				readonly(formID, false);
			else
				jobActive.prop('checked', false),
				readonly(formID, true);
		}
	});
});

function errFormJob(data) {
	if (data.error_job_sk != '')
		errJSk.html(data.error_job_sk),
		fillJSk.addClass(isInvalid);

	else
		errJSk.html(''),
		fillJSk.removeClass(isInvalid);

	if (data.error_job_name != '')
		errJName.html(data.error_job_name),
		fillJName.addClass(isInvalid);

	else
		errJName.html(''),
		fillJName.removeClass(isInvalid);
}

function clearJob() {
	jobForm[0].reset();
	errJSk.html(''),
		errJName.html(''),
		fillJSk.removeClass(isInvalid),
		fillJName.removeClass(isInvalid);
}

function chkdJob() { //checked
	fillJSk.prop('readonly', true),
		fillJName.prop('readonly', true),
		fillJDesc.prop('readonly', true);
}

function unchkdJob() { //unchecked
	fillJSk.prop('readonly', false),
		fillJName.prop('readonly', false),
		fillJDesc.prop('readonly', false);
}
