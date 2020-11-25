//defined table product
_tablePro = $('#tb_product').DataTable({
	'ajax': SITE_URL + SHOWALL,
	'processing': true,
	'language': {
		'processing': '<i class="fas fa-spinner fa-spin fa-1x fa-fw"></i><span> Processing...</span>'
	},
	'columnDefs': [{
			'targets': -1,
			'orderable': false //nonaktif sort by
		},
		{
			'targets': 0,
			'visible': false //hide column
		}
	]
});

//defined table category
_tableCat = $('#tb_category').DataTable({
	'ajax': SITE_URL + SHOWALL,
	'processing': true,
	'language': {
		'processing': '<i class="fas fa-spinner fa-spin fa-1x fa-fw"></i><span> Processing...</span>'
	},
	'columnDefs': [{
			'targets': -1,
			'orderable': false //nonaktif sort by
		},
		{
			'targets': 0,
			'visible': false //hide column
		}
	]
});

//defined table job
_tableJob = $('#tb_job').DataTable({
	'ajax': SITE_URL + SHOWALL,
	'processing': true,
	'language': {
		'processing': '<i class="fas fa-spinner fa-spin fa-1x fa-fw"></i><span> Processing...</span>'
	},
	'columnDefs': [{
			'targets': -1,
			'orderable': false //nonaktif sort by
		},
		{
			'targets': 0,
			'visible': false //hide column
		}
	]
});

_tableSo = $('#tb_sales').DataTable({
	// 'ajax': SITE_URL + STORE,
	'columnDefs': [
		// {
		// 	'targets': -1,
		// 	'orderable': false //nonaktif sort by
		// },
		{
			'targets': 0,
			'visible': false //hide column
		}
	]
});

//defined table greeting
_tableGre = $('#tb_greeting').DataTable({
	'ajax': SITE_URL + SHOWALL,
	'processing': true,
	'language': {
		'processing': '<i class="fas fa-spinner fa-spin fa-1x fa-fw"></i><span> Processing...</span>'
	},
	'columnDefs': [{
			'targets': -1,
			'orderable': false //nonaktif sort by
		},
		{
			'targets': 0,
			'visible': false //hide column
		}
	]
});

//defined table uom
_tableUom = $('#tb_uom').DataTable({
	'ajax': SITE_URL + SHOWALL,
	'processing': true,
	'language': {
		'processing': '<i class="fas fa-spinner fa-spin fa-1x fa-fw"></i><span> Processing...</span>'
	},
	'columnDefs': [{
			'targets': -1,
			'orderable': false //nonaktif sort by
		},
		{
			'targets': 0,
			'visible': false //hide column
		}
	]
});

//defined table customer
_tableCus = $('#tb_customer').DataTable({
	'ajax': SITE_URL + SHOWALL,
	'processing': true,
	'language': {
		'processing': '<i class="fas fa-spinner fa-spin fa-1x fa-fw"></i><span> Processing...</span>'
	},
	'columnDefs': [{
			'targets': -1,
			'orderable': false //nonaktif sort by
		},
		{
			'targets': 0,
			'visible': false //hide column
		}
	],
	'autoWidth': true
});

_tableSup = $('#tb_supplier').DataTable({
	'ajax': SITE_URL + SHOWALL,
	'processing': true,
	'language': {
		'processing': '<i class="fas fa-spinner fa-spin fa-1x fa-fw"></i><span> Processing...</span>'
	},
	'columnDefs': [{
			'targets': -1,
			'orderable': false //nonaktif sort by
		},
		{
			'targets': 0,
			'visible': false //hide column
		}
	],
	'autoWidth': true
});

_tableProv = $('#tb_province').DataTable({
	'ajax': SITE_URL + SHOWALL,
	'processing': true,
	'language': {
		'processing': '<i class="fas fa-spinner fa-spin fa-1x fa-fw"></i><span> Processing...</span>'
	},
	'order': [2, 'asc'],
	'columnDefs': [{
			'targets': -1,
			'orderable': false //nonaktif sort by
		},
		{
			'targets': 0,
			'visible': false //hide column
		}
	]
});

_tableCity = $('#tb_city').DataTable({
	'ajax': SITE_URL + SHOWALL,
	'processing': true,
	'language': {
		'processing': '<i class="fas fa-spinner fa-spin fa-1x fa-fw"></i><span> Processing...</span>'
	},
	'order': [2, 'asc'],
	'columnDefs': [{
			'targets': -1,
			'orderable': false //nonaktif sort by
		},
		{
			'targets': 0,
			'visible': false //hide column
		}
	],
	'autoWidth': true
});

