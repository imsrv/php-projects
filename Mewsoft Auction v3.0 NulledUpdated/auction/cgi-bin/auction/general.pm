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
sub Check_Referer{
	$Check=&Check_Referers;
	if (!$Check) {
		print "Content-type: text/html\n\n";
		&Msg($Language{'referer_error_title'}, $Language{'referer_error_msg'}, 1);
		exit 0;
	}

}
#==========================================================
sub Help_Index{
my($x,$key,$title,$link,$Out);

	&Read_Language_File($Global{'Language_General_File'});
	&Read_Language_File($Global{'Language_Help_File'});
	&Read_Language_File($Global{'Language_Help_Pages_File'});

	$Out=&Translate_File($Global{'Help_Template'});

	for $x(0..100) {
		$key="<!--Help_Link:".$x."-->";
		$title="help_link_title_".$x;
		$Page="help_page_" . $x;
		#if (!$Language{$title}) {	$Language{$title}=$title;}
		if (!$Language{$Page}) {	$Language{$title}="";}
		$link=qq!<a href="$Script_URL?action=Get_Help&Index=$x&Lang=$Global{'Language'}">$Language{$title}</a>!;
		if ($Out=~ m/$key/) {$Out=~ s/$key/$link/g;}
	}

	$Plugins{'Body'}="";
    &Display($Out, 1);

}
#==========================================================
sub Get_Help{

	&Read_Language_File($Global{'Language_General_File'});
	&Read_Language_File($Global{'Language_Help_Pages_File'});

	$Out=&Translate_File($Global{'Help_Pages_Template'});

	$Page="help_page_" . $Param{'Index'};
	$Plugins{'Body'}=$Language{$Page};
    &Display($Out, 1);

}
#==========================================================
sub About_Us{

	&Read_Language_File($Global{'Language_General_File'});
	&Read_Language_File($Global{'Language_About_Us_File'});

	$Plugins{'Body'}="";
    &Display($Global{'About_Us_Template'});

}
#==========================================================
sub User_Agreement{

	&Read_Language_File($Global{'Language_General_File'});
	&Read_Language_File($Global{'Language_User_Agreement_File'});

	$Plugins{'Body'}="";
    &Display($Global{'User_Agreement_Template'});

}
#==========================================================
sub Privacy_Policy{

	&Read_Language_File($Global{'Language_General_File'});
	&Read_Language_File($Global{'Language_Privacy_Policy_File'});

	$Plugins{'Body'}="";
    &Display($Global{'Privacy_Policy_Template'});
}
#==========================================================
sub Ask_Seller{
my($Out, $Name, $Email);

	&Read_Language_File($Global{'Language_General_File'});
	&Read_Language_File($Global{'Language_View_Item_File'});

	if 	(&Check_User_Authentication($Param{'User_ID'}, $Param{'Password'}) == 0 ){
			$Plugins{'Body'}=&Msg($Language{'login_error'}, $Language{'login_error_help'}, 1);
			&Display($Global{'General_Template'});
			exit 0;
	}
	
	&Check_User_Login_Cookie;
	
	($Email, $Name) =&Get_User_Email_and_Name($Param{'User_ID_To_Ask'});

	$Out=$Language{'required_user_email_help'};
	$Out=~ s/<!--USER_ID-->/$Param{'User_ID_To_Ask'}/g;
	$Out=~ s/<!--USER_EMAIL-->/$Email/g;
	$Out=~ s/<!--USER_FULL_NAME-->/$Name/g;

	$Plugins{'Body'}=&Msg($Language{'required_user_email_title'}, $Out, 1);
	&Display($Global{'General_Template'});

}
#==========================================================
sub Get_Languages{
my (@Languages);

	@Languages=split(/\|/, $Global{'Languages'});
	return @Languages;
}
#==========================================================
sub Set_Language{

	&Read_Language_File($Global{'Language_General_File'});
	&Read_Language_File($Global{'Set_Language_File'});

	$Plugins{'Body'}="";
	
	&Display(&Set_Language_Form, 1);

}
#==========================================================
sub Set_Current_Language{

		$Global{'Language'}=$Param{'Language_Selected'};
		$Param{'Lang'}=$Param{'Language_Selected'};

		&Set_Cookies("User_Language", $Param{'Language_Selected'}, 1 );

		&Initialize_Language_Paths;
		&Initialize_Categories;

		&Display_Front_Page;
}
#==========================================================
sub Set_Language_Form{
my(@Languages, $Out, $Form, $List);

	$Out=&Translate_File($Global{'Set_Language_Template'});

	$List=qq!<form NAME="Language_Form" method="POST" action="$Script_URL">
					 <input type="hidden" name="Lang" value="$Global{'Language'}">
					 <input type="hidden" name="action" value="Set_Current_Language">!;

	$Out=~ s/<!--FORM_START-->/$List/;

	@Languages=split(/\|/, $Global{'Languages'});
	
	$List="";

	foreach $lang (@Languages) {
			$check="";
			$langs=$lang;

			if ($lang eq $Global{'Language'}) {
				$check="checked";
				$langs="<B>$lang</B>";
			}

			$Form = $Global{'Set_Language_Form'};
			$Form =~ s/<<Language>>/$lang/;
			$Form =~ s/<<Language_Name>>/$langs/;
			$Form =~ s/<<CHECKED>>/$check/;

			$List .= $Form;
	}
	
	$Out=~ s/<!--LANGUAGE_FORM-->/$List/;

	$Out=~ s/<!--SUBMIT_BUTTON-->/$Language{'submit_button'}/;
	$Out=~ s/<!--CANCEL_BUTTON-->/$Language{'cancel_button'}/;
	$Out=~ s/<!--RESET_BUTTON-->/$Language{'reset_button'}/;

	$Out=~ s/<!--FORM_END-->/<\/FORM>/;

	return $Out;
}
#==========================================================
sub Search_Help{

	&Read_Language_File($Global{'Language_General_File'});
	&Read_Language_File($Global{'Language_Search_Tips_File'});

	$Plugins{'Body'}="";
    &Display($Global{'Search_Tips_Template'});
}
#==========================================================
sub Log_off{

	&Delete_Cookies("User_User_ID", "User_Password", "User_Remember_login");
	eval "use displaylist";
	&Display_Front_Page;

}
#==========================================================
sub Get_Preferences{
my $Out="";
my %Preferences=();

	%Preferences=&Get_Language_File($Global{'Preferences_File'});

	$Out=qq!<SELECT NAME="Search_Preferences" size="1">!;
	@Preferences=sort  keys %Preferences;
	if (!$Param{'Search_Preferences'}) {$Param{'Search_Preferences'} = "All";}

	$Value="";
	foreach $Key(@Preferences)  {
			$Value="";
			if ($Key eq $Param{'Search_Preferences'}) {$Value="selected"};
			$Out.=qq!<OPTION VALUE="$Key" $Value>$Preferences{$Key}</OPTION>!;
	}
	
	$Out .= "</SELECT>";
	return $Out;
}
#==========================================================
sub Search_Main_Form{ 
my ($Width, $Cat_ID) = @_;
my ($Out, $Hidden, $Prefences);
	
	if ($Width <1) {$Width=15;}
	if (!$Param{'Page'}) {$Param{'Page'} = 1;}
	if (!$Param{'Terms'}) {$Param{'Terms'} = "";}
	if (!$Cat_ID) {$Cat_ID = "";}
#<INPUT TYPE="hidden" NAME="Page" VALUE="$Param{'Page'}">
	$Prefences = &Get_Preferences;

$Hidden=<<HTML;
  <input type="hidden" name="action" value="Search">
  <input type="hidden" name="Search" value="All">
  <input type="hidden" name="Cat_ID" value="$Cat_ID">
  <input type="hidden" name="Page" value="1">
  <input type="hidden" name="Lang" value="$Global{'Language'}">
  <input type="hidden" name="Sort" value="$Param{'Sort'}">
  <input type="hidden" name="Dir" value="$Param{'Dir'}">
HTML

	$Out= &Translate($Global{'Search_Main_Form'});
	$Out=~ s/<!--Search_Hidden_Fields-->/$Hidden/;

	$Plugins{'Search_Description'} = qq!<INPUT NAME="Title_and_Description" TYPE="checkbox" VALUE="1">!;
	$Out=~ s/<!--CLASS::Search_Description-->/$Plugins{'Search_Description'}/;

	$Hidden=qq!<INPUT TYPE="TEXT" NAME="Terms" SIZE="$Width" VALUE=\'$Param{'Terms'}\'>!;
	$Out=~ s/<!--Search_Box-->/$Hidden/;
	$Out=~ s/<!--Search_Preferences-->/$Prefences/;
	$Out=~ s/<!--CLASS::Search_Help_Link-->/$Plugins{'Search_Help_Link'}/;

	$Out=~ s/<!--Program_URL-->/$Script_URL/;
	$Out=~ s/<!--Submit_Button-->/$Language{'search_button_main'}/;
	$Out=~ s/<!--CLASS::Image_URL-->/$Global{'ImagesDir'}/;

	$Plugins{'Search_Main'} = $Out;
	return $Out;

}
#==========================================================
sub Search_Category_Form{ 
my ($Width, $Cat_ID) = @_;
my ($Out,  $Hidden, $Prefences);
	
	if ($Width <1) {$Width=15;}
	if (!$Param{'Page'}) {$Param{'Page'} = 1;}
	if (!$Param{'Terms'}) {$Param{'Terms'} = "";}
	if (!$Cat_ID) {$Cat_ID = "";}
	$Prefences = &Get_Preferences;

$Hidden=<<HTML;
<INPUT TYPE="hidden" NAME="action" VALUE="Search">
<INPUT TYPE="hidden" NAME="Search" VALUE="Category">
<INPUT TYPE="hidden" NAME="Cat_ID" VALUE="$Cat_ID">
<INPUT TYPE="hidden" NAME="Lang" VALUE="$Global{'Language'}">
<INPUT TYPE="hidden" NAME="Page" VALUE="1">
<INPUT TYPE="hidden" NAME="Sort" VALUE="$Param{'Sort'}">
<INPUT TYPE="hidden" NAME="Dir" VALUE="$Param{'Dir'}">
HTML

	$Out = &Translate($Global{'Search_Category_Form'});

	$Plugins{'Search_Description'} = qq!<INPUT NAME="Title_and_Description" TYPE="checkbox" VALUE="1">!;
	$Out=~ s/<!--CLASS::Search_Description-->/$Plugins{'Search_Description'}/;
	
	$Out =~ s/<!--Search_Hidden_Fields-->/$Hidden/;
	$Hidden=qq!<INPUT TYPE="TEXT" NAME="Terms" SIZE="$Width" VALUE=\'$Param{'Terms'}\'>!;
	$Out=~ s/<!--Search_Box-->/$Hidden/;

$Hidden=<<HTMLx;
<SELECT NAME="Where" size="1">
<OPTION SELECTED VALUE="All_Auctions">$Language{'search_all_categories'}</OPTION>
<OPTION VALUE="Just_This_Category">$Language{'search_Just_This_Category'}</OPTION>
</SELECT>
HTMLx

	$Out=~ s/<!--Search_Options-->/$Hidden/;
	$Out=~ s/<!--Submit_Button-->/$Language{'search_category_button'}/;
	$Out=~ s/<!--Program_URL-->/$Script_URL/;
	$Out=~ s/<!--CLASS::Image_URL-->/$Global{'ImagesDir'}/;
	$Out=~ s/<!--CLASS::Search_Help_Link-->/$Plugins{'Search_Help_Link'}/;
	$Out=~ s/<!--Search_Preferences-->/$Prefences/;
	
	$Plugins{'Search_Category'} = $Out;

	return $Out;
}
#==========================================================
1;