<?
/******************************************************************************
 *  SiteBar 3 - The Bookmark Server for Personal and Team Use.                *
 *  Copyright (C) 2003  Ondrej Brablc <sitebar@brablc.com>                    *
 *                                                                            *
 *  This program is free software; you can redistribute it and/or modify      *
 *  it under the terms of the GNU General Public License as published by      *
 *  the Free Software Foundation; either version 2 of the License, or         *
 *  (at your option) any later version.                                       *
 *                                                                            *
 *  This program is distributed in the hope that it will be useful,           *
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of            *
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             *
 *  GNU General Public License for more details.                              *
 *                                                                            *
 *  You should have received a copy of the GNU General Public License         *
 *  along with this program; if not, write to the Free Software               *
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA *
 ******************************************************************************/

function dump($expr,$inscript=0)
{
    if ($inscript) echo "</script>";
    echo "<pre>";
    var_dump($expr);
    echo "</pre>";
    if ($inscript) echo "<script>";
}

/* Static storage for error messages */
function & _errorHandlerMessages()
{
    static $errors = array();
    return $errors;
}

/* Static storage for error count */
function _errorCounter($add=0)
{
    static $counter = 0;
    $counter += $add;
    return $counter;
}

/* Static storage for warning count */
function _warnCounter($add=0)
{
    static $counter = 0;
    $counter += $add;
    return $counter;
}

class ErrorHandler
{
/*public:*/

    /**
    * Issue error
    */
    function error($msg)
    {
        _errorCounter(1);
        $errors =& $this->getErrors();
        $errors[] = array(E_ERROR,$msg);
    }

    /**
    * Issue warning
    */
    function warn($msg)
    {
        _warnCounter(1);
        $errors =& $this->getErrors();
        $errors[] = array(E_WARNING,$msg);
    }

    /**
    * Fatal error
    */
    function fatal($msg)
    {
        trigger_error($msg, E_USER_ERROR);
        die();
    }

    /**
    * Returns any possible errors
    */
    function & getErrors()
    {
        $errors =& _errorHandlerMessages();
        return $errors;
    }

    /**
    * Tells wheter there are errors to be reported
    */
    function hasErrors($type=null)
    {
        switch ($type)
        {
            case E_ERROR:
                return _errorCounter();

            case E_WARNING:
                return _warnCounter();

            default:
                return count($this->getErrors());
        }
    }

    /**
    * Write errors as UL
    */
    function writeErrors($fulldetails = true)
    {
        if ($fulldetails) echo "<ul>";

        foreach ($this->getErrors() as $err)
        {
            $el = "";
            switch($err[0])
            {
                case E_ERROR:
                    $el = 'Error';
                    break;

                case E_WARNING:
                    $el = 'Warning';
                    break;

                default:
                    $el = 'Unknown';
            }
            if ($fulldetails)
            {
                echo "<li>" . $el . ": " . $err[1];
            }
            else
            {
                echo "<p>" . $err[1];
            }
        }

        if ($fulldetails) echo "</ul>";
    }
}

?>