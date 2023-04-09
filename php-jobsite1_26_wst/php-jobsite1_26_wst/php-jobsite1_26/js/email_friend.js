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

function check_friendform() {
        var error = 0;
        var error_message = "<?php echo eregi_replace("\"","\\\"",JS_ERROR);?>";

        var jname = document.sendjob.jname.value;
        var jemail = document.sendjob.jemail.value;
        var jmessage = document.sendjob.jmessage.value;
        var fname = document.sendjob.fname.value;
        var femail = document.sendjob.femail.value;

        //Validation for visitor name
        if (jname == "") {
                error_message = error_message + "<?php echo eregi_replace("\"","\\\"",JNAME_ERROR);?>\n";
                error = 1;
        }

        //Validation for visitor EMAIL
        if (jemail == "" || (isEmail(document.sendjob.jemail.value) == 1)) {
                error_message = error_message + "<?php echo eregi_replace("\"","\\\"",JEMAIL_ERROR);?>\n";
                error = 1;
        }

        //Validation for friend name
        if (fname == "") {
                error_message = error_message + "<?php echo eregi_replace("\"","\\\"",FNAME_ERROR);?>\n";
                error = 1;
        }

        //Validation for friend EMAIL
        if (jemail == "" || (isEmail(document.sendjob.femail.value) == 1)) {
                error_message = error_message + "<?php echo eregi_replace("\"","\\\"",FEMAIL_ERROR);?>\n";
                error = 1;
        }

        //Validation for visitor message
        if (jmessage == "") {
                error_message = error_message + "<?php echo eregi_replace("\"","\\\"",JMESSAGE_ERROR);?>\n";
                error = 1;
        }

        if (error == 1) {
                alert(error_message);
                return false;
        } else {
                return true;
        }
}