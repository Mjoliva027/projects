<?php


function random_num($length)
{
    // Seed the random number generator with current time in microseconds
    mt_srand((double) microtime() * 1000000);

    // Initialize an empty string to hold the random number
    $text = "";

    // Ensure the minimum length is 5
    if ($length < 5) {
        $length = 5;
    }

    // Generate a random length between 4 and the provided length
    $len = mt_rand(4, $length); 

    // Loop to generate each digit of the random number
    for ($i = 0; $i < $len; $i++) {
        // Append a random digit (0-9) to the text
        $text .= mt_rand(0, 9);
    }

    // Return the generated random number as a string
    return $text;
}

