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
sub Language_Manager{

		&Print_Page(&Language_Admin_Form );

}
#==========================================================
sub Set_Default_Language{
my %data;

	 if (!&Lock($Global{'Configuration_File'})) {&Exit("Cannot Lock database file $Global{'Configuration_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}

	tie %data, "DB_File", $Global{'Configuration_File'}, O_RDWR | O_CREAT, 0640, $DB_HASH 
                                         or &Exit( "Cannot open database file $Global{'Configuration_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	$data{'Language'}=$Param{'Language'};
	$Global{'Language'}=$data{'Language'};
	untie %data;
	undef %data;
	
	&Unlock($Global{'Configuration_File'});

	&Language_Manager;

}
#==========================================================
sub Delete_Language{
my ($dir, $file, @files);

	$dir="$Global{'Language_Dir'}/$Param{'Delete_Language'}";
	undef @files;

	opendir(Dir, "$dir");
	foreach $file (  readdir(Dir)  ) {
			push (@files, $file);
    }

	closedir(Dir);

	foreach $file(@files){
		if($file ne "." && $file ne "..") { 
			unless ( -d "$dir/$file") {
				unlink ("$dir/$file") or &Exit("can't remove language file $dir/$file: $!"."<BR>Line ". __LINE__ . ", File ". __FILE__);
			}
		}

	}

	rmdir ($dir) or &Exit( "can't remove language directory $dir: $!"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	&Initialize_Language;

}
#==========================================================
sub Create_New_Language {
my $Base_Language;
my $Dir;
my $File;

	$Dir="$Global{'Language_Dir'}/$Param{'New_Language_Name'}";
	mkdir ($Dir, 0777)   or  &Exit("Can't creat language directory $Dir: $!"."<BR>Line ". __LINE__ . ", File ". __FILE__);
	$Base_Language="$Global{'Language_Dir'}/$Param{'Inherit_Language'}";
	opendir(Base_Lang_Dir, "$Base_Language");
	foreach $File (  readdir(Base_Lang_Dir)  ) {
			copy("$Base_Language/$File",	"$Dir/$File");
    }

	closedir(Base_Lang_Dir);
	chmod (0777, $Dir);
	
	&Initialize_Language;

}
#==========================================================
sub Language_List{
my ($x, $Out, @dirlist, $file, $lines, $title, $dir);

	$dir="$Global{'Language_Dir'}";
	undef @dirlist;
	opendir(Dir, "$dir");
	foreach $file (  readdir(Dir)  ) {
			push (@dirlist, "$file");
    }

	closedir(Dir);

	 $Out = "";

	for $x(0..$#dirlist) {
			$file=$dirlist[$x];
			if(-d "$dir/$file" && $file ne "." && $file ne "..") { 
				$selected="";
				if (lc($file) eq lc($Global{'Language'}) ) {$selected="selected"; }
					 $Out.=qq!<option value="$file" $selected>$file</option>!;
			}
	}

	return $Out;

 }
#==========================================================
sub Initialize_Language{
my (%data, $x, $Out, @dirlist, $file, $lines);
my ($title, $lang, $dir);

	$dir = "$Global{'Language_Dir'}";
	
	undef @dirlist;

	opendir(Dir, "$dir");
	foreach $File (  readdir(Dir)  ) {
			push (@dirlist, "$File");
    }

	closedir(Dir);

	@dirlist =sort @dirlist;
	
	$lang = "";

	for $x(0..$#dirlist ) {
				$file=$dirlist[$x];
				if (-d "$dir/$file" && $file ne "." && $file ne ".." && $file !~ m/\_/) { 
							$lang .= "|$file";
				}
	}
	$lang =~ s/^\|//;
	
	 if (!&Lock($Global{'Configuration_File'})) {&Exit("Cannot Lock database file $Global{'Configuration_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);}

	tie %data, "DB_File", $Global{'Configuration_File'}, O_RDWR | O_CREAT, 0640, $DB_HASH 
                                         or &Exit( "Cannot open database file $Global{'Configuration_File'}: $!\n"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	$data{'Languages'}= $lang;

	untie %data;
	undef %data;
	&Unlock($Global{'Configuration_File'});

	&Language_Manager;
}
#==========================================================
sub Get_Installed_Languages{
my (%data, $x, $Out, @dirlist, $file, $lines);
my ($title, $lang, $dir, @Languages);

	$dir = "$Global{'Language_Dir'}";
	
	undef @dirlist;
	undef @Languages;

	opendir(Dir, "$dir");
	foreach $file (  readdir(Dir)  ) {
			push (@dirlist, "$file");
    }

	closedir(Dir);

	@dirlist =sort @dirlist;
	
	$lang = "";

	for $file(@dirlist ) {
				if (-d "$dir/$file" && $file ne "." && $file ne ".." && $file !~ m/^\_/) { 
							push @Languages, $file;
				}
	}
	
	return @Languages;
}
#==========================================================
sub List_Language_Files {
my $x;
my $Language;
my $Out;
my @dirlist;
my $file;
my $Lines;
my $title;
my %Title;

	$Title{'accesslock.pm'}="Access Lock Page";
	$Title{'contact.pm'}="Contact Us Page";
	$Title{'editprofile.pm'}="My profile Page";
	$Title{'general.pm'}="Home Page/General";
	$Title{'login.pm'}="Users Login Pages";
	$Title{'preferences.pm'}="Preferences";
	$Title{'previewitem.pm'}="Preview Item Page";
	$Title{'registration.pm'}="Registration Page";
	$Title{'search.pm'}="Search Pages";
	$Title{'setlanguage.pm'}="Select Language Page";
	$Title{'submititem.pm'}="Submit Item Page";
	$Title{'uploadfile.pm'}="Upload Files Page";
	$Title{'viewitem.pm'}="View Item Page";
	$Title{'categories.pm'}="Program Categories";
	$Title{'aboutus.pm'}="About Us Page";
	$Title{'alertme.pm'}="Alert Me Pages";
	$Title{'announcements.pm'}="Announcements Page";
	$Title{'custom.pm'}="User Defined Custom Classes";
	$Title{'emailauction.pm'}="Email Auction to a Friend";
	$Title{'help.pm'}="Main Help Index Page";
	$Title{'helppages.pm'}="Help Pages Contents";
	$Title{'bidding.pm'}="Bidding Pages";
	$Title{'privacypolicy.pm'}="Privacy policy Page";
	$Title{'searchtips.pm'}="Search Tips Page";
	$Title{'useragreement.pm'}="User Agreement Page";
	$Title{'speciallist.pm'}="Special Lists Pages";
	$Title{'feedback.pm'}="Feedback Forum Pages";

	
	$Language=$Param{'Edit_Language'};
	$dir="$Global{'Language_Dir'}/$Language";
	
	undef @dirlist;
	opendir(Dir, "$dir");
	foreach $File (  readdir(Dir)  ) {
			push (@dirlist, "$File");
    }

	closedir(Dir);

	@dirlist= sort @dirlist;

	$Out="";
	$y=1;
	for $x(0..$#dirlist) {
		$file=$dirlist[$x];
		if ($Title{$file} eq "") {$Title{$file} = $file;}
		
		if ($file=~ m/\.pm$/) {
			if (-f  "$dir/$file") {
			   $Out .= qq!<TR><TD align="right"><B>$y-</B></TD><TD>
				   <A HREF=$Script_URL?action=Edit_Language_File&Language=$Param{'Edit_Language'}&Filename=$file>
				   <B>$Title{$file}</B>
				   </TD></TR>!;		
				   $y++;
			}
		}
	}

	return $Out;
 }
#==========================================================
sub Edit_Language{
	
		&Print_Page(&Edit_Language_Files_List_Form);

}
#==========================================================
sub Edit_Language_File{

	&Print_Page(&Edit_Language_File_Form);

}
#==========================================================
sub Encode_Form{
my $Temp =shift;

	$Temp =~ s/\"/\&quot\;/g;
    $Temp =~ s/\'/\&\#39\;/g;	
	$Temp =~ s/\</\&lt\;/g;
	$Temp =~ s/\>/\&gt\;/g;

	return $Temp;
}
#==========================================================
sub Load_Language_File{
my ($Filename, $Line, $delimiter, @Variables);
my ($Out, $Key, $Value, $Count);
my (%Var, %Cats, @Subs, $Sub, $Key1);

	$Filename="$Global{'Language_Dir'}/$Param{'Language'}/$Param{'Filename'}";
	open(FILE,"$Filename") or &Exit( "Error: Can't open file $Filename: $!"."<BR>Line ". __LINE__ . ", File ". __FILE__);
	@Variables = <FILE>;
	close(FILE);

	if ($Param{'Filename'} eq "categories.pm") {
			foreach $Line (@Variables) {
				chomp($Line);
				#$Line =~ s/^\s+//;
				if ($Line) {
						($Key, $Value)=split('~==~', $Line);
						$Var{$Key}=$Value;
				}
			}

			&Prepare_Categories;
			
			undef @Variables;
	
			for $x (0..$All_SubCategories_Count-1) {
						undef @Subs;
						@Subs=split(/\:/, $Category_URL[$x]);
						foreach $Sub (@Subs) {
									if ($Var{$Sub}) {
										$Cat_Var=$Var{$Sub}; 
									} 
									else{
										$Cat_Var=$Sub; 
									}

									$Cats{$Sub}=$Cat_Var;
						}
			}

			$Count=0;
			while (($Key, $Value) = (each %Cats)) {
				$Variables[$Count++]="$Key"."~==~"."$Value";
			}
	}#endif filename=categories.pm

	

	#$/="\n";
	 $Out=qq!
      <tr>
        <td align="right" height="38" bgcolor="#B6DEDC">
          <b><font color="#003046" size="4">
		  #
		  </font></b>
        </td>

		<td width="100%" height="38" bgcolor="#B6DEDC">
          <b><font color="#003046" size="4">
		  Program Object Name
		  </font></b>
        </td>
        <td width="100%" height="38" bgcolor="#B6DEDC">
          <b><font color="#003046" size="4">
		  Text Value (HTML is allowed)
		  </font></b>
        </td>
      </tr>
	!;
	
	@Variables= sort @Variables;	
	$Counter=0;

	foreach $Line (@Variables) {
		chomp($Line);
		($Key, $Value)=split('~==~', $Line);
		$Key=~ s/\_/ /g;
		$Objects{$Key}=&Encode_Form($Value);
	}
	
	@Keys= sort keys %Objects;

	foreach $Key (@Keys) {
		$Value=$Objects{$Key};
		$Key1=ucfirst($Key); 

		$Counter++;

        if( length($Value) >= 60) { 
           if( length($Value) >= (60)) { $Row=4;}
           if( length($Value) >= (60*3) ){ $Row=5;}
           if( length($Value) >= (60*5) ){ $Row=8;}
           if( length($Value) >= (60*7)) { $Row=10;}
           if( length($Value) >= (60*15)) { $Row=20;}
           if( length($Value) >= (60*25)) { $Row=30;}
           $Out .= qq!<tr>
							<td bgcolor="#B6DEDC"  align="right" ><b>$Counter-</b></td>
							<td bgcolor="#B6DEDC" ><b>$Key1</b></td>
							<td bgcolor="#B6DEDC">
							<textarea name="$Key" rows=$Row cols=52 wrap=virtual  onfocus="select();">$Value</textarea>
							</td></tr>!;
        }
        else { 
           $Out .= qq!<tr>
								<td bgcolor="#B6DEDC" align="right" ><b>$Counter-</b></td>
								<td bgcolor="#B6DEDC" ><b>$Key1</b></td>
								<td bgcolor="#B6DEDC">
								<input type="text" name="$Key" value="$Value" size=60  onfocus="select();">
								</td></tr>!;
        }

	}

	$Out.=qq!<tr><td colspan=3 bgcolor="#B6DEDC" align="center" height="40">
								<p align="center">
								<input type="submit" value="Save Changes"> &nbsp;
								<input type="reset" value="Restore">&nbsp;
								<input onclick="history.go(-1);" type="button" value="Cancel">
								
					     </td>
					  </tr>!;


	$Counter++;
	$Out.=qq!<tr><td colspan=3 align="center">
								<B><font color="#ffffff">Add New Language Object to This File</font></b>
					  </td></tr>
					  <tr>

					  <td  bgcolor="#B6DEDC"  align="center" colspan=2 >Object Name(Case Sensitive)<br>
                       <input name="New_Variable" size=35 onfocus="select();"> </TD>
					   <td  bgcolor="#B6DEDC"   align="center" >Object Text Value (HTML is allowed)<br>
					   <input name="New_Value" size=50 onfocus="select();">
					   </td></tr>!;

	return $Out;
	
}
#==========================================================
sub Save_Language_File{
my $Filename;
my ($Key, $Value);

	$Filename="$Global{'Language_Dir'}/$Param{'X_Selected_Language'}/$Param{'Filename'}";

	open(FILE,">$Filename") or &Exit( "Error: Can't open file $Filename: $!"."<BR>Line ". __LINE__ . ", File ". __FILE__);

	while (($Key, $Value)=(each %Param) ){
      if($Key ne "action" && $Key ne "Filename" && $Key ne "X_Selected_Language" && 
												$Key ne "New_Variable" && $Key ne "New_Value") {

         $Value =~ s/\n/ /g;
         $Value =~ s/\r/ /g;
         $Value =~ s/\cM/ /g;
		 $Key=~ s/\s+/_/g;

         print FILE "$Key~==~$Value\n";
      }
   }

   if($Param{'New_Variable'} && $Param{'New_Value'}) { 

		print FILE "$Param{'New_Variable'}~==~$Param{'New_Value'}\n";

   }

	close(FILE);
	
	&Admin_Msg("File Saved", "Language File Successfully Saved.",2);
}
#==========================================================
sub Language_Admin_Form{
my $Out;
my $Languages;
my $Edit_Languages;
my $Inherit_Languages;
my $Initialize_Language;
my($Help);

	$List=&Language_List;

	$Help=&Help_Link("Language_Manager");

	$Out=qq!<select size="1" name="Language">!;
	$Languages=$Out.$List."</select>";

	$Out=qq!<select size="1" name="Edit_Language">!;
	$Edit_Languages=$Out.$List."</select>";

	$Out=qq!<select size="1" name="Delete_Language">!;
	$Delete_Languages=$Out.$List."</select>";

	$Out=qq!<select size="1" name="Inherit_Language">!;
	$Inherit_Languages=$Out.$List."</select>";

	$Initialize_Language=qq!<a href="$Script_URL?action=Initialize_Language"><b>Initialize Languages</b></a>!;

$Out=<<HTML;
 
<div class="lbr" align="center">
    <center>
    <table border="0" width="100%" bgcolor="#003046" cellspacing="0" cellpadding="1">
      <tr>
        <td width="100%" bgcolor="#003046" valign="middle" align="center">
          <div align="center">
            <center>
            <table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td width="23%"></td>
                <td width="52%">
                  <p align="center"><b><font face="Verdana,Arial, Helvetica" size="4" color="#00FFFF">Language
                  Manager</font></b></p>
                </td>
                <td width="25%">
                  <p align="center">$Help</p>
                </td>
              </tr>
            </table>
            </center>
          </div>
        </td>
      </tr>

	  <tr>
        <td width="100%" bgcolor="#B6DEDC" align="center">
            <div align="center">
              <center>
              <table border="0" width="100%" bgcolor="#003046" cellspacing="1" cellpadding="5">
                <tr>
                  <td bgcolor="#B6DEDC" width="50%"><b>Prepare All Available Languages</b></td>
                  <td bgcolor="#B6DEDC" width="50%">

				  $Initialize_Language

					&nbsp;&nbsp;&nbsp;&nbsp;
				</td>
                </tr>
              </table>
              </center>
            </div>
          </form>
        </td>
      </tr>
	
	  <tr>
        <td width="100%"  bgcolor="#B6DEDC" align="center">
            <div align="center">
              <center>
              <table border="0" width="100%" bgcolor="#003046" cellspacing="01" cellpadding="5">
                <tr>
			      <form method="POST" action="$Script_URL">
					<input type="hidden" name="action" value="Set_Default_Language">
				  <td bgcolor="#B6DEDC" width="50%"><b>Select Program Default Language</b></td>
                  <td bgcolor="#B6DEDC" width="50%">

				  $Languages

					&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="submit" value="Set Default Language" >
					</td>
		          </form>
                </tr>
              </table>
              </center>
            </div>
        </td>
      </tr>

	  <tr>
        <td width="100%"  bgcolor="#B6DEDC" align="center" valign="middle">
            <div align="center">
              <table border="0" width="100%" bgcolor="#003046" cellspacing="01" cellpadding="5">
                <tr>
          <form method="POST" action="$Script_URL">
			<input type="hidden" name="action" value="Edit_Language">
				  <td bgcolor="#B6DEDC" width="50%"><b>Select Language To Edit</b></td>
                  <td bgcolor="#B6DEDC" width="50%">

				  $Edit_Languages

					&nbsp;&nbsp;&nbsp;&nbsp; 
			<input type="submit" value="Edit Language" name="   Edit_Language   ">
          </td>
          </form>
				</tr>
              </table>
            </div>
        </td>

      </tr>
      
      <tr>
        <td width="100%"  bgcolor="#B6DEDC" align="center" valign="middle">
            <div align="center">
              <table border="0" width="100%" bgcolor="#003046" cellspacing="1" cellpadding="5">
                <tr>
	          <form method="POST" action="$Script_URL">
				<input type="hidden" name="action" value="Delete_Language">
				  <td bgcolor="#B6DEDC" width="50%"><b>Select Language To Delete <font color="red">(Un-recoverable)</font></b></td>
                  <td bgcolor="#B6DEDC" width="50%">

				  $Delete_Languages
					
					&nbsp;<font color="red"><b>!</b></font> &nbsp;&nbsp; 
			<input type="submit" value="Delete Language!">
          </td>
          </form>
				</tr>
              </table>
            </div>
        </td>
      </tr>


      <tr>
        <td width="100%" height="38" bgcolor="#B6DEDC">
          <form method="POST" action="$Script_URL">
			<input type="hidden" name="action" value="Create_New_Language">
            <div align="center">
              <center>
              <table border="0" width="100%" cellspacing="0" cellpadding="5">
                <tr>
                  <td width="100%"  colspan="2"><b>
				  <font size =4 color="#000000">
				  <p align="left">Create New Language</p>
				  </font></b></td>
                </tr>
                <tr>
                  <td width="50%" bgcolor="#B6DEDC"><b>Select Language to Translate From:</b></td>
                  <td width="50%" bgcolor="#B6DEDC">
				  
				  $Inherit_Languages

					</td>
                </tr>
                <tr>
                  <td width="50%" bgcolor="#B6DEDC"><b>New Language Name</b>:</td>
                  <td width="50%" bgcolor="#B6DEDC"><input type="text" name="New_Language_Name" size="20" onFocus="select();"></td>
                </tr>
                <tr>
                  <td width="100%" colspan="2" bgcolor="#B6DEDC">
                    <p align="center"><br>
                    <input type="submit" value="Create Language" name="Create_Language">&nbsp;
                    <input type="reset" value="Clear Form">&nbsp; <input onclick="history.go(-1);" type="button" value="Cancel"></td>
                </tr>
              </table>
              </center>
            </div>
          </form>
        </td>
      </tr>
    </table>
    </center>
  </div>


HTML
return $Out;

}
#==========================================================
sub Edit_Language_Files_List_Form{
my $Out="";
my $Go_Back_Button;
my $Language_Files;

	$Go_Back_Button=&Go_Back(0);
	$Language_Files=&List_Language_Files;
#<div align="center">
$Out=<<HTML;
<div class="lbr" align="center">

    <center>
    <table border="0" width="100%" bgcolor="#003046" cellspacing="1" cellpadding="2">
      <tr>
        <td width="100%" bgcolor="#003046" valign="middle" align="center">
          <div align="center">
            <center>
            <table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td width="23%"></td>
                <td width="52%">
                  <p align="center"><b><font face="Verdana,Arial, Helvetica" size="5" color="#00FFFF">Edit
                  Language</font></b></p>
                </td>
                <td width="25%">
                  <p align="center"><a href="http://"><font color="#E1E1C4"><b>Help</b></font></a></p>
                </td>
              </tr>
            </table>
            </center>
          </div>
        </td>
      </tr>
      <form method="POST" action="$Script_URL"></form>
      
      <tr>
        <td width="100%" height="38" bgcolor="#B6DEDC">
          <b><font color="#FF00FF" size="5">$Param{'Edit_Language'} Language Files</font></b>
        </td>
      </tr>
      
      <tr>
        <td align="center" width="100%"  bgcolor="#B6DEDC">
			<table border=1 width ="100%" cellspacing=2 cellpadding=4>
	
			  $Language_Files

			</table>
        </td>
      </tr>
      
      <tr>
        <td width="100%" height="38" bgcolor="#B6DEDC">
          <p align="center">
		  
		  $Go_Back_Button

        </td>
      </tr>
    </table>
    </center>
  </div>

HTML
return $Out;
};
#==========================================================
sub Edit_Language_File_Form{
my $Variables;
my $Langfile;

	$Variables=&Load_Language_File;
	$Langfile =$Param{'Filename'};
	$Langfile =~ s/\.pm//g;

$Out=<<HTML;
<form method="post" action="$Script_URL">

 <input type="hidden" name="action" value="Save_Language_File">
  <input type="hidden" name="Filename" value="$Param{'Filename'}">
   <input type="hidden" name="X_Selected_Language" value="$Param{'Language'}">

<div class="lbr" align="center">
    <center>
    <table border="0" width="100%" bgcolor="#003046" cellspacing="1" cellpadding="5">
      <tr>
        <td width="100%" bgcolor="#003046" valign="middle" align="center">
          <div align="center">
            <center>
            <table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td width="23%"></td>
                <td width="52%">
                  <p align="center"><b><font face="Verdana,Arial, Helvetica" size="5" color="#00FFFF">Edit
                  Language</font></b></p>
                </td>
                <td width="25%">
                  <p align="center"><a href="http://"><font color="#E1E1C4"><b>Help</b></font></a></p>
                </td>
              </tr>
            </table>
            </center>
          </div>
        </td>
      </tr>
      
      <tr>
        <td width="100%" height="38" bgcolor="#B6DEDC">
          <b><font color="#003046" size="3">
		  
		 Language: $Param{'X_Selected_Language'}    &nbsp;&nbsp&nbsp;&nbsp;&nbsp; File: $Langfile

		  </font></b>
        </td>
      </tr>

      <tr>
        <td width="100%" height="38" bgcolor="#B6DEDC">
			<table width="100%" bgcolor="#003046" cellspacing="1" cellpadding="3">
	
			  $Variables

			</table>
        </td>
      </tr>
      
      <tr>
        <td width="100%" colspan="2" height="25" bgcolor="#B6DEDC">
          <p align="center">
			<input type="submit" value="Create New Object"> &nbsp;
				<input type="reset" value="Restore">&nbsp;
			<input onclick="history.go(-1);" type="button" value="Cancel">
		  </td>
      </tr>
		  
    </table>
    </center>
  </div>
</form>

HTML
return $Out;
};
#==========================================================
#==========================================================
1;