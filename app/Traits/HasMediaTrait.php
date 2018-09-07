<?php

namespace App\Traits;

use Spatie\MediaLibrary\HasMedia\HasMediaTrait as BaseTrait;

trait HasMediaTrait
{
    use BaseTrait {
        addMedia as addMediaBase;
    }

    public function addMedia($file, $collection = 'default')
    {
        return $this->addMediaBase($file)->sanitizingFileName(function ($fileName) {
            return $this->id . str_random(5) . '.' . explode('.', $fileName)[1];
        })->toMediaCollection($collection);
    }
}