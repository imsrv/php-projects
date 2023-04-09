#!/usr/bin/perl

##############################################################################
# PROGRAM : BuildACommunity.com Perl Module                                  #
# VERSION : 3.1                                                              #
#                                                                            #
# NOTES   :                                                                  #
##############################################################################
# All source code, images, programs, files included in this distribution     #
# Copyright (c) 1999 -> 2017                                                 #
#           Eric L. Pickup, Ecreations, BuildACommunity                      #
#           All Rights Reserved.                                             #
##############################################################################
#                                                                            #
#    ------ DO NOT MODIFY ANYTHING BELOW THIS POINT !!! -------              #
#                                                                            #
##############################################################################


$max_groups = 10;

use File::Copy;
use DB_File;

$userpm = "T";
require "./common.pm";
require $GPath{'cf.pm'};


$PROGRAM_NAME = "cforum.cgi";

#if ($yh_domains ne "") { if( &Invalid_IP($yh_domains) ) { print "Location: $CONFIG{'COMMUNITY_noip'}\n\n"; } }

&parse_FORM;
#$BODY .= "BUFFER: $buffer\n<BR><BR><BR>";

($VALID, %IUSER) = &validate_session;

	open (FILE, "$GPath{'cforums_data'}/god.def");
	@god = <FILE>;
	close(FILE);
	$admin_num = $god[0];

	&read_forum;

	if ((($IUSER{'filenum'} eq $IFORUM{'bbs_admin'}) && (($IFORUM{'moderator_edit'} eq "Settings Not Appearance") || ($IFORUM{'moderator_edit'} eq "Yes"))) || ($IUSER{'filenum'} eq $admin_num))  {}
	else {
		&access_denied;
	}




if (($FORM{'action'} eq "Edit Settings") || ($FORM{'action'} eq "")) {
	if ($IFORUM{'moderator_edit'} eq "Settings Not Appearance") {
		&forum_no_appearance_form;
	}
	else {
		&forum_form;
	}
	&print_output('cforum_mod');
	exit;
}

if ($FORM{'action'} eq "template") {
	&open_templates;
	&print_output('cforum_mod');
	exit;
}

if ($FORM{'action'} eq "Save Forum Configuration") {
	&save_forum;
	&print_output('cforum_mod');
	exit;
}

if ($FORM{'action'} eq "Save Template") {
	&save_template;
	&print_output('cforum_mod');
	exit;
}



sub read_forum {
	%IFORUM = &readbbs("$GPath{'cforums_data'}/$FORM{'forum'}.cfg");
	$forum = $FORM{'forum'};
}


sub save_forum {
	open (CFG, ">$GPath{'cforums_data'}/$FORM{'forum'}.cfg");
	print CFG "$FORM{'title'}|";
	print CFG "$FORM{'pg_color'}|";
	print CFG "$FORM{'win_color'}|";
	print CFG "$FORM{'font_face'}|";
	print CFG "$FORM{'text_color'}|";
	print CFG "$FORM{'title_color'}|";
	print CFG "$FORM{'ttxt_color'}|";
	print CFG "$FORM{'bbs_admin'}|";
	print CFG "$FORM{'access'}|";
	print CFG "$FORM{'restrictedto'}|";
	print CFG "$FORM{'group'}|";
	print CFG "$FORM{'newthreads'}|";
	print CFG "$FORM{'moderated'}|";
	print CFG "$FORM{'emailmoderator'}|";
	print CFG "$FORM{'moderator_edit'}|";
	print CFG "$FORM{'bbs_table1'}|";
	print CFG "$FORM{'bbs_table2'}|";
	print CFG "$FORM{'highlightcolor'}|";
	print CFG "$FORM{'topic_color'}|";
	print CFG "$FORM{'public'}|";
	print CFG "$FORM{'status'}|";
	print CFG "$FORM{'applicantmessage'}|";
	print CFG "$FORM{'clubforum'}|";
	print CFG "$FORM{'CLUB_max_kb'}|";
	print CFG "$FORM{'CLUB_max_images'}|";

	print CFG "|";
	print CFG "$FORM{'bbs_private_pw'}\n";
	print CFG "$FORM{'bbs_desc'}";
	close (CFG);

	$BODY .= "<TABLE BORDER>\n";
	$BODY .= "</TR>\n";
	$BODY .= "<TD BGCOLOR=NAVY BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
	$BODY .= "<CENTER><FONT COLOR=WHITE><B>Configuration Saved.</B></FONT></CENTER>\n";
	$BODY .= "</TD></TR><TR>\n";
	$BODY .= "<TD $CONFIG{'WINCOLOR'}><FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\"> \n";
	$BODY .= "File Saved.\n";
	$BODY .= "<CENTER><FORM><INPUT TYPE=\"button\" VALUE=\"--- OK ---\" onClick=\"history.go(-2);\"></FORM></CENTER>\n";
	$BODY .= "</TD></TR></TABLE>\n";
	$BODY .= "<P>\n";
	$BODY .= "<HR>\n";
	$BODY .= "$FORM{'TEMPLATE'}\n";
}

