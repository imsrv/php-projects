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
sub Get_BidFind_Pages{
my(%Cat_Count, @Required_Categories);
my($Page_Length, $Category, $Cat_ID);
my($Root_Cat_ID, $Cat_File, $Count);
my(%index, $Start_Item, %Required, @ID);
my(%Items_Required, $Output, %index1);
my($Total_Count, $End_Item);
my($Items, $Item_ID);
my($Current_Page, $Next_Page, $Last_Page);
my($Next_Page_Link);

	@Required_Categories= sort @Main_Categories;
	if (!$Param{'Page'}) {$Param{'Page'} = 0};

	if (!$Param{'Page_Length'}) {$Param{'Page_Length'}=1000};
	$Page_Length = $Param{'Page_Length'};

	&DB_Exist($Global{'OpenItemsIndexFile'});
	tie %index, "DB_File", $Global{'OpenItemsIndexFile'}, O_RDONLY
        or &Exit("Cannot open database file $Global{'OpenItemsIndexFile'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);
	%index1=%index;
	untie %index;
	undef %index;

	@ID=sort keys %index1;
	$Total_Count=@ID;

	$Last_Page=int($Total_Count / $Page_Length);
	if (($Total_Count % $Page_Length)) { $Last_Page++; }

	$Current_Page=$Param{'Page'};
	$Next_Page=$Current_Page + 1;
	if ($Next_Page > $Last_Page) {
			$Next_Page="";
	}

	if ($Next_Page) {
			$Next_Page_Link=qq!<A HREF="$Script_URL?action=BidFind&Page=$Next_Page&Page_Length=$Page_Length">Next Page</A>\n!;
	}
	else{
			$Next_Page_Link="";
	}

	$Start_Item = $Param{'Page'} * $Page_Length;
	if ($Start_Item > $Total_Count) {$Start_Item =0;}

	$End_Item=$Start_Item + $Page_Length;
	if ($End_Item > $Total_Count) {
			$End_Item  = $Total_Count;
	}

	for $	Count($Start_Item.. $End_Item-1) {
			$Required{$ID[$Count]}=$index1{$ID[$Count]};
	}

	while(($Item_ID, $Cat_ID)=(each %Required)){
			$Root_Cat_ID=&Get_Root_Cat_ID($Cat_ID);
			$Items_Required{$Root_Cat_ID} = "";
	}

	
	while(($Item_ID, $Cat_ID)=each %Required){
			$Root_Cat_ID=&Get_Root_Cat_ID($Cat_ID);
			$Items_Required{$Root_Cat_ID} .= "$Item_ID|";
	}

$Output=<<HTML;
<HTML>
<HEAD>
<TITLE>BidFind MegaList. Powered by Mewsoft Auction Software, www.mewsoft.com</TITLE>
</HEAD>
<BODY>
HTML

	while(($Root_Cat_ID, $Items)=each %Items_Required){
			undef @IDs;
			@IDs=split(/\|/, $Items);
			&Read_From_Category_Items($Root_Cat_ID, @IDs);
			$Output .= &Parse_BidFind;
	}

	if ($Next_Page_Link) { $Output.=$Next_Page_Link;}

$Output.=<<HTML1;
</BODY>
</HTML>
HTML1

	print "Content-type: text/html\n\n";
	print "$Output";

}
#==========================================================
sub Parse_BidFind{
my($Count, $Title, $ID, $Cat_ID);
my($url, $Cat, $Out, $Price);
my( $sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $dst );

    for $Count(0.. $Items_Count-1) {
		$Title=$Item_Info[$Count]{'Title'};
		$ID=$Item_Info[$Count]{'Item_ID'};
		$Cat_ID=$Item_Info[$Count]{'Cat_ID'};
		$url=qq!$Script_URL?action=View_Item&Item_ID=$ID&Cat_ID=$Cat_ID&Lang=$Global{'Language'}!;
	
		$Cat =$Category_Root{$Cat_ID};
		$Price=$Item_Info[$Count]{'Current_Bid'};
		( $sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $dst )= gmtime( $Item_Info[$Count]{'End_Time'} );
		$mon++;

		$Out.=qq!<A HREF="$url">$Title</A><PRICE>$Global{'Currency_Symbol'}$Price<CAT>$Cat<ENDS>$mon/$mday<BR>\n!;
    }
		return $Out;
}
#==========================================================
1;