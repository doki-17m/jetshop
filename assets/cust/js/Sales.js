//field pos
const fillSDate = $('[name = pos_date]'),
	fillSCashier = $('[name = pos_cashier]'),
	fillSBarcode = $('[name = pos_barcode]'),
	fillSInvoiceNo = $('#documentno');

const msgInvoiceNo = $('#documentno'),
	msgGrandTotal = $('#grandtotal');

const btnCheckout = $('#btn_checkout'),
	btnPrint = $('#btn_print'),
	btnPos = $('#btn_pos'),
	btnClosePos = $('#btn_close_pos'),
	btnRefresh = $('#btn_refresh');

const showDataTable = $('#show_data');
//close field pos

//field on modal
const boxCustomer = $('#detail_datacustomer'), //box info
	boxCart = $('#detail_cart');

const fillPosCustSelect = $('[name = pos_cust_id]'),
	fillPosCustInput = $('[name = pos_cust_name]'),
	fillPosPhone = $('[name = pos_phone]'),
	fillPosCourier = $('[name = pos_courier]'),
	fillPosWeight = $('[name = pos_total_weight]'),
	fillPosDelivery = $('[name = pos_delivery]'),
	fillPosCity = $('[name = pos_city]'),
	fillPosAddress = $('[name = pos_address]'),
	fillPosJMarket = $('[name = pos_job_market]'),
	fillPosNote = $('[name = pos_note]'),
	fillPosPayment = $('[name = pos_payment]'),
	fillPosBank = $('[name = pos_bankacc]');

const groupPosCustSelect = $('#group_pos_cust_id'),
	groupPosCustInput = $('#group_pos_cust_name'),
	groupPosPhone = $('#group_pos_phone'),
	groupPosCourier = $('#group_pos_courier'),
	groupPosCustDelivery = $('#group_pos_delivery'),
	groupPosCustCity = $('#group_pos_city'),
	groupPosCustAddress = $('#group_pos_address'),
	groupPosCustJMarket = $('#group_pos_job_market'),
	groupPosBank = $('#group_pos_bankacc');

const errPosCustSelect = $('#error_pos_cust_id'),
	errPosCustInput = $('#error_pos_cust_name'),
	errPosPhone = $('#error_pos_phone'),
	errPosCourier = $('#error_pos_courier'),
	errPosCity = $('#error_pos_city'),
	errPosAddress = $('#error_pos_faddress'),
	errPosDelivery = $('#error_pos_delivery'),
	errPosPayment = $('#error_pos_payment'),
	errPosBank = $('#error_pos_bankacc');

const cxbIsmember = $('#pos_ismember'); // checkbox walk in customer

const ACTION_increment = 'INCREMENT',
	ACTION_decrement = 'DECREMENT';

let totalAmount = 0;
let setQty = 0;
var arrCart = [];

$(document).ready(function () {
	msgGrandTotal.html(formatRupiah(totalAmount));
	clearFilPos();
	posCashier(); // call function show data cashier

	// change qty value of the cart datatable
	_tablePOS.on('change paste', '.quantity-field', function (e) {
		ID = $(this).prop('id');
		var currentVal = $(this).val();
		updateCart(ID, currentVal);
	});

	// number only on field quantity of the cart datatable
	_tablePOS.on('keypress', '.quantity-field', function (evt) {
		$(this).val($(this).val().replace(/[^\d].+/, ""));
		if ((evt.which < 48 || evt.which > 57))
			evt.preventDefault();

		if (evt.code === 'Enter')
			autoFocus();
	});

	// button add and button substract quantity of the cart datatable
	_tablePOS.on('click', '.button-plus, .button-minus', function (evt) {
		ID = $(this).val();
		var typeButton = $(this).prop('id');
		var fieldName = $(this).data('button');

		if (typeButton === 'button-plus')
			indecrementVal(ID, evt, fieldName, ACTION_increment);
		else
			indecrementVal(ID, evt, fieldName, ACTION_decrement);

		autoFocus();
	});

	btnRefresh.click(function () {
		clearFilPos();
		autoFocus();
		clearTable();
	});

	btnCheckout.click(function (e) {
		e.preventDefault();
		const existDataTable = _tablePOS.data().any();

		if (existDataTable)
			checkoutData();
	});

	if (LAST_URL == 'sales')
		autoComplete();
})

