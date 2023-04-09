#!/usr/bin/perl

# This script handles configuration changes to the board such as: Paths,
# configuration options, and color configurations.
#
# ScareCrow (C)opyright 2001 Jonathan Bravata.
#
# This file is part of ScareCrow.
#
# ScareCrow is free software; you can redistribute it and/or modify it under
# the terms of the GNU General Public License as published by the Free
# Software Foundation; either version 2 of the License, or (at your option),
# any later version.
#
# ScareCrow is distributed in the hope that it will be useful, but WITHOUT
# ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
# FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for
# more details.
#
# You should have received a copy of the GNU General Public License along
# with ScareCrow; if not, write to the Free Software Foundation, Inc.,
# 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA.
#
# Author: Jonathan Bravata
# Revision: October 2001

require "global.cgi";
require "admin.lib";

# Check the cookie
$inf = get_cookie("mb-admin");
($cookieuser,$cookiepassword) = split(/\|/,$inf);

if(!$cookieuser) {   # Give them a chance to log in the admin cookie
  content();
  page_header("$config{'board_name'} > Configuration Editor");
  admin_login("$paths{'board_url'}config.cgi");
  page_footer();
  exit;
}

if(check_account($cookieuser,$cookiepassword) == $FALSE || perms($cookieuser,"ADMINCP") == $FALSE) {
  redirect_die("We're sorry, but your username/password combination was
  invalid or you do not have access to this area.","","4","black","You Do Not Have Access");
}

# Output the content type
content();
page_header("$config{'board_name'} > Configuration Editor");

# Determine action and pass control to the appropriate function
$action = $Pairs{'action'};

if($action eq 'board')           { boardconfigform();            }
elsif($action eq 'saveboard')    { saveboard();                  }
elsif($action eq 'path')         { pathconfigform();             }
elsif($action eq 'savepath')     { savepath();                   }
elsif($action eq 'color')        { colorconfigform();            }
elsif($action eq 'savecolors')   { savecolors();                 }
elsif($action eq 'restrict')     { username_restrictions();      }
elsif($action eq 'saverestrict') { save_username_restrictions(); }
elsif($action eq 'templateform') { template_form();              }
elsif($action eq 'edittemplate') { edit_template();              }

sub template_form {
  # Get the template from the file
  lock_open(TEMPLATE,"$cgi_path/templates/template.txt","r");
  while($in = <TEMPLATE>) { $template .= $in; }
  close(TEMPLATE);
  
  # Print the form
  print <<end;
    <table width="98%" align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="$color_config{'border_color'}"><tr><td>
      <table width="100%" border="0" cellspacing="1" cellpadding="5">
        <tr bgcolor="$color_config{'nav_top'}"><td colspan="2"><font face="Verdana" size="2"><b>&#187; Edit Board Template</b></font></td></tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Board Template</b></font></td>
	  <td><textarea name="template" cols="35" rows="15">$template</textarea></td>
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}"><td colspan="2"><font face="Verdana" size="2">
	  <p><b>Notice!</b>  The board template is the general layout of your message board.  In it you can
	  place Cascading Style Sheets (CSS), new JavaScripts, etc.  However, the delimenter for the board
	  data, <!-- BOARD DATA -->, must exist someplace within the template or you will <b>not</b> be
	  allowed to edit it.  Also, although you are not required to do so, it would be greatly appreciated
	  by the ScareCrow coders if you would leave (or place) a copyright statement for the software, and
	  a return link back to the ScareCrow homepage.</p>
	  
	  <p>Certain variables will be converted for you wherever you use them in order to create a flexible
	  template.  They are as follows:</p>
	  
	  <p><ul>
	    <li><b>$1</b> - Body background color.</li>
	    <li><b>$2</b> - Body text color.</li>
	    <li><b>$3</b> - Link color.</li>
	    <li><b>$4</b> - Active link color.</li>
	    <li><b>$5</b> - Visited link color.</li>
	    <li><b>$page_title</b> - The board-generated title for any given page.</li>
	  </ul></p>
	</font></td></tr>
	<tr bgcolor="$color_config{'nav_top'}"><td colspan="2" align="center"><input type="submit" name="submit" value="Submit Template"></td></tr>
      </table>
    </td></tr></table>
end
}

sub edit_template {
  # Get the template
  my $template = $Pairs{'template'};
  
  # Check that the required field is there someplace
  if($template !~ /<\!\-\-\s*BOARD DATA\s*\-\->/i) {
    print "<b>Error:</b> Template does not contain <!-- BOARD DATA --> field.  Please go back and add the delimenter where the board data should be placed.<br>\n";
  }
  
  # Save the template to file
  lock_open(TEMPLATE,"$cgi_path/templates/template.txt","w");
  truncate(TEMPLATE,0);   seek(TEMPLATE,0,0);
  print TEMPLATE $template;
  close(TEMPLATE);
  
  # Update the user on the progress
  print "<b>Template saved successfully!</b>.<br>\n";
}

