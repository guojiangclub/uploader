<?php

namespace iBrand\Upload\Checkers;

use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface BaseChecker
{
	public function canHandleMime(string $mime = ''): bool;

	public function canHandleExtension(string $extension = ''): bool;

	public function allowMaxFileSize(UploadedFile $file): bool;

	public function supportedExtensions(): Collection;

	public function supportedMimeTypes(): Collection;
}
