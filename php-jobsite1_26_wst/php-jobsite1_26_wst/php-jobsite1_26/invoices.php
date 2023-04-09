<?php
include ('application_config_file.php');
include(DIR_LANGUAGES.$language."/".FILENAME_INVOICES);
if ($HTTP_GET_VARS['printit']=="yes") {
    echo "<html><head><title>".TEXT_PRINT_INV_DETAILS.":".$HTTP_GET_VARS['opid']."</title>";
    echo "<SCRIPT Language=\"Javascript\">\n";
    echo "function printit(){  \n";
    echo "var navver = parseInt(navigator.appVersion);\n";
    echo "if (navver > 3) {\n";
    echo "   if (window.print) {\n";
    echo "        parent.pmain.focus();\n";
    echo "        window.print() ;\n";  
    echo "    }\n";
    echo "}\n";
    echo "}\n";
    echo "</script>\n";
    echo "</head><body>\n";
}
if ($HTTP_SESSION_VARS['employerid'])
      {
       if ($HTTP_GET_VARS['action']=="pay")
       {
          $invoice_query=bx_db_query("SELECT *,".$bx_table_prefix."_invoices.currency as icurrency from ".$bx_table_prefix."_invoices,".$bx_table_prefix."_pricing_".$bx_table_lng." where ".$bx_table_prefix."_invoices.opid='".$HTTP_GET_VARS['opid']."' and ".$bx_table_prefix."_pricing_".$bx_table_lng.".pricing_id=".$bx_table_prefix."_invoices.pricing_type");
          SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
          $invoice_result=bx_db_fetch_array($invoice_query);
          if ($invoice_result['compid']==$HTTP_SESSION_VARS['employerid']) {
              if ($HTTP_GET_VARS['printit']!="yes") {
                  include(DIR_SERVER_ROOT."header.php");
              }
              include(DIR_FORMS.FILENAME_INVOICES_FORM);
              if ($HTTP_GET_VARS['printit']!="yes") {
                  include(DIR_SERVER_ROOT."footer.php");
              }
          } //end if ($invoice_result['compid']==$HTTP_SESSION_VARS['employerid'])
          else {
               $error_message=TEXT_UNAUTHORIZED_ACCESS;
               $back_url=bx_make_url(HTTP_SERVER.FILENAME_MEMBERSHIP, "auth_sess", $bx_session);
               if ($HTTP_GET_VARS['printit']!="yes") {
                  include(DIR_SERVER_ROOT."header.php");
               }
               include(DIR_FORMS.FILENAME_ERROR_FORM);
               if ($HTTP_GET_VARS['printit']!="yes") {
                  include(DIR_SERVER_ROOT."footer.php");
               }
          }//end else ($verify_result['compid']==$HTTP_SESSION_VARS['employerid'])
       }//end if exist action==pay
       elseif ($HTTP_GET_VARS['action']=="view")
        {
          $invoice_query=bx_db_query("SELECT *,".$bx_table_prefix."_invoices.currency as icurrency from ".$bx_table_prefix."_invoices,".$bx_table_prefix."_pricing_".$bx_table_lng." where ".$bx_table_prefix."_invoices.opid='".$HTTP_GET_VARS['opid']."' and ".$bx_table_prefix."_pricing_".$bx_table_lng.".pricing_id=".$bx_table_prefix."_invoices.pricing_type");
          SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
          $invoice_result=bx_db_fetch_array($invoice_query);
          if ($invoice_result['compid']==$HTTP_SESSION_VARS['employerid'])
           {
                if ($HTTP_GET_VARS['printit']!="yes") {
                      include(DIR_SERVER_ROOT."header.php");
                }
                include(DIR_FORMS.FILENAME_INVOICES_FORM);
                if ($HTTP_GET_VARS['printit']!="yes") {
                      include(DIR_SERVER_ROOT."footer.php");
                }
           } //end if ($verify_result['compid']==$HTTP_SESSION_VARS['employerid'])
           else
           {
               $error_message=TEXT_UNAUTHORIZED_ACCESS;
               $back_url=bx_make_url(HTTP_SERVER.FILENAME_MEMBERSHIP, "auth_sess", $bx_session);
               if ($HTTP_GET_VARS['printit']!="yes") {
                      include(DIR_SERVER_ROOT."header.php");
               }
               include(DIR_FORMS.FILENAME_ERROR_FORM);
               if ($HTTP_GET_VARS['printit']!="yes") {
                      include(DIR_SERVER_ROOT."footer.php");
               }
           }//end else ($verify_result['compid']==$HTTP_SESSION_VARS['employerid'])
        } //end elseif ($HTTP_GET_VARS['action']=="view")
		elseif ($HTTP_GET_VARS['action']=="del")
        {
		  $invoice_query=bx_db_query("SELECT *,".$bx_table_prefix."_invoices.currency as icurrency from ".$bx_table_prefix."_invoices,".$bx_table_prefix."_pricing_".$bx_table_lng." where ".$bx_table_prefix."_invoices.opid='".$HTTP_GET_VARS['opid']."' and ".$bx_table_prefix."_pricing_".$bx_table_lng.".pricing_id=".$bx_table_prefix."_invoices.pricing_type");
          SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
          $invoice_result=bx_db_fetch_array($invoice_query);
          if ($invoice_result['compid']==$HTTP_SESSION_VARS['employerid'])
           {
				if ($HTTP_GET_VARS['del']=="n") {
					header("Location: ".bx_make_url(HTTP_SERVER.FILENAME_MYINVOICES, "auth_sess", $bx_session));
                    bx_exit();
				}
				elseif ($HTTP_GET_VARS['del']=="y") {
					bx_db_query("DELETE FROM ".$bx_table_prefix."_invoices where ".$bx_table_prefix."_invoices.opid='".$HTTP_GET_VARS['opid']."'");
					SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
					header("Location: ".bx_make_url(HTTP_SERVER.FILENAME_MYINVOICES, "auth_sess", $bx_session));
                    bx_exit();
				}
		   } //end if ($verify_result['compid']==$HTTP_SESSION_VARS['employerid'])
           else
           {
               $error_message=TEXT_UNAUTHORIZED_ACCESS;
               $back_url=bx_make_url(HTTP_SERVER.FILENAME_MEMBERSHIP, "auth_sess", $bx_session);
               if ($HTTP_GET_VARS['printit']!="yes") {
                      include(DIR_SERVER_ROOT."header.php");
               }
               include(DIR_FORMS.FILENAME_ERROR_FORM);
               if ($HTTP_GET_VARS['printit']!="yes") {
                      include(DIR_SERVER_ROOT."footer.php");
               }
           }//end else ($verify_result['compid']==$HTTP_SESSION_VARS['employerid'])
		}
		elseif ($HTTP_GET_VARS['action']=="cancel")
        {
		  $invoice_query=bx_db_query("SELECT *,".$bx_table_prefix."_invoices.currency as icurrency from ".$bx_table_prefix."_invoices,".$bx_table_prefix."_pricing_".$bx_table_lng." where ".$bx_table_prefix."_invoices.opid='".$HTTP_GET_VARS['opid']."' and ".$bx_table_prefix."_pricing_".$bx_table_lng.".pricing_id=".$bx_table_prefix."_invoices.pricing_type");
          SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
          $invoice_result=bx_db_fetch_array($invoice_query);
          if ($invoice_result['compid']==$HTTP_SESSION_VARS['employerid'])
          {
                if ($HTTP_GET_VARS['printit']!="yes") {
                  include(DIR_SERVER_ROOT."header.php");
                }
                include(DIR_FORMS.FILENAME_INVOICES_FORM);
                if ($HTTP_GET_VARS['printit']!="yes") {
                  include(DIR_SERVER_ROOT."footer.php");
                }
          } //end if ($verify_result['compid']==$HTTP_SESSION_VARS['employerid'])
          else
          {
               $error_message=TEXT_UNAUTHORIZED_ACCESS;
               $back_url=bx_make_url(HTTP_SERVER.FILENAME_MEMBERSHIP, "auth_sess", $bx_session);
               if ($HTTP_GET_VARS['printit']!="yes") {
                  include(DIR_SERVER_ROOT."header.php");
               }
               include(DIR_FORMS.FILENAME_ERROR_FORM);
               if ($HTTP_GET_VARS['printit']!="yes") {
                  include(DIR_SERVER_ROOT."footer.php");
               }
          }//end else ($verify_result['compid']==$HTTP_SESSION_VARS['employerid'])
		}
        elseif ($HTTP_GET_VARS['action']=="update")
        {
          $invoice_query=bx_db_query("SELECT *,".$bx_table_prefix."_invoices.currency as icurrency from ".$bx_table_prefix."_invoices,".$bx_table_prefix."_pricing_".$bx_table_lng." where ".$bx_table_prefix."_invoices.opid='".$HTTP_GET_VARS['opid']."' and ".$bx_table_prefix."_pricing_".$bx_table_lng.".pricing_id=".$bx_table_prefix."_invoices.pricing_type");
          SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
          $invoice_result=bx_db_fetch_array($invoice_query);
          if ($invoice_result['compid']==$HTTP_SESSION_VARS['employerid'] && $invoice_result['updated'] == "N")
           {
            if ($invoice_result['pricing_type']>0)
             {
               bx_db_query("UPDATE ".$bx_table_prefix."_companycredits set jobs=if ((jobs+".$invoice_result['pricing_avjobs'].")>999, 999, (jobs+".$invoice_result['pricing_avjobs'].")), featuredjobs=(featuredjobs+".$invoice_result['pricing_fjobs']."),contacts=if((contacts+".$invoice_result['pricing_avsearch'].")>999, 999, (contacts+".$invoice_result['pricing_avsearch'].")) where compid='".$invoice_result['compid']."'");
			   $pricing_query=bx_db_query("SELECT pricing_id from ".$bx_table_prefix."_membership  where compid='".$invoice_result['compid']."'");
			   if (bx_db_num_rows($pricing_query)!=0) {
			       bx_db_query("UPDATE ".$bx_table_prefix."_membership set pricing_id='".$invoice_result['pricing_type']."' where compid='".$invoice_result['compid']."'");
                   SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
               }
			   else {
			       bx_db_insert($bx_table_prefix."_membership","compid,pricing_id","'".$invoice_result['compid']."','".$invoice_result['pricing_type']."'");
                   SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
               }
			   bx_db_query("UPDATE ".$bx_table_prefix."_companies set expire='".date('Y-m-d',mktime (0,0,0,date('m')+$invoice_result['pricing_period'],date('d'),date('Y')))."' where compid='".$HTTP_SESSION_VARS['employerid']."'");
               if ($invoice_result['pricing_fcompany']=="yes") {
                   bx_db_query("update ".$bx_table_prefix."_companies set featured=1 where compid='".$invoice_result['compid']."'");
                }
             }//end if ($invoice_result['pricing_type']>0)
             elseif ($invoice_result['pricing_type']==0)
             {
              bx_db_query("UPDATE ".$bx_table_prefix."_companycredits set jobs=if ((jobs+".$invoice_result['jobs'].")>999, 999, (jobs+".$invoice_result['jobs'].")), featuredjobs=(featuredjobs+".$invoice_result['featuredjobs']."),contacts=if((contacts+".$invoice_result['contacts'].")>999, 999, (contacts+".$invoice_result['contacts'].")) where compid='".$invoice_result['compid']."'");
			  SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
             }//end elseif ($invoice_result['pricing_type']==0)
              bx_db_query("UPDATE ".$bx_table_prefix."_invoices set updated='Y' where ".$bx_table_prefix."_invoices.opid='".$invoice_result['opid']."'");
              SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
             $success_message=TEXT_UPDATE_SUCCESFULLY;
             $back_url=bx_make_url(HTTP_SERVER.FILENAME_MEMBERSHIP, "auth_sess", $bx_session);
             if ($HTTP_GET_VARS['printit']!="yes") {
                  include(DIR_SERVER_ROOT."header.php");
             }
             include(DIR_FORMS.FILENAME_MESSAGE_FORM);
             if ($HTTP_GET_VARS['printit']!="yes") {
                  include(DIR_SERVER_ROOT."footer.php");
             }
           } //end if ($verify_result['compid']==$HTTP_SESSION_VARS['employerid'])
           else
           {
               $error_message=TEXT_UNAUTHORIZED_ACCESS;
               $back_url=bx_make_url(HTTP_SERVER.FILENAME_MEMBERSHIP, "auth_sess", $bx_session);
               if ($HTTP_GET_VARS['printit']!="yes") {
                      include(DIR_SERVER_ROOT."header.php");
               }
               include(DIR_FORMS.FILENAME_ERROR_FORM);
               if ($HTTP_GET_VARS['printit']!="yes") {
                      include(DIR_SERVER_ROOT."footer.php");
               }
           }//end else ($verify_result['compid']==$HTTP_SESSION_VARS['employerid'])
        } //end elseif ($HTTP_GET_VARS['action']=="update")
      }
     else
      {
          $login='employer';
          if ($HTTP_GET_VARS['printit']!="yes") {
                  include(DIR_SERVER_ROOT."header.php");
          }
          include(DIR_FORMS.FILENAME_LOGIN_FORM);
          if ($HTTP_GET_VARS['printit']!="yes") {
                  include(DIR_SERVER_ROOT."footer.php");
          }
      }
if ($HTTP_GET_VARS['printit']=="yes") {
    echo "</body></html>";
}
?>