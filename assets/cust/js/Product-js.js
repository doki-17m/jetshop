const PRODUCT = '/product',
	fillPCode = $('[name = pro_code]'),
	fillPName = $('[name = pro_name]'),
	fillPDesc = $('[name = pro_desc]'),
	fillPCatg = $('[name = pro_catg]'),
	fillPUom = $('[name = pro_uom]'),
	fillPPurch = $('[name = pro_purchidr]'),
	fillPSales = $('[name = pro_slsidr]'),
	fillPImage = $('[name = pro_image]');

const formUResult = $('#form-upload-result'),
	formUpload = $('#form-upload'),
	btnDelImg = $('#btn_delimg');

var Imgsrc;

btnNewPro.click(function () {
	openModalForm();
	modalDialog.addClass('modal-dialog-scrollable modal-lg');
	modalTitle.text('New Product');
	setSave = 'add';
	proForm[0].reset();
	proActive.attr('checked', true);
});

fillPImage.change(function (e) {
	e.preventDefault();
	var formData = new FormData();
	const image = $(this).get(0).files[0];
	formData.append('pro_image', image);

	url = SITE_URL + '/uploadImage';
	formUpload.hide();
	$.ajax({
		url: url,
		type: 'POST',
		data: formData,
		processData: false,
		contentType: false,
		cache: false,
		async: false,
		success: function (result) {
	// 		console.log(result)
			loadImage(result);
		}
	});
});


function loadImage(src) {
	// var html = '<label class="form-result col-md-6">';
	// html += '<button type="button" class="close-img" id="btn_delimg" aria-label="Close">';
	// html += '<span aria-hidden="true">&times;</span>';
	// html += '</button>';
	// html += '<img src="'+CUST_URL+'/assets/cust/images/'+src+'")';
	// html += '</label>';
	var html = '<img class="img1" src="' + CUST_URL + '/assets/cust/images/' + src + '"/>';
	$('.form-result').show()
	// $('.form-result').html(html);
	$('.form-result').append(html);
	// formUResult.html(html);
	formUpload.hide();
	Imgsrc = src;
	// checkRefresh(src)
	// delete1(Imgsrc)

}

function delete1(path) {
// btnDelImg.click(function (e) {
// // 		e.preventDefault();	
		// const pathImg = $('.img1').attr('src');
		// const pathImg = path;
		// alert('test')
		// console.log(pathImg)
// // 	// 	// formUpload.show()
// // 	// 	// formUResult.hide()
// });
}
// var formChanged = [];
// window.onbeforeunload = exitCheck;
function exitCheck() {
	// return "Any string value here forces a dialog box to \nappear before excuting the unload."
	// console.log(evt)
	confirm('test')
}
// proForm.addEventListener('change', () => formChanged = true);
// window.addEventListener('beforeunload', (event) => {
// 	// return exitCheck(event)
// 	event.returnValue = exitCheck();
// 	// return confirm('test')
// });
// 	// Cancel the event as stated by the standard.
// 	// event.preventDefault();
// 	// var imgt = event.returnValue = Imgsrc;
// 	// // // Chrome requires returnValue to be set.
// 	// // console.log(setSave);
// 	// // console.log($('.img1'));
// 	// // return formChanged = true;
// 	// // if (setSave === 'Add')
// 	// // 	console.info(true)
// 	// // else 
// 	// // 	console.info(false)
// 	// event.returnValue = 'You have unfinished changes!';
// 	// // formChanged = event.currentTarget;
// 	// console.log(event);
// 	// // if (performance.navigation.type.TYPE_RELOAD == 1)
// 	// // delete_data(16)
// 	// formChanged.push('1');
// 	if ($('#form_product').serialize() != $('#form_product').data('serialize')) return true;
// 	else event = null;

// 	// if (formChanged = true) {
// 		// }
// 		// console.log(event)
// 	});
	// console.log(performance.navigation.TYPE_RELOAD);
	// console.log(formChanged);
// console.log(formChanged)
// checkRefresh()
// function checkRefresh() {
	// delete1(Imgsrc)
	// performance.navigation.TYPE_RELOAD
	// if (performance.navigation.type == performance.navigation.TYPE_RELOAD) {
		// console.log(performance.navigation.type);
		// console.info(performance.navigation.TYPE_RELOAD);
		// console.info(performance.navigation.TYPE_NAVIGATE);
		// console.info(window);
		// if (currentTarget.performance.navigation.type == 1) {
		// 	alert("refresh button is clicked");
		// }
		// console.log("This page is reloaded");
		// alert('test')
	// 	confirm(performance.navigation.type + Imgsrc);
	// }
	// if (performance.navigation.type == performance.navigation.TYPE_NAVIGATE) {
	// 	console.info("This page is navigate");
	// 	// delete1(Imgsrc)
	// }
	// if (performance.navigation.type == performance.navigation.TYPE_RESERVED) {
	// 	console.info("This page is reserved");
	// 	// delete1(Imgsrc)
	// }
	// if (performance.navigation.type == performance.navigation.TYPE_BACK_FORWARD) {
	// 	console.info("This page is back forward");
	// 	// delete1(Imgsrc)
	// }
