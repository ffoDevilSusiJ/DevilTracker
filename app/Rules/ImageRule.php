<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

class ImageRule implements Rule
{
    protected int $width;
    protected int $height;

    public function __construct(int $width = null, int $height = null)
    {
        $this->width = $width;
        $this->height = $height;
    }

    public function passes($attribute, $value)
    {
        if ($value instanceof UploadedFile) {
            $image = getimagesize($value);
            if ($image !== false && ($this->width === null || $image[0] <= $this->width) && ($this->height === null || $image[1] <= $this->height)) {
                return true;
            }
        }
        return false;
    }

    public function message()
    {
        return trans('validation.custom.' . static::class . '.invalid');
    }
}