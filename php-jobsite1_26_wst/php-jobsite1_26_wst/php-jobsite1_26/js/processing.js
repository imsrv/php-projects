function isNum(str)
{
        // Return false if characters are not '0-9'
        for (var i = 0; i < str.length; i++)
        {
        var ch = str.substring(i, i + 1);
        if (ch < "0" || "9" < ch)
                {
                return 1;
                }
        }
        return 0;
}

function check_form() {
        var error = 0;
        var error_message = "<?php echo eregi_replace("\"","\\\"",JS_ERROR);?>";

        var jobs =  document.membership_form.jobs.value;
        var fjobs =  document.membership_form.fjobs.value;
        var resumes =  document.membership_form.resumes.value;

        //Validation for jobs field
        ret=isNum(document.membership_form.jobs.value);
        if (ret==1)
        {
                error_message = error_message + "<?php echo eregi_replace("\"","\\\"",JOBS_ERROR);?>\n";
                error = 1;
        }

        //Validation for fjobs field
        ret=isNum(document.membership_form.fjobs.value);
        if (ret==1)
        {
                error_message = error_message + "<?php echo eregi_replace("\"","\\\"",FJOBS_ERROR);?>\n";
                error = 1;
        }

        //Validation for resumes field
        ret=isNum(document.membership_form.resumes.value);
        if (ret==1)
        {
                error_message = error_message + "<?php echo eregi_replace("\"","\\\"",RESUMES_ERROR);?>\n";
                error = 1;
        }

        if (error == 1) {
                alert(error_message);
                return false;
        } else {
                return true;
        }
}