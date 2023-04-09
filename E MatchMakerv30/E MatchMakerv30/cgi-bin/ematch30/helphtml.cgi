#################################################
#################################################
# Help Routines

sub mainhelp {

print <<MAINHELP;
Content-type: text/html

<html><head><title>e_Match</title>$header
<h1 align=center><i><CENTER>Main Menu Tips</CENTER></i></h1>
<p>
<ul>
<li>If no matches are found, either the database is too low at this time, or your profile was too restrictive.  Click <b>[Help]</b> on the profile form page for more details.
<li>NOTE: A match becomes &quot;<b>active</b>&quot; when you post a private message to their board.  Active matches are displayed with a white background and remain on your match list until you <b>[Nuke'em]</b>.</ul><hr>
<TABLE WIDTH="90%">
 <TR>
  <TD align=right>
   <b><SMALL>Nickname:</SMALL></b>
  </TD>
  <TD>
   <SMALL>- This match's Nickname. (Not a real name or an e-mail address)</SMALL>
  </TD>
 </TR>
 <TR>
  <TD align=right>
   <b><SMALL>Score:</SMALL></b>
  </TD>
  <TD>
   <SMALL>- A value based on a comparison of the two profiles.</SMALL>
  </TD>
 </TR>
 <TR>
  <TD align=right>
   <B><SMALL>[View&nbsp;(Match)'s&nbsp;Profile]</SMALL></B>
  </TD>
  <TD>
   <SMALL> - Click here to view this match's profile.</SMALL>
  </TD>
 </TR>
 <TR>
  <TD align=right>
   <B><SMALL>[View Board]</SMALL></B>
  </TD>
  <TD>
   <SMALL> - Click here to view the private message board shared by you and this match.</SMALL>
  </TD>
 </TR>
 <TR>
  <TD ALIGN=right valign=top>
   <B><SMALL>Status:</SMALL></B>
  </TD>
  <td>
   <SMALL>- <B>Empty</B> = nothing posted yet, <br> - <B>Posted</B> = you posted a message that hasn't been read yet, <br> - <B>Read</B> = all messages have been read by both parties, <br> - <B>New</B> = you have a new message to read.</SMALL>
  </td>
 </TR>
  <td align=right>
   <B><SMALL>[Nuke'em]</SMALL></B>
  </td>
  <td align=left>
   <SMALL> - Click here if you want to remove this match from your list permanently.</SMALL>
  </td>
 <tr>
</TABLE>

$footer</body></html>
MAINHELP
exit;
}

#################################################
#################################################
# Profile Form Help

sub formhelp {

print <<FORMHELP;
Content-type: text/html

<html><head><title>e_Match</title>$header
<h1 align=center><i><CENTER>Profile Tips - close this window to return</CENTER></i></h1>
<UL>
<LI>You don't need to answer every question, and you can redo your profile at any time.
<li>You can add a picture to your profile after it is completed.  Just click the <b>[View Your Profile]</b> button on the Main Menu for details.
</UL><hr>
<h2 align=center>Information about you</h2>
<ul><li>Choose the characterstics about yourself that you want included in your profile.  Remember, you don't have to "tell all."</ul>
<hr>

<h2 align=center>Limit matches to people looking for...</h2>
<ul><li><B>USE THIS CAREFULLY!</B>  If you choose anything but "Doesn't Matter", you'll be limiting your matches to those who picked the same relationship type, or who chose "Doesn't Matter."</ul>
<hr>

<h2 align=center>Information about people you're looking for</h2>
<ul><li>Choose the charateristics of the type of person you want to match.  You don't have to choose anything for a characteristic if you don't want to.  You can also rate each characteristic.
<p align=center><B>USE "ESSENTIAL!" AND "NO THANKS!" Sparingly!</B></p> If you choose "ESSENTIAL!" for a characteristic, anyone not having that trait will be eliminated from you match list, regardless of any other items in their profile.  If you choose "NO THANKS!", you'll eliminate everyone who DOES have that trait.</ul>
<hr>

<h2 align=center>Favorite...</h2>
<ul><li>The next several sections are used to determine common interests.  You can choose any of the interests, and also give the interest a positive or negative rating.  As stated above, use the extreme ratings ("ESSENTIAL!" and "NO THANKS!") sparingly, since they will narrow your field of matches considerably.  They are to be used only if your matches either have to have, or must not have, a certain interest.</ul>
<hr>

<h2 align=center>Comment:</h2>
<ul><li>Of course no simple collection of traits and interests can really define a person.  If you feel that something more needs to be said, or you just want to express your favorite quote or saying, go ahead and add a brief, one paragraph comment here.  This section does not affect your rating one way or the other.</li>

$footer
FORMHELP
exit;
}

1;