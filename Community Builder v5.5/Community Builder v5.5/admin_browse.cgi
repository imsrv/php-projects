#!/usr/bin/perl
###
#######################################################
#		Community Builder v5.0
#     
#  		Created by  Scripts
# 		Email: Community
#		Web: Community Builder
#
#######################################################
#
#
# COPYRIGHT NOTICE:
#
# Copyright 1999  Scripts  All Rights Reserved.
#
# Selling the code for this program without prior written consent is
# expressly forbidden. In all cases
# copyright and header must remain intact.
#
#######################################################

require "variables.pl";

print "Content-type: text/html\n\n ";
$demo=0;

@char_set = ('a'..'z','0'..'9');

$cgi_url = $ENV{'SCRIPT_NAME'};

read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
@pairs = split(/&/, $buffer);
foreach $pair (@pairs) {
	($name, $value) = split(/=/, $pair);
	$value =~ tr/+/ /;
	$value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
	$name =~ tr/+/ /;
	$name =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
	if ($INPUT{$name}) { $INPUT{$name} = $INPUT{$name}.",".$value; }
	else { $INPUT{$name} = $value; }

# print "<font face=verdana size=1>$name - $value</FONT><BR>";
}

if ($INPUT{'mod_browse'}) { &mod_browse; }
elsif ($INPUT{'get_acc'}) { &get_acc; }
elsif ($INPUT{'del_up_admin'}) { &del_up_admin; }
elsif ($INPUT{'del_up_mod'}) { &del_up_mod; }
elsif ($INPUT{'admin_browse'}) { &admin_browse; }
&main;

sub mod_browse {
	&check_mod;
	$moderate=1;
	&browse;
}
sub admin_browse {
	&checkpword;
	$moderate=0;
	&browse;
}

######### MODERATOR LOGIN ##########
sub main {
&Header;
print <<EOF;
<form action="$cgi_url" method="POST">
<input type="Hidden" name="mod" value="1">
<center>
<TABLE CELLPADDING=8 CELLSPACING=0 BORDER=0>
<TR><TD>
<FONT FACE=verdana size=2>
Account Name:</TD>
<TD>
<input type="Text" name="acc_name">
</TD></TR>
<TR><TD>
<FONT FACE=verdana size=2>
Password:</TD>
<TD>
<input type="password" name="acc_pass">
</TD></TR>
EOF
if ($category) {
	$select ='';
	open (ACC, "$path/categories.txt");
	@cata_data = <ACC>;
	close (ACC);

	foreach $cata_line(@cata_data) {
		chomp($cata_line);
		@abbo = split(/\|/,$cata_line);
		($key,$abbo[0]) = split(/\%\%/,$abbo[0]);
		$select .= "<OPTION VALUE=\"$key\">$abbo[1]\n";	
	}

print <<EOF;
<TR><TD ALIGN=left>
<font face=verdana size=2>
Select your $cata_name:
</TD><TD>
<select name="catas">
<OPTION VALUE="accounts">No $cata_name
$select</select>
</TD></TR>
EOF
}
print <<EOF;
<TR><TD colspan=2 align=center>
<input type="Submit" name="get_acc" value="  Verify Details  ">
</TD></TR></TABLE>
<TABLE WIDTH=450 BORDER=0>
<TR><TD>
<FONT FACE=verdana size=2>
<BR><BR>
<B>Moderater Privilages-</B>
<BR><BR>
Moderators have the ability to view all files of accounts in the directory they are a moderator 
for. Accounts will be listed along with the total number offiles that account contains, also the total 
number of folders and the amount of space that account is taking up. Each file is a link that will open that
paticular file in a new window. The moderator has the option to put an account "on hold", which means that
the owner of the account will not be able to log into their account. An error message with explaining why
they are on hold will come up instead. For a moderator to put an account "on hold" they must
enter the reason in the "on hold" text box and press the "Update" button at the bottom of the
page. To take an account off the "on hold" status just delete all the text in the "on hold" text box and
press the "Update" button.
</TD></TR> 
</TABLE>
</form>
EOF
}

