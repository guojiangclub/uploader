<?php

namespace iBrand\Upload\Test;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Orchestra\Testbench\TestCase;

abstract class BaseTest extends TestCase
{
	use DatabaseMigrations;

	/**
	 * set up test.
	 */
	protected function setUp()
	{
		parent::setUp();

		$this->loadMigrationsFrom(__DIR__ . '../migrations');
	}

	/**
	 * @param \Illuminate\Foundation\Application $app
	 */
	protected function getEnvironmentSetUp($app)
	{
		$app['config']->set('database.default', 'testing');
		$app['config']->set('database.connections.testing', [
			'driver'   => 'sqlite',
			'database' => ':memory:',
		]);

		$app['config']->set('ibrand.uploader', require __DIR__ . '/../config/config.php');
		$app['config']->set('filesystems.disks', array_merge($app['config']->get('ibrand.uploader.disks'), $app['config']->get('filesystems.disks')));
	}

	/**
	 * @param \Illuminate\Foundation\Application $app
	 *
	 * @return array
	 */
	protected function getPackageProviders($app)
	{
		return [
			\Orchestra\Database\ConsoleServiceProvider::class,
			\iBrand\Upload\UploadServiceProvider::class,
			\Overtrue\LaravelFilesystem\Qiniu\QiniuStorageServiceProvider::class
		];
	}
}