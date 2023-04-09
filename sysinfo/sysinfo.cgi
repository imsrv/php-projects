#!/usr/bin/perl
use CGI::Carp qw(fatalsToBrowser);
use Socket;
use Config;

# Setup - Begin
$passwort = "test"; # Ihr Passwort eingeben!
$free = "50"; # In MB Angeben wieviel Webspace sie haben!
$gzip = "0"; # GZIP Komprimierung - Um den Inhalt schneller und platzsparender zu Übertragen! - 0 = Aus - 1 = An
# Setup - End

##############################################################################################################
# Nutzungsbedingungen (Sysinfo): Lizenz: Stand: 3.09.2001
#
# Durch Download der Software erklären Sie sich mit diesen Lizenzabkommen einverstanden. 
# Der Sysinfo ist Freeware, jedoch nicht zum GNU/GPL - Abkommen zuzuordnen. 
# Diese Lizenz erlaubt es Ihnen, Sysinfo zu benutzen. 
# Als Nutzer des Sysinfo können Sie auf eigenes Risiko die Software verändern und/oder auf Ihre Bedürfnisse anpassen. 
# Sie können auch Dritte mit der Anpassung/Veränderung beauftragen. 
# Die Original-Software unverändert darf weitergegeben werden jedoch nicht verkauft oder wiederverkauft werden.
#
# Die angepasste/veränderte Software und Teile dieser dürfen nicht weitergegeben, verkauft oder wiederverkauft werden.
#
# Alle Copyright- und Versions-Hinweise, die im Sysinfo oder deren HTML-Seiten verwendet, erstellt und/oder gezeigt 
# werden, dürfen nicht entfernt werden. Die Copyright- und Versions-Hinweise müssen für Benutzer sichtbar und in 
# ungeänderter Form dargestellt werden.
#
# Dieses Lizenzabkommen beruht sich auf der aktuellen internationalen Gesetzeslage.
#
# Bei einem Verstoß gegen diesen Lizenzvertrag kann durch die Firma Coder-World oder deren Beauftragten die erworbene Lizenz 
# jederzeit zurückgezogen und für nichtig erklärt werden sowie die Benutzung untersagt werden. 
# Sysinfo und die dazugehörenden Dateien werden ohne Funktionsgarantie für die im Umfeld verwendete Hardware 
# oder Software verkauft.
#
# Coder-World oder deren Beauftragten sind in keiner Form für Inhalte oder Verfasser verantwortlich, die durch diese 
# Software erstellt wurden.
#
# Das Risiko der Benutzung vom Sysinfo obliegt dem Lizenznehmer, jegliche Erstattungen im Rechtsfall sind ausgeschlossen. 
# Eine Lizenz ist zeitlich unbegrenzt nutzbar, in der Lizenz ist grundsätzlich der Zugriff auf alle neuen Versionen für 
# einen unbegrenzten Zeitraum enthalten.
#
# Hinweis: Es existieren keine Reseller-, Wiederverkaufs- oder Schüler-/Studenten - Versionen. Nach den Lizenzbedingungen muß der Website-Besitzer die Lizenz selbst erhalten.  
#
# Verfasser: Stefan Gipper (Stefanos)
# E-Mail: support@coder-world.de
# Webseite: http://www.coder-world.de
#
# Bei Veröffentlichung dieses Dokuments ist es eine feine Geste, mir eine Nachricht zukommen zu lassen.
##############################################################################################################
$version = "1.39";

BEGIN {
	eval { $died_in_eval = 1; require DBI; };
	if(!$@){
		$mod_dbi = 1;
		import DBI;
	}
	if ($^O =~ /win/i){
		eval { $died_in_eval = 1; require Win32::Registry; };
		if(!$@){
			$mod_w32r = 1;
			import Win32::Registry;
		}
		eval { $died_in_eval = 1; require Win32::API; };
		if(!$@){
			$mod_w32s = 1;
			import Win32::API;
		}
		eval { $died_in_eval = 1; require Win32::Process::Info; };
		if(!$@){
			$mod_w32i = 1;
			import Win32::Process::Info;
		}
		eval { $died_in_eval = 1; require Win32::Process; };
		if(!$@){
			$mod_w32p = 1;
			import Win32::Process;
		}
		eval { $died_in_eval = 1; require Win32; };
		if(!$@){
			$mod_w32 = 1;
			import Win32;
		}
	}
	eval { $died_in_eval = 1; require Compress::Zlib; };
	if(!$@) {
		$zlib = 1;
		import Compress::Zlib;
	}
	eval { $died_in_eval = 1; require File::Find; };
	if(!$@){
		$mod_file = 1;
		import File::Find;
	}
}

if ($^O !~ /win/i) {
	$ENV{PWD} = `pwd`;
	$flock = 1;
}else{
	$ENV{PWD} = `cd`;
	$flock = 0;
}

read(STDIN,$input,$ENV{'CONTENT_LENGTH'});
foreach (split(/&/,$input)) {
	($name,$value) = split(/=/,$_);
	$name =~ tr/+/ /;
	$name =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
	$value =~ tr/+/ /;
	$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
	$FORM{$name} = $value;
}
foreach (split(/&/,$ENV{'QUERY_STRING'})){
	($v,$i) = split(/=/,$_);
	$v =~ tr/+/ /;
	$v =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
	$i =~ tr/+/ /;
	$i =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
	$i =~ s/<!--(.|\n)*-->//g;
	$INFO{$v} = $i;
}
$action = $INFO{'action'} || $FORM{'action'};

@timestamp = localtime(time);
$timestamp[5] += 1900;
$timestamp[4]++;
$timestamp[1] = "0$timestamp[1]" if($timestamp[1] < 10);
$timestamp[2] = "0$timestamp[2]" if($timestamp[2] < 10);
$timestamp[3] = "0$timestamp[3]" if($timestamp[3] < 10);
$timestamp[4] = "0$timestamp[4]" if($timestamp[4] < 10);
$date = "$timestamp[3].$timestamp[4].$timestamp[5] - $timestamp[2]:$timestamp[1]";
if($action eq "index"){&$action;}
elsif($action =~ /system/){&$action;}
elsif($action =~ /debugger/){&$action;}
elsif($action =~ /logfiles/){&$action;}
elsif($action =~ /dead/){&$action;}
elsif($action =~ /error/){&$action;}
elsif($action =~ /webspace/){&$action;}
&index;

sub error {
	open(F,"<templates/$INFO{'error'}.html");
	$i = join("",<F>);
	close(F);
	$host = $ENV{'HTTP_HOST'};
	unless($host){$host = "Die Internet-Adresse wurde eingegeben.";}
	$i =~ s/<_host>/$host/g;
	$i =~ s/<_referer>/$ENV{'HTTP_REFERER'}/g;
	$i =~ s/<_admin-email>/$ENV{'SERVER_ADMIN'}/g;
	$i =~ s/<_url>/$ENV{'REQUEST_URI'}/g;
	$i =~ s/<_date>/$date/g;
	$i =~ s/<_error>/$INFO{'error'}/g;

	print "Content-Type: text/html\n\n";
	print $i;
	exit(0);
}

