<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class EditorController extends Controller
{
	public function index(Request $request)
	{
		$params = $request->all();
		$files = File::where('user_id', Auth::user()->id)
			->where(function ($fileQuery) use ($params) {
				if (isset($params['month']) && !is_null($params['month'])) {
					return $fileQuery->whereMonth('created_at', Carbon::create($params['month']));
				} else {
					return $fileQuery->whereMonth('created_at', Carbon::now());
				}
			})
			->paginate(config('const.paginate'));
		foreach ($files as $file) {
			$file->priority = File::CONVERT_PRIORITY_TXT[$file->priority];
		}
		return view('editors.index', compact('files'));
	}

	public function update(Request $request, string $id)
	{
		$param = $request->all();
		$file = File::find($id);
		if (isset($param['file']) && !is_null($param['file'])) {
			$fileName = $file->filename;
			$lastDot = strrpos($file->filename, '.');
			if ($lastDot !== false) {
				$name = substr($file->filename, 0, $lastDot);
				$extension = substr($file->filename, $lastDot + 1);
			} else {
				$name = $file->filename;
				$extension = '';
			}
			$fileName = $name . '_done' . ($extension ? '.' . $extension : '');
			$directory = explode('@', Auth::user()->email)[0];
			$path = public_path('uploads/' . $directory . '/' . $fileName);
			$fileUpload = $request->file('file');
			move_uploaded_file($fileUpload, $path);

			return redirect()->back();
		}
		$file->status = File::CONVERT_PRIORITY_TXT();
		$file->save();

		return redirect()->back();
	}

	public function download(Request $request, string $id)
	{
		$folder = explode('@', Auth::user()->email)[0];
		$file = File::find($id);
		if (!$file) {
			return [
				'code' => '404',
				'message' => 'File not found'
			];
		}
		$path = public_path('uploads/' . $folder . '/' . $file->filename);
		if (!file_exists($path)) {
			return [
				'code' => '404',
				'message' => 'File not found'
			];
		}
		return response()->download($path);
	}
}
