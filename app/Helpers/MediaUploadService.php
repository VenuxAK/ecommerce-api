<?php

namespace App\Helpers;

use App\Models\ProductImage;

trait MediaUploadService
{
    private $allowedFileExtension = ["jpg", "png", "jpeg", "webp"];

    protected function productImagesUpload(array $files)
    {
        foreach ($files as $file) {
            $extension = $file->getClientOriginalExtension();
            $check = in_array($extension, $this->allowedFileExtension);
            if ($check) {
                return true;
            } else {
                return NULL;
            }
        }
    }
    protected function categoryThumbnailUpload($file)
    {
        $extension = $file->getClientOriginalExtension();
        $check = in_array($extension, $this->allowedFileExtension);
        if ($check) {
            return $file->store("categories", ["disks", "eStore_images"]);
        } else {
            return NULL;
        }
    }
}