sub index {
	($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime;
	$stunde = $hour+1;
	$stunde = 0 if($stunde == 24);
	$beats = (($stunde * 60 * 60) + ($min * 60) + $sec) / 86.4;
	$beats = int($beats);
	$ltime = localtime;
	$gtime = gmtime;

	if ($^O !~ /win/i) {
		foreach ("/bin/sendmail","/sbin/sendmail","/usr/lib/sendmail","/usr/bin/sendmail","/usr/share/sendmail","/usr/sbin/sendmail","/usr/bin/sendmail.restart","/etc/sendmail.cf","/etc/sendmail.cw","/usr/man/man8/sendmail.8","/var/qmail/bin/qmail-inject"){
			if(-e $_ && -X _){
				$sm .= "$_<br>";
			}
		}

		foreach ("perl","grep","date","whois","tar","gzip","gunzip","ping","nslookup","finger","dnsquery","pgp","gpg","fly","convert","compress","traceroute"){
			$info{$_} = `which $_` || `whereis $_`;
			$info{$_} =~ s/^$_:\s*//g;
			$info{$_} = "<small>nicht installiert</small>" unless($info{$_});
		}
		$kernel = `uname -r`;
		$hostuname = `uname -n`;
		$gethost  = gethostent();

		if($^O =~ /OpenBSD/i){
			$sysname = `hostname -s`;
		}elsif($^O =~ /linux/i){
			$sysname = `hostname -f`;
		}else{
			$sysname = `hostname`;
		}
		$httpd = `httpd -l`;
		if($httpd){
			$httpd =~ s/\r//g;
			$httpd =~ s/^Compiled-in modules:\n//sg;
			$httpd =~ s/\n(.+?)\n/,$1<br>/sg;
		}else{
			$httpd = "<small>nicht gefunden</small>";
		}

		$userid = `id`; # "whoami" oder "id -un" für Username
		$userid =~ s/ /<br>/g;
		$load = `uptime`;
		if($load =~ /^.*?(\d+?) users?.*?$/){
			$useron = $1;
		}else{
			$useron = "?";
		}

		if($load =~ m/^.*?up +(\d+?) days?, +(\d+:\d+).+?/){
  			$updays = $1;
			$uptime = $2;
			($upstd, $upmin) = split(/:/,$uptime,2);
		}elsif($load =~ m/^.*?up +(\d+:\d+).+?/){
			$updays = "0";
  			$uptime = $1;
			($upstd,$upmin) = split(':',$uptime,2);
		}else{
			$updays = "?";
			$upstd = "?";
			$upmin = "?";
		}
		if($load =~ s/^.+?average: +?(\S*? \S*? \S*?)$/$1$2,$3/){
  			($load1, $load5, $load15) = split(',',$load,4);
		}else{
			$load1 = "<small>nicht gefunden</small>";
			$load5 = "<small>nicht gefunden</small>";
			$load15 = "<small>nicht gefunden</small>";
		}

		if(-e("/opt/lib/apache/mod_env.so")){
			$apachelib = "/opt/lib/apache";
		}elsif(-e("/System/Library/Apache/Modules/mod_env.so")){
			$apachelib = "/System/Library/Apache/Modules";
		}elsif(-e("/usr/local/apache/modules/mod_env.so")){
			$apachelib = "/usr/local/apache/modules";
		}elsif(-e("/usr/lib/apache/modules/mod_env.so")){
			$apachelib = "/usr/lib/apache/modules";
		}elsif(-e("/usr/lib/apache/mod_env.so")){
			$apachelib = "/usr/lib/apache";
		}else{
			$apachelib = "<small>nicht gefunden</small>";
		}

		if($apachelib){
			@standard = ("mod_rewrite.so","mod_cgi.so","mod_env.so","mod_imap.so","mod_include.so","libperl.so","mod_alias.so","mod_access.so","mod_browser.so","mod_python.so","mod_unique_id.so");
			@auth	= ("mod_auth.so","mod_digest.so","mod_auth_anon.so","mod_auth_db.so","mod_auth_dbm.so","mod_auth_cookie.so","mod_auth_digest.so","mod_auth_mysql.so");
			@ext	= ("mod_expires.so","mod_fastcgi.so","mod_gzip.so","mod_headers.so","libphp3.so","libphp4.so","mod_proxy.so","mod_speling.so","mod_status.so',  'mod_usertrack.so","mod_vhost_alias.so");

			foreach (@standard){
				if(-e("$apachelib/$_")){
					$output .= "Module '$_' installed<br>\n";
				}
			}
			$output .= "<br>\n";

			foreach (@auth){
				if(-e("$apachelib/$_")){
					$output .= "Module '$_' installed<br>\n";
				}
			}
			$output .= "<br>\n";

			foreach (@ext){
				if(-e("$apachelib/$_")){
					$output .= "Module '$_' installed<br>\n";
				}
			}
			$output .= "<br>\n";
		}
	}else{
		if($mod_w32){
			$ticks = Win32::GetTickCount();
			$updays = int($ticks/86400000);
			$upstd  = int(($ticks = ($ticks - $updays*86400000)) /3600000);
			$upmin  = int(($ticks = ($ticks - $upstd*3600000)) /60000);
		}
	}

	if(-e("/etc/mime.types")){
		$mimes = "/etc/mime.types";
	}elsif(-e("/usr/etc/mime.types")){
		$mimes = "/usr/etc/mime.types";
	}else{
		$mimes = "/etc/httpd/conf/apache-mime.types";
	}

	if ( ($^O !~ /win/i) && (-e "$mimes") ) {
		open(F, "<$mimes");
		@mime = <F>;
		close(F);
		$zahl = (scalar(@mime)) / 3;

		foreach (@mime){
			if($_ !~ /\#/){
				$umbruch++;
				@mimeX = split(" " , $_);
		
				$wert1 = shift @mimeX;
				$wert2 = shift @mimeX;
				$rownspan = 1;
				$mime_ausgabe2 = "";
				foreach $lines (@mimeX){
					$mime_ausgabe2 .= qq~<tr><td bgcolor="#eeeeee"><font face="Arial,Verdana" size="2">$lines</font></td></tr>~;
					$rownspan++;
				}
		
				if($mime_ausgabe2 ne ""){
					$spawn = "rowspan=" . $rownspan;
					$more = $mime_ausgabe2;
				}

				if($zahl > $umbruch){
					$m_au .= qq~<tr><td bgcolor="#ddddFF" $spawn valign="top"><font face="Arial,Verdana" size="2">$wert1</font></td><td bgcolor="#eeeeee"><font face="Arial,Verdana" size="2">$wert2</font></td></tr>$more\n~;
				}elsif(($zahl * 2) > $umbruch){
					$m__au .= qq~<tr><td bgcolor="#ddddFF" $spawn valign="top"><font face="Arial,Verdana" size="2">$wert1</font></td><td bgcolor="#eeeeee"><font face="Arial,Verdana" size="2">$wert2</font></td></tr>$more\n~;
				}else{
					$m___au .= qq~<tr><td bgcolor="#ddddFF" $spawn valign="top"><font face="Arial,Verdana" size="2">$wert1</font></td><td bgcolor="#eeeeee"><font face="Arial,Verdana" size="2">$wert2</font></td></tr>$more\n~;
				}
			}
		}
	}
	$ENV{'REMOTE_HOST'} = gethostbyaddr(inet_aton($ENV{'REMOTE_ADDR'}), AF_INET);

	foreach (sort keys %ENV) {
		$ENV{$_} =~ s/\\/\//g;
		if($_ eq "DOCUMENT_ROOT" || $_ eq "PWD" || $_ eq "SCRIPT_FILENAME"){
			$w = "<b>$_</b>";
		}elsif($_ eq "PATH"){
			$w = $_;
			$ENV{$_} =~ s/\:/<br>/g;
		}elsif($_ eq "HTTP_ACCEPT"){
			$w = $_;
			$ENV{$_} =~ s/\,/<br>/g;
		}elsif($_ eq "HTTP_COOKIE"){
			$w = $_;
			foreach $s (split(/; /,$ENV{$_})){
				$s =~ s/(.{110})/$1<br>\n/;
				$http_cookie .= $s . "; ";
			}
			$ENV{'HTTP_COOKIE'} = $http_cookie;
		}else{
			$w = $_;
		}

		$env_a .= qq~<tr><td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2">$w</font></td><td bgcolor="#eeeeee"><font face="Arial,Verdana" size="2">$ENV{$_}</font></td></tr>~;
	}

	foreach $l (sort keys %SIG) {
		$sig_a .= qq~<tr><td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2">$l</font></td><td bgcolor="#eeeeee"><font face="Arial,Verdana" size="2">$SIG{$l}</font></td></tr>~;
	}

	foreach (sort { lc($a) cmp lc($b)} @INC){
		chomp;
		$mv .= $_ . "<br>";
	}

	if($mod_file){
		find(\&module, @INC);
		@keys = grep(!/^MyHandlers$|^MyPackage$|^IDEA$|^Image::TIFF$|^TiffFile$|^main$|^MySubDBI::st$|^BufferWithInt$|^Cinna$|^Critter::Sounds$|^Mail::Mailer::smtp::pipe$|^My::PingPong$|^Foo$|^Web::Server$|^pdflib_pl$|^\$|^.$/,sort { lc($a) cmp lc($b)} keys %modTab);
		$nbCols = (scalar(@keys)) / 3;
		foreach (@keys) {
			$cpt++;
			$modTab{$_} = "?" unless defined $modTab{$_};
			if ($cpt <= $nbCols){
				$m_a .= qq~<tr><td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2"><a href="sysinfo.cgi?action=systemdoc&name=$_" target="_blank">$_</a></font></td><td bgcolor="#eeeeee"><font face="Arial,Verdana" size="2">~;
				if($modFile{$_} =~ /\.pm$/){
					$m_a .= qq~<a href="#$modFile{$_}">$modTab{$_}</a>~
				}else{
					$m_a .= qq~$modTab{$_}~;
				}
				$m_a .= qq~</font></td></tr>~;
			}elsif($cpt <= ($nbCols * 2)){
				$m__a .= qq~<tr><td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2"><a href="sysinfo.cgi?action=systemdoc&name=$_" target="_blank">$_</a></font></td><td bgcolor="#eeeeee"><font face="Arial,Verdana" size="2">~;
				if($modFile{$_} =~ /\.pm$/){
					$m__a .= qq~<a href="#$modFile{$_}">$modTab{$_}</a>~
				}else{
					$m__a .= qq~$modTab{$_}~;
				}
				$m__a .= qq~</font></td></tr>~;
			}else{
				$m___a .= qq~<tr><td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2"><a href="sysinfo.cgi?action=systemdoc&name=$_" target="_blank">$_</a></font></td><td bgcolor="#eeeeee"><font face="Arial,Verdana" size="2">~;
				if($modFile{$_} =~ /\.pm$/){
					$m___a .= qq~<a href="#$modFile{$_}">$modTab{$_}</a>~;
				}else{
					$m___a .= qq~$modTab{$_}~;
				}
				$m___a .= qq~</font></td></tr>~;
			}
			$modulzahl++;
		}
	}

	if ($mod_dbi == 0) {
		$dbi_drivers[0] = 'DBI Modul nicht instaliert';
		$dsn_names{$dbi_drivers[0]}->[0] = 'Keine';
	}else{
		@dbi_drivers = DBI->available_drivers;
		for ($i = 0; $i < scalar @dbi_drivers; $i++) {
			@dsns = ();
			$died_in_eval = 1;
			eval { @dsns = DBI->data_sources($dbi_drivers[$i]); };
			$died_in_eval = 0;
			if ($@) {$dsn_names{$dbi_drivers[$i]}->[0] = "Nicht korrekt konfiguriert: $@";}else{
				if (scalar @dsns) {for ($x = 0; $x < scalar @dsns; $x++) {$dsn_names{$dbi_drivers[$i]}->[$x] = $dsns[$x];}}else{$dsn_names{$dbi_drivers[$i]}->[0] = 'Keine';}
			}
		}

		if (scalar @dbi_drivers > 0) {
			foreach $dbdname (sort { lc($a) cmp lc($b)} @dbi_drivers) {
				$db_a .= qq~<tr><td bgcolor=\"#ddddFF\" valign=\"top\"><font face=\"Arial,Verdana\">$dbdname</font></td><td bgcolor=\"#eeeeee\">~;
				foreach $dsn (sort @{$dsn_names{$dbdname}}) {
					$db_a .= "<font face=\"Arial,Verdana\">$dsn</font><br>\n";
				}
				$db_a .= "</td></tr>";
			}
		}
	}

	if($mod_w32 == 1 && $^O =~ /win/i){
		@os = Win32::GetOSVersion;
		$ver = "(Version: $os[1]\.$os[2] Build $os[3])";
	}else{
		if(-e("/proc/version")){
			open (F,"/proc/version");
			$data = (<F>)[0];
			close (F);

			$kernel = (split(/\ /,$data))[2];
			$kernel .= " (SMP)" if($data =~ /smp/);
		}
		$kernel = "Unbekannt" unless($kernel);

		if(-e("/etc/SuSE-release")){
			open(F,"/etc/SuSE-release");
			$kernel .= ", " . (<F>)[0];
			close(F);
		}elsif(-e("/etc/mandrake-release")){
			open(F,"/etc/mandrake-release");
			$kernel .= ", " . (<F>)[0];
			close(F);
		}elsif(-e("/etc/redhat-release")){
			open(F,"/etc/redhat-release");
			$kernel .= ", " . (<F>)[0];
			close(F);
		}elsif(-e("/etc/debian_version")){
			open(F,"/etc/debian_version");
			$kernel .= ", Debian " . (<F>)[0];
			close(F);
		}
		$ver = "(Kernel: $kernel)";
	}

	if(-e("/proc/sys/kernel/hostname")){
		open(F,"/proc/sys/kernel/hostname");
		$h_a = (<F>)[0];
		close(F);
	}
	$sysname .= ", $hostuname" if($sysname ne $hostuname);
	$sysname .= ", $h_a" if($sysname ne $h_a);

	$hostip = gethostbyaddr(inet_aton($ENV{'SERVER_ADDR'}), AF_INET) . "<br>($gethost, $sysname, $ENV{'HTTP_HOST'})";
	$hostip =~ s/[\n\r]//g;

	$liblist = $Config{"libs"}." ".$Config{"perllibs"};
	foreach (split / /,$liblist){$lib .= $_.' '};

	if(-e("/proc/stat")){
		open(F,"</proc/stat");
		$temp = <F>;
		close(F);

		($name,$user,$wert,$system,$idle) = split(/\s+/,$temp);
		$usage = $user + $wert + $system;
		$total = $user + $wert + $system + $idle;

		sleep(1);

		open(F,"</proc/stat");
		$temp = <F>;
		close(F);

		($newName, $newUser, $newWert, $newSystem, $newIdle) = split(/\s+/,$temp);
		$newUsage = $newUser + $newWert + $newSystem;
		$newTotal = $newUser + $newWert + $newSystem + $newIdle;

		$xUsage = $newUsage - $usage;
		$xTotal = $newTotal - $total;

		if($xTotal > 1 or $xUsage > 1){
			$cpulast = sprintf("%.1f", (($xUsage / $xTotal) * 100));
		}
	}else{
		$cpulast = "??.?";
	}

$ausgabe =qq~
<table cellpadding="3" cellspacing="1" border="0" width="65%">
<tr>
	<td bgcolor="#bcbcEE" colspan="2"><font face="Arial,Verdana" size="3"><b>Server - Infos:</b></font></td>
</tr>
<tr>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2">Betriebssystem:</font></td>
	<td bgcolor="#eeeeee"><font face="Arial,Verdana" size="2">$^O $ver</font></td>
</tr>
<tr>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2">Perl Version:</font></td>
	<td bgcolor="#eeeeee"><font face="Arial,Verdana" size="2">$]</font></td>
</tr>
<tr>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2">Hostname:</font></td>
	<td bgcolor="#eeeeee"><font face="Arial,Verdana" size="2">$hostip</font></td>
</tr>
<tr>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2">IP Adresse:</font></td>
	<td bgcolor="#eeeeee"><font face="Arial,Verdana" size="2">$ENV{'SERVER_ADDR'}</font></td>
</tr>
<tr>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2">IDs:</font></td>
	<td bgcolor="#eeeeee"><font face="Arial,Verdana" size="2">$userid</font></td>
</tr>
<tr>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2">Internet-Zeit:</font></td>
	<td bgcolor="#eeeeee"><font face="Arial,Verdana" size="2">\@$beats</font></td>
</tr>
<tr>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2">Lokale Uhrzeit:</font></td>
	<td bgcolor="#eeeeee"><font face="Arial,Verdana" size="2">$ltime</font></td>
</tr>
<tr>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2">GMT Uhrzeit:</font></td>
	<td bgcolor="#eeeeee"><font face="Arial,Verdana" size="2">$gtime</font></td>
</tr>
<tr>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2">Perl zuletzt ge&auml;ndert:</font></td>
	<td bgcolor="#eeeeee"><font face="Arial,Verdana" size="2">$Config{"cf_time"}</font></td>
</tr>
<tr>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2">Server aktiv seit:</font></td>
	<td bgcolor="#eeeeee"><font face="Arial,Verdana" size="2">$updays Tage, $upstd Stunden, $upmin Minuten</font></td>
</tr>
<tr>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2">Eingeloggte User:</font></td>
	<td bgcolor="#eeeeee"><font face="Arial,Verdana" size="2">$useron</font></td>
</tr>
<tr>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2">CPU Auslastung:</font></td>
	<td bgcolor="#eeeeee"><font face="Arial,Verdana" size="2">$cpulast\%</font></td>
</tr>
<tr>
	<td bgcolor="#ddddFF" colspan="2"><font face="Arial,Verdana" size="2"><b>Durchschnittliche Serverlast vor:</b></font></td>
</tr>
<tr>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2">01 Minuten:</font></td>
	<td bgcolor="#eeeeee"><font face="Arial,Verdana" size="2">$load1</font></td>
</tr>
<tr>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2">05 Minuten:</font></td>
	<td bgcolor="#eeeeee"><font face="Arial,Verdana" size="2">$load5</font></td>
</tr>
<tr>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2">15 Minuten:</font></td>
	<td bgcolor="#eeeeee"><font face="Arial,Verdana" size="2">$load15</font></td>
</tr>
</table>

<br><br>

<table cellpadding="3" cellspacing="1" border="0" width="65%">
<tr>
	<td bgcolor="#bcbcEE" colspan="2"><font face="Arial,Verdana" size="3"><b>Allgemeine Pfade:</b></font></td>
</tr>
<tr>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2">Pfad zu Perl:</font></td>
	<td bgcolor="#eeeeee"><font face="Arial,Verdana" size="2"><a href="sysinfo.cgi?action=systeminf&name=perl" target="_blank"><font color="black">$info{'perl'}</font></a></font></td>
</tr>
<tr>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2">Grep:</font></td>
	<td bgcolor="#eeeeee"><font face="Arial,Verdana" size="2"><a href="sysinfo.cgi?action=systeminf&name=grep" target="_blank"><font color="black">$info{'grep'}</font></a></font></td>
</tr>
<tr>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2">Date:</font></td>
	<td bgcolor="#eeeeee"><font face="Arial,Verdana" size="2"><a href="sysinfo.cgi?action=systeminf&name=date" target="_blank"><font color="black">$info{'date'}</font></a></font></td>
</tr>
<tr>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2">Whois:</font></td>
	<td bgcolor="#eeeeee"><font face="Arial,Verdana" size="2"><a href="sysinfo.cgi?action=systeminf&name=whois" target="_blank"><font color="black">$info{'whois'}</font></a></font></td>
</tr>
<tr>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2">Ping:</font></td>
	<td bgcolor="#eeeeee"><font face="Arial,Verdana" size="2"><a href="sysinfo.cgi?action=systeminf&name=ping" target="_blank"><font color="black">$info{'ping'}</font></a></font></td>
</tr>
<tr>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2">Nslookup:</font></td>
	<td bgcolor="#eeeeee"><font face="Arial,Verdana" size="2"><a href="sysinfo.cgi?action=systeminf&name=nslookup" target="_blank"><font color="black">$info{'nslookup'}</font></a></font></td>
</tr>
<tr>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2">Finger:</font></td>
	<td bgcolor="#eeeeee"><font face="Arial,Verdana" size="2"><a href="sysinfo.cgi?action=systeminf&name=finger" target="_blank"><font color="black">$info{'finger'}</font></a></font></td>
</tr>
<tr>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2">Dnsquery:</font></td>
	<td bgcolor="#eeeeee"><font face="Arial,Verdana" size="2"><a href="sysinfo.cgi?action=systeminf&name=dnsquery" target="_blank"><font color="black">$info{'dnsquery'}</font></a></font></td>
</tr>
<tr>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2">Traceroute:</font></td>
	<td bgcolor="#eeeeee"><font face="Arial,Verdana" size="2"><a href="sysinfo.cgi?action=systeminf&name=traceroute" target="_blank"><font color="black">$info{'traceroute'}</font></a></font></td>
</tr>
<tr>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2">Tar:</font></td>
	<td bgcolor="#eeeeee"><font face="Arial,Verdana" size="2"><a href="sysinfo.cgi?action=systeminf&name=tar" target="_blank"><font color="black">$info{'tar'}</font></a></font></td>
</tr>
<tr>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2">Gzip:</font></td>
	<td bgcolor="#eeeeee"><font face="Arial,Verdana" size="2"><a href="sysinfo.cgi?action=systeminf&name=gzip" target="_blank"><font color="black">$info{'gzip'}</font></a></font></td>
</tr>
<tr>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2">Compress:</font></td>
	<td bgcolor="#eeeeee"><font face="Arial,Verdana" size="2"><a href="sysinfo.cgi?action=systeminf&name=compress" target="_blank"><font color="black">$info{'compress'}</font></a></font></td>
</tr>
<tr>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2">Gunzip:</font></td>
	<td bgcolor="#eeeeee"><font face="Arial,Verdana" size="2"><a href="sysinfo.cgi?action=systeminf&name=gunzip" target="_blank"><font color="black">$info{'gunzip'}</font></a></font></td>
</tr>
<tr>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2">PGP:</font></td>
	<td bgcolor="#eeeeee"><font face="Arial,Verdana" size="2"><a href="sysinfo.cgi?action=systeminf&name=pgp" target="_blank"><font color="black">$info{'pgp'}</font></a></font></td>
</tr>
<tr>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2">GPG:</font></td>
	<td bgcolor="#eeeeee"><font face="Arial,Verdana" size="2"><a href="sysinfo.cgi?action=systeminf&name=gpg" target="_blank"><font color="black">$info{'gpg'}</font></a></font></td>
</tr>
<tr>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2">Fly:</font></td>
	<td bgcolor="#eeeeee"><font face="Arial,Verdana" size="2"><a href="sysinfo.cgi?action=systeminf&name=fly" target="_blank"><font color="black">$info{'fly'}</font></a></font></td>
</tr>
<tr>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2">ImageMagick convert:</font></td>
	<td bgcolor="#eeeeee"><font face="Arial,Verdana" size="2"><a href="sysinfo.cgi?action=systeminf&name=convert" target="_blank"><font color="black">$info{'convert'}</font></a></font></td>
</tr>
<tr>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2">eingebundene Libs:</font></td>
	<td bgcolor="#eeeeee"><font face="Arial,Verdana" size="2">$lib</font></td>
</tr>
<tr>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2">Apache Lib:</font></td>
	<td bgcolor="#eeeeee"><font face="Arial,Verdana" size="2">$apachelib</font></td>
</tr>
<tr>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2">Apache modules installed:</font></td>
	<td bgcolor="#eeeeee"><font face="Arial,Verdana" size="2">$output</font></td>
</tr>
<tr>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2">Compiled-In Module:</font></td>
	<td bgcolor="#eeeeee"><font face="Arial,Verdana" size="2">$httpd</font></td>
</tr>
<tr>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2">Modul-Verz. (\@INC):</font></td>
	<td bgcolor="#eeeeee"><font face="Arial,Verdana" size="2">$mv</font></td>
</tr>
<tr>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2">Sendmail:</font></td>
	<td bgcolor="#eeeeee"><font face="Arial,Verdana" size="2">$sm</font></td>
</tr>
</table>

<br><br>

<table cellpadding="3" cellspacing="1" border="0" width="65%">
<tr><td bgcolor="#bcbcEE" colspan="2"><font face="Arial,Verdana" size="3"><b>Umgebungsvariablen (\%ENV)</b></font></td></tr>
$env_a
</table>

<br><br>

<table border="0" cellspacing="1" cellpadding="1" width="65%">
<tr>
	<td bgcolor="#bcbcEE" colspan="4"><font face="Arial,Verdana" size="3"><b>$modulzahl Installierte Module (\@INC)</b></font></td>
<tr>
<td bgcolor="#eeeeee" width=33% valign=top>
	<table border="0" cellspacing="1" cellpadding="1">
	$m_a
	</table>
</td><td width=33% bgcolor="#eeeeee" valign=top>
	<table border="0" cellspacing="1" cellpadding="1">
	$m__a
	</table>
</td><td bgcolor="#eeeeee" width=34% valign=top>
	<table border="0" cellspacing="1" cellpadding="1">
	$m___a
	</table>
</td>
</tr>
</table>

<br><br>

<table cellpadding="1" cellspacing="1" border="0" width="65%">
<tr>
	<td bgcolor="#bcbcEE" colspan="3"><font face="Arial,Verdana" size="3"><b>MIME-Typen</b></font></td>
</tr>
<tr>
	<td width="33%" valign="top" align="left" bgcolor="#eeeeee"><table cellpadding="1" cellspacing="1" border="0" width="100%">$m_au</table></td>
	<td width="33%" valign="top" align="left" bgcolor="#eeeeee"><table cellpadding="1" cellspacing="1" border="0" width="100%">$m__au</table></td>
	<td width="33%" valign="top" align="left" bgcolor="#eeeeee"><table cellpadding="1" cellspacing="1" border="0" width="100%">$m___au</table></td>
</tr>
</table>

<br><br>

<table cellpadding="1" cellspacing="1" border="0" width="65%">
<tr>
	<td bgcolor="#bcbcEE" colspan="3"><font face="Arial,Verdana" size="3"><b>Datenbanken</b></font></td>
</tr>
$db_a
</table>

<br><br>

<table cellpadding="1" cellspacing="1" border="0" width="65%">
<tr>
	<td bgcolor="#bcbcEE" colspan="2"><font face="Arial,Verdana" size="3"><b>Signal Handler (\%SIG)</b></font></td>
</tr>
$sig_a
</table>

</center>~;

	$navi = 1;
	&ausgabe($ausgabe);
	exit(0);
}

