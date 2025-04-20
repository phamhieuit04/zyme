<?php

namespace App\Console\Commands;

use App\Models\File;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Salary extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'app:salary';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command tính lương, sẽ được server chạy định kỳ hàng ngày, vào lúc 0 giờ đêm';

	/**
	 * Execute the console command.
	 */
	public function handle()
	{
		// Tính lương của nhân viên theo tháng
		$timeNow = Carbon::now();
		$editors = User::with(relations: [
			'files' => function ($fileQuery) use ($timeNow) {
				return $fileQuery->whereMonth('created_at', $timeNow)
					->where('status', File::STATUS_DONE);
			},
			'salary' => function ($salaryQuery) use ($timeNow) {
				return $salaryQuery->whereMonth('month', $timeNow)->get();
			}
		])->get();
		$salarys = [];
		foreach ($editors as $editor) {
			$tempSalary = count($editor->files) * \App\Models\Salary::BASE_SALARY;
			if (count($editor->salary) > 0) {
				DB::table('salary')->where('id', $editor->salary[0]->id)
					->update([
						'salary' => $tempSalary
					]);
			} else {
				$salarys[] = [
					'user_id' => $editor->id,
					'status' => \App\Models\Salary::STATUS_UN_PAID,
					'salary' => $tempSalary,
					'month' => $timeNow,
					'created_at' => $timeNow,
					'updated_at' => $timeNow
				];
			}
		}
		DB::table('salary')->insert($salarys);
		echo "Update salary thanh cong!";
		return true;
	}
}
