<?php

namespace App\Exports;

use App\Models\File;
use App\Models\Salary;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SalaryExport implements FromCollection, ShouldAutoSize, WithHeadings, WithStyles
{
	private $month;

	public function __construct($month)
	{
		$this->month = $month;
	}

	/**
	 * @return \Illuminate\Support\Collection
	 */
	public function collection()
	{
		$exportData = [];
		$salaries = Salary::with([
			'user',
			'user.files' => function ($fileQuery) {
				return $fileQuery->where('status', File::STATUS_DONE);
			}
		])->whereMonth('month', $this->month)
			->orderBy('id', 'DESC')
			->get();

		// Format each salary record for the export
		foreach ($salaries as $salary) {
			$salary->txt_status = Salary::CONVERT_STATUS_TXT[$salary->status];
			$salaryTmp = "0";
			if ($salary->salary != 0) {
				$salaryTmp = $salary->salary;
			}
			$exportData[] = [
				$salary->id,
				$salary->user->name,
				$salary->user->email,
				count($salary->user->files),
				Salary::CONVERT_STATUS_TXT[$salary->status],
				$salaryTmp
			];
		}
		return collect($exportData);
	}

	public function headings(): array
	{
		return [
			'#',
			'Name',
			'Email',
			'Total file',
			'Status',
			'Salary'
		];
	}

	public function styles(Worksheet $sheet)
	{
		return [
			1 => [
				'font' => [
					'color' => ['rgb' => 'FFFFFF'],
				],
				'fill' => [
					'fillType' => Fill::FILL_SOLID,
					'startColor' => ['rgb' => '0000FF']
				]
			]
		];
	}

}
