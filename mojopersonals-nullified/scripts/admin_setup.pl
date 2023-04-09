###############################################################
sub SetupMain{
	&LoadConfigFile;
	if($FORM{'class'} eq "config"){				&Configuration; 			}
	elsif($FORM{'class'} eq "behavior"){		&Behavior;					}
	elsif($FORM{'class'} eq "display"){			&DisplaySetup;				}
	elsif($FORM{'class'}){	&PrintError($mj{error}, $mj{confuse});}
	&Configuration;
}
###############################################################
sub Configuration{
	my($message);
	
	if($FORM{cancel}){	$message = $mj{cancel};	}
	elsif($FORM{'step'} eq "final"){
		&CheckAdminPermission("config");
		
		$message = &CheckConfiguration;
		$message .= "<li>$mj{setup48}</li>" unless (-e "$CONFIG{admin_db}");
		$message .= "<li>$mj{setup49}</li>" unless (-e "$CONFIG{group_db}");
		&PrintConfiguration($message) if $message;	
		%MOJOSCRIPTS = %FORM;
		&WriteConfig;
		$message = $mj{success};
	}
	&PrintConfiguration($message);
}
###############################################################
sub Behavior{
	my($message);
	
	if($FORM{'cancel'}){		$message = $mj{'cancel'};	}
	elsif($FORM{'step'} eq "final"){
		&CheckAdminPermission("behavior");
		
		$message = &CheckBehaviorInput;
		&PrintBehavior($message) if $message;
		foreach $key (keys %FORM){			$CONFIG{$key} = $FORM{$key};		}
		&WriteConfig;
		$message = $mj{success};
	}
	&PrintBehavior($message);
}
############################################################
sub DisplaySetup{
	my($message);
	
	if($FORM{cancel}){	$message = $mj{cancel};	}
	elsif($FORM{'step'} eq "final"){
		&CheckAdminPermission("behavior");
		
		%TABLE = %FORM;
		&WriteConfig;
		$message = $mj{success};
	}
	&PrintDisplaySetup($message);
}
############################################################
sub CheckBehaviorInput{
	my($message);
	$message .= qq|<li>$mj{mem21}: $FORM{ad_notify}</li>| if ($FORM{ad_notify} and not &GoodEmail($FORM{ad_notify}));
	$message .= qq|<li>$mj{mem21}: $FORM{member_notify}</li>| if($FORM{member_notify} and not &GoodEmail($FORM{member_notify}));
	return $message;
}
############################################################
sub LoadConfigFile{ %MOJOSCRIPTS = %CONFIG;	}
############################################################
sub PrintBehavior{
	my($message, @label, %LABEL, %LABEL2, @label2, %HTML);
	($message) = @_ if $_[0];
	@label  = (1,0);
	%LABEL =(1=>"Yes", 0=>"No");
	%LABEL2 =(0=>"Yes", 1=>"No");
	@label2 = ('instant', 'sendmail','pending');
	$HTML{flock}=      $Cgi->popup_menu("flock", \@label, $CONFIG{flock}, \%LABEL);
	$HTML{rename}=     $Cgi->popup_menu("rename", \@label, $CONFIG{rename}, \%LABEL);
	$HTML{ad_type}=    $Cgi->popup_menu("ad_type", ['instant', 'pending'], $CONFIG{ad_type});
	$HTML{member_type}=$Cgi->popup_menu("member_type", \@label2, $CONFIG{member_type});
	$HTML{duplicate_email}=$Cgi->popup_menu("duplicate_email", \@label, $CONFIG{duplicate_email}, \%LABEL);
	$HTML{thumbnailer}=$Cgi->popup_menu("thumbnailer", [none, GD, "Image Magick"], $CONFIG{thumbnailer});
	$HTML{show_empty_subs}=$Cgi->popup_menu("show_empty_subs", \@label, $CONFIG{show_empty_subs}, \%LABEL);
	$HTML{paysite}=    $Cgi->popup_menu("paysite", \@label, $CONFIG{paysite}, \%LABEL);
	&PrintMojoHeader;
	print qq|
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
      <form name="mojo" method="post" action="$CONFIG{admin_url}">
        <div align="center">
          <input type="hidden" name="type" value="config">
          <input type="hidden" name="class" value="behavior">
          <input type="hidden" name="step" value="final">
          <b></b> 
          <table width="600" border="1" cellspacing="0" cellpadding="1" bordercolor="#CCCCCC">
            <tr> 
              <td colspan="2"><br>
                <b><font face="Tahoma">$mj{cfg}</font></b><br>
              </td>
            </tr>
            <tr> 
              <td colspan="2"> 
                <div align="center"><b><font color="#FF0000">$message </font></b></div>
              </td>
            </tr>
            <tr> 
              <td bgcolor="#EEEEEE">$mj{cfg1}</td>
              <td width="200" bgcolor="#EEEEEE">$HTML{flock}</td>
            </tr>
            <tr> 
              <td bgcolor="#EEEEEE">$mj{cfg2}</td>
              <td width="200" bgcolor="#EEEEEE">$HTML{rename}</td>
            </tr>
				  <tr> 
              <td bgcolor="#EFEFEF" height="5">$mj{cfg3a}</td>
              <td width="200" bgcolor="#EFEFEF" height="5"> 
                <input type="text" size="25" name="mpp" value="$CONFIG{mpp}" maxlength="3">
              </td>
            </tr>
            <tr> 
              <td bgcolor="#EFEFEF" height="5">$mj{cfg3}</td>
              <td width="200" bgcolor="#EFEFEF" height="5"> 
                <input type="text" size="25" name="lpp" value="$CONFIG{lpp}" maxlength="3">
              </td>
            </tr>
            <tr> 
              <td height="1" bgcolor="#EFEFEF">$mj{cfg4}</td>
              <td width="200" height="1" bgcolor="#EFEFEF"> 
                <input type="text" size="25" name="daysnew" value="$CONFIG{daysnew}" maxlength="10">
              </td>
            </tr>
            <tr> 
              <td bgcolor="#EFEFEF" height="5">&nbsp;</td>
              <td width="200" bgcolor="#EFEFEF" height="5">&nbsp;</td>
            </tr>
            <tr> 
              <td>$mj{cfg6}</td>
              <td width="200"> 
                <input type="text" size="25" name="ad_length" value="$CONFIG{ad_length}" maxlength="5">
              </td>
            </tr>
            <tr> 
              <td>$mj{cfg7}</td>
              <td width="200">$HTML{ad_type}</td>
            </tr>
<!--            <tr> 
              <td>$mj{cfg8}</td>
              <td width="200"> 
                <input type="text" size="25" name="ad_allowed" value="$CONFIG{ad_allowed}" maxlength="5">
              </td>
            </tr> -->
            <tr> 
              <td>$mj{cfg9}</td>
              <td width="200"> 
                <input type="text" size="30" name="ad_notify" value="$CONFIG{ad_notify}">
              </td>
            </tr>
            <tr> 
              <td>&nbsp;</td>
              <td width="200">&nbsp;</td>
            </tr>
            <tr> 
              <td bgcolor="#EEEEEE">$mj{cfg11}</td>
              <td width="200" bgcolor="#EEEEEE"> 
                <input type="text" size="25" name="media_size" value="$CONFIG{media_size}" maxlength="10">
              </td>
            </tr>
<!--            <tr> 
              <td bgcolor="#EEEEEE">$mj{cfg12}</td>
              <td width="200" bgcolor="#EEEEEE"> 
                <input type="text" size="25" name="media_allowed" value="$CONFIG{media_allowed}" maxlength="5">
              </td>
            </tr>  -->
            <tr> 
              <td bgcolor="#EEEEEE">$mj{cfg13}</td>
              <td width="200" bgcolor="#EEEEEE"> 
                <input type="text" size="30" name="media_ext" value="$CONFIG{media_ext}">
              </td>
            </tr>
            <tr> 
              <td bgcolor="#EEEEEE">$mj{cfg14}</td>
              <td width="200" bgcolor="#EEEEEE"> 
                <input type="text" size="25" name="media_width" value="$CONFIG{media_width}" maxlength="5">
              </td>
            </tr>
            <tr> 
              <td bgcolor="#EEEEEE">$mj{cfg15}</td>
              <td width="200" bgcolor="#EEEEEE"> 
                <input type="text" size="25" name="media_height" value="$CONFIG{media_height}" maxlength="5">
              </td>
            </tr>
            <tr> 
              <td bgcolor="#EEEEEE">&nbsp;</td>
              <td width="200" bgcolor="#EEEEEE">&nbsp;</td>
            </tr>
            <tr> 
              <td>$mj{cfg16}</td>
              <td width="200">$HTML{member_type}</td>
            </tr>
            <tr> 
              <td>$mj{cfg17}</td>
              <td width="200"> 
                <input type="text" size="30" name="member_notify" value="$CONFIG{member_notify}">
              </td>
            </tr>
            <tr> 
              <td>$mj{cfg18}</td>
              <td width="200"> 
                <input type="text" size="25" name="member_length" value="$CONFIG{member_length}" maxlength="10">
              </td>
            </tr>
			<tr>
			  <td>$mj{cfg25}</td>
			  <td width="200"> 
                <input type="text" size="25" name="advanced_expire_email" value="$CONFIG{advanced_expire_email}" maxlength="10">
              </td>
			</tr>
			<tr> 
              <td>$mj{cfg19}</td>
              <td width="200"> $HTML{duplicate_email}</td>
            </tr>
<!--            <tr> 
              <td>$mj{cfg20}</td>
              <td width="200"> 
                <input type="text" size="25" name="mailbox_size" value="$CONFIG{mailbox_size}" maxlength="3">
              </td>
            </tr> -->
            <tr> 
              <td>$mj{cfg20a}</td>
              <td width="200">
                <input type="text" size="5" name="username_length" value="$CONFIG{username_length}" maxlength="3">
              </td>
            </tr>
            <tr> 
              <td>$mj{cfg20b}</td>
              <td width="200">
                <input type="text" size="5" name="password_length" value="$CONFIG{password_length}" maxlength="3">
              </td>
            </tr>
            <tr> 
              <td>&nbsp;</td>
              <td width="200">&nbsp;</td>
            </tr>
            <tr> 
              <td height="0" bgcolor="#EEEEEE">$mj{cfg21}</td>
              <td width="200" height="0" bgcolor="#EEEEEE"> 
                <input type="text" size="25" name="max_wordlength" value="$CONFIG{max_wordlength}" maxlength="10">
              </td>
            </tr>
            <tr> 
              <td bgcolor="#EEEEEE">$mj{cfg22}</td>
              <td width="200" bgcolor="#EEEEEE"> 
                <input type="text" size="25" name="max_description" value="$CONFIG{max_description}" maxlength="10">
              </td>
            </tr>
            <tr> 
              <td height="1" bgcolor="#EEEEEE">$mj{cfg23}</td>
              <td width="200" height="1" bgcolor="#EEEEEE"> 
                <input type="text" size="25" name="min_description" value="$CONFIG{min_description}" maxlength="10">
              </td>
            </tr>
            <tr> 
              <td bgcolor="#EEEEEE">$mj{cfg24}</td>
              <td width="200" bgcolor="#EEEEEE"> 
                <input type="text" size="25" name="short_description" value="$CONFIG{short_description}" maxlength="3">
              </td>
            </tr>
            <tr> 
              <td height="1">&nbsp;</td>
              <td width="200" height="1">&nbsp;</td>
            </tr>
            <tr> 
              <td height="0" bgcolor="#EEEEEE">$mj{cfg26}</td>
              <td width="200" height="0" bgcolor="#EEEEEE"> $HTML{thumbnailer}</td>
            </tr>
            <tr> 
              <td height="0" bgcolor="#EEEEEE">$mj{cfg27}</td>
              <td width="200" height="1" bgcolor="#EEEEEE">$HTML{show_empty_subs}</td>
            </tr>
            <tr> 
              <td height="1" bgcolor="#EEEEEE">$mj{cfg28}</td>
              <td width="200" height="1" bgcolor="#EEEEEE">$HTML{paysite}</td>
            </tr>
            <tr> 
              <td colspan="2"> 
                <div align="center"> 
                  <input type="submit" name="Submit" value="Submit">
                  <input type="reset" name="reset" value="Reset">
                </div>
              </td>
            </tr>
          </table>
        </div>
      </form>
    </td>
  </tr>
</table>
|;
	&PrintMojoFooter;
	exit;
}
############################################################
sub PrintConfiguration{
	my ($message) = @_;
	foreach (keys %CONFIG){	$FORM{$_} = $CONFIG{$_} unless $FORM{$_};	}
	&PrintMojoHeader;
	&ConfigTemplate($CONFIG{admin_url}, $message);
	&PrintMojoFooter;
}
############################################################
sub PrintDisplaySetup{
	my($cat_width,$cat_border,$cat_cellspacing,$cat_cellpadding,$cat_bgcolor,
		$cat_bordercolor,$cat_columns,$menu_width,$menu_border,$menu_cellspacing,
		$menu_cellpadding,$menu_bgcolor,$menu_bordercolor,
		$message, @label1, %LABEL1);
		@label1 = ("0", "1");
		%LABEL1 = ("0"=>"One Row Style", "1"=>"Two Row Style");
	($message) = @_;
$cat_width 			= textfield("cat_width", $TABLE{cat_width}, 15, 10);
$cat_border			= textfield("cat_border", $TABLE{cat_border}, 15, 10);
$cat_cellspacing  = textfield("cat_cellspacing", $TABLE{cat_cellspacing}, 15, 10);
$cat_cellpadding  = textfield("cat_cellpadding", $TABLE{cat_cellpadding}, 15, 10);
$cat_bgcolor      = textfield("cat_bgcolor", $TABLE{cat_bgcolor}, 15, 10);
$cat_bordercolor  = textfield("cat_bordercolor", $TABLE{cat_bordercolor}, 15, 10);
$cat_columns      = popup_menu("cat_cols", \@label1, $TABLE{cat_cols}, \%LABEL1);

$menu_width       = textfield("menu_width", $TABLE{menu_width}, 15, 10);
$menu_border      = textfield("menu_border", $TABLE{menu_border}, 15, 10);
$menu_cellspacing = textfield("menu_cellspacing", $TABLE{menu_cellspacing}, 15, 10);
$menu_cellpadding = textfield("menu_cellpadding", $TABLE{menu_cellpadding}, 15, 10);
$menu_bgcolor     = textfield("menu_bgcolor", $TABLE{menu_bgcolor}, 15, 10);
$menu_bordercolor = textfield("menu_bordercolor", $TABLE{menu_bordercolor}, 15, 10);

&PrintMojoHeader;
print qq|
<form name="mojo" method="post" action="$CONFIG{admin_url}">
  <input type="hidden" name="type" value="config">
  <input type="hidden" name="class" value="display">
  <input type="hidden" name="step" value="final">
  <table width="567" border="1" cellspacing="0" cellpadding="0" align="center" bordercolor="#99CCFF">
    <tr> 
      <td colspan="2" height="3"> 
        <div align="center"><font size="4"><b>Display Options</b></font><br>
        </div>
      </td>
    </tr>
    <tr> 
      <td colspan="2"><b><font size="4">Category table</font></b></td>
    </tr>
    <tr> 
      <td width="369"><b>Table width</b></td>
      <td width="184">$cat_width</td>
    </tr>
    <tr> 
      <td width="369"><b>Table border</b></td>
      <td width="184">$cat_border</td>
    </tr>
    <tr> 
      <td width="369"><b>Table cellspacing</b></td>
      <td width="184">$cat_cellspacing</td>
    </tr>
    <tr> 
      <td width="369"><b>Table cellpadding</b></td>
      <td width="184">$cat_cellpadding</td>
    </tr>
    <tr> 
      <td width="369"><b>Table background color</b></td>
      <td width="184">$cat_bgcolor</td>
    </tr>
    <tr> 
      <td width="369"><b>Table border color</b></td>
      <td width="184">$cat_bordercolor</td>
    </tr>
    <tr> 
      <td width="369"><b>Align the categories in a two rows style or 1 row style</b></td>
      <td width="184">$cat_columns</td>
    </tr>
    <tr> 
      <td colspan="2"> 
        <p>&nbsp;</p>
        <p><b><font size="4">User menu table</font></b></p>
      </td>
    </tr>
    <tr> 
      <td width="369"><b>Table width</b></td>
      <td width="184">$menu_width</td>
    </tr>
    <tr> 
      <td width="369"><b>Table border</b></td>
      <td width="184">$menu_border</td>
    </tr>
    <tr> 
      <td width="369"><b>Table cellspacing</b></td>
      <td width="184">$menu_cellspacing</td>
    </tr>
    <tr> 
      <td width="369"><b>Table cellpadding</b></td>
      <td width="184">$menu_cellpadding</td>
    </tr>
    <tr> 
      <td width="369"><b>Table background color</b></td>
      <td width="184">$menu_bgcolor</td>
    </tr>
    <tr> 
      <td width="369"><b>Table border color</b></td>
      <td width="184">$menu_bordercolor</td>
    </tr>
  </table>
  <div align="center"><br>
    <input type="submit" name="Submit" value="$TXT{save}">
    <input type="submit" name="cancel" value="$TXT{cancel}">
  </div>
</form>


	|;
	&PrintMojoFooter;
}
###################################################################
sub WriteConfig{
	my($filename);
	if($ENV{PATH_TRANSLATED}){
		($filename=$ENV{PATH_TRANSLATED}) =~ s/\\/\//g;
		$filename = &ParentDirectory($filename);
		$filename .=  "/config.pl";
	}
	else{
		$filename=$ENV{SCRIPT_FILENAME};
		$filename = &ParentDirectory($filename);
		$filename .=  "/config.pl";
	}
	$CONFIG{script_ext} = ($MOJOSCRIPTS{script_ext})?$MOJOSCRIPTS{script_ext}:"cgi";
	
	open(FILE, ">$filename") or &PrintFatal("$mj{file3}: \"$filename\"", (caller)[1], (caller)[2]);
#	flock(FILE,2);
	print FILE qq~
\$CONFIG{site_title}=    qq|$MOJOSCRIPTS{site_title}|;
\$CONFIG{document_root}= qq|$MOJOSCRIPTS{document_root}|;
\$CONFIG{backup_path}=   qq|$MOJOSCRIPTS{backup_path}|;
#\$CONFIG{data_path}=     qq|$MOJOSCRIPTS{data_path}|;
\$CONFIG{email_path}=    qq|$MOJOSCRIPTS{email_path}|;
\$CONFIG{image_path}=    qq|$MOJOSCRIPTS{image_path}|;
\$CONFIG{image_url}=     qq|$MOJOSCRIPTS{image_url}|;
\$CONFIG{log_path}=      qq|$MOJOSCRIPTS{log_path}|;
#\$CONFIG{member_path}=   qq|$MOJOSCRIPTS{member_path}|;
#\$CONFIG{mail_path}=     qq|$MOJOSCRIPTS{mail_path}|;
\$CONFIG{photo_path}=    qq|$MOJOSCRIPTS{photo_path}|;
\$CONFIG{photo_url}=     qq|$MOJOSCRIPTS{photo_url}|;
\$CONFIG{program_files_path}=qq|$MOJOSCRIPTS{program_files_path}|;
\$CONFIG{script_path}=   qq|$MOJOSCRIPTS{script_path}|;
\$CONFIG{script_url}=    qq|$MOJOSCRIPTS{script_url}|;
\$CONFIG{session_path}=  qq|$MOJOSCRIPTS{session_path}|;
\$CONFIG{template_path}= qq|$MOJOSCRIPTS{template_path}|;
\$CONFIG{var_path}=      qq|$MOJOSCRIPTS{var_path}|;
\$CONFIG{mysql_hostname}=qq|$CONFIG{mysql_hostname}|;
\$CONFIG{mysql_database}=qq|$CONFIG{mysql_database}|;
\$CONFIG{mysql_username}=qq|$CONFIG{mysql_username}|;
\$CONFIG{mysql_password}=qq|$CONFIG{mysql_password}|;
\$CONFIG{myname}=        qq|$MOJOSCRIPTS{myname}|;
\$CONFIG{myemail}=       q|$MOJOSCRIPTS{myemail}|;
\$CONFIG{sendmail}=      qq|$MOJOSCRIPTS{sendmail}|;
\$CONFIG{smtp_server}=   qq|$MOJOSCRIPTS{smtp_server}|;
\$CONFIG{system}=        qq|$MOJOSCRIPTS{system}|;
\$CONFIG{language_lib}=  qq|$MOJOSCRIPTS{language_lib}|;
\$CONFIG{script_ext}=    qq|$MOJOSCRIPTS{script_ext}|;
\$CONFIG{use_GD}=        qq|$MOJOSCRIPTS{use_GD}|;

######### Configurations ##########
\$CONFIG{flock}=          qq|$CONFIG{flock}|;
\$CONFIG{rename}=         qq|$CONFIG{rename}|;
\$CONFIG{lpp}=            qq|$CONFIG{lpp}|;
\$CONFIG{mpp}=            qq|$CONFIG{mpp}|;
\$CONFIG{daysnew}=        qq|$CONFIG{daysnew}|;

\$CONFIG{ad_length}=      qq|$CONFIG{ad_length}|; 
\$CONFIG{ad_type}=        qq|$CONFIG{ad_type}|; 
#\$CONFIG{ad_allowed}=     qq|$CONFIG{ad_allowed}|;
\$CONFIG{ad_notify}=       q|$CONFIG{ad_notify}|;

\$CONFIG{media_size}=     qq|$CONFIG{media_size}|;
#\$CONFIG{media_allowed}=  qq|$CONFIG{media_allowed}|;
\$CONFIG{media_ext}=      qq|$CONFIG{media_ext}|;
\$CONFIG{media_width}=    qq|$CONFIG{media_width}|;
\$CONFIG{media_height}=   qq|$CONFIG{media_height}|;

\$CONFIG{member_type}=    qq|$CONFIG{member_type}|;
\$CONFIG{member_notify}=   q|$CONFIG{member_notify}|;
\$CONFIG{member_length}=  qq|$CONFIG{member_length}|;
\$CONFIG{advanced_expire_email}=qq|$CONFIG{advanced_expire_email}|;
\$CONFIG{duplicate_email}=qq|$CONFIG{duplicate_email}|;
#\$CONFIG{mailbox_size}=   qq|$CONFIG{mailbox_size}|;
\$CONFIG{username_length}=qq|$CONFIG{username_length}|;
\$CONFIG{password_length}=qq|$CONFIG{password_length}|;

\$CONFIG{max_wordlength}= qq|$CONFIG{max_wordlength}|;
\$CONFIG{max_description}=qq|$CONFIG{max_description}|;
\$CONFIG{min_description}=qq|$CONFIG{min_description}|;
\$CONFIG{short_description}=qq|$CONFIG{short_description}|;

\$CONFIG{thumbnailer}=    qq|$CONFIG{thumbnailer}|;
\$CONFIG{show_empty_subs}=qq|$CONFIG{show_empty_subs}|;
\$CONFIG{paysite}=        qq|$CONFIG{paysite}|;

\$CONFIG{catlayout}=      qq|$CONFIG{catlayout}|;

\$CONFIG{check_wholename}=qq|$CONFIG{check_wholename}|;
\$CONFIG{check_case}=     qq|$CONFIG{check_case}|;

\$CONFIG{default_account}=qq|$CONFIG{default_account}|;
\$CONFIG{payment_notify}= q|$CONFIG{payment_notify}|;
################ TABLE DEFINITION  ########################
\$TABLE{media_width}=      qq|$TABLE{media_width}|;
\$TABLE{media_border}=     qq|$TABLE{media_border}|;
\$TABLE{media_cellspacing}=qq|$TABLE{media_cellspacing}|;
\$TABLE{media_cellpadding}=qq|$TABLE{media_cellpadding}|;
\$TABLE{media_bgcolor}=    qq|$TABLE{media_bgcolor}|;
\$TABLE{media_bordercolor}=qq|$TABLE{media_bordercolor}|;
\$TABLE{media_rows}=       qq|$TABLE{media_rows}|; 
\$TABLE{media_cols}=       qq|$TABLE{media_cols}|;

\$TABLE{cat_width}=        qq|$TABLE{cat_width}|;
\$TABLE{cat_border}=       qq|$TABLE{cat_border}|;
\$TABLE{cat_cellspacing}=  qq|$TABLE{cat_cellspacing}|;
\$TABLE{cat_cellpadding}=  qq|$TABLE{cat_cellpadding}|;
\$TABLE{cat_bgcolor}=      qq|$TABLE{cat_bgcolor}|;
\$TABLE{cat_bordercolor}=  qq|$TABLE{cat_bordercolor}|;
\$TABLE{cat_rows}=         qq|$TABLE{cat_rows}|; 
\$TABLE{cat_cols}=         qq|$TABLE{cat_cols}|;

\$TABLE{menu_width}=       qq|$TABLE{menu_width}|;
\$TABLE{menu_border}=      qq|$TABLE{menu_border}|;
\$TABLE{menu_cellspacing}= qq|$TABLE{menu_cellspacing}|;
\$TABLE{menu_cellpadding}= qq|$TABLE{menu_cellpadding}|;
\$TABLE{menu_bgcolor}=     qq|$TABLE{menu_bgcolor}|;
\$TABLE{menu_bordercolor}= qq|$TABLE{menu_bordercolor}|;
\$TABLE{menu_rows}=        qq|$TABLE{menu_rows}|; 
\$TABLE{menu_cols}=        qq|$TABLE{menu_cols}|;
########################################################
1;

~;

#    flock(FILE,8);
	close(FILE);
	chmod(0777, $config_filename);
	return 1;
}
############################################################
1;