sub forum_no_appearance_form {

	$forum = time . "," . $$;

	for $x(0 .. $max_groups) {
		$GROUP_SELECT .= "<OPTION VALUE=\"$x\">$x</OPTION>\n";
	}

	if ($CONFIG{'win_color'} ne "") {
		$CONFIG{'WINCOLOR'} .= " BGCOLOR=$CONFIG{'win_color'}";
	}
	else {
		$CONFIG{'WINCOLOR'} .= "";
	}
	if ($ENV{'HTTP_USER_AGENT'} =~ /MSIE/i) {
		$HELPURL = "<A HREF=\"$GUrl{'cforum.cgi'}?action=help&file=club_settings\">";
	}
	else {
		$HELPURL = "<A HREF=\"javascript:ShowHelp('club_settings')\">";
	}

	if ($IFORUM{'clubforum'} ne "Club") {
		my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/cforum/forum_no_appearance_form.tmplt");
		$BODY = $template->fill_in;
		$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/cforum/forum_no_appearance_form.tmplt";
	}
	else {
		my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/cforum/autoclubs/forum_no_appearance_form.tmplt");
		$BODY = $template->fill_in;
		$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/cforum/autoclubs/forum_no_appearance_form.tmplt";
	}
}



sub forum_form {
	for $x(0 .. $max_groups) {
		$GROUP_SELECT .= "<OPTION VALUE=\"$x\">$x</OPTION>\n";
	}

	my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/cforum/moderator_form.tmplt");
	$BODY = $template->fill_in;
	$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/cforum/moderator_form.tmplt";
}




