#!/usr/bin/perl

######################################################################
#                       X-treme TGP v1.0
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
@months =('Jan.','Feb.','March','Apr.','May','June','July','Aug.','Sept.','Oct.','Nov.','Dec');

$time = time;
$reset_offset = $reset_offset * 3600;
$time = $time + $reset_offset;
($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = localtime($time);
$mon++;
$year += 1900;
$now = "$mon.$mday.$year";
$sunday = $yday - $wday;
$weekly="weekly.txt";



$data_file="weekly.txt";
open(DAT, "<$path/$data_file") || die("Could not open file!");
@raw_data=<DAT>;
close(DAT);  
foreach $main (@raw_data)
{
 chop($main);
 ($m1_img,$m1_down,$m2_img,$m2_down,$now)=split(/\|/,$main);
}



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
        <div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>About 
          the Weekly Movies</b></font></div>
      </td>
    </tr>
    <tr> 
      <td bgcolor="#6699CC"><font size="2" face="Arial, Helvetica, sans-serif" color="#000000">With 
        this part of X-Treme you can specify the weekly movies for your TGP<br>
        This feature saves you a lot of time, as you don't have to manually edit<br>
        the template files, (you could if you wished though) and can update movies 
        very quickly, if links go down!</font></td>
    </tr>
  </table>
  <br>
  <table width="86%" cellspacing="1" cellpadding="1" bgcolor="#000000">
    <tr>
      <td bgcolor="#000000" height="7">
        <div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>You 
          Last updated Your Movies On</b></font></div>
      </td>
    </tr>
    <tr> 
      <td bgcolor="#6699CC" height="7"> 
        <div align="center"><font size="2" face="Verdana, Arial, Helvetica,
sans-serif" color="#FFFFFF"><b><font color="#000000"> $now</font></b></font></div>
      </td>
    </tr>
  </table>
  <form name="form1" method="post" action="xtreme_weekly2.cgi">
    <table width="86%" cellspacing="1" cellpadding="1" bgcolor="#000000">
      <tr bgcolor="#000000"> 
        <td width="41%"><b><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif">NAME</font></b></td>
        <td width="59%"><b><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif">URL</font></b></td>
      </tr>
      <tr bgcolor="#6699CC"> 
        <td width="41%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000000">Movie 
          #1 Image Url</font></td>
        <td width="59%"> <font color="#000000" face="Verdana, Arial, Helvetica, sans-serif" size="2"> 
          <input type="text" size="33" value="$m1_img" name="m1_img">
          </font></td>
      </tr>
      <tr bgcolor="#6699CC"> 
        <td width="41%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000000">Movie 
          #1 Download Url</font></td>
        <td width="59%"> <font color="#000000" face="Verdana, Arial, Helvetica, sans-serif" size="2"> 
          <input type="text" name="m1_down" size="33" value="$m1_down">
          </font></td>
      </tr>
      <tr bgcolor="#6699CC"> 
        <td width="41%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000000">Movie 
          #2 Image Url</font></td>
        <td width="59%"> <font color="#000000" face="Verdana, Arial, Helvetica, sans-serif" size="2"> 
          <input type="text" name="m2_img" size="33" value="$m2_img">
          </font></td>
      </tr>
      <tr bgcolor="#6699CC"> 
        <td width="41%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000000">Movie 
          #2 Download Url</font></td>
        <td width="59%"> <font color="#000000" face="Verdana, Arial, Helvetica, sans-serif" size="2"> 
          <input type="text" name="m2_down" size="33" value="$m2_down">
          </font></td>
      </tr>
      <tr bgcolor="#000000"> 
        <td colspan="2"> 
          <div align="center"> <font color="#FFFFFF" face="Verdana, Arial, Helvetica, sans-serif" size="2"> 
            <input type="hidden" name="check" value="1">
            <input type="submit" name="Submit" value="Save Changes &gt;&gt;">
            </font></div>
        </td>
      </tr>
    </table>
  </form>
  <font size="2" face="Verdana, Arial, Helvetica,
sans-serif"><font color="#000000"></font></font> </div>
</body>
</html>





HTML2

}

&main;




