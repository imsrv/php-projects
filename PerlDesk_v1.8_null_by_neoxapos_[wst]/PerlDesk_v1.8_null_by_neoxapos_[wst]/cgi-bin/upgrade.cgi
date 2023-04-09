#!/usr/bin/perl
# Please direct bug reports,suggestions or feedback to the perldesk forums.       #
# www.perldesk.com/board                                                          #
#                                                                                 #
# (c) PerlDesk (JBSERVE LTD) 2002/2003                                            #
# PerlDesk is protected under copyright laws and cannot be resold, redistributed  # 
# in any form without prior written permission from JBServe LTD.                  #
#                                                                                 #
# This program is commercial and only licensed customers may have an installation #
###################################################################################  
 use DBI;
 use CGI;

 use lib 'include/mods';
 require "include/conf.cgi";
 
   $dbh  =  DBI->connect("DBI:mysql:$dbname:$dbhost","$dbuser","$dbpass");
   $q    =  CGI->new();   

   print $q->header();

 
  &action if  $q->param('version'); 
  &form   if !$q->param('version');


sub action 
 {
 
# Perform the database Upgrade

 if ($q->param('version') == "1.5.5")
  {

                 $dbh->do(qq{ALTER TABLE staff ADD `id` SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST});
	 $rv  =  $dbh->do(qq{INSERT INTO settings values ("global_form", "0")});
	 $rv  =  $dbh->do(qq{INSERT INTO settings values ("pager", "0")});
	 $rv  =  $dbh->do(qq{INSERT INTO settings values ("pageraddr", "")});

	 $rv  =  $dbh->do(qq{INSERT INTO settings values ("sess_ip", "1")});
	 $rv  =  $dbh->do(qq{INSERT INTO settings values ("kb_req_user", "0")});

   $progress .= "Creating Blocked Entries Table...";
   $sql6df    = qq|CREATE TABLE blocked_email (
                       `id` SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, 
                       `address` VARCHAR(255) NOT NULL,
                       `type` VARCHAR(255) NOT NULL
                      ) 
                  |;
 
   $dbh->do($sql6df);


   $dbh->do(qq|DROP TABLE IF EXISTS files|);

   $dbh->do(qq|CREATE TABLE `files` (
                   `id` SMALLINT( 5 ) UNSIGNED NOT NULL AUTO_INCREMENT,
                   `cid` VARCHAR( 255 ) NOT NULL ,
                   `nid` VARCHAR( 255 ) NOT NULL ,
                   `filename` VARCHAR( 255 ) NOT NULL ,
                   `file` LONGTEXT NOT NULL,
                    PRIMARY KEY  (id)
                   ) TYPE=MyISAM|);


   $progress .= "Creating settings extra Table...";
   $sql10    = qq| CREATE TABLE settings_extra (
                       setting varchar(50) default NULL,
                       value varchar(225) default NULL
                    ) TYPE=MyISAM
                 |;

    $dbh->do($sql10);
    $progress .= "[ OK ] <br>";



   $progress .= "Creating reviews Table...";
   $sql8    = qq| CREATE TABLE reviews (
                      id smallint(5) unsigned NOT NULL auto_increment,
                      owner varchar(255) default NULL,
                      staff varchar(255) default NULL,
                      nid varchar(255) default NULL,
                      rating varchar(255) default NULL,
                      comments text,
                    PRIMARY KEY  (id)
                    ) TYPE=MyISAM
                 |;

   $dbh->do($sql8);
   $progress .= "[ OK ] <br>";

	 $rv  =  $dbh->do(qq{INSERT INTO settings_extra values ("staff_rating", "1")});
                 $dbh->do(qq{ALTER TABLE calls ADD `key` VARCHAR( 255 ) NOT NULL});
                 $dbh->do(qq{ALTER TABLE notes ADD `key` VARCHAR( 255 ) NOT NULL AFTER `time`});
         $rv  =  $dbh->do(qq{INSERT INTO settings_extra values ("file_path", "")});
	 $rv  =  $dbh->do(qq{INSERT INTO settings_extra values ("access_submit", "1")});
	 $rv  =  $dbh->do(qq{INSERT INTO settings_extra values ("access_view", "1")});
	 $rv  =  $dbh->do(qq{INSERT INTO settings_extra values ("access_respond", "1")});
         $rv  =  $dbh->do(qq{INSERT INTO settings_extra values ("access_rate", "1")});

	$statemente = 'SELECT * FROM notes WHERE owner = "1"';  	$sth = $dbh->prepare($statemente) or die print "Couldn't prepare statement: $DBI::errstr; stopped";  	$sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped"; 	      while(my $ref = $sth->fetchrow_hashref()) 
                {
                   my $author = $ref->{'author'};
                   my $id     = $ref->{'id'}; 
                   my $sid;

                      	$tatemente = 'SELECT id,username FROM staff WHERE username = ?';                     	$th = $dbh->prepare($tatemente) or die print "Couldn't prepare statement: $DBI::errstr; stopped";                  	$th->execute( $author ) or die print "Couldn't execute statement: $DBI::errstr; stopped"; 	                      while(my $ef = $th->fetchrow_hashref()) 
                                  {
                                       $sid = $ef->{'id'};
                                  }
                      $dbh->do(qq|UPDATE notes SET author = "$sid" WHERE id = "$id"|);
                 }
}


if (($q->param('version') == "1.6") || ($q->param('version') == "1.5.5"))
  {

                 $dbh->do(qq|ALTER TABLE `staff` ADD `lpage` VARCHAR( 255 ) NOT NULL|);
	 $rv  =  $dbh->do(qq{INSERT INTO settings_extra values ("use_smtp", "0")});
	 $rv  =  $dbh->do(qq{INSERT INTO settings_extra values ("smtp_address", "")});
	 $rv  =  $dbh->do(qq{INSERT INTO settings_extra values ("smtp_port", "25")});
                 $dbh->do(qq|ALTER TABLE `departments` CHANGE `level` `level` VARCHAR( 255 ) DEFAULT NULL|); 
  }


if (($q->param('version') == "1.6") || ($q->param('version') == "1.5.5") || ($q->param('version') == "1.7"))
  {

                 $dbh->do(qq|ALTER TABLE `staff` ADD `play_sound` CHAR(1) NOT NULL|);

                      	$tatemente = 'SELECT * FROM ticket_fields WHERE (name = "email" OR name ="e mail" OR name = "e-mail")';                     	$th = $dbh->prepare($tatemente) or die print "Couldn't prepare statement: $DBI::errstr; stopped";                  	$th->execute( ) or die print "Couldn't execute statement: $DBI::errstr; stopped"; 	                      while(my $ef = $th->fetchrow_hashref()) 
                                  {        
                                        $dbh->do(qq|DELETE FROM call_fields WHERE fid = "$ef->{'id'}"|);
                                  } 
  }


if (($q->param('version') == "1.7") || ($q->param('version') == "1.6") || ($q->param('version') == "1.5.5") || ($q->param('version') == "1.7"))
  { 
           $dbh->do(qq|ALTER TABLE `notes` CHANGE `key` `ikey` VARCHAR( 255 ) DEFAULT NULL|);
           $dbh->do(qq|ALTER TABLE `calls` CHANGE `key` `ikey` VARCHAR( 255 ) DEFAULT NULL|);
  

        foreach(qw/announce blocked_email call_fields calls departments em_forwarders files kb_cat kb_entries messages notes preans reviews settings settings_extra staff staffactive stafflogin staffread ticket_fields user_events users/)
         {
             my $sql = 'ALTER TABLE ' . $_ . ' RENAME TO perlDesk_' . $_;
                $dbh->do(qq|$sql|);
         }

   $progress .= "Creating Blocked Entries Table...";
   $dbh->do(qq|DROP TABLE IF EXISTS perlDesk_activitylog|);
   $sql6dfs    = qq|CREATE TABLE perlDesk_activitylog (
                       `id` SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, 
                       `cid` VARCHAR(255) NOT NULL,
                       `date` VARCHAR(255) NOT NULL,
                       `user` VARCHAR(255) NOT NULL,
                       `action` VARCHAR(255) NOT NULL
                      ) 
                  |;
 
   $dbh->do($sql6dfs);
   $progress .= "[ OK ] <br>";


      # OPTIMIZE DATABASE

          $dbh->do(qq|ALTER TABLE `perlDesk_calls` CHANGE `status` `status` ENUM( 'OPEN', 'CLOSED', 'HOLD' ) DEFAULT 'OPEN' NOT NULL|);
          $dbh->do(qq|ALTER TABLE `perlDesk_notes` CHANGE `id` `id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT|);
          $dbh->do(qq|ALTER TABLE `perlDesk_notes` CHANGE `call` `call` INT( 11 ) DEFAULT NULL|);



          $dbh->do(qq|ALTER TABLE `perlDesk_calls` ADD `time_spent` VARCHAR( 255 ) NOT NULL AFTER `an`|);
          $dbh->do(qq|ALTER TABLE `perlDesk_calls` ADD `is_locked` VARCHAR( 255 ) NOT NULL AFTER `time_spent`|);
          $dbh->do(qq|ALTER TABLE `perlDesk_staff` ADD `llogin` VARCHAR( 255 ) NOT NULL AFTER `play_sound`|);  
          $dbh->do(qq|ALTER TABLE `perlDesk_notes` ADD `poster_ip` VARCHAR( 255 ) NOT NULL AFTER `comment`|);                  
          $dbh->do(qq{INSERT INTO perlDesk_settings_extra values ("signup_notification", "0")});
          $dbh->do(qq|ALTER TABLE `perlDesk_settings_extra` CHANGE `value` `value` text DEFAULT NULL|); 
	 $rv  =  $dbh->do(qq{INSERT INTO perlDesk_settings_extra values ("em_header", "")});
	 $rv  =  $dbh->do(qq{INSERT INTO perlDesk_settings_extra values ("em_footer", "")});
	 $rv  =  $dbh->do(qq{INSERT INTO perlDesk_settings_extra values ("pass_chars", "6")});

                      	$tatemente = 'SELECT * FROM perlDesk_settings WHERE setting = "imgbase"';                     	$th = $dbh->prepare($tatemente) or die print "Couldn't prepare statement: $DBI::errstr; stopped";                  	$th->execute( ) or die print "Couldn't execute statement: $DBI::errstr; stopped"; 	                      while(my $ef = $th->fetchrow_hashref()) 
                                  {  $imgbase = $ef->{'value'}; } 

         $license = $q->param('license');

    $progress .= "Creating pop server Table...";
    $dbh->do(qq|DROP TABLE IF EXISTS perlDesk_popservers|);
    $sql15d    = qq|CREATE TABLE perlDesk_popservers (
                       id SMALLINT( 5 ) UNSIGNED NOT NULL AUTO_INCREMENT,
                       pop_host VARCHAR( 255 ) NOT NULL ,
                       pop_user VARCHAR( 255 ) NOT NULL ,
                       pop_password VARCHAR( 255 ) NOT NULL ,
                       pop_port VARCHAR(5) NOT NULL,
                       PRIMARY KEY  (id)
                     ) TYPE=MyISAM|;

    $dbh->do($sql15d);
    $progress .= "[ OK ] <br>";

##

    $progress .= "Creating ticket fields table...";
    $dbh->do(qq|DROP TABLE IF EXISTS perlDesk_signup_fields|);
    $sql1216 = qq|CREATE TABLE perlDesk_signup_fields (
                   id smallint(5) unsigned NOT NULL auto_increment,
                   name varchar(255) default NULL,
                   value varchar(255) default NULL,
                   dorder varchar(10) default NULL,
                   PRIMARY KEY (id)
                  ) TYPE=MyISAM
                 |;

    $dbh->do($sql1216);
    $progress .= "[ OK ] <br>";



    $progress .= "Creating ticket fields table...";

   $dbh->do(qq|DROP TABLE IF EXISTS perlDesk_signup_values|);
    $sql12162 = qq|CREATE TABLE perlDesk_signup_values (
                   id smallint(5) unsigned NOT NULL auto_increment,
                   cid varchar(10) default NULL,
                   sid varchar(10) default NULL,
                   value varchar(255) default NULL,
                   PRIMARY KEY (id)
                  ) TYPE=MyISAM
                 |;

    $dbh->do($sql12162);
    $progress .= "[ OK ] <br>";

##
    $dbh->do(qq|INSERT INTO `perlDesk_signup_fields` (`id`, `name`, `value`, `dorder`) VALUES ('', 'Company', '{company}', '1')|);
    $dbh->do(qq|INSERT INTO `perlDesk_signup_fields` (`id`, `name`, `value`, `dorder`) VALUES ('', 'URL', '{url}', '2')|);


                      	$tatemente = 'SELECT id,company,url FROM perlDesk_users';                     	$th = $dbh->prepare($tatemente) or die print "Couldn't prepare statement: $DBI::errstr; stopped";                  	$th->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped"; 	                      while(my $ef = $th->fetchrow_hashref()) 
                                  {
                                         $userid  = $ef->{'id'};
                                         $company = $ef->{'company'};
                                         $url     = $ef->{'url'};

                                        my $sth = $dbh->prepare( "INSERT INTO perlDesk_signup_values VALUES ( ?, ?, ?, ? )" ) or die $DBI->errstr;
                                           $sth->execute( "NULL", $userid, "1", "$company" ) or die $DBI->errstr;              

                                        my $fth = $dbh->prepare( "INSERT INTO perlDesk_signup_values VALUES ( ?, ?, ?, ? )" ) or die $DBI->errstr;
                                           $fth->execute( "NULL", $userid, "2", "$url" ) or die $DBI->errstr; 
 
                                  }



	 $rv  =  $dbh->do(qq{INSERT INTO perlDesk_settings values ("logo_url", "$imgbase/logo.gif")});
	 $rv  =  $dbh->do(qq{INSERT INTO perlDesk_settings values ("license_id", "$license")});

     my $del_fields = $q->param('remove');

       if ($del_fields == "1")
           {
                $dbh->do(qq|DELETE FROM perlDesk_ticket_fields WHERE name = "Company"|);
                $dbh->do(qq|DELETE FROM perlDesk_ticket_fields WHERE name = "Url"|);
           }
   }
  print "PERLDESK UPGRADE COMPLETE\n===========================<br><Br>";
  print "Thank you - You may now remove this file and login to your administration\n";   
 
}


sub form {

# Which Version?

print qq|<html>
<head>
<title>PerlDesk Upgrade</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#FFFFFF" text="#000000">
<p>&nbsp;</p>
<form name="form1" method="post" action="upgrade.cgi">
  <table width="450" border="0" cellspacing="1" cellpadding="2" align="center">
    <tr> 
      <td height="44" colspan="2"><font size="4" face="Trebuchet MS, Arial, Verdana"><b>PerlDesk: 
        1.8 Upgrade </b></font></td>
    </tr>
    <tr> 
      <td height="52" colspan="2"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Please 
        run this upgrade file. Then replace all of the files in the perldesk folder, 
        using the tar file downloaded. There are also new image files, please 
        ensure to upload them to your images directory. </font></td>
    </tr>
    <tr> 
      <td width="8">&nbsp;</td>
      <td width="431">&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Please 
        choose the version from which you are upgrading</font><font face="Verdana, Arial, Helvetica, sans-serif" size="2">&nbsp;</font></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td bgcolor="#DADDE7"> <input type="radio" name="version" value="1.7"> <font size="1" face="Verdana, Arial, Helvetica, sans-serif">1.7</font></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td bgcolor="#DADDE7"> <input type="radio" name="version" value="1.6"> <font size="1" face="Verdana, Arial, Helvetica, sans-serif">1.6</font></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td bgcolor="#DADDE7"> <input type="radio" name="version" value="1.5.5"> 
        <font size="1" face="Verdana, Arial, Helvetica, sans-serif">1.5.5 </font></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="2"><table width="100%" border="0" cellspacing="1" cellpadding="6" align="center" bgcolor="#FFFFFF" bordercolorlight="#CCCCCC">
          <tr bgcolor="#BEC4D6"> 
            <td height="25" colspan="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Ticket 
              Fields </b></font></td>
          </tr>
          <tr bgcolor="#F0F0F0"> 
            <td height="114" colspan="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">The 
              registration system in 1.8 includes some major changes from previous 
              versions, two fields on the web based submission form will NOT be 
              pre-filled with user data as previously was the case, these fields 
              are 'URL' and 'COMPANY' - You may remove them if you wish by ticking 
              the checkbox below. They can be re-added at a later date in the 
              admin.</font></td>
          </tr>
          <tr bgcolor="#F0F0F0"> 
            <td width="38%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>REMOVE 
              FIELDS</strong></font></td>
            <td width="62%"><input name="remove" type="checkbox" id="remove" value="1"></td>
          </tr>
        </table>
        <br>
        <table width="100%" border="0" cellspacing="1" cellpadding="6" align="center" bgcolor="#FFFFFF" bordercolorlight="#CCCCCC">
          <tr bgcolor="#BEC4D6"> 
            <td height="25" colspan="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>PerlDesk 
              License Information</b></font></td>
          </tr>
          <tr bgcolor="#F0F0F0"> 
            <td width="38%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">License 
              ID </font></td>
            <td width="62%"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"> 
              <input type="text" name="license">
              </font></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="2"> <div align="center"> 
          <input type="hidden" name="action" value="up">
          <input type="submit" name="Submit" value="Submit">
        </div></td>
    </tr>
  </table>
</form>
</body>
</html>
|;

      }