sub open_templates {
	$fn = "$GPath{'template_data'}/$FORM{'template2edit'}";
	if (! -e "$fn") {$fn = "$GPath{'template_data'}/bbs.txt";}

	open(FILE, "$fn");
 		@source = <FILE>;
	close(FILE);

	foreach $line(@source) {
		$TEXT .= $line;
	}
     	$TEXT =~ s/\cM//g;



	&Symbol_List;
	&Font_List;
	&Plugin_List;
	&Tags;
	&Colors;
	$BODY .= <<LIST1;
		<SCRIPT LANGUAGE="javascript">
		function ShowHelp(c_what) {
		  var Location = "$GUrl{'cforum.cgi'}?action=help&file=" + c_what;
		  link=open(Location,"CCSLink","toolbar=no,scrollbars=yes,directories=no,menubar=no,resizable=yes,width=420,height=410");
		}

		function OpenWin(Loc) {
		  link=open(Loc,"CCSLink","toolbar=no,scrollbars=yes,directories=no,menubar=no,resizable=yes,width=420,height=410");
		}

		function OpenForum(v_forum) {
		  document.forum_select.forum.value = v_forum;
		  document.forum_select.submit();  
		}
		</SCRIPT>
LIST1

$BODY .= <<DONE;
    <SCRIPT LANGUAGE="javascript">
	    function Symbols() {
		    var text=document.html_form.source.value;
			var num = document.html_form.symbol.selectedIndex;
			var sval = document.html_form.symbol[num].text;
			if(num > 0) {
			   text = text + sval;
			   document.html_form.source.value=text;
			   document.html_form.source.focus();
			}
		}
		
	    function Font() {
		    var text=document.html_form.source.value;
			var num = document.html_form.font.selectedIndex;
			var sval = document.html_form.font[num].text;
			if(num > 0) {			
 			   text = text + "<FONT FACE='" + sval + "' SIZE='$CONFIG{'font_size'}' COLOR='$CONFIG{'text_color'}'>";
			   document.html_form.source.value=text;
			   document.html_form.source.focus();
			}			   
		}		

	    function Plugin() {
		    var text=document.html_form.source.value;
			var num = document.html_form.plugin.selectedIndex;
			var sval = document.html_form.plugin[num].value;
			if(num > 0) {
			   text = text + sval;
			   document.html_form.source.value=text;
			   document.html_form.source.focus();
			}
		}

	    function Tag() {
		    var text=document.html_form.source.value;
			var num = document.html_form.tag.selectedIndex;
			var sval = document.html_form.tag[num].value;
			if(num > 0) {
			   text = text + sval;
			   document.html_form.source.value=text;
			   document.html_form.source.focus();
			}
		}

	    function Color(c_value) {
		    var text=document.html_form.source.value;
			text = text + c_value;
			document.html_form.source.value=text;
			document.html_form.source.focus();
		}
				
	</SCRIPT>
	<FONT FACE="arial,helvetica" SIZE=-1>
	<CENTER>
    <form ENCTYPE=\"application/x-www-form-urlencoded\"  NAME="html_form" ACTION="$GUrl{'cf_moderators.cgi'}" METHOD="post">
	<TABLE BGCOLOR="black" BORDER=0 WIDTH=500 CELLSPACING=2 CELLPADDING=0><TR><TD>
	  <TABLE WIDTH=100% BORDER=0 BGCOLOR="$CONFIG{'win_color'}">
	    <TR><TD VALIGN="top" BGCOLOR="$CONFIG{'title_color'}">
		  <FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\">
		    <FONT COLOR=\"$CONFIG{'ttxt_color'}\" SIZE=\"+1\"><B><H3>Template Editor</H3></B></FONT>
 	        $symbols
	        $fonts
	        $plugins
	        $tags
		&nbsp &nbsp &nbsp &nbsp<A HREF="javascript:ShowHelp('templates')"><IMG SRC="$CONFIG{'button_dir'}/help.gif" BORDER=0 WIDTH="25" HEIGHT="25" VALIGN=top ALIGN=top></A>
	      </FONT>		  
		</TD></TR>
	    <TD VALIGN="top">
 		 <CENTER>
	     <FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\"><TEXTAREA NAME="source" COLS=60 ROWS=15>$TEXT</TEXTAREA><BR>
                 <INPUT TYPE="hidden" NAME="password" VALUE="$password">
                 <INPUT TYPE="hidden" NAME="filename" VALUE="$FILENAME">
                 <INPUT TYPE="hidden" NAME="template2edit" VALUE="$FORM{'template2edit'}">
                 <INPUT TYPE="hidden" NAME="mode" VALUE="$input{'mode'}">
                 <INPUT TYPE="hidden" NAME="todo" VALUE="$input{'todo'}">
                 <CENTER><INPUT TYPE="submit" NAME="action" VALUE="Save Template">
		 </CENTER>
	    </TD></TR>
	  </TABLE>
	</TD></TR></TABLE>
	</FORM><FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\">
    <B>Click to insert color...</B><BR>
    <TABLE BORDER="1" CELLSPACING="0" CELLPADDING="1">
      <TR>
        $colortable
      </TR>
    </TABLE>
  </CENTER>

DONE

}

