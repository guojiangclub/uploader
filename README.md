# cdn文件上传-七牛云

## 特性

1. 支持上传图片，音频，视频
2. 自定义允许上传文件类型
3. 使用简单、即插即用

## 安装
```
composer require ibrand/uploader
```
- 低于 Laravel5.5 版本，`config/app.php` 文件中 `providers` 添加`iBrand\Upload\UploadServiceProvider::class`

- 如需自定义配置请执行 `php artisan vendor:publish --provider="iBrand\Upload\UploadServiceProvider" --tag="config"`

### 配置项

``` 
   return [
	'disks' => [
		'qiniu' => [
			'driver'     => 'qiniu',
			//七牛云access_key
			'access_key' => env('QINIU_ACCESS_KEY', ''),
			//七牛云secret_key
			'secret_key' => env('QINIU_SECRET_KEY', ''),
			//七牛云文件上传空间
			'bucket'     => env('QINIU_BUCKET', ''),
			//七牛云cdn域名
			'domain'     => env('QINIU_DOMAIN', ''),
			//与cdn域名保持一致
			'url'        => env('QINIU_DOMAIN', ''),
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
```

## 使用

在.env文件中配置QINIU_ACCESS_KEY，QINIU_SECRET_KEY，QINIU_BUCKET，QINIU_DOMAIN等配置项。

### 定义路由

```php
$router->post('cdn/upload', 'UploadController@upload');
```


### 返回结果示例
```
    [
  "status" => true
  "message" => "上传成功"
  "data" => array:2 [
    "path" => "client_id/date/xxxxxx.jpg"
    "url" => "https://cdn.xxxxx.cc/client_id/date/xxxxxx.jpg"
  ]
]
```

具体使用请参照单元测试

## Resource

项目基于[overtrue/laravel-filesystem-qiniu](https://github.com/overtrue/laravel-filesystem-qiniu)

## 贡献源码

如果你发现任何错误或者问题，请[提交ISSUE](https://github.com/ibrandcc/uploader/issues)
