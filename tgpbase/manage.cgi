#!/usr/bin/perl

use Cwd;
use CGI qw(:standard);

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
 if (exists $FORM{$name})
 { $FORM{$name} = $FORM{$name} . "," . $value; }
 else
 { $FORM{$name} = $value; }
}

open(D,"vars.cgi");
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
	  my ($var,$value) = split(/\s*=\s*/, $_, 2);
	  $var_name = $var;
	  $var_value = $value;
	  eval '$$var_name = $var_value;';	  
}
close(D);

##make the urllocation
@parts = split(/manage\.cgi/,$ENV{'SCRIPT_NAME'});
$urllocation = @parts[0];



if ($FORM{'p'} eq "") { &showmain;exit; }
if ($FORM{'p'} eq "home") { &showmain; exit; }
if ($FORM{'p'} eq "update") { &showupdate;exit; }
if ($FORM{'p'} eq "deleteurl") { &deleteurl;exit; }
if ($FORM{'p'} eq "deletecat") { &deletecat;exit; }
if ($FORM{'p'} eq "newcat" ) { &newcat;exit; }
if ($FORM{'p'} eq "newurl" ) { &newurl;exit; }
if ($FORM{'p'} eq "addfromtxt" ) { &addfromtxt;exit; }
if ($FORM{'p'} eq "updateoptions") { &updateoptions; exit; }
if ($FORM{'p'} eq "showcats" ) { &catspage;exit; }
if ($FORM{'p'} eq "showoptions" ) { &showoptions;exit; }
if ($FORM{'p'} eq "editgallery") { &editgallery;exit; }
if ($FORM{'p'} eq "updategallery") { &updategallery;exit; }
if ($FORM{'p'} eq "editcat") { &editcat;exit; }
if ($FORM{'p'} eq "updatecat") { &updatecat;exit; }

sub updateoptions
{
	## work out the path for the current file....
	open(DATA,"vars.cgi"); #or print "opening old failed: $! <BR>";
	open(NEW,">vars.new"); #or print "opening new failed: $! <BR>";
	while (<DATA>)
	{
		chomp $_;
		$orig = $_;
		$_ =~ tr/ //;
		($name,$value) = split (/=/,$_);
		if ($_ ne "")
		{
			if ($name =~ /\$bad/)
			{
				print NEW "\$bad=\"$FORM{'bad'}\";\n";
			}	
			else
			{
				print NEW "$orig\n";
			}
		}
		
	}
	close(DATA);	
	close(NEW);
	rename("vars.new","vars.cgi");

	$location = "Location: http://$ENV{'HTTP_HOST'}$ENV{'SCRIPT_NAME'}\n\n";
	print $location;

}

