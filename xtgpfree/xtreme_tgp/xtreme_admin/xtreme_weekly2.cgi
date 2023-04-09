#!/usr/bin/perl

######################################################################
#                        X-treme TGP v1.0
#                        Created by Relic
#                     webmaster@cyphonic.net
#####################################################################
$path = "/home/darkforce/newraw";

#NOTHING BELOW THIS LINE NEEDS TO BE TOUCHED
###########################################################

$cnt = $ENV{'QUERY_STRING'};
read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
@pairs = split(/&/, $buffer);
foreach $pair (@pairs) {
        ($name, $value) = split(/=/, $pair);
        $value =~ tr/+/ /;
        $value =~ s/%([a-fA-F0-9][a-fA-F0-9])/pack("C", hex($1))/eg;
    $value =~ s/<([^>]|\n)*>//g;
        if ($INPUT{$name}) { $INPUT{$name} = $INPUT{$name}.",".$value; }
        else { $INPUT{$name} = $value; }
}  

print "Content-type:text/html\n\n";
@months
=('Jan.','Feb.','March','Apr.','May','June','July','Aug.','Sept.','Oct.','Nov.','Dec');

$time = time;
$reset_offset = $reset_offset * 3600;
$time = $time + $reset_offset;
($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime($time);
$mon++;
$year += 1900;
$now = "$mon.$mday.$year";
$sunday = $yday - $wday;
$weekly="weekly.txt";



$aproveme="weekly.txt";
open(DAT,">$path/$aproveme") || die("THERE WAS A FILE ERROR!");
print DAT "$INPUT{'m1_img'}|$INPUT{'m1_down'}|$INPUT{'m2_img'}|$INPUT{'m2_down'}|$now\n";  


sub main {



print <<HTML2;   

<html>
<head>
<title>Xtreme TGP v1.0</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#F1F1F1" text="#000000">
<div align="center">
  <table width="86%" cellspacing="1" cellpadding="1" bgcolor="#000000">
    <tr>
      <td bgcolor="#000000"> 
        <div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>STATUS</b></font></div>
      </td>
    </tr>
    <tr>
      <td bgcolor="#6699CC" height="2">
        <div align="center"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">The 
          weekly movies were updated and the changes will be viewable once the 
          list is re-built</font></div>
      </td>
    </tr>
  </table>
</div>
</body>
</html>






HTML2

}

&main;






