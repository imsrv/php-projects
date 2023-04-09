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
BEGIN{
	eval "use users";
}
#==========================================================
sub Login_Submit_Item{
my ($Hidden, $Out, $Temp, $Temp1);
	
	&Read_Language_File($Global{'Language_General_File'});
	&Read_Language_File($Global{'Language_Login_File'});

	if ($Category_Accept{$Category_Root{$Param{'Cat_ID'}}} == 0 || $Param{'Cat_ID'} eq ""){
		$Out=$Language{'submit_item_help_title'}. $Language{'submit_item_help'};
		$Plugins{'Category_Tree_Link'}=qq!<A HREF="$Script_URL?action=Display_Categories_Tree&Lang=$Global{'Language'}">$Language{'display_all_categories'}</a>!;
		
		$Temp=$Global{'Category_Unders_Mode'};
		$Temp1=$Global{'Category_Columns'};

		$Global{'Category_Unders_Mode'} = 3;
		$Global{'Category_Columns'}=3;

		$Out.=&Categories_Form("", "Browse_Categories");

		$Global{'Category_Unders_Mode'}=$Temp;
		$Global{'Category_Columns'}=$Temp1;
		
		$Plugins{'Body'}=$Out;
		&Display($Global{'All_Categories_Template'});
		exit 0;
	}

	if ( &Check_Previous_User_Login ) {&Submit_Item; return;}

	$Hidden=qq!<input type="hidden" name="Cat_ID" value=$Param{'Cat_ID'}>!;

	&Login("Submit_Item",
					$Language{'seller_login_form_title'},
					$Language{'seller_login_form_help'},
					$Language{'seller_user_id_label'},
					$Language{'seller_password_label'},
					$Language{'seller_remember_login_label'},
					$Language{'seller_submit_button'},
					$Hidden
					);
	
}
#==========================================================
sub Login_Edit_Profile{

	if ( &Check_Previous_User_Login ) {&Edit_Profile; return;}

	&Read_Language_File($Global{'Language_General_File'});
	&Read_Language_File($Global{'Language_Login_File'});

	&Login("Edit_Profile",
					$Language{'my_profile_login_form_title'},
					$Language{'my_profile_login_form_help'},
					$Language{'my_profile_user_id_label'},
					$Language{'my_profile_password_label'},
					$Language{'my_profile_remember_login_label'},
					$Language{'my_profile_submit_button'},""
					);
}
#==========================================================
sub My_Auctions_Login{
my($List);

	if ( &Check_Previous_User_Login ) {&My_Auctions; return;}

	&Read_Language_File($Global{'Language_General_File'});
	&Read_Language_File($Global{'Language_Login_File'});

	$List=qq!<input type="hidden" name="Page" value="1">!;

	&Login("My_Auctions",
					$Language{'my_auctions_login_form_title'},
					$Language{'my_auctions_login_form_help'},
					$Language{'my_auctions_user_id_label'},
					$Language{'my_auctions_password_label'},
					$Language{'my_auctions_remember_login_label'},
					$Language{'my_auctions_submit_button'}, $List
					);
}
#==========================================================
sub Account_Manager_Login{
my($List);

	if ( &Check_Previous_User_Login ) {&Account_Manager; return;}

	&Read_Language_File($Global{'Language_General_File'});
	&Read_Language_File($Global{'Language_Login_File'});

	&Login("Account_Manager",
					$Language{'account_manager_login_form_title'},
					$Language{'account_manager_login_form_help'},
					$Language{'account_manager_user_id_label'},
					$Language{'account_manager_password_label'},
					$Language{'account_manager_remember_login_label'},
					$Language{'account_manager_submit_button'}, ""
					);
}
#==========================================================
sub My_Closed_Auctions_Login{
my($List);

	if ( &Check_Previous_User_Login ) {&My_Closed_Auctions; return;}

	&Read_Language_File($Global{'Language_General_File'});
	&Read_Language_File($Global{'Language_Login_File'});

	$List=qq!<input type="hidden" name="Page" value="1">!;

	&Login("My_Closed_Auctions",
					$Language{'my_auctions_login_form_title'},
					$Language{'my_auctions_login_form_help'},
					$Language{'my_auctions_user_id_label'},
					$Language{'my_auctions_password_label'},
					$Language{'my_auctions_remember_login_label'},
					$Language{'my_auctions_submit_button'}, $List
					);
}
#==========================================================
sub Feedback_Login{

	if ( &Check_Previous_User_Login ) {&Feedback_Forum; return;}

	&Read_Language_File($Global{'Language_General_File'});
	&Read_Language_File($Global{'Language_Login_File'});

	&Login("Feedback_Forum",
					$Language{'feedback_login_form_title'},
					$Language{'feedback_login_form_help'},
					$Language{'feedback_user_id_label'},
					$Language{'feedback_password_label'},
					$Language{'feedback_remember_login_label'},
					$Language{'feedback_submit_button'},""
					);
}
#==========================================================
sub Ask_Seller_Login{
my($List);

	if ( &Check_Previous_User_Login ) {&Ask_Seller; return;}

	&Read_Language_File($Global{'Language_General_File'});
	&Read_Language_File($Global{'Language_Login_File'});

	$List=qq!<input type="hidden" name="User_ID_To_Ask" value="$Param{'User_ID_To_Ask'}">!;
	&Login("Ask_Seller",
					$Language{'ask_seller_login_form_title'},
					$Language{'ask_seller_login_form_help'},
					$Language{'ask_seller_user_id_label'},
					$Language{'ask_seller_password_label'},
					$Language{'ask_seller_remember_login_label'},
					$Language{'ask_seller_submit_button'},
					$List
					);
}
#==========================================================
sub Forgot_Username{

	&Read_Language_File($Global{'Language_General_File'});
	&Read_Language_File($Global{'Language_Login_File'});

	&Forgot_Login("Send_Forgot_Username",
								$Language{'search_for_userid_title'},
								$Language{'search_for_userid_help'},
								$Language{'your_email_label'},
								$Language{'submit_search_user_id_button'},""
								);
}
#==========================================================
sub Forgot_Password{

	&Read_Language_File($Global{'Language_General_File'});
	&Read_Language_File($Global{'Language_Login_File'});

	&Forgot_Login("Send_Forgot_Password",
								$Language{'search_for_password_title'},
								$Language{'search_for_password_help'},
								$Language{'your_user_id_label'},
								$Language{'submit_password_search_button'},""
								);
}
#==========================================================
sub Send_Forgot_Password{
my $Found;

	&Read_Language_File($Global{'Language_General_File'});
	&Read_Language_File($Global{'Language_Login_File'});

	($Found, $Email)=&Get_User_Password_by_User_ID($Param{'User_in'});
	if ($Found eq "") {
		$Out=&Msg($Language{'no_password_found_title'}, $Language{'no_password_found_help'}, 1);
		$Plugins{'Body'}=$Out;
		&Display($Global{'General_Template'});
	}
	else{
		$msg=$Language{'found_password_email_message'};
		$msg=~ s/<<PASSWORD>>/$Found/g;
		
		#Email($From, $TO, $Subject,   $Message);
		&Email($Global{'Webmaster_Email'}, $Email, 
					$Language{'found_password_email_subject'}, $msg);

		$Out=&Msg($Language{'password_found_title'}, $Language{'password_found_help'}, 2);
		$Plugins{'Body'}=$Out;
		&Display($Global{'General_Template'});

	}

}
#==========================================================
sub Forgot_Login{
my($Action, $Title, $Help, $Box_Label, $Submit_Button, $Hidden)=@_;
my $Out;

	$Out=&Translate_File($Global{'ForgotLoginTemplate'});

	$Out=~ s/<!--FORGOT_LOGIN_TITLE-->/$Title/;
	$Out=~ s/<!--FORGOT_LOGIN_HELP-->/$Help/;
	$Out=~ s/<!--FORGOT_LOGIN_BOX_LABEL-->/$Box_Label/;

	$List=qq!<FORM NAME="Forgot_Login" ACTION="$Script_URL" METHOD="POST">
					<input type="hidden" name="action" value="$Action">!;
	$List.=$Hidden;
	$Out=~ s/<!--FORM_START-->/$List/;

	$List=qq!<INPUT NAME="User_in" SIZE=22 VALUE="" onFocus="select();">!;
	$Out=~ s/<!--FORGOT_LOGIN_BOX-->/$List/;

	$List=qq!<input type="submit" value=" $Submit_Button">!;
	$Out=~ s/<!--SUBMIT_BUTTON-->/$Submit_Button/;

	$List=qq!<input type="reset" value="$Language{'reset_button'}">!;
	$Out=~ s/<!--RESET_BUTTON-->/$Language{'reset_button'}/;

	$List=qq!<input onclick="history.go(-1);" type="button" value="$Language{'cancel_button'}">!;
	$Out=~ s/<!--CANCEL_BUTTON-->/$Language{'cancel_button'}/;

	$List=qq!</FORM>!;
	$Out=~ s/<!--FORM_END-->/$List/;
	
	$Plugins{'Body'}=$Out;
	&Display($Out,1);

}
#==========================================================
sub Send_Forgot_Username{
my $Found;

	&Read_Language_File($Global{'Language_General_File'});
	&Read_Language_File($Global{'Language_Login_File'});

	$Found=&Get_User_ID_by_Email($Param{'User_in'});
	if ($Found eq "") {
		$Out=&Msg($Language{'no_username_found_title'}, $Language{'no_username_found_help'}, 1);
		$Plugins{'Body'}=$Out;
		&Display($Global{'General_Template'});
	}
	else{
		$msg=$Language{'found_userid_email_message'};
		$msg=~ s/<<USER_ID>>/$Found/g;
		
		#Email($From, $TO, $Subject,   $Message);
		&Email($Global{'Webmaster_Email'}, $Param{'User_in'}, 
					$Language{'found_userid_email_subject'}, $msg);

		$Out=&Msg($Language{'username_found_title'}, $Language{'username_found_help'}, 2);
		$Plugins{'Body'}=$Out;
		&Display($Global{'General_Template'});

	}

}
#==========================================================
sub Login{
my ($Action, $Title, $Help, $User_ID_Label, 
		$Password_Label, $Remember_Login_Label, $Submit_Button, $Hidden_Fields,)=@_;
my ($User_ID, $Password, $Check, $Remember_login);

	#------------------------------------------------------------------
	if (!$Cookies{'User_User_ID'}) {$Cookies{'User_User_ID'} = "";}
	if (!$Cookies{'User_Password'}) {$Cookies{'User_Password'} = "";}
	if (!$Cookies{'User_Remember_login'}) {$Cookies{'User_Remember_login'} = "";}	

	$User_ID=$Cookies{'User_User_ID'};
	$Password=$Cookies{'User_Password'};
	$Remember_login=$Cookies{'User_Remember_login'};
	
	#------------------------------------------------------------------
	$Out=&Translate_File($Global{'Login_Template'});
	#------------------------------------------------------------------
	$Out=~ s/<!--LOGIN_FORM_TITLE-->/$Title/;
	$Out=~ s/<!--LOGIN_FORM_HELP-->/$Help/;
	$Out=~ s/<!--USER_ID_LABEL-->/$User_ID_Label/;
	$Out=~ s/<!--PASSWORD_LABEL-->/$Password_Label/;
	$Out=~ s/<!--REMEMBER_LOGIN_LABEL-->/$Remember_Login_Label/;
	#------------------------------------------------------------------
	$List=qq!<form name="User_Login" method="POST" action="$Script_URL">
					 <input type="hidden" name="Lang" value="$Global{'Language'}">!;
	$List.=qq!<input type="hidden" name="action" value="$Action">!;

	$List.=$Hidden_Fields;
	$Out=~ s/<!--FORM_START-->/$List/;

	$List=qq!<INPUT  name="User_ID" size="20" value="$User_ID">!;
	$Out=~ s/<!--USER_ID_BOX-->/$List/;

	$List=qq!<INPUT name="Password" size="20" type="password" value="$Password">!;
	$Out=~ s/<!--PASSWORD_BOX-->/$List/;

	$Check="";
	if ($Remember_login) { $Check="checked";	}
	$List=qq!<input  name="Remember_login" type="checkbox" value="yes" CHECKED>!;

	$Out=~ s/<!--REMEMBER_LOGIN_BUTTON-->/$List/;

	$List=qq!<A HREF="$Script_URL?action=Forgot_Username">$Language{'forgot_username'}</A>!;
	$Out=~ s/<!--FORGOT_USERNAME-->/$List/;

	$List=qq!<A HREF="$Script_URL?action=Forgot_Password">$Language{'forgot_password'}</A>!;
	$Out=~ s/<!--FORGOT_PASSWORD-->/$List/;
	
	$List=qq!<A HREF="#" onclick="document.User_Login.submit(); return false;"><B>$Submit_Button</B></A>!;
	$Out=~ s/<!--SUBMIT_BUTTON-->/$List/;
	$Out=~ s/<!--RESET_BUTTON-->/$Language{'reset_button'}/;
	$Out=~ s/<!--CANCEL_BUTTON-->/$Language{'cancel_button'}/;

	$Out=~ s/<!--FORM_END-->/<\/FORM>/g;
	#-------------------------------------------------------------------

	$Plugins{'Body'}="";
	&Display($Out, 1);
}
#==========================================================
sub Check_User_Login_Cookie{
	
	if ($Param{'Remember_login'}){
			$Param{'User_ID'}=lc($Param{'User_ID'});
			&Set_Cookies ("User_User_ID", $Param{'User_ID'}, 1 );
			&Set_Cookies ("User_Password", $Param{'Password'}, 1);
			&Set_Cookies ("User_Remember_login", "yes", 1 );
	}
	else{
			&Delete_Cookies("User_User_ID", "User_Password", "User_Remember_login");
	}

}
#==========================================================
#==========================================================
1;