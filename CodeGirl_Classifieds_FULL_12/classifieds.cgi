#!/usr/local/bin/perl
use vars qw(%config %category %left %right %form %supercat);
local %form = &get_form_data;
use strict;
#-###########################################################################
#CodeGirl Classifieds v 1.2
#Copyright 2001 by CodeGirl Classifieds. All rights reserved. This copyright 
#notice must remain intact. By installing this software you agree to the following 
#terms and conditions. If you do not agree to these terms and conditions, you 
#must delete this software immediately. This script may not be copied or 
#modified in any way without permission in writing from CodeGirl Classifieds. 
#This Software Product is licensed (not sold) to you, and CodeGirl Classifieds 
#owns all copyright, trade secret, patent and other proprietary rights in the 
#Software Product. The term "Software Product" includes all copies of the 
#CodeGirl classifieds script and its documentation.You are hereby granted a 
#nonexclusive license to use the Software Product on a single domain.  You may 
#make one copy of the Software Product's computer program for back-up 
#purposes only. You may not: (1) copy (other than once for back-up purposes), 
#distribute, rent, lease or sublicense all or any portion of the Software Product; 
#(3) reverse engineer, decompile or dissemble the Software Product.  You agree 
#to keep confidential and use your best efforts to prevent and protect the 
#contents of the Software Product from unauthorized disclosure or use. Transfer 
#of the Software Product is prohibited.  Your license is automatically terminated 
#if you transfer the Software Product. For 90 days from the date of registration, 
#we warrant that the media (for example, ZIP archive) on which the 
#Software Product is contained will be free from defects in materials and 
#workmanship.  This warranty does not cover damage caused by improper use or 
#neglect.  We do not warrant the contents of the Software Product or that it will 
#be error free.  The Software Product is furnished "As Is" and without warranty 
#as to the performance or results you may obtain by using the Software Product. 
#The entire risk as to the results and performance of the Software Product is 
#assumed by you.  The warranties in this agreement replace all other warranties, 
#express or implied, including any warranties of merchantability or fitness for a 
#particular pupose. We disclaim and exclue all other warranties. In no event will 
#our liability of any kind include any special, incidental or consequential 
#damages, including lost profits, even if we have knowledge of the potential loss 
#or damage. We will not be liable for any loss or damage caused by delay in 
#furnishing a Software Product or any other performance under this Agreement. 
#Our entire liability and your exclusive remedies for our liability of any kind 
#(including liability for negligence except liability for personal injury caused 
#solely by our negligence) for the Software Product covered by this Agreement 
#and all other performance or nonperformance by us under or related to this 
#Agreement are limited to the remedies specified by this Agreement. This 
#Agreement is effective until terminated. You may terminate it at any time by 
#destroying the Software Product, including all computer programs and 
#documentation, and erasing any copies residing on computer equipment or 
#storage media.  This Agreement also will terminate if you do not comply
#with any terms or conditions of this Agreement.  Upon such termination you 
#agree to destroy the Software Product and erase all copies residing on computer 
#equipment or storage media. The Software Product is provided to the 
#Government only with restricted rights and limited rights.  Use, duplication, or 
#disclosure by the Government is subject to restrictions set forth in FAR Sections 
#52-227-14 and 52-227-19 or DFARS Section 52.227-7013(C)(1)(ii), as 
#applicable. You are responsible for installation, management and operation of 
#the Software Product.
#-###########################################################################

#-#############################################
# Configuration Section
# Edit these variables!
local %config;
$config{'basepath'} = '/path/to/your/data/directory/';
$config{'closedir'} = 'closed';
$config{'regdir'} = 'users';
$config{'adminpass'} = 'password';
$config{'mailprog'} = '/var/qmail/bin/qmail-inject';
#$config{'mailhost'} = 'localhost'; # UNCOMMENT THIS LINE IF YOU NEED A MAIL HOST (SMTP)
$config{'admin_address'} = 'yourname@youraddress.com';
$config{'scripturl'} = 'www.yourdomain.com'; #no http or trailing slash
$config{'colortablehead'} = '#666699';
$config{'colortablebody'} = '#EEEEEE';
$config{'colortableborder'} = '#333366';
$config{'sitename'} = 'Your Site Name';
$config{'pagebreak'} = '15';
$config{'searchpagebreak'} = '25';
$config{'adlimit'} = '20';
$config{'flock'} = 1;
$config{'newokay'} = 1;
$config{'imageuploaddir'} = '/path/to/your/images';
$config{'imageuploadurl'} = "http://www.yourdomain.com/pictures";

###############################################
# Get the script location: UNIX or Windows
###############################################

#--Image Upload END------------------------------------#

# List each directory and its associated
# category name.  These directories should
# be subdirectories of the base directory.

%supercat = (
	AV => 'Audio & Video',
	AU => 'Audio',
	AB => 'Video',
	CA => 'Cameras',
	BU => 'Business',
	BO => 'Opportunities',
	CS => 'Computers & Software',
	HO => 'Household',
	EM => 'Employment',
	PE => 'Personals',
	RE => 'Real Estate',
	AT => 'Automotive',
	AM => 'Automobiles',
	MS => 'Miscellaneous',
	PT => 'Pets & Supplies',
	PS => 'Pet Services',
	CO => 'Collectibles',
	TY => 'Toys',
	TR => 'Travel',
);

%category = (
	AVA     => '<!--AV--><!--AU-->Instruments',
	AVB     => '<!--AV--><!--AU-->CDs & Cassettes',
	AVC     => '<!--AV--><!--AU-->Stereo Equipment',
	AVD     => '<!--AV--><!--AU-->MP3',
	AVE     => '<!--AV--><!--AB-->Video Cameras',
	AVF     => '<!--AV--><!--AB-->TV',
	AVG     => '<!--AV--><!--AB-->VCR',
	AVH     => '<!--AV--><!--AB-->Satellites',
	AVI     => '<!--AV--><!--CA-->35mm',
	AVJ    => '<!--AV--><!--CA-->Digital',
	AVK    => '<!--AV--><!--CA-->Polaroid',
	AVL    => '<!--AV--><!--CA-->Other Cameras',
	AVM    => '<!--AV-->Other Audio & Video',
	BUA     => '<!--BU--><!--BO-->Home-Based',
	BUB     => '<!--BU--><!--BO-->Internet',
	BUC     => '<!--BU--><!--BO-->Investments',
	BUD     => '<!--BU--><!--BO-->Other Business Ops',
	BUE     => '<!--BU-->Office Equipment',
	BUF     => '<!--BU-->Business Services',
	BUG     => '<!--BU-->Other Business',
	CSA     => '<!--CS-->Hardware',
	CSB     => '<!--CS-->Software',
	CSC     => '<!--CS-->Internet',
	CSD     => '<!--CS-->Computer Services',
	HOA    => '<!--HO-->Furniture',
	HOB    => '<!--HO-->Appliances',
	HOC    => '<!--HO-->Home Services',
	HOD    => '<!--HO-->Other Household',
	EMA    => '<!--EM-->Help Wanted',
	EMB    => '<!--EM-->Resumes',
	EMC    => '<!--EM-->Career Services',
	EMD    => '<!--EM-->Other Job Resources',
	PEA     => '<!--PE-->Women Seeking Men',
	PEB     => '<!--PE-->Men Seeking Men',
	PEC     => '<!--PE-->Women Seeking Women',
	PED     => '<!--PE-->Men Seeking Women',
	REA     => '<!--RE-->Commercial',
	REB     => '<!--RE-->Residential',
	REC     => '<!--RE-->Rentals',
	RED     => '<!--RE-->Real Estate Services',
	ATA     => '<!--AT--><!--AM-->Cars',
	ATB     => '<!--AT--><!--AM-->Trucks',
	ATC     => '<!--AT--><!--AM-->Vans',
	ATD     => '<!--AT--><!--AM-->Sport Utilities',
	ATE     => '<!--AT-->Boats',
	ATF     => '<!--AT-->Motorcycles',
	ATG     => '<!--AT-->Other Automotive',
	TRA     => '<!--TR-->Tours',
	TRB     => '<!--TR-->Tickets',
	TRC     => '<!--TR-->Travel Agents',
	TRD     => '<!--TR-->Other Travel',
	MSA     => '<!--MS-->Books',
 	MSB     => '<!--MS-->Sports Equipment',
  	MSC     => '<!--MS-->Health & Beauty',
     	MSD     => '<!--MS-->Other',
	PTA     => '<!--PT-->Birds',
	PTB     => '<!--PT-->Dogs',
	PTC     => '<!--PT-->Cats',
	PTD     => '<!--PT-->Exotic Animals',
	PTE     => '<!--PT-->Other Animals',
	PTF     => '<!--PT--><!--PS-->Grooming',
	PTG     => '<!--PT--><!--PS-->Veterinary Care',
	PTH     => '<!--PT--><!--PS-->Boarding',
	PTI     => '<!--PT--><!--PS-->Other Pet Services',
	COA    => '<!--CO-->Antiques',
	COB    => '<!--CO--><!--TY-->Beanies',
	COC    => '<!--CO--><!--TY-->Star Wars',
	COD    => '<!--CO--><!--TY-->Pokemon',
	COE    => '<!--CO--><!--TY-->Other Toys',
	COF    => '<!--CO-->Dolls',
	COG    => '<!--CO-->Stamps',
	COH    => '<!--CO-->Coins',
	COI    => '<!--CO-->Other Collectibles',
);

# You can configure your own header which will
# be appended to the top of each page.

$config{'header'} =<<"EOF";
<HTML>
<HEAD>
	<TITLE>$config{'sitename'} - Powered by CodeGirl Classifieds</TITLE>
</HEAD>
<BODY TEXT=#000000 BGCOLOR=#FFFFFF LINK=#000088 VLINK=#000088 ALINK=#000088>
		<H1><CENTER>$config{'sitename'} Classifieds</FONT></CENTER></H1>
	<P>
EOF

# You can configure your own footer which will
# be appended to the bottom of each page.
# Although not required, a link back to
# everysoft.com will help to support future
# development.

$config{'footer'} =<<"EOF";
<P>
<CENTER><FONT SIZE=-1><I>Powered By <A HREF=http://codegirl.virtualave.net/>CodeGirl Classifieds 1.2</A></I></FONT></CENTER>
</BODY>
</HTML>
EOF



#-#############################################
# Main Program
# You do not need to edit anything below this
# line.

#-#############################################
# Print The Page Header
#
print "Content-type: text/html\n\n";
print $config{'header'};
#
#-#############################################
#if ($form{'action'} eq 'new') { &new; }
if ($form{'action'} eq 'new') { &upload; }
elsif ($form{'picture'}) { &new; }
elsif ($form{'pictureurl'}) { &new; }
elsif (lc($form{'action'}) eq 'uploaddone') { &new; }
elsif ($form{'action'} eq 'repost') { &new; }
elsif ($form{'action'} eq 'procnew') { &procnew; }
elsif ($form{'action'} eq 'procrft') { &procrft; }
elsif ($form{'action'} eq 'reg') { &reg; }
elsif ($form{'action'} eq 'procreg') { &procreg; }
elsif ($form{'action'} eq 'creg') { &creg; }
elsif ($form{'action'} eq 'proccreg') { &proccreg; }
elsif ($form{'action'} eq 'closed') { &viewclosed1; }
elsif ($form{'action'} eq 'closed2') { &viewclosed2; }
elsif ($form{'action'} eq 'closed3') { &viewclosed3; }
elsif ($form{'action'} eq 'admin') { &admin; }
elsif ($form{'action'} eq 'adminview') { &adminview; }
elsif ($form{'action'} eq 'vregusers') { &vregusers; }
elsif ($form{'action'} eq 'deleteuser') { &deleteuser; }
elsif ($form{'action'} eq 'deleteuser2') { &deleteuser2; }
elsif ($form{'action'} eq 'admin_moditem') { &admin_moditem; }
elsif ($form{'action'} eq 'admin_moditemb') { &admin_moditemb; }
elsif ($form{'action'} eq 'admin_moditem2') { &admin_moditem2; }
elsif ($form{'action'} eq 'banemail') { &banemail; }
elsif ($form{'action'} eq 'banemail2') { &banemail2; }
elsif ($form{'action'} eq 'unbanemail') { &unbanemail; }
elsif ($form{'action'} eq 'unbanemail2') { &unbanemail2; }
elsif ($form{'action'} eq 'emailusers') { &emailusers; }
elsif ($form{'action'} eq 'procadmin') { &procadmin; }
elsif ($form{'action'} eq 'mlist') { &maillist; }
elsif ($form{'action'} eq 'search1') { &start_search; }
elsif ($form{'action'} eq 'search') { &procsearch; }
elsif ($form{'item'} eq int($form{'item'}) and $category{$form{'category'}}) { &dispitem; }
elsif ($category{$form{'category'}}) { &displist; }
elsif ($form{'action'} eq 'lp') { &lp; }
elsif ($form{'action'} eq 'lp2') { &lp2; }
elsif ($form{'action'} eq 'seller_moditem') { &seller_moditem; }
elsif ($form{'action'} eq 'seller_moditem2') { &seller_moditem2; }
else { &dispcat; }

#-#############################################
# Print The Page Footer
#
print "<P><P ALIGN=CENTER><FONT SIZE=-1><A HREF=$ENV{'SCRIPT_NAME'}>[Categories]</A>";
print " <A HREF=$ENV{'SCRIPT_NAME'}?action=new>[Post New Ad]</A>" if ($config{'newokay'});
print " <A HREF=$ENV{'SCRIPT_NAME'}?action=reg>[New Registration]</A> <A HREF=$ENV{'SCRIPT_NAME'}?action=creg>[Edit Registration]</A>" if ($config{'regdir'});
print " <A HREF=$ENV{'SCRIPT_NAME'}?action=closed>[Repost Ad]</A>" if ($config{'regdir'}) and ($config{'closedir'});
print " <A HREF=$ENV{'SCRIPT_NAME'}?action=search1>[Search Ads]</A>";
print " </FONT></P>\n";
print $config{'footer'};
EXITSCRIPT: check_index();
#-#############################################
    eval {
        if ($ENV{'WINDIR'}) {
            ($0 =~ m,(.*)\\[^\\]+,) && unshift (@INC, "$1"); # Windows
        }
        else {
            ($0 =~ m,(.*)/[^/]+,) && unshift (@INC, "$1"); # UNIX
        }
    };
    if ($@) {
        print "Error - the following files couldn't be opened: $@\n";
        print "Please, make sure that the files exist and/or access rights and paths are configured correctly.";
        exit;
    }


