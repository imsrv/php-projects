#!/usr/bin/perl
############################################################
eval {
	($0=~ m,(.*)/[^/]+,)   && unshift (@INC, "$1");
	($0=~ m,(.*)\\[^\\]+,) && unshift (@INC, "$1");
	require "config.pl";
	unshift(@INC, $CONFIG{script_path});
	unshift(@INC, "$CONFIG{script_path}/scripts");
  	require "database.pl";
        require "new_database.pl";
	require "default_config.pl";
	require "display.pl";
	require "english.lng";
	require "html.pl";
	require "images.pl";
	require "library.pl";
	require "logs.pl";
	require "templates.pl";
	require "mojoscripts.pl";
	require "parse_template.pl";
	require "upgrade.pl";
	use CGI qw(:standard);
	use CGI::Carp qw(fatalsToBrowser);
	use File::Path;
	use strict;
#	use vars qw($Cgi, %FORM);
   &main;
};
if ($@) {
	print "content-type:text/html\n\n";
	print "Error Including configuration file, Reason: $@";
	exit;
}
################################################################
sub main {
	$|++;
	$t_start = time;
	$Cgi = new CGI; $Cgi{mojoscripts_created} = 1;
	&ParseForm;
	&Initialization;
	if ($FORM{cancel}) {&PrintEnd("Process completed.");}
	elsif ($FORM{step} eq 'final'){
	       &DeleteOld;
	       &PrintEnd("Old database successfully deleted.");
	}
	else {&PrintDelete;}
}




############################################################
sub PrintDelete{

        &PrintHeader;
	print qq|<html>
<head>
<title>\$mj{program} $mj{version} Upgrading procedure</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#FFFFFF" text="#000000">
      <form name="mojo" method="post" action="delete_old.cgi">
<table width="80%" border="1" cellspacing="0" cellpadding="0" align="center" bordercolor="#330066">
  <tr>
    <td>
      <div align="center"><b><font size="4">$mj{program} $mj{version} Upgrading
        Procedure<br>
        from version 2.XX to $mj{version}</font></b></div>
    </td>
  </tr>
  <tr>
    <td height="200">
      <div align="center"><b><font color="#FF0000">Step 5 of upgrading procedure: going to delete old (text) database.</font></b></div>
    </td>
  </tr>
	<tr> 
	  <td valign="middle" align="center" colspan="2"> 
        <input type="SUBMIT" value="Next >>" name="submit">
        <input type="submit" name="cancel" value="Cancel">
      </td>
    </tr>
        </table>
        <input type="hidden" name="step" value="final">
      </form>
    </td>
  </tr>
</table>
</body>
</html>
	|;
	&PrintFooter;
}

