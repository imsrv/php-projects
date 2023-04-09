<?php

/*------------------------------------\
| AvidNews Version 1.00               |
| News/article management system      |
+-------------------------------------+
| VIEWALL.PHP ::                      |
+-------------------------------------+
| (C) Copyright 2003 Avid New Media   |
| Consult README for further details  |
+------------------------------------*/

# Include configuration script

include './config.php';

# Connect to MySQL database

mysql_connect($CONF['dbhost'], $CONF['dbuser'], $CONF['dbpass']);
mysql_select_db($CONF['dbname']);

# Get our variables into a better format

$_SUBMIT = array_merge( $HTTP_GET_VARS, $HTTP_POST_VARS );
extract( $_SUBMIT, EXTR_OVERWRITE );

# Start Gathering information
$writernum = mysql_query("SELECT COUNT(id) FROM `$CONF[table_prefix]admins`
WHERE status = \"writer\"");
$getwriter = mysql_result($writernum, 0, 0);

$adminnum = mysql_query("SELECT COUNT(id) FROM `$CONF[table_prefix]admins`
WHERE status = \"admin\"");
$getadmin = mysql_result($adminnum, 0, 0);

$catnum = mysql_query("SELECT COUNT(catid) FROM `$CONF[table_prefix]categories`");
$getcat = mysql_result($catnum, 0, 0);

$livenum = mysql_query("SELECT COUNT(headline) FROM `$CONF[table_prefix]news`
WHERE live = \"yes\"");
$getlive = mysql_result($livenum, 0, 0);

$unappnum = mysql_query("SELECT COUNT(headline) FROM `$CONF[table_prefix]news`
WHERE live = \"no\"");
$getunapp = mysql_result($unappnum, 0, 0);

# Done getting information

 echo("<TABLE WIDTH=\"100%\" CELLPADDING=\"0\" CELLSPACING=\"0\" BORDER=\"0\">
    <TR>
    <FONT SIZE=4><FONT FACE=Verdana,Arial,Times New I2>Article Management System Stats</font></font></font><br>
     <TD WIDTH=\"100%\" BGCOLOR=\"#666699\" VALIGN=\"TOP\">
      <P>
       <TABLE WIDTH=\"100%\" CELLPADDING=\"0\" CELLSPACING=\"1\" BORDER=\"0\">
        <TR>
         <TD WIDTH=\"100%\" BGCOLOR=\"WHITE\" VALIGN=TOP>
          <P>
           <TABLE WIDTH=\"100%\" CELLPADDING=\"2\" CELLSPACING=\"1\" BORDER=\"0\">
            <TR>
             <TD WIDTH=\"11%\" BGCOLOR=\"#E3E3E3\" VALIGN=\"CENTER\">
              <P ALIGN=CENTER>
               <FONT FACE=\"Arial,Helvetica,Monaco\"><FONT SIZE=\"2\"><B><FONT COLOR=\"#666699\">Writers</FONT></B></FONT></FONT></TD>
             <TD WIDTH=\"12%\" BGCOLOR=\"#E3E3E3\" VALIGN=CENTER>
              <P ALIGN=CENTER>
               <FONT FACE=\"Arial,Helvetica,Monaco\"><FONT SIZE=\"2\"><B><FONT COLOR=\"#666699\">Admins</FONT></B></FONT></FONT></TD>
             <TD WIDTH=\"14%\" BGCOLOR=\"#E3E3E3\" VALIGN=CENTER>
              <P ALIGN=CENTER>
               <FONT FACE=\"Arial,Helvetica,Monaco\"><FONT SIZE=\"2\"><B><FONT COLOR=\"#666699\">Categories</FONT></B></FONT></FONT></TD>
             <TD WIDTH=\"13%\" BGCOLOR=\"#E3E3E3\" VALIGN=CENTER>
              <P ALIGN=CENTER>
               <FONT FACE=\"Arial,Helvetica,Monaco\"><FONT SIZE=\"2\"><B><FONT COLOR=\"#666699\">Live
                Articles</FONT></B></FONT></FONT></TD>
             <TD WIDTH=\"17%\" BGCOLOR=\"#E3E3E3\" VALIGN=CENTER>
              <P ALIGN=CENTER>
               <FONT FACE=\"Arial,Helvetica,Monaco\"><FONT SIZE=\"2\"><B><FONT COLOR=\"#666699\">Unapproved
                Articles</FONT></B></FONT></FONT></TD>
            </TR>
            <TR>
             <TD WIDTH=\"11%\" VALIGN=TOP>
              <P ALIGN=CENTER>
               <FONT FACE=\"Verdana,Arial,Times New I2\"><FONT SIZE=\"1\"><a href=\"admin.php?action=admins&status=writer\">$getwriter</a></FONT></FONT></TD>
             <TD WIDTH=\"12%\" VALIGN=TOP>
              <P ALIGN=CENTER>
               <FONT FACE=\"Verdana,Arial,Times New I2\"><FONT SIZE=\"1\"><a href=\"admin.php?action=admins&status=admin\">$getadmin</FONT></FONT></TD>
             <TD WIDTH=\"14%\" VALIGN=TOP>
              <P ALIGN=CENTER>
               <FONT FACE=\"Verdana,Arial,Times New I2\"><FONT SIZE=\"1\"><a href=\"admin.php?action=categories\">$getcat</a></FONT></FONT></TD>
             <TD WIDTH=\"13%\" VALIGN=TOP>
              <P ALIGN=CENTER>
               <FONT FACE=\"Verdana,Arial,Times New I2\"><FONT SIZE=\"1\"><a href=\"admin.php?action=artviewall&em=view\">$getlive</a></FONT></FONT></TD>
             <TD WIDTH=\"17%\" VALIGN=TOP>
              <P ALIGN=CENTER>
               <FONT FACE=\"Verdana,Arial,Times New I2\"><FONT SIZE=\"1\"><a href=\"admin.php?action=artviewua&em=view\">$getunapp</a></FONT></FONT></TD>
            </TR>
           </TABLE></TD>
        </TR>
       </TABLE></TD>
    </TR>
   </TABLE>");
   ?>