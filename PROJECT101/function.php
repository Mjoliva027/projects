<?php


function random_num($length)
{
    $text = "";
    if ($length < 5) {
        $length = 5;
    }
    $len = mt_rand(4, $length); 
    for ($i = 0; $i < $len; $i++) {
        $text .= mt_rand(0, 9);
    }
    return $text;
}


