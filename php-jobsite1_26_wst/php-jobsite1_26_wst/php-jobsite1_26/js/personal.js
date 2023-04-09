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
   if (val.indexOf ('@',0) == -1 ||
       val.indexOf ('.',0) == -1)
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

function isPhone(str)
   {
   // Return false if characters are not '0-9' or '.' .
   for (var i = 0; i < str.length; i++)
      {
      var ch = str.substring(i, i + 1);
      if ((ch < "0" || "9" < ch) && ch != ' ' && ch != '+' && ch != '-' && ch !=')' && ch !='(')
         {
         return 1;
         }
      }
   return 0;
  }

function check_form() {
  var error = 0;
  var error_message = "<?php echo eregi_replace("\"","\\\"",JS_ERROR);?>";

 var password = document.frmPerson.password.value;
 var confpassword = document.frmPerson.confpassword.value;
 var jname = document.frmPerson.jname.value;
 var address = document.frmPerson.address.value;
 var phone = document.frmPerson.phone.value;
 <?php if (ENTRY_BIRTHYEAR_LENGTH!=0) {?>
 var birthyear = document.frmPerson.birthyear.value;
 <?php }?>
 var email = document.frmPerson.email.value;
 var postalcode = document.frmPerson.postalcode.value;
 var city = document.frmPerson.city.value;
 var agree = document.frmPerson.agree;

   //Validation for PASSWORD
   if (password == "" || password.length < <?php echo ENTRY_PASSWORD_MIN_LENGTH;?>) {
    error_message = error_message + "<?php echo eregi_replace("\"","\\\"",PASSWORD_ERROR);?>\n";
    error = 1;
   }
   //Validation for RETYPE_PASSWORD
   if (confpassword == "" || confpassword.length < <?php echo ENTRY_PASSWORD_MIN_LENGTH;?>) {
    error_message = error_message + "<?php echo eregi_replace("\"","\\\"",CONFPASSWORD_ERROR);?>\n";
    error = 1;
   }
   if (document.frmPerson.password.value!=document.frmPerson.confpassword.value) {
    error_message = error_message + "<?php echo eregi_replace("\"","\\\"",CONFPASSWORD_ERROR);?>\n";
    error = 1;
   }
   //Validation for NAME
   if (jname == "" || jname.length < <?php echo ENTRY_NAME_MIN_LENGTH;?>) {
    error_message = error_message + "<?php echo eregi_replace("\"","\\\"",NAME_ERROR);?>\n";
    error = 1;
   }
   //Validation for EMAIL
   if (email == "" || email.length < <?php echo ENTRY_EMAIL_MIN_LENGTH;?> || isEmail(document.frmPerson.email.value)==1) {
    error_message = error_message + "<?php echo eregi_replace("\"","\\\"",EMAIL_ERROR);?>\n";
    error = 1;
   }
   //Validation for ADDRESS
   if (address == "" || address.length < <?php echo ENTRY_ADDRESS_MIN_LENGTH;?>) {
    error_message = error_message + "<?php echo eregi_replace("\"","\\\"",ADDRESS_ERROR);?>\n";
    error = 1;
   }
   //Validation for   TELEPHONE
   if (phone == "" || phone.length < <?php echo ENTRY_PHONE_MIN_LENGTH;?> || isPhone(document.frmPerson.phone.value)==1) {
    error_message = error_message + "<?php echo eregi_replace("\"","\\\"",PHONE_ERROR);?>\n";
    error = 1;
   }
   <?php if (ENTRY_BIRTHYEAR_LENGTH!=0) {?>
   //Validation for BIRTHYEAR
   if (birthyear == "" || birthyear.length < <?php echo ENTRY_BIRTHYEAR_LENGTH;?> || birthyear.length > <?php echo ENTRY_BIRTHYEAR_LENGTH;?> || isNum(document.frmPerson.birthyear.value==1)) {
    error_message = error_message + "<?php echo eregi_replace("\"","\\\"",BIRTH_YEAR_ERROR);?>\n";
    error = 1;
   }
   <?php }?>
   //Validation for POSTALCODE
   if (postalcode == "" || postalcode.length < <?php echo ENTRY_POSTALCODE_MIN_LENGTH;?>) {
    error_message = error_message + "<?php echo eregi_replace("\"","\\\"",POSTALCODE_ERROR);?>\n";
    error = 1;
   }
   //Validation for CITY
   if (city == "" || city.length < <?php echo ENTRY_CITY_MIN_LENGTH;?>) {
    error_message = error_message + "<?php echo eregi_replace("\"","\\\"",CITY_ERROR);?>\n";
    error = 1;
   }
   //Validation for TERMS AND CONDITIONS
   if ( (!agree.checked) && agree.value!="yes" ) {
        error_message = error_message + "<?php echo eregi_replace("\"","\\\"",TERMS_ERROR);?>\n";
        error = 1;
   }

  if (error == 1) {
    alert(error_message);
    return false;
  } else {
    return true;
  }
}