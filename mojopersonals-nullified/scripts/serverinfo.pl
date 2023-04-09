################################################################
sub ServerInfo{
	   if($FORM{'class'} eq "env"){			&Env;					}
	elsif($FORM{'class'} eq "system"){		&System;				}
	elsif($FORM{'class'} eq "module"){		&InstalledModules;}
	elsif($FORM{'class'} eq "file"){			&Filestructure;	}
	elsif($FORM{'class'}){	&PrintError($mj{'error'}, $mj{'confuse'});	}
	&PrintServerInfo;
}
################################################################
sub Env{
	my ($html);
	foreach $key (sort keys %ENV) {
		if(lc($key) eq "path"){	@a= split(/\:/,$ENV{$key}); $ENV{$key} = join("<br>", @a);}
		$html .= qq|<tr><td width="200" align=left>$key:</td><td>$ENV{$key}</td></tr>|;
	}
	&PrintEnv($html);
}
################################################################
sub InstalledModules{
	my($html, $half, $i);
	find(\&FindModules,@INC);
	@mods = sort {	lc($a) cmp lc($b)} @mods;
#	@filepaths = sort {	$b cmp $a} @filepaths;
	
	$total = @mods;
	$count=1;
	for(my $i=0; $i <@mods; $i++){
		$mod = $mods[$i];
		if($count == 2){
			$html .=qq|</tr><tr><td>$mod</td>|;
			$count=1;	
		}
		else{
			$html .=qq|<td>$mod</td>|;
			$count++;
		}
	}
	$html =qq|<tr>$html</tr>|;
	&PrintInstalledModules($html, $total, $message);
}
############################################################
sub System{
	use English;
	if ($^O eq 'MSWin32') {
		$MOJO{OS}=        	"MSWin32";
		$MOJO{VERSION}=		`ver`;
		$MOJO{HOSTNAME}=		`hostname`;
		$MOJO{MAIL_PROGRAM} ="try mail.$ENV{HOSTNAME}";
	}
	else{
		$MOJO{CONVERT}=		`which convert`;
		$MOJO{GZIP}=			`which gzip`;
		$MOJO{MACHINE}=		`uname -m`;
		$MOJO{NODENAME}=		`uname -n`;
		$MOJO{OS_VERSION}=   `uname -v`;
		$MOJO{PERL_LOCATION}=`which perl`;
		$MOJO{PROCESSOR}=		`uname -p`;
		$MOJO{RELEASE}=		`uname -r`;
		$MOJO{SYSNAME}=		`uname -s`;
		$MOJO{TAR}=				`which tar`;
		$MOJO{WHOAMI}=			`whoami`;
		$MOJO{WHOIS}=			`which whois`;

		$temp	=`whereis sendmail`;
		$MOJO{SENDMAIL_LOCATION} = join("<br>", split(/ /, $temp));
		$temp	=`whereis perl`;
		$MOJO{PERL_LOCATION} = join("<br>", split(/ /, $temp));
	}
	$MOJO{PERL_EXECUTABLE_LOCATION}= join("<br>", @INC);
	$MOJO{PERL_COMPILED_VERSION}=    $^O;	
	$MOJO{PERL_VERSION}=             $];	
		
	$MOJO{REAL_USER_ID}=  $REAL_USER_ID;
	$MOJO{REAL_GROUP_ID}= $REAL_GROUP_ID;
	$MOJO{PERL_VERSION }= $PERL_VERSION;
	$MOJO{PROCESS_ID}=    $PROCESS_ID;
	
	
	foreach $key (sort keys %MOJO) {
		$html .= qq|<tr><td width="200" align=left valign="top">$key:</td><td>$MOJO{$key}</td></tr>|;
	}
	&PrintSystem($html);
}
############################################################
#$File::Find::name contains the full path of the file when called by File::Find::find()
sub FindModules{
	use File::Find;
	return unless ($File::Find::name =~ /\.pm$/);
	open(FILE,$File::Find::name) or return;
	while(<FILE>){
		if (/^ *package +(\S+);/){
			push (@mods, $1);
			push (@filepaths, $File::Find::name);
			last;
		}
	}
  close(FILE);
}
############################################################
sub isModInstalled{
	my($module) = @_;
	find(\&FindModules,@INC);
	for (my $i=0; $i < @mods; $i++){	return $filepaths[$i] if ($mods[$i] eq $module);	}
	return 0;
}
############################################################
sub MailProgram{
	return "/usr/lib/sendmail" if (-e "/usr/lib/sendmail");
	return "/usr/bin/sendmail" if (-e "/usr/bin/sendmail");
	return "/usr/sbin/sendmail" if (-e "/usr/sbin/sendmail");
	return "/var/qmail/bin/qmail-inject" if (-e "/var/qmail/bin/qmail-inject");
	return `which sendmail`;
}
################################################################
sub PrintEnv{
	my ($html, $message) = @_;
	&PrintMojoHeader;
	print qq|
<table width="90%" border="1" cellspacing="0" cellpadding="0" align="center" bordercolor="#DDDDDD">
  <tr bgcolor="#EBEBEB"> 
    <td bgcolor="#EBEBEB"> 
      <div align="center"><font color="#FFFFFF" size="5"><b><font color="#5A5D94">Server 
        Variables</font></b></font></div>
    </td>
  </tr>
  <tr> 
    <td>
      <table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#DDDDDD" align="center">
          $html 
      </table>
    </td>
  </tr>
</table>
	|;
	&PrintMojoFooter;
}
################################################################
sub PrintInstalledModules{
	my ($html, $total, $message) = @_;
	&PrintMojoHeader;
	print qq|
<table width="90%" border="1" cellspacing="0" cellpadding="0" align="center" bordercolor="#DDDDDD">
  <tr bgcolor="#EBEBEB"> 
    <td bgcolor="#EBEBEB"> 
      <div align="center"><font color="#FFFFFF" size="5"><b><font color="#5A5D94">Installed 
        Modules ($total)</font></b></font></div>
    </td>
  </tr>
  <tr> 
    <td>
      <table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#DDDDDD" align="center">
          $html 
      </table>
    </td>
  </tr>
</table>
	|;
	&PrintMojoFooter;
}
################################################################
sub PrintSystem{
	my ($html, $message) = @_;
	&PrintMojoHeader;
	print qq|
<table width="90%" border="1" cellspacing="0" cellpadding="0" align="center" bordercolor="#DDDDDD">
  <tr bgcolor="#EBEBEB"> 
    <td bgcolor="#EBEBEB"> 
      <div align="center"><font color="#FFFFFF" size="5"><b><font color="#5A5D94">System 
        Variables</font></b></font></div>
    </td>
  </tr>
  <tr> 
    <td>
      <table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#DDDDDD" align="center">
          $html 
      </table>
    </td>
  </tr>
</table>
	|;
	&PrintMojoFooter;
}
################################################################
sub PrintServerInfo{
	&PrintMojoHeader;
	print qq|
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="82"> 
      <table border="0" width="601" cellspacing="1" cellpadding="4" bgcolor="#6394BD" class="bordercolor" align="center">
        <tr> 
          <td class="titlebg" bgcolor="#EBEBEB" height="6"> &nbsp;<font size=2 class="text1" color="#FFFFFF"><b><font color="#0000FF">Server 
            Information </font></b></font></td>
        </tr>
        <tr> 
          <td class="titlebg" bgcolor="#EEEEEE" height="29"> 
            <div align="center"><b><font color="#FF0000">$message</font></b></div>
          </td>
        </tr>
        <tr> 
          <td class="titlebg" bgcolor="#EEEEEE" height="83" valign="top"> 
            <ol>
              <li><a href="$CONFIG{admin_url}?type=server&class=env">Server Variables</a></li>
              <li><a href="$CONFIG{admin_url}?type=server&class=module">Installed Modules</a></li>
              <li><a href="$CONFIG{admin_url}?type=server&class=file">File Structure</a></li>
              <li><a href="$CONFIG{admin_url}?type=server&class=system">System Variables</a></li>
            </ol>
          </td>
        </tr>
        <tr> 
          <td bgcolor="#EBEBEB" height="2">&nbsp; </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
	|;
	&PrintMojoFooter;
}
################################################################
1;