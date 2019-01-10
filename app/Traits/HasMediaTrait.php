<?php

namespace App\Traits;

use Spatie\MediaLibrary\HasMedia\HasMediaTrait as BaseTrait;

trait HasMediaTrait
{
    use BaseTrait {
        addMedia as addMediaBase;
        addMediaFromUrl as addMediaFromUrlBase;
    }

    public function addMedia($file, $custom = [], $collection = 'default')
    {
        return $this->addMediaBase($file)->sanitizingFileName(function ($fileName) {
            return $this->id . str_random(5) . '.' . explode('.', $fileName)[1];
        })->withCustomProperties($custom)->toMediaCollection($collection);
    }

    public function addMediaFromUrl($file, $custom = [], $collection = 'default')
    {
        return $this->addMediaFromUrlBase($file)->sanitizingFileName(function ($fileName) {
            return $this->id . str_random(5) . '.' . explode('.', $fileName)[1];
        })->withCustomProperties($custom)->toMediaCollection($collection);
    }
}