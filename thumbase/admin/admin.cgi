#!/usr/bin/perl
########## COPYRIGHT CHRIS PALMER http://www.adultraffic.com #######
#																   #
#		   THIS SCRIPT IS FREE IN RETURN OF LINK[S]				   #
#		   DETAILS http://www.adultraffic.com/thumbBase/		   #
#																   #
####################################################################
&getquery;
open(D,"DBDETAILS");
while (<D>)
{
 	  chomp;
	  s/\$//g;
	  s/;//g;
	  s/\"//g;
	  s/#.*//;
	  s/^\s+//;
	  s/\s+$//;
	  next unless length;
	  next if ($_ =~ /<\?/);
	  my ($var,$value) = split(/\s*=\s*/, $_, 2);
	  $var_name = $var;
	  $var_value = $value;
	  eval '$$var_name = $var_value;';	  
}
close(D);

use DBI;
use CGI;
use Time::localtime;
$connect = &dbconnect;
my $sql = &querydb($connect,"SELECT * FROM settings WHERE settingID='1';");
my %FIELDS = &returnFieldNames($sql);
my @row = $sql->fetchrow;
foreach (keys %FIELDS) {
	$ss{$_} = @row[$FIELDS{$_}];
}
$sql->finish;
$thumbdir = $ss{'thumbsDirectory'};

if ($FORM{'p'} eq "") {
	&welcome;
} else {
	$where = $FORM{'p'};
	if (defined(&$where)) {
		&$where;
	} else {
		&header;
		print "<BR><BR>FAILED: $FORM{'p'} doesn't exist!<BR>";
	}
}

$connect->disconnect;

sub welcome
{
	print "Content-type: text/html\n\n";
	print "not much here gov!";
}

################# SUBMISSIONS STUFF ####################################

sub submissions
{
	print "Content-type: text/html\n\n";

	print <<"EOF";
<SCRIPT>
function reviewer(id,url)
{
	var w = 480, h = 340;

	if (document.all || document.layers) {
	   w = screen.availWidth;
	   h = screen.availHeight;
	}

	var popW = 770, popH = 640;

	var leftPos = (w-popW)/2, topPos = (h-popH)/2;

	window.open('reviewer.cgi?p=main&submissionID='+id+'&galleryURL='+url,'popup','width=' + popW + ',height=' + popH + ',top=' + topPos + ',left=' + leftPos + ',scrollbars=1');
}
</SCRIPT>
EOF
	;

	&actiontable("Submissions","Action","Time","URL [click to review]","Category");

	my $sql = &querydb($connect,"SELECT * FROM submissions ORDER BY time");
	my %FIELDS = &returnFieldNames($sql);
	while (my @row = $sql->fetchrow)
	{
		$then = localtime(@row[$FIELDS{'time'}]);
		$encurl = &encode(@row[$FIELDS{'galleryURL'}]);
		$time = $then->mday . "/" . ($then->mon+1) . "/" . ($then->year+1900) . " - " . ($then->hour) . ":" . ($then->min) . ":" . $then->sec;
		print &tableline("Approve, Reject",$time,"<A href=\"javascript:void(0)\" onClick=\"reviewer('@row[$FIELDS{'galleryURL'}]','$encurl');\">@row[$FIELDS{'galleryURL'}]</a>",@row[$FIELDS{'categoryID'}]);
	}
	$sql->finish;

	&etable;


	&footer;
}

########################################################################