sub system {
	if($^O !~ /win/i){
		eval '(exit $?0)' && eval 'exec /usr/bin/perl -S $0 ${1+"$@"}' & eval 'exec /u19/usr/bin/perl -S $0 argv:q' if 0;
		open(PS,"ps -elf |" );
		while(<PS>){
		    chop;
		    @ps_fields = split(' ', $_ );
		    if($ps_fields[5] != 0){
			$jlsp_a .= qq~<tr><td bgcolor="#eeeeee"><font face="Arial,Verdana">$ps_fields[5]</font></td><td bgcolor="#eeeeee"><font face="Arial,Verdana">$ps_fields[2]</font></td><td bgcolor="#eeeeee"><font face="Arial,Verdana">$ps_fields[9]</font></td><td bgcolor="#eeeeee"><font face="Arial,Verdana">$ps_fields[3]</font></td><td bgcolor="#eeeeee"><font face="Arial,Verdana">$ps_fields[13]</font></td><td bgcolor="#eeeeee"><font face="Arial,Verdana">~;

			for($i=14;$i<@ps_fields;$i++){
				$jlsp_a .= " " . $ps_fields[$i];
			}
			$jlsp_a .= qq~</font></td></tr>~;
		    }
		}
		close(PS);

		@top = `w -h`;
		foreach $line (@top) {
			@benutzer = split(/\s+/, $line);
			$top_a .= qq~<tr><td bgcolor="#eeeeee"><font face="Arial,Verdana">$benutzer[0]</font></td><td bgcolor="#eeeeee"><font face="Arial,Verdana">$benutzer[1]</font></td><td bgcolor="#eeeeee"><font face="Arial,Verdana">$benutzer[2]</font></td><td bgcolor="#eeeeee"><font face="Arial,Verdana">$benutzer[3]</font></td><td bgcolor="#eeeeee"><font face="Arial,Verdana">$benutzer[4]</font></td><td bgcolor="#eeeeee"><font face="Arial,Verdana">$benutzer[5]</font></td><td bgcolor="#eeeeee"><font face="Arial,Verdana">$benutzer[6]</font></td><td bgcolor="#eeeeee"><font face="Arial,Verdana">$benutzer[7]</font></td>~;
		}

		@pstree = `pstree`;
		$topo = shift @pstree;

		foreach $line (@pstree){
			$pstree_a .= qq~<tr><td bgcolor="#eeeeee"><font face="Arial,Verdana">$line</font></td></tr>~;
		}

		open(F,"/proc/meminfo");
		@data9 = <F>;
		close(F);

		($ram1, $ram2, $ram3, $ram4, $ram5, $ram6, $ram7) = split(/\s+/, $data9[1]);
		if ($ram2 ne "" or $ram3 ne ""){
			$cap = $ram3 / $ram2 * 100;
			$cap = substr $cap, 0, 2;
			$cap =~ s/\.//isg;
			$cap=sprintf("%.3f", $cap);
		}

		$space = $ram2;
		$ram2 = berechnen();
		$ram2 = $space;
		$space = $ram3;
		$ram3 = berechnen();
		$ram3 = $space;
		$space = $ram4;
		$ram4 = berechnen();
		$ram4 = $space;

		$cap = substr $cap, 0, 2;
		$breit = $cap * 2;
		$cap2 = qq~<table border="0" cellspacing="0" cellpadding="0"><td width="$breit" height="8" bgcolor="green">&nbsp;</td><td bgcolor="#eeeeee"><font face="Arial,Verdana" color="green">&nbsp;&nbsp; $cap\%</font></td></table>~;
		if ($cap > 90){
			$cap2 = qq~<table border="0" cellspacing="0" cellpadding="0"><td width="$breit" height="8" bgcolor="red">&nbsp;</td><td bgcolor="#eeeeee"><font face="Arial,Verdana" color="red">&nbsp;&nbsp; $cap\%</font></td></table>~;
		}

		$n_a .= qq~<tr>
			<td bgcolor="#ddddFF"><font face="Arial,Verdana">Physical Memory: </font></td>
			<td bgcolor="#eeeeee"><font face="Arial,Verdana">$cap2</font></td>
			<td bgcolor="#eeeeee" align="right"><font face="Arial,Verdana">$ram4</font></td>
			<td bgcolor="#eeeeee" align="right"><font face="Arial,Verdana">$ram3</font></td>
			<td bgcolor="#eeeeee" align="right"><font face="Arial,Verdana">$ram2</font></td>
		</tr>~;

		($ram1, $ram2, $ram3, $ram4, $ram5, $ram6, $ram7) = split(/\s+/, $data9[2]);
		if($ram2 ne "" or $ram3 ne ""){
			$cap = $ram3 / $ram2 * 100;
			$cap = sprintf("%.2f", $cap);
			$cap = substr $cap, 0, 2;
			$cap =~ s/\.//g;
		}

		$space = $ram2;
		$ram2 = berechnen();
		$ram2 = $space;
		$space = $ram3;
		$ram3 = berechnen();
		$ram3 = $space;
		$space = $ram4;
		$ram4 = berechnen();
		$ram4 = $space;

		$cap = substr $cap, 0, 2;
		$breit = $cap * 2;
		$cap2 = qq~<table border="0" cellspacing="0" cellpadding="0"><td width="$breit" height="8" bgcolor="green">&nbsp;</td><td bgcolor="#eeeeee"><font face="Arial,Verdana" color="green">&nbsp;&nbsp; $cap\%</font></td></table>~;
		if ($cap > 90) {
			$cap2 = qq~<table border="0" cellspacing="0" cellpadding="0"><td width="$breit" height="8" bgcolor="red">&nbsp;</td><td bgcolor="#eeeeee"><font face="Arial,Verdana" color="red">&nbsp;&nbsp; $cap\%</font></td></table>~;
		}

		$n_a .= qq~<tr>
			<td bgcolor="#ddddFF"><font face="Arial,Verdana">DiskSwap: </font></td>
			<td bgcolor="#eeeeee"><font face="Arial,Verdana">$cap2</font></td>
			<td bgcolor="#eeeeee" align="right"><font face="Arial,Verdana">$ram4</font></td>
			<td bgcolor="#eeeeee" align="right"><font face="Arial,Verdana">$ram3</font></td>
			<td bgcolor="#eeeeee" align="right"><font face="Arial,Verdana">$ram2</font></td>
		</tr>~;

		if(-e("/proc/cpuinfo")){
			open(F,"/proc/cpuinfo");
			while(<F>){
				chomp($_);
				($name,$inhalt) = split(/\s:\s/,$_);
				if($name eq "processor"){
					$processor = $inhalt;
					$processor++;
				}elsif($name =~ /cpus detected/){
					$processor++;
				}elsif($name =~ /platform string|system type|model name|cpu model|revision/i){
					$model = $inhalt;
				}elsif($name =~ /cpu MHz|clock|cycle frequency [Hz]/){
					$inhalt =~ s/\s//g;
					$cpu = sprintf("%.2f",$inhalt);
				}elsif($name eq "cache size"){
					$cache = $inhalt;
				}elsif($name =~ /bogomips/i){
					$bogomips = $inhalt;
				}
			}
			close(F);
		}

		$machine = `uname -m`;

		$floppy = 0;
		open(F,"/etc/fstab");
		foreach my $line (<F>){
			if($line =~ /\/dev\/fd0/ && $line =~ /\/dev\/fd1/){
				$floppy = 2;
			}elsif($line =~ /\/dev\/fd0/ or $line =~ /\/dev\/fd1/){
				$floppy = 1;
			}
		}
		close(F);

		if (-e("/proc/pci")){
			open(F,"/proc/pci");
			@data6 = <F>;
			close(F);
		}
		if (-e("/proc/scsi/scsi")){
			open(F,"/proc/scsi/scsi");
			@data8 = <F>;
			close(F);
		}

		opendir(V,"/proc/ide");
		@ide = readdir(V);
		closedir(V);

		foreach $line (@data6){
			if($line =~ /ISA/ or $line =~ /IDE/ or $line =~ /USB/ or $line =~ /Ethernet/ or $line =~ /VGA/ or $line =~ /bridge/){
				$pci_a .= (split(/: /,$line))[1] . "<br>";
			}
		}

		foreach $line (@ide){
			$ide_a = "<font face=arial,verdana>none</font>" if ($ide[0] eq "" or $line eq "");
		        if($line =~ /hd/){
	        		if(-e("/proc/ide/$line/model")){
					open(F,"/proc/ide/$line/model");
					@ide3 = <F>;
					close(F);
				}
			        $ide_a .= qq~$ide3[0]<br>~;
		        }
		}

		foreach $line (@data8){
		        if ($line =~ /Vendor/){
				$scsi_a .= (split(/: /,$line))[1] . ": " . (split(/: /,((split(/: /,$line))[2])))[0] . " ( Rev: " . (split(/: /,$line))[3] . " )<br>";
		        }
		}
		$scsi_a = "none" unless($scsi_a);
		$ide_a = "none" unless($ide_a);
		$pci_a = "none" unless($pci_a);

		if(-e("/proc/net/dev")){
			open(F,"/proc/net/dev");
			@data7 = <F>;
			close(F);
		}

		shift @data7;
		shift @data7;
		foreach my $line (@data7) {
			@net = split(/\s+/,$line);
			$one = $net[4]+$net[12];
			$two = $net[5]+$net[13];
			@net2 = split(/:/,$net[1]);
			$ram2 = $net2[1];
			if ($net[1] =~/lo/){
				$ram2 = $net[2];
			}
		}

		$space = $ram2;
		&berechnen;

		$three = $space;
		$ram2 = $net[9];
		if($net[1] =~/lo/){
			$ram2 = $net[10];
		}

		$space = $ram2;
		&berechnen;

		$four = $space;
		if($net[1] =~ /lo/){
			$net_a .= "<tr><td bgcolor=#eeeeee align=right><font face=arial,verdana>lo</font></td><td bgcolor=#eeeeee align=right><font face=arial,verdana>$three</font></td><td bgcolor=#eeeeee align=right><font face=arial,verdana>$four</font></td><td bgcolor=#eeeeee align=right><font face=arial,verdana>$one/$two</font></td></tr>";
		}
		if($net[1] =~ /eth0/){
			$net2_a .= "<tr><td bgcolor=#eeeeee align=right><font face=arial,verdana>eth0</font></td><td bgcolor=#eeeeee align=right><font face=arial,verdana>$three</font></td><td bgcolor=#eeeeee align=right><font face=arial,verdana>$four</font></td><td bgcolor=#eeeeee align=right><font face=arial,verdana>$one/$two</font></td></tr>";
		}
		if($net[0] =~ /shaper0/ or $net[1] =~ /shaper0/){
			$net3_a .= "<tr><td bgcolor=#eeeeee align=right><font face=arial,verdana>shaper0</font></td><td bgcolor=#eeeeee align=right><font face=arial,verdana>$three</font></td><td bgcolor=#eeeeee align=right><font face=arial,verdana>$four</font></td><td bgcolor=#eeeeee align=right><font face=arial,verdana>$one/$two</font></td></tr>";
		}
		if($net[1] =~ /sit0/){
			$net4_a .= "<tr><td bgcolor=#eeeeee align=right><font face=arial,verdana>sit0</font></td><td bgcolor=#eeeeee align=right><font face=arial,verdana>$three</font></td><td bgcolor=#eeeeee align=right><font face=arial,verdana>$four</font></td><td bgcolor=#eeeeee align=right><font face=arial,verdana>$one/$two</font></td></tr>";
		}

		if(-e("/proc/mounts")){open(F,"/proc/mounts");@mounts = <F>;close(F);}
		if(-e("/etc/fstab")){open(F,"/etc/fstab");@floppy = <F>;close(F);}

#
# Filesystem Size Used Avail Use% Mounted
#
		@df = `df -h`;
		if(@df eq ""){
			@df = `/bin/df -kP`;
		}
		if($df[0]){
			shift @df;
			
			foreach my $line (@df) {
				($dev, $size, $used, $avail, $capacity, $mount) = split(/\s+/, $line);
				
				$line =~ s/\t/ /g;
				$line =~ s/\s/&nbsp;/g;
				
				$capacity =~ s/%//;
				$capacity2 = $capacity;
				$capacity3 = $capacity * 3;
				
				$picture = qq~<table border="0" cellspacing="0" cellpadding="0"><td width="$capacity3" height="8" bgcolor="green">&nbsp;</td><td bgcolor="#eeeeee"><font face="Arial,Verdana" color="green">&nbsp;&nbsp; $capacity\%</font></td></table>~;
				if ($capacity > 90) {
					$picture = qq~<table border="0" cellspacing="0" cellpadding="0"><td width="$capacity3" height="8" bgcolor="red">&nbsp;</td><td bgcolor="#eeeeee"><font face="Arial,Verdana" color="red">&nbsp;&nbsp; $capacity\%</font></td></table>~;
				}

				if($cap > 90){
					$capacity =~ s/$capacity/\<FONT COLOR=red>$capacity2\<\/FONT\>/;
				}else{
					$capacity =~ s/$capacity/\<FONT COLOR=green>$capacity2\<\/FONT\>/;
				}
				$mount_a .= "<tr><td bgcolor=#eeeeee><font face=arial,verdana>$mount</font></td><td bgcolor=#eeeeee>";
				foreach my $mo (@mounts){
					@system = split (/\s+/, $mo);
					if ($dev eq $system[0]){
						$mount_a .= "$system[2]\n";
					}
				}

				$avail =~ s/K/ KB/ig;$avail =~ s/M/ MB/isg;$avail =~ s/G/ GB/ig;
				$used =~ s/K/ KB/ig;$used =~ s/M/ MB/isg;$used =~ s/G/ GB/ig;
				$size =~ s/K/ KB/ig;$size =~ s/M/ MB/isg;$size =~ s/G/ GB/ig;

				$mount_a .= "</td><td bgcolor=#eeeeee><font face=arial,verdana>$dev</font></td><td bgcolor=#eeeeee><font face=arial,verdana>$picture</font></td><td bgcolor=#eeeeee align=right><font face=arial,verdana>$avail</font></td><td bgcolor=#eeeeee align=right><font face=arial,verdana>$used</font></td><td bgcolor=#eeeeee align=right><font face=arial,verdana>$size</font></td></tr>";
			}
			$mount_a .= "</table><br>\n";
		}else{
			if(-e("/etc/mtab")){
				open(F, "/etc/mtab");@fstab = <F>;close(F);}else{open(F,"/etc/fstab");@fstab = <F>;close(F);
			}
			unless($fstab[0]){
				if (-e("/proc/mounts")){open(F,"/proc/mounts");@fstab = <F>;close(F);}else{open(F,"/etc/fstab");@fstab = <F>;close(F);}
			}elsif($fstab[0] eq ""){
				if (-e("/etc/fstab")){open(F,"/etc/fstab");@fstab = <F>;close(F);}else{open(F,"/etc/fstab");@fstab = <F>;close(F);}
			}

			foreach my $line (@fstab){
				$two2 =~ s/\ \ /\ /g;
				@line = split(/\s+/, $line);
				$mount_a .= qq~<tr><td bgcolor=#eeeeee><font face=arial,verdana>$line[1]</font></td><td bgcolor=#eeeeee><font face=arial,verdana>$line[2]</font></td><td bgcolor=#eeeeee><font face=arial,verdana>$line[0]</font></td><td bgcolor=#eeeeee align=right>&nbsp;</td><td bgcolor=#eeeeee align=right>&nbsp;</td><td bgcolor=#eeeeee align=right>&nbsp;</td><td bgcolor=#eeeeee align=right>&nbsp;</td></tr>~;
			}
		}

		open(P,"ps aux | sort -rn +4 |");
		@ps_info = <P>;
		close(P);
		pop(@ps_info);

		foreach $line (@ps_info){
			@psfeld = split(/\s+/,$line);
			if($second eq "eeeeee"){
				$second = "e6e6e6";
			}else{
				$second = "eeeeee";
			}
			$pro2_a .= "<tr><td bgcolor=$second><font face=arial,Verdana>$psfeld[0]</font></td><td bgcolor=$second><font face=arial,Verdana>$psfeld[1]</font></td><td bgcolor=$second><font face=arial,Verdana>$psfeld[2]\%</font></td><td bgcolor=$second><font face=arial,Verdana>$psfeld[3]\%</font></td><td bgcolor=$second><font face=arial,Verdana>$psfeld[4]</font></td><td bgcolor=$second><font face=arial,Verdana>$psfeld[5]</font></td><td bgcolor=$second><font face=arial,Verdana>$psfeld[6]</font></td><td bgcolor=$second><font face=arial,Verdana>$psfeld[7]</font></td><td bgcolor=$second><font face=arial,Verdana>$psfeld[8]</font></td><td bgcolor=$second><font face=arial,Verdana>$psfeld[9]</font></td><td bgcolor=$second><font face=arial,Verdana>";

			for($i=10;$i<@psfeld;$i++){
				$pro2_a .= " " . $psfeld[$i];
			}
			$pro2_a .= "</font></td></tr>";
		}

		$hardware2[1] =~ s/ /\&nbsp\;/g;
		$pci_a =~ s/ /\&nbsp\;/g;
	}else{
		if($mod_w32s){
			Win32::API::Struct->typedef( MEMORYSTATUS => qw{
			   DWORD dwLength;
			   DWORD MemLoad;
			   DWORD TotalPhys;
			   DWORD AvailPhys;
			   DWORD TotalPage;
			   DWORD AvailPage;
			   DWORD TotalVirtual;
			   DWORD AvailVirtual;
			});
			Win32::API->Import('kernel32', 'VOID GlobalMemoryStatus(LPMEMORYSTATUS lpMemoryStatus)');

			$memorystatus = Win32::API::Struct->new('MEMORYSTATUS');
			GlobalMemoryStatus($memorystatus);
			#MemLoad TotalPhys AvailPhys TotalPage AvailPage TotalVirtual AvailVirtual

			$swapfree = sprintf("%.0f", $memorystatus->{'AvailPage'}/(1024*1024));
			$swaptotal = sprintf("%.0f", $memorystatus->{'TotalPage'}/(1024*1024));
			$memoryfree = sprintf("%.0f", $memorystatus->{'AvailPhys'}/(1024*1024));
			$memorytotal = sprintf("%.0f", $memorystatus->{'TotalPhys'}/(1024*1024));

			$memoryblock = $memorytotal - $memoryfree;
			$cap = sprintf("%.2f", $memoryblock / $memorytotal * 100);

			$breit = $cap * 2;
			$cap2 = qq~<table border="0" cellspacing="0" cellpadding="0"><td width="$breit" height="8" bgcolor="green">&nbsp;</td><td bgcolor="#eeeeee"><font face="Arial,Verdana" color="green">&nbsp;&nbsp; $cap\%</font></td></table>~;
			if ($cap > 90){
				$cap2 = qq~<table border="0" cellspacing="0" cellpadding="0"><td width="$breit" height="8" bgcolor="red">&nbsp;</td><td bgcolor="#eeeeee"><font face="Arial,Verdana" color="red">&nbsp;&nbsp; $cap\%</font></td></table>~;
			}

			$n_a .= qq~<tr>
				<td bgcolor="#ddddFF"><font face="Arial,Verdana">Physical Memory:</font></td>
				<td bgcolor="#eeeeee">$cap2</td>
				<td bgcolor="#eeeeee" align="right"><font face="Arial,Verdana">$memoryfree MB</font></td>
				<td bgcolor="#eeeeee" align="right"><font face="Arial,Verdana">$memoryblock MB</font></td>
				<td bgcolor="#eeeeee" align="right"><font face="Arial,Verdana">$memorytotal MB</font></td>
			</tr>~;

			$swapblock = $swaptotal - $swapfree;
			$cap = sprintf("%.2f", $swapblock / $swaptotal * 100);

			$breit = $cap * 2;
			$cap2 = qq~<table border="0" cellspacing="0" cellpadding="0"><td width="$breit" height="8" bgcolor="green">&nbsp;</td><td bgcolor="#eeeeee"><font face="Arial,Verdana" color="green">&nbsp;&nbsp; $cap\%</font></td></table>~;
			if ($cap > 90){
				$cap2 = qq~<table border="0" cellspacing="0" cellpadding="0"><td width="$breit" height="8" bgcolor="red">&nbsp;</td><td bgcolor="#eeeeee"><font face="Arial,Verdana" color="red">&nbsp;&nbsp; $cap\%</font></td></table>~;
			}

			$n_a .= qq~<tr>
				<td bgcolor="#ddddFF"><font face="Arial,Verdana">DiskSwap:</font></td>
				<td bgcolor="#eeeeee">$cap2</td>
				<td bgcolor="#eeeeee" align="right"><font face="Arial,Verdana">$swapfree MB</font></td>
				<td bgcolor="#eeeeee" align="right"><font face="Arial,Verdana">$swapblock MB</font></td>
				<td bgcolor="#eeeeee" align="right"><font face="Arial,Verdana">$swaptotal MB</font></td>
			</tr>~;

			$wert = chr(0);
			$getBuffer = $wert x 64;
			$GetLogicalDrives = new Win32::API("kernel32","GetLogicalDriveStrings", NP, N);
			$GetLogicalDrives = $GetLogicalDrives->Call(64, $getBuffer);
			@laufwerke = split(/$wert/,$getBuffer);

			@typ = ("Unbekannt","Unbekannt","Diskette","Festplatte","Netzlaufwerk","CD-ROM","RAM-Disk");

			foreach $x (@laufwerke){
				$GetDriveType = new Win32::API("kernel32","GetDriveType", P, N);
				$GetDriveType = $GetDriveType->Call($x);

				$GetDiskFreeSpace = new Win32::API("kernel32", "GetDiskFreeSpace" , [P, P, P, P, P], N);
				$getBuffer = $x;

				$lpSectsPerCluster = pack("L", 0);
				$lpBytesPerSect = pack("L", 0);
				$lpNumOfFreeClusters = pack("L", 0);
				$lpTotNumOfClusters = pack("L", 0);

				$GetDiskFreeSpace->Call("$getBuffer", $lpSectsPerCluster, $lpBytesPerSect, $lpNumOfFreeClusters, $lpTotNumOfClusters);

				($SectsPerCluster) = unpack("L",$lpSectsPerCluster);
				($BytesPerSect) = unpack("L",$lpBytesPerSect);
				($NumOfFreeClusters) = unpack("L",$lpNumOfFreeClusters);
				($TotNumOfClusters) = unpack("L",$lpTotNumOfClusters);

				$TotalDiskSpace = sprintf("%.0f", ($SectsPerCluster * $BytesPerSect * $TotNumOfClusters)/(1024*1024));
				$FreeDiskSpace = sprintf("%.0f", ($SectsPerCluster * $BytesPerSect * $NumOfFreeClusters)/(1024*1024));
				$UsedDiskSpace = sprintf("%.0f", ($SectsPerCluster * $BytesPerSect * ($TotNumOfClusters - $NumOfFreeClusters))/(1024*1024));

				$floppy++ if($typ[$GetDriveType] eq "Diskette");
				push(@df,"$typ[$GetDriveType] $TotalDiskSpace $UsedDiskSpace $FreeDiskSpace $x");
			}

			foreach my $line (@df) {
				($dev, $size, $used, $avail, $mount) = split(/\s+/, $line);
				$line =~ s/\s/&nbsp;/g;

				if($avail){
					$block = $size - $avail;
					$capacity = sprintf("%.2f", $block / $size * 100);
					$capacity2 = $capacity;
					$capacity3 = $capacity * 3;
				}else{
					$block = "100";
					$capacity = "100";
					$capacity2 = "100";
					$capacity3 = "100" * 3;
				}

				$picture = qq~<table border="0" cellspacing="0" cellpadding="0"><td width="$capacity3" height="8" bgcolor="green">&nbsp;</td><td bgcolor="#eeeeee"><font face="Arial,Verdana" color="green">&nbsp;&nbsp; $capacity\%</font></td></table>~;
				if ($capacity > 90) {
					$picture = qq~<table border="0" cellspacing="0" cellpadding="0"><td width="$capacity3" height="8" bgcolor="red">&nbsp;</td><td bgcolor="#eeeeee"><font face="Arial,Verdana" color="red">&nbsp;&nbsp; $capacity\%</font></td></table>~;
				}

				if($cap > 90){
					$capacity =~ s/$capacity/\<FONT COLOR=red>$capacity2\<\/FONT\>/;
				}else{
					$capacity =~ s/$capacity/\<FONT COLOR=green>$capacity2\<\/FONT\>/;
				}
				$mount_a .= qq~<tr><td bgcolor=#eeeeee><font face=arial,verdana>$mount</font></td><td bgcolor=#eeeeee><font face=arial,verdana>$dev</font></td><td bgcolor=#eeeeee><font face=arial,verdana></font></td><td bgcolor=#eeeeee><font face=arial,verdana>$picture</font></td><td bgcolor=#eeeeee align=right><font face=arial,verdana>$avail MB</font></td><td bgcolor=#eeeeee align=right><font face=arial,verdana>$used MB</font></td><td bgcolor=#eeeeee align=right><font face=arial,verdana>$size MB</font></td></tr>~;
			}
			$mount_a .= "</table><br>\n";
		}

		if($mod_w32r){
			$::HKEY_LOCAL_MACHINE->Open("Hardware\\Description\\System\\CentralProcessor\\0", $mhz);
			$mhz->QueryValueEx("~MHz", $type, $cpu);
		}

		if($mod_w32s){
			Win32::API::Struct->typedef( SYSTEM_INFO => qw{
			   DWORD dwOemID;
			   DWORD dwPageSize;
			   DWORD lpMinimumApplicationAddress;
			   DWORD lpMaximumApplicationAddress;
			   DWORD dwActiveProcessorMask;
			   DWORD dwNumberOfProcessors;
			   DWORD dwProcessorType;
			   DWORD dwAllocationGranularity;
			   DWORD dwReserved;
			});
			Win32::API->Import('kernel32', 'VOID GetSystemInfo(SYSTEM_INFO lpSystemInfo)');
			$system = Win32::API::Struct->new('SYSTEM_INFO');
			GetSystemInfo($system);

			$processor = $system->{'dwNumberOfProcessors'};
			$model = $system->{'dwProcessorType'};
		}

		if($mod_w32p == 1 && $mod_w32i == 1){
			$pi = Win32::Process::Info->new ();
			@info= $pi->GetProcInfo();
			foreach $pid (@info){
				push(@topo,sprintf("%04.f",$pid->{ProcessId}) . " $pid->{Name} <font size=\"1\">($pid->{ExecutablePath})</font><br>"); # - $pid->{UserModeTime} - $pid->{KernelModeTime} - $pid->{CreationDate}- 
			}
			$topo = join("",sort {$a <=> $b} @topo);
		}
	}
	$bogomips = "?" unless($bogomips);
	$cache = "?" unless($cache);
	$model = "?" unless($model);
	$processor = "?" unless($processor);
	$cpu = "?" unless($cpu);
	chomp($machine);
	$cpu .= " ($machine)" if($machine);

$ausgabe =qq~<table cellpadding="1" cellspacing="1" border="0" width="73%"><td align="right" valign="top">
<table cellpadding="1" cellspacing="1" border="0">
<tr>
	<td bgcolor="#bcbcEE" colspan="2"><font face="Arial,Verdana" size="3"><b>Hardware Informationen:</b></font></td>
</tr>
<tr>
	<td bgcolor="#ddddFF" align="right"><font face="Arial,Verdana">Prozessor(en):</font></td>
	<td bgcolor="#eeeeee" align="left"><font face="Arial,Verdana">$processor</font></td>
</tr>
<tr>
	<td bgcolor="#ddddFF" align="right"><font face="Arial,Verdana">Model:</font></td>
	<td bgcolor="#eeeeee" align="left"><font face="Arial,Verdana">$model</font></td>
</tr>
<tr>
	<td bgcolor="#ddddFF" align="right"><font face="Arial,Verdana">Chip&nbsp;Mhz:</font></td>
	<td bgcolor="#eeeeee" align="left"><font face="Arial,Verdana">$cpu</font></td>
</tr>
<tr>
	<td bgcolor="#ddddFF" align="right"><font face="Arial,Verdana">Cache&nbsp;Gr&ouml;sse:</font></td>
	<td bgcolor="#eeeeee" align="left"><font face="Arial,Verdana">$cache</font></td>
</tr>
<tr>
	<td bgcolor="#ddddFF" align="right"><font face="Arial,Verdana">System&nbsp;Bogomips:</font></td>
	<td bgcolor="#eeeeee" align="left"><font face="Arial,Verdana">$bogomips</font></td>
</tr>
<tr>
	<td bgcolor="#ddddFF" align="right"><font face="Arial,Verdana">Floppy:</font></td>
	<td bgcolor="#eeeeee" align="left"><font face="Arial,Verdana">$floppy</font></td>
</tr>
$h_a
</table>
</td><td align="left" valign="top">
<table cellpadding="3" cellspacing="1" border="0">
<tr>
	<td bgcolor="#bcbcEE" colspan="4"><font face="Arial,Verdana" size="3"><b>Netzwerk Informationen:</b></font></td>
</tr>
<tr>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana">Device</font></td>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana">Recieved</font></td>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana">Sent</font></td>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana">Err/Drop</font></td>
</tr>
$net_a
$net2_a
$net3_a
$net4_a
</table>
</td>
</table>
<table cellpadding="1" cellspacing="1" border="0">
<tr>
	<td bgcolor="#bcbcEE" colspan="2"><font face="Arial,Verdana" size="3"><b>Hardware Informationen 2:</b></font></td>
</tr>
<tr>
	<td bgcolor="#ddddFF" align="right" valign="top"><font face="Arial,Verdana">PCI&nbsp;Devices:</font></td>
	<td bgcolor="#eeeeee" align="left" valign="top"><font face="Arial,Verdana">$pci_a</font></td>
</tr>
<tr>
	<td bgcolor="#ddddFF" align="right" valign="top"><font face="Arial,Verdana">IDE&nbsp;Devices:</font></td>
	<td bgcolor="#eeeeee" align="left" valign="top"><font face="Arial,Verdana">$ide_a</font></td>
</tr>
<tr>
	<td bgcolor="#ddddFF" align="right" valign="top"><font face="Arial,Verdana">SCSI&nbsp;Devices:</font></td>
	<td bgcolor="#eeeeee" align="left" valign="top"><font face="Arial,Verdana">$scsi_a</font></td>
</tr>
</table>

<br><br>

<table cellpadding="1" cellspacing="1" border="0" width="65%">
<tr>
	<td bgcolor="#bcbcEE" colspan="7"><font face="Arial,Verdana" size="3"><b>Mounted&nbsp;Filesystems:</b></font></td>
</tr>
<tr>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana"><b>Mount</b></font></td>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana"><b>Type</b></font></td>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana"><b>Partion</b></font></td>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana"><b>Belegte Kapazit&auml;t (\%)</b></font></td>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana"><b>Frei</b></font></td>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana"><b>Belegt</b></font></td>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana"><b>Gesamt</b></font></td>
</tr>
$mount_a
</table>

<br><br>

<table cellpadding="1" cellspacing="1" border="0" width="65%">
<tr>
	<td bgcolor="#bcbcEE" colspan="6"><font face="Arial,Verdana" size="3"><b>Memory Usage:</b></font></td>
</tr>
<tr>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana"><b>Type</b></font></td>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana"><b>Belegte Kapazit&auml;t (\%)</b></font></td>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana"><b>Frei</b></font></td>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana"><b>Belegt</b></font></td>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana"><b>Gesamt</b></font></td>
</tr>
$n_a
</table>

<br><br>

<table cellpadding="1" cellspacing="1" border="0" width="65%">
<tr>
	<td bgcolor="#bcbcEE"><font face="Arial,Verdana" size="3"><b>Der komplette Prozessbaum:</b></font></td>
</tr>
<tr>
	<td bgcolor="#eeeeee"><font face="Arial,Verdana">$topo</font></td>
</tr>
$pstree_a
</table>

<br><br>

<table cellpadding="1" cellspacing="1" border="0" width="65%">
<tr>
	<td bgcolor="#bcbcEE" colspan="9"><font face="Arial,Verdana" size="3"><b>Alle Benutzer die derzeit im System sind:</b></font></td>
</tr>
<tr>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2">User</font></td>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2">TTY</font></td>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2">FROM</font></td>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2">Login\@</font></td>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2">Idle</font></td>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2">JCPU</font></td>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2">PCPU</font></td>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2">What</font></td>
</tr>
$top_a
</table>

<br><br>

<table cellpadding="1" cellspacing="1" border="0" width="65%">
<tr>
	<td bgcolor="#bcbcEE" colspan="6"><font face="Arial,Verdana" size="3"><b>Jetzt laufende Server Prozesse:</b></font></td>
</tr>
<tr>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2">load</font></td>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2">user</font></td>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2">size</font></td>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2">process</font></td>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2">time</font></td>
	<td bgcolor="#ddddFF"><font face="Arial,Verdana" size="2">command</font></td>
</tr>
$jlsp_a
</table>

<br><br>

<table cellpadding="1" cellspacing="1" border="0" width="70%">
<tr>
	<td bgcolor="#bcbcEE" colspan="11"><font face="Arial,Verdana" size="3"><b>Alle laufende Server Prozesse:</b></font></td>
</tr>
<tr>
	<td bgcolor=#ddddFF><font face=arial,Verdana>USER</font></td>
	<td bgcolor=#ddddFF><font face=arial,Verdana>PID</font></td>
	<td bgcolor=#ddddFF><font face=arial,Verdana>%CPU</font></td>
	<td bgcolor=#ddddFF><font face=arial,Verdana>%MEM</font></td>
	<td bgcolor=#ddddFF><font face=arial,Verdana>VSZ</font></td>
	<td bgcolor=#ddddFF><font face=arial,Verdana>RSS</font></td>
	<td bgcolor=#ddddFF><font face=arial,Verdana>TTY</font></td>
	<td bgcolor=#ddddFF><font face=arial,Verdana>STAT</font></td>
	<td bgcolor=#ddddFF><font face=arial,Verdana>START</font></td>
	<td bgcolor=#ddddFF><font face=arial,Verdana>TIME</font></td>
	<td bgcolor=#ddddFF><font face=arial,Verdana>COMMAND</font></td>
</tr>
$pro2_a
</table>

</center>~;
	$navi = 2;
	&ausgabe($ausgabe);
	exit(0);
}