sub showmain
{

	open(D,"cats.txt");
	@data = <D>;
	close(D);

	foreach (@data)
	{
		chomp $_;
		push(@cats,"<option value=$_>$_</option>\n");
	}

	print "Content-type: text/html\n\n";

	if ($FORM{'a'} eq "" ) { $FORM{'a'} = 25; }
	if ($FORM{'s'} eq "" ) { $FORM{'s'} = 0; }
	if ($FORM{'e'} eq "" ) { $FORM{'e'} = $FORM{'s'}+$FORM{'a'}; }

	open(D,"hahadatabase.txt");
	@data = <D>;
	close(D);

	open(D,"cats.txt");
	@catsdata = <D>;
	close(D);


	push(@showbycats,"Show by: ");
	push(@showbycats,"<a href=\"$ENV{'SCRIPT_NAME'}?s=0&e=$FORM{'a'}&a=25&c\">All</a>&nbsp;");

	foreach (@catsdata)
	{
		chomp $_; push(@showbycats,"<a href=\"$ENV{'SCRIPT_NAME'}?s=0&e=$FORM{'a'}&c=$_&a=$FORM{'a'}\">$_</a>&nbsp;");
	}

	push(@showbycats,"<BR>Gallerys Per Page: <a href=\"$ENV{'SCRIPT_NAME'}?a=10&s=0\">10</a>&nbsp;");
	push(@showbycats,"<a href=\"$ENV{'SCRIPT_NAME'}?a=25&s=0\">25</a>&nbsp;");
	push(@showbycats,"<a href=\"$ENV{'SCRIPT_NAME'}?a=50&s=0\">50</a>&nbsp;");
	push(@showbycats,"<a href=\"$ENV{'SCRIPT_NAME'}?a=75&s=0\">75</a>&nbsp;");
	push(@showbycats,"<a href=\"$ENV{'SCRIPT_NAME'}?a=100&s=0\">100</a>&nbsp;");
	push(@showbycats,"<a href=\"$ENV{'SCRIPT_NAME'}?a=150&s=0\">150</a>&nbsp;");
	push(@showbycats,"<a href=\"$ENV{'SCRIPT_NAME'}?a=250&s=0\">250</a>&nbsp;");
	push(@showbycats,"<a href=\"$ENV{'SCRIPT_NAME'}?a=500&s=0\">500</a>&nbsp;");
	push(@showbycats,"<a href=\"$ENV{'SCRIPT_NAME'}?a=500&s=0\">750</a>&nbsp;");
	push(@showbycats,"<a href=\"$ENV{'SCRIPT_NAME'}?a=1000&s=0\">1000</a>&nbsp;");

	$tabledata .= "<BR>@showbycats<BR>\n";
	$tabledata .= "<BR><table cellspacing=0 border=1 cellpadding=5><tr><td><B>Action</td><td><B>ID</td><td><B>URL</td><td><B>Category</td></tr>\n";

	$a = 0;

	$start = $FORM{'s'};
	$end = $FORM{'e'};
	$amount = $#data +1;
	$amountincat=0;

	foreach (@data)
	{
		chomp $_;
		($code,$url,$category) = split(/\|/,$_);
		$a++;
		if ($FORM{'c'} ne "")
		{
			if ($FORM{'c'} eq $category)
			{
				$amountincat++;
				if ( ($amountincat > $start) && ($amountintcat < $end) )
				{
					$urlenc = &encode($url);
					$catenc = &encode($category);
					$tabledata .= "<tr><td><a href=\"g.cgi?$code\" target=_blank>View</a>&nbsp;&nbsp;<a href=\"$ENV{'SCRIPT_NAME'}?p=editgallery&code=$code&a=$FORM{'a'}&s=$FORM{'s'}&e=$FORM{'e'}&c=$FORM{'c'}&cat=$catenc&url=$urlenc\">Edit</a>&nbsp;&nbsp;<a href=\"javascript:deletegallery('$code');\">Del</a></td><td>$code</td><td><a href=\"$url\" target=_blank>$url</a></td><td><a href=\"g.cgi?$category\" target=_blank>$category</a></td></tr>\n";

				}
			}		
		}
		else
		{
				$amountincat++;
				if ( ($amountincat > $start) && ($amountincat <= $end) )
				{
					$urlenc = &encode($url);
					$catenc = &encode($category);
					$tabledata .= "<tr><td><a href=\"g.cgi?$code\" target=_blank>View</a>&nbsp;&nbsp;<a href=\"$ENV{'SCRIPT_NAME'}?p=editgallery&code=$code&a=$FORM{'a'}&s=$FORM{'s'}&e=$FORM{'e'}&c=$FORM{'c'}&cat=$catenc&url=$urlenc\">Edit</a>&nbsp;&nbsp;<a href=\"javascript:deletegallery('$code');\">Del</a></td><td>$code</td><td><a href=\"$url\" target=_blank>$url</a></td><td><a href=\"g.cgi?$category\" target=_blank>$category</a></td></tr>\n";
					$listed++;
				}
		}

	}
	$tabledata .= "</table>\n";

	if ($amountincat > $end)
	{
		$nend = $end+$FORM{'a'};
		$nextpage = "<A href=\"$ENV{'SCRIPT_NAME'}?s=$end&e=$nend&cat=$FORM{'c'}&a=$FORM{'a'}\">next</a>";
	}

	if ($start > 0)
	{
		$nstart = $start-$FORM{'a'};
		$nend = $end-$FORM{'a'};
		$prevpage = "<A href=\"$ENV{'SCRIPT_NAME'}?s=$nstart&e=$nend&c=$FORM{'c'}&a=$FORM{'a'}\">prev</a>";
	
	}

	my(@bb);
	open(BB,"main.htm");
	@bb=<BB>;
	$"="";
	eval("print <<\"BLOCK\" \n@bb\n\BLOCK\n\n");
	$"=" ";
	close(BB); 
	
}

sub encode {
        my($toencode) = @_;
        $toencode=~s/([^a-zA-Z0-9_\-.])/uc sprintf("%%%02x",ord($1))/eg;
        return $toencode;
}

