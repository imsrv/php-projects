#!/usr/bin/perl

$errors="";
$local=0;

use CGI qw(:standard);
use File::Copy;
use DBI;
use File::Find;
use Cwd;

$dir = cwd;
$CGIURL = $ENV{'SCRIPT_NAME'};
$CGIURL =~ m/(.*)\/(.*)/;
$CGIURL = $1;
$CGIURL = "http://$ENV{'HTTP_HOST'}$CGIURL";
$noCGIURL = "http://$ENV{'HTTP_HOST'}";
$nonCGI = "$ENV{'DOCUMENT_ROOT'}";

$step = param('step');
if ($step==0) {
	$step=0;
}

if ($step==0) {

	print "Content-type: text/html\n\n";
	if ($errors ne "") {
		print $errors;
	}
	print <<"EOF";
<H1>thumbBase</H1>
by Chris Palmer, Copyright 2003.
<h4>Use of this script is subject to the conditions here: <a href=\"http://www.adultraffic.com/thumbBase/\" target=\"_blank\">http://www.adultraffic.com/thumbBase/</a></h4>
<form method="POST" action="$ENV{'SCRIPT_NAME'}">
<input type="hidden" name="step" value="1">
<B><font size=4>Required Modules</font></B><BR>
EOF
	;

	print $result = moduleTest("DBI"),"<BR>";
	print $result = moduleTest("Image::Magick"),"<BR>";

	print <<"EOF";
<BR><B><font color=red>NOTE:</font></B> If any modules are missing then you MUST install them before continuing. <a href=\"http://www.adultraffic.com/thumbBase/\" target=\"_blank\">More Info</a>.
<BR>
<BR>
<B><font size=4>Setup Information - dont use trailing slashes</font></B><BR>
<B>:. Paths (all full absolute)</B><BR>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr><td colspan=2><B>This Directory</B></Td></tr>
    <tr> 
      <td>Server Path to this file</td>
      <td><input type="text" name="thisdirectory" value="$dir" size=60></td>
    </tr>
	<tr><td colspan=2><B>Thumbs (nonCGIDirectory) Settings</B></Td></tr>
    <tr> 
      <td>Thumbs Directorys install dir: [<font color=blue>MUST ALREADY EXIST AND BE CHMODDED TO 777</font>]</td>
      <td><input type="text" name="thumbDirectory" value="$nonCGI/thumbs" size=60></td>
    </tr>
    <tr> 
      <td>Thumbs Directorys install URL: </td>
      <td><input type="text" name="thumbDirectoryURL" value="$noCGIURL/thumbs" size=60></td>
    </tr>
	<tr><td colspan=2><B>PHP (phpDirectory) Settings [<font color=blue>MUST ALREADY EXIST AND BE CHMODDED TO 777</font>]</B></Td></tr>
    <tr> 
      <td>PHP install dir: </td>
      <td><input type="text" name="phpDirectory" value="$nonCGI/thumbBase" size=60></td>
    </tr>
    <tr> 
      <td>PHP install URL: </td>
      <td><input type="text" name="phpDirectoryURL" value="$noCGIURL/thumbBase" size=60></td>
    </tr>
    <tr>
      <td><b>:. DB</b></td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td>MySql Host </td>
      <td><input type="text" name="host" value="127.0.0.1" size=20></td>
    </tr>
    <tr> 
      <td>MySql DB </td>
      <td><input type="text" name="db" value="" size=20></td>
    </tr>
    <tr> 
      <td>MySql Username </td>
      <td><input type="text" name="username" value="admin" size=20></td>
    </tr>
    <tr> 
      <td>MySql Password </td>
      <td><input type="text" name="password" value="" size=20></td>
    </tr>
  </table>
  <BR>
<BR>
<input type="submit" value="Continue &gt;">
</form>
EOF
	;
}

