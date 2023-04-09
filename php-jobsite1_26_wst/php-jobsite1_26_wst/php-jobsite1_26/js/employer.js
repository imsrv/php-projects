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

        var description = document.frmJob.description.value;
        var jobtitle = document.frmJob.jobtitle.value;
        var salary =  document.frmJob.salary.value;
        var jobtype =  document.frmJob["jobtypeids[]"];

        //Validation for TITLE
        if (jobtitle == "" ) {
                error_message = error_message + "<?php echo eregi_replace("\"","\\\"",JOBTITLE_ERROR);?>\n";
                error = 1;
        }

        //Validation for DESCRIPTION
        if (description == "" || description.length < <?php echo ENTRY_DESCRIPTION_MIN_LENGTH;?>) {
                error_message = error_message + "<?php echo eregi_replace("\"","\\\"",DESCRIPTION_ERROR);?>\n";
                error = 1;
        }

        //Validation for salary range
        ret=isNum(document.frmJob.salary.value);
        if (ret==1)
        {
                error_message = error_message + "<?php echo eregi_replace("\"","\\\"",SALARY_ERROR);?>\n";
                error = 1;
        }
        
        var j_sel = 0;
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