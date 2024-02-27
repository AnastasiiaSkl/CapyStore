<?php

require 'core/db.php';

$myDB = new MyDB();

function getMerch($filter)
{
    global $myDB;

    $myDB->escape($filter);
    $myDB->escapeLike($filter["title"]);

    $condition = "ID = %s";
    $prepared_id  = sprintf($condition, $filter["id"]);

    $query = "SELECT * FROM merch";

    if (!isFilterEmpty($filter))
    {
        $query .= " WHERE ";
    }

    if (!empty($filter["id"]))
    {
        $query .= $prepared_id;
        if (!empty($filter["title"]))
        {
            $query .= " AND ";
        }
    }
    if (!empty($filter["title"]))
    {
        $query .= "TITLE LIKE '%%%s%%'";
        $query  = sprintf($query, $filter["title"]);
    }

    return $myDB->query($query);
}

function isFilterEmpty(array $filter): bool
{
    return empty($filter['title']) && empty($filter['id']);
}

$filter = $_GET["search"] ?? [];

$merch = getMerch($filter);
$pics = [];
while ($row = $merch->fetchArray()) {
    $pics[] = ["ID" => $row["ID"], "PICTURE" => $row["PICTURE"], "TITLE" => $row["TITLE"]];
}

include('templates/merch.html');