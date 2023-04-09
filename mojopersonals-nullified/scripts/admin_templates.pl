############################################################
sub TemplateMain{
	   if($FORM{class} eq "email"){				&TemplateEmail;		}
	elsif($FORM{class} eq "html"){				&TemplateHTML;			}
	elsif($FORM{class} eq "subject"){			&TemplateSubjects;	}
#	elsif($FORM{class}){ 			&PrintAdminError($mj{'error'}, $mj{'confuse'});		}
	&PrintTemplate;
}
############################################################
sub TemplateEmail{
	my($message);
	&CheckAdminPermission("template_email") if ($FORM{action} =~ /edit|save/);
	if($FORM{cancel}){			$message = $mj{cancel};	}
	elsif($FORM{edit}){	&PrintTemplateEdit("$CONFIG{email_path}/$FORM{filename}");	}
	elsif($FORM{action} eq "save"){	&FileWrite("$CONFIG{email_path}/$FORM{filename}", $FORM{content});}
	&PrintTemplate($message?$message:$mj{success});
}
############################################################
sub TemplateHTML{
	my($message);
	&CheckAdminPermission("template_html") if ($FORM{action} =~ /edit|save/);
	if($FORM{cancel}){			$message = $mj{cancel};	}
	elsif($FORM{edit}){	&PrintTemplateEdit("$CONFIG{template_path}/$FORM{filename}");	}
	elsif($FORM{action} eq "save"){	&FileWrite("$CONFIG{template_path}/$FORM{filename}", $FORM{content});}
	&PrintTemplate($message?$message:$mj{success});
}
############################################################
sub TemplateSubjects{
	my(@content, $message);
	&CheckAdminPermission("template_email") if ($FORM{action} =~ /edit|save/);;
	if($FORM{cancel}){			$message = $mj{cancel};	}
	elsif($FORM{edit}){			&PrintTemplateSubjects;	}
	elsif($FORM{action} eq "save"){
		foreach (keys %SUBJECT){	push(@content, "\$SUBJECT\{$_\}=qq|$FORM{$_}|;");	}
		push(@content, "return 1;");
		&FileWrite("$CONFIG{email_subjects}", \@content);
	}
	&PrintTemplate($message?$message:$mj{success});
}
############################################################
sub PrintTemplate{
	my(@emails, @html, %HTML, $message, @subjects);
	($message) = @_;
	@emails = &DirectoryFiles($CONFIG{email_path},0, 1);
	@html =   &DirectoryFiles($CONFIG{template_path},0, 1);
#	@subjects=&DirectoryFiles($CONFIG{email_path},0, 1);
	$HTML{email} = $Cgi->popup_menu("filename", \@emails);
	$HTML{html} = $Cgi->popup_menu("filename", \@html);
	&PrintMojoHeader;
	print qq|
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="145"> 
          
      <table border="0" width="601" cellspacing="1" cellpadding="4" bgcolor="#6394BD" class="bordercolor" align="center">
        <tr> 
          <td class="titlebg" bgcolor="#EBEBEB" height="6"> &nbsp;<font size=2 class="text1" color="#FFFFFF"><b><font color="#0000FF">$mj{template1}</font></b></font></td>
        </tr>
        <tr>
          <td class="titlebg" bgcolor="#EEEEEE" height="4">
            <div align="center"><b><font color="#FF0000">$message</font></b></div>
          </td>
        </tr>
        <tr> 
          <td class="windowbg" bgcolor="#EEEEEE" height="41"> 
            <li>Email Templates<br>
              <form name="mojo" method="post" action="$CONFIG{admin_url}">
                <input type="hidden" name="type" value="template">
                <input type="hidden" name="class" value="email">
                <input type="submit" name="edit" value="$TXT{edit}">
                $HTML{email} 
              </form>
            </li>
          </td>
        </tr>
        <tr> 
          <td class="windowbg" bgcolor="#EEEEEE" height="3"> 
            <li>Email Subjects<br>
               <form name="mojo" method="post" action="$CONFIG{admin_url}">
                <input type="hidden" name="type" value="template">
                <input type="hidden" name="class" value="subject">
                <input type="submit" name="edit" value="$TXT{edit}">
                $HTML{subject} 
              </form>
            </li>
          </td>
        </tr>
        <tr> 
          <td class="windowbg" bgcolor="#EEEEEE" height="2"> 
            <li>HTML Templates<br>
              <form name="mojo" method="post" action="$CONFIG{admin_url}">
                <input type="hidden" name="type" value="template">
                <input type="hidden" name="class" value="html">
                <input type="submit" name="edit" value="$TXT{edit}">
                $HTML{html} 
              </form>
            </li>
          </td>
        </tr>
        <tr> 
          <td bgcolor="#EBEBEB" height="2"> 
            <div align="center"> </div>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
	|;
	&PrintMojoFooter;
}
############################################################
sub PrintTemplateEdit{
	my ($file, $message) = @_;
	$FORM{'content'} = &FileRead($file) if (-f $file);
	$message = ucfirst($FORM{class})." Templates" unless $message;
	&PrintMojoHeader;
	print qq|
	<table  cellpadding="5" cellspacing="0" width="100%" height="521">
  <tr> 
    <td height="533" valign="top" align="center"> 
      <form method=POST action="$CONFIG{admin_url}" name="mojo">
        <p> 
          <input type=hidden name=account value="$FORM{'account'}">
          <input type=hidden name=type value="template">
          <input type=hidden name=class value="$FORM{class}">
			 <input type=hidden name=action value="save">
          <input type=hidden name=step value="final">
          <br>
        </p>
        <table border="0" width="601" cellspacing="1" cellpadding="4" bgcolor="#6394BD" class="bordercolor" align="center">
          <tr> 
            <td class="titlebg" bgcolor="#EBEBEB" height="6"> &nbsp;<font size=2 class="text1" color="#FFFFFF"><b><font color="#0000FF">$mj{template1}</font></b></font></td>
          </tr>
          <tr> 
            <td class="titlebg" bgcolor="#EEEEEE" height="13"> 
              <div align="center"><b><font color="#FF0000">$message</font></b></div>
            </td>
          </tr>
          <tr> 
            <td class="titlebg" bgcolor="#EEEEEE" height="4"> 
              <div align="center"> 
                <textarea name="content" cols="70" rows="25" wrap="VIRTUAL">$FORM{'content'}</textarea>
              </div>
            </td>
          </tr>
          <tr> 
            <td class="titlebg" bgcolor="#EEEEEE" height="4"> 
              <div align="center"><b>$TXT{filename}</b> 
                <input type="text" name="filename" value="$FORM{filename}">
              </div>
            </td>
          </tr>
          <tr>
            <td class="titlebg" bgcolor="#EEEEEE" height="4"> 
              <div align="center">
                <input type=submit value="  $TXT{'save'}" name="save">
                <input type="reset" name="reset" value="  $TXT{'reset'}">
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
############################################################
sub PrintTemplateSubjects{
	my($html, $message);
	($message) = @_;
	foreach (sort keys %SUBJECT){
		$html .= qq|<tr><td width="179" valign="top"><div align="right"><b><font face="Tahoma" size="2">$_</font></b></div></td>
			<td width="100" valign="top">&nbsp;</td>
			<td><input type="text" size="60" name="$_" value="$SUBJECT{$_}"></td>
			</tr>|;
	}
	$html =qq|<table width="600" border="0" cellspacing="0" cellpadding="2" align="center">$html</table>|;

	&PrintMojoHeader;
	print qq|
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" height="131"> 
      <form name="mojo" method="post" action="$CONFIG{admin_url}">
        <input type="hidden" name="type" value="template">
        <input type="hidden" name="class" value="subject">
        <input type="hidden" name="action" value="save">
        <input type="hidden" name="step" value="final">
        <table border="0" width="601" cellspacing="1" cellpadding="4" bgcolor="#6394BD" class="bordercolor" align="center">
          <tr> 
            <td class="titlebg" bgcolor="#EBEBEB" height="6"> &nbsp;<font size=2 class="text1" color="#FFFFFF"><b><font color="#0000FF">$mj{template1}</font></b></font></td>
          </tr>
          <tr> 
            <td class="titlebg" bgcolor="#EEEEEE" height="4"> 
              <div align="center"><b><font color="#FF0000">$message</font></b></div>
            </td>
          </tr>
          <tr> 
            <td class="titlebg" bgcolor="#EEEEEE" height="4" valign="top"> 
              $html
            </td>
          </tr>
          <tr>
            <td class="titlebg" bgcolor="#EEEEEE" height="13" valign="top"> 
              <div align="center"> 
                <input type="submit" name="submit" value="$TXT{save}">
                <input type="reset" name="reset" value="$TXT{reset}">
              </div>
            </td>
          </tr>
        </table>
        <div align="center"><b></b></div>
        </form>
    </td>
  </tr>
</table>
	|;
	&PrintMojoFooter;
}













############################################################
sub PrintTemplateDisplay{
	my ($message) = @_;
	&PrintMojoHeader;
	print qq|

<table  cellpadding="5" cellspacing="0" width="100%" height="521">
  <tr> 
    <td height="556" valign="top" align="center"> 
      <form method=POST action="$CONFIG{admin_url}" name="mojo">
        <p>
          <input type=hidden name=account value="$FORM{'account'}">
          <input type=hidden name=type value="template">
          <input type=hidden name=class value="$FORM{class}">
        </p>
        <table width="676">
          <tr> 
            <td> 
              <div align="center"><font face="Geneva, Arial, Helvetica, san-serif" color="#000000"><b><font color="#FF0000">$message 
                </font></b></font> </div>
            </td>
          </tr>
          <tr>
            <td>
              <div align="center">$template_list 
                <input type="submit" name="edit" value="  $TXT{'edit'}">
              </div>
            </td>
          </tr>
          <tr> 
            <td> 
              <div align="center"> 
                <textarea name="content" cols="70" rows="25" wrap="VIRTUAL">$FORM{'content'}</textarea>
              </div>
            </td>
          </tr>
          <tr> 
            <td valign=top> 
              <div align="center"><b>$TXT{filename}</b> 
                <input type="text" name="filename" value="$FORM{filename}">
              </div>
            </td>
          </tr>
          <tr> 
            <td valign=top> 
              <div align="center"> 
                <input type=submit value="  $TXT{'save'}" name="save">
                <input type="reset" name="reset" value="  $TXT{'reset'}">
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
############################################################
sub TemplateDisplay{
	my($file, @files, $html, $filename, $last_mod, $message, $path);
	($path, $message) = @_;
	@files = &DirectoryFiles($path);
	foreach $file(@files){
		$filename = &LastDirectory($file);
		$last_mod = &FormatTime((stat($file))[9]);
		$html .= qq|<tr><td><b>$filename</b></td>
			<td>$last_mod</td>
			<td><a href="$CONFIG{admin_url}?type=template&class=$FORM{class}&action=edit&filename=$filename">$TXT{edit}&nbsp;</a></td>
			</tr>|;
	}
	&PrintTemplateDisplay($html, $message);
}
############################################################
1;
