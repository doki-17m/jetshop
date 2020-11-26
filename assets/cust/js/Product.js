const fillPCode = $('[name = pro_code]'),
	fillPName = $('[name = pro_name]'),
	fillPDesc = $('[name = pro_desc]'),
	fillPCatg = $('[name = pro_catg]'),
	fillPUom = $('[name = pro_uom]'),
	fillPWeight = $('[name = pro_weight]'),
	fillPMinOrder = $('[name = pro_minorder]'),
	fillPPurch = $('[name = pro_purchidr]'),
	fillPSales = $('[name = pro_slsidr]'),
	fillPImage = $('[name = pro_image]'),
	fillPQty = $('[name = pro_qty]');

const errPCode = $('#error_pro_code'),
	errPName = $('#error_pro_name'),
	errPWeight = $('#error_pro_weight'),
	errPMinOrder = $('#error_pro_minorder'),
	errPPurch = $('#error_pro_purchidr'),
	errPSales = $('#error_pro_slsidr'),
	errPCatg = $('#error_pro_catg'),
	errPQty = $('#error_pro_qty');

const groupPQty = $('#group_pro_qty'),
	groupPMinOrder = $('#group_pro_minorder');

const msgPWeight = $('#msg_pro_weight');

const formUResult = $('#form-upload-result'),
	formUpload = $('#form-upload'),
	formResult = $('.form-result');

const btnDelImg = $('#btn_delimg');

const IMAGE_PATH = '/assets/cust/images/';

const TMP = '/tmp/';

// proUom(setSave);

btnNewPro.click(function () {
	openModalForm();
	Largemodal();
	Scrollmodal();
	modalTitle.text('New Product');
	clearPro();
	fillPHide();
	proActive.attr('checked', true);
	const formID = proForm[0]['id'];
	isActive(formID);
	setSave = 'add';
	proUom(setSave, 0);
	proCategory(setSave, 0);
});

_tablePro.on('click', 'td:not(:last-child)', function (e) {
	e.preventDefault();
	const formID = proForm[0]['id'];
	const row = _tablePro.row(this).data();
	ID = row[0]; //index array ID
	var NAME = row[3];
	openModalForm();
	Scrollmodal();
	Largemodal();
	modalTitle.html(NAME);

	clearPro();
	fillPHide();
	isActive(formID);
	setSave = 'update';
	url = SITE_URL + SHOW + ID;

	$.getJSON(url, function (result) {
		proCategory(setSave, result.m_product_category_id);
		proUom(setSave, result.m_uom_id);
		fillPCode.val(result.value);
		fillPName.val(result.name);
		fillPDesc.val(result.description);
		fillPWeight.val(result.weight);
		fillPQty.val(result.qty);
		fillPMinOrder.val(result.minorder);
		fillPPurch.val(formatRupiah(result.purchprice));
		fillPSales.val(formatRupiah(result.salesprice));
		var image = result.ad_image_id;

		if (image !== '')
			setAction = setSave,
			loadImage(image, setAction),
			imgSrc = image;
		else
			setAction = 'add';

		if (result.isactive == active)
			proActive.prop('checked', true),
			readonly(formID, false);
		else
			proActive.prop('checked', false),
			readonly(formID, true);
	});
});

fillPImage.change(function (e) {
	e.preventDefault();
	var formData = new FormData();
	const image = $(this).get(0).files[0];
	formData.append('pro_image', image);

	url = SITE_URL + '/upload_image';
	$.ajax({
		url: url,
		type: 'POST',
		data: formData,
		processData: false,
		contentType: false,
		cache: false,
		async: false,
		dataType: 'JSON',
		success: function (result) {
			if (result.success)
				setAction = 'add',
				loadImage(replaceChar(result.success), setAction),
				imgSrc = replaceChar(result.success),
				formUpload.hide();
			else
				alert(replaceChar(result.error)),
				formUpload.show();
		},
		error: function (jqXHR, textStatus, errorThrown) {
			console.info(errorThrown)
			alert(errorThrown)
		}
	});
});

//Button delete image
btnDelImg.click(function (e) {
	deleteImage(imgSrc)
});

function loadImage(src, action) {
	const img = '<img class="img-result"/>';
	formResult.show().append(img);
	if (action === 'add')
		$('.img-result').attr('src', CUST_URL + TMP + src);
	else
		$('.img-result').attr('src', CUST_URL + IMAGE_PATH + src),
		formUpload.hide();
}

function deleteImage(path) {
	url = SITE_URL + '/destroy_image';
	var product_id = 0;
	if (setSave == 'update')
		product_id = ID;

	$.post(url, {
		src: path,
		set: setAction,
		id: product_id
	}, function (e) {
		imgSrc = 0;
		$('.img-result').remove();
		formResult.hide();
		formUpload.show();
	});
}

