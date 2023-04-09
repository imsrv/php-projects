#!/usr/bin/perl
print "Content-type:text/html\n\n";
######################################################################
#                        X-treme TGP v1.0
#                        Created by Relic
#                     webmaster@cyphonic.net
#####################################################################


#Url to your TGP directory
$url = "http://www.18z.org/";

#Path to the TGP directory
$path = "/home/darkforce/newraw";

#NOTHING BELOW THIS LINE NEEDS TO BE TOUCHED
###########################################################
$cnt = 0;

$INPUT{'action'} = $ENV{'QUERY_STRING'};
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

if ($INPUT{'action'} eq "there") 
{ 
&there;
 }
elsif ($INPUT{'action'} eq "base") 
{ 
&base;
 }
elsif ($INPUT{'action'} eq "backupmain") 
{ 
&backupmain;
 }
elsif ($INPUT{'action'} eq "backup") 
{ 
&backup;
 }
elsif ($INPUT{'action'} eq "queue") 
{ 
&queue;
 }
elsif ($INPUT{'action'} eq "backupqueue") 
{ 
&backupqueue;
 }
elsif ($INPUT{'action'} eq "backupall") 
{ 
&backupall;
 }
elsif ($INPUT{'action'} eq "backupmovies") 
{ 
&backupmovies;
 }
elsif ($INPUT{'action'} eq "ban2") 
{ 
&ban2;
 }
elsif ($INPUT{'action'} eq "ban") 
{ 
&ban;
 }
else 
{
&whatever;
}





$update="update.txt";
open(DAT, "<$path/$update") || die("Could not open file!");
$last_updated=<DAT>;
close(DAT);  

sub whatever {
print <<whatever;

<b>This file cannot be called in this manner!</b>

whatever

}

sub queue {
$data="aprove.txt";
open(DAT, "<$path/$data") || die("Could not open file!");
@raw_data=<DAT>;
close(DAT);
$many = 0;
foreach $main (@raw_data)
{
$many = $many + 1;
}
print <<EndOfHTML;
<html>
<head>
<title>Xtreme TGP v1.0</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>


<div align="center">
  <table width="86%" cellspacing="1" cellpadding="1" bgcolor="#000000">
    <tr>
      <td bgcolor="#CCCCCC"> 
        <div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><font color="#000000">The 
          Queue </font></b></font></div>
      </td>
    </tr>
    <tr>
      <td bgcolor="#E7E7E7" height="36"><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">The 
        following sites have been submitted to your TGP but have not yet been 
        processed. We suggest you inspect each site for quality as well as content 
        before either approving the site or deleting it! Note: If you delete a 
        site it is gone! If you approve a site it will be added to your tgp, when 
        you update the list.</font></td>
    </tr>
  </table>
 <br>
  <font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><font color="#000000">There 
  are currently <font color="#FF0000">$many <font color="#000000">sites in the queue</font></font></font></b></font></div>



EndOfHTML
$data_file="aprove.txt";
open(DAT, "<$path/$data_file") || die("Could not open file!");
@raw_data=<DAT>;
close(DAT);  
foreach $main (@raw_data)
{
 chop($main);
 ($name,$email,$count,$url,$ip,$type)=split(/\|/,$main);
$cnt = $cnt +1;
print <<HTML;


<div align="center"><br>
  <table width="86%" cellspacing="1" cellpadding="2" bgcolor="#000000">
    <tr bgcolor="#FEC650"> 
      <td height="5" bgcolor="#CCCCCC"> 
        <div align="center"><font face="Verdana, Arial, Helvetica,
sans-serif" size="2" color="#000000"><b>SUBMISSION #$cnt FROM $ip</b></font></div>
      </td>
    </tr>
    <tr bgcolor="#FEC650"> 
      <td height="5" bgcolor="#E7E7E7"><font size="2" face="Verdana,
Arial, Helvetica, sans-serif" color="#000000">NAME: $name</font></td>
    </tr>
    <tr bgcolor="#FEC650"> 
      <td height="5" bgcolor="#E7E7E7"><font size="2" face="Verdana,
Arial, Helvetica, sans-serif" color="#000000">EMAIL: $email </font></td>
    </tr>
    <tr bgcolor="#FEC650"> 
      <td height="5" bgcolor="#E7E7E7"><font size="2" face="Verdana,
Arial, Helvetica, sans-serif" color="#000000">MOVIES:$count </font></td>
    </tr>
    <tr bgcolor="#FEC650"> 
      <td height="5" bgcolor="#E7E7E7"><font size="2" face="Verdana,
Arial, Helvetica, sans-serif" color="#000000">TYPE:$type</font></td>
    </tr>
    <tr bgcolor="#FEC650"> 
      <td height="5" bgcolor="#E7E7E7"><font size="2" face="Verdana,
Arial, Helvetica, sans-serif" color="#000000">URL:<a
href="$url" target="_blank">$url</a></font></td>
    </tr>
    <tr bgcolor="#FEC650"> 
      <td height="3" bgcolor="#CCCCCC"> 
        <div align="right"> <font size="2"><a
href="xtreme_delete.cgi?$cnt"><font face="Verdana, Arial, Helvetica,
sans-serif"><b><font color="#000000">Delete</font></b></font></a> <b><font face="Verdana, Arial, Helvetica, sans-serif"><a
href="xtreme_aprove.cgi?$cnt"><font color="#000000">Aprove</font></a> </font></b> 
          </font></div>
      </td>
    </tr>
  </table>

<div align="center"></div>







HTML

}



}

 

