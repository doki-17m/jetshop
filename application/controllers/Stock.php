<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Stock extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('excel');
		$this->load->model('m_transaction');
	}

	public function index()
	{
		$startDate = date('d-m-Y', strtotime('- 1 days'));
		$endDate = date('d-m-Y');
		//test
		$data['date_range'] = $startDate . ' - ' . $endDate;
		$this->template->load('overview', 'stock/v_stock', $data);
	}

	public function export()
	{
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setTitle('Stock');

		$post = $this->input->post(NULL, TRUE);
		$dateExplode = explode(' - ', $post['stock_date']);
		$startDate = date('Y-m-d', strtotime($dateExplode[0]));
		$endDate = date('Y-m-d', strtotime($dateExplode[1]));
		
		$stock = $this->m_transaction->getStock($startDate, $endDate)->result();

		//Nomor
		$sheet->getColumnDimension('A')->setWidth(12);
		$sheet->setCellValue('A1', 'No');

		//Brand
		$sheet->getColumnDimension('B')->setWidth(12);
		$sheet->setCellValue('B1', 'Brand');

		//Kode Product
		$sheet->getColumnDimension('C')->setWidth(12);
		$sheet->setCellValue('C1', 'Kode Product');

		//Nomor Adjust
		$sheet->getColumnDimension('D')->setWidth(12);
		$sheet->setCellValue('D1', 'Nomor Adjust');

        //Nomor Invoice
        $sheet->getColumnDimension('E')->setWidth(12);
		$sheet->setCellValue('E1', 'Nomor Invoice');

		//Qty In Out
		$sheet->getColumnDimension('F')->setWidth(12);
		$sheet->setCellValue('F1', 'Qty In Out');

		//Tanggal Transaksi
		$sheet->getColumnDimension('G')->setWidth(12);
		$sheet->setCellValue('G1', 'Tanggal Transaksi');

		//Stock Akhir
		// $sheet->getColumnDimension('H')->setWidth(12);
		// $sheet->setCellValue('H1', 'Stok Akhir');
        // $sheet->getStyle('A1:H1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('808080');
		// $sheet->getStyle('A1:H1')->getFont()->setBold(true);
		// $sheet->getStyle('A1:H1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		// $sheet->getStyle('A1:H1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		// $sheet->getStyle('A1:H1')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		// $sheet->getStyle('A1:H1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		// $sheet->getStyle('A1:H1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

		/**
		 * Data excel
		 */

		$row = 2;
		$cell = 1;
		$number = 1;
		//Nomor Inoice
		foreach ($stock as $value) {
			$sheet->setCellValue('A' . $row, $number)
			->setCellValue('B' . $row, $value->brand_product)
			->setCellValue('C' . $row, $value->kode_product)
			->setCellValue('D' . $row, $value->nomor_mio)
			->setCellValue('E' . $row, $value->nomor_invoice)
			->setCellValue('F' . $row, $value->movementqty)
            ->setCellValue('G' . $row, $value->tanggal_pindah);
			// ->setCellValue('H' . $row, $value->stock_akhir);

			$row++;
			$number++;
		}

		$writer = new Xlsx($spreadsheet);

		$filename = 'Report Stock' . '_' . $post['stock_date'] . '.xlsx'; //save our workbook as this file name
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}
}