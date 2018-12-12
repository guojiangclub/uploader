<?php

namespace iBrand\Upload;

use iBrand\Upload\Checkers\PublicChecker;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
	public function upload(Request $request)
	{
		$client_id = $request->input('client_id');

		try {
			if (!$request->hasFile('upload_file') || !$request->file('upload_file')->isValid()) {
				throw  new \Exception('请上传文件');
			}

			$file     = $request->file('upload_file');
			$mineType = $file->getMimeType();
			$mines    = explode('/', $mineType);
			$alias    = 'upload_' . $mines[0];
			if (!app()->isAlias($alias)) {
				throw  new \Exception('不允许上传的文件类型');
			}

			$checker = app($alias);
			if (!$checker instanceof PublicChecker || !$checker->canHandleMime($mineType)) {
				throw  new \Exception('不允许上传的文件类型');
			}

			$ext = $file->getClientOriginalExtension();
			if (!$checker->canHandleExtension($ext)) {
				throw  new \Exception('只允许上传：' . $checker->supportedExtensions()->implode(',') . ' 类型的文件');
			}

			if (!$checker->allowMaxFileSize($file)) {
				throw  new \Exception('上传文件不能超过：' . config('ibrand.uploader.' . $alias . '.allowMaxSize') . 'M');
			}

			$uniqueName = $this->generateUniqueName($file);
			$path       = $file->storeAs(
				$client_id . '/' . date('Y-m-d'), $uniqueName, 'qiniu'
			);

			if (!Storage::disk('qiniu')->has($path)) {
				throw  new \Exception('文件上传失败');
			}

			UploadFiles::create([
				'client_id' => $client_id,
				'path'      => $path,
				'url'       => Storage::disk('qiniu')->url($path),
			]);

			return response()->json(['status' => true, 'message' => '上传成功', 'data' => ['path' => $path, 'url' => Storage::disk('qiniu')->url($path)]]);
		} catch (\Exception $exception) {

			return response()->json(['status' => false, 'message' => $exception->getMessage()]);
		}
	}

	public function generateUniqueName(UploadedFile $file)
	{
		return md5(uniqid()) . '.' . $file->getClientOriginalExtension();
	}
}