fillSBarcode.scannerDetection({
	timeBeforeScanTest: 100, // wait for the next character for upto 100ms
	avgTimeByChar: 40, // it's not a barcode if a character takes longer than 100ms
	preventDefault: true,
	endChar: [13],
	onComplete: function (barcode, qty) {
		validScan = true;
		fillSBarcode.val(barcode);
		insertCart(barcode, qty);
	},
	onError: function (string, qty) {
		fillSBarcode.val(fillSBarcode.val() + string);
	}
});

function autoComplete() {
	classBarcode.autocomplete({
		source: CUST_URL + PRODUCT + '/showProduct/?',
		minLength: 1,
		scroll: true,
		select: function (event, ui) {
			$(this).val(ui.item.value);
			var pro_code = $(this).val();
			if (pro_code !== '') {
				setQty = 1;
				insertCart(pro_code, setQty);
			}
		},
		close: function () {
			$(this).val('');
			autoFocus();
		}
	}).keyup(function (e) {
		if (e.keyCode === 13) { //keycode enter
			e.preventDefault();
			$(this).val('');
		}
	}).data('ui-autocomplete')._renderItem = function (ul, item) {
		return $("<li class='ui-autocomplete-row'></li>")
			.data("item.autocomplete", item)
			.append(item.label)
			.appendTo(ul);
	};
}

function showTable(url) {
	_tablePOS.ajax.url(url).load().draw(true);
	_tablePOS.on('xhr', function (r) {
		var json = _tablePOS.ajax.json();
		var total = json['total'];
		arrCart.push(json);

		if (total > 0) {
			totalAmount = total;
			msgGrandTotal.html(formatRupiah(totalAmount));
		} else {
			totalAmount = 0;
			msgGrandTotal.html(formatRupiah(totalAmount));
		}
	});
}

// insert data cart
function insertCart(code, qty) {
	url = SITE_URL + '/create_cart?code=' + code + '&qty=' + qty;
	showTable(url);
}

function updateCart(id, qty) {
	url = SITE_URL + '/edit_cart?id=' + id + '&qty=' + qty;
	showTable(url);
}

// delete data cart
function destroyCart(id) {
	setQty = 0;
	url = SITE_URL + '/edit_cart?id=' + id + '&qty=' + setQty;
	showTable(url);
}

function clearTable() {
	url = SITE_URL + '/destroy_allcart?';
	showTable(url);
}

// increment and decrement quantity of the cart datatable
function indecrementVal(id, e, field, action) {
	var parent = $(e.target).closest('.input-group');
	var currentVal = parseInt(parent.find('input[name=' + field + ']').val(), 10);

	if (!isNaN(currentVal) && action === ACTION_increment)
		setQty = currentVal + 1,
		parent.find('input[name=' + field + ']').val(setQty);
	else if (!isNaN(currentVal) && action === ACTION_decrement)
		setQty = currentVal - 1,
		parent.find('input[name=' + field + ']').val(setQty);
	else
		parent.find('input[name=' + field + ']').val(0);

	updateCart(id, setQty);
}

