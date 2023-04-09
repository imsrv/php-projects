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
sub Curent_Date_Time{
my $time=shift;
my ( $Out);

@DAYS = ('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday',  
		         'Friday', 'Saturday');
    
@MONTHS = ('January', 'February', 'March', 'April', 'May', 'June',  
		           'July', 'August', 'September', 'October', 'November',
		           'December');
   $time = &Time(time) if(! int($time));

   my( $sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $dst )= gmtime( $time );


	$Date{'ap'} = ($hour >= 12) ? 'PM' : 'AM';
	if ($hour > 12) { $hour -= 12; }    elsif  ($hour == 0) { $hour = 12; }

	$Date{'time'} = sprintf("%d:%02d:%02d %s", $hour, $min, $sec, $Date{'ap'});
	$Date{'m'} = sprintf("%02d", $mon + 1);
	$Date{'0d'} = sprintf("%02d", $mday);
	$Date{'mon'} = $MONTHS[$mon];
	$Date{'wday'} = $DAYS[$wday];
	$Date{'year'} = 1900 + $year;
	
	$Out= "$Date{'wday'}, $Date{'mon'} $Date{'0d'}, $Date{'year'} $Date{'time'}";
	
	return $Out;
}
#==========================================================
sub Get_Local_Time{
my $time=shift;
my ($Out);

@DAYS = ('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday',  
		         'Friday', 'Saturday');
    
@MONTHS = ('January', 'February', 'March', 'April', 'May', 'June',  
		           'July', 'August', 'September', 'October', 'November',
		           'December');
   $time = time if(! int($time));

   my( $sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $dst )= localtime( $time );

	$Date{'ap'} = ($hour >= 12) ? 'PM' : 'AM';
	if ($hour > 12) { $hour -= 12; }    elsif  ($hour == 0) { $hour = 12; }

	$Date{'time'} = sprintf("%d:%02d:%02d %s", $hour, $min, $sec, $Date{'ap'});
	$Date{'m'} = sprintf("%02d", $mon + 1);
	$Date{'0d'} = sprintf("%02d", $mday);
	$Date{'mon'} = $MONTHS[$mon];
	$Date{'wday'} = $DAYS[$wday];
	$Date{'year'} = 1900 + $year;
	
	$Out= "$Date{'wday'}, $Date{'mon'} $Date{'0d'}, $Date{'year'} $Date{'time'}";
	
	return $Out;
}
#==========================================================
sub Format_Time{
my $time=shift;
my ($Out);

@DAYS = ('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday',  
		         'Friday', 'Saturday');
    
@MONTHS = ('January', 'February', 'March', 'April', 'May', 'June',  
		           'July', 'August', 'September', 'October', 'November',
		           'December');
my($sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $dst);

if (!$time) {$time=&Time(time);}

($sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $dst) = gmtime($time);

$Date{'ap'} = ($hour >= 12) ? $Language{'PM'} : $Language{'AM'};
if ($hour > 12) { $hour -= 12; }    elsif  ($hour == 0) { $hour = 12; }
$Date{'time'} = sprintf("%d:%02d %s", $hour, $min, $Date{'ap'});

$Date{'m'} = sprintf("%02d", $mon + 1);

$Date{'mon'} = $MONTHS[$mon];
$Date{'mon'} = $Language{$Date{'mon'}};
$Date{'mon'} = substr($Date{'mon'}, 0, 3);

$Date{'wday'} = substr($DAYS[$wday], 0, 3);
$Date{'weekday'} = $DAYS[$wday];
$Date{'0d'} = sprintf("%02d", $mday);
$Date{'year'} = 1900 + $year;

$Out= "$Date{'mon'}, $Date{'0d'} $Date{'time'}";

return $Out;
}
#==========================================================
sub Time_Left{
my ($Starts, $Ends)=@_;
my($Ticks, $secs, $hours);
my($days, $minutes);

	$Ticks=abs($Ends - $Starts);

	$sec=int($Ticks % 60);
	$Ticks=int($Ticks / 60); # $Ticks in minutes
	$minutes=$Ticks % 60;
	$Ticks=int($Ticks / 60); #$Ticks in hours
	$hours= $Ticks % 24; 
	$days=int($Ticks  /  24);

	return ($days, $hours, $minutes);

}
#==========================================================
sub Format_Time_Left{
my ($days, $hours, $minutes)=@_;
my ($D, $H, $M);
my $Out="";

if ($days >0) {
	$D="$days $Language{'day'}";
	$D.=($days>1)? $Language{'plural'}: "";
}

if ($hours >0) {
	$H="$hours $Language{'hour'}";
	$H.=($hours>1)? $Language{'plural'}: "";
}

if ($minutes >0) {
	$M="$minutes $Language{'minute'}";
	$M.=($hours>1)? $Language{'plural'}: "";
}

if ($days>0) {
	$Out=$D;
	if ($hours) {$Out .= $Language{'plus_time'};}
}
elsif ($hours>0){
	$Out=$H;
	if ($minutes) {$Out .=$Language{'plus_time'};	}
}
else{
	$Out=$M;
}
return $Out;
}
#==========================================================
sub Time_Diff{
my($Start_Time, $End_Time)=@_;
my ($days, $hours, $minutes);
my $Out;

	($days, $hours, $minutes)=&Time_Left($Start_Time, $End_Time);
	$Out=&Format_Time_Left ($days, $hours, $minutes);
	return $Out;

}
#==========================================================
sub Long_Date_Time{
my $time=shift;
my ($Offset, $Out);

@DAYS = ('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday',  
		         'Friday', 'Saturday');
    
@MONTHS = ('January', 'February', 'March', 'April', 'May', 'June',  
		           'July', 'August', 'September', 'October', 'November',
		           'December');
   $time = &Time(time) if(! int($time));

   my( $sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $dst )= gmtime( $time );


	$Date{'ap'} = ($hour >= 12) ? $Language{'PM'} : $Language{'AM'};
	if ($hour > 12) { $hour -= 12; }    elsif  ($hour == 0) { $hour = 12; }

	$Date{'time'} = sprintf("%d:%02d:%02d %s", $hour, $min, $sec, $Date{'ap'});
	$Date{'m'} = sprintf("%02d", $mon + 1);
	$Date{'0d'} = sprintf("%02d", $mday);
	$Date{'mon'} = $MONTHS[$mon];
	$Date{'wday'} = $DAYS[$wday];
	$Date{'year'} = 1900 + $year;
	
	$Out= "$Language{$Date{'wday'}}, $Language{$Date{'mon'}} $Date{'0d'}, $Date{'year'} $Date{'time'}";
	
	return $Out;
}
#==========================================================
sub Erupe_Long_Date_Time{
my $time=shift;
my ($Offset, $Out);

@DAYS = ('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday',  
		         'Friday', 'Saturday');
    
@MONTHS = ('January', 'February', 'March', 'April', 'May', 'June',  
		           'July', 'August', 'September', 'October', 'November',
		           'December');
   $time = &Time(time) if(! int($time));

   my( $sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $dst )= gmtime( $time );


	$Date{'ap'} = ($hour >= 12) ? $Language{'PM'} : $Language{'AM'};
	if ($hour > 12) { $hour -= 12; }    elsif  ($hour == 0) { $hour = 12; }

	$Date{'time'} = sprintf("%d:%02d:%02d %s", $hour, $min, $sec, $Date{'ap'});
	$Date{'m'} = sprintf("%02d", $mon + 1);
	$Date{'0d'} = sprintf("%02d", $mday);
	$Date{'mon'} = $MONTHS[$mon];
	$Date{'wday'} = $DAYS[$wday];
	$Date{'year'} = 1900 + $year;
	
	$Out= "$Language{$Date{'wday'}} $Date{'0d'} $Language{$Date{'mon'}} $Date{'year'} $Date{'time'}";
	
	return $Out;
}
#==========================================================
sub Long_Date{
my $time=shift;
my %Data;
my $Offset;

@DAYS = ('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday',  
		         'Friday', 'Saturday');
    
@MONTHS = ('January', 'February', 'March', 'April', 'May', 'June',  
		           'July', 'August', 'September', 'October', 'November',
		           'December');

   $time = &Time(time) if(! int($time));

   my( $sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $dst )= gmtime( $time );


	$Date{'ap'} = ($hour >= 12) ? $Language{'PM'} : $Language{'AM'};
	if ($hour > 12) { $hour -= 12; }    elsif  ($hour == 0) { $hour = 12; }

	$Date{'time'} = sprintf("%d:%02d %s", $hour, $min, $Date{'ap'});

	$Date{'m'} = sprintf("%02d", $mon + 1);
	$Date{'mon'} = $MONTHS[$mon];
	$Date{'wday'} = $DAYS[$wday];
	$Date{'0d'} = sprintf("%02d", $mday);
	$Date{'year'} = 1900 + $year;
	
	$Out= "$Language{$Date{'wday'}}, $Language{$Date{'mon'}} $Date{'0d'}, $Date{'year'}";
	
	return $Out;
}
#==========================================================
sub Short_Date {
my $time=shift;
my %Data;
my $Offset;

@DAYS = ('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday',  
		         'Friday', 'Saturday');
    
@MONTHS = ('January', 'February', 'March', 'April', 'May', 'June',  
		           'July', 'August', 'September', 'October', 'November',
		           'December');

   $time = &Time(time) if(! int($time));

   my( $sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $dst )= gmtime( $time );


	$Date{'ap'} = ($hour >= 12) ? $Language{'PM'} : $Language{'AM'};
	if ($hour > 12) { $hour -= 12; }    elsif  ($hour == 0) { $hour = 12; }

	$Date{'time'} = sprintf("%d:%02d %s", $hour, $min, $Date{'ap'});
	$Date{'m'} = sprintf("%02d", $mon + 1);
	$Date{'0d'} = sprintf("%02d", $mday);

	$Date{'mon'} = $MONTHS[$mon];
	$Date{'wday'} = $DAYS[$wday];

	$Date{'year'} = 1900 + $year;

	$Out= "$Language{$Date{'mon'}} $Date{'0d'}, $Date{'year'}";
	return $Out;
}
#==========================================================
sub Date_Formated {
my($Format,  $time)=@_;
my $Offset;
my $Time_now;

   $time = &Time(time) if(! int($time));

	my( $sec, $min, $hour, $mday, $mon, $year, $wday, $yday, $dst )= gmtime( $time );

	my $AP = ($hour >= 12) ? $Language{'PM'} : $Language{'AM'};
	if ($hour > 12) { $hour -= 12; }    elsif  ($hour == 0) { $hour = 12; }

	my( $month )= ($mon + 1);
    
	$sec= sprintf("%02d", $sec);
	$min= sprintf("%02d", $min);
	$hour= sprintf("%02d", $hour);
	$mon= sprintf("%02d", $mon);
	$mday= sprintf("%02d", $mday);

	$Time_now="$hour\:$min $AP";

   $year += 1900;
	if ($Format <= 0 ) {
			return "$month/$mday/$year";
	}
	elsif ($Format ==1 ) {
			return "$mday/$month/$year";
	}
	elsif ($Format ==2 ) {
			return "$year/$month/$mday";
	}
	elsif ($Format ==3 ) {
			return "$year/$mday/$month";
	}
	if ($Format ==4 ) {
			return "$month/$mday/$year $Time_now";
	}
	elsif ($Format ==5 ) {
			return "$mday/$month/$year $Time_now";
	}
	elsif ($Format ==6 ) {
			return "$year/$month/$mday $Time_now";
	}
	else {
			return "$year/$mday/$month $Time_now";
	}

}
#==========================================================
sub Get_Date_Formated{
my ($Format, $Time)=@_;

	if ($Format<8) { 
				$Out=&Date_Formated($Format, $Time);
	}
	elsif ($Format==8) { 
				$Out=&Short_Date($Time);
	}
	elsif ($Format==9) { 
				$Out=&Long_Date($Time);
	}
	elsif ($Format==10) { 
				$Out=&Erupe_Long_Date_Time($Time);
	}
	else { 
				$Out=&Long_Date_Time($Time);
	}
}
#==========================================================
#==========================================================
1;