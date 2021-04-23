<?php

use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class Excel
{
	public function cellsByColsRow($start = -1, $end = -1, $row = -1, $action = null)
	{
		$colRow = '';
		if (strtolower($action) == 'merge') {
			if ($start >= 0 && $end >= 0 && $row >= 0) {
				$start = Coordinate::stringFromColumnIndex($start);
				$end = Coordinate::stringFromColumnIndex($end);
				$colRow = "$start{$row}:$end{$row}";
			}
		} else {
			if ($start >= 0 && $row >= 0) {
				$start = Coordinate::stringFromColumnIndex($start);
				$colRow = "$start{$row}";
			}
		}
		return $colRow;
	}
}
