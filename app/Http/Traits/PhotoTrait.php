<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

trait PhotoTrait
{
    public function savePhoto($img, $size = null){
        $fileName = 'img/' . time().rand(1,999).'.jpg';
        
        if(is_null($size)) {
            $image = Image::make($img)->
                    save(storage_path('app/public/' . $fileName));
        } else {
            $image = Image::make($img)->
                    fit($size, $size)->
                    save(storage_path('app/public/' . $fileName));
        }
        
        if(!$image){
            return response()->json(['success' => false, 'message' => 'Error saving image']);
        }
        
        return 'storage/' . $fileName;
    }

    public function deletePhoto($name, $path){
        Storage::disk('local')->delete($path.$name);
    }
}