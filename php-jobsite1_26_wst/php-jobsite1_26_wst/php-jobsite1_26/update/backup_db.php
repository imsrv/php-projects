<?php
function my_handler($sql_insert)
{
    global $endtag, $asfile;
    
    if (!empty($sql_insert)) {
            return "$sql_insert;$endtag";
    }
    else {
        return "";
    }    
}

function get_table_def($db, $table, $endtag, $crlf)
{
    $schema_create = "";
    $schema_create .= "DROP TABLE IF EXISTS $table;$endtag";

    $schema_create .= "CREATE TABLE $table ($crlf";

    $result = mysql_db_query($db, "SHOW FIELDS FROM $table");
    while($row = mysql_fetch_array($result))
    {
        $schema_create .= "   $row[Field] $row[Type]";

        if(isset($row["Default"]) && (!empty($row["Default"]) || $row["Default"] == "0"))
            $schema_create .= " DEFAULT '$row[Default]'";
        if($row["Null"] != "YES")
            $schema_create .= " NOT NULL";
        if($row["Extra"] != "")
            $schema_create .= " $row[Extra]";
        $schema_create .= ",$crlf";
    }
    $schema_create = ereg_replace(",".$crlf."$", "", $schema_create);
    $result = mysql_db_query($db, "SHOW KEYS FROM $table") or mysql_die();
    while($row = mysql_fetch_array($result))
    {
        $kname=$row['Key_name'];
        if(($kname != "PRIMARY") && ($row['Non_unique'] == 0))
            $kname="UNIQUE|$kname";
         if(!isset($index[$kname]))
             $index[$kname] = array();
         $index[$kname][] = $row['Column_name'];
    }

    while(list($x, $columns) = @each($index))
    {
         $schema_create .= ",$crlf";
         if($x == "PRIMARY")
             $schema_create .= "   PRIMARY KEY (" . implode($columns, ", ") . ")";
         elseif (substr($x,0,6) == "UNIQUE")
            $schema_create .= "   UNIQUE ".substr($x,7)." (" . implode($columns, ", ") . ")";
         else
            $schema_create .= "   KEY $x (" . implode($columns, ", ") . ")";
    }

    $schema_create .= "$crlf)";
    return (stripslashes($schema_create));
}

// Get the content of $table as a series of INSERT statements.
// After every row, a custom callback function $handler gets called.
// $handler must accept one parameter ($sql_insert);
function get_table_content($db, $table, $handler)
{
    $to_return='';
    $result = mysql_db_query($db, "SELECT * FROM $table") or mysql_die();
    $i = 0;
    while($row = mysql_fetch_row($result))
    {
        set_time_limit(60); // HaRa
        $table_list = "(";

        for($j=0; $j<mysql_num_fields($result);$j++)
            $table_list .= mysql_field_name($result,$j).", ";

        $table_list = substr($table_list,0,-2);
        $table_list .= ")";

        if(isset($GLOBALS["showcolumns"]))
            $schema_insert = "INSERT INTO $table $table_list VALUES (";
        else
            $schema_insert = "INSERT INTO $table VALUES (";

        for($j=0; $j<mysql_num_fields($result);$j++)
        {
            if(!isset($row[$j]))
                $schema_insert .= " NULL,";
            elseif($row[$j] != "")
                $schema_insert .= " '".addslashes($row[$j])."',";
            else
                $schema_insert .= " '',";
        }
        $schema_insert = ereg_replace(",$", "", $schema_insert);
        $schema_insert .= ")";
        $to_return.=$handler(trim($schema_insert));
        $i++;
    }
    return $to_return;
}
$db=DB_DATABASE;
@set_time_limit(0);
$crlf="\n";
$endtag="#%%\n";

        
$tables = mysql_list_tables($db);

$num_tables = @mysql_numrows($tables);
if($num_tables == 0)
{
    echo "No Tables Found";
}
else
{
    $i = 0;
    $fp=fopen(DIR_SERVER_ROOT."update/backup/".date('m-d-Y')."-".$db.".sql", "w");
    fwrite($fp, "# Php-Jobsite ".PHP_JOBSITE_VERSION." MySQL-Dump$endtag");
    fwrite($fp,  "# http://www.bitmixsoft.com/php-jobsite/$endtag");
    fwrite($fp,  "# Web access: ".HTTP_SERVER.$endtag);
    fwrite($fp,  "# Directory path: ".DIR_SERVER_ROOT.$endtag);
    fwrite($fp,  "#$endtag");
    fwrite($fp,  "# Host: " . DB_SERVER.$endtag);
    fwrite($fp,  "# Database: $db$endtag");
    fwrite($fp,  "#".SITE_NAME." - ".SITE_MAIL."$endtag");
    fwrite($fp,  "#".SITE_TITLE."$endtag");

    while($i < $num_tables)
    {
        $table = mysql_tablename($tables, $i);

        fwrite($fp,  $endtag);
        fwrite($fp,  "# --------------------------------------------------------$endtag");
        fwrite($fp,  "#$endtag");
        fwrite($fp,  "#TableStructure '$table'$endtag");
        fwrite($fp,  "#$endtag");
        fwrite($fp,  $endtag);

        fwrite($fp,  get_table_def($db, $table, $endtag, $crlf).";$endtag$endtag");

        fwrite($fp,  "#$endtag");
        fwrite($fp,  "#Dumping data for table '$table'$endtag");
        fwrite($fp,  "#$endtag");
        fwrite($fp,  $endtag);

        fwrite($fp,  get_table_content($db, $table, "my_handler"));
        $i++;
    }
    fclose($fp);
    if(@function_exists('gzencode')) {
        $content=ob_get_contents();
        $tgz=fread(fopen(DIR_SERVER_ROOT."update/backup/".date('m-d-Y')."-".$db.".sql", "r"), filesize(DIR_SERVER_ROOT."update/backup/".date('m-d-Y')."-".$db.".sql"));
        $tgz = gzencode($tgz);
        $fp=fopen(DIR_SERVER_ROOT."update/backup/".date('m-d-Y')."-".$db.".sql.gz", "w");
        fwrite($fp, $tgz);
        fclose($fp);
        @unlink(DIR_SERVER_ROOT."update/backup/".date('m-d-Y')."-".$db.".sql.gz");
    } 
}
?>