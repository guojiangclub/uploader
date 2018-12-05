<?php

return [
	'disks' => [
		'qiniu' => [
			'driver'     => 'qiniu',
			//七牛云access_key
			'access_key' => env('QINIU_ACCESS_KEY', 'vLl-qCt035dy0CWylyjVzL7VTKqaIh7jZvly8ArZ'),
			//七牛云secret_key
			'secret_key' => env('QINIU_SECRET_KEY', 'vm0dd1qy78JHd23z3HP9C5L3i2oX2IDzIiPr90KB'),
			//七牛云 文件上传空间
			'bucket'     => env('QINIU_BUCKET', 'ibrand'),
			//七牛云 cdn域名
			'domain'     => env('QINIU_DOMAIN', 'https://cdn.ibrand.cc'),
			'url'        => env('QINIU_DOMAIN', 'https://cdn.ibrand.cc'),
		],
	],
	'image' => [
		//允许上传的文件类型
		'supportedExtensions' => ['png', 'jpg', 'jpeg', 'gif'],
		'supportedMimeTypes'  => ['image/jpeg', 'image/gif', 'image/png'],
		//单位：M
		'allowMaxSize'        => 2,
	],
	'voice' => [
		'supportedExtensions' => ['mp3', 'wav'],
		'supportedMimeTypes'  => ['audio/mpeg', 'audio/x-wav'],
		'allowMaxSize'        => 5,
	],
	'video' => [
		'supportedExtensions' => ['webm', 'mov', 'mp4'],
		'supportedMimeTypes'  => ['video/webm', 'video/mpeg', 'video/mp4', 'video/quicktime'],
		'allowMaxSize'        => 30,
	],
];