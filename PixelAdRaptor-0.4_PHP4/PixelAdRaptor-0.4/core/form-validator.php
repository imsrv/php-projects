<?php
/**
 *
 * Form validator
 *
 * @author Karolis Tamutis
 * @date 2005-08-19
 * @file form-validator.php
 *
 * Copyright (C) 2005  Karolis Tamutis
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA. 
 */ 
 
if (!defined('MAIN')) {

    die('No direct access.');
    
}

class FormValidator {

    /**
     *
     * Contains the name of the method used to transfer form data
     *
     * @var string
     */
    var $_method;

    /**
     *
     * Contains filter to field rules
     * 
     * @var array
     */
    var $_filters;

    /**
     *
     * Contains filter directory
     *
     * @var string
     */
    var $_filterPath;

    /**
     *
     * Error message if required field's missing
     *
     * @var string
     */
    var $_requiredMsg;

    /**
     *
     * Indicates wether the form was submitted
     *
     * @var bool
     */    
    var $_wasSubmitted;

    /**
     *
     * Error buffer
     *
     * @var array
     */
    var $_errors;

    /**
     *
     * A constructor
     * @param string $method method used to transfer form data
     */
    function FormValidator($method) {

        $this->_filters = array();
        $this->_filterPath = 'core/';
        $this->_requiredMsg = 'You`ve forgot to enter';
        $this->_wasSubmitted = false;
        $this->_errors = array();

        switch (strtolower($method)) {

            case 'post':
                $this->_method = & $_POST;
                break;
            case 'get':
                $this->_method = & $_GET;
                break;

        }

    }

    /**
     *
     * Method to set filter path
     *
     * @param string $path filter path
     */
    function setFilterPath($path) {

        $this->_filterPath = $path;

    }

    /**
     *
     * Method to set requiredMsg property
     *
     * @param string $msg required field error message
     */
    function setRequiredMsg($msg) {

        $this->_requiredMsg = $msg;

    }

    /**
     *
     * Method to check if the form was submited
     * Be aware of this issue in IE 6: http://msdn.microsoft.com/library/default.asp?url=/workshop/author/dhtml/reference/objects/input_submit.asp
     *
     * @param string $s name of submit button
     */
    function wasSubmitted($s) {

        if (isset($this->_method[$s])) {

            $this->_wasSubmitted = true;
            return true;

        }

        return false;

    }

    /**
     *
     * Method to set up required fields
     *
     * @param array $list list with required field names tied with their string names
     */
    function addRequired($list) {

        $this->_required = $list;

    }

    /**
     *
     * Method to add an error string
     *
     * @param string $errorString
     */
    function addError($errorString) {

        $id = rand(0,100);

        while (array_key_exists($id, $this->_errors)) {

            $id = rand(0,100);

        }

        $this->_errors[$id] = $errorString;

    }

    /**
     *
     * Method to assign filters to form fields
     * A filter, in other works, is a rule, by which we do a validation on a specified field.
     * In order to achieve more efficiency, we will not add filters until the form is submitted.
     *
     * @param string $field name of the form field
     * @param string $filter name of the filter to be assigned
     * @param array $params array of filter parameters
     * @param string $errorStr error string if the filter returns false
     */
    function addFilter($field, $filter, $params, $errorStr) {

        $this->_filters[$field] = array($filter, $params, $errorStr);

    }

    /**
     *
     * Method to perform field validation by assigning filters.
     * Executes only if the form was submitted.
     */
   function performValidation() {

        if ($this->_wasSubmitted && !empty($this->_required)) {
 
            foreach ($this->_required as $key => $value) {

                if (array_key_exists($key, $this->_required) && empty($this->_method[$key])) {

                    $this->_errors[$key] = '<b>'.$this->_requiredMsg.':</b> '.$this->_required[$key];

                }

            }

            if (!empty($this->_filters)) {   

                foreach ($this->_filters as $key => $value) {

                    if (is_file($this->_filterPath.$value[0].'.php')) {

                        require_once($this->_filterPath.$value[0].'.php');

                        $filter = & new $value[0];

                        if (!$filter->validate($key, $value[1], $this->_method) && !array_key_exists($key, $this->_errors)) {
                        
                            $this->_errors[$key] = $value[2];    

                        }                    

                    } else {

                        echo('Filter '.$this->_filterPath.$value[0].'.php'.' does not exist');

                    }
                }
            }
        }
    }

    /**
     *
     * Method to check if the filtering passed clear
     */
    function isOk() {

        if (!empty($this->_errors)) {

            return false;

        }

        return true;

    }

    /**
     *
     * Method to get raw error array.
     * You do the error formatting.
     */
    function getRawErrors() {

        return $this->_errors;

    }

    /**
     *
     * Method to get html formatted errors
     */
    function getHtmlErrors() {

        $str = '<ul class="error">';

        foreach ($this->_errors as $value) {

            $str .= '<li>'.$value.'</li>';

        }

        $str .= '</ul>';

        return $str;

    }

    /**
     *
     * Method to return javascript code, that turns 
     * failed field border colors to red
     */
    function getJs() {

        $js = '<script type="text/javascript">';

        foreach ($this->_errors as $key => $value) {

            if (!is_numeric($key)) {

                $js .= 'document.getElementById("'.$key.'").style.borderColor = "#ff0000"; ';
                
            }

        }

        return $js.'</script>';

    }

    /**
     *
     * Method to flush the error buffer
     */
    function flushBuffer() {

        $this->_errors = array();

    }
       

}     
     
?>