_tableCou = $('#tb_courier').DataTable({
	'ajax': SITE_URL + SHOWALL,
	'processing': true,
	'language': {
		'processing': '<i class="fas fa-spinner fa-spin fa-1x fa-fw"></i><span> Processing...</span>'
	},
	'columnDefs': [{
			'targets': -1,
			'orderable': false //nonaktif sort by
		},
		{
			'targets': 0,
			'visible': false //hide column
		}
	],
	'autoWidth': true
});

_tableAcc = $('#tb_account').DataTable({
	'ajax': SITE_URL + SHOWALL,
	'processing': true,
	'language': {
		'processing': '<i class="fas fa-spinner fa-spin fa-1x fa-fw"></i><span> Processing...</span>'
	},
	'columnDefs': [{
			'targets': -1,
			'orderable': false //nonaktif sort by
		},
		{
			'targets': 0,
			'visible': false //hide column
		}
	],
	'autoWidth': true
});

_tableUsr = $('#tb_user').DataTable({
	'ajax': SITE_URL + SHOWALL,
	'processing': true,
	'language': {
		'processing': '<i class="fas fa-spinner fa-spin fa-1x fa-fw"></i><span> Processing...</span>'
	},
	'columnDefs': [{
			'targets': -1,
			'orderable': false //nonaktif sort by
		},
		{
			'targets': 0,
			'visible': false //hide column
		}
	],
	'autoWidth': true
});

_tablePOS = $('#tb_sales_pos').DataTable({
	'columnDefs': [{
			'targets': -1,
			'orderable': false //nonaktif sort by
		},
		{
			'targets': [0, 1],
			'visible': false //hide column
		}
	],
	'ordering': false,
	'autoWidth': true,
	'lengthChange': false,
	'searching': false,
	'paging': false,
	'scrollY': 300,
	'scrollCollapse': true
	// 'info': false
});

_tableProList = $('#tb_product_list').DataTable({
	'processing': true,
	'language': {
		'processing': '<i class="fas fa-spinner fa-spin fa-1x fa-fw"></i><span> Processing...</span>'
	},
	'columnDefs': [{
			'targets': -1,
			'orderable': false //nonaktif sort by
		},
		{
			'targets': 0,
			'visible': false //hide column
		},
		{
			'targets': -1,
			'className': 'custom-pointer'
		}
	],
	'autoWidth': true,
	'searching': false,
	'lengthChange': false
});

_tableExp = $('#tb_expense').DataTable({
	'ajax': SITE_URL + SHOWALL,
	'processing': true,
	'language': {
		'processing': '<i class="fas fa-spinner fa-spin fa-1x fa-fw"></i><span> Processing...</span>'
	},
	'columnDefs': [{
			'targets': -1,
			'orderable': false //nonaktif sort by
		},
		{
			'targets': 0,
			'visible': false //hide column
		}
	],
	'autoWidth': true
});

_tableExpLine = $('#tb_expenseline').DataTable({
	'autoWidth': true,
	'lengthChange': false,
	'pageLength': 5,
	'searching': false,
	'ordering': false
});

function reloadTable(last_url) {
	if (last_url == 'product')
		_tablePro.ajax.reload(null, false);
	else if (last_url == 'so')
		_tableSo.ajax.reload(null, false);
	else if (last_url == 'category')
		_tableCat.ajax.reload(null, false);
	else if (last_url == 'job')
		_tableJob.ajax.reload(null, false);
	else if (last_url == 'greeting')
		_tableGre.ajax.reload(null, false);
	else if (last_url == 'uom')
		_tableUom.ajax.reload(null, false);
	else if (last_url == 'customer')
		_tableCus.ajax.reload(null, false);
	else if (last_url == 'supplier')
		_tableSup.ajax.reload(null, false);
	else if (last_url == 'province')
		_tableProv.ajax.reload(null, false);
	else if (last_url == 'city')
		_tableCity.ajax.reload(null, false);
	else if (last_url == 'courier')
		_tableCou.ajax.reload(null, false);
	else if (last_url == 'account')
		_tableAcc.ajax.reload(null, false);
	else if (last_url == 'user')
		_tableUsr.ajax.reload(null, false);
	else if (last_url == 'expense')
		_tableExp.ajax.reload(null, false);
	else
		console.info(false)
}