sub boardconfigform {
  # Load the defaults
  my @d = ();  # Clear the array
  if($config{'registration_notification'} eq 'yes') { $d[0] = "checked";  }
  if($config{'announcements'} eq 'yes')             { $d[1] = "checked";  }
  if($config{'avatars'} eq 'on')                    { $d[2] = "checked";  }
  if($config{'autopasswords'} eq 'yes')             { $d[3] = "checked";  }
  if($config{'emailallposts'} eq 'yes')             { $d[4] = "checked";  }
  if($config{'post_status'} eq 'disabled')          { $d[5] = "";         } else { $d[5] = "checked"; }
  if($config{'reportmethod'} eq 'pm')               { $d[6] = "checked";  }
  if($config{'reportmethod'} eq 'email')            { $d[7] = "checked";  }
  if($config{'mail_type'} eq 'sendmail')            { $d[8] = "selected"; }
  if($config{'mail_type'} eq 'smtp')                { $d[9] = "selected"; }
  $d[10] = $config{'smtp_port'} || "25";
  if($config{'email_options'} eq 'on')              { $d[11] = "checked"; }
  if($config{'email_options'} eq 'off')             { $d[12] = "checked"; }
  if($config{'songtags'} eq 'yes')                  { $d[13] = "checked"; }
  if($config{'randomtags'} eq 'yes')                { $d[14] = "checked"; }
  if($config{'validate_users'} eq 'yes')            { $d[15] = "checked"; }
  if($config{'validate_posts'} eq 'yes')            { $d[16] = "checked"; }
                   
  
  # Print out the form
  print <<form;
    <table width="98%" align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="$color_config{'border_color'}"><tr><td>
      <form action="$paths{'board_url'}config.cgi" method="post">
      <table width="100%" border="0" cellspacing="1" cellpadding="5">
        <!-- Header: Configuration Options -->
	<tr bgcolor="$color_config{'nav_top'}"><td colspan="2"><font face="Verdana" size="3"><b>&#187; Configuration Options</b></font></td></tr>
	<!-- Board name -->
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Message Board Name</b></font></td>
	  <td><input type="text" name="board_name" value="$config{'board_name'}"></td>
	</tr>
	<!-- Board description -->
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Message Board Description</b></font></td>
	  <td><input type="text" name="board_description" value="$config{'board_description'}"></td>
	</tr>
	<!-- Website name -->
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Website Name</b></font></td>
	  <td><input type="text" name="website_name" value="$config{'website_name'}"></td>
	</tr>
	<!-- Default table width -->
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Default Table Width (pixels or %)</b></font></td>
	  <td><input type="text" name="table_width" value="$config{'table_width'}"></td>
	</tr>
	<!-- Flood Control -->
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Flood Control</b></font><br><font face="Verdana" size="1">Force all users (without the ignore flood control permission) to wait this many seconds between posts (0 for no flood control).</font></td>
	  <td><input type="text" name="floodcontrol" value="$config{'floodcontrol'}"></td>
	</tr>
	<!-- Server Time -->
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>All server times are...</b></font><br><font face="Verdana" size="1">Example: Central Standard Time (CST)</font></td>
	  <td><input type="text" name="times" value="$config{'times'}"></td>
	</tr>
	<!-- Time Offset -->
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Time Offset</b></font><br><font face="Verdana" size="1">Enter the number of hours you want the board time offset from the server time.</font></td>
	  <td><input type="text" name="time_offset" value="$config{'time_offset'}"></td>
	</tr>
	<!-- Default Time Format -->
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Time Format</b></font><br><font face="Verdana" size="1">(<a href="" onClick="openScript("$paths{'board_url'}help.cgi?topic=Timecodes"); return false;" onMouseOver="mouseit('View Time Codes'); return true;" onMouseOut="mouseit(''); return true;">help</a>)</font></td>
	  <td><input type="text" name="default_time_format" value="$config{'default_time_format'}"></td>
	</tr>
	<!-- Autolock Time (days) -->
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Autolock Time</b></font><br><font face="Verdana" size="1">The number of days before a topic is automatically locked (from users without the override permission).  A zero disables this feature.</font></td>
	  <td><input type="text" name="autolock_time" value="$config{'autolock_time'}"></td>
	</tr>
	<!-- Default User Account -->
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Default User Group</b></font><br><font face="Verdana" size="1">The group that new users are assigned to by default.</font></td>
	  <td><input type="text" name="default_user_group" value="$config{'default_user_group'}"></td>
	</tr>
	<!-- Copyright Statement -->
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Copyright Statement</b></font><br><font face="Verdana" size="1">The copyright of the web design and the content of the message board.</font></td>
	  <td><input type="text" name="copyright" value="$config{'copyright'}"></td>
	</tr>
	<!-- Default Board Logo File -->
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Board Logo</b></font><br><font face="Verdana" size="1">The default file to use for the board logo, for forums without a differing logo or areas without the option to specify a different logo.</font></td>
	  <td><input type="text" name="board_logo" value="$config{'board_logo'}"></td>
	</tr>
        <!-- Registration Notification -->
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Registration Notification</b></font><br><font face="Verdana" size="1">Would you like notification emailed to you for every registration?</font></td>
	  <td><input type="checkbox" name="registration_notification" value="yes" $d[0]> Yes</td>
	</tr>
        <!-- Announcements -->
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Announcements</b></font><br><font face="Verdana" size="1">Would you like an administrator-only announcements forum on the main page?</font></td>
	  <td><input type="checkbox" name="announcements" value="yes" $d[1]> Yes</td>
	</tr>
        <!-- Avatars -->
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Allow user avatars?</b></font></td>
	  <td><input type="checkbox" name="avatars" value="on" $d[2]> Yes</td>
	</tr>
        <!-- Allow [song] tags -->
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Allow [song] ScareCrow Code Tags?</b></font><br><font face="Verdana" size="1">Allow the [song] tag to be used to generate random song lyrics.</font></td>
	  <td><input type="checkbox" name="songtags" value="yes" $d[13]> Yes</td>
	</tr>
        <!-- Allow [random] tags -->
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Allow [random] ScareCrow Code Tags?</b></font><br><font face="Verdana" size="1">Allow [random] tags to be used to generate a random quote.</font></td>
	  <td><input type="checkbox" name="randomtags" value="yes" $d[14]> Yes</td>
	</tr>
        <!-- Autopasswords -->
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Verify Email Address?</b></font><br><font face="Verdana" size="1">Verifies the email of a registrant by emailing them their pasword.</font></td>
	  <td><input type="checkbox" name="autopasswords" value="yes" $d[3]> Yes</td>
	</tr>
        <!-- Report Method -->
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Report Method</b></font><br><font face="Verdana" size="1">When a user clicks the "report this post to the moderators", send that report via...</font></td>
	  <td><input type="radio" name="reportmethod" value="pm" $d[6]> Private Message &nbsp;&nbsp; <input type="radio" name="reportmethod" value="email" $d[7]> Email</td>
	</tr>
        <!-- Email All Posts -->
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Email All Posts</b></font><br><font face="Verdana" size="1">Would you like to receive a copy of ALL posts made to the message board to the board's email address specified for this purpose?</font></td>
	  <td><input type="checkbox" name="emailallposts" value="yes" $d[4]> Yes</td>
	</tr>
        <!-- Enabled/Disable Posting -->
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Allow Posting</b></font><br><font face="Verdana" size="1">Turn this off if you need to temporarily suspend all posting for some purpose.</font></td>
	  <td><input type="checkbox" name="post_status" value="enabled" $d[5]> Yes</td>
	</tr>
        <!-- Require User Validation? -->
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Require User Validation</b></font><br><font face="Verdana" size="1">Do you wish to have to manually validate all user accounts before they are useable?.</font></td>
	  <td><input type="checkbox" name="validate_users" value="enabled" $d[15]> Yes</td>
	</tr>
        <!-- Require Post Validation -->
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Require Post Validation</b></font><br><font face="Verdana" size="1">Do you wish to have to manually approve all posts before they are posted on the board?</font></td>
	  <td><input type="checkbox" name="validate_posts" value="enabled" $d[16]> Yes</td>
	</tr>
	<!-- Header: Email Options -->
	<tr bgcolor="$color_config{'nav_top'}"><td colspan="2"><font face="Verdana" size="3"><b>&#187; Email Options</b></font></td></tr>
	<!-- Email Options -->
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Enable Email Options</b></font><br><font face="Verdana" size="1">If you do NOT have access to sendmail or sockets on your server, you should disable email functions.  Otherwise, enable them.</font></td>
	  <td><input type="radio" name="email_options" value="on" $d[11]> Enabled &nbsp;&nbsp; <input type="radio" name="email_options" value="off" $d[12]> Disabled</td>
	</tr>
	<!-- Outgoing Email Name -->
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Outgoing Email Name</b></font><br><font face="Verdana" size="1">The name you want emails sent from the message board to appear as (often the name of the message board)</font></td>
	  <td><input type="text" name="from_email_name" value="$config{'from_email_name'}"></td>
	</tr>
	<!-- Outgoing Email Address (Reply-to Address) -->
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Outgoing (Reply-to) Email Address</b></font><br><font face="Verdana" size="1">The email address you want emails from the board to appear to come from; also the email that people will reply to. </font></td>
	  <td><input type="text" name="from_email_addr" value="$config{'from_email_addr'}"></td>
	</tr>
	<!-- Incoming Email Address -->
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Incoming Email Address</b></font><br><font face="Verdana" size="1">The email you want registation notifications and such to be sent to, if those options are toggled.</font></td>
	  <td><input type="text" name="email_in_addr" value="$config{'email_in_addr'}"></td>
	</tr>
	<!-- Outgoing Email Method -->
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Method for sending outgoing mail</b></font><br><font face="Verdana" size="1">For UNIX-based systems, sendmail is usually the best option.  If you do not have sendmail, or are under NT, and have access to sockets, SMTP is the option for you.  If you choose "sendmail", you will set the sendmail path in the PATHS configuration section.</font></td>
	  <td>
	    <select name="mail_type">
	      <option value="sendmail" $d[8]>Sendmail</option>
	      <option value="smtp" $d[9]>SMTP Server</option>
	    </select>
	  </td>
	</tr>
	<!-- SMTP Server -->
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>SMTP Server</b></font><br><font face="Verdana" size="1">The SMTP server to connect to (if your method for sending is SMTP)</font></td>
	  <td><input type="text" name="smtp_host" value="$config{'smtp_host'}"></td>
	</tr>
	<!-- SMTP Port -->
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>SMTP Server Port</b></font><br><font face="Verdana" size="1">The SMTP server to connect to (if your method for sending is SMTP)</font></td>
	  <td><input type="text" name="smtp_port" value="$d[10]"></td>
	</tr>
	<!-- Email Posts To-->
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Email All Posts To</b></font><br><font face="Verdana" size="1">If you have selected to receive a copy of ALL posts on the board, this is where you specify the email address(s) those posts will be sent to.</font></td>
	  <td><input type="text" name="emailpoststo" value="$config{'emailpoststo'}"></td>
	</tr>
	<!-- Header: Other Options -->
	<tr bgcolor="$color_config{'nav_top'}"><td colspan="2"><font face="Verdana" size="3"><b>&#187; Other Configuration Options</b></font></td></tr>
	<!-- Threads Per Page -->
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Threads Per Page</b></font><br><font face="Verdana" size="1">Display this number of threads per page on the listing of all forum threads (forum.cgi)</font></td>
	  <td><input type="text" name="threads_per_page" value="$config{'threads_per_page'}"></td>
	</tr>
	<!-- Messages Per Page -->
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Messages Per Page</b></font><br><font face="Verdana" size="1">The number of posts to display on each page of a topic (topic.cgi)</font></td>
	  <td><input type="text" name="messages_per_page" value="$config{'messages_per_page'}"></td>
	</tr>
	<!-- Hot Topic Count -->
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Hot Topic Posts</b></font><br><font face="Verdana" size="1">The number of posts a thread must have before it is flagged as a "hot topic".</font></td>
	  <td><input type="text" name="hot_topic_posts" value="$config{'hot_topic_posts'}"></td>
	</tr>
	<!-- Footer: Submit Button -->
	<tr bgcolor="$color_config{'nav_top'}"><td colspan="2" align="center"><input type="submit" name="submit" value="Submit Configuration Changes"></td></tr>
      </table>
      <input type="hidden" name="action" value="saveboard">
      </form>
    </td></tr></table>
form
}