function errFormPro(data) {
	if (data.error_pro_code != '')
		errPCode.html(data.error_pro_code),
		fillPCode.addClass(isInvalid);
	else
		errPCode.html(''),
		fillPCode.removeClass(isInvalid);

	if (data.error_pro_name != '')
		errPName.html(data.error_pro_name),
		fillPName.addClass(isInvalid);
	else
		errPName.html(''),
		fillPName.removeClass(isInvalid);

	if (data.error_pro_weight != '')
		errPWeight.html(data.error_pro_weight),
		fillPWeight.addClass(isInvalid),
		msgPWeight.hide();
	else
		errPWeight.html(''),
		fillPWeight.removeClass(isInvalid),
		msgPWeight.show();

	if (data.error_pro_minorder != '')
		errPMinOrder.html(data.error_pro_minorder),

		fillPMinOrder.addClass(isInvalid);
	else
		errPMinOrder.html(''),
		fillPMinOrder.removeClass(isInvalid);

	if (data.error_pro_purchidr != '')
		errPPurch.html(data.error_pro_purchidr),
		fillPPurch.addClass(isInvalid);
	else
		errPPurch.html(''),
		fillPPurch.removeClass(isInvalid);

	if (data.error_pro_slsidr != '')
		errPSales.html(data.error_pro_slsidr),
		fillPSales.addClass(isInvalid);
	else
		errPSales.html(''),
		fillPSales.removeClass(isInvalid);

	if (data.error_pro_catg != '')
		errPCatg.html(data.error_pro_catg);
	else
		errPCatg.html('');

	if (data.error_pro_qty != '')
		errPQty.html(data.error_pro_qty),
		fillPQty.addClass(isInvalid);
	else
		errPQty.html(''),
		fillPQty.removeClass(isInvalid);
}

function clearPro() {
	proForm[0].reset();
	errPCode.html('');
	errPName.html('');
	errPWeight.html('');
	errPMinOrder.html('');
	errPPurch.html('');
	errPSales.html('');
	errPCatg.html('');
	errPQty.html('');
	fillPCatg.val(null).change();
	fillPUom.val(null).change();
	fillPCode.removeClass(isInvalid);
	fillPName.removeClass(isInvalid);
	fillPWeight.removeClass(isInvalid);
	fillPMinOrder.removeClass(isInvalid);
	fillPPurch.removeClass(isInvalid);
	fillPSales.removeClass(isInvalid);
	fillPQty.removeClass(isInvalid);
	$('.img-result').remove();
	formResult.hide();
	formUpload.show();
	imgSrc = 0;
}

function chkdPro() { //checked
	fillPCode.prop('readonly', true);
	fillPName.prop('readonly', true);
	fillPDesc.prop('readonly', true);
	fillPWeight.prop('readonly', true);
	fillPMinOrder.prop('readonly', true);
	fillPPurch.prop('readonly', true);
	fillPSales.prop('readonly', true);
	fillPCatg.prop('disabled', true);
	fillPUom.prop('disabled', true);
}

function unchkdPro() { //unchecked
	fillPCode.prop('readonly', false);
	fillPName.prop('readonly', false);
	fillPDesc.prop('readonly', false);
	fillPWeight.prop('readonly', false);
	fillPMinOrder.prop('readonly', false);
	fillPPurch.prop('readonly', false);
	fillPSales.prop('readonly', false);
	fillPCatg.prop('disabled', false);
	fillPUom.prop('disabled', false);
}

function proCategory(set, id) {
	url = CUST_URL + CATEGORY + '/showCategory';

	$.getJSON(url, function (response) {
		fillPCatg.empty();
		fillPCatg.append('<option selected="selected" value="">-- Choose One --</option>');

		$.each(response, function (idx, elem) {
			var category_id = elem.m_product_category_id;
			var category_name = elem.name;
			if (id == category_id)
				fillPCatg.append('<option value="' + category_id + '" selected="selected">' + category_name + '</option>');
			else
				fillPCatg.append('<option value="' + category_id + '">' + category_name + '</option>');
		});
	});
}

function proUom(set, id) {
	url = CUST_URL + UOM + '/showUom';

	$.getJSON(url, function (response) {
		fillPUom.empty();
		fillPUom.append('<option selected="selected" value="">-- Choose One --</option>');
		$.each(response, function (idx, elem) {
			var uom_id = elem.m_uom_id;
			var uom_code = elem.value;
			var uom_name = elem.name;
			if (set == 'add')
				if (uom_id == 1 || uom_code === 'PCS')
					fillPUom.append('<option value="' + uom_id + '" selected="selected">' + uom_name + '</option>');
				else
					fillPUom.append('<option value="' + uom_id + '">' + uom_name + '</option>');
			else if (set == 'update' && id == uom_id)
				fillPUom.append('<option value="' + uom_id + '" selected="selected">' + uom_name + '</option>');
			else
				fillPUom.append('<option value="' + uom_id + '">' + uom_name + '</option>');
		});

	});
}

function fillPShow() {
	groupPMinOrder.show();
}

function fillPHide() {
	groupPMinOrder.hide();
}