sub delete {
$sitedata="aprove.txt";

open(DAT, "<$path/$sitedata") || die("Cannot Open File");
@raw_data=<DAT>; 
close(DAT);

splice(@raw_data,1,1);

open(DAT,">$sitedata") || die("Cannot Open File");
print DAT @raw_data; 
close(DAT);



}

sub there {

$data="list.txt";
open(DAT, "<$path/$data") || die("Could not open file!");
@raw_data=<DAT>;
close(DAT);
$many = 0;
foreach $main (@raw_data)
{
$many = $many + 1;
}

print <<what;
<html>
<head>
<title>Xtreme TGP v1.0</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>


<div align="center">
  <table width="86%" cellspacing="1" cellpadding="1" bgcolor="#000000">
    <tr>
      <td bgcolor="#CCCCCC"> 
        <div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><font color="#000000">Currently 
          Listed Sites</font></b></font></div>
      </td>
    </tr>
    <tr>
      <td bgcolor="#E7E7E7" height="23"><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">The 
        following sites are currently being listed on your tgp! To delete a site 
        just select to corresponding the link and then update the list!</font></td>
    </tr>
  </table>
  <br>
  <font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><font color="#000000">There 
  are currently <font color="#FF0000">$many <font color="#000000">sites being 
  listed</font></font></font></b></font></div>


what


foreach $main (@raw_data)
{
 chop($main);
 ($name,$email,$count,$url,$ip,$type)=split(/\|/,$main);
$cnt = $cnt +1;
print <<HTML;

<div align="center"><br>
  <table width="86%" cellspacing="1" cellpadding="2" bgcolor="#000000">
    <tr bgcolor="#FEC650"> 
      <td height="5" bgcolor="#CCCCCC"> 
        <div align="center"><font face="Verdana, Arial, Helvetica,
sans-serif" size="2"><b><font color="#000000">SUBMISSION #$cnt FROM $ip</font></b></font></div>
      </td>
    </tr>
    <tr bgcolor="#FEC650"> 
      <td height="5" bgcolor="#E7E7E7"><font size="2" face="Verdana,
Arial, Helvetica, sans-serif" color="#000000">NAME: $name</font></td>
    </tr>
    <tr bgcolor="#FEC650"> 
      <td height="5" bgcolor="#E7E7E7"><font size="2" face="Verdana,
Arial, Helvetica, sans-serif" color="#000000">EMAIL: $email </font></td>
    </tr>
    <tr bgcolor="#FEC650"> 
      <td height="5" bgcolor="#E7E7E7"><font size="2" face="Verdana,
Arial, Helvetica, sans-serif" color="#000000">MOVIES:$count </font></td>
    </tr>
    <tr bgcolor="#FEC650"> 
      <td height="5" bgcolor="#E7E7E7"><font size="2" face="Verdana,
Arial, Helvetica, sans-serif" color="#000000">TYPE:$type</font></td>
    </tr>
    <tr bgcolor="#FEC650"> 
      <td height="5" bgcolor="#E7E7E7"><font size="2" face="Verdana,
Arial, Helvetica, sans-serif" color="#000000">URL:<a
href="$url" target="_blank"><font color="black">$url</font></a></font></td>
    </tr>
    <tr bgcolor="#FEC650"> 
      <td height="3" bgcolor="#CCCCCC"> 
        <div align="right"> <font size="2"><a
href="xtreme_delete2.cgi?$cnt"><font face="Verdana, Arial, Helvetica,
sans-serif"><b><font color="#000000">Delete</font></b></font></a> </font></div>
      </td>
    </tr>
  </table>

<div align="center"></div>







HTML

}

}


