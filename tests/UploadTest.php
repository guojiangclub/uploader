<?php

namespace iBrand\Upload\Test;

use iBrand\Upload\UploadFiles;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UploadTest extends BaseTest
{
	/** @test */
	public function TestConfig()
	{
		$config = config('filesystems.disks');

		$this->assertArrayHasKey('qiniu', $config);
	}

	/** @test */
	public function testUploadImage()
	{
		$client_id = 1;
		$response  = $this->post('cdn/upload', [
			'upload_file' => UploadedFile::fake()->image('no_head.jpg'),
			'client_id'   => $client_id,
		]);

		$res    = $response->getContent();
		$result = json_decode($res, true);
		$this->assertTrue($result['status']);
		$this->assertArrayHasKey('data', $result);
		$this->assertTrue(Storage::disk('qiniu')->has($result['data']['path']));

		$file = UploadFiles::where('client_id', $client_id)->where('path', $result['data']['path'])->first();
		$this->assertTrue(Storage::disk('qiniu')->has($file->path));
		$this->assertSame($result['data']['url'], $file->url);
	}

	/** @test */
	public function testUploadInvalidFileType()
	{

		$client_id = 1;
		$response  = $this->post('cdn/upload', [
			'upload_file' => '12123123',
			'client_id'   => $client_id,
		]);

		$res    = $response->getContent();
		$result = json_decode($res, true);
		$this->assertFalse($result['status']);

		$response = $this->post('cdn/upload', [
			'upload_file' => UploadedFile::fake()->create('document.pdf'),
			'client_id'   => $client_id,
		]);

		$res    = $response->getContent();
		$result = json_decode($res, true);
		$this->assertFalse($result['status']);

		$response = $this->post('cdn/upload', [
			'upload_file' => UploadedFile::fake()->create('test.bmp'),
			'client_id'   => $client_id,
		]);

		$res    = $response->getContent();
		$result = json_decode($res, true);
		$this->assertFalse($result['status']);

		config(['ibrand.uploader.image.supportedExtensions' => ['png']]);
		$response = $this->post('cdn/upload', [
			'upload_file' => UploadedFile::fake()->create('test.jpeg'),
			'client_id'   => $client_id,
		]);

		$res    = $response->getContent();
		$result = json_decode($res, true);
		$this->assertFalse($result['status']);
	}

	/** @test */
	public function testAllowUploadFileSize()
	{
		$client_id = 1;
		$response  = $this->post('cdn/upload', [
			'upload_file' => UploadedFile::fake()->image('test.jpg')->size(3),
			'client_id'   => $client_id,
		]);

		$res    = $response->getContent();
		$result = json_decode($res, true);
		$this->assertFalse($result['status']);
	}
}