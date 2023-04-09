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
sub TextLine{
my ($Name, $Value, $Size)=@_;
my $Out;

	$Out=qq!<input type="text" name="$Name" size="$Size" value="$Value">!;
	
	return $Out;
}
#==========================================================
sub TextBox{
my ($Name, $Value, $Columns, $Rows)=@_;
my $Out;

	$Out=qq!<textarea rows="$Rows" name="$Name" cols="$Columns">$Value</textarea>!;

	return $Out;
}
#==========================================================
sub CheckBox{
my ($Name, $Value, $State)=@_;
my $Out;
	
	$Check="";
	if ($State ne "") {$Check="checked";}
	$Out=qq!<input type="checkbox" name="$Name" value="$Value" $Check>!;
	
	return $Out;
}
#==========================================================
sub RadioButton{
my ($Name, $Value, $State)=@_;
my $Out;
	
	$Check="";
	if ($State ne "") {$Check="checked";}
	$Out=qq!<input type="radio" value="$Value"  name="$Name"  $Check>!;
	
	return $Out;
}
#==========================================================
sub DropDownMenu{
my ($Name, $Value, $State)=@_;
my $Out;

	$Out=qq!<select size="1" name="$Name">
					 <option selected value="$Value1">$Item1</option>
					 </select>!;
	return $Out;
 }