sub base {
$data_file="stats.txt";
open(DAT, "<$path/$data_file") || die("Could not open file!");
@raw_data=<DAT>;
close(DAT); 
foreach $main (@raw_data)
{
 chop($main);
 ($gal_out,$other_out)=split(/\|/,$main);
}

$data="aprove.txt";
open(DAT, "<$path/$data") || die("Could not open file!");
@raw_data=<DAT>;
close(DAT);
$many = 0;
foreach $main (@raw_data)
{
$many = $many + 1;
}  
$data="list.txt";
open(DAT, "<$path/$data") || die("Could not open file!");
@raw_data=<DAT>;
close(DAT);
$queued = 0;
foreach $main (@raw_data)
{
$queued = $queued + 1;
}

print <<EndOfHTML;


<html>
<head>
<title>Xtreme TGP v1.0 - Free</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body bgcolor="#FFFFFF">
<div align="center"> 
  <table width="86%" cellspacing="1" cellpadding="1" bgcolor="#000000">
    <tr> 
      <td bgcolor="#CCCCCC"> 
        <div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><font color="#000000">Welcome 
          to the Admin Panel</font></b></font></div>
      </td>
    </tr>
    <tr> 
      <td bgcolor="#E7E7E7"><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">We 
        have made an effort to make the admin part of xtreme-tgp vv1.0 the easiest 
        and most user friendly part of the system. To navigate the admin, simply 
        use the links on the left of your screen. If you need help with anything 
        concerning the system, feel free to email me at webmaster\@cyphonic.net. 
        Have fun, and enjoy the power of Xtreme TGP!</font></td>
    </tr>
  </table>
  
  <br>
  <table width="86%" cellspacing="1" cellpadding="1" bgcolor="#000000">
    <tr> 
      <td bgcolor="#CCCCCC" colspan="2"> 
        <div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><font color="#000000">Quick 
          Stats </font></b></font></div>
      </td>
    </tr>
    <tr> 
      <td bgcolor="#E7E7E7" width="50%"><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
        Hits Sent to Galleries:</font></td>
      <td bgcolor="#E7E7E7" width="50%"> 
        <div align="center"><b><font size="2" face="Verdana, Arial, Helvetica, sans-serif">$gal_out</font></b></div>
      </td>
    </tr>
    <tr> 
      <td bgcolor="#E7E7E7" width="50%"><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">Hits 
        Sent to Out Script:</font></td>
      <td bgcolor="#E7E7E7" width="50%"> 
        <div align="center"><b><font size="2" face="Verdana, Arial, Helvetica, sans-serif">$other_out 
          </font></b></div>
      </td>
    </tr>
    <tr> 
      <td bgcolor="#E7E7E7" width="50%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Sites 
        in the Queue</font></td>
      <td bgcolor="#E7E7E7" width="50%"> 
        <div align="center"><b><font size="2" face="Verdana, Arial, Helvetica, sans-serif">$many</font></b></div>
      </td>
    </tr>
    <tr> 
      <td bgcolor="#E7E7E7" width="50%"><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">Number 
        of Sites on your Tgp:</font></td>
      <td bgcolor="#E7E7E7" width="50%"> 
        <div align="center"><b><font size="2" face="Verdana, Arial, Helvetica, sans-serif">$queued</font></b></div>
      </td>
    </tr>
  </table>
  
</div>






EndOfHTML








}


