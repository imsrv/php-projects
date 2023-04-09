<?php
include ('admin_design.php');
include ('../application_config_file.php');
include ('admin_auth.php');
function my_handler($sql_insert)
{
    global $crlf;
    echo "$sql_insert".$crlf;
}

function write_field_list($db, $table, $fields, $field_list, $delim, $escape, $crlf)
{
    $schema_create = "";
    $my_list = split(",", $field_list);
    for($i=0; $i<sizeof($my_list); $i++) {
        $field_name = $fields[$my_list[$i]][1];
        $schema_create .= $escape.$field_name.$escape.$delim;
    }
    $schema_create = eregi_replace($delim."$","",$schema_create);
    return ($schema_create.$crlf);
}

function export_data($db, $table, $fields, $field_list, $delim, $escape, $crlf, $handler)
{
    global $location_names,$jobcategory_names,$type_names,$degree_names;
    if (!isset($escape)) {
            $escape  = '';
    } else if (get_magic_quotes_gpc()) {
            $escape  = stripslashes($escape);
    }
    if (!isset($delim)) {
            $delim  = '';
    } else if (get_magic_quotes_gpc()) {
            $delim  = stripslashes($delim);
    }
    $my_fields = split(",", $field_list);
    $result = bx_db_query("SELECT $field_list FROM $table");
    SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
    $no_of_fields  = mysql_num_fields($result);
    $i = 0;
    while ($row = mysql_fetch_row($result)) {
            $schema_insert = '';
            for ($j = 0; $j < $no_of_fields; $j++) {
                $format = $fields[$my_fields[$j]][3];
                if (!isset($row[$j])) {
                    $schema_insert .= 'NULL';
                }
                else if ($row[$j] == '0' || $row[$j] != '') {
                    $search       = array("\x00", "\x0a", "\x0d", "\x1a"); 
                    $replace      = array('\0', '', '', '\Z');
                    $row[$j] = str_replace($search, $replace, $row[$j]);
                    if($format == "date") {
                        $row[$j] = bx_format_date($row[$j], DATE_FORMAT);
                    }
                    elseif ($format == "location") {
                        $row[$j] = $location_names[$row[$j]];
                    }
                    elseif ($format == "locationids") {
                        $w=$row[$j];
                        $row[$j] = "";
                        while (eregi("-([0-9]*)-(.*)",$w,$regs)) {
                             $row[$j] .= $location_names[$regs[1]]." - ";
                             $w="-".$regs[2];
                        }
                        $row[$j] = eregi_replace(" - $","",$row[$j]);
                    }
                    elseif ($format == "price") {
                        $row[$j] = bx_format_price($row[$j],PRICE_CURENCY,0);
                    }
                    elseif ($format == "jobtype") {
                        $row[$j] = $type_names[$row[$j]];
                    }
                    elseif ($format == "jobtypeids") {
                        $w=trim($row[$j]);
                        $row[$j] = "";
                        while (eregi("([0-9]*)-(.*)",$w,$regs)) {
                             $row[$j] .= $type_names[$regs[1]]." - ";
                             $w=$regs[2];
                        }
                        $row[$j] = eregi_replace(" - $","",$row[$j]);
                    }
                    elseif ($format == "jobcategory") {
                        $row[$j] = $jobcategory_names[$row[$j]];
                    }
                    elseif ($format == "jobcategoryids") {
                        $w=trim($row[$j]);
                        $row[$j] = "";
                        while (eregi("-([0-9]*)-(.*)",$w,$regs)) {
                             $row[$j] .= $jobcategory_names[$regs[1]]." - ";
                             $w="-".$regs[2];
                        }
                        $row[$j] = eregi_replace(" - $","",$row[$j]);
                    }
                    elseif ($format == "degree") {
                       // print "<br>Most".$row[$j]."<br>";
                        // print ${TEXT_DEGREE_OPT.trim($row[$j])};
                        $row[$j] = $degree_names[$row[$j]];
                    }
                    if ($escape == '') {
                        $schema_insert .= bx_unhtmlspecialchars($row[$j]);
                    } else {
                        $schema_insert .= $escape.str_replace($escape, $escape.$escape, bx_unhtmlspecialchars($row[$j])).$escape;
                    }
                }
                else {
                    $schema_insert .= '';
                }
                if ($j < $no_of_fields-1) {
                    $schema_insert .= $delim;
                }
            }// end for
            $handler(trim($schema_insert));
            $i++;
    }
    return true;
}
if ($HTTP_POST_VARS['todo'] == "sel_fields") {
    if(ADMIN_SAFE_MODE == "yes") {
        include("header.php");
        $error_title = "exporting database!";
        bx_admin_error(TEXT_SAFE_MODE_ALERT);
        include("footer.php");
    }//end if ADMIN_SAFE_MODE == yes
    elseif (ADMIN_BX_DEMO=="yes") {
        include("header.php");
        $error_title = "exporting database!";
        bx_admin_error(TEXT_DEMO_MODE_ALERT);
        include("footer.php");
    }//end if ADMIN_BX_DEMO == yes
    else {
        $db=DB_DATABASE;
        @set_time_limit(0);
        $crlf="\r\n";
        $location_names = array();
        $location_query = bx_db_query("SELECt * from ".$bx_table_prefix."_locations_".$bx_table_lng);
        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
        while ($location_result = bx_db_fetch_array($location_query)) {
            $location_names[$location_result['locationid']] = $location_result['location'];
        }
        $type_names = array();
        $type_query = bx_db_query("select * from ".$bx_table_prefix."_jobtypes_".$bx_table_lng);
        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
        while ($type_result = bx_db_fetch_array($type_query)) {
            $type_names[$type_result['jobtypeid']] = $type_result['jobtype'];
        }
        $jobcategory_names = array();
        $jobcategory_query = bx_db_query("select * from ".$bx_table_prefix."_jobcategories_".$bx_table_lng);
        SQL_CHECK(0,"SQL Error at ".__FILE__.":".(__LINE__-1));
        while ($jobcategory_result = bx_db_fetch_array($jobcategory_query)) {
            $jobcategory_names[$jobcategory_result['jobcategoryid']] = $jobcategory_result['jobcategory'];
        }
        $degree_names = array();
        $i=1;
        while (${TEXT_DEGREE_OPT.$i}) {
             $degree_names[$i]= ${TEXT_DEGREE_OPT.$i};
             $i++;
        } 
        if($HTTP_POST_VARS['file_type'] == "csv") {
            header("Content-disposition: filename=".date('m-d-Y')."-export.csv");
        }
        else {
            header("Content-disposition: attachment; filename=".date('m-d-Y')."-export.txt");    
        }
        header("Content-type: application/octetstream");
        header("Pragma: no-cache");
        header("Expires: 0");
            
        if($HTTP_POST_VARS['file_type'] == "csv") {
            $delim = ",";
            $escape = '"';
        }
        else {
            if($HTTP_POST_VARS['delim'] == "" ) {
                    $delim = $HTTP_POST_VARS['delimy'];
                    $delim = str_replace('\\t', "\011", $delim);
             }
             else {
                    switch ($HTTP_POST_VARS['delim']) {
                        case "comma": $delim = ","; break;
                        case "tab": $delim = "\011"; break;
                    }
             }
             $escape = $HTTP_POST_VARS['enclosed'];
        }
        for($i=0; $i<sizeof($HTTP_POST_VARS['phpjob_db']); $i++) {
            $field_list = "";
            for($j=0; $j<sizeof($HTTP_POST_VARS[$HTTP_POST_VARS['phpjob_db'][$i]]) ; $j++) {
              $field_list .=  $HTTP_POST_VARS[$HTTP_POST_VARS['phpjob_db'][$i]][$j].",";
            }
            $field_list = eregi_replace(",$","",$field_list);
            include(DIR_ADMIN.$HTTP_POST_VARS['phpjob_db'][$i].".cfg.php");
            if($HTTP_POST_VARS['show_fields'] == "Y") {
                echo write_field_list($db, $HTTP_POST_VARS['phpjob_db'][$i], $fields, $field_list, $delim, $escape, $crlf);
            }
            export_data($db, $HTTP_POST_VARS['phpjob_db'][$i], $fields, $field_list, $delim, $escape, $crlf, "my_handler");    
        }    
        bx_exit();
    }//end else ADMIN_SAFE_MODE==yes    
}
else {
    include("header.php");
    include(DIR_ADMIN.FILENAME_ADMIN_EXPORT_DB_FORM);
    include("footer.php");
}
?>