########## ACCOUNT SELECTION SCREEN ##########
sub get_acc {
&check_mod;

&Header;

print <<EOF;
<BR><BR>
<FORM METHOD=POST ACTION="admin_browse.cgi">
<input type="Hidden" name="acc_name" value="$INPUT{'acc_name'}">
<input type="Hidden" name="acc_pass" value="$INPUT{'acc_pass'}">
<input type="Hidden" name="catas" value="$INPUT{'catas'}">
<table cellpadding=8 border=1 cellspacing=0 bgcolor="white">
<TR bgcolor=silver align=center><TD colspan=2>
<font face=arial size=2><B>Advanced Account Browsing</B></FONT>
</TD></TR>
EOF

if ($category) {
print <<EOF;
<TR><TD valign=top><font face=arial size=2>Accounts in category:</FONT><BR><BR>
<CENTER>
<select name="cata" multiple>
<option value="_all_" SELECTED>All Categories
EOF
	$acco[32] = ",$acco[32],";
	if ($acco[32] =~ /,accounts,/) {	
		print "<option value=\"accounts\">Base Dir.";
	}
	open (ACC, "$path/categories.txt");
	@cata_data = <ACC>;
	close (ACC);

	foreach $cata_line(@cata_data) {
		chomp($cata_line);
		@abbo = split(/\|/,$cata_line);
		($key,$abbo[0]) = split(/\%\%/,$abbo[0]);

		if ($acco[32] =~ /,$abbo[1],/) {	
			print "<option value=\"$key\">$abbo[1]\n";
		}
	}
	print "</SELECT></TD>\n";
}
else {
print <<EOF;
<TR><TD valign=top><font face=arial size=2>Accounts in category:<BR><BR>
<CENTER>
<B>Base Dir.
<input type="Hidden" name="cata" value="accounts">
</TD>
EOF
}
print <<EOF;
<TD valign=top>
<font face=arial size=2>
Show accounts joining:
<BR><BR><input type="Radio" name="start_on" value="on"> <font color=red><B>on</B></FONT><BR>
<input type="Radio" name="start_on" value="after"> <font color=red><B>after</B></FONT><BR>
<input type="Radio" name="start_on" value="before"> <font color=red><B>before</B></FONT><BR>
<BR>this date:
<input type="Text" name="date" size="10">
</TD></TR>
<TR><TD valign=top>
<font face=arial size=2>
Show only accounts taking up:
<BR><BR><input type="Radio" name="size_on" value="more"> <font color=red><B>more</B></FONT><BR>
<input type="Radio" name="size_on" value="less"> <font color=red><B>less</B></FONT><BR>
<BR>than <input type="Text" name="size" size="10"> kb of space.
</TD>
<TD valign=top>
<font face=arial size=2>
Accounts using:
<BR><BR><input type="Radio" name="files_on" value="more"> <font color=red><B>more</B></FONT><BR>
<input type="Radio" name="files_on" value="less"> <font color=red><B>less</B></FONT><BR>
<BR>than <input type="Text" name="files" size="8"> files in total.
</TD>
</TR>
<TR><TD valing=top>
<font face=arial size=2>
Sort matching accounts by:<BR><BR>
<input type="Radio" name="sort" value="name" checked> <font color=red><B>Name</B></FONT><BR>
<input type="Radio" name="sort" value="size"> <font color=red><B>Size</B></FONT><BR>
<input type="Radio" name="sort" value="files"> <font color=red><B>Number files</B></FONT><BR>
<input type="Radio" name="sort" value="joined"> <font color=red><B>Date joined</B></FONT><BR>
<input type="Radio" name="sort" value="last"> <font color=red><B>Date last logged in</B></FONT><BR>
<BR><BR></TD>
<TD valign=top>
<font face=arial size=2># Accounts per page:
<input type="Text" name="number_acc" value="25" size="3">
<input type="Hidden" name="number_start" value="1">
</TD>
</TR>
<TR bgcolor=silver align=center><TD colspan=2>
<input type="Submit" name="mod_browse" value=" Retrieve Matching Accounts ">
</TD></TR>
EOF

print "</TABLE></FORM>";
&Footer;
exit;
}