sub backup {

print <<bak;

<html>
<head>
<title>Xtreme TGP v1.0 - Free</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body bgcolor="#FFFFFF">
<div align="center"> 
  <table width="86%" cellspacing="1" cellpadding="1" bgcolor="#000000">
    <tr> 
      <td bgcolor="#CCCCCC"> 
        <div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><font color="#000000">Backup 
          Options </font></b></font></div>
      </td>
    </tr>
    <tr> 
      <td bgcolor="#E7E7E7"><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">This 
        option of Xtreme TGP enables you to back up all aspects of your TGP. To 
        back up a certain file, simply click the corresponding link below. Or, 
        to save time, select Backup All. To use a backup, download the files in 
        the backup directory to your HD, then overwrite the current ones on your 
        server.</font></td>
    </tr>
  </table>
  
  <br>
  <table width="86%" cellspacing="1" cellpadding="1" bgcolor="#000000">
    <tr> 
      <td bgcolor="#CCCCCC"> 
        <div align="left"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><font color="#000000">Backup 
          Main Database</font></b></font></div>
      </td>
    </tr>
    <tr>
      <td bgcolor="#E7E7E7"><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">This 
        will backup your list.txt file, and save it to the Backup Directory.<br>
        We recomend doing this frequently!</font></td>
    </tr>
    <tr> 
      <td bgcolor="#CCCCCC">
        <div align="right"><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif"><a href="xtreme_admin.cgi?backupmain"><font color="black">EXECUTE 
          BACKUP</font></a></font></div>
      </td>
    </tr>
  </table>
  <br>
  <table width="86%" cellspacing="1" cellpadding="1" bgcolor="#000000">
    <tr> 
      <td bgcolor="#CCCCCC"> 
        <div align="left"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><font color="#000000">Backup 
          Queue</font></b></font></div>
      </td>
    </tr>
    <tr> 
      <td bgcolor="#E7E7E7" height="16"><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">This 
        will backup your aprove.txt file, and save it to the Backup Directory.</font></td>
    </tr>
    <tr> 
      <td bgcolor="#CCCCCC"> 
        <div align="right"><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif"><a href="xtreme_admin.cgi?backupqueue"><font color="black">EXECUTE 
          BACKUP</font></a></font></div>
      </td>
    </tr>
  </table>
  <br>
  <table width="86%" cellspacing="1" cellpadding="1" bgcolor="#000000">
    <tr> 
      <td bgcolor="#CCCCCC"> 
        <div align="left"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><font color="#000000">Backup 
          Weekly Movies</font></b></font></div>
      </td>
    </tr>
    <tr> 
      <td bgcolor="#E7E7E7" height="16"><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">This 
        will backup your weekly.txt file, and save it to the Backup Directory.</font></td>
    </tr>
    <tr> 
      <td bgcolor="#CCCCCC"> 
        <div align="right"><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif"><a href="xtreme_admin.cgi?backupmovies"><font color="black">EXECUTE 
          BACKUP</font></a></font></div>
      </td>
    </tr>
  </table>
  <br>
  <table width="86%" cellspacing="1" cellpadding="1" bgcolor="#000000">
    <tr> 
      <td bgcolor="#CCCCCC"> 
        <div align="left"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><font color="#000000">Backup 
          All </font></b></font></div>
      </td>
    </tr>
    <tr> 
      <td bgcolor="#E7E7E7" height="16"><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">This 
        will backup all your files, to the backup directory.<br>
        This option will save you the most time!</font></td>
    </tr>
    <tr> 
      <td bgcolor="#CCCCCC"> 
        <div align="right"><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif"><a href="xtreme_admin.cgi?backupall"><font color="black">EXECUTE 
          BACKUP</font></a></font></div>
      </td>
    </tr>
  </table>
</div>



bak

}

