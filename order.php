<?php

include "core/db.php";

$myDB = new MyDB();

function saveOrder(array $order)
{
    global $myDB;
    $myDB->escape($order);
    $query = 'INSERT INTO orders(PRODUCT_ID, ADDRESS, PHONE) VALUES
        ("' . intval($order["id"]) .
        '", "' . $order["address"] .
        '", "' . $order["phone"] . '")'
    ;
    $myDB->exec($query);
}

if (isset($_GET["id"]) && is_numeric($_GET["id"]))
{
    $id = $_GET["id"];
}
else
{
    $id = "";
}

include "templates/order.html";

if (isset($_POST["order"]))
{
    if (is_array($_POST["order"]))
    {
        saveOrder($_POST["order"]);
    }
    else
    {
        echo "Не заполнены обязательные поля";
    }
}