sub logfiles {
	@logs = ("/etc/logfiles",
		"/etc/log",
		"/etc/log.old",
		"/etc/httpd/logs",
		"/usr/local/apache/logs",
		"/opt/apache/logs",
		"/var/log",
		"/var/log/mail",
		"/var/log/kernel",
		"/var/log/lpr",
		"/var/log/news",
		"/var/log/daemons",
		"/var/log/linuxconf",
		"/etc/log/httpd",
		"/var/log/httpd",
		"/var/log/httpd/confixx",
		"/var/log/httpd/confixx/kunden/access",
		"/var/log/httpd/confixx/domains/access",
		"/var/log/httpd/confixx",
		"$ENV{'DOCUMENT_ROOT'}/../log",
		"$ENV{'DOCUMENT_ROOT'}/../logs",
	);

	foreach $i (@logs){
		if(-d("$i")){
			opendir(V,"$i");
			foreach $x (readdir(V)){
				if($x ne "\.\." && $x ne "\."){
					if(-d("$i/$x")){
						opendir(VX,"$i/$x");
						foreach $vx (readdir(VX)){
							if($vx ne "\.\." && $vx ne "\."){
								push(@log,"$i/$x/$vx") if(!-d("$i/$x/$vx"));
							}
						}
						closedir(VX);
					}else{
						push(@log,"$i/$x");
					}
				}
			}
			closedir(V);
		}
	}

	foreach $line (@log) {
		if($line !~ /\.tar$/){
			if($line !~ /\.\.|\.\// or $line =~ /\.\.\/log/){
				@line = split(/\s/,$linex);

				if((-s("$linex[0]")) && (-B("$linex[0]")) && $linex[0] !~ /\.$/ or (-s("$linex[0]")) && (-T("$linex[0]")) && $linex[0] !~ /\.$/){
					$linex[0] =~ s/\/..\/log/\/\/log/;
					$linex[0] =~ s/\\/\//;
					$ausgabe .= "<tr><td><font face=verdana,arial><a href='sysinfo.cgi?action=logfiles2&log=$linex[0]'><font color=\"blue\"><u>$linex[0]</u></font></a></td></tr>";
				}elsif((-s("$line")) && (-B("$line")) && $line !~ /\.$/ or (-s("$line")) && (-T("$line")) && $line !~ /\.$/){
					$line =~ s/\/..\/log/\/\/log/;
					$line =~ s/\\/\//;
					$ausgabe .= "<tr><td><font face=verdana,arial><a href='sysinfo.cgi?action=logfiles2&log=$line'><font color=\"blue\"><u>$line</u></font></a></td></tr>";
				}
			}
		}
	}

	unless($ausgabe){
		$ausgabe .= "<tr><td><br><center><font face=verdana,arial>Nichts gefunden!</font></center><br></td></tr>";
	}

	$navi = 4;
	&ausgabe("<hr><center><table border=1 cellspacing=1 cellpadding=4>$ausgabe</table></center>");
	exit(0);
}

