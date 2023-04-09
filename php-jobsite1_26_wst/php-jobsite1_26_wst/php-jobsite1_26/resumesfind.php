<?php
include ('application_config_file.php');
include(DIR_LANGUAGES.$language."/".FILENAME_SEARCH_RESUMES);
$jsfile="search.js";
if($HTTP_GET_VARS['action']) {
    $action = $HTTP_GET_VARS['action'];
}
elseif($HTTP_GET_VARS['action']) {
    $action = $HTTP_GET_VARS['action'];
}
else {
    $action='';
}
include(DIR_SERVER_ROOT."header.php");
if ($HTTP_SESSION_VARS['employerid'])
       {
       if ($action=="search")
       {
        /** Validating form posts for invalid inputs  */
        $error=0;
        if (verify($HTTP_GET_VARS['bx_minsalary'],"int")==1) {
               $error=1;
               $minsalary_error=1;
        }//end if (verify($HTTP_GET_VARS['bx_minsalary'],"int")==1)
        else {
              $minsalary_error=0;
        }//end else if (verify($HTTP_GET_VARS['bx_minsalary'],"int")==1)
        if (verify($HTTP_GET_VARS['bx_maxsalary'],"int")==1) {
           $error=1;
           $maxsalary_error=1;
        }//end if (verify($HTTP_GET_VARS['bx_maxsalary'],"int")==1)
        else {
           $maxsalary_error=0;
        }//end  if (verify($HTTP_GET_VARS['bx_maxsalary'],"int")==1)
        if ($error==1) {
            include(DIR_FORMS.FILENAME_SEARCH_RESUME_FORM);
        }
        else {
       $sql_statement = "select ".$bx_table_prefix."_resumes.resumeid, ".$bx_table_prefix."_resumes.persid, ";
       $sql_statement .= "  ".$bx_table_prefix."_resumes.resumedate, ".$bx_table_prefix."_resumes.summary,".$bx_table_prefix."_persons.persid, ";
	   $sql_statement .= "  ".$bx_table_prefix."_persons.name,".$bx_table_prefix."_persons.hide_name,".$bx_table_prefix."_persons.hide_location, ";
       $sql_statement .= "  concat(if (".$bx_table_prefix."_persons.city='','',concat(".$bx_table_prefix."_persons.city, ' - ')), if (".$bx_table_prefix."_persons.province='','', concat(".$bx_table_prefix."_persons.province,' - ')), ".$bx_table_prefix."_locations_".$bx_table_lng.".location) as location, ".$bx_table_prefix."_resumes.postlanguage  ";
       $sql_statement .= "from ".$bx_table_prefix."_resumes, ".$bx_table_prefix."_persons, ".$bx_table_prefix."_locations_".$bx_table_lng." ";
       $sql_statement .= "where ".$bx_table_prefix."_persons.persid=".$bx_table_prefix."_resumes.persid and ".$bx_table_prefix."_locations_".$bx_table_lng.".locationid=".$bx_table_prefix."_persons.locationid ";
       if(HIDE_RESUME == "yes") {
               $sql_statement .= " and ".$bx_table_prefix."_resumes.confidential!='1' ";
       }
       if(RESUME_EXPIRE == "yes") {
               $sql_statement .= " and TO_DAYS(".$bx_table_prefix."_resumes.resumeexpire)>= TO_DAYS(NOW()) ";
       }
       
 // if we have a language selected
  if ($HTTP_GET_VARS['bx_postlang']) {
	   if ($HTTP_GET_VARS['bx_postlang'][0] != '0') {
		   for ($i=0;$i<sizeof($HTTP_GET_VARS['bx_postlang']);$i++) {
			     $sql_in.="'".$HTTP_GET_VARS['bx_postlang'][$i]."',";
			}
			$sql_in=substr($sql_in,0,strlen($sql_in)-1);
			$sql_statement .= "and ".$bx_table_prefix."_resumes.postlanguage in ($sql_in) ";
	   }
  }

  if ($HTTP_GET_VARS['jobcategoryids']) {
       if ($HTTP_GET_VARS['jobcategoryids'][0]!="00") {
			for ($i=0;$i<sizeof($HTTP_GET_VARS['jobcategoryids']);$i++) {
				$categ_list.="(POSITION('-".$HTTP_GET_VARS['jobcategoryids'][$i]."-' IN ".$bx_table_prefix."_resumes.jobcategoryids)!=0) or ";
			}
			$categ_list=substr($categ_list,0,strlen($categ_list)-3);
			$sql_statement .= " and ($categ_list) ";
       }
  }
  
  if ($HTTP_GET_VARS['jobtypeids']) {
     if ($HTTP_GET_VARS['jobtypeids'][0]!="0") {
		for ($i=0;$i<sizeof($HTTP_GET_VARS['jobtypeids']);$i++) {
            $jobtype_list.="(POSITION('".$HTTP_GET_VARS['jobtypeids'][$i]."' IN ".$bx_table_prefix."_resumes.jobtypeids)!=0) or ";
		}
		$jobtype_list=substr($jobtype_list,0,strlen($jobtype_list)-3);
		$sql_statement .= " and ($jobtype_list) ";
      }
  }

  if ($HTTP_GET_VARS['locationids'] || $HTTP_GET_VARS['bx_province']) {
	  $first=1;
	  if ($HTTP_GET_VARS['locationids']) {
		 if ($HTTP_GET_VARS['locationids'][0]!="000") {
			for ($i=0;$i<sizeof($HTTP_GET_VARS['locationids']);$i++) {
				$country_list.="(POSITION('-".$HTTP_GET_VARS['locationids'][$i]."-' IN ".$bx_table_prefix."_resumes.locationids)!=0) or ";
			}
			$country_list=substr($country_list,0,strlen($country_list)-3);
			$first = 0;
			$sql_statement.= "and (($country_list) ";
		 }
      }
      if ($HTTP_GET_VARS['bx_province']) {
           if ($first) {
                      $first = 0;
                      $sql_statement .= "and (".$bx_table_prefix."_persons.province like '%$HTTP_GET_VARS[bx_province]%' ";
           } else {
                      $sql_statement .= "or ".$bx_table_prefix."_persons.province like '%$HTTP_GET_VARS[bx_province]%' ";
            }
       }//end if ($HTTP_GET_VARS['bx_province'])
       if ($first == 0) {
              $sql_statement .= ") ";
       }
   }
  
   if ($HTTP_GET_VARS['bx_minsalary']) {
		$sql_statement .= "and (".$bx_table_prefix."_resumes.salary >= $HTTP_GET_VARS[bx_minsalary] or ".$bx_table_prefix."_resumes.salary = '')";
   }
   if ($HTTP_GET_VARS['bx_maxsalary']) {
		$sql_statement .= "and (".$bx_table_prefix."_resumes.salary <= $HTTP_GET_VARS[bx_maxsalary] or ".$bx_table_prefix."_resumes.salary = '')";
   }
   $first = 1;
   if ($HTTP_GET_VARS['bx_languageids']) {
		 if ($HTTP_GET_VARS{'rdLang'} == 1) {
			$opLang = 'and';
		 } else {
			$opLang = 'or';
		 }
         $first=1;
		 if ($HTTP_GET_VARS['bx_languageids'][0]!="-") {
			for ($i=0;$i<sizeof($HTTP_GET_VARS['bx_languageids']);$i++) {
				$lang_list=$HTTP_GET_VARS['bx_languageids'][$i]."1%' or ".$bx_table_prefix."_resumes.languageids like '%".$HTTP_GET_VARS['bx_languageids'][$i]."2' or ".$bx_table_prefix."_resumes.languageids like '%".$HTTP_GET_VARS['bx_languageids'][$i]."3";
				if ($first) {
					$first = 0;
					$sql_statement .= "and ((".$bx_table_prefix."_resumes.languageids like '%$lang_list%' ";
				} else {
				$sql_statement .= ") $opLang (".$bx_table_prefix."_resumes.languageids like '%$lang_list%' ";
             }
         }
         $sql_statement .= ") ";
    }
    if ($first == 0) {
      $sql_statement .= ") ";
    }
 }

 if ($HTTP_GET_VARS['bx_criteria']) {
    $field_list = array("".$bx_table_prefix."_resumes.skills", "".$bx_table_prefix."_resumes.resume", "".$bx_table_prefix."_resumes.workexperience", "".$bx_table_prefix."_resumes.education", "".$bx_table_prefix."_resumes.salary", "".$bx_table_prefix."_resumes.resume_city", "".$bx_table_prefix."_resumes.resume_province", "".$bx_table_prefix."_resumes.summary","".$bx_table_prefix."_locations_".$bx_table_lng.".location");    
    if ($HTTP_GET_VARS['rdKeyw'] == 3) {
           if ($HTTP_GET_VARS['bx_criteria']!="") {
                   $str=htmlspecialchars(trim($HTTP_GET_VARS['bx_criteria']));
                   $str = eregi_replace("\\\\","\\\\",$str);
                   $str = eregi_replace("\+","\\\\+",$str);
                   $str = eregi_replace("\*","\\\\*",$str);
                   $str = eregi_replace("\.","\\\\.",$str);
                   $str = eregi_replace("\?","\\\\?",$str);
                   $str = eregi_replace("\]","\\\\]",$str);
                   $str = eregi_replace("\[","\\\\[",$str);
                   $str = eregi_replace("\^","\\\\^",$str);
                   $str = eregi_replace("\(","\\\\(",$str);
                   $str = eregi_replace("\)","\\\\)",$str);
                   $str = eregi_replace("\\\$","\\\\$",$str);
                   $str = eregi_replace("'","\\'",$str);
                   $sql_statement .= "and ( ";
                   for ( $i=0;$i<sizeof($field_list);$i++) {
                            $sql_statement.="LCASE(".$field_list[$i].") regexp '".strtolower($str)."' or ";
                   }
                   $sql_statement = eregi_replace(" or $",") ",$sql_statement);
               }
    }
    else {
            if ($HTTP_GET_VARS['rdKeyw'] == 1) {
              $opKeyw = 'and';
            } else {
              $opKeyw = 'or';
            }
            $first = 1;
            if ($HTTP_GET_VARS['bx_criteria']!="") {
             $str=htmlspecialchars(trim($HTTP_GET_VARS['bx_criteria']));
             $str = eregi_replace("\\\\","\\\\",$str);
             $str = eregi_replace("\+","\\\\+",$str);
             $str = eregi_replace("\*","\\\\*",$str);
             $str = eregi_replace("\.","\\\\.",$str);
             $str = eregi_replace("\?","\\\\?",$str);
             $str = eregi_replace("\]","\\\\]",$str);
             $str = eregi_replace("\[","\\\\[",$str);
             $str = eregi_replace("\^","\\\\^",$str);
             $str = eregi_replace("\(","\\\\(",$str);
             $str = eregi_replace("\)","\\\\)",$str);
             $str = eregi_replace("\\\$","\\\\$",$str);
             $str = eregi_replace("'","\\'",$str);
             $str = eregi_replace("\|","%%or%%",$str);
                   while (eregi("(.*)[,| ](.*)",$str,$regs))
                      {
                       $regs[2] = trim($regs[2]);
                       if (!empty($regs[2])) {
                           $regs[2] = eregi_replace("%%or%%","\\\\|",$regs[2]);
                           if ($first) {
                                  $first = 0;
                                  $sql_statement .= "and ((";
                           } else {
                                  $sql_statement .= "$opKeyw (";
                           }
                           for ( $i=0;$i<sizeof($field_list);$i++) {
                                    $sql_statement.="LCASE(".$field_list[$i].") regexp '".strtolower($regs[2])."' or ";
                           }
                           $sql_statement = eregi_replace(" or $",") ",$sql_statement); 
                       }
                       $str=$regs[1];
                       }
                       $str = eregi_replace("%%or%%","\\\\|",trim($str));
                       if(!empty($str)) {
                           if ($first) {
                              $first = 0;
                               $sql_statement .= "and ((";
                           }
                           else {
                               $sql_statement .= "$opKeyw (";
                           }
                           for ( $i=0;$i<sizeof($field_list);$i++) {
                                   $sql_statement.="LCASE(".$field_list[$i].") regexp '".strtolower($str)."' or ";
                           }
                           $sql_statement = eregi_replace(" or $",") ",$sql_statement);
                      }     
                      if ($first == 0) {
                         $sql_statement .= ") ";
                      }
                }
           }     
     }

     if ($HTTP_GET_VARS['posted']) {
		$sql_statement .= "and ".$bx_table_prefix."_resumes.resumedate >= DATE_SUB(NOW(), INTERVAL '".$HTTP_GET_VARS['posted']."' DAY) ";
     }
     $sql_statement .= "order by ".$bx_table_prefix."_resumes.resumedate desc";
     include(DIR_FORMS.FILENAME_RESUMESFIND_FORM);
 }
}
else {
     include(DIR_FORMS.FILENAME_RESUMESFIND_FORM);
}
}
 else {
       $login='employer';
       include(DIR_FORMS.FILENAME_LOGIN_FORM);
 }
include(DIR_SERVER_ROOT."footer.php");
?>