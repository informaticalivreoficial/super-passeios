<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class Cropper
{
    public static function thumb(string $uri, int $width, ?int $height = null): string
    {
        $disk = 'r2';
        $filename  = md5($uri . $width . $height) . '.webp';
        $cachePath = 'cache/' . $filename;

        if (Storage::disk($disk)->exists($cachePath)) {
            return $cachePath;
        }

        if (!Storage::disk($disk)->exists($uri)) {
            return '';
        }

        $contents = Storage::disk($disk)->get($uri);

        $manager = new ImageManager(new Driver());
        $image   = $manager->read($contents);

        if ($height) {
            $image->cover($width, $height);
        } else {
            $image->scale(width: $width);
        }

        $temp = tempnam(sys_get_temp_dir(), 'crop') . '.webp';
        $image->toWebp(80)->save($temp);
        Storage::disk($disk)->put($cachePath, file_get_contents($temp));
        unlink($temp);

        return $cachePath;
    }

    public static function flush(?string $path = null): void
    {
        $disk = 'r2';

        if (!empty($path)) {
            $hash = md5($path);
            foreach (Storage::disk($disk)->files('cache') as $file) {
                if (str_contains($file, $hash)) {
                    Storage::disk($disk)->delete($file);
                }
            }
        } else {
            Storage::disk($disk)->deleteDirectory('cache');
        }
    }
}
