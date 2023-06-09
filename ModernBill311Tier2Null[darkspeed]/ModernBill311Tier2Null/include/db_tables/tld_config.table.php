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

 /* ----------------- TLD_CONFIG ---------------------*/
      $title = TLDCONFIG;
      $parent = array(1=>"package_type");
      $args = array(array("column"         => "tld_id",
                           "required"      => 0,
                           "title"         => ID,
                           "type"          => "HIDDEN"),
                    array("column"         => "tld_extension",
                           "required"      => 1,
                           "title"         => EXTENSION,
                           "type"          => "TEXT",
                           "size"          => 5,
                           "maxlength"     => 10,
                           "append"        => "(".EXAMPLE.": com)"),
                    array("column"         => "tld_name",
                           "required"      => 1,
                           "title"         => NAME,
                           "type"          => "TEXT",
                           "size"          => 25,
                           "maxlength"     => 50),
                    array("column"         => "tld_whois_server",
                           "required"      => 1,
                           "title"         => WHOISSERVER,
                           "type"          => "TEXT",
                           "size"          => 40,
                           "maxlength"     => 255,
                           "append"        => "<br>Define the WHOIS server you want to search for this TLD extention.
                                                   Not all servers are the same and there may be more than one that will work for you.
                                               <br><br>
                                                   ModernBill supports fsocket connections:<br>
                                                   ".EXAMPLE.": \"<b>whois.internic.net</b>\"
                                                   <br><br>
                                                   And also URL based searches:<br>
                                                   ".EXAMPLE.":<br>\"http://www.some_whois_server.com/some_lookup.cgi?domain=<b>%%domain%%</b>\"
                                                   <br><i>Be sure to use the <b>%%domain%%</b> variable to be replaced at runtime with a domain name.</i>
                                               <br><br>"),
                    array("column"         => "tld_whois_response",
                           "required"      => 1,
                           "title"         => WHOISMATCH,
                           "type"          => "TEXT",
                           "size"          => 25,
                           "maxlength"     => 255,
                           "append"        => "<br>Define the string to be searched for within the results of the qhois query.
                                               <br><br>
                                                   ".EXAMPLE.": \"<b>No Match</b>\"
                                               <br><br>"),
                    array("column"         => "tld_accepted",
                           "required"      => 1,
                           "title"         => STATUS,
                           "type"          => "FUNCTION_CALL",
                           "function_call" => status_select_box($tld_accepted,"tld_accepted")),
                    array("column"         => "tld_auto_search",
                           "required"      => 0,
                           "title"         => ALLOWAUTOSEARCH,
                           "type"          => "FUNCTION_CALL",
                           "admin_only"    => 1,
                           "function_call" => true_false_radio("tld_auto_search",$tld_auto_search),
                           "append"        => "<br>Set to <b>YES</b> if you want this TLD searched in the Vortech Signup Form.
                                                   You should never have more than 2 or 3 TLDs set to <b>YES</b>.
                                                   Your connection may timeout.
                                               <br><br>"),
                    array("column"         => "tld_transfer",
                           "required"      => 1,
                           "title"         => TRANSFER,
                           "type"          => "TEXT",
                           "size"          => 6,
                           "maxlength"     => 10,
                           "append"        => "(".ENTERFORFREE.")",
                           "default_value" => "0.00"),
                    array("column"         => "tld_1y",
                           "required"      => 1,
                           "title"         => YEAR1,
                           "type"          => "TEXT",
                           "size"          => 6,
                           "maxlength"     => 10,
                           "append"        => "(".EXAMPLE.": 15.00)",
                           "default_value" => "0.00"),
                    array("column"         => "tld_2y",
                           "required"      => 1,
                           "title"         => YEAR2,
                           "type"          => "TEXT",
                           "size"          => 6,
                           "maxlength"     => 10,
                           "default_value" => "0.00"),
                    array("column"         => "tld_3y",
                           "required"      => 1,
                           "title"         => YEAR3,
                           "type"          => "TEXT",
                           "size"          => 6,
                           "maxlength"     => 10,
                           "default_value" => "0.00"),
                    array("column"         => "tld_4y",
                           "required"      => 1,
                           "title"         => YEAR4,
                           "type"          => "TEXT",
                           "size"          => 6,
                           "maxlength"     => 10,
                           "default_value" => "0.00"),
                    array("column"         => "tld_5y",
                           "required"      => 1,
                           "title"         => YEAR5,
                           "type"          => "TEXT",
                           "size"          => 6,
                           "maxlength"     => 10,
                           "default_value" => "0.00"),
                    array("column"         => "tld_6y",
                           "required"      => 1,
                           "title"         => YEAR6,
                           "type"          => "TEXT",
                           "size"          => 6,
                           "maxlength"     => 10,
                           "default_value" => "0.00"),
                    array("column"         => "tld_7y",
                           "required"      => 1,
                           "title"         => YEAR7,
                           "type"          => "TEXT",
                           "size"          => 6,
                           "maxlength"     => 10,
                           "default_value" => "0.00"),
                    array("column"         => "tld_8y",
                           "required"      => 1,
                           "title"         => YEAR8,
                           "type"          => "TEXT",
                           "size"          => 6,
                           "maxlength"     => 10,
                           "default_value" => "0.00"),
                    array("column"         => "tld_9y",
                           "required"      => 1,
                           "title"         => YEAR9,
                           "type"          => "TEXT",
                           "size"          => 6,
                           "maxlength"     => 10,
                           "default_value" => "0.00"),
                    array("column"         => "tld_10y",
                           "required"      => 1,
                           "title"         => YEAR10,
                           "type"          => "TEXT",
                           "size"          => 6,
                           "maxlength"     => 10,
                           "default_value" => "0.00"),
                    array("column"         => "registrar_id",
                           "required"      => 1,
                           "title"         => REGISTRAR,
                           "type"          => "FUNCTION_CALL",
                           "function_call" => registrar_select_box($registrar_id)),
                    array("column"         => "pack_id",
                           "required"      => 1,
                           "title"         => PACKAGE,
                           "type"          => "FUNCTION_CALL",
                           "cuttext"       => 10,
                           "function_call" => package_select_box_no_link($pack_id,NULL),
                           "link_to_parent"=> 1));

      $select_sql = "SELECT  tld_id,
                             tld_extension,
                             tld_name,
                             tld_whois_server,
                             tld_whois_response,
                             tld_auto_search,
                             registrar_id,
                             pack_id,
                             tld_accepted FROM $db_table ";

      $insert_sql = "INSERT INTO $db_table (tld_id,
                                            tld_extension,
                                            tld_name,
                                            tld_whois_server,
                                            tld_whois_response,
                                            tld_accepted,
                                            tld_auto_search,
                                            tld_transfer,
                                            tld_1y,
                                            tld_2y,
                                            tld_3y,
                                            tld_4y,
                                            tld_5y,
                                            tld_6y,
                                            tld_7y,
                                            tld_8y,
                                            tld_9y,
                                            tld_10y,
                                            registrar_id,
                                            pack_id) VALUES (NULL,
                                                             '$tld_extension',
                                                             '$tld_name',
                                                             '$tld_whois_server',
                                                             '$tld_whois_response',
                                                             '$tld_accepted',
                                                             '$tld_auto_search',
                                                             '$tld_transfer',
                                                             '$tld_1y',
                                                             '$tld_2y',
                                                             '$tld_3y',
                                                             '$tld_4y',
                                                             '$tld_5y',
                                                             '$tld_6y',
                                                             '$tld_7y',
                                                             '$tld_8y',
                                                             '$tld_9y',
                                                             '$tld_10y',
                                                             '$registrar_id',
                                                             '$pack_id')";

      $update_sql = "UPDATE $db_table SET tld_extension='$tld_extension',
                                          tld_name='$tld_name',
                                          tld_whois_server='$tld_whois_server',
                                          tld_whois_response='$tld_whois_response',
                                          tld_accepted='$tld_accepted',
                                          tld_auto_search='$tld_auto_search',
                                          tld_transfer='$tld_transfer',
                                          tld_1y='$tld_1y',
                                          tld_2y='$tld_2y',
                                          tld_3y='$tld_3y',
                                          tld_4y='$tld_4y',
                                          tld_5y='$tld_5y',
                                          tld_6y='$tld_6y',
                                          tld_7y='$tld_7y',
                                          tld_8y='$tld_8y',
                                          tld_9y='$tld_9y',
                                          tld_10y='$tld_10y',
                                          registrar_id='$registrar_id',
                                          pack_id='$pack_id' WHERE tld_id='$tld_id'";

      $delete_sql = array("DELETE FROM $db_table WHERE tld_id='$tld_id'");
?>