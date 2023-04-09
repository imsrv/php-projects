#!/usr/bin/perl

# This script will handle global functions such as account validation,
# reading and setting of cookies, group permissions, etc.
#
# Revision: October 2001
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


use CGI::Carp "fatalsToBrowser";          # Output errors to browser
use Fcntl;                                # Flock function
require "ban.lib";                        # Load the ban functions
use CGI; 

# Before we do ANYTHING, check if this user is banned by IP.
check_ip_ban($ENV{'REMOTE_ADDR'});

parse_form();

if($Pairs{'cookie'} eq 'yes')       { send_cookie();    }
elsif($Pairs{'cookie'} eq 'logout') { remove_cookies(); }

load('config');                           # Load the board configuration
load('paths');                            # Load the path information
load('color_config');                     # Load color configuration options

#### Assign some global variables ###############################
 $cgi_path = $paths{'cgi_path'};
 $TRUE  = 1;
 $FALSE = -1;
 $version = '2.00';
 $query = new CGI;
 $cookiepath = "/";
 if($Pairs{'page_title'}) { $page_title = $Pairs{'page_title'};  }
 else                     { $page_title = $config{'board_name'}; }
 if(!$config{'board_logo'}) { $board_logo = "board.jpg"; }
 $TOTAL_PERMISSIONS = 21;
 # Set up a guest account
 $users{"Guest"}{'memberstate'} = "Guest";
 $users{"Guest"}{'groups'}      = "Guests";

#################################################################
get_template();                           # Get the board template


###############################################################################
# getvarfromfile()
#
# Inputs  : $variablename, $filename
# Returns : none
# Function: Loads the specified file into variablename.
###############################################################################
sub getvarfromfile {
  my($variable,$filename) = @_;

  lock_open(FH,$filename,"r");
  while(my $in = <FH>) { $$variable .= $in; }
  close(FH);
}

###############################################################################
# load()
#
# Inputs  : $filename
# Returns : none
# Function: Loads the specified configuration filename and sets %$filename.
###############################################################################
sub load {
  local($f) = $_[0];
  lock_open(file,"data/$f.txt",'r');
  while($in = <file>) {
    $in = strip($in);
    ($name,$value) = split(/=/,$in,2);
    $$f{$name} = $value;
  }
  close(file);
}

###############################################################################
# check_account()
#
# Inputs  : $user, $password
# Returns : TRUE or FALSE
# Function: Determines whether the supplied data correctly authenticates an
#           account.  Along the way, it sets %account_data with all the
#           name=value pairs in the user file.
###############################################################################
sub check_account {
    local($check_user,$check_password) = ($_[0],$_[1]);
   
    my $check = get_member($check_user);
    #if(!$check) { unlink "members/$check_user.dat"; return $FALSE; }

    if($users{$check_user}{'username'} eq $check_user) {
      if($users{$check_user}{'password'} eq crypt($check_password,$users{$check_user}{'salt'})) {
        return $TRUE;
      }
    }

    return $FALSE;
}

###############################################################################
# strip()
#
# Inputs  : $string
# Returns : formatted string
# Function: Strips newlines and linefeeds from a string.
###############################################################################
sub strip {
  $_[0] =~ s/\n//ig;     $_[0] =~ s/\r//ig;
  return $_[0];
}

###############################################################################
# parse_form()
#
# Inputs  : none
# Returns : none
# Function: Parses the GET or POST form and places it into %Pairs.
###############################################################################
sub parse_form
{
    if(!$ENV{'QUERY_STRING'})   # Was from a post
    {
        read(STDIN,$ENV{'QUERY_STRING'},$ENV{'CONTENT_LENGTH'});
    }

    # We've got the pairs in QUERY_STRING now, break it into an associative
    # array.
    local(@elements) = split(/\&/,$ENV{'QUERY_STRING'});
    local($element) = "";
    foreach $element (@elements)
    {
        local($name,$value) = split(/=/,$element,2);
        $value = unescape($value);
        if($Pairs{$name}) {
          $Pairs{$name} .= ",$value";
        }
        else {
          $Pairs{$name} = $value;
        }
    }
}

###############################################################################
# include_file()
#
# Inputs  : $filename
# Returns : none
# Function: Reads in and prints out a specified file.
###############################################################################
sub include_file {
  local($final) = "";

  lock_open(file,$_[0],'r');
  while($in = <file>) { $final .= $in; }

  return $final;
}

###############################################################################
# lock_open(FILEHANDLE, filename, type, [lock type])
#
# Type is one of "rw" "w" "r" "a" for read/write, write, read, append, in that
# order.  The lock type is automatically determined, you can force it by
# setting 'lock type'
###############################################################################
sub lock_open {
  local($fh, $filename, $type, $lockt, $lcount);

  $lcount = 0;
  $fh = shift;
  $filename = shift;
  $type = shift;
  $lockt = shift;

  # default to write
  if(!$type)  { $type = 2; }
  elsif($type eq "w") {                 # writing mode
    $type = 2;
  }
  elsif($type eq "r") {
    $type = 1;
  }
  elsif($type eq "a") {
    $type = 3;
  }
  elsif($type eq "rw") {
    $type = 4;
  }

  # set correct lock type
  if(!$lockt) {
    if($type == 1) {  # shared lock
      $lockt = 1;
    }
    elsif($type == 2 || $type == 3 || $type == 4) {   # exclusive lock
      $lockt = 2;
    }
  }
  if($type == 1)    { $otype = O_RDONLY|O_CREAT;         }
  elsif($type == 2) { $otype = O_WRONLY|O_CREAT;         }
  elsif($type == 3) { $otype = O_RDWR|O_CREAT;           }
  elsif($type == 4) { $otype = O_RDWR|O_CREAT;           }
  else              { $otype = O_RDWR|O_CREAT;           }

  # open the file
  sysopen($fh, $filename, $otype,0744);
  # lock the file
  flock($fh,$lockt);

  # read or read/write type, just seek
  if($type == 1 || $type == 4) {
  # just to be safe
    seek($fh, 0, 0);
  }
  # write type, clear the file
  elsif($type == 2) {
    truncate($fh, 0);
  # just to be safe
    seek($fh, 0, 0);
   }
  # append type, seek to end of file
  elsif($type == 3) {
    seek($fh, 0, 2);
  }
}

###############################################################################
# get_cookie()
#
# Inputs  : cookie name
# Returns : cookie data or FALSE
# Function: Reads a cookie and returns the contents.
###############################################################################
sub get_cookie {
  my $cookie_name = $_[0];
  my $cookie = $query->cookie($cookie_name);
  $cookie = unescape($cookie);
  $cookie =~ s/\%7C/\|/ig;
  return $cookie;

  my $raw_cookies = $ENV{'HTTP_COOKIE'};
  if(!$raw_cookies) { $cookies = $ENV{'COOKIE'}; }
  if(!$raw_cookies) { return ""; }

  my @cookies = split(';',$raw_cookies);

  foreach $cookie (@cookies) {
    $cookie =~ tr/ //;
    ($name,$value) = split(/=/,$cookie);
    if($name eq $cookie_name) {
      $value = unescape($value);
      return $value;
    }
  }

  return "";
}

###############################################################################
# page_header()
#
# Inputs  : $pagetitle
# Returns : none
# Function: Creates the opening HTML tags and body tag, with page title or
#           board name by default.
###############################################################################
sub page_header {
  my $title = $_[0];
  if(!$title) { $title = $config{'board_name'}; }
  # Some variable transformations
  $templateheader =~ s/\$page_title/$title/ig;                   # Page title
  $templateheader =~ s/\$1/$color_config{'body_bgcolor'}/ig;     # Body bgcolor
  $templateheader =~ s/\$2/$color_config{'body_textcolor'}/ig;   # Body textcolor
  $templateheader =~ s/\$3/$color_config{'link_color'}/ig;       # Link color
  $templateheader =~ s/\$4/$color_config{'active_color'}/ig;     # Active Link Color
  $templateheader =~ s/\$5/$color_config{'visited_color'}/ig;    # Visited Link Color

  print $templateheader;
}

###############################################################################
# page_footer()
#
# Inputs  : none
# Returns : none
# Function: Displays the bottom navigation for all pages, including copyright.
###############################################################################
sub page_footer {
  $templatefooter =~ s/\$version/$version/ig;
  $templatefooter =~ s/\$copyright/$config{'copyright'}/ig;
  print $templatefooter;
}

###############################################################################
# unescape()
#
# Inputs  : $string
# Returns : Formatted string
# Function: Unencodes URL-encoded data
###############################################################################
sub unescape {
    shift() if ref($_[0]);
    my $todecode = shift;
    return undef unless defined($todecode);
    $todecode =~ tr/+/ /;       # pluses become spaces
    $todecode =~ s/%([0-9a-fA-F]{2})/pack("c",hex($1))/ge;
    return $todecode;
}

###############################################################################
# clean_input()
#
# Inputs  : $string
# Returns : cleaned string
# Function: Removes potentially damaging characters from a string.
###############################################################################
sub clean_input {
  my $f = substr($_[0],0,1);
  # Get rid of evil or potentially dangerous characters
  while($f eq '|' || $f eq '/' || $f eq '.') {
    $_[0] = substr($_[0],1,length($_[0]));
    $f = substr($_[0],0,1);
  }
  $_[0] =~ s/<!--(.|\n)*-->//g;
  $_[0] =~ s/<script>/\&lt;script\&gt;/ig;
  $_[0] =~ s/\&/\&amp;/g;
  $_[0] =~ s/"/\&quot;/g;
  $_[0] =~ s/  / \&nbsp;/g;
  $_[0] =~ s/</\&lt;/g;
  $_[0] =~ s/>/\&gt;/g;
  $_[0] =~ s/\|/\&#0124;/g;
  $_[0] =~ s/\t//g;
  $_[0] =~ s/\r//g;
  $_[0] =~ s/  / /g;
  $_[0] =~ s/\n\n/[p]/g;
  $_[0] =~ s/\n/[br]/g;

  return $_[0];
}

###############################################################################
# scarecrow_die()
#
# Inputs  : $message
# Returns : none
# Function: Aborts the program and displays an error message.
###############################################################################
sub scarecrow_die {
  local($message);
  $message = shift;
  print "ScareCrow | The following error occured: <font color=red>$message</font>\r\n";
  die($message);
}

###############################################################################
# board_header()
#
# Inputs  : none
# Returns : none
# Function: Creates the top navigation box on all message board screens.
###############################################################################
sub board_header {
  print <<end_header;
  <!-- Main navigation table -->
  <table align="center" width="$config{'table_width'}" bgcolor="$color_config{'border_color'}" cellspacing="1" cellpadding="0" border="0"><tr><td>
    <table width="100%" cellspacing="0" border="0" cellpadding="4" border="0">
      <tr bgcolor="$color_config{'nav_top'}" valign="top">
        <td>
          <table width="100%"><tr><td>
            <font size="4" color="#444444" face="verdana"><b>$config{'board_name'}</b></font><br>
            <font color="#444444" face="verdana" size="2">$config{'board_description'}</font>
          </td><td align="right" valign="bottom">
            &#187; <a href="$paths{'website_url'}"><font face="verdana" size="1">back to $config{'website_name'}</font></small></a>
          </td></tr>
          </table>
        </td>
      </tr>
      <tr bgcolor="$color_config{'nav_bottom'}">
        <td>
          <font face="verdana" size="2">
          <a href="$paths{'board_url'}register.cgi">Register</a> |
          <a href="$paths{'board_url'}profile.cgi">Profile</a> |
          <a href="$paths{'board_url'}login.cgi">Log In</a> |
          <a href="$paths{'board_url'}misc.cgi?action=lostpassword">Lost Password</a> |
          <a href="$paths{'board_url'}activeusers.cgi">Active Users</a> |
          <a href="#" onClick="openScript('$paths{'board_url'}help.cgi','600','500'); return false;" onMouseOver="mouseit('Help Files'); return true;" onMouseOut="mouseit(''); return true;">Help</a> |
          <a href="$paths{'board_url'}search.cgi">Search</a> |
          <a href="$paths{'board_url'}rules.cgi">Board Rules</a> |
          <a href="$paths{'board_url'}faq.cgi">FAQ</a>
          </font>
        </td>
      </tr>
    </table>
  </td></tr></table><br>
end_header
}

###############################################################################
# user_line()
#
# Inputs  : none
# Returns : none
# Function: Creates the user line, either allowing them options such as
#           editing their profile and logging out, or offers to allow them
#           to log in or register.
###############################################################################
sub user_line {
  # Get the cookie information
  my $inf = get_cookie("mb-user");
  my($membername,$password) = split(/\|/,$inf);
  
  if($users{$membername}{'validated'} eq 'no') { # Compile unvalidated line
    $validated = qq~(<a href="" onMouseOver="mouseit('View Help Files'); return true;" onMouseOut="mouseit(''); return true;" onClick="openScript('$paths{'board_url'}help.cgi?topic=Validation','400','350'); return false;"><font color="red">unvalidated</font></a>)&nbsp;&nbsp;~;
  } else { $validated = ""; }

  if(!$membername || !-e "$paths{'cgi_path'}/members/$membername.dat") {
    print <<end_box
      <!-- User login/information table -->
    <table align="center" width="$config{'table_width'}" cellspacing="0" cellpadding="0" bgcolor="$color_config{'border_color'}" border="0"><tr><td>
      <table width="100%" cellspacing="1" cellpadding="4" border="0"><tr bgcolor="$color_config{'nav_top'}"><td>
        <font face="verdana" size="1">&#187; You are not logged in.&nbsp;&nbsp;
        <a href="$paths{'board_url'}login.cgi?action=login">log in</a> |
        <a href="$paths{'board_url'}register.cgi">register</a>
        </font>
      </td></tr></table>
    </td></tr></table><br>
end_box
  }
  else {
    if(has_new_private($membername) == $TRUE) { $pmline = qq~
      <table width="$config{'table_width'}" cellspacing="0" cellpadding="0" border="0" align="center"><tr><td align="right"><a href=\"$paths{'board_url'}messanger.cgi\"><img src=\"$paths{'noncgi_url'}/images/newprivate.gif\" border=\"0\"></a></td></tr></table>~;
    }
    else { $pmline = ""; }
    print <<end_box;
    <!-- User login/information table -->
    <table align="center" width="$config{'table_width'}" cellspacing="0" cellpadding="0" bgcolor="$color_config{'border_color'}" border="0"><tr><td>
      <table width="100%" cellspacing="1" cellpadding="4" border="0"><tr bgcolor="$color_config{'nav_top'}"><td>
        <font face="verdana" size="1">&#187; Welcome, $membername.&nbsp;&nbsp;$validated
        <a href="$paths{'board_url'}login.cgi?action=logout">log out</a> |
        <a href="$paths{'board_url'}messanger.cgi">private messages</a> |
        <a href="#" onClick="openScript('$paths{'board_url'}misc.cgi?action=newposts','600','500'); return false;" onMouseOver="mouseit('Show New Posts'); return true;" onMouseOut="mouseit(''); return true;">show new posts</a> |
        <a href="$paths{'board_url'}misc.cgi?action=allread">mark <b>all</b> posts as read</a>
        </font>
      </td></tr></table>
    </td></tr></table><br>
    <div align="right">$pmline</div>
end_box
  }

}

