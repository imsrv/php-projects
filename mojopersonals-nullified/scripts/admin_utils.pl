############################################################
sub UtilsMain{
	require "utils.pl";
	$ADMIN{'backup'} = $ADMIN{'export'} = $ADMIN{'import'} = $ADMIN{'restore'} =$ADMIN{'repair'} =$ADMIN{'utils'};
	if($FORM{'class'} eq "backup"){			&Backup;				}
elsif($FORM{'class'} eq "export"){		&Export;				}
	elsif($FORM{'class'} eq "import"){		&Import;				}
	elsif($FORM{'class'} eq "restore"){		&Restore;			}
	elsif($FORM{'class'} eq "repair"){		&Repair;				}
	elsif($FORM{'class'}){	&PrintAdminError($mj{'error'}, $mj{'confuse'});	}
	&PrintUtilityMain;
}
################################################################
sub Backup{
	&CheckAdminPermission("utils", "backup");
	&BackupHTaccess;
	&BackupMemberDB;
	$CONFIG{message} = $mj{success};
}
################################################################
sub Export{
    my(@fields,@members,$member,$q);
	if($FORM{'step'} eq "final"){
		&CheckAdminPermission("utils", "export");
		$FORM{'fields'} =~ s/\s+//g;
        @fields = split(/\,\s*/, $FORM{'data_fields'});
        @members = &ExportMembers($FORM{account}, $FORM{database},\@fields, $FORM{'separator'});
#        $q=new CGI;
        print "Content-type:text/plain\n\n";
#        print $q->header;
        foreach $member(@members){ print "$member\n";   }
		exit;
	}
	&PrintExport;
}
################################################################
sub Import{
    my($content, $count, $message, $member, %MEM, $size,@fields,@lines,
    $length);
	
	if($FORM{'step'} eq "final"){
		&CheckAdminPermission("utils", "import");
        @lines = split(/\\n/, $FORM{'content'});
		@fields = split(/\,\s*/, $FORM{'data_fields'});
		$FORM{'separator'} = "|" unless $FORM{'separator'};
		$length = $CONFIG{systemtime} + $FORM{length} * 24 * 60 * 60;
		$count=0;
        foreach $line (@lines){
			   if($FORM{'separator'} eq '|'){  @tokens = split(/\|/, $line);		}
			elsif($FORM{'separator'} eq "\,"){ @tokens = split(/\,/, $line);		}
			elsif($FORM{'separator'} eq "\:"){ @tokens = split(/\:/, $line);		}
			elsif($FORM{'separator'} eq '::'){ @tokens = split(/\:\:,/, $line);	}
            elsif($FORM{'separator'} eq "\/"){ @tokens = split(/\//, $line);}
            elsif($FORM{'separator'} eq "\\"){ @tokens = split(/\\/, $line);}
            elsif($FORM{'separator'} eq "\%"){ @tokens = split(/\%/, $line);}
            elsif($FORM{'separator'} eq "\!"){ @tokens = split(/\!/, $line);}
            else{                              @tokens = split(/\|/, $line);}
			undef %MEMBER;
			
            for(my $i=0; $i <@fields; $i++){ $number=$fields[$i];       $MEMBER{$number} = $tokens[$i]; }
			next unless ($MEMBER{username} and $MEMBER{password} and $MEMBER{email});
            $MEMBER{'date_create'} = $CONFIG{systemtime} unless $MEMBER{'date_create'};
			$MEMBER{'date_end'} = $length if $FORM{length};
			$MEMBER{account} = $FORM{account} if $FORM{account};
			%MEM = &isMemberExist($MEMBER{username});
			if($MEM{username}){
				next unless ($FORM{'replace'});
				&UpdateMemberDB(\%MEMBER);	
			}
			else{
				&AddMemberDB(\%MEMBER);
			}
			$count++;
		}
		$message = "$count members have been succesfully imported";
	}
	elsif($FORM{'step'} eq "2"){
		$content = &ReadRemoteFile($FORM{'file'});
		if($content == 0){		$message = qq|Please select a file to import|;				}
		elsif($content == -1){	$message = qq|The selected file is too big to upload|;	}
		else{		
			$content = $$content;
			$size = length($content);
			$message ="This is the content of the file you have selected [$FORM{'file'}]. <br>The file size is $size bytes.";
			&PrintImportConfirm($content, $message);
		}
	}
	&PrintImport($message);
}
################################################################
sub Restore{
	&CheckAdminPermission("utils", "restore");
	if($FORM{database} eq 'htaccess'){	&FileCopy("$CONFIG{password_file}.bak", $CONFIG{password_file}) if (-f "$CONFIG{password_file}.bak");	}
	elsif($FORM{database} eq "active"){	&DirectoryCopy($CONFIG{backup_path}, $CONFIG{member_path}, $CONFIG{member_ext});	}
	elsif($FORM{database} eq "expire"){	&DirectoryCopy($CONFIG{backup_path}, $CONFIG{member_path}, $CONFIG{expire_ext});	}
	elsif($FORM{database} eq "pending"){&DirectoryCopy($CONFIG{backup_path}, $CONFIG{member_path}, $CONFIG{pending_ext});	}
	elsif($FORM{database} eq "suspend"){&DirectoryCopy($CONFIG{backup_path}, $CONFIG{member_path}, $CONFIG{suspend_ext});	}
	elsif($FORM{database} eq "all"){		&DirectoryCopy($CONFIG{backup_path}, $CONFIG{member_path}, [$CONFIG{member_ext},$CONFIG{expire_ext},$CONFIG{pending_ext},$CONFIG{suspend_ext}]);	}
	elsif($FORM{database} eq "admin"){	&FileCopy("$CONFIG{backup_path}/admin_db.db", "$CONFIG{admin_db}");	}
	elsif($FORM{database} eq "group"){	&FileCopy("$CONFIG{backup_path}/groups_db.db", "$CONFIG{group_db}");}
	&PrintRestore($FORM{database}?$mj{success}:"");
}
################################################################
sub Repair{
	my $message;
	&CheckAdminPermission("utils", "repair");
	$message=&RepairTables;
	$CONFIG{message} =$message;
}
################################################################
sub BuilldUtilsDatabase{
	my(@label, %LABEL);
	@label = ("all", "active", "expire", "pending", "suspend");
	push(@label, "allabove") if $FORM{class} eq "backup";
	%LABEL = ("all"    =>"All member profiles",
				 "active" =>"Active member profiles only",
				 "expire" =>"Expired member profiles only",
				 "pending"=>"Pending member profiles only",
				 "suspend"=>"Suspended member profiles only",
				 "htaccess"=>"htaccess password list");
	return $Cgi->popup_menu("database", \@label, $FORM{database}, \%LABEL);
}
################################################################
sub PrintBackup{
	my(%HTML, $message);
	$message = $_[0]?$_[0]:$mj{utils2};
	$HTML{database} = &BuilldUtilsDatabase;
	&PrintMojoHeader;
	print qq|
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="205"> <br>
      <br>
      <form name="mojo" method="post" action="$CONFIG{admin_url}">
        <input type="hidden" name="account" value="$FORM{'account'}">
        <input type="hidden" name="type" value="utils">
        <input type="hidden" name="class" value="backup">
        <input type="hidden" name="step" value="final">
        <table border="0" width="601" cellspacing="1" cellpadding="4" bgcolor="#6394BD" class="bordercolor" align="center">
          <tr> 
            <td class="titlebg" bgcolor="#EBEBEB" height="6"> &nbsp;<font size=2 class="text1" color="#FFFFFF"><b><font color="#0000FF">$mj{utils1}</font></b></font></td>
          </tr>
          <tr> 
            <td class="titlebg" bgcolor="#EEEEEE" height="29"> 
              <div align="center"><b><font color="#FF0000">$message</font></b></div>
            </td>
          </tr>
          <tr> 
            <td class="titlebg" bgcolor="#EEEEEE" height="94" valign="top"> 
              <ul>
                <li>Please select a database<br>
                  &nbsp; &nbsp; $HTML{database}<br>
                  <br>
                  <input type="submit" name="Submit" value="$TXT{submit}">
                  <br>
                </li>
              </ul>
            </td>
          </tr>
          <tr> 
            <td bgcolor="#EBEBEB" height="2">&nbsp;
			
            </td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
</table>

	|;
	&PrintMojoFooter;
}
################################################################
sub PrintExport{
	my(@data_fields, %HTML, $message);
	$message = shift;
	&PrintMojoHeader;
	@data_fields  = &DefineMemberDB;
	$FORM{data_fields} = join(",", @data_fields);
	$HTML{database} = &BuilldUtilsDatabase;
	$HTML{account} = &BuildAccountMenu("all", "All accounts");
#	$FORM{separator} = '|';
	print qq|
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="357"> <br>
      <br>
      <form name="mojo" method="post" action="$CONFIG{admin_url}">
        <input type="hidden" name="type" value="utils">
        <input type="hidden" name="class" value="export">
        <input type="hidden" name="step" value="final">
        <table border="0" width="601" cellspacing="1" cellpadding="4" bgcolor="#6394BD" class="bordercolor" align="center">
          <tr> 
            <td class="titlebg" bgcolor="#EBEBEB" height="6"> &nbsp;<font size=2 class="text1" color="#FFFFFF"><b><font color="#0000FF">$mj{utils6}</font></b></font></td>
          </tr>
          <tr> 
            <td class="titlebg" bgcolor="#EEEEEE" height="14"> 
              <div align="center"><b><font color="#FF0000">$message</font></b></div>
            </td>
          </tr>
          <tr> 
            <td class="titlebg" bgcolor="#EEEEEE" height="7">$mj{utils7}</td>
          </tr>
          <tr> 
            <td class="titlebg" bgcolor="#EEEEEE" height="210"> 
              <table width="713" border="1" cellspacing="0" cellpadding="3" bordercolor="#DDDDDD">
                <tr> 
                  <td width="114" valign="top" height="137"><b>Data Field</b></td>
                  <td width="587" height="137"> 
                    <textarea name="data_fields" cols="50" rows="8">$FORM{data_fields}</textarea>
                    <br>
                    $mj{utils8}</td>
                </tr>
                <tr> 
                  <td width="114" valign="top"><b>Field separator</b></td>
                  <td width="587"> 
                    <select name="separator">
                    <option value=",">Comma ( , )</option>
                    <option value="\|" selected>Pipe ( \| )</option>
                    <option value=":">Semi Colon ( : )</option>
                    <option value="::">Double SemiColons ( :: )</option>
                    <option value="/">Forward Slash ( / )</option>
                    <option value="\\">Backward slash ( \\ )</option>
                    <option value="%">Percent Sign ( % )</option>
                    <option value="!">Exclaimation Point ( ! )</option>
                  </select><br>
                    $mj{utils9}</td>
                </tr>
                <tr> 
                  <td height="20"> <div align="center"><b>Database</b></div></td>
                  <td height="20" valign="top"> $HTML{database}</td>
                </tr>
					 <tr> 
                  <td height="20"> <div align="center"><b>Account</b></div></td>
                  <td height="20" valign="top"> $HTML{account}</td>
                </tr>
              </table>
            </td>
          </tr>
          <tr> 
            <td bgcolor="#EBEBEB" height="2"> 
              <div align="center"> 
                <input type="submit" name="Submit" value="$TXT{submit}">
                <input type="reset" name="reset" value="$TXT{reset}">
              </div>
            </td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
</table>
	|;
	&PrintMojoFooter;
}
################################################################
sub PrintImport{
	my(@data_fields, $message);
	$message = shift;
	&PrintMojoHeader;
	@data_fields = &DefineMemberDB;
	$FORM{data_fields} = join(",", @data_fields);
	$HTML{account} = &BuildAccountMenu("0", "Keep old account");
	print qq|
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="525"> <br>
      <br>
      <form name="mojo" method="post" action="$CONFIG{admin_url}"  enctype="multipart/form-data" target="_blank">
        <input type="hidden" name="type" value="utils">
        <input type="hidden" name="step" value="2">
        <input type="hidden" name="class" value="import">
        <table border="0" width="601" cellspacing="1" cellpadding="4" bgcolor="#6394BD" class="bordercolor" align="center">
          <tr> 
            <td class="titlebg" bgcolor="#EBEBEB" height="6"> &nbsp;<font size=2 class="text1" color="#FFFFFF"><b><font color="#0000FF">$mj{utils11}</font></b></font></td>
          </tr>
          <tr> 
            <td class="titlebg" bgcolor="#EEEEEE" height="29"> 
              <div align="center"><b><font color="#FF0000">$message</font></b></div>
            </td>
          </tr>
          <tr> 
            <td class="titlebg" bgcolor="#EEEEEE" height="330" valign="top"> 
              <table width="600" border="1" cellspacing="0" cellpadding="2" align="center" bordercolor="#DDDDDD">
                <tr> 
                  <td width="103" valign="top" height="22"><b>Select a File</b></td>
                  <td width="489" height="22"> 
                    <input type="file" name="file" size="60">
                  </td>
                </tr>
                <tr> 
                  <td width="103" valign="top" height="11"><b>Database</b></td>
                  <td width="489" height="11"> 
                    <textarea name="data_fields" cols="50" rows="8">$FORM{data_fields}</textarea>
                    <br>
                    $mj{utils12}</td>
                </tr>
                <tr> 
                  <td width="103" valign="top" height="27"><b>Separator</b></td>
                  <td width="489" height="27"> 
                    <select name="separator">
                      <option value=",">Comma ( , )</option>
                      <option value="\|" selected>Pipe ( \| )</option>
                      <option value=":">Semi Colon ( : )</option>
                      <option value="::">Double SemiColons ( :: )</option>
                      <option value="/">Forward Slash ( / )</option>
                      <option value="\\">Backward slash ( \\ )</option>
                      <option value="%">Percent Sign ( % )</option>
                      <option value="!">Exclaimation Point ( ! )</option>
                    </select>
                    <br>
                    $mj{utils13}</td>
                </tr>
                <tr> 
                  <td width="103" valign="top" height="4"><b>Length</b></td>
                  <td width="489" height="4"> 
                    <input type="text" name="length" size="20" maxlength="10" value="$FORM{'length'}">
                    <br>
                    $mj{utils14}</td>
                </tr>
                <tr>
                  <td width="103" valign="top" height="5"><b>Account</b></td>
                  <td width="489" height="5">$HTML{account}</td>
                </tr>
                <tr> 
                  <td colspan="2" height="2"> 
                    <p align="center"> 
                      <input type="submit" name="replace" value="$TXT{submit}">
                    </p>
                  </td>
                </tr>
              </table>
              
            </td>
          </tr>
          <tr> 
            <td bgcolor="#EBEBEB" height="2">&nbsp;
			
            </td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
</table>
	|;
	&PrintMojoFooter;
}
################################################################
sub PrintImportConfirm{
	my($content, $message) = @_;
	$FORM{content} = $FORM{display} = $content;
    $FORM{display} =~ s/\n/<br>/g;
    $FORM{content} =~ s/\n/\\n/g;
	&PrintHeader;
	print qq|

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="234"> <br>
      <br>
      <form name="mojo" method="post" action="$CONFIG{admin_url}">
        <input type="hidden" name="account" value="$FORM{'account'}">
        <input type="hidden" name="type" value="utils">
        <input type="hidden" name="class" value="import">
        <input type="hidden" name="step" value="final">
        <input type="hidden" name="data_fields" value="$FORM{'data_fields'}">
        <input type="hidden" name="separator" value="$FORM{'separator'}">
        <input type="hidden" name="length" value="$FORM{'length'}">
        <input type="hidden" name="content" value="$FORM{content}">
        <table border="0" width="100%" cellspacing="1" cellpadding="4" bgcolor="#6394BD" class="bordercolor" align="center">
          <tr> 
            <td class="titlebg" bgcolor="#EBEBEB" height="6"> &nbsp;<font size=2 class="text1" color="#FFFFFF"><b><font color="#0000FF">$mj{utils11}</font></b></font></td>
          </tr>
          <tr> 
            <td class="titlebg" bgcolor="#EEEEEE" height="14"> 
              <div align="left"><b><font color="#FF0000">$message</font></b></div>
            </td>
          </tr>
          <tr> 
            <td class="titlebg" bgcolor="#EEEEEE" height="14"><NOBR>$FORM{display}<NOBR></td>
          </tr>
          <tr> 
            <td bgcolor="#EBEBEB" height="2"> 
              <div align="left"> 
                <input type="submit" name="replace" value="Import And Replace">
                <input type="submit" name="noreplace" value="Import But Don't Replace">
              </div>
            </td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
</table>

	|;
	exit;
}
################################################################
sub PrintRepair{
	my(%HTML, $message);
	$message = $_[0]?$_[0]:$mj{utils17};
	my %LABEL = (ads=>"Ads database", member=>"Member database", htaccess=>"HTAccess password list");
	$HTML{database} = $Cgi->popup_menu("database",[htaccess, member], $FORM{database}, \%LABEL);
	&PrintMojoHeader;
	print qq|
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="205"> <br>
      <br>
      <form name="mojo" method="post" action="$CONFIG{admin_url}">
        <input type="hidden" name="account" value="$FORM{'account'}">
        <input type="hidden" name="type" value="utils">
        <input type="hidden" name="step" value="final">
        <input type="hidden" name="class" value="repair">
        <table border="0" width="601" cellspacing="1" cellpadding="4" bgcolor="#6394BD" class="bordercolor" align="center">
          <tr> 
            <td class="titlebg" bgcolor="#EBEBEB" height="6"> &nbsp;<font size=2 class="text1" color="#FFFFFF"><b><font color="#0000FF">$mj{utils16}</font></b></font></td>
          </tr>
          <tr> 
            <td class="titlebg" bgcolor="#EEEEEE" height="29"> 
              <div align="center"><b><font color="#FF0000">$message</font></b></div>
            </td>
          </tr>
          <tr> 
            <td class="titlebg" bgcolor="#EEEEEE" height="94" valign="top"> 
              <ul>
                <li>Please select a database<br>
                  &nbsp; &nbsp; $HTML{database}<br>
                  <br>
                  <input type="submit" name="Submit" value="$TXT{submit}">
                  <br>
                </li>
              </ul>
            </td>
          </tr>
          <tr> 
            <td bgcolor="#EBEBEB" height="2">&nbsp;
			
            </td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
</table>

	|;
	&PrintMojoFooter;
}
################################################################
sub PrintRestore{
	my(%HTML, $message);
	$message = $_[0]?$_[0]:$mj{utils22};
	$HTML{database} = &BuilldUtilsDatabase;
	&PrintMojoHeader;
	print qq|
	
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="205"> <br>
      <br>
      <form name="mojo" method="post" action="$CONFIG{admin_url}">
        <input type="hidden" name="account" value="$FORM{'account'}">
        <input type="hidden" name="type" value="utils">
        <input type="hidden" name="step" value="final">
        <input type="hidden" name="class" value="restore">
        <table border="0" width="601" cellspacing="1" cellpadding="4" bgcolor="#6394BD" class="bordercolor" align="center">
          <tr> 
            <td class="titlebg" bgcolor="#EBEBEB" height="6"> &nbsp;<font size=2 class="text1" color="#FFFFFF"><b><font color="#0000FF">$mj{utils21}</font></b></font></td>
          </tr>
          <tr> 
            <td class="titlebg" bgcolor="#EEEEEE" height="29"> 
              <div align="center"><b><font color="#FF0000">$message</font></b></div>
            </td>
          </tr>
          <tr> 
            <td class="titlebg" bgcolor="#EEEEEE" height="94" valign="top"> 
              <ul>
                <li>Please select a database<br>
                  &nbsp; &nbsp; $HTML{database}<br>
                  <br>
                  <input type="submit" name="Submit" value="$TXT{submit}">
                  <br>
                </li>
              </ul>
            </td>
          </tr>
          <tr> 
            <td bgcolor="#EBEBEB" height="2">&nbsp;
			
            </td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
</table>

	|;
	&PrintMojoFooter;
}

################################################################
sub PrintUtilityMain{
	&PrintMojoHeader;
	my $message = $CONFIG{message};
	print qq|
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="345"> <br>
      <br>
      <form name="mojo" method="post" action="$CONFIG{admin_url}">
        <input type="hidden" name="account" value="$FORM{'account'}">
        <input type="hidden" name="type" value="utils">
        <input type="hidden" name="step" value="final">
        <table border="0" width="601" cellspacing="1" cellpadding="4" bgcolor="#6394BD" class="bordercolor" align="center">
          <tr> 
            <td class="titlebg" bgcolor="#EBEBEB" height="6"> &nbsp;<font size=2 class="text1" color="#FFFFFF"><b><font color="#0000FF">$mj{utils}</font></b></font></td>
          </tr>
          <tr> 
            <td class="titlebg" bgcolor="#EEEEEE" height="29"> 
              <div align="center"><b><font color="#FF0000">$message</font></b></div>
            </td>
          </tr>
          <tr> 
            <td class="titlebg" bgcolor="#EEEEEE" height="212" valign="top">
<font size="5"><font face="Tahoma" size="2">We provide 
                  a great deals of utilities for you to work and maintain your 
                  copy of </font><font size="5"><font face="Tahoma" size="2">$mj{'program'} 
                  $mj{'version'}. If you ever need more utilities to work with, 
                  just contact us.</font></font></font>
<ol>
                <li><a href="$CONFIG{admin_url}?type=utils&class=export">Export</a></li>
                <li><a href="$CONFIG{admin_url}?type=utils&class=import">Import</a></li>
			    <li><a href="$CONFIG{admin_url}?type=utils&class=repair">Repair</a></li>
              </ol>
            </td>
          </tr>
          <tr> 
            <td bgcolor="#EBEBEB" height="2">&nbsp;
			
            </td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
</table>
	|;
	&PrintMojoFooter;
}
################################################################

1;
