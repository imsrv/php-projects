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
sub Get_Random_File_Name{
my $temp_dir =shift;
my $ext=shift;
my $Fname="";

#   BEGIN{ srand ($$.time) }
   do {
			$Fname=int (rand(100000000000)).".".$ext;
			$temp_file  = "$temp_dir/$Fname";
   } until (!-e $temp_file);

   return $Fname;
}
#==========================================================
sub Go_Back{
my($GoType)=shift;
my($Out)="";

if ($GoType==0) {
      $Out= <<HTML;
              <CENTER>
			   <BR><BR>
			  <A HREF="javascript:history.go(-1)">Back to Previous Page</A>
			  </CENTER></FONT><BR><BR>
HTML
	 }
 else{
$Out= <<HTML;
		<center>
		<form>
				<input type=button value="<< Go Back " onClick="history.go(-1)">
		</form></center>
HTML
	}
return $Out;
}
#==========================================================
sub Msg{
my($Title, $Message, $Level)=@_;
my($Out, $L);

	$Out=$Global{'Message_Form'};
	$Out=~ s/(<!--MESSAGE_TITLE-->)/$Title/g;
	$Out=~ s/(<!--MESSAGE_BODY-->)/$Message/g;
	if (!$Level) {$Level = 1;}
	$Level = $Level * -1;

	$L = $Language{'ok_message_button'};
	$L =~ s/<<Level>>/$Level/;
	$Out=~ s/(<!--OK_BUTTON-->)/$L/g;
	
	return $Out;
}
#==========================================================
sub Error{
my($Message, $Title, $Level)=@_;
my($Out, $L)="";

	if ($Title eq "") {$Title="Critical Error";}
	if ($Level !~ /^\d+$/) {$Level=1;}

	$Out=$Global{'Error_Form'};
	$Out=~ s/<!--ERROR_MESSAGE_TITLE-->/$Title/g;
	$Out=~ s/<!--ERROR_MESSAGE_BODY-->/$Message/g;

	$L=qq!<input type=button value="--Ok--" onClick="history.go(-$Level)">!;
	$Out=~ s/(<!--OK_BUTTON-->)/$L/g;
	
	return ($Out);
}
#==========================================================
sub Header{
	print "Content-type: text/html\n\n";
}
#==========================================================
sub Print_Header{ 
my ($title)=shift;
	print "Content-type: text/html\n\n";
	print "<HTML>";
	print "<HEAD><TITLE>$title</TITLE></HEAD>";
	print "<BODY>";
}
#==========================================================
sub Print_Footer{ 
	print "</BODY>";
	print "</HTML>";
}
#==========================================================
sub Get_Form { 
my $buffer = "";
my @pair;
my ($key, $value, $pair, $original_value);

    if ($ENV{'CONTENT_LENGTH'} ) {
        read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});
        @pair=split(/&/,$buffer);
       } 
	elsif ($ENV{'QUERY_STRING'}) {
        @pair = split(/\\*\&/, $ENV{'QUERY_STRING'});
    }

    foreach $pair (@pair) {
			($key,$value)= split(/=/,$pair);
			$original_value=$value;
			$value =~ tr/+/ /;
			$value =~ s/%([A-Fa-f0-9]{2})/pack("C", hex($1))/ge;
			$value =~ s/\r$//g;
			$value =~ s/\n$//sg;  
			$key =~ s/\cM$//;

			$key =~ tr/\+/ /;
			$key =~ s/%([A-Fa-f0-9]{2})/pack("C", hex($1))/eg;
			$key =~ s/\r$//g;
			$key =~ s/\n$//g;
			$key =~ s/\cM$//;

			if(!$Param{$key}) {
					$Param{$key} = $value;
					$Paramx{$key}=$original_value;
			}
			else {
  					$Param{$key} = $Param{$key}."||".$value;
					$Paramx{$key}=$Paramx{$key}."||".$original_value;
			 }

	 }

}
#==========================================================
sub Get_Form_Multipart{
my($Input, $Boundary, @List, %Data);
my($Upload_File, $Upload_File_Name);
my($Upload_File_Content, $x);

	binmode(STDIN);
	binmode(STDOUT);
	binmode(STDERR);

	read(STDIN, $Input, $ENV{'CONTENT_LENGTH'});

    $Input =~ /^(.+)\r\n/;
    $Boundary = $1;
	@List = split(/$Boundary/, $Input); 

	$Upload_File = $List[1]; 
	$Upload_File =~ /\r\n\r\n|\n\n/;         #separate header and body 
	$Upload_File_Name = $`;                # front part
	$Upload_File_Content = $';             # rear part
 	$Upload_File_Content =~ s/\r\n$//;  # the last \r\n was put in by Netscape

	# Parse header
	$Upload_File_Name =~ /filename=\"(.+)\"/; 
	$Upload_File_Name = $1;  #print "[[Header= $Header ]](($Input))<br>";
	$Upload_File_Name =~ s/\"//g; # remove "s
    $Upload_File_Name =~ s/\s//g; # make sure no space(include \n, \r..) in the file name 
	@File_Name = split(/[\/|\\]/, $Upload_File_Name); 
	$Upload_File_Name = pop @File_Name;

	# Parse trailer
	for $x(2..$#List) { 
					$List[$x] =~ s/^.+name=$//; 
					$List[$x] =~ /\"(\w+)\"/; 
					$Data{$1} = $'; 
	}

	while (($Key, $Value)=(each %Data)) {
				$Original_Value=$Value;
				#$value =~ tr/+/ /;
				#$value =~ s/%([A-Fa-f0-9]{2})/pack("C", hex($1))/eg;

				#$key =~ tr/+/ /;
				#$key =~ s/%([A-Fa-f0-9]{2})/pack("C", hex($1))/eg;

				$Key=~ s/^(\r\n)+//g;
				$Key=~ s/(\r\n)+$//g;
				
				$Value=~ s/^(\r\n)+//g;
				$Value=~ s/(\r\n)+$//g;
				
				$Key=~ s/\cM//g;
				$Value=~ s/\cM//g;

				if(!$Param{$Key}) {
						$Param{$Key} = $Value;
						$Paramx{$Key} = $Original_Value;
				}
				else {
						$Param{$Key} = $Param{$Key}."||".$Calue;
						$Paramx{$Key} =$ Paramx{$Key}."||".$Original_Value;
				 }
	}
	
	$Param{'Upload_File_Content'} = $Upload_File_Content;
	$Paramx{'Upload_File_Content'} = $Upload_File_Content;
	$Param{'Upload_File_Name'} = $Upload_File_Name;
	$Paramx{'Upload_File_Name'} = $Upload_File_Name;
}
#==========================================================
sub JS_Win{ 
my($URL, $Title)=@_;
my ($Out);
$Out=<<HTML;
	<SCRIPT LANGUAGE="javascript">
 	function PopUp(subjects) {
		var GoTo = "$Script_URL?action=Help&subject=" + subjects;
		link=open(GoTo, "$Title","toolbar=no, scrollbars=yes, directories=no,menubar=no,resizable=yes,width=400,height=500");
   }
	</SCRIPT>
HTML
	return $Out;
}
#==========================================================
sub Get_Host{
my ($ip_address,$ip_number,@numbers);

	if ($ENV{'REMOTE_HOST'}) {
				$host = $ENV{'REMOTE_HOST'};
	} 
	else{
				$ip_address = $ENV{'REMOTE_ADDR'};
				@numbers = split(/\./, $ip_address);
				$ip_number = pack("C4", @numbers);
				$host = (gethostbyaddr($ip_number, 2))[0];
	}

	if ($host eq "") {
				$host = "$ENV{'REMOTE_ADDR'}";
	}
	
	return $host;
}
#==========================================================
sub Get_Script_URL{ 
my($http);

$Doc_Root = "";
if ($ENV{'DOCUMENT_ROOT'}) {
   $Doc_Root = $ENV{'DOCUMENT_ROOT'};
}

$http="http://";
if ($ENV{'HTTP_REFERER'}) {
		if ($ENV{'HTTP_REFERER'} =~ m|^https://|i) {
			$http="https://";
        }
}


$Domain = "";
if ($ENV{'HTTP_HOST'}) {
   $Domain = $http . $ENV{'HTTP_HOST'};
}

$Script_URL ="";
if ($ENV{'SCRIPT_NAME'}) {
   $Script_Name = $ENV{'SCRIPT_NAME'};
   $Script_URL = $Domain . $Script_Name;
  }

}
#==========================================================
sub Random_ID{
my $x;
my @Codes;
my $Rand_ID;
my $Randum_Num;

#	srand(time ^ $$);
	@Codes = ('a'..'k', 'm'..'n', 'p'..'z', '2'..'9');
	$Rand_ID = "";
	for ($x = 0; $x < 10; $x++) {
		$Randum_Num = int(rand($#Codes + 1));
		$Rand_ID .= $Codes[$Randum_Num];
	}
	return $Rand_ID;
}
#==========================================================
sub Random_No{ 
my $Randum_Num;

$Randum_Num="";
#srand (time | $$);
$Randum_Num = int (rand(1000000));
$Randum_Num .= '$$';
$Randum_Num=~ s/-//;

return $Randum_Num;
}
#==========================================================
sub Generate_ID { 
my $Pause;
my @Codes;
my ($ID, $x);

   $Pause = time;

   @Codes=("a".."n","p".."z",1..9);
#   srand( time() ^ ($$ + ($$ << 15)) );
   $ID="";
   for ($x=1;$x<=6;$x++){ 
        $ID.= "$Codes[rand(@Codes)]";
   }
   $ID .= "$Pause";
   return $ID;
}
#==========================================================
sub DB_Exist{
my($DB_File_Name)=@_;
my(%data);

	if (-e $DB_File_Name) {return 1;}
	tie %data, "DB_File", $DB_File_Name or
								 &Exit("Cannot create database file $DB_File_Name: $!\n" . "<BR>Line " . __LINE__ . ", File ". __FILE__);
	untie %data;
	return 0;
}
#==========================================================
sub Lock{
my ($File) =shift;
my(@Parts, $Time, $Start, $Spent, $Wait);
my($Lock_File);

	@Parts=split(/[\/|\\]/, $File);
	$File=pop @Parts;
	if (!$File) {return 0;}

	$Lock_File = $Global{'Lock_Dir'}. "/" . $File. "\.lck";
    $Start = 0;   $Spent = 0 ;   $Wait = 0;
    $Time = time;

	if (-e $Lock_File) {
			open(IN, $Lock_File);
			$Start = <IN>;
			close(IN);
        
			$Spent = $Time - $Start;
			if ($Spent <= 60) {
					while (-e "$Lock_File") {
							$Wait++;
							sleep 1;
							if ($Wait == 25) {return 0;}
					}
			 }
	}

    open (OUT, "> $Lock_File") or return 0;
    print OUT $Time;
    close (OUT);

    return (1);
}
#==========================================================
sub Unlock{
my ($File) =shift;
my(@Parts, $Lock_File);

	@Parts=split(/[\/|\\]/, $File);
	$File=pop @Parts;
	$Lock_File = $Global{'Lock_Dir'}. "/" . $File. "\.lck";
	return (unlink $Lock_File);
}
#==========================================================
sub Numeric { 

	$_ = shift;
    if ((/^\d+$/) || (/^\d+\.$/) || (/^\d+\.\d+$/) || (/^\.\d+$/)) {
			return 1;
    }
			return 0;
}
#==========================================================
sub Format_Decimal{
my($Value) = @_;
my($D, $F, $Z );

		if (!$Value) { return "0.00";}
		$Value =~ s/\s//g;
		($D, $F)=split(/\./, $Value);
		$Z = "0" x (2-length($F));
		$Value = $D.".". $F. $Z;
		return $Value;

}
#==========================================================
sub Check_URL { 
my $URL = shift;

   if ($URL !~ /^mailto:.*\@\S+\./ && $URL !~ /^news:/ 
				&& $URL !~ /^(f|ht)tps?:\/\/\S+\.\S+/) { 
				return(1); 
	}
   else {
				return(0); 
	}

}
#==========================================================
sub Check_Referers { 
my (@Allowed_Domains) =@_;
my @Referers;
my ($Status, $Key);

    $Status =1;

    if ($ENV{'HTTP_REFERER'}) {
        foreach $Referer (@Allowed_Domains) {
            if ($ENV{'HTTP_REFERER'} =~ m|https?://([^/]*)$Referer|i) {
                $Status = 1; last;
            }
        }
    }
    else {
        $Status = 0;
    }
    return($Status);
}
#==========================================================
sub Check_Writable_Files_Permissions{ 
my @Check_Files=@_;
my @Non_Writable_files = ();
my ($Error) = 0;

		foreach $File (@Check_Files){
			unless (-w "$File") { 
							$Error = 1;
						push (@Non_Writable_files, $File); 
			}
		}

		if ($Error) {
				&Msg("Write file error", "@Non_Writable_files", 1);
				exit 0;
		}
		else {
				&Msg("File write ok", "All files are writable", 1);
				exit 0;
		}

}
#==========================================================
sub Remove_HTML_Tags{ 
my $Source = shift;
   
   $Source =~ s/<[^>]+>//ig;
   return  $Source ;
}
#==========================================================
sub Chmod{ 
($Files, $Mode)=@_;

	if ($OS=~ /unix/i) { 
			chmod $Mode, "$Files"; 
	}

}
#==========================================================
sub Get_OS{ 

	$OS = $^O;
	if (($OS eq "MSWin32") || ($OS eq "Windows_NT") || ($OS =~ /win/i)) {
			$OS = "WINNT"; 
	}
	else { 
		$OS = "UNIX"; 
	}
	return $OS;
}
#==========================================================
sub Encode_HTML{
my $Temp =shift;

	$Temp =~ s/\"/\&quot\;/g;
	$Temp =~ s/\'/\&\#39\;/g;
	$Temp =~ s/\</\&lt\;/g;
	$Temp =~ s/\>/\&gt\;/g;
	return $Temp;

}
#==========================================================
sub Get_Random_ID{
my ($Randon_ID);

#	srand($$|time);
	$Randon_ID = int(rand(999999));

	$Randon_ID = unpack("H*", pack("Nnn", time, $$, $Randon_ID) );
	return $Randon_ID;
}
#==========================================================
sub Get_Referer { 
   return $ENV{'HTTP_REFERER'};
}
#==========================================================
sub HTML_Treat{
my ($List, $Method)=@_;

	$List=&Web_Decode($List);

     if ($Method eq "Show_Code") {
              $List =~ s/\</\&lt;/g;
			  $List =~ s/\>/\&gt;/g;
              $List =~ s/\&lt;CR\&gt;/<BR>/g;
              $List =~ s/  /\&nbsp;\&nbsp;/g;
      }
     elsif ($Method eq "Show_Safe_Code") {
			$List =~ s/<!--(.|\n)*-->//g;
			$List =~ s/\s-\w.+//g;
			$List =~ s/system\(.+//g;
			$List =~ s/grep//g;
			$List =~ s/\srm\s//g;
			$List =~ s/\srf\s//g;
			$List =~ s/\.\.([\/\:]|$)//g;
			$List =~ s/< *((SCRIPT)|(APPLET)|(EMBED))[^>]+>//ig;
	 }
     elsif ($Method eq "Remove_Code") {
			$List =~ s/<.+>?//g;
			$List =~ s/<!--(.|\n)*-->//g;
			$List =~ s/\s-\w.+//g;
			$List =~ s/system\(.+//g;
			$List =~ s/grep//g;
			$List =~ s/\srm\s//g;
			$List =~ s/\srf\s//g;
			$List =~ s/\.\.([\/\:]|$)//g;
			$List =~ s/< *((SCRIPT)|(APPLET)|(EMBED))[^>]+>//ig;
	 }

	 return $List;
}
#==========================================================
sub Check_Email_Address{
my($Email_Address) = shift;

    if ($Email_Address =~ /(@.*@)|(\.\.)|(@\.)|(\.@)|(^\.)|(\.$)/ || 
       ($Email_Address !~ /^.+\@localhost$/ && 
        $Email_Address !~ /^.+\@\[?(\w|[-.])+\.[a-zA-Z]{2,3}|[0-9]{1,3}\]?$/)) {
       return(0); #Error :Invalid email address
    }
    else {
        return(1); #Valid email address
    }
}
#==========================================================
sub Web_Decode{  
my ($Out)= shift;

	$Out =~ s/%([A-Fa-f0-9]{2})/pack("C",hex($1))/eg;
	return $Out;

}
#==========================================================
sub Web_Encode{  
my($Out) = shift;

   $Out =~ s/([^a-zA-Z0-9_\-.])/uc sprintf("%%%02x",ord($1))/eg;
   return $Out;

}
#==========================================================
sub Get_Cookies{ 
my ($Name, $Value);

	foreach (split(/; /,$ENV{'HTTP_COOKIE'})) {
                ($Name, $Value) = split(/=/);
				$Name =&Web_Decode($Name);
				$Value =&Web_Decode($Value);
                $Cookies{$Name} = $Value;
    }
}
#==========================================================
sub Set_Cookies{
my ($Name, $Value, $Exp) = @_;
my($Secure, $Expires);
	
	$Name =&Web_Encode($Name);
	$Value =&Web_Encode($Value);
	$Secure = "";
   
	if (!$Exp) { #Browser session
		$Expires="";
	}
	elsif ($Exp == -1) { #delete it
  		$Expires="expires=Wed, 09-nov-1970 00:00:00 GMT;";
	}
	else {
	  	  $Expires="expires=Wed, 09-nov-2050 00:00:00 GMT;";
	}

	print "Set-Cookie: ";
	print "$Name=$Value;  $Expires"; 
	print "\n";

}
#==========================================================
sub Delete_Cookies{
my (@Cookies_to_Delete) = @_;
my ($Name, $Exp);

$Exp="Wednesday, 01-Jan-80 00:00:00 GMT";
  foreach $Name (@Cookies_to_Delete) {
		delete $Set_Cookies{$Name} if ($Set_Cookies{$Name});
		delete $Cookies{$Name} if ($Cookies{$Name});
		print "Set-Cookie: $Name=deleted; expires=$Exp;\n";
  }

}
#==========================================================
sub Local_Time{
my($Time)=shift;
my($Local_Time);

	if (!$Time) {$Time=time;}

	if(defined $Global{'GMT_Offset'}) {
       $Local_Time = $Time + (3600 * $Global{'GMT_Offset'}); 
	}
	return $Local_Time;
}
#==========================================================
sub Check_Previous_User_Login{
	
	$Param{'User_ID'} = "";
	$Param{'Password'} = "";
	$Param{'Remember_login'} = "";

	if ($Cookies{'User_User_ID'} && $Cookies{'User_Password'} ){
			#if 	(!&Check_User_Authentication($Cookies{'User_User_ID'}, $Cookies{'User_Password'})){
			#	return 0;
			#}
			$Param{'User_ID'} =$Cookies{'User_User_ID'};
			$Param{'Password'} = $Cookies{'User_Password'};
			$Param{'Remember_login'} = $Cookies{'User_Remember_login'};
			$Param{'User_ID'} = lc($Param{'User_ID'});
			return 1;
	}
	else{
			return 0;
	}

}
#==========================================================
sub Time{
my($Time)=shift;

	if (! int($Time)) {$Time=time;}

	if($Global{'GMT_Offset'}) {
	       $Time = int($Time + (3600 * $Global{'GMT_Offset'})); 
	}
	return $Time;
}
#==========================================================
1;