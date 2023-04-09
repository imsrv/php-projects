#!/usr/bin/perl
###################################################################################
#                                                                                 #
#                   PerlDesk - Customer Help Desk Software                        #
#                                                                                 #
###################################################################################
#                                                                                 #
#     Author: John Bennett                                                            #
#      Email: j.bennett@perldesk.com                                              #
#        Web: http://www.perldesk.com                                             #
#   Filename: install.cgi                                                         #
#    Details: The installation file                                               #
#    Release: 1.8                                                                 #
#   Revision: 1                                                                   #
#                                                                                 #
###################################################################################
# Please direct bug reports,suggestions or feedback to the perldesk forums.       #
# www.perldesk.com/board                                                          #
#                                                                                 #                                                                                 #
# (c) PerlDesk (JBSERVE LTD) 2002/2003                                            #
# PerlDesk is protected under copyright laws and cannot be resold, redistributed  #
# in any form without prior written permission from JBServe LTD.                  #
#                                                                                 #
# This program is commercial and only licensed customers may have an installation #
###################################################################################

  BEGIN
   {
       eval 'use CGI qw(:standard)'    or $error .= "Perl Module CGI.pm is not installed\n";
       eval 'use Digest::MD5'          or $error .= "Perl Module Digest::MD5 is not installed\n";
       eval 'use DBI'                  or $error .= "Perl Module DBI/DBD::MySQL is not installed\n";
   }

eval
 {
   require "include/conf.cgi";

   use lib 'include/mods';
   $dbh   =  DBI->connect("DBI:mysql:$dbname:$dbhost","$dbuser","$dbpass") or script_fatal("Sorry, PerlDesk was unable to establish a connection with the database. Please check that you have set the variables in the conf.cgi file correctly<br><br><i>include/conf.cgi - Unable to establish database connection</i><br><br><b>Possible Causes<br><ul><li>Invalid Database Name/Username/Password Specified</li><li>Database Fields not entered in configuration file</li><li>Database is not running</li></ul>");
   $q     =  CGI->new();

   &navigate();
 };


if ($@ || defined $error)
     {
        print "Content-type: text/plain\n\n";
        print "\nFATAL PERLDESK INSTALL ERROR\n==========================================\n";
        print $@ $error;
        print "\n\n\nIf the above error indicates a 'Can't locate X' You may be missing a\nPerl module on this server, which can be obtained from http://search.cpan.org\n\nPlease email PerlDesk Suport along with your license ID to obtain\nhelp, or visit our support forums.\n";
     }

sub navigate
 {
    if (defined $q->param('action'))
      {
           my $action = $q->param('action');

          &install2 if $action eq "install2";
          &install3 if $action eq "install3";
          &install4 if $action eq "install4";
      }
        else {
                &install2;
             }
 }


