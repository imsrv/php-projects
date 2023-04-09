#!/usr/bin/perl

# This script will allow users to log in and out.
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
# The latest version of this software can be found by pointing one's web
# browser to http://scarecrowmsgbrd.cjb.net
#
# Author: Jonathan Bravata
# Revision: November 2001

require "global.cgi";

# Start the page
$action = $Pairs{'action'};
if($action eq 'sendlogin')      { $type = "Login Attempt";  }
elsif($action eq 'sendlogout')  { $type = "Logout Attempt"; }
else                            { $type = "Login Attempt";  }

if(!$action || $action eq 'login') { login();   }
elsif($action eq 'logout')         { logout();  }
elsif($action eq 'sendlogin')      { slogin();  }
elsif($action eq 'sendlogout')     { slogout(); }
else                               { login();   }
page_footer();

# The form to log in
sub login {
  content();
  this_head();

  my $cookie = get_cookie("mb-user");
  my($user,$pass) = split(/\|/,$cookie);

  $message = qq~
    <table width="$config{'table_width'} cellspacing="0" cellpadding="0" align="center" border="0"><tr><td>
      <form action="$paths{'board_url'}login.cgi" method="post">
      <table width="100%" cellspacing="1" cellpadding="5" border="0">
        <tr><td><font face="Verdana" size="2"><b>Username</b></font></td><td><input type="text" name="user" value="$user"></td></tr>
        <tr><td><font face="Verdana" size="2"><b>Password</b></font></td><td><input type="password" name="pass" value="$pass"></td></tr>
      </table>
      <input type="hidden" name="action" value="sendlogin">
      <input type="submit" name="Submit" value="Login">
      </form>
    </td></tr></table>
~;
  notice_box("Login",$message);
}

sub this_head {
  page_header("$config{'board_name'} > $type");
  board_header();
  user_line();
  position_tracker("","$type");

}

# The form to log out
sub logout {
  content();
  this_head();

  my $cookie = get_cookie("mb-user");
  my($user,$pass) = split(/\|/,$cookie);
  $message = qq~
    <table width="$config{'table_width'} cellspacing="0" cellpadding="0" align="center" border="0"><tr><td>
      <form action="$paths{'board_url'}login.cgi" method="post">
      <table width="100%" cellspacing="1" cellpadding="5" border="0">
        <tr><td><font face="Verdana" size="2"><b>Username</b></font></td><td><input type="text" name="user" value="$user"></td></tr>
        <tr><td><font face="Verdana" size="2"><b>Password</b></font></td><td><input type="password" name="pass" value="$pass"></td></tr>
      </table>
      <input type="hidden" name="action" value="sendlogout">
      <input type="submit" name="Submit" value="Logout">
      </form>
    </td></tr></table>
~;
  notice_box("Logout",$message);
}

# Sends the login cookie and displays the results of the attempt.
sub slogin {
    $user = $Pairs{'user'};
    $pass = $Pairs{'pass'};

    if(check_account($user,$pass) == $FALSE) {
      content();
      this_head();
      redirect_die("Your login attempt failed.  Please
      check your username and password and try again.  If you have not yet
      registered an account, please do so before logging in.  If you have
      forgotten your password, you may have it sent to the email address you
      specified at registration by clicking <a href=\"$paths{'board_url'}misc.cgi?action=lostpassword\">
      here</a> and entering your login details.<br><br><ul><li><a href=\"$paths{'board_url'}login.cgi\">
      Go back</a></li></ul><br>","","3","black","<b>Login Failed</b>");
    }
    $data = "$user|$pass";
    $cookiepath = $query->url(-absolute=>1);
    $cookiepath =~ s/login\.cgi//ig;
    $cookiepath =~ s/global\.cgi//ig;
    
    $exp = time() + (60*86400);

    my $cookie = $query->cookie(-name      => "mb-user",
                                -value     => $data,
                                -expires   => $exp,
                                -domain     =>   $paths{'cookie_domain'},
                                -path      => $cookiepath);
    print $query->header(-cookie=>$cookie);
    $content_sent = 1;
    this_head();

    redirect_die("Your login was successful!<br><br><ul><li><a href=\"$paths{'board_url'}scarecrow.cgi\">Go
    back</li></ul><br>","$paths{'board_url'}scarecrow.cgi","3","black","<b>Login Successful!</b>");
}

# Attempts to remove all cookies and displays the results of the attempt.
sub slogout {
  $cookiepath = $query->url(-absolute=>1);
  $cookiepath =~ s/login\.cgi//ig;
  $cookiepath =~ s/global\.cgi//ig;
  $now = time() - 900;
  my $a = $query->cookie(-name    =>   "mb-user",
                         -value   =>   "",
                         -path    =>   $cookiepath,
                         -domain  =>   $paths{'cookie_domain'},
                         -expires =>   $now);
  my $b = $query->cookie(-name    =>   "mb-forums",
                         -value   =>   "",
                         -path    =>   $cookiepath,
                         -domain  =>   $paths{'cookie_domain'},
                         -expires =>   $now);
  print $query->header(-cookie=>[$a,$b]);
  $content_sent = 1;
  this_head();

  redirect_die("Your cookies have been removed.<br><br><ul><li><a href=\"$paths{'board_url'}scarecrow.cgi\">Go
  back</a></li></ul><br>","$paths{'board_url'}scarecrow.cgi","3","black","<b>Cookie Removal Successful</b>");

}