if ($step==1) {
	## check that the install directories exist
	print "Content-type: text/html\n\n";
	print <<"EOF";
<HTML>
<H1>Setting up ...</H1>
EOF
	;

	## test the mysql connection
	$where = "DBI:mysql:".param("db").":".param("host"); 
	$connection = DBI->connect($where,param("username"),param("password"));
	if (DBI->errstr() ne "") {
		$error .= "MySql Connection Error: ",DBI->errstr(),"<BR>";
	}

	if ($error ne "") {
		print "<font color=red>$error</font>";
		exit;
	}

	$thisdirectory = param("thisdirectory");
	$thumbDirectory = param("thumbDirectory");
	$thumbDirectoryURL = param("thumbDirectoryURL");
	$phpDirectory = param("phpDirectory");
	$phpDirectoryURL = param("phpDirectoryURL");

	if ("$thisdirectory/update.php" ne "$phpDirectory/update.php") {
		copy("$thisdirectory/update.php","$phpDirectory/update.php") or print "Failed to copy $thisdirectory/update.php -> $phpDirectory/update.php<BR>";
	}
	if ("$thisdirectory/click.php" ne "$phpDirectory/click.php") {
		copy("$thisdirectory/click.php","$phpDirectory/click.php") or print "Failed to copy $thisdirectory/click.php -> $phpDirectory/click.php<BR>";
	}

	&runquery("thumbbase.sql");

	## set most of the settings for ease of use
	$sqlquery = $connection->prepare("UPDATE settings SET thumbsDirectory='$thumbDirectory',thumbsURL='$thumbDirectoryURL',installURL='$phpDirectoryURL',thumbWidth='88',thumbHeight='88',thumbQuality='65' WHERE settingID=1;");
	$sqlquery->execute;
	$sqlquery->finish;

	## update the vars.cgi file to reflect the new db details n shit
	$username = param("username");
	$password = param("password");
	$password =~ s/\@/\\\@/ig;
	$password =~ s/\$/\\\$/ig;
	$username =~ s/\@/\\\@/ig;
	$username =~ s/\$/\\\$/ig;
	$host = param("host");
	$db = param("db");

	open(D,"$thisdirectory/dbdetails.php") or print "failed to open file $thisdirectory/dbdetails.php: $!<BR>";
	@lines = <D>;
	close(D);
	open(OUT,"> $thisdirectory/dbdetails.php") or print "failed to Write file $thisdirectory/dbdetails.php: $!<BR>";
	foreach (@lines) {
		chomp $_;
		$_ =~ s/USERNAME/$username/g;
		$_ =~ s/PASSWORD/$password/g;
		$_ =~ s/HOST/$host/g;
		$_ =~ s/DB/$db/g;
		$_ =~ s/PERLPATH/$pathToPerl/g;
		print OUT "$_\n";
	}					   
	close(OUT);
	chmod(0777,"$thisdirectory/dbdetails.php");

	open(D,"$thisdirectory/admin/admin.cgi");
	@lines = <D>;
	close(D);
	open(OUT,"> $thisdirectory/admin/admin.cgi"); 
	foreach (@lines) {
		chomp $_;
		$_ =~ s/DBDETAILS/$thisdirectory\/dbdetails.php/g;
		print OUT "$_\n";
	}					   
	close(OUT);

	open(D,"$thisdirectory/admin/getthumb.cgi");
	@lines = <D>;
	close(D);
	open(OUT,"> $thisdirectory/admin/getthumb.cgi"); 
	foreach (@lines) {
		chomp $_;
		$_ =~ s/DBDETAILS/$thisdirectory\/dbdetails.php/g;
		print OUT "$_\n";
	}					   
	close(OUT);

	open(D,"$phpDirectory/update.php");
	@lines = <D>;
	close(D);
	open(OUT,"> $phpDirectory/update.php") or print "Failed to Write $phpDirectory/update.php<BR>"; 
	foreach (@lines) {
		chomp $_;
		$_ =~ s/DBDETAILS/$thisdirectory\/dbdetails.php/g;
		print OUT "$_\n";
	}					   
	close(OUT);

	## chmod stuff
	chmod(0777,"$thisdirectory/uploads")		or print "failed to chmod $thisdirectory/uploads, You need to chmod it to 777 [$!]<BR>";
	chmod(0777,"$thisdirectory/backup")			or print "failed to chmod $thisdirectory/backup, You need to chmod it to 777 [$!]<BR>";
	chmod(0755,"$thisdirectory/admin")			or print "failed to chmod $thisdirectory/admin, You need to chmod it to 755 [$!]<BR>";
	chmod(0755,"$thisdirectory/admin/admin.cgi")		or print "failed to chmod $thisdirectory/admin.cgi, You need to chmod it to 755 [$!]<BR>";
	chmod(0755,"$thisdirectory/admin/frame.cgi")		or print "failed to chmod $thisdirectory/frame.cgi, You need to chmod it to 755 [$!]<BR>";
	chmod(0755,"$thisdirectory/admin/showadmin.cgi")	or print "failed to chmod $thisdirectory/showadmin.cgi, You need to chmod it to 755 [$!]<BR>";
	chmod(0755,"$thisdirectory/admin/topframe.cgi")	or print "failed to chmod $thisdirectory/topframe.cgi, You need to chmod it to 755 [$!]<BR>";
	chmod(0755,"$thisdirectory/admin/getthumb.cgi")	or print "failed to chmod $thisdirectory/getthumb.cgi, You need to chmod it to 755 [$!]<BR>";
	chmod(0755,"$thisdirectory/admin/admin.htm")		or print "failed to chmod $thisdirectory/admin.htm, You need to chmod it to 755 [$!]<BR>";
	chmod(0755,"$thisdirectory/admin/frame.htm")		or print "failed to chmod $thisdirectory/frame.htm, You need to chmod it to 755 [$!]<BR>";
	chmod(0755,"$thisdirectory/admin/topframe.htm")	or print "failed to chmod $thisdirectory/topframe.htm, You need to chmod it to 755 [$!]<BR>";

	chmod(0777,"$thumbDirectory")				or print "failed to chmod $thumbDirectory, You need to chmod it to 777 [$!]<BR>";

	chmod(0755,"$phpDirectory/click.php")		or print "failed to chmod $phpDirectory/click.php, You need to chmod it to 755<BR>";
	chmod(0755,"$phpDirectory/update.php")		or print "failed to chmod $phpDirectory/update.php, You need to chmod it to 755<BR>";

	print "<BR><BR><B>Finished.</B><BR>";
	print <<"EOF";
<B>:. Admin Area:</B><BR><a href="$CGIURL/admin/showadmin.cgi" target="_blank">$CGIURL/admin/showadmin.cgi</a><BR>
&nbsp;&nbsp;&nbsp;- You'll need to change the settings in the Admin to reflect where your template and output files are.<BR>
&nbsp;&nbsp;&nbsp;- And put some galleries in too of course :)
<BR>
<BR>
<B>:. Update Script is here:</B><BR><a href="$phpDirectoryURL/update.php" target="_blank">$phpDirectoryURL/update.php</a><BR>
EOF
	;
}

