#!/usr/bin/perl

# This script will allow the viewing of the active user database.  The IP for
# guest users is only show to those with Administrator access.
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

# Output the content header
content();

# Start the page
page_header("$config{'board_name'} > Search");
board_header();
user_line();
position_tracker("","Search the Board");

$action = $Pairs{'action'};
if(!$action)               { searchwords();  }
elsif($action eq 'step')   { step();         }
elsif($action eq 'finish') { finish();       }
else                       { searchwords();  }

page_footer();

sub searchwords {
  $message = qq~
    <form action="$paths{'board_url'}search.cgi" type="post">
    <table width="100%" cellspacing="0" cellpadding="0">
      <tr><td><font face="Verdana" size="2"><b>Search Keywords</b></font></td><td><input type="text" name="keywords"></tr>
      <tr><td><font face="Verdana" size="2"><b>Search Field</b></font></td><td><select name="field"><option value="1">Subject</option><option value="2">Message Body</option><option value="3">Both Subject and Message</option></select></td></tr>
      <tr><td><font face="Verdana" size="2"><b>Boolean Type</b></font></td><td><select name="type"><option value="AND">AND</option><option value="OR">OR</option></select></td></tr>
      <tr><td><font face="Verdana" size="2"><b>Match only posts by user (blank for any)</font></b></td><td><input type="text" name="user"></td></tr>
      <tr><td><font face="Verdana" size="2"><b>Search Forum</b></font></td><td><select name="forum">~;
  $message .= forumjump();
    for($x = 1; ; $x++) {
      if(!-d "$cgi_path/forum$x") { last; }
      if($x == 1) { $complete = "$x"; }
      else       { $complete .= "~~$x"; }
    }
    $message .= qq~
      <option value="$complete" selected>-- All Forums</option></select></td></tr>
    </table>
    <input type="hidden" name="action"  value="step">
    <input type="hidden" name="number"  value="0">
    <input type="hidden" name="matches" value="0">
    <input type="submit" name="Submit" value="Begin Search">
    </form>~;

    notice_box("<b>Define a Search</b>",$message);
}

sub step {
  my $step = $Pairs{'step'};
  my $results = $Pairs{'result'};
  my $matches = $Pairs{'matches'};
  my $stepnumber = $Pairs{'number'};
  my $keyword = $Pairs{'keywords'};
  my $field = $Pairs{'field'};
  my $forum = $Pairs{'forum'};
  my $id    = $Pairs{'id'};
  my $type = $Pairs{'type'};
  my $user = $Pairs{'user'};
  

  $keyword =~ s/ /\+/ig;
  $keyword =~ s/\%20/\+/ig;
  @keywords = split(/\+/,$keyword);

  if($forum == -1) { redirect_die("You did not specify any valid forum to search.  You may not pick a category.","","3","black","Search Error"); }
  # Determine where we are and display the results for this step
  if($stepnumber == 0 || !$stepnumber) {  # Defining keywords and search the first forum
    $id = time();
    $id .= "-" . int(rand 5000);
    my @forums = split(/~~/,$forum);
    @forums = reverse(@forums);
    my $this = pop @forums;    @forums = reverse(@forums);
    $forumline = join('~~',@forums);
    $message = qq~
      <ul>
        <li><b>Defined keywords</b></li>
        <li>Searching forum <b>$this</b></li>
        <li>Matches so far: 0</li>
      </ul>~;

    # Search the specified forum
    $matches = search_forum($this,$id,$field,$type,$user);
    $stepnumber++;
  } else { # Searching the next forum
    if(!$forum) { finish(); exit;  }
    my @forums = split(/~~/,$forum);
    @forums = reverse(@forums);
    my $this = pop @forums;    @forums = reverse(@forums);
    $forumline = join('~~',@forums);
    $message = qq~
      <ul>
        <li><b>Defined keywords</b></li>
        <li>Searching forum <b>$this</b></li>
        <li>Matches so far: $matches</li>
      </ul>~;

    $matches += search_forum($this,$id,$field,$type,$user);
    $resultsline = join('~~',@results);
    $resultsline = "$results~~$resultsline";
    $stepnumber++;
  }

  # Set up the redirect and the hidden fields and such
  $form = "action=step\&matches=$matches\&keywords=$keyword\&number=$stepnumber\&forum=$forumline\&id=$id";

  $content_sent = 1;
  redirect_die($message,"$paths{'board_url'}search.cgi?$form","3","black","<b>Search Progress</b>");
}

