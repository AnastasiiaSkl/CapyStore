<?php

require 'core/db.php';

$myDB = new MyDB();

function getMerch(int $id)
{
    global $myDB;
    $query = "SELECT PICTURE, TITLE, DESCRIPTION FROM merch WHERE ID=$id";
    $result = $myDB->query($query);
    return $result->fetchArray();
}

include "templates/card.html";