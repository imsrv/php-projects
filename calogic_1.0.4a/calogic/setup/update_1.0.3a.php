<?php

# this is the database update 

# run this update only if you are updating from 
# CaLogic version 1.0.1a or 1.0.2a or 1.0.3a

include("../include/dbloader.php");

$sqlstr = "delete from ".$tabpre."_cal_ini where tuid = '1'";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

$sqlstr = "INSERT INTO ".$tabpre."_cal_ini VALUES (1, '0', 'Default', 0, 'Default', 'Default', 0, 1, 'Month', 1, 1, '0000', '0000', 1, './img/stonbk.jpg', '#0000FF', '', 'underline', '#0000FF', '', 'underline', '#0000FF', 'underline', '#FFFF80', '#000000', '#B04040', '#FFFFFF', 'none', '#FFFFFF', '#FF0000', '#80FFFF', '#0000FF', '#FFFF80', '#000000', '#C0C0C0', 'none', '#C0C0C0', '#000000', '#808080', 'none', '#808080', '#0000FF', '#FFFF80', 'none', '#FFFF80', '#000000', '#FFFFFF', 'none', '#FFFFFF', 'Lightpink', '#000000', '#000000', '#B04040', '#FFFFFF', 'none', '#FFFFFF', '#FF0000', '#80FFFF', '#0000FF', '#FFFF80', '#000000', '#C0C0C0', 'none', '#C0C0C0', '#000000', '#808080', 'none', '#808080', '#0000FF', '#FFFF80', 'none', '#FFFF80', '#FFFFFF', 'Lightpink', '#000000', '#000000', '#FF0000', '#80FFFF', '#0000FF', '#FFFF80', '#000000', '#C0C0C0', 'none', '#C0C0C0', '#000000', '#808080', 'none', '#808080', '#0000FF', '#FFFF80', 'none', '#FFFF80', '#000000', '#FFFFFF', 'none', '#FFFFFF', '#B04040', '', 'none', '#000000', '#000000', '#FF0000', '#80FFFF', 'none', '#80FFFF', '#0000FF', '#FFFF80', 'none', '#FFFF80', '#0000FF', '#FFFF80', 'none', '#FFFF80', '#000000', '#008000', '#008000', '#000000', '#C0C0C0', '#C0C0C0', '#000000', '#808080', '#808080', '#000000', '#FFFF80', '#FFFF80', '#000000', '#C0C0C0', '#C0C0C0', '#000000', '#808080', '#808080', '#000000', '#FFFF80', '#FFFF80', '#000000', '#FFFFFF', '#FFFFFF', '#000000', '#000000', '#000000', '#008000', '#008000', '#000000', '#008000', '#008000', '#000000', '#008000', '#008000', '#000000', '#008000', '#008000', '#000000', '#C0C0C0', '#C0C0C0', '#000000', '#808080', '#808080', '#000000', '#FFFF80', '#FFFF80', '#000000', '#FFFFFF', '#FFFFFF')";
mysql_query($sqlstr) or die("Database setup error.<br><br>MySQL said: ".mysql_error()."<br><br>SQL String: ".$sqlstr."<br><br>File: ".substr(__FILE__,strrpos(__FILE__,"/"))."<br><br>Line: ".__LINE__.$GLOBALS["errep"]);

include("calogic_lang_english.php");
include("calogic_mysql_color.php");

?>