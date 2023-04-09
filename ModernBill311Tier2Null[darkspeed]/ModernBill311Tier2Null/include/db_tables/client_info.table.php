<?php
// +----------------------------------------------------------------------+
// | ModernBill [TM] .:. Client Billing System                            |
// +----------------------------------------------------------------------+
// | Copyright (c) 2001-2002 ModernGigabyte, LLC                          |
// +----------------------------------------------------------------------+
// | This source file is subject to the ModernBill End User License       |
// | Agreement (EULA), that is bundled with this package in the file      |
// | LICENSE, and is available at through the world-wide-web at           |
// | http://www.modernbill.com/extranet/LICENSE.txt                       |
// | If you did not receive a copy of the ModernBill license and are      |
// | unable to obtain it through the world-wide-web, please send a note   |
// | to license@modernbill.com so we can email you a copy immediately.    |
// +----------------------------------------------------------------------+
// | Authors: ModernGigabyte, LLC <info@moderngigabyte.com>               |
// | Support: http://www.modernsupport.com/modernbill/                    |
// +----------------------------------------------------------------------+
// | ModernGigabyte and ModernBill are trademarks of ModernGigabyte, LLC. |
// +----------------------------------------------------------------------+

 /* ----------------- CLIENT_INFO ---------------------*/
      $title        = CLIENTS;
      $children     = array("client_invoice","client_package","domain_names","client_credit","account_details","event_log");
      $details_link = "client_details";
      $args = array(array("column"         => "client_id",
                           "required"      => 0,
                           "title"         => ID,
                           "type"          => "HIDDEN"),
                    array("type"           => "HEADERROW",
                           "title"         => CLIENTINFO),
                    array("column"         => "client_fname",
                           "required"      => 1,
                           "title"         => FIRSTNAME,
                           "type"          => "TEXT",
                           "size"          => 15,
                           "maxlength"     => 255),
                    array("column"         => "client_lname",
                           "required"      => 1,
                           "title"         => LASTNAME,
                           "type"          => "TEXT",
                           "size"          => 15,
                           "maxlength"     => 255),
                    array("column"         => "secondary_contact",
                           "required"      => 0,
                           "title"         => SECONDARYCONTACT,
                           "type"          => "TEXT",
                           "size"          => 40,
                           "maxlength"     => 255),
                    array("column"         => "client_email",
                           "required"      => 0,
                           "title"         => EMAIL,
                           "type"          => "TEXT",
                           "size"          => 40,
                           "maxlength"     => 80),
                    array("column"         => "client_secondary_email",
                           "required"      => 0,
                           "title"         => SECONDARYEMAIL,
                           "type"          => "TEXT",
                           "size"          => 40,
                           "maxlength"     => 80),
                    array("column"         => "client_company",
                           "required"      => 0,
                           "title"         => COMPANY,
                           "type"          => "TEXT",
                           "size"          => 25,
                           "maxlength"     => 100,
                           "append"        => "(".COMPORDOM.")"),
                    array("column"         => "client_address",
                           "required"      => 1,
                           "title"         => ADDRESS." 1",
                           "type"          => "TEXT",
                           "size"          => 40,
                           "maxlength"     => 80),
                    array("column"         => "client_address_2",
                           "required"      => 0,
                           "title"         => ADDRESS." 2",
                           "type"          => "TEXT",
                           "size"          => 40,
                           "maxlength"     => 80,
                           "no_details"    => 1),
                    array("column"         => "client_city",
                           "required"      => 1,
                           "title"         => CITY,
                           "type"          => "TEXT",
                           "size"          => 40,
                           "maxlength"     => 80),
                    array("column"         => "client_state",
                           "required"      => 0,
                           "title"         => STATEREGION,
                           "type"          => "TEXT",
                           "size"          => 30,
                           "maxlength"     => 40,
                           "append"        => STATEEXAMPLE),
                    array("column"         => "client_zip",
                           "required"      => 1,
                           "title"         => ZIP,
                           "type"          => "TEXT",
                           "size"          => 10,
                           "maxlength"     => 10,
                           "append"        => "(".ZIPFORMAT.")"),
                    array("column"         => "client_country",
                           "required"      => 1,
                           "title"         => COUNTRY,
                           "type"          => "TEXT",
                           "size"          => 10,
                           "maxlength"     => 255,
                           "default_value" => "US",
                           "append"        => COUNTRYEXAMPLE),
                    array("column"         => "client_phone1",
                           "required"      => 1,
                           "title"         => PHONE,
                           "type"          => "TEXT",
                           "size"          => 15,
                           "maxlength"     => 15,
                           "append"        => "(".PHONEFORMAT.")"),
                    array("column"         => "client_phone2",
                           "required"      => 0,
                           "title"         => FAX,
                           "type"          => "TEXT",
                           "size"          => 15,
                           "maxlength"     => 15,
                           "append"        => "(".PHONEFORMAT.")"),
                    array("type"           => "HEADERROW",
                           "admin_only"    => 1,
                           "title"         => BILLINGINFO),
                    array("column"         => "billing_method",
                           "required"      => 0,
                           "no_edit"       => 0,
                           "admin_only"    => 1,
                           "title"         => BILLINGMETHOD,
                           "type"          => "FUNCTION_CALL",
                           "function_call" => billing_method_select_box($billing_method)),
                    array("column"         => "billing_cc_type",
                           "required"      => 0,
                           "no_add"        => 1,
                           "no_edit"       => 1,
                           "title"         => CCNUM,
                           "type"          => "TEXT"),
                    array("column"         => "billing_cc_num",
                           "required"      => 0,
                           "title"         => CCNUM,
                           "no_edit"       => 1,
                           "no_details"    => 1,
                           "type"          => "TEXT",
                           "size"          => 16,
                           "maxlength"     => 16,
                           "append"        => $we_accept),
                    array("column"         => "billing_cc_exp",
                           "required"      => 0,
                           "no_edit"       => 1,
                           "title"         => EXPIRATIONDATE2,
                           "type"          => "TEXT",
                           "size"          => 6,
                           "maxlength"     => 7,
                           "append"        => DATEFORMAT),
                    array("column"         => "x_Bank_Name",
                           "required"      => 0,
                           "no_add"        => 1,
                           "no_edit"       => 1,
                           "no_details"    => 1,
                           "title"         => BANKNAME,
                           "type"          => "TEXT",
                           "size"          => 40,
                           "maxlength"     => 255),
                    array("column"         => "x_Bank_ABA_Code",
                           "required"      => 0,
                           "no_add"        => 1,
                           "no_edit"       => 1,
                           "no_details"    => 1,
                           "title"         => BANKABACODE,
                           "type"          => "TEXT",
                           "size"          => 40,
                           "maxlength"     => 255),
                    array("column"         => "x_Bank_Acct_Num",
                           "required"      => 0,
                           "no_add"        => 1,
                           "no_edit"       => 1,
                           "no_details"    => 1,
                           "title"         => BANKACCOUNTNUM,
                           "type"          => "TEXT",
                           "size"          => 40,
                           "maxlength"     => 255),
                    array("column"         => "x_Drivers_License_Num",
                           "required"      => 0,
                           "no_add"        => 1,
                           "no_edit"       => 1,
                           "no_details"    => 1,
                           "title"         => LICENSENUM,
                           "type"          => "TEXT",
                           "size"          => 40,
                           "maxlength"     => 255),
                    array("column"         => "x_Drivers_License_State",
                           "required"      => 0,
                           "no_add"        => 1,
                           "no_edit"       => 1,
                           "no_details"    => 1,
                           "title"         => LICENSESTATE,
                           "type"          => "TEXT",
                           "size"          => 40,
                           "maxlength"     => 255),
                    array("column"         => "x_Drivers_License_DOB",
                           "required"      => 0,
                           "no_add"        => 1,
                           "no_edit"       => 1,
                           "no_details"    => 1,
                           "title"         => LICENSEDOB,
                           "type"          => "TEXT",
                           "size"          => 40,
                           "maxlength"     => 255),
                   /* array("column"         => "billing_cc_code",
                           "required"      => 0,
                           "no_edit"       => 1,
                           "no_add"        => 1,
                           "title"         => "CVV2/CVC2",
                           "type"          => "TEXT",
                           "size"          => 4,
                           "maxlength"     => 3,
                           "append"        => THREEDIGIT), */
                    array("type"           => "HEADERROW",
                           "admin_only"    => 1,
                           "no_edit"       => 1,
                           "title"         => LOGININFO),
                    array("column"         => "client_password",
                           "required"      => 0,
                           "no_edit"       => 1,
                           "no_details"    => 1,
                           "title"         => NEWPW,
                           "type"          => "TEXT",
                           "size"          => 15,
                           "maxlength"     => 15,
                           "append"        => PWFORMAT),
                    array("column"         => "client_password2",
                           "required"      => 0,
                           "no_edit"       => 1,
                           "no_details"    => 1,
                           "title"         => VERIFYPW,
                           "type"          => "TEXT",
                           "size"          => 15,
                           "maxlength"     => 15),
                    array("column"         => "client_username",
                           "required"      => 0,
                           "no_add"        => 1,
                           "admin_only"    => 1,
                           "no_edit"       => 1,
                           "no_details"    => 1,
                           "title"         => USERNAME,
                           "type"          => "TEXT",
                           "size"          => 15,
                           "maxlength"     => 255),
                    array("column"         => "client_real_pass",
                           "required"      => 0,
                           "no_edit"       => 1,
                           "admin_only"    => 1,
                           "title"         => RAWPASSWORD,
                           "type"          => "TEXT",
                           "size"          => 15,
                           "maxlength"     => 255),
                    array("type"           => "HEADERROW",
                           "title"         => OTHERINFO,
                           "admin_only"    => 1),
                    array("column"         => "apply_tax",
                           "required"      => 0,
                           "no_add"        => 1,
                           "admin_only"    => 1,
                           "no_edit"       => 1,
                           "no_details"    => 1,
                           "title"         => APPLYTAX,
                           "type"          => "FUNCTION_CALL",
                           "function_call" => true_false_radio("apply_tax",$apply_tax)),
                    array("column"         => "default_currency",
                           "required"      => 0,
                           "no_add"        => 1,
                           "no_edit"       => 1,
                           "no_details"    => 1,
                           "title"         => DEFAULTCURRENCY,
                           "type"          => "TEXT",
                           "size"          => 10,
                           "maxlength"     => 255),
                    array("column"         => "default_translation",
                           "required"      => 0,
                           "no_add"        => 1,
                           "no_edit"       => 1,
                           "no_details"    => 1,
                           "title"         => DEFAULTTRANSLATION,
                           "type"          => "FUNCTION_CALL",
                           "function_call" => language_select_box(Rdefault_translation,"default_translation")),
                    array("column"         => "send_email_type",
                           "required"      => 0,
                           "no_add"        => 1,
                           "no_edit"       => 1,
                           "no_details"    => 1,
                           "title"         => DEFAULTEMAILSTYPE,
                           "type"          => "TEXT",
                           "size"          => 10,
                           "maxlength"     => 255),
                    array("column"         => "client_comments",
                           "required"      => 0,
                           "title"         => COMMENTS,
                           "admin_only"    => 1,
                           "type"          => "TEXTAREA",
                           "rows"          => $textarea_rows,
                           "cols"          => $textarea_cols,
                           "wrap"          => $textarea_wrap),
                    array("column"         => "encryption_key",
                           "required"      => 0,
                           "no_edit"       => 1,
                           "no_details"    => 1,
                           "title"         => ENCRYPTIONKEY,
                           "type"          => "TEXTAREA",
                           "rows"          => $textarea_rows,
                           "cols"          => $textarea_cols,
                           "wrap"          => $textarea_wrap),
                    array("column"         => "client_status",
                           "required"      => 0,
                           "title"         => STATUS,
                           "admin_only"    => 1,
                           "type"          => "FUNCTION_CALL",
                           "function_call" => status_select_box($client_status,"client_status")),
                    array("column"         => "client_stamp",
                           "required"      => 0,
                           "no_add"        => 1,
                           "no_edit"       => 1,
                           "title"         => TIMESTAMP,
                           "type"          => "FUNCTION_CALL",
                           "function_call" => date_input_generator($client_stamp,"client_stamp")));