sub saveboard {
  # Get the variables
  my $board_name                = $Pairs{'board_name'};
  my $from_email_name           = $Pairs{'from_email_name'};
  my $from_email_addr           = $Pairs{'from_email_addr'};
  my $email_in_addr             = $Pairs{'email_in_addr'};
  my $registration_notification = $Pairs{'registration_notification'};
  my $smtp_port                 = $Pairs{'smtp_port'};
  my $smtp_host                 = $Pairs{'smtp_host'};
  my $table_width               = $Pairs{'table_width'};
  my $board_description         = $Pairs{'board_description'};
  my $website_name              = $Pairs{'website_name'};
  my $default_time_format       = $Pairs{'default_time_format'};
  my $announcements             = $Pairs{'announcements'};
  my $time_offset               = $Pairs{'time_offset'};
  my $threads_per_page          = $Pairs{'threads_per_page'};
  my $avatars                   = $Pairs{'avatars'};
  my $email_options             = $Pairs{'email_options'};
  my $mail_type                 = $Pairs{'mail_type'};
  my $autopasswords             = $Pairs{'autopasswords'};
  my $hot_topic_posts           = $Pairs{'hot_topic_posts'};
  my $messages_per_page         = $Pairs{'messages_per_page'};
  my $times                     = $Pairs{'times'};
  my $floodcontrol              = $Pairs{'floodcontrol'};
  my $post_status               = $Pairs{'post_status'};
  my $emailallposts             = $Pairs{'emailallposts'};
  my $reportmethod              = $Pairs{'reportmethod'};
  my $emailpoststo              = $Pairs{'emailpoststo'};
  my $defaultusergroup          = $Pairs{'default_user_group'};
  my $songtags                  = $Pairs{'songtags'};
 $randomtags                = $Pairs{'randomtags'};
  my $autolocktime              = $Pairs{'autolock_time'};
  my $copyright                 = $Pairs{'copyright'};
  my $board_logo                = $Pairs{'board_logo'};
  
  # Set defaults for the checkboxes that weren't checked, etc
  if(!$registration_notification) { $registration_notification = "no"; }
  if(!$announcements)             { $announcements = "no";             }
  if(!$time_offset)               { $time_offset = "0";                }
  if(!$avatars)                   { $avatars = "off";                  }
  if(!$songtags)                  { $songtags = "no";                  }
  if(!$randomtags)                { $randomtags = "no";                }
  if(!$email_options)             { $email_options = "off";            }
  if(!$autopasswords)             { $autopasswords = "no";             }
  if(!$floodcontrol)              { $floodcontrol = "0";               }
  if(!$post_status)               { $post_status = "disabled";         }
  if(!$emailallposts)             { $emailallposts = "no";             }
  if(!$reportmethod || ($reportmethod ne 'pm' && $reportmethod ne 'email'))  { $reportmethod = "pm";    }
  if(!$mail_type || ($mail_type ne 'sendmail' && $mail_type ne 'smtp'))      { $mail_type = "sendmail"; }
  if(!$email_options || ($email_options ne 'on' && $email_options ne 'off')) { $email_options = "off";  }
  if(!$emailpoststo)              { $emailpoststo = $email_in_addr;    }
  if(!$default_time_format)       { $default_time_format = "%th%wn %mn %md, %ye - %hr:%mi %ap"; }
  if(!$threads_per_page)          { $threadsperpage = 30;    }
  if(!$messages_per_page)         { $messages_per_page = 25; }
  if(!$hot_topic_posts)           { $hot_topic_posts = 25;   }
  if(!$emailpoststo)              { $emailpoststo = $email_in_addr; }
  if(!$board_logo)                { $board_logo = "board.jpg"; }

  # Make sure we have the required fields
  if(!$board_name || !$board_description || !$registration_notification || !$table_width || !$website_name ||
     !$default_time_format || !$announcements || !$threads_per_page || !$messages_per_page ||
     !$hot_topic_posts || !$autopasswords || !$times || !$post_status || !$emailallposts || !$reportmethod ||
     !$emailpoststo || !$defaultusergroup) {
       endit(1);
  }
  
  # These are conditional required fields -- they are only required if email options are ON and perhaps
  # still other conditions are met (for instance, SMTP host is required if the mail type is SMTP).
  if($email_options eq 'on') {  # Check for required fields now that this is enabled
    # First, unconditional requirements under this
    if(!$mail_type || !$from_email_name || !$from_email_addr || !$email_in_addr) { endit(1); }
    if($mail_type eq 'smtp') {  # Requirements if the mail type is SMTP
      if(!$smtp_host || !$smtp_port) { endit(1); }
    }
  }
  
  # If we have reached this point, we have all the required fields.  Set them in the %config hash in memory.
  $config{'board_name'}                = $board_name;
  $config{'from_email_name'}           = $from_email_name;
  $config{'from_email_addr'}           = $from_email_addr;
  $config{'email_in_addr'}             = $email_in_addr;
  $config{'registration_notification'} = $registration_notification;
  $config{'smtp_port'}                 = $smtp_port;
  $config{'smtp_host'}                 = $smtp_host;
  $config{'table_width'}               = $table_width;
  $config{'board_description'}         = $board_description;
  $config{'website_name'}              = $website_name;
  $config{'default_time_format'}       = $default_time_format;
  $config{'announcements'}             = $announcements;
  $config{'time_offset'}               = $time_offset;
  $config{'threads_per_page'}          = $threads_per_page;
  $config{'avatars'}                   = $avatars;
  $config{'email_options'}             = $email_options;
  $config{'mail_type'}                 = $mail_type;
  $config{'autopasswords'}             = $autopasswords;
  $config{'hot_topic_posts'}           = $hot_topic_posts;
  $config{'messages_per_page'}         = $messages_per_page;
  $config{'times'}                     = $times;
  $config{'floodcontrol'}              = $floodcontrol;
  $config{'post_status'}               = $post_status;
  $config{'emailallposts'}             = $emailallposts;
  $config{'reportmethod'}              = $reportmethod;
  $config{'emailpoststo'}              = $emailpoststo;
  $config{'default_user_group'}        = $defaultusergroup;
  $config{'songtags'}                  = $songtags;
  $config{'randomtags'}                = $randomtags;
  $config{'autolock_time'}             = $autolocktime;
  $config{'copyright'}                 = $copyright;
  $config{'board_logo'}                = $board_logo;
  
  # Save the %config hash from memory back to config.txt
  lock_open(CONFIG,"$cgi_path/data/config.txt","w");
  truncate(CONFIG,0);   seek(CONFIG,0,0);
  foreach my $key (keys %config) {
    print CONFIG "$key=$config{$key}\n";
  }
  close(CONFIG);
  
  # Update them on the progress
  endit(2);
}

