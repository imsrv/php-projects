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
#package Auction;
print "Content-Type: text/html\n\n";
#print &Server_Config;
# Unbuffer Output
$| = 1;
print &Get_Server_Test;
exit 0;
#==========================================================
sub Get_Sys_OS{ 

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
sub Get_Perl_Path{
my ($Out, $Outs);

	$OS=Get_Sys_OS;
					
	if ($OS =~ m/unix/i) {
		$Outs=qq!<TABLE  width="100%" border="1" cellspacing="1" cellpadding="3">!;

		$Out=`which perl`;
		@Path = split(" ", $Out);
		$Out = join("<br>", @Path);

		$Outs.=qq!<TR><TD aligin="center" width="30%"><b>Perl Path (which perl): </b> </td><td><font color=blue>$Out</font><BR>\n</td></tr>!;
		$Out=`whereis perl`;

		@Path = split(" ", $Out);
		$Out = join("<br>", @Path);
		$Outs.=qq!<TR><TD aligin="center" width="30%"><b>Perl Path(whereis perl): </b></td><td> <font color=blue>$Out</font><BR>\n</td></tr>!;

		$Out=`which sendmail`;
		@Path = split(" ", $Out);
		$Out = join("<br>", @Path);
		$Outs.=qq!<TR><TD aligin="center" width="30%"><b>Sendmail Location(which sendmail): </b></td><td> <font color=blue>$Out</font><BR>\n<td></tr>!;

		$Out=`whereis sendmail`;
		@Path = split(" ", $Out);
		$Out = join("<br>", @Path);
		$Outs.=qq!<TR><TD aligin="center" width="30%"><b>Sendmail Location(whereis sendmail): </b></td><td> <font color=blue>$Out</font><BR>\n</td></tr>!;
		$Outs.=qq!</table>!;
	}
	else{
		$Outs="Windows System, can't  detemine perl  and sendmail path...!"
	}

	return ($Outs);
} 
#==========================================================
sub OS_Version{
my $Out;

	$Out=qq!<TABLE  width="100%" border="1" cellspacing="1" cellpadding="3">!;
   $Out .= qq!<TR><TD aligin="center" width="30%"><B>Perl Version:</b><td> $]</td></tr>\n!;
   $Out .= qq!<TR><TD aligin="center" width="30%"><B>Operating System</B>:</td><td> $^O<BR>\n</td></tr>!;
   $Out .=qq!</table>!;
   return $Out;

}
#==========================================================
sub SQL_Drivers{
my (@drivers, $Out);

eval "use DBI";
 if ($@) { return "SQL Drivers: None!!";}

  $Out = qq!<TABLE  width="100%" border="1" cellspacing="1" cellpadding="3">!;

@drivers= DBI->available_drivers();# or $Out.="No drivers found!\n<br>";

foreach my $driver (@drivers) {
	$Out.=qq!<TR><TD aligin="center" width="30%"> Driver <u><b>$driver</b></u>\n</td><td><font color=blue>Installed</font><br></td></tr>!;
	#my @dataSources = DBI->data_sources($driver);
	
	foreach my $dataSource (@dataSources ) {
		#	$Out.= "\tData Source is $dataSource\n<br>";
	}
	#$Out.="\n<br>";
}
$Out.=qq!</table>!;
	return $Out;
}
#==========================================================
sub Module_Test {
my $Out;
my $Out4;

   eval "use DB_File";
   $Out = qq!<TABLE  width="100%" border="1" cellspacing="1" cellpadding="3">!;

   if ($@) {
		$Out .= qq!<TR><TD aligin="center" width="30%">Module <b><u>DB_File</u></b> </td><td><font color=red>Not Found</font>.<BR>\n</td></tr>!;
   }
   else { 
		$Out .= qq!<TR><TD aligin="center" width="30%">Module <b><u>DB_File</u></b> </td><td><font color=blue>Found.</font><BR>\n</td></tr>!;
   }

   eval "use File::Copy";
   if ($@) {
		$Out .= qq!<TR><TD aligin="center" width="30%">Module <b><u>File::Copy</u></b></td><td> <font color=red>Not Found</font>.<BR>\n</td></tr>!;
   }
   else {
		$Out .= qq!<TR><TD aligin="center" width="30%">Module <b><u>File::Copy</u></b></td><td> <font color=blue>Found</font>.<BR>\n</td></tr>!;
   }

   eval "use DBI";
   if ($@) {
		$Out .= qq!<TR><TD aligin="center" width="30%">Module <b><u>DBI</u></b> </td><td><font color=red>Not Found</font>.<BR>\n</td></tr>!;
   }
   else { 
		$Out .= qq!<TR><TD aligin="center" width="30%">Module <b><u>DBI</u></b></td><td> <font color=blue>Found.</font><BR>\n</td></tr>!;
		$Out4=&SQL_Drivers;
   }

   eval "use Cwd";
   if ($@) {
		$Out .= qq!<TR><TD aligin="center" width="30%">Module <b><u>Cwd</u></b></td><td> <font color=red>Not Found</font>.<BR>\n</td></tr>!;
   }
   else {
		$Out .= qq!<TR><TD aligin="center" width="30%">Module <b><u>Cwd</u></b></td><td> <font color=blue>Found</font>.!;
		$Out.=", Current directory is: ";
		$Out.=cwd;
		$Out.=qq!<BR>\n</td></tr>!;
   }

   eval "use Fcntl";
   if ($@) {
		$Out .= qq!<TR><TD aligin="center" width="30%">Module <b><u>Fcntl</u></b></td><td> <font color=red>Not Found</font>.<BR>\n</td></tr>!;
   }
   else {
		$Out .= qq!<TR><TD aligin="center" width="30%">Module <b><u>Fcntl</u></b> </td><td><font color=blue>Found</font>.<BR>\n</td></tr>!;
   }

eval "use Socket";
   if ($@) {
		$Out .= qq!<TR><TD aligin="center" width="30%">Module <b><u>Socket</u></b></td><td> <font color=red>Not Found</font>.<BR>\n</td></tr>!;
   }
   else { 
		$Out .= qq!<TR><TD aligin="center" width="30%">Module <b><u>Socket</u></b> </td><td><font color=blue>Found.</font><BR>\n</td></tr>!;
   }

eval "use LWP::Simple";
   if ($@) {
		$Out .= qq!<TR><TD aligin="center" width="30%">Module <b><u>LWP::Simple</u></b></td><td> <font color=red>Not Found</font>.<BR>\n</td></tr>!;
   }
   else { 
		$Out .= qq!<TR><TD aligin="center" width="30%">Module <b><u>LWP::Simple</u></b> </td><td><font color=blue>Found.</font><BR>\n</td></tr>!;
   }

eval "use LWP::UserAgent";
   if ($@) {
		$Out .= qq!<TR><TD aligin="center" width="30%">Module <b><u>LWP::UserAgent</u></b></td><td> <font color=red>Not Found</font>.<BR>\n</td></tr>!;
   }
   else { 
		$Out .= qq!<TR><TD aligin="center" width="30%">Module <b><u>LWP::UserAgent</u></b> </td><td><font color=blue>Found.</font><BR>\n</td></tr>!;
   }
=cut_this
eval "use Net::SSLeay";
   if ($@) {
		$Out .= qq!<TR><TD aligin="center" width="30%">Module <b><u>Net::SSLeay</u></b> </td><td><font color=red>not found</font>.<BR>\n</td></tr>!;
   }
   else { 
		$Out .= qq!<TR><TD aligin="center" width="30%">Module <b><u>Net::SSLeay</u></b> </td><td><font color=blue>found.</font><BR>\n</td></tr>!;
  }
=cut
	$Out.=qq!</table>!;
		return ($Out, $Out4);
 }