include($DIR."include/config/config.client_extras.php");
for($ic=1;$ic<=10;$ic++)
{
   if (${"client_field_active_$ic"})
   {
     array_push ($args, array("column"       => "client_field_$ic",
                               "required"      => ${"client_field_required_$ic"},
                               "title"         => ${"client_field_title_$ic"},
                               "type"          => ${"client_field_type_$ic"},
                               "size"          => ${"client_field_size_$ic"},
                               "maxlength"     => ${"client_field_maxlength_$ic"},
                               "admin_only"    => ${"client_field_admin_only_$ic"},
                               "append"        => ${"client_field_append_$ic"},
                               "default_value" => ${"client_field_append_$ic"}));
   }
}

     // Additional Validation for New Clients
     if ($submit&&!$client_id&&$do=="add")
     {
        GLOBAL $data;
        $client_address=($client_address_2) ? $client_address."\n".$client_address_2 : $client_address ;
        ## THESE ARE US SPECIFIC VALIDATIONS, UNCOMMENT FOR US ONLY VERSION
        //if (!ereg("([0-9]{5})",$client_zip)) $oops .= "[".ERROR."] ".ZIPINVALID."<br>";
        //if (!ereg("([0-9]{3})-([0-9]{3})-([0-9]{4})",$client_phone1)) $oops .= "[".ERROR."] ".PHONEINVALID."<br>";
        //if ($client_phone2&&!ereg("([0-9]{3})-([0-9]{3})-([0-9]{4})",$client_phone2)) $oops .= "[".ERROR."] ".FAXINVALID."<br>";
        $password_length = ($password_length) ? $password_length : 6 ;
        if (strlen(strval($client_password))<$password_length) { $oops .= "[".ERROR."] ".NEWPWSHORT."<br>"; }
        if ($client_password!=$client_password2) { $oops .= "[".ERROR."] ".NEWPWMATCH."<br>"; }
        if (!is_valid_email(strtolower(trim($client_email)))) { $oops .= "[".ERROR."] ".EMAILINVALID."<br>"; }
        if ($billing_method==1)
        {
           if (!ereg("([0-9]{2})/([0-9]{4})",$billing_cc_exp)) { $oops .= "[".ERROR."] ".EXPIRESINVALID."<br>"; }

           $billing_cc_type=validate_cc_input($billing_cc_num,$client_id);

           if ($billing_cc_type&&$data)
           {
              $this_client_stamp = ($client_stamp) ? $client_stamp : mktime() ;
              $new_data = ($store_cc_in_db=="agree") ? $data : "5400000000000005" ;
              if($signup_form)
                $data=encrpyt($this_client_stamp,$new_data);
              else
                $data=encrpyt($this_client_stamp.md5($encryption_key),$new_data);
           }
           else
           {
              $oops .= "[".ERROR."] ".CCNUMINVALID."<br>";
           }
           if (!$billing_cc_exp) $oops .= "[".REQUIRED."] ".EXPIRATIONDATE2."<br>";
        }
     }
     elseif ($submit&&$do=="edit")
     {
        $client_address=($client_address_2) ? $client_address."\n".$client_address_2 : $client_address ;
        if (!is_valid_email(strtolower(trim($client_email)))) $oops.= "[".ERROR."] ".EMAILINVALID."<br>";
        ## THESE ARE US SPECIFIC VALIDATIONS, UNCOMMENT FOR US ONLY VERSION
        //if (!ereg("([0-9]{5})",$client_zip)) $oops .= "[".ERROR."] ".ZIPINVALID."<br>";
        //if (!ereg("([0-9]{3})-([0-9]{3})-([0-9]{4})",$client_phone1)) $oops .= "[".ERROR."] ".PHONEINVALID."<br>";
        //if ($client_phone2&&!ereg("([0-9]{3})-([0-9]{3})-([0-9]{4})",$client_phone2)) $oops .= "[".ERROR."] ".FAXINVALID."<br>";
      }

      $billing_cc_code = "xxx";
      $select_sql = "SELECT client_id, client_fname, client_lname, client_email, client_company, client_phone1, client_status FROM $db_table ";
      $insert_sql = "INSERT INTO $db_table (client_id,
                                            client_fname,
                                            client_lname,
                                            client_email,
                                            client_company,
                                            client_address,
                                            client_city,
                                            client_state,
                                            client_zip,
                                            client_country,
                                            client_phone1,
                                            client_phone2,
                                            billing_method,
                                            billing_cc_type,
                                            billing_cc_num,
                                            billing_cc_exp,
                                            billing_cc_code,
                                            client_password,
                                            client_comments,
                                            client_status,
                                            client_stamp,
                                            client_secondary_email,
                                            client_username,
                                            client_real_pass,
                                            x_Bank_Name,
                                            x_Bank_ABA_Code,
                                            x_Bank_Acct_Num,
                                            x_Drivers_License_Num,
                                            x_Drivers_License_State,
                                            x_Drivers_License_DOB,
                                            apply_tax,
                                            default_translation,
                                            default_currency,
                                            send_email_type,
                                            secondary_contact,
                                            client_field_1,
                                            client_field_2,
                                            client_field_3,
                                            client_field_4,
                                            client_field_5,
                                            client_field_6,
                                            client_field_7,
                                            client_field_8,
                                            client_field_9,
                                            client_field_10) VALUES (NULL,
                                                                  '".ucfirst($client_fname)."',
                                                                  '".ucfirst($client_lname)."',
                                                                  '".strtolower(trim($client_email))."',
                                                                  '$client_company',
                                                                  '".ucwords($client_address)."',
                                                                  '".ucfirst($client_city)."',
                                                                  '".strtoupper($client_state)."',
                                                                  '$client_zip',
                                                                  '".strtoupper($client_country)."',
                                                                  '$client_phone1',
                                                                  '$client_phone2',
                                                                  '$billing_method',
                                                                  '$billing_cc_type',
                                                                  '$data',
                                                                  '$billing_cc_exp',
                                                                  '$billing_cc_code',
                                                                  '".md5($client_password)."',
                                                                  '$client_comments',
                                                                  '$client_status',
                                                                  '$this_client_stamp',
                                                                  '$client_secondary_email',
                                                                  '$client_username',
                                                                  '$client_real_pass',
                                                                  '$x_Bank_Name',
                                                                  '$x_Bank_ABA_Code',
                                                                  '$x_Bank_Acct_Num',
                                                                  '$x_Drivers_License_Num',
                                                                  '$x_Drivers_License_State',
                                                                  '$x_Drivers_License_DOB',
                                                                  '$apply_tax',
                                                                  '$default_translation',
                                                                  '$default_currency',
                                                                  '$send_email_type',
                                                                  '$secondary_contact',
                                                                  '$client_field_1',
                                                                  '$client_field_2',
                                                                  '$client_field_3',
                                                                  '$client_field_4',
                                                                  '$client_field_5',
                                                                  '$client_field_6',
                                                                  '$client_field_7',
                                                                  '$client_field_8',
                                                                  '$client_field_9',
                                                                  '$client_field_10')";

      $update_sql = "UPDATE $db_table SET client_fname='".ucfirst($client_fname)."',
                                          client_lname='".ucfirst($client_lname)."',
                                          client_email='".strtolower(trim($client_email))."',
                                          client_company='$client_company',
                                          client_address='".ucwords($client_address)."',
                                          client_city='".ucfirst($client_city)."',
                                          client_state='".strtoupper($client_state)."',
                                          client_zip='$client_zip',
                                          client_country='".strtoupper($client_country)."',
                                          client_phone1='$client_phone1',
                                          client_phone2='$client_phone2',
                                          billing_method='$billing_method',
                                          client_comments='$client_comments',
                                          client_status='$client_status',
                                          client_secondary_email='$client_secondary_email',
                                          apply_tax='$apply_tax',
                                          default_translation='$default_translation',
                                          default_currency='$default_currency',
                                          send_email_type='$send_email_type',
                                          secondary_contact='$secondary_contact',
                                          client_field_1='$client_field_1',
                                          client_field_2='$client_field_2',
                                          client_field_3='$client_field_3',
                                          client_field_4='$client_field_4',
                                          client_field_5='$client_field_5',
                                          client_field_6='$client_field_6',
                                          client_field_7='$client_field_7',
                                          client_field_8='$client_field_8',
                                          client_field_9='$client_field_9',
                                          client_field_10='$client_field_10' WHERE client_id='$client_id'";

