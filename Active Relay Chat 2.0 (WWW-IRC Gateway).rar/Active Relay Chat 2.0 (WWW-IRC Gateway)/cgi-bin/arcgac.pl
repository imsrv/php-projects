#!/bin/perl
######################################################################
# Active Relay Chat 2.0 (WWW-IRC Gateway)                            #
#--------------------------------------------------------------------#
# Copyright 1999 Michael L. Sissine                                  #
# You can use this program only with one site                        #
# If you want to purchase unlimited license please contact us        #
# You cannot sell or redistribute this product                       #
# If you want to become our reseller please contact us               #
# http://spiderweb.hypermart.net/                                    #
# http://www.trxx.co.uk/                                             #
# trxx@trxx.co.uk                                                    #
# trxx@usa.net                                                       #
# trxx@telebot.net                                                   #
######################################################################
# Variables Section                                                  #
######################################################################
# Reading CFG
open (F, "<arc.cfg");
@commands=<F>;
close (F);
foreach (@commands)
{
	eval $_;
}

######################################################################
# Main Section                                                       #
######################################################################
if ($ENV{CONTENT_LENGTH}>0){sysread(STDIN,$data,$ENV{CONTENT_LENGTH});}
else {($data=$ENV{QUERY_STRING});}
@data=split("&",$data);
foreach (@data)
{
	/([^=]+)=(.*)/ && do
	{
		($field,$value)=($1,$2);
		$value=~s/\+/ /g;
		$value=~s/%([0-9a-fA-F]{2})/pack('C',hex($1))/eg;
		if ($data{$field}){$data{$field}="$data{$field},$value";}
		else {$data{$field}=$value;}
	}
}
open(F,"<$arcpath/bases/arc.chl");
@msg=<F>;
close(F);
@msg=reverse(@msg);
print "HTTP/1.0 200 Found\n" if ($sysid eq "Windows");
print "content-type: text/html\n\n";
print qq~
<html>
<head>
<title>Chat menu</title>
<base target="message">
</head>
<script language="JavaScript">
<!-- 
if(navigator.appVersion.substring(0, 1) >= 3) {

	kn4 = new Image;
	kn4.src = "$arcurl/images/k4.gif";
	kn4_H = new Image;
	kn4_H.src = "$arcurl/images/k4r.gif";

	kn5 = new Image;
	kn5.src = "$arcurl/images/k5.gif";
	kn5_H = new Image;
	kn5_H.src = "$arcurl/images/k5r.gif";

	kn6 = new Image;
	kn6.src = "$arcurl/images/k6.gif";
	kn6_H = new Image;
	kn6_H.src = "$arcurl/images/k6r.gif";

}

function PutImgHi(imgDocID, imgName)
{
if(navigator.appVersion.substring(0, 1) >= 3)
	{
	document.images[imgDocID].src = eval(imgName + "_H.src");
	}
}

function PutImg(imgDocID, imgName)
{
if(navigator.appVersion.substring(0, 1) >= 3) 
	{
	document.images[imgDocID].src = eval(imgName + ".src");
	}
}
// -->
</script>

<body bgcolor="#0D027B">
<a href="$cgi/arcactop.pl?username=$data{username}&channel=$data{channel}&method=clearmessage" onmouseover="PutImgHi('kn5','kn5'); return true;" onmouseout="PutImg('kn5','kn5'); return true;"><img src="$arcurl/images/k5.gif" border="0" name="kn5"></a><br>
<a href="$cgi/arcactop.pl?username=$data{username}&channel=$data{channel}&method=quit" onmouseover="PutImgHi('kn4','kn4'); return true;" onmouseout="PutImg('kn4','kn4'); return true;"><img src="$arcurl/images/k4.gif" border="0" name="kn4"></a><br>
<a href="$cgi/arcactop.pl?username=$data{username}&channel=$data{channel}&method=help" onmouseover="PutImgHi('kn6','kn6'); return true;" onmouseout="PutImg('kn6','kn6'); return true;"><img src="$arcurl/images/k6.gif" border="0" name="kn6"></a><br>
</form>
</body>
</html>
~;