sub finish {
  my $id = $Pairs{'id'};

  # Create the table that we'll need
  if($id) {
    lock_open(results,"$cgi_path/search/$id","r");
    @searchresults = <results>;
    close(results);
    # Delete the file
    unlink("search/$id");
  }

  my $matches = @searchresults;
  print <<end;
    <table width="$config{'table_width'}" bgcolor="$color_config{'border_color'}" cellspacing="0" cellpadding="0" border="0" align="center"><tr><td>
      <table width="100%" cellspacing="1" cellpadding="5" border="0">
      <tr bgcolor="$color_config{'nav_top'}"><td colspan="2" align="center"><font face="Verdana" size="3"><b>Your search turned up $matches matches.</b></font></td></tr>
end
  if($matches == 0) {
        print "<tr bgcolor=\"$color_config{'body_bgcolor'}\"><td colspan=\"2\"><b>Your search turned up no results</b></td></tr>\n";
  }
  else {
    $x = 0;
    foreach $result (@searchresults) {
      my($forum,$topic,$id,$title) = split(/\|/,$result);
      $x++;

      print <<end;
        <tr bgcolor="$color_config{'body_bgcolor'}">
          <td align="center" width="5%" bgcolor="$color_config{'body_bgcolor'}">$x</td>
          <td bgcolor="$color_config{'body_bgcolor'}"><font face="Verdana" size="2"><b><a href=\"$paths{'board_url'}topic.cgi?forum=$forum&topic=$topic#$id">$title</a></b></font></td>
        </tr>
end
    }
  }
  print <<end;
      <tr align="center" bgcolor="$color_config{'nav_top'}"><td colspan="2"><b><a href="$paths{'board_url'}/search.cgi">Search Again</a></b></td></tr>
      </table>
    </td></tr></table>
end
  page_footer();
}



sub search_forum {
  my ($forum,$id,$field,$type,$user) = @_;

  if(!$forum || !-d "$cgi_path/forum$forum") { return 0; }
  get_forum_information($forum);
  if($foruminformation{$forum}{'forumstatus'} eq 'private') {
    # Get the username from the cookie
    my $inf = get_cookie("mb-user");
    my($member,$password) = split(/\|/,$inf);
    if($allowed{$member}{$forum} ne 'yes') { return; }  # They do not have access to search this forum
  }

  # Search the forum
  opendir(forum,"$cgi_path/forum$forum");
  my @entries = readdir(forum);
  closedir(forum);
  # Whittle the matches down to only .thd fields
  @entries = grep(/thd/,@entries);

  # Loop through the matches
  foreach $entry (@entries) {
    lock_open(thread,"$cgi_path/forum$forum/$entry","r");
    $thisnumber = $entry;    $thisnumber =~ s/\.thd//ig;
    my @messages = <thread>;
    close(thread);
    my @topicfields = split(/\|/,$messages[0]);
    foreach $a (@messages) {
      my @fields = split(/\|/,$a);
      my $message = $fields[10];
      my $subject = $fields[2];
      my $need = 0;
      # Check if the user matches first
      if($user && $fields[1] !~ m/$user/i)  { # If there is a user, and it doesn't match, go to next message
        next;
      }
      # Define the search area
      if($field == 1) { # Search only the subject
        $searcharea = $subject;
      } elsif($field == 2) { # Search only the message
        $searcharea = $message;
      } else { # Search both
        $searcharea = "$subject~~~~~$message";
      }
      
      foreach $keyword (@keywords) {
        $need++;
        if($searcharea =~ m/$keyword/i) { $got++; }
      }
      # Determine if it matches
      if($type eq 'AND') {
        if($need == $got) { 
	  if(!$gotresults{$thisnumber}) {
	    push @results, "$forum|$thisnumber|$fields[0]|$topicfields[2]"; $total++;
	    $gotresults{$thisnumber} = "yes";
	  }
	}
      } else { # OR search
        if($got > 0) {
	  if(!$gotresults{$thisnumber}) {
  	    push @results,"$forum|$thisnumber|$fields[0]|$topicfields[2]"; $total++;
	    $gotresults{$thisnumber} = "yes";
	  }
	}
      }
      $need = 0;  $got = 0;
    }
  }
  # Write any results
  lock_open(results,"$cgi_path/search/$id","a");
  seek(results,0,2);
  foreach $result (@results) {
    print results "$result\n";
    $forummatches++;
  }
  close(results);

  return $forummatches;
}