sub dispcat {
	&autoclose;
	if (my $backto = &backto) {print "$backto<br><br>"}
	my $catinfo="<!--$form{category}-->";$catinfo=~s/\:/--><!--/g;$catinfo=~s/<!---->//g;
	print "<p><TABLE WIDTH=100\% BORDER=0 BGCOLOR=$config{'colortableborder'} CELLSPACING=0><TR><TD>";
 	if($form{category} =~ /:([^:]*)$/){
		# SUB CATEGORIES
  		print "<TABLE BORDER=0 WIDTH=100\% CELLPADDING=2 CELLSPACING=1><TR><TD BGCOLOR=$config{'colortablehead'} COLSPAN=2><CENTER><B>Subcategories of $supercat{$1}</B></CENTER></TD></TR>";
	}else{
		# MAIN CATEGORIES
		print "<TABLE BORDER=0 WIDTH=100\% CELLPADDING=2 CELLSPACING=1><TR><TD BGCOLOR=$config{'colortablehead'} COLSPAN=2><CENTER><B>Categories</B></CENTER></TD></TR>";
	}
	
	my($key, %numfiles, %mycategory);
	foreach $key (keys %category) {
		next if $category{$key}!~/^\Q$catinfo\E/;
		umask(000);  # UNIX file permission junk
		mkdir("$config{'basepath'}$key", 0777) unless (-d "$config{'basepath'}$key");
		opendir THEDIR, "$config{'basepath'}$key" or &oops("Category directory $key could not be opened.");
		my @allfiles = grep -T, map "$config{'basepath'}$key/$_", readdir THEDIR;
		closedir THEDIR;
		if($category{$key} =~ /^\Q$catinfo\E<!--([^>]*)-->/ && $supercat{$1} ne ''){
			$mycategory{"$form{category}:$1"} = $supercat{$1};
			$numfiles{"$form{category}:$1"} += @allfiles;
		}else{
			$mycategory{$key} = $category{$key};
			$numfiles{$key} += @allfiles;
		}
	}
	# PRINT TWO COLUMNS
	my @keys = sort {lc $mycategory{$a} cmp lc $mycategory{$b}} keys %mycategory;
	my $middle=int($#keys/2) + 1;
	my $i;
	for($i=0;$i<$middle;$i++) {
		print "<tr bgcolor=$config{'colortablebody'}>";
		foreach(($i,$i+$middle)){
			my $key=$keys[$_];
			print "<td align=center width=49\%><a href=$ENV{'SCRIPT_NAME'}?category=$key&super=true>$mycategory{$key}</a> ($numfiles{$key})</td>";
		}
		print "</tr>";
	}
	print "</TABLE></TD></TR></TABLE>\n";
}

sub displist {
 	if (my $backto = &backto) {print "$backto"}
	print "<br><br><TABLE WIDTH=100\% BORDER=0 BGCOLOR=$config{'colortableborder'} CELLSPACING=0><TR><TD><TABLE BORDER=0 WIDTH=100\% CELLPADDING=2 CELLSPACING=1>\n";
	print "<TR><TD ALIGN=CENTER BGCOLOR=$config{'colortablehead'}><B>$category{$form{'category'}}</B></TD></TR>\n";
	opendir THEDIR, "$config{'basepath'}$form{'category'}" or &oops("Category directory $form{'category'} could not be opened.");
	readdir THEDIR;readdir THEDIR;
	my @allfiles = sort { $a <=> $b } map {int $_} readdir THEDIR;
	closedir THEDIR;
	my $file;
	my $pagebreak = int $form{pb} || $config{'pagebreak'};
	my ($icount, $pcount) = (0,0);
	foreach $file (@allfiles) {
		if(++$icount > $pagebreak){$icount=1; $pcount++}
		next if $pcount != $form{page};
		$file =~ s/^$config{'basepath'}$form{'category'}\///;
		$file =~ s/\.dat$//;
		my ($title, $rgt, $rht, $desc, $image, $url, @rfts) = &read_item_file($form{'category'},$file);
  		if ($title ne '') {
			my ($alias, $email, $rft, $time, $add1, $add2, $add3) = &read_rft($rfts[$#rfts]);
			my @closetime = localtime($file);
			$closetime[4]++;
			print "<TR><TD BGCOLOR=$config{'colortablebody'}><A HREF=$ENV{'SCRIPT_NAME'}\?category=$form{'category'}\&item=$file>$title</A>";
			print "&nbsp;&nbsp;<IMG SRC=camera.gif>" if ($image);
			print "</TD></TR>\n";
		}
	}
	print "</TABLE></TD></TR></TABLE><br>\n";
	pagebreak($pcount,$pagebreak);
}

sub dispitem {
	if (my $backto = &backto) {print "$backto"}
	my ($title, $rgt, $rht, $desc, $image, $url, @rfts) = &read_item_file($form{'category'},$form{'item'});
	&oops("Ad $form{'item'} could not be opened.<br>If this ad has expired and you are the ad poster, you may <A HREF=$ENV{'SCRIPT_NAME'}\?action=closed>repost</A> your ad.") if $title eq '';
	my $nowtime = localtime(time);
	my $closetime = localtime($form{'item'});
	print "<p><TABLE WIDTH=100\% BORDER=0 BGCOLOR=$config{'colortableborder'} CELLSPACING=0><TR><TD><TABLE BORDER=0 WIDTH=100\% CELLPADDING=2 CELLSPACING=1><TR><TD BGCOLOR=$config{'colortablehead'}><B>$title</B></TD></TR><TR><TD BGCOLOR=$config{'colortablebody'}>";
	my ($alias, $email, $rft, $time, $add1, $add2, $add3) = &read_rft($rfts[0]); # read first rft
	print "<B>Reply To: <A HREF=\"mailto:$email?subject=$config{'sitename'} Classified Ad Response\"><u>$alias</u></A></B></TD></TR>";
 	print "<TR><TD BGCOLOR=$config{'colortablebody'}><B>Website: <A HREF=\"$url\"} TARGET=top><u>$url</u></A></B></TD></TR>"  if ($url);
	print "<TR><TD BGCOLOR=$config{'colortablebody'}>$desc</TD></TR>";
	print "<TR><TD BGCOLOR=$config{'colortablebody'}><CENTER><IMG SRC=$image></CENTER></TD></TR>" if ($image);
	print "</TABLE></TD></TR></TABLE>";
	my ($alias, $email, $rft, $time, $add1, $add2, $add3) = &read_rft($rfts[$#rfts]); # read the last rft
	if ((time > int($form{'item'})) && (time > (60 * 0 + $time))) {
		print "<FONT SIZE=-1 COLOR=#FF0000><B>THIS AD HAS EXPIRED</B></FONT><BR>";
		&closeit($form{'category'},$form{'item'});
	}
	else {
	print <<"EOF";
</form><br><br><center><FORM ACTION=$ENV{'SCRIPT_NAME'} METHOD=POST>
<input type=hidden name=action value=seller_moditem>
<input type=hidden name=CATEGORY value=$form{'category'}>
<input type=hidden name=ITEM value=$form{'item'}>
<input type=hidden name=TITLE value=$form{'title'}> 
EOF

	{if ($config{'regdir'}) {
		print <<"EOF";
  <table border=0 cellpadding=0 bordercolor=#000000>
<tr>
<td COLSPAN=2><center>
If this is your ad you may modify or delete it.<br>Please remember to capitalize the first letter of your username.
</center></td></tr>
<tr><td><b>Username:</B></TD><TD ALIGN=LEFT><INPUT NAME=ALIAS TYPE=TEXT SIZE=20 MAXLENGTH=30></TD></TR><TR><TD><b>Password:</b><BR><i><font size=\"-1\"><A HREF=$ENV{'SCRIPT_NAME'}?action=lp>Forgot password\?</a></font></i></TD><TD ALIGN=LEFT><INPUT NAME=PASSWORD TYPE=PASSWORD SIZE=20></td></tr>
<tr><td valign="top" COLSPAN=2><center>Modify or Delete?
<select name=MODDEL>
<option selected value="">[Select One]</option>
<option value=MOD>Modify</option>
<option value=DEL>Delete</option></select>&nbsp;&nbsp;<input type=submit value="Continue"></form></center></td></tr></table>
EOF
}

}


	}
}

sub new {
	my $rht = '1.00';
	my ($title, $rgt, $rht, $desc, $image, $url, @rfts);
	if ($form{'REPOST'}) {
		$form{'REPOST'} =~ s/\W//g;
		if (-T "$config{'basepath'}$config{'closedir'}/$form{'REPOST'}.dat") {
			open THEFILE, "$config{'basepath'}$config{'closedir'}/$form{'REPOST'}.dat";
			($title, $rgt, $rht, $desc, $image, $url, @rfts) = <THEFILE>;
			close THEFILE;
			chomp($title, $rgt, $rht, $desc, $image, $url, @rfts);
			$title =~ s/\"//g; 
		}
	}
	print <<"EOF";
<FORM ACTION=$ENV{'SCRIPT_NAME'} METHOD=POST>
<H2><CENTER>Place A New Ad</CENTER></H2>
<TABLE WIDTH=100% BORDER=0>
<INPUT TYPE=HIDDEN NAME=action VALUE=procnew>
<TR><TD VALIGN=TOP><B>Category:</B></TD><TD><SELECT NAME=CATEGORY>
<OPTION SELECTED VALUE=\"\">[Select One]</OPTION>
EOF
	my($key, $disppath, $thispath, @this);
	foreach $key (keys %category) {
		$disppath = '';
		$thispath = $category{$key};
		while($thispath =~ s/^<!--([^\>]*)-->//){
			if($supercat{$1} ne ''){
				$disppath .= "$supercat{$1} -> ";
			}
		}
		push(@this, ["$disppath$category{$key}", $disppath, "<OPTION VALUE=\"$key\">$disppath$category{$key}</OPTION>\n"]);
	}
	foreach $key (sort {lc $a->[0] cmp lc $b->[0]} @this){
		if($key->[1] ne $thispath){
			$thispath=$key->[1];
		}
		print $key->[2];
	}
	print <<"EOF";
</SELECT></TD></TR>
<TR><TD VALIGN=TOP><B>Title:<BR></B>No HTML</TD><TD><INPUT NAME=TITLE VALUE=\"$title\" TYPE=TEXT SIZE=50 MAXLENGTH=50></TD></TR>
EOF
    if ($form{'action'} eq 'uploaddone') {
            $form{'IMAGEUPLOAD'} = "YES";
                if ($form{'extension'} ne '') {
                    print "<INPUT TYPE=HIDDEN NAME=extension VALUE=$form{'extension'}>";
                }
            $image = $form{'image'};
            print "<INPUT TYPE=HIDDEN NAME=IMAGEUPLOAD VALUE=YES>";
        }
        else {
            $form{'IMAGEUPLOAD'} = "NO";
            print "<INPUT TYPE=HIDDEN NAME=IMAGEUPLOAD VALUE=NO>";
            $image = "NONE" if $form{'picture'};
            $image = $form{'pictureurl'} if $form{'pictureurl'};
        }
    print "<TR><TD VALIGN=TOP><B>Image:<BR></B></TD>";
    print "<TD><INPUT NAME=IMAGE VALUE=\"$image\" TYPE=HIDDEN SIZE=50><b> $image</b></TD></TR>";
    print <<"EOF";
<TR><TD VALIGN=TOP><B>Website:<BR></B>Optional - Include http://</TD><TD><INPUT NAME=URL VALUE=\"$url\" TYPE=TEXT SIZE=50 VALUE="http://"></TD></TR>
<TR><TD VALIGN=TOP><B>Ad Duration:<BR></B>1 week - 1 year</TD><TD><select name=DAYS size="1">
<option value="" selected>[Select One]<option value="7">1 week<option value="14">2 weeks<option value="21">3 weeks<option value="30">1 month<option value="60">2 months<option value="90">3 months<option value="180">6 months<option value="270">9 months<option value="365">1 year</select></TD></TR>
<TR><TD VALIGN=TOP><B>Description:<BR></B>HTML Allowed</TD><TD><TEXTAREA NAME=DESC WRAP=VIRTUAL ROWS=5 COLS=45>$desc</TEXTAREA></TD></TR>
<TR><TD COLSPAN=2 VALIGN=TOP><br>
EOF

	if ($config{'regdir'}) {
		print <<"EOF";
<P><CENTER><B><A HREF="$ENV{'SCRIPT_NAME'}?action=reg">Registration</A> is required to place an ad.</B><br><br></CENTER></TD></TR>
<TR><TD VALIGN=TOP><B>Username:</B></TD><TD><INPUT NAME=ALIAS TYPE=TEXT SIZE=30 MAXLENGTH=30>
<TR><TD VALIGN=TOP><B>Password:</B><BR><i><font size=\"-1\"><A HREF=$ENV{'SCRIPT_NAME'}?action=lp>Forgot password\?</a></font></i></TD><TD><INPUT NAME=PASSWORD TYPE=PASSWORD SIZE=30></TD></TR></TABLE>
EOF
	}

 else {
		print <<"EOF";
</TD></TR>
<TR><TD VALIGN=TOP><B>Your Username: <BR></B>Used to track your post</TD><TD><INPUT NAME=ALIAS TYPE=TEXT SIZE=30 MAXLENGTH=30></TD></TR>
<TR><TD VALIGN=TOP><B>E-Mail Address:</B> </TD><TD><INPUT NAME=EMAIL TYPE=TEXT SIZE=30></TD></TR>
<TR><TD VALIGN=TOP COLSPAN=2><BR><BR><B>Contact Information: </B>Will <b>not</b> be listed in your ad. If you would like your contact information to appear in your ad, please enter it in the description field.</TD></TR>
<TR><TD><B><BR><BR>Full Name:</B> </TD><TD><BR><BR><INPUT NAME=ADDRESS1 TYPE=TEXT SIZE=30></TD></TR>
<TR><TD><B>Street Address:</B> </TD><TD><INPUT NAME=ADDRESS2 TYPE=TEXT SIZE=30></TD></TR>
<TR><TD VALIGN=TOP><B>City: </B></TD><TD><INPUT NAME=ADDRESS3 TYPE=TEXT SIZE=30><br></TD></TR>
<TR><TD VALIGN=TOP><B>State:</B> <BR>Choose\"International\" if living outside the US.</TD>
<TD>
			<select name=ADDRESS4 size="1">
<option value="" selected>[Select One]<option value="INT">International<option value="AL">Alabama<option value="AK">Alaska<option value="AZ">Arizona<option value="AR">Arkansas<option value="CA">California<option value="CO">Colorado<option value="CT">Connecticut<option value="DE">Delaware<option value="DC">District of Columbia<option value="FL">Florida<option value="GA">Georgia<option value="HI">Hawaii<option value="ID">Idaho<option value="IL">Illinois<option value="IN">Indiana<option value="IA">Iowa<option value="KS">Kansas<option value="KY">Kentucky<option value="LA">Louisiana<option value="ME">Maine<option value="MD">Maryland<option value="MA">Massachusetts<option value="MI">Michigan<option value="MN">Minnesota<option value="MS">Mississippi<option value="MO">Missouri<option value="MT">Montana<option value="NE">Nebraska<option value="NV">Nevada<option value="NH">New Hampshire<option value="NJ">New Jersey<option value="NM">New Mexico<option value="NY">New York<option value="NC">North Carolina<option value="ND">North Dakota<option value="OH">Ohio<option value="OK">Oklahoma<option value="OR">Oregon<option value="PA">Pennsylvania<option value="RI">Rhode Island<option value="SC">South Carolina<option value="SD">South Dakota<option value="TN">Tennessee<option value="TX">Texas<option value="UT">Utah<option value="VT">Vermont<option value="VA">Virginia<option value="WA">Washington<option value="WV">West Virginia<option value="WI">Wisconsin<option value="WY">Wyoming
			</select>
<BR></TD></TR>
<TR><TD VALIGN=TOP><B>ZIP: </B></TD><TD><INPUT NAME=ADDRESS5 TYPE=TEXT SIZE=30><br></TD></TR>
<TR><TD VALIGN=TOP><B>Country:</B></TD>
<TD>
			<select name=ADDRESS6 size="1">
<option value="" selected>[Select One]<option value="US">United States<option value="UM">United States Minor Outlying Islands<option value="AF">Afghanistan<option value="AL">Albania<option value="DZ">Algeria<option value="AS">American Samoa<option value="AD">Andorra<option value="AO">Angola<option value="AI">Anguilla<option value="AQ">Antarctica<option value="AG">Antigua And Barbuda<option value="AR">Argentina<option value="AM">Armenia<option value="AW">Aruba<option value="AU">Australia<option value="AT">Austria<option value="AZ">Azerbaijan<option value="BS">Bahamas, The<option value="BH">Bahrain<option value="BD">Bangladesh<option value="BB">Barbados<option value="BY">Belarus<option value="BE">Belgium<option value="BZ">Belize<option value="BJ">Benin<option value="BM">Bermuda<option value="BT">Bhutan<option value="BO">Bolivia<option value="BA">Bosnia and Herzegovina<option value="BW">Botswana<option value="BV">Bouvet Island<option value="BR">Brazil<option value="IO">British Indian Ocean Territory<option value="BN">Brunei<option value="BG">Bulgaria<option value="BF">Burkina Faso<option value="BI">Burundi<option value="KH">Cambodia<option value="CM">Cameroon<option value="CA">Canada<option value="CV">Cape Verde<option value="KY">Cayman Islands<option value="CF">Central African Republic<option value="TD">Chad<option value="CL">Chile<option value="CN">China<option value="CX">Christmas Island<option value="CC">Cocos (Keeling) Islands<option value="CO">Colombia<option value="KM">Comoros<option value="CG">Congo<option value="CD">Congo, Democractic Republic of the  <option value="CK">Cook Islands<option value="CR">Costa Rica<option value="CI">Cote D\'Ivoire (Ivory Coast)
<option value="HR">Croatia (Hrvatska)<option value="CU">Cuba<option value="CY">Cyprus<option value="CZ">Czech Republic<option value="DK">Denmark<option value="DJ">Djibouti<option value="DM">Dominica<option value="DO">Dominican Republic<option value="TP">East Timor<option value="EC">Ecuador<option value="EG">Egypt<option value="SV">El Salvador<option value="GQ">Equatorial Guinea<option value="ER">Eritrea<option value="EE">Estonia<option value="ET">Ethiopia<option value="FK">Falkland Islands (Islas Malvinas)<option value="FO">Faroe Islands<option value="FJ">Fiji Islands<option value="FI">Finland<option value="FR">France<option value="GF">French Guiana<option value="PF">French Polynesia<option value="TF">French Southern Territories<option value="GA">Gabon<option value="GM">Gambia, The<option value="GE">Georgia<option value="DE">Germany<option value="GH">Ghana<option value="GI">Gibraltar<option value="GR">Greece<option value="GL">Greenland<option value="GD">Grenada<option value="GP">Guadeloupe<option value="GU">Guam<option value="GT">Guatemala<option value="GN">Guinea<option value="GW">Guinea-Bissau<option value="GY">Guyana<option value="HT">Haiti<option value="HM">Heard and McDonald Islands<option value="HN">Honduras<option value="HK">Hong Kong S.A.R.<option value="HU">Hungary<option value="IS">Iceland<option value="IN">India<option value="ID">Indonesia<option value="IR">Iran<option value="IQ">Iraq<option value="IE">Ireland<option value="IL">Israel<option value="IT">Italy<option value="JM">Jamaica<option value="JP">Japan<option value="JO">Jordan<option value="KZ">Kazakhstan<option value="KE">Kenya<option value="KI">Kiribati<option value="KR">Korea<option value="KP">Korea, North <option value="KW">Kuwait<option value="KG">Kyrgyzstan<option value="LA">Laos<option value="LV">Latvia<option value="LB">Lebanon<option value="LS">Lesotho<option value="LR">Liberia<option value="LY">Libya<option value="LI">Liechtenstein<option value="LT">Lithuania<option value="LU">Luxembourg<option value="MO">Macau S.A.R.<option value="MK">Macedonia, Former Yugoslav Republic of<option value="MG">Madagascar<option value="MW">Malawi<option value="MY">Malaysia<option value="MV">Maldives<option value="ML">Mali<option value="MT">Malta<option value="MH">Marshall Islands<option value="MQ">Martinique<option value="MR">Mauritania<option value="MU">Mauritius<option value="YT">Mayotte<option value="MX">Mexico<option value="FM">Micronesia<option value="MD">Moldova<option value="MC">Monaco<option value="MN">Mongolia<option value="MS">Montserrat<option value="MA">Morocco<option value="MZ">Mozambique<option value="MM">Myanmar<option value="NA">Namibia<option value="NR">Nauru<option value="NP">Nepal<option value="AN">Netherlands Antilles<option value="NL">Netherlands, The<option value="NC">New Caledonia<option value="NZ">New Zealand<option value="NI">Nicaragua<option value="NE">Niger<option value="NG">Nigeria<option value="NU">Niue<option value="NF">Norfolk Island<option value="MP">Northern Mariana Islands<option value="NO">Norway<option value="OM">Oman<option value="PK">Pakistan<option value="PW">Palau<option value="PA">Panama<option value="PG">Papua new Guinea<option value="PY">Paraguay<option value="PE">Peru<option value="PH">Philippines<option value="PN">Pitcairn Island<option value="PL">Poland<option value="PT">Portugal<option value="PR">Puerto Rico<option value="QA">Qatar<option value="RE">Reunion<option value="RO">Romania<option value="RU">Russia<option value="RW">Rwanda<option value="SH">Saint Helena<option value="KN">Saint Kitts And Nevis<option value="LC">Saint Lucia<option value="PM">Saint Pierre and Miquelon<option value="VC">Saint Vincent And The Grenadines<option value="WS">Samoa<option value="SM">San Marino<option value="ST">Sao Tome and Principe<option value="SA">Saudi Arabia<option value="SN">Senegal<option value="SC">Seychelles<option value="SL">Sierra Leone<option value="SG">Singapore<option value="SK">Slovakia<option value="SI">Slovenia<option value="SB">Solomon Islands<option value="SO">Somalia<option value="ZA">South Africa<option value="GS">South Georgia And The South Sandwich Islands<option value="ES">Spain<option value="LK">Sri Lanka<option value="SD">Sudan<option value="SR">Suriname<option value="SJ">Svalbard And Jan Mayen Islands<option value="SZ">Swaziland<option value="SE">Sweden<option value="CH">Switzerland<option value="SY">Syria<option value="TW">Taiwan<option value="TJ">Tajikistan<option value="TZ">Tanzania<option value="TH">Thailand<option value="TG">Togo<option value="TK">Tokelau<option value="TO">Tonga<option value="TT">Trinidad And Tobago<option value="TN">Tunisia<option value="TR">Turkey<option value="TM">Turkmenistan<option value="TC">Turks And Caicos Islands<option value="TV">Tuvalu<option value="UG">Uganda<option value="UA">Ukraine<option value="AE">United Arab Emirates<option value="UK">United Kingdom<option value="UY">Uruguay<option value="UZ">Uzbekistan<option value="VU">Vanuatu<option value="VA">Vatican City State (Holy See)<option value="VE">Venezuela<option value="VN">Vietnam<option value="VG">Virgin Islands (British)<option value="VI">Virgin Islands (US)<option value="WF">Wallis And Futuna Islands<option value="YE">Yemen<option value="YU">Yugoslavia<option value="ZM">Zambia<option value="ZW">Zimbabwe
				</select>
<br></TD></TR>
<TR><TD VALIGN=TOP><B>Phone: <BR></B>Not Required</TD><TD><INPUT NAME=PHONE TYPE=TEXT SIZE=15></TD></TR></TABLE>
EOF
	}
	
	print <<"EOF";
<CENTER><BR><INPUT NAME=RFT TYPE=HIDDEN VALUE=1><INPUT NAME=RGT TYPE=HIDDEN VALUE=0><INPUT NAME=RHT TYPE=HIDDEN VALUE=1><INPUT TYPE=SUBMIT VALUE=Preview></CENTER>
EOF
}

sub procnew {
	my ($password, @userrfts);
 	my $image;
    	my $image2;
	if ($config{'regdir'} ne "") {
		&oops('Invalid username.') unless ($password, $form{'EMAIL'}, $form{'ADDRESS1'}, $form{'ADDRESS2'}, $form{'ADDRESS3'}, $form{'ADDRESS4'}, $form{'ADDRESS5'}, $form{'ADDRESS6'}, $form{'PHONE'}, @userrfts) = &read_reg_file($form{'ALIAS'});
		$form{'ALIAS'} = ucfirst(lc($form{'ALIAS'}));
		&oops('Your password is incorrect.') unless ((lc $password) eq (lc $form{'PASSWORD'}));
		}
	&oops('Your ad title must be 50 characters or less.') unless ($form{'TITLE'} && (length($form{'TITLE'}) < 51));
	$form{'TITLE'} =~ s/\</\&lt\;/g;
	$form{'TITLE'} =~ s/\>/\&gt\;/g;
        &oops('You must select a category.') unless (-d "$config{'basepath'}$form{'CATEGORY'}" and $category{$form{'CATEGORY'}});
	$form{'IMAGE'} = "" if ($form{'IMAGE'} eq "http://");
  	#--Image Upload----------------------------------------#
    	$form{'IMAGE'} = "" if ($form{'IMAGE'} eq "NONE");
    	#--Image Upload END------------------------------------#
 	$form{'URL'} = "" if ($form{'URL'} eq "http://");
	&oops('You must choose how long you would like your ad to run.') unless (($form{'DAYS'} > 0) and ($form{'DAYS'} < 366));
	&oops('You must enter an ad description.') unless ($form{'DESC'});
 	&oops('You must enter a username to track your ad.') unless ($form{'ALIAS'});
	&oops('You must enter a valid e-mail address.') unless ($form{'EMAIL'} =~ /^.+\@.+\..+$/);
	&oops('.') unless ($form{'RFT'} =~ /^(\d+\.?\d*|\.\d+)$/);
	&oops('.') unless (($form{'RHT'} =~ /^(\d+\.?\d*|\.\d+)$/) and ($form{'RHT'} >= .01));
	$form{'RHT'} = &parserft($form{'RHT'});
	$form{'RGT'} = &parserft($form{'RGT'});
  	&oops('You must enter your full name.') unless ($form{'ADDRESS1'});
	&oops('You must enter your street address.') unless ($form{'ADDRESS2'});
	&oops('You must enter your city.') unless ($form{'ADDRESS3'});
 	&oops('You must enter your state.') unless ($form{'ADDRESS4'});
  	&oops('You must enter your zip code or postal code.') unless ($form{'ADDRESS5'});
	&oops('You must enter your country.') unless ($form{'ADDRESS6'});
	my $item_number = ($form{'DAYS'} * 86400 + time);
	$item_number = ($form{'DAYS'} * 86400 + time) until (!(-f "$config{'basepath'}$form{'CATEGORY'}/$item_number.dat"));
	if ($form{'FROMPREVIEW'}) {
		my $key;
		foreach $key (keys %form) {
			$form{$key} =~ s/\[greaterthansign\]/\>/gs;
			$form{$key} =~ s/\[lessthansign\]/\</gs;
			$form{$key} =~ s/\[quotes\]/\"/gs;
		}
            if ($form{'IMAGEUPLOAD'} eq 'YES') {
                $image = $form{'IMAGE'};
                $image2 = ($form{'CATEGORY'} . $item_number . "." . $form{'extension'});
                $form{'IMAGE'} = ($config{'imageuploadurl'} . '/' . $form{'CATEGORY'} . $item_number . "." . $form{'extension'});
                &oops('We are unable to post your image.') unless rename("$config{'imageuploaddir'}/$image", "$config{'imageuploaddir'}/$image2");
                 }
 		&Validate_Item_Posting($item_number, $form{'ALIAS'}, @userrfts); 	
		&oops('We are unable to post your ad.  This could be a write permissions problem. Please note this error message and contact the site administrator.') unless (open (NEW, ">$config{'basepath'}$form{'CATEGORY'}/$item_number.dat"));
		print NEW "$form{'TITLE'}\n$form{'RGT'}\n$form{'RHT'}\n$form{'DESC'}\n$form{'IMAGE'}\n$form{'URL'}\n$form{'ALIAS'}\[\]$form{'EMAIL'}\[\]".&parserft($form{'RFT'})."\[\]".time."\[\]$form{'ADDRESS1'}\[\]$form{'ADDRESS2'}\[\]$form{'ADDRESS3'}\[\]$form{'ADDRESS4'}\[\]$form{'ADDRESS5'}\[\]$form{'ADDRESS6'}\[\]$form{'PHONE'}";
		close NEW;
		if ($config{'regdir'} ne "") {
			&oops('We could not open the registration file.  This could be a write permissions problem. Please note this error message and contact the site administrator.') unless (open(REGFILE, ">>$config{'basepath'}$config{'regdir'}/$form{'ALIAS'}.dat"));
			print REGFILE "\n$form{'CATEGORY'}$item_number";
			close REGFILE;
		}
		print "<center>Your ad was posted under $category{$form{'CATEGORY'}}. Click <A HREF=\"$ENV{'SCRIPT_NAME'}\?category=$form{'CATEGORY'}\&item=$item_number\">here</A> to view your ad.</center>\n\n\n";
&sendemail($config{'admin_address'}, $config{'admin_address'}, 'New Ad Posted', "NOTE TO THE ADMINISTRATOR : New Ad Posting on $config{'sitename'}\r\n\r\nUSERNAME: $form{'ALIAS'}\r\n\r\nAD TITLE:$form{'TITLE'} was posted under $category{$form{'CATEGORY'}}\r\n\r\nClick on http://$config{'scripturl'}$ENV{'SCRIPT_NAME'}\?category=$form{'CATEGORY'}\&item=$item_number to view the ad.");
	}
	else {
		my $nowtime = localtime(time);
		my $closetime = localtime($item_number);
		print "<CENTER><H2>Preview</H2></CENTER>\n";
		print "<TABLE WIDTH=100\% BORDER=0 BGCOLOR=$config{'colortableborder'} CELLSPACING=0><TR><TD><TABLE BORDER=0 WIDTH=100\% CELLPADDING=2 CELLSPACING=1><TR><TD BGCOLOR=$config{'colortablehead'}><B>$form{'TITLE'}</B></TD></TR><TR><TD BGCOLOR=$config{'colortablebody'}><B>Category:</B> <b><A HREF=$ENV{'SCRIPT_NAME'}\?category=$form{'CATEGORY'}>$category{$form{'CATEGORY'}}</A></b></TD></TR><TR><TD BGCOLOR=$config{'colortablebody'}><B>Reply To: <A HREF=mailto:$form{'EMAIL'}><u>$form{'ALIAS'}</u></A></B></TD></TR>";
		print "<TR><TD BGCOLOR=$config{'colortablebody'}><B>Website: <A HREF=\"$form{'URL'}\"} TARGET=top><u>$form{'URL'}</u></A></B></TD></TR>"  if ($form{'URL'});
  		print "<TR><TD BGCOLOR=$config{'colortablebody'}>$form{'DESC'}</TD></TR>";
		if ($form{'IMAGEUPLOAD'} eq 'NO') {
                    $image = "<TR><TD BGCOLOR=$config{'colortablebody'}><CENTER><IMG SRC=$form{'IMAGE'}></CENTER></TD></TR>" if ($form{'IMAGE'});
                    $image = "" if ($form{'IMAGE'} eq 'http://');
                    $image = "" if ($form{'IMAGE'} eq 'NONE');
                }
                if ($form{'IMAGEUPLOAD'} eq 'YES') {
                    $image = "<TR><TD BGCOLOR=$config{'colortablebody'}><CENTER><IMG SRC=$config{'imageuploadurl'}/$form{'IMAGE'}></CENTER></TD></TR>";
                }
            print $image if ($image);
		print "</TABLE></TD></TR></TABLE>";
		print "<FORM ACTION=$ENV{'SCRIPT_NAME'} METHOD=POST><CENTER>If you are satisfied with your ad press the \"Submit\" button below.<br>If you would like to make any changes, please hit the back button on your browser to edit your ad.</CENTER><INPUT TYPE=HIDDEN NAME=FROMPREVIEW VALUE=1><p><CENTER><INPUT TYPE=SUBMIT VALUE=\"Submit\"></CENTER>\n";
		my $key;
		foreach $key (keys %form) {
			$form{$key} =~ s/\>/\[greaterthansign\]/gs;
			$form{$key} =~ s/\</\[lessthansign\]/gs;
			$form{$key} =~ s/\"/\[quotes\]/gs;
			print "<INPUT TYPE=hidden NAME=\"$key\" VALUE=\"$form{$key}\">\n";
		}
		print "</FORM>\n";
  	
	}
 	unlink("$config{'basepath'}resume.dat");
}

sub procsearch {
	&oops("You must enter a keyword or username to search for.") if $form{searchstring} eq '';
	if($category{$form{category}} ne ''){
		print "You searched in: <b><a href=$ENV{SCRIPT_NAME}?category=$form{category}>$category{$form{category}}</a></b><br>";
	}else{
		$form{category} = '';
	}
	print "<p><TABLE WIDTH=100\% BORDER=0 BGCOLOR=$config{'colortableborder'} CELLSPACING=0><TR><TD><TABLE BORDER=0 WIDTH=100\% CELLPADDING=2 CELLSPACING=1><tr bgcolor=$config{colortablehead} align=center><th>Search results for \"$form{searchstring}\"</th></tr>\n";
	my $pagebreak = $config{pagebreak} || $config{'searchpagebreak'};
	my ($icount, $pcount) = (0,0);
	my $tcount;
	my $search = lc $form{searchstring};
	my @indices;
	foreach my $key (keys %category){
		next if $key ne $form{category} && $form{category} ne '';
		push @indices, $key;
	}
	if($search ne ''){
		foreach my $key (@indices){
			open(INDEX, "$config{basepath}idx_$key.dat");
			while( my $line = <INDEX>) {
				my($undef,$file,$user,$users,$text) = split /\t/, $line, 5;
				if($form{searchtype} eq 'keyword'){
					next if index(lc $text, $search) < 0;
				}else{
					next if index( lc $user, $search) < 0 && index( lc $users, $search) < 0;
				}
				$tcount++;
				if(++$icount > $pagebreak){$icount=1; $pcount++}
				next if $pcount != $form{page};

				my($title, $rgt, $rht, $desc, $image, $url, @rfts) = &read_item_file($key,$file);
				next if $title eq '';
				my ($alias, $email, $rft, $time, $add1, $add2, $add3) = &read_rft($rfts[$#rfts]);
				my @closetime = localtime($file);
				$closetime[4]++;
        			if ($form{imagesearch} ne 'photos') {
				print "<tr bgcolor=$config{colortablebody}><td><a href=$ENV{SCRIPT_NAME}?category=$key&item=$file>$title</a>";
				print "&nbsp;&nbsp;<IMG SRC=camera.gif>" if ($image);
				print "</td></tr>\n";
    				}
          			elsif ($form{imagesearch} eq 'photos' && $image ne ''){
				print "<tr bgcolor=$config{colortablebody}><td><a href=$ENV{SCRIPT_NAME}?category=$key&item=$file>$title</a>";
				print "&nbsp;&nbsp;<IMG SRC=camera.gif>";
				print "</td></tr>\n";
    				} 
			}
			close(INDEX);
		}
	}
	print "</table></td></tr></table><br>\n";
	eval{pagebreak($pcount,$pagebreak)} or print "<br><b>[",$pcount+1," Pages]</b>";
}
sub creg {
	print <<"EOF";
<FORM ACTION=$ENV{'SCRIPT_NAME'} METHOD=POST>
<H2><CENTER>Change Your Password or Contact Information</CENTER></H2>
<TABLE WIDTH=100% BORDER=0 CELLSPACING=0>
<INPUT TYPE=HIDDEN NAME=action VALUE=proccreg>
<TR><TD VALIGN=TOP><B>Username:</B></TD><TD><INPUT NAME=ALIAS TYPE=TEXT SIZE=30 MAXLENGTH=30></TD></TR>
<TR><TD VALIGN=TOP><B>Password:</B><BR><i><font size=\"-1\"><A HREF=$ENV{'SCRIPT_NAME'}?action=lp>Forgot password\?</a></font></i></TD><TD><INPUT NAME=OLDPASS TYPE=PASSWORD SIZE=30></TD></TR>
<TR><TD VALIGN=TOP><B>New Password:<BR></B>Leave blank if unchanged</TD><TD><INPUT NAME=NEWPASS1 TYPE=PASSWORD SIZE=30></TD></TR>
<TR><TD VALIGN=TOP><B>New Password Again:<BR></B>Leave blank if unchanged</TD><TD><INPUT NAME=NEWPASS2 TYPE=PASSWORD SIZE=30></TD></TR>
<TR><TD VALIGN=TOP><B>New E-Mail Adress:<BR></B>Leave blank if unchanged<BR><BR></TD><TD><INPUT NAME=EMAIL TYPE=TEXT SIZE=30><BR><BR></TD></TR>
<TR><TD VALIGN=TOP COLSPAN=2><B>Contact Information:\&nbsp;\&nbsp;</B>Leave blank if unchanged. If changing any of your contact information, you must complete all fields.<BR><BR></TD></TR>
<TR><TD VALIGN=TOP><B>Full Name: </B></TD><TD><INPUT NAME=ADDRESS1 TYPE=TEXT SIZE=30><BR></TD></TR>
<TR><TD VALIGN=TOP><B>Street Address:</B></TD><TD><INPUT NAME=ADDRESS2 TYPE=TEXT SIZE=30><BR></TD></TR>
<TR><TD VALIGN=TOP><B>City: </B></TD><TD><INPUT NAME=ADDRESS3 TYPE=TEXT SIZE=30><br></TD></TR>
<TR><TD VALIGN=TOP><B>State:</B> <BR>Choose\"International\" if living<BR>outside the US.</TD>
<TD>
			<select name=ADDRESS4 size="1">
<option value="" selected>[Select One]<option value="INT">International<option value="AL">Alabama<option value="AK">Alaska<option value="AZ">Arizona<option value="AR">Arkansas<option value="CA">California<option value="CO">Colorado<option value="CT">Connecticut<option value="DE">Delaware<option value="DC">District of Columbia<option value="FL">Florida<option value="GA">Georgia<option value="HI">Hawaii<option value="ID">Idaho<option value="IL">Illinois<option value="IN">Indiana<option value="IA">Iowa<option value="KS">Kansas<option value="KY">Kentucky<option value="LA">Louisiana<option value="ME">Maine<option value="MD">Maryland<option value="MA">Massachusetts<option value="MI">Michigan<option value="MN">Minnesota<option value="MS">Mississippi<option value="MO">Missouri<option value="MT">Montana<option value="NE">Nebraska<option value="NV">Nevada<option value="NH">New Hampshire<option value="NJ">New Jersey<option value="NM">New Mexico<option value="NY">New York<option value="NC">
North Carolina<option value="ND">North Dakota<option value="OH">Ohio<option value="OK">Oklahoma<option value="OR">Oregon<option value="PA">Pennsylvania<option value="RI">Rhode Island<option value="SC">South Carolina<option value="SD">South Dakota<option value="TN">Tennessee<option value="TX">Texas<option value="UT">Utah<option value="VT">Vermont<option value="VA">Virginia<option value="WA">Washington<option value="WV">West Virginia<option value="WI">Wisconsin<option value="WY">Wyoming
			</select>
<BR></TD></TR>
<TR><TD VALIGN=TOP><B>ZIP Code: </B></TD><TD><INPUT NAME=ADDRESS5 TYPE=TEXT SIZE=30><br></TD></TR>
<TR><TD VALIGN=TOP><B>Country:</B></TD>
<TD>
			<select name=ADDRESS6 size="1">
<option value="" selected>[Select One]<option value="US">United States<option value="UM">United States Minor Outlying Islands<option value="AF">Afghanistan<option value="AL">Albania<option value="DZ">Algeria<option value="AS">American Samoa<option value="AD">Andorra<option value="AO">Angola<option value="AI">Anguilla<option value="AQ">Antarctica<option value="AG">Antigua And Barbuda<option value="AR">Argentina<option value="AM">Armenia<option value="AW">Aruba<option value="AU">Australia<option value="AT">Austria<option value="AZ">Azerbaijan<option value="BS">Bahamas, The<option value="BH">Bahrain<option value="BD">Bangladesh<option value="BB">Barbados<option value="BY">Belarus<option value="BE">Belgium<option value="BZ">Belize<option value="BJ">Benin<option value="BM">Bermuda<option value="BT">Bhutan<option value="BO">Bolivia<option value="BA">Bosnia and Herzegovina<option value="BW">Botswana<option value="BV">Bouvet Island<option value="BR">Brazil<option value="IO">British Indian Ocean Territory<option value="BN">Brunei<option value="BG">Bulgaria<option value="BF">Burkina Faso<option value="BI">Burundi<option value="KH">Cambodia<option value="CM">Cameroon<option value="CA">Canada<option value="CV">Cape Verde<option value="KY">Cayman Islands<option value="CF">Central African Republic<option value="TD">Chad<option value="CL">Chile<option value="CN">China<option value="CX">Christmas Island<option value="CC">Cocos (Keeling) Islands<option value="CO">Colombia<option value="KM">Comoros<option value="CG">Congo<option value="CD">Congo, Democractic Republic of the  <option value="CK">Cook Islands<option value="CR">Costa Rica<option value="CI">Cote D\'Ivoire (Ivory Coast)
<option value="HR">Croatia (Hrvatska)<option value="CU">Cuba<option value="CY">Cyprus<option value="CZ">Czech Republic<option value="DK">Denmark<option value="DJ">Djibouti<option value="DM">Dominica<option value="DO">Dominican Republic<option value="TP">East Timor<option value="EC">Ecuador<option value="EG">Egypt<option value="SV">El Salvador<option value="GQ">Equatorial Guinea<option value="ER">Eritrea<option value="EE">Estonia<option value="ET">Ethiopia<option value="FK">Falkland Islands (Islas Malvinas)<option value="FO">Faroe Islands<option value="FJ">Fiji Islands<option value="FI">Finland<option value="FR">France<option value="GF">French Guiana<option value="PF">French Polynesia<option value="TF">French Southern Territories<option value="GA">Gabon<option value="GM">Gambia, The<option value="GE">Georgia<option value="DE">Germany<option value="GH">Ghana<option value="GI">Gibraltar<option value="GR">Greece<option value="GL">Greenland<option value="GD">Grenada<option value="GP">Guadeloupe
<option value="GU">Guam<option value="GT">Guatemala<option value="GN">Guinea<option value="GW">Guinea-Bissau<option value="GY">Guyana<option value="HT">Haiti<option value="HM">Heard and McDonald Islands<option value="HN">Honduras<option value="HK">Hong Kong S.A.R.<option value="HU">Hungary<option value="IS">Iceland<option value="IN">India<option value="ID">Indonesia<option value="IR">Iran<option value="IQ">Iraq<option value="IE">Ireland<option value="IL">Israel<option value="IT">Italy<option value="JM">Jamaica<option value="JP">Japan<option value="JO">Jordan<option value="KZ">Kazakhstan<option value="KE">Kenya<option value="KI">Kiribati<option value="KR">Korea<option value="KP">Korea, North <option value="KW">Kuwait<option value="KG">Kyrgyzstan<option value="LA">Laos<option value="LV">Latvia<option value="LB">Lebanon<option value="LS">Lesotho<option value="LR">Liberia<option value="LY">Libya<option value="LI">Liechtenstein<option value="LT">Lithuania<option value="LU">Luxembourg
<option value="MO">Macau S.A.R.<option value="MK">Macedonia, Former Yugoslav Republic of<option value="MG">Madagascar<option value="MW">Malawi<option value="MY">Malaysia<option value="MV">Maldives<option value="ML">Mali<option value="MT">Malta<option value="MH">Marshall Islands<option value="MQ">Martinique<option value="MR">Mauritania<option value="MU">Mauritius<option value="YT">Mayotte<option value="MX">Mexico<option value="FM">Micronesia<option value="MD">Moldova<option value="MC">Monaco<option value="MN">Mongolia<option value="MS">Montserrat<option value="MA">Morocco<option value="MZ">Mozambique<option value="MM">Myanmar<option value="NA">Namibia<option value="NR">Nauru<option value="NP">Nepal<option value="AN">Netherlands Antilles<option value="NL">Netherlands, The<option value="NC">New Caledonia<option value="NZ">New Zealand<option value="NI">Nicaragua<option value="NE">Niger<option value="NG">Nigeria<option value="NU">Niue<option value="NF">Norfolk Island<option value="MP">Northern Mariana Islands<option value="NO">Norway<option value="OM">Oman<option value="PK">Pakistan<option value="PW">Palau<option value="PA">Panama<option value="PG">Papua new Guinea<option value="PY">Paraguay<option value="PE">Peru<option value="PH">Philippines<option value="PN">Pitcairn Island<option value="PL">Poland<option value="PT">Portugal<option value="PR">Puerto Rico<option value="QA">Qatar<option value="RE">Reunion<option value="RO">Romania<option value="RU">Russia<option value="RW">Rwanda<option value="SH">Saint Helena<option value="KN">Saint Kitts And Nevis<option value="LC">Saint Lucia<option value="PM">Saint Pierre and Miquelon<option value="VC">Saint Vincent And The Grenadines<option value="WS">Samoa<option value="SM">San Marino<option value="ST">Sao Tome and Principe<option value="SA">Saudi Arabia<option value="SN">Senegal<option value="SC">Seychelles<option value="SL">Sierra Leone<option value="SG">Singapore<option value="SK">Slovakia<option value="SI">Slovenia<option value="SB">Solomon Islands<option value="SO">Somalia<option value="ZA">South Africa<option value="GS">South Georgia And The South Sandwich Islands<option value="ES">Spain<option value="LK">Sri Lanka<option value="SD">Sudan<option value="SR">Suriname<option value="SJ">Svalbard And Jan Mayen Islands<option value="SZ">Swaziland<option value="SE">Sweden<option value="CH">Switzerland<option value="SY">Syria<option value="TW">Taiwan<option value="TJ">Tajikistan<option value="TZ">Tanzania<option value="TH">Thailand<option value="TG">Togo<option value="TK">Tokelau<option value="TO">Tonga<option value="TT">Trinidad And Tobago<option value="TN">Tunisia<option value="TR">Turkey<option value="TM">Turkmenistan<option value="TC">Turks And Caicos Islands<option value="TV">Tuvalu<option value="UG">Uganda<option value="UA">Ukraine<option value="AE">United Arab Emirates<option value="UK">United Kingdom<option value="UY">Uruguay<option value="UZ">Uzbekistan<option value="VU">Vanuatu<option value="VA">Vatican City State (Holy See)<option value="VE">Venezuela<option value="VN">Vietnam<option value="VG">Virgin Islands (British)<option value="VI">Virgin Islands (US)<option value="WF">Wallis And Futuna Islands<option value="YE">Yemen<option value="YU">Yugoslavia<option value="ZM">Zambia<option value="ZW">Zimbabwe
				</select>
<br></TD></TR>
<TR><TD VALIGN=TOP><B>Phone: <BR></B>Not Required</TD><TD><INPUT NAME=PHONE TYPE=TEXT SIZE=15></TD></TR></TABLE>
<CENTER><BR><INPUT TYPE=SUBMIT VALUE="Edit Registration"></CENTER>
EOF
}

sub proccreg {
	if ($config{'regdir'}) {
		&oops('You must enter your username.') unless ($form{'ALIAS'});
		&oops('You must enter your old password.') unless ($form{'OLDPASS'});
		if ($form{'EMAIL'}) {
				&oops('You must enter a valid e-mail address.') unless ($form{'EMAIL'} =~ /^.+\@.+\..+$/);

		}
  		if ($form{'EMAIL'} eq lc($form{'EMAIL'})) {
		&banemail;
		}
  		if ($form{'ADDRESS1'}) {
			&oops('If changing any part of your contact information, you must enter all of your contact information.  Please enter your street address.') unless ($form{'ADDRESS2'});
			&oops('If changing any part of your contact information, you must enter all of your contact information.  Please enter your city.') unless ($form{'ADDRESS3'});
			&oops('If changing any part of your contact information, you must enter all of your contact information.  Please enter your state.') unless ($form{'ADDRESS4'});
			&oops('If changing any part of your contact information, you must enter all of your contact information.  Please enter your Zip Code or Postal Code.') unless ($form{'ADDRESS5'});
			&oops('If changing any part of your contact information, you must enter all of your contact information.  Please enter your country.') unless ($form{'ADDRESS6'});
		}
		if ($form{'NEWPASS1'}) {
			&oops('Your new passwords do not match.') unless ($form{'NEWPASS2'} eq $form{'NEWPASS1'});
		}
		if (my ($password,$email,$add1,$add2,$add3,$add4,$add5,$add6,$phone,@past_rfts) = &read_reg_file($form{'ALIAS'})) {
			$form{'ALIAS'} = ucfirst(lc($form{'ALIAS'}));
			&oops('Your old password does not match our records.') unless ((lc $password) eq (lc $form{'OLDPASS'}));
			$form{'NEWPASS1'} = $password if !($form{'NEWPASS1'});
			$form{'EMAIL'} = $email if !($form{'EMAIL'});
			$form{'ADDRESS1'} = $add1 if !($form{'ADDRESS1'});
			$form{'ADDRESS2'} = $add2 if !($form{'ADDRESS2'});
			$form{'ADDRESS3'} = $add3 if !($form{'ADDRESS3'});
			$form{'ADDRESS4'} = $add4 if !($form{'ADDRESS4'});
			$form{'ADDRESS5'} = $add5 if !($form{'ADDRESS5'});
			$form{'ADDRESS6'} = $add6 if !($form{'ADDRESS6'});
			$form{'PHONE'} = $phone if !($form{'PHONE'});
			&oops('We cannot open your account.  This could be a server write problem. Please note this error message and contact the site administrator.') unless (open NEWREG, ">$config{'basepath'}$config{'regdir'}/$form{'ALIAS'}.dat");
			print NEWREG "$form{'NEWPASS1'}\n$form{'EMAIL'}\n$form{'ADDRESS1'}\n$form{'ADDRESS2'}\n$form{'ADDRESS3'}\n$form{'ADDRESS4'}\n$form{'ADDRESS5'}\n$form{'ADDRESS6'}\n$form{'PHONE'}";
			my $rft;
			foreach $rft (@past_rfts) {
				print NEWREG "\n$rft";
			}
			close NEWREG;
			print "<center>$form{'ALIAS'}, your information has been successfully changed.</center>\n";
		}
		else {
			print "<center>That username is not valid.  If you do not have a username, please create a <A HREF=$ENV{'SCRIPT_NAME'}?action=reg>new account</A>.</center>\n";
		}
	}
	else {
		print "<center>User registration is not implemented on this server.  The system administrator did not specify a registration directory.</center>\n";
	}
}	

sub reg {
	print <<"EOF";
<FORM ACTION=$ENV{'SCRIPT_NAME'} METHOD=POST>
<H2><CENTER>New User Registration</CENTER></H2>
<TABLE WIDTH=100% BORDER=0>
<INPUT TYPE=HIDDEN NAME=action VALUE=procreg>
<TR><TD COLSPAN=2 VALIGN=TOP>This form will allow you to register to place a new ad. Your password will be e-mailed to you. After receiving your password, you can change it to a password of your choice by editing your registration information.<BR><BR></TD></TR>
<TR><TD VALIGN=TOP><B>Username:</B></TD><TD><INPUT NAME=ALIAS TYPE=TEXT SIZE=30 MAXLENGTH=30></TD></TR>
<TR><TD VALIGN=TOP><B>E-Mail Address:</B><BR><BR></TD><TD><INPUT NAME=EMAIL TYPE=TEXT SIZE=30><BR><BR></TD></TR>
<TR><TD VALIGN=TOP COLSPAN=2><B>Note:\&nbsp;\&nbsp;</B>The following contact information will <b>not</b> be listed in your ad. If you would like to include your contact information in your listing, please enter it in the description when entering your ad details.<BR><BR></TD></TR>
<TR><TD VALIGN=TOP><B>Full Name: </B></TD><TD><INPUT NAME=ADDRESS1 TYPE=TEXT SIZE=30><BR></TD></TR>
<TR><TD VALIGN=TOP><B>Street Address:</B></TD><TD><INPUT NAME=ADDRESS2 TYPE=TEXT SIZE=30><BR></TD></TR>
<TR><TD VALIGN=TOP><B>City: </B></TD><TD><INPUT NAME=ADDRESS3 TYPE=TEXT SIZE=30><br></TD></TR>
<TR><TD VALIGN=TOP><B>State:</B> <BR>Choose\"International\" if living outside the US.</TD>
<TD>
			<select name=ADDRESS4 size="1">
<option value="" selected>[Select One]<option value="INT">International<option value="AL">Alabama<option value="AK">Alaska<option value="AZ">Arizona<option value="AR">Arkansas<option value="CA">California<option value="CO">Colorado<option value="CT">Connecticut<option value="DE">Delaware<option value="DC">District of Columbia<option value="FL">Florida<option value="GA">Georgia<option value="HI">Hawaii<option value="ID">Idaho<option value="IL">Illinois<option value="IN">Indiana<option value="IA">Iowa<option value="KS">Kansas<option value="KY">Kentucky<option value="LA">Louisiana<option value="ME">Maine<option value="MD">Maryland<option value="MA">Massachusetts<option value="MI">Michigan<option value="MN">Minnesota<option value="MS">Mississippi<option value="MO">Missouri<option value="MT">Montana<option value="NE">Nebraska<option value="NV">Nevada<option value="NH">New Hampshire<option value="NJ">New Jersey<option value="NM">New Mexico<option value="NY">New York<option value="NC">North Carolina<option value="ND">North Dakota<option value="OH">Ohio<option value="OK">Oklahoma<option value="OR">Oregon<option value="PA">Pennsylvania<option value="RI">Rhode Island<option value="SC">South Carolina<option value="SD">South Dakota<option value="TN">Tennessee<option value="TX">Texas<option value="UT">Utah<option value="VT">Vermont<option value="VA">Virginia<option value="WA">Washington<option value="WV">West Virginia<option value="WI">Wisconsin<option value="WY">Wyoming
			</select>
<BR></TD></TR>
<TR><TD VALIGN=TOP><B>ZIP: </B></TD><TD><INPUT NAME=ADDRESS5 TYPE=TEXT SIZE=30><br></TD></TR>
<TR><TD VALIGN=TOP><B>Country:</B></TD>
<TD>
			<select name=ADDRESS6 size="1">
<option value="" selected>[Select One]<option value="US">United States<option value="UM">United States Minor Outlying Islands<option value="AF">Afghanistan<option value="AL">Albania<option value="DZ">Algeria<option value="AS">American Samoa<option value="AD">Andorra<option value="AO">Angola<option value="AI">Anguilla<option value="AQ">Antarctica<option value="AG">Antigua And Barbuda<option value="AR">Argentina<option value="AM">Armenia<option value="AW">Aruba<option value="AU">Australia<option value="AT">Austria<option value="AZ">Azerbaijan<option value="BS">Bahamas, The<option value="BH">Bahrain<option value="BD">Bangladesh<option value="BB">Barbados<option value="BY">Belarus<option value="BE">Belgium<option value="BZ">Belize<option value="BJ">Benin<option value="BM">Bermuda<option value="BT">Bhutan<option value="BO">Bolivia<option value="BA">Bosnia and Herzegovina<option value="BW">Botswana<option value="BV">Bouvet Island<option value="BR">Brazil<option value="IO">British Indian Ocean Territory<option value="BN">Brunei<option value="BG">Bulgaria<option value="BF">Burkina Faso<option value="BI">Burundi<option value="KH">Cambodia<option value="CM">Cameroon<option value="CA">Canada<option value="CV">Cape Verde<option value="KY">Cayman Islands<option value="CF">Central African Republic<option value="TD">Chad<option value="CL">Chile<option value="CN">China<option value="CX">Christmas Island<option value="CC">Cocos (Keeling) Islands<option value="CO">Colombia<option value="KM">Comoros<option value="CG">Congo<option value="CD">Congo, Democractic Republic of the  <option value="CK">Cook Islands<option value="CR">Costa Rica<option value="CI">Cote D\'Ivoire (Ivory Coast)
<option value="HR">Croatia (Hrvatska)<option value="CU">Cuba<option value="CY">Cyprus<option value="CZ">Czech Republic<option value="DK">Denmark<option value="DJ">Djibouti<option value="DM">Dominica<option value="DO">Dominican Republic<option value="TP">East Timor<option value="EC">Ecuador<option value="EG">Egypt<option value="SV">El Salvador<option value="GQ">Equatorial Guinea<option value="ER">Eritrea<option value="EE">Estonia<option value="ET">Ethiopia<option value="FK">Falkland Islands (Islas Malvinas)<option value="FO">Faroe Islands<option value="FJ">Fiji Islands<option value="FI">Finland<option value="FR">France<option value="GF">French Guiana<option value="PF">French Polynesia<option value="TF">French Southern Territories<option value="GA">Gabon<option value="GM">Gambia, The<option value="GE">Georgia<option value="DE">Germany<option value="GH">Ghana<option value="GI">Gibraltar<option value="GR">Greece<option value="GL">Greenland<option value="GD">Grenada<option value="GP">Guadeloupe<option value="GU">Guam<option value="GT">Guatemala<option value="GN">Guinea<option value="GW">Guinea-Bissau<option value="GY">Guyana<option value="HT">Haiti<option value="HM">Heard and McDonald Islands<option value="HN">Honduras<option value="HK">Hong Kong S.A.R.<option value="HU">Hungary<option value="IS">Iceland<option value="IN">India<option value="ID">Indonesia<option value="IR">Iran<option value="IQ">Iraq<option value="IE">Ireland<option value="IL">Israel<option value="IT">Italy<option value="JM">Jamaica<option value="JP">Japan<option value="JO">Jordan<option value="KZ">Kazakhstan<option value="KE">Kenya<option value="KI">Kiribati<option value="KR">Korea<option value="KP">Korea, North <option value="KW">Kuwait<option value="KG">Kyrgyzstan<option value="LA">Laos<option value="LV">Latvia<option value="LB">Lebanon<option value="LS">Lesotho<option value="LR">Liberia<option value="LY">Libya<option value="LI">Liechtenstein<option value="LT">Lithuania<option value="LU">Luxembourg<option value="MO">Macau S.A.R.<option value="MK">Macedonia, Former Yugoslav Republic of<option value="MG">Madagascar<option value="MW">Malawi<option value="MY">Malaysia<option value="MV">Maldives<option value="ML">Mali<option value="MT">Malta<option value="MH">Marshall Islands<option value="MQ">Martinique<option value="MR">Mauritania<option value="MU">Mauritius<option value="YT">Mayotte<option value="MX">Mexico<option value="FM">Micronesia<option value="MD">Moldova<option value="MC">Monaco<option value="MN">Mongolia<option value="MS">Montserrat<option value="MA">Morocco<option value="MZ">Mozambique<option value="MM">Myanmar<option value="NA">Namibia<option value="NR">Nauru<option value="NP">Nepal<option value="AN">Netherlands Antilles<option value="NL">Netherlands, The<option value="NC">New Caledonia<option value="NZ">New Zealand<option value="NI">Nicaragua<option value="NE">Niger<option value="NG">Nigeria<option value="NU">Niue<option value="NF">Norfolk Island<option value="MP">Northern Mariana Islands<option value="NO">Norway<option value="OM">Oman<option value="PK">Pakistan<option value="PW">Palau<option value="PA">Panama<option value="PG">Papua new Guinea<option value="PY">Paraguay<option value="PE">Peru<option value="PH">Philippines<option value="PN">Pitcairn Island<option value="PL">Poland<option value="PT">Portugal<option value="PR">Puerto Rico<option value="QA">Qatar<option value="RE">Reunion<option value="RO">Romania<option value="RU">Russia<option value="RW">Rwanda<option value="SH">Saint Helena<option value="KN">Saint Kitts And Nevis<option value="LC">Saint Lucia<option value="PM">Saint Pierre and Miquelon<option value="VC">Saint Vincent And The Grenadines<option value="WS">Samoa<option value="SM">San Marino<option value="ST">Sao Tome and Principe<option value="SA">Saudi Arabia<option value="SN">Senegal<option value="SC">Seychelles<option value="SL">Sierra Leone<option value="SG">Singapore<option value="SK">Slovakia<option value="SI">Slovenia<option value="SB">Solomon Islands<option value="SO">Somalia<option value="ZA">South Africa<option value="GS">South Georgia And The South Sandwich Islands<option value="ES">Spain<option value="LK">Sri Lanka<option value="SD">Sudan<option value="SR">Suriname<option value="SJ">Svalbard And Jan Mayen Islands<option value="SZ">Swaziland<option value="SE">Sweden<option value="CH">Switzerland<option value="SY">Syria<option value="TW">Taiwan<option value="TJ">Tajikistan<option value="TZ">Tanzania<option value="TH">Thailand<option value="TG">Togo<option value="TK">Tokelau<option value="TO">Tonga<option value="TT">Trinidad And Tobago<option value="TN">Tunisia<option value="TR">Turkey<option value="TM">Turkmenistan<option value="TC">Turks And Caicos Islands<option value="TV">Tuvalu<option value="UG">Uganda<option value="UA">Ukraine<option value="AE">United Arab Emirates<option value="UK">United Kingdom<option value="UY">Uruguay<option value="UZ">Uzbekistan<option value="VU">Vanuatu<option value="VA">Vatican City State (Holy See)<option value="VE">Venezuela<option value="VN">Vietnam<option value="VG">Virgin Islands (British)<option value="VI">Virgin Islands (US)<option value="WF">Wallis And Futuna Islands<option value="YE">Yemen<option value="YU">Yugoslavia<option value="ZM">Zambia<option value="ZW">Zimbabwe
				</select>
<br></TD></TR>
<TR><TD VALIGN=TOP><B>Phone: <BR></B>Not Required</TD><TD><INPUT NAME=PHONE TYPE=TEXT SIZE=15></TD></TR></TABLE>
<CENTER><BR><INPUT TYPE=SUBMIT VALUE="Register"></CENTER>
EOF
}

sub procreg {
	if ($config{'regdir'}) {
		umask(000);  # UNIX file permission junk
		mkdir("$config{'basepath'}$config{'regdir'}", 0777) unless (-d "$config{'basepath'}$config{'regdir'}");		
		&oops('You must enter a username that consists of alphanumeric characters only.') if $form{'ALIAS'} =~ /\W/ or !($form{'ALIAS'});
		my $testmail = $form{'EMAIL'};
if ($testmail =~ /(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)/ ||
	$testmail !~ /^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?)$/)
      	{
	&oops('You must enter a valid e-mail address.');
	}
               
                if ($form{'EMAIL'} eq lc($form{'EMAIL'})) {
		&banemail;
		}
		&oops('You must enter your full name.') unless ($form{'ADDRESS1'});
		&oops('You must enter a valid street address.') unless ($form{'ADDRESS2'});
		&oops('You must enter your city.') unless ($form{'ADDRESS3'});
		&oops('You must enter your state.') unless ($form{'ADDRESS4'});
		&oops('You must enter your Zip Code or Postal Code.') unless ($form{'ADDRESS5'});
		&oops('You must enter your country.') unless ($form{'ADDRESS6'});
		$form{'ALIAS'} = ucfirst(lc($form{'ALIAS'}));
		if (!(-f "$config{'basepath'}$config{'regdir'}/$form{'ALIAS'}.dat")) {
			&oops('We were unable to write to the user directory. Please note this error message and contact the site administrator.') unless (open NEWREG, ">$config{'basepath'}$config{'regdir'}/$form{'ALIAS'}.dat");
			my $newpass = &randompass; 
			print NEWREG "$newpass\n$form{'EMAIL'}\n$form{'ADDRESS1'}\n$form{'ADDRESS2'}\n$form{'ADDRESS3'}\n$form{'ADDRESS4'}\n$form{'ADDRESS5'}\n$form{'ADDRESS6'}\n$form{'PHONE'}";
			close NEWREG;
			print "<center><H2>Thanks for registering $form{'ALIAS'}!</H2><p>In a few minutes you will receive an e-mail with your password that will allow you to place an ad.<br>When you recieve your password, you may <A HREF=$ENV{'SCRIPT_NAME'}?action=creg>edit your registration</a> and choose your own password.</center>\n";
			&sendemail($form{'EMAIL'}, $config{'admin_address'}, 'Classifieds Password', "PLEASE DO NOT REPLY TO THIS E-MAIL.\r\n\r\nThank-you for registering to use the classifieds at $config{'sitename'}!\r\n\r\nYour password is: $newpass\r\nYour username is: $form{'ALIAS'}\r\n\r\nYou may choose your own password by visiting the following link:\r\nhttp://$config{'scripturl'}$ENV{'SCRIPT_NAME'}?action=creg");
   			&sendemail($config{'admin_address'}, $config{'admin_address'}, 'New User Registration', "NOTE TO THE ADMINISTRATOR : A new user has registered at $config{'sitename'}.\r\n\r\nUsername: $form{'ALIAS'}\r\nPassword: $newpass");
		}
		else {
			print "<center>Sorry, that username is taken.  Hit back to try again.</center>\n";
		}
	}
	else {
		print "<center>User Registration is Not Implemented on This Server. Please note this error message and contact the site administrator.</center>\n";
	}
}	

sub viewclosed1 {
	print <<"EOF";
<FORM ACTION=$ENV{'SCRIPT_NAME'} METHOD=POST>
<CENTER>Please enter your username and password to view or repost expired ads that you have posted.<br><br><TABLE BORDER=0>
<INPUT TYPE=HIDDEN NAME=action VALUE=closed2>
<TR><TD VALIGN=TOP><B>Username:</B></TD><TD><INPUT NAME=ALIAS TYPE=TEXT SIZE=30 MAXLENGTH=30>
<TR><TD VALIGN=TOP><B>Password:</B><BR><i><font size=\"-1\"><A HREF=$ENV{'SCRIPT_NAME'}?action=lp>Forgot password\?</a></font></i></TD><TD><INPUT NAME=PASSWORD TYPE=PASSWORD SIZE=30>
</TD></TR></TABLE><BR></CENTER>
<CENTER><INPUT TYPE=SUBMIT VALUE="View Expired Ads"></CENTER>
EOF
}

sub viewclosed2 {
	&oops('Invalid Username') unless my ($password,$email,$add1,$add2,$add3,$add4,$add5,$add6,$phone,@past_rfts) = &read_reg_file($form{'ALIAS'});
	&oops('Your password is incorrect.') unless ((lc $password) eq (lc $form{'PASSWORD'}));
	print "<center>Please select an ad.<br><br><FORM METHOD=POST ACTION=\"$ENV{'SCRIPT_NAME'}\">\n";
	print "<INPUT TYPE=HIDDEN NAME=action VALUE=closed3><INPUT TYPE=HIDDEN NAME=ALIAS VALUE=\"$form{'ALIAS'}\"><SELECT NAME=RFTTOVIEW>\n";
	my $rft;
	foreach $rft (@past_rfts) {
		if (-T "$config{'basepath'}$config{'closedir'}/$rft.dat") {
			open THEFILE, "$config{'basepath'}$config{'closedir'}/$rft.dat";
			my ($title, $rgt, $rht, $desc, $image, $url, @rfts) = <THEFILE>;
			close THEFILE;
			chomp($title, $rgt, $rht, $desc, $image, $url, @rfts);
			print "<OPTION VALUE=\"$rft\">$title</OPTION>\n";
		}
	}
	print "</SELECT><br><br><INPUT TYPE=SUBMIT VALUE=\"View Ad\"></FORM></center>\n";
}

sub viewclosed3 {
	$form{'RFTTOVIEW'} =~ s/\W//g;
	open (THEFILE, "$config{'basepath'}$config{'closedir'}/$form{'RFTTOVIEW'}.dat") or &oops('Ad could not be opened.  This could be a server read issue.');
	my ($title, $rgt, $rht, $desc, $image, $url, @rfts) = <THEFILE>;
	close THEFILE;
	chomp($title, $rgt, $rht, $desc, $image, $url, @rfts);
	print "<p><TABLE WIDTH=100\% BORDER=0 BGCOLOR=$config{'colortableborder'} CELLSPACING=0><TR><TD><TABLE BORDER=0 WIDTH=100\% CELLPADDING=2 CELLSPACING=1><TR><TD BGCOLOR=$config{'colortablehead'}><B>$title</B></TD></TR><TR><TD BGCOLOR=$config{'colortablebody'}>";
	my ($alias, $email, $rft, $time, $add1, $add2, $add3) = &read_rft($rfts[0]); # read first rft
	print "<B>Reply To: <A HREF=mailto:$email><u>$alias</u></A></B></TD></TR>";
	print "<TR><TD BGCOLOR=$config{'colortablebody'}>$desc</TD></TR>";
	print "<TR><TD BGCOLOR=$config{'colortablebody'}><CENTER><IMG SRC=$image></CENTER></TD></TR>" if ($image);
	print "</TABLE></TD></TR></TABLE>";
	print "<FORM ACTION=$ENV{'SCRIPT_NAME'} METHOD=POST><center>If you would like to repost your ad hit the button below.<p><INPUT TYPE=SUBMIT VALUE=\"Repost\"><INPUT TYPE=HIDDEN NAME=action VALUE=\"repost\"><INPUT TYPE=HIDDEN NAME=REPOST VALUE=\"$form{'RFTTOVIEW'}\"></center></FORM>\n";

}


sub admin {
	if (lc($form{'PASSWORD'}) eq lc($config{'adminpass'})) {
	print <<"EOF";
<FORM ACTION=$ENV{'SCRIPT_NAME'} METHOD=POST>
<H2><CENTER>Administration Page</CENTER></H2>
<p><center><TABLE WIDTH=600 BORDER=0 CELLSPACING=0 BGCOLOR=$config{'colortablebody'}>
<INPUT TYPE=HIDDEN NAME=action VALUE=procadmin>
<TR><TD COLSPAN=2 VALIGN=TOP><center><b>Delete an Ad</b><BR><BR></center>
</TD></TR>
<TR><TD VALIGN=TOP><B>Category:</B></TD><TD><SELECT NAME=CATEGORY>
<OPTION SELECTED VALUE=\"\">[Select One]</OPTION>
EOF
		my($key, $disppath, $thispath, @this);
	foreach $key (keys %category) {
		$disppath = '';
		$thispath = $category{$key};
		while($thispath =~ s/^<!--([^\>]*)-->//){
			if($supercat{$1} ne ''){
				$disppath .= "$supercat{$1} -> ";
			}
		}
		push(@this, ["$disppath$category{$key}", $disppath, "<OPTION VALUE=\"$key\">$disppath$category{$key}</OPTION>\n"]);
	}
	foreach $key (sort {lc $a->[0] cmp lc $b->[0]} @this){
		if($key->[1] ne $thispath){
			$thispath=$key->[1];
		}
		print $key->[2];
	}
	print <<"EOF";
</SELECT></TD></TR>
<TR><TD VALIGN=TOP><B>Ad Number:<BR></B></TD><TD><INPUT NAME=ITEM TYPE=TEXT SIZE=30 MAXLENGTH=30></TD></TR>
<TR><TD><B>Administrator Password:</B></TD><TD><INPUT NAME=PASSWORD TYPE=PASSWORD SIZE=30></TD></TR>
<TR><TD ALIGN=CENTER COLSPAN=2><BR><INPUT TYPE=SUBMIT VALUE="Delete"></form></TD></TR>
</TD></TR></TABLE></center>
<br><br>

<center><TABLE WIDTH=600 BORDER=0 CELLSPACING=0 BGCOLOR=$config{'colortablebody'}>
<FORM ACTION=$ENV{'SCRIPT_NAME'} METHOD=POST>
<input type=hidden name=action value=vregusers>
<TR><TD><center><b>View/Delete Registered Users</b><BR><BR></center>
</TD></TR>
<TR><TD ALIGN=CENTER><B>Administrator Password: </B><INPUT NAME=PASSWORD TYPE=PASSWORD SIZE=30></TD></TR>
<TR><TD><BR><CENTER><input type=submit value=View></CENTER></form>
</TD></TR></TABLE></CENTER>
<br><br>

<center><TABLE WIDTH=600 BORDER=0 CELLSPACING=0 BGCOLOR=$config{'colortablebody'}><tr><td align=center><b>Generate Mailing List<br><br></b>
<FORM ACTION=$ENV{'SCRIPT_NAME'} method="post"><input type="hidden" name="action" value="mlist"><input type="radio" name="createfile" value="0" checked> Show Mailing List <input type="radio" name="createfile" value="1"> Create File<p><b>Administrator Password:</b> <input name="adminpass" type="password"><p><input type="submit" value="SUBMIT"></form></td></tr></table></center><br><br>

<center><TABLE WIDTH=600 BORDER=0 CELLSPACING=0 BGCOLOR=$config{'colortablebody'}>
<FORM ACTION=$ENV{'SCRIPT_NAME'} METHOD=POST>
<input type=hidden name=action value=emailusers>
<TR><TD COLSPAN=2><center><b>E-mail All Registered Users<BR><BR></b></center></TD></TR>
<tr><TD ALIGN=CENTER COLSPAN=2><INPUT NAME=MAILHEAD VALUE="Subject" TYPE=TEXT SIZE=50 MAXLENGTH=50></TD></tr>
<tr><TD ALIGN=CENTER COLSPAN=2><textarea NAME="MESSAGE1" WRAP=VIRTUAL ROWS="5" COLS="40">Insert Message Here.</textarea></TD></TR>
<TR><TD ALIGN=CENTER><BR><BR><B>Administrator Password: </B><INPUT NAME=PASSWORD TYPE=PASSWORD SIZE=30></TD></TR>
<TR><TD align=center COLSPAN=2><BR><input type=submit value=Send Message></form></TD></TR>
</TABLE></CENTER><br><br>

<center><TABLE WIDTH=600 BORDER=0 CELLSPACING=0 BGCOLOR=$config{'colortablebody'}>
<FORM ACTION=$ENV{'SCRIPT_NAME'} METHOD=POST>
<input type=hidden name=action value=banemail2>
<TR><TD COLSPAN=2><center><b>Ban an E-mail Address from Registering<BR><BR></b></center>
</TD></TR>
<TR><TD VALIGN=TOP ALIGN=RIGHT><B>E-mail Address: </B></TD><TD ALIGN=LEFT><INPUT NAME=EMAIL TYPE=text SIZE=30></TD></TR><TR><TD ALIGN=RIGHT><B>Administrator Password: </B></TD><TD ALIGN=LEFT><INPUT NAME=PASSWORD TYPE=PASSWORD SIZE=30></TD></TR><TR><TD ALIGN=CENTER COLSPAN=2><BR><input type=submit value="Ban"></form></TD></TR></CENTER>
</TD></TR></TABLE></CENTER><br><br>

<center><TABLE WIDTH=600 BORDER=0 BGCOLOR=$config{'colortablebody'} CELLSPACING=0>
<FORM ACTION=$ENV{'SCRIPT_NAME'} METHOD=POST>
<input type=hidden name=action value=unbanemail2>
<TR><TD COLSPAN=2><center><b>View/Reinstate Banned E-mail Addresses</b><br><br></center>
</TD></TR><TR><TD ALIGN=CENTER><B>Administrator Password: </B><INPUT NAME=PASSWORD TYPE=PASSWORD SIZE=30></TD></TR><TR><TD align=center COLSPAN=2><BR><input type=submit value="View All"></form></CENTER>
</TD></TR></TABLE><br><br>

<center><TABLE WIDTH=600 BORDER=0 CELLSPACING=0 BGCOLOR=$config{'colortablebody'}>
<FORM ACTION=$ENV{'SCRIPT_NAME'} METHOD=POST>
<INPUT TYPE=HIDDEN NAME=action VALUE=admin_moditem>
<TR><TD COLSPAN=2 VALIGN=TOP><center><b>Modify Ad Information</b><br>If you change the ad category, the listing will still exist in the original category.<br>You will have to delete the original listing manually.<br><br></center>
</TD></TR>
<TR><TD VALIGN=TOP><B>Category: </B></TD><TD><SELECT NAME=CATEGORY>
<OPTION SELECTED VALUE=\"\">[Select One]</OPTION>
EOF
	my($key, $disppath, $thispath, @this);
	foreach $key (keys %category) {
		$disppath = '';
		$thispath = $category{$key};
		while($thispath =~ s/^<!--([^\>]*)-->//){
			if($supercat{$1} ne ''){
				$disppath .= "$supercat{$1} -> ";
			}
		}
		push(@this, ["$disppath$category{$key}", $disppath, "<OPTION VALUE=\"$key\">$disppath$category{$key}</OPTION>\n"]);
	}
	foreach $key (sort {lc $a->[0] cmp lc $b->[0]} @this){
		if($key->[1] ne $thispath){
			$thispath=$key->[1];
		}
		print $key->[2];
	}
	print <<"EOF";
</SELECT></TD></TR>
<TR><TD VALIGN=TOP><B>Ad Number:<BR></B></TD><TD><INPUT NAME=ITEM TYPE=TEXT SIZE=30 MAXLENGTH=30>
<TR><TD><B>Administrator Password: </B></TD><TD><INPUT NAME=PASSWORD TYPE=PASSWORD SIZE=30></TD></TR>
<TR><TD ALIGN=CENTER COLSPAN=2><BR><INPUT TYPE=SUBMIT VALUE="Continue"></form>
</TD></TR></TABLE></center>
<br><br>

EOF
		}
		else {
		print "<p>&nbsp;</p><center><b>Incorrect administrator password.</b></center>\n";
	}

}

sub procadmin {
	if (lc($form{'PASSWORD'}) eq lc($config{'adminpass'})) {
		&oops('Invalid ad category or number.') unless &read_item_file($form{'CATEGORY'},$form{'ITEM'});
		if (unlink("$config{'basepath'}$form{'CATEGORY'}/$form{'ITEM'}.dat")) {
			print "<CENTER><FONT SIZE=+1>File successfully removed!</FONT></CENTER>\n";
		}
		else {
			print "<center>File could not be removed!</center>\n";
		}
		}
		else {
		print "<p>&nbsp;</p><center><b>Incorrect administrator password.</b></center>\n";
	}
}
sub vregusers {
		if (lc($form{'PASSWORD'}) eq lc($config{'adminpass'})) {
		my $file;
		opendir THEDIR, "$config{'basepath'}$config{'regdir'}" || die "Unable to open directory: $!";
		my @allfiles = readdir THEDIR;
		closedir THEDIR;
		foreach $file (sort { int($a) <=> int($b) } @allfiles) {
		if ("$config{'basepath'}$config{'regdir'}/$file" =~ /\.dat/) {
		open THEFILE, "$config{'basepath'}$config{'regdir'}/$file";
		my ($password,$email,$add1,$add2,$add3,$add4,$add5,$add6,$phone,@junk) = <THEFILE>;
		close THEFILE;
		chomp($password,$email,$add1,$add2,$add3,$add4,$add5,$add6,$phone,@junk);
		$file =~ s/\.dat//;
		print "<FORM ACTION=$ENV{'SCRIPT_NAME'} METHOD=POST>\n";
		print "<INPUT TYPE=HIDDEN NAME=action VALUE=deleteuser>\n";
		my $username = $file;
		print "<input type=hidden name=ALIAS value=$username>";
		print "<br><br><CENTER><table width=500 border=1 cellpadding=2 bgcolor=\"#FFFFFF\">";
		print "<tr><td width=100><B>Name:</B> </td><td width=400><font face=arial size=2>$add1</td></tr>";
		print "<tr><td width=100><B>Username:</B> </td><td width=400><font face=arial size=2>$username</td></tr>";
		print "<tr><td width=100><B>Password:</B> </td><td width=400><font face=arial size=2>$password</td></tr>";
		print "<tr><td width=100><B>E-mail: </B></B></td><td width=400><font face=arial size=2>$email</td></tr>";
		print "<tr><td width=100><B>Street:</B> </td><td width=400><font face=arial size=2>$add2</td></tr>";
		print "<tr><td width=100><B>City:</B> </td><td width=400><font face=arial size=2>$add3</td></tr>";
		print "<tr><td width=100><B>State: </B></td><td width=400><font face=arial size=2>$add4</td></tr>";
		print "<tr><td width=100><B>Zip Code: </B></td><td width=400><font face=arial size=2>$add5</td></tr>";
		print "<tr><td width=100><B>Country: </B></td><td width=400><font face=arial size=2>$add6</td></tr>";
		print "<tr><td width=100><B>Phone: </B></td><td width=400><font face=arial size=2>$phone</td></tr></table></CENTER>";
		print "<center><BR><input type=submit value=\"Delete User\"></center></form>";
		}
		}
		}
                else {
		print "<p>&nbsp;</p><center><b>Incorrect administrator password.</b></center>\n";
		}
 }
sub deleteuser {
	if (unlink("$config{'basepath'}$config{'regdir'}/$form{'ALIAS'}.dat")) {
	print "<br><br><center><FONT SIZE=+1>$form{'ALIAS'} has been deleted from the system.</FONT></center><br><br>";
	}
	else{
	&oops('Invalid Username');
	}
	
}

sub adminview {
		
		print "<H2><center><b>Administration Page Access</b></center></H2><center><TABLE WIDTH=100\% BORDER=0>\n"; 		
      		print "<FORM ACTION=$ENV{'SCRIPT_NAME'} METHOD=POST>\n";
		print "<INPUT TYPE=HIDDEN NAME=action VALUE=admin>\n";  
		print "<TR><TD ALIGN=CENTER VALIGN=TOP><B>Administrator Password: </B><INPUT NAME=PASSWORD TYPE=PASSWORD SIZE=30>\n";
		print "<br><bR><input type=submit value=Enter></form>\n";
		print "</td></tr></table></center>\n";		
}

sub admin_moditem {
	if (lc($form{'PASSWORD'}) eq lc($config{'adminpass'})) {
	my $cat = $form{'CATEGORY'};
	my $item = $form{'ITEM'};
	my $nowtime = localtime(time);
	my $closetime = localtime($form{'item'});
	my @rfts;
	my ($alias, $email, $rft, $time, $add1, $add2, $add3) = &read_rft($rfts[0]);
	print "<FORM ACTION=$ENV{'SCRIPT_NAME'} METHOD=POST>";
	print "<input type=hidden value=admin_moditem2 name=action>";
	print" <input type=hidden name=CATEGORY VALUE=$form{'category'}";
	&oops('You must enter a valid category and ad number.') unless $form{'CATEGORY'} and $form{'ITEM'};
	
	&oops('Ad File Not Found.') unless open FILE, "$config{'basepath'}$cat/$item.dat";
	my ($title, $rgt, $rht, $desc, $image, $url, @rfts) = <FILE>;
	close FILE;
	chomp ($title, $rgt, $rht, $desc, $image, $url, @rfts);
	my @firstrft =  &read_rft($rfts[0]);
	my @lastrft = &read_rft($rfts[$#rfts]);
	print "<INPUT TYPE=HIDDEN NAME=PRFT0 VALUE=\"$firstrft[0]\">\n";
 	print "<INPUT TYPE=HIDDEN NAME=LRFT0 VALUE=\"$lastrft[0]\">\n";
	print "<INPUT TYPE=HIDDEN NAME=RGT VALUE=\"$rgt\">\n";
  	print "<INPUT TYPE=HIDDEN NAME=RHT VALUE=\"$rht\">\n";
   	print "<INPUT TYPE=HIDDEN NAME=EMAIL VALUE=\"$email\">\n";
	print "<br><br><center><font face=arial size=2><b>Edit the ad information below.</b></font></center><br><br>";
	print "<center><table border=0 cellpadding=3>";
	print "<tr><td width=100><b>Username: </b></td><td><input type=hidden name=PRFT0 value=$firstrft[0]>$firstrft[0]</td></tr>";
	print "<tr><td width=100><b>Ad number: </b></td><td><input type=hidden name=ITEM value=\"$form{'ITEM'}\">$form{'ITEM'}</td></tr>";
	print "<tr><td width=100><b>Category: </b></td><td><input type=text size=40 name=CATEGORY value=\"$form{'CATEGORY'}\"></TD></tr>";
	print "<tr><td width=100><b>Title: </b></td><td><input type=text size=40 maxsize=50 name=TITLE value=\"$title\"></td></tr>";
	print "<tr><td width=100 valign=top><b>Description: </b></td><td><textarea rows=12 cols=50 name=DESC WRAP=VIRTUAL value=\"$desc\">$desc</TEXTAREA></td></tr>";
 	print "<tr><td width=100><b>Website: </b><br>Optional - Include http://</td><td><input type=text size=45 name=URL value=\"$url\"></td></tr>";
	print "<tr><td width=100><b>Image URL: </b><br>Optional - Include http://</td><td><input type=text size=45 name=IMAGE value=\"$image\"></td></tr>";
	print "</table></center>";
	print "<center><br><input type=submit value=Continue></form></center>";
	}
 	else {
	print "<p>&nbsp;</p><center><b>Incorrect administrator password.</b></center>\n";
	}
}

sub admin_moditem2 {
		my $cat = $form{'CATEGORY'};
		my $item_number = $form{'ITEM'};
		if ($form{'FROMPREVIEW'}) {
			my $key;
			foreach $key (keys %form) {
				$form{$key} =~ s/\[greaterthansign\]/\>/gs;
				$form{$key} =~ s/\[lessthansign\]/\</gs;
				$form{$key} =~ s/\[quotes\]/\"/gs;
			}
			if (($form{'LRFT2'}) eq ($form{'PRFT2'})) {
			&oops('We are unable to modify the ad.  This could be a write permissions problem.') unless (open (NEW, ">$config{'basepath'}$form{'CATEGORY'}/$item_number.dat"));
			print NEW "$form{'TITLE'}\n$form{'RGT'}\n$form{'RHT'}\n$form{'DESC'}\n$form{'IMAGE'}\n$form{'URL'}\n$form{'PRFT0'}";
			close NEW;
			}
			else {
			&oops('We are unable to modify the ad.  This could be a write permissions problem.') unless (open (NEW, ">$config{'basepath'}$form{'CATEGORY'}/$item_number.dat"));			
			print NEW "$form{'TITLE'}\n$form{'RGT'}\n$form{'RHT'}\n$form{'DESC'}\n$form{'IMAGE'}\n$form{'URL'}\n$form{'PRFT0'}\n$form{'LRFT0'}";
			close NEW;
			}
			print "<br><center><B>$form{'TITLE'}</b> has been modified.<BR>You may want to <A HREF=\"$ENV{'SCRIPT_NAME'}\?category=$form{'CATEGORY'}\&item=$item_number\">view</A> the ad to confirm modification.</center>\n\n";
			}
			else {
			my $nowtime = localtime(time);
			my $closetime = localtime($item_number);
			print "<center><H2>Admin Modification Preview</H2></center><BR><br>\n";
			print "<TABLE WIDTH=100\% BORDER=0 BGCOLOR=$config{'colortableborder'} CELLSPACING=0><TR><TD><TABLE BORDER=0 WIDTH=100\% CELLPADDING=2 CELLSPACING=1><TR><TD BGCOLOR=$config{'colortablehead'}><B>$form{'TITLE'}</B></TD></TR><TR><TD BGCOLOR=$config{'colortablebody'}><B>Category:</B> <b><A HREF=$ENV{'SCRIPT_NAME'}\?category=$form{'CATEGORY'}>$category{$form{'CATEGORY'}}</A></b></TD></TR>";
			print "<TR><TD BGCOLOR=$config{'colortablebody'}><B>Website: <A HREF=\"$form{'URL'}\"} TARGET=top><u>$form{'URL'}</u></A></B></TD></TR>"  if ($form{'URL'});
   			print "<TR><TD BGCOLOR=$config{'colortablebody'}>$form{'DESC'}</TD></TR>";
			print "<TR><TD BGCOLOR=$config{'colortablebody'}><CENTER><IMG SRC=$form{'IMAGE'}></CENTER></TD></TR>" if ($form{'IMAGE'});
			print "</TABLE></TD></TR></TABLE>";
			print "<CENTER><FORM ACTION=$ENV{'SCRIPT_NAME'} METHOD=POST>If you are satisfied with the ad hit the submit button below.<br>If you need to make any changes, please hit the back button on your browser to edit the information<br><br><INPUT TYPE=SUBMIT VALUE=\"Submit\"><INPUT TYPE=HIDDEN NAME=FROMPREVIEW VALUE=1></CENTER>\n";
			my $key;
			foreach $key (keys %form) {
				$form{$key} =~ s/\>/\[greaterthansign\]/gs;
				$form{$key} =~ s/\</\[lessthansign\]/gs;
				$form{$key} =~ s/\"/\[quotes\]/gs;
				print "<INPUT TYPE=hidden NAME=\"$key\" VALUE=\"$form{$key}\">\n";
			}
			print "</FORM>\n";
			
	}
}

sub banemail {
		my $file;
		opendir THEDIR, "$config{'basepath'}bannedmail" || die "Unable to open directory: $!";
		my @allfiles = readdir THEDIR;
		closedir THEDIR;
		chomp(@allfiles);
		foreach $file (@allfiles) {
		if($form{'EMAIL'} eq $file){
		&oops("That e-mail address has been banned from our system.");
		die "email address not permitted ";
		}
				
	}
	
}


sub banemail2 {
		if (lc($form{'PASSWORD'}) eq lc($config{'adminpass'})) {
		my $banned = "$form{'EMAIL'}";
		&oops('You must enter a valid e-mail address.') unless (open (NEW, ">$config{'basepath'}bannedmail/$banned"));
		print NEW "";
		close NEW;
		print "<p>&nbsp;</p><center>E-mail address <b>$form{'EMAIL'}</b> is now banned from the system.";
		}
		else {
		print "<p>&nbsp;</p><center><b>Incorrect administrator password.</b></center>\n";
		}
}


sub unbanemail {
	my $line;	
		
		if (unlink("$config{'basepath'}bannedmail/$form{'EMAIL'}")) {
			print "<p>&nbsp;</p><center>The e-mail address <b>$form{'EMAIL'}</b> will now be allowed to access the system.</center>";
			}
			else{
			&oops('Address not found in banned e-mail directory.');
	}
}


sub unbanemail2 {
	if (lc($form{'PASSWORD'}) eq lc($config{'adminpass'})) {
			
			my $file;
			opendir THEDIR, "$config{'basepath'}bannedmail" || die "Unable to open directory: $!";
			my @allfiles = readdir THEDIR;
			closedir THEDIR;
			print "<p>&nbsp;</p><center><b>Banned E-mail Addresses</b><br><br>Click \"Reinstate\" to allow an address to use the system.<br><br>";
			print "<center><table width=350 border=0 cellpadding=0>";
			foreach $file (@allfiles) {
			if ($file =~ /\@/){
			print "<tr><td><FORM ACTION=$ENV{'SCRIPT_NAME'} METHOD=POST><input type=hidden name=action value=unbanemail><input type=text size=30 name=EMAIL value=$file> &nbsp;<input type=submit value=Reinstate></form></td></tr>";
			}
			}
			print "</table></center>";
			}
			else {
			print "<p>&nbsp;</p><center><b>Incorrect administrator password.</b></center>\n";
			}
				

}
sub emailusers {
if (lc($form{'PASSWORD'}) eq lc($config{'adminpass'})) {

my $mailit = "$form{'MESSAGE1'}";
		my $file;
		opendir THEDIR, "$config{'basepath'}$config{'regdir'}" || die "Unable to open directory: $!";
		my @allfiles = readdir THEDIR;
		closedir THEDIR;
		foreach $file (sort { int($a) <=> int($b) } @allfiles) {
		if ("$config{'basepath'}$config{'regdir'}/$file" =~ /\.dat/) {
		open THEFILE, "$config{'basepath'}$config{'regdir'}/$file";
		my ($password,$email,@junk) = <THEFILE>;
		close THEFILE;
		chomp($password,$email,@junk);
		$file =~ s/\.dat//;
		my $username = $file;
		&sendemail($email, $config{'admin_address'}, $form{'MAILHEAD'}, $mailit);
		}
		}
		print "<br><FONT SIZE=+1><CENTER>Your message has been sent.</CENTER></FONT>";
}
else {
		print "<p>&nbsp;</p><center><b>Incorrect administrator password.</b></center>\n";
	}
}

sub closeit {
	my ($cat,$item) = @_;
	if ($cat ne $config{'closedir'}) {
		my ($title, $rgt, $rht, $desc, $image, $url, @rfts) = &read_item_file($cat,$item);
		my @lastrft = &read_rft($rfts[$#rfts]);
		my @firstrft =  &read_rft($rfts[0]);
  			&sendemail($firstrft[1], $config{'admin_address'}, "AD EXPIRED: $title", "Ad number $item is now closed.\r\nYou may repost your ad by using the closed ad manager at http://$config{'scripturl'}$ENV{'SCRIPT_NAME'}?action=closed.\r\n\nThanks for using $config{'sitename'}!");
		if ($config{'closedir'}) {
			umask(000);  # UNIX file permission junk
			mkdir("$config{'basepath'}$config{'closedir'}", 0777) unless (-d "$config{'basepath'}$config{'closedir'}");		
			print "Please notify the site admin that this ad cannot be copied to the closed directory even though it is closed.\n" unless &movefile("$config{'basepath'}$cat/$item.dat", "$config{'basepath'}$config{'closedir'}/$cat$item.dat");		
		}
		else {
			print "Please notify the site administrator that this ad cannot be removed even though it is closed.\n" unless unlink("$config{'basepath'}$cat/$item.dat");
		}
	}
}

sub sendemail {
        my ($to,$from,$subject,$message) = @_;
        my $trash;
        if ($config{'mailhost'}) {
		eval('use IO::Socket; 1;') or &oops("IO::Socket could not be loaded by the script. Perl version $].  IO::Socket may not be included with versions of perl prior to 5.00404.");
                my $remote;
                $remote = IO::Socket::INET->new("$config{'mailhost'}:smtp(25)");
                $remote->autoflush();
                print $remote "HELO\r\n";
                $trash = <$remote>;
                print $remote "MAIL From:<$config{'admin_address'}>\r\n";
                $trash = <$remote>;
                print $remote "RCPT To:<$to>\r\n";
                $trash = <$remote>;
                print $remote "DATA\r\n";
                $trash = <$remote>;
                print $remote "From: <$from>\r\nSubject: $subject\r\n\r\n";
                print $remote $message;
                print $remote "\r\n.\r\n";
                $trash = <$remote>;
                print $remote "QUIT\r\n";
        }
        else {
                open MAIL, "|$config{'mailprog'}";
                print MAIL "To: $to\r\nFrom: $from\r\nSubject: $subject\r\n\r\n$message\r\n\r\n";
                close MAIL;
        }
}

sub get_form_data {
        my $temp;
        my $buffer;
        my @data;
        read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
        foreach $temp (split(/&|=/,$buffer)) {
                $temp =~ tr/+/ /;
                $temp =~ s/%([0-9a-fA-F]{2})/pack("c",hex($1))/ge;
		$temp =~ s/[\r\n]/ /g;
                push @data, $temp;
        }
        foreach $temp (split(/&|=/,$ENV{'QUERY_STRING'})) {
                $temp =~ tr/+/ /;
                $temp =~ s/%([0-9a-fA-F]{2})/pack("c",hex($1))/ge;
		$temp =~ s/[\r\n]/ /g;
                push @data, $temp;
        }
        return @data;
}

sub randompass {
	srand(time ^ $$);
	my @passset = ('a'..'k', 'm'..'n', 'p'..'z', '2'..'9');
	my $randpass = "";
	for (my $i=0; $i<8; $i++) {
		$randpass .= $passset[int(rand($#passset + 1))];
	}
	return $randpass;
}

sub parserft {
	$_[0] =~ s/\,//g; 
	my @rftamt = split(/\./, $_[0]);
	$rftamt[0] = "0" if (!($rftamt[0]));
	$rftamt[0] = int($rftamt[0]);
	$rftamt[1] = substr($rftamt[1], 0, 2);
	$rftamt[1] = "00" if (length($rftamt[1]) == 0);
	$rftamt[1] = "$rftamt[1]0" if (length($rftamt[1]) == 1);
	return "$rftamt[0].$rftamt[1]";
}

sub oops {
	print "<P><H2><CENTER><B>ERROR</B></H2><P><FONT SIZE=4><I>$_[0]</I></FONT><P>Please hit the back browser on your browser to try again.<br>If you believe this is a server problem you may contact the <A HREF=\"mailto:$config{'admin_address'}\">site  administrator</A>.</center>\n";
	print $config{'footer'};
	die "Error: $_[0]\n";
}

sub movefile {
	my ($firstfile, $secondfile) = @_;
	return 0 unless open(FIRSTFILE,$firstfile);
	my @lines=<FIRSTFILE>;
	close FIRSTFILE;
	return 0 unless open(SECONDFILE,">$secondfile");
	my $line;
	foreach $line (@lines) {
		print SECONDFILE $line;
	}
	close SECONDFILE;
	return 0 unless unlink($firstfile);
	return 1;
}

sub read_reg_file {
	my $alias = shift;
	return '' unless $alias;
	# verify the user exists
	&oops('Your username must consist of alphanumeric characters only.') if $alias =~ /\W/;
	$alias = ucfirst(lc($alias));
	return '' unless -r "$config{'basepath'}$config{'regdir'}/$alias.dat" and -T "$config{'basepath'}$config{'regdir'}/$alias.dat";
	open FILE, "$config{'basepath'}$config{'regdir'}/$alias.dat";
	my @past_rfts=<FILE>;
	my $password = $past_rfts[0];
	my $email = $past_rfts[1];
	my $add1 = $past_rfts[2];
	my $add2 = $past_rfts[3];
	my $add3 = $past_rfts[4];
 	my $add4 = $past_rfts[5];
	my $add5 = $past_rfts[6];
	my $add6 = $past_rfts[7];
	my $phone = $past_rfts[8];
	chomp ($password,$email,$add1,$add2,$add3,$add4,$add5,$add6,$phone,@past_rfts);
	return ($password,$email,$add1,$add2,$add3,$add4,$add5,$add6,$phone,@past_rfts);
}

sub read_item_file {
	my ($cat, $item) = @_;
	return '' unless ($cat) and ($item);
	&oops('The category must consist of alphanumeric characters only.') if $cat =~ /\W/;
	return '' unless $category{$cat};
	&oops('The ad number must consist of alphanumeric characters only.') if $item =~ /\D/;
	return '' unless 0||#1>>noconfuse(ea;-)
	open FILE, "$config{'basepath'}$cat/$item.dat";
	my ($title, $rgt, $rht, $desc, $image, $url, @rfts) = <FILE>;
	close FILE;
	chomp ($title, $rgt, $rht, $desc, $image, $url, @rfts);
	return ($title, $rgt, $rht, $desc, $image, $url, @rfts);
}

sub read_rft {
	my $rft_string = shift;
	my ($alias, $email, $rft, $time, $add1, $add2, $add3) = split(/\[\]/,$rft_string);
	return ($alias, $email, $rft, $time, $add1, $add2, $add3);
}
 
sub maillist {
&oops('Incorrect Password') if ($form{'adminpass'} ne $config{'adminpass'} && exists $form{adminpass});
 print "<center><TABLE WIDTH=600 BORDER=0 CELLSPACING=0 BGCOLOR=$config{'colortablebody'}><tr><td><center><p>\n";
 
 if(!exists $form{adminpass}){
  print qq~<form action="$ENV{SCRIPT_NAME}" method="post"><input type="hidden" name="action" value="$form{action}"><input type="radio" name="createfile" value="0" checked> Show Maillist <input type="radio" name="createfile" value="1"> Create file<p>Password <input name="adminpass" type="password"><p><input type="submit" value="SUBMIT"></form></center></td></tr></table>~;
  return;
 }
 opendir(THEDIR, "$config{'basepath'}$config{'regdir'}") || &oops("Unable to open directory: $!");
 readdir THEDIR;readdir THEDIR;
  print qq~<H2><b>Mailing List</b></H2><pre>\n~;
 my $totalusers;
 if($form{createfile}){
  print qq~<form name="f1"><textarea name="t1" rows="8" cols="40" wrap="off" style="background-color:white;color:black;font-family:monospace">Creating file...\n\n~;
  unless (open(FILE, ">maillist.xls")){ print "$!\n\nFile could not be created.</textarea></form></td></tr></table>"; die }
  select FILE;
 }
 foreach my $file (sort readdir THEDIR) {
  unless (open(REGFILE, "$config{'basepath'}$config{'regdir'}/$file")){ print "Unable to open file: $!</td></tr></table>"; die }
  my ($mlpassword, $mlemail) = <REGFILE>;
  chomp($mlpassword, $mlemail);
  close REGFILE;
  $file =~ s/\.dat$//;
  if($form{createfile}){
  print qq~$file\t$mlemail\t"""$file"" <$mlemail>"\n~;
  }else{
  print qq~"$file" &lt;<a href="mailto:$mlemail">$mlemail</a>&gt;\n~;
  }
  $totalusers++;
 }
 if($form{createfile}){
  select STDOUT;
  close(FILE);
  print "maillist.xls has been created!\n</textarea></form>";
 }
 closedir THEDIR;
 print qq~\n</pre><b>$totalusers Users</b><br><br></p>~;
 print "</td></tr></table></center>";
} 

sub start_search {
		  print <<"EOF";
		  <CENTER>
			<FORM ACTION=$ENV{'SCRIPT_NAME'} METHOD=POST>
			<h2>Search Ads</h2>
			<INPUT TYPE=TEXT NAME=searchstring value="@{[map{s,<|"|>,,g;$_}$_=$form{searchstring}]}">
			<select name=category>
			<option value="">All Categories
			@{[map {$_ eq $form{category} ? "<option selected value=$_>$category{$_}\n" : "<option value=$_>$category{$_}\n"} sort keys %category]}
			</select>
   			<INPUT TYPE=SUBMIT VALUE="Search">
			<INPUT TYPE=HIDDEN NAME=action VALUE="search"><br>
   			<table><tr><td><FONT SIZE=-1><b>Search by: </b><INPUT TYPE=RADIO NAME=searchtype VALUE="keyword" CHECKED>Keyword <INPUT TYPE=RADIO NAME=searchtype VALUE="username">Username<br></font></td></tr>
			<tr><td><FONT SIZE=-1><b>Check the box to display ads with photos only. </b></FONT><INPUT TYPE=CHECKBOX NAME=imagesearch VALUE="photos"></td></tr></table>
				</form>
			<BR>
		</center>
EOF
}
sub pagebreak{
	my $begin = "<center>";
	my $next = "Next >";
	my $nonext = "Next >";
	my $previous = "< Back";
	my $noprevious = "< Back";
	my $end = "</center>";
	
	my $urlfragment;
	foreach(keys %form){
		next if($_ eq 'pb' || $_ eq 'page');
		my $f = $form{$_};
		$f=~s/(\W)/'%'.unpack("H2", $1)/eg;
		$urlfragment.='&' if $urlfragment;
		$urlfragment.="$_=$f";
	}
	my($pcount, $pagebreak) = @_;
	print $begin;
	if($form{page} > 0){ print " <a href=$ENV{SCRIPT_NAME}?$urlfragment&page=@{[$form{page}-1]}&pb=$form{pb}>$previous</a> " }
	else{ print " $noprevious " }
	print "|";
	for(0..$form{page}-1){ print " <a href=$ENV{'SCRIPT_NAME'}?$urlfragment&page=$_&pb=$form{pb}>@{[$_+1]}</a> " }
	print " <b>", int($form{page})+1, "</b> ";
	for($form{page}+1..$pcount){ print " <a href=$ENV{'SCRIPT_NAME'}?$urlfragment&page=$_&pb=$form{pb}>@{[$_+1]}</a> " }
	if($pcount>0){ print " <a href=$ENV{'SCRIPT_NAME'}?$urlfragment&pb=@{[(1+$pcount)*$pagebreak]}>All</a> " }
	print "|";
	if($form{page} < $pcount){ print " <a href=$ENV{'SCRIPT_NAME'}?$urlfragment&page=@{[$form{page}+1]}&pb=$form{pb}>$next</a> " }
	else{ print " $nonext " }
	print $end;
}

sub lp {
	print <<"EOF";
<center><FORM METHOD=POST ACTION=\"$ENV{'SCRIPT_NAME'}\">
<input name="action" type="hidden" value="lp2">
<table cellspacing=0 cellpadding=0 border=0 width=325>
<td width=50\%><b>Username:</b>\&nbsp;\&nbsp;</td><td width=50\%><input name="ALIAS" type="text" value="" size=25 maxlength=30></td></tr><tr><td width=50\%><b>E-mail Address:</b>\&nbsp;\&nbsp;</td>
<td width=50\%><input name="EMAIL" type="text" value="" size=25 maxlength=30></td>
</tr>
</table>

<br><input type="submit" value="Get Password">
</form>			
	
	
EOF
} 

sub lp2 {
	&oops('You must enter a username that consists of alphanumeric characters only.') if $form{'ALIAS'} =~ /\W/ or !($form{'ALIAS'});
	my $testmail = $form{'EMAIL'};
if ($testmail =~ /(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)/ ||
	$testmail !~ /^.+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?)$/)
      	{
	&oops('You must enter a valid e-mail address.');
	}
		
	$form{'ALIAS'} =~ s/\W//g;
	$form{'ALIAS'} = lc($form{'ALIAS'});
	$form{'ALIAS'} = ucfirst($form{'ALIAS'});
	&oops('Invalid Username') unless (open(REGFILE, "$config{'basepath'}$config{'regdir'}/$form{'ALIAS'}.dat"));
	my ($password,$email,$add1,$add2,$add3,$add4,$add5,$add6,$phone,@junk) = <REGFILE>;
	chomp($password,$email,$add1,$add2,$add3,$add4,$add5,$add6,$phone,@junk);
	close REGFILE;
	&oops('Your e-mail address does not match our records.') unless ((lc $email) eq (lc $form{'EMAIL'}));
	&sendemail($email, $config{'admin_address'}, "Password Request", "We have received a request for your password.\n\nYour password is: $password \r\n\nThanks for using $config{'sitename'}!");
		
	print "<center>$form{'ALIAS'}, your password has been sent to you by e-mail.</center>";
	

}

sub backto{

	my $Separator = " : ";
	my $Item = "Item";
	my $Home = "Top";

	my (@backs, $backto, $path, $thispath, $current);
	if($_[0] eq ''){$_[0] = $form{category}}
	$thispath=$_[0];
	if($category{$_[0]} ne ''){
		$thispath=$category{$form{category}};
		while($thispath=~s/^<!--([^\>]*)-->//){
			if($supercat{$1} ne ''){$thispath.=":$1"}
		}
		# $current=$category{$_[0]};##
	}
	@backs=split(/\:/, $thispath);
	foreach (0..($#backs-1)){
		if($supercat{$backs[$_]} ne ''){
			$path.=":$backs[$_]";
			$backto.="$Separator<a href=\"$ENV{SCRIPT_NAME}?category=$path&super=true\">$supercat{$backs[$_]}</a>";
		}
	}
	$path.=":$backs[-1]";
	if($supercat{$backs[-1]} ne '' && $category{$_[0]} ne ''){
		if($form{item} ne ''){ # ITEM
			$backto.="$Separator<a href=\"$ENV{SCRIPT_NAME}?category=$path&super=true\">$supercat{$backs[-1]}</a>$Separator<a href=\"$ENV{SCRIPT_NAME}?category=$_[0]\">$category{$_[0]}</a>";
		}else{ # ITEMLIST
			$backto.="$Separator<a href=\"$ENV{SCRIPT_NAME}?category=$path&super=true\">$supercat{$backs[-1]}</a>$Separator$category{$_[0]}";
		}
	}elsif($supercat{$backs[-1]} ne ''){ # SUBCATEGORIES
		$backto.="$Separator$supercat{$backs[-1]}";
	}
	if($backto ne ''){return "<a href=\"$ENV{SCRIPT_NAME}\">$Home</a>$backto"}
	else{return ''}
}

sub seller_moditem {
	
	my $cat = $form{'CATEGORY'};
	my $item = $form{'ITEM'};
	my $nowtime = localtime(time);
	my $closetime = localtime($form{'item'});
	my @rfts;
	my ($alias, $email, $rft, $time, $add1, $add2, $add3, $add4, $add5, $add6, $phone) = &read_rft($rfts[0]);
	&oops('You must enter a valid category and ad number.') unless $form{'CATEGORY'} and $form{'ITEM'};
	&oops('Ad File Not Found.') unless open FILE, "$config{'basepath'}$cat/$item.dat";
	my ($title, $rgt, $rht, $desc, $image, $url, @rfts) = <FILE>;
	close FILE;
	chomp ($title, $rgt, $rht, $desc, $image, $url, @rfts);
	my @firstrft =  &read_rft($rfts[0]);
	my ($password, @userrfts);
	&oops('Invalid Username') unless ($password, $email, $add1, $add2, $add3, $add4, $add5, $add6, $phone, @userrfts) = &read_reg_file($form{'ALIAS'});
	&oops('Incorrect Username or Password') unless  ((($form{'ALIAS'}) eq ($firstrft[0])) && ((lc $password) eq (lc $form{'PASSWORD'})));
	if ($form{'MODDEL'} eq '') {
	print "<center>You must select Modify or Delete.</center>";
	}
	
	elsif ($form{'MODDEL'} eq "MOD") {
	print "<FORM ACTION=$ENV{'SCRIPT_NAME'} METHOD=POST>";
	print "<input type=hidden value=seller_moditem2 name=action>"; 	
	print "<br><br><h4>Edit your ad below. To move your ad to a different category, please delete this ad and post a new one.</h4>";
	print "<center><table border=0 cellspacing=0 cellpadding=3>";
	print "<tr><td width=100><b>Username: </b></td><td><input type=hidden name=PRFT0 value=$firstrft[0]>$firstrft[0]</td></tr>";
	print "<tr><td width=100><b>Ad Number: </b></td><td><input type=hidden name=ITEM value=$form{'ITEM'}>$form{'ITEM'}</td></tr>";
	print "<tr><td width=100><b>Category: </b></td><td><input type=hidden name=CATEGORY value=$form{'CATEGORY'}>$form{'CATEGORY'}</td></tr>";
	print "<tr><td width=100><b>Title: </b></td><td><input type=text size=40 maxsize=50 name=TITLE value=\"$title\"></td></tr>";
	print "<tr><td width=100 valign=top}><b>Description: </b></td><td><textarea rows=12 cols=50 name=DESC WRAP=VIRTUAL value=\"$desc\">$desc</TEXTAREA></td></tr>";
 	print "<tr><td width=100><b>Website: </b><br>Optional - Include http://</td><td><input type=text size=45 name=URL value=\"$url\"></td></tr>";
	print "<tr><td width=100><b>Image URL: </b><br>Optional - Include http://</td><td><input type=text size=45 name=IMAGE value=\"$image\"></td></tr>";
	print "</table></center>";
	print "<center><p><input type=submit value=Modify></form></center>";
	}
	elsif ($form{'MODDEL'} eq "DEL") {
	unlink("$config{'basepath'}$form{'CATEGORY'}/$form{'ITEM'}.dat");
			print "<center>Your ad has been successfully deleted.</center>";
		
	}
	
}

sub seller_moditem2 {

	my $cat = $form{'CATEGORY'};
	my $item_number = $form{'ITEM'};
		
		&oops('We are unable to modify the ad.  The item directory could not be opened.') unless (open (NEW, ">$config{'basepath'}$form{'CATEGORY'}/$item_number.dat"));			
			print NEW "$form{'TITLE'}\n$form{'RGT'}\n$form{'RHT'}\n$form{'DESC'}\n$form{'IMAGE'}\n$form{'URL'}\n$form{'PRFT0'}\n$form{'LRFT0'}";
			close NEW;
		print "<CENTER>Your ad description has been modified.<br>Click <A HREF=\"$ENV{'SCRIPT_NAME'}\?category=$form{'CATEGORY'}\&item=$item_number\">here</A> to view your ad and confirm your changes.</CENTER>";
}

sub autoclose { 
my $key; 
my $file; 
foreach $key (sort keys %category) { 
umask(000); # UNIX file permission junk 
mkdir("$config{'basepath'}$key", 0777) unless (-d "$config{'basepath'}$key"); 
opendir DIR, "$config{'basepath'}$key" or &oops("Category directory $key could not be opened."); 
readdir DIR;readdir DIR; 
my @allfiles = sort { $a <=> $b } readdir DIR; 
closedir DIR; 
foreach $file (@allfiles) { 
$file =~ s/^$config{'basepath'}$key\///; 
$file =~ s/\.dat$//; 
my ($title, $rgt, $rht, $desc, $image, $url, @rfts) = &read_item_file($key,$file); 
if (time > $file) { 
&closeit($key,$file); 
}}}} 
sub check_index{
	&oops("Cannot find index.txt") if !-e "index.txt";
	open(RESUME, "$config{basepath}resume.dat");
	$_ = <RESUME>;
	chomp;
	my($resumetime,$resumedir,$resumefile,$resumedbsize) = split /\t/;
	close(RESUME);
	$resumedir = '' if $category{$resumedir} eq '';
	$resumefile = '' if $resumedir eq '';
	$resumefile = '' if !-e "$config{basepath}$resumedir/$resumefile.dat";
	exit if $resumedir eq '' && time < $resumetime;
	exit if time < $resumetime+15;
	close(STDERR);
	close(STDOUT);
	`$^X index.txt`;
}
sub Validate_Item_Posting 
	{ 
	my ($ItemNumber, $Alias, @RftsParam) = @_; 
	my ($maximum_allowed_posts, $current_rfts, $RftUpdate, @Rft_History, $ItemRfts, @ItemRfts, @rfts, $rft, @ParsedRft, $User_rft, $j, $RftUpdate, @Rft_History, $tempstring, $FileID, $Category);
	$maximum_allowed_posts = $config{'adlimit'};
	$current_rfts = 0; 
	$RftUpdate = 0; 
	if (! @RftsParam)
		{
		(undef, undef, undef, undef, undef, undef, @rfts) = &read_reg_file($form{'ALIAS'});
		}
	else
		{
		@rfts = @RftsParam;
		}
	foreach $rft (@rfts) 
		{ 
		$FileID = $rft; 
		$FileID =~ s/\D+//g; 
		next if ($FileID < time);
		my $tempstring = substr($rft, 0, -9);  
		$tempstring = substr($rft, -10, -9); 
		if ($tempstring =~ /[A-Za-z]/)  
			{  
			$tempstring = substr($rft, -9);  
			$Category = substr($rft, 0, -9);  
			}  
		elsif ($tempstring =~ /[0-9]/)  
			{  
			$tempstring = substr($rft, -10);  
			$Category = substr($rft, 0, -10);  
			}
		(undef, undef, undef, undef, undef, undef, @ItemRfts) = &read_item_file($Category, $FileID); 
		@ParsedRft = split(/\[\]/,$ItemRfts[0]); 
		$User_rft = 1 if ($ParsedRft[0] eq $Alias); 
		if ($User_rft == 1) 
			{ 
			$Rft_History[$current_rfts++] = $FileID; 
			} 
		} 
	foreach $rft (@Rft_History) 
		{ 
		$RftUpdate = 1 if ($rft eq $ItemNumber); 
		} 
	&oops("$Alias, you have reached the allowed limit of ads per user: ($maximum_allowed_posts)") if (($current_rfts >= $maximum_allowed_posts) && ($RftUpdate eq 0)); 
	return(); 
	} 
sub upload {

	print <<"EOF";
<H2><CENTER>Place a New Ad</CENTER></H2>
<br><center><font size=4><b>Would you like to include a picture with your ad?</b></font></center>
<form method="post" action="$ENV{'SCRIPT_NAME'}">
  <input type="hidden" name="picture" value="none"><div align="center"><center><table
  border="0" width="80%" cellpadding="5" cellspacing="0">
    <tr>
      <td bgcolor=$config{'colortablebody'}><font size="3">If you don't have a picture you may continue without posting a picture by clicking the button below.</font></td>
    </tr>
    <tr>
      <td bgcolor=$config{'colortablebody'} valign=middle><center><br><input type="submit" value="No, I Don't Have a Picture"></center><br></td>
    </tr>
  </table>
  </center></div>
</form>
<form method="post" action="$ENV{'SCRIPT_NAME'}">
  <div align="center"><center><table border="0" width="80%" cellpadding="5" cellspacing="0">
    <tr>
      <td bgcolor=$config{'colortablebody'}><font size="3">If your picture is located on a web site, enter
      the URL of the picture in the field below.</font></td>
    </tr>
    <tr>
      <td bgcolor=$config{'colortablebody'}><table border="0" width="100%">
        <tr>
          <td bgcolor=$config{'colortablebody'} nonwrap><center><font size=3><b>Image URL:</b></font> <input type="text" name="pictureurl" size="50" value="http://"></center></td>
        </tr>
      </table>
      </td>
    </tr>
    <tr>
      <td bgcolor=$config{'colortablebody'} valign=middle><center><br><input type="submit" value="Use My Image URL"></center><br></td>
    </tr>
  </table>
  </center></div>
</form>
<form ENCTYPE="multipart/form-data" method="post" action="upload.cgi">
  <div align="center"><center><table border="0" width="80%" cellpadding="5" cellspacing="0">
    <tr>
      <td bgcolor=$config{'colortablebody'}><font size="3">If you have a picture that you would like to upload from your computer, click the 'Browse' button and select the file.</font></td>
    </tr>
    <tr>
      <td bgcolor=$config{'colortablebody'}><table border="0" width="100%">
        <tr>
          <td bgcolor=$config{'colortablebody'} nowrap><center><font size=3><b>Image to Upload:</b> <input type="file" name="UploadedFile" size="40"></font></center></td>
        </tr>
      </table>
      </td>
    </tr>
    <tr>
      <td bgcolor=$config{'colortablebody'} valign=middle><center><br><input type="submit" value="Upload My Picture"></center><br></td>
    </tr>
  </table>
  </center></div>
</form>
EOF
}
