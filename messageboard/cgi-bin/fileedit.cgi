#!/usr/bin/perl

# This script will provide those users with access, the main form for the
# Administator Control Panel.
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

my $action = $Pairs{'action'};

if($action eq 'addrules')      { add_form('Rule');     }
elsif($action eq 'editrules')  { edit_rules_form();    }
elsif($action eq 'addfaqs')    { add_form('Faq');      }
elsif($action eq 'editfaqs')   { edit_faqs_form();     }
elsif($action eq 'deleterule') { delete_form('Rule');  }
elsif($action eq 'ruledelete') { deleteit('rules');    }
elsif($action eq 'deletefaq')  { delete_form('Faq');   }
elsif($action eq 'faqdelete')  { deleteit('faqs');     }
elsif($action eq 'editrule')   { edit_rule();          }
elsif($action eq 'editfaq')    { edit_faq();           }
elsif($action eq 'addrule')    { addit('Rule');        }
elsif($action eq 'addfaq')     { addit('Faq');         }
elsif($action eq 'saverule')   { saveit('rules');      }
elsif($action eq 'savefaq')    { saveit('faqs');       }


sub add_form {  
  # Determine the type of addition and generate that part of the form
  if($_[0] eq 'Rule') {
    $action = "addrule";   # Set the action to output
    $conditional = qq~
      <tr bgcolor="$color_config{'body_bgcolor'}">
        <td><font face="Verdana" size="2"><b>Rule To Add</b></font></td>
	<td><input type="text" name="rule"></td>
      </tr>
    ~;
  } else {
    $action = "addfaq";    # Set the action to output
    $conditional = qq~
      <tr bgcolor="$color_config{'body_bgcolor'}">
        <td><font face="Verdana" size="2"><b>Question</b></font></td>
	<td><input type="text" name="question"></td>
      </tr>
      <tr bgcolor="$color_config{'body_bgcolor'}">
        <td><font face="Verdana" size="2"><b>Answer</b></font></td>
	<td><textarea name="answer" cols="30" rows="15"></textarea></td>
      </tr>
    ~;
  }
     
  # Print the form
  print <<end;
    <table width="98%" align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="$color_config{'border_color'}"><tr><td>
      <form action="$paths{'board_url'}fileedit.cgi" method="post">
      <table width="100%" border="0" cellspacing="1" cellpadding="5">
        <tr bgcolor="$color_config{'nav_top'}"><td colspan="2"><font face="Verdana" size="2"><b>&#187; Add a $_[0]</b></font></td></tr>
	$conditional
	<tr bgcolor="$color_config{'nav_top'}"><td colspan="2" align="center"><input type="submit" value="Submit $_[0]"></td></tr>
      </table>
      <input type="hidden" name="action" value="$action">
    </td></tr></table>
end
}

sub addit {
  # Determine the type and write the data appropriately
  if($_[0] eq 'Rule') {
    my $rule = $Pairs{'rule'};
    lock_open(FILE,"$cgi_path/data/rules.txt","a");
    seek(FILE,0,2);
    print FILE "$rule\n";
    close(FILE);
  }
  else {
    my $question = $Pairs{'question'};
    my $answer   = $Pairs{'answer'};
    $answer =~ s/\n\n/<p>/ig;   $answer =~ s/\n/<br>/ig;
    lock_open(FILE,"$cgi_path/data/faqs.txt","a");
    seek(FILE,0,2);
    print FILE "$question|$answer\n";
    close(FILE);
  }
  
  # Display the progress
  print "<b>Your $_[0] has been successfully recorded.</b><br>\n";
}