sub settings
{
	print "Content-type: text/html\n\n";
	&table;
	&form;
	&hidden("p","settings_save");
	&hhtml("<B>Thumbs</B>");

	&htext("Thumb Width 1","thumbWidth","$ss{'thumbWidth'}");
	&htext("Thumb Height 1","thumbHeight","$ss{'thumbHeight'}");
	&htext("Thumb Quality 1","thumbQuality","$ss{'thumbQuality'}");
	&htext("Thumb Width 2","thumbWidth2","$ss{'thumbWidth2'}");
	&htext("Thumb Height 2","thumbHeight2","$ss{'thumbHeight2'}");
	&htext("Thumb Quality 2","thumbQuality2","$ss{'thumbQuality2'}");
	&htext("Thumb Width 3","thumbWidth3","$ss{'thumbWidth3'}");
	&htext("Thumb Height 3","thumbHeight3","$ss{'thumbHeight3'}");
	&htext("Thumb Quality 3","thumbQuality3","$ss{'thumbQuality3'}");

	&hhtml("<B>File Settings (use absolute FULL paths)</B>");
	&hhtml("<B>Page 1</B>");
	&htext("Template File 1","templateFile1","$ss{'templateFile1'}");
	&htext("Output File 1","outputFile1","$ss{'outputFile1'}");
	&htext("Trade Script to Trades","tradeScriptOut","$ss{'tradeScriptOut'}","i.e. /cgi-bin/lpt/lptout.cgi?lnk=thumbs<BR><B><font color=red>Note:</font></B>If you are using this db on a number of sites<BR>then you must enter the FULL url<BR>i.e. http://www.site.com/cgi-bin/lpt/lptout.cgi?lnk=thumbs");
	&htext("Trade Script to Galleries","tradeScriptGalleryOut","$ss{'tradeScriptGalleryOut'}","For tracking hits to galleries, use #URL# to note where the gallery url should go<BR>i.e. /cgi-bin/lpt/lptout.cgi?url=#URL#");
	&hhtml("<B>Page 2</B>");
	&htext("Template File 2","templateFile2","$ss{'templateFile2'}");
	&htext("Output File 2","outputFile2","$ss{'outputFile2'}");
	&htext("Trade Script to Trades","tradeScriptOut2","$ss{'tradeScriptOut2'}");
	&htext("Trade Script to Galleries","tradeScriptGalleryOut2","$ss{'tradeScriptGalleryOut2'}");
	&hhtml("<B>Page 3</B>");
	&htext("Template File 3","templateFile3","$ss{'templateFile3'}");
	&htext("Output File 3","outputFile3","$ss{'outputFile3'}");
	&htext("Trade Script to Trades","tradeScriptOut3","$ss{'tradeScriptOut3'}");
	&htext("Trade Script to Galleries","tradeScriptGalleryOut3","$ss{'tradeScriptGalleryOut3'}");
	&hhtml("<B>General</B>");
	&htext("Install Directory","installDirectory","$ss{'installDirectory'}");
	&htext("phpDirectory Install URL","installURL","$ss{'installURL'}");
	&htext("Thumbs Directory Path","thumbsDirectory","$ss{'thumbsDirectory'}");
	&htext("Thumbs URL","thumbsURL","$ss{'thumbsURL'}","<font color=red>Note:</font></B>If you are using this db on a number of sites<BR>then you must enter the FULL url<BR>i.e. http://www.site.com/t/thumbs");
	&hsubmit("Update &gt;");
	&etable;
	&eform;
}

sub deleteall
{
	print "Content-type: text/html\n\n";
	print <<"EOF";
<form action="admin.cgi" method="post">
<input type="hidden" name="p" value="deleteallconfirm">
<input type="submit" value="Click here to remove all galleries">
</form>
EOF
	;
}

sub deleteallconfirm
{
	print "Content-type: text/html\n\n";
	print "done.";

	my $sql = &querydb($connect,"DELETE FROM thumbs");
	$sql->finish;
	opendir(D,"$ss{'thumbsDirectory'}");
	while (defined($file = readdir(D))) {
		next if ($_ =~ /^\./);
		unlink("$ss{'thumbsDirectory'}/$file");
	}
	closedir(D);
}

sub settings_save
{
	$q = "UPDATE settings SET ";
	foreach (sort (keys %FORM)) {
		if ( ($_ ne "p") ) {
			$q .= "$_=\"$FORM{$_}\",";
			$fields++
		}
	}
	$q = substr($q,0,length($q)-1);
	$q .= " WHERE settingID='1'";
	my $sql = &querydb($connect,$q);
	$sql->finish;
	&go2("p=settings");
}

