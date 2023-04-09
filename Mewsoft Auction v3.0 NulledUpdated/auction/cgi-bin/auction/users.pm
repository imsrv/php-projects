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
sub Check_User_Exist{
my ($User_ID)=shift;
my ($Found, %data);
my($UN,$PW,$FN,$MI,$LN,$CM,$S1,$S2,$CT,$ST,$Z,$CY,$PH,$EX,$FX,$EM,$PM,$NOC,
			$CCN,$CTP,$EXM,$EY,$S3,$S4,$CT1,$ST1,$Z1,$CY1,$Prf );

&DB_Exist($Global{'RegistrationFile'});
tie %data, "DB_File", $Global{'RegistrationFile'}, O_RDONLY
        or &Exit("Cannot open database file $Global{'RegistrationFile'} : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

$Found=0;
foreach  $ID (keys %data ) {
	($UN,$PW,$FN,$MI,$LN,$CM,$S1,$S2,$CT,$ST,$Z,$CY,$PH,$EX,$FX,$EM,$PM,$NOC,
			$CCN,$CTP,$EXM,$EY,$S3,$S4,$CT1,$ST1,$Z1,$CY1,$Prf )=split(/\|/, $data{$ID});
	if (lc($User_ID) eq lc($UN) ) {$Found=1; last; }
}

untie %data;
return $Found;
}
#==========================================================
sub Check_Email_Exist{
my ($Email)=shift;
my ($Found, %data);
my($UN,$PW,$FN,$MI,$LN,$CM,$S1,$S2,$CT,$ST,$Z,$CY,$PH,$EX,$FX,$EM,$PM,$NOC,
			$CCN,$CTP,$EXM,$EY,$S3,$S4,$CT1,$ST1,$Z1,$CY1,$Prf );

&DB_Exist($Global{'RegistrationFile'});
tie %data, "DB_File", $Global{'RegistrationFile'}, O_RDONLY
        or &Exit("Cannot open database file $Global{'RegistrationFile'} : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

$Found=0;
foreach  $ID (keys %data ) {
	($UN,$PW,$FN,$MI,$LN,$CM,$S1,$S2,$CT,$ST,$Z,$CY,$PH,$EX,$FX,$EM,$PM,$NOC,
			$CCN,$CTP,$EXM,$EY,$S3,$S4,$CT1,$ST1,$Z1,$CY1,$Prf )=split(/\|/, $data{$ID});
	if (lc($EM) eq lc($Email) ) {$Found=1; last; }
}

untie %data;
return $Found;
}
#==========================================================
sub Get_User_ID_by_Email{
my $User_Email=shift;
my ($Found, %data);
my($UN,$PW,$FN,$MI,$LN,$CM,$S1,$S2,$CT,$ST,$Z,$CY,$PH,$EX,$FX,$EM,$PM,$NOC,
			$CCN,$CTP,$EXM,$EY,$S3,$S4,$CT1,$ST1,$Z1,$CY1,$Prf );

&DB_Exist($Global{'RegistrationFile'});
tie %data, "DB_File", $Global{'RegistrationFile'}, O_RDONLY
        or &Exit("Cannot open database file $Global{'RegistrationFile'} : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);
$Found="";
foreach  $ID (keys %data ) {
	($UN,$PW,$FN,$MI,$LN,$CM,$S1,$S2,$CT,$ST,$Z,$CY,$PH,$EX,$FX,$EM,$PM,$NOC,
			$CCN,$CTP,$EXM,$EY,$S3,$S4,$CT1,$ST1,$Z1,$CY1,$Prf )=split(/\|/, $data{$ID});
	if ($User_Email eq $EM ) {$Found=$UN; last; }
}

untie %data;
return $Found;			#return user name
}
#==========================================================
sub Get_User_Password_by_User_ID{
my ($User_ID)=shift;
my ($Found, %data);
my ($UN,$PW,$FN,$MI,$LN,$CM,$S1,$S2,$CT,$ST,$Z,$CY,$PH,$EX,$FX,$EM,$PM,$NOC,
			$CCN,$CTP,$EXM,$EY,$S3,$S4,$CT1,$ST1,$Z1,$CY1,$Prf );

&DB_Exist($Global{'RegistrationFile'});
tie %data, "DB_File", $Global{'RegistrationFile'}, O_RDONLY
        or &Exit("Cannot open database file $Global{'RegistrationFile'} : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

$Found="";
foreach  $ID (keys %data ) {
	($UN,$PW,$FN,$MI,$LN,$CM,$S1,$S2,$CT,$ST,$Z,$CY,$PH,$EX,$FX,$EM,$PM,$NOC,
			$CCN,$CTP,$EXM,$EY,$S3,$S4,$CT1,$ST1,$Z1,$CY1,$Prf )=split(/\|/, $data{$ID});
	if (lc($User_ID) eq lc($UN) ) {$Found=$PW; last; }
}

untie %data;
return ($Found, $EM);			#return user password and email
}
#==========================================================
sub Get_User_Email_and_Name{
my ($User_ID)=shift;
my ($Found, %data);

my($UN,$PW,$FN,$MI,$LN,$CM,$S1,$S2,$CT,$ST,$Z,$CY,$PH,$EX,$FX,$EM,$PM,$NOC,
			$CCN,$CTP,$EXM,$EY,$S3,$S4,$CT1,$ST1,$Z1,$CY1,$Prf );

&DB_Exist($Global{'RegistrationFile'});
tie %data, "DB_File", $Global{'RegistrationFile'}, O_RDONLY
        or &Exit("Cannot open database file $Global{'RegistrationFile'} : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

$Found="";
foreach  $ID (keys %data ) {
	($UN,$PW,$FN,$MI,$LN,$CM,$S1,$S2,$CT,$ST,$Z,$CY,$PH,$EX,$FX,$EM,$PM,$NOC,
			$CCN,$CTP,$EXM,$EY,$S3,$S4,$CT1,$ST1,$Z1,$CY1,$Prf )=split(/\|/, $data{$ID});
	if (lc($User_ID) eq lc($UN) ) {$Found=$EM; last; }
}

untie %data;
return ($Found, "$LN, $FN $MI.");			#return user email and full name
}
#==========================================================
sub Check_User_Authentication{
my ($User_ID, $Passwd)=@_;
my ($Found, $ID);
my (%data);
my($UN,$PW,$FN,$MI,$LN,$CM,$S1,$S2,$CT,$ST,$Z,$CY,$PH,$EX,$FX,$EM,$PM,$NOC,
			$CCN,$CTP,$EXM,$EY,$S3,$S4,$CT1,$ST1,$Z1,$CY1,$Prf );

&DB_Exist($Global{'RegistrationFile'});
tie %data, "DB_File", $Global{'RegistrationFile'}, O_RDONLY
        or &Exit("Cannot open database file $Global{'RegistrationFile'} : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

$Found=0;
foreach  $ID (keys %data ) {
	($UN,$PW,$FN,$MI,$LN,$CM,$S1,$S2,$CT,$ST,$Z,$CY,$PH,$EX,$FX,$EM,$PM,$NOC,
			$CCN,$CTP,$EXM,$EY,$S3,$S4,$CT1,$ST1,$Z1,$CY1,$Prf )=split(/\|/, $data{$ID});
	
	if ( lc($User_ID) eq lc($UN) && ($Passwd eq $PW) ) {$Found=1; last; }

}

untie %data;
undef %data;

return $Found;

}
#==========================================================
sub Get_Users_Group{
my($Group)=shift;
my (@User, @Users,%data, $Count);

	&DB_Exist($Global{'RegistrationFile'});
	tie %data, "DB_File", $Global{'RegistrationFile'}, O_RDONLY
						or &Exit("Cannot open database file $Global{'RegistrationFile'} : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	$Count=0;
	undef @User;

	while (($User_ID, $User)= each %data) {
		 ($User[$Count]{'User_ID'},
          $User[$Count]{'Password'},
          $User[$Count]{'FirstName'},
          $User[$Count]{'MiddleInitial'},
          $User[$Count]{'LastName'},
          $User[$Count]{'Company'},
          $User[$Count]{'Street1'},
          $User[$Count]{'Street2'},
          $User[$Count]{'City'},
          $User[$Count]{'Stat'},
          $User[$Count]{'Zip'},
          $User[$Count]{'Country'},
          $User[$Count]{'Phone'},
          $User[$Count]{'Extension'},
          $User[$Count]{'Fax'},
          $User[$Count]{'EmailAddress'}, 
          $User[$Count]{'PaymentType'},
          $User[$Count]{'NameOnCard'},
          $User[$Count]{'CreditCardNumber'},
          $User[$Count]{'CardType'},
          $User[$Count]{'ExpiryMonth'},
          $User[$Count]{'ExpiryYear'},
          $User[$Count]{'Street3'},
          $User[$Count]{'Street4'},
          $User[$Count]{'City1'},
          $User[$Count]{'Stat1'},
          $User[$Count]{'Zip1'},
          $User[$Count]{'Country1'},
          $User[$Count]{'Prefers'} ) = split(/\|/, $User);

		  if ($User_ID=~ /^$Group/i) {
				$Users[$Count]=$User[$Count];
				$Count++;
		  }
	}
	#------------------------------------------------------------------------------------
	untie %data;
	if ($Count==0) {undef @Users;}

	@Users = sort { $a->{'User_ID'} cmp $b->{'User_ID'} } @Users;
	return @Users;
}
#==========================================================
sub Get_User_Info{
my ($UserID)=shift;
my (%data, %User);

	&DB_Exist($Global{'RegistrationFile'});
	tie %data, "DB_File", $Global{'RegistrationFile'}, O_RDONLY
						or &Exit("Cannot open database file $Global{'RegistrationFile'} : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

		 ($User_Info{'User_ID'},
          $User_Info{'Password'},
          $User_Info{'FirstName'},
          $User_Info{'MiddleInitial'},
          $User_Info{'LastName'},
          $User_Info{'Company'},
          $User_Info{'Street1'},
          $User_Info{'Street2'},
          $User_Info{'City'},
          $User_Info{'Stat'},
          $User_Info{'Zip'},
          $User_Info{'Country'},
          $User_Info{'Phone'},
          $User_Info{'Extension'},
          $User_Info{'Fax'},
          $User_Info{'EmailAddress'}, 
          $User_Info{'PaymentType'},
          $User_Info{'NameOnCard'},
          $User_Info{'CreditCardNumber'},
          $User_Info{'CardType'},
          $User_Info{'ExpiryMonth'},
          $User_Info{'ExpiryYear'},
          $User_Info{'Street3'},
          $User_Info{'Street4'},
          $User_Info{'City1'},
          $User_Info{'Stat1'},
          $User_Info{'Zip1'},
          $User_Info{'Country1'},
          $User_Info{'Prefers'} ) = split(/\|/, $data{lc($UserID)});

	#------------------------------------------------------------------------------------
	($User_Info{'Prefs_ent'},$User_Info{'Prefs_hf'},$User_Info{'Prefs_hth'},$User_Info{'Prefs_mc'},
	 $User_Info{'Prefs_shg'},$User_Info{'Prefs_spt'},	$User_Info{'Prefs_bs'},$User_Info{'Prefs_pct'},
	 $User_Info{'Prefs_en'},$User_Info{'Prefs_pf'},$User_Info{'Prefs_sb'},$User_Info{'Prefs_tvl'},
	 $User_Info{'Gender'},$User_Info{'Occupation'},$User_Info{'Industry'},$User_Info{'Contact_Me'}) = split(/\:/, $User_Info{'Prefers'});

	untie %data;
	%User = %User_Info;
	return %User;
}
#==========================================================
sub Delete_Users{
my(@Users_IDs)=@_;
my (%data,  $User_ID);

	if (!&Lock($Global{'RegistrationFile'})) {&Exit("Cannot Lock database file $Global{'RegistrationFile'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}
	tie %data, "DB_File", $Global{'RegistrationFile'}
						or &Exit("Cannot open database file $Global{'RegistrationFile'} : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);
	
	foreach $User_ID (@Users_IDs) {
			if ($data{$User_ID}) {delete $data{$User_ID};}
	}

	untie %data;
	&Unlock($Global{'RegistrationFile'});
	&Delete_Accounts_Activities(@Users_IDs);
	&Update_Total_Users_Count;
}
#==========================================================
sub Get_Users{
my (%data, %Users);

	&DB_Exist($Global{'RegistrationFile'});
	tie %data, "DB_File", $Global{'RegistrationFile'}, O_RDONLY
						or &Exit("Cannot open database file $Global{'RegistrationFile'} : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);
	
	%Users = %data;
	untie %data;
	return %Users;
}
#==========================================================
sub Update_Total_Users_Count{
my (%data);

	if (!&Lock($Global{'Configuration_File'})) {&Exit("Cannot Lock database file $Global{'Configuration_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}
	tie %data, "DB_File", $Global{'Configuration_File'}
                                         or &Exit("Cannot open database file $Global{'Configuration_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	$data{'Total_Users_Count'} = &Get_Users_Count;
	untie %data;
	&Unlock($Global{'Configuration_File'});
}
#==========================================================
sub Get_Users_Count{
my (%data,  $Users);

&DB_Exist($Global{'RegistrationFile'});
tie %data, "DB_File", $Global{'RegistrationFile'}, O_RDONLY
        or &Exit("Cannot open database file $Global{'RegistrationFile'} : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);
$Users= keys %data;
untie %data;
return $Users;

}
#==========================================================
sub Get_Users_Emails{
my(@Users_ID)=@_;
my (%data,  $User_ID, %Users);
my($UN,$PW,$FN,$MI,$LN,$CM,$S1,$S2,$CT,$ST,$Z,$CY,$PH,$EX,$FX,$EM,$PM,$NOC,
			$CCN,$CTP,$EXM,$EY,$S3,$S4,$CT1,$ST1,$Z1,$CY1,$Prf );

&DB_Exist($Global{'RegistrationFile'});
tie %data, "DB_File", $Global{'RegistrationFile'}, O_RDONLY
        or &Exit("Cannot open database file $Global{'RegistrationFile'} : $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

foreach $User_ID (@Users_ID) {
	if ($data{$User_ID}) {
		($UN,$PW,$FN,$MI,$LN,$CM,$S1,$S2,$CT,$ST,$Z,$CY,$PH,$EX,$FX,$EM,$PM,$NOC,
				$CCN,$CTP,$EXM,$EY,$S3,$S4,$CT1,$ST1,$Z1,$CY1,$Prf )=split(/\|/, $data{$User_ID});
		$Users{$User_ID}=$EM;
	}
	else{
		$Users{$User_ID}=undef;
	}
}

untie %data;
return %Users;

}
#==========================================================
#==========================================================
1;