sub backupmain {
$bpath = "/home/sites/site12/web/adm/backup";
$data="list.txt";
open(DAT, "<$path/$data") || die("Could not open file!");
@raw_data=<DAT>;
close(DAT);
$ip="list.txt";
open(DAT,">$bpath/$ip") || die("THERE WAS A FILE ERROR!");
print DAT "@raw_data";
close(DAT);
print <<bak2;
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#FFFFFF" text="#000000">
<div align="center">
  <table width="86%" cellspacing="1" cellpadding="1" bgcolor="#000000">
    <tr> 
      <td bgcolor="#CCCCCC"> 
        <div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><font color="#000000">Status</font></b></font></div>
      </td>
    </tr>
    <tr> 
      <td bgcolor="#E7E7E7">
        <div align="center"><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">The 
          Backup was succesfull and the Backup directory now contains the new 
          file!</font></div>
      </td>
    </tr>
  </table>
</div>
</body>
</html>
bak2
}

sub backupqueue {
$bpath = "/home/sites/site12/web/adm/backup";
$data="aprove.txt";
open(DAT, "<$path/$data") || die("Could not open file!");
@raw_data=<DAT>;
close(DAT);
$ip="aprove.txt";
open(DAT,">$bpath/$ip") || die("THERE WAS A FILE ERROR!");
print DAT "@raw_data";
close(DAT);
print <<backupqueuehtml;
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#FFFFFF" text="#000000">
<div align="center">
  <table width="86%" cellspacing="1" cellpadding="1" bgcolor="#000000">
    <tr> 
      <td bgcolor="#CCCCCC"> 
        <div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><font color="#000000">Status</font></b></font></div>
      </td>
    </tr>
    <tr> 
      <td bgcolor="#E7E7E7">
        <div align="center"><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">The 
          Backup was succesfull and the Backup directory now contains the new 
          file!</font></div>
      </td>
    </tr>
  </table>
</div>
</body>
</html>

backupqueuehtml

}

sub backupall {

$bpath = "/home/sites/site12/web/adm/backup";
$data="aprove.txt";
open(DAT, "<$path/$data") || die("Could not open file!");
@raw_data=<DAT>;
close(DAT);
$ip="aprove.txt";
open(DAT,">$bpath/$ip") || die("THERE WAS A FILE ERROR!");
print DAT "@raw_data";
close(DAT);

$bpath = "/home/sites/site12/web/adm/backup";
$data="list.txt";
open(DAT, "<$path/$data") || die("Could not open file!");
@raw_data=<DAT>;
close(DAT);
$ip="list.txt";
open(DAT,">$bpath/$ip") || die("THERE WAS A FILE ERROR!");
print DAT "@raw_data";
close(DAT);

$bpath = "/home/sites/site12/web/adm/backup";
$data="weekly.txt";
open(DAT, "<$path/$data") || die("Could not open file!");
@raw_data=<DAT>;
close(DAT);
$ip="weekly.txt";
open(DAT,">$bpath/$ip") || die("THERE WAS A FILE ERROR!");
print DAT "@raw_data";
close(DAT);
print <<backupallT;
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#FFFFFF" text="#000000">
<div align="center">
  <table width="86%" cellspacing="1" cellpadding="1" bgcolor="#000000">
    <tr> 
      <td bgcolor="#CCCCCC"> 
        <div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><font color="#000000">Status</font></b></font></div>
      </td>
    </tr>
    <tr> 
      <td bgcolor="#E7E7E7">
        <div align="center"><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">The 
          Backup was succesfull and the Backup directory now contains the new 
          files!</font></div>
      </td>
    </tr>
  </table>
</div>
</body>
</html>
backupallT

}

