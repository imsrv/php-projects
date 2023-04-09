<?php
/**
 *
 * Template engine. Complete rewrite.
 *
 * @author Karolis Tamutis
 * @date 2005-09-16
 * @file template.php
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

class Template {


    /**
     *
     * Template data container
     *
     * @var string
     */
    var $input;
    
    /**
     *
     * Template loop container
     *
     * @var array
     */
    var $loops;
    
    /**
     *
     * Scalar variable container
     *
     * @var array
     */
    var $scals;
    
    /**
     *
     * Error messages
     *
     * @var array
     */
    var $errors = array('Input file does not exist',
                            'Zero length input stream',
                            'Not valid input stream specified');
                            
    /**
     *
     * Template error buffer
     * 
     * @var array
     */
    var $errorBuffer;

    /**
     *
     * A constructor.
     */
    function Template() {
    
        $this->input = null;
        $this->scals = null;
        
        $this->loops = array();
        
        $this->errorBuffer = array();
    
    }
    
    /**
     *
     * Method to set template variables.
     *
     * @param string $variable variable name
     * @param string $value variable value
     * @return bool
     */
    function set($variable, $value) {
    
        /**
         *
         * Check if the value is an array, else - threat is as scalar
         */
        if (is_array($value)) {
            
            $this->loops[$variable] = $value;
        
        } else {
        
            $this->scals[$variable] = $value;
        
        }
        
        return true;
    
    }
    
    /**
     *
     * Method to parse file includes
     * Replaces all include directives with their file contents
     * 
     * @return bool
     */
    function parseIncludes() {
    
        preg_match_all('/\[include:(.*?)\]/', $this->input, $matches);
        
        foreach ($matches[1] as $key => $value) {
            
            if (!($file = @file_get_contents($value))) {
            
                $this->input = str_replace($matches[0][$key], null, $this->input);
            
            } else {
            
                $this->input = str_replace($matches[0][$key], $file, $this->input);
                
            }
        
        }
        
        return true;
    
    }
    
    /**
     *
     * Method to parse scalar variables
     *
     * @return bool
     */
    function parseScalars() {
    
        if (!empty($this->scals)) {
    
            foreach ($this->scals as $key => $value) {
                
                $this->input = str_replace('{scal:'.$key.'}', $value, $this->input);
        
            }
        
        }
        
        return true;
    
    }    
    
    /**
     *
     * 'Giant' method to parse template loops.
     * Nested loop support included!
     *
     * @param string $loopName name of the loop
     * @param string $loopArr array containing loop data
     * @param string $string input string
     *
     * @return bool | string
     */
    function parseLoops($loopName, $loopArr, $string) {
        
        $st_pos = strpos($string, '{loop:'.$loopName.'}') + 7 + strlen($loopName);
        $en_pos = strpos($string, '{endloop:'.$loopName.'}');
        
        if ($st_pos !== false && $en_pos !== false) {

            $str = substr($string, $st_pos, $en_pos - $st_pos);
            $str_buff = null;
            $i = 0;
                        
            foreach ($loopArr as $key => $value) {
                
                $keys = array_keys($value);
                $str_buff_temp = $str;
                
                foreach ($keys as $v) {
                
                    if (is_array($value[$v])) {
                        
                        $str_tmp = $this->parseLoops($loopName.'.'.$v, $value[$v], $str_buff_temp);
                        
                        if ($str_tmp) {
                        
                            $str_buff_temp = $str_tmp;
                        
                        }
                    
                    } else {
                    
                        $sub_st_pos = strpos($str_buff_temp, '{loop:'.$loopName.'.'.$v.'}') + 7 + strlen($loopName.'.'.$v);
                        $sub_en_pos = strpos($str_buff_temp, '{endloop:'.$loopName.'.'.$v.'}');
                   
                        if ($sub_st_pos !== false && $sub_en_pos !== false) {

                            $str_buff_temp = substr_replace($str_buff_temp, null,  $sub_st_pos, $sub_en_pos - $sub_st_pos);
                            
                        }
                        
                        $str_buff_temp = str_replace('{'.$loopName.'.'.$v.'}', $value[$v], $str_buff_temp);
                    
                    }
                
                }
                
                preg_match('/{cycle:(.*?)\|(.*?)}/', $str_buff_temp, $buf);

                if (!empty($buf)) {
                        
                    $str_buff .= ($i % 2 == 0)?str_replace($buf[0], $buf[1], $str_buff_temp):str_replace($buf[0], $buf[2], $str_buff_temp);
                        
                } else {
                        
                    $str_buff .= $str_buff_temp;
                        
                }
                
                $i++;
                                        
            }
            
            return substr_replace($string, $str_buff, $st_pos, $en_pos - $st_pos); 
        
        } else {
        
            return false;
        
        }
    
    }
    
    /**
     *
     * Method to call all internal methods, to do parsing
     *
     * @return string
     */
    function process() {
    
        $this->parseScalars();
        
        /**
         *
         * @TODO Fix this crazy logic.
         *
         * Ok, quick sollution.
         * Call it two times, to 2nd level includes also.
         */
        $this->parseIncludes();
        
        $this->parseScalars();

        $this->parseIncludes();
        
        $this->parseScalars();
        
        while (list($loopName, $loopArr) = each($this->loops)) {

            $this->input = $this->parseLoops($loopName, $loopArr, $this->input);
            
        }
        
        $this->parseScalars();
        
        return preg_replace('/<div class="(top|left|center|right|bottom)">{[^ \t\r\n}]+}<\/div>/', null, preg_replace('/{[^ \t\r\n}]+}/', null, $this->input)); 
    
    }
    
    /**
     *
     * Public method to show the output
     *
     * @param string $input input 
     * @param string $stream input stream type
     */ 
    function show($input, $stream) {
    
        switch ($stream) {
        
            case 'file':
                
                if (!($this->input = @file_get_contents($input))) {
                
                    $this->setError(0);
                    
                    return false;
                
                }
                
                echo $this->process();
                
                $this->clean();
                
                return true;
                
                break;
                
            case 'string':
            
                if (strlen($input) == 0) {
                
                    $this->setError(1);
                    
                    return false;
                
                }
                
                echo $this->process();
                
                $this->clean();

                return true;
            
                break;
        
        }
        
        $this->setError(2);
        
        return false;
    
    }
    
    /**
     *
     * Method to set an error message onto the error buffer.
     */ 
    function setError($id) {
    
        if (isset($this->errors[$id])) {
        
            $this->errorBuffer[] = $id;
            
            return true;
        
        }
        
        return false;
    
    }
    
    /**
     *
     * Method to get raw input
     */
    function getInput() {
    
        return $this->input;
    
    }
    
    /**
     *
     * Method to alter input dynamicaly.
     */
    function setInput($input) {
    
        $this->input = $input;
    
    }
    
    /**
     *
     * Method to unset some unneeded variables
     *
     * @return bool
     */
    function clean() {
    
        unset($this->input, $this->errorBuffer);
        
        return true;
    
    }
    
    /**
     *
     * Method to return the error buffer
     *
     * @return array
     */
    function getErrors() {
    
        return $this->errorBuffer;
    
    }

}

?>