sub endit {
  my $type = $_[0];
  my($message,$subject) = "";   # Blank 'em out.
  
  if($type == 1) {
    $message = qq~You did not complete all required fields.  Please go back and try again.~;
    $subject = qq~Error Saving Configuration Options~;
  }
  elsif($type == 2) {
    $message = qq~<b>Thank you!</b>  The configuration changes have successfully been saved.~;
    $subject = qq~Configuration Changes Successful~;
  }
  elsif($type == 3) {
    $message = qq~You did not complete all fields.  Please go back and try again.~;
    $subject = qq~Error Saving Path Changes~;
  }
  elsif($type == 4) {
    $message = qq~<b>Thank you!</b>  The path changes have successfully been saved.  Please note that if
    you are attempting to move the location of your files, this will <i>not</i> move them, simply change the
    pointer to them.  You will need to do all moving manually.~;
    $subject = qq~Path Changes Successful~;
  }
  elsif($type == 5) {
    $message = qq~<b>Thank you!</b>  The color configuration changse have successfully been saved.~;
    $subject = qq~Color Configuration Changes Successful~;
  }

  # Let them know their progress
  print <<end;
    <h3>$subject</h3>
    
    $message
end
}

sub pathconfigform {
  print <<form;
    <table width="98%" align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="$color_config{'border_color'}"><tr><td>
      <form action="$paths{'board_url'}config.cgi" method="post">
      <table width="100%" border="0" cellspacing="1" cellpadding="5">
        <!-- Header: Path Configurations -->
	<tr bgcolor="$color_config{'nav_top'}"><td colspan="2"><font face="Verdana" size="2"><b>&#187; Path Configuration Options</b></font></td></tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>CGI Path</b></font><br><font face="Verdana" size="1">The full <i>system</i> path to the ScareCrow CGI directory.</font></td>
	  <td><input type="text" name="cgi_path" value="$paths{'cgi_path'}">
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Non-CGI Path</b></font><br><font face="Verdana" size="1">The full system path to the non-cgi directory.  Do <i>not</i> include any of the directory names: "emoticons", "avatars", "images" on the end of this path!</font></td>
	  <td><input type="text" name="noncgi_path" value="$paths{'noncgi_path'}">
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Sendmail Path</b></font><br><font face="Verdana" size="1">The full system path to your sendmail program.  If you do not know this data, please contact your system administrator and request this data.  This field is only required if your email type is sendmail.</font></td>
	  <td><input type="text" name="sendmail_path" value="$paths{'sendmail_path'}">
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Board URL</b></font><br><font face="Verdana" size="1">The fully-qualified URL to your ScareCrow CGI directory.</font></td>
	  <td><input type="text" name="board_url" value="$paths{'board_url'}">
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Website URL</b></font><br><font face="Verdana" size="1">The fully-qualified URL to the host website of the message board.</font></td>
	  <td><input type="text" name="website_url" value="$paths{'website_url'}">
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Non-CGI Url</b></font><br><font face="Verdana" size="1">The fully-qualified URL to the ScareCrow non-CGI files such as emoticons.  Do <i>not</i> include any of the directory names: "emoticons", "avatars", "images" on the end of this URL!</font></td>
	  <td><input type="text" name="noncgi_url" value="$paths{'noncgi_url'}">
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Cookie Domain</b></font><br><font face="Verdana" size="1">The domain to send the cookie from.  This <i>must</i> be the same domain your account is run under.  It is recommended that you prefix this domain with a period if you do not operate under a subdomain.</font></td>
	  <td><input type="text" name="cookie_domain" value="$paths{'cookie_domain'}">
	</tr>
	<!-- Footer: Submission button -->
	<tr bgcolor="$color_config{'nav_top'}"><td colspan="2" align="center"><input type="submit" name="submit" value="Submit Path Configuration"></td></tr>
      </table>
      <input type="hidden" name="action" value="savepath">
      </form>
    </td></tr></table>
form
}

