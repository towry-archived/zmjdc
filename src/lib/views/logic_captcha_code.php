<?php

function logic_captcha_code() {
    $csrf = params('id', null);
    if (! csrf_check($csrf)) {
        error(404, 'Page not found');
    }

    $width = params('w', 120);
    $height = params('h', 40);

    $image_width = $width;
    $image_height = $height;
    $characters_on_image = 5;
    $font = BASEPATH . '/assets/fonts/MONOFONT.TTF';

    $possible_letters = '3456789bcedfghjkmnpqrstvwxy';
    $random_dots = 20;
    $random_lines = 5;
    $captcha_text_color = "0x142864";
    $captcha_noise_color = "0x142864";

    $code = '';

    $i = 0;
    while ($i < $characters_on_image) {
        $code .= substr($possible_letters, mt_rand(0, strlen($possible_letters) - 1), 1);
        $i++;
    }

    $font_size = $image_height * 0.75;
    $image = @imagecreate($image_width, $image_height);

    $background_color = imagecolorallocate($image, 255, 255, 255);
    $arr_text_color = hexrgb($captcha_text_color);
    $text_color = imagecolorallocate($image, $arr_text_color['red'], $arr_text_color['green'],
        $arr_text_color['blue']);

    $arr_noise_color = hexrgb($captcha_noise_color);
    $image_noise_color = imagecolorallocate($image, $arr_noise_color['red'], $arr_noise_color['green'],
        $arr_noise_color['blue']);

    /** generate random dots */
    for ( $i= 0; $i < $random_dots; $i++) {
        imagefilledellipse($image, mt_rand(0, $image_width), 
            mt_rand(0, $image_height), 2, 3, $image_noise_color);
    }
    /** generate random lines */
    for ( $i = 0; $i < $random_lines; $i++) {
        imageline($image, mt_rand(0, $image_width), mt_rand(0, $image_height), 
            mt_rand(0, $image_width), mt_rand(0, $image_height), $image_noise_color);
    }

    $textbox = imagettfbbox($font_size, 0, $font, $code);
    $x = ($image_width - $textbox[4]) / 2;
    $y = ($image_height - $textbox[5]) / 2;
    imagettftext($image, $font_size, 0, $x, $y, $text_color, $font, $code);

    header('Content-Type: image/jpeg');
    imagejpeg($image, null, 100);
    imagedestroy($image);

    session('captcha_code', $code);
}


if (! function_exists('hexrgb')) {
    function hexrgb($hex) {
        $int = hexdec($hex);

        return array('red' => 0xFF & ($int >> 0x10),
            'green' => 0xFF & ($int >> 0x8),
            'blue' => 0xFF & $int
        );
    }
}