sub gallerys
{
	print "Content-type: text/html\n\n";
	print <<"EOF";
<HTML>
<HEAD>
<SCRIPT>
function goOnResponse(message,location) {
	if (confirm(message)==1) { document.location.href=location; }
}
</SCRIPT>
<style type="text/css">
body {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
}
td {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
}
input {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
}
select {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
}
</style>
</HEAD>
<BODY>
EOF
	;
	&form;
	&actiontable("New Gallery[s]","Field","Details");
	&hidden("p","gallerys_new");
	&htextbox("URL[s]","galleryURL","",10,60);
	&hsubmit("Add &gt;");

	&eform;
	&etable;

	print "<BR>";

	print "<a href=\"#\" onClick=\"goOnResponse('Are you sure you wish to remake all thumbs?','$ENV{'SCRIPT_NAME'}?p=remake');\"><font size=+1>Remake all thumbs</font></a><BR>";
	print "<a href=\"#\" onClick=\"goOnResponse('Are you sure you wish to make thumbs for all galleries without thumbs?','$ENV{'SCRIPT_NAME'}?p=remakesome');\"><font size=+1>Make all without thumbs</font></a><BR>";
	print "<a href=\"$ENV{'SCRIPT_NAME'}?p=massadd\"><font size=+1>Mass Gallery Add</font></a><BR><BR>";

	$perpage = 10;
	$start=$FORM{'start'};

	$next = $FORM{'start'} + $perpage;
	$prev = $FORM{'start'} - $perpage;

	my $sql = &querydb($connect,"SELECT COUNT(*) FROM thumbs;");
	my @row = $sql->fetchrow;
	$allmax = @row[0];
	$max = @row[0]-1;
	$rem = ($max % $perpage);
	$max = $max - $rem ;
	$sql->finish;
	print "<table width=600><tr>Page: ";
	for($i=0;$i<=$max;$i=$i+$perpage)
	{
		if ($FORM{'start'}!=$i) {
			print "<a href=\"$ENV{'SCRIPT_NAME'}?p=gallerys&start=$i&sortby=$FORM{'sortby'}\">",($i/$perpage)+1,"</a> ";
		} else {
			print "",($i/$perpage)+1," ";
		}
	}
	print "</td></tr></table>";
	print "<BR><B>$allmax Galleries in DB</B><BR>";

	if ($prev >-1) {
		$previouslink = <<"EOF";
	[ <a href="$ENV{'SCRIPT_NAME'}?p=gallerys&start=$prev&sortby=$FORM{'sortby'}">Previous Page</a> ]
EOF
		;
	}
	if ($next < $allmax) {
		$nextlink = <<"EOF";
	[ <a href="$ENV{'SCRIPT_NAME'}?p=gallerys&start=$next&sortby=$FORM{'sortby'}">Next Page</a> ]
EOF
		;
	}
	print <<"EOF";
[ <a href="$ENV{'SCRIPT_NAME'}?p=gallerys&start=0&sortby=$FORM{'sortby'}">First Page</a> ] $previouslink $nextlink [ <a href="$ENV{'SCRIPT_NAME'}?p=gallerys&start=$max&sortby=$FORM{'sortby'}">Last Page</a> ] <BR><BR>
EOF
	;

	&actiontable("Gallerys","Action","URL","Thumbnail","Get Thumb");

	if ($start == 0) { $start = 0; }
	my $sql = &querydb($connect,"SELECT * FROM thumbs ORDER BY thumbID DESC;");
	my %FIELDS = &returnFieldNames($sql);
	$a=0;
	while (my @row = $sql->fetchrow) {
		$action = <<"EOF";
[ <a href="$ENV{'SCRIPT_NAME'}?p=gallerys_edit&thumbID=@row[0]&sortby=$FORM{'sortby'}&start=$FORM{'start'}">Edit</a> ]
[ <a href="$ENV{'SCRIPT_NAME'}?p=gallerys_delete&thumbID=@row[0]&sortby=$FORM{'sortby'}&start=$FORM{'start'}">Delete</a> ]
[ <a href="#" onClick="if (confirm('Are you sure you wish to move this gallery to the Bad Thumbs DB?')==1){document.location.href='$ENV{'SCRIPT_NAME'}?p=gallerys_baddb&thumbID=@row[0]&sortby=$FORM{'sortby'}&start=$FORM{'start'}';}">Move to Bad DB</a> ]
EOF
		;
		$encurl = &encode(@row[$FIELDS{'galleryURL'}]);
		$where = &encode("p=gallerys&start=$FORM{'start'}");
		$makethumb = <<"EOF";
<table><tr><Td><form action="getthumb.cgi" method="post">
	<input type="hidden" name="url" value="$encurl">
	<input type="hidden" name="thumbID" value="@row[0]">
	<input type="hidden" name="where" value="$where">
	<input type="hidden" name="thumbWidth" value="$ss{'thumbWidth'}">
	<input type="hidden" name="thumbHeight" value="$ss{'thumbHeight'}">
	<input type="hidden" name="thumbQuality" value="$ss{'thumbQuality'}">
	<input type="hidden" name="thumbWidth2" value="$ss{'thumbWidth2'}">
	<input type="hidden" name="thumbHeight2" value="$ss{'thumbHeight2'}">
	<input type="hidden" name="thumbQuality2" value="$ss{'thumbQuality2'}">
	<input type="hidden" name="thumbWidth3" value="$ss{'thumbWidth3'}">
	<input type="hidden" name="thumbHeight3" value="$ss{'thumbHeight3'}">
	<input type="hidden" name="thumbQuality3" value="$ss{'thumbQuality3'}">
	<input type="hidden" name="start" value="$FORM{'start'}">
	<input type="hidden" name="sortby" value="$FORM{'sortby'}">
	<input type="submit" style="font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;" value="New Thumb">
</form>
</td></tr></table>
EOF
		;
		$thumbnail = "NA";
		if ( (-e "$thumbdir/@row[$FIELDS{'fileName'}]") && (length(@row[$FIELDS{'fileName'}])>1)) {
			$thumbnail = "<img src=\"$ss{'thumbsURL'}/@row[$FIELDS{'fileName'}]\">";
		}

		$dateadded = localtime(@row[$FIELDS{'dateAdded'}]);
		$dateadded = $dateadded->mday . "/" . ($dateadded->mon+1) . "/" . ($dateadded->year+1900);

		$gurl = &get_domain(@row[$FIELDS{'galleryURL'}]);
		$line = &tableline($action,"<a href=\"@row[$FIELDS{'galleryURL'}]\" target=\"_blank\">$gurl</a>",$thumbnail,"$makethumb");
		push(@lines,"$line||$prod||@row[0]||@row[$FIELDS{'totalRealShows'}]||@row[$FIELDS{'totalRealClicks'}]");
	}
	$sql->finish;

	foreach (@lines) {
		chomp $_;
		($line,$prod,$id,$shows,$clicks) = split(/\|\|/,$_);
		if ( ($listed < $perpage) && ($a >= $start) ) {
			print $line;
			$listed++; 
		}
		$a++;
	}
	&etable;
	print <<"EOF";
<BR>[ <a href="$ENV{'SCRIPT_NAME'}?p=gallerys&start=0&sortby=$FORM{'sortby'}">First Page</a> ] $previouslink $nextlink [ <a href="$ENV{'SCRIPT_NAME'}?p=gallerys&start=$max&sortby=$FORM{'sortby'}">Last Page</a> ] <BR><BR>
EOF
	;
}

