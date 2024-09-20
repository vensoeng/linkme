<?php

if (!function_exists('compressImage')) {
    function compressImage($source, $destination, $quality)
    {
        $info = getimagesize($source);

        if ($info['mime'] == 'image/jpeg') {
            $image = imagecreatefromjpeg($source);
            imagejpeg($image, $destination, $quality);
        } elseif ($info['mime'] == 'image/png') {
            $image = imagecreatefrompng($source);
            imagepng($image, $destination, $quality / 10);
        } elseif ($info['mime'] == 'image/webp') {
            $image = imagecreatefromwebp($source);
            imagewebp($image, $destination, $quality);
        }
        imagedestroy($image);
    }
}

if (!function_exists('uploadAndCompressImage')) {
    function uploadAndCompressImage($file, $filename)
    {
        if (isset($file) && $file['error'] == 0) {
            $fileSize = $file['size'];
            $fileTmp = $file['tmp_name'];
            $fileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

            // Allowed file formats
            $allowedFormats = ['jpg', 'jpeg', 'png', 'webp'];

            if (in_array($fileExt, $allowedFormats)) {
                $destination = 'storage/upload/' . $filename;

                if ($fileSize > 1048576) { // If the file is larger than 1MB
                    $quality = 75; // Initial quality level

                    // Compress the image
                    do {
                        compressImage($fileTmp, $destination, $quality);
                        $compressedSize = filesize($destination);
                        $quality -= 5; // Decrease quality for further compression if needed
                    } while ($compressedSize > 1048576 && $quality > 10); // Keep compressing until size is under 1MB
                } else {
                    // Move the uploaded file if it's already under 1MB
                    move_uploaded_file($fileTmp, $destination);
                }

                return $filename; // Return the filename for database storage
            } else {
                // echo "Unsupported file format!";
                return null;
            }
        } else {
            // echo "No file uploaded or there was an error!";
            return null;
        }
    }
}
if (!function_exists('validateImagesEX')) {
    function validateImagesEX($file, $allowedFormats = ['jpg', 'jpeg', 'png', 'webp'], )
    {
        $fileExt = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        if (in_array($fileExt, $allowedFormats)) {
            return true;
        } else {
            return false;
        }
    }

}