// }

modalForm.on("hidden.bs.modal", function () {
	delete1(Imgsrc)
});


function hoverImage() {
	fillPImage.mouseover(function () {
		$(this).attr('readonly', true);
		$(this).css({
			'background-color': 'white',
			'resize': 'none',
			'cursor': 'pointer'
		});
	});

	fillPImage.click(function () {
		modalUpload.modal('show')
	});
}

function product_details(productOptions, data) {
	if (!data == '')
		$.ajax({
			url: CUST_URL + PRODUCT + '/get_product/' + isActive,
			type: 'GET',
			dataType: 'JSON',
			success: function (result) {
				$.each(productOptions, function () {
					var value = this.value;
					var html = '<option value="">No Selected</option>';
					var i;
					for (i = 0; i < result.length; i++) {
						var p_id = result[i].m_product_id;
						var p_name = result[i].name;

						if (p_id == value) {
							html += '<option value="' + p_id + '" selected>' + p_name + '</option>';
						} else {
							html += '<option value="' + p_id + '">' + p_name + '</option>';
						}
						$(this).html(html)
					}
				})
			}
		})
	else
		$.ajax({
			url: CUST_URL + PRODUCT + '/get_product/' + isActive,
			type: 'GET',
			dataType: 'JSON',
			success: function (result) {
				console.log(result)
				$.each(productOptions, function () {
					if (this.value == '') {
						var html = '<option value="">No Selected</option>';
						for (i = 0; i < result.length; i++) {
							html += '<option value="' + result[i].m_product_id + '">' + result[i].name + '</option>';
						}
						$(this).html(html)
					}
				})
			}
		})
}

// btnSave.click(function () {
// 	const form = proForm.serialize() +
// 		'&isactive=' + active_pro();

// if (setSave === 'add')
// 	url = SITE_URL + CREATE;
// else
// 	url = SITE_URL + EDIT + ID;

// $.ajax({
// 	url: url,
// 	type: 'POST',
// 	data: form,
// 	dataType: 'JSON',
// 	success: function (result) {
// 		closeModalForm();
// 		refreshPro();
// 		console.log(result)
// 	}
// })
// console.log(form)
// 		if (result.success) {
// 			Toast.fire({
// 				type: 'success',
// 				title: result.message
// 			})
// 			$('#modal-users').modal('hide')
// 			loadUser()
// 			resetUser()
// 			$('#form_user')[0].reset()
// 		}
// 		if (result.error) {
// 			if (result.usr_value !== '') {
// 				$('#usr_value').addClass('is-invalid')
// 				$('.usr_value').addClass('text-danger').html(result.usr_value)
// 			} else {
// 				$('#usr_value').removeClass('is-invalid')
// 				$('.usr_value').removeClass('text-danger').html('')
// 			}
// 			if (result.usr_name !== '') {
// 				$('#usr_name').addClass('is-invalid')
// 				$('.usr_name').addClass('text-danger').html(result.usr_name)
// 			} else {
// 				$('#usr_name').removeClass('is-invalid')
// 				$('.usr_name').removeClass('text-danger').html('')
// 			}
// 			if (result.usr_email !== '') {
// 				$('#usr_email').addClass('is-invalid')
// 				$('.usr_email').addClass('text-danger').html(result.usr_email)
// 			} else {
// 				$('#usr_email').removeClass('is-invalid')
// 				$('.usr_email').removeClass('text-danger').html('')
// 			}
// 			if (result.usr_pass !== '') {
// 				$('#usr_pass').addClass('is-invalid')
// 				$('.usr_pass').addClass('text-danger').html(result.usr_pass)
// 			} else {
// 				$('#usr_pass').removeClass('is-invalid')
// 				$('.usr_pass').removeClass('text-danger').html('')
// 			}
// 			if (result.usr_passconf !== '') {
// 				$('#usr_passconf').addClass('is-invalid')
// 				$('.usr_passconf').addClass('text-danger').html(result.usr_passconf)
// 			} else {
// 				$('#usr_passconf').removeClass('is-invalid')
// 				$('.usr_passconf').removeClass('text-danger').html('')
// 			}
// 			if (result.usr_role !== '') {
// 				$('#usr_role').addClass('is-invalid')
// 				$('.usr_role').addClass('text-danger').html(result.usr_role)
// 			} else {
// 				$('#usr_role').removeClass('is-invalid')
// 				$('.usr_role').removeClass('text-danger').html('')
// 			}
// 		}
// 	},
// 	error: function (jqXHR, textStatus, errorThrown) {
// 		console.log(errorThrown)
// 	}
// })
// })

_tablePro.on('click', 'td:not(:last-child)', function (e) {
	e.preventDefault()
	const row = _tablePro.row(this).data();
	ID = row[0]; //index array
	url = SITE_URL + SHOW + ID;
	openModalForm();
	modalDialog.addClass('modal-dialog-scrollable modal-lg');
	modalTitle.html('Product' + ': ' + row[1]);
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
			// fillPQty.val(result.qtyonhand);
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
