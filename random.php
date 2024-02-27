<?php

function randomCapy()
{
    $files = glob(__DIR__ . "/static/rand" . '/*.*');
    $file = array_rand($files);
    $file = str_replace(__DIR__, "", $files[$file]);
    return $file;
}

$randomCapy = randomCapy();

include('templates/random.html');
?>
