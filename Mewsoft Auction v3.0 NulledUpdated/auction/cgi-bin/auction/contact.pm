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
sub Contact_Us{

	&Read_Language_File($Global{'Language_General_File'});
	&Read_Language_File($Global{'Language_Contact_Us_File'});

	$Plugins{'Body'}="";
    &Display(&Contact_Us_Form,1);
}
#==========================================================
sub Send_Contact_Us{
my ($Msg);

	&Read_Language_File($Global{'Language_General_File'});
	&Read_Language_File($Global{'Language_Contact_Us_File'});

	$Msg = "";

	if (!&Check_Email_Address($Param{'Contact_Us_Email_Address'})) {
			$Msg .= $Language{'invalid_email'};
	}

	if (!$Param{'Contact_Us_Full_Name'}) {$Msg .= $Language{'error_contact_us_full_name'};}
	if (!$Param{'Contact_Us_Phone'}) {$Msg .= $Language{'error_contact_us_phone'};}
	if (!$Param{'Contact_Us_Subject'}) {$Msg .= $Language{'error_contact_us_subject'};}
	if (!$Param{'Contact_Us_Comments'}) { $Msg .= $Language{'error_contact_us_comments'};}

	if ($Msg) {
					$Plugins{'Body'}=&Msg($Language{'missing_information'}, $Msg, 1);
					&Display($Global{'General_Template'});
					return;
	}

$Msg=<<HTML;
Full name: $Param{'Contact_Us_Full_Name'}
Email: $Param{'Contact_Us_Email_Address'}
Phone: $Param{'Contact_Us_Phone'}
Subject: $Param{'Contact_Us_Subject'}
Comments:
$Param{'Contact_Us_Comments'}

Contact: $Param{'Contact_Us_Contact'}

Remote Address: /$ENV{'REMOTE_ADDR'} $ENV{'REMOTE_HOST'} $ENV{'REMOTE_USER'} $ENV{'REMOTE_IDENT'}
HTML

	&Email($Param{'Contact_Us_Email_Address'}, $Global{'Contact_Us_Email'}, 
								$Language{'contact_us_email_subject'}, "$Msg");

	$Plugins{'Body'}=&Msg($Language{'contact_us_received'}, $Language{'contact_us_received_description'}, 2);
    &Display($Global{'General_Template'});

}
#==========================================================
sub Contact_Us_Form{
my ($Out, $List);

	$Out=&Translate_File($Global{'Contact_Us_Template'});

	$List=qq!<FORM ACTION="$Script_URL" NAME="Contact_Us_Form" METHOD="POST">
					 <input type="hidden" name="Lang" value="$Global{'Language'}">					
					<input type="hidden" name="action" value="Send_Contact_Us">!;

	$Out=~ s/<!--FORM_START-->/$List/;

	$List=qq!<INPUT NAME="Contact_Us_Full_Name" SIZE=35 VALUE="">!;
	$Out=~ s/<!--FULL_NAME-->/$List/;

	$List=qq!<INPUT NAME="Contact_Us_Email_Address" size=35 VALUE="">!;
	$Out=~ s/<!--EMAIL_ADDRESS-->/$List/;

	$List=qq!<INPUT NAME="Contact_Us_Phone" SIZE=20 VALUE="">!;
	$Out=~ s/<!--PHONE_NUMBER-->/$List/;

	$List=qq!<INPUT NAME="Contact_Us_Subject" SIZE=45 VALUE="">!;
	$Out=~ s/<!--SUBJECT-->/$List/;

	$List=qq!<TEXTAREA NAME="Contact_Us_Comments" cols=50 rows=8 wrap=physical value=""></TEXTAREA>!;
	$Out=~ s/<!--COMMENTS-->/$List/;

	$List=qq!<select size="1" name="Contact_Us_Contact">
						<option selected value="Please contact me">$Language{'yes_label'}</option>
						<option value="">$Language{'no_label'}</option>
						</select>!;

	$Out=~ s/<!--CONTACT-->/$List/;

	$Out =~ s/<!--SUBMIT_BUTTON-->/$Language{'submit_button'}/;
	$Out =~ s/<!--CLEAR_FORM_BUTTON-->/$Language{'clear_form_button'}/;
	$Out =~ s/<!--CANCEL_BUTTON-->/$Language{'cancel_button'}/;

	$List  =qq!</FORM>!;
	$Out =~ s/<!--FORM_END-->/$List/;
	
	return $Out;

}
#==========================================================
1;