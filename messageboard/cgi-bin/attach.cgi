#!/usr/bin/perl

# This script handles file uploads from validated users.  There is an option
# within the script to restrict uploads to certain file extensions, but that
# can be turned off.
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
# Revision: June 2001

require "global.cgi";

# Output the content headers
content();
page_header("$config{'board_name'} > Attach a File");

my $action = $Pairs{'action'};
if($action eq 'select' || !$action) { selectfile(); }
elsif($action eq 'upload')          { uploadfile(); }
else                                { selectfile(); }


# Provides the form to upload a file
sub selectfile {
  # Get the forum, topic and ID of the post to save the files under
  my $forum = $Pairs{'forum'};
  my $topic = $Pairs{'topic'};
  my $id    = $Pairs{'id'};
  my $randomid = $Pairs{'randomid'};
  my $inf   = get_cookie("mb-user");   my($user,$pass) = split(/\|/,$inf);
  
  # Print the form
  print <<end;
    <table width="98%" align="center" border="0" cellspacing="0" cellpadding="0" bgcolor="$color_config{'border_color'}"><tr><td>
      <form enctype="multipart/form-data" method="post" action="$paths{'board_url'}attach.cgi?action=upload">
      <table width="100%" border="0" cellspacing="1" cellpadding="5">
        <tr bgcolor="$color_config{'nav_top'}"><td colspan="2"><font face="Verdana" size="2"><b>&#187; Attach a File</b></font></td></tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Username</b></font></td>
	  <td><input type="text" name="user" value="$user"></td>
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>Password</b></font></td>
	  <td><input type="password" name="pass" value="$pass"></td>
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}">
	  <td><font face="Verdana" size="2"><b>File To Attach</b></font></td>
	  <td><input type="file" name="fileupload"></td>
	</tr>
	<tr bgcolor="$color_config{'body_bgcolor'}"><td colspan="2"><font face="Verdana" size="2">
	  <b>Notice:</b> There will be a small pause after you hit "Attach File" while the file is uploaded
	  to the server.
	</font></td></tr>
	<tr bgcolor="$color_config{'nav_top'}"><td colspan="2" align="center"><input type="submit" name="submit" value="Attach File"></td></tr>
      </table>
      <input type="hidden" name="action" value="upload">
      <input type="hidden" name="forum"  value="$forum">
      <input type="hidden" name="topic"  value="$topic">
      <input type="hidden" name="id"     value="$id">
      <input type="hidden" name="randomid" value="$randomid">
      </form>
    </td></tr></table>
end
}

# Uploads a file to the uploads directory
sub uploadfile {
  my $user  = $query->param('user');
  my $pass  = $query->param('pass');
  my $forum = $query->param('forum');
  my $file  = $query->param('fileupload');
  my $randomid = $query->param('randomid');
  
  # Check the user account and permission
  if(check_account($user,$pass) == $FALSE) {
    print "<font face=\"Verdana\" size=\"2\"><b>Your username/password combination was invalid.</b></font><br>\n";
    exit;
  }
  if(perms($user,'ATTACH') == $FALSE) { noaccess('uploadfile'); }
  
  # They have permission -- check the required variables exist
  if(!$file || !$forum || !-d "$cgi_path/forum$forum") {
    print "<font face=\"Verdana\" size=\"2\"><b>You did not supply all required fields.</b></font><br>\n";
    exit;
  }
  
  # Compose the filename for the file to save
  $given_name = $file;  my @parts = split(/[\/\\]/,$file);   $given_name = $parts[$#parts];
  $random_number = int(rand 10000);
  $filename = "$forum-$random_number-$given_name";
  $type = filetype($file);
  
  # Save the file
  lock_open(FILE,"$paths{'noncgi_path'}/uploads/$filename","w");
  truncate(FILE,0);   seek(FILE,0,0);
  while($in = <$file>) { print FILE $in; }
  close(FILE);
  
  # Attach the file information to the random attach file
  lock_open(ATTACH,"$cgi_path/forum$forum/$randomid.attach","a");
  truncate(ATTACH,0);    seek(ATTACH,0,2);
  print ATTACH "\[file=$type\]$filename\[\/file\]\n";
  close(ATTACH);
   
  # Update the user on the progress
  print <<end;
    <font face="Verdana" size="2">
      <p><b>File uploaded successfully!</b></p>
      
      <p>
	<input type="button" name="attach" value="Close Window"    onClick="self.close();">&nbsp;&nbsp;
        <input type="button" name="attach" value="Upload Another"  onClick="location=$paths{'board_url'}attachi.cgi?forum=$forum;">
      
end
}

sub filetype {
  # Set up the MIME Type Tables
  mimetable();
 
  # Read in the current file
  my $file = $_[0];
  
  # Get the file type
  my $mimetype = $query->uploadInfo($file)->{'Content-type'};
  
  # Set the icon to use by the mimetype from the table
  $icon = $MimeTable{$mimetype};
  
  if($icon && -e "$paths{'noncgi_path'}/mimetypes/$icon") { return $icon; } else { return "html.gif"; }
}

sub mimetable {
  %MimeTable = ('image/jpeg',                'image.gif',
                'image/gif',                 'image.gif',
		'text/plain',                'html.gif',
		'html',                      'html.gif',
		'text/html',                 'html.gif',
		'application/x-gtar',        'zip.gif',
		'application/x-gzip',        'zip.gif',
		'application/zip',           'zip.gif',
		'audio/midi',                'audio.gif',
		'audio/mpeg',                'audio.gif',
		'audiox-pn-realaudio',       'audio.gif',
		'audio/x-wav',               'audio.gif'
	       );
}
