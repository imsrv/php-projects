#!/usr/bin/perl

# This script will provide forms for the administrators to add and remove
# email and IP bans for their message board.
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

require "global.cgi";
require 'admin.lib';

# Check the cookie
$inf = get_cookie("mb-admin");
($cookieuser,$cookiepassword) = split(/\|/,$inf);

if(!$cookieuser) {   # Give them a chance to log in the admin cookie
  content();
  page_header("$config{'board_name'} > Administrator Control Panel");
  admin_login("$paths{'board_url'}admincenter.cgi");
  exit;
}

if(check_account($cookieuser,$cookiepassword) == $FALSE) {
  redirect_die("We're sorry, but your username/password combination was
  invalid or you are not an administrator on this message board.","","4","black","You Do Not Have Access");
}

# Output the content headers
content();
page_header("$config{'board_name'} > Ban Manager");

my $type = $Pairs{'type'};

if($type eq 'email')        { email_bans();      }
elsif($type eq 'saveemail') { save_email_bans(); }
elsif($type eq 'ip')        { ip_list();         }
elsif($type eq 'removeip')  { remove_ip_ban();   }
elsif($type eq 'addip')     { add_ip_ban();      }
elsif($type eq 'saveip')    { save_ip_ban();     }
else                        { email_bans();      }

sub email_bans {
  # Get the current bans
  lock_open(BANS,"$cgi_path/data/email.ban","r");
  while($ban = <BANS>) { 
    $ban = strip($ban);
    if($final) { $final .= "\n$ban"; }
    else       { $final  = $ban;     }
  }
  close(BANS);
  
  # Output the form
  print <<end;
    <font face="Verdana" size="2">
     <p><b>Add/Remove Email Bans</b></p>
     
     <p>Welcome.  From this screen, you may add or remove email bans.  To add a ban, simply add the email
     address to ban to the list.  Likewise, to remove a ban, simply remove the address from the list.  When
     you are finished making your revisions, click "Save Bans".  Email bans will prevent anybody from
     registering an account with the specified email with a banned message.</p>
     
     <table width="98%" align="center" cellspacing="0" cellpadding="0" border="0" bgcolor="$color_config{'border_color'}"><tr><td>
       <form action="$paths{'board_url'}banmanage.cgi" method="post">
       <table width="100%" cellspacing="1" cellpadding="5" border="0">
         <tr bgcolor="$color_config{'nav_top'}"><td colspan="2"><font face="Verdana" size="2"><b>&#187; Manage Email Bans</b></font></td></tr>
         <tr bgcolor="$color_config{'body_bgcolor'}">
	   <td><font face="Verdana" size="2"><b>Email Ban List</b></font></td>
	   <td><textarea name="bans" cols="35" rows="10">$final</textarea></td>
	 </tr>
         <tr bgcolor="$color_config{'nav_top'}"><td colspan="2" align="center"><input type="submit" name="submit" value="Save Bans"></td></tr>
       </table>
       <input type="hidden" name="type" value="saveemail">
       </form>
     </td></tr></table>
end
}

sub save_email_bans {
  my $bans = $Pairs{'bans'};
  
  lock_open(BANS,"$cgi_path/data/email.ban","w");
  truncate(BANS,0);   seek(BANS,0,0);
  print BANS $bans;
  close(BANS);
  
  print "<font face=\"Verdana\" size=\"2\"><b>Thank you.</b>  The email bans have successfully been saved.</font>";
}

sub ip_list {
  # Start the table
  print <<end;
    <table width="98%" align="center" cellspacing="0" cellpadding="0" border="0" bgcolor="$color_config{'border_color'}"><tr><td>
      <table width="100%" cellspacing="1" cellpadding="5" border="0">
        <tr bgcolor="$color_config{'nav_bottom'}"><td colspan="2"><font face="Verdana" size="2"><b>&#187; Manage IP Bans</b> | <a href="$paths{'board_url'}banmanage.cgi?type=addip">Add IP Ban</a></font></td></tr>
	<tr bgcolor="$color_config{'nav_top'}">
	  <td><font face="Verdana" size="2"><b>IP Ban</b></font></td>
	  <td><font face="Verdana" size="2"><b>Delete</b></font></td>
	</tr>
end
  
  # Loop through the bans and provide a delete option
  lock_open(BANS,"$cgi_path/data/ip.ban","r");
  while($in = <BANS>) {
    $in = strip($in);
    print <<end;
      <tr bgcolor="$color_config{'body_bgcolor'}">
        <td><font face="Verdana" size="2">$in</font></td>
	<td><a href="$paths{'board_url'}banmanage.cgi?type=removeip&ip=$in">Delete</a>
      </tr>
end
  }
  close(BANS);

  # Finish off the table
  print <<end;
      </table>
      <input type="hidden" name="type" value="saveemail">
      </form>
    </td></tr></table>
end
}

sub remove_ip_ban {
  # Get the ban to remove
  my $ban = $Pairs{'ip'};
  
  # Remove the ban
  lock_open(BANS,"$cgi_path/data/ip.ban","rw");
  seek(BANS,0,0);
  while($in = <BANS>) {
    $in = strip($in);
    if($in eq $ban) { $done = 1; }
    else { $final = "$in\n"; }
  }
  truncate(BANS,0);  seek(BANS,0,0);
  print BANS $final;
  close(BANS);
  
  # Update the user on the progress
  if($done == 1) {
    print "<font face=\"Verdana\" size=\"2\"><b>Thank you.</b>  The selected ban ($ban) has been removed.</font>";
  } else {
    print "<font face=\"Verdana\" size=\"2\"><b>Error!</b>  The selected ban ($ban) was not found in the ban database.</font>";
  }
}

sub add_ip_ban {
  # Print out the form to add an IP ban
  print <<end;
    <font face="Verdana" size="2">
     <p><b>Add An IP Ban</b></p>
     
     <p>Welcome.  From this screen, you may add an IP ban.  To add the ban, simply type the IP you wish
     to ban into the box below and click "Save Ban".  You may ban blocks of IPs using the wildcard
     character, "*".</p>
     
     <p><b>Ban examples:</b><br>
       10.0.0.1       - Bans ONLY the IP 10.0.0.1<br>
       192.168.*.*    - Bans ALL IPs beginning with 192.168
     </p>
     
     <table width="98%" align="center" cellspacing="0" cellpadding="0" border="0" bgcolor="$color_config{'border_color'}"><tr><td>
       <form action="$paths{'board_url'}banmanage.cgi" method="post">
       <table width="100%" cellspacing="1" cellpadding="5" border="0">
         <tr bgcolor="$color_config{'nav_top'}"><td colspan="2"><font face="Verdana" size="2"><b>&#187; Add An IP Ban</b></font></td></tr>
         <tr bgcolor="$color_config{'body_bgcolor'}">
	   <td><font face="Verdana" size="2"><b>IP Ban To Add</b></font></td>
	   <td><input type="text" name="ip"></td>
	 </tr>
         <tr bgcolor="$color_config{'nav_top'}"><td colspan="2" align="center"><input type="submit" name="submit" value="Save Ban"></td></tr>
       </table>
       <input type="hidden" name="type" value="saveip">
       </form>
     </td></tr></table>

end
}

sub save_ip_ban {
  # Get the ban
  my $ban = $Pairs{'ip'};
  
  # Save the ban
  lock_open(BANS,"$cgi_path/data/ip.ban","a");
  seek(BANS,0,2);
  print BANS "$ban\n";
  close(BANS);
  
  print "<font face=\"Verdana\" size=\"2\"><b>Thank you!</b>  The ban for $ban has successfully been saved.</font>";
}
