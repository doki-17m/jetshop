const fillEDocumentNo = $('[name = exp_documentno]'),
	fillEDate = $('[name = exp_date]'),
	fillEStatus = $('[name = exp_status]'),
	fillEDesc = $('[name = exp_desc]'),
	fillEPayment = $('[name = exp_payment]'),
	fillEBank = $('[name = exp_bankacc]');

const errEDate = $('#error_exp_date'),
	errEPayment = $('#error_exp_payment'),
	errEBank = $('#error_exp_bankacc');

const groupEBank = $('#group_exp_bankacc');

$(document).ready(function (e) {
	fillEDocumentNo.prop('readonly', true);

	fillEPayment.change(function (e) {
		var value = $(this).val();

		if (value == 2) {
			groupEBank.show();
			fillEBank.val(null).change();
		} else {
			groupEBank.hide();
			fillEBank.val(null).change();
		}
	});
});

$(document).on('click', '#close_exp', function (e) {
	const existDataTable = _tableExpLine.data().any();
	// if (!existDataTable)
	// 	Toast.fire({
	// 		type: 'error',
	// 		title: 'Please add some item.'
	// 	});
	// else
	expForm[0].reset();
	$('#modal_exp').modal('hide');
});

btnNewExp.click(function () {
	$('#modal_exp').modal({
		backdrop: 'static',
		keyboard: false
	});
	Scrollmodal();
	modalTitle.text('New Expense');
	Largemodal();
	groupEBank.hide();
	clearExp();

	const formID = expForm[0]['id'];
	isActive(formID);
	showDocNo();
	setSave = 'add';
	expAccount(setSave, 0);
});

_tableExp.on('click', 'td:not(:last-child)', function (e) {
	e.preventDefault()
	const row = _tableExp.row(this).data();
	ID = row[0]; //index array ID
	var NAME = row[2];
	url = SITE_URL + SHOW + ID;

	$('#modal_exp').modal({
		backdrop: 'static',
		keyboard: false
	});
	Scrollmodal();
	Largemodal();
	modalTitle.html(NAME);
	clearExp();
	setSave = 'update';

	$.getJSON(url, function (result) {
		let detailLine = [];
		$.each(result, function (idx, elem) {
			let docstatus = elem.docstatus;
			let payment = elem.paymentmethod;
			let account = elem.m_account_id;
			fillEDocumentNo.val(elem.documentno);
			fillEDate.val(formatDate(elem.datereport));
			fillEDesc.val(elem.note);
			fillEPayment.val(payment).change();
			expAccount(setSave, account);
			expReadOnly(docstatus);
			detailLine.push(elem.trx_expenseline_id);
		});

		if (!detailLine.includes(null))
			showExpLine(result);
	});
});

btnNewExpLine.click(function (e) {
	e.preventDefault();
	showExpLine(null);
});

