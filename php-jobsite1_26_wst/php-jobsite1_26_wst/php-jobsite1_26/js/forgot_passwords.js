function isEmail(val)
{
        // Return false if e-mail field does not contain a '@' and '.' .
        if (val.indexOf ('@',0) == -1 || val.indexOf ('.',0) == -1)
        {
                return 1;
        }
        else
        {
                return 0;
        }
}

function check_form(bx_input) {
        var error = 0;
        var error_message = "<?php echo eregi_replace("\"","\\\"",JS_ERROR);?>";

        var email = bx_input.value;

        //Validation for EMAIL
        if (email == "" || (isEmail(bx_input.value)==1)) {
                error_message = error_message + "<?php echo eregi_replace("\"","\\\"",EMAIL_ERROR);?>\n";
                error = 1;
        }

        if (error == 1) {
                alert(error_message);
                return false;
        } else {
                return true;
        }
}