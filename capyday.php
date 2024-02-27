<?php

function fisherYatesShuffle(array &$items, int $seed)
{
    @mt_srand($seed);
    for ($i = count($items) - 1; $i > 0; $i--)
    {
        $j = @mt_rand(0, $i);
        $tmp = $items[$i];
        $items[$i] = $items[$j];
        $items[$j] = $tmp;
    }
}

function capyOfTheDay()
{
    $files = glob(__DIR__ . "/static/rand" . '/*.*');

    $date = date('Y-m-01');
    fisherYatesShuffle($files, strtotime($date));

    $day = (int)idate('d');
    $file = $files[($day - 1) % count($files)];
    
    return str_replace(__DIR__, "", $file);
}

$capyOfTheDay = capyOfTheDay();

include('templates/capyday.html');
