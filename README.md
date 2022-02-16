### cdn文件上传-七牛云

#### 特性

1. 支持上传图片，音频，视频
2. 自定义允许上传文件类型
3. 使用简单、即插即用

#### 安装
```
composer require ibrand/uploader
```
- 低于 Laravel5.5 版本，`config/app.php` 文件中 `providers` 添加`iBrand\Upload\UploadServiceProvider::class`

- 如需自定义配置请执行 `php artisan vendor:publish --provider="iBrand\Upload\UploadServiceProvider" --tag="config"`

#### 配置项

``` 
   return [
       'default'      => [
           'disk' => env('DEFAULT_UPLOAD_DISK', 'public'),
       ],
       'disks'        => [
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
       'upload_image' => [
           //允许上传的文件类型
           'supportedExtensions' => ['png', 'jpg', 'jpeg', 'gif'],
           'supportedMimeTypes'  => ['image/jpeg', 'image/gif', 'image/png'],
           //单位：M
           'allowMaxSize'        => 2,
       ],
       'upload_voice' => [
           'supportedExtensions' => ['mp3', 'wav'],
           'supportedMimeTypes'  => ['audio/mpeg', 'audio/x-wav'],
           'allowMaxSize'        => 5,
       ],
       'upload_video' => [
           'supportedExtensions' => ['webm', 'mov', 'mp4'],
           'supportedMimeTypes'  => ['video/webm', 'video/mpeg', 'video/mp4', 'video/quicktime'],
           'allowMaxSize'        => 30,
       ],
   ];
```

#### 使用

在.env文件中配置QINIU_ACCESS_KEY，QINIU_SECRET_KEY，QINIU_BUCKET，QINIU_DOMAIN等配置项。

有两种方式上传文件至七牛云以供选择：

1. 请求接口：

   ```
   $router->post('cdn/upload', 'UploadController@upload');
   返回结果：
   {
       "status": true,
       "message": "上传成功",
       "data": {
           "path": "client_id/date/xxxxxx.jpg",
           "url": "https://cdn.xxxxx.cc/client_id/date/xxxxxx.jpg"
       }
   }
   ```

   具体使用请参照单元测试

2. 调用Storage 

   ```
   use Storage
   Storage::disk('qiniu')->put($filename, $file);
   ```

#### Resource

项目基于[overtrue/laravel-filesystem-qiniu](https://github.com/overtrue/laravel-filesystem-qiniu)

#### 果酱云社区

<p align="center">
  <a href="https://guojiang.club/" target="_blank">
    <img src="https://cdn.guojiang.club/image/2022/02/16/wu_1fs0jbco2182g280l1vagm7be6.png" alt="点击跳转"/>
  </a>
</p>



- 全网真正免费的IT课程平台

- 专注于综合IT技术的在线课程，致力于打造优质、高效的IT在线教育平台

- 课程方向包含Python、Java、前端、大数据、数据分析、人工智能等热门IT课程

- 300+免费课程任你选择



<p align="center">
  <a href="https://guojiang.club/" target="_blank">
    <img src="https://cdn.guojiang.club/image/2022/02/16/wu_1fs0l82ae1pq11e431j6n17js1vq76.png" alt="点击跳转"/>
  </a>
</p>