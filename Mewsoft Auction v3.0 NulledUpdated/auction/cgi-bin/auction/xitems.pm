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
                                 Do not modify anything below this line
==========================================================
=cut
#==========================================================
package Auction;
#==========================================================
sub xitems{
my $Item_Extra="";
my $Item_all ="";
my $Days_in_Sec;
my $TimeNow;
my $Spare;
my(@Title)=();
my($Item_ID);
#&Initialize_Language_Paths;
#&Prepare_Categories;

print "Content-type: text/html\n\n";
print "<HTML>";
print "<HEAD><TITLE>$title</TITLE></HEAD>";
print "<BODY>";

# Unbuffer Output
$| = 1;

$Count=500;
if ($Param{'count'}) {$Count=$Param{'count'};}

$Spare="";
@Gift=qw(anniversary.gif  baby.gif  birthday.gif  christmas.gif  easter.gif  fatherday.gif  halloween.gif hanukkah.gif july4th.gif motherday.gif patrickday.gif thanksgiving.gif valentineday.gif wedding.gif);
push (@Gift,"");
$Start=$Global{'Total_Items_Count'};

$Title[0]="New ATX FORM CARD / 2 USB, PS/2, Infra Red";
$Title[1]="180Watts MULTI 3D SPEAKERS GREAT SOUND BidNow";
$Title[2]="ECLIPSE COMPUTER LIGHT REDUCE EYE STRAIN NEW!";
$Title[3]="NEW 400 Watts PMPO 3D Multimedia SUBWOOFER";
$Title[4]="NEW Digital Camera w/FLASH and USB";
$Title[5]="How To Setup Your Own Network on VHS..HOT/CC";
$Title[6]="NEW SANDISK SMARTMEDIA CARD READER";
$Title[7]="NEW! SCSI-2 DB50M-Centronics 50M Cable C.C.OK";
$Title[8]="NEW The Lone Ranger in Color Mousepad Mouse P";
$Title[9]="CD WRITER UTILITIES 2000 *BURN UNCOPYABLE CDS";
$Title[10]="Cassiopeia JK-512CR Charger and Case NEW!";
$Title[11]="MODEM, internal 56K (V90) PCI Voice/Fax/Data";
$Title[12]="AC SURGE PROTECTOR SRW-GS-3 W/6' CORD UL";
$Title[13]="Miniature Computer FM Radio NEW Great Gift";
$Title[14]="Singer Actor Will Smith Mousepad Mouse Pad";
$Title[15]="FELLOWS MINI TRACKBALL LAP TOP PRESENTATIONS";
$Title[16]="LEXMARK 7000 PRINTER/4 WAY SWITCH/SPEAKERS";
$Title[17]="SCREW IN THE DARK! LIGHTED MULTI SCREWDRIVER!";
$Title[18]="SANDISK SMART MEDIA READER USB BRAND NEW";
$Title[19]="850 Watt SUB 5-PC SURROUND COMPUTER SPEAKERS";
$Title[20]="RETRACTABLE KEYBOARD TRAY BY PERFORMEX";
$Title[21]="INTERNET READY ARTICULATED KEYBOARD TRAY ARM";
$Title[22]="MOTOROLA 56K ISA V.90 V/D/F Modem ONLY $17.00";
$Title[23]="CREATIVE 33.6 INTERNAL FAX MODEM NEW W/CD";
$Title[24]="ZOOM 33.6 MODEM BRAND NEW STILL IN BOX";
$Title[25]="USRobotics 56K Voice Faxmodem. New, pic";
$Title[26]="Diamond Supra SST 56K Internal PCI Modem - NR";
$Title[27]="XIRCOM REALPORT CARDBUS 10/100+56K PCMCIA";
$Title[28]="Cleaning out Garage -Box of 6 External Modems";
$Title[29]="Efficient Networks Speedstream 3060 DSL Modem";
$Title[30]="EXTERNAL SupraFAXModem 14.4bps Fax V.32 Data";

$Param{'Cat_ID'}=1;

for $Counter($Start..($Start+$Count-1)) {
	print "..................................................";
	if (!($Counter % 25)) {print "<br> Adding Item $Counter ";}

		$Param{'Country'}="All";
		$Param{'Item_Language'}="English";
		$Param{'ypChecks'}="yes";
		$Param{'yccMorders'}="yes";
		$Param{'yCCards'}="yes";
		$Param{'escrow'}="yes";
		$Param{'shipping'}="yes";
		$Param{'ship_time'}="yes";
		$Param{'Ship_Internationally'}="yes";
		$Param{'Start_Bid'}=100+ int(rand(100));
		$Param{'Increment'}=int(rand(30)) + 1;
		$Param{'Location'}="Knoxville, TN, 37919";
		$Param{'Enhancement'}=int(rand(2));
		$Param{'Reserve'}=150+int(rand(50));
		$Param{'BuyPrice'}="";
		$Param{'BidRating'}=0;
		$Param{'Closing_Time'}=int(rand(13))+10;
#		$Param{'Closing_Time'}=int(rand(1))+0;
		$Param{'Resubmit'}=int(rand(5));
		$Param{'Homepage'}="https://www.safeweb.com/o/_i:http://www.mewsoft.com";
		$Param{'Current_Bid'}=$Param{'Start_Bid'};
		$Param{'Bids'}=0;
		$Param{'Resubmited'}=int(rand(5));
		$Param{'Featured_Homepage'}=0;
		$Param{'Featured_Category'}=0;

		if (!($Counter % 20) ) {
			$Param{'Featured_Homepage'}=1;
		}

		if (!($Counter % 5) ) {
			$Param{'Featured_Category'}=1;
		}

$Item_Extra=join("~|~",
		$Param{'Country'},
		$Param{'Item_Language'},
		$Param{'ypChecks'},
		$Param{'yccMorders'},
		$Param{'yCCards'},
		$Param{'escrow'},
		$Param{'shipping'},
		$Param{'ship_time'},
		$Param{'Ship_Internationally'},
		$Param{'Start_Bid'},
		$Param{'Increment'},
		$Param{'Location'},
		$Param{'Featured_Homepage'},
		$Param{'Featured_Category'},
		$Param{'Reserve'},
		$Param{'BuyPrice'},
		$Param{'BidRating'},
		$Param{'Closing_Time'},
		$Param{'Resubmit'},
		$Param{'Homepage'},
		$Param{'Resubmited'},
		$Spare,
		$Spare,
		$Spare,
		$Spare,
		$Spare
		);

		$Upload[0]=qq!/www/mewsoft/auction/upload/64471155776.gif|/www/mewsoft/auction/upload/43524886201.gif!;
		$Upload[1]="";
		$Upload[2]=qq!/www/mewsoft/auction/upload/70875904708.gif!;
		$Upload[3]="";
		$Param{'Uploaded_Files'}=$Upload[int(rand(3))];

		$Param{'Cat_ID'}++;
		if ($Param{'Cat_ID'} <1 || $Param{'Cat_ID'} >$All_SubCategories_Count) {$Param{'Cat_ID'}=1;}
		$Param{'User_ID'}="admin";
		$Param{'Title'}=$Title[int($Counter % @Title)];
		$Param{'Description'}=qq!This is a demo auction, it is not real auction. You can use the auction search utility to find items containing the words computer, comp*, c*, hard drive, CD-rom, DVD, mouse mac, pc, os, keyboard, monitor, cost , free, gift, near, city. Also you can search for single items by searching for a specific number starting from 1 to xxxx. The text of all items are the same but each item has only on specific number different from all others. <br><br><center><img src="$Global{'ImagesDir'}/auction_logo.gif" border=0></center><br><br>!;
		$Param{'Description'}=&Web_Encode($Param{'Description'});

		$Param{'Quantity'}=int(rand(4)+1);
		$Param{'Duration'}=8 + int(rand(6));
#		$Param{'Duration'}=0 + int(rand(1));

		$TimeNow=&Time(time);
		$Param{'Start_Time'}=$TimeNow;
		$Days_in_Sec= int( ($Param{'Duration'}-1) * 86400);
		my( $sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $dst )= gmtime(&Time(time));
		$Param{'End_Time'}=$TimeNow + $Days_in_Sec + (($Param{'Closing_Time'} + 24-$hour)*3600) ;


		$Param{'Title_Enhancement'}=int(rand(3));
		$Param{'Gift_Icon'}=$Gift[int(rand(@Gift))];

$Item_all = join ("~#~", 
		$Param{'Cat_ID'},
		$Param{'User_ID'},
		$Param{'Title'},
		$Param{'Description'},
		$Param{'Quantity'},
		$Param{'Current_Bid'},
		$Param{'Bids'},
		$Param{'Duration'},
		$Param{'End_Time'},
		$Param{'Title_Enhancement'},
		$Param{'Uploaded_Files'},
		$Param{'Gift_Icon'},
		$Param{'Start_Time'},
		$Item_Extra,
		$Spare,
		$Spare,
		$Spare,
		$Spare,
		$Spare
		);

	$ID=&Save_Item($Param{'Cat_ID'}, $Item_all);
	$Item_ID=$ID;

	if ($Param{'Featured_Homepage'}){
		&Add_Featured_Home_Item($Item_ID, $Item_all);
	}
	
	if ($Param{'Featured_Category'}){
		&Add_Featured_Item($Item_ID, $Param{'Cat_ID'});
	}

	&Add_Item_For_Bid($ID, $Param{'Quantity'}, $Param{'Current_Bid'},
												 $Param{'Increment'}, $Param{'Reserve'}, $Param{'BuyPrice'});
}#end loop
	
	&Update_All_Categories_Count(0);

	print "</BODY>";
	print "</HTML>";

	&Read_Language_File($Global{'Language_General_File'});
	&Read_Language_File($Global{'Language_Upload_File'});
	
	$Plugins{'Body'}=$Language{'your_item_submitted'};
    &Display($Global{'General_Template'});

}
#==========================================================
1;