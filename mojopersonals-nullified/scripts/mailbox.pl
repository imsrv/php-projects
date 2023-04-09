################################################################
sub Mailbox{
	use vars qw($message);
	$CONFIG{member_mailbox} = qq|$CONFIG{mail_path}/$FORM{'username'}|;
	&MemberValidateSession;
	if($FORM{action} eq "compose" or $FORM{compose}){		&MailCompose;						}
	elsif($FORM{action} eq "delete" or $FORM{delete}){		&MailDelete;}
	elsif($FORM{action} eq "faq"){		&MailFaq;							}
	elsif($FORM{action} eq "notify"){	&MailNotification;				}
	elsif($FORM{action} eq "next"){		&MailNext;							}
	elsif($FORM{action} eq "prev"){		&MailPrevious;						}	
	elsif($FORM{action} eq "read"){		&MailRead;							}	
	elsif($FORM{action} eq "signature"){&MailSignature;					}
	elsif($FORM{action} eq "reply" or $FORM{reply}){		&MailSend;	}
	elsif($FORM{action} eq "send"){		&MailSend;							}
	elsif($FORM{action} eq "afolder"){	&AddMailFolder;					}
	elsif($FORM{action} eq "dfolder"){	&DeleteMailFolder;				}

	elsif($FORM{action} eq "show" or $FORM{show}){		&MyMailbox;		}
	&MyMailbox($message);
}
################################################################
sub MailCompose{	&MailSend();	}
################################################################
sub MailDelete{
    my($id, @selectedid, $list, $toorfrom,$sth);
    $FORM{folder} = "inbox" unless $FORM{folder};
    if ($FORM{folder} eq "inbox") {$toorfrom="to";}
    elsif ($FORM{folder}="outbox") {$toorfrom="from";}
    @selectedid = $Cgi->param('chkList');
    push(@selectedid, $FORM{mailid}) if $FORM{mailid};
    @selectedid=map("id=$_",@selectedid);
    $list=join(' OR ',@selectedid);
    $sth=runSQL("UPDATE mails SET folder_$toorfrom=\'\' WHERE
                 $list");
    $sth=runSQL("DELETE FROM mails WHERE folder_to=\'\' AND
                 folder_from=\'\'");
    $message = $mj{success};
}
############################################################
sub MailFaq{
	&PrintTemplate("$CONFIG{template_path}/faq.html");
}
################################################################
sub MailNotification{
	if($FORM{step} eq "final"){
		if($FORM{yes}){	$MEMBER{P_notify_pm} = 1;	}
        else{                   $MEMBER{P_notify_pm} = "0";  }
		&UpdatePreferenceDB($MEMBER{username}, \%MEMBER);
	}
	&PrintMailNotification;
}
################################################################
sub MailNext{
    my($id, $next, $i, $toorfrom, $order, @db, %MAIL, $exist,$sth);
	$next = shift;
	$next = 1 unless $next;
	$FORM{folder} = "inbox" unless $FORM{folder};
    if ($FORM{folder}='inbox') {$toorfrom='to'; }
    elsif ($FORM{folder}='outbox') {$toorfrom='from'; }
    $i=($next>0) ? $next : -$next;
    $i=$i-1;
    if ($next>0) {$order="id>$FORM{mailid} ORDER BY id ASC";}
    else {$order="id<$FORM{mailid} ORDER BY id DESC";}
    $sth=runSQL("SELECT * FROM mails WHERE
                 sent_$toorfrom=\'$FORM{username}\' AND
                 folder_$toorfrom=\'$FORM{folder}\' AND $order
                 LIMIT $i, 1");
    $exist=$sth->rows();
    if ($exist) {
         @mail_data=$sth->fetchrow();
         @db = &DefineMailDB;
         for (my $i=0; $i <@db; $i++){$MAIL{$db[$i]}=$mail_data[$i]};
         $MAIL{date_sent} = &FormatTime($MAIL{date_sent});
         if($MAIL{new}){
             $MAIL{new} = 0;
             &UpdateMailDB(\%MAIL);
         }
         &PrintMailRead(\%MAIL);
   }
	&MyMailbox;
}
################################################################
sub MailPrevious{	&MailNext(-1);}
################################################################
sub MailRead{
	my($mail, %MAIL);
    %MAIL=&RetrieveMailDB($FORM{mailid});
    unless ($MAIL{id}>0){ &PrintMailbox($mj{email25}); }
    $MAIL{message}=&OneLine($MAIL{message});
	if($MAIL{new}){
		$MAIL{new} = 0;
        &UpdateMailDB(\%MAIL);
	}
	&PrintMailRead(\%MAIL);
}
################################################################
sub MailSend{
	my($mail, %MAIL, @good,  $to, @tos);
	if($FORM{cancel}){	$message = $mj{cancel};	}
	elsif($FORM{step} eq "final"){
		$message = &CheckMailSendInput;
		&PrintMailCompose($message) if $message;
        $FORM{date_sent} = $CONFIG{systemtime};
        $FORM{sent_from} = $MEMBER{username};
       $FORM{new}=1;

		@tos = split(/;\s*/, $FORM{to});
		foreach $to(@tos){
            $FORM{sent_to} = $to;
            &AddMailDB(\%FORM);
		}
		$message = qq|<li>$mj{email30}:<br>|. join("<br>", @tos) .qq|</li>|;
		$FORM{folder} = "outbox";
		&MyMailbox($message);
	}
###if this a reply to a mail
#    elsif(-f "$CONFIG{mail_path}/$MEMBER{username}/$FORM{folder}/$FORM{mailid}"){
    elsif ($FORM{reply}) {
        %MAIL = &RetrieveMailDB($FORM{mailid});
		$FORM{subject} = "RE: " . $MAIL{subject};
        $FORM{to} = ($MAIL{sent_to} eq $MEMBER{username})?$MAIL{sent_from}:$MAIL{sent_to};
		&PrintMailCompose($message);
	}
###if this is a reply to an ad
	elsif("$FORM{adid}"){
		my $ad = &RetrieveAdDB($FORM{adid});
		my %AD = %$ad if $ad;
		$AD{reply}++;
		&UpdateAdDB(\%AD);
		$FORM{subject} = "RE: " . $AD{title};
		$FORM{to} = $AD{username};
		&PrintMailCompose($message);
	}

	else{	&PrintMailCompose($message);	}
}
################################################################
sub MailSignature{
	if($FORM{step} eq "final"){
       $MEMBER{signature}=&ConvertFromForm($FORM{signature});
       UpdateMemberDB(\%MEMBER);
	}
	&PrintMailSignature;
}
################################################################
sub MyMailbox{
    my($ad_url, @mail_data, %HTML, $ID,  $out, $mail, %MAIL,$sth,
    $message, $name, $new, $size, $value, $toorfrom, @db, $db, $total,
    $username);
	$message = shift;
    if($FORM{mfolder}){     $FORM{folder} = $FORM{mfolder}; }
    unless( defined $FORM{folder}){  $FORM{folder} = "inbox";            }
    $username=$dbh->quote($MEMBER{username});
    if ($FORM{folder} eq 'inbox') {$toorfrom='to'; $HTML{to_or_from} = "Sender"; }
    elsif ($FORM{folder} eq 'outbox') {$toorfrom='from'; $HTML{to_or_from} = "Recipient";}

    $sth=runSQL("SELECT count(*) FROM mails WHERE sent_$toorfrom=$username
                 AND folder_$toorfrom=\'$FORM{folder}\'");
    $total=$sth->rows();
    if ($total>=$MEMBER{mailbox_size}) {
        $message.="<li>$mj{email51}</li>";
    }

    @db = &DefineMailDB;
    $db=join(', ',@db);
    $sth=runSQL("SELECT $db FROM mails WHERE sent_$toorfrom=$username
                 AND folder_$toorfrom=\'$FORM{folder}\' ORDER BY
                 id");
    $total=$sth->rows();
    while (@mail_data=$sth->fetchrow()) {
         for (my $i=0; $i <@db; $i++){$MAIL{$db[$i]}=$mail_data[$i]};
         $MAIL{date_sent} = &FormatTime($MAIL{date_sent});
         if($MAIL{sent_from} eq $MEMBER{username}){$name = $MAIL{sent_to};}
         else{$name = $MAIL{sent_from};}
         if($MAIL{new}>0){ $new ="new";    }
         else{   $new = "";  }
#		$ad_url = qq|<a href="$CONFIG{program_url}?action=view&cat=$MAIL{cat}&adid=$MAIL{adid}"><font face="Tahoma" size="1">$MAIL{adid}</font></a>| if($MAIL{cat} and $MAIL{adid});
        $HTML{mailbox} .=qq|<tr><td><input type=checkbox name=chkList value ="$MAIL{id}"><br><font size=1>$new</font></td>
			<td>$name</td>
            <td><a href="$CONFIG{mail_url}&action=read&folder=$FORM{folder}&mailid=$MAIL{id}">$MAIL{subject}</a></td>
            <td><font face="Tahoma" size="1">$MAIL{date_sent}</font></td>
			</tr>|;
	}
	unless($HTML{mailbox}){
		$HTML{mailbox} =qq|<tr><td colspan=5 align=center><font color=red size=4><br>Folder Empty<br><br></font></td></tr>|;
	}
#    $used = sprintf("%.1f", &DirectorySize("$CONFIG{mail_path}/$MEMBER{username}")/1024);
#    $size = sprintf("%.1f", $CONFIG{mailbox_size}/1024);
#    $HTML{usage} =qq| You have used $used KB out of $size KB|;
    $HTML{total} =$total;
	&PrintMailboxDisplay(\%HTML, $message);
}
################################################################






################################################################
sub CheckMailSendInput{
	my(@notexist, @disallow, @full, @good, $message, %PREF, @tos,$to,$q_to,
	$sth,$total,$mailbox_size);
	$message = qq|<li>$mj{email29}</li>| if(length($FORM{message}) > 3000);
	@tos = split(/;\s*/, $FORM{to});
	foreach $to(@tos){
		if($to eq $MEMBER{username}){	$message .= qq|<li>$mj{email28}</li>|;	}
        elsif (not isMemberExist($to) ){ push(@notexist, $to);       }
		else {
		    %PREF = &RetrievePreferenceDB($to);
			if($PREF{P_disable_pm}){ push(@disallow,$to);}
			else{
				  $q_to=$dbh->quote($to);
				  $sth=runSQL("SELECT COUNT(*) FROM mails WHERE sent_to=$q_to
				               and folder_to=\'inbox\'");
				  ($total)=$sth->fetchrow();
				  $sth=runSQL("SELECT mailbox_size FROM member WHERE username=$q_to");
				  ($mailbox_size)=$sth->fetchrow();
				  if ($total>=$mailbox_size) {push(@full,$to);}
			      else {push (@good,$to);}
			}
		}
	}
	$message .=qq|<li>$mj{email31}:\ |.join(", ", @notexist) .qq|</li>| if @notexist;
	$message .=qq|<li>$mj{email32}:\ |.join(", ", @disallow) .qq|</li>| if @disallow;
	$message .=qq|<li>$mj{email50}:\ |.join(", ", @full) .qq|</li>| if @full;

	return $message;
}
################################################################
#sub CleanUpMailBox{
#    use File::Path;
#    my($size, $username);
#    my ($username) = @_;
#
#    $size = &DirectorySize("$CONFIG{mail_path}/$username");
#    if( $size >= $CONFIG{mailbox_size}){
#        rmtree("$CONFIG{mail_path}/$username/trash");
#        mkdir("$CONFIG{mail_path}/$username/trash", 0777);
#        chmod(0777, "$CONFIG{mail_path}/$username/trash");
#    }
#    $size = &DirectorySize("$CONFIG{mail_path}/$username");
#    if( $size >= $CONFIG{mailbox_size}){
#        rmtree("$CONFIG{mail_path}/$username/outbox");
#        mkdir("$CONFIG{mail_path}/$username/outbox", 0777);
#        chmod(0777, "$CONFIG{mail_path}/$username/outbox");
#    }
#    $size = &DirectorySize("$CONFIG{mail_path}/$username");
#    if($size >= $CONFIG{mailbox_size}){
#        rmtree("$CONFIG{mail_path}/$username/inbox");
#        mkdir("$CONFIG{mail_path}/$username/inbox", 0777);
#        chmod(0777, "$CONFIG{mail_path}/$username/inbox");
#    }
#    return $size;
#}
############################################################
sub PrintMailbox{
	my($template, $html);
	$html = shift;
	$template = &ParseCommonCodes($TEMPLATE{mailbox});
	$template =~ s/\[TEMPLATE_MENU\]/&BuildMailboxMenu()/e;
	$template =~ s/\[TEMPLATE_TITLE\]/&BuildMailboxTitle()/e;
	$template =~ s/\[TEMPLATE_SUBTITLE\]/&BuildMailboxSubtitle()/e;
	$template =~ s/\[TEMPLATE_CONTENT\]/$html/;
	&PrintHeader;
	print $template;
	&PrintFooter;	
}
############################################################
sub PrintMailCompose{		&PrintMailbox(&BuildMailCompose(@_));			}
sub PrintMailNotification{	&PrintMailbox(&BuildMailNotification(@_));	}
sub PrintMailRead{			&PrintMailbox(&BuildMailRead(@_));				}
sub PrintMailSignature{		&PrintMailbox(&BuildMailSignature(@_));		}
sub PrintMailboxDisplay{	&PrintMailbox(&BuildMailboxDisplay(@_));		}
############################################################
sub BuildMailCompose{
	my($message) = @_;
    $FORM{message} =$FORM{message}?$FORM{message}:"\n\n\n\n\n\n\n\n\n\n\n\n\n".&ConvertToForm($MEMBER{signature});
	my %HTML;
	$HTML{rules} = "<li>HTML code is not allowed</li>";	
	return qq|
<table border=0 cellpadding=3 cellspacing=0 width="100%">
  <tr> 
    <td valign=top height="390"> 
      <form method=post action="$CONFIG{mail_url}" name="mojo">
        <div align="center">
          <input type=hidden name="type" value="mail">
          <input type=hidden name="action" value="send">
          <input type=hidden name="step" value="final">
          <b><font color="#FF0000"> $message </font></b></div>
        <table border=0 cellpadding=1 cellspacing=1 width="100%">
          <tr> 
            <td align=right width="13%"><b><font size="2">To:&nbsp;</font></b></td>
            <td nowrap width="87%"> 
              <input type=text name=to value="$FORM{to}" size=49>
              separate each username with a semicolon (;)</td>
          </tr>
          <tr> 
            <td align=right width="13%"><b><font size="2">Subject:&nbsp;</font></b></td>
            <td width="87%"> 
              <input type=text name=subject value="$FORM{subject}" size=49>
            </td>
          </tr>
          <tr>
            <td align=right width="13%" valign="top"><b><font size="2">Message:&nbsp;</font></b></td>
            <td width="87%"> 
              <textarea name=message rows=15 cols=55 wrap=virtual>$FORM{message}</textarea>
            </td>
          </tr>
          <tr>
            <td align=right width="13%" valign="top"><b><font size="2">Message Rules:&nbsp;</font></b></td>
            <td width="87%">$HTML{rules}</td>
          </tr>
          <tr> 
            <td width="13%" bgcolor="#EFEBEF">&nbsp;</td>
            <td width="87%" bgcolor="#EBEBEB"><font  face=arial,helvetica,sans-serif size="-1"> 
              <input type=submit name="send" value="Send">
              &nbsp; &nbsp; 
              <input type=submit name="cancel" value="Cancel">
              </font></td>
          </tr>
        </table>
        </form>
    </td>
  </tr>
</table>
	|;
}
############################################################
sub BuildMailNotification{
	my($onoff);
	if($MEMBER{P_notify_pm}){	$onoff = $TXT{on};	}
	else{								$onoff = $TXT{off};	}
	return qq|
	<table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr> 
    <td height="73">$mj{email23}<br>
      <form name="mojo" method="post" action="$CONFIG{mail_url}">
        <input type="hidden" name="type" value="mail">
        <input type="hidden" name="action" value="notify">
        <input type="hidden" name="step" value="final">
        <table width="250" border="0" cellspacing="0" cellpadding="0" align="center" height="21">
          <tr> 
            <td> 
              <input type="submit" name="yes" value="Yes">
            </td>
            <td> 
              <input type="submit" name="no" value="No">
            </td>
          </tr>
        </table>
        <br>
      </form>
    </td>
  </tr>
  <tr> 
    <td height="27"> 
      <div align="center">$mj{email24} <b>$onoff</b></div>
    </td>
  </tr>
</table>
	|;
}
############################################################
sub BuildMailRead{
	my($isReply, $mail, %MAIL);
	($mail, $message) = @_;
	%MAIL = %$mail;
##This is to check if this is an outgoing or incoming mail, and generate the approriate button
#	$MAIL{message} = &ConvertTo
    if($MEMBER{username} eq $MAIL{sent_from}){   $isReply = "ReSend";    }
    else{  $isReply = "Reply"; }
	return qq|
	<table border=0 cellpadding=3 cellspacing=0 width="90%">
  <tr> 
    <td valign=top height="253"> 
      <form method=post action="$CONFIG{mail_url}">
        <input type=hidden name="type" value="mail">
        <input type=hidden name="username" value="$FORM{username}">
        <input type=hidden name="folder" value="$FORM{folder}">
        <input type=hidden name="mailid" value="$MAIL{id}">
        <table border=0 cellpadding=4 cellspacing=0 width="100%">
          <tr> 
            <td bgcolor="#EBEBEB" width="1%" nowrap><font  face=arial,helvetica,sans-serif size="-1"> 
              &nbsp; 
              <input type=submit name="reply" value="$isReply">
              &nbsp; 
              <input type=submit name="delete" value="Delete">
              </font></td>
            <td bgcolor="#EBEBEB" align=right nowrap> <b> <font face=arial,helvetica,sans-serif size="-1"><a href="$CONFIG{mail_url}&action=prev&folder=$FORM{folder}&mailid=$MAIL{id}">Previous</a></font>&nbsp; 
              \|&nbsp;<font face=arial,helvetica,sans-serif size="-1"><a href="$CONFIG{mail_url}&action=next&folder=$FORM{folder}&mailid=$MAIL{id}">Next</a></font>&nbsp; 
              \|&nbsp;<font face=arial,helvetica,sans-serif size="-1"><a href="$CONFIG{mail_url}&folder=$FORM{folder}">View&nbsp;$FORM{folder}</a></font> 
              </b></td>
          </tr>
        </table>
        <table border=1 cellpadding=1 cellspacing=0 width="100%" bordercolor="#EBEBEB">
          <tr> 
            <td align=right valign=top width="10%"> 
              <div align="left"><b>Date:</b></div>
            </td>
            <td width="90%">$MAIL{date_sent}</td>
          </tr>
          <tr> 
            <td align=right valign=top width="10%"> 
              <div align="left"><b>From:</b></div>
            </td>
            <td width="90%">$MAIL{sent_from}</td>
          </tr>
          <tr> 
            <td align=right valign=top width="10%"> 
              <div align="left"><b>To:</b></div>
            </td>
            <td width="90%">$MAIL{sent_to}</td>
          </tr>
          <tr> 
            <td align=right valign=top width="10%"> 
              <div align="left"><b>Subject:</b></div>
            </td>
            <td width="90%">$MAIL{subject}</td>
          </tr>
          <tr> 
            <td colspan=2> 
              <p>&nbsp;</p>
              <p>$MAIL{message}</p>
              <p><br>
            </p>
            </td>
          </tr>
        </table>
        <table border=0 cellpadding=4 cellspacing=0 width="100%">
          <tr> 
            <td bgcolor="#EBEBEB" width="1%" nowrap><font  face=arial,helvetica,sans-serif size="-1"> 
              &nbsp; 
              <input type=submit name="reply" value="$isReply">
              &nbsp; 
              <input type=submit name="delete" value="Delete">
              </font></td>
            <td bgcolor="#EBEBEB" align=right nowrap> <b> <font face=arial,helvetica,sans-serif size="-1"><a href="$CONFIG{mail_url}&action=prev&folder=$FORM{folder}&mailid=$MAIL{id}">Previous</a></font>&nbsp; 
              \|&nbsp;<font face=arial,helvetica,sans-serif size="-1"><a href="$CONFIG{mail_url}&action=next&folder=$FORM{folder}&mailid=$MAIL{id}">Next</a></font>&nbsp; 
              \|&nbsp;<font face=arial,helvetica,sans-serif size="-1"><a href="$CONFIG{mail_url}&folder=$FORM{folder}">View&nbsp;$FORM{folder}</a></font> 
              </b></td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
</table>
|;
}

############################################################
sub BuildMailSignature{

    my $string = $MEMBER{signature};
	$FORM{signature} = &ConvertToForm($string);
	return qq|
	<table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr> 
    <td height="73">
<form name="mojo" method="post" action="$CONFIG{mail_url}">
        <input type="hidden" name="type" value="mail">
        <input type="hidden" name="action" value="signature">
        <input type="hidden" name="step" value="final">
        <br>
        <textarea name="signature" cols="50" rows="5">$FORM{signature}</textarea>
        <br>
        <input type="submit" name="yes" value="Submit">
        <br>
      </form>
    </td>
  </tr>
  <tr> 
    <td height="2"> 
      <div align="center"></div>
    </td>
  </tr>
</table>
	|;
}
############################################################
sub BuildMailboxDisplay{
	my($html, $message) = @_;
	my %HTML = %$html;
	my $inbox_name = $FORM{folder};
	require 'js.pl';
	return 	&MailJs().qq|
<table width="90%" border="0" cellspacing="0" cellpadding="0" bordercolor="0" align="center">
  <tr>
    <td valign="top" height="156"> 
      <form name="frm1" method="post" action="$CONFIG{mail_url}">
        <div align="center">
          <input type="hidden" name="type" value="mail">
          <input type="hidden" name="folder" value="$FORM{folder}">
        </div>
        <div align="center"><font color="#FF0000"><b>$message</b></font><br>
        </div>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td width="49%">$HTML{total} message(s)</td>
            <td align="right" width="51%">$HTML{usage}</td>
        </tr>
      </table>
        <table border=1 cellpadding=3 cellspacing=0 width="100%" bordercolor="#EEEEEE">
          <tr bgcolor="#EFEBEF" align=center> 
            <td align=left width="4%"><b><font size="2">&nbsp;</font></b></td>
            <td align=left width="17%"><b><font face="Tahoma" size="2">$HTML{to_or_from}</font></b></td>
            <td align=left width="71%"><b><font face="Tahoma" size="2">Subject</font></b></td>
            <td align=left width="8%" bgcolor="#EFEBEF"><b><font face="Tahoma" size="2">Date</font></b></td>
          </tr>
          $HTML{mailbox} 
          <tr> 
            <td colspan=4><a href="javascript:SetChecked(1)">Check&nbsp;All</a>&nbsp; 
              \|&nbsp; <a href="javascript:SetChecked(0)">Clear&nbsp;All</a></td>
          </tr>
          <tr bgcolor="#ebebeb"> 
            <td colspan=4> 
              <input type=submit name="delete" value="delete">
            </td>
          </tr>
        </table>
       </form>
    </td>
  </tr>
</table>
<br>
<p>&nbsp;</p>
	|;
}
############################################################
sub BuildMailboxMenu{
	return qq|
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="81"><a href="$CONFIG{mail_url}">Mailbox main</a><br>
      <a href="$CONFIG{mail_url}&action=compose">Compose</a><br>
      <a href="$CONFIG{mail_url}&folder=inbox">Inbox</a><br>
      <a href="$CONFIG{mail_url}&folder=outbox">Outbox</a><br>
      <a href="$CONFIG{mail_url}&action=notify">Notification</a><br>
      <a href="$CONFIG{mail_url}&action=signature">Signature</a><br>
      <a href="$CONFIG{mail_url}&action=faq#mail">FAQ</a></td>
  </tr>
  <tr><td> <hr width="100%" size="0"></td></tr>
  <tr> <td height="5"><a href="$CONFIG{ad_url}">Ads</a></td></tr>
  <tr> <td><a href="$CONFIG{gallery_url}">Gallery</a></td></tr>
  <tr> <td><a href="$CONFIG{member_url}&action=profile">Profile</a></td></tr>
</table>

	|;
}
############################################################
sub BuildMailboxSubtitle{
	my($title);
	if($FORM{action} eq "compose"){		$title =qq|Compose new Message|;				}
	elsif($FORM{action} eq "notify"){	$title =qq|Private mail Notification|;		}
	elsif($FORM{action} eq "signature"){$title =qq|Email Signature|;					}
	elsif($FORM{folder}){					$title =qq|$FORM{folder}|;						}
	else{											$title =qq|Your Private Mailbox|;			}
	return $title;
}
############################################################
sub BuildMailboxTitle{		return "Your Private Mailbox";	}
############################################################

1;
