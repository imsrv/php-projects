<? 

function getHelpContents(){
	global $Document,$GlobalSettings,$Language;
	
	$contents = <<<EOF
<BR/><BR/>
<TABLE WIDTH="90%" ALIGN="CENTER">
<TR>
	<TD CLASS="TDPlain">
	<P ALIGN="JUSTIFY">
	This section briefly explains the important points that might
	save you time when modifying and maintaining your forums. 
	<OL>
		<LI>Scripts are in the <STRONG>includes</STRONG> folder
		<LI>HTML codes are in the <STRONG>templates</STRONG> folder and in the file includes/<STRONG>functions.php</STRONG>
		<LI>Language dependent files, including graphics, are in their particular named language's folder, i.e.: <STRONG>english</STRONG>.  If
		you're looking for a certain set of translations and graphics in your language, please visit our
		<a href="http://www.pearlinger.com/pearl/languages/">Language Packs Section</a>.  It might not be available in
		your language but please take a look anyway, or you can contribute yours.
	</OL>
	
	<STRONG>Access/Privileges</STRONG><BR><BR>
	<EM>Administrators</EM> - All access, including this administration area<BR>
	<EM>Global Moderators</EM> - All access, except this administration area<BR>
	<EM>Moderators</EM> - Access is limited to desinated room(s).  Cannot move topics.
	</P>
	<HR SIZE="10"><BR/>

	<A NAME="SpamGuard"></A>
	<STRONG><U>SPAM GUARD</U></STRONG>:<BR><BR>
	You can activate SpamGuard on registration and (or) login to prevent
	automatic registrations.  With SpamGuard turned on, a user has to
	fillout the 7-digit code in the image provide in order to continue.

	<HR SIZE="10"><BR/>
	
	<A NAME="Registration"></A>
	<STRONG><U>MEMBERS REGISTRATION</U></STRONG>:<BR><BR>
	Registration requires a valid email.  Passwords will be sent to new members' emails
	after registration.  We make this process simple enough so that you can customize it
	to suit your needs.  We recommend that you test-register some accounts first,
	then read the welcome messages and make appropriate changes.  All email messages
	are in the choosen language's folder (<STRONG>english</STRONG> is the default).

	<HR SIZE="10"><BR/>
	
	<A NAME="Settings"></A>
	<STRONG><U>SETTINGS</U></STRONG>: <BR/><BR/>
	This section updates the settings.php file.  You can also update settings.php directly, but
	we recommend that you make changes to the includes/adminSettings.php file first.<BR/><BR/>
	
	<STRONG>Notes on important variables</STRONG>:<BR><BR>
	<EM>Members Only</EM> - Force visitors to login.
	<BR/><BR/>
	<EM>Graphic Buttons</EM> - Default is <EM>yes</EM>.  All links will be in text mode if set to <EM>no</EM> .

	<HR SIZE="10"><BR/>

	<A NAME="Boards"></A>
	<STRONG><U>BOARDS</U></STRONG>:<BR><BR>
	Closed boards are still visible, accessible to global moderators and administrators.  
	Deleting a board will delete all dependent forums, topics, postings etc., of that board.
	
	<HR SIZE="10"><BR/>

	<A NAME="Forums"></A>
	<STRONG><U>FORUMS</U></STRONG>:<BR><BR>
	Closed forums are still visible, accessible to global moderators and administrators.  
	Deleting a forum will delete all dependent topics, postings etc., of that forum.  Rooms
	designated as Announcement Only will still allow members to participate, as replies only and
	cannot start a new topic in such rooms.
	
	<HR SIZE="10"><BR/>

	<A NAME="Members"></A>
	<STRONG><U>MEMBERS</U></STRONG>:<BR><BR>
	Only administrators can lock/unlock an account.  Deleting a member will remove all
	postings by that member, as well as any postings in topics that are started by this member.
	
	<HR SIZE="10"><BR/>

	<A NAME="Groups"></A>
	<STRONG><U>GROUPS</U></STRONG>:<BR><BR>
	Groups are used to limit members' access to certain boards.  If a board is
	desinated to the group <EM>PHP Geeks</EM> then only members in 
	that group can access that board's forums.

	<HR SIZE="10"><BR/>

	<STRONG><U>ATTACHMENTS</U></STRONG>:<BR><BR>
	When an attachment is deleted by its owner, the actual file and its record is
	removed.  When deleted by an admin or moderator, only the physical file is
	removed.  The record itself will be left in the database and marked as removed
	by admin/moderator.
	
	<HR SIZE="10"><BR/>

	<A NAME="Polls"></A>
	<STRONG><U>POLLS</U></STRONG>:<BR><BR>
	Only admin or moderators can start a poll, and is automatically removed 
	when the topic is removed.  Each vote casted is stored in the PollVotes
	table.
		
	
	<HR SIZE="10"><BR/>

	<A NAME="Avatars"></A>
	<STRONG><U>AVATARS</U></STRONG>:<BR><BR>
	Avatars uploaded in this admin section will be available to all members.
	Avatars that are uploaded by members through profile updating will not be 
	available to anyone except the owners themselves.
	<HR SIZE="10"><BR/>

	<A NAME="Smileys"></A>
	<STRONG><U>SMILEYS</U></STRONG>:<BR><BR>
	The smileys/smiley.js file is generated upon installation.  This file and
	its folder has to be writable.
	<HR SIZE="10"><BR/>

	<A NAME="Emails"></A>
	<STRONG><U>EMAIL UTILITY</U></STRONG>:<BR><BR>
	Used for mass mailing, you can also send messages as an alternative.
	
	<HR SIZE="10"><BR/>

	<A NAME="Banned"></A>
	<STRONG><U>BANNED IPs</U></STRONG>:<BR><BR>
	Set the <EM>Check For Banned IPs</EM> flag in settings to <EM>Yes</EM>
	if you wish to use this feature.
	
	<HR SIZE="10"><BR/>

	<A NAME="Sensored"></A>
	<STRONG><U>SENSORED WORDS</U></STRONG>:<BR><BR>
	Set the <EM>Check Sensored Words</EM> flg to <EM>Yes</EM>
	Login names are also checked against this list on registration.
	<HR SIZE="10"><BR/>

	<A NAME="Reserved"></A>
	<STRONG><U>RESERVED USERNAMES</U></STRONG>:<BR><BR>
	Make sure that you populate this list first before allowing users to register.  
	<HR SIZE="10"><BR/>
		
	<A NAME="Errorlogs"></A>
	<STRONG><U>ERROR LOGS</U></STRONG>:<BR><BR>
	This feature helps monitor sql syntaxes.   
	</TD>
</TR>
</TABLE>	
EOF;
	return $contents;
	
}
?>