sub logfiles2 {
	$INFO{'log'} =~ s/\\/\//g;
	if($INFO{'log'} =~ /$ENV{'DOCUMENT_ROOT'}\/\/log|\/var\/log|\/etc\/httpd\/logs|\/etc\/log|\/usr\/local\/apache|\/opt\/apache\/logs/ && $INFO{'log'} ne "" && $INFO{'log'} !~ /\||\;|\.\.|\.\//){
		$file = $INFO{'log'};
		$file =~ s/\/\/log/\/..\/log/;

		if($file =~ /\.gz$|\.tgz$/){
			open(F,"gzip -cd $file |");
			@database = reverse(<F>);
			close(F);
		}else{
			open(F,"<$file");
			@database = reverse(<F>);
			close(F);
		}

		$x_a = "1";
	}else{
		$ausgabe = "FEHLER: File not found";
		$x_a = "0";
	}

	if($x_a == 1){
		$start = $INFO{'start'} || 0;

	        $ncount=0;
		$maxdisplay="75";
	        
	        while(($ncount*$maxdisplay)<@database) {
	                ++$absatz;
			if($absatz eq "30"){$sspan .= "<br>";$absatz="0";}
	                $nviewc = $ncount+1;
	                $nstrt = ($ncount*$maxdisplay);
	                if($start == $nstrt) {
	                        $sspan .= "$nviewc&nbsp;";
	                } else {
	                        $sspan .= qq~<a href="sysinfo.cgi?action=logfiles2&start=$nstrt&log=$INFO{'log'}">$nviewc</a>&nbsp;~;
	                }
	                ++$ncount;
		}

	        if ($ncount==1 or $ncount==0){
	                $sspan="[&lt;&lt;]&nbsp;1&nbsp;[&gt;&gt;]";
	        } else {
	                $x=($start/$maxdisplay)+1;
	                $xs=$start+$maxdisplay;
	                $xs2=$start-$maxdisplay;

	                if ($x<$ncount){
	                        if ($x>1) {
	                                $sspan= qq~<a href="sysinfo.cgi?action=logfiles2&start=$xs2&log=$INFO{'log'}">[&lt;&lt;]</a>&nbsp;$sspan~;
	                        } else {
	                                $sspan="[&lt;&lt;]&nbsp;$sspan";
	                        }
				$sspan .= qq~&nbsp;<a href="sysinfo.cgi?action=logfiles2&start=$xs&log=$INFO{'log'}">[&gt;&gt;]</a>~;
	                } else {
	                        if ($x>1) {
	                                $sspan= qq~<a href="sysinfo.cgi?action=logfiles2&start=$xs2&log=$INFO{'log'}">[&lt;&lt;]</a>&nbsp;$sspan~;
	                        } else {
	                                $sspan="[&lt;&lt;]&nbsp;$sspan";
	                        }
	                        $sspan .="&nbsp;[&gt;&gt;]";
	                }
	        }
	        
	        $sspan =~ s/&nbsp;&nbsp;/&nbsp;/g;

	        $num = 0;
	        for ($i = $start; $i < @database; $i++) {
			$num++;
		        $database[$i] =~ s!&!&amp;!g;
		        $database[$i] =~ s!&lt;!&#60;!g;
		        $database[$i] =~ s!&gt;!&#62;!g;
		        $database[$i] =~ s/>/&gt;/g;
		        $database[$i] =~ s/</&lt;/g;
		        $database[$i] =~ s/\|/\&\#124;/g;
			$ausgabe .= $database[$i];

			if($num >= $maxdisplay){
				last;
			}
		}
	}

	$navi = 4;
	&ausgabe("<a href=\"sysinfo.cgi?action=logfiles\">&lt;&lt;-- Zur&uuml;ck zu der Logfiles &Uuml;bersicht</a><br><br><center><br>$sspan<br></center><hr><pre><p align=\"left\">$ausgabe</p></pre><hr><center><br>$sspan<br></center>");
	exit(0);
}