sub Plugin_List {

   $plugins=<<DONEPLUGINS;
    <SELECT NAME="plugin" onChange="Plugin();">
      <OPTION>Plugins
      <OPTION VALUE="\nPLUGIN:BODY\n">PLUGIN:BODY
      <OPTION VALUE="\nPLUGIN:BANNER\n">PLUGIN:BANNER
      <OPTION VALUE="\nPLUGIN:CONTROL_PANEL\n">PLUGIN:CONTROL_PANEL

      <OPTION VALUE="PLUGIN:LONGDATE">PLUGIN:LONGDATE
      <OPTION VALUE="PLUGIN:USDATE">PLUGIN:USDATE
      <OPTION VALUE="PLUGIN:SHORTDATE">PLUGIN:SHORTDATE
      <OPTION VALUE="PLUGIN:REFERER">PLUGIN:REFERER
      <OPTION VALUE="PLUGIN:USEREMAIL">PLUGIN:USEREMAIL
      <OPTION VALUE="PLUGIN:USERDESCRIPTION">PLUGIN:USERDESCRIPTION
      <OPTION VALUE="PLUGIN:USERCOMMUNITY">PLUGIN:USERCOMMUNITY
      <OPTION VALUE="PLUGIN:COMMUNITYNAME">PLUGIN:COMMUNITYNAME
      <OPTION VALUE="PLUGIN:HANDLE">PLUGIN:HANDLE
      <OPTION VALUE="PLUGIN:USERREALNAME">PLUGIN:USERREALNAME
      <OPTION VALUE="PLUGIN:SCREENNAME">PLUGIN:SCREENNAME
      <OPTION VALUE="PLUGIN:USERNAME">PLUGIN:USERNAME
      <OPTION VALUE="PLUGIN:FIRSTNAME">PLUGIN:FIRSTNAME
      <OPTION VALUE="PLUGIN:MIDDLENAME">PLUGIN:MIDDLENAME
      <OPTION VALUE="PLUGIN:LASTNAME">PLUGIN:LASTNAME
      <OPTION VALUE="PLUGIN:BIRTH:DAY">PLUGIN:BIRTH:DAY
      <OPTION VALUE="PLUGIN:BIRTH:MONTH">PLUGIN:BIRTH:MONTH
      <OPTION VALUE="PLUGIN:BIRTH:MONTH:WORD">PLUGIN:BIRTH:MONTH:WORD
      <OPTION VALUE="PLUGIN:BIRTH:YEAR">PLUGIN:BIRTH:YEAR
      <OPTION VALUE="PLUGIN:FILLER(1..10)">PLUGIN:FILLER
      <OPTION VALUE="&lt;A HREF='PLUGIN:_PROFILE'&gt;Your text here&lt;/A&gt;">PLUGIN:_PROFILE
      <OPTION VALUE="&lt;A HREF='PLUGIN:_WEBPAGE'&gt;Your text here&lt;/A&gt;">PLUGIN:_WEBPAGE

      <OPTION VALUE="PLUGIN:CUSTOM:Your_Function_Name">PLUGIN:CUSTOM


    </SELECT>
DONEPLUGINS

}

sub Font_List {

   $fonts=<<DONEFONTS;
    <SELECT NAME="font" onChange="Font();">
     <OPTION>Font
     <OPTION>Arial,Helvetica
     <OPTION>Tahoma,Helvetica
     <OPTION>Verdana,Helvetica
     <OPTION>Times Roman
     <OPTION>MS Comic Sans Serif
     <OPTION>Courier
    </SELECT>
DONEFONTS
}


sub Tags {
   $tags=<<DONETAGS;
    <SELECT NAME="tag" onChange="Tag();">
     <OPTION>HTML Tags
     <OPTION VALUE="&lt;H1&gt; &lt;/H1&gt;">H1
     <OPTION VALUE="&lt;H2&gt; &lt;/H2&gt;">H2
     <OPTION VALUE="&lt;H3&gt; &lt;/H3&gt;">H3
     <OPTION VALUE="&lt;H4&gt; &lt;/H4&gt;">H4
     <OPTION VALUE="&lt;B&gt; &lt;/B&gt;">BOLD
     <OPTION VALUE="&lt;U&gt; &lt;/U&gt;">Underline
     <OPTION VALUE="&lt;I&gt; &lt;/I&gt;">Italics
     <OPTION VALUE="&lt;BLOCKQUOTE&gt;\n&lt;/BLOCKQUOTE&gt;">Blockquote
     <OPTION VALUE="&lt;IMG SRC='/path/to/image.gif'&gt;">Image
     <OPTION VALUE="&lt;CENTER&gt; &lt;/CENTER&gt;">Center
     <OPTION VALUE="&lt;P ALIGN='left'&gt; &lt;/P&gt;">Align Left
     <OPTION VALUE="&lt;P ALIGN='right'&gt; &lt;/P&gt;">Align Right
    </SELECT>
DONETAGS
}