########## CHECK MOD PERMISSIONS ##########
sub check_mod {

$acc_name = $INPUT{'acc_name'};
$acc_pass = $INPUT{'acc_pass'};
$catas = $INPUT{'catas'};

@accarray = split(//,$acc_name);
$accfile = "$path/members/$INPUT{'catas'}/$accarray[0]/$acc_name.dat";

unless (-e "$accfile") {
&Header;
print <<EOF;
<BR>
<table cellpadding=5 border=1 cellspacing=0 bgcolor=$table_bg>
<TR><TD><font face=$font_face size=$font_size color=$text_table>
The account name you entered could not be found in our database
</TD></TR></TABLE>
EOF
untie(%acc);
exit;
&Footer;
}

undef $/;
open (ACC, "$accfile");
$acc_data = <ACC>;
close (ACC);
$/ = "\n";

@acco = split(/\n/,$acc_data);

if ($acco[18]) {
&Header;
print <<EOF;
<BR>
<table cellpadding=5 border=1 cellspacing=0 bgcolor=$table_bg>
<TR><TD><font face=$font_face size=$font_size color=$text_table>
We are sorry, this account is currently on hold for the following reason:
<BR><BR>
$acco[18]
<BR><BR>
If you have a question about the status of your account, please contact<BR>
us at <A href="mailto:$your_email">$your_email</A>.<BR><BR>
</TD></TR></TABLE>
EOF
untie(%acc);
&Footer;
exit;
}

unless ($INPUT{'acc_pass'} eq $acco[2]) {
&Header;
print <<EOF;
<BR>
<table cellpadding=5 border=1 cellspacing=0 bgcolor=$table_bg>
<TR><TD><font face=$font_face size=$font_size color=$text_table>
You have entered the wrong password for this account
</TD></TR></TABLE>
EOF
untie(%acc);
&Footer;
exit;
}
unless ($acco[32]) {
&Header;
print <<EOF;
<BR>
<table cellpadding=5 border=1 cellspacing=0 bgcolor=$table_bg>
<TR><TD><font face=$font_face size=$font_size color=$text_table>
We are sorry, you are not a moderator
</TD></TR></TABLE>
EOF
untie(%acc);
&Footer;
exit;
}
untie(%acc);
}

########## FIND ACCOUNTS ##########
sub browse {

&DHTML_Header;
print <<EOF;
<CENTER>
<font face=verdana size=2>$message</FONT>
<form action="$cgi_url" method="POST">
EOF

while ( ($key, $value) = each( %INPUT) ) {
	if ($key eq "number_start") { $value = $value + $INPUT{'number_acc'}; }
	next if ($key =~ /^del_up/);
	next if ($key =~ /^on_hold/);
	next if ($key =~ /^delete/);
	next if ($key eq "mod_browse");
	print "<input type=\"Hidden\" name=\"$key\" value=\"$value\">\n";
}
print <<EOF;
<TABLE CELLPADDING=3 CELLSPACING=0 Border=0>
<TR><TD>
EOF

$catas =",$INPUT{'cata'},";
$acco[32] = ",$acco[32],";
$mod = $acco[32];

$accounts_shown = 1;
$where_stop = $INPUT{'number_acc'} + $INPUT{'number_start'};

$numcata =0;
open (ACC, "$path/categories.txt");
@cata_data = <ACC>;
close (ACC);


@cata_data = reverse(@cata_data);
push(@cata_data,"accounts\%\%BASE_DIR");
@cata_data = reverse(@cata_data);

foreach $cata_line(@cata_data) {
	chomp($cata_line);
	@values = split(/\|/,$cata_line);
	($key,$values[0]) = split(/\%\%/,$values[0]);

	if ($accounts_shown == $where_stop) { last; }
	$numcata ++;
	if (($catas =~ /\,$key\,/) || ($catas =~ /\,_all_\,/)) {
	   	$dir = "$path/members";
		if (!($moderate) || ($moderate  && ($mod =~ /\,$values[0]\,/))) {
			foreach $ch(@char_set) {
				opendir (DIR, "$dir/$key/$ch") || &error("can not open $dir/$key/$ch");
				@acc_arr = grep {!(/^\./) && -f "$dir/$key/$ch/$_"}  readdir(DIR);
				close (DIR); 
				foreach $account(@acc_arr) {
					undef $/;
					open (ACC, "$dir/$key/$ch/$account") || &error("Error reading $dir/$key/$ch/$account");
					$acc_data = <ACC>;
					close (ACC);
					$/ = "\n";
					$account =~ s/\.dat//;
			
					@acco = split(/\n/,$acc_data);
					
					if ($accounts_shown == $where_stop) { last; }
					$numaccounts ++;
				
					if ($INPUT{'date'} && $INPUT{'start_on'}) {
					   $cdate =0;
					   $cdate = &check_date;
					   next unless $cdate;
					}


					$num_files=0;
					$num_fold=0;
					$total_k =0;
					$html ='';
		
					if ($key eq "accounts") {
					   $acc_dir="$account";
					}
					else {
						 $acc_dir = "$values[0]/$account";
					}
					&dir_lists("$free_path/$acc_dir",1);

$html2 = <<EOF;
<TABLE CELLPADDING=5 CELLSPACING=0 Border=1 width=100\%>
<TR><TD bgcolor=silver><font face=verdana size=2>Account: <font color=red>$account</FONT> &nbsp;&nbsp;&nbsp;Category: <font color=red>$key</FONT>
<BR># Files: <font color=red>$num_files</FONT> &nbsp;&nbsp; # Folders: <font color=red>$num_fold</FONT>
&nbsp;&nbsp; Space Used: <font color=red>$total_k</FONT>k</TD></TR>
<TR><TD bgcolor=silver><font face=verdana size=2>On Hold:
<input type="Text" name="on_hold_$key|$account" value="$acco[18]" size=30></TD></TR>
<TR><TD>
<font face=verdana size=2>
<ul>
   <li id="foldheader">&nbsp;&nbsp;Dir Listing</li>
   <ul id="foldinglist" style="display:none" style=&{head};>
EOF
	   				unless ($moderate) {
						$html2 .= "<LI>\&nbsp\;\&nbsp\;<input type=\"Checkbox\" name=\"delete_acc\" value=\"$key|$account\"> <font color=red>Delete Account</FONT></LI>";
					}
					$html = $html2 . $html;
		
					unless ($total_k) { $total_k =0; }

					## CHECK SPACE ##
					if ($INPUT{'size_on'} && $INPUT{'size_on'}) {
						if (($INPUT{'size_on'} eq "more") && ($INPUT{'size'} >= $total_k)) { next; }
						if (($INPUT{'size_on'} eq "less") && ($INPUT{'size'} <= $total_k)) { next; }
					}
					## CHECK # FILES ##
				    if ($INPUT{'files_on'} && $INPUT{'files_on'}) {
					   if (($INPUT{'files_on'} eq "more") && ($INPUT{'files'} >= $num_files)) { next; }
					   if (($INPUT{'files_on'} eq "less") && ($INPUT{'files'} <= $num_files)) { next; }
					}
								
					$html .= "</UL></TD></TR></TABLE>";

					$accounts_shown++;
					if ($accounts_shown <= $INPUT{'number_start'}) { next; }

					if ($INPUT{'sort'} eq "name") { 
					   print "$html";
					   if ($a) {
					   	   $a=0;
					   	   print "</TD></TR><TR><TD valign=top align=center>\n";
					   }
					   else {
						   $a=1;
						   print "</TD><TD valign=top align=center>\n";
					   }
					}
					elsif ($INPUT{'sort'} eq "size") {
						$sort{$account} = "$total_k";
						$content{$account} = $html;
					}
					elsif ($INPUT{'sort'} eq "files") {
						  $sort{$account} = $num_files;
						  $content{$account} = $html;
					}
					elsif ($INPUT{'sort'} eq "joined") {
						  $sort{$account} = "$acco[4]";
						  $content{$account} = $html;
					}
					elsif ($INPUT{'sort'} eq "last") {
						$sort{$account} = "$acco[5]";
						$content{$account} = $html;
					}		
				}		
			}
		}
	}
}
	
&sort_print;

if ($moderate) {
print <<EOF;
</TD></TR>
<TR><TD colspan=2><BR><BR><TABLE cellpadding=0 cellspacing=0 border=0 width=100\%><TR>
<TD align=left>
<input type="Submit" name="mod_browse" value="Previous $INPUT{'number_acc'}">
</TD><TD align=center>
<input type="Submit" name="del_up_mod" value="Update onhold values">
</TD>
<TD align=right>
<input type="Submit" name="mod_browse" value="Next $INPUT{'number_acc'}">
</TD></TR></TABLE>
</TD></TR>
</TABLE>
</FORM>
EOF
}
else {
print <<EOF;
</TD></TR>
<TR><TD colspan=2><BR><BR><TABLE cellpadding=0 cellspacing=0 border=0 width=100\%><TR>
<TD align=left>
<input type="Submit" name="admin_browse" value="Previous $INPUT{'number_acc'}">
</TD><TD align=center>
<input type="Submit" name="del_up_admin" value="Delete/Update selected files and accounts">
</TD>
<TD align=right>
<input type="Submit" name="admin_browse" value="Next $INPUT{'number_acc'}">
</TD></TR></TABLE>
</TD></TR>
</TABLE>
</FORM>
EOF
}

&DHTML_Footer;
exit;
}

########## DELETE UPDATE ADMIN ##########
sub del_up_admin {
if ($demo) { &demo; }
&checkpword;

@inputs = keys %INPUT;
$aa=0;
foreach $keys (@inputs) {		
	if ($keys =~ /^on_hold_/) {
		$nohold = $keys;
		$nohold =~ s/^on_hold_//gi;
		$onhold[$aa] = $nohold;
		$aa++;
	} 
}

foreach $file(@onhold) {
	@ffile = split(/\|/,$file);
	$account = $ffile[1];
	$cata = $ffile[0];
	$current_hold = $INPUT{'on_hold_'.$cata.'|'.$account};

	unless ($cata) {
		$cata = "accounts";
	}

	unless ($cata eq "accounts") {
		   open (ACC, "$path/categories.txt");
		   @cata_data = <ACC>;
		   close (ACC);

		   foreach $cata_line(@cata_data) {
		   		chomp($cata_line);
				@abbo = split(/\|/,$cata_line);
				($key,$abbo[0]) = split(/\%\%/,$abbo[0]);
				if ($key eq $cata) {
				   $dir_acc = "$free_path/$abbo[0]/$account";
				   @accarray = split(//,$account);
				   $accfile = "$path/members/$key/$accarray[0]/$account.dat";
				   last;
				}
			}
	}
	else {
		$dir_acc = "$free_path/$account";
		@accarray = split(//,$account);
		$accfile = "$path/members/accounts/$accarray[0]/$account.dat";
	}
		
	undef $/;
	open (ACC, "$accfile") || &error("Error reading $accfile");
	$acc_data = <ACC>;
	close (ACC);
	$/ = "\n";
	$account =~ s/\.dat//;
			
	@acco = split(/\n/,$acc_data);
	$numaccounts ++;
	$acco[18] = $current_hold;
	$acc_data = join("\n",@acco);
	open (ACC, ">$accfile") || &error("Error printing $accfile");
	print ACC $acc_data;
	close (ACC);	

}


@del_files = split(/\,/,$INPUT{'delete'});
foreach $file(@del_files) {
	unlink("$file");
}

@del_files = split(/\,/,$INPUT{'delete_dir'});
foreach $file(@del_files) {
	&dir_del("$file");
	rmdir ("$file");
}

@del_files = split(/\,/,$INPUT{'delete_acc'});
foreach $file(@del_files) {
	@ffile = split(/\|/,$file);
	$account = $ffile[1];
	$cata = $ffile[0];
	
	unless ($cata) {
		$cata = "accounts";
	}

	unless ($cata eq "accounts") {
		   open (ACC, "$path/categories.txt");
		   @cata_data = <ACC>;
		   close (ACC);

		   foreach $cata_line(@cata_data) {
		   		chomp($cata_line);
				@abbo = split(/\|/,$cata_line);
				($key,$abbo[0]) = split(/\%\%/,$abbo[0]);
				if ($key eq $cata) {
				   $dir_acc = "$free_path/$abbo[0]/$account";
				   @accarray = split(//,$account);
				   $accfile = "$path/members/$key/$accarray[0]/$account.dat";
				   last;
				}
			}
	}
	else {
		$dir_acc = "$free_path/$account";
		@accarray = split(//,$account);
		$accfile = "$path/members/accounts/$accarray[0]/$account.dat";
	}
		

	&dir_del("$dir_acc");
	rmdir ("$dir_acc");
	unlink($accfile);
	
}
$message = "Selected files/accounts deleted -- Onhold status updated";
$INPUT{'number_start'} = $INPUT{'number_start'} - $INPUT{'number_acc'};
$moderate=0;
&browse;
}

######### DIR DEL ##########
sub dir_del {

my $direc = $_[0];
my (@dirs,$new_dir);

opendir(DIR,$direc);
@dirs = grep {!(/^\./) && -d "$direc/$_" } readdir(DIR);
close DIR;
@dirs = sort(@dirs);

opendir (DIR, "$direc");
@files = grep {!(/^\./) && -f "$direc/$_"}  readdir(DIR);
close (DIR); 

foreach $file(@files) {
	unlink("$direc/$file") || &error("Failed to remove $direc/$file");
}


for $new_dir(0..$#dirs) {
	&dir_del("$direc/$dirs[$new_dir]");
	rmdir("$direc/$dirs[$new_dir]") || &error("Failed to remove $direc/$dirs[$new_dir]");
}

}

########## MOD UPDATE ADMIN ##########
sub del_up_mod {
if ($demo) { &demo; }
&check_mod;

@inputs = keys %INPUT;
$aa=0;
foreach $keys (@inputs) {		
	if ($keys =~ /^on_hold_/) {
		$nohold = $keys;
		$nohold =~ s/^on_hold_//gi;
		$onhold[$aa] = $nohold;
		$aa++;
	} 
}

foreach $file(@onhold) {
	@ffile = split(/\|/,$file);
	$account = $ffile[1];
	$cata = $ffile[0];
	$current_hold = $INPUT{'on_hold_'.$cata.'|'.$account};

	unless ($cata) {
		$cata = "accounts";
	}
		
	unless ($cata eq "accounts") {
		   open (ACC, "$path/categories.txt");
		   @cata_data = <ACC>;
		   close (ACC);

		   foreach $cata_line(@cata_data) {
		   		chomp($cata_line);
				@abbo = split(/\|/,$cata_line);
				($key,$abbo[0]) = split(/\%\%/,$abbo[0]);
				if ($key eq $cata) {
				   $dir_acc = "$free_path/$abbo[0]/$account";
				   @accarray = split(//,$account);
				   $accfile = "$path/members/$key/$accarray[0]/$account.dat";
				   last;
				}
			}
	}
	else {
		$dir_acc = "$free_path/$account";
		@accarray = split(//,$account);
		$accfile = "$path/members/accounts/$accarray[0]/$account.dat";
	}
		
	undef $/;
	open (ACC, "$accfile") || &error("Error reading $accfile");
	$acc_data = <ACC>;
	close (ACC);
	$/ = "\n";
	$account =~ s/\.dat//;
			
	@acco = split(/\n/,$acc_data);
	$numaccounts ++;
	$acco[18] = $current_hold;
	$acc_data = join("\n",@acco);
	open (ACC, ">$accfile") || &error("Error printing $accfile");
	print ACC $acc_data;
	close (ACC);	

}

$message = "Onhold status updated";
$INPUT{'number_start'} = $INPUT{'number_start'} - $INPUT{'number_acc'};
$moderate=1;
&browse;
}


########## SORT ACCOUNTS ###########
sub sort_print {

if ($INPUT{'sort'} eq "name") { 
	return;
}
elsif (($INPUT{'sort'} eq "size") || ($INPUT{'sort'} eq "files")) {
	foreach $key (sort_hash(\%sort)) {
		print $content{$key};
		if ($a) {
			$a=0;
			print "</TD></TR><TR><TD valign=top align=center>\n";
		}
		else {
			$a=1;
			print "</TD><TD valign=top align=center>\n";
		}
	}
}
elsif (($INPUT{'sort'} eq "joined") || ($INPUT{'sort'} eq "last")) {
	foreach $key (sort_hashs(\%sort)) {
		print $content{$key};
		if ($a) {
			$a=0;
			print "</TD></TR><TR><TD valign=top align=center>\n";
		}
		else {
			$a=1;
			print "</TD><TD valign=top align=center>\n";
		}
	}
}

}

sub sort_hash {
	my $x = shift;
	my %array = %$x;
	sort { $array{$b} cmp $array{$a}; } keys %array;
}
sub sort_hashs {
	my $x = shift;
	my %array = %$x;
	sort { $array{$b} cmp $array{$a}; } keys %array;
}

########## GET DATE ##########
sub check_date {

if ($INPUT{'date'} =~ /\//) { @date = split(/\//,$INPUT{'date'}); }
elsif ($INPUT{'date'} =~ /\,/) { @date = split(/\,/,$INPUT{'date'}); }

if ($date[2] > 1900) { $date[2] = $date[2] - 1900; }

$time = time;
($jsec,$jmin,$jhour,$jmday,$jmon,$jyear,$jwday,$jyday,$jisdst) = localtime($acco[4]);
$jmon++;

($msec,$mmin,$mhour,$mmday,$mmon,$myear,$mwday,$myday,$misdst) = localtime($acco[5]);
$mmon++;

if (($INPUT{'start_on'} eq "on") && ($date[0] == $jmon) && ($date[1] == $jmday) && ($date[2] == $jyear)) { return(1); }

if ($INPUT{'start_on'} eq "before") {
	$ans = $date[2] >= $jyear;
	return(0) unless $ans;
	if ($date[2] == $jyear) {
		$ans = $date[0] >= $jmon;
		return(0) unless $ans;
	}
	if (($date[2] == $jyear) && ($date[0] == $jmon)) {
		$ans = $date[1] >= $jmday;
		return(0) unless $ans;
	}
	return(1);
}
if ($INPUT{'start_on'} eq "after") {
	$ans = $date[2] <= $jyear;
	return(0) unless $ans;
	if ($date[2] == $jyear) {
		$ans = $date[0] <= $jmon;
		return(0) unless $ans;
	}
	if (($date[2] == $jyear) && ($date[0] == $jmon)) {
		$ans = $date[1] <= $jmday;
		return(0) unless $ans;
	}
	return(1);
}
return(0);
}

############ DIRECTORY LISTS ##########
sub dir_lists {

my $direc = $_[0];
my $super_size = $_[1];
my (@dirs,$new_dir);

opendir(DIR,$direc);
@dirs = grep {!(/^\./) && -d "$direc/$_" } readdir(DIR);
close DIR;
@dirs = sort(@dirs);

opendir (DIR, "$direc");
@files = grep {!(/^\./) && -f "$direc/$_"}  readdir(DIR);
close (DIR); 
@files = sort(@files);

foreach $file(@files) {
	$show_file = "$direc/$file";
	$show_file =~ s/$free_path\///i;

	if ($super_size) {
		$html .= "<LI>\&nbsp\;\&nbsp\;";
		unless ($moderate) {
			$html .= "<input type=\"Checkbox\" name=\"delete\" value=\"$direc/$file\"> ";
		}
		$html .= "<a href=\"$url/$show_file\" target=\"main\">$file</A></LI>\n";
	}

	@stats = stat("$direc/$file");
	$mtime = $stats[9];
	$atime = $stats[8];
	$size = $stats[7];
	$size = $size /1000;
	$total_k = $size + $total_k;
	$num_files++;
}

for $new_dir(0..$#dirs) {
	$show_dir = "$direc/$dirs[$new_dir]";
	$show_dir =~ s/$free_path\/$direc\///i;

	if ($super_size) {
		$html .= "<li id=\"foldheader\">\&nbsp\;\&nbsp\; \&nbsp\;\&nbsp\;$dirs[$new_dir]</li>\n";
		$html .= "<ul id=\"foldinglist\" style=\"display:none\" style=\&{head}\;>\n";
		unless ($moderate) {
			$html .= "<LI>\&nbsp\;\&nbsp\;<input type=\"Checkbox\" name=\"delete_dir\" value=\"$dirs[$new_dir]\"> <Font color=red>Delete Dir.</font></LI>\n";
		}
	}
	$num_fold++;

	&dir_lists("$direc/$dirs[$new_dir]",$super_size);
	$html .= "</UL>\n";
}
}


########## DHTML HEADER ##########
sub DHTML_Header {
print <<EOF;
<HTML>
<HEAD>
	<TITLE>Advanced Browsing -- $free_name</TITLE>
<style>
<!--
#foldheader{cursor:hand ; 
list-style-image:url($url_to_icons/fold.gif)}
#foldinglist{list-style-image:url($url_to_icons/list.gif)}
//-->
</style>
<script language="JavaScript1.2">
<!--
/** 
 *  Based on Folding Menu Tree 
 *  Dynamic Drive (www.dynamicdrive.com)
 *  For full source code, installation instructions,
 *  100s more DHTML scripts, and Terms Of
 *  Use, visit dynamicdrive.com
 *
 *  Updated to support arbitrarily nested lists
 *  by Mark Quinn (mark\@robocast.com) November 2nd 1998
 */

var head="display:''"
img1=new Image()
img1.src="$url_to_icons/fold.gif"
img2=new Image()
img2.src="$url_to_icons/open.gif"

function change(){
   if(!document.all)
      return
   if (event.srcElement.id=="foldheader") {
      var srcIndex = event.srcElement.sourceIndex
      var nested = document.all[srcIndex+1]
      if (nested.style.display=="none") {
         nested.style.display=''
         event.srcElement.style.listStyleImage="url($url_to_icons/open.gif)"
      }
      else {
         nested.style.display="none"
         event.srcElement.style.listStyleImage="url($url_to_icons/fold.gif)"
      }
   }
}

document.onclick=change

//-->
</script>
</HEAD>

<BODY BGCOLOR="#FFFFFF">
EOF
}

########## DHTML FOOTER #########
sub DHTML_Footer {
print <<EOF;

</HTML>

EOF
}


########## CHECK ADMIN PASSWORD ##########
sub checkpword {

open (VARIABLES, "$path/password.txt") || &error("Error reading password.txt");
$admin_password = <VARIABLES>;
close (VARIABLES);

if ($INPUT{'password'}) {
	$newpassword = crypt($INPUT{'password'}, ai);
	unless ($newpassword eq $admin_password) {
		print <<EOF;
<table cellspacing =0 bgcolor =#00416B border=1 cellpadding =8>
<TR bgcolor=#E4E4E4 align=center><TD><FONT SIZE="-1" FACE="Arial">Wrong Password 
</TD></TR></TABLE>
EOF
		&Footer;
		exit;
	}
}
else {
print <<EOF;
<table cellspacing =0 bgcolor =#00416B border=1 cellpadding =8>
<TR bgcolor=#E4E4E4 align=center><TD><FONT SIZE="-1" FACE="Arial">You must enter a password
</TD></TR></TABLE>
EOF
	&Footer;
	exit;
}
$password = $INPUT{'password'};
}

sub error {
print "$_[0]";
exit;
}

sub Header {
print <<EOF;
<HTML><HEAD>
<TITLE>Advanced Browsing</TITLE>
</HEAD>
<BODY><BR><CENTER>
EOF

}

sub Footer {
print <<EOF;
</BODY>
EOF
}

sub demo {

print <<EOF;
<html>
<head>
<title>Error</title>
</head>
<body>
<TABLE border=1 bgcolor=Gainsboro><TR align=left><TD>
<font face="arial" size="-1"><center>
<B>Community Feature Disabled<BR><BR>
<BR><BR>
Because this is a demo open to the public, some features must be disabled<BR>
should you have any questions about this feature, please email us Community Builder</a>
<BR><BR>
</TD></TR></TABLE>
</BODY></HTML>
EOF
&Footer;
exit;
}