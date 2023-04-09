#!/usr/bin/perl

# This script handles rating posts for the purpose of the tolerance levels.
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

# Output the content headers
content();

# Determine the action
$action = $Pairs{'action'};

# Start the page.  This script will be run entirely in small new windows,
# so there will be no board header or position trackers.
page_header("$config{'board_name'} > Rate a Post");

# The only function of this script is to add the rating, so let's get to it.

# Get the calling user
my $inf = get_cookie("mb-user");
($user,$pass) = split(/\|/,$inf);
if(!$user || !-e "$cgi_path/members/$user.dat") { errorout("You are not logged in or do not have a valid account."); }

# Determine the forum/topic information and if they have already voted
my $forum = $Pairs{'forum'};
my $topic = $Pairs{'topic'};
my $id    = $Pairs{'id'};
my $vote  = $Pairs{'vote'};
if(!-e "forum$forum/$topic.thd") { errorout("The specified thread does not exist."); }
if(alreadyvoted($user,$forum,$topic,$id) == $TRUE) { errorout("You have already voted on this message."); }
$class = $users{$user}{'memberstate'};
if(($vote > 5 || $vote < -1) && ($class ne 'admin' && $class ne 'moderator')) { errorout("You cannot specify a vote greater than five or less than -1."); }

# Locate the specified ID and update the vote
my $final = "";
lock_open(FILE,"forum$forum/$topic.thd","rw");
seek(FILE,0,0);
while(my $in = <FILE>) {
  $in = strip($in);
  @parts = split(/\|/,$in);
  if($parts[0] == $id) {
    $found = 1;  # Found it
    $parts[8]++;              $total = $parts[8];
    $parts[9] += $vote;       $score = $parts[9];
  }
  $in = join('|',@parts);
  $final .= "$in\n";
}                           
if($found != 1) { close(FILE);  errorout("The specified ID was not found within thread \#$topic in forum $forum."); }
truncate(FILE,0);
seek(FILE,0,0);
print FILE $final;    # Write the revisions
close(FILE);

# Set that the user has now voted for the specified topic if they're not an
# administrator.
if($class ne 'admin' && $class ne 'moderator') {
  dbmopen(%votes,"forum$forum/votes",0660);
  if($votes{$user}) {
    $votes{$user} .= ";$topic-$id";
  } else {
    $votes{$user} = "$topic-$id";
  }
  dbmclose(%votes);
}

# Add this to the user's list of votes
if($users{$user}{'votelist'}) { $users{$user}{'votelist'} .= ",$vote"; }
else                          { $users{$user}{'votelist'} = "$vote";   }
saveuser($user);

# Add this to the user who POSTED the message's average
get_member($parts[1]);
$users{$parts[1]}{'totalvotes'}++;
$users{$parts[1]}{'totalscore'} += $vote;
saveuser($user);

# Compute the average
$avg = round($score / $total,2);
$rnd = int($score / $total + .5);
print <<end;

  <!-- Message to the user -->
  <h2>Your Vote Has Been Registered</h2>

  <p>The following data has successfully been written:</p><br>

  <p><b>Forum Number:</b> $forum<br>
  <b>Topic Number:</b> $topic<br>
  <b>Message ID:</b> $id<br>
  <b>Your Score:</b> $vote<br>
  <b>Total Votes:</b> $total<br>
  <b>Total Score:</b> $score<br>
  <b>Average:</b> $avg (rounds to $rnd)</p><br>
end



# Determine if a user has already voted for a topic.  If so, returns $TRUE,
# otherwise $FALSE.
sub alreadyvoted {
  my($user,$forum,$topic,$id) = @_;

  # Get the calling member's info
  get_member($user);
  # If they're an admin, they can do it regardless.
  if($users{$user}{'memberstate'} eq 'admin' || $users{$user}{'memberstate'} eq 'moderator') { return $FALSE; }

  # Associate the DBM hash
  dbmopen(%votes,"forum$forum/votes",0644);
  my $line = $votes{$user} || return $FALSE;
  dbmclose(%votes);

  # Get a list of topics they have voted on and check if the included is one
  my @parts = split(/\;/,$line);
  my $find = "$topic\-$id";
  foreach my $check (@parts) {
    if($check eq $find) { return $TRUE; }
  }
  return $FALSE;
}

sub errorout {
  my($errormsg) = @_;

  print <<end;
    <h2>Your Vote Was NOT Saved</h2>

    <b>Reason:</b> <p>$errormsg</p>
end
  page_footer();
  exit;
}
