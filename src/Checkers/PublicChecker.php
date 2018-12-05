<?php

namespace iBrand\Upload\Checkers;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Support\Collection;

abstract class PublicChecker implements BaseChecker
{
	const TYPE = '';

	public function canHandleMime(string $mime = ''): bool
	{
		return $this->supportedMimeTypes()->contains($mime);
	}

	public function canHandleExtension(string $extension = ''): bool
	{
		return $this->supportedExtensions()->contains($extension);
	}

	public function allowMaxFileSize(UploadedFile $file): bool
	{
		return $file->getSize() < config('ibrand.uploader.' . static::TYPE . '.allowMaxSize') * 1024;
	}

	public function supportedExtensions(): Collection
	{
		return collect(config('ibrand.uploader.' . static::TYPE . '.supportedExtensions'));
	}

	public function supportedMimeTypes(): Collection
	{
		return collect(config('ibrand.uploader.' . static::TYPE . '.supportedMimeTypes'));
	}
}
