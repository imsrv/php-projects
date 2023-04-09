############################################################
sub MailMain{
	   if($FORM{class} eq "mail_by_username"){	&MailByUsername;		}
	elsif($FORM{class} eq "mail_by_email"){		&MailByEmail;			}
	elsif($FORM{class}){	&PrintAdminError("Do not Understand", $mj{'confuse'});	}
	&PrintMail;
}
############################################################
sub MailByEmail{
	
	my($email, @emails, $message);
	if($FORM{cancel}){	$CONFIG{message} = $mj{cancel};	}
	elsif($FORM{load}){	
		$FORM{message} =  &FileRead("$CONFIG{email_path}/$FORM{template}");$CONFIG{message} = $mj{success};
		&PrintMailCompose;
	}
	elsif($FORM{step} eq "final"){
		&CheckAdminPermission("mail");
		@emails = split(/;\s*/, $FORM{'emails'});
		foreach $email (@emails) {
			&SendMail( $CONFIG{myname}, $CONFIG{myemail}, $email, $FORM{'subject'}, $FORM{'message'}, $FORM{mail_type});
		}
		$CONFIG{message} = $mj{success};
	}
	else{
		&Maillist;
		&PrintMailCompose;
	}
}
############################################################
sub MailByUsername{
	
	my(%MEM, $email, @emails, $message, $username, @usernames);
	if($FORM{cancel}){	$CONFIG{message} = $mj{cancel};	}
	elsif($FORM{load}){	
		$FORM{message} =  &FileRead("$CONFIG{email_path}/$FORM{template}");
		&PrintMailCompose;	
	}
	elsif($FORM{step} eq "final"){
		&CheckAdminPermission("mail");
		@usernames = split(/;\s*/, $FORM{'emails'});
		$message = $FORM{message};
		foreach $username (@usernames) {
			%MEMBER = &isMemberExist($username);
			next unless $MEMBER{email};
			if(lc($FORM{parse}) eq "full"){	$message = &ParseEmailTemplate($FORM{message}, \%MEMBER);	}
			&SendMail( $CONFIG{myname}, $CONFIG{myemail}, $MEMBER{email}, $FORM{'subject'}, $message, $FORM{mail_type});
		}
		$CONFIG{message} = $mj{success};
	}
	else{
		&Maillist;
		&PrintMailCompose;
	}
}
###################################################################
sub Maillist{
	my(@member,@db,$db,$sth,%MEMBER,@where,$where);
    if($account and ($account ne "all")){ push(@where,"account=\'$account\'");}
    if($status and (lc($status) ne "all")){ push(@where,"status=\'$status\'");}
    $where=join(" AND ",@where);
    if ($where ne '') {$where="WHERE ".$where;}
	@db=&DefineMemberDB;
	$db=join(', ',@db);
	$sth=runSQL("SELECT $db FROM member $where ORDER BY username");
	while (@member=$sth->fetchrow()){
        for (my $i=0; $i <@db; $i++){$MEMBER{$db[$i]}=$member[$i]};
		if($FORM{class} eq "mail_by_username"){		$FORM{emails} .= "$MEMBER{username};";	}
		else{										$FORM{emails} .= "$MEMBER{email};";		}
	}
}
######################################################################
sub PrintMailCompose{
	my(%HTML, $hidden, $message, @templates);
	@templates = &DirectoryFiles($CONFIG{email_path}, 0, 1);
	unshift(@templates, "");
	$HTML{template} = $Cgi->popup_menu("template", \@templates, "");
	if($FORM{class} eq "mail_by_username"){
		%LABEL = ("full"=>"Full parse", "none"=>"none");
		$HTML{parse} =$Cgi->radio_group("parse", ["full", "none"], "none", 0,\%LABEL);
	}
	else{
		$HTML{parse} = "<b>Not Available</b>";
	}
	
	&PrintMojoHeader;
	print qq|
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="466"> 
      <form name="mojo" method="post" action="$CONFIG{admin_url}">
        <input type="hidden" name="type" value="mail">
        <input type="hidden" name="class" value="$FORM{class}">
		  <input type="hidden" name="account" value="$FORM{account}">
		  <input type="hidden" name="status" value="$FORM{status}">
        <input type="hidden" name="step" value="final">
        <table border="0" width="601" cellspacing="1" cellpadding="4" bgcolor="#6394BD" class="bordercolor" align="center">
          <tr> 
            <td class="titlebg" bgcolor="#EBEBEB" height="14"> &nbsp;<font size=2 class="text1" color="#FFFFFF"><b><font color="#0000FF">$mj{mail1}</font></b></font></td>
          </tr>
          <tr> 
            <td class="windowbg" bgcolor="#EEEEEE" height="7"> <font size="2" color="#000000">$mj{mail6} 
              $mj{mail7} </font></td>
          </tr>
          <tr> 
            <td class="windowbg2" bgcolor="#F8F8F8" height="2"> 
              <div align="center"><b><font color="#FF0000">$message</font></b></div>
            </td>
          </tr>
          <tr> 
            <td class="windowbg2" bgcolor="#F8F8F8" height="29"> 
              <textarea cols="70" rows="7" name="emails" wrap="VIRTUAL">$FORM{emails}</textarea>
            </td>
          </tr>
          <tr> 
            <td bgcolor="#EEEEEE" height="14"></td>
          </tr>
          <tr> 
            <td bgcolor="#F8F8F8" class="windowbg2" height="6"> <font size="2">$mj{mail2}</font> 
              <input type=text name="subject" size=30 value="$FORM{subject}">
            </td>
          </tr>
          <tr>
            <td bgcolor="#F8F8F8" class="windowbg2" height="8"> 
              <input type="submit" name="load" value="Load Template">
              $HTML{template} </td>
          </tr>
          <tr> 
            <td bgcolor="#F8F8F8" class="windowbg2" height="81"> 
              <textarea cols=70 rows=9 name=message wrap="VIRTUAL">$FORM{message}</textarea>
            </td>
          </tr>
          <tr> 
            <td bgcolor="#EEEEEE" height="6">$mj{mail4}: 
              <input type="radio" name="mail_type" value="html">HTML Enable 
              <input type="radio" name="mail_type" value="0" checked>Plain-text<br>
              Parsing: $HTML{parse}</td>
          </tr>
          <tr> 
            <td bgcolor="#F8F8F8" height="10"> 
              <div align="center"> 
                <input type=submit value="Send" name="submit">
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
######################################################################
sub PrintMail{
	my($message, %HTML);
	$message = $CONFIG{message} if $CONFIG{message};
	$HTML{status} = $Cgi->popup_menu("status", [all, active, pending, expired, suspend], "all");
#	$HTML{account} = &BuildAccountMenu("all", "All accounts");
	&PrintMojoHeader;
	print qq|
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="187"> 
      <table border="0" width="601" cellspacing="1" cellpadding="4" bgcolor="#6394BD" class="bordercolor" align="center">
          
        <tr> 
            
          <td class="titlebg" bgcolor="#EBEBEB" height="6"> &nbsp;<font size=2 class="text1" color="#FFFFFF"><b><font color="#0000FF">$mj{mail1}</font></b></font></td>
        </tr>
        <tr>
          <td class="titlebg" bgcolor="#EBEBEB" height="7">
            <div align="center"><b><font color="#FF0000">$message</font></b></div>
          </td>
        </tr>
          
        <tr> 
            
          <td class="windowbg" bgcolor="#EEEEEE" height="3"> 
               
            <li>Mail with usernames (you can parse personal information)</li>
            <form name="mojo" method="post" action="$CONFIG{admin_url}">
				  
              <input type="hidden" name="type" value="mail">
              <input type="hidden" name="class" value="mail_by_username">
              $HTML{status} $HTML{account}
              <input type=submit value="Start" name="submit">
            </form>
          </td>
        </tr>
          
        <tr> 
          <td class="windowbg" bgcolor="#EEEEEE" height="3">
              
            <li>Mail with email addresses</li>
            <form name="mojo" method="post" action="$CONFIG{admin_url}">
				 
              <input type="hidden" name="type" value="mail">
              <input type="hidden" name="class" value="mail_by_email">
              $HTML{status} 
              $HTML{account}
              <input type=submit value="Start" name="submit">
            </form>
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
######################################################################
return 1;
