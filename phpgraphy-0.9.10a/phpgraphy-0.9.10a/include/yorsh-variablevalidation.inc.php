<?php

/*
*
*  This program is free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2, or (at your option)
*  any later version.
*
*  This program is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  You should have received a copy of the GNU General Public License
*  along with this program; if not, write to the Free Software
*  Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
*
*  $Id: yorsh-variablevalidation.inc.php 196 2005-10-18 16:10:10Z jim $
*
*/

/**
* Yorsh Variable Validation (Main Class File)
*
* Yorsh Variable Validation class enables you to maintain
* a central list of variables with attached properties
* so that you can easily check if they're valid.
*
* Originally written for phpGraphy {@link http://phpgraphy.sourceforge.net}.
*
* @author JiM / aEGIS
* @version 0.1
* @copyright 2005 - jim [at] aegis [hyphen] corp [dot] org
*
*/

// Load $var_name_ref & $var_type_ref array + user custom functions
require_once "include/yorsh-variablevalidation-data.inc.php";

/**
* Function that check a variable by matching its name with a reference array
* If the variable is listed in $var_name_ref, then all the properties are checked
* and if one of them fail, it will return false. This is used in phpGraphy in
* combination with a loop to check the user input data (GET/POST/COOKIE).
* 
* @param string $varname
* @param string $value
* @return true|false
* @see $var_name_ref, $var_type_ref
*/

function check_variable($varname, $value) 
{

    global $var_name_ref, $var_type_ref;

    /**
    * Array of all peformed by the function
    * All values should be set to 1 for the test to be successful
    * 
    * @var var_check
    */

    $var_check['found']         = 0;
    $var_check['valid_type']    = 0;

    /* Check below are optionnal and thus will be initialized only if needed
    *
    *  Checks like empty_allowed and not_too_long may be performed in a regexp
    *  but if no regexp is really needed after, then use them as they're faster
    *

    $var_check['empty_allowed'] = 0;
    $var_check['not_too_long']  = 0;
    $var_check['pregex']        = 0;
    $var_check['function']      = 0;

    */


    // Testing structure

    if ($var_name_ref[$varname]) {

        $var_check['found'] = 1;

        if (is_array($var_type_ref[$var_name_ref[$varname]['type']])) {
    
            $var_check['valid_type'] = 1;

            if (isset($var_name_ref[$varname]['empty']) && !$value) {

                $var_check['empty_allowed'] = 0;

	            if ($var_name_ref[$varname]['empty']) {

                    $var_check['empty_allowed'] = 1;

                }

            }


	        if (isset($var_name_ref[$varname]['maxlength'])) {

                $var_check['not_too_long']  = 0;

	            if (strlen($value) <= $var_name_ref[$varname]['maxlength']) $var_check['not_too_long'] = 1;

	        }

            if ($value) {
                // Performing additional checks (pregex, function)

                // additional.pregex
                if (isset($var_type_ref[$var_name_ref[$varname]['type']]['pregex'])) {
                    $var_check['pregex'] = 0;
                    if (preg_match($var_type_ref[$var_name_ref[$varname]['type']]['pregex'], $value)) {
                        $var_check['pregex'] = 1;
                    }
                }

                // additional.function
                if (isset($var_type_ref[$var_name_ref[$varname]['type']]['function'])) {

                    $var_check['function'] = 0;

                    if (call_user_func($var_type_ref[$var_name_ref[$varname]['type']]['function'], $value)) {
                        $var_check['function'] = 1;
                    }

                }

            }

        }

    }

    // Let's now analyse the results and to see if one of the check has failed.

    $var_check_failed = 0;


    // This rely on the Yorsh Error Handler to be properly handle
    // $debug_output = "DEBUG: Checking var($varname) ";
    // if (strlen($value) > 50) $debug_output.= "stripped_";
    // $debug_output.= "value(".substr($value, 0, 50).")";
    // Uncomment if needed but this is very verbose
    // trigger_error($debug_output, E_USER_NOTICE);

    // Preparing an output with all details if it has failed
    $debug_output = "DEBUG: var($varname) content(".substr($value, 0, 50).") lenght(".strlen($value).") FAILED to validate - ";

    foreach ($var_check as $check => $status) {

        $debug_output.= "$check(";

        if ($status) {

            $debug_output.= "OK";

        } else {

            $debug_output.= "NOK";
            $var_check_failed = 1;
        }

        $debug_output.= ") ";

    }

    if (!$var_check_failed) {

        $debug_output = "DEBUG: var($varname) was successfully checked";
        // Uncomment if needed but this is very verbose
        // trigger_error($debug_output, E_USER_NOTICE);

        return true;

        // The idea would be to make the variable global but this need to be done
        // outside of the function
        // $$varname=$value;

    } else {

        trigger_error($debug_output, E_USER_NOTICE);
        return false;

    }

}

?>
