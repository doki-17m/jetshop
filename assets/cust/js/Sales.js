const fillSOrder = $('[name = so_orderno]');
const fillSCustomer = $('[name = so_cusname]');
const fillSQty = $('[name = so_qty]');
const fillSPrice = $('[name = so_pricelist]');
var _tableSDetails;

btnNewSo.click(function () {
	openModalForm();
	modalDialog.addClass('modal-dialog-scrollable modal-lg');
	modalTitle.text('New Sales Order');
	setSave = 'add';
	soForm[0].reset();
})

_tableSDetails = $('#tb_salesdetail').DataTable({
	'lengthChange': false,
	'searching': false,
	'ordering': false,
	'pageLength': 5
	// 'columnDefs': [
	// 	{
	// 		'targets': 0,
	// 		'visible': false //hide column
	// 	}
	// ]
})

btnNewDetails.click(function (e) {
	e.preventDefault();
	table(null)
	const allPage = _tableSDetails.rows().nodes()
	var productOptions = $('.receipts_details_product', allPage);
	product_details(productOptions, null)
	// console.log(CUST_URL)
})

function table(data) {
	if (data !== null) {
		var product;
		for (var i = 0; i < data.length; i++) {
			_tableSDetails.row.add([
				'<select class="form-control receipts_details_product">' +
				'<option value="' + data[i].m_product_id + '"></option>' +
				'</select>',
				'<input type="number" class="form-control receipts_details_qty" value="' + data[i].qtyordered + '">',
				'<input type="text" class="form-control receipts_details_price" value="' + data[i].sellprice + '">',
				'<a class="btn" title="Delete"><i class="fa fa-trash-alt text-danger"></i></a>'
			]).draw(false);
			const allPage = _tableSDetails.rows().nodes();
			product = $('.receipts_details_product', allPage)
		}
		product_details(product, data)
	} else {
		_tableSDetails.row.add([
			'<select class="form-control receipts_details_product">' +
			'</select>',
			'<input type="number" class="form-control receipts_details_qty">',
			'<input type="number" class="form-control">',
			'<a class="btn" title="Delete"><i class="fa fa-trash-alt text-danger"></i></a>'
		]).draw(false);
	}
}



_tableSo.on('click', function (e) {
	e.preventDefault()
	const row = _tableSo.row(this).data();
	ID = row[0]; //index array
	url = SITE_URL + SHOW + ID;
	openModalForm();
	modalDialog.addClass('modal-dialog-scrollable modal-lg');
	modalTitle.html('Sales Order' + ' : ' + row[1]);
	soForm[0].reset();

	$.ajax({
		url: url,
		type: 'GET',
		dataType: 'JSON',
		success: function (result) {
			fillSOrder.val(result.documentno);
			fillSCustomer.val(result.m_customer);
			fillSQty.val(result.qtyordered);
			fillSPrice.val(result.pricelist);
		}
	})
})