function saveOrder(table) {

	var dateTrx = fillSDate.val();
	var cashier = fillSCashier.val();
	var invoiceno = fillSInvoiceNo.html();
	var ismember = MemberValue();
	var courier = $('#pos_courier option:selected').val();
	var payment = $('#pos_payment option:selected').val();
	var bank = $('#pos_bankacc option:selected').val();

	var form = $('#form_checkout').serialize() +
		'&pos_courier=' + courier +
		'&ismember=' + ismember +
		'&pos_date=' + dateTrx +
		'&pos_cashier=' + cashier +
		'&pos_invoiceno=' + invoiceno +
		'&pos_payment=' + payment +
		'&pos_bankacc=' + bank;

	var arrData = callbackTable(table)

	$.ajax({
		url: SITE_URL + '/checkQty',
		type: 'POST',
		data: {
			data: arrData
		},
		dataType: 'JSON',
		success: function (result) {
			if (result.length > 0) {
				$.each(result, function (idx, elem) {
					var zero = elem.zero;
					var more = elem.more;
					if (zero)
						Toast.fire({
							type: 'error',
							title: zero
						});

					if (more)
						Toast.fire({
							type: 'error',
							title: more
						});
				});
			} else {
				url = SITE_URL + CREATE;
				$.ajax({
					url: url,
					type: 'POST',
					data: form,
					dataType: 'JSON',
					success: function (response) {
						if (response.error) {
							if (response.error_pos_cust_id != '')
								errPosCustSelect.html(response.error_pos_cust_id);
							else
								errPosCustSelect.html('');

							if (response.error_pos_cust_name != '')
								errPosCustInput.html(response.error_pos_cust_name),
								fillPosCustInput.addClass(isInvalid);
							else
								errPosCustInput.html(''),
								fillPosCustInput.removeClass(isInvalid);

							if (response.error_pos_phone != '')
								errPosPhone.html(response.error_pos_phone),
								fillPosPhone.addClass(isInvalid);
							else
								errPosPhone.html(''),
								fillPosPhone.removeClass(isInvalid);

							if (response.error_pos_courier != '')
								errPosCourier.html(response.error_pos_courier);
							else
								errPosCourier.html('');

							if (response.error_pos_city != '')
								errPosCity.html(response.error_pos_city);
							else
								errPosCity.html('');

							if (response.error_pos_faddress != '')
								errPosAddress.html(response.error_pos_faddress),
								fillPosAddress.addClass(isInvalid);
							else
								errPosAddress.html(''),
								fillPosAddress.removeClass(isInvalid);

							if (response.error_pos_delivery != '')
								errPosDelivery.html(response.error_pos_delivery);
							else
								errPosDelivery.html('');

							if (response.error_pos_payment != '')
								errPosPayment.html(response.error_pos_payment);
							else
								errPosPayment.html('');

							if (response.error_pos_bankacc != '')
								errPosBank.html(response.error_pos_bankacc);
							else
								errPosBank.html('');
						}

						if (response.last_id) {
							saveOrderLine(arrData, response.last_id)
						}
					}
				});
			}
		}
	});
}

function saveOrderLine(arrData, last_id) {
	url = SITE_URL + '/create_line';

	$.ajax({
		url: url,
		type: 'POST',
		data: {
			id: last_id,
			data: arrData
		},
		dataType: 'JSON',
		success: function (result) {
			if (result.success) {
				Toast.fire({
					type: 'success',
					title: result.message
				});
				clearErrPos();
				chkdPos();
				clearTable();
				btnPos.hide();
				btnPrint.show();
				btnClosePos.show();
			}
		}
	});
}

function MemberValue() {
	var isActive;
	if (cxbIsmember.is(':checked'))
		isActive = active;
	else
		isActive = nonactive;
	return isActive;
}