#==========================================================
sub Server_Config{
my $Out;
my $key;
my %EN;

   @EN= keys %ENV;
   @EN= sort  @EN;

	$Out="<table width=100% border=1 cellspacing=1 cellpadding=3>";
	$Out.=qq!<tr><td  width="30%"><font color=red size =3><b>Variable</b></font></td><td><font color=red size =3><b>Value</b></font></td></tr>!;

   foreach $key(@EN) {
			$Out .= qq!<tr><td ><font color=blue>  $key:</td><td></font> <I>  $ENV{$key}</I></td></tr>!; 
	}

	$Out .= "</Table>";
	
	return $Out;
}
#==========================================================
sub Get_Server_Test{
my ($Out, $Out1, $Out2, $Out3, $Out4, $Modules);

	($Out1, $Out4) = &Module_Test;
	$Out2 = &Server_Config;
	$Out3 = &OS_Version;
	$Out4 = &SQL_Drivers;
	$Out5 = &Get_Perl_Path;
	$Modules = &Get_Perl_Modules;

$Out=<<HTML;
			<TABLE width="100%" cellpadding="5">
			<TR>	<TD aligin="center" bgcolor="#003046" >
				<Font color="#FFFFFF" size=4><b>
				
				Operating System and Perl Version

				</b>	</font>
			</TD></TR>

			<TR>	<TD>
			
			$Out3
			</TD></TR>
			<TR>	<TD aligin="center" bgcolor="#003046">
				<Font color="#FFFFFF" size=4><b>
				
				Perl Path and Sendmail Location

				</b>	</font>
			</TD></TR>

			<TR>	<TD>
			
			$Out5

			</TD></TR>
			
			<TR>	<TD aligin="center" bgcolor="#003046">
				<Font color="#FFFFFF" size=4><b>
				
					Server test for required perl modules

				</b>	</font>
			</TD></TR>

			<TR>	<TD>

			$Out1
			
			</TD></TR>

			<TR>	<TD aligin="center" bgcolor="#003046">
				<Font color="#FFFFFF" size=4><b>
				
					DBI Installed Drivers and Data Sources

				</b>	</font>
			</TD></TR>

			<TR>	<TD>
			$Out4
			</TD></TR>
			

			<TR><TD align="center" bgcolor="#003046"><Font color="#FFFFFF" size=4><b>Server Environment</b>	</font></TD></TR>
			<TR><TD>$Out2</TD></TR>
			<TR><TD align="center" bgcolor="#003046"><Font color="#FFFFFF" size=4><b>Installed perl modules</b>	</font></TD></TR>
			<TR><TD>$Modules</TD></TR>

			<TR><TD align="center"><A HREF="javascript:history.go(-1)"><b>Back to the previous page</b></A></TD></TR>
			<TR><TD align="center" bgcolor="#003046"><Font color="#FFFFFF" size=4><b>Copyright © 2001 <A href="https://www.safeweb.com/o/_i:http://www.mewsoft.com"><font color="yellow">Mewsoft</font></A>. All rights reserved </b>	</font></TD></TR>
		</TABLE>	
HTML

	return $Out;
}
#==========================================================
sub Get_Perl_Modules{
my(@Modules, $Rows, $Col, $Table, $x, $y, $Count);

	@Modules = &Get_Installed_Perl_Modules;
	@Modules = sort @Modules;
	
	$Rows = "";
	$Col = 0; $Counter = 0;
	$Count = @Modules;

	for $x(0..$Count -1){
			if ($Col == 0){$Rows .= qq!<TR>!;}
			if (!$Modules[$x]) {$Modules[$x] = "&nbsp;";}
			$Counter ++;
			$y = $Modules[$x];
			$y =~ s/^(\S+::)/\<B\>$1\<\/B\>/;
			$Rows .= qq!<TD>$Counter- $y</TD>!;
			$Col++;
			if ($Col > 2){$Rows .= qq!</TR>!; $Col = 0;}
	}

	if ($Col >0 && $Col< 3) {
			for $x($Col..2){
					$Rows .= qq!<TD>&nbsp;</TD>!;
			}
	}

	$Table = qq!<table align="center" width="100%" border="1" cellpadding="2" cellspacing="1">$Rows</table>!;

}
#==========================================================
sub Get_Installed_Perl_Modules{
my(@Modules, $Perl_Include_Dir, @Found, @Temp_Modules);

	undef @Modules;

	foreach $Perl_Include_Dir(@INC) {
			$Perl_Include_Dir =~ s/^\s//g;
			$Perl_Include_Dir =~ s/\s$//g;
			if ($Perl_Include_Dir) {
					@Found = &Scan_Directory($Perl_Include_Dir);	
					@Temp_Modules = &Filter_Perl_Modules(@Found);
					push @Modules, @Temp_Modules;
			}
	}

	return @Modules;
}
#==========================================================
sub Scan_Directory{
my($Directory)=@_;
my(@Files, %Found);

	%Found = ();
	@Files = ();
	
	my $CRLF = "\015\012"; # how lines should be terminated; "\r\n" is not correct on all systems, for instance MacPerl defines it to "\012\015"

	%Found = &Scan_Dir($Directory);

	while (($Key, $Value)= each %Found) {
			if (!$Value) {
				push @Files, $Key;
			}
	}

	return @Files;
}
#==========================================================
sub Scan_Dir{
my($Directory)=@_;
my(@Directories, @Files, %Found);
my($Current_Directory);

	undef @Directories;
	undef %Found;
	undef @Files;

	if (!$Directory) {$Directory = '.';}

	push @Directories, $Directory;
	
	while (@Directories) {
		   $Current_Directory = shift (@Directories);

		   opendir (DIR, "$Current_Directory") or return undef;# die ("Can't open $Current_Directory: $!");
		   @Files = readdir (DIR);
		   closedir (DIR);

		   foreach $File (@Files) {
					$Temp = "$Current_Directory/$File";
					  if (-d $Temp && $File ne "." && $File ne "..") {
								push @Directories, $Temp;
								$Found{$Temp} = 1;
								next;
					  }
					  else{
								if ($File ne "." && $File ne "..") {
										$Found{$Temp} = 0;
								}
					  }
			}
	}

	return %Found;
}
#==========================================================
sub Filter_Perl_Modules{
my(@Files)=@_;
my(%Modules);

	foreach $File(@Files){
		if ($File =~ m/\.pm$/){
			open(FILE, $File) or return undef;
				while(<FILE>){	
						if (/^ *package +(\S+);/){
							$Modules{$1}++;
							last;
						}
				}
		}
	}

	return keys %Modules;
}
#==========================================================
#==========================================================