<?php


namespace App;


use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ImageUtility
{
   public const  defaultOriginalImage="/storage/images/original/5APbBDSrH91mMX3MybnJObT1q7ojD28RGJbwewEM.png";
   public const  defaultProfileImage="/storage/images/profile/wLn6zd0l4uX8SbxUoyUIH01SAbZIO3qg8aTGEHHD.png";
  public  const  defaultThumbnailImage="/storage/images/thumbnail/wLn6zd0l4uX8SbxUoyUIH01SAbZIO3qg8aTGEHHD.png";
    public static function storeImage($image,$path,$width,$height)
    {

        $extension= ImageUtility::getExtension($image);
        $randomStr=Str::random(40);
        $image= Image::make($image);

        $directory = public_path().$path;
        $ImageStr=$directory.$randomStr.$extension;
        $image->resize($width,$height);
        $image->save($ImageStr);
        return $path.$randomStr.$extension;
    }

    public static function getExtension($image)
    {
        $array=explode('.',$image->getClientOriginalName());
        return '.'.$array[sizeof($array)-1];
    }
    public static function deleteImage($image)
    {
        $imageDirectory = public_path( $image);
        if (file_exists($imageDirectory))
            unlink($imageDirectory);
    }
}