sub backupmovies {
$bpath = "/home/sites/site12/web/adm/backup";
$data="weekly.txt";
open(DAT, "<$path/$data") || die("Could not open file!");
@raw_data=<DAT>;
close(DAT);
$ip="weekly.txt";
open(DAT,">$bpath/$ip") || die("THERE WAS A FILE ERROR!");
print DAT "@raw_data";
close(DAT);
print <<backupmovies2;
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#FFFFFF" text="#000000">
<div align="center">
  <table width="86%" cellspacing="1" cellpadding="1" bgcolor="#000000">
    <tr> 
      <td bgcolor="#CCCCCC"> 
        <div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><font color="#000000">Status</font></b></font></div>
      </td>
    </tr>
    <tr> 
      <td bgcolor="#E7E7E7">
        <div align="center"><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">The 
          Backup was succesfull and the Backup directory now contains the new 
          file!</font></div>
      </td>
    </tr>
  </table>
</div>
</body>
</html>
backupmovies2

}

sub ban {
print <<ban;
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#FFFFFF" text="#000000">
<div align="center">
  <table width="86%" cellspacing="1" cellpadding="1" bgcolor="#000000">
    <tr> 
      <td bgcolor="#CCCCCC"> 
        <div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><font color="#000000">Banning</font></b></font></div>
      </td>
    </tr>
    <tr> 
      <td bgcolor="#E7E7E7"> 
        <div align="left"><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">If 
          you have some jerk, who keeps submitting stupid posts, or massive amounts 
          of posts, you can use the following option to ban them. </font></div>
      </td>
    </tr>
  </table>
  <br>
  <form name="form1" method="post" action="xtreme_ban.cgi">
    <table width="86%" cellspacing="1" cellpadding="1" bgcolor="#000000">
      <tr> 
        <td bgcolor="#CCCCCC"> 
          <div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><font color="#000000">Ban 
            an IP</font></b></font></div>
        </td>
      </tr>
      <tr> 
        <td bgcolor="#E7E7E7" height="13"> 
          <div align="center"><font color="#000000" size="2" face="Verdana, Arial, Helvetica, sans-serif">IP 
            ADDRESS: 
            <input type="text" name="ip">
            <input type="submit" name="Submit" value="Ban">
            </font></div>
        </td>
      </tr>
    </table>
    </form>
</div>
</body>
</html>
<div align="center">
  <table width="86%" cellspacing="1" cellpadding="1" bgcolor="#000000">
    <tr> 
      <td bgcolor="#CCCCCC" colspan="2"> 
        <div align="center"><font color="#FFFFFF" size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><font color="#000000">Currently 
          Banned Users</font></b></font></div>
      </td>
    </tr>
    <tr> 
      <td bgcolor="#E7E7E7" width="50%"> 
        <div align="left"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">IP 
          ADDRESS</font></b></div>
      </td>
      <td bgcolor="#E7E7E7"> 
        <div align="left"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">DATE 
          OF BAN</font></b></div>
      </td>
    </tr>
ban

$data_file="ban.txt";
open(DAT, $data_file) || die("Could not open file!");
@raw_data=<DAT>;
close(DAT);  
foreach $main (@raw_data)
{
 chop($main);
 ($ip,$ipdate)=split(/\|/,$main);
print <<HTML;
</tr>
    <tr> 
      <td bgcolor="#E7E7E7"> 
        <div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">$ip</font></div>
      </td>
      <td bgcolor="#E7E7E7"> 
        <div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">$ipdate</font></div>
      </td>
    </tr>
HTML
}
print <<ss;
</table>
</div>
</body>
</html>
ss

}