sub Symbol_List {

   $symbols=<<DONESYMBOLS;
   <SELECT NAME="symbol" onChange="Symbols();">
     <OPTION>Symbol
     <OPTION>&quot;
     <OPTION>&amp
     <OPTION>&lt;
     <OPTION>&gt;
	 
	 <!--
     <OPTION>&euro;
     <OPTION>&fnof;
     <OPTION>&hellip;
     <OPTION>&dagger;
     <OPTION>&Dagger;
     <OPTION>&permil;
     <OPTION>&Scaron;
     <OPTION>&OElig;
     <OPTION>&bull;
     <OPTION>&mdash;
     <OPTION>&trade;
     <OPTION>&scaron;
     <OPTION>&rsaquo;
     <OPTION>&oelig;
     <OPTION>&Yuml;
	 -->
	 
     <OPTION>&nbsp;
     <OPTION>&iexcl;
     <OPTION>&cent;
     <OPTION>&pound;
     <OPTION>&curren;
     <OPTION>&yen;
     <OPTION>&brvbar;
     <OPTION>&sect;
     <OPTION>&copy;
     <OPTION>&laquo;
     <OPTION>&not;
     <OPTION>&reg;
     <OPTION>&deg;
     <OPTION>&plusmn;
     <OPTION>&sup2;
     <OPTION>&sup3;
     <OPTION>&acute;
     <OPTION>&micro;
     <OPTION>&para;
     <OPTION>&middot;
     <OPTION>&sup1;
     <OPTION>&raquo;
     <OPTION>&frac14;
     <OPTION>&frac12;
     <OPTION>&frac34;
     <OPTION>&iquest;
     <OPTION>&Agrave;
     <OPTION>&times;
     <OPTION>&Oslash;
     <OPTION>&szlig;
     <OPTION>&divide;
    </SELECT>
DONESYMBOLS
   
}


