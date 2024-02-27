<?php

class MyDB extends SQLite3
{
	function __construct()
	{
		$this->open('base/base.db');
	}

    function escape(&$field)
    {
        if (is_string($field))
        {
            $field = str_replace(["'", '"', "\\"], ["''", '""', "\\\\"], $field);
        }

        if (is_array($field))
        {
            foreach ($field as &$val)
            {
                $this->escape($val);
            }
        }
        return $field;
    }

    function escapeLike(&$field)
    {
        if (is_string($field))
        {
            $field = str_replace(["%", "_"], ["[%]", "[_]"], $field);
        }

        if (is_array($field))
        {
            foreach ($field as &$val)
            {
                $this->escape($val);
            }
        }
        return $field;
    }
}

?>