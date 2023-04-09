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
#returns : 0=Invalid CC, 1= Valid CC
sub Verify_Credit_Card{
my ($Card_Type, $Card_Number) =@_; 

	$Card_Number =~ s/ //g;
	$Card_Number =~ s/-//g;
	if (!($Card_Number =~ /^[0-9]*$/)) {
			return 0; # Invalid CC
	}

	$Card_Length = length($Card_Number);

	if ($Card_Type =~ /visa/i) { 
		return 0 unless (($Card_Length ==13) || ($Card_Length == 16)); 
		if ($Card_Length == 13) { return &Check_13_Digit_Credit_cards($Card_Number); }
		if ($Card_Length == 16) { return &Check_16_Digit_Credit_cards($Card_Number); }
	}

	if ($Card_Type =~ /mastercard/i || $Card_Type =~ /master card/i) { 
		return 0  unless ($Card_Length == 16);  
		return &Check_16_Digit_Credit_cards($Card_Number);
	}

	if ($Card_Type =~ /amex/i || $Card_Type  =~ /american express/i) { 
		return 0  unless ($Card_Length == 15); 
		return &Check_15_Digit_Credit_cards($Card_Number); 
	}

	if ($Card_Type =~ /novus/i || $Card_Type =~ /discover/i) { 
		return 0  unless ($Card_Length == 16);  
		return &Check_16_Digit_Credit_cards($Card_Number);
	}
	if ($Card_Type =~ /isracard/i) { 
		return 0  unless ($Card_Length == 9);  
		return &Check_9_Digit_Credit_cards($Card_Number);
	}

	return  2;
}
#==========================================================
sub Check_9_Digit_Credit_cards {
my( $Card_Number) =shift;
my(@Ds, $D, $Counter, $Sum);

	$Counter=9;
	@Ds=split(//, $Card_Number);
	foreach $D (@Ds) {
		$Sum = $Sum+ ($D * $Counter);  
		$Counter--;
	}

	if ($Sum % 11 != 0) {
			return 0; #Invalid CC;
	}

	return 1; # Valid CC
}
#==========================================================
# Check 13 digit cards
sub Check_13_Digit_Credit_cards {
my ($Card_Number) =shift;

my($D0,$D1,$D2,$D3,$D4,$D5,$D6,$D7,$D8,$D9,$D10,$D11,$D12);
my($D1a, $D1b, $D1c, $D3a, $D5a, $D7a, $D9a, $D11a);
my($D3b, $D3c, $D5b, $D5c,  $D7b, $D7c);
my($D9b, $D9c,  $D11b, $D11c, $Sum);

	($D0,$D1,$D2,$D3,$D4,$D5,$D6,$D7,$D8,$D9,$D10,$D11,$D12)=split(//,$Card_Number);

	$D1a = $D1 * 2;
    $D3a = $D3 * 2;
    $D5a = $D5 * 2;
    $D7a = $D7 * 2;
    $D9a = $D9 * 2;
    $D11a = $D11 * 2;

    if ($D1a >= 10) {
            $D1b = substr($D1a,0,1);
            $D1c = substr($D1a,1,1);
            $D1 = $D1b+$D1c;
    } else {
            $D1 = $D1a;
    }

    if ($D3a >= 10) {
            $D3b = substr($D3a,0,1);
            $D3c = substr($D3a,1,1);
            $D3 = $D3b+$D3c;
    } else {
            $D3 = $D3a;
    }

    if ($D5a >= 10) {
            $D5b = substr($D5a,0,1);
            $D5c = substr($D5a,1,1);
            $D5 = $D5b+$D5c;
    } else {
            $D5 = $D5a;
    }

    if ($D7a >= 10) {
            $D7b = substr($D7a,0,1);
            $D7c = substr($D7a,1,1);
            $D7 = $D7b+$D7c;
    } else {
            $D7 = $D7a;
    }

    if ($D9a >= 10) {
            $D9b = substr($D9a,0,1);
            $D9c = substr($D9a,1,1);
            $D9 = $D9b+$D9c;
    } else {
            $D9 = $D9a;
    }

    if ($D11a >= 10) {
            $D11b = substr($D11a,0,1);
            $D11c = substr($D11a,1,1);
            $D11 = $D11b+$D11c;
    } else {
            $D11 = $D11a;
    }

    $Sum = $D0+$D1+$D2+$D3+$D4+$D5+$D6+$D7+$D8+$D9+$D10+$D11+$D12;
    
	if (substr($Sum,1,1) !=0 ) {
            return 0;
    }

	return 1;
}
#==========================================================
# Check 15 digit (Amex) cards
sub Check_15_Digit_Credit_cards {
my ($Card_Number) =shift;

my($D0,$D1,$D2,$D3,$D4,$D5,$D6,$D7,$D8,$D9,$D10,$D11,$D12, $D13,$D14);
my($D1a, $D1b, $D1c, $D3a, $D5a, $D7a, $D9a, $D11a, $D13a, $D13b, $D13c);
my($D3b, $D3c,  $D5b, $D5c, $D7b, $D7c);
my( $D9b, $D9c, $D11b, $D11c, $Sum);
	
	
	($D0,$D1,$D2,$D3,$D4,$D5,$D6,$D7,$D8,$D9,$D10,$D11,$D12,$D13,$D14)=split(//, $Card_Number);

        $D1a = $D1 * 2;
        $D3a = $D3 * 2;
        $D5a = $D5 * 2;
        $D7a = $D7 * 2;
        $D9a = $D9 * 2;
        $D11a = $D11 * 2;
        $D13a = $D13 * 2;

        if ($D1a >= 10) {
            $D1b = substr($D1a,0,1);
            $D1c = substr($D1a,1,1);
            $D1 = $D1b+$D1c;
        } else {
            $D1 = $D1a;
        }

        if ($D3a >= 10) {
            $D3b = substr($D3a,0,1);
            $D3c = substr($D3a,1,1);
            $D3 = $D3b+$D3c;
        } else {
            $D3 = $D3a;
        }

        if ($D5a >= 10) {
            $D5b = substr($D5a,0,1);
            $D5c = substr($D5a,1,1);
            $D5 = $D5b+$D5c;
        } else {
            $D5 = $D5a;
        }

        if ($D7a >= 10) {
            $D7b = substr($D7a,0,1);
            $D7c = substr($D7a,1,1);
            $D7 = $D7b+$D7c;
        } else {
            $D7 = $D7a;
        }

        if ($D9a >= 10) {
            $D9b = substr($D9a,0,1);
            $D9c = substr($D9a,1,1);
            $D9 = $D9b+$D9c;
        } else {
            $D9 = $D9a;
        }

        if ($D11a >= 10) {
            $D11b = substr($D11a,0,1);
            $D11c = substr($D11a,1,1);
            $D11 = $D11b+$D11c;
        } else {
            $D11 = $D11a;
        }

        if ($D13a >= 10) {
            $D13b = substr($D13a,0,1);
            $D13c = substr($D13a,1,1);
            $D13 = $D13b+$D13c;
        } else {
            $D13 = $D13a;
        }

        $Sum = $D0+$D1+$D2+$D3+$D4+$D5+$D6+$D7+$D8+$D9+$D10+$D11+$D12+$D13+$D14;
        if (substr($Sum,1,1) !=0 ) {
            return 0;
        }

		return 1;
}
#==========================================================
# Check 16 digit cards
sub Check_16_Digit_Credit_cards {
my ($Card_Number) =shift;

my($D0,$D1,$D2,$D3,$D4,$D5,$D6,$D7,$D8,$D9,$D10,$D11,$D12,$D13,$D14,$D15);
my($D1a, $D1b, $D1c, $D3a, $D5a, $D7a, $D9a, $D11a, $D12a, $D12b, $D12c);
my($D3b, $D3c, $D5b, $D5c, $D7b, $D7c, $D14a, $D14b, $D14c);
my($D9b, $D9c, $D11b, $D11c, $Sum);


	($D0,$D1,$D2,$D3,$D4,$D5,$D6,$D7,$D8,$D9,$D10,$D11,$D12,$D13,$D14,$D15)=split(//,$Card_Number);
     
        $D0a = $D0 * 2;
        $D2a = $D2 * 2;
        $D4a = $D4 * 2;
        $D6a = $D6 * 2;
        $D8a = $D8 * 2;
        $D10a = $D10 * 2;
        $D12a = $D12 * 2;
        $D14a = $D14 * 2;

        if ($D0a >= 10) {
            $D0b = substr($D0a,0,1);
            $D0c = substr($D0a,1,1);
            $D0 = $D0b+$D0c;
        } else {
            $D0 = $D0a;
        }
        if ($D2a >= 10) {
            $D2b = substr($D2a,0,1);
            $D2c = substr($D2a,1,1);
            $D2 = $D2b+$D2c;
        } else {
            $D2 = $D2a;
        }
        if ($D4a >= 10) {
            $D4b = substr($D4a,0,1);
            $D4c = substr($D4a,1,1);
            $D4 = $D4b+$D4c;
        } else {
            $D4 = $D4a;
        }
        if ($D6a >= 10) {
            $D6b = substr($D6a,0,1);
            $D6c = substr($D6a,1,1);
            $D6 = $D6b+$D6c;
        } else {
            $D6 = $D6a;
        }
        if ($D8a >= 10) {
            $D8b = substr($D8a,0,1);
            $D8c = substr($D8a,1,1);
            $D8 = $D8b+$D8c;
        } else {
            $D8 = $D8a;
        }
        if ($D10a >= 10) {
            $D10b = substr($D10a,0,1);
            $D10c = substr($D10a,1,1);
            $D10 = $D10b+$D10c;
        } else {
            $D10 = $D10a;
        }
        if ($D12a >= 10) {
            $D12b = substr($D12a,0,1);
            $D12c = substr($D12a,1,1);
            $D12 = $D12b+$D12c;
        } else {
            $D12 = $D12a;
        }
        if ($D14a >= 10) {
            $D14b = substr($D14a,0,1);
            $D14c = substr($D14a,1,1);
            $D14 = $D14b+$D14c;
        } else {
            $D14 = $D14a;
        }

        $Sum = $D0+$D1+$D2+$D3+$D4+$D5+$D6+$D7+$D8+$D9+$D10+$D11+$D12+$D13+$D14+$D15;
        if (substr($Sum,1,1) !=0 ) {
            return 0;
        }
		return 1;
}
#==========================================================

1;