sub gallerys_baddb
{
	my $sql = &querydb($connect,"SELECT galleryURL FROM thumbs WHERE thumbID='$FORM{'thumbID'}';");
	my %FIELDS = &returnFieldNames($sql);
	my @row = $sql->fetchrow;
	$url = @row[0];
	$sql->finish;
	my $sql = &querydb($connect,"DELETE FROM thumbs WHERE thumbID='$FORM{'thumbID'}';");
	$sql->finish;
	my $sql = &querydb($connect,"INSERT INTO badthumbs (galleryURL) VALUES ('$url');");
	$sql->finish;
	&go2("p=gallerys");
}

sub remake
{
	print "Content-type: text/html\n\n";
	if ($FORM{'count'} ==0) {
		$FORM{'count'}=0;
	}
	if ( ($FORM{'count'} == $FORM{'max'}) && ($FORM{'count'} >0) ){
		print "<HTML>finished.</HTML>\n";
		print <<"EOF";
<META HTTP-EQUIV="refresh" CONTENT="2;URL=admin.cgi?p=gallerys">
EOF
		;
		exit;
	}
	if ($FORM{'max'} ==0) {
		my $sql = &querydb($connect,"SELECT COUNT(*) FROM thumbs ORDER BY thumbID DESC");
		my @row = $sql->fetchrow;
		$FORM{'max'} = @row[0];
		$sql->finish;
	}

	my $sql = &querydb($connect,"SELECT * FROM thumbs ORDER BY thumbID DESC");
	my %FIELDS = &returnFieldNames($sql);
	$next=0;
	while (my @row = $sql->fetchrow) {
		if ( ($next ==1) || ($FORM{'thumb'} ==0) ) {
			$nexthumb = @row[0];
			$url = &encode(@row[$FIELDS{'galleryURL'}]);
			last;
		}
		if (@row[0] ==$FORM{'thumb'}) {
			$next=1;
		}
	}
	$nextcount = $FORM{'count'}+1;	
	$where = &encode("p=remake&thumb=$nexthumb&max=$FORM{'max'}&count=$nextcount");
	$url = "getthumb.cgi?where=$where&url=$url&thumbID=$nexthumb&thumbQuality=$ss{'thumbQuality'}&thumbWidth=$ss{'thumbWidth'}&thumbHeight=$ss{'thumbHeight'}&thumbQuality2=$ss{'thumbQuality2'}&thumbWidth2=$ss{'thumbWidth2'}&thumbHeight2=$ss{'thumbHeight2'}&thumbQuality3=$ss{'thumbQuality3'}&thumbWidth3=$ss{'thumbWidth3'}&thumbHeight3=$ss{'thumbHeight3'}";
	print <<"EOF";
<HTML>
<HEAD>
<META HTTP-EQUIV="refresh" CONTENT="0;URL=$url">
</HEAD>
<BODY>
EOF
	;
	print "Making thumb number: $nextcount / $FORM{'max'} thumbs<BR></BODY></HTML>";
}

