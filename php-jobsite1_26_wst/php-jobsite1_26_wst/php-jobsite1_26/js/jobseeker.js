function isSTR(val){
        var str = val;
        // Return false if characters are not a-z, A-Z, or a space.
        for (var i = 0; i < str.length; i++){
                var ch = str.substring(i, i + 1);
                if (((ch < "a" || "z" < ch) && (ch < "A" || "Z" < ch)) && ch != ' '){
                return 1;
                }
        }
        return 0;
}
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

function isNum(str)
{
        // Return false if characters are not '0-9' or '.' .
        for (var i = 0; i < str.length; i++)
        {
                var ch = str.substring(i, i + 1);
                if ((ch < "0" || "9" < ch) && ch != '.' && ch != '-')
                {
                        return 1;
                }
        }
        return 0;
}

function check_form() {
        var error = 0;
        var error_message = "<?php echo eregi_replace("\"","\\\"",JS_ERROR);?>";

        var summary = document.frm.summary.value;
        var salary = document.frm.salary.value;
        var expyears = document.frm.experience.value;
        var jobcategory =  document.frm["jobcategoryids[]"];
        var jobtype =  document.frm["jobtypeids[]"];

        //Validation for SUMARY
        if (summary == "" || summary.length < <?php echo ENTRY_SUMMARY_MIN_LENGTH;?>) {
                error_message = error_message + "<?php echo eregi_replace("\"","\\\"",SUMMARY_ERROR);?>\n";
                error = 1;
        }
        //Validation for SALARY RANGE
        if (isNum(salary)==1) {
                error_message = error_message + "<?php echo eregi_replace("\"","\\\"",SALARY_ERROR);?>\n";
                error = 1;
        }

        //Validation for EXPYEARS
        if (isNum(expyears)==1) {
                error_message = error_message + "<?php echo eregi_replace("\"","\\\"",EXPYEARS_ERROR);?>\n";
                error = 1;
        }
        
        var j_sel = 0;
        //Validation for resume_categories
        for (i=0; i<jobcategory.length; i++) {
            if(jobcategory[i].selected) {
                j_sel = 1;
            }
        }
        
        if (j_sel==0)
        {
                error_message = error_message + "<?php echo eregi_replace("\"","\\\"",JOBCATEGORY_ERRROR);?>\n";
                error = 1;
        }
        
        j_sel = 0;
        //Validation for jotypes
        for (i=0; i<jobtype.length; i++) {
            if(jobtype[i].selected) {
                j_sel = 1;
            }
        }
        
        if (j_sel==0)
        {
                error_message = error_message + "<?php echo eregi_replace("\"","\\\"",EMPLOYMENT_ERROR);?>\n";
                error = 1;
        }
        
        if (error == 1) {
                alert(error_message);
                return false;
        } else {
                return true;
        }
}