function checkoutData() {
	var lastArrCart = arrCart[arrCart.length - 1]; // last index array datatables
	const table = document.getElementById('list_cart');
	var invoiceno = fillSInvoiceNo.html();

	$('#modal_checkout').modal({
		backdrop: 'static',
		keyboard: false
	});
	Scrollmodal();
	modalDialog.addClass('modal-xl');
	modalTitle.html('BIll No: ' + invoiceno.bold());
	$('#form_checkout')[0].reset();

	btnClosePos.hide();
	btnPrint.hide();
	fillPosPhone.prop('readonly', true);
	fillPosCourier.prop('disabled', true);
	fillPosDelivery.prop('disabled', true);
	groupPosCustInput.hide();
	groupPosCustDelivery.hide();
	groupPosCustCity.hide();
	groupPosCustAddress.hide();
	groupPosCustJMarket.hide();
	groupPosBank.hide();
	fillPosPayment.val(null).change();
	fillPosBank.val(null).change();

	posCustomer(null, null);
	posCourier(null, null);
	posCity(null, null);
	getDelivery(null, null);
	getTotalWeight(lastArrCart);
	getListCart(table, lastArrCart);
	posAccount(null, null);

	// checkbox member
	cxbIsmember.change(function (e) {
		var chkVal = true;
		if (!cxbIsmember.is(':checked')) {
			chkVal = false;
		}

		if (chkVal) {
			groupPosCustSelect.show();
			groupPosCustInput.hide();
			groupPosCustCity.hide();
			groupPosCustAddress.hide();
			groupPosCustDelivery.hide();
			fillPosPhone.val('');
			fillPosPhone.prop('readonly', true);
			fillPosCourier.val(null).change();
			fillPosCourier.prop('disabled', true);
		} else {
			groupPosCustSelect.hide();
			groupPosCustInput.show();
			groupPosCustCity.show();
			groupPosCustAddress.show();
			fillPosCustSelect.val(null).change();
			fillPosPhone.val('');
			fillPosPhone.prop('readonly', false);
			fillPosCourier.val(null).change();
			fillPosCourier.prop('disabled', false);
			fillPosCity.val(null).change();
			fillPosAddress.val('');
		}
	});

	// event change field customer select
	fillPosCustSelect.change(function (e) {
		var customer = $(this).val();
		fillPosCourier.prop('disabled', false);

		url = CUST_URL + CUSTOMER + SHOW + customer;

		$.getJSON(url, function (result) {
			var phone = result.phone;
			var address = result.address;
			var city = result.city_id;

			posCity(null, city);
			fillPosPhone.val(phone);
			fillPosAddress.val(address);
		});
	});

	// event change field courier
	fillPosCourier.change(function (e) {
		groupPosCustDelivery.show();
		groupPosCustCity.show();
		groupPosCustAddress.show();
	});

	// event change field delivery
	fillPosDelivery.change(function (e) {
		groupPosCustJMarket.show();
	});

	btnPos.click(function (e) {
		saveOrder(table);
	});

	fillPosPayment.change(function (e) {
		var value = $(this).val();

		if (value == 2) {
			groupPosBank.show();
			fillPosBank.val(null).change();
		} else {
			groupPosBank.hide();
			fillPosBank.val(null).change();
		}
	});
}

