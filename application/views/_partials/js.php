<!-- jQuery -->
<script src="<?php echo base_url('assets/plugins/jquery/jquery.min.js') ?>"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url('assets/plugins/jquery-ui/jquery-ui.min.js ') ?>"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
	$.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<!-- daterangepicker -->
<script src="<?php echo base_url('assets/plugins/moment/moment.min.js') ?>"></script>
<script src="<?php echo base_url('assets/plugins/daterangepicker/daterangepicker.js') ?>"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo base_url('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') ?>"></script>
<!-- overlayScrollbars -->
<script src="<?php echo base_url('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') ?>"></script>
<!-- Select2 -->
<script src="<?php echo base_url('assets/plugins/select2/js/select2.full.min.js') ?>"></script>
<!-- bs-custom-file-input -->
<script src="<?php echo base_url('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') ?>"></script>
<!-- SweetAlert2 -->
<script src="<?php echo base_url('assets/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('assets/dist/js/adminlte.js') ?>"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url('assets/dist/js/demo.js') ?>"></script>
<!-- fullCalendar 2.2.5 -->
<script src="<?php echo base_url('assets/plugins/moment/moment.min.js') ?>"></script>
<script src="<?php echo base_url('assets/plugins/fullcalendar/main.min.js') ?>"></script>
<script src="<?php echo base_url('assets/plugins/fullcalendar-daygrid/main.min.js') ?>"></script>
<script src="<?php echo base_url('assets/plugins/fullcalendar-timegrid/main.min.js') ?>"></script>
<script src="<?php echo base_url('assets/plugins/fullcalendar-interaction/main.min.js') ?>"></script>
<script src="<?php echo base_url('assets/plugins/fullcalendar-bootstrap/main.min.js') ?>"></script>
<!-- DataTables -->
<script src="<?php echo base_url('assets/plugins/datatables/jquery.dataTables.js') ?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.js') ?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables-fixedcolumns/js/dataTables.fixedColumns.min.js') ?>"></script>
<!-- bootstrap-datepicker -->
<!-- <script src="<?php //echo base_url('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') 
					?>"></script> -->
<!-- Bootstrap Toggle -->
<!-- <script src="<?php //echo base_url('assets/plugins/bootstrap4-toggle/js/bootstrap4-toggle.min.js') 
					?>"></script> -->
<!-- AutoNumeric Rupiah -->
<script src="<?php echo base_url('/assets/plugins/auto-numeric/autoNumeric.js') ?>"></script>
<!-- Scanner Auto Focus -->
<script src="<?php echo base_url('assets/plugins/jquery-scanner/jquery.scannerdetection.js') ?>"></script>
<!-- Loader WaitMe -->
<script src="<?= base_url('assets/plugins/loader/waitMe.min.js') ?>"></script>
<!-- date-range-picker -->
<script src="<?= base_url('assets/plugins/daterangepicker/daterangepicker.js') ?>"></script>
<!-- JS -->
<script src="<?php echo base_url('assets/cust/js/Variables.js')  ?>"></script>
<script src="<?php echo base_url('assets/cust/js/Process.js')  ?>"></script>
<script src="<?php echo base_url('assets/cust/js/Tables.js')  ?>"></script>
<script src="<?php echo base_url('assets/cust/js/Auth.js')  ?>"></script>
<script src="<?php echo base_url('assets/cust/js/Product.min.js')  ?>"></script>
<script src="<?php echo base_url('assets/cust/js/Category-js.js')  ?>"></script>
<script src="<?php echo base_url('assets/cust/js/Job-js.js')  ?>"></script>
<script src="<?php echo base_url('assets/cust/js/Greeting-js.js')  ?>"></script>
<script src="<?php echo base_url('assets/cust/js/Uom-js.js')  ?>"></script>
<script src="<?php echo base_url('assets/cust/js/Customer.min.js')  ?>"></script>
<script src="<?php echo base_url('assets/cust/js/Supplier-js.js')  ?>"></script>
<script src="<?php echo base_url('assets/cust/js/Destination-js.js')  ?>"></script>
<script src="<?php echo base_url('assets/cust/js/Courier-js.js')  ?>"></script>
<script src="<?php echo base_url('assets/cust/js/Account-js.js')  ?>"></script>
<script src="<?php echo base_url('assets/cust/js/User.min.js')  ?>"></script>
<script src="<?php echo base_url('assets/cust/js/Sales.js')  ?>"></script>
<script src="<?php echo base_url('assets/cust/js/Expense.js')  ?>"></script>
<script src="<?php echo base_url('assets/cust/js/Brand-js.js')  ?>"></script>
<script src="<?php echo base_url('assets/cust/js/Rma.js')  ?>"></script>

<script src="https://cdn.jsdelivr.net/npm/recta/dist/recta.js"></script>
<script>
	$('#ins_date').daterangepicker({
		locale: {
			format: 'DD-MM-YYYY'
		}
	});
</script>
<script>
	$('#keu_date').daterangepicker({
		locale: {
			format: 'DD-MM-YYYY'
		}
	});
</script>
<script>
	var printer = new Recta('1188118811', '1811')

	// 4 space break
	let spaceBreak = "   ";

	function printStruk(prder_id) {
		$.ajax({
			url: '<?= base_url('sales/cetak') ?>',
			type: 'POST',
			data: {
				id: prder_id
			},
			cache: false,
			dataType: 'JSON',
			success: function(result) {
				printer.open().then(function(e) {
					printer.align('center')
						.text('JS BOUTIQUESHOP ONLINE')
						.text('ITC MANGGA DUA LT. 2 BLOK A NO. 124-125')
						.text('JAKARTA UTARA\n')
						.text(spaceBreak + '---------------------------------------------');

					printer.align('left')
						// .text(spaceBreak + 'Date: ' + result.date + '	' + 'Time: ' + result.time)
						.text(spaceBreak + 'Date: ' + result.date)
						.text(spaceBreak + 'Invoice No: ' + result.invoice);
					if (result.cashier !== null) {
						printer.text(spaceBreak + 'Cashier: ' + result.cashier);
					} else {
						printer.text(spaceBreak + 'Cashier: ' + '-');
					}
					printer.text(spaceBreak + 'SPG: ' + result.salesname + '\n')
						.text(spaceBreak + 'Customer: ' + result.bpartner);

					printer.text(spaceBreak + '---------------------------------------------');

					$.each(result.detail1, function(idx, elem) {
						printer.text(spaceBreak + elem);
					});

					printer.text(spaceBreak + '---------------------------------------------')
						.text(spaceBreak + result.subtotal[0] + '\n');

					printer.align('center')
						.text('Follow IG @jsboutiqueshop')
						.text('Merchandise cannot be exchanged or refund')
						.text('Thank you for shopping\n')
						.text('Printed: ' + result.printed)
						.feed(6)
						.cut()
						.print();
				})

				// printer.on('open', function(result) {
				// 	alert(result)
				// }).on('error', function(error) {
				// 	alert(error)
				// })
			}
		});
	}

	$('#btn_print').click(function(evt) {
		let order_id = $(this).val();
		printStruk(order_id);
	})
</script>
