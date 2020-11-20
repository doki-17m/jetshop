const fillCRCc = $('[name = cus_code]'),
	fillCRName = $('[name = cus_name]'),
	fillCRGre = $('[name = cus_greeting]'),
	fillCREmail = $('[name = cus_email]'),
	fillCRAddress = $('[name = cus_address]'),
	fillCRPhone = $('[name = cus_phone]'),
	fillCRPhone2 = $('[name = cus_phone2]'),
	fillCRSales = $('[name = cus_sales]'),
	fillCRFSale = $('[name = cus_firstsale]'),
	fillCRProv = $('[name = cus_province]'),
	fillCRCity = $('[name = cus_city]'),
	fillCRDesc = $('[name = cus_desc]');

//error field form
const errCRCc = $('#error_cus_code'),
	errCRName = $('#error_cus_name'),
	errCREmail = $('#error_cus_email'),
	errCRAddress = $('#error_cus_address'),
	errCRPhone = $('#error_cus_phone'),
	errCRProv = $('#error_cus_province'),
	errCRCity = $('#error_cus_city');

const hideCRCity = $('[name = hidden_city]');

const classCRFSale = $('.cus_firstsale');

cusGreeting(); //Show data all greeting
cusProv(); //Show data all province
getCity(); //Get data city based on province
cusSales(); //Show data salesrep

btnNewCus.click(function () {
	openModalForm();
	Largemodal();
	Scrollmodal();
	modalTitle.text('New Customer');
	clearCus();
	cusActive.prop('checked', true);
	formID = cusForm[0]['id'];
	isActive(formID);
	fSaleShowHide();
	setSave = 'add';
});

_tableCus.on('click', 'td:not(:last-child)', function (e) {
	e.preventDefault()
	const formID = cusForm[0]['id'];
	const row = _tableCus.row(this).data();
	ID = row[0]; //index array ID
	let NAME = row[3];
	openModalForm();
	Largemodal();
	Scrollmodal();
	modalTitle.html('Customer : ' + NAME);
	isActive(formID);
	fSaleShowHide();
	clearCus();
	url = SITE_URL + SHOW + ID;
	setSave = 'update';

	$.ajax({
		url: url,
		type: 'GET',
		dataType: 'JSON',
		success: function (result) {
			hideCRCity.val(result.city_id),
				fillCRCc.val(result.value),
				fillCRGre.val(result.m_greeting_id).change(),
				fillCRName.val(result.name),
				fillCREmail.val(result.email),
				fillCRAddress.val(result.address),
				fillCRPhone.val(result.phone),
				fillCRPhone2.val(result.phone2),
				fillCRProv.val(result.province_id).change(),
				fillCRCity.val(result.city_id).change(),
				fillCRSales.val(result.salesrep_id).change(),
				fillCRFSale.val(result.firstsale),
				fillCRDesc.val(result.description);

			if (result.isactive == active)
				cusActive.prop('checked', true),
				readonly(formID, false);
			else
				cusActive.prop('checked', false),
				readonly(formID, true);
		}
	});

});

function errFormCus(data) {
	if (data.error_cus_code != '')
		errCRCc.html(data.error_cus_code),
		fillCRCc.addClass(isInvalid);
	else
		errCRCc.html(''),
		fillCRCc.removeClass(isInvalid);

	if (data.error_cus_name != '')
		errCRName.html(data.error_cus_name),
		fillCRName.addClass(isInvalid);
	else
		errCRName.html(''),
		fillCRName.removeClass(isInvalid);

	if (data.error_cus_email != '')
		errCREmail.html(data.error_cus_email),
		fillCREmail.addClass(isInvalid);
	else
		errCREmail.html(''),
		fillCREmail.removeClass(isInvalid);

	if (data.error_cus_address != '')
		errCRAddress.html(data.error_cus_address),
		fillCRAddress.addClass(isInvalid);
	else
		errCRAddress.html(''),
		fillCRAddress.removeClass(isInvalid);

	if (data.error_cus_phone != '')
		errCRPhone.html(data.error_cus_phone),
		fillCRPhone.addClass(isInvalid);
	else
		errCRPhone.html(''),
		fillCRPhone.removeClass(isInvalid);

	if (data.error_cus_province != '')
		errCRProv.html(data.error_cus_phone);
	else
		errCRProv.html('');

	if (data.error_cus_city != '')
		errCRCity.html(data.error_cus_city);
	else
		errCRCity.html('');
}

