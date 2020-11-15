//field pos
const fillSDate = $('[name = pos_date]'),
	fillSCashier = $('[name = pos_cashier]'),
	fillSBarcode = $('[name = pos_barcode]');

const cxbIsWalk = $('#pos_iswic'); // checkbox walk in customer

const msgInvoiceNo = $('#documentno'),
	msgGrandTotal = $('#grandtotal');

const btnCheckout = $('#btn_checkout'),
	btnPrint = $('#btn_print'),
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
	fillPosProvince = $('[name = pos_province]'),
	fillPosCity = $('[name = pos_city]'),
	fillPosAddress = $('[name = pos_address]'),
	fillPosJMarket = $('[name = pos_job_market]'),
	fillPosNote = $('[name = pos_note]');

const groupPosCustSelect = $('#pos_cust_id'),
	groupPosCustInput = $('#pos_cust_name'),
	groupPosCustDelivery = $('#pos_delivery'),
	groupPosCustProvince = $('#pos_province'),
	groupPosCustCity = $('#pos_city'),
	groupPosCustAddress = $('#pos_address'),
	groupPosCustJMarket = $('#pos_job_market');

const cxbIsmember = $('#pos_ismember'); // checkbox walk in customer

const ACTION_increment = 'INCREMENT',
	ACTION_decrement = 'DECREMENT';

let totalAmount = 0;
let setQty = 0;
var arrCart = [];

$(document).ready(function () {
	cxbIsWalk.prop('checked', true);
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
	_tablePOS.on('keypress keyup blur', '.quantity-field', function (evt) {
		$(this).val($(this).val().replace(/[^\d].+/, ""));
		if ((evt.which < 48 || evt.which > 57))
			evt.preventDefault();
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
		var chkVal = false;

		if (cxbIsWalk.is(':checked'))
			chkVal = true;

		// if (existDataTable)
		checkoutData(chkVal);
	});

	if (LAST_URL == 'sales')
		autoComplete();
})

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
			msgGrandTotal.html(totalAmount);
		} else {
			totalAmount = 0;
			msgGrandTotal.html(totalAmount);
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

function checkoutData(iswalkin) {
	var lastArrCart = arrCart[arrCart.length - 1]; // last index array datatables

	$('#modal_checkout').modal({
		backdrop: 'static',
		keyboard: false
	});
	Scrollmodal();
	getListCart(lastArrCart)

	if (iswalkin) {
		boxCustomer.hide();
		boxCart.addClass('col-md-12');
		modalDialog.removeClass('modal-xl');
	} else {
		boxCustomer.show();
		boxCart.removeClass('col-md-12');
		modalDialog.addClass('modal-xl');

		groupPosCustInput.hide();
		groupPosCustDelivery.hide();
		groupPosCustProvince.hide();
		groupPosCustCity.hide();
		groupPosCustAddress.hide();
		groupPosCustJMarket.hide();

		fillPosDelivery.prop('disabled', true);
		posCustomer(null, null);
		posCourier(null, null);
		posProv(null, null);
		getCity(null, null);
		getDelivery(null, null);
		getTotalWeight(lastArrCart);

		cxbIsmember.change(function (e) {
			var chkVal = true;
			if (!cxbIsmember.is(':checked')) {
				chkVal = false;
			}

			if (chkVal)
				groupPosCustSelect.show(),
				groupPosCustInput.hide();
			else
				groupPosCustSelect.hide(),
				groupPosCustInput.show();
		});

		fillPosCourier.change(function (e) {
			groupPosCustDelivery.show();
			groupPosCustProvince.show();
			groupPosCustCity.show();
			groupPosCustAddress.show();
		});

		fillPosDelivery.change(function (e) {
			groupPosCustJMarket.show();
		});
	}
}

function getListCart(dataCart) {
	var html = '';
	var cost = 0;
	var data = dataCart['data'];
	var total = dataCart['total'];
	var grandTotal = 0;
	$.each(data, function (idx, elem) {
		var qty = elem[1];
		var sku = elem[3];
		var amount = elem[6];
		html += '<li class="list-group-item"><a class="sku"><b>' + sku + '</b> x  ' + qty + '</a> <a class ="float-right subtotal">' + amount + '</a></li> ';
	})
	html += '<li class="list-group-item"><p style="text-align: center">Subtotal: <a class="float-right" id="subtotal">' + formatRupiah(total) + '</a></p></li>';
	html += '<li class="list-group-item"><p style="text-align: center">Ongkos Kirim: <a class="float-right" id="ongkir"></a></p></li>';
	fillPosDelivery.change(function (e) {
		cost = $(this).val().substring($(this).val().search('/') + 1);
		$('#ongkir').html(formatRupiah(cost));
		// grandTotal = total.add(cost);
		// console.log(grandTotal)
		// $('#grandTotal').html(formatRupiah(grandTotal));
	});
	grandTotal = formatRupiah(total);
	html += '<li class="list-group-item"><p style="text-align: center">Grand Total: <a class="float-right" id="grandTotal">' + grandTotal + '</a></p></li>';
	$('#detail_cart_list').html(html);
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
			var cashier_id = elem.m_user_id;
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

function posProv(set, id) {
	url = CUST_URL + PROVINCE + '/showProvince';

	$.getJSON(url, function (response) {
		fillPosProvince.empty();
		fillPosProvince.append('<option selected="selected" value="">-- Choose One --</option>');
		$.each(response, function (idx, elem) {
			var province_id = elem.m_province_id;
			var province_name = elem.name;
			if (id == province_id)
				fillPosProvince.append('<option value="' + province_id + '" selected="selected">' + province_name + '</option>');
			else
				fillPosProvince.append('<option value="' + province_id + '">' + province_name + '</option>');
		});
	});
}

function getCity(set, id) {
	fillPosProvince.change(function (e) {
		e.preventDefault();
		let province_id = $(this).val();

		url = CUST_URL + CITY + '/showCity';

		$.ajax({
			url: url,
			type: 'POST',
			data: {
				id: province_id
			},
			dataType: 'JSON',
			success: function (result) {
				fillPosCity.empty();
				fillPosCity.append('<option selected="selected" value="">-- Choose One --</option>');
				$.each(result, function (idx, elem) {
					var city_id = elem.m_city_id;
					var city_name = elem.name;

					if (id == city_id)
						fillPosCity.append('<option selected="selected" value="' + city_id + '">' + city_name + '</option>');
					else
						fillPosCity.append('<option value="' + city_id + '">' + city_name + '</option>');
				});
			}
		});
	});
}

function getDelivery(set, id) {
	var delivery = 155; //Jakarta Utara
	var destination = 0;
	var totalWeight = 0;
	var courier = null;

	fillPosCourier.change(function (e) {
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
						fillPosDelivery.append('<option value="' + etd + '">' + delivery_name + '</option>');
					})
				});
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
