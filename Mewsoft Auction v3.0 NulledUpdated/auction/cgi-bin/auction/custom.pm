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
sub Custom_Body{
my($Sub, $File);

	&Read_Language_File($Global{'Language_General_File'});
	&Read_Language_File($Global{'Language_Custom_File'});

	$Sub=$Param{'Sub'};
	$File=$Param{'File'};
	require("$Global{'CustomDir'}/$File.pm");
	$Plugins{'Body'}=&$Sub($Param{'Param'});
	
	$Param{'Temp'} .= ".html" unless ($Param{'Temp'}=~ m/\./ );

	&Display("$Global{'TemplateDir'}/$Param{'Temp'}");
	
}
#==========================================================
sub Do_Custom_Classes{
my ($Out)=@_;
my ($Class, $Classes, $User_Class, $Params_to_Pass);

		while (	$Out =~ /(<!--)(CLASS::Custom)(:)(.*)(-->)/){
					$Class = $1 . $2 . $3 . $4 . $5;
					$User_Class = $4;

					if($User_Class =~ /(.*)(\(.*\))(.*)/) {
									$User_Class = $1;
									$Params_to_Pass = $2;
									$Params_to_Pass =~ s/^\s*\(//g;
									$Params_to_Pass =~ s/\)\s*$//g;
									@_ = split( /\,/ ,   $Params_to_Pass);
					}
					require("$Global{'CustomDir'}/$User_Class.pm");#if (-e "$Global{'CustomDir'}/$User_Class.pm");
					$Output = &$User_Class($Params_to_Pass);
					$Classes = quotemeta($Class);
					$Out =~ s/$Classes/$Output/;
		}
		return $Out;
}
#==========================================================
#==========================================================
1;