function getListCart(table, dataCart) {
	const tableListCart = $('#list_cart');

	var html = '';
	var data = dataCart['data'];
	var total = dataCart['total'];
	var cost = 0;
	var grandTotal = 0;

	// header table list cart
	html += '<tr id="list_header">' +
		'<th>Product </th>' +
		'<th>Qty </th>' +
		'<th>Amount </th>' +
		'</tr>';

	$.each(data, function (idx, elem) {
		var product_id = elem[0];
		var qty = elem[1];
		var product = elem[3];
		var amount = replaceRupiah(elem[6]);
		html += '<tr id="product_group">' +
			'<th class="product" id="' + product_id + '" style="text-align: left; width: 200px">' + product + '</th>' +
			'<td class="qty" id="' + qty + '">x' + qty + '</td>' +
			'<td class="amount" style="text-align: right">' +
			'<input type="text" class="form-control rupiah" style="text-align: right;" value="' + amount + '">' +
			'</tr>';
	});

	//subtotal
	html += '<tr id="subtotal">' +
		'<th colspan="2" style="text-align: right">Subtotal: </th>' +
		'<td class="subtotal" style="text-align: right">' + formatRupiah(total) + '</td>' +
		'</tr>';

	//ongkos kirim
	html += '<tr id="ongkir">' +
		'<th colspan="2" style="text-align: right">Shipping: </th>' +
		'<td class="ongkir" style="text-align: right">' + cost + '</td>' +
		'</tr>';

	//grandtotal
	html += '<tr id="grandTotal">' +
		'<th colspan="2" style="text-align: right">Grand Total: </th>' +
		'<td class="grandTotal" style="text-align: right; color: red">' + grandTotal + '</td>' +
		'</tr>';

	tableListCart.html(html);

	// field summary
	var cellSubtotal = $('.subtotal'),
		cellOngkir = $('.ongkir'),
		cellGrandTotal = $('.grandTotal');

	//cek ongkos kirim
	fillPosDelivery.change(function (e) {
		cost = $(this).val().substring($(this).val().search('/') + 1);
		total = replaceRupiah(cellSubtotal.html());
		grandTotal = parseInt(total) + parseInt(cost);

		cellOngkir.html(formatRupiah(cost));
		cellGrandTotal.html(formatRupiah(grandTotal));
	});

	$('.rupiah').autoNumeric('init', {
		aSep: '.',
		aDec: ',',
		mDec: '0'
	}).on('keypress keyup blur', function (evt) {
		var valAmt = [];

		for (let i in table.rows) {
			let row_id = table.rows[i].id
			let row = table.rows[i]

			//table row product_group
			if (row_id === 'product_group') {
				for (let j in row.cells) {
					let col = row.cells[j]
					let col_class = row.cells[j].className

					//table data class amount
					if (col_class === 'amount') {
						var amount = replaceRupiah(col.lastChild.value);
						valAmt.push(amount);
					}
				}
			}
		}

		var numberAmt = valAmt.toString().split(',').map(Number);

		cost = replaceRupiah(cellOngkir.html());
		total = replaceRupiah(cellSubtotal.html());
		grandTotal = parseInt(total) + parseInt(cost);

		var totalAmt = numberAmt.reduce(function (a, b) {
			return a + b;
		});

		cellSubtotal.html(formatRupiah(totalAmt));
		cellOngkir.html(formatRupiah(cost));
		cellGrandTotal.html(formatRupiah(grandTotal));
	});
}

function callbackTable(table) {
	var listProduct = [];
	var listQty = [];
	var listAmt = [];
	var ongkir = [];
	var grandtotal = [];

	for (let i in table.rows) {
		let row = table.rows[i]

		for (let j in row.cells) {
			let col = row.cells[j]
			let col_class = row.cells[j].className

			if (col_class === 'product')
				listProduct.push({
					product_id: col.id
				});

			if (col_class === 'qty')
				listQty.push({
					qty: col.id
				});

			if (col_class === 'amount') {
				var amount = parseInt(replaceRupiah(col.lastChild.value));
				listAmt.push({
					amount: amount
				});
			}

			if (col_class === 'ongkir') {
				var deliveryfee = parseInt(replaceRupiah(col.innerHTML));
				ongkir.push({
					ongkir: deliveryfee
				});
			}

			if (col_class === 'grandTotal') {
				var gt = parseInt(replaceRupiah(col.innerHTML));
				grandtotal.push({
					grandtotal: gt
				});
			}
		}
	}
	return listProduct.map((item, i) => Object.assign({}, item, listQty[i], listAmt[i], ongkir[i], grandtotal[i]))
}

function getTotalWeight(dataCart) {
	url = SITE_URL + '/totalWeight';

	$.ajax({
		url: url,
		type: 'POST',
		data: dataCart,
		dataType: 'JSON',
		success: function (result) {
			fillPosWeight.val(result)
		}
	});
}

// function show cashier
function posCashier() {
	url = CUST_URL + USER + '/showCashier';

	$.getJSON(url, function (response) {

		$.each(response, function (idx, elem) {
			var job_id = elem.m_job_id;
			var cashier_id = elem.sys_user_id;
			var cashier_name = elem.username;
			if (job_id == 1)
				fillSCashier.append('<option value="' + cashier_id + '" selected="selected">' + cashier_name + '</option>');
		});
		fillSCashier.prop('disabled', true);
	});
}

