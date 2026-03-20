<?php

namespace App\Trait;

use Illuminate\Support\Str;

trait ImageProcessingTrait
{

    private function generateNewImageName($imgName, $scaleHeight)
    {
        $imgExplode = explode('.', $imgName);
        return $imgExplode[0] . "_$scaleHeight." . $imgExplode[1];
    }

    /**
     * @param string $imgName
     * @param int $scaleHeight
     * @param string $imgExtension
     * @param string $srcImgDir
     * @param string $dstImgDir
     * @param string $storagePrefixPath
     * @return string
     */
    private function changePicScale(string $imgName, int $scaleHeight = 100, string $imgExtension = 'jpeg', string $srcImgDir = 'pics', string $dstImgDir = 'picsGenerated', string $storagePrefixPath = 'app/private/'): string
    {
        $image = $this->imageManager->read(
            $this->getFileStoragePath($imgName, $storagePrefixPath . $srcImgDir)
        );
        //dd($image);
        $image->scale(height: $scaleHeight);
        $imageEncoded = $image->{'to' . Str::title($imgExtension)}();
        $imgNewName = $this->generateNewImageName($imgName, $scaleHeight);
        $imageEncoded->save(
            $this->getFileStoragePath($imgNewName, $storagePrefixPath . $dstImgDir)
        );
        return $imgNewName;
    }

    /**
     * @param $imgName
     * @param $path
     * @return string
     */
    private function getFileStoragePath($imgName, $path): string
    {
        $path = Str::endsWith($path, '/') ? $path : $path . '/';
        return storage_path($path . $imgName);
    }
}
