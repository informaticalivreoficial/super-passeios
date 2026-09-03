<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class Cropper
{
    public static function thumb(string $uri, int $width, ?int $height = null): string
    {
        $filename  = md5($uri . $width . $height) . '.webp';
        $cachePath = 'cache/' . $filename;

        if (Storage::disk('public')->exists($cachePath)) {
            return $cachePath;
        }

        if (!Storage::disk('public')->exists($uri)) {
            return '';
        }

        $contents = Storage::disk('public')->get($uri);

        $manager = new ImageManager(new Driver());
        $image   = $manager->read($contents);

        if ($height) {
            $image->cover($width, $height);
        } else {
            $image->scale(width: $width);
        }

        $temp = tempnam(sys_get_temp_dir(), 'crop') . '.webp';
        $image->toWebp(80)->save($temp);
        Storage::disk('public')->put($cachePath, file_get_contents($temp));
        unlink($temp);

        return $cachePath;
    }

    public static function flush(?string $path = null): void
    {
        if (!empty($path)) {
            $hash = md5($path);
            foreach (Storage::disk('public')->files('cache') as $file) {
                if (str_contains($file, $hash)) {
                    Storage::disk('public')->delete($file);
                }
            }
        } else {
            Storage::disk('public')->deleteDirectory('cache');
        }
    }
}
