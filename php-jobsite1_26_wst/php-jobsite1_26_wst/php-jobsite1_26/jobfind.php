<?php
include ('application_config_file.php');
$jsfile="search.js";
include(DIR_SERVER_ROOT."header.php");
if($HTTP_POST_VARS['action']) {
    $action = $HTTP_POST_VARS['action'];
}
elseif($HTTP_GET_VARS['action']) {
    $action = $HTTP_GET_VARS['action'];
}
else {
    $action='';
}
if ($action=="search")
     {
       /**Validating form posts for invalid inputs */
        $error=0;
        if (verify($HTTP_GET_VARS['bx_minsalary'],"int")==1) {
           $error=1;
           $minsalary_error=1;
         }//end if (verify($HTTP_GET_VARS['bx_minsalary'],"int")==1)
         else  {
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
            include(DIR_FORMS.FILENAME_SEARCH_JOB_FORM);
         }
 else {
       $sql_statement = "select ".$bx_table_prefix."_jobs.jobid,".$bx_table_prefix."_jobs.jobtitle, ".$bx_table_prefix."_jobs.hide_compname, ".$bx_table_prefix."_jobs.compid, ".$bx_table_prefix."_locations_".$bx_table_lng.".location , ".$bx_table_prefix."_jobs.jobdate, ".$bx_table_prefix."_jobcategories_".$bx_table_lng.".jobcategory, ";
       $sql_statement .= "   ".$bx_table_prefix."_companies.company, ";
       $sql_statement .= "  concat(if (".$bx_table_prefix."_jobs.city='','',concat(".$bx_table_prefix."_jobs.city, ' - ')),if (".$bx_table_prefix."_jobs.province='','', concat(".$bx_table_prefix."_jobs.province,' - ')), ".$bx_table_prefix."_locations_".$bx_table_lng.".location) as location ";
       $sql_statement .= "from ".$bx_table_prefix."_jobcategories_".$bx_table_lng.",".$bx_table_prefix."_jobs, ".$bx_table_prefix."_locations_".$bx_table_lng." , ".$bx_table_prefix."_companies ";
       $sql_statement .= "where (".$bx_table_prefix."_jobs.compid = ".$bx_table_prefix."_companies.compid  or ".$bx_table_prefix."_jobs.compid=0) and ".$bx_table_prefix."_locations_".$bx_table_lng.".locationid=".$bx_table_prefix."_jobs.locationid ";
       // if we have a language selected
       if ($HTTP_GET_VARS['bx_plng']) {
              if ($HTTP_GET_VARS['bx_plng'][0] != '0') {
                    for ($i=0;$i<sizeof($HTTP_GET_VARS['bx_plng']);$i++) {
                             $sql_in.="'".$HTTP_GET_VARS['bx_plng'][$i]."',";
                     }
                     $sql_in=substr($sql_in,0,strlen($sql_in)-1);
                     $sql_statement .= "and ".$bx_table_prefix."_jobs.postlanguage in ($sql_in) ";
               }
        }//end if ($HTTP_GET_VARS['bx_plng'])
				
        if ($HTTP_GET_VARS['jids']) {
		  	if ($HTTP_GET_VARS['jids'][0]!="00")  {
			      for ($i=0;$i<sizeof($HTTP_GET_VARS['jids']);$i++) {
						$categ_list.="".$bx_table_prefix."_jobs.jobcategoryid='".$HTTP_GET_VARS['jids'][$i]."' or ";
				  }
				  $categ_list=substr($categ_list,0,strlen($categ_list)-3);
				  $sql_statement .= " and ($categ_list) ";
			}
		}
        
		if ($HTTP_GET_VARS['tids']) {
             if ($HTTP_GET_VARS['tids'][0]!="0") {
                    for ($i=0;$i<sizeof($HTTP_GET_VARS['tids']);$i++) {
                           $jobtype_list.="(POSITION('".$HTTP_GET_VARS['tids'][$i]."' IN ".$bx_table_prefix."_jobs.jobtypeids)!=0) or ";
                    }//end for
                    $jobtype_list=substr($jobtype_list,0,strlen($jobtype_list)-3);
                    $sql_statement .= " and ($jobtype_list) ";
             }
        }//end if ($HTTP_GET_VARS['tds'])

        if ($HTTP_GET_VARS['lids'] || $HTTP_GET_VARS['bx_prv']) {
            $first=1;
            if ($HTTP_GET_VARS['lids']) {
                  if ($HTTP_GET_VARS['lids'][0]!="000") {
                         for ($i=0;$i<sizeof($HTTP_GET_VARS['lids']);$i++) {
                             $country_list.="'".$HTTP_GET_VARS['lids'][$i]."',";
                          }
                          $first = 0;
                          $country_list=substr($country_list,0,strlen($country_list)-1);
                          $sql_statement .= "and (".$bx_table_prefix."_jobs.locationid in ($country_list) ";
                   }
            }//end if ($HTTP_GET_VARS['lids'])
            if ($HTTP_GET_VARS['bx_prv']) {
                       if ($first) {
                          $first = 0;
                          $sql_statement .= "and (".$bx_table_prefix."_jobs.province like '%$HTTP_GET_VARS[bx_prv]%' ";
                        } else {
                        $sql_statement .= "or ".$bx_table_prefix."_jobs.province like '%$HTTP_GET_VARS[bx_prv]%' ";
                        }
            }//end if ($HTTP_GET_VARS['bx_prv'])
            if ($first == 0) {
                     $sql_statement .= ") ";
            }
        }

        if ($HTTP_GET_VARS['bx_minsalary']) {
                   $sql_statement .= "and (".$bx_table_prefix."_jobs.salary >= $HTTP_GET_VARS[bx_minsalary] or ".$bx_table_prefix."_jobs.salary = '')";
        }
        
		if ($HTTP_GET_VARS['bx_maxsalary']) {
                   $sql_statement .= "and (".$bx_table_prefix."_jobs.salary <= $HTTP_GET_VARS[bx_maxsalary] or ".$bx_table_prefix."_jobs.salary = '')";
        }
		$first = 1;
        
		if ($HTTP_GET_VARS['bx_lngids']) {
                  if ($HTTP_GET_VARS{'rdLang'} == 1) {
                         $opLang = 'and';
                  } else {
                         $opLang = 'or';
                  }
                  $first=1;
                  if ($HTTP_GET_VARS['bx_lngids'][0]!="-") {
                          for ($i=0;$i<sizeof($HTTP_GET_VARS['bx_lngids']);$i++) {
                                 $lang_list=$HTTP_GET_VARS['bx_lngids'][$i]."1%' or ".$bx_table_prefix."_jobs.languageids like '%".$HTTP_GET_VARS['bx_lngids'][$i]."2%' or ".$bx_table_prefix."_jobs.languageids like '%".$HTTP_GET_VARS['bx_lngids'][$i]."3";
                                 if ($first) {
                                     $first = 0;
                                     $sql_statement .= "and ((".$bx_table_prefix."_jobs.languageids like '%$lang_list%' ";
                                 } else {
                                      $sql_statement .= ") $opLang (".$bx_table_prefix."_jobs.languageids like '%$lang_list%' ";
                                 }
                          }//end for
                          $sql_statement .= ") ";
                  }
                  if ($first == 0) {
                          $sql_statement .= ") ";
                  }
         }

         if ($HTTP_GET_VARS['bx_employer']) {
                  if ($HTTP_GET_VARS['bx_employer'][0] != 0) {
                           for ($i=0;$i<sizeof($HTTP_GET_VARS['bx_employer']);$i++) {
                                   $comp_list.=$HTTP_GET_VARS['bx_employer'][$i].",";
                           }//end for
                           $comp_list=substr($comp_list,0,strlen($comp_list)-1);
                           $sql_statement .= "and ".$bx_table_prefix."_jobs.compid in ($comp_list) ";
                   }
         }
         
         if ($HTTP_GET_VARS['kwd']) {
                 $HTTP_GET_VARS['bx_kwd'] = $HTTP_GET_VARS['kwd'];
         }        
		 if ($HTTP_GET_VARS['bx_kwd']) {
                   $field_list = array("".$bx_table_prefix."_jobs.skills", "".$bx_table_prefix."_jobs.description", "".$bx_table_prefix."_jobs.jobtitle", "".$bx_table_prefix."_jobs.city", "".$bx_table_prefix."_jobs.salary", "".$bx_table_prefix."_jobs.province", "".$bx_table_prefix."_jobcategories_".$bx_table_lng.".jobcategory","".$bx_table_prefix."_locations_".$bx_table_lng.".location");    
                   if ($HTTP_GET_VARS['rdKeyw'] == 3) {
                       if (trim($HTTP_GET_VARS['bx_kwd'])!="") {
                           $str=htmlspecialchars(trim($HTTP_GET_VARS['bx_kwd']));
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
                           if ($HTTP_GET_VARS['bx_kwd']!="") {
                                    $str=htmlspecialchars(trim($HTTP_GET_VARS['bx_kwd']));
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
                                    while (eregi("(.*)[,| ](.*)",$str,$regs))  {
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
                                    }//end while
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
         $sql_statement .= "and ".$bx_table_prefix."_jobcategories_".$bx_table_lng.".jobcategoryid=".$bx_table_prefix."_jobs.jobcategoryid ";
         if ($HTTP_GET_VARS['posted']) {
            $sql_statement .= "and ".$bx_table_prefix."_jobs.jobdate >= DATE_SUB(NOW(), INTERVAL '".$HTTP_GET_VARS['posted']."' DAY) ";
         }
         $sql_statement .= "GROUP BY ".$bx_table_prefix."_jobs.jobid order by ".$bx_table_prefix."_jobs.jobdate desc";
         include(DIR_FORMS.FILENAME_JOBFIND_FORM);
    }//end else if ($error==1)
  } //end action==search
  else {
       include(DIR_FORMS.FILENAME_JOBFIND_FORM);
  }
include(DIR_SERVER_ROOT."footer.php");
?>