sub remakesome
{
	print "Content-type: text/html\n\n";
	if ($FORM{'count'} ==0) {
		$FORM{'count'}=0;
	}
	if ( ($FORM{'count'} == $FORM{'max'}) && ($FORM{'count'} >0) ){
		print "<HTML>Finished.</HTML>\n";
		print <<"EOF";
<META HTTP-EQUIV="refresh" CONTENT="0;URL=admin.cgi?p=gallerys">
EOF
		;
		exit;
	}
	if ($FORM{'max'} ==0) {
		my $sql = &querydb($connect,"SELECT COUNT(*) FROM thumbs WHERE fileName IS NULL ORDER BY thumbID DESC;");
		my @row = $sql->fetchrow;
		$FORM{'max'} = @row[0];
		$sql->finish;
	}
	if ($FORM{'max'}==0) {
		print "<HTML>Finished.</HTML>\n";
		print <<"EOF";
<META HTTP-EQUIV="refresh" CONTENT="0;URL=admin.cgi?p=gallerys">
EOF
		;
		exit;
	}
	my $sql = &querydb($connect,"SELECT * FROM thumbs WHERE fileName IS NULL ORDER BY thumbID DESC;");
	my %FIELDS = &returnFieldNames($sql);
	$next=0;
	while (my @row = $sql->fetchrow) {
		$nexthumb = @row[0];
		$url = &encode(@row[$FIELDS{'galleryURL'}]);
		last;
	}
	$nextcount = $FORM{'count'}+1;
	$where = &encode("p=remakesome&thumb=$nexthumb&max=$FORM{'max'}&count=$nextcount");
	$url = "getthumb.cgi?where=$where&url=$url&thumbID=$nexthumb&thumbQuality=$ss{'thumbQuality'}&thumbWidth=$ss{'thumbWidth'}&thumbHeight=$ss{'thumbHeight'}&thumbQuality2=$ss{'thumbQuality2'}&thumbWidth2=$ss{'thumbWidth2'}&thumbHeight2=$ss{'thumbHeight2'}&thumbQuality3=$ss{'thumbQuality3'}&thumbWidth3=$ss{'thumbWidth3'}&thumbHeight3=$ss{'thumbHeight3'}";
	print <<"EOF";
<HTML>
<HEAD>
<META HTTP-EQUIV="refresh" CONTENT="0;URL=$url">
</HEAD>
<BODY>
EOF
	;
	print "Making thumb number: $nextcount / $FORM{'max'} thumbs, next thumb is $nexthumb<BR></BODY></HTML>";
}

sub massadd
{
	print "Content-type: text/html\n\n";
	print "<HTML>Mass ADD, Choose a file from the <B>uploads</B> directory<BR><BR>";
	print <<"EOF";
<SCRIPT>
function goOnResponse(message,location) {
	if (confirm(message)==1) { document.location.href=location; }
}
</SCRIPT>
EOF
	;
	opendir(D,"../uploads");
	while (defined($file = readdir(D))) {
		next if ($file =~ /^\./);
		$file = &encode($file);
		print <<"EOF";
<a href="#" onClick="goOnResponse('Are you sure you wish to import all galleries in this file?','$ENV{'SCRIPT_NAME'}?p=massadd_save&fileName=$file');">Read $file</a><BR>
EOF
		;
	}
	closedir(D);
}

sub massadd_save
{
	print "Content-type: text/html\n\n";
	open(D,"../uploads/$FORM{'fileName'}");
	@lines = <D>;
	close(D);
	$count=0;
	foreach (@lines) {
		s/^\s+//;
		s/\s+$//;
		$_ =~ s/(((http|https):\/\/|www)[a-z0-9\-\._]+\/?[a-z0-9_\.\-\?\+\/~=&;,]*[a-z0-9\?\/]{1})/
				my $gall = $1;
				my $sql = &querydb($connect,"SELECT COUNT(*) FROM thumbs WHERE galleryURL='$gall';");
				@row = $sql->fetchrow;
				$already=@row[0];
				$sql->finish;
				my $sql = &querydb($connect,"SELECT COUNT(*) FROM badthumbs WHERE galleryURL='$gall';");
				@row = $sql->fetchrow;
				$bad=@row[0];
				$sql->finish;
				if (($already==0)&&($bad==0)) {
					my $sql = &querydb($connect,"INSERT INTO thumbs (galleryURL,active) VALUES ('$gall',0);");
					$count++;
					$sql->finish;
				}
		/egix;
	}
	print <<"EOF";
<META HTTP-EQUIV="refresh" CONTENT="2;URL=admin.cgi?p=gallerys">
$count Gallery[s] were added to the db.
EOF
	;
}

