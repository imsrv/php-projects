<?php
/************************************************************************/
/*  Program Name         : QuizShock                                    */
/*  Program Version      : 1.5.4                                        */
/*  Program Author       : Pineapple Technologies                       */
/*  Supplied by          : CyKuH [WTN]                                  */
/*  Nullified by         : CyKuH [WTN]                                  */
/*  Distribution         : via WebForum and Forums File Dumps           */
/*                  (c) WTN Team `2004                                  */
/*   Copyright (c)2002 Pineapple Technologies. All Rights Reserved.     */
/************************************************************************/

require("../script_ext.inc");
require("admin_global" . $script_ext);

$fn = get_global_input('fn');
switch($fn)
{
	case 'nullification':
	        $WTN="CyKuH [WTN]";
	        $WTN1="WTN Team";
		nullification();
	break;
}
function nullification() {

show_cp_header();

show_section_info("Nullification Info", "");
$form_options = get_global_input("form_options");

 global $HTTP_POST_VARS,$form_options,$form_options_error, $db;
 global $CP_HVARS, $TS_SCRIPTS, $OPTIONS;
 start_form_table();
 do_table_header("<b>Extra Information</b>", 2);
 $currbg = switch_bgcolor($currbg);
 start_table_row();
 do_option_info_cell("Program Name   ", "",$currbg, "50%");
 do_option_info_cell("QuizShock", "",$currbg, "50%");
 end_table_row();
 $currbg = switch_bgcolor($currbg);
 start_table_row();
 do_option_info_cell("Program Version", "",$currbg, "50%");
 do_option_info_cell("1.5.4", "",$currbg, "50%");
 end_table_row();
 $currbg = switch_bgcolor($currbg);
 start_table_row();
 do_option_info_cell("Program Author ", "",$currbg, "50%");
 do_option_info_cell("Pineapple Technologies.", "",$currbg, "50%");
 end_table_row();
 $currbg = switch_bgcolor($currbg);
 start_table_row();
 do_option_info_cell("Home Page", "",$currbg, "50%");
 do_option_info_cell("hxxp://wxw.triviashock.net", "",$currbg, "50%");
 end_table_row();
 $currbg = switch_bgcolor($currbg);
 start_table_row();
 do_option_info_cell("Retail Price   ", "",$currbg, "50%");
 do_option_info_cell("$74.95 United States Dollars", "",$currbg, "50%");
 end_table_row();
 $currbg = switch_bgcolor($currbg);
 start_table_row();
 do_option_info_cell("WebForum Price ", "",$currbg, "50%");
 do_option_info_cell("$00.00 Always 100% Free", "",$currbg, "50%");
 end_table_row();
 $currbg = switch_bgcolor($currbg);
 start_table_row();
 do_option_info_cell("xCGI Price     ", "",$currbg, "50%");
 do_option_info_cell("$00.00 Always 100% Free", "",$currbg, "50%");
 end_table_row();
 $currbg = switch_bgcolor($currbg);
 start_table_row();
 do_option_info_cell("Supplied by    ", "",$currbg, "50%");
 do_option_info_cell("CyKuH [WTN]", "",$currbg, "50%");
 end_table_row();
 $currbg = switch_bgcolor($currbg);
 start_table_row();
 do_option_info_cell("Nullified by   ", "",$currbg, "50%");
 do_option_info_cell("CyKuH [WTN]", "",$currbg, "50%");
 end_table_row();
 $currbg = switch_bgcolor($currbg);
 start_table_row();
 do_option_info_cell("Distribution   ", "",$currbg, "50%");
 do_option_info_cell("via WebForum, xCGI Forums and Forums File Dumps", "",$currbg, "50%");
 end_table_row();
 $currbg = switch_bgcolor($currbg);
 start_table_row();
 do_option_info_cell("Protection     ", "",$currbg, "50%");
 do_option_info_cell("Callhome, License Checker, Hot Links, Refferer Links", "",$currbg, "50%");
 end_table_row();
 $currbg = switch_bgcolor($currbg);
 start_table_row();
 do_option_info_cell("Language       ", "",$currbg, "50%");
 do_option_info_cell("PHP, MySQL", "",$currbg, "50%");
 end_table_row();
 $currbg = switch_bgcolor($currbg);
 start_table_row();
 do_option_info_cell("Extra Note     ", "��� ����, �� �� � ���������� :o)",$currbg, "50%");
 do_option_info_cell("&copy  WTN Team `2003     ", "WTN Team members secrets...",$currbg, "50%");
 end_table_row();
 end_table(2);
}
show_cp_footer();
?>
