function isNum(str)
{
        // Return false if characters are not '0-9'
        for (var i = 0; i < str.length; i++)
        {
        var ch = str.substring(i, i + 1);
        if ((ch < "0" || "9" < ch) && ch !='.')
                {
                return 1;
                }
        }
        return 0;
}

function check_form() {
        var error = 0;
        var error_message = "<?php echo eregi_replace("\"","\\\"",JS_ERROR);?>";

        var sal_min =  document.search_res.bx_minsalary.value;
        var sal_max =  document.search_res.bx_maxsalary.value;


        //Validation for salary range
        ret=isNum(document.search_res.bx_minsalary.value);
        if (ret==1)
        {
                error_message = error_message + "<?php echo eregi_replace("\"","\\\"",SALARY_ERROR);?>\n";
                error = 1;
        }

        ret=isNum(document.search_res.bx_maxsalary.value);
        if (ret==1)
        {
                error_message = error_message + "<?php echo eregi_replace("\"","\\\"",SALARY_ERROR);?>\n";
                error = 1;
        }

        if (error == 1) {
                alert(error_message);
                return false;
        } else {
                return true;
        }
}
function check_search_job_form() {
        var error = 0;
        var error_message = "<?php echo eregi_replace("\"","\\\"",JS_ERROR);?>";

        var sal_min =  document.searchj.bx_minsalary.value;
        var sal_max =  document.searchj.bx_maxsalary.value;

        //Validation for salary range
        ret=isNum(document.searchj.bx_minsalary.value);
        if (ret==1)
        {
                error_message = error_message + "<?php echo eregi_replace("\"","\\\"",SALARY_ERROR);?>\n";
                error = 1;
        }

        ret=isNum(document.searchj.bx_maxsalary.value);
        if (ret==1)
        {
                error_message = error_message + "<?php echo eregi_replace("\"","\\\"",SALARY_ERROR);?>\n";
                error = 1;
        }
        if (error == 1) {
                alert(error_message);
                return false;
        } else {
                return true;
        }
}