sub gallerys_edit
{
	my $sql = &querydb($connect,"SELECT * FROM thumbs WHERE thumbID='$FORM{'thumbID'}';");
	my %FIELDS = &returnFieldNames($sql);
	my @row = $sql->fetchrow;
	$sql->finish;

	print "Content-type: text/html\n\n";

	my $sql2 = &querydb($connect,"SELECT * FROM cats");
	my %FIELDS2 = &returnFieldNames($sql2);
	while (my @row2 = $sql2->fetchrow) {
		if (@row2[0] == @row[$FIELDS{'categoryID'}]) {
			push(@cats,"<OPTION value=\"@row2[0]\" SELECTED>@row2[$FIELDS2{'catName'}]</OPTION>\n");
		} else {
			push(@cats,"<OPTION value=\"@row2[0]\">@row2[$FIELDS2{'catName'}]</OPTION>\n");
		}
		$CATNAME{@row2[0]} = @row2[$FIELDS2{'catName'}];
	}
	$sql2->finish;
	&form;
	&hidden("thumbID","$FORM{'thumbID'}");
	&actiontable("New Gallery[s]","Field","Details");
	&hidden("p","gallerys_save");
	&htextbox("URL","galleryURL",@row[$FIELDS{'galleryURL'}],10,60);
	&htext("ThumbNail","fileName",@row[$FIELDS{'fileName'}]);
	&hidden("start","$FORM{'start'}");
	&hidden("sortby","$FORM{'sortby'}");
	&hsubmit("Add &gt;");
	&eform;
	&etable;
}

sub gallerys_save
{
	my $sql = &querydb($connect,"UPDATE thumbs Set fileName='$FORM{'fileName'}',galleryURL='$FORM{'galleryURL'}' WHERE thumbID='$FORM{'thumbID'}';");
	$sql->finish;
	&go2("p=gallerys&start=$FORM{'start'}&sortby=$FORM{'sortby'}");
}

sub gallerys_new
{
	@gallerys = split(/,/,$FORM{'galleryURL'});
	$id = time();
	my $sql = &querydb($connect,"SELECT * FROM thumbs");
	my %FIELDS = &returnFieldNames($sql);
	while (my @row = $sql->fetchrow) {
		$EXISTS{@row[$FIELDS{'galleryURL'}]} = 1;
	}
	$sql->finish;
	$written = 0;
	foreach (@gallerys) {
		chomp $_;
		if ($EXISTS{$_}!=1) {
			my $sql = &querydb($connect,"INSERT INTO thumbs (galleryURL,dateAdded,categoryID) VALUES ('$_','$FORM{'id'}','$FORM{'categoryID'}');");
			$insertid = $sql->{mysql_insertid};
			$sql->finish;
			$written++;
		}
	}

	if ($written >0) {
		$encurl = &encode($FORM{'galleryURL'});
		print "Location: getthumb.cgi?url=$encurl&thumbID=$insertid&thumbQuality=$ss{'thumbQuality'}&thumbWidth=$ss{'thumbWidth'}&thumbHeight=$ss{'thumbHeight'}&start=$FORM{'start'}&sortby=$FORM{'sortby'}&thumbQuality2=$ss{'thumbQuality2'}&thumbWidth2=$ss{'thumbWidth2'}&thumbHeight2=$ss{'thumbHeight2'}&thumbQuality3=$ss{'thumbQuality3'}&thumbWidth3=$ss{'thumbWidth3'}&thumbHeight3=$ss{'thumbHeight3'}\n\n";
	} else {
		print "Location: admin.cgi?p=gallerys&start=$FORM{'start'}&sortby=$FORM{'sortby'}\n\n";
	}
}

sub gallerys_delete
{
	my $sql = &querydb($connect,"DELETE FROM thumbs WHERE thumbID='$FORM{'thumbID'}';");
	$sql->finish;
	## delete the gallery's thumbs
	if (-e "$ss{'thumbsDirectory'}/sthumb$FORM{'thumbID'}.jpg") {
		unlink("$ss{'thumbsDirectory'}/sthumb$FORM{'thumbID'}.jpg");
	}
	if (-e "$ss{'thumbsDirectory'}/sthumb$FORM{'thumbID'}.jpg.jpg") {
		unlink("$ss{'thumbsDirectory'}/sthumb$FORM{'thumbID'}.jpg.jpg");
	}
	if (-e "$ss{'thumbsDirectory'}/3-sthumb$FORM{'thumbID'}.jpg") {
		unlink("$ss{'thumbsDirectory'}/sthumb$FORM{'thumbID'}.jpg.jpg.jpg");
	}
	&go2("p=gallerys&start=$FORM{'start'}&sortby=$FORM{'sortby'}");
}

##### EXPORT DATA #######