sub Colors {

   push @cl,"#000000";
   push @cl,"#003300";
   push @cl,"#006600";
   push @cl,"#009900";
   push @cl,"#00cc00";
   push @cl,"#00ff00";
   push @cl,"#000033";
   push @cl,"#003333";
   push @cl,"#006633";
   push @cl,"#009933";
   push @cl,"#00cc33";
   push @cl,"#00ff33";
   push @cl,"#000066";
   push @cl,"#003366";
   push @cl,"#006666";
   push @cl,"#009966";
   push @cl,"#00cc66";
   push @cl,"#00ff66";
   push @cl,"#000099";
   push @cl,"#003399";
   push @cl,"#006699";
   push @cl,"#009999";
   push @cl,"#00cc99";
   push @cl,"#00ff99";
   push @cl,"#0000cc";
   push @cl,"#0033cc";
   push @cl,"#0066cc";
   push @cl,"#0099cc";
   push @cl,"#00cccc";
   push @cl,"#00ffcc";
   push @cl,"#0000ff";
   push @cl,"#0033ff";
   push @cl,"#0066ff";
   push @cl,"#0099ff";
   push @cl,"#00ccff";
   push @cl,"#00ffff";
   push @cl,"#330000";
   push @cl,"#333300";
   push @cl,"#336600";
   push @cl,"#339900";
   push @cl,"#33cc00";
   push @cl,"#33ff00";
   push @cl,"#330033";
   push @cl,"#333333";
   push @cl,"#336633";
   push @cl,"#339933";
   push @cl,"#33cc33";
   push @cl,"#33ff33";
   push @cl,"#330066";
   push @cl,"#333366";
   push @cl,"#336666";
   push @cl,"#339966";
   push @cl,"#33cc66";
   push @cl,"#33ff66";
   push @cl,"#330099";
   push @cl,"#333399";
   push @cl,"#336699";
   push @cl,"#339999";
   push @cl,"#33cc99";
   push @cl,"#33ff99";
   push @cl,"#3300cc";
   push @cl,"#3333cc";
   push @cl,"#3366cc";
   push @cl,"#3399cc";
   push @cl,"#33cccc";
   push @cl,"#33ffcc";
   push @cl,"#3300ff";
   push @cl,"#3333ff";
   push @cl,"#3366ff";
   push @cl,"#3399ff";
   push @cl,"#33ccff";
   push @cl,"#660000";
   push @cl,"#663300";
   push @cl,"#666600";
   push @cl,"#669900";
   push @cl,"#66cc00";
   push @cl,"#66ff00";
   push @cl,"#660033";
   push @cl,"#663333";
   push @cl,"#666633";
   push @cl,"#669933";
   push @cl,"#66cc33";
   push @cl,"#66ff33";
   push @cl,"#660066";
   push @cl,"#663366";
   push @cl,"#666666";
   push @cl,"#669966";
   push @cl,"#66cc66";
   push @cl,"#66ff66";
   push @cl,"#660099";
   push @cl,"#663399";
   push @cl,"#666699";
   push @cl,"#669999";
   push @cl,"#66cc99";
   push @cl,"#66ff99";
   push @cl,"#6600cc";
   push @cl,"#6633cc";
   push @cl,"#6666cc";
   push @cl,"#6699cc";
   push @cl,"#66cccc";
   push @cl,"#66ffcc";
   push @cl,"#6600ff";
   push @cl,"#6633ff";
   push @cl,"#6666ff";
   push @cl,"#6699ff";
   push @cl,"#66ccff";
   push @cl,"#66ffff";
   push @cl,"#990000";
   push @cl,"#993300";
   push @cl,"#996600";
   push @cl,"#999900";
   push @cl,"#99cc00";
   push @cl,"#99ff00";
   push @cl,"#990033";
   push @cl,"#993333";
   push @cl,"#996633";
   push @cl,"#999933";
   push @cl,"#99cc33";
   push @cl,"#99ff33";
   push @cl,"#990066";
   push @cl,"#993366";
   push @cl,"#996666";
   push @cl,"#999966";
   push @cl,"#99cc66";
   push @cl,"#99ff66";
   push @cl,"#990099";
   push @cl,"#993399";
   push @cl,"#996699";
   push @cl,"#999999";
   push @cl,"#99cc99";
   push @cl,"#99ff99";
   push @cl,"#9900cc";
   push @cl,"#9933cc";
   push @cl,"#9966cc";
   push @cl,"#9999cc";
   push @cl,"#99cccc";
   push @cl,"#99ffcc";
   push @cl,"#9900ff";
   push @cl,"#9933ff";
   push @cl,"#9966ff";
   push @cl,"#9999ff";
   push @cl,"#99ccff";
   push @cl,"#99ffff";
   push @cl,"#cc0000";
   push @cl,"#cc3300";
   push @cl,"#cc6600";
   push @cl,"#cc9900";
   push @cl,"#cccc00";
   push @cl,"#ccff00";
   push @cl,"#cc0033";
   push @cl,"#cc3333";
   push @cl,"#cc6633";
   push @cl,"#cc9933";
   push @cl,"#cccc33";
   push @cl,"#ccff33";
   push @cl,"#cc0066";
   push @cl,"#cc3366";
   push @cl,"#cc6666";
   push @cl,"#cc9966";
   push @cl,"#cccc66";
   push @cl,"#ccff66";
   push @cl,"#cc0099";
   push @cl,"#cc3399";
   push @cl,"#cc6699";
   push @cl,"#cc9999";
   push @cl,"#cccc99";
   push @cl,"#ccff99";
   push @cl,"#cc00cc";
   push @cl,"#cc33cc";
   push @cl,"#cc66cc";
   push @cl,"#cc99cc";
   push @cl,"#cccccc";
   push @cl,"#ccffcc";
   push @cl,"#cc00ff";
   push @cl,"#cc33ff";
   push @cl,"#cc66ff";
   push @cl,"#cc99ff";
   push @cl,"#ccccff";
   push @cl,"#ccffff";
   push @cl,"#ff0000";
   push @cl,"#ff3300";
   push @cl,"#ff6600";
   push @cl,"#ff9900";
   push @cl,"#ffcc00";
   push @cl,"#ffff00";
   push @cl,"#ff0033";
   push @cl,"#ff3333";
   push @cl,"#ff6633";
   push @cl,"#ff9933";
   push @cl,"#ffcc33";
   push @cl,"#ffff33";
   push @cl,"#ff0066";
   push @cl,"#ff3366";
   push @cl,"#ff6666";
   push @cl,"#ff9966";
   push @cl,"#ffcc66";
   push @cl,"#ffff66";
   push @cl,"#ff0099";
   push @cl,"#ff3399";
   push @cl,"#ff6699";
   push @cl,"#ff9999";
   push @cl,"#ffcc99";
   push @cl,"#ffff99";
   push @cl,"#ff00cc";
   push @cl,"#ff33cc";
   push @cl,"#ff66cc";
   push @cl,"#ff99cc";
   push @cl,"#ffcccc";
   push @cl,"#ffffcc";
   push @cl,"#ff00ff";
   push @cl,"#ff33ff";
   push @cl,"#ff66ff";
   push @cl,"#ff99ff";
   push @cl,"#ffccff";
   push @cl,"#ffffff";
   push @cl,"aqua";
   push @cl,"gray">
   push @cl,"navy";
   push @cl,"silver";
   push @cl,"black";
   push @cl,"green";
   push @cl,"olive";
   push @cl,"teal";
   push @cl,"blue";
   push @cl,"lime";
   push @cl,"purple";
   push @cl,"white";
   push @cl,"fuchsia";
   push @cl,"maroon";
   push @cl,"red";
   push @cl,"yellow";

   $x=0;
   foreach $color(@cl) {
      $x++;
      $colortable .= "<TD BGCOLOR=\"$color\"><A HREF=\"javascript:Color('$color');\">&nbsp;&nbsp;&nbsp;</a></TD>\n";
      if($x == 36) { $colortable .= "</TR><TR>"; $x=0; }
   }

}