$client_update_sql = "UPDATE $db_table SET client_fname='".ucfirst($client_fname)."',
                                          client_lname='".ucfirst($client_lname)."',
                                          client_email='".strtolower(trim($client_email))."',
                                          client_company='$client_company',
                                          client_address='".ucwords($client_address)."',
                                          client_city='".ucfirst($client_city)."',
                                          client_state='".strtoupper($client_state)."',
                                          client_zip='$client_zip',
                                          client_country='".strtoupper($client_country)."',
                                          client_phone1='$client_phone1',
                                          client_phone2='$client_phone2' WHERE client_id='$client_id'";

      $delete_sql = array("DELETE FROM client_info WHERE client_id='$client_id'",
                          "DELETE FROM client_credit WHERE client_id='$client_id'",
                          "DELETE FROM client_invoice WHERE client_id='$client_id'",
                          "DELETE FROM client_package WHERE client_id='$client_id'",
                          "DELETE FROM event_log WHERE client_id='$client_id'",
                          "DELETE FROM domain_names WHERE client_id='$client_id'",
                          "DELETE FROM account_details WHERE client_id='$client_id'",
                          "DELETE FROM account_pops WHERE client_id='$client_id'",
                          "DELETE FROM account_dbs WHERE client_id='$client_id'",
                          "DELETE FROM authnet_batch WHERE x_Cust_ID='$client_id'",
                          "DELETE FROM affiliate_config WHERE client_id='$client_id'",
                          "DELETE FROM client_register WHERE client_id='$client_id'",
                          "DELETE FROM affiliate_config WHERE client_id='$client_id'");
?>