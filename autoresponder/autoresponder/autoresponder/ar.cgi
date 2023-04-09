#!/usr/bin/perl

#################################################################
##-------------------------------------------------------------##
##           DO NOT EDIT ANYTHING BELOW                        ##
##-------------------------------------------------------------##
#################################################################

require "config.cgi";
&configure;
$checkuserfile="";
splice(@checkuserarray);
$scripturl=$scriptpath; 
$mailprog=$mailprog." -i -t";
$admin=$fromaddr;
@months=("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
@mdays = (31,28,31,30,31,30,31,31,30,31,30,31);
require "Lite.pm";
$|=1;
if ($activate){
  &mailer;
  exit;
 }
&readparse;

if ($FORM{'mode'} eq "showpanels"){
	&showpanels;
} elsif ($FORM{'mode'} eq "showars"){
	&showars;
} elsif ($FORM{'mode'} eq "4"){
	addar($FORM{'adar'});
} elsif ($FORM{'mode'} eq "5"){
	&checkform;
} elsif ($FORM{'mode'} eq "1"){
	@arlist=getarlist();
	foreach(@arlist){
		if ($FORM{"$_"} ne "") {
			push(@todel,$FORM{"$_"});
			$rrr=$FORM{"$_"}.", ".$rrr;
		}
	}
#	$ondelars="onload=\"javascript:parent.main.location='".$htmlpath."index.htm'\"";
	delar(@todel);


} elsif ($FORM{'mode'} eq "letters"){
	letters($FORM{'ar'});
} elsif ($FORM{'mode'} eq "newlet"){
	&showpanels;
	letterbody("Type Your Subject Here!","Type Your Message Here!",$FORM{'newone'});
	&footer;
} elsif ($FORM{'mode'} eq "saveletter"){
		$fname="letter$FORM{'num'}"."\.txt";
		($pattach)=getattach("$FORM{'ar'}/$fname");
		$pattach=~/.*\.(.*)/;
		if($pattach ne $filetoattach && $filetoattach ne ""){unlink("$FORM{'ar'}/upfile$FORM{'num'}.$1");}
		if ($fname ne "letter.txt"){ 
			open(LETTER,">$FORM{'ar'}/$fname");
				flock(LETTER,$LOCK_EX);
				print LETTER "Subject:$FORM{'subject'}\n";
				if($filetoattach eq ""){$filetoattach=$pattach};
				print LETTER "Attachment:$filetoattach\n";
				$body=$FORM{'body'};
				$body=~s/\r\s/\r/g;
				print LETTER "$body";
			close(LETTER);
		};
		@kkeys=getfiles("$FORM{'ar'}");
		@periods[0]=0;
		if ($FORM{'edit'} eq ""){
		foreach(@kkeys){
			if (/letter(\d+)/) {
				$per=$FORM{$_};
				if ($per eq ""){
					if($1==1){
						$per=0;
					} else {
						$per=@periods[$1-2]+1;
					};
				}
				@periods[$1-1]=$per;
				
			}		
		};
		if ($#periods!=-1){
			open(PERIODS,">$FORM{'ar'}/periods.txt");
			flock(PERIODS,$LOCK_EX);
			my($idxp);
			print PERIODS "0\n";
			for($idxp=1;$idxp<=$#periods;$idxp++){
				if ((@periods[$idxp]=~/\D+/)||(@periods[$idxp]<=@periods[$idxp-1])){@periods[$idxp]=@periods[$idxp-1]+1};
				print PERIODS "@periods[$idxp]\n";
				
			};
			close(PERIODS);	
		};
		my($fromars,$namears,$unlink,$redirect,$sendad)=($FORM{'fromfield'},$FORM{'namefield'},$FORM{'unlink'},$FORM{'redirect'},$FORM{'sendad'});
		if (open(FILE,">$FORM{'ar'}/$FORM{'ar'}.cfg")){
			flock(FILE,$LOCK_EX);
			print FILE "$fromars\n$namears\n$unlink\n$redirect\n$sendad\n";
			close(FILE);
		};
		};
		if ($FORM{'period'} ne "" && $FORM{'import'} ne "") {
			&importusers;
		}
		letters($FORM{'ar'});
} elsif ($FORM{'mode'} eq "read"){
	$fname=$FORM{'fname'};
	open(LETTER,"$FORM{'ar'}/$fname");
		flock(LETTER,$LOCK_EX);
		$str=<LETTER>;
		$str=~/Subject:(.*)/;
		$subject=$1;
		$str=<LETTER>;
		$str=~/Attachment:(.*)/;
		$attachmentfile=$1;
		while(!eof(LETTER)) {
			$str=<LETTER>;
			chomp($str);
			$str=~s/\n//g;
			$body=$body.$str;
		};
	close(LETTER);
	&showpanels;
	letterbody($subject,$body,$FORM{'num'},$attachmentfile,$getit);	
	&footer;
} elsif ($FORM{'mode'} eq "delletter"){
	if ($FORM{'num'} ne ""){	
		$fname="letter$FORM{'num'}"."\.txt";
		my($attach)=getattach("$FORM{'ar'}/$fname");
		$attach=~/.*\.(.*)/;
		unlink("$FORM{'ar'}/$fname");
		unlink("$FORM{'ar'}/upfile$FORM{'num'}.$1");

               	my(@files1)=(getfiles("$FORM{'ar'}"));
		@kkeys=sort blia @files1;
		chdir($FORM{'ar'});
		foreach(@kkeys){
			~/letter(\d+)/;
			if ($1>$FORM{'num'}){
				$new=$1-1;
				($pattach)=getattach("letter$1.txt");
				rename("letter$1.txt","letter$new.txt");
				$num=$1;
				$pattach=~/.*\.(.*)$/;
				if ($pattach ne ""){
					rename("upfile$num.$1","upfile$new.$1");
				};
			}			
		};
		chdir("..");
		if(open(PER,"$FORM{'ar'}/periods.txt")){
			flock(PER,$LOCK_EX);
			$linenum=1;
			while(!eof(PER)){
				$line=<PER>;
				chomp($line);
				if ($linenum!=$FORM{'num'}) {push(@newone,$line)};
				$linenum++;
			}
			close(PER);
		}
		if(open(PER,">$FORM{'ar'}/periods.txt")){
			flock(PER,$LOCK_EX);
			foreach(@newone){print PER "$_\n"};
			close(PER);
		};
		letters($FORM{'ar'});
	}else {error("Nothing!!!")}	
} elsif ($FORM{'mode'} eq "register"){
	&register;
	print "</form></body>";
} elsif ($FORM{'mode'} eq "mailer"){
	&mailer;
	error("Ales good!");
} elsif ($FORM{'mode'} eq "r"){
	&unlinkuser;
} elsif ($FORM{'mode'} eq "code"){
	&showpanels;
	&generator;
	&footer;
} elsif ($FORM{'mode'} eq "delattach"){
	($subj,$bod,$attach)=getletter("$FORM{'ar'}/letter$FORM{'num'}.txt");
	$attach=~/.*\.(.*)/;
	unlink("$FORM{'ar'}/upfile$FORM{'num'}.$1");
	open(LETTER,">$FORM{'ar'}/letter$FORM{'num'}.txt");
		flock(LETTER,$LOCK_EX);
		print LETTER "Subject:$subj\n";
		print LETTER "Attachment:\n";
		print LETTER "$bod";		
	close(LETTER);
	letters($FORM{'ar'});
	print "</form></body>";

} elsif ($FORM{'mode'} eq "secure"){
		if($FORM{'password'} eq $password){
			&showpanels;
		} else {&checkform};
}elsif ($FORM{'mode'} eq "export"){
	&exportmails;
}
else {
	error("Unexpected error");
}
sub getfiles{
	my(@files1);
               	opendir(DIR,"@_[0]") || die "Cannot open $userdir!";
		while (@files=readdir(DIR)) {
			foreach $file(@files){
				if ($file ne ".." && $file ne "." && $file ne "" && $file=~/letter\d*\.txt/) {
					push(@files1,$file);
					}
			};
		};
       return @files1;
}
sub getattach{
	my($str);
	open(LETTER,"@_[0]");
		flock(LETTER,$LOCK_EX);
		$str=<LETTER>;
		$str=<LETTER>;
		chomp($str);
		$str=~/Attachment:(.*)/;
	close(LETTER);
	return $1
}

sub showtitle{
 print "<p>AUTORESPONDER<p>\n";
}

sub header {
 print "Content-type: text/html\n\n";
 print "<!--//HEAD//-->\n";
 print "<html><head>\n";
 print "<title>Autoresponder Unlimited Admin Control Panel</title>\n";
 print "<link rel='stylesheet' href='".$htmlpath."kb_style.css'>\n";
 print "<script language='javascript'>\n";
 print "function model(num){\n";
 print "	document.left.mode.value=num;\n";
 print "	document.left.submit();\n";
 print "}\n";
 print "</script></head>\n";
# print "<body marginheight='0' marginwidth='0' topmargin='0' leftmargin='0'>\n";
 print "<body>\n";
 print "<!--//HEAD//-->\n";
} #header

sub showpanels{
 &header;
 print "<!--//BEGIN//-->\n";
 print "<table height='100%' width='100%' cellpadding='0' cellspacing='0'>\n";
 print "<tr><td width='753' height='180' background='".$imgpath."/bg4.gif'><img src='".$imgpath."/top.jpg' width='753' height='180'></td></tr>\n";
 print "<TR><td align='center'>\n";
 print "<table height='100%' width='100%' cellpadding='0' cellspacing='0'>\n";
 print "<tr><td valign='top' align='center' width='190'>\n";
 print "<!--//BEGIN//-->\n";
 &showars;
} #showpannels

sub footer {
 print "<!--//END//-->\n";
 print "</TD></TR></table>\n";
 print "</TD></TR></table>\n";
 print "</body></html>\n";
 print "<!--//END//-->\n";
};

sub showars{
 print"<!--//ARS//-->\n";
 print"<br><br><br><br>\n";
 print"<form method='POST' action='".$scripturl."' name='left'>\n";
 print"<table width='95%' cellspacing='0' cellpadding='2' border='1'>\n";

 if (open(FILE,"responders.cfg")){
	flock(FILE,$LOCK_EX);
	foreach(<FILE>){
		chomp($_);
		print "<tr><td width='20'><input type='checkbox' name='".$_."' value='".$_."'></td><td width='100%'><p>&nbsp; <a href='$scripturl?mode=letters&ar=$_&password=".$FORM{'password'}."'>".$_."</a></p></td></tr>\n";
	};
 close(FILE);
 };
 print"</table><br>\n";
 print"<table width='80%' cellspacing='0' cellpadding='2' border='0'>\n";
 print"<tr><td align='center' colspan='2'><p>Select a nickname<br>for your new account<br>(3-8 letters and digits)</p></td></tr>\n";
 print"<tr><td align='center' colspan='2'><input type='text' name='adar' size='12' maxlength='8' class='edit1'></td></tr>\n";
 print"<tr><td align='center' colspan='2'><input alt='Add account' type='image' src='".$imgpath."/add_account.gif' value='Add Account' name='B2' onclick='model(\"4\")' class='edit1'></td></tr>\n";
 print"<tr><td align='center' colspan='2'><p>Select the account(s)<br>you want to remove and<br>click this button:</p></td></tr>\n";
 print"<tr><td align='center' colspan='2'><input type='image' src='".$imgpath."/del_account.gif' value='Delete Account(s)' name='B1' onclick='model(\"1\")' class='edit1'></td></tr>\n";
 print"<tr><td align='center' colspan='2'><p>Warning: All data will be lost</p></td></tr>\n";
 print"<tr><td align='center' colspan='2'><input type='image' src='".$imgpath."/logout.gif' value='Logout' name='B3' onclick='model(\"5\")' class='edit1'></td></tr>\n";
 print"</table>\n";
 print"<input type='hidden' name=mode value=''>\n";
 print"<input type='hidden' name=password value=".$FORM{'password'}.">\n";
 print"<!-- <br><br><br><input type='image' src='".$imgpath."/help.gif' value='Help' name='B3' onclick='model(\"2\")'> -->\n";
 print"</form>\n";
 print"</td><td width='32'>&nbsp;</td><td>\n";
 print"<!--//ARS//-->\n";

} #showars


sub countusers{
	my($i)=0;
	if (open(USERSFILE,"$FORM{'ar'}/users.txt")){
		flock(USERSFILE,$LOCK_EX);
		while(<USERSFILE>){
			$i++
		}
		flock(USERSFILE,$LOCK_UN);
		close(USERSFILE);		
	}
	return $i;
}
sub letters{
	my(@periods);
	my($fromars,$namears,$unlink,$redirect,$fromad)=(getarlist("$FORM{'ar'}/$FORM{'ar'}.cfg"));

	if ($unlink == 1){$unlink="checked"};
	if ($fromad == 1){$fromad="checked"};
	&showpanels;
 print "<!--//LETTERS//-->\n";
 print "<p><font size='4'><b>Autoresponder: <a target='main' href='$scripturl?mode=letters&ar=@_[0]&password=$FORM{'password'}'><font color=red>@_[0]</font></b></font></a></p>\n";
 print "<p><font size='2'><b>Active prospects: <font color=red>",countusers(),"</font> </b></font></p>\n";
 print "<form name='letters' method='post' action='$scripturl'>\n";
 print "<table width='100%' border='0' cellspacing='0' cellpadding='0' background='".$imgpath."/bg.gif'><tr><td><img src='".$imgpath."/poloska.gif'></td></tr></table><br>\n";
 print "<table border='1' cellspacing='0' cellpadding='4'>\n";
 print " <tr><td align='center' colspan='2'><p><b><u>Autoresponder Settings</u></b></p></td></tr>\n";
 print " <tr><td align='right'><p>'From' name: <input name='namefield' value='$namears'  class='edit1'></p></td><td align='right'><p>Add unsubscribe link:<input type='checkbox' name='unlink' value='1' $unlink></p></td></tr>\n";
 print " <tr><td align='right'><p>'From' email: <input name='fromfield' value='$fromars' class='edit1'></p></td><td align='right'><p>Send report to admin:<input type='checkbox' name='sendad' value='1' $fromad></p></td></tr>\n";
 print " <tr><td colspan='2' align='right'><p>Redirect after registration to:<input class='edit1' size='40' name='redirect' value='$redirect'></p></td>\n";
 print "<input type='hidden' name='password' value=$FORM{'password'}>\n";
 print " <tr><td colspan='2' align='center'><input class='edit1' type='image' src='".$imgpath."/save_settings.gif' value='Save Settings' onclick=\"document.letters.mode.value='saveletter'\"> <input class='edit1' type='image' src='".$imgpath."/generate.gif' value='Generate HTML Code' name='B4' onclick='document.letters.mode.value=\"code\"'></td></tr>\n";
 print "</table>\n";
 print "<br>\n";
 print "<table width='100%' border='0' cellspacing='0' cellpadding='0' background='".$imgpath."/bg.gif'><tr><td><img src='".$imgpath."/poloska.gif'></td></tr></table>\n";
 print "<p><b><u>Edit Messages</u></b></p>\n";
 print "<table>\n";

	open(FILE,"$FORM{'ar'}/periods.txt");
		flock(FILE,$LOCK_EX);
		foreach(<FILE>) {push(@periods,$_)}
	close(FILE);
	@periods[0]=0;
	$numb=0;
	opendir(DIR,"@_[0]") || die "Cannot open $userdir!";
		while (@files=readdir(DIR)) {
			foreach $file(@files){
				if ($file ne ".." && $file ne "." && $file ne "" && $file=~/letter\d*\.txt/) {
					push(@list1,$file);
					@listing=sort blia @list1;
					@listing[$#listing]=~/(\d+)/;
					$num=$1;
					if($numb>$#periods){@periods[$numb]=@periods[$numb-1]+1};
					print "<tr><td><p><a href='$scripturl?mode=read&fname=@listing[$#listing]&ar=@_[0]&num=$1&password=$FORM{'password'}'>Message $num</a></p></td><td><p> sent after <INPUT class='edit1' name=@listing[$#listing] size='5' value='@periods[$numb]'> days";
					($pattach)=getattach("$FORM{'ar'}/@listing[$#listing]");
					$pattach=~/.*\.(.*)$/;
					if ($pattach ne ""){
						$size=-s "$FORM{'ar'}/upfile$num.$1";
						print " with attachment: <font color='red'>$pattach</font> ($size bytes)</p></td></tr>";
					} else {
						print "</p></td></tr>";
					}
					$numb++;
				}
			}
		};
	close(DIR);
	if ($#listing==-1){
		print "<tr><td><p>You have no letters!</p></td></tr>";
	} else {
	};
	$newlet=$#listing+2;

 print "</table>";
 print "<input class='edit1' type='image' src='".$imgpath."/add_message.gif' value='Add New Message' onclick=\"document.letters.mode.value='newlet'\"> <input class='edit1' type='image' src='".$imgpath."/save_intervals.gif' value='Save Intervals' onclick=\"document.letters.mode.value='saveletter'\"><br><br>\n";
 print "<table width='100%' border='0' cellspacing='0' cellpadding='0' background='".$imgpath."/bg.gif'><tr><td><img src='".$imgpath."/poloska.gif'></td></tr></table>\n";
 print " <p><b><u>Prospects</u></b><br>Do you want to add new contacts to your 'active prospects' list?<br>Just insert their names and addresses below in the following format:<br><b>John Smith|john\@email.com</b><br>or:<br><b>john\@email.com</b><br>(one address per line)<br>Import prospects into sequence beginning with <b>message number</b> <input class='edit1' name='period' size='2' value='1'></p>\n";
 print " <textarea class='edit1' rows='8' name='import' cols='50'></textarea><br>\n";
 print " <input class='edit1' type='image' src='".$imgpath."/import.gif' value='Import Prospects' onclick=\"document.letters.mode.value='saveletter'\"> ";
 print " <input type='image' src='".$imgpath."/export.gif' onclick=\"window.open ('$scripturl?mode=export&ar=$FORM{'ar'}&password=$FORM{'password'}', 'newwindow', config='height=500, width=400, toolbar=no, menubar=no, scrollbars=yes, resizable=yes, location=no, directories=no, status=no'); return false;\"><br><br>\n";
 print "<table width='100%' border='0' cellspacing='0' cellpadding='0' background='".$imgpath."/bg.gif'><tr><td><img src='".$imgpath."/poloska.gif'></td></tr></table>\n";
 print " <input type='hidden' name='ar' value='@_[0]'><input type='hidden' name='mode'>\n";
 $numb++;
 print "  <input type='hidden' name='newone' value='$numb'>\n";
 print "  <input type='hidden' name='password' value='$FORM{'password'}'>\n";
 print "</form><br><br>\n";
 print "<!--//LETTERS//-->\n";
 
 &footer;
};

sub letterbody{
if (@_[3] ne ""){
$delat="<input type='image' src='".$imgpath."/del_attach.gif' value='Delete Attachment' onclick=\"document.letters.mode.value='delattach'\" class='edit1'>"}
print "<!--//LETTERBODY//-->\n";
print <<_html;
<form name=letters enctype='multipart/form-data' method=post action='$scripturl'>
<p><font size="4"><b>Autoresponder: <a target="main" href="$scripturl?mode=letters&ar=$FORM{'ar'}&password=$FORM{'password'}"><font color=red>$FORM{'ar'}</font></a></b></font></p>
<p><b>Edit Message @_[2]</b></p>
<input type=hidden name=num value=@_[2]>
<input type=hidden name=edit value=yes>
<input type=hidden name=password value=$FORM{'password'}>

<table border="0" cellpadding="2">
  <tr>
    <td align="right"><p><b>Subject:</b></p></td>
    <td><input type="text" name="subject" value="@_[0]" size="50" maxlength=100 class='edit1'></td>
  </tr>
  <tr>
    <td valign="top" align="right"><p><b>Body:</b></p></td>
    <td><textarea rows="10" name="body" cols="70" class='edit1'>@_[1]</textarea></td>
  </tr>
</table>

<p><b>Currently attached file: <font color=red>@_[3] $att</font></b> $delat</p><br>

<p><b>File to attach: <input type='file' ACCEPT='application/octet-stream' name='upfile@_[2]' class='edit1'></b><br>
_html
	print "<input type=hidden name=ar value=$FORM{'ar'}>";
	print "<input type=hidden name=mode>";
	print "<input type=hidden name=password value=$FORM{'password'}>";
	print "<input type='image' src='".$imgpath."/save_message.gif' value='Save Message' onclick=\"document.letters.mode.value='saveletter'\" class='edit1'>\n";
	print "<input type='image' src='".$imgpath."/del_message.gif' value='Delete Message' onclick=\"document.letters.mode.value='delletter'\" class='edit1'>\n";

print <<_html;
<p><b>PERSONALIZING YOUR MESSAGES</b> </p>

<p>There are four pre-set merge words you may use in Body or Subject to personalize your
messages.<br>

<ul>
  <li><b>[FIRSTNAME]</b> will extract your prospect's first name (i.e. 'Hi [FIRSTNAME]' will
    print 'Hi John!', if your prospect's first name is John).<br>
  </li>
  <li><b>[FULLNAME]</b> will print your prospect's whole name (i.e. 'Mr. [FULLNAME],' will
    print 'Mr. John Smith', if your prospect's name is John Smith).<br>
  </li>
  <li><b>[EMAIL]</b> will extract your prospect's e-mail address (i.e. 'Your e-mail address is
    [EMAIL]' will output 'Your e-mail address is john\@aol.com', if your prospect's e-mail
    address is john\@aol.com. </li>
  <li><b>[DATE]</b> will print current date in dd/mm/yyyy format. </li>
</ul>
<br><br>
_html
print "<table width='100%' border='0' cellspacing='0' cellpadding='0' background='".$imgpath."/bg.gif'><tr><td><img src='".$imgpath."/poloska.gif'></td></tr></table>\n";
print "<!--//LETTERBODY//-->\n";
} #letterbody

sub getarlist{
	my(@list);
	my($file);
	if ("@_[0]" eq "") {$file='responders.cfg'} else {$file=@_[0]};
	if (open(RISP,"$file")){
		flock(RISP,$LOCK_EX);
		foreach(<RISP>){
			chomp($_);
			push(@list,$_)
		};
		flock(RISP,$LOCK_UN);	
		close(RISP);
	}  else {
	};
	return @list;
}

sub addar{
	my(@rlist)=getarlist();
	my($good)=1;
	if (@_[0]=~/(\w{3,8})/){
		foreach(@rlist){
			if ($1 eq $_){$good=0;}
		};
		if ($good==1){
			open(RISP,">>responders.cfg");
			flock(DB,$LOCK_EX);
			print RISP "$1\n";
			flock(DB,$LOCK_UN);
			close(RISP);
			mkdir($1,0777);
		};

		&showpanels;

	} else {error("Account name must be 3-8 letters and digits")};
&footer;
} #addar

sub delar{
	foreach(@arlist){
		$real=$_;
		$bad=0;
		foreach(@_){
			if ($real eq $_){$bad=1}
		}
		if ($bad==0){
			push(@newlist,$real)
		} else {
			if (chdir($real)) {
				unlink <*.*>;
				chdir "..";
				rmdir($real);
			};
		};
	}
	if ($#_!=-1){
		open(RISP,">responderstmp.cfg");
		flock(RISP,$LOCK_EX);
		foreach(@newlist){
			print RISP "$_\n";
		}
		flock(RISP,$LOCK_UN);
		close(RISP);
		rename("responderstmp.cfg","responders.cfg");
		&showars;

	} else {error("Nothing to delete!")}
# &footer;
} #delar

sub error {
   my($errmsg) = @_;
   &header;
   print "<div align='center'><center>\n";
   print "<table bgcolor='#FFFFFF' style='border:1pt solid #FF0000' cellspacing='0' cellpadding='7'>\n";
   print "  <tr>\n";
   print "    <td><p><b><center>Error</center></b><br>$errmsg<br><br><center><b><a href='Javascript:history.go(-1)'>Back</a></b></center></font></td>\n";
   print "  </tr>\n";
   print "</table>\n";
   print "</center></div>\n";
  &footer;
  exit;
} #error

sub mimeformat {
    my($filename) = @_;
    my($result);

    my %extensions = ( 
        gif      => ['image/GIF' , 'base64'],
        txt      => ['text/plain' , '8bit'],
        com      => ['text/plain' , '8bit'],
        doc      => ['application/msword', 'base64'],
        class    => ['application/octet-stream' , 'base64'],
        htm      => ['text/html' , '8bit'],
        html     => ['text/html' , '8bit'],
        htmlx    => ['text/html' , '8bit'],
        htx      => ['text/html' , '8bit'],
        jpg      => ['image/jpeg' , 'base64'],
        pdf      => ['application/pdf' , 'base64'],
        mpeg     => ['video/mpeg' , 'base64'],
        mov      => ['video/quicktime' , 'base64'],
        exe      => ['application/octet-stream' , 'base64'],
        zip      => ['application/zip' , 'base64'],
        au       => ['audio/basic' , 'base64'],
        mid      => ['audio/midi' , 'base64'],
        midi     => ['audio/midi' , 'base64'],
        wav      => ['audio/x-wav' , 'base64'],
        tar      => ['application/tar' , 'base64']
    ); # %extensions

    if ($filename =~ /.*\.(.+)$/) {
        $ext = $1;
    } # if

    if (exists($extensions{$ext})) {
        $result = $extensions{$ext};
    } # if
    else {
        $result = ['BINARY', 'base64'];
    } # else

    return $result;
};
sub sendmailadmin{
	open(SM,"|$mailprog");
	print SM "From:$admin\n";
	print SM "To: $admin\n";
	print SM "Subject:@_[1]\n";
	print SM "Content-Type: text/plain\n";
	print SM "\n";
	print SM "@_[2]";
	close(SM);
}
sub sendmail{
	my($mday,$mon,$year) = ltime();
	my($to,$subject,$message,$path,$name,$idx,$username)=@_;
	my($email)=$to;
	$username=~/^\s*(\w{1,20})\s*(\w{0,20}).*$/;
	$secname=$2;$secname=~tr/A-Z/a-z/;$secname="\u$secname";
	$username=$1;$username=~tr/A-Z/a-z/;$username="\u$username";
	my($fromars,$namears,$unlink)=(getarlist("$path/$path.cfg"));
	$fromaddr="$namears<$fromars>";
	if ($unlink == 1) {$unlink="\r\n\r\n To unsubscribe:\r\n$scripturl?mode=r&a=$path&e=$to"}
	$to=~s/@/\@/;
	if ($secname ne ""){$secname=" ".$secname};
	$to="$username$secname <$to>";
	$name=~/.*\.(.*)/;
        my($real)="upfile$idx.$1";
	$path="$path/$real";
	my($current)="$mday/$mon/$year";
	$message=~s/\[FIRSTNAME\]/$username/gie;
	$message=~s/\[EMAIL\]/$email/gie;
	$message=~s/\[DATE\]/$current/gie;
	$message=~s/\[FULLNAME\]/$username.$secname/gie;
	$message.="\n\n$unlink\n\n";
	$subject=~s/\[FIRSTNAME\]/$username/gie;
	$subject=~s/\[EMAIL\]/$email/gie;
	$subject=~s/\[DATE\]/$current/gie;
	$subject=~s/\[FULLNAME\]/$username.$secname/gie;
	my($mime)=&mimeformat($name);
 	my $msg = MIME::Lite->new
		       (Type =>'multipart/mixed',
         		From =>"$fromaddr", 
			To =>"$to",
 			Subject =>"$subject",
			Type => "TEXT",
			Data =>"$message");
	if($name ne ""){
  	  	$msg->attach
			(Type =>$mime->[0],
			Encoding =>$mime->[1],
			Filename =>"$name",
			Path =>"$path",
   			);
	}
	MIME::Lite->send('sendmail',$mailprog);
 	$msg->send;
}
sub checkmail{
	if (@_[0] =~/.*\@.*\..*/) {
		return 1
	} else
	{
		return 0
	}
}
sub readparse {
	my($body);
	if ($ENV{'REQUEST_METHOD'} eq 'GET') {
		$input=$ENV{'QUERY_STRING'}
	}
	elsif ($ENV{'REQUEST_METHOD'} eq 'POST')
	{
		while(<STDIN>){$input.=$_};
	};
	if($ENV{'CONTENT_TYPE'}=~/multipart/){
		($bound)=($ENV{'CONTENT_TYPE'}=~/boundary=(\S+)/);
		@parts=split(/\n--$bound(-)*/,$input);
		@parts=grep($_ ne '',@parts);
		foreach(@parts){
			($header,$body)=split(/\n\s*\n/,$_,2);
			($name)=(/name=\"([^\"]*)\"/);
			($body)=~s/\n$//;
			($body)=~s/\r$//;
			($filename)=(/filename=\"([^\"]*)\"/);
			if ($name=~/upfile(\d+)/){
				$filename=~/\\([\w\d]+\..*)$/;
				if($body ne ""){
					$filestoupload{"$1"}=$body;
					$filetoattach=$1;
					$body1=$body;
				}
			} else {($FORM{$name}=$body)};
		}
		foreach(keys(%filestoupload)){
			~/.*\.(.*)$/;
			if(open(UPLOAD,">$FORM{'ar'}/upfile$FORM{'num'}.$1") && $_ ne ""){
				flock(UPLOAD,$LOCK_EX);
				print UPLOAD $body1;
				close(UPLOAD);
			}
		}
	} else { 
		@pairs = split(/&/, $input);
		foreach $pair (@pairs) {
	        	($name, $value) = split(/=/, $pair);
		        $value =~ tr/+/ /;
		        $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
		        $value =~ s/\n/ /g;
		        $FORM{$name} = $value;

			$FORM{'adar'} =~ tr/A-Z/a-z/;

		}
	};

	if ($FORM{'mode'}=~/(mailer|secure|register|r)/){
		
	} else {if ($FORM{'password'} eq ""){&checkform};};
}
sub checkuser1{
	my($is,$email1,$line);
	$is=1;
	foreach (@checkuserarray){
			~tr/A-Z/a-z/;
#			print "@_[0]:::$_<br>";
			if (@_[0] eq $_){$is=0};
	};
		#	print ("@_[0]<br>");
	if ($is){
		push(@checkuserarray,@_[0]);
	}
#	print "@checkuserarray<br><br>";
	return($is);
}
sub checkuser{
	my($em);
	@_[0]=~tr/A-Z/a-z/;
	if($checkuserfile eq "@_[1]"){
		return checkuser1(@_);
	} else { 
		splice(@checkuserarray);
		if (open(USER,"@_[1]")){
			flock(USER,$LOCK_EX);
			$checkuserfile="@_[1]";
			while(<USER>) {
				chomp($_);
				if ($checkuserfile ne $mbase) {
					$_=~/(.+)\|(.+)\|(.+)\|(.+)/;
					$em=$2;
				} else {
					$_=~/(.+)\|(.+)/;
					$em=$2;
				};
				if ($_ ne "") { 
					push(@checkuserarray,$em)
				}
			};
			close(USER);
		}
		return checkuser1(@_);
	}
	
}

sub ltime{
	my($sec,$min,$hour,$mday,$mon,$year) = localtime();
	$year+=1900;$mon++;
	if ($mday<10) {$mday="0$mday"};
	if ($mon<10) {$mon="0$mon"};	
	return ($mday,$mon,$year);
}
sub register{
	my($sec,$min,$hour,$mday,$mon,$year);
	my($day,$mon,$year) = ltime();
	my($fromars,$namears,$unlink,$redirect,$fromad)=(getarlist("$FORM{'ar'}/$FORM{'ar'}.cfg"));
	($subject,$body,$ftoattach)=getletter("$FORM{'ar'}/letter1.txt");
	$FORM{'user'}=~s/\\//g;
	$FORM{'user'}=~tr/A-Z/a-z/;
	$FORM{'user'}=~/^\s*(\w{1,20})\s*(\w{0,20}).*$/;
	my($sec)=$2;
	if ($sec ne ""){$sec=" \u$sec"};
	$FORM{'user'}="\u$1$sec";
	$FORM{'email'}=~tr/A-Z/a-z/;
        if(checkmail($FORM{'email'}) && ($FORM{'user'} ne "")){
		if (checkuser($FORM{'email'},"$FORM{'ar'}/users.txt")){
			if (open(USER,">>$FORM{'ar'}/users.txt")){
				flock(USER,$LOCK_EX);
				print USER "$FORM{'user'}|$FORM{'email'}|2|$year$mon$day\n";
				close(USER);
			};
			if(checkuser($FORM{'email'},$mbase)){
				if (open(TOTUSER,">>$mbase")){
					flock(TOTUSER,$LOCK_EX);
					print TOTUSER "$FORM{'user'}|$FORM{'email'}\n";
					close(TOTUSER);
				};
			};
			($sec,$min,$hour,$mday,$mon,$year) = localtime();
			$year+=1900;
			if ($mday<10) {$mday="0$mday"};
			$subject1="User $FORM{'email'} for \"$FORM{'ar'}\" autoresponder first login";
			$date1="$mday @months[$mon] $year at $hour:$min:$sec";
			$body1="\nAutoresponder: $FORM{'ar'}\r\nName: $FORM{'user'}\r\nE-mail: $FORM{'email'}\r\nDate: $date1\r\nIP addres: $ENV{'REMOTE_ADDR'}\r\n\n Remove this prospect:\n $scripturl?mode=r&a=$FORM{'ar'}&e=$FORM{'email'}";
			if ($fromad==1) {
				sendmailadmin($admin,$subject1,$body1);
			}		
		} else {
				($sec,$min,$hour,$mday,$mon,$year) = localtime();
				$year+=1900;
				if ($mday<10) {$mday="0$mday"};
				$date1="$mday @months[$mon] $year at $hour:$min:$sec";
				$body1="\nAutoresponder: $FORM{'ar'}\r\nName: $FORM{'user'}\r\nE-mail: $FORM{'email'}\r\nDate: $date1\r\nIP addres: $ENV{'REMOTE_ADDR'}\r\n\n Remove this prospect:\n $scripturl?mode=r&a=$FORM{'ar'}&e=$FORM{'email'}";
		   		$subject2="User $FORM{'email'} for \"$FORM{'ar'}\" autoresponder repeat login";
				if ($fromad==1) {
					sendmailadmin($admin,$subject2,$body1);
				}		

			};
		sendmail($FORM{'email'},$subject,$body,$FORM{'ar'},$ftoattach,1,$FORM{'user'});
	} else {error "Both fields are required!"};
	if ($redirect ne "") {
			print "Location:$redirect\n\n";
		} else {error("Redirecting URL has not been specified!")};
};
sub getletter{
	my($subject,$body,$attachment);
	if (open(LETTER,"@_[0]")){;
		flock(LETTER,$LOCK_EX);
		$str=<LETTER>;
		$str=~/Subject:(.*)/;
		$subject=$1;
		$str=<LETTER>;
		$str=~/Attachment:(.*)/;
		$attachment=$1;
		while(!eof(LETTER)) {
			$str=<LETTER>;
			chomp($str);
			$str=~s/\r/\r\n/g;
			$body=$body."$str";
			};
		close(LETTER);
	};
	return ($subject,$body,$attachment);
}
sub leapyear{
	my($year)=@_;
    if ($year % 4 == 0){
        if ($year % 100 == 0){
            if ($year % 400 == 0){
                return 1
           } else 
		{return 0}
        }else
            {return 1}
    }else
        {return 0}
}
sub daysfrom{
	my($i,$sum)=(0,0);
	my($year,$month,$day)=@_;
	$month--;
	for($i=0;$i<$month;$i++){
		$sum+=@mdays[$i];
	};
	$sum+=$day;
	if (leapyear($year)== 1){
		if ($month>1){
			$sum++;#print "leap=$year;mon=$month;day=$day";
		}
	};
	return $sum
}
sub days{
	my($todate,$fromdate)=@_;
	my($days,$sum)=0;
	$fromdate=~/(\d{4})(\d\d)(\d\d)/;
	my($fromyear,$frommonth,$fromday)=($1,$2,$3);
	$todate=~/(\d{4})(\d\d)(\d\d)/;
	my($toyear,$tomonth,$today)=($1,$2,$3);
	$daysfrom1=daysfrom($toyear,$tomonth,$today);
	$daysfrom2=daysfrom($fromyear,$frommonth,$fromday);
	if ($toyear==$fromyear){
		$days=$daysfrom1-$daysfrom2;

	} else{
		for($i=$fromyear+1;$i<$toyear;$i++){
			$days+=365+1*leapyear($i)
		};
		$days+=(365+leapyear($fromyear)*1-$daysfrom2)+$daysfrom1;
	}
	return $days;
}
sub statuscheck{
	my($time);
	if (open(STATUS,"status.cfg")){
		flock(STATUS,$LOCK_EX);
		$time=<STATUS>;
		chomp($time);		
		if ($time eq "@_[0]@_[1]@_[2]") {error("Today's mailing already done");exit};
		close(FILE);
	} else {
		#if (-e "status.cfg") {
		#	exit
		#}
	};
	if(open(STATUS,">status.cfg")){
		flock(STATUS,$LOCK_EX);
		print STATUS "@_[0]@_[1]@_[2]\n";
		close(STATUS);
	} else {error("Cannot write status.cfg")}
		
};
sub mailer{
	my($mday,$mon,$year) = ltime();
	statuscheck("$mday","$mon","$year");
	print "Content-type:text/plain\n\n";
	$current="$year$mon$mday";
	my(@list)=getarlist();
	foreach(@list){
		@stadii=getarlist("$_/periods.txt");
		@users=getarlist("$_/users.txt");
		print "users:@users\n";
		print "Mailing started";
		$dir=$_;
		print("autoresp:$dir\n");
		for($i=0;$i<=$#users;$i++){
			@users[$i]=~/(.+)\|(.+)\|(.+)\|(.+)/;
			print "@users[$i]\n";
			print "stadiya:$3\n";
			$diff=days($current,$4);
			if($3<=$#stadii+1){
				if(@stadii[$3-1]<=days($current,$4)){
					($subject,$body,$ftoattach)=getletter("$dir/letter$3.txt");
					#error($2,$subject,$body,$dir,$ftoattach,$really);
					sendmail($2,$subject,$body,$dir,$ftoattach,$3,$1);
					$sentto{$dir}.="$1 $2 letter:$3\r\n";
					@users[$i]=~s/(.+)\|(.+)\|(.+)\|(.+)/"$1\|$2\|".($3+1)."|$4"/ie;
				};
				push(@newusers,@users[$i]);
			}			
		};
		if (open(USERS,">$dir/users.txt")){
			flock(USERS,$LOCK_EX);
			foreach(@newusers){print USERS "$_\n"};
			close(USERS);
		}
		 
		splice(@newusers);
	};
	my($repbody);
	$repbody="Mailing Report for $mon/$mday/$year:\r\n";
	foreach(keys(%sentto)){
		$repbody.="-----------------------------------------------------\r\n-- Autoresponder: $_\r\n"."$sentto{$_}";
	};
	sendmailadmin($admin,"Mailing report",$repbody);
}

sub generator{
	my($fromars,$namears,$unlink,$redirect)=(getarlist("$FORM{'ar'}/$FORM{'ar'}.cfg"));	
print "<!--//GENERATOR//-->\n";
print <<html_;
<p><font size="4"><b>Autoresponder: <a target="main" href="$scripturl?mode=letters&ar=$FORM{'ar'}&password=$FORM{'password'}"><font color=red>$FORM{'ar'}</font></a></b></font></p>
<p>Copy and paste this code into your HTML document:</p>
<p><textarea rows="17" name="S1" cols="60" class='edit'>  &lt;form method=&quot;POST&quot; action=&quot;$scripturl&quot;&gt;&lt;input type=&quot;hidden&quot; name=&quot;mode&quot; value=&quot;register&quot;&gt;&lt;input type=&quot;hidden&quot; name=&quot;ar&quot; value=$FORM{'ar'}&gt;&lt;div align=&quot;center&quot;&gt;&lt;center&gt;&lt;table border=&quot;1&quot; cellSpacing=&quot;0&quot; bgcolor=&quot;#C0C0C0&quot; cellpadding=&quot;2&quot;&gt;&lt;tr&gt;&lt;td align=&quot;right&quot;&gt;&lt;font face=&quot;Tahoma&quot; size=&quot;2&quot;&gt;Name:&lt;/font&gt;&lt;/td&gt;&lt;td&gt;&lt;font face=&quot;Tahoma&quot; size=&quot;2&quot;&gt;&lt;input type=&quot;text&quot; name=&quot;user&quot; size=&quot;20&quot;&gt;&lt;/font&gt;&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td align=&quot;right&quot;&gt;&lt;font face=&quot;Tahoma&quot; size=&quot;2&quot;&gt;Email:&lt;/font&gt;&lt;/td&gt;&lt;td&gt;&lt;font face=&quot;Tahoma&quot; size=&quot;2&quot;&gt;&lt;input type=&quot;text&quot; name=&quot;email&quot; size=&quot;20&quot;&gt;&lt;/font&gt;&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td align=&quot;right&quot; colspan=&quot;2&quot;&gt;&lt;div align=&quot;center&quot;&gt;&lt;center&gt;&lt;p&gt;&lt;font face=&quot;Tahoma&quot; size=&quot;2&quot;&gt;&lt;input type=&quot;submit&quot; value=&quot;Subscribe&quot; name=&quot;B1&quot;&gt;&lt;/font&gt;&lt;/td&gt;&lt;/tr&gt;&lt;/table&gt;&lt;/center&gt;&lt;/div&gt;&lt;/form&gt;</textarea></p>
<br><p>It will appear on your web page like this:</p><br>
<div align="center"><center>
<table border="1" cellSpacing="0" bgcolor="#C0C0C0" cellpadding="2">
<tr><td align="right"><p>Name:</p></td><td><p>
<input type="text" name="user" size="20" class='edit1'></p></td></tr><tr><td align="right">
<p>Email:</p></td><td><p><input type="text" name="email" size="20" class='edit1'></p></td></tr>
<tr><td align="center" colspan="2"><p><input type="submit" value="Subscribe" name="B1" class='edit1'></p></td></tr>
</table>
</center></div>
<br><p>Remember that you can change the subscription box in any way you want.</p>
<br><br><hr><br><br>
html_
print "<!--//GENERATOR//-->\n";
} #generator

sub blia{
	$a=~/(\d+)/;
	$a1=$1;
	$b=~/(\d+)/;
	return $a1<=>$1
}

sub checkform {
 print "Location: ".$htmlpath."/admin.html\n\n";
 exit;
} #checkform

sub importusers{
	my(%gooduser);
	my(@import)=split(/\r/,$FORM{'import'});
	my(@periods)=(getarlist("$FORM{'ar'}/periods.txt"));
	my($day,$mon,$year)=(ltime());
	my($nday,$nmon,$nyear);
	$dfr=daysfrom($year,$mon,$day);
	if ($dfr<@periods[$FORM{'period'}-1]){
		($nday,$nmon,$nyear)=(data(365+leapyear($year-1)-@periods[$FORM{'period'}-1]+$dfr+1,$year-1));
	} elsif ($dfr==@periods[$FORM{'period'}-1])
	{	
		($nday,$nmon,$nyear)=(data(1,$year));
	} else {
		($nday,$nmon,$nyear)=(data($dfr-@periods[$FORM{'period'}-1],$year))	
	};
	my($email,$name);
	foreach(@import){
		$_=~s/^\s//;
		$email=$_;
		$name="";
		if (/(.*)\|(.*)/){
			$email=$2;
			$name=$1;
		};
		if ($name ne "") {
			$name=~s/^\s//;
			$name=~s/\\//g;
			$name=~tr/A-Z/a-z/;
			$name=~/^\s*(\w{1,20})\s*(\w{0,20}).*$/;
			$name=$1;
			$sec=$2;
			if ($sec ne ""){$sec=~tr/A-Z/a-z/;$sec=" \u$sec"};
		};
		$email=~tr/A-Z/a-z/;
		if ($name eq ""){$name=$emptyuname} else{$name="\u$name$sec";};
		if(checkmail($email)==1){
			if (checkuser($email,"$FORM{'ar'}/users.txt")==1){ 
				if (open(USER,">>$FORM{'ar'}/users.txt")){
					flock(USER,$LOCK_EX);
					print USER "$name|$email|$FORM{'period'}|$nyear$nmon$nday\n";
					$gooduser{$email}=$name;
					close(USER);
				};
			} else {
				};
		}
	}; 
		if((%gooduser)){
		if(-e "$mbase"){} else{
			if(open(BASE,">$mbase")){
				print BASE "$gooduser{$email}|$email\n";
				close(BASE)
			}
		};
		foreach(keys(%gooduser)){
				$emm=$_;
				if (($emm ne "")&&(checkuser("$emm","$mbase")==1)) {
					$goodtotuser{$emm}=$gooduser{$emm};
				};
			};
		if (%goodtotuser){
			if (open(TOTUSER,">>$mbase")){
#				flock(TOTUSER,$LOCK_EX);
				foreach(keys(%goodtotuser)){
					if($_ ne "") {
						print TOTUSER "$goodtotuser{$_}|$_\n";
						}
				};
				close(TOTUSER);
			}
		}
	};
}
sub data{
	my($days,$i,$day,$sum,$year)=(@_[0],0,0,0,@_[1]);
	@mdays1=@mdays;
	if (leapyear($year)==1){@mdays1[1]=29} else {@mdays1[1]=28};
	#print("\n$year\n");
	while ($sum<$days){
		$sum+=@mdays1[$i];
		$i++
	};
	if ($day==$sum) {$day=@mdays1{$i-1}} else {$day=$days+@mdays1[$i-1]-$sum};
	if ($i<10){$i="0$i"};
	if ($day<10){$day="0$day"};
	return ($day,$i,$year);
	#print "\ndata=",daysfrom($year,$i++,$day),"\n";
}

sub exportmails{
	print "Content-type: text/html\n\n";
	print "<body style=\"font-family: Courier New, Courier, Verdana; font-size: 10pt\" link=\"blue\" vlink=\"blue\" alink=\"red\" bgcolor=\"#FFFFFF\">";
	my(@adrs)=getarlist("$FORM{'ar'}/users.txt");
	print "<font face=\"Tahoma, Verdana\" size=\"4\"><b>Autoresponder: <font color=red>$FORM{'ar'}</font></b></font><br>";
	print "<font face=\"Tahoma, Verdana\" size=\"2\"><b>Active Prospects:</font></b><br><hr noshade size=\"4\" color=\"#008080\">";
	foreach(@adrs){
		~/(.+)\|(.+)\|(.+)\|(.+)/;
		print "$1|$2<br>";
	};
	$total=$#adrs+1;
	print "<hr noshade size=\"4\" color=\"#008080\"><br><b>Total:$total</b><br>";
	print "<center><input style=\"font-family: Tahoma, Verdana; font-size: 8pt\" type=\"Button\" value=\"Close Window\" onClick=\"window.close()\" name=\"Button\"></center>";

}

sub unlinkuser{
	my(@good);
	$check=0;
	if (open(FILE,"$FORM{'a'}/users.txt") && "$FORM{'e'}" ne ""){
		flock(FILE,$LOCK_EX);
		while(<FILE>){
			~/(.+)\|(.+)\|(.+)\|(.+)/;
			chomp($_);
			if($FORM{'e'} ne $2){
				if ($_ ne "") {
					push(@good,$_);
				}
			} else {$check=1};
		}
		flock(RISP,$LOCK_UN);
		close(FILE);
	};

	if ((open(FILE,">$FORM{'a'}/users.txt")) && ("$FORM{'e'}" ne "") && ("@good" ne "")){
		flock(FILE,$LOCK_EX);
		foreach(@good) {
			if ($_ ne "") {
				print FILE "$_\n";
			}
		}
		flock(RISP,$LOCK_UN);
		close(FILE);
	};
	print "Content-type:text/html\n\n";
	if ($check==1) {
		&unlinkmessages("<p>The email address <font color=red><u>$FORM{'e'}</u></font><br>was removed from the database.</p>");
	} else {
		&unlinkmessages("<p>The email address <font color=red><u>$FORM{'e'}</u></font><br>you submitted to be removed<br>was not in the database.</p>");
	}
 exit;
}

sub unlinkmessages {
    my($msg) = @_;
    print <<HTML;
<br><br><br>
<div align="center"><center>
<table border="1" bordercolor="#FF0000" cellspacing="0" cellpadding="10">
  <tr>
    <td><p align='center'><font face="Verdana"><h3>$msg</font></p></td>
  </tr>
</table>
</center></div>
HTML
 exit;
}