sub editgallery
{

	open(D,"cats.txt");
	@catdata = <D>;
	close(D);

	foreach (@catdata)
	{
		chomp $_;
		if ($FORM{'cat'} eq $_)
		{   push(@cats,"<option value=$_ selected>$_</option>\n"); }
		else
		{	push(@cats,"<option value=$_>$_</option>\n"); }
	}

	print "Content-type: text/html\n\n";

	my(@bb);
	open(BB,"edit.htm");
	@bb=<BB>;
	$"="";
	eval("print <<\"BLOCK\" \n@bb\n\BLOCK\n\n");
	$"=" ";
	close(BB); 

}

sub updategallery
{
	open(D,"hahadatabase.txt");
	@data = <D>;
	close(D);

	open(D,">hahadatabase.txt");
	flock(D,2);
	foreach (@data)
	{
		chomp $_;
		($code,$url,$category) = split(/\|/,$_);
		if ($code eq $FORM{'code'})
		{
			print D "$code|$FORM{'url'}|$FORM{'category'}\n";		
		}
		else
		{
			print D "$_\n";
		}

	}
	close(D);

	$location = "Location: http://$ENV{'HTTP_HOST'}$ENV{'SCRIPT_NAME'}?s=$FORM{'s'}&e=$FORM{'e'}&a=$FORM{'a'}&c=$FORM{'c'}\n\n";
	print $location;

}

sub editcat
{

	print "Content-type: text/html\n\n";
	my(@bb);
	open(BB,"editcat.htm");
	@bb=<BB>;
	$"="";
	eval("print <<\"BLOCK\" \n@bb\n\BLOCK\n\n");
	$"=" ";
	close(BB); 
}

sub updatecat
{

	open(D,"cats.txt");
	@current = <D>;
	close(D);

	open(D,">cats.txt");
	flock(D,2);
	foreach (@current)
	{
		chomp $_;
		if ($_ eq $FORM{'code'})
		{
		    print D "$FORM{'cat'}\n";
		}
		else
		{
			print D "$_\n";
		}
	}
	close(D);

	## find all of the galleries affected by this change
	open(D,"hahadatabase.txt");
	@gallerydata = <D>;
	close(D);

	open(D,">hahadatabase.txt");
	flock(D,2);
	foreach (@gallerydata)
	{	
		chomp $_;
		($code,$url,$category) = split(/\|/,$_);
		if ($category eq $FORM{'code'})
		{
			print D "$code|$url|$FORM{'cat'}\n";		
		}	
		else
		{
			print D "$_\n";
		}
	}
	close(D);
	
	$location = "Location: http://$ENV{'HTTP_HOST'}$ENV{'SCRIPT_NAME'}?p=showcats\n\n";
	print $location;

}

sub catspage
{
	open(D,"cats.txt");
	@data = <D>;
	close(D);

	$catdata .= "<table cellspacing=0 border=1 cellpadding=5><tr><td><B>Action</td><td><B>Category</td></tr>\n";
	foreach (@data)
	{
		chomp $_;
		$catenc = &encode($_);
		$catdata .= "<tr><td><a href=\"g.cgi?$_\" target=_blank>View</a>&nbsp;&nbsp;<a href=\"$ENV{'SCRIPT_NAME'}?p=editcat&cat=$catenc\">Edit</a>";
		$catdata .= "&nbsp;&nbsp;<a href=\"javascript:deletecat('$catenc');\">Del Cat Only</a>&nbsp;&nbsp;<a href=\"javascript:deleteall('$catenc');\">Delete Full</a></td><td>$_</td></td></tr>\n";
	}
	$catdata .= "</table>\n";

	open(D,"cats.txt");
	@catdata = <D>;
	close(D);

	foreach (@catdata)
	{
		chomp $_;
		push(@cats,"<option value=$_>$_</option>\n");
	}

	print "Content-type: text/html\n\n";
	my(@bb);
	open(BB,"cats.htm");
	@bb=<BB>;
	$"="";
	eval("print <<\"BLOCK\" \n@bb\n\BLOCK\n\n");
	$"=" ";
	close(BB); 
}

sub showoptions
{

	print "Content-type: text/html\n\n";
	my(@bb);
	open(BB,"options.htm");
	@bb=<BB>;
	$"="";
	eval("print <<\"BLOCK\" \n@bb\n\BLOCK\n\n");
	$"=" ";
	close(BB); 

}

