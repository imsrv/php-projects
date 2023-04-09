<?php

/*
 * Very simplistic version of PEAR.php
 */
class Exception
{
    var $message = '';

    function isException($data) {
        return (bool)(is_object($data) &&
                      (get_class($data) == "exception"));
    }

    function Exception($message = "unknown error")
    {
        $this->message = $message;
	}

    function getMessage ()
    {
        return ($this->message);
    }
}

?>
