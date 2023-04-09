<? 

include "config.php";
include "header.php";

if (!$step && $use_taf==1) {

?>

<TABLE ALIGN=CENTER WIDTH="100%" CELLPADDING=15 CELLSPACING=0 BORDER=0>
<TR><TD>
<FONT FACE="<? echo $font_face; ?>" Size="1"> 
<BR>
&nbsp;If you have a friend that you would like to recommend this page to, or if you just wish to send yourself a reminder, here is the easy way to do it!  
<BR><BR>
&nbsp;Simply fill in your name and e-mail address, and the e-mail address of the person(s) you wish to tell about <B><? echo "$obj->SiteName" ?></B>, and click the <B>SEND</B> button. 
<BR><BR>
&nbsp;If you want to, you can also enter a message that will be included on the e-mail. 
<BR><BR>
&nbsp;After sending the e-mail, you will be redirected back to the page you recommended! 
<BR><BR>
</FONT>

<TABLE ALIGN=CENTER WIDTH=450>
<TR><TD>
    <FORM action="recommend.php" method=post>
    <INPUT name=site type=hidden value="<? echo $site ?>">
    <INPUT name=step type=hidden value="1">
    <INPUT name=cid type=hidden value="<? echo $cid ?>">
     <TABLE align=center BGCOLOR="#3060CF" border=1 cellPadding=5 cellSpacing=0 width=100%>
      <TBODY>
       <TR>
        <TD>
         <TABLE align=center border=0 cellPadding=1 cellSpacing=0 width="100%">
          <TBODY>
           <TR>
            <TD>&nbsp;</TD>
             <TD align=middle><FONT face=<? echo $font_face; ?> size=2 color=#ffffff><B>Name</B></FONT></TD>
             <TD align=middle><FONT face=<? echo $font_face; ?> size=2 color=#ffffff><B>E-Mail Address</B></FONT>
             <TD></TD>
           </TR>
           <TR>
             <TD><FONT face=<? echo $font_face; ?> size=2 color=#ffffff><B>Your</B></FONT></TD>
             <TD><INPUT name=send_name></TD>
             <TD><INPUT name=send_email></TD>
           </TR>
           <TR>
            <TD><FONT face=<? echo $font_face; ?> size=<? echo $font_size; ?> color=#ffffff><B>Friend 1</B></FONT></TD>
            <TD><INPUT name=recipname_1></TD>
            <TD><INPUT name=recipemail_1></TD>
           </TR>
           <TR>
            <TD><FONT face=<? echo $font_face; ?> size=<? echo $font_size; ?> color=#ffffff><B>Friend 2</B></FONT></TD>
            <TD><INPUT name=recipname_2></TD>
            <TD><INPUT name=recipemail_2></TD>
           </TR>
           <TR>
            <TD><FONT face=<? echo $font_face; ?> size=<? echo $font_size; ?> color=#ffffff><B>Friend 3</B></FONT></TD>
            <TD><INPUT name=recipname_3></TD>
            <TD><INPUT name=recipemail_3></TD>
           </TR>
           <TR>
            <TD><FONT face=<? echo $font_face; ?> size=<? echo $font_size; ?> color=#ffffff><B>Friend 4</B></FONT></TD>
            <TD><INPUT name=recipname_4></TD>
            <TD><INPUT name=recipemail_4></TD>
           </TR>
           <TR>
            <TD><FONT face=<? echo $font_face; ?> size=<? echo $font_size; ?> color=#ffffff><B>Friend 5</B></FONT></TD>
            <TD><INPUT name=recipname_5></TD>
            <TD><INPUT name=recipemail_5></TD>
           </TR>
           <TR>
            <TD>&nbsp;</TD>
            <TD align=middle colSpan=2><B><FONT face=<? echo $font_face; ?> size=2 color=#ffffff>Your Message</FONT></B>
               <BR><TEXTAREA cols=40 name=message rows=5 wrap=virtual></TEXTAREA>
               <BR><BR><INPUT name=submit type=submit value="    SEND!    "> 
                       <INPUT type=reset value="    Reset    ">
            </TD>
           </TR>
          </TBODY>
         </TABLE>
            </TD>
           </TR>
          </TBODY>
         </TABLE>
        </FORM>
</TD></TR></TABLE>

</TD></TR></TABLE>
<?
}

if ($submit && $REQUEST_METHOD=="POST" && $use_taf==1)
{

	$query = mysql_db_query ($dbname,"Select title from top_user where sid=$site",$db) or die (mysql_error());
	$rows = mysql_fetch_array($query);

$msg = $send_name." stopped by ".$top_name."
and suggested that you might be interested in visiting the following URL:\n"
.$url_to_folder."/out.php?site=".$site."\n"
.$url_to_folder."/index.php?cat=".$cid;

if ($message) {
$msg.="
Here's $send_name's personal message to you ...
-----------------------------------------------
$message
-----------------------------------------------
";}

$msg.="
Encontre seu Amor na velocidade da Internet => http://www.amorajato.com.br";

if (check_email_addr($send_email) == 1 && $send_name) {
	if (check_email_addr($recipemail_1) == 1 && $recipname_1) {mail($recipemail_1,$r_subject,"Hi $recipname_1\n".$msg,"From: $send_email\nReply-To: $send_email");}
	if (check_email_addr($recipemail_2) == 1 && $recipname_2) {mail($recipemail_2,$r_subject,"Hi $recipname_2\n".$msg,"From: $send_email\nReply-To: $send_email");}
	if (check_email_addr($recipemail_3) == 1 && $recipname_3) {mail($recipemail_3,$r_subject,"Hi $recipname_3\n".$msg,"From: $send_email\nReply-To: $send_email");}
	if (check_email_addr($recipemail_4) == 1 && $recipname_4) {mail($recipemail_4,$r_subject,"Hi $recipname_4\n".$msg,"From: $send_email\nReply-To: $send_email");}
	if (check_email_addr($recipemail_5) == 1 && $recipname_5) {mail($recipemail_5,$r_subject,"Hi $recipname_5\n".$msg,"From: $send_email\nReply-To: $send_email");}
}

echo "  <BR><BR><CENTER>
	<font face=\"verdana\" size=\"2\" color=\"red\">\"$rows[title]\"</font> <font face=\"verdana\" size=\"2\">has been successfully sent to your friend(s).<BR><BR>
	Thanks for using ".$top_name." \"Recommend-it\" service !</font><BR><BR>
	<A HREF=\"".$url_to_folder."\">Clique aqui para retornar ".$top_name." Homepage</A>
	</CENTER>";

}
include "footer.php";
?>