###############################################################################
# get_time()
#
# Inputs  : $time, $format (or blank for default)
# Returns : Formatted time string
# Function: Evaluates the desired formatting variable for the time, and parses
#           the time supplied or, by default, the current time.  This function
#           also happily takes into account time differences.
###############################################################################
sub get_time {
  # $modifier = (hour difference) * 60 * 60;
  local($feed) = 0;
  # If there is no (valid) argument, return never, otherwise set the initial feed.
  if(!$_[0] || int($_[0]) == 0) { return "never"; } else { $feed = $_[0]; }

  # Check the user account for time offset settings
  $time_modifier = 0;
  my $inf = get_cookie("user");
  my($user,$password) = split(/\|/,$inf);
  get_member($user);
  if($users{$user}{'time_offset'}) {
    my $time_offset = $users{$user}{'time_offset'};
    $time_offset =~ s/\+//ig;   $time_offset =~ s/h//ig;
    $time_modifier = $time_offset * 3600;   # User time offset
  }
  $time_modifier += $config{'time_offset'} * 3600;          # Board time offset
  $feed += $time_modifier;                                  # Add on all the modifiers

  # Get all the parts of the time as passed and modified
  ($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime($feed);
  # Add appropriate values to certain variables
  $year += 1900;    $mon++;  $wday++;

  # Format it appropriately by substituting codes for the values.  Codes:
  # %dw - Day of week (number)              %ye - Year
  # %se - Seconds                           %mi - Minutes
  # %hr - Hours                             %md - Day (number) of month
  # %mo - Month (numerical)                 %yd - Day of year            
  # %mn - Name of month                     %wn - Day of week (name)
  # %th - Twelve hour clock                 %ap - AM or PM, respectively
  # CURRENTLY: Thu Apr 16 20:16:38 2001  -- %dw %mn %mday %hr:%mi:%se %ye
  
  # Get some preliminary data ready
  local($mnam) = get_month_name($mon,'no');
  local($wnam) = get_weekday_name($wday,'yes');
  ($min,$sec,$hour) = double_format($min,$sec,$hour);
  if(!$_[1]) { $return_time = $config{'default_time_format'}; } else { $return_time = $_[1]; }

  # Check if they want twelve hour clock
  if($return_time =~ /\%th/) {
    if($hour > 12) {  # They want it and the time needs converting
      $hour -= 12;
      $ap = "PM";   # Set AM/PM variable
    } else {
     if($hour == 12) { $ap = "PM"; }
     else          { $ap = "AM"; }
     if($hour == 0) { $hour = 12; }
   }
    $return_time =~ s/\%th//ig;  # Get rid of the tag
  }
  # If the AM/PM varible is not set (on the 24-hour clock), we'll set it
  # anyway
  if(!$ap) {
    if($hour => 12) { $ap = "PM"; }
    else          { $ap = "AM"; }
  }
    

  # Replace all the variables with their values
  $return_time =~ s/\%dw/$wday/ig;          $return_time =~ s/\%ye/$year/ig;
  $return_time =~ s/\%se/$sec/ig;           $return_time =~ s/\%mi/$min/ig;
  $return_time =~ s/\%hr/$hour/ig;          $return_time =~ s/\%md/$mday/ig;
  $return_time =~ s/\%mo/$mon/ig;           $return_time =~ s/\%yd/$yday/ig;
  $return_time =~ s/\%mn/$mnam/ig;          $return_time =~ s/\%wn/$wnam/ig;
  $return_time =~ s/\%ap/$ap/ig;

  return $return_time;

}
###############################################################################
# get_month_name()
#
# Inputs  : $month_number
# Returns : name of month
# Function: Returns the name of a supplied numerical month.
###############################################################################
sub get_month_name {
  local($name) = "";
  if($_[0] == 1)      { $name = 'January';   }
  elsif($_[0] == 2)   { $name = 'February';  }
  elsif($_[0] == 3)   { $name = 'March';     }
  elsif($_[0] == 4)   { $name = 'April';     }
  elsif($_[0] == 5)   { $name = 'May';       }
  elsif($_[0] == 6)   { $name = 'June';      }
  elsif($_[0] == 7)   { $name = 'July';      }
  elsif($_[0] == 8)   { $name = 'August';    }
  elsif($_[0] == 9)   { $name = 'September'; }
  elsif($_[0] == 10)  { $name = 'October';   }
  elsif($_[0] == 11)  { $name = 'November';  }
  elsif($_[0] == 12)  { $name = 'December';  }
  else { return "month lookup error"; }

  if($_[1] eq 'yes') { $name = substr($name,0,3); }

  return $name;

}

###############################################################################
# get_weekday_name()
#
# Inputs  : $day
# Returns : name of day
# Function: Determines the name of the day of the week by a supplied number
###############################################################################
sub get_weekday_name {
  local($name) = "";
  if($_[0] == 1)     { $name = "Sunday";    }
  elsif($_[0] == 2)  { $name = "Monday";    }
  elsif($_[0] == 3)  { $name = "Tuesday";   }
  elsif($_[0] == 4)  { $name = "Wednesday"; }
  elsif($_[0] == 5)  { $name = "Thursday";  }
  elsif($_[0] == 6)  { $name = "Friday";    }
  elsif($_[0] == 7)  { $name = "Saturday";  }
  else { return "weekday lookup error"; }

  if($_[1] eq 'yes') { $name = substr($name,0,3); }

  return $name;

}

###############################################################################
# double_format()
#
# Inputs  : $variable
# Returns : formatted variable
# Function: Turns any single number into a double (adds a leading zero)
###############################################################################
sub double_format {
  local($in,$x) = ("",0);

  for($x = 0; $x <= $#_; $x++) {
    if(length($_[$x]) == 1) { $_[$x] = "0$_[$x]"; }
  }

  return @_;
}

###############################################################################
# notice_box()
#
# Inputs  : $boxtitle,$boxmessage
# Returns : none
# Function: Creates a notice box with a specified title and message.
###############################################################################
sub notice_box {
  local($box_title,$box_content) = @_;

    print <<end_box;
    <table cellpadding=0 cellspacing=0 border=0 width=$config{'table_width'} bgcolor=$color_config{'border_color'} align=center><tr><td>
      <table cellpadding=6 cellspacing=1 border=0 width=100%>
        <tr>
         <td bgcolor=$color_config{'nav_top'} align=center><font face="Verdana" size="3"><b>$box_title</b></td>
        </tr>
        <tr>
         <td bgcolor=$color_config{'body_bgcolor'} align=left><font face="Verdana" size=2><br>
           <font face="Verdana" size="2">$box_content</font>
         </td>
        </tr>
      </table>
    </td></tr></table>
end_box
}

###############################################################################
# redirect_die()
#
# Inputs  : $message, $urltogoto, $timeforredirect,$redirectfontcolor,$title
# Returns : none
# Function: Redirects the user to a specified page, in a specified amount of
#           time, with an optional message and title box.
###############################################################################
sub redirect_die {
    local($msg,$ref_url,$time,$red_font_col,$box_title) = @_;
    if(!$ref_url)  # No specified direct
    {
        $ref_url = $ENV{'HTTP_REFERER'};
    }
    else
    {
        $ref_url = $_[1];
    }
    if(!$time)  # No specified time
    {
        $time = "2";
    }
    else
    {
        $time = $_[2];
    }
    if(!$red_font_col)  # No specified text color
    {
        $red_font_col = "navy";
    }
    else
    {
        $red_font_col = $_[3];
    }
    if(!$content_sent) { print "Content-type: text/html\n\n"; }
    print <<end_box;
    <table cellpadding=0 cellspacing=0 border=0 width=$config{'table_width'} bgcolor=$color_config{'border_color'} align=center><tr><td>
      <table cellpadding=6 cellspacing=1 border=0 width=100%>
        <tr>
         <td bgcolor=$color_config{'nav_top'} align=center><font face="Verdana" size="3"><b>$box_title</b></td>
        </tr>
        <tr>
         <td bgcolor=$color_config{'body_bgcolor'} align=left><font face="Verdana" size=2><br>
           <META HTTP-EQUIV="Refresh" CONTENT="$time; URL=$ref_url">
           <font face="Verdana" size="2" color="$red_font_color">$msg</font>
         </td>
        </tr>
      </table>
    </td></tr></table>
end_box

  page_footer();
  exit;
}

###############################################################################
# get_newtag()
#
# Inputs  : $lastvisited, $lastmodified, $postsfromforum, $sticky
# Returns : new or not new image
# Function: Determines whether or not a forum or topic has been viewed and
#           returns the appropriate new tag.
###############################################################################
sub get_newtag {
  my($lastvisited,$lastmodified,$posts) = @_;
  my $inf = get_cookie("mb-user");
  if(!$inf) { return; }
  if(!$lastmodified || $lastmodified == 0) { $tagicons[3] = 1; return "<img src=\"$paths{'noncgi_url'}/images/topic-old.gif\">"; }

  # Special case -- within a thread new tags
  if($posts == -1) {
    if($lastvisited <= $lastmodified) {
      return "<img src=\"$paths{'noncgi_url'}/images/new.gif\">";
    } else { return ""; }
  }
  if($lastvisited =~ /\|/) { $lastvisited =~ s/\|//ig; }
  if(!$lastvisited) { $lastvisited = 0; }
  if($lastvisited <= $lastmodified) {  # New
    if($sticky != 1) {
      if($posts >= $config{'hot_topic_posts'}) {
        $tagicons[0] = 1;
        return "<img src=\"$paths{'noncgi_url'}/images/topic-hotnew.gif\">";
      } else {
        $tagicons[1] = 1;
        return "<img src=\"$paths{'noncgi_url'}/images/topic-new.gif\">";
      }
    } else {
      $tagicons[5] = 1;
      return "<img src=\"$paths{'noncgi_url'}/images/sticky-new.gif\">";
    }
  } else {   # Not new
    if($sticky != 1) {
      if($posts >= $config{'hot_topic_posts'}) {
        $tagicons[2] = 1;
        return "<img src=\"$paths{'noncgi_url'}/images/topic-hot.gif\">";
      } else {
        $tagicons[3] = 1;
        return "<img src=\"$paths{'noncgi_url'}/images/topic-old.gif\">";
      }
    } else {
      $tagicons[6] = 1;
      return "<img src=\"$paths{'noncgi_url'}/images/sticky-old.gif\">";
    }
  }

  return "";
}


###############################################################################
# position_tracker()
#
# Inputs  : $logo (or blank for default), @positions
# Returns : none
# Function: Creates a hierarchal navigation system to show the position on
#           the board that a person is currently at.  The name of the message
#           board is ALWAYS the first entry, followed by each of @positions.
###############################################################################
sub position_tracker {
  my($logo,@positions) = @_;
  if(!$logo || !-e "$paths{'noncgi_path'}/images/$logo") { $logo = $config{'board_logo'}; }

  print <<end;
    <table width="$config{'table_width'}" border="0" align="center"><tr><td valign="top" width=\"30%\">
      <img src="$paths{'noncgi_url'}/images/$logo"></td>
      <td width="1%">&nbsp;</td>
      <td valign="top" align="left">
end
  my $count = @positions;
  print "<font face=\"Verdana\" size=\"2\"><a href=\"$paths{'board_url'}scarecrow.cgi\">$config{'board_name'}</a></font><br>\n";
  for($x = 1; $x <= $count; $x++) {
    my $spaces = "";
    for($y = 1; $y <= $x; $y++) {
      $spaces .= "&nbsp;&nbsp;";
    }
    #my $img = "<img src=\"$paths{'noncgi_url'}/images/";
    #if($x == $count) { $img .= "tracker-open.gif\">&nbsp;";   }
    #else             { $img .= "tracker-closed.gif\">&nbsp;"; }
    print "$spaces<img src=\"$paths{'noncgi_url'}/images/bar.gif\">&nbsp;$img<font face=\"Verdana\" size=\"2\">$_[$x]</font><br>\n";
  }
  print "    </td>\n";
  print "  </tr>\n";
  print "  </table><br>\n";
}

###############################################################################
# check_private()
#
# Inputs  : @foruminfo
# Returns : none
# Function: Determines whether or not a user has access to a private forum.
#           If they are not logged in, supplies a form to log in first that
#           will return them to the referring page.
###############################################################################
sub check_private {
  my $access = "FALSE";
  my @foruminfo = @_;
  if($foruminfo[7] eq 'private') {
    my $inf = get_cookie("mb-user");
    my($membername,$password) = split(/\|/,$inf);
    if(check_account($membername,$password) == $FALSE) {
      notice_box("You Do Not Have Access To $foruminfo[2]","<br>You are not on the list of authorized users for this forum.<br>");
      page_footer();
      exit;
    }
    if(!$membername) { private_access_form($foruminfo[0]); }
    if($allowed{$membername}{$forum} eq 'yes') { $access = "TRUE";  }
    else                                       { $access = "FALSE"; }

    if($access ne "TRUE" && $users{$membername}{'memberstate'} ne 'admin') {
      # They do not have access
      notice_box("You Do Not Have Access To $foruminfo[2] ($forum)","<br>You are not on the list of authorized users for this forum.<br>");
      page_footer();
      exit;
    }
  }
}

##############################################################################
# private_access_form()
# Inputs  : none
# Returns : none
# Function: Creates a form for a person to attempt to log in to a private
#           forum.
###############################################################################
sub private_access_form {
  #print $query->redirect("$paths{'board_url'}login.cgi");
  print "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"$time; URL=$ref_url\">\n";
  return;

  my $html = "";
  $html = qq~
    <form action="$board_url\forum.cgi" method="post">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr><td><b>Username</b></td><td><input type="text" name="user"></td></tr>
      <tr><td><b>Password</b></td><td><input type="password" name="pass"></td></tr>
    </table>
    <input type="hidden" name="cookie" value="yes">
    <input type="hidden" name="forum" value="$_[0]">
    <input type="submit" name="Submit" value="Submit">
    </form>
~;
  notice_box("Log In To A Private Forum",$html);
}

###############################################################################
# send_cookie()
#
# Inputs  : none
# Returns : none
# Function: Outputs a cookie if there is valid data provided.
###############################################################################
sub send_cookie {
  my $user = $Pairs{'user'};
  my $pass = $Pairs{'pass'};
  if(!$user || !$pass) { content(); return; }

  # If we're here, the account is valid--send the cookies
  my $namecookie = $query->cookie(-name   =>   "mb-user",
                         -value   =>   "$user|$pass",
                         -path    =>   $cookiepath,
                         -domain  =>   $paths{'cookie_domain'},
                         -expires =>   "+60d");

  print $query->header(-cookie=>$namecookie);
}

###############################################################################
# content()
#
# Inputs  : none
# Returns : none
# Function: Checks if there is a forumtimes cookie.  If not, tries to output it
#           if a user is logged in.  Either way, it outputs the content header
###############################################################################
sub content {
  my $inf1 = get_cookie("mb-forums");
  my @forumtimes = split(/\|/,$inf1);
  my $inf2 = get_cookie("mb-user");
  my($user,$pass) = split(/\|/,$inf2);
  
  if(!$user || !$inf2) {} else {
    if(!$inf1) {  # We've got to output one
      # Get the forum information
      lock_open(lastread,"$cgi_path/lastread/$user.dat","r");
      my $data = <lastread>;
      close(lastread);
      if(!$data) { $data = -1; }

      # Output the cookie
      my $cookie = $query->cookie(-name => "mb-forums",
      #my $cookie = $query->cookie(-name    => "mb-forums",
                                  -domain  =>   $paths{'cookie_domain'},
                                  -value   => $data,
                                  -path    => $cookiepath);
      print $query->header(-cookie=>$cookie,-pragma=>'no-cache');
      $content_sent = 1;
    }
  }
  if($content_sent != 1) { 
    print $query->header(-pragma=>'no-cache');
    $content_sent = 1;
  }
}

###############################################################################
# get_forum_information()
#
# Inputs  : $forumnumber
# Returns : @foruminfo or $foruminfo
# Function: Reads and returns the forum information for a given forum
###############################################################################
sub get_forum_information {
  my $f = 0;
  my $forum = $_[0];
  lock_open(file,"$cgi_path/data/forum.lst","r");
  while($in = <file>) {
    my($a,$id) = split(/\|/,$in);
    if($id == $forum) { $f = 1; $line = $in; last; }
  }
  close(file);
  @info = split(/\|/,$line);
  lock_open(file,"$cgi_path/forum$forum/forum.opt",'r');
  while($in = <file>) {
    $in = strip($in);
    my($name,$value) = split(/=/,$in,2);
    $foruminformation{$forum}{$name} = $value;
  }
  close(file);
  if($f != 1) { scarecrow_die("No such forum entry ($forum)."); }
  # Add a few things to the array
  $foruminformation{$forum}{'name'} = $info[2];
  $foruminformation{$forum}{'description'} = $info[3];
  
  # Override certain entries with option file entries
  $info[4] = $foruminformation{$forum}{'moderators'};
  $info[13] = $foruminformation{$forum}{'forumlogo'};
  $info[5] = $foruminformation{$forum}{'htmlallow'};
  $info[6] = $foruminformation{$forum}{'sccallow'};
  $info[7] = $foruminformation{$forum}{'forumstatus'};
  $info[8] = $foruminformation{$forum}{'postrequirements'};

  # Return the information the way they want it
  return @info;
}

###############################################################################
# load_user_database()
#
# Inputs  : none
# Returns : none
# Function: Loads the user database into a hash of hashes.
###############################################################################
sub load_user_database {
  # Variables
  my($in,$membername,$member,@members,%info) = "";

  # First, let's get a member list
  opendir(dir,"$cgi_path/members/");
  while($in = readdir(dir)) {
    if(-d "$cgi_path/members/$in") { next; }
    ($membername,$rest) = split(/\./,$in);
    push @members,$membername;
  }
  closedir(dir);

  # Load the hash for each member, and place it into a hash by member name.
  foreach $member (@members) {
    lock_open(member,"$cgi_path/members/$member.dat",'r');
    while($in = <member>) {
      $in = strip($in);
      my($name,$value) = split(/=/,$in);
      $userdatabase{$member}{$name} = $value;
    }
    close(member);
  }
}

###############################################################################
# translate_emoticons()
#
# Inputs  : $string
# Returns : formatted string
# Function: Translates ASCII smilies into graphics
###############################################################################
sub translate_emoticons {
  my $string = $_[0];

  # Get a list of emoticons
  if($emoticons_done != 1) {
    opendir(emoticons,"$paths{'noncgi_path'}/emoticons/");
    @list = readdir(emoticons);
    closedir(emoticons);
    @list = grep(/gif/,@list);
    $emoticons_done = 1;
  }

  # Translate special emoticons first (ones explicitly declared)
  my $path = "$paths{'noncgi_url'}/emoticons";
  $string =~ s/\:\)/<img src=\"$path\/smile.gif\" border=\"0\">/ig;
  $string =~ s/\:\(/<img src=\"$path\/frown.gif\" border=\"0\">/ig;

  # Translate the list of emoticons
  foreach my $entry (@list) {
    my $filename  = $entry;
    my $smilename = $entry;
    $smilename =~ s/\.gif//ig;
    $string =~ s/\:$smilename\:/<img src=\"$path\/$filename\" border=\"0\">/ig;
  }

  return $string;
}

###############################################################################
# codeify()
#
# Inputs  : $string
# Returns : formatted string
# Function: Translates ScareCrow code into HTML
###############################################################################
sub codeify {
  my $string = $_[0];

  # Quotes
  #$string =~ s/\[quote\]/<CENTER><table CELLSPACING=0 border=0 WIDTH=95\% BGCOLOR=$color_config{'body_textcolor'}><TR><TD><table width=\"100%\" cellspacing=\"2\" cellpadding=\"5\" border=\"0\"><tr bgcolor=\"$color_config{'body_bgcolor'}\"><td>/isg;
  #$string =~ s/\[\/quote\]/<\/td><\/tr><\/font><\/td><\/tr><\/table><\/center>/isg;
  #$string =~ s/\[quote\](.+?)\[\/quote\]/<table width=\"60%\" align=\"center\"><tr><td><hr><font face=\"Verdana\" size=\"1\">$1<\/font><hr><\/td><\/tr><\/table>/ig;
  $string =~ s/\[quote\]/<table width=\"90%\" cellspacing=\"0\" cellpadding=\"0\" align=\"center" border=\"0\" bgcolor=\"$color_config{'border_color'}\"><tr><td><table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"5\"><tr bgcolor=\"$color_config{'body_bgcolor'}\"><td align=\"left\"><font face=\"Verdana\" size=\"1\" color=\"$color_config{'body_textcolor'}\">/ig;
  $string =~ s/\[\/quote\]/<\/font><\/pre><\/td><\/tr><\/table><\/td><\/tr><\/table>/ig;

  $string =~ s/\[b\](.+?)\[\/b\]/<b>$1<\/b>/ig;
  $string =~ s/\[i\](.+?)\[\/i\]/<i>$1<\/i>/ig;
  $string =~ s/\[u\](.+?)\[\/u\]/<u>$1<\/u>/ig;
  #$string =~ s/http:\/\/([A-Za-z0-9\_\-\.]*\/{0,})([A-Za-z0-9\_\-\.]*\/{0,1})([\.\,\s+]{0,})/<a href=\"http:\/\/$1$2\">$1$2<\/a>/ig;
  #$string =~ s/<a href=\"(.+?)\.\">(.+?)\.<\/a>/<a href=\"$1\" target=\"_blank\">$2<\/a>/ig;
  $string =~ s/\[url=(.+?)](.+?)\[\/url\]/<a href=\"$1\" target=\"_blank\">$2<\/a>/ig;
  $string =~ s/\[url\](.+?)\[\/url\]/<a href=\"$1\" target=\"_blank\">$1<\/a>/ig;
  $string =~ s/\[color=(.+?)\](.+?)\[\/color\]/<font color=\"$1\">$2<\/font>/ig;
  $string =~ s/\[font=(.+?)\](.+?)\[\/font\]/<font face=\"$1\">$2<\/font>/ig;
  $string =~ s/\[size=(.+?)\](.+?)\[\/size\]/<font size=\"$1\">$2<\/font>/ig;
  $string =~ s/\[email=(.+?)\](.+?)\[\/email\]/<a href=\"mailto:$1\">$2<\/a>/ig;
  $string =~ s/\[email\](.+?)\[\/email\]/<a href=\"mailto:$1\">$1<\/a>/ig;
  $string =~ s/\[br\]/<br>/ig;
  $string =~ s/\[p\]/<br><br>/ig;
  $string =~ s/\[pre\](.+?)\[\/pre\]/<pre>$1<\/pre>/ig;
  $string =~ s/\[code\](.+?)\[\/code\]/<table width=\"90%\" cellspacing=\"0\" cellpadding=\"0\" align=\"center" border=\"0\" bgcolor=\"$color_config{'border_color'}\"><tr><td><table width=\"100%\" border=\"0\" cellspacing=\"2\" cellpadding=\"5\"><tr bgcolor=\"$color_config{'body_bgcolor'}\"><td align=\"left\"><font face=\"Verdana\" size=\"1\" color=\"$color_config{'code_textcolor'}\"><b>Code Sample<\/b><\/font><br><br><font face=\"Verdana\" size=\"1\" color=\"$color_config{'code_textcolor'}\">$1<\/font><\/pre><\/td><\/tr><\/table><\/td><\/tr><\/table>/ig;

  # List data
  $string =~ s/\[list\]/<ul>/ig;    $string =~ s/\[\/list\]/<\/ul>/ig;
  $string =~ s/\[item\]/<li>/ig;    $string =~ s/\[\/item\]/<\/li>/ig;
  
  # File attachments
  $string =~ s/\[file=(.+?)\](.+?)\[\/file\]/<a href=\"$paths{'noncgi_url'}\/uploads\/$2\"><img src=\"$paths{'noncgi_url'}\/images\/mimetypes\/$1\" border=\"0\">\&nbsp\;$2<\/a>/ig;
  
  # We have to do image tags separately with some security checks in due to
  # an exploitable problem in the prior method.
  while($string =~ /\[img\](.+?)\[\/img\]/i) {
    if($1 =~ /cgi-bin/ || $1 =~ /\.cgi/ || $1 =~ /\.pl/) {
      $string =~ s/\[img\](.+?)\[\/img\]/<font color=\"red\">SECURITY ALERT: $1<\/font>/i;
    } else {
      $string =~ s/\[img\](.+?)\[\/img\]/<img src=\"$1\">/i;
    }
  }

  return $string;
}

###############################################################################
# is_moderator()
#
# Inputs  : $username, $forum
# Returns : $TRUE or $FALSE
# Function: Determines if the user is a moderator in a given forum.
###############################################################################
sub is_moderator {
  my($who,$forum) = @_;

  if(!$users{$who}) { get_member($who); }
  if($users{$who}{'memberstate'} eq 'moderator' || $users{$who}{'memberstate'} eq 'mod') { return $TRUE; }

  get_forum_information($forum);
  my $are = $foruminformation{$forum}{'moderators'};
  my @list = split(/,/,$are);
  foreach my $a (@list) {
    $a = strip($a);
    if($a eq $who) { return $TRUE; }
  }
  return $FALSE;
}

###############################################################################
# forumjump()
#
# Inputs  : none
# Returns : $html
# Function: Returns HTML code for a forum jump select box.
###############################################################################
sub forumjump {
  my $final = "";

  # Get the forum information
  lock_open(file,"$cgi_path/data/forum.lst",'r');
  my @forums = <file>;
  close(file);

  # Load the catagory names
  lock_open(catagory_file,"data/catagories.lst",'r');
  while($in = <catagory_file>) {
    $in = strip($in);
    $c++;
    $catagories{$c} = $in;
  }
  close(catagory_file);

  # Loop through and create an entry for each
  foreach my $entry (@forums) {
    my($cat,$num,$name,@rest) = split(/\|/,$entry);
    if($cat == $lastcat) { $catagory = ""; }
    else {
      $catagory = $catagories{$cat};
      $lastcat = $cat;
    }
    if($catagory) {
      $final .= qq~<option value="-1">-- $catagory</option>~;
    }
    $final .= qq~<option value="$num">$name</option>~;
  }

  return $final;
}

###############################################################################
# generate_random_string()
#
# Inputs  : $length
# Returns : $randomstring
# Function: Generates a random string of specified length.
###############################################################################
sub generate_random_string {
    my $characters = $_[0];
    my $letters, $letter,$string;
    for($letters = 0; $letters < $characters; $letters++)
    {
        # Randomize here
        my $num = -1;
        while($num < 0 || $num > 61)
        {  $num = int(rand 61);  }

        if($num >= 0 && $num <= 9)  { $letter = $num; }
        elsif($num == 10)           { $letter = 'A';  }
        elsif($num == 11)           { $letter = 'B';  }
        elsif($num == 12)           { $letter = 'C';  }
        elsif($num == 13)           { $letter = 'D';  }
        elsif($num == 14)           { $letter = 'E';  }
        elsif($num == 15)           { $letter = 'F';  }
        elsif($num == 16)           { $letter = 'G';  }
        elsif($num == 17)           { $letter = 'H';  }
        elsif($num == 18)           { $letter = 'I';  }
        elsif($num == 19)           { $letter = 'J';  }
        elsif($num == 20)           { $letter = 'K';  }
        elsif($num == 21)           { $letter = 'L';  }
        elsif($num == 22)           { $letter = 'M';  }
        elsif($num == 23)           { $letter = 'N';  }
        elsif($num == 24)           { $letter = 'O';  }
        elsif($num == 25)           { $letter = 'P';  }
        elsif($num == 26)           { $letter = 'Q';  }
        elsif($num == 27)           { $letter = 'R';  }
        elsif($num == 28)           { $letter = 'S';  }
        elsif($num == 29)           { $letter = 'T';  }
        elsif($num == 30)           { $letter = 'U';  }
        elsif($num == 31)           { $letter = 'V';  }
        elsif($num == 32)           { $letter = 'W';  }
        elsif($num == 33)           { $letter = 'X';  }
        elsif($num == 34)           { $letter = 'Y';  }
        elsif($num == 35)           { $letter = 'Z';  }
        elsif($num == 36)           { $letter = 'a';  }
        elsif($num == 37)           { $letter = 'b';  }
        elsif($num == 38)           { $letter = 'c';  }
        elsif($num == 39)           { $letter = 'd';  }
        elsif($num == 40)           { $letter = 'e';  }
        elsif($num == 41)           { $letter = 'f';  }
        elsif($num == 42)           { $letter = 'g';  }
        elsif($num == 43)           { $letter = 'h';  }
        elsif($num == 44)           { $letter = 'i';  }
        elsif($num == 45)           { $letter = 'j';  }
        elsif($num == 46)           { $letter = 'k';  }
        elsif($num == 47)           { $letter = 'l';  }
        elsif($num == 48)           { $letter = 'm';  }
        elsif($num == 49)           { $letter = 'n';  }
        elsif($num == 50)           { $letter = 'o';  }
        elsif($num == 51)           { $letter = 'p';  }
        elsif($num == 52)           { $letter = 'q';  }
        elsif($num == 53)           { $letter = 'r';  }
        elsif($num == 54)           { $letter = 's';  }
        elsif($num == 55)           { $letter = 't';  }
        elsif($num == 56)           { $letter = 'u';  }
        elsif($num == 57)           { $letter = 'v';  }
        elsif($num == 58)           { $letter = 'w';  }
        elsif($num == 59)           { $letter = 'x';  }
        elsif($num == 60)           { $letter = 'y';  }
        elsif($num == 61)           { $letter = 'z';  }
        $string .= $letter;
    }
    if(length($string) < $characters)
    {
        redirect_die("A fatal error has occured generating your password.  Please try again.","","3","red");
    }
    return $string;

}

###############################################################################
# tempfile()
#
# Inputs  : $filehandle
# Returns : $tempfilename
# Function: Gets a unique temp filename and returns it to the caller open for
#           writing.
###############################################################################
sub tempfile {
  $fh = shift;

  if(!$fh) { scarecrow_die("global.cgi (tempfile): No filehandle supplied."); }

  # Generate the random filename
  my $filename = time();   $filename .= '-';
  $filename .= int(rand 10000);

  # Open it up -- it is exclusively named, so needn't be exclusively opened
  open($fh,">$filename");

  return $filename;
}

###############################################################################
# increase_forum_count()
#
# Inputs  : $forum,$position,$amount
# Returns : none
# Function: Increases the post/thread counts in a forum by a specified amount.
#           The amount can be a negative.
###############################################################################
sub increase_forum_count {
  my($id,$type,$amt,$itime,$who) = @_;
  my $final = "";
  lock_open(forums,"$cgi_path/data/forum.lst","rw");
  seek(forums,0,0);
  while($in = <forums>) {
    $in = strip($in);
    my @inf = split(/\|/,$in);
    if($inf[1] == $id) {  # Found the ID
      if($type eq 'posts') {
        $inf[9] += $amt;
      } elsif($type eq 'threads') {
        $inf[10] += $amt;
      } elsif($type eq 'postupdate') {
        $inf[9] += $amt;   $inf[11] = $itime;   $inf[12] = $who;
      } elsif($type eq 'bothupdate') {
        $inf[9] += $amt;     $inf[10] += $amt;
        $inf[11] = $itime;   $inf[12] = $who;
      } elsif($type eq 'update') {
        $inf[11] = $itime;   $inf[12] = $who;
      } elsif($type eq 'both') {
        $inf[9] += $amt;     $inf[10] += $amt;
      } else {
        $inf[9] += $amt;    $inf[10] += $amt;
      }
    }
    my $line = join('|',@inf);
    $final .= "$line\n";
  }
  truncate(forums,0);
  seek(forums,0,0);
  print forums $final;
  close(forums);
}


###############################################################################
# activeusers()
#
# Inputs  : $where
# Returns : none
# Function: Adds/updates a user to the active users list.  The function has
#           to get user names/guest IPs by itself, as only a location is
#           given.
###############################################################################
sub activeusers {
  my $doing = $_[0];
  my $inf = get_cookie("mb-user");
  my($membername,$password) = split(/\|/,$inf);
  my $final, $match = "";
  $doing =~ s/\|/\*/ig;

  if($membername == $FALSE || !$membername) {
     $membername = "Guest $ENV{'REMOTE_ADDR'}";
  } else {
    # Check if they have the "hide" option on and abort if so
    if($users{$membername}{'activehide'} eq 'yes') { return; }  # They have the hide option set
  }
  
  if(!$membername) { scarecrow_die("global.cgi (activeusers) : Unable to determine membername ($membername) for active users."); }
  

  # See if they're in the list.  If so, update their location.  If not, add
  # them.  While we're here, also check for expired entries.
  lock_open(activeusers,"$cgi_path/data/active.txt","r");
  while(my $in = <activeusers>) {
    $in = strip($in);
    my($lastactivity,$user,$where) = split(/\|/,$in);
    if(time - 900 > $lastactivity) {} else {
      if($user eq $membername) {
        if($where ne $doing) {
          $where = $doing;
        }
        $lastactivity = time();
        $match = 1;
      }
      $final .= "$lastactivity|$user|$where\n";
    }
  }
  if($match != 1) {
    my $now = time();
    $final .= "$now|$membername|$doing\n";
  }
  close(activeusers);

  # Write any changes that have been made
  lock_open(ACTIVEUSERS,"$cgi_path/data/active.txt","w");
  truncate(ACTIVEUSERS,0);    seek(ACTIVEUSERS,0,0);
  print ACTIVEUSERS $final;
  close(ACTIVEUSERS);

  return $TRUE;
}

###############################################################################
# get_member()
#
# Inputs  : $member
# Returns : none
# Function: Adds $member's information to the %users array.
###############################################################################
sub get_member {
  my $member = $_[0];
  if($users{$member}{'memberstate'}) { return ""; }

  # Get the entry from the file
  if(!-e "$cgi_path/members/$member.dat") { return $FALSE; }
  lock_open(member,"$cgi_path/members/$member.dat","r");
  while($in = <member>) {
    $in = strip($in);
    my($name,$value) = split(/=/,$in,2);
    $users{$member}{$name} = $value;
  }
  close(member);

  # Get the private forum access
  if($users{$member}{'privateaccess'}) {
    if($users{$member}{'privateaccess'} =~ /\;/) {
      @parts = split(/\;/,$users{$member}{'privateaccess'});
      foreach my $part (@parts) {
        $allowed{$member}{$part} = "yes";
      }
    } else { $allowed{$member}{$users{$member}{'privateaccess'}} = "yes"; }
  }
  
  # Get a list of the groups they belong to
  if($users{$member}{'groups'}) {
    if($users{$member}{'groups'} =~ /,/) {
      @parts = split(/\,/,$users{$member}{'groups'});
      foreach my $part (@parts) {
        $usergroups{$member}{$part} = "yes";
      }
    }
    else { $usergroups{$member}{$users{$member}{'groups'}} = "yes"; }
  }
  
  # If the user is unvalidated, impose some restrictions
  if($users{$member}{'validated'} eq 'no') {
    # Add the "Unvalidated" user group if it exists
    lock_open(GROUPS,"$cgi_path/data/groups.txt","r");   my @groups = <GROUPS>;   close(GROUPS);
    foreach my $line (@groups) { my($name,@rest) = split(/\|/,$line);  if($name eq 'Unvalidated') { $a = 1; last; } }
    if($a == 1)  { # There IS an "Unvalidated" group.  Add them
      $users{$member}{'groups'} .= ",Unvalidated";
      $usersgroups{$member}{'Unvalidated'} = "yes";
    } else { # The group does NOT exist - impose some reasonable denies
      # Deny: Posting (any), deleting (any), editing (any), flood ignore, user editor, CP, announcements,
      # overrides, attachments, lock/unlocks, prunes, sticky topics, admin data, and queues (any)
      #
      # Allow: Private messages, profile editing
      $users{$member}{'denies'} |= "11111111100111111111";
    }
  }

  return $TRUE;
}

###############################################################################
# load_post_levels()
#
# Inputs  : none
# Returns : none
# Function: Loads the number=posts_requirement=Class_title pairs
###############################################################################
sub load_post_levels {
  lock_open(levels,"$cgi_path/data/dots.txt","r");
  @postlevels = <levels>;
  close(levels);
  #while($in = <levels>) {
  #  $in = strip($in);
  #  
  #  my($req,$class,$dots) = split(/=/,$in);
  #  $postreq{$level} = $req;
  #  $classes{$level} = $class;
  #}
  #close(levels);
}

###############################################################################
# remove_cookies()
#
# Inputs  : none
# Returns : none
# Function: Adds $member's information to the %users array.
###############################################################################
sub remove_cookies {
  my $a = cookie(-name    =>   "mb-user",
                 -value   =>   "",
                 -path    =>   $cookiepath,
                 -expires =>   "now");
  my $b = cookie(-name    =>   "mb-forums",
                 -value   =>   "",
                 -path    =>   $cookiepath,
                 -expires =>   "now");
                         
  print $query->header(-cookie=>[$a, $b]);
}

###############################################################################
# update_lastread()
#
# Inputs  : $forum, (1 || 0)
# Returns : $TRUE or $FALSE
# Function: Updates the last time a member has read a forum LOCALLY.  If $_[1]
#           is 1, also attempts to send out a cookie to update it for the
#           user.
###############################################################################
sub update_lastread {
  my ($forum,$option) = @_;
  # Get the username or abort
  my $cookie = get_cookie("mb-user");
  my($user,$pass) = split(/\|/,$cookie);
  if(!$user) { content(); return $FALSE; }

  # Update their information
  my $now = time();
  lock_open(lastread,"$cgi_path/lastread/$user.dat","r");
  $data = <lastread>;
  close(lastread);
  my(@forums) = split(/\|/,$data);
  $forums[$forum] = $now;
  $data = join('|',@forums);
  $data = strip($data);   $data .= "\n";
  lock_open(lastread,"$cgi_path/lastread/$user.dat","w");
  truncate(lastread,0);   seek(lastread,0,0);
  print lastread $data;
  close(lastread);

  # Update the user's last visited data
  get_member($user);
  $users{$user}{'lastvisited'} = time;
  saveuser($user);

  # Send a cookie if requested
  if($option == 1) {
    my $cookie = $query->cookie(-name      => "mb-forums",
                        -domain  =>   $paths{'cookie_domain'},
                        -value     => $data,
                        -expires   => "",
                        -path      => $cookiepath);
    print $query->header(-cookie=>$cookie);
    $content_sent = 1;
  } elsif($option == 2) { # Do nothing
  } else { # Send the content type anyway to begin the page
    content();
  }

  return $TRUE;
}

###############################################################################
# get_lastvisited
#
# Inputs  : $forum
# Returns : int lastvisited
# Function: Returns the time a user has last visisted the specified forum.
###############################################################################
sub get_lastvisited {
  my $forum = $_[0];
  my $inf = get_cookie("mb-user");

  if(!$forum) { return 0; }
  if(!$inf)   { return 0; }
  my($user,$pass) = split(/\|/,$inf);
  if(!-e "$cgi_path/lastread/$user.dat") { return 0; }

  lock_open(lastread,"$cgi_path/lastread/$user.dat","r");
  my $data = <lastread>;
  close(lastread);

  my @forumtimes = split(/\|/,$data);

  return $forumtimes[$forum] || 0;
 
}

###############################################################################
# taglist()
#
# Inputs  : none
# Returns : none
# Function: Displays an explanation of all posts icons that have been shown
#           on the current page, to the current user.
###############################################################################
sub taglist {
  if($tagicons[0] + $tagicons[1] + $tagicons[2] + $tagicons[3] + $tagicons[4] + $tagicons[5] + $tagicons[6] +$tagicons[7] == 0) { return; }
  $help = helpline("Sticky_Topics");

  my $output = qq~
    <br><br><table width="$config{'table_width'}" align="center" cellspacing="0" cellpadding="0" bgcolor="$color_config{'border_color'}" border="0"><tr><td>
      <table width="100%" cellspacing="1" cellpadding="5" border="0">
        <tr bgcolor="$color_config{'nav_top'}">
          <td colspan="2"><font face="Verdana" size="1"><b>Icon Explanation</b></font></td>
        </tr>~;

  if($tagicons[0] == 1) {
    $output .= qq~
      <tr bgcolor="$color_config{'body_bgcolor'}">
        <td align="center" width="5%"><img src="$paths{'noncgi_url'}/images/topic-hotnew.gif"></td>
        <td><font face="Verdana" size="1">New topic with more than $config{'hot_topic_posts'} posts.</font></td>
      </tr>~;
  }
  if($tagicons[1] == 1) {
    $output .= qq~
      <tr bgcolor="$color_config{'body_bgcolor'}">
        <td align="center" width="5%"><img src="$paths{'noncgi_url'}/images/topic-new.gif"></td>
        <td><font face="Verdana" size="1">New topic.</font></td>
      </tr>~;
  }
  if($tagicons[2] == 1) {
    $output .= qq~
      <tr bgcolor="$color_config{'body_bgcolor'}">
        <td align="center" width="5%"><img src="$paths{'noncgi_url'}/images/topic-hot.gif"></td>
        <td><font face="Verdana" size="1">Topic with more than $config{'hot_topic_posts'} posts.</font></td>
      </tr>~;
  }
  if($tagicons[3] == 1) {
    $output .= qq~
      <tr bgcolor="$color_config{'body_bgcolor'}">
        <td align="center" width="5%"><img src="$paths{'noncgi_url'}/images/topic-old.gif"></td>
        <td><font face="Verdana" size="1">No new posts.</font></td>
      </tr>~;
  }
  if($tagicons[5] == 1) {
    $output .= qq~
      <tr bgcolor="$color_config{'body_bgcolor'}">
        <td align="center" width="5%"><img src="$paths{'noncgi_url'}/images/sticky-new.gif"></td>
        <td><font face="Verdana" size="1">A sticky topic with new replies. $help</font></td>
      </tr>~;
  }
  if($tagicons[6] == 1) {
    $output .= qq~
      <tr bgcolor="$color_config{'body_bgcolor'}">
        <td align="center" width="5%"><img src="$paths{'noncgi_url'}/images/sticky-old.gif"></td>
        <td><font face="Verdana" size="1">A sticky topic with no new replies. $help</font></td>
      </tr>~;
  }
  if($tagicons[4] == 1) {
    $output .= qq~
      <tr bgcolor="$color_config{'body_bgcolor'}">
        <td align="center" width="5%"><img src="$paths{'noncgi_url'}/images/locked.gif"></td>
        <td><font face="Verdana" size="1">The topic is locked.  No new replies are being accepted.</font></td>
      </tr>~;
  }
  if($tagicons[7] == 1) {
    $output .= qq~
      <tr bgcolor="$color_config{'body_bgcolor'}">
        <td align="center" width="5%"><img src="$paths{'noncgi_url'}/images/stickylocked.gif"></td>
        <td><font face="Verdana" size="1">The topic is sticky, and locked.  No new replies are being accepted.</font></td>
      </tr>~;
  }

  $output .= qq~
      </table>
    </td></tr></table>~;

  print $output;
}

###############################################################################
# mark()
#
# Inputs  : none
# Returns : none
# Function: Sets marks for debugging purposes.
###############################################################################
sub mark {
  $mark++;
  $time = time;
  print "mark $mark: $time<br>\n";
}

###############################################################################
# round()
#
# Inputs  : $number, $places
# Returns : rounded number
# Function: Rounds the specified number to the specified number of places.
###############################################################################
sub round {
  return (int($_[0] * (10 ** $_[1]) + .5) / (10 ** $_[1]));
}

###############################################################################
# get_next_id()
#
# Inputs  : $forum
# Returns : ID
# Function: Returns the next available ID for a forum.
###############################################################################
sub get_next_id {
  my $forum = $_[0];
  my $lastid;
  if(!-e "$cgi_path/forum$forum/post.cnt") { $lastid = 0; }
  else {
    lock_open(idfile,"$cgi_path/forum$forum/post.cnt","r");
    $lastid = <idfile>;
    close(idfile);
  }
  $lastid = strip($lastid);
  $lastid++;  # New id number
  # Record it as the last ID used
  lock_open(idfile,"$cgi_path/forum$forum/post.cnt","w");
  truncate(idfile,0);   seek(idfile,0,0);
  print idfile "$lastid\n";
  close(idfile);

  # Return it
  return $lastid;
}

###############################################################################
# rebuildlist()
#
# Inputs  : $forum
# Returns : none
# Function: Rebuilds a forum's forum.lst file from the .idx files.
###############################################################################
sub rebuildlist {
  my $forum = $_[0];
  my @threads,$line,@lines = "";
  if(!$forum || !-d "$cgi_path/forum$forum") { scarecrow_die("global.cgi: rebuildlist(); -- No valid forum specified."); }

  # Get a list of all the threads (idx files)
  opendir(FORUM,"$cgi_path/forum$forum/");
  @threads = readdir(FORUM);
  closedir(FORUM);
  @threads = grep(/\.idx/,@threads);

  # Sort the list by the date
  @threads = datesort(@threads);

  # Get the thread data in advance
  foreach my $thread (@threads) {
    lock_open(THREAD,"$cgi_path/forum$forum/$thread","r");
    my $line = <THREAD>;
    close(THREAD);
    $line = strip($line);  $line = "$line\n";
    push @lines,$line;
  }

  # Recreate the list file
  lock_open(LIST,"$cgi_path/forum$forum/forum.lst","w",2);
  truncate(LIST,0);
  seek(LIST,0,0);
  foreach $line (@lines) { $line = strip($line); if($line) { print LIST "$line\n"; } }
  close(LIST);
}

###############################################################################
# datesort()
#
# Inputs  : @array
# Returns : sorted array
# Function: Sorts a forum thread list array.
###############################################################################
sub datesort {
  my @data = @_;
  my @idx;
  # Compile the index array
  foreach $entry (@data) {
    my($topicnumber,$topictitle,$topicdescription,$topicstate,$replies,$views,$poster,$posttime,$lastposter,$lastmodtime) = split(/\|/,$entry);
    push @idx, $posttime > $lastmodtime ? $posttime : $lastmodtime;
  }
  # Sort it
  @data = @data[ sort { $idx[$b] <=> $idx[$a] } 0 .. $#idx ];
  # Return
  return @data;
}


###############################################################################
# adjust_postcounts()
#
# Inputs  : $forum,$topic,$adjustment,$type
# Returns : none
# Function: Updates the forum and topic postcounts
###############################################################################
sub adjust_postcounts {
  my($forum,$topic,$adjustment,$type) = @_;

  # Adjust the data in the .idx file first
  lock_open(IDX,"$cgi_path/forum$forum/$topic.idx","rw");
  seek(IDX,0,0);
  my $line = <IDX>;
  $line = strip($line);
  # Split it into parts and make the adjustment
  my @parts = split(/\|/,$line);
  $parts[4] += $adjustment;
  $line = join('|',@parts);
  # Clear the file and re-write the changse
  truncate(IDX,0);
  seek(IDX,0,0);
  print IDX "$line\n";
  close(IDX);

  # Now adjust the data in the forum/forum.lst file
  my $final = "";
  lock_open(FLIST,"$cgi_path/forum$forum/forum.lst","rw");
  seek(FLIST,0,0);
  while(my $in = <FLIST>) {
    $in = strip($in);
    my @parts = split(/\|/,$in);
    if($parts[0] == $topic) {
      $parts[4] += $adjustment;
    }
    $in = join('|',@parts);
    $final .= "$in\n";
  }
  truncate(FLIST,0);
  seek(FLIST,0,0);
  print FLIST $final;
  close(FLIST);

  # Last, update the master forum list information
  $final = "";
  lock_open(FORUMLIST,"$cgi_path/data/forum.lst","rw");
  seek(FORUMLIST,0,0);
  while(my $in = <FORUMLIST>) {
    $in = strip($in);
    my @parts = split(/\|/,$in);
    if($parts[1] == $forum) {
      $parts[9] += $adjustment;
      if($type eq 'threadkill') { $parts[10]--; }
    }
    $in = join('|',@parts);
    $final .= "$in\n";
  }
  truncate(FORUMLIST,0);
  seek(FORUMLIST,0,0);
  print FORUMLIST $final;
  close(FORUMLIST);
}

###############################################################################
# delete_thread()
#
# Inputs  : $forum, $topic, $rebuild
# Returns : number of deleted posts from the thread
# Function: Deletes the selected thread completely and properly.
###############################################################################
sub delete_thread {
  my($forum,$topic,$rebuild) = @_;

  # Get a count of the posts being removed
  lock_open(POSTS,"$cgi_path/forum$forum/$topic.thd","r") || return 0;
  my @posts = <POSTS>;
  close(POSTS);
  my $count = @posts;

  # Remove the thread files
  unlink "forum$forum/$topic.thd" || return 0;
  unlink "forum$forum/$topic.idx" || return 0;

  # Update the postcounts for the forum
  $final = "";
  lock_open(FORUMS,"$cgi_path/data/forum.lst","rw") || return 0;
  seek(FORUMS,0,0);
  while(my $in = <FORUMS>) {
    $in = strip($in);
    my @parts = split(/\|/,$in);
    if($parts[1] == $forum) {
      $parts[9] -= $count;
      $parts[10]--;
    }
    $in = join('|',@parts);
    $final .= "$in\n";
  }
  truncate(FORUMS,0);
  seek(FORUMS,0,0);
  print FORUMS $final;
  close(FORUMS);

  if($rebuild == 1) { rebuildlist($forum); }

  return $count;
}

###############################################################################
# has_new_private()
#
# Inputs  : $user
# Returns : TRUE or FALSE
# Function: Returns whether or not the user has any new private messages.
###############################################################################
sub has_new_private {
  my $who = $_[0];
  if(!-e "$cgi_path/private/$who.in") { return $FALSE; }
  lock_open(INBOX,"$cgi_path/private/$who.in","r");
  while(my $in = <INBOX>) {
    my ($a,$a,$a,$a,$flags) = split(/\|/,$in);
    if($flags =~ /n/) { $retval = $TRUE; last; }
  }
  close(INBOX);

  if($retval) { return $retval; } else { return $FALSE; }
}

###############################################################################
# lastpost()
#
# Inputs  : $user,$forum,$forumname,$topic,$topicname,$when
# Returns : none
# Function: Updates what thread a user has last posted in.
###############################################################################
sub lastpost {
  my($user,$forum,$forumname,$topic,$topicname,$when) = @_;

  # Make sure we have enough values and if not, get them if possible
  if(!$user || !$forum || !$topic || !$topicname || !$forumname) { return; }
  if(!$when) { $when = time; }
  if(!$users{$user}) { get_member($user); }

  # Set the line
  my $lastpostedline = qq~<font face="Verdana" size="1">Last posted under <a href="$paths{'board_url'}topic.cgi?forum=$forum&topic=$topic">$topicname</a> in <a href="$paths{'board_url'}forum.cgi?forum=$forum">$forumname</a>.</font>~;

  # Set it in the user profile
  $users{$user}{'lastpost'} = $lastpostedline;

  # Save the user account back out to file
  saveuser($user);
}

###############################################################################
# saveuser()
#
# Inputs  : $user
# Returns : none
# Function: Saves a user from the %users hash back to their account file.
###############################################################################
sub saveuser {
  my $who = $_[0];

  $fwho = $who;
  #$fwho =~ s/ /_/ig;
  my $temp = $users{$who};   # temp is now a hash de-reference
  my @keys = keys %$temp;
  lock_open(MEMBER,"$cgi_path/members/$fwho.dat","w");
  truncate(MEMBER,0);   seek(MEMBER,0,0);
  foreach my $key (@keys) {
    my $value = $users{$who}{$key};
    $value =~ s/\n//ig;   $value =~ s/\r//ig;
    if(!$value) { next; }
    print MEMBER "$key=$value\n";
  }
  close(MEMBER);
}

###############################################################################
# helpline()
#
# Inputs  : $helpfilename, $format
# Returns : $string
# Function: Sends a link to the specified helpfile.
###############################################################################
sub helpline {
  my ($helpfilename,$format) = @_;
  if(!$helpfilename) { return ""; }
  if(!$format) {
    $var = qq~
      <font face="Verdana" size="1" style="font-weight: normal">
        (<a href="#" onClick="openScript('$paths{'board_url'}help.cgi?topic=$helpfilename','600','500'); return false;" onMouseOver="mouseit('Get Help'); return true;" onMouseOut="mouseit(''); return true;">help</a>)
      </font>~;
  }

  return $var;
}

###############################################################################
# get_topic_information()
#
# Inputs  : $forum, $topic
# Returns : @topicinfo
# Function: Returns the original topic and all replies for $topic
###############################################################################
sub get_topic_information {
  my($forum,$topic) = @_;
  lock_open(thread,"$cgi_path/forum$forum/$topic.thd",'r');
  my @topicinfo = <thread>;
  close(thread);

  return @topicinfo;
}

###############################################################################
# get_template()
#
# Inputs  : none
# Returns : none
# Function: Sets the global scalars $templateheader and $templatefooter to
#           the header and footer from the template file for the board.
###############################################################################
sub get_template {
  my ($template,$in) = "";
     ($templateheader,$templatefooter) = "";

  # Load the template file itself
  if(!-e "$cgi_path/templates/template.txt") { defaulttemplate(); return; }  # No template?  Return.
  lock_open(FH,"$cgi_path/templates/template.txt","r");
  while(my $in = <FH>) { $template .= $in; }
  close(FH);
  if(!$template) { defaulttemplate(); return; }

  # Get the section in question to a common formatting
  $template =~ s/<\!\-\-\s*BOARD DATA\s*\-\-\>/<\!\-\- BOARD DATA \-\->/ig;
  # A template, but no data section?
  if($template !~ /<\!\-\-\s*BOARD DATA\s*\-\->/i) {
    redirect_die("A fatal error has occured.  The \"<!-- Board Data\" tag could
    not be located in the message board template.  Please inform the administrator
    and ask him to remedy the problem immediately.");
  }


  # Split the template into its specified parts at the DATA marker
  ($templateheader,$templatefooter) = split(/<\!\-\- BOARD DATA \-\-\>/,$template);
}

###############################################################################
# defaulttemplate()
#
# Inputs  : none
# Returns : none
# Function: Sets a default template if none is specified.
##############################################################################
sub defaulttemplate {

  $templateheader = qq~
    <html>
      <head>
        <title>$page_title</title>~;
  $templateheader .=  include_file("$cgi_path/templates/styles.txt");
  $templateheader .= include_file("$cgi_path/templates/scripts.txt");
  $templateheader .= qq~
      </head>
      <body bgcolor="$color_config{'body_bgcolor'}" text="$color_config{'body_textcolor'}" link="$color_config{'link_color'}" alink="$color_config{'active_color'}" vlink="$color_config{'visited_color'}">~;

   $templatefooter = qq~
        <br><br>
        <center><small><font color="#333333">&copy;&nbsp;$config{'copyright'}<br>
          Powered by: <a href="http://scarecrow.sourceforge.net">ScareCrow version $version</a><br>
          &copy; 2001 Jonathan Bravata.  All rights reserved.<br>
        </font></small></center>
      </body>
    </html>~;
}

###############################################################################
# get_postlimit()
#
# Inputs  : minutes between posts
# Returns : word-formatted output
# Function: Determines a coherant sentence for how often a user can post
###############################################################################
sub get_postlimit {
  my $minutes = $_[0];
  if(!$minutes) { return "Always"; }
  if($minutes < 1) { # A restriction of only seconds
    my $seconds = $minutes * 60;
    if($seconds == 1) { return "Every 1 second"; }
    else              { return "Every $seconds seconds"; }
  }
  
  # It's in minutes, form a sentence
  if($minutes == 1) { return "Every 1 minute"; }
  else              { return "Every $minutes minutes"; }
}


###############################################################################
# has_permissions()
#
# Inputs  : permissions flag, user permissions
# Returns : $TRUE or $FALSE
# Function: Determines if a user has permissions for a specified command
###############################################################################
sub has_permissions {
  my($permissions,$userpermissions) = @_;
  # Check if they passed permissions in as binary or a flag
  if($permissions =~ /^\d\d\d\d\d\d\d\d$/) {}
  else { # Inputed as a flag -- look up the values
    # Check if the permission set has ALREADY been loaded
    if($permissions_loaded != $TRUE) {
      load_permissions();           # Load the permission sets
      $permissions_loaded = $TRUE;  # We HAVE loaded the permissions now
    }
    
    # Permissions are loaded -- convert
    $permissions = $PermissionsList{$permissions};
  }
  
    
  # Check if they have permission.  If the match is good, return TRUE, else return FALSE
  return $permissions & $userpermissions == $permissions ? $TRUE : $FALSE; 
}

###############################################################################
# subscribeuser()
#
# Inputs  : $forum, $topic, $user
# Returns : none
# Function: Subscribes a user to a topic
###############################################################################
sub subscribeuser {
  my($forum,$topic,$user) = @_;
  if(-e "$cgi_path/forum$forum/$topic.sub")  { # Existing subscriptions -- check for duplicates
    $mode = "w";
    lock_open(FILE,"$cgi_path/forum$forum/$topic.sub","r");
    while(my $subscriber = <FILE>) {
      $final .= $subscriber;
      $subscriber = strip($subscriber);
      if($subscriber eq $user) { # The user already is subscribed -- terminate function
        return;
      }
    }
    close(FILE);
  }
  $final .= "$user\n";
  
  # They are not yet subscribed -- add them
  lock_open(FILE,"$cgi_path/forum$forum/$topic.sub",$mode);
  print FILE $final;
  close(FILE);
}

###############################################################################
# modifysubscription()
#
# Inputs  : $forum, $topic, $user
# Returns : none
# Function: Subscribes a user to a topic if they are not subscribed, unsubscribes
#           otherwise
###############################################################################
sub modifysubscription {
  my($forum,$topic,$user) = @_;
  my($unsub,$final) = "";
  lock_open(FILE,"$cgi_path/forum$forum/$topic.sub","r");
  while(my $subscriber = <FILE>) {
    $subscriber = strip($subscriber);
    if($subscriber eq $user) { $unsub = "yes"; }
    else { $final .= "$subscriber\n"; }
  }
  close(FILE);
  if(!$unsub) {   # If they weren't UNSUBSCRIBED, SUBSCRIBE them
    $final .= "$user\n";
  }
  
  # Make the changes
  lock_open(FILE,"$cgi_path/forum$forum/$topic.sub","w");
  truncate(FILE,0);    seek(FILE,0,0);
  print FILE $final;
  close(FILE);
}

sub unsubscribeuser {
  my($forum,$topic,$user) = @_;
  lock_open(FILE,"$cgi_path/forum$forum/$topic.sub","r");
  while(my $subscriber = <FILE>) {
    $subscriber = strip($subscriber);
    if($subscriber eq $user) { }
    else { $final .= "$subscriber\n"; }
  }
  close(FILE);
  
  # Make the changes
  lock_open(FILE,"$cgi_path/forum$forum/$topic.sub","w");
  truncate(FILE,0);    seek(FILE,0,0);
  print FILE $final;
  close(FILE);
}


###############################################################################
# censor()
#
# Inputs  : $forum, $message
# Returns : censored message
# Function: Censors a message based on a specific forum's censor rules
###############################################################################
sub censor {
  my($forum,$message) = @_;
  
  if(!-e "$cgi_path/forum$forum/CENSOR.TXT") { return $message; }  # No censoring to be done
  
  # Load the censored words and their replacements and regexp out any words from the message that match
  lock_open(CENSORS,"$cgi_path/forum$forum/CENSOR.TXT","r");
  my @entries = <CENSORS>;
  close(CENSORS);
  
  foreach my $censor (@censors) {
    my($word,$replacement) = split(/\=/,$censor,2);
    if($message =~ /$word/) { $message =~ s/$word/$replacement/ig; }
  }
  
  return $message;
}

###############################################################################
# echelon()
#
# Inputs  : $forum, $message
# Returns : none
# Function: Alerts moderators if certain flagged words are used.
###############################################################################
sub echelon {
  my($forum,$message) = @_;
  
  if(!-e "$cgi_path/forum$forum/ECHELON.TXT") { return $message; }  # No censoring to be done
  
  # Load the censored words and their replacements and regexp out any words from the message that match
  lock_open(CENSORS,"$cgi_path/forum$forum/ECHELON.TXT","r");
  my @entries = <CENSORS>;
  close(CENSORS);
  
  foreach my $censor (@censors) {
    $censor = strip($censor);
    if($message =~ /$word/) {  # File an alert
      # Compose the message
      my $message = qq~
        [p]There was a post that triggered the Echelon filter set for forum $forum for word $censor.
        [p]Direct link to the post: $paths{'board_url'}topic.cgi?forum=$forum&topic=$topic\#$id
        [p]Here is a copy of the text of the message in question, posted by $poster ($ip) at $posttime:
        [p]$message.
        [p]Thank you.
      ~;

      # Check which way the board is configured to send these reports
      if($config{'reportmethod'} eq 'pm')  {  # Send it as a private message
        my @moderators = split(/\,/,$foruminformation{$forum}{'moderators'});
        # Compose the line to add as a message
        $message =~ s/\n\n/\[p\]/ig;
        $message =~ s/\n/\[br\]/ig;
        my $id = time();
        my $line = "$id|Echelon Keyword Triggered|$config{'board_name'}|$id|n|$message\n";
        foreach my $moderator (@moderators) {
          lock_open(PMS,"$cgi_path/private/$moderator\.in","a");
          print PMS $line;
          close(PMS);
        }
      }
      else {   # Send it as an email
        # Format the message
        $message = codeify($message);
        require "mail.lib";    # Mail functions
        my @moderators = split(/\,/,$foruminformation{$forum}{'moderators'});
        foreach my $moderator (@moderators) {
          get_member($moderator);
          send_mail($users{$moderator}{'email'},$subject,$message);
        }
      }
    }
  }
}


###############################################################################
# perms()
#
# Inputs  : $user, $field
# Returns : $TRUE or 0
# Function: Determines is the user has permissions set for a certain field.
#           The 'field' argument may be a numeric position identifier or a
#           string that maps to said value.
###############################################################################
sub perms {
  my($user,$field) = @_;
  if(!$user) { return 0; }  # Don't have a user?  Pfft, default deny.
  get_member($user);
  if(!$users{$user}{'memberstate'}) { return 0; }  # No such member -- default deny.
  
  # If the field is non-numeric, find the numeric mapping
  if(int($field) == 0)  {   # Non-numeric
    if($Mappings{'ON'} != -1) {
      %Mappings = ('ON',        '-1',     # Sets that this has been loaded
                   'POSTNEW',   '1',      # Can post new messages
                   'POSTREP',   '2',      # Can post replies
	  	   'DELEOWN',   '3',      # Can delete your own posts
	  	   'DELEOTH',   '4',      # Can delete other peoples' posts
		   'EDITOWN',   '5',      # Can edit your own posts
		   'EDITOTH',   '6',      # Can edit others' posts
		   'NOFLOOD',   '7',      # Ignores flood control
		   'USEREDT',   '8',      # Can access user editor
		   'ADMINCP',   '9',      # Can access Admin Control Panel
		   'PRIVMSG',   '10',     # Can send private messages
		   'PROFILE',   '11',     # Can edit your own profile
		   'ANNOUNC',   '12',     # Can post board-wide announcements
		   'AUTOLCK',   '13',     # Override autolocked posts and post anyway
		   'ATTACH',    '14',     # Can attach files to their posts
		   'LOCK',      '15',     # Can lock/unlock threads and polls
		   'PRUNE',     '16',     # Can prune forums
		   'STICKY',    '17',     # Can add/remove sticky status for topics
		   'VIEWADM',   '18',     # Can see the administrative data in profiles
		   'UQUEUE',    '19',     # Can view/modify the user queue
		   'QUEUE',     '20',     # Can view/modify the forum post queues
		   'ACTIVE',    '21',     # Can hide from the active users list
		  );
    }
    
    $field = $Mappings{$field};           # Now it IS the proper numeric identifier
  }
  
  # At this point we have the member loaded into memory.
  # Get their EFFECTIVE permissions lists (adjusting for group permissions and denys)
  my $permissions = get_effective_permissions($user);
  
  # See if the permission is set or denied
  if(substr($permissions,$field-1,1) == 1) { return $TRUE;  }   # Has permissions to the selected field
  else                                     { return $FALSE; }   # Does not have permission to the field
  
  # We should never be here--but incase, return $FALSE.
  return $FALSE;
}

###############################################################################
# get_effective_permissions()
#
# Inputs  : $user
# Returns : Effective permissions lists
# Function: Censors a message based on a specific forum's censor rules
###############################################################################
sub get_effective_permissions {
  my($user) = @_;    # Make sure that get_member() has already been called by this point
  
  # Get the user permission list first
  my $userpermissions = $users{$user}{'permissions'};
  my $userdenies      = $users{$user}{'denies'};
  
  if(!$userpermissions) {
    for($x = 1; $x <= $TOTAL_PERMISSIONS; $x++) {
      $userpermissions .= "0";
    }
  }
  if(!$userdenies) {
    for($x = 1; $x <= $TOTAL_PERMISSIONS; $x++) {
      $userdenies .= "0";
    }
  }
    
  # Loop through the list of groups the user belongs to and AND the permissions
  $effectivepermissions = "";     my @denylist = ();
  my @groups = split(/\,/,$users{$user}{'groups'});
  foreach my $group (@groups) {
    my ($grouppermissions,$denies) = get_group_permissions($group);   # Load the group permissions
    if($effectivepermissions) { # We already have some loaded
      $effectivepermissions |= $grouppermissions;    # If either gives permission, set it.
    } else {  # First time through -- set the original permissions
      $effectivepermissions = $grouppermissions;
    }
    # For a DENY: Flag the field with a ZERO, NOT a one.  When the strings are AND'd, a zero will make
    # any permission false.
    push @denylist,$denies;
  }
  
  # Add in the USER permissions
  $effectivepermissions |= $userpermissions;
  # Remove the USER denies
  push @denylist,$userdenies;
  
  # The AND'd permissions are in.  Now subtract fields for denies
  foreach my $deny (@denylist) {
    if(!$deny || int($deny) == 0) { next; }
    # Change 0's to 1's and 1's to 0's -- weird, but ...
    $deny =~ tr/01/10/;
    $effectivepermissions &= $deny;   # AND denies to get rid of deny'd flags
  }
  
  return $effectivepermissions;
}

###############################################################################
# get_group_permissions()
#
# Inputs  : $group
# Returns : Group permissions, denies
# Function: Loads the permissiona and denies for a specified group
###############################################################################
sub get_group_permissions {
  my $group = $_[0];
  
  # Open the group file and load the specified group's permissions
  lock_open(GROUPS,"$cgi_path/data/groups.txt","r");
  while($in = <GROUPS>) {
    my($name,$ipermissions,$idenies) = split(/\|/,$in);
    if($name eq $group) { close(GROUPS); return ($ipermissions,$idenies); }
  }
  
  # No match?  Return blanks.
  close(GROUPS);
  print "!";
  for($x = 1; $x <= $TOTAL_PERMISSIONS; $x++) { $iperm .= "0"; }
  return ($iperm,$iperm);
}

###############################################################################
# offsetcode()
#
# Inputs  : $current_time
# Returns : Select box (with defaults) for the time offset
# Function: Provides an easy input for the time offset
###############################################################################
sub offsetcode {
  my $default = $_[0];
  
  my $code = qq~
    <select name="offset">
    <option value="0">Use Default Server Time</option>
  ~;
  for($x = -23; $x <= 23; $x++) {
    if($x == 0) { next; }
    if($x == $default) { $def = "selected"; }   # Check if this setting is
    else               { $def = "";         }   # the user's default
    
    # Spit out the entry
    if($x > 0) { $val = "+$x"; }
    else       { $val = "$x";  }
    $code .= qq~<option value="$val\h">$val Hours</option>~;
  }
  
  # Finish it up and spew it out
  $code .= "</select>\n";
  
  return $code;
}

###############################################################################
# get_grouplist()
#
# Inputs  : $grouplist
# Returns : Option values (with defaults) for the list of available groups
# Function: Provides an option list of all available groups, flagged as
#           selected as necessary, as set by the comma-separated list of
#           groups passed as the only argument to the function.
###############################################################################
sub get_grouplist {
  # Set the local %groups hash based on what is passed in
  my $grouplist = $_[0];
  my @data = split(/\,/,$grouplist);
  my %groups;
  foreach my $group (@data) {
    $groups{$group} = "yes";
  }
  
  my $string = "";
  for($x = 1; $x<=35; $x++) { $string .= "&nbsp;"; }
  my $list = qq~<option value="">$string~;   # Just a big blank entry to expand the box
  $list   .= qq~<option value="All">All Groups</option>~;
  
  lock_open(GROUPS,"$cgi_path/data/groups.txt","r");
  while(my $in = <GROUPS>) {
    my($name) = split(/\|/,$in);
    if($groups{$name} eq 'yes')  { # They ARE a member of this group
      $list .= qq~<option value="$name" selected>$name</option>~;
    }
    else { # They're not, but list it anyway
      $list .= qq~<option value="$name">$name</option>~;
    }
  }
  close(GROUPS);
  
  return $list;
}

###############################################################################
# permissions_form()
#
# Inputs  : $permissions, $denies
# Returns : $formdata
# Function: Sets up the form for selecting permissions -- also takes a
#           permission string as an argument for defaults.
###############################################################################
# Sets up the form for selecting permissions -- also takes a permission string as an argument for defaults
sub permissions_form {
  my($permissionlist,$denylist) = @_;
  
  if($permissionlist) {
    my @permissions = split(//,$permissionlist);
    my @denies      = split(//,$denylist);
    # Set up the defaults
    for($x = 0; $x <= $#permissions; $x++) {
      if($denies[$x] == 1)  { # This is explicitly DENIED
        $defaults[$x+1][0] = "checked";
        $defaults[$x+1][1] = "";
        $defaults[$x+1][2] = "";
      }
      elsif($permissions[$x] == 1)  {  # This is explicitly ALLOWED
        $defaults[$x+1][0] = "";
        $defaults[$x+1][1] = "checked";
        $defaults[$x+1][2] = "";
      } else { # Neither explicitly allowed nor explicitly denied
        $defaults[$x+1][0] = "";
        $defaults[$x+1][1] = "";
        $defaults[$x+1][2] = "checked";
      }
    }
  } else { # They did not pass any permissions -- set everything to the N/A state
    for($x = 1; $x <= $TOTAL_PERMISSIONS; $x++) {
      $defaults[$x][2] = "checked selected";
    }
  }
  
  my $form = qq~
    <table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="$color_config{'border_bgcolor'}"><tr><td>
      <table width="100%" border="0" cellspacing="1" cellpadding="5">
        <tr bgcolor="$color_config{'nav_top'}">
	  <td align="center" width="12%"><font face="Verdana" size="1"><b>Allowed</b></font></td>
	  <td align="center" width="12%"><font face="Verdana" size="1"><b>Denied</b></font></td>
	  <td align="center" width="12%"><font face="Verdana" size="1"><b>Not Set</b></font></td>
	  <td width="64%"><font face="Verdana" size="1"><b>Permission Description</b></font></td>
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td align="center" width="12%"><input type="radio" name="p1" value="1" $defaults[1][1]></td>
	  <td align="center" width="12%"><input type="radio" name="p1" value="0" $defaults[1][0]></td>
	  <td align="center" width="12%"><input type="radio" name="p1" value="-1" $defaults[1][2]></td>
	  <td width="64%"><font face="Verdana" size="1">Can post new topics</font></td>
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td align="center" width="12%"><input type="radio" name="p2" value="1" $defaults[2][1]></td>
	  <td align="center" width="12%"><input type="radio" name="p2" value="0" $defaults[2][0]></td>
	  <td align="center" width="12%"><input type="radio" name="p2" value="-1" $defaults[2][2]></td>
	  <td width="64%"><font face="Verdana" size="1">Can post replies</font></td>
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td align="center" width="12%"><input type="radio" name="p3" value="1" $defaults[3][1]></td>
	  <td align="center" width="12%"><input type="radio" name="p3" value="0" $defaults[3][0]></td>
	  <td align="center" width="12%"><input type="radio" name="p3" value="-1" $defaults[3][2]></td>
	  <td width="64%"><font face="Verdana" size="1">Can delete their own messages</font></td>
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td align="center" width="12%"><input type="radio" name="p4" value="1" $defaults[4][1]></td>
	  <td align="center" width="12%"><input type="radio" name="p4" value="0" $defaults[4][0]></td>
	  <td align="center" width="12%"><input type="radio" name="p4" value="-1" $defaults[4][2]></td>
	  <td width="64%"><font face="Verdana" size="1">Can delete others' messages</font></td>
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td align="center" width="12%"><input type="radio" name="p5" value="1" $defaults[5][1]></td>
	  <td align="center" width="12%"><input type="radio" name="p5" value="0" $defaults[5][0]></td>
	  <td align="center" width="12%"><input type="radio" name="p5" value="-1" $defaults[5][2]></td>
	  <td width="64%"><font face="Verdana" size="1">Can edit their own messages</font></td>
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td align="center" width="12%"><input type="radio" name="p6" value="1" $defaults[6][1]></td>
	  <td align="center" width="12%"><input type="radio" name="p6" value="0" $defaults[6][0]></td>
	  <td align="center" width="12%"><input type="radio" name="p6" value="-1" $defaults[6][2]></td>
	  <td width="64%"><font face="Verdana" size="1">Can edit others' messages</font></td>
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td align="center" width="12%"><input type="radio" name="p7" value="1" $defaults[7][1]></td>
	  <td align="center" width="12%"><input type="radio" name="p7" value="0" $defaults[7][0]></td>
	  <td align="center" width="12%"><input type="radio" name="p7" value="-1" $defaults[7][2]></td>
	  <td width="64%"><font face="Verdana" size="1">Ignores board-wide flood control</font></td>
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td align="center" width="12%"><input type="radio" name="p8" value="1" $defaults[8][1]></td>
	  <td align="center" width="12%"><input type="radio" name="p8" value="0" $defaults[8][0]></td>
	  <td align="center" width="12%"><input type="radio" name="p8" value="-1" $defaults[8][2]></td>
	  <td width="64%"><font face="Verdana" size="1">Can access the user editor</font></td>
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td align="center" width="12%"><input type="radio" name="p9" value="1" $defaults[9][1]></td>
	  <td align="center" width="12%"><input type="radio" name="p9" value="0" $defaults[9][0]></td>
	  <td align="center" width="12%"><input type="radio" name="p9" value="-1" $defaults[9][2]></td>
	  <td width="64%"><font face="Verdana" size="1">Can access the administrator Control Panel</font></td>
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td align="center" width="12%"><input type="radio" name="p10" value="1" $defaults[10][1]></td>
	  <td align="center" width="12%"><input type="radio" name="p10" value="0" $defaults[10][0]></td>
	  <td align="center" width="12%"><input type="radio" name="p10" value="-1" $defaults[10][2]></td>
	  <td width="64%"><font face="Verdana" size="1">Can send private messages</font></td>
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td align="center" width="12%"><input type="radio" name="p11" value="1" $defaults[11][1]></td>
	  <td align="center" width="12%"><input type="radio" name="p11" value="0" $defaults[11][0]></td>
	  <td align="center" width="12%"><input type="radio" name="p11" value="-1" $defaults[11][2]></td>
	  <td width="64%"><font face="Verdana" size="1">Can edit their own profile</font></td>
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td align="center" width="12%"><input type="radio" name="p12" value="1" $defaults[12][1]></td>
	  <td align="center" width="12%"><input type="radio" name="p12" value="0" $defaults[12][0]></td>
	  <td align="center" width="12%"><input type="radio" name="p12" value="-1" $defaults[12][2]></td>
	  <td width="64%"><font face="Verdana" size="1">Can post board-wide announcements</font></td>
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td align="center" width="12%"><input type="radio" name="p13" value="1" $defaults[13][1]></td>
	  <td align="center" width="12%"><input type="radio" name="p13" value="0" $defaults[13][0]></td>
	  <td align="center" width="12%"><input type="radio" name="p13" value="-1" $defaults[13][2]></td>
	  <td width="64%"><font face="Verdana" size="1">User ignores timed thread lockings.</font></td>
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td align="center" width="12%"><input type="radio" name="p14" value="1" $defaults[14][1]></td>
	  <td align="center" width="12%"><input type="radio" name="p14" value="0" $defaults[14][0]></td>
	  <td align="center" width="12%"><input type="radio" name="p14" value="-1" $defaults[14][2]></td>
	  <td width="64%"><font face="Verdana" size="1">User can attach files to their posts.</font></td>
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td align="center" width="12%"><input type="radio" name="p15" value="1" $defaults[15][1]></td>
	  <td align="center" width="12%"><input type="radio" name="p15" value="0" $defaults[15][0]></td>
	  <td align="center" width="12%"><input type="radio" name="p15" value="-1" $defaults[15][2]></td>
	  <td width="64%"><font face="Verdana" size="1">User can lock/unlock threads and polls.</font></td>
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td align="center" width="12%"><input type="radio" name="p16" value="1" $defaults[16][1]></td>
	  <td align="center" width="12%"><input type="radio" name="p16" value="0" $defaults[16][0]></td>
	  <td align="center" width="12%"><input type="radio" name="p16" value="-1" $defaults[16][2]></td>
	  <td width="64%"><font face="Verdana" size="1">User can prune forums.</font></td>
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td align="center" width="12%"><input type="radio" name="p17" value="1" $defaults[17][1]></td>
	  <td align="center" width="12%"><input type="radio" name="p17" value="0" $defaults[17][0]></td>
	  <td align="center" width="12%"><input type="radio" name="p17" value="-1" $defaults[17][2]></td>
	  <td width="64%"><font face="Verdana" size="1">User can add/remove sticky status on a topic.</font></td>
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td align="center" width="12%"><input type="radio" name="p18" value="1" $defaults[18][1]></td>
	  <td align="center" width="12%"><input type="radio" name="p18" value="0" $defaults[18][0]></td>
	  <td align="center" width="12%"><input type="radio" name="p18" value="-1" $defaults[18][2]></td>
	  <td width="64%"><font face="Verdana" size="1">User can view administrative data in the profiles.</font></td>
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td align="center" width="12%"><input type="radio" name="p19" value="1" $defaults[19][1]></td>
	  <td align="center" width="12%"><input type="radio" name="p19" value="0" $defaults[19][0]></td>
	  <td align="center" width="12%"><input type="radio" name="p19" value="-1" $defaults[19][2]></td>
	  <td width="64%"><font face="Verdana" size="1">User can view/modify the user queue.</font></td>
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td align="center" width="12%"><input type="radio" name="p20" value="1" $defaults[20][1]></td>
	  <td align="center" width="12%"><input type="radio" name="p20" value="0" $defaults[20][0]></td>
	  <td align="center" width="12%"><input type="radio" name="p20" value="-1" $defaults[20][2]></td>
	  <td width="64%"><font face="Verdana" size="1">User can view/modify forum posts queues.</font></td>
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td align="center" width="12%"><input type="radio" name="p21" value="1" $defaults[21][1]></td>
	  <td align="center" width="12%"><input type="radio" name="p21" value="0" $defaults[21][0]></td>
	  <td align="center" width="12%"><input type="radio" name="p21" value="-1" $defaults[21][2]></td>
	  <td width="64%"><font face="Verdana" size="1">User can hide from the active user list.</font></td>
	</tr>
      </table>
    </td></tr></table>~;
    
    
  return $form;
}

###############################################################################
# noaccess()
#
# Inputs  : $type, @suplementary_data
# Returns : none
# Function: Displays a redirect_die with a message about the activity attempted
#           and why it was failed -- for lack of permissions.
###############################################################################
sub noaccess {
  my ($type,@supplementary) = @_;
  
  if($type eq 'read') {
    $subject = qq~You Do Not Have Access To Read This Forum~;
    $message = qq~
      Your group affiliations do not permit you to view this forum.  If you believe you are entitled to
      access this forum, and are receiving this page in error, please be sure to contact the message
      board <a href="mailto:$config{'email_in_addr'}">administrator</a> as soon as possible.  Specify your
      username and the forum you were trying to access to expediate the process.
    ~;
  }
  elsif($type eq 'postnew') {
    $subject = qq~You Do Not Have Access To Post A New Thread In This Forum~;
    $message = qq~
      Your user/group permissions do not permit you to post a new thread in this forum.  If you believe you
      are in fact entitled to post, and are receiving this page in error, please be sure to contact the
      message board <a href="mailto:$config{'email_in_addr'}">administrator</a> as soon as possible.  Specify your
      username to expediate the process.
    ~;
  }
  elsif($type eq 'postreply') {
    $subject = qq~You Do Not Have Access To Post A Reply In This Forum~;
    $message = qq~
      Your user/group permissions do not permit you to post a reply in this forum.  If you believe you
      are in fact entitled to post, and are receiving this page in error, please be sure to contact the
      message board <a href="mailto:$config{'email_in_addr'}">administrator</a> as soon as possible.  Specify your
      username to expediate the process.
    ~;
  }
  elsif($type eq 'profile') {
    $subject = qq~You Do Not Have Access To Edit Your Profile~;
    $message = qq~
      Your user/group permissions do not permit you to edit your own profile.  If you would like to refute
      this setting, or you believe that you are receiving this page in error, please be sure to contact the
      message board <a href="mailto:$config{'email_in_addr'}">administrator</a> as soon as possible.  Specify your
      username in the email to expediate the process.
    ~;
  }
  elsif($type eq 'private') {
    $subject = qq~You Do Not Have Access To Send A Private Message~;
    $message = qq~
      Your user/group permissions do not permit you to send a private message.  If you would like to refute
      this setting, or you believe that you are receiving this page in error, please be sure to contact the
      message board <a href="mailto:$config{'email_in_addr'}">administrator</a> as soon as possible.  Specify your
      username in the email to expediate the process.
    ~;
  }
  elsif($type eq 'deleteown') {
    $subject = qq~You Do Not Have Access To Delete Your Own Posts~;
    $message = qq~
      Your user/group permissions do not permit you to delete your own posts..  If you would like to refute
      this setting, or you believe that you are receiving this page in error, please be sure to contact the
      message board <a href="mailto:$config{'email_in_addr'}">administrator</a> as soon as possible.  Specify your
      username in the email to expediate the process.
    ~;
  }
  elsif($type eq 'deleteother') {
    $subject = qq~You Do Not Have Access To Delete Another User's Post~;
    $message = qq~
      Your user/group permissions do not permit you to delete another user's post.  If you would like to refute
      this setting, or you believe that you are receiving this page in error, please be sure to contact the
      message board <a href="mailto:$config{'email_in_addr'}">administrator</a> as soon as possible.  Specify your
      username in the email to expediate the process.
    ~;
  }
  elsif($type eq 'editown') {
    $subject = qq~You Do Not Have Access To Edit Your Own Posts~;
    $message = qq~
      Your user/group permissions do not permit you to edit your own posts.  If you would like to refute
      this setting, or you believe that you are receiving this page in error, please be sure to contact the
      message board <a href="mailto:$config{'email_in_addr'}">administrator</a> as soon as possible.  Specify your
      username in the email to expediate the process.
    ~;
  }
  elsif($type eq 'editother') {
    $subject = qq~You Do Not Have Access To Edit Another User's Post~;
    $message = qq~
      Your user/group permissions do not permit you to edit another user's post.  If you would like to refute
      this setting, or you believe that you are receiving this page in error, please be sure to contact the
      message board <a href="mailto:$config{'email_in_addr'}">administrator</a> as soon as possible.  Specify your
      username in the email to expediate the process.
    ~;
  }
  elsif($type eq 'useredit') {
    $subject = qq~You Do Not Have Access To The User Editor~;
    $message = qq~
      Your user/group permissions do not permit you to the user editor.  If you would like to refute
      this setting, or you believe that you are receiving this page in error, please be sure to contact the
      message board <a href="mailto:$config{'email_in_addr'}">administrator</a> as soon as possible.  Specify your
      username in the email to expediate the process.
    ~;
  }
  elsif($type eq 'cp') {
    $subject = qq~You Do Not Have Access To The Administrator Control Panel~;
    $message = qq~
      Your user/group permissions do not permit you to the administrator control panel.  If you would like to refute
      this setting, or you believe that you are receiving this page in error, please be sure to contact the
      message board <a href="mailto:$config{'email_in_addr'}">administrator</a> as soon as possible.  Specify your
      username in the email to expediate the process.
    ~;
  }
  elsif($type eq 'announce') {
    $subject = qq~You Do Not Have Access To Make An Announcement~;
    $message = qq~
      Your user/group permissions do not permit you to make an announcement.  If you would like to refute
      this setting, or you believe that you are receiving this page in error, please be sure to contact the
      message board <a href="mailto:$config{'email_in_addr'}">administrator</a> as soon as possible.  Specify your
      username in the email to expediate the process.
    ~;
  }
  elsif($type eq 'uploadfile') {
    $subject = qq~You Do Not Have Access To Attach A File~;
    $message = qq~
      Your user/group permissions do not permit you to attach a file to your message.  If you would like
      to refute this setting, or you believe that you are receiving this page in error, please be sure to
      contact the message board <a href="mailto:$config{'email_in_addr'}">administrator</a> as soon as possible.
      Specify your username to expediate the process.
    ~;
  }
  elsif($type eq 'lock') {
    $subject = qq~You Do Not Have Access To Lock Threads/Polls~;
    $message = qq~
      Your user/group permissions do not permit you to lock threads or polls.  If you would like to
      refute this setting, or you believe you are receiving this page in error, please be sure to contact
      the message board <a href="mailto:$config{'email_in_addr'}">administrator</a> as soon as possible.
      Specify your username to expediate the process.
    ~;
  }
  elsif($type eq 'prune') {
    $subject = qq~You Do Not Have Access To Prune A Forum~;
    $message = qq~
      Your user/group permissions do not permit you to prune forums.  If you would like to refute this
      setting, or you believe you are receiving this page in error, please be sure to contact
      the message board <a href="mailto:$config{'email_in_addr'}">administrator</a> as soon as possible.
      Specify your username to expediate the process.
    ~;
  }
  elsif($type eq 'sticky') {
    $subject = qq~You Do Not Have Access To Modify Sticky Status~;
    $message = qq~
      Your user/group permissions do not permit you to modify sticky topic status.  If you would like to
      refute this setting, or you believe you are receiving this page in error, please be sure to contact
      the message board <a href="mailto:$config{'email_in_addr'}">administrator</a> as soon as possible.
      Specify your username to expediate the process.
    ~;
  }
  elsif($type eq 'userqueue') {
    $subject = qq~You Do Not Have Access To View/Modify User Queues~;
    $message = qq~
      Your user/group permissions do not permit you to view/modify user queues.  If you would like to
      refute this setting, or you believe you are receiving this page in error, please be sure to contact
      the message board <a href="mailto:$config{'email_in_addr'}">administrator</a> as soon as possible.
      Specify your username to expediate the process.
    ~;
  }
  elsif($type eq 'queue') {
    $subject = qq~You Do Not Have Access To View/Modify Forum Post Queues~;
    $message = qq~
      Your user/group permissions do not permit you to view/modify forum post queues.  If you would like to
      refute this setting, or you believe you are receiving this page in error, please be sure to contact
      the message board <a href="mailto:$config{'email_in_addr'}">administrator</a> as soon as possible.
      Specify your username to expediate the process.
    ~;
  }
  elsif($type eq 'activehide') {
    $subject = qq~You Do Not Have Access To Hide From The Active User List~;
    $message = qq~
      Your user/group permissions do not permit you to remove yourself from the active users list.  If you
      would like to refute this setting, or you believe you are receiving this page in error, please be sure
      to contact the message board <a href="mailto:$config{'email_in_addr'}">administrator</a> as soon
      as possible.  Specify your username to expediate the process.
    ~;
  }
  else {  # Generic Response
    $subject = qq~You Do Not Have Access To This Feature~;
    $message = qq~
      Your user/group permissions do not permit you to complete this action.  If you would like to refute
      this setting, or you beleive you are receiving this page in error, please be sure to contact the
      message board <a href="mailto:$config{'email_in_addr'}">administrator</a> as soon as possible.  Specify your
      username and the action which you have been denied to expediate the process.
    ~;
  }
  
  # Append the return options
  $message .= qq~
    <ul>
      <li><a href="$ENV{'HTTP_REFERER'}">Go back</a></li>
      <li><a href="$paths{'board_url'}scarecrow.cgi">Go to the main forum listing</a></li>
    </ul>
  ~;
  
  # Send out the notification_box with notification.
  notice_box($subject,$message);
  
  # Quit the program -- they can't proceed
  exit;
}

# Compile the permission and deny list from the form data
sub form_permissions {
  my($permissions,$denies) = "";
  
  # Loop through from first permission to $TOTAL_PERMISSIONS
  for($x = 1; $x <= $TOTAL_PERMISSIONS; $x++) {
    # Get the setting
    my $setting = $Pairs{"p$x"};
    
    # Check what the setting is and set everything accordingly
    if($setting == 0) {  # Explicit deny
      $denies .= "1";
      $permissions .= "0";
    }
    elsif($setting == 1) {  # Explicit allow
      $denies .= "0";
      $permissions .= "1";
    } else  {  # Neither explicitly denied nor explicitly allowed
      $denies .= "0";
      $permissions .= "0";
    }
  }
  
  # Return the variables
  return($permissions,$denies);
}

sub get_randomsong {
  if($randomsong != 1) { 
    lock_open(QUOTES,"$cgi_path/data/songs.txt","r");
    @quotes = <QUOTES>;
    close(QUOTES);
  }
  
  # Pick one randomly
  my $quote = $quotes[int(rand $#quotes)];
  $quote = strip($quote);  $quote .= "[br]";
  $randomsong = 1;
  
  return $quote;
}

sub get_randomquote {
  if($randomquote != 1) {
    lock_open(QUOTES,"$cgi_path/data/quotes.txt","r");
    @quotes = <QUOTES>;
    close(QUOTES);
  }
  
  # Pick one randomly
  my $quote = $quotes[int(rand $#quotes)];
  $quote = strip($quote);  $quote .= "[br]";
  $randomquote = 1;
  
  return $quote;
}

sub hasgroup {
  my($user,$poss) = @_;
  my @possibilities = split(/\,/,$poss);
  
  if(!$user) {
    $user = "Guest";
    $usergroups{$user}{'Guests'} = 'yes';
  } else {
    get_member($user);   # Load the member information
  }
  
  foreach my $chance (@possibilities) {
    if($chance eq 'All') { return $TRUE; }
    if($usergroups{$user}{$chance} eq 'yes') { return $TRUE; }
  }
  
  print "<b>Allowed groups:</b> $poss<br>\n";
  return $FALSE;   # They never broke out, so they don't have access.
}

sub give_post {
  my($who,$number) = @_;

  my $rv = get_member($who);
  if($rv == $FALSE) { return $FALSE; }

  # Increment/decrement posts
  $users{$who}{'posts'} += $number;
  my $posts = $users{$who}{'posts'};
  
  # Set last post time
  $users{$who}{'lastposttime'} = time;

  # Load post levels
  load_post_levels();

  # Check if they are at a new post level
  # First, sort the array from smallest to largest
  @postlevels = levelsort(@postlevels);
  
  # Loop through each element and see if they hit the requirement
  for($x = $#postlevels; $x >= 0; $x--) {
    my $inf = $postlevels[$x];
    $inf = strip($inf);
    my($requirement,$class,$dots) = split(/=/,$inf);
    if($posts >= $requirement) {
      $users{$who}{'memberlevel'} = $class;
      $users{$who}{'dots'}        = $dots;
      last;
    }
  }

    #for($x = 2; $x <= 6; $x++) {
  #  if($posts >= $postreq{$x} && $posts <= $postreq{$x+1}) {
  #    $users{$who}{'memberlevel'} = $classes{$x};
  #    if($users{$who}{'memberstate'} ne 'admin') {
  #        if($x == 2)     { $users{$who}{'dots'} = "leveltwo.gif";   }
  #        elsif($x == 3)  { $users{$who}{'dots'} = "levelthree.gif"; }
  #        elsif($x == 4)  { $users{$who}{'dots'} = "levelfour.gif";  }
  #        elsif($x == 5)  { $users{$who}{'dots'} = "levelfive.gif";  }
  #        elsif($x == 6)  { $users{$who}{'dots'} = "master.gif";     }
  #    }
  #  }
  #  elsif($posts < $postreq{$x}) { last; }
  #}

  # Re-write the data
  saveuser($who);
}

sub cleanit {
  my $message = $_[0];
  $message =~ s/<!--(.|\n)*-->//g;
  $message =~ s/<script>/\&lt;script\&gt;/ig;
  $message =~ s/\&/\&amp;/g;
  $message =~ s/"/\&quot;/g;
  $message =~ s/  / \&nbsp;/g;
  $message =~ s/\|/\&#0124;/g;
  $message =~ s/\t//g;
  $message =~ s/\r//g;
  $message =~ s/  / /g;
  $message =~ s/\n\n/[p]/g;
  $message =~ s/\n/[br]/g;
  return $message;
}

sub polldisplay {
  my($forum,$topic) = @_;
  my $caller = $user;      # The person requesting the poll
  
  # Verify arguments.
  if(!-d "$cgi_path/forum$forum" || !-e "$cgi_path/forum$forum/$topic.poll") { return ""; }
  
  # Load the poll data
  lock_open(POLL,"$cgi_path/forum$forum/$topic.poll","r");
  my $pollstatus = <POLL>;     $pollstatus = strip($pollstatus);
  my $question   = <POLL>;     $question   = strip($question);
  my $optionlst  = <POLL>;     $optionlst  = strip($optionlst);
  my $votelst    = <POLL>;     $votelst    = strip($votelst);
  my $voterlst   = <POLL>;     $voterlst   = strip($voterlst);
  close(POLL);
  
  # Check if this user has voted yet
  if($user && $user ne 'Guest') {
    my @voters = split(/\|/,$voterlst);
    foreach my $voter (@voters) {  if($user eq $voter) { $novote = "You Have Already Voted On This Poll";  last; }  }
  } else { $novote = "Guests Cannot Vote"; }
  # Check if the poll is locked
  if($pollstatus eq 'locked') { $novote = "This Poll Has Been Locked By The Administration"; }
  
  # Determine the total number of votes
  my @votes = split(/\|/,$votelst);
  foreach my $a (@votes) { $totalvotes += $a; }
  my @options = split(/\|/,$optionlst);
  
  # Begin the return value
  my $retval = qq~
    <table width="$config{'table_width'}" border="0" cellspacing="0" cellpadding="0" bgcolor="$color_config{'border_color'}" align="center"><tr><td>
      <table width="100%" cellspacing="1" cellpadding="5" border="0">
        <tr bgcolor="$color_config{'poll_top'}"><td colspan="3"><font face="Verdana" size="2"><b>Poll Question: $question</b>&nbsp;&nbsp;&nbsp;($totalvotes votes)</font></td></tr>
  ~;
  $retval .= qq~<form action="$paths{'board_url'}poll.cgi" method="post">~;
  
  # Determine the lock/unlock lines
  my $admin = "";
  if(perms($caller,'LOCK') == $TRUE) {
    if($pollstatus eq 'locked') {
      $admin = qq~<font face="Verdana" size="2"><a href="$paths{'board_url'}poll.cgi?forum=$forum&pollid=$topic&action=modify&type=Unlock">Unlock Poll</a></font>~;
    } else {
      $admin = qq~<font face="Verdana" size="2"><a href="$paths{'board_url'}poll.cgi?forum=$forum&pollid=$topic&action=modify&type=Lock">Lock Poll</a></font>~;
    }
  }
  # Determine the delete line
  if(perms($caller,'DELEOTH') == $TRUE) {
    if($admin) { $admin .= " | "; }
    $admin .= qq~<font face="Verdana" size="2"><a href="$paths{'board_url'}poll.cgi?forum=$forum&pollid=$topic&action=modify&type=Delete">Delete Poll</a></font>~;
  }
  
  # Figure out the footer
  if(!$novote) {
    $footer  = qq~<tr bgcolor="$color_config{'body_bgcolor'}"><td colspan="3"><center><input type="submit" name="vote" value="Vote!">&nbsp;&nbsp;&nbsp;$admin</center></td></tr>~;
  } else {
    $footer  = qq~<tr bgcolor="$color_config{'body_bgcolor'}"><td colspan="3"><center><font face="Verdana" size="2"><b>$novote</b>&nbsp;&nbsp;&nbsp;$admin</font></center></td></tr>~;
  }
  
  # Insert the response rows
  my $count = 0;
  foreach my $option (@options) {
    $percent = 0;
    # Determine the percentage of total that this one has
    if($totalvotes > 0) { 
      $percent = round($votes[$count]/$totalvotes * 100,1);
    } else { $percent = 0; }
    $retval .= qq~<tr bgcolor="$color_config{'body_bgcolor'}">~;
    # Check if they can vote or not
    if(!$novote) {  # Yes, they can
      $retval .= qq~<td width="15%" align="center"><input type="radio" name="voteid" value="$count"></td>~;
    } else {
      $retval .= qq~<td width="15%">&nbsp;</td>~;
    }
    
    # Attach the rest
    $retval .= qq~    
	    <td><font face="Verdana" size="2">$options[$count]</font></td>
	    <td>
	      <img src="$paths{'noncgi_url'}/images/votebar.gif" width="$percent" height="15"> &nbsp;&nbsp; <font face="Verdana" size="1">$percent\% ($votes[$count] votes)</font>
	    </td>
	  </tr>
    ~;
    $count++;
  }
  
  # Finish the table off
  $retval .= $footer;
  $retval .= qq~
      <input type="hidden" name="pollid" value="$topic">
      <input type="hidden" name="forum" value="$forum">
      <input type="hidden" name="action" value="vote">
      </form>
      </table>
    </td></tr></table>
  ~;
  
  return $retval;   # Return the form   
}

sub levelsort {
  my @data = @_;
  my @idx;
  # Compile the index array
  foreach $entry (@data) {
    my($postreq) = split(/=/,$entry);
    push @idx, $postreq;
    if($postreq == 0) { $ok = "yes"; }
  }
  if($ok ne 'yes') {  # Assign a default account if there is none
    push @data,"0=Newbie=levelone.gif";
    push @idx,"0";
  }  
  # Sort it
  @data = @data[ sort { $idx[$a] <=> $idx[$b] } 0 .. $#idx ];
  # Return
  return @data;
}


1;