$('#save_exp').click(function (e) {
	const formData = expForm.serialize();

	if (setSave === 'add')
		url = SITE_URL + CREATE;
	else
		url = SITE_URL + EDIT + ID;

	var allRows = _tableExpLine.rows().nodes();
	var desc = $('.exp_line_desc', allRows);
	var qty = $('.exp_line_qty', allRows);
	var price = $('.exp_line_price', allRows);
	var line_id = $('.exp_line_id', allRows);

	var arrDesc = [];
	var arrQty = [];
	var arrPrice = [];
	$.each(desc, function (idx, elem) {
		var value = this.value;

		if (value === '') {
			arrDesc.push(value)
		}
	});
	$.each(qty, function (idx, elem) {
		var value = this.value;

		if (value === '') {
			arrQty.push(value)
		}
	});
	$.each(price, function (idx, elem) {
		var value = this.value;

		if (value === '') {
			arrPrice.push(value)
		}
	});

	var arrData = mergeExpLine(desc, qty, price, line_id);

	if (arrData.length == 0) {
		Toast.fire({
			type: 'error',
			title: 'Please add some item.'
		});
	} else if (arrDesc.length > 0) {
		Toast.fire({
			type: 'error',
			title: 'The Description field is required.'
		});
	} else if (arrQty.length > 0) {
		Toast.fire({
			type: 'error',
			title: 'The Quantity field is required.'
		});
	} else if (arrPrice.length > 0) {
		Toast.fire({
			type: 'error',
			title: 'The Price field is required.'
		});
	} else {
		$.ajax({
			url: url,
			type: 'POST',
			data: formData,
			dataType: 'JSON',
			success: function (result) {
				if (result.error) {
					errFormExp(result)
				} else {
					let id = result;
					saveLine(id, arrData, setSave);
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.info(errorThrown)
				alert(errorThrown)
			}
		});
	}
});

function saveLine(parent_id, data, setSave) {
	if (setSave === 'add')
		url = SITE_URL + '/create_line';
	else
		url = SITE_URL + '/update_line';

	$.ajax({
		url: url,
		type: 'POST',
		data: {
			id: parent_id,
			data: data
		},
		dataType: 'JSON',
		success: function (result) {
			if (result.success)
				Toast.fire({
					type: 'success',
					title: result.message
				}),
				reloadTable(LAST_URL),
				errorClear('form_expense'),
				$('#modal_exp').modal('hide');
		},
		error: function (jqXHR, textStatus, errorThrown) {
			console.info(errorThrown)
			alert(errorThrown)
		}
	});
}

function showExpLine(data) {
	var allRows;
	if (data !== null) {
		for (var i = 0; i < data.length; i++) {
			let line_id = data[i].trx_expenseline_id;
			let detail = data[i].detail;
			let qty = data[i].qtyentered;
			let price = data[i].pricelist;
			let status = data[i].docstatus;
			_tableExpLine.row.add(editExpLine(line_id, detail, qty, price, status)).draw(false);
		}
	} else {
		_tableExpLine.row.add(addExpLine()).draw(false);
	}

	allRows = _tableExpLine.rows().nodes();
	$('.exp_line_id', allRows).click(function (e) {
		e.preventDefault();
		var IDX = this.id;
		var tr = _tableExpLine.$(this).closest('tr');
		var row = _tableExpLine.row(tr);

		if (IDX == '') {
			row.remove().draw(false);
		} else {
			url = SITE_URL + '/destroy_line?id=' + IDX;

			$.get(url, function (result) {
				row.remove().draw(false)
			});
		}
	});

	$('.rupiah').autoNumeric('init', {
		aSep: '.',
		aDec: ',',
		mDec: '0'
	});

	$('.number').on('keypress keyup blur', function (evt) {
		$(this).val($(this).val().replace(/[^\d].+/, ""));
		if ((evt.which < 48 || evt.which > 57)) {
			evt.preventDefault();
		}
	});
}

function addExpLine() {
	return [
		'<input type="text" class="form-control exp_line_desc" style="width: 100%;">',
		'<input type="text" class="form-control number exp_line_qty" value="1" title="Quantity" style="width: 100%;">',
		'<input type="text" class="form-control rupiah exp_line_price" title="Quantity" style="width: 100%;">',
		'<a class="btn exp_line_id" title="Delete"><i class="fas fa-trash-alt text-danger"></i></a>'
	];
}

function editExpLine(line_id, desc, qty, price, status) {
	if (status !== 'DR') {
		return [
			'<input type="text" class="form-control exp_line_desc" value="' + desc + '" style="width: 100%;" readonly>',
			'<input type="text" class="form-control number exp_line_qty" title="Quantity" value="' + qty + '" style="width: 100%;" readonly>',
			'<input type="text" class="form-control rupiah exp_line_price" value="' + price + '" title="Quantity" style="width: 100%;" readonly>',
			'<a class="btn" title="Delete"><i class="fas fa-trash-alt text-danger"></i></a>'
		];
	} else {
		return [
			'<input type="text" class="form-control exp_line_desc" value="' + desc + '" style="width: 100%;">',
			'<input type="text" class="form-control number exp_line_qty" title="Quantity" value="' + qty + '" style="width: 100%;">',
			'<input type="text" class="form-control rupiah exp_line_price" value="' + price + '" title="Quantity" style="width: 100%;">',
			'<a class="btn exp_line_id" id="' + line_id + '" title="Delete"><i class="fas fa-trash-alt text-danger"></i></a>'
		];
	}
}

function mergeExpLine(desc, qty, price, line_id) {
	var arrDesc = [];
	var arrQty = [];
	var arrPrice = [];
	var arrLineID = [];

	$.each(desc, function (idx, elem) {
		arrDesc.push({
			desc: this.value
		})
	})

	$.each(qty, function () {
		arrQty.push({
			qty: this.value
		})
	})

	$.each(price, function () {
		arrPrice.push({
			price: this.value
		})
	})

	$.each(line_id, function () {
		arrLineID.push({
			id: this.id
		})
	})

	return arrDesc.map((item, i) => Object.assign({}, item, arrQty[i], arrPrice[i], arrLineID[i]));
}

function showDocNo() {
	url = SITE_URL + '/get_docno';
	$.getJSON(url, function (result) {
		fillEDocumentNo.val(result);
	});
}

function expReadOnly(status) {
	if (status !== 'DR') {
		fillEDate.prop('readonly', true);
		fillEDesc.prop('readonly', true);
		fillEPayment.prop('disabled', true);
		fillEBank.prop('disabled', true);
		btnNewExpLine.prop('disabled', true);
		$('#save_exp').prop('disabled', true);
	} else {
		fillEDate.prop('readonly', false);
		fillEDesc.prop('readonly', false);
		fillEPayment.prop('disabled', false);
		fillEBank.prop('disabled', false);
		btnNewExpLine.prop('disabled', false);
		$('#save_exp').prop('disabled', false);
	}
}

function errFormExp(data) {
	if (data.error_exp_date != '')
		errEDate.html(data.error_exp_date),
		fillEDate.addClass(isInvalid);
	else
		errEDate.html(''),
		fillEDate.removeClass(isInvalid);

	if (data.error_exp_payment != '')
		errEPayment.html(data.error_exp_payment);
	else
		errEPayment.html('');

	if (data.error_exp_bankacc != '')
		errEBank.html(data.error_exp_bankacc);
	else
		errEBank.html('');
}

function clearExp() {
	expForm[0].reset();
	fillEPayment.val(null).change();
	fillEBank.val(null).change();
	errEDate.html('');
	errEPayment.html('');
	errEBank.html('');
	fillEDate.removeClass(isInvalid);
	_tableExpLine.clear().draw();
	fillEDate.prop('readonly', false);
	fillEDesc.prop('readonly', false);
	fillEPayment.prop('disabled', false);
	fillEBank.prop('disabled', false);
	btnNewExpLine.prop('disabled', false);
	$('#save_exp').prop('disabled', false);
}

function expAccount(set, id) {
	url = CUST_URL + ACCOUNT + '/showAccount';

	$.getJSON(url, function (response) {
		fillEBank.empty();
		fillEBank.append('<option selected="selected" value="">-- Choose One --</option>');

		$.each(response, function (idx, elem) {
			var account_id = elem.m_account_id;
			var bank = elem.bank;
			var accountno = elem.accountno;
			var account_name = accountno + '_' + bank + ' - ' + elem.name;

			if (id == account_id)
				fillEBank.append('<option value="' + account_id + '" selected="selected">' + account_name + '</option>');
			else
				fillEBank.append('<option value="' + account_id + '">' + account_name + '</option>');
		});
	});
}