sub importdata
{
	print "Content-type: text/html\n\n";
	print <<"EOF";
<SCRIPT>
function goOnResponse(message,location) {
	if (confirm(message)==1) { document.location.href=location; }
}
</SCRIPT>
EOF
	;
	opendir(D,"../backup");
	while (defined($file = readdir(D))) {
		next if ($file =~ /^\./);
		($good,$crap) = $file =~ m/(.*)\.(.*)/;
		$when = localtime($file);
		$display = ($when->mon+1) . "-" . ($when->mday) . "-" . ($when->year+1900);
		print <<"EOF";
[<a href="#" onClick="goOnResponse('Are you sure you wish to delete $display's backup?','$ENV{'SCRIPT_NAME'}?p=importdata_delete&fileName=$file');">Delete</a>] <a href="$ENV{'SCRIPT_NAME'}?p=importdata_import&fileName=$file">Import $display</a><BR>
EOF
		;
	}
	closedir(D);
}

sub importdata_import
{
	## find the file and read it .....and process it ;)
	open(D,"../backup/$FORM{'fileName'}");
	@lines = <D>;
	close(D);
	foreach (@lines) {
		chomp $_;
		next if ($_ eq "");
		my $sql = &querydb($connect,"$_");
		$sql->finish;
	}	
	&go2("");
}

sub exportdata
{
	$id=time();
	go2("p=exportdata_save&fileName=$id.txt");
}

sub importdata_delete
{
	unlink("../backup/$FORM{'fileName'}");
	go2("p=importdata");
}

sub exportdata_save
{
	$table = "thumbs";
	open(INPUT,">../backup/$FORM{'fileName'}");	
	## write the drop table for this table ;)
	print INPUT "delete from $table;\n";	
	my $sql = &querydb($connect,"SELECT * FROM $table");
	my %FIELDS = &returnFieldNames($sql);
	while (my @row = $sql->fetchrow) {
		$statement ="INSERT INTO $table (";
		foreach (keys %FIELDS) {
			$statement .= "$_,";
		}
		$statement = substr($statement,0,length($statement)-1);
		$statement .= ") VALUES (";
		foreach (keys %FIELDS) {
			$statement .= "'@row[$FIELDS{$_}]',";
		}
		$statement = substr($statement,0,length($statement)-1);
		$statement .= ");";
		print INPUT "$statement\n";
	}
	$sql->finish;
	close(INPUT);
	chmod(0777,"../backup/$FORM{'fileName'}");
	print "Content-type: text/html\n\n";
	print "back up to $FORM{'fileName'} sucessful.<BR>";
}

##### CATEGORY STUFF ####

sub cats
{
	print "Content-type: text/html\n\n";

	&actiontable("New Category","Field","Details");
	&form;
	&hidden("p","cats_new");
	&htext("Category Name","catName");
	&hsubmit("Add New Cat &gt;");
	&eform;
	&etable;

	print "<BR>";

	&actiontable("Categories","Action","Name");

	my $sql = &querydb($connect,"SELECT * FROM cats");
	my %FIELDS = &returnFieldNames($sql);
	while (my @row = $sql->fetchrow)
	{
		$action = <<"EOF";
[<a href="$ENV{'SCRIPT_NAME'}?p=cats_del&catID=@row[0]">Delete</a>]
EOF
		;
		print &tableline($action,@row[$FIELDS{'catName'}]);
	}
	$sql->finish;

	&etable;
}

sub cats_del
{
	my $sql = &querydb($connect,"DELETE FROM cats WHERE catID='$FORM{'catID'}';");
	$sql->finish;

	&go2("p=cats");
}

sub cats_new
{
	my $sql = &querydb($connect,"INSERT INTO cats (catName) VALUES ('$FORM{'catName'}');");
	$sql->finish;

	&go2("p=cats");
}


##### UTILTY STUFF ######

sub dbconnect
{
	my $where = "DBI:mysql:$dbname:$dbhost";
	my $connection = DBI->connect($where,$dbusername,$dbpassword);
	return $connection;
}

sub go2
{
	($where) = shift;
	print <<"EOF";
Content-type: text/html\n\n


<HTML>
<HEAD>
<META HTTP-EQUIV="refresh" CONTENT="0;URL=$ENV{'SCRIPT_NAME'}?$where">
</HEAD>
</HTML>
EOF
	;
}

sub tableline
{
	@stuff = (@_);

	my $what;

	$what = <<"EOF";
<tr>
EOF
	;

	foreach (@stuff)
	{
		chomp $_;
		$what .= <<"EOF";
	<td><div align=center>$_</div></td>
EOF
		;
	}

	$what .= <<"EOF";
</tr>
EOF
	;

	return $what;
}

sub querydb
{
	my $connection = shift;
	my $sql=shift;
	my $sqlquery = $connection->prepare($sql);
	$sqlquery->execute;
	return $sqlquery;
}

sub fieldnames
{
	my $sqlquery =shift;
	@fields = @{$sqlquery->{NAME}};
	return @fields;
}

