<?php
namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

trait CommonFunctions
{
    public function UpdateImage(UploadedFile $imageFile, $folderName="images", string $oldImagePath , int $height=0,int $width=0)
    {

        $this->RemoveImage($oldImagePath);
        return $this->UploadImage($imageFile, $folderName, $height, $width);
    }

    public function UploadImage(UploadedFile $imageFile, $folderName="images",int $height=0,int $width=0)
    {
        $fileName       =  time().$imageFile->getClientOriginalName();
        $uploads = 'assets/images/uploads';
        $filePath       ='assets/images/'.$folderName;
//        dd($imageFile->getPathname(), $filePath);
        $image_resize = Image::make($imageFile->getPathname());
//        $image_resize = Image::make($imageFile->getRealPath());
        if ($width>0 && $height>0) {
            $image_resize->resize(null, $height ,function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });


        }
        $image_resize->save($filePath.'/' .$fileName);
        $image = $filePath.'/'.$fileName;
        return $image;
    }

    public function RemoveImage($image_path)
    {
        try{
            if(File::exists(public_path($image_path)))
            {
                File::delete(public_path($image_path));
                return true;
            }

           return false;

        }
        catch (\Exception $e)
        {
            echo $e->getMessage();
            return false;
        }
    }

    public function GetCheckBoxValue($data,$fieldName)
    {
        if (isset($data[$fieldName]) && $data[$fieldName]=='on') {
            return 1;
        }
        else
            return 0;
    }
}
