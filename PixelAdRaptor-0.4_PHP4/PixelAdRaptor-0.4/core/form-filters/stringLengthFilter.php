<?php

class stringLengthFilter {

    /**
     *
     * A constructor
     */
    function stringLengthFilter() {
    
    }
    
    /**
     *
     * A validation method, it must have the same name and the same parameters,
     * the code inside is modified according to the needs.
     *
     * @param string $field form field name
     * @param array $params array with parameters
     * @param int $params[0] minimum string length
     * @param int $params[1] maximum string length
     * @param string $method method to transfer data
     */
    function validate($field, $params, $method) {
        
        if (strlen($method[$field]) < $params[0] || strlen($method[$field]) > $params[1]) {
            
            return false;
          
        }
        
        return true;  
    
    }
}
?>