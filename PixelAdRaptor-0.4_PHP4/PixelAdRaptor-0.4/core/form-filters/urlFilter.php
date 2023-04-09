<?php
class urlFilter {

    /**
     *
     * A constructor
     */
    function urlFilter() {
    
    }
    
    /**
     *
     * A validation method, it must have the same name and the same parameters,
     * the code inside is modified according to the needs.
     *
     * @param string $field form field name
     * @param string $method method to transfer data
     */
    function validate($field, $params, $method) {
        
        if (eregi('^(http|https)+(:\/\/)+[a-z0-9_-]+\.+[a-z0-9_-]', $method[$field])) {
   
            return true;
            
        }
                
        return false;  
    
    }
}
?>