sub savepath {
  # Get the variables
  my $cgi_path      = $Pairs{'cgi_path'};
  my $sendmail_path = $Pairs{'sendmail_path'};
  my $board_url     = $Pairs{'board_url'};
  my $website_url   = $Pairs{'website_url'};
  my $noncgi_url    = $Pairs{'noncgi_url'};
  my $noncgi_path   = $Pairs{'noncgi_path'};
  my $cookie_domain = $Pairs{'cookie_domain'};
  
  # Check that there are trailing slashes where needed, and not where not needed
  # We do NOT want a trailing slash for these variables
  if(substr($cgi_path,-1,1) eq '/')      { $cgi_path = substr($cgi_path,0,length($cgi_path)-1); }
  if(substr($sendmail_path,-1,1) eq '/') { $sendmail_path = substr($sendmail_path,0,length($sendmail_path)-1); }
  if(substr($cookie_domain,-1,1) eq '/') { $cookie_domain = substr($cookie_domain,0,length($cookie_domain)-1); }
  if(substr($noncgi_url,-1,1) eq '/')    { $noncgi_url = substr($noncgi_url,0,length($noncgi_url)-1); }
  if(substr($noncgi_path,-1,1) eq '/')   { $noncgi_path = substr($noncgi_path,0,length($noncgi_path)-1); }
  # We DO want a trailing slash for these variables
  if(substr($website_url,-1,1) eq '/')   { $website_url = substr($website_url,0,length($website_url)-1); }
  
  # Make sure we have the required fields -- they are ALL required
  if(!$cgi_path || !$sendmail_path || !$board_url || !$website_url || !$noncgi_url || !$noncgi_path ||
     !$cookie_domain) {
       endit(3);
  }
  
  # If we reach this point we have them all.  Set them into the global %paths hash.
  $paths{'cgi_path'}      = $cgi_path;
  $paths{'sendmail_path'} = $sendmail_path;
  $paths{'board_url'}     = $board_url;
  $paths{'website_url'}   = $website_url;
  $paths{'noncgi_url'}    = $noncgi_url;
  $paths{'noncgi_path'}   = $noncgi_path;
  $paths{'cookie_domain'} = $cookie_domain;
  
  # Save the %paths hash back to disk
  lock_open(PATHS,"$cgi_path/data/paths.txt","w");
  truncate(PATHS,0);   seek(PATHS,0,0);
  foreach my $key (keys %paths) {
    print PATHS "$key=$paths{$key}\n";
  }
  close(PATHS);
  
  # Update them on the progress
  endit(4);
}

