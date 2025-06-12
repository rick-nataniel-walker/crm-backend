<?php

namespace App\Traits;

trait FileUpload
{
    use StringsTrait;

    public function uploadDoc($request, $filename, $folder, $storename = null)
    {
        if($storename == null) $storename = $this->generateString();
        $file = $request->file($filename);
        if ($file->isValid()) {
            $path = 'public/' . $folder;

            $storename = $storename . '.' . $file->extension();
            if (strlen($file->storeAs($path, $storename)) > 0) {
                return array('storename' => $storename, 'path' => explode('/', $path)[1] . '/' . $storename);
            }
            return false;
        }
        return null;
    }

    public function saveBlob($rawImg, $storename, $folderPath)
    {
        $image_parts = explode(";base64,", $rawImg);

        foreach ($image_parts as $key => $image) {
            $image_base64 = base64_decode($image);
        }

        $path = 'storage/' . $folderPath . '/';

        $filename = $storename . '.png';

        $filepath = $path . $filename;
        $results = ['path' => $filepath, 'filename' => $filename];
        return file_put_contents($filepath, $image_base64) != false ? $results : null;

    }

}