// function show courier
function posCustomer(set, id) {
	url = CUST_URL + CUSTOMER + '/showCustomer';

	$.getJSON(url, function (response) {
		fillPosCustSelect.empty();
		fillPosCustSelect.append('<option selected="selected" value="">-- Choose One --</option>');
		$.each(response, function (idx, elem) {
			var customer_id = elem.m_bpartner_id;
			var customer_value = elem.value;
			var customer_name = customer_value + '_' + elem.name;
			if (id == customer_id)
				fillPosCustSelect.append('<option value="' + customer_id + '" selected="selected">' + customer_name + '</option>');
			else
				fillPosCustSelect.append('<option value="' + customer_id + '">' + customer_name + '</option>');
		});
	});
}

function posCourier(set, id) {
	url = CUST_URL + COURIER + '/showCourier';

	$.getJSON(url, function (response) {
		fillPosCourier.empty();
		fillPosCourier.append('<option selected="selected" value="">-- Choose One --</option>');
		$.each(response, function (idx, elem) {
			var courier_id = elem.m_courier_id;
			var courier_value = elem.value;
			var courier_name = elem.name;
			if (id == courier_id)
				fillPosCourier.append('<option value="' + courier_value + '" selected="selected">' + courier_name + '</option>');
			else
				fillPosCourier.append('<option value="' + courier_value + '">' + courier_name + '</option>');
		});
	});
}

function posCity(set, id) {
	url = CUST_URL + CITY + '/showCity';

	$.ajax({
		url: url,
		type: 'POST',
		data: {
			id: null
		},
		dataType: 'JSON',
		success: function (result) {
			fillPosCity.empty();
			fillPosCity.append('<option selected="selected" value="">-- Choose One --</option>');
			$.each(result, function (idx, elem) {
				var city_id = elem.m_city_id;
				var city_type = elem.type;
				var city_name = city_type + ' ' + elem.name;

				if (id == city_id)
					fillPosCity.append('<option value="' + city_id + '" selected="selected">' + city_name + '</option>');
				else
					fillPosCity.append('<option value="' + city_id + '">' + city_name + '</option>');
			});
		}
	});
}

