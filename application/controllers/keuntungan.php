<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Keuntungan extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('excel');
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
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setTitle('Keuntungan');

		$post = $this->input->post(NULL, TRUE);
		$dateExplode = explode(' - ', $post['keu_date']);
		$startDate = date('Y-m-d', strtotime($dateExplode[0]));
		$endDate = date('Y-m-d', strtotime($dateExplode[1]));
		
		$invoice = $this->m_order->getKeuntungan($startDate, $endDate)->result();

		//Nomor Invoice
		$sheet->getColumnDimension('A')->setWidth(12);
		$sheet->setCellValue('A1', 'Nomor Invoice');

		//Kode Product
		$sheet->getColumnDimension('B')->setWidth(12);
		$sheet->setCellValue('B1', 'Kode Product');

		//Sales
		$sheet->getColumnDimension('C')->setWidth(12);
		$sheet->setCellValue('C1', 'Sales');

		//Harga Modal
		$sheet->getColumnDimension('D')->setWidth(12);
		$sheet->setCellValue('D1', 'Harga Modal');

		//Harga Jual
		$sheet->getColumnDimension('E')->setWidth(12);
		$sheet->setCellValue('E1', 'Harga Jual');

		//pcs
		$sheet->getColumnDimension('F')->setWidth(12);
		$sheet->setCellValue('F1', 'Pcs');

		//Keuntungan
		$sheet->getColumnDimension('G')->setWidth(12);
		$sheet->setCellValue('G1', 'Keuntungan');

		//Rekening
		$sheet->getColumnDimension('H')->setWidth(12);
		$sheet->setCellValue('H1', 'Rekening');
		$sheet->getStyle('A1:H1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('808080');
		$sheet->getStyle('A1:H1')->getFont()->setBold(true);
		$sheet->getStyle('A1:H1')->getBorders()->getTop()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		$sheet->getStyle('A1:H1')->getBorders()->getBottom()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		$sheet->getStyle('A1:H1')->getBorders()->getLeft()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
		$sheet->getStyle('A1:H1')->getBorders()->getRight()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

		$sheet->getStyle('A1:H1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

		/**
		 * Data excel
		 */

		$row = 2;
		$cell = 1;
		//Nomor Inoice
		foreach ($invoice as $value) {
			$sheet->setCellValue('A' . $row, $value->documentno)
			->setCellValue('B' . $row, $value->product)
			->setCellValue('C' . $row, $value->nama_sales)
			->setCellValue('D' . $row, $value->costprice)
			->setCellValue('E' . $row, $value->unitprice)
			->setCellValue('F' . $row, $value->qtyordered)
			->setCellValue('G' . $row, $value->keuntungan)
			->setCellValue('H' . $row, $value->payment);
			$row++;

		}

		$writer = new Xlsx($spreadsheet);

		$filename = 'Report Keuntungan' . '_' . $post['keu_date'] . '.xlsx'; //save our workbook as this file name
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}
}