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
sub Announcements{
my($Out, $Form, $Body, $key, $value, $List, %Announcements);
my(%data,%data1, $URL, $Subject, $Message, $Form1);

	&Read_Language_File($Global{'Language_General_File'});
	&Read_Language_File($Global{'Language_Announcements_File'});

	$Out=&Translate_File($Global{'Announcements_Template'});
	$Form=&Translate($Global{'Announcements_Form'});

	&DB_Exist($Global{'Announcements_File'});
	tie %data1, "DB_File", "$Global{'Announcements_File'}", O_RDONLY
                                   or die "Cannot open database file $Global{'Announcements_File'}: $!\n";

	%data=%data1;
	untie %data1;
	undef %data1;

	$Body="";

	while (($key, $value) = each(%data)) {
			$Form1=$Form;
			($time, $Subject)=split(/\=/, $key);
			#$value=&Encode_HTML($value);
			($URL, $Message)=split(/~==~/, $value);
 			$Form1=~ s/<!--ANNOUNCEMENT_TITLE-->/$Subject/;

			if ($Form1=~ m/(<!--)(ANNOUNCEMENT::Date_Time)(:)(\d{1,3})(-->)/ ){
					$s = $1 . $2 . $3 . $4 . $5;
					$x=&Get_Date_Formated($4, $time);
					$Form1=~ s/$s/$x/g;
			}

			$U="$URL";
			$URL=&Encode_HTML($URL);
			$Form1=~ s/<!--ANNOUNCEMENT_URL-->/$U/;
			#$Message=&Encode_HTML($Message);
			#$Message=~ s/\&lt\;/</g;
			#$Message=~ s/\&gt\;/>/g;
			$Form1=~ s/<!--ANNOUNCEMENT_MESSAGE-->/$Message/;
			$Announcements{$time}=$Form1;
			#$Body.=$Form1;
	} 
	
	@Dates=sort keys %Announcements;
	 @Dates = reverse @Dates;
#@Dates = sort {$b <=> $a} @dates;

	for $x (0..$#Dates) {
			$Body.=$Announcements{$Dates[$x]};
	}

	
	$Out=~ s/<!--ANNOUNCEMENTS-->/$Body/;

	$List=qq!<A HREF="#announcements_title">$Language{'back_to_top_label'}</A>!;
	$Out=~ s/<!--TOP_OF_PAGE-->/$List/;

	$List=qq!<A HREF="javascript:history.go(-1)">$Language{'cancel_button'}</A>!;
	$Out=~ s/<!--CANCEL_BUTTON-->/$List/;

	$Plugins{'Body'} = "";
	&Display($Out, 1);

}
#==========================================================
#==========================================================
1;