sub newcat
{
	open(D,"cats.txt");
	while (<D>)
	{
		chomp $_;
		$EXIST{$_} = 1;
	}
	close(D);

	$category = $FORM{'name'};
	$category =~ s/^\s+//;
	$category =~ s/\s+$//;
	$category =~ s/\s+//g;

	if (($FORM{'name'} =~ / /) || ($FORM{'name'} =~ /\+/) )
	{
		print "Content-type: text/html\n\n";
		print "Category has spaces in it, OR characters which are not letters or numbers, spaces are not allow in category names.<BR>";	
		exit;
	}

	if ($EXIST{$FORM{'name'}} == 1)
	{
		print "Content-type: text/html\n\n";
		print "Category already exists in the database.<BR>";
	}
	else
	{
		open(D,"+>>cats.txt");
		flock(D,2);
		print D "$FORM{'name'}\n";
		close(D);
		$location = "Location: http://$ENV{'HTTP_HOST'}$ENV{'SCRIPT_NAME'}?p=showcats\n\n";
		print $location;
	}

}

sub newurl
{

	$lastnum=0;

	## get the gallerys to be added :D
	@gallerys = split(/,/,$FORM{'urls'});
	
	open(D,"hahadatabase.txt");
	while (<D>)
	{
		chomp $_;
		($code,$url) = split(/\|/,$_);
		$lastnum = $code;
	}
	close(D);

	
	open(D,"+>>hahadatabase.txt");
	flock(D,2);
	foreach (@gallerys) 
	{
		chomp $_;
		s/^\s+//;
		s/\s+$//;
		next unless length;
		$lastnum++;
		print D "$lastnum|$_|$FORM{'category'}\n";
	}

	close(D);
	$location = "Location: http://$ENV{'HTTP_HOST'}$ENV{'SCRIPT_NAME'}?a=$FORM{'a'}&s=$FORM{'s'}&e=$FORM{'e'}&c=$FORM{'c'}\n\n";
	print $location;
}

sub addfromtxt
{

	$number=0;

	if (-e $FORM{'filename'})
	{
		open(D,"hahadatabase.txt");
		while (<D>)
		{
			chomp $_;
			$number++;
		}
		close(D);

		open(D,"$FORM{'filename'}");
		@urls = <D>;
		close(D);

		open(D,"+>>hahadatabase.txt");
		flock(D,2);
		foreach (@urls) {
			chomp $_;
			($url,$category) = split(/\|/,$_);
			$number++;
			print D "$number|$url|$category\n";
		}
		close(D);

		$location = "Location: http://$ENV{'HTTP_HOST'}$ENV{'SCRIPT_NAME'}?\n\n";
		print $location;
	}
	else
	{
		print "Content-type: text/html\n\n";
		print "Filename not found.<BR>";

	}
}

sub deleteurl
{
	open(D,"hahadatabase.txt");
	@current = <D>;
	close(D);

	open(D,">hahadatabase.txt");
	flock(D,2);
	foreach (@current)
	{
		chomp $_;
		($code,$url,$category) = split(/\|/,$_);
		if ($code == $FORM{'code'})
		{
		
		}
		else
		{
			print D "$_\n";
		}
	}
	close(D);
	$location = "Location: http://$ENV{'HTTP_HOST'}$ENV{'SCRIPT_NAME'}?a=$FORM{'a'}&s=$FORM{'s'}&e=$FORM{'e'}&c=$FORM{'c'}\n\n";
	print $location;
}

sub deletecat
{

	open(D,"cats.txt");
	@current = <D>;
	close(D);

	open(D,">cats.txt");
	flock(D,2);
	foreach (@current)
	{
		chomp $_;
		if ($_ eq $FORM{'code'})
		{
		
		}
		else
		{
			print D "$_\n";
		}
	}
	close(D);

	if ($FORM{'all'} == 1)
	{
		open(D,"hahadatabase.txt");
		@gallerydata = <D>;
		close(D);

		open(D,">hahadatabase.txt");
		flock(D,2);
		foreach (@gallerydata)
		{	
			chomp $_;
			($code,$url,$category) = split(/\|/,$_);
			if ($category eq $FORM{'code'})
			{

			}	
			else
			{
				print D "$_\n";
			}
		}
		close(D);
	}


	$location = "Location: http://$ENV{'HTTP_HOST'}$ENV{'SCRIPT_NAME'}?p=showcats\n\n";
	print $location;
}