sub install2 {

   #~~
   # Grab Data Path

     my $path =  $ENV{'SCRIPT_FILENAME'};
        $path =~ s/\/install.cgi//gi;

   #~~
   # Grab Base URL

    my $burl =  $ENV{'SERVER_NAME'} . $ENV{'REQUEST_URI'};
       $burl =~ s/\/install.cgi//gi;

   #~~
   # Sendmail Path

       $sendmails = `whereis sendmail`;
       @sendmailc = split(' ',$sendmails);
       $sendmail  = $sendmailc[1];

   my $html = qq|<form action="install.cgi" method="post">
  <table width="100%" border="0" cellspacing="0" cellpadding="4" align="center">
    <tr>
      <td>&nbsp;</td>
      <td><font size="2" face="Trebuchet MS, Tahoma"><strong>Thank you</strong>
        for downloading and installing PerlDesk 1.8. By completing the installation
        below you agree to the terms of the license outlined on the PerlDesk
        site. <br>
        <br>
        <strong><font color="#990000">Database Warning !! </font><br>
        </strong>If you are intending to upgrade from a previous version, please
        run the upgrade.cgi - Any existing perldesk data in the database will
        be overwritten!</font></td>
    </tr>
    <tr valign="bottom">
      <td colspan="2"> <hr></td>
    </tr>
    <tr>
      <td colspan="2" height="30"><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="25%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>License
              ID </strong></font></td>
            <td width="75%"> <input name="license" type="text" class="tbox" id="license" size="35">
            </td>
          </tr>
          <tr>
            <td width="25%" height="42">&nbsp;</td>
            <td width="75%" height="42"> <font size="2" face="Verdana, Arial, Helvetica, sans-serif">Please
              enter your license ID (Lic: WAREZSCRIPTSRULEZ) which was detailed in your purchase email,
              it is essential that you enter this correctly. </font></td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td colspan="2" height="30"><hr></td>
    </tr>
    <tr>
      <td colspan="2" height="30"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><font color="#666666">General
        Settings</font></b></font></td>
    </tr>
    <tr>
      <td width="32" height="19">&nbsp;</td>
      <td width="847" height="19"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="25%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Data
              Path </font></td>
            <td width="75%"> <input type="text" name="data" class="tbox" size="35" value="$path">
            </td>
          </tr>
          <tr>
            <td width="25%" height="42">&nbsp;</td>
            <td width="75%" height="42"> <table width="90%" border="0" cellspacing="1" cellpadding="0">
                <tr bgcolor="#D1D1D1">
                  <td height="19" bgcolor="#000000"> <table width="100%" border="0" cellspacing="1" cellpadding="2">
                      <tr bgcolor="#F5F5F5">
                        <td bgcolor="#D9DBE8"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">This
                          is the full system path to the main perldesk files (pdesk.cgi/staff.cgi/admin/cgi)
                          There should be no trailing / </font></td>
                      </tr>
                    </table></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td width="25%" height="34"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Image
              URL </font></td>
            <td width="75%" height="34"> <input type="text" name="imgbase" size="35" class="tbox" value="http://yoursite.com/images">
            </td>
          </tr>
          <tr>
            <td width="25%" height="35">&nbsp;</td>
            <td width="75%" height="35"> <table width="90%" border="0" cellspacing="1" cellpadding="0">
                <tr bgcolor="#D1D1D1">
                  <td bgcolor="#000000"> <table width="100%" border="0" cellspacing="1" cellpadding="2">
                      <tr bgcolor="#F5F5F5">
                        <td bgcolor="#D9DBE8"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">The
                          url to the folder containing the perldesk images, no
                          ending /</font></td>
                      </tr>
                    </table></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td width="25%" height="35"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Base
              URL</font></td>
            <td width="75%" height="35"> <input type="text" name="baseurl" class="tbox" size="35" value="http://url.to/perldesk">
            </td>
          </tr>
          <tr>
            <td width="25%" height="36">&nbsp;</td>
            <td width="75%" height="36"> <table width="90%" border="0" cellspacing="1" cellpadding="0">
                <tr bgcolor="#D1D1D1">
                  <td height="19" bgcolor="#000000"> <table width="100%" border="0" cellspacing="1" cellpadding="2">
                      <tr bgcolor="#F5F5F5">
                        <td bgcolor="#D9DBE8"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">The
                          url to the 'data path' specified above, where the main
                          .cgi files are located, no ending /</font></td>
                      </tr>
                    </table></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td height="35"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Admin
              Password </font></td>
            <td height="35"> <input name="pass" type="password" class="tbox" id="pass" size="15">
            </td>
          </tr>
          <tr>
            <td height="36">&nbsp;</td>
            <td height="36"> <table width="90%" border="0" cellspacing="1" cellpadding="0">
                <tr bgcolor="#D1D1D1">
                  <td height="19" bgcolor="#000000"> <table width="100%" border="0" cellspacing="1" cellpadding="2">
                      <tr bgcolor="#F5F5F5">
                        <td bgcolor="#D9DBE8"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">You
                          will need to enter this password whenever you login
                          to the administration area</font></td>
                      </tr>
                    </table></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td height="33">&nbsp;</td>
            <td height="33">&nbsp;</td>
          </tr>
          <tr>
            <td width="25%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Help
              Desk Title</font></td>
            <td width="75%"> <input type="text" name="title" class="tbox" value="PerlDesk" size="30">
            </td>
          </tr>
          <tr>
            <td width="25%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Sendmail</font></td>
            <td width="75%"> <input type="text" name="sendmail" class="tbox" value="$sendmail" size="30">
            </td>
          </tr>
          <tr>
            <td width="25%">&nbsp;</td>
            <td width="75%">&nbsp;</td>
          </tr>
          <tr>
            <td width="25%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Default
              Language</font></td>
            <td width="75%"> <select name="language">
                <option value="en">English</option>
                <option value="fr">French</option>
                <option value="es">Spanish</option>
                <option value="no">Norweigan</option>
                <option value="sw">Swedish</option>
                <option value="gm">German</option>
              </select> </td>
          </tr>
          <tr>
            <td width="25%">&nbsp;</td>
            <td width="75%">&nbsp;</td>
          </tr>
          <tr>
            <td width="25%" valign="top"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Tracking
              Code</font></td>
            <td width="75%"> <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
                <input type="text" name="pretrack" class="tbox" value="100" size="4">
                <br>
                <font size="1">This will get be used in outgoing email subject
                lines in order to track customer responses.</font></font></p>
              <p>&nbsp;</p></td>
          </tr>
          <tr>
            <td width="25%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Admin
              Email</font></td>
            <td width="75%"> <input type="text" name="adminemail" size="40" value="$ENV{'SERVER_ADMIN'}" class="tbox">
            </td>
          </tr>
          <tr>
            <td width="25%">&nbsp;</td>
            <td width="75%">&nbsp;</td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td width="32" height="19">&nbsp;</td>
      <td width="847" height="19"> <div align="center">
          <input type="hidden" name="action" value="install3">
          <input type="hidden" name="host" value="$dbhost">
          <input type="hidden" name="database" value="$dbname">
          <input type="hidden" name="username" value="$dbuser">
          <input type="hidden" name="password" value="$dbpass">
          <input type="submit" name="Submit" value="Import Database ...">
        </div></td>
    </tr>
  </table>
</form>|;


  print "Content-type:text/html\n\n";
  template("$html");

}