sub delete_form {  
  # Determine the type of removeal
  if($_[0] eq 'Rule') { $action = "ruledelete"; }
  else                { $action = "faqdelete"; }
     
  # Print the form
  print <<end;
    <table width="98%" align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="$color_config{'border_color'}"><tr><td>
      <form action="$paths{'board_url'}fileedit.cgi" method="post">
      <table width="100%" border="0" cellspacing="1" cellpadding="5">
        <tr bgcolor="$color_config{'nav_top'}"><td colspan="2"><font face="Verdana" size="2"><b>&#187; Delete a $_[0]</b></font></td></tr>
	<tr bgcolor="$color_config{'body_bgcolor'}"><td colspan="2"><font face="Verdana" size="2">
	  <b>Warning!</b>  You are about to delete a $_[0].  If you submit this form, the $_[0] will be
	  removed.  This operation is <i>irreversible</i>.  Click the button below only if you are sure
	  that you wish to proceed!
	</font></td></tr>
	<tr bgcolor="$color_config{'nav_top'}"><td colspan="2" align="center"><input type="submit" value="Delete $_[0] $Pairs{'id'}"></td></tr>
      </table>
      <input type="hidden" name="action" value="$action">
      <input type="hidden" name="entryid" value="$Pairs{'entryid'}">
    </td></tr></table>
end
}


sub deleteit {
  my $id = $Pairs{'entryid'};  # The ID of the entry to remove
  my $count = 0;
  lock_open(FILE,"$cgi_path/data/$_[0].txt","rw");
  seek(FILE,0,0);
  while($in = <FILE>) {
    $count++;
    if($count == $id) { $done = 1; }
    else { $final .= $in; }
  }
  truncate(FILE,0);     seek(FILE,0,0);
  print FILE $final;
  close(FILE);
  
  # Update the user on the progress
  if($done == 1) {
    print "<b>The selected entry has been successfully removed.</b><br>\n";
  } else {
    print "<b>Error!</b>  Entry $id cannot be found.<br>\n";
  }
  
}

sub edit_rules_form {
  # Gather up the data
  my $count = 0;   my $conditional = "";
  lock_open(FILE,"$cgi_path/data/rules.txt","r");
  while($in = <FILE>) {
    $in = strip($in);
    $count++;
    $conditional .= qq~
      <tr bgcolor="$color_config{'body_bgcolor'}">
        <td><font face="Verdana" size="1">$in</td>
	<td>
	  <a href="$paths{'board_url'}fileedit.cgi?action=editrule&entryid=$count">Edit</a> | 
	  <a href="$paths{'board_url'}fileedit.cgi?action=deleterule&entryid=$count">Delete</a>
	</td>
      </tr>
    ~;
  }
  close(FILE);
  
  # Display the form
  print <<end;
    <table width="98%" align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="$color_config{'border_color'}"><tr><td>
      <table width="100%" border="0" cellspacing="1" cellpadding="5">
        <tr bgcolor="$color_config{'nav_top'}"><td colspan="2"><font face="Verdana" size="2"><b>&#187; Edit/Delete a Rule</b></font></td></tr>
	$conditional
      </table>
    </td></tr></table>
end

}

sub edit_faqs_form {
  # Gather up the data
  my $count = 0;   my $conditional = "";
  lock_open(FILE,"$cgi_path/data/faqs.txt","r");
  while($in = <FILE>) {
    $in = strip($in);
    $count++;
    my($question,$answer) = split(/\|/,$in);
    $conditional .= qq~
      <tr bgcolor="$color_config{'body_bgcolor'}">
        <td><font face="Verdana" size="1">$question</td>
	<td><font face="Verdana" size="1">$answer</td>
	<td>
	  <a href="$paths{'board_url'}fileedit.cgi?action=editfaq&entryid=$count">Edit</a> |
	  <a href="$paths{'board_url'}fileedit.cgi?action=deletefaq&entryid=$count">Delete</a>
	</td>
      </tr>
    ~;
  }
  close(FILE);
  
  # Display the form
  print <<end;
    <table width="98%" align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="$color_config{'border_color'}"><tr><td>
      <table width="100%" border="0" cellspacing="1" cellpadding="5">
        <tr bgcolor="$color_config{'nav_top'}"><td colspan="3"><font face="Verdana" size="2"><b>&#187; Edit/Delete a FAQ</b></font></td></tr>
	$conditional
      </table>
    </td></tr></table>
end

}