sub colorconfigform {
  print <<form;
    <table width="98%" align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="$color_config{'border_color'}"><tr><td>
      <form action="$paths{'board_url'}config.cgi" method="post">
      <table width="100%" border="0" cellspacing="1" cellpadding="5">
        <!-- Header: Color Configurations -->
	<tr bgcolor="$color_config{'nav_top'}"><td colspan="2"><font face="Verdana" size="2"><b>&#187; Color Configuration Options</b></font></td></tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Body Background Color</b></font><br><font face="Verdana" size="1">The color of the background of all pages.</font></td>
	  <td><input type="text" name="body_bgcolor" value="$color_config{'body_bgcolor'}">
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Body Text Color</b></font><br><font face="Verdana" size="1">The default color of all the text not otherwise modified.</font></td>
	  <td><input type="text" name="body_textcolor" value="$color_config{'body_textcolor'}">
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Link Color</b></font><br><font face="Verdana" size="1">The color of all non-visited board links.</font></td>
	  <td><input type="text" name="link_color" value="$color_config{'link_color'}">
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Active Link Color</b></font><br><font face="Verdana" size="1">The color of a link that has just been clicked on.</font></td>
	  <td><input type="text" name="active_color" value="$color_config{'active_color'}">
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Visited Link Color</b></font><br><font face="Verdana" size="1">The color of a link to a page that a user has already been to.</font></td>
	  <td><input type="text" name="visited_color" value="$color_config{'visited_color'}">
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Border Color</b></font><br><font face="Verdana" size="1">The color of the table borders.</font></td>
	  <td><input type="text" name="border_color" value="$color_config{'border_color'}">
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Top Navigation Color</b></font><br><font face="Verdana" size="1">The color of the table cells on top of each page that contains the message board name, description and link back to the main page.</font></td>
	  <td><input type="text" name="nav_top" value="$color_config{'nav_top'}">
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Bottom Navigation Color</b></font><br><font face="Verdana" size="1">The color of the table cells that contain the message board links such as "Register", "Profile", "Help", etc.</font></td>
	  <td><input type="text" name="nav_bottom" value="$color_config{'nav_bottom'}">
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Notice Box Color</b></font><br><font face="Verdana" size="1">The color of the header for an information box that does NOT redirect the user.</font></td>
	  <td><input type="text" name="notice_boxcolor" value="$color_config{'notice_boxcolor'}">
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Redirect Box Color</b></font><br><font face="Verdana" size="1">The color of the header of an information box that DOES redirect the user.</font></td>
	  <td><input type="text" name="redirect_boxcolor" value="$color_config{'redirect_boxcolor'}">
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Table Headers</b></font><br><font face="Verdana" size="1">The color of the header for the the forum lists and help list.</font></td>
	  <td><input type="text" name="table_headers" value="$color_config{'table_headers'}">
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Info Box Color</b></font><br><font face="Verdana" size="1">The color of the box that lists the number of pages in a forum and its moderators.</font></td>
	  <td><input type="text" name="info_box" value="$color_config{'info_box'}">
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Topic Color One</b></font><br><font face="Verdana" size="1">The background color of odd-numbered posts in a thread.</font></td>
	  <td><input type="text" name="topic_alt1" value="$color_config{'topic_alt1'}">
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Topic Color Two</b></font><br><font face="Verdana" size="1">The background color of even-numbered posts in a thread.</font></td>
	  <td><input type="text" name="topic_alt2" value="$color_config{'topic_alt2'}">
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Text Color One</b></font><br><font face="Verdana" size="1">The text color of odd-numbered posts in a thread.</font></td>
	  <td><input type="text" name="text_alt1" value="$color_config{'text_alt1'}">
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Text Color Two</b></font><br><font face="Verdana" size="1">The text color of even-numbered posts in a thread.</font></td>
	  <td><input type="text" name="text_alt2" value="$color_config{'text_alt2'}">
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Administrator Color</b></font><br><font face="Verdana" size="1">The color that the username of an administrator shows up in.</font></td>
	  <td><input type="text" name="admin_color" value="$color_config{'admin_color'}">
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Moderator Color</b></font><br><font face="Verdana" size="1">The color that the username of an moderator shows up in.</font></td>
	  <td><input type="text" name="moderator_color" value="$color_config{'moderator_color'}">
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>User Color</b></font><br><font face="Verdana" size="1">The color that the username of a normal user shows up in.</font></td>
	  <td><input type="text" name="user_color" value="$color_config{'user_color'}">
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Profile Name Color</b></font><br><font face="Verdana" size="1">The color that the username show's up as in profiles and private message centers.</font></td>
	  <td><input type="text" name="profilename_color" value="$color_config{'profilename_color'}">
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>"Code" Text Color</b></font><br><font face="Verdana" size="1">The color that the text of something placed in the [code][/code] tags shows up as.</font></td>
	  <td><input type="text" name="code_textcolor" value="$color_config{'code_textcolor'}">
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Poll Header Color</b></font><br><font face="Verdana" size="1">The color that the header (containing the question) of a poll display is.</font></td>
	  <td><input type="text" name="poll_top" value="$color_config{'poll_top'}">
	</tr>
	<!-- Footer: Submission button -->
	<tr bgcolor="$color_config{'nav_top'}"><td colspan="2" align="center"><input type="submit" name="submit" value="Submit Color Configuration"></td></tr>
      </table>
      <input type="hidden" name="action" value="savecolors">
      </form>
    </td></tr></table>
form
}