sub fieldnames
{
	my $sqlquery =shift;
	@fields = @{$sqlquery->{NAME}};
	return @fields;
}

sub runquery
{
	($file) = shift;
	open(D,$file);
	while (<D>) {
		chomp $_;
		$lines .= $_;
	}
	close(D);
	@statements = split(';',$lines);
	$line=0;
	foreach (@statements) {
		$line++;
		$sql = "$_;";
		$sqlquery = $connection->prepare($sql);
		$sqlquery->execute;
		if (DBI->errstr()) {
			print "<BR><BR><font color=red><B>MYSQL ERROR:</B></font> Query Failed.",DBI->errstr(),"  [$file:$line] ($sql)<BR>";
		}
	}
}

sub copydir
{
	($from,$to) = (@_);
	if (!(-d $to)) {
		mkdir($to,0777) or print "failed to make directory: $to<BR>";
	}
	sub process_file {
		$file = $File::Find::name;
		$file =~ m/(.*)\/(.*)/;
		$dir = $1;
		$filename= $2;
		
		$newfilename = substr($file,length($from)+1,length($file));
		if ($newfilename =~ /\//) {
			$directory   = substr($newfilename,0,(length($newfilename)-length($filename))-1);
			if ($directory ne "") {
				if (!-d "$to/$directory") {
					mkdir("$to/$directory",0777) or print "failed: $!<BR>";
					print "making NEW directory [$to/$directory]<BR>";
				}
			}
		}
		return if (-d "$thisdirectory/$file");
		copy("$thisdirectory/$file","$to/$newfilename");
		if (($from !~ /scripts/) && ( ($newfilename =~ /\.cgi$/) || ($newfilename =~ /\.php$/)) ) {
			chmod(0755,"$to/$newfilename");
		} else {
			chmod(0777,"$to/$newfilename");
		}

		## check that this file copied properly
		if ($newfilename ne "") {
			print "Verifying $to/$newfilename: ";
			if (-e "$to/$newfilename") {
				print "<font color=green>File Written</font><BR>";
			} else {
				print "<font color=red>File NOT Written</font><BR>";
			}
		}
	};
	find(\&process_file,"$from");
}

sub chmoddir
{
	($from,$chmod) = (@_);
	$thisdir = $from;
	$thisdir =~ m/(.*)\/(.*)/;
	$thisdir = $2;
	sub process_file2 {
		$file = $File::Find::name;
		$file =~ m/(.*)\/(.*)/;
		$dir = $1;
		$filename= $2;		
		$newfilename = substr($file,length($from)+1,length($file));
		next if (-d $file);
		if ($newfilename =~ /\//) {
			$directory   = substr($newfilename,0,(length($newfilename)-length($filename))-1);
			if ($thisdir ne $directory) {
				next;
			}
		}
		chmod($chmod,$file) or print "Permissions Failed: $!<BR>";
		print "Permissions Changed to $chmod for $file<BR>";
	};
	find(\&process_file2,"$from");
}

sub moduleTest
{
    my $module = shift;
    eval("use $module;");    
    return failed($module) if( $@ );
    return passed($module);
}

sub failed 
{
	my $module = shift;
	return "<font color=red>Module $module Not Available</font>";
}

sub passed 
{
	my $module = shift;
	return "<font color=green>Module $module Available</font>";
}
