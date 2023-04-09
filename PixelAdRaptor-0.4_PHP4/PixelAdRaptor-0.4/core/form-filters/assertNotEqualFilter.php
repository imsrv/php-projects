<?php
/** 
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

class assertNotEqualFilter {

    /**
     *
     * A constructor
     */
    function assertNotEqualFilter() {
    
    }
    
    /**
     *
     * A validation method, it must have the same name and the same parameters,
     * the code inside is modified according to the needs.
     *
     * @param string $field form field name
     * @param mixed $param value to compare with
     * @param string $method method to transfer data
     */
    function validate($field, $param, $method) {
        
        if ($method[$field] != $param) {
   
            return true;
            
        }
                
        return false;  
    
    }
}
?>