function clearCus() {
	cusForm[0].reset(),
		fillCRGre.val(null).change(),
		fillCRSales.val(null).change(),
		errCRCc.html(''),
		errCRName.html(''),
		errCREmail.html(''),
		errCRAddress.html(''),
		errCRPhone.html(''),
		fillCRProv.val(null).change(),
		fillCRCity.val(null).change(),
		fillCRCity.empty(),
		fillCRCc.removeClass(isInvalid),
		fillCRName.removeClass(isInvalid),
		fillCREmail.removeClass(isInvalid),
		fillCRAddress.removeClass(isInvalid),
		fillCRPhone.removeClass(isInvalid);
}

function chkdCus() { //checked
	fillCRCc.prop('readonly', true),
		fillCRGre.prop('disabled', true),
		fillCRName.prop('readonly', true),
		fillCREmail.prop('readonly', true),
		fillCRProv.prop('disabled', true),
		fillCRCity.prop('disabled', true),
		fillCRAddress.prop('readonly', true),
		fillCRPhone.prop('readonly', true),
		fillCRPhone2.prop('readonly', true),
		fillCRSales.prop('disabled', true),
		fillCRDesc.prop('readonly', true);
}

function unchkdCus() { //unchecked
	fillCRCc.prop('readonly', false),
		fillCRGre.prop('disabled', false),
		fillCRName.prop('readonly', false),
		fillCREmail.prop('readonly', false),
		fillCRProv.prop('disabled', false),
		fillCRCity.prop('disabled', false),
		fillCRAddress.prop('readonly', false),
		fillCRPhone.prop('readonly', false),
		fillCRPhone2.prop('readonly', false),
		fillCRSales.prop('disabled', false),
		fillCRDesc.prop('readonly', false);
}

function fSaleShowHide() {
	if (fillCRFSale[0].value !== '')
		classCRFSale.show(),
		fillCRFSale.prop('readonly', true);
	else
		classCRFSale.hide(),
		fillCRFSale.prop('readonly', false);
}

function cusGreeting() {
	url = CUST_URL + GREETING + '/showGreeting';

	$.getJSON(url, function (response) {
		fillCRGre.append('<option selected="selected" value="">-- Choose One --</option>');
		$.each(response, function (idx, elem) {
			var greeting_id = elem.m_greeting_id;
			var greeting_name = elem.name;
			fillCRGre.append('<option value="' + greeting_id + '">' + greeting_name + '</option>');
		});
	});
}

function cusSales() {
	url = CUST_URL + USER + '/showSales';

	$.getJSON(url, function (response) {
		fillCRSales.append('<option selected="selected" value="">-- Choose One --</option>');
		$.each(response, function (idx, elem) {
			var sales_id = elem.sys_user_id;
			var sales_username = elem.value;
			fillCRSales.append('<option value="' + sales_id + '">' + sales_username + '</option>');
		});
	});
}

function cusProv() {
	url = CUST_URL + PROVINCE + '/showProvince';

	$.getJSON(url, function (response) {
		fillCRProv.append('<option selected="selected" value="">-- Choose One --</option>');
		$.each(response, function (idx, elem) {
			var province_id = elem.m_province_id;
			var province_name = elem.name;
			fillCRProv.append('<option value="' + province_id + '">' + province_name + '</option>');
		});
	});
}

function getCity() {
	fillCRProv.change(function (e) {
		e.preventDefault();
		let province_id = $(this).val();
		let setCity_id = hideCRCity.val();

		url = CUST_URL + CITY + '/showCity';

		$.ajax({
			url: url,
			type: 'POST',
			data: {
				id: province_id
			},
			dataType: 'JSON',
			success: function (result) {
				fillCRCity.empty();
				fillCRCity.append('<option selected="selected" value="">-- Choose One --</option>');
				$.each(result, function (idx, elem) {
					var city_id = elem.m_city_id;
					var city_type = elem.type;
					var city_name = city_type + ' ' + elem.name;

					if (setCity_id == elem.m_city_id)
						fillCRCity.append('<option selected="selected" value="' + city_id + '">' + city_name + '</option>').change();
					else
						fillCRCity.append('<option value="' + city_id + '">' + city_name + '</option>');
				});
			}
		});
	});
}
