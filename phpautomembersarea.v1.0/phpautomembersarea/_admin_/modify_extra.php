<?
/**********************************************************
 *             phpAutoMembersArea                         *
 *           Author:  Seiretto.com                        *
 *    phpAutoMembersArea © Copyright 2003 Seiretto.com    *
 *              All rights reserved.                      *
 **********************************************************
 *        Launch Date:  Dec 2003                          *
 *                                                        *
 *     Version    Date              Comment               *
 *     1.0       15th Dec 2003      Original release      *
 *                                                        *
 *  NOTES:                                                *
 *        Requires:  PHP 4.2.3 (or greater)               *
 *                   and MySQL                            *
 **********************************************************/
$phpAutoMembersArea_version="1.0";
// ---------------------------------------------------------
$id_input="<input TYPE=\"hidden\" NAME=\"id\" value=\"".$row["id"]."\">";
$heardaboutusfrom = $row["heardaboutusfrom"];
$comments = $row["comments"];
$name_input="<input TYPE=\"text\" SIZE=\"20\" NAME=\"name\" maxlength=\"30\" value=\"".$row['name']."\" class=\"inputc\">";
$company_input="<input TYPE=\"text\" SIZE=\"20\" NAME=\"companyname\" maxlength=\"30\" value=\"".$row["companyname"]."\"  class=\"inputc\">";
$address_input="<textarea ROWS=\"2\" COLS=\"30\" NAME=\"address\" wrap=\"off\" class=\"inputc\">".$row["address"]."</textarea>";
$postcode_input="<input type=\"text\" name=\"postcode\" value=\"".$row["postcode"]."\" size=\"30\" maxlength=\"12\" class=\"inputc\">";
$tel_input="<input TYPE=\"text\" SIZE=\"20\" NAME=\"tel\" maxlength=\"30\" value=\"".$row["tel"]."\"  class=\"inputc\">";
$email_input="<input TYPE=\"text\" SIZE=\"40\" NAME=\"email\" maxlength=\"64\" value=\"".$row["email"]."\"  class=\"inputc\">";


?>