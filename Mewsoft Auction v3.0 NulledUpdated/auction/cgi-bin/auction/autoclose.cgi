#!/usr/bin/perl
#!/usr/local/bin/perl
#!/usr/local/bin/perl5
#!C:\perl\bin\perl.exe -w 
=Copyright Infomation
==========================================================
                                                   Mewsoft 

    Program Name    : Mewsoft Auction Software
    Program Version : 3.0
    Program Author  : Elsheshtawy, Ahmed Amin.
    Home Page       : http://www.mewsoft.com
    Nullified By    : TNO (T)he (N)ameless (O)ne

 Copyrights © 2000-2001 Mewsoft. All rights reserved.
==========================================================
 This software license prohibits selling, giving away, or otherwise distributing 
 the source code for any of the scripts contained in this SOFTWARE PRODUCT,
 either in full or any subpart thereof. Nor may you use this source code, in full or 
 any subpart thereof, to create derivative works or as part of another program 
 that you either sell, give away, or otherwise distribute via any method. You must
 not (a) reverse assemble, reverse compile, decode the Software or attempt to 
 ascertain the source code by any means, to create derivative works by modifying 
 the source code to include as part of another program that you either sell, give
 away, or otherwise distribute via any method, or modify the source code in a way
 that the Software looks and performs other functions that it was not designed to; 
 (b) remove, change or bypass any copyright or Software protection statements 
 embedded in the Software; or (c) provide bureau services or use the Software in
 or for any other company or other legal entity. For more details please read the
 full software license agreement file distributed with this software.
==========================================================
              ___                         ___    ___    ____  _______
  |\      /| |     \        /\         / |      /   \  |         |
  | \    / | |      \      /  \       /  |     |     | |         |
  |  \  /  | |-|     \    /    \     /   |___  |     | |-|       |
  |   \/   | |        \  /      \   /        | |     | |         |
  |        | |___      \/        \/       ___|  \___/  |         |

==========================================================
You are allowed to change this file to reflect your server
==========================================================
=cut
#==========================================================
#print "Content-type: text/html\n\n";
package Auction;
#==========================================================
# For Windows Servers , you may need set the following variable to you
# cgi-bin auction directoy example: d:/225.225.225.1/cgi-bin/auction.
BEGIN {
$Program_CGI_Directory="/usr/local/plesk/apache/vhosts/bidsea.com/cgi-bin/auction";
}
#==========================================================
#                 ---------- End of Setup File-------------
#==========================================================
# Unbuffer Output
$| = 1;
#use CGI::Carp qw(fatalsToBrowser); 
#==========================================================
BEGIN {
	if ( $Program_CGI_Directory)  {push @INC, $Program_CGI_Directory;}
	require "path.setup";
	use Cwd;
	$CWD = cwd;
	push @INC, $CWD;
	push @INC, "."; 
	push @INC, $Program_CGI_Directory; 
}
#==========================================================
BEGIN { 
   use vars qw (%Param  %Category_ID %Category_Count %Category_TFlag %Category_SortNo
   %Category_Description %All_SubCategories @Sub_Categories %Category_Name %Plugins
   @Main_Categories $All_SubCategories_Count $Sub_Categories_Count $Categories_Count
   @Item_Info   $Items_Count  $PageNumber $Domain $Doc_Root $Script_Name $Script_URL
   $Category_ON_Count @Category_ON %Category_Subs_URL  %Global
   %Category_Accept $SubCategory_Tree_Count @Bad_Words %Set_Cookies $Build_Pages
   @SubCategory_Tree_URL @Category_URL %Language %User_Info %Cookies $Delimiter
   @Title_Suffix @Title_Prefx    
   );
}

use Fcntl;
use DB_File;
use File::Copy;
require "$Program_CGI_Directory/configuration.pm";
require "$Program_CGI_Directory/mewsoft.pm";
require "$Program_CGI_Directory/catmanager.pm";
require "$Program_CGI_Directory/language.pm";
require "$Program_CGI_Directory/displaymgr.pm";
require "$Program_CGI_Directory/submititem.pm";
require "$Program_CGI_Directory/registration.pm";
require "$Program_CGI_Directory/users.pm";
require "$Program_CGI_Directory/timedate.pm";
require "$Program_CGI_Directory/dbmanagar.pm";
require "$Program_CGI_Directory/maillib.pm";
require "$Program_CGI_Directory/general.pm";
require "$Program_CGI_Directory/accountmgr.pm";
#==========================================================
&Read_Configuration;
&Prepare_Categories;
#==========================================================
#====================MAIN==================================
&Archive_Closed_Items;
exit 0;
#==========================================================
sub Archive_Closed_Items{
my($Closed_Items_Count, $Resubmitted_Items_Count);
my($Show);

	$Show=0;
	if($ARGV[0] =~ /show/i ){$Show=1};

	&Read_Language_File($Global{'Language_General_File'});
	&Read_Language_File($Global{'Language_Bidding_File'});

	$Resubmitted_Items_Count=&Resubmit_Items($Show);
	$Closed_Items_Count=&Move_Closed_Items($Show);

	print "$Global{'Auction_Close_Log'}\n"   if ($Show);
	
	if (! -e "$Global{'Auction_Close_Log'}") {
		open(LOG, ">$Global{'Auction_Close_Log'}") 
				or &Exit("can't create log file: $Global{'Auction_Close_Log'}"."<BR>Line ". __LINE__ . ", File ". __FILE__);
		close LOG;
	}

	open(LOG, ">>$Global{'Auction_Close_Log'}") 
													or &Exit("Can't open log file: $Global{'Auction_Close_Log'}"."<BR>Line ". __LINE__ . ", File ". __FILE__);
	$Out=&Get_Local_Time(&Time(time));
	print LOG "$Out\n";
	$Out=qq!The number of resubmitted auctions is: $Resubmitted_Items_Count\n!;
	$Out.=qq!The number of archived auctions is: $Closed_Items_Count\n!;
	print LOG "$Out\n";
	close LOG;

	$Out=qq!\nThe number of resubmitted auctions is: $Resubmitted_Items_Count\n!;
	$Out.=qq!The number of archived auctions is: $Closed_Items_Count\n!;
	print "$Out\n"  if ($Show);
	print "Finished... Bye\n"  if ($Show);
}
#==========================================================
sub Exit{
my($Msg, $Title, $Level)=@_;
my ($Out);

	if ($Title eq "") {$Title="Error";	}
	print "$Title\n<br>";
	print "$Msg\n<br>";
	exit 0;
}
#======================================================#
#======================================================#