function getDelivery(set, id) {
	var delivery = 155; //Jakarta Utara
	var destination = 0;
	var totalWeight = 0;
	var courier = null;

	fillPosCourier.change(function (e) {
		url = SITE_URL + '/cost';
		destination = $('#pos_city option:selected').val();
		totalWeight = fillPosWeight.val();
		courier = $(this).val();

		fillPosDelivery.prop('disabled', true);
		fillPosDelivery.empty();
		$.ajax({
			url: url,
			type: 'POST',
			data: {
				origin: delivery,
				destination: destination,
				weight: totalWeight,
				courier: courier
			},
			dataType: 'JSON',
			success: function (result) {
				if (result.code === 400) {
					Toast.fire({
						type: 'error',
						title: result.description
					});
				} else {
					fillPosDelivery.prop('disabled', false);
					fillPosDelivery.append('<option selected="selected" value="">-- Choose One --</option>');
					$.each(result, function (idx, elem) {
						var costs = elem.cost;
						var desc = elem.description;
						var service = elem.service;
						$.each(costs, function (idx, obj) {
							var etd = obj.etd; //estimated delivery
							var cost = obj.value;
							var delivery_name = service + ' - ' + '(Rp. ' + formatRupiah(cost) + ', Estimasi pengiriman : ' + etd + ' Hari)';
							fillPosDelivery.append('<option value="' + service + '/' + cost + '">' + delivery_name + '</option>');
						})
					});
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.info(errorThrown)
				alert(errorThrown)
			}
		});
	});

	fillPosCity.change(function (evt) {
		url = SITE_URL + '/cost';
		destination = $(this).val();
		totalWeight = fillPosWeight.val();
		courier = $('#pos_courier option:selected').val();

		fillPosDelivery.prop('disabled', true);
		fillPosDelivery.empty();
		$.ajax({
			url: url,
			type: 'POST',
			data: {
				origin: delivery,
				destination: destination,
				weight: totalWeight,
				courier: courier
			},
			dataType: 'JSON',
			success: function (result) {
				if (result.code === 400) {
					Toast.fire({
						type: 'error',
						title: result.description
					});
				} else {
					fillPosDelivery.prop('disabled', false);
					fillPosDelivery.append('<option selected="selected" value="">-- Choose One --</option>');
					$.each(result, function (idx, elem) {
						var costs = elem.cost;
						var desc = elem.description;
						var service = elem.service;
						$.each(costs, function (idx, obj) {
							var etd = obj.etd; //estimated delivery
							var cost = obj.value;
							var delivery_name = service + ' - ' + '(Rp. ' + formatRupiah(cost) + ', Estimasi pengiriman : ' + etd + ' Hari)';
							fillPosDelivery.append('<option value="' + service + '/' + cost + '">' + delivery_name + '</option>');
						})
					});
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.info(errorThrown)
				alert(errorThrown)
			}
		});
	});
}

function posAccount(set, id) {
	url = CUST_URL + ACCOUNT + '/showAccount';

	$.getJSON(url, function (response) {
		fillPosBank.empty();
		fillPosBank.append('<option selected="selected" value="">-- Choose One --</option>');

		$.each(response, function (idx, elem) {
			var account_id = elem.m_account_id;
			var bank = elem.bank;
			var accountno = elem.accountno;
			var account_name = accountno + '_' + bank + ' - ' + elem.name;

			if (id == account_id)
				fillPosBank.append('<option value="' + account_id + '" selected="selected">' + account_name + '</option>');
			else
				fillPosBank.append('<option value="' + account_id + '">' + account_name + '</option>');
		});
	});
}

// function auto focus field barcode
function autoFocus() {
	document.getElementById('pos_barcode').focus();
}

function clearFilPos() {
	fillSBarcode.val('');
}

function clearErrPos() {
	errPosCustSelect.html('');
	errPosCustInput.html('');
	errPosPhone.html('');
	errPosCourier.html('');
	errPosCity.html('');
	errPosAddress.html('');
	errPosDelivery.html('');
	fillPosPhone.removeClass(isInvalid);
	fillPosAddress.removeClass(isInvalid);
	errPosPayment.html('');
	errPosBank.html('');
}

function chkdPos() { //checked
	fillPosCustInput.prop('readonly', true);
	fillPosPhone.prop('readonly', true);
	fillPosAddress.prop('readonly', true);
	fillPosJMarket.prop('readonly', true);
	fillPosNote.prop('readonly', true);
	fillPosWeight.prop('readonly', true);
	fillPosCustSelect.prop('disabled', true);
	fillPosCourier.prop('disabled', true);
	fillPosCity.prop('disabled', true);
	fillPosDelivery.prop('disabled', true);
	cxbIsmember.prop('disabled', true);
	fillPosPayment.prop('disabled', true);
	fillPosBank.prop('disabled', true);
}

function unchkdPos() { //unchecked
	fillPosCustInput.prop('readonly', false);
	fillPosPhone.prop('readonly', false);
	fillPosAddress.prop('readonly', false);
	fillPosJMarket.prop('readonly', false);
	fillPosNote.prop('readonly', false);
	fillPosCustSelect.prop('disabled', false);
	fillPosCourier.prop('disabled', false);
	fillPosCity.prop('disabled', false);
	fillPosDelivery.prop('disabled', false);
	cxbIsmember.prop('disabled', false);
	fillPosPayment.prop('disabled', false);
	fillPosBank.prop('disabled', false);
}


$(document).on('click', '#close_checkout, #btn_close_pos', function (e) {
	$('#modal_checkout').modal('hide');
	$('#form_checkout')[0].reset();
	clearErrPos();
	unchkdPos();
});
