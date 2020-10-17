const fillPCode = $('[name = pro_code]');
const fillPName = $('[name = pro_name]');
const fillPDesc = $('[name = pro_desc]');
const fillPCatg = $('[name = pro_catg]');
const fillPUom = $('[name = pro_uom]');
const fillPPurch = $('[name = pro_purchidr]');
const fillPSales = $('[name = pro_slsidr]');
const fillPQty = $('[name = pro_qty]');

btnNewProduct.click(function () {
	openModalForm();
	modalDialog.addClass('modal-dialog-scrollable modal-lg');
	modalTitle.text('New Product');
	setSave = 'add';
	proForm[0].reset();
	proActive.attr('checked', true);
})

btnSave.click(function () {
	const form = proForm.serialize() +
		'&isactive=' + active_pro();

	if (setSave === 'add')
		url = SITE_URL + CREATE;
	else
		url = SITE_URL + EDIT + ID;

	$.ajax({
		url: url,
		type: 'POST',
		data: form,
		dataType: 'JSON',
		success: function (result) {
			closeModalForm();
			refreshPro();
			console.log(result)
		}
	})
})

_tablePro.on('click', 'td:not(:last-child)', function (e) {
	e.preventDefault()
	const row = _tablePro.row(this).data();
	ID = row[0]; //index array
	url = SITE_URL + SHOW + ID;
	openModalForm();
	modalDialog.addClass('modal-dialog-scrollable modal-lg');
	modalTitle.html('Product'+ ' : ' +row[1]);
	proForm[0].reset();

	$.ajax({
		url: url,
		type: 'GET',
		dataType: 'JSON',
		success: function (result) {
			fillPCode.val(result.value);
			fillPName.val(result.name);
			fillPDesc.val(result.description);
			// fillPProfit.val(result.profitpercen);
			fillPUom.val(result.unitmeasure).change();
			fillPQty.val(result.qtyonhand);
			// fillPReorder.val(result.reorderlvl);
			fillPPurch.val(result.costprice);
			fillPSales.val(result.sellprice);

			if (result.isactive == 'Y')
				proActive.attr('checked', true);
			else
				proActive.attr('checked', false);
		}
	})
})

function delete_data(id) {
	url = SITE_URL + DELETE + id;
	Swal.fire({
		title: 'Delete?',
		text: "Are you sure you wish to delete the selected data ? ",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#d33',
		cancelButtonColor: 'btn-default',
		confirmButtonText: '<i class="fas fa-check"> Yes</i>',
		cancelButtonText: '<i class="fas fa-times"> No</i>'
	}).then((data) => {
		if (data.value) //true
			$.ajax({
				url: url,
				type: 'POST',
				Type: 'JSON',
				success: function (result) {
					// console.log(result)
					refreshPro();
				}
			})
	})
}

function active_pro() {
	var value;
	if (proActive.is(':checked'))
		value = 'Y';
	else
		value = 'N';
	return value;
}