sub returnFieldNames
{
	my $sqlquery = shift;
	@fieldnames = &fieldnames($sqlquery);$a=0;
	my %FIELDS;
	foreach (@fieldnames)
	{$FIELDS{$_} = $a;$a++; }
	return %FIELDS;
}

sub disconnect
{
	my $connect = shift;
	$connect->disconnect;
}




sub actiontable
{
	(@stuff) = (@_);

	my $showstuff;
	foreach (@stuff)
	{
		next if ($_ eq @stuff[0]);
		$showstuff .=<<"EOF";
<td><div align=center><B>$_</B></div></td>
EOF
		;
	}

	print <<"EOF";
<table border=1 bordercolor=black cellpadding=3>
<th colspan=$#stuff><font size=-1>@stuff[0]</font></th>
<tr bgcolor="#CCCCFF">
$showstuff
</tr>
EOF
	;
}

sub infotable
{
	(@stuff) = (@_);

	my $showstuff;
	foreach (@stuff)
	{
		next if ($_ eq @stuff[0]);
		$showstuff .=<<"EOF";
<td><div align=center><B>$_</B></div></td>
EOF
		;
	}

	print <<"EOF";
<table border=1 bordercolor=black cellpadding=3>
<th colspan=$#stuff><div align=center><font size=-1>@stuff[0]</font></div></th>
<tr bgcolor="#0099FF">
$showstuff
</tr>
EOF
	;
}

sub etable
{
	print "</table>\n";
}

sub eform
{
	print "</form>\n";
}

sub hsubmit
{
	($value) = (@_);

	print <<"EOF";
<tr>
	<td colspan=2><input type="submit" style="font-family: Arial, Helvetica, sans-serif;font-size: 10px;" value="$value"></td>
</tr>
EOF
	;
}

sub form
{
	print "<form action=\"$ENV{'SCRIPT_NAME'}\" method=\"POST\">\n";
}

sub getquery
	{
		if ($ENV{'REQUEST_METHOD'} eq "GET") 
		{ 
			$querystring = $ENV{'QUERY_STRING'};
		}
		else 
		{ 
			read(STDIN, $querystring, $ENV{'CONTENT_LENGTH'}); 
		}

		@pairs = split(/&/, $querystring);

		foreach $pair (@pairs) 
		{
		 ($name, $value) = split(/=/, $pair);
		 $value =~ tr/+/ /;
		 $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
		 $name =~ tr/+/ /;
		 $name =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
		 $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
		 $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
		 $value =~ s/'/\\'/g;
		 if (exists($FORM{$name})) { $FORM{$name} = $FORM{$name} . "," . $value; } else { $FORM{$name} = $value; }
		 $EFORM{$name} = &encode($value);
		 $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
		 $UFORM{$name} = $value;
		}
	}
sub encode {
        my($toencode) = @_;
        $toencode=~s/([^a-zA-Z0-9_\-.])/uc sprintf("%%%02x",ord($1))/eg;
        return $toencode;
}
sub hidden
{
	($name,$value) = (@_);

	print <<"EOF";
<input type="hidden" name="$name" value="$value">
EOF
	;
}

sub hhtml
{
	($description,$html,$note) = (@_);

	print <<"EOF";
<tr>
	<td valign=top>
		$description
	</td>
	<td>
		$html</td>
</tr>
<tr>
	<td colspan=2>
		<font color=blue>$note</font>
	</td>
</tr>
EOF
	;
}

sub htextbox
{
	($description,$name,$value,$rows,$cols,$note) = (@_);

	print <<"EOF";
<tr>
	<td valign=top>$description</td>
	<td valign=top><TEXTAREA name="$name" rows="$rows" cols="$cols">$value</TEXTAREA></td>
EOF
	;
	if ($note ne "")
	{
		print <<"EOF";
<tr>
	<td colspan=2><font color=blue>$note</font></td>
</tr>
EOF
		;
	}
}

sub table
{
	print "<table border=0>\n";
}

sub htext
{
	($description,$name,$value,$note) = (@_);
		print <<"EOF";
<tr>
<td>
$description
</td>
<td valign=top>
<input type="text" name="$name" size="30" value="$value">
</td>
<tr>
	<td colspan=2><font color=blue>$note</font></td>
</tr>
EOF
		;

}

sub get_domain
{
	my $address = shift;
	if ($address !~ /noref/)
	{
		##remove trailing /
		if (substr($address,0,7) eq lc("http://"))
		{ $address = substr($address,7,length($address)); }
		my (@stuff) = split(/\//,$address);

		##remove the www.
		@parts = split(/\./,@stuff[0]);
		if ($#parts == 2)
		{ 
			$new = @parts[1] . '.' . @parts[2];
		}
		else
		{
			$new = @parts[0] . '.' . @parts[1];	
		}
	}
	else
	{
		$new = $address;
	}
	return($new);
}