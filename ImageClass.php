<?php

class ImageClass
{
    public static function resizeImage($image_name, $new_width, $new_height, $saveLocation, $mime_type)
    {
        list($width, $height) = getimagesize($image_name);
        
        if ($width > $height && $new_height < $height) {
            $new_height = $height / ($width / $new_width);
        } else if ($width < $height && $new_width < $width) {
            $new_width = $width / ($height / $new_height);
        } else {
            $new_width = $width;
            $new_height = $height;
        }

        $thumb_image = imagecreatetruecolor($new_width, $new_height);
        if ($mime_type == 'image/png') {
            $src = imagecreatefrompng($image_name);
            imagecopyresized($thumb_image, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

            imagepng($thumb_image, $saveLocation . mt_rand(1, 1000) . ".png");
        } else {
            $src = imagecreatefromjpeg($image_name);
            imagecopyresized($thumb_image, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

            imagejpeg($thumb_image, $saveLocation . mt_rand(1, 1000) . ".jpg");
        }
    }

    public static function cropImage($image_name, $max_width, $max_height, $saveLocation, $mime_type)
    {
        if ($mime_type == 'image/png') {
            $src = imagecreatefrompng($image_name);

            $croppedImage = imagecrop($src, ['x' => 0, 'y' => 0, 'width' => $max_width, 'height' => $max_height]);
            if ($croppedImage !== FALSE) {
                imagepng($croppedImage, $saveLocation);
            }
        } else {
            $src = imagecreatefromjpeg($image_name);

            $croppedImage = imagecrop($src, ['x' => 0, 'y' => 0, 'width' => $max_width, 'height' => $max_height]);
            if ($croppedImage !== FALSE) {
                imagejpeg($croppedImage, $saveLocation);
            }
        }
    }

    public static function cropImageToSquare($image_name, $max_width, $max_height, $saveLocation,  $mime_type)
    {
        $side_length = min($max_width, $max_height);
        if ($mime_type == 'image/png') {
            $src = imagecreatefrompng($image_name);

            $size = min(imagesx($src), imagesy($src));
            $cropped_size = min($side_length, $size);

            $croppedImage = imagecrop($src, ['x' => 0, 'y' => 0, 'width' => $cropped_size, 'height' => $cropped_size]);
            if ($croppedImage !== FALSE) {
                imagepng($croppedImage, $saveLocation);
            }
        } else {
            $src = imagecreatefromjpeg($image_name);

            $size = min(imagesx($src), imagesy($src));
            $cropped_size = min($side_length, $size);

            $croppedImage = imagecrop($src, ['x' => 0, 'y' => 0, 'width' => $cropped_size, 'height' => $cropped_size]);
            if ($croppedImage !== FALSE) {
                imagejpeg($croppedImage, $saveLocation);
            }
        }
    }
}
