<?php

include "core/db.php";
include "templates/feedback.html";

$myDB = new MyDB();

function saveFeedback($comment)
{
    global $myDB;
    $myDB->escape($comment);
    $date = date('Y-m-d', time());
    $time = date('H:i:s', time());
    $myDB->exec('INSERT INTO feedback(COMMENT, DATE, TIME) VALUES ("' . $comment . '", "' . $date . '", "' . $time . '")');
}

function getFeedback(array $filter)
{
    global $myDB;

    $myDB->escape($filter);


    $query = 'SELECT COMMENT, DATE, TIME FROM feedback';

    if (!isFilterEmpty($filter))
    {
        $query .= ' WHERE ';
    }

    if (!empty($filter["comment"]))
    {
        $comment = $myDB->escapeLike($filter['comment']);
        $query .= 'COMMENT LIKE "%' . $comment . '%"';

        if (isDateValid($filter))
        {
            $query .= ' AND ';
        }
    }

    if (isDateValid($filter))
    {
        $condition = "DATE = '%s'";
        $prepared_date  = sprintf($condition, $filter["date"]);

        $query .= $prepared_date;
    }

    $query .= " ORDER BY ID DESC LIMIT 30";

    $result = $myDB->query($query);
    while ($row = $result->fetchArray()) 
    {
        $res[] = [
            'text' => $row['COMMENT'],
            'date' => $row['DATE'] . ' ' . ($row['TIME'] ?? ''),
        ];
    }

    return $res;
}

function isFilterEmpty(array $filter): bool
{
    return empty($filter['date']) && empty($filter['comment']);
}

function isDateValid(array $filter): bool
{
    return !empty($filter['date']) && preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $filter['date']);
}


if (isset($_POST["feedback"]))
{
    saveFeedback($_POST["feedback"]);
}

$filter = $_GET["search"] ?? [];

$feedback = getFeedback($filter) ?? [];
foreach ($feedback as $comment)
{
?> 
<div class="feedback-block">
        <div class="feedback-comment">
            <div class="comment-date">
                <?= htmlspecialchars($comment['date'] ?? '') ?>
            </div>
            <div class="comment-text">
                <?= htmlspecialchars($comment['text'] ?? '') ?>
            </div>
        </div>
</div>
<? 
}