sub save_template {
	$fn = "$GPath{'template_data'}/$FORM{'template2edit'}";
	open(FILE, ">$fn") || &diehtml("I can't create that $fn\n");
	print FILE "$FORM{'source'}\n";
	close(FILE);
	chmod 0777, "$fn";

	$BODY .= "<TABLE>\n";
	$BODY .= "</TR>\n";
	$BODY .= "<TD BGCOLOR=$CONFIG{'title_color'} BORDER=0 CELLSPACING=0 CELLPADDING=0>\n";
	$BODY .= "<FONT COLOR=\"$CONFIG{'ttxt_color'}\" SIZE=\"+1\"><B>Template Saved.</B></FONT></CENTER>\n";
	$BODY .= "</TD></TR><TR>\n";
	$BODY .= "<TD BGCOLOR=$CONFIG{'win_color'}>\n";
	$BODY .= "File Saved.\n";
	$BODY .= "<CENTER><FORM><FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\"> <INPUT TYPE=\"button\" VALUE=\"--- OK ---\" onClick=\"history.go(-2);\"></FORM></CENTER>\n";
	$BODY .= "</TD></TR></TABLE>\n";
	$BODY .= "<P>\n";
	$BODY .= "<HR>\n";
	$BODY .= "$FORM{'TEMPLATE'}\n";
}

sub access_denied {
	require "common.pm";
	$BODY .= "<TABLE WIDTH=400 CELLPADDING=0 CELLSPACING=0>\n";
	$BODY .= "<TR><TD BGCOLOR=\"$CONFIG{'title_color'}\"><CENTER><FONT COLOR=\"$CONFIG{'ttxt_color'}\" SIZE=\"+1\"><B>An Error Has Occured</B></FONT></CENTER></TD></TR>\n";
	$BODY .= "<TR><TD $CONFIG{'WINCOLOR'}><FONT COLOR=\"$CONFIG{'text_color'}\" SIZE=\"$CONFIG{'font_size'}\" FACE=\"$CONFIG{'font_face'}\">\n";
	$BODY .= "Only the moderator or the administration are allowed to access this program.\n";
	$BODY .= "if ((($IUSER{'filenum'} eq $IFORUM{'bbs_admin'}) && (($IFORUM{'moderator_edit'} eq \"Settings Not Appearance\") || ($IFORUM{'moderator_edit'} eq \"Yes\"))) || ($IUSER{'filenum'} eq $admin_num))  \n";
	$BODY .= "</TD></TR></TABLE>\n";
	
	# For the sake of convience, just spit it out.
	&print_output('error');  
}