sub install3 {

   my $data     = $q->param('data');
   my $imgbase  = $q->param('imgbase');
   my $baseurl  = $q->param('baseurl');
   my $title    = $q->param('title');
   my $sendmail = $q->param('sendmail');
   my $tracking = $q->param('pretrack');
   my $language = $q->param('language');
   my $adminem  = $q->param('adminemail');
   my $pass     = $q->param('pass');
   my $license  = $q->param('license');


      $data     =~ s#'\'#'\\'#g;

        my @chars    = (A..Z);
           $salt     = $chars[rand(@chars)] . $chars[rand(@chars)];
           $password = crypt($pass, $salt);

      if (-e "$data/include/tpl/default.tpl")
        {
               # OK DATA PATH IS OK
        }
      else { script_fatal("Sorry, the data path you entered does not seem to be correct, please double check that it is the full path to the PerlDesk directory, with no ending /<br><br><i>Open Template Test Failed</i><br><font size=1>$data/include/tpl/default.tpl Does Not Exist</font><br>"); }



   $progress .= "<form action=install.cgi method=post><font face=Verdana size=2>Please be patient while your database is setup<br><br> You will need to proceed to the next step at the bottom<br><br></font><font size=2 face=Courier New, Courier, mono>";
   $progress .= "Creating Announcements Table...";

   $dbh->do(qq|DROP TABLE IF EXISTS perlDesk_announce|);
   $sql1 = qq|CREATE TABLE perlDesk_announce (
                  id smallint(5) unsigned NOT NULL auto_increment,
                  author varchar(255) default NULL,
                  subject varchar(255) default NULL,
                  message text,
                  staff char(1) default NULL,
                  users char(1) default NULL,
                  time varchar(16) default NULL,
                  PRIMARY KEY  (id)
                  ) TYPE=MyISAM
              |;
    $dbh->do($sql1);
    $progress .= "[ OK ] <br>";


    $progress .= "Creating Requests Table...";
   $dbh->do(qq|DROP TABLE IF EXISTS perlDesk_calls|);
    $sql2 = qq| CREATE TABLE perlDesk_calls (
                  id smallint(5) unsigned NOT NULL auto_increment,
                  status enum('OPEN','CLOSED','HOLD') NOT NULL default 'OPEN',
                  username varchar(30) default NULL,
                  email varchar(255) default NULL,
                  priority char(1) default NULL,
                  category varchar(255) default NULL,
                  subject varchar(255) default NULL,
                  description text,
                  time varchar(20) default NULL,
                  ownership varchar(255) default NULL,
                  closedby varchar(255) default NULL,
                  method char(2) default NULL,
                  track varchar(50) NOT NULL default '',
                  active varchar(50) NOT NULL default '',
                  aw char(1) default NULL,
                  an CHAR(1) NOT NULL,
                  time_spent VARCHAR(255) NOT NULL,
                  is_locked CHAR(1) NOT NULL,
                  ikey VARCHAR(255) NOT NULL,
                PRIMARY KEY  (id),
                KEY calls_st (status)
                ) TYPE=MyISAM
              |;
    $dbh->do($sql2);
    $progress .= "[ OK ] <br>";

    $progress .= "Creating Departments Table...";
    $dbh->do(qq|DROP TABLE IF EXISTS perlDesk_departments|);
    $sql3 = qq| CREATE TABLE perlDesk_departments (
                   level varchar(255) default NULL
                ) TYPE=MyISAM
              |;

   $dbh->do($sql3);
   $progress .= "[ OK ] <br>";

   $progress .= "Creating Email Forwarding Table...";
   $dbh->do(qq|DROP TABLE IF EXISTS perlDesk_em_forwarders|);
   $sql4  = qq| CREATE TABLE perlDesk_em_forwarders (
                    address varchar(255) default NULL,
                    category varchar(255) default NULL
                 ) TYPE=MyISAM
               |;

   $dbh->do($sql4);
   $progress .= "[ OK ] <br>";


    $progress .= "Creating user events Table...";
   $dbh->do(qq|DROP TABLE IF EXISTS perlDesk_user_events|);
    $sql4b  = qq| CREATE TABLE perlDesk_user_events (
                      id smallint(5) unsigned NOT NULL auto_increment,
                      user varchar(255) default NULL,
                      time varchar(255) default NULL,
                      subject varchar(255) default NULL,
                      description text,
                      date varchar(50) default NULL,
                    PRIMARY KEY  (id)
                 ) TYPE=MyISAM
               |;
   $dbh->do($sql4b);
   $progress .= "[ OK ] <br>";

    $progress .= "Creating KB Categories Table...";
   $dbh->do(qq|DROP TABLE IF EXISTS perlDesk_kb_cat|);
    $sql5    = qq|  CREATE TABLE perlDesk_kb_cat (
                       category varchar(255) default NULL
                    ) TYPE=MyISAM
                 |;

   $dbh->do($sql5);
   $progress .= "[ OK ] <br>";


   $progress .= "Creating Blocked Entries Table...";
   $dbh->do(qq|DROP TABLE IF EXISTS perlDesk_blocked_email|);
   $sql6df    = qq|CREATE TABLE perlDesk_blocked_email (
                       `id` SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                       `address` VARCHAR(255) NOT NULL,
                       `type` VARCHAR(255) NOT NULL
                      )
                  |;

   $dbh->do($sql6df);
   $progress .= "[ OK ] <br>";


   $progress .= "Creating Activity Log Table...";
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


    $progress .= "Creating KB Entries Table...";
   $dbh->do(qq|DROP TABLE IF EXISTS perlDesk_kb_entries|);
    $sql6    = qq|  CREATE TABLE perlDesk_kb_entries (
                      id smallint(5) unsigned NOT NULL auto_increment,
                      category varchar(255) default NULL,
                      author varchar(255) default NULL,
                      subject varchar(255) default NULL,
                      description text,
                      views varchar(50) default NULL,
                    PRIMARY KEY  (id)
                    ) TYPE=MyISAM
                 |;
   $dbh->do($sql6);
   $progress .= "[ OK ] <br>";


   $progress .= "Creating Messages Table...";
   $dbh->do(qq|DROP TABLE IF EXISTS perlDesk_messages|);
   $sql7    = qq|  CREATE TABLE perlDesk_messages (
                       id SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                       touser VARCHAR(50) NOT NULL,
                       sender VARCHAR(50) NOT NULL,
                       date VARCHAR(20) NOT NULL,
                       subject VARCHAR(255) NOT NULL,
                       message TEXT NOT NULL,
                       stamp VARCHAR(20) NOT NULL
                     )
                 |;
   $dbh->do($sql7);
   $progress .= "[ OK ] <br>";


   $progress .= "Creating Notes Table...";
   $dbh->do(qq|DROP TABLE IF EXISTS perlDesk_notes|);
   $sql8    = qq| CREATE TABLE perlDesk_notes (
                      id int(10) unsigned NOT NULL auto_increment,
                      owner char(1) default NULL,
                      visible char(1) default NULL,
                      action varchar(255) default NULL,
                      call int(11) default NULL,
                      author varchar(255) default NULL,
                      time varchar(20) default NULL,
                      ikey varchar(255) default NULL,
                      comment text,
                      poster_ip varchar(40) default NULL,
                    PRIMARY KEY  (id),
                    KEY pd_owner (owner),
                    KEY pd_call (call)
                    ) TYPE=MyISAM
                 |;

   $dbh->do($sql8);
   $progress .= "[ OK ] <br>";



   $progress .= "Creating reviews Table...";
   $dbh->do(qq|DROP TABLE IF EXISTS perlDesk_reviews|);
   $sql8    = qq| CREATE TABLE perlDesk_reviews (
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


   $progress .= "Creating Pre-defined answers Table...";
   $dbh->do(qq|DROP TABLE IF EXISTS perlDesk_preans|);
   $sql9    = qq| CREATE TABLE perlDesk_preans (
                     id smallint(5) unsigned NOT NULL auto_increment,
                     author varchar(25) default NULL,
                     subject varchar(255) default NULL,
                     text text,
                     date varchar(20) default NULL,
                    PRIMARY KEY  (id)
                    ) TYPE=MyISAM
                 |;

   $dbh->do($sql9);
   $progress .= "[ OK ] <br>";


   $progress .= "Creating settings Table...";
   $dbh->do(qq|DROP TABLE IF EXISTS perlDesk_settings|);
   $sql10    = qq| CREATE TABLE perlDesk_settings (
                       setting varchar(50) default NULL,
                       value varchar(225) default NULL
                    ) TYPE=MyISAM
                 |;

    $dbh->do($sql10);
    $progress .= "[ OK ] <br>";


   $progress .= "Creating settings extra Table...";
   $dbh->do(qq|DROP TABLE IF EXISTS perlDesk_settings_extra|);
   $sql10    = qq| CREATE TABLE perlDesk_settings_extra (
                       setting varchar(50) default NULL,
                       value text default NULL
                    ) TYPE=MyISAM
                 |;

    $dbh->do($sql10);
    $progress .= "[ OK ] <br>";


    $progress .= "Creating staff Table...";
   $dbh->do(qq|DROP TABLE IF EXISTS perlDesk_staff|);
    $sql11    = qq|CREATE TABLE perlDesk_staff (
                      id smallint(5) unsigned NOT NULL auto_increment,
                      username varchar(20) default NULL,
                      password varchar(255) default NULL,
                      name varchar(50) default NULL,
                      email varchar(50) default NULL,
                      access varchar(255) default NULL,
                      notify char(1) default NULL,
                      responsetime varchar(20) default NULL,
                      callsclosed varchar(10) default NULL,
                      signature text,
                      rkey char(2) default NULL,
                      lpage varchar(255) default NULL,
                      play_sound char(1) default NULL,
                      llogin varchar(255) default NULL,
                    PRIMARY KEY  (id)
                    ) TYPE=MyISAM
                 |;
    $dbh->do($sql11);
    $progress .= "[ OK ] <br>";


    $progress .= "Creating staff active Table...";
   $dbh->do(qq|DROP TABLE IF EXISTS perlDesk_staffactive|);
    $sql12    = qq|  CREATE TABLE perlDesk_staffactive (
                        username varchar(20) NOT NULL default '',
                        date varchar(20) NOT NULL default ''
                     ) TYPE=MyISAM
                 |;

    $dbh->do($sql12);
    $progress .= "[ OK ] <br>";



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



    $progress .= "Creating staff login Table...";
   $dbh->do(qq|DROP TABLE IF EXISTS perlDesk_stafflogin|);
    $sql13    = qq|  CREATE TABLE perlDesk_stafflogin (
                        username varchar(50) default NULL,
                        date varchar(20) default NULL
                     ) TYPE=MyISAM
                 |;

    $dbh->do($sql13);
    $progress .= "[ OK ] <br>";


    $progress .= "Creating staff read Table...";
   $dbh->do(qq|DROP TABLE IF EXISTS perlDesk_staffread|);
    $sql14    = qq| CREATE TABLE perlDesk_staffread (
                       username varchar(50) NOT NULL default '',
                       date varchar(20) NOT NULL default ''
                     ) TYPE=MyISAM
                 |;

    $dbh->do($sql14);
    $progress .= "[ OK ] <br>";

    $progress .= "Creating users Table...";
   $dbh->do(qq|DROP TABLE IF EXISTS perlDesk_users|);
    $sql15    = qq| CREATE TABLE perlDesk_users (
                      id smallint(5) unsigned NOT NULL auto_increment,
                        username varchar(30) default NULL,
                        password varchar(255) default NULL,
                        name varchar(50) default NULL,
                        email varchar(50) default NULL,
                        url varchar(50) default NULL,
                        company varchar(50) default NULL,
                        rkey varchar(5) default NULL,
                        pending CHAR(1) NOT NULL,
                        active varchar(50) default NULL,
                        acode varchar(50) default NULL,
                        lcall varchar(255) NOT NULL,
                      PRIMARY KEY  (id)
                      ) TYPE=MyISAM
                 |;


    $dbh->do($sql15);
    $progress .= "[ OK ] <br>";


    $progress .= "Creating files Table...";
    $dbh->do(qq|DROP TABLE IF EXISTS perlDesk_files|);
    $sql15d    = qq|CREATE TABLE perlDesk_files (
                       id SMALLINT( 5 ) UNSIGNED NOT NULL AUTO_INCREMENT,
                       cid VARCHAR( 255 ) NOT NULL ,
                       nid VARCHAR( 255 ) NOT NULL ,
                       filename VARCHAR( 255 ) NOT NULL ,
                      `file` VARCHAR(255) NOT NULL,
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


    $progress .= "Creating ticket fields table...";
   $dbh->do(qq|DROP TABLE IF EXISTS perlDesk_ticket_fields|);
    $sql116 = qq|CREATE TABLE perlDesk_ticket_fields (
                   id smallint(5) unsigned NOT NULL auto_increment,
                   name varchar(255) default NULL,
                   value varchar(255) default NULL,
                   dorder varchar(10) default NULL,
                   PRIMARY KEY (id)
                  ) TYPE=MyISAM
                 |;

    $dbh->do($sql116);
    $progress .= "[ OK ] <br>";


    $progress .= "Creating call fields table...";

   $dbh->do(qq|DROP TABLE IF EXISTS perlDesk_call_fields|);
    $sql117 = qq|CREATE TABLE perlDesk_call_fields (
  id smallint(5) unsigned NOT NULL auto_increment,
  cid varchar(255) default NULL,
  fid varchar(255) default NULL,
  value text,
  PRIMARY KEY  (id)
) TYPE=MyISAM
|;
    $dbh->do($sql117);
    $progress .= "[ OK ] <br>";


    $dbh->do(qq|INSERT INTO `perlDesk_signup_fields` (`id`, `name`, `value`, `dorder`) VALUES ('', 'Company', '{company}', '1')|);
    $dbh->do(qq|INSERT INTO `perlDesk_signup_fields` (`id`, `name`, `value`, `dorder`) VALUES ('', 'URL', '{url}', '2')|);

    $dbh->do(qq{INSERT INTO perlDesk_settings VALUES ('reqvalid', '0')});

  my $query1 = qq|INSERT INTO perlDesk_settings VALUES ('ereqreg', '0')|;
     $rv     = $dbh->do(qq{$query1});

  my $query2 = qq|INSERT INTO perlDesk_settings VALUES ('pri1', '#F1F1F8')|;
     $rv     = $dbh->do(qq{$query2});

  my $query3 = qq|INSERT INTO perlDesk_settings VALUES ('pri2', '#F1F1F8')|;
     $rv     = $dbh->do(qq{$query3});

  my $query4 = qq|INSERT INTO perlDesk_settings VALUES ('pri3', '#F1F1F8')|;
     $rv     = $dbh->do(qq{$query4});

  my $query5 = qq|INSERT INTO perlDesk_settings VALUES ('pri4', '#F1F1F8')|;
     $rv     = $dbh->do(qq{$query5});

  my $query6 = qq|INSERT INTO perlDesk_settings VALUES ('pri5', '#F1F1F8')|;
     $rv     = $dbh->do(qq{$query6});

  my $queryv = qq|INSERT INTO perlDesk_settings VALUES ('validate', '1')|;
     $rv     = $dbh->do(qq{$queryv});

  my $query7 = qq|INSERT INTO perlDesk_settings VALUES ('sdelete', '1')|;
     $rv     = $dbh->do(qq{$query7});

  my $query8 = qq|INSERT INTO perlDesk_settings VALUES ('slock', '0')|;
     $rv     = $dbh->do(qq{$query8});

  my $query9 = qq|INSERT INTO perlDesk_settings VALUES ('avgtime', '0')|;
     $rv     = $dbh->do(qq{$query9});

  my $query10 = qq|INSERT INTO perlDesk_settings VALUES ('ssi_closed', '0')|;
     $rv      = $dbh->do(qq{$query10});

  my $query101 = qq|INSERT INTO perlDesk_settings VALUES ('timeoffset', '0')|;
     $rv       = $dbh->do(qq{$query101});

    execute_sql(qq|INSERT INTO perlDesk_staff VALUES ('', 'admin', "$password", 'admin', 'admin', 'admin', '0', '0', '0', '', "$salt", '', '', 'Never')|);

 my $query12 = qq|INSERT INTO perlDesk_ticket_fields (`id`, `name`, `value`, `dorder`) VALUES ('', 'Name', '{name}', '1')|;
     $rv      = $dbh->do(qq{$query12});


# my $query13 = qq|INSERT INTO `perlDesk_ticket_fields` (`id`, `name`, `value`, `dorder`) VALUES ('', 'Company', '{company}', '2')|;
#     $rv      = $dbh->do(qq{$query13});


# my $query15 = qq|INSERT INTO `perlDesk_ticket_fields` (`id`, `name`, `value`, `dorder`) VALUES ('', 'Url', '{url}', '4')|;
 #    $rv      = $dbh->do(qq{$query15});

          $rv  =  $dbh->do(qq{INSERT INTO perlDesk_settings values ("license_id", "$license")});
          $rv  =  $dbh->do(qq{INSERT INTO perlDesk_settings values ("data", "$data")});
          $rv  =  $dbh->do(qq{INSERT INTO perlDesk_settings values ("adminemail", "$adminem")});
         $rv  =  $dbh->do(qq{INSERT INTO perlDesk_settings values ("imgbase", "$imgbase")});
         $rv  =  $dbh->do(qq{INSERT INTO perlDesk_settings values ("baseurl", "$baseurl")});
         $rv  =  $dbh->do(qq{INSERT INTO perlDesk_settings values ("title", "$title")});
         $rv  =  $dbh->do(qq{INSERT INTO perlDesk_settings values ("sendmail", "$sendmail")});
         $rv  =  $dbh->do(qq{INSERT INTO perlDesk_settings values ("epre", "$tracking")});
         $rv  =  $dbh->do(qq{INSERT INTO perlDesk_settings values ("language", "$language")});
         $rv  =  $dbh->do(qq{INSERT INTO perlDesk_settings values ("reqvalid", "0")});
         $rv  =  $dbh->do(qq{INSERT INTO perlDesk_settings values ("floodwait", "15")});
         $rv  =  $dbh->do(qq{INSERT INTO perlDesk_settings values ("validate", "0")});
         $rv  =  $dbh->do(qq{INSERT INTO perlDesk_settings values ("pager", "0")});
         $rv  =  $dbh->do(qq{INSERT INTO perlDesk_settings values ("pageraddr", "")});
         $rv  =  $dbh->do(qq{DELETE * FROM perlDesk_ticket_fields WHERE id >= 5});
         $rv  =  $dbh->do(qq{INSERT INTO perlDesk_settings values ("global_form", "0")});
         $rv  =  $dbh->do(qq{INSERT INTO perlDesk_settings values ("kb_req_user", "0")});
         $rv  =  $dbh->do(qq{INSERT INTO perlDesk_settings values ("sess_ip", "1")});
         $rv  =  $dbh->do(qq{INSERT INTO perlDesk_settings values ("logo_url", "$imgbase/logo.gif")});
         $rv  =  $dbh->do(qq{INSERT INTO perlDesk_settings_extra values ("staff_rating", "1")});
         $rv  =  $dbh->do(qq{INSERT INTO perlDesk_settings_extra values ("use_smtp", "0")});
         $rv  =  $dbh->do(qq{INSERT INTO perlDesk_settings_extra values ("smtp_address", "")});
         $rv  =  $dbh->do(qq{INSERT INTO perlDesk_settings_extra values ("smtp_port", "25")});
         $rv  =  $dbh->do(qq{INSERT INTO perlDesk_settings_extra values ("pass_chars", "6")});
         $rv  =  $dbh->do(qq{INSERT INTO perlDesk_settings_extra values ("em_header", "")});
         $rv  =  $dbh->do(qq{INSERT INTO perlDesk_settings_extra values ("em_footer", "")});
         $rv  =  $dbh->do(qq{INSERT INTO perlDesk_settings_extra values ("signup_notification", "0")});
         $rv  =  $dbh->do(qq{INSERT INTO perlDesk_settings_extra values ("access_submit", "1")});
         $rv  =  $dbh->do(qq{INSERT INTO perlDesk_settings_extra values ("access_view", "1")});
         $rv  =  $dbh->do(qq{INSERT INTO perlDesk_settings_extra values ("access_respond", "1")});
         $rv  =  $dbh->do(qq{INSERT INTO perlDesk_settings_extra values ("access_rate", "1")});
         $rv  =  $dbh->do(qq{INSERT INTO perlDesk_settings_extra values ("file_path", "")});


    print "Content-type:text/html\n\n";
     $progress .= "</font><font face=Verdana size=2><br><br><b>SQL Setup Complete<br><br></b><input type=hidden name=action value=install4><div align=center><input type=submit name=submit value=Finish></div></form>";
    template("$progress");
 }


sub install4
 {
   $html = qq|
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2" height="27"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><font color="#990000">Congratulations!</font>
      Installation Complete</b></font></td>
  </tr>
  <tr>
    <td colspan="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Please
      access your administration panel using the details below. </font></td>
  </tr>
  <tr>
    <td rowspan="5">&nbsp;</td>
    <td width="93%">&nbsp;</td>
  </tr>
  <tr>
    <td width="93%" height="29"><font size="2" face="Courier New, Courier, mono"><a href="admin.cgi">Admin
      Login</a></font></td>
  </tr>
  <tr>
    <td rowspan="2"><font size="2" face="Courier New, Courier, mono">Username:
      admin</font></td>
  </tr>
  <tr> </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" height="8"><div align="center"><font color="#000033" size="2" face="Verdana, Arial, Helvetica, sans-serif">You
        <b>MUST</b> delete this install.cgi file before accessing the administration
        panel for security reasons.</font></div></td>
  </tr>
</table>

|;

    print "Content-type:text/html\n\n";
    template("$html");
 }



sub template
 {
   my @web = "@_";
   print qq|<html><head><title>PerlDesk Installation</title>
           <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
           <style type="text/css">
             .tbox { FONT-SIZE: 11px; FONT-FAMILY: Verdana,Arial,Helvetica,sans-serif; COLOR: #000000; BACKGROUND-COLOR: #ffffff}
           </style>
           </head><body bgcolor="#FFFFFF">
<div align="center"><b><font face="Verdana, Arial, Helvetica, sans-serif">perldesk</font></b>
  <br>
</div>
<div align="center"></div>
<br>
<table width="600" border="0" cellspacing="0" cellpadding="4" align="center">
  <tr>
    <td colspan="2" height="57"> <font size="2"><font face="Verdana, Arial, Helvetica, sans-serif"><b>PerlDesk
      1.8</b></font><b><font face="Verdana, Arial, Helvetica, sans-serif">: Installation</font></b></font></td>
  </tr>
  <tr>
    <td colspan="2">@web</td>
</tr>
</table>
</body></html>|;
   exit;
 }