sub savecolors {
  # Get the variables
  my $body_bgcolor      = $Pairs{'body_bgcolor'};
  my $body_textcolor    = $Pairs{'body_textcolor'};
  my $link_color        = $Pairs{'link_color'};
  my $visited_color     = $Pairs{'visited_color'};
  my $active_color      = $Pairs{'active_color'};
  my $border_color      = $Pairs{'border_color'};
  my $nav_top           = $Pairs{'nav_top'};
  my $nav_bottom        = $Pairs{'nav_bottom'};
  my $redirect_boxcolor = $Pairs{'redirect_boxcolor'};
  my $notice_boxcolor   = $Pairs{'notice_boxcolor'};
  my $topic_alt1        = $Pairs{'topic_alt1'};
  my $topic_alt2        = $Pairs{'topic_alt2'};
  my $text_alt1         = $Pairs{'text_alt1'};
  my $text_alt2         = $Pairs{'text_alt2'};
  my $table_headers     = $Pairs{'table_headers'};
  my $info_box          = $Pairs{'info_box'};
  my $admin_color       = $Pairs{'admin_color'};
  my $moderator_color   = $Pairs{'moderator_color'};
  my $user_color        = $Pairs{'user_color'};
  my $profilename_color = $Pairs{'profilename_color'};
  my $code_textcolor    = $Pairs{'code_textcolor'};
  my $poll_top          = $Pairs{'poll_top'};
  
  # Assign the variables into the hash
  $color_config{'body_bgcolor'}      = $body_bgcolor;
  $color_config{'body_textcolor'}    = $body_textcolor;
  $color_config{'link_color'}        = $link_color;
  $color_config{'visited_color'}     = $visited_color;
  $color_config{'active_color'}      = $active_color;
  $color_config{'border_color'}      = $border_color;
  $color_config{'nav_top'}           = $nav_top;
  $color_config{'nav_bottom'}        = $nav_bottom;
  $color_config{'redirect_boxcolor'} = $redirect_boxcolor;
  $color_config{'notice_boxcolor'}   = $notice_boxcolor;
  $color_config{'topic_alt1'}        = $topic_alt1;
  $color_config{'topic_alt2'}        = $topic_alt2;
  $color_config{'text_alt1'}         = $text_alt1;
  $color_config{'text_alt2'}         = $text_alt2;
  $color_config{'table_headers'}     = $table_headers;
  $color_config{'info_box'}          = $info_box;
  $color_config{'admin_color'}       = $admin_color;
  $color_config{'moderator_color'}   = $moderator_color;
  $color_config{'user_color'}        = $user_color;
  $color_config{'profilename_color'} = $profilename_color;
  $color_config{'code_textcolor'}    = $code_textcolor;
  $color_config{'poll_top'}          = $poll_top;
  
  # Write the changes back to the file
  lock_open(PATHS,"$cgi_path/data/color_config.txt","w");
  truncate(PATHS,0);   seek(PATHS,0,0);
  foreach my $key (keys %color_config) {
    print PATHS "$key=$color_config{$key}\n";
  }
  close(PATHS);
  
  # Update them on the progress
  endit(5);
}