sub edit_rule {
  # Gather the proper entry
  my $id = $Pairs{'entryid'};   my $count = 0;
  lock_open(FILE,"$cgi_path/data/rules.txt","r");
  while($in = <FILE>) {
    $count++;
    if($count == $id) {
      $in = strip($in);
      $in =~ s/\"/\&quote\;/ig;
      $conditional = qq~
        <tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Rule</b></td>
	  <td><input type="text" name="rule" value="$in"></td>
	</tr>
      ~;
    }
  }
  close(FILE);
  
  # Display the form
  print <<end;
    <table width="98%" align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="$color_config{'border_color'}"><tr><td>
      <form action="$paths{'board_url'}fileedit.cgi" method="post">
      <table width="100%" border="0" cellspacing="1" cellpadding="5">
        <tr bgcolor="$color_config{'nav_top'}"><td colspan="2"><font face="Verdana" size="2"><b>&#187; Edit a Rule</b></font></td></tr>
	$conditional
	<tr bgcolor="$color_config{'nav_top'}"><td colspan="2" align="center"><input type="submit" name="submit" value="Edit Rule"></td></tr>
      </table>
      <input type="hidden" name="action" value="saverule">
      <input type="hidden" name="id" value="$id">
    </td></tr></table>
end

}

sub edit_faq {
  # Gather the proper entry
  my $id = $Pairs{'entryid'};   my $count = 0;
  lock_open(FILE,"$cgi_path/data/faqs.txt","r");
  while($in = <FILE>) {
    $count++;
    if($count == $id) {
      $in = strip($in);
      my($question,$answer) = split(/\|/,$in);
      $question =~ s/\"/\&quote\;/ig;
      $conditional = qq~
        <tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Question</b></td>
	  <td><input type="text" name="question" value="$question"></td>
	</tr>
        <tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Answer</b></td>
	  <td><textarea name="answer" cols="30" rows="15">$answer</textarea></td>
	</tr>
      ~;
    }
  }
  close(FILE);
  
  # Display the form
  print <<end;
    <table width="98%" align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="$color_config{'border_color'}"><tr><td>
      <form action="$paths{'board_url'}fileedit.cgi" method="post">
      <table width="100%" border="0" cellspacing="1" cellpadding="5">
        <tr bgcolor="$color_config{'nav_top'}"><td colspan="2"><font face="Verdana" size="2"><b>&#187; Edit a FAQ</b></font></td></tr>
	$conditional
	<tr bgcolor="$color_config{'nav_top'}"><td colspan="2" align="center"><input type="submit" name="submit" value="Edit FAQ"></td></tr>
      </table>
      <input type="hidden" name="action" value="savefaq">
      <input type="hidden" name="id" value="$id">
    </td></tr></table>
end

}

sub saveit {
  # Compile the replacement line
  if($_[0] eq 'rules') { $line = "$Pairs{'rule'}\n"; }
  else                 {
    my $answer = $Pairs{'answer'};   my $question = $Pairs{'question'};
    $answer =~ s/\n\n/<p>/ig;     $answer =~ s/\n/<br>/ig;
    $line = "$question|$answer\n";
  }
  # Get the id and replace the entry
  my $count = 0;   my $id = $Pairs{'id'};   my $final = "";
  lock_open(FILE,"$cgi_path/data/$_[0].txt","rw");
  seek(FILE,0,0);
  while(my $in = <FILE>) {
    $count++;
    if($count == $id) { $done = 1;  $in = $line; }
    $final .= $in;
  }
  truncate(FILE,0);     seek(FILE,0,0);
  print FILE $final;
  close(FILE);
  
  # Update the user on the progress
  if($done == 1) { # Success
    print "<b>The selected entry has successfully been edited.</b><br>\n";
  } else {
    print "<b>Error!</b>  The selected entry could not be found in the $_[0] database.</b><br>\n";
  }
}

