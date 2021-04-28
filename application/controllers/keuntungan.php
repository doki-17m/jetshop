<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Insentif extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('excel');
		$this->load->model('m_user');
		$this->load->model('m_order');
	}

	public function index()
	{
		$startDate = date('d-m-Y', strtotime('- 1 days'));
		$endDate = date('d-m-Y');
		//test
		$data['date_range'] = $startDate . ' - ' . $endDate;
		$this->template->load('overview', 'keuntungan/v_keuntungan', $data);
	}

	public function export()
	{
		$post = $this->input->post(NULL, TRUE);
		$dateExplode = explode(' - ', $post['ins_date']);
		$dateRange = $this->getDatesFromRange($dateExplode[0], $dateExplode[1]);

		// $user = $this->m_user->listSales('Y');
		// $listSales = $user->result();

        $invoice = $this->m_order->detail();
        $detail = $invoice->result();

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setTitle('Keuntungan');

		// $sheet->getColumnDimension('A')->setWidth(12);
		// $sheet->setCellValue('A1:A2')->setCellValue('A1', 'TANGGAL');
		// $sheet->getStyle('A1:A2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('808080');
		// $sheet->getStyle('A1:A2')->getFont()->setBold(true);
		// $sheet->getStyle('A1:A2')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		// $sheet->getStyle('A1:A2')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		// $sheet->getStyle('A1:A2')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		// $sheet->getStyle('A1:A2')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		// $sheet->getStyle('A1:A2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

		// $countUser = $user->num_rows();
		$startCol = 2;
		$endCol = $startCol;

		$col_1 = [];
		$col_2 = [];
		$arrCol = [];

		//even column
		for ($i = $startCol; $i <= $endCol; $i++) {
			if ($i % 2 == 0) {
				$col_1[] = $i;
			}
		}

		//odd column
		for ($j = $startCol + 1; $j <= $endCol + 2; $j++) {
			if ($j % 2 == 1) {
				$col_2[] = $j;
			}
		}

		//merge column odd and even column
		foreach ($col_1 as $key => $val) :
			$arrCol[] = array_merge(
				(array) $col_1[$key],
				(array) $col_2[$key]
			);
		endforeach;

		foreach ($arrCol as $index => $value) :
			$sales = $listSales[$index];
			$rangeStart = $value[0];
			$rangeEnd = $value[1];

			$row = 1;
			$range = $this->excel->cellsByColsRow($rangeStart, $rangeEnd, $row, 'merge');
			$firstCol = $this->excel->cellsByColsRow($rangeStart, 0, $row);

			/** 
			 * Merge cell header
			 * */
			// $sheet->mergeCells($range)->setCellValue($firstCol, strtoupper($sales->name));
			// $sheet->getStyle($range)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('808080');
			// $sheet->getStyle($range)->getFont()->setBold(true);
			// $sheet->getStyle($range)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			// $sheet->getStyle($range)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			// $sheet->getStyle($range)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			// $sheet->getStyle($range)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			// $sheet->getStyle($range)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            //Nomor Invoice
            $sheet->setCellValue($firstCol, strtoupper('Nomor Invoice'));
			$sheet->getStyle($range)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('808080');
			$sheet->getStyle($range)->getFont()->setBold(true);
			$sheet->getStyle($range)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle($range)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle($range)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle($range)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle($range)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            //Kode Product
            $sheet->setCellValue($firstCol, strtoupper('Kode Product'));
			$sheet->getStyle($range)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('808080');
			$sheet->getStyle($range)->getFont()->setBold(true);
			$sheet->getStyle($range)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle($range)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle($range)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle($range)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle($range)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            //Sales
            $sheet->setCellValue($firstCol, strtoupper('Sales'));
			$sheet->getStyle($range)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('808080');
			$sheet->getStyle($range)->getFont()->setBold(true);
			$sheet->getStyle($range)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle($range)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle($range)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle($range)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle($range)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            //Harga Modal
            $sheet->setCellValue($firstCol, strtoupper('Harga Modal'));
			$sheet->getStyle($range)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('808080');
			$sheet->getStyle($range)->getFont()->setBold(true);
			$sheet->getStyle($range)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle($range)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle($range)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle($range)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle($range)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

			//Harga Jual
            $sheet->setCellValue($firstCol, strtoupper('Harga Jual'));
			$sheet->getStyle($range)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('808080');
			$sheet->getStyle($range)->getFont()->setBold(true);
			$sheet->getStyle($range)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle($range)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle($range)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle($range)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle($range)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

			//pcs
            $sheet->setCellValue($firstCol, strtoupper('Pcs'));
			$sheet->getStyle($range)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('808080');
			$sheet->getStyle($range)->getFont()->setBold(true);
			$sheet->getStyle($range)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle($range)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle($range)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle($range)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle($range)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

			//Keuntungan
            $sheet->setCellValue($firstCol, strtoupper('Keuntungan'));
			$sheet->getStyle($range)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('808080');
			$sheet->getStyle($range)->getFont()->setBold(true);
			$sheet->getStyle($range)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle($range)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle($range)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle($range)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle($range)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

			//Rekening
            $sheet->setCellValue($firstCol, strtoupper('Rekening'));
			$sheet->getStyle($range)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('808080');
			$sheet->getStyle($range)->getFont()->setBold(true);
			$sheet->getStyle($range)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle($range)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle($range)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle($range)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			$sheet->getStyle($range)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			// $row = 2;
			//Obral
			// $range = $this->excel->cellsByColsRow($rangeStart, 0, $row);
			// $sheet->setCellValue($range, 'L');
			// $sheet->getStyle($range)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('808080');
			// $sheet->getStyle($range)->getFont()->setBold(true);
			// $sheet->getStyle($range)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			// $sheet->getStyle($range)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			// $sheet->getStyle($range)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			// $sheet->getStyle($range)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			// $sheet->getStyle($range)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

			//Non obral
			// $range = $this->excel->cellsByColsRow($rangeEnd, 0, $row);
			// $sheet->setCellValue($range, 'D');
			// $sheet->getStyle($range)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('808080');
			// $sheet->getStyle($range)->getFont()->setBold(true);
			// $sheet->getStyle($range)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			// $sheet->getStyle($range)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			// $sheet->getStyle($range)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			// $sheet->getStyle($range)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			// $sheet->getStyle($range)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

			/**
			 * Data excel
			 */
			// $row = 3;
			// $cell = 1;
			// foreach ($dateRange as $date) :
			// 	$sheet->setCellValueByColumnAndRow($cell, $row, date('d-M-y', strtotime($date)));

			// 	$range = 'A' . $sheet->getHighestRow() . ':' . 'A' . $sheet->getHighestRow();

			// 	$sheet->getStyle($range)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			// 	$sheet->getStyle($range)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			// 	$sheet->getStyle($range)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
			// 	$sheet->getStyle($range)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

				// Data Obral
				// $range = $this->excel->cellsByColsRow($rangeStart, 0, $row);
				// $sale = $this->m_order->getInsentif($sales->sys_user_id, 'Y', $date);
				// if ($sale->num_rows() > 0) {
				// 	foreach ($sale->result() as $key) :
				// 		$sheet->setCellValue($range, $key->item_product);
				// 		$sheet->getStyle($range)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
				// 		$sheet->getStyle($range)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
				// 		$sheet->getStyle($range)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
				// 		$sheet->getStyle($range)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
				// 	endforeach;
				// } else {
				// 	$sheet->setCellValue($range, 0);
				// 	$sheet->getStyle($range)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
				// 	$sheet->getStyle($range)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
				// 	$sheet->getStyle($range)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
				// 	$sheet->getStyle($range)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
				// }

				// Data non obral
	// 			$range = $this->excel->cellsByColsRow($rangeEnd, 0, $row);
	// 			$nonSale = $this->m_order->getInsentif($sales->sys_user_id, 'N', $date);
	// 			if ($nonSale->num_rows() > 0) {
	// 				foreach ($nonSale->result() as $key) :
	// 					$sheet->setCellValue($range, $key->item_product);
	// 					$sheet->getStyle($range)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
	// 					$sheet->getStyle($range)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
	// 					$sheet->getStyle($range)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
	// 					$sheet->getStyle($range)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
	// 				endforeach;
	// 			} else {
	// 				$sheet->setCellValue($range, 0);
	// 				$sheet->getStyle($range)->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
	// 				$sheet->getStyle($range)->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
	// 				$sheet->getStyle($range)->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
	// 				$sheet->getStyle($range)->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
	// 			}

	// 			$row++;

	// 		endforeach;

	// 	endforeach;

	// 	$writer = new Xlsx($spreadsheet);

	// 	$filename = 'Report Insentif' . '_' . $post['ins_date'] . '.xlsx'; //save our workbook as this file name
	// 	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	// 	header('Content-Disposition: attachment;filename="' . $filename . '"');
	// 	header('Cache-Control: max-age=0');
	// 	$writer->save('php://output');
	// }

	// function getDatesFromRange($start, $end, $format = 'Y-m-d')
	// {
	// 	$array = [];

		// Variable that store the date interval
		// of period 1 day
		// $interval = new DateInterval('P1D');

		// $realEnd = new DateTime($end);
		// $realEnd->add($interval);

		// $period = new DatePeriod(new DateTime($start), $interval, $realEnd);

		// // Use loop to store date into array
		// foreach ($period as $date) :
		// 	$array[] = $date->format($format);
		// endforeach;

		return $array;
	}
}