sub username_restrictions {
  # Get the current bans
  lock_open(BANS,"$cgi_path/data/usernames.ban","r");
  while($ban = <BANS>) { 
    $ban = strip($ban);
    if($final) { $final .= "\n$ban"; }
    else       { $final  = $ban;     }
  }
  close(BANS);
  
  # Output the form
  print <<end;
    <font face="Verdana" size="2">
     <p><b>Manage Username Restrictions</b></p>
     
     <p>Welcome.  From this screen, you may add or remove a list of usernames that cannot be registered.  To
     add a restricted username, simply add the username to the list.  Likewise, to remove a restriction,
     simply remove the address from the list.  When you ar efinished making your revisions, click "Save".
     Please note that these restrictions are case insensitive, meaning "the" is the same as "THE".</p>     
    
     <table width="98%" align="center" cellspacing="0" cellpadding="0" border="0" bgcolor="$color_config{'border_color'}"><tr><td>
       <form action="$paths{'board_url'}config.cgi" method="post">
       <table width="100%" cellspacing="1" cellpadding="5" border="0">
         <tr bgcolor="$color_config{'nav_top'}"><td colspan="2"><font face="Verdana" size="2"><b>&#187; Manage Restricted Usernames</b></font></td></tr>
         <tr bgcolor="$color_config{'body_bgcolor'}">
	   <td><font face="Verdana" size="2"><b>Restricted Username List</b></font></td>
	   <td><textarea name="bans" cols="35" rows="10">$final</textarea></td>
	 </tr>
         <tr bgcolor="$color_config{'nav_top'}"><td colspan="2" align="center"><input type="submit" name="submit" value="Save"></td></tr>
       </table>
       <input type="hidden" name="action" value="saverestrict">
       </form>
     </td></tr></table>
end
}

sub save_username_restrictions {
  my $bans = $Pairs{'bans'};
  
  lock_open(BANS,"$cgi_path/data/usernames.ban","w");
  truncate(BANS,0);   seek(BANS,0,0);
  print BANS $bans;
  close(BANS);
  
  print "<font face=\"Verdana\" size=\"2\"><b>Thank you.</b>  The username restrictions have successfully been saved.</font>";
}
