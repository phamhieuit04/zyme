<?php

namespace App\Http\Controllers;

use App\Exports\SalaryExport;
use App\Models\File;
use App\Models\Salary;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class StatisticController extends Controller
{
	public function index(Request $request)
	{
		$params = $request->all();
		$timeNow = Carbon::now();

		$salaries = Salary::with(
			[
				'user',
				'user.files' => function ($fileQuery) {
					return $fileQuery->where('status', File::STATUS_DONE);
				}
			]
		)
			->where(function ($query) use ($params, $timeNow) {
				// Return current month's salary
				if (!isset($params['date'])) {
					return $query->whereMonth('month', $timeNow);
				}
				$selectedMonth = Carbon::create($params['date']);
				return $query->whereMonth('month', $selectedMonth);
			})
			->orderBy('id', 'DESC')
			->get();
		foreach ($salaries as $salary) {
			$salary->txt_status = Salary::CONVERT_STATUS_TXT[$salary->status];
		}

		return view('admin.statistic.index', compact('salaries'));
	}

	public function paidSalary($salaryId)
	{
		$salary = Salary::find($salaryId);
		$salary->status = Salary::STATUS_PAID;
		$salary->save();
		return redirect()->back();
	}

	public function export()
	{
		$timeNow = Carbon::now();
		return Excel::download(new SalaryExport($timeNow), 'export.xlsx');
	}
}