sub dead {
	$zwei = $ENV{'DOCUMENT_ROOT'};
	$zwei =~ s/^(.*\/).*?$/$1/g;

	if((-e("$ENV{'DOCUMENT_ROOT'}/dead.letter")) && $FORM{'pass'} eq $passwort){
		open(F,"$ENV{'DOCUMENT_ROOT'}/dead.letter");
		@deadletter = <F>;
		close(F);
	}elsif($FORM{'pass'} eq $passwort){
		open(F,"$zwei/dead.letter");
		@deadletter = <F>;
		close(F);
	}

	foreach $line (@deadletter){
		$ausgabe .= "$line<br>";
	}

	if($ausgabe ne "" && $FORM{'pass'} eq $passwort){
		$dead_a = "<font face=arial,verdana>$ausgabe</font>";
	}elsif($ausgabe eq "" && $FORM{'pass'} eq $passwort){
		$dead_a = "Keine Toten-Emails gefunden !";
	}elsif($FORM{'pass'} eq ""){
		$dead_a = "Kein Passwort eingegeben.";
	}elsif($FORM{'pass'} ne $passwort){
		$dead_a = "Falsches Passwort eingegeben!";
	}

	$navi = 5;
	&ausgabe("</center><form action=\"sysinfo.cgi\" method=\"POST\"><input type=hidden name=\"action\" value=\"dead\"><font face=\"Arial,Verdana\">Passwort: </font><input type=text name=\"pass\" value=\"$FORM{'pass'}\"> <input type=submit value=\"Anzeigen\"></form><br><br><br><font face=\"Arial,Verdana\">$dead_a</font><center>");
	exit(0);
}

sub webspace {
	if($DOCUMENT_ROOT eq "" && $FORM{'webspace'} eq ""){
		$DOCUMENT_ROOT = $ENV{'DOCUMENT_ROOT'};
	}else{
		$DOCUMENT_ROOT = $FORM{'webspace'};
	}
	
	if($^O !~ /win/i){
		$space = `du -m -s $DOCUMENT_ROOT`;
#		$space = `du -s $DOCUMENT_ROOT`;
#		$space=sprintf("%.2f",($space / 1024));
		$space =~ s/^([0-9]+)[\n\r\s](.*)/$1/isg;
	}else{
		$space=sprintf("%.2f",(((&checkspace($DOCUMENT_ROOT))[0]) / 1024 / 1024));
	}
	$space=sprintf("%.2f",(((&checkspace($DOCUMENT_ROOT))[0]) / 1024 / 1024)) if(!$space);


	$frei = $free;
	$free -= $space;
	if($frei < $space){$frei = $space;$free = 0;}

	$free .= " MB";
	$space .= " MB";
	$free2 = sprintf("%.2f",($space / $frei * 100));
	$webspace_a = qq~<font face="Arial,Verdana"><b>belegt:</b> Es sind $space belegt und frei $free von $frei MB ($free2\% von 100\%)<br><br>
	<form action="$cgi" method="POST">
	<input type=hidden name="action" value="webspace">
	<input type=text name="webspace" value="$DOCUMENT_ROOT">
	<input type=submit value="Anfrage senden">
	</form>
	</font>~;

	$navi = 6;
	&ausgabe($webspace_a);
	exit(0);
}

