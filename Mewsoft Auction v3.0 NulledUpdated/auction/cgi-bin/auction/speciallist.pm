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
sub New_Auctions{
my($Time, $Table);

		&Read_Language_File($Global{'Language_General_File'});
		&Read_Language_File($Global{'Language_Special_List_File'});

		&Prepare_Categories;
	
		$Time=&Time(time) - int($Global{'New_Item_Houres'} * 3600);

		if (!$Param{'Cat_ID'}) {$Param{'Cat_ID'} ="";}
		&Get_New_Items($Time, $Param{'Cat_ID'});

#		$Out=&Get_Items_List("View_Item", "New_Auctions", "New_Auctions");
		$Table = &Get_Items_Page_List("New_Auctions", "New_Auctions", "View_Item");
		$Plugins{'Items_Count'} = $Items_Count;
		$Plugins{'Body'} = $Table;
		&Get_Menu_Bar(1);
		$Plugins{'Menu_Bar'} .= $Language{'new_auction_guide_bar'};
		&Display($Global{'Listing_Template'});

}
#==========================================================
sub Ending_Now{
my($Time, $Table);

		&Read_Language_File($Global{'Language_General_File'});
		&Read_Language_File($Global{'Language_Special_List_File'});

		&Prepare_Categories;

		if (!$Param{'Cat_ID'}) {$Param{'Cat_ID'} ="";}	
		
		if (!$Param{'Dir'}){$Param{'Dir'} =  "Up";}
		if (!$Param{'Sort'}){$Param{'Sort'} = "End";}
		
		$Time=&Time(time) + int($Global{'Ending_Items_Time_Minutes'} * 60);
		&Get_Ending_Items($Time, $Param{'Cat_ID'});
		
#		$Out=&Get_Items_List("View_Item", "Ending_Now", "");
		$Table = &Get_Items_Page_List("Ending_Now", "Ending_Now", "View_Item");
		$Plugins{'Items_Count'} = $Items_Count;
		$Plugins{'Body'} = $Table;
		&Get_Menu_Bar(1);
		$Plugins{'Menu_Bar'} .= $Language{'ending_auction_guide_bar'};
		&Display($Global{'Listing_Template'});

}
#==========================================================
sub Big_Ticket{
my($Time, $Table);

		&Read_Language_File($Global{'Language_General_File'});
		&Read_Language_File($Global{'Language_Special_List_File'});

		&Prepare_Categories;

		if (!$Param{'Cat_ID'}) {$Param{'Cat_ID'} ="";}	

		&Get_Big_Tickets_Items($Global{'Big_Ticket_Items_Price'}, $Param{'Cat_ID'});
		
#		$Out=&Get_Items_List("View_Item", "Ending_Now", "");
		$Table = &Get_Items_Page_List("Big_Ticket", "Big_Ticket", "View_Item");
		$Plugins{'Items_Count'} = $Items_Count;
		$Plugins{'Body'} = $Table;
		&Get_Menu_Bar(1);
		$Plugins{'Menu_Bar'} .= $Language{'big_tickets_auction_guide_bar'};
		&Display($Global{'Listing_Template'});

}
#==========================================================
sub Featured{
my($Time, $Table);

		&Read_Language_File($Global{'Language_General_File'});
		&Read_Language_File($Global{'Language_Special_List_File'});

		&Prepare_Categories;

		if (!$Param{'Cat_ID'}) {$Param{'Cat_ID'} ="";}	

		&Get_Featured_Items($Param{'Cat_ID'});
		
#		$Out=&Get_Items_List("View_Item", "Ending_Now", "");
		$Table = &Get_Items_Page_List("Featured", "Featured", "View_Item");
		$Plugins{'Items_Count'} = $Items_Count;
		$Plugins{'Body'} = $Table;
		&Get_Menu_Bar(1);
		$Plugins{'Menu_Bar'} .= $Language{'featured_auction_guide_bar'};
		&Display($Global{'Listing_Template'});

}
#==========================================================
sub Cool_Auctions{
my($Out);

		&Read_Language_File($Global{'Language_General_File'});
		&Read_Language_File($Global{'Language_Special_List_File'});

		&Prepare_Categories;

		if (!$Param{'Cat_ID'}) {$Param{'Cat_ID'} ="";}	

		&Get_High_Bids_Items($Global{'Cool_Item_Bids'});

#		$Out=&Get_Items_List("View_Item", "Cool_Auctions", "Cool_Auctions", "");
		$Table = &Get_Items_Page_List("Cool_Auctions", "Cool_Auctions", "View_Item");
		$Plugins{'Items_Count'} = $Items_Count;
		$Plugins{'Body'} = $Table;
		&Get_Menu_Bar(1);
		$Plugins{'Menu_Bar'} .= $Language{'cool_auction_guide_bar'};
		&Display($Global{'Listing_Template'});
}
#==========================================================
sub Hot_Auctions{

		&Read_Language_File($Global{'Language_General_File'});
		&Read_Language_File($Global{'Language_Special_List_File'});

		&Prepare_Categories;
	
		if (!$Param{'Cat_ID'}) {$Param{'Cat_ID'} ="";}	

		&Get_High_Bids_Items($Global{'Hot_Item_Bids'});

	#	$Out=&Get_Items_List("View_Item", "Hot_Auctions", "Hot_Auctions", "");
		$Table = &Get_Items_Page_List("Hot_Auctions", "Hot_Auctions", "View_Item");
		$Plugins{'Items_Count'} = $Items_Count;
		$Plugins{'Body'} = $Table;
		&Get_Menu_Bar(1);
		$Plugins{'Menu_Bar'} .= $Language{'hot_auction_guide_bar'};
		&Display($Global{'Listing_Template'});
}
#==========================================================
sub Seller_Auctions{
my($Temp, $Table);

		&Read_Language_File($Global{'Language_General_File'});
		&Read_Language_File($Global{'Language_Special_List_File'});

		&Prepare_Categories;

		&Get_User_Open_Items($Param{'User_ID'});

		$Table = &Get_Items_Page_List("Seller_Auctions", "Seller_Auctions", "View_Item");
		$Plugins{'Items_Count'} = $Items_Count;
		$Plugins{'Body'} = $Table;
		&Get_Menu_Bar(1);
		$Temp = $Language{'seller_auctions_guide_bar'};
		$Temp =~ s/<!--User_ID-->/$Param{'User_ID'}/g;
		$Plugins{'Menu_Bar'} .= $Temp;

		&Display($Global{'Listing_Template'});
}
#==========================================================
sub Seller_Closed_Auctions{
my($Temp, $Table);

		&Read_Language_File($Global{'Language_General_File'});
		&Read_Language_File($Global{'Language_Special_List_File'});

		&Prepare_Categories;

		&Get_User_Closed_Items($Param{'User_ID'});

		$Table = &Get_Items_Page_List("Seller_Closed_Auctions", "Seller_Closed_Auctions", "View_Archived_Item");
		$Plugins{'Items_Count'} = $Items_Count;
		$Plugins{'Body'} = $Table;
		&Get_Menu_Bar(1);
		$Temp = $Language{'seller_closed_auctions_guide_bar'};
		$Temp =~ s/<!--User_ID-->/$Param{'User_ID'}/g;
		$Plugins{'Menu_Bar'} .= $Temp;

		&Display($Global{'Listing_Template'});
}
#==========================================================
#==========================================================
1;