#==========================================================
sub Read_Language_File{
my $Language_Filename=shift;

my @Variables;
my $Line;
my $delimiter;
my ($Key, $Value);

	open(FILE, "$Language_Filename") or
									&Exit("Error: Can't open file language file $Language_Filename: $!"."<BR>Line ". __LINE__ . ", File ". __FILE__);
	@Variables = <FILE>;
	close(FILE);
	
	#$/="\n";
	foreach $Line (@Variables) {
		chomp($Line);
		$delimiter=qq!~==~!;
		($Key, $Value)=split(/$delimiter/, $Line);
		$Value =~ s/\'/\&\#39\;/g;
		$Language{$Key}="$Value";
	}

}
#==========================================================
sub Get_Language_File{ 
my ($Language_Filename) = @_;
my (%Langs, @Variables, $Line);
my ($Key, $Value);

	open(FILE, "$Language_Filename") or
									&Exit("Error: Can't open file lnaguage file $Language_Filename: $!"."<BR>Line ". __LINE__ . ", File ". __FILE__);
	@Variables = <FILE>;
	close(FILE);
	
	foreach $Line (@Variables) {
				chomp($Line);
				($Key, $Value)=split('~==~', $Line);
				$Value =~ s/\'/\&\#39\;/g;
				$Key=~ s/^\s+//;
				if ($Key) {
						$Langs{$Key} = $Value;
				}
	}
	return  %Langs;
}
#==========================================================
sub Translate_File{
my $Template_File=shift;
my @Templ;

	open(FILE, "$Template_File")
				or &Exit("Error, Can't open file $Template_File: $!"."<BR>Line ". __LINE__ . ", File ". __FILE__);

    @Templ = <FILE>;
    close(FILE);

	$Out=join("", @Templ);
	$Out=Translate($Out);
	return $Out;
}
#==========================================================
sub Translate{
my $Text=shift;
my ($Key, $Value);

	while ( ($Key, $Value)=each(%Language) ) {
		$Key="<<"."$Key".">>";
		$Text=~ s/$Key/$Value/gs;
	}

	return $Text;
}
#==========================================================
sub Translate_Classes{
my ($Out)=shift;
my($key, $value);

	while ( ($key, $value)=each(%Plugins) ) {
				$plugin="<!--CLASS::".$key."-->";
				$Out=~ s/$plugin/$Plugins{$key}/g  if (defined ($Plugins{$key}) );
	}
	return $Out;
}
#==========================================================
sub Read_Classes{
my ($Line, $key, $value, $Cat);
my ($plugin, $s, $x);
my $Out;

if ($Global{'SSL_Status'} eq "YES"){
	$Plugins{'Sign_in'}=qq!<A HREF="$Global{'SSL_URL'}?action=Sign_in&Lang=$Global{'Language'}" >$Language{'sign_in'}</a>!;
#	$Plugins{'Edit_Profile'}=qq!<A HREF="$Global{'SSL_URL'}?action=Edit_Profile_login&Lang=$Global{'Language'}">$Language{'edit_profile'}</a>!;
}
else{
	$Plugins{'Sign_in'}=qq!<A HREF="$Script_URL?action=Sign_in&Lang=$Global{'Language'}" >$Language{'sign_in'}</a>!;
#	$Plugins{'Edit_Profile'}=qq!<A HREF="$Script_URL?action=Edit_Profile_login&Lang=$Global{'Language'}">$Language{'edit_profile'}</a>!;
}

if (!$Global{'Categories_Count'}) {$Global{'Categories_Count'}=0;}
$Plugins{'Categories_Count'} = $Global{'Categories_Count'};
if (!$Global{'Total_Items_Count'}) {$Global{'Total_Items_Count'}=0;}
$Plugins{'Total_Items_Count'} = $Global{'Total_Items_Count'};
$Plugins{'Site_Name'}=$Global{'Site_Name'};
if (!$Global{'Total_Users_Count'}) {$Global{'Total_Users_Count'}=0;}
$Plugins{'Total_Users_Count'}=$Global{'Total_Users_Count'};#&Get_Users_Count;

if (!($Param{'Cat_ID'})) {$Param{'Cat_ID'}="";}
$Cat = "Cat_ID=" . $Param{'Cat_ID'};
if (!($Param{'User_ID'})) {$Param{'User_ID'}="";}

$Plugins{'Edit_Profile'}=qq!<A HREF="$Script_URL?action=Edit_Profile_login&Lang=$Global{'Language'}&User_ID=$Param{'User_ID'}">$Language{'edit_profile'}</a>!;
$Plugins{'Language'}=qq!<A HREF="$Script_URL?action=Set_Language&Lang=$Global{'Language'}">$Language{'set_language'}</a>!;
$Plugins{'Contact_Us'}=qq!<A HREF="$Script_URL?action=Contact_Us&Lang=$Global{'Language'}" >$Language{'contact_us'}</a>!;
$Plugins{'Announcements'}=qq!<A HREF="$Script_URL?action=Announcements&Lang=$Global{'Language'}" >$Language{'announcements'}</a>!;
$Plugins{'Log_off'}=qq!<A HREF="$Script_URL?action=Log_off&Lang=$Global{'Language'}" >$Language{'log_off'}</a>!;
$Plugins{'My_Auctions'}=qq!<A HREF="$Script_URL?action=My_Auctions_Login&Lang=$Global{'Language'}&Page=1&User_ID=$Param{'User_ID'}" >$Language{'my_auctions'}</a>!;
$Plugins{'New_Auctions'}=qq!<A HREF="$Script_URL?action=New_Auctions&$Cat&Lang=$Global{'Language'}&Page=1" >$Language{'new_auctions'}</a>!;
$Plugins{'Ending_Now'}=qq!<A HREF="$Script_URL?action=Ending_Now&$Cat&Lang=$Global{'Language'}&Page=1" >$Language{'ending_now'}</a>!;
$Plugins{'Hot_Auctions'}=qq!<A HREF="$Script_URL?action=Hot_Auctions&$Cat&Lang=$Global{'Language'}&Page=1" >$Language{'hot_auctions'}</a>!;
$Plugins{'Cool_Auctions'}=qq!<A HREF="$Script_URL?action=Cool_Auctions&$Cat&Lang=$Global{'Language'}&Page=1" >$Language{'cool_auctions'}</a>!;
$Plugins{'Big_Ticket'}=qq!<A HREF="$Script_URL?action=Big_Ticket&$Cat&Lang=$Global{'Language'}&Page=1" >$Language{'big_ticket'}</a>!;
$Plugins{'Featured'}=qq!<A HREF="$Script_URL?action=Featured&$Cat&Lang=$Global{'Language'}&Page=1" >$Language{'featured'}</a>!;

$Plugins{'Feedback'}=qq!<A HREF="$Script_URL?action=Feedback_Login&Lang=$Global{'Language'}&User_ID=$Param{'User_ID'}" >$Language{'feedback'}</a>!;
$Plugins{'Account_Manager'}=qq!<A HREF="$Script_URL?action=Account_Manager_Login&Lang=$Global{'Language'}" >$Language{'account_manager'}</a>!;

$Plugins{'Account_Overview'}=qq!<A HREF="$Script_URL?action=Account_Overview&Lang=$Global{'Language'}&User_ID=$Param{'User_ID'}" >$Language{'account_overview'}</a>!;
$Plugins{'Account_Activity'}=qq!<A HREF="$Script_URL?action=Account_Activity&Lang=$Global{'Language'}&User_ID=$Param{'User_ID'}" >$Language{'account_activity'}</a>!;
$Plugins{'Account_Current_Auctions'}=qq!<A HREF="$Script_URL?action=Seller_Auctions&Lang=$Global{'Language'}&User_ID=$Param{'User_ID'}" >$Language{'account_current_auctions'}</a>!;
$Plugins{'Account_Closed_Auctions'}=qq!<A HREF="$Script_URL?action=Seller_Closed_Auctions&Lang=$Global{'Language'}&User_ID=$Param{'User_ID'}" >$Language{'account_closed_auctions'}</a>!;
$Plugins{'Account_Edit_Profile'}=qq!<A HREF="$Script_URL?action=Edit_Profile_login&Lang=$Global{'Language'}&User_ID=$Param{'User_ID'}" >$Language{'account_edit_profile'}</a>!;
$Plugins{'Account_Feedback_profile'}=qq!<A HREF="$Script_URL?action=Account_Feedback&Lang=$Global{'Language'}&User_ID=$Param{'User_ID'}" >$Language{'account_account_Feedback_profile'}</a>!;

$Plugins{'Submit_Item'}=qq!<A HREF="$Script_URL?action=Submit_Item_Login&$Cat&Lang=$Global{'Language'}&User_ID=$Param{'User_ID'}">$Language{'submit_item'}</a>!;
$Plugins{'Category_Tree'}=qq!<A HREF="$Script_URL?action=Display_Categories&Lang=$Global{'Language'}">$Language{'category_tree'}</a>!;
$Plugins{'Home'}=qq!<A HREF="$Script_URL?Lang=$Global{'Language'}">$Language{'home'}</A>!;
$Plugins{'Site_Home'}=qq!<A HREF="$Language{'Site_Home_URL'}">$Language{'Site_Home_Name'}</A>!;
$Plugins{'Search_Help_Link'}=qq!<A HREF="$Script_URL?action=Search_Help&$Cat&Lang=$Global{'Language'}">$Language{'Search_Help_Link'}</a>!;
$Plugins{'Previous_Page_Link'}=qq!<A HREF="javascript:history.go(-1)">$Language{'previous_page_label'}</A>!;
$Plugins{'Next_Page_Link'}=qq!<A HREF="javascript:history.go(1)">$Language{'next_page_label'}</A>!;
$Plugins{'Advanced_Search_Link'}=qq!<a href="$Script_URL?action=Smart_Search&Lang=$Global{'Language'}">$Language{'smart_search'}</a>!;
$Plugins{'User_Agreement'}=qq!<a href="$Script_URL?action=User_Agreement&Lang=$Global{'Language'}">$Language{'user_agreement'}</a>!;
$Plugins{'Privacy_Policy'}=qq!<a href="$Script_URL?action=Privacy_Policy&Lang=$Global{'Language'}">$Language{'privacy_policy'}</a>!;
$Plugins{'Help'}=qq!<a href="$Script_URL?action=Help&Lang=$Global{'Language'}">$Language{'help_button_label'}</a>!;
$Plugins{'About_Us'}=qq!<a href="$Script_URL?action=About_Us&Lang=$Global{'Language'}">$Language{'about_us_button_label'}</a>!;
$Plugins{'Image_URL'}=$Global{'ImagesDir'};
$Plugins{'Currency_Symbol'}=$Global{'Currency_Symbol'};
$Plugins{'CGI_URL'} = $Global{'CGI_URL'};
$Plugins{'HTML_URL'} = $Global{'HTML_URL'};

if (&Check_Previous_User_Login ) {
	$Plugins{'Welcome_User'}=$Param{'User_ID'};
}
else{
	$Plugins{'Welcome_User'}=$Language{'welcome_new_user'};
}

$Plugins{'Search_Description'}=qq!<INPUT NAME="Title_and_Description" TYPE="checkbox" VALUE="1">!;

$Plugins{'Header'}=&Translate($Global{'Header'});
$Plugins{'Footer'}=&Translate($Global{'Footer'}); 
$Plugins{'Top_Navigation'}=&Translate($Global{'Top_Navigation'});
$Plugins{'Bottom_Navigation'}=&Translate($Global{'Bottom_Navigation'});
$Plugins{'Side_Navigation'}=&Translate($Global{'Side_Navigation'});
$Plugins{'General'}=&Translate($Global{'General'});
$Plugins{'Extra'}=&Translate($Global{'Extra'});
$Plugins{'Form_Start'}=qq!<form method="POST" action="$Script_URL">!;
$Plugins{'Form_End'}="</FORM>";

}
#==========================================================
sub Display{
my ($Template, $Translated_Flag) = @_; 
my ($Line, $key, $value, $Cat);
my ($plugin, $s, $x);
my $Out;

	&Read_Classes;

	if ($Translated_Flag eq "") {
			$Out=&Translate_File("$Template");
	}
	else{
			$Out=$Template;
	}

	while ( ($key, $value)=each(%Plugins) ) {
		$plugin="<!--CLASS::".$key."-->";
		$Out=~ s/$plugin/$Plugins{$key}/g  if (defined ($Plugins{$key}) );
	}

	#<!--CLASS::Custom:user_subs(param1,...)--> <!--CLASS::Custom:Menu-->
	$Out = &Do_Custom_Classes("$Out");
	$Out = &Do_SSI_Classes("$Out");

	$Global{'Program_End_Time'}=time;
	$Plugins{'Benchmark'} = $Global{'Program_End_Time'} - $Global{'Program_Start_Time'};

	while ( ($key, $value)=each(%Plugins) ) {
		$plugin="<!--CLASS::".$key."-->";
		$Out=~ s/$plugin/$Plugins{$key}/g if (defined ($Plugins{$key}));
	}

	#<!--CLASS::Search_Main:20-->
	while ($Out=~ m/(<!--)(CLASS::Search_Main)(:)(\d{1,3})(-->)/  ){
		$s = $1 . $2 . $3 . $4 . $5;
		$x=&Search_Main_Form($4, $Param{'Cat_ID'});
		$Out=~ s/$s/$x/g;
	}

	#<!--CLASS::Search_Category:20-->
	while ($Out=~ m/(<!--)(CLASS::Search_Category)(:)(\d{1,3})(-->)/  ){
		$s = $1 . $2 . $3 . $4 . $5;
		if ($Param{'Cat_ID'}) {
				$x=&Search_Category_Form($4, $Param{'Cat_ID'});
		}
		else{
				$x=&Search_Main_Form($4, $Param{'Cat_ID'});
		}
		$Out=~ s/$s/$x/g;
	}

	#<!--CLASS::Date_Time:20-->
	while ($Out=~ m/(<!--)(CLASS::Date_Time)(:)(\d{1,3})(-->)/ ){
		$s = $1 . $2 . $3 . $4 . $5;
		$x=&Get_Date_Formated($4);
		$Out=~ s/$s/$x/g;
	}
	
	print "Content-type: text/html\n\n";
	print "$Out";

	#$Output=join("", values %Set_Cookies);
	#$Output.="Content-type: text/html\n\n" .  "$Out";
	 #print "$Output";

}# End sub Display
#==========================================================
#==========================================================
1;