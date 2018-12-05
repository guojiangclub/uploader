<?php

namespace iBrand\Upload;

use Illuminate\Database\Eloquent\Model;

class UploadFiles extends Model
{
	public $guarded = ['id'];

	public function __construct(array $attributes = [])
	{
		parent::__construct($attributes);

		$prefix = config('ibrand.app.database.prefix', 'ibrand_');

		$this->setTable($prefix . 'cdn_files');
	}
}