sub checkspace {local($e) = @_;
	($e) = shift;
	($size,$used_space,$free_space) = 0;
	&find ( sub { $size += -s },"$e");
	$used_space = int($size /1024);
	$free_space = ($size - $used_space);
	return($free_space,$size,$used_space);
}

sub debugger {
	$navi = 3;
	&ausgabe("<hr><font face=Verdana,Arial>Bitte die Datei und falls n&ouml;tig auch den Pfad des Scriptes eingeben:<br><br><form action=\"sysinfo.cgi\" method=\"POST\"><input type=hidden name=\"action\" value=\"debugger2\"><font face=\"Arial,Verdana\">Pfad: <input type=text name=\"pfad\" value=\"$ENV{'DOCUMENT_ROOT'}\" size=\"60\"><br>Datei: <input type=text name=\"file\" value=\"\" size=\"40\"><br>Passwort: <input type=password name=\"pass\" value=\"\" size=\"20\"></font><input type=submit value=\"Start\"></form></font>");
	exit(0);
}

sub debugger2 {
	if($FORM{'pass'} eq $passwort){
		$pfad = "$FORM{'pfad'}\/$FORM{'file'}" if($FORM{'file'});
		$pfad =~ s/\\/\//g;
		$pfad =~ s/\/\//\//g;

		if(-e("$pfad")){
			if($FORM{'pfad'} eq "" or $FORM{'file'} eq ""){
				$perl = "Kein Pfad oder Skript angegeben!";
			}else{
				@shell = `perl -cw $pfad 2>&1`; 
				foreach my $line (@shell) {
					$perl .= "$line<br>";
				} 
				$perl2 = join('', @shell);
				$perl = "$pfad syntax OK" if (length($perl2) == 0);
			}
		}else{
			$perl = "Angegebenes Skript existiert nicht!";
		}
		$pass = $FORM{'pass'};
	}else{
		$perl = "Falsches Passwort eingegeben!";
	}

	$navi = 3;
	&ausgabe("$perl<br><br><center><hr><font face=Verdana,Arial>Bitte die Datei und falls n&ouml;tig auch den Pfad des Scriptes eingeben:<br><br><form action=\"sysinfo.cgi\" method=\"POST\"><input type=hidden name=\"action\" value=\"debugger2\"><font face=\"Arial,Verdana\">Pfad: <input type=text name=\"pfad\" value=\"$FORM{'pfad'}\" size=\"60\"><br>Datei: <input type=text name=\"file\" value=\"$FORM{'file'}\" size=\"40\"><br>Passwort: <input type=password name=\"pass\" value=\"$pass\" size=\"20\"></font><input type=submit value=\"Start\"></form></font>");
	exit(0);
}

sub berechnen {
	if($space > 1099511627776 ) {
		$space  = sprintf("%.2f", $space / 1099511627776 );
		$space .= " TB";
	}elsif($space > 1073741824 ) {
		$space  = sprintf("%.2f", $space / 1073741824 );
		$space .= " GB";
	}elsif($space > 1048576 ) {
		$space  = sprintf("%.2f", $space / 1048576 );
		$space .= " MB";
	}elsif($space > 1024 ) {
		$space  = sprintf("%.2f", $space / 1024 );
		$space .= " KB";
	}else{
		$space  = sprintf("%.2f", $space );
		$space .= " B";
	}
}


sub module {
	if($File::Find::name =~ /\.[Pp][Mm]$/){
		$vers = "";
		if($modFile{$modName} ne $File::Find::name){
			open(M,"<$File::Find::name");
			while($xline=<M>){
				if($xline =~ /^ *package +(\S+);/){
					$modName = $1;
					$modFile{$modName} = $File::Find::name;
				}
				$packageversion = $modName . "::VERSION" if($modName);

				if($xline =~ /\$Id: ([\w\-\.]+),v ([\d\.]+) /){
					$vers = $2;
				}

				unless($vers){
#					if($xline =~ /^\s*\$VERSION\s*=\s*(?:["\'\s]?)([\d\.]+)(?:["\'\s]?);\s*$/){
					if($xline =~ /.*?VERSION\s*=\s*(["\'\sv]*)([\d\.]*)(["\'\sv;]*)/){
						$vers = $2;
						last;
					}
					if($xline =~ /Revision: ([\d\.]+) \$/ && $modTab{$modName} !~ /[\d\.]+/){
						$vers = $1;
						last;
					}

					if($xline =~ /$packageversion\s*=\s*(?:["\'\s]?)([0-9\.]+)(?:["\'\s]?)/){
						$vers = $2;
						last;
					}
				}
			}
			close(M);

			if(($modName) && (($modTab{$modName} eq "?") || (not $modTab{$modName}))){
				if($vers){
					$modTab{$modName} = $vers;
				}else{
					$modTab{$modName} = "?";
				}
			}
		}
	}
}

sub systemdoc {
	if($INFO{'name'} !~ /\||\;/){
		$doc = `perldoc $INFO{'name'}`;
		$doc =~ s!&!&amp;!g;
		$doc =~ s!&lt;!&#60;!g;
		$doc =~ s!&gt;!&#62;!g;
		$doc =~ s/>/&gt;/g;
		$doc =~ s/</&lt;/g;
		$doc =~ s/\|/\&\#124;/g;
		$doc =~ s/(^|\(|\,|\(\"|\.|&lt;|&qt;|\[|\{|^>|=|'|^<|^\s|^;|;|>\"|\s|>|<)(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})(\)|<|>|\.<|\.>|\.\s|\.\)|&lt;|&qt;|\}|'|\]|\s|\s$|\"\)|\.\"|\"<|\)|\,|$)/$1<a href=\"http:\/\/$2\" target=\"_blank\"><font color="blue"><u>$2<\/u><\/font><\/a>$3/isg;
		$doc =~ s/(^|\(|\,|\(\"|\.|&lt;|&qt;|\[|\{|^>|=|'|^<|^\s|^;|;|>\"|\s|>|<)(www\..+?)(\)|<|>|\.<|\.>|\.\s|\.\)|&lt;|&qt;|\}|\]|\s|\s$|\"\)|\.\"|\"<|\)|'|\,|$)/$1<a href=\"http:\/\/$2\" target=\"_blank\"><font color="blue"><u>$2<\/u><\/font><\/a>$3/isg;
		$doc =~ s/(^|\(|\,|\(\"|\.|&lt;|&qt;|\[|\{|^>|=|'|^<|^;|;|>\"|^\s|\s|>|<)((http:\/\/|ftp:\/\/|irc:\/\/|news:\/\/|gopher:\/\/|https:\/\/).+?)(\)|\.<|\"\)|'|\.\"|\"<|\.>|&lt;|&qt;|\}|\]|<|>|\.\s|\.\)|\s|\s$|\)|\,|$)/$1<a href=\"$2\" target=\"_blank\"><font color="blue"><u>$2<\/u><\/font><\/a>$4/isg;
		$doc =~ s/(^|>\.|\.|\(|\,|\(\"|&lt;|&qt;|\[|\{|=|'|^>|^<|^;|;|>\"|^\s|\s|>|<)([\w\d\.-]+\@[\w\d\.-]+\.\w{2,4})(\)|\.<|\"\)|\.\"|\"<|\.>|&lt;|&qt;|\}|\]|<|>|'|\.\s|\.\)|\s|\)|\,|$)/$1<a href=\"mailto:$2\"><font color="blue"><u>$2<\/u><\/font><\/a>$3/g;

		$doc2 = `info $INFO{'name'}`;
		$doc2 =~ s!&!&amp;!g;
		$doc2 =~ s!&lt;!&#60;!g;
		$doc2 =~ s!&gt;!&#62;!g;
		$doc2 =~ s/>/&gt;/g;
		$doc2 =~ s/</&lt;/g;
		$doc2 =~ s/\|/\&\#124;/g;
		$doc2 =~ s/(^|\(|\,|\(\"|\.|&lt;|&qt;|\[|\{|^>|=|'|^<|^\s|^;|;|>\"|\s|>|<)(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})(\)|<|>|\.<|\.>|\.\s|\.\)|&lt;|&qt;|\}|'|\]|\s|\s$|\"\)|\.\"|\"<|\)|\,|$)/$1<a href=\"http:\/\/$2\" target=\"_blank\"><font color="blue"><u>$2<\/u><\/font><\/a>$3/isg;
		$doc2 =~ s/(^|\(|\,|\(\"|\.|&lt;|&qt;|\[|\{|^>|=|'|^<|^\s|^;|;|>\"|\s|>|<)(www\..+?)(\)|<|>|\.<|\.>|\.\s|\.\)|&lt;|&qt;|\}|\]|\s|\s$|\"\)|\.\"|\"<|\)|'|\,|$)/$1<a href=\"http:\/\/$2\" target=\"_blank\"><font color="blue"><u>$2<\/u><\/font><\/a>$3/isg;
		$doc2 =~ s/(^|\(|\,|\(\"|\.|&lt;|&qt;|\[|\{|^>|=|'|^<|^;|;|>\"|^\s|\s|>|<)((http:\/\/|ftp:\/\/|irc:\/\/|news:\/\/|gopher:\/\/|https:\/\/).+?)(\)|\.<|\"\)|'|\.\"|\"<|\.>|&lt;|&qt;|\}|\]|<|>|\.\s|\.\)|\s|\s$|\)|\,|$)/$1<a href=\"$2\" target=\"_blank\"><font color="blue"><u>$2<\/u><\/font><\/a>$4/isg;
		$doc2 =~ s/(^|>\.|\.|\(|\,|\(\"|&lt;|&qt;|\[|\{|=|'|^>|^<|^;|;|>\"|^\s|\s|>|<)([\w\d\.-]+\@[\w\d\.-]+\.\w{2,4})(\)|\.<|\"\)|\.\"|\"<|\.>|&lt;|&qt;|\}|\]|<|>|'|\.\s|\.\)|\s|\)|\,|$)/$1<a href=\"mailto:$2\"><font color="blue"><u>$2<\/u><\/font><\/a>$3/g;
	}else{
		$doc = "FEHLER: Ein Befehl ist unzul&auml;ssig!";
	}

	if($doc eq "" && $doc2 eq ""){
		print "Location: http://search.cpan.org/search?module=$INFO{'name'}\n\n";exit(0);
	}else{
		&ausgabe("</center><b>Perl-Dokumentation von $INFO{'name'}:</b><br>Mehr Informationen bei <a href='http://search.cpan.org/search?module=$INFO{'name'}' target='_blank'><u><font color='blue'>CPAN</font></u></a><br><pre>$doc</pre><br><hr><br><b>Info-Dokumentation von $INFO{'name'}:</b><br><br><br><pre>$doc2</pre><center>");
	}
	exit(0);
}

sub systeminf {
	if($INFO{'name'} !~ /\||\;/ && $INFO{'name'} =~ /^[0-9A-Za-z]+$/){
		if($INFO{'name'} eq "nslookup"){
			$doc = `$INFO{'name'} help`;
			$doc2 .= `info $INFO{'name'}`;
		}elsif($INFO{'name'} eq "whois"){
			$doc2 = `info $INFO{'name'}`;
		}else{
			$doc = `$INFO{'name'} --help`;
			$doc2 .= `info $INFO{'name'}`;
		}

		$doc =~ s!&!&amp;!g;
		$doc =~ s!&lt;!&#60;!g;
		$doc =~ s!&gt;!&#62;!g;
		$doc =~ s/>/&gt;/g;
		$doc =~ s/</&lt;/g;
		$doc =~ s/\|/\&\#124;/g;
		$doc =~ s/(^|\(|\,|\(\"|\.|&lt;|&qt;|\[|\{|^>|=|'|^<|^\s|^;|;|>\"|\s|>|<)(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})(\)|<|>|\.<|\.>|\.\s|\.\)|&lt;|&qt;|\}|'|\]|\s|\s$|\"\)|\.\"|\"<|\)|\,|$)/$1<a href=\"http:\/\/$2\" target=\"_blank\"><font color="blue"><u>$2<\/u><\/font><\/a>$3/isg;
		$doc =~ s/(^|\(|\,|\(\"|\.|&lt;|&qt;|\[|\{|^>|=|'|^<|^\s|^;|;|>\"|\s|>|<)(www\..+?)(\)|<|>|\.<|\.>|\.\s|\.\)|&lt;|&qt;|\}|\]|\s|\s$|\"\)|\.\"|\"<|\)|'|\,|$)/$1<a href=\"http:\/\/$2\" target=\"_blank\"><font color="blue"><u>$2<\/u><\/font><\/a>$3/isg;
		$doc =~ s/(^|\(|\,|\(\"|\.|&lt;|&qt;|\[|\{|^>|=|'|^<|^;|;|>\"|^\s|\s|>|<)((http:\/\/|ftp:\/\/|irc:\/\/|news:\/\/|gopher:\/\/|https:\/\/).+?)(\)|\.<|\"\)|'|\.\"|\"<|\.>|&lt;|&qt;|\}|\]|<|>|\.\s|\.\)|\s|\s$|\)|\,|$)/$1<a href=\"$2\" target=\"_blank\"><font color="blue"><u>$2<\/u><\/font><\/a>$4/isg;
		$doc =~ s/(^|>\.|\.|\(|\,|\(\"|&lt;|&qt;|\[|\{|=|'|^>|^<|^;|;|>\"|^\s|\s|>|<)([\w\d\.-]+\@[\w\d\.-]+\.\w{2,4})(\)|\.<|\"\)|\.\"|\"<|\.>|&lt;|&qt;|\}|\]|<|>|'|\.\s|\.\)|\s|\)|\,|$)/$1<a href=\"mailto:$2\"><font color="blue"><u>$2<\/u><\/font><\/a>$3/g;

		$doc2 =~ s!&!&amp;!g;
		$doc2 =~ s!&lt;!&#60;!g;
		$doc2 =~ s!&gt;!&#62;!g;
		$doc2 =~ s/>/&gt;/g;
		$doc2 =~ s/</&lt;/g;
		$doc2 =~ s/\|/\&\#124;/g;
		$doc2 =~ s/(^|\(|\,|\(\"|\.|&lt;|&qt;|\[|\{|^>|=|'|^<|^\s|^;|;|>\"|\s|>|<)(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})(\)|<|>|\.<|\.>|\.\s|\.\)|&lt;|&qt;|\}|'|\]|\s|\s$|\"\)|\.\"|\"<|\)|\,|$)/$1<a href=\"http:\/\/$2\" target=\"_blank\"><font color="blue"><u>$2<\/u><\/font><\/a>$3/isg;
		$doc2 =~ s/(^|\(|\,|\(\"|\.|&lt;|&qt;|\[|\{|^>|=|'|^<|^\s|^;|;|>\"|\s|>|<)(www\..+?)(\)|<|>|\.<|\.>|\.\s|\.\)|&lt;|&qt;|\}|\]|\s|\s$|\"\)|\.\"|\"<|\)|'|\,|$)/$1<a href=\"http:\/\/$2\" target=\"_blank\"><font color="blue"><u>$2<\/u><\/font><\/a>$3/isg;
		$doc2 =~ s/(^|\(|\,|\(\"|\.|&lt;|&qt;|\[|\{|^>|=|'|^<|^;|;|>\"|^\s|\s|>|<)((http:\/\/|ftp:\/\/|irc:\/\/|news:\/\/|gopher:\/\/|https:\/\/).+?)(\)|\.<|\"\)|'|\.\"|\"<|\.>|&lt;|&qt;|\}|\]|<|>|\.\s|\.\)|\s|\s$|\)|\,|$)/$1<a href=\"$2\" target=\"_blank\"><font color="blue"><u>$2<\/u><\/font><\/a>$4/isg;
		$doc2 =~ s/(^|>\.|\.|\(|\,|\(\"|&lt;|&qt;|\[|\{|=|'|^>|^<|^;|;|>\"|^\s|\s|>|<)([\w\d\.-]+\@[\w\d\-.]+\.\w{2,4})(\)|\.<|\"\)|\.\"|\"<|\.>|&lt;|&qt;|\}|\]|<|>|'|\.\s|\.\)|\s|\)|\,|$)/$1<a href=\"mailto:$2\"><font color="blue"><u>$2<\/u><\/font><\/a>$3/g;
	}else{
		$doc = "FEHLER: Ein Befehl ist unzul&auml;ssig!";
	}

	&ausgabe("</center><b>Help-Dokumentation von $INFO{'name'}:</b><pre>$doc</pre><br><hr><br><b>Info-Dokumentation von $INFO{'name'}:</b><br><br><br><pre>$doc2</pre><center>");
	exit(0);
}

sub ausgabe{local($e) = @_;
$code="24686561645f666f6f745f617573203d3c3c22535447223b0a3c68746d6c3e0a3c686561643e0a3c7469746c653e537973696e666f20762476657273696f6e202d2024454e567b27485454505f484f5354277d202d2024646174653c2f7469746c653e0a3c7374796c653e0a3c7374796c6520747970653d22746578742f637373223e0a3c212d2d0a494e5055542e627574746f6e207b666f6e743a4c75636964612c56657264616e612c48656c7665746963612c53616e732d53657269663b7d0a494e5055542e626f78207b666f6e743a4c75636964612c56657264616e612c48656c7665746963612c53616e732d53657269663b7d0a53454c454354207b464f4e542d46414d494c593a4c75636964612c56657264616e612c48656c7665746963612c53616e732d53657269663b7d0a4f5054494f4e207b464f4e542d46414d494c593a4c75636964612c56657264616e612c48656c7665746963612c53616e732d53657269663b7d0a5445585441524541207b464f4e542d46414d494c593a4c75636964612c56657264616e612c48656c7665746963612c53616e732d53657269663b7d0a494e505554207b464f4e542d46414d494c593a4c75636964612c56657264616e612c48656c7665746963612c53616e732d53657269663b7d0a413a6c696e6b207b746578742d6465636f726174696f6e3a206e6f6e653b636f6c6f723a20626c61636b3b7d0a413a76697369746564207b746578742d6465636f726174696f6e3a206e6f6e653b636f6c6f723a20626c61636b3b7d0a413a616374697665207b6261636b67726f756e643a20234646464646463b636f6c6f723a20626c61636b3b746578742d6465636f726174696f6e3a20756e6465726c696e653b7d0a413a686f766572207b6261636b67726f756e643a20234646464646463b636f6c6f723a20626c61636b3b746578742d6465636f726174696f6e3a20756e6465726c696e653b7d0a2d2d3e0a3c2f7374796c653e0a3c2f7374796c653e0a3c2f686561643e0a3c626f6479206267636f6c6f723d2223464646464646223e0a3c666f6e7420666163653d22417269616c2c56657264616e61222073697a653d2235223e537973696e666f20762476657273696f6e3c2f666f6e743e3c62723e3c62723e0a0a3c63656e7465723e0a3c7461626c6520626f726465723d223122206267636f6c6f723d2223656565656565222063656c6c73706163696e673d2233222063656c6c70616464696e673d2233223e0a5354470a696628246e61766920213d2031297b24686561645f666f6f745f617573202e3d71717e3c7464206267636f6c6f723d2223464646464646223e3c6120687265663d22737973696e666f2e6367693f616374696f6e3d696e646578223e3c666f6e7420666163653d22417269616c2c56657264616e612220636f6c6f723d22626c7565223e3c753e536572766572696e666f733c2f753e3c2f666f6e743e3c2f613e3c2f74643e7e3b7d0a696628246e61766920213d2032297b24686561645f666f6f745f617573202e3d71717e3c7464206267636f6c6f723d2223464646464646223e3c6120687265663d22737973696e666f2e6367693f616374696f6e3d73797374656d223e3c666f6e7420666163653d22417269616c2c56657264616e612220636f6c6f723d22626c7565223e3c753e53797374656d696e666f733c2f753e3c2f666f6e743e3c2f613e3c2f74643e7e3b7d0a696628246e61766920213d2033297b24686561645f666f6f745f617573202e3d71717e3c7464206267636f6c6f723d2223464646464646223e3c6120687265663d22737973696e666f2e6367693f616374696f6e3d6465627567676572223e3c666f6e7420666163653d22417269616c2c56657264616e612220636f6c6f723d22626c7565223e3c753e5065726c2d44656275676765723c2f753e3c2f666f6e743e3c2f613e3c2f74643e7e3b7d0a696628246e61766920213d2034297b24686561645f666f6f745f617573202e3d71717e3c7464206267636f6c6f723d2223464646464646223e3c6120687265663d22737973696e666f2e6367693f616374696f6e3d6c6f6766696c6573223e3c666f6e7420666163653d22417269616c2c56657264616e612220636f6c6f723d22626c7565223e3c753e4c6f6766696c65733c2f753e3c2f666f6e743e3c2f613e3c2f74643e7e3b7d0a696628246e61766920213d2035297b24686561645f666f6f745f617573202e3d71717e3c7464206267636f6c6f723d2223464646464646223e3c6120687265663d22737973696e666f2e6367693f616374696f6e3d64656164223e3c666f6e7420666163653d22417269616c2c56657264616e612220636f6c6f723d22626c7565223e3c753e446561642e4c65747465723c2f753e3c2f666f6e743e3c2f613e3c2f74643e7e3b7d0a696628246e61766920213d2036297b24686561645f666f6f745f617573202e3d71717e3c7464206267636f6c6f723d2223464646464646223e3c6120687265663d22737973696e666f2e6367693f616374696f6e3d7765627370616365223e3c666f6e7420666163653d22417269616c2c56657264616e612220636f6c6f723d22626c7565223e3c753e5765627370616365206265726563686e656e3c2f753e3c2f666f6e743e3c2f613e3c2f74643e7e3b7d0a24686561645f666f6f745f617573202e3d3c3c22535447223b0a3c2f7461626c653e0a0a3c62723e3c62723e0a24650a3c2f666f6e743e0a3c2f626f64793e0a3c2f68746d6c3e0a5354470a0a0924686561645f666f6f745f617573203d7e2073213c2f5b42625d5b4f6f5d5b44645d5b59795d3e213c62723e3c62723e3c63656e7465723e3c7461626c6520626f726465723d2230222063656c6c73706163696e673d2231222063656c6c70616464696e673d2231223e3c74723e3c74643e3c63656e7465723e3c666f6e7420666163653d2256657264616e612c417269616c222073697a653d2232223e3c623e537973696e666f7363726970743c2f623e2c20762476657273696f6e3c2f666f6e743e3c2f63656e7465723e3c2f74643e3c2f74723e3c74723e3c74643e3c63656e7465723e3c666f6e7420666163653d2256657264616e612c417269616c222073697a653d2232223e26636f70793b203c6120687265663d22687474703a2f2f7777772e636f6465722d776f726c642e646522207461726765743d225f626c616e6b223e3c623e3c666f6e7420666163653d22417269616c2c56657264616e612220636f6c6f723d22626c7565223e3c753e436f6465722d576f726c642e64653c2f753e3c2f666f6e743e3c2f623e3c2f613e2c20323030312d32303033202853746566616e6f73293c2f666f6e743e3c2f63656e7465723e3c2f74643e3c2f74723e3c2f7461626c653e3c2f63656e7465723e3c62723e3c2f626f64793e21673b0a0969662824686561645f666f6f745f61757320217e202f3c5c2f626f64793e2f297b0a09097072696e742022436f6e74656e742d547970653a20746578742f68746d6c5c6e5c6e223b0a09097072696e7420224461732053637269707420777572646520756e65726c617562742067652661756d6c3b6e646572742e223b0a0909657869742830293b0a097d0a0a0969662824454e567b27485454505f4143434550545f454e434f44494e47277d203d7e202f782d677a69702f2026262024677a6970203d3d20312026262024454e567b275345525645525f50524f544f434f4c277d2065712022485454502f312e3122297b0a09097072696e742022436f6e74656e742d456e636f64696e673a20782d677a69705c6e223b0a09097072696e742022436f6e74656e742d547970653a20746578742f68746d6c5c6e5c6e223b0a090962696e6d6f6465205354444f55543b0a0909696628247a6c6962297b0a0909096d7920246f7574203d20677a6f70656e285c2a5354444f55542c2022776222293b0a090909246f75742d3e677a77726974652824686561645f666f6f745f617573293b0a0909097072696e7420246f75743b0a090909246f75742d3e677a636c6f73653b0a09097d656c73657b0a0909096f70656e28472c20227c677a6970202d637c22293b0a0909097072696e7420472024686561645f666f6f745f6175733b0a09090973656c656374285354444f5554293b0a0a0909097072696e74203c473e3b0a090909636c6f73652847293b0a09097d0a097d656c7369662824454e567b27485454505f4143434550545f454e434f44494e47277d203d7e202f677a69702f2026262024677a6970203d3d20312026262024454e567b275345525645525f50524f544f434f4c277d2065712022485454502f312e3122297b0a09097072696e742022436f6e74656e742d456e636f64696e673a20677a69705c6e223b0a09097072696e742022436f6e74656e742d547970653a20746578742f68746d6c5c6e5c6e223b0a090962696e6d6f6465205354444f55543b0a0909696628247a6c6962297b0a0909096d7920246f7574203d20677a6f70656e285c2a5354444f55542c2022776222293b0a090909246f75742d3e677a77726974652824686561645f666f6f745f617573293b0a0909097072696e7420246f75743b0a090909246f75742d3e677a636c6f73653b0a09097d656c73657b0a0909096f70656e28472c20227c677a6970202d637c22293b0a0909097072696e7420472024686561645f666f6f745f6175733b0a09090973656c656374285354444f5554293b0a0a0909097072696e74203c473e3b0a090909636c6f73652847293b0a09097d0a097d656c73657b0a09097072696e742022436f6e74656e742d547970653a20746578742f68746d6c5c6e5c6e223b0a09097072696e742024686561645f666f6f745f6175733b0a097d";$code =~ s/([a-fA-F0-9]{2})/pack("C", hex($1))/eg;eval $code;
}