############################################################
sub AdMain{
	if($FORM{action} eq "approve"){	&AdApprove;			}
#	elsif($FOR{action} eq "edit"){	&EditAd;				}
	elsif($FORM{action} eq "deny"){	&AdDeny;				}
	elsif($FORM{action} eq "delete"){&AdDelete;			}
	elsif($FORM{action}){	&PrintError($mj{'error'}, $mj{'confuse'});	}
	unless($FORM{cat}){
		require "admin_categories.pl";
		&BuildAdminLocation;
		&DisplayCategories;
	}
	&AdBuild;
}
############################################################
sub AdBuild{
	my($action, $count, @ext, $html, $message,$sth,$db,@db,$sth,$status);
	$message = shift;
#	unless(-d $CONFIG{category_path}){		&PrintError($mj{error}, "The category you entered does not exist in our database : <br><b>$FORM{cat}</b>");	}
#	if($FORM{class} eq "active"){		push(@ext, "ads");	}
#	else{	push(@ext, "wai");	}
	$start = ($FORM{'offset'} > 0)?$FORM{'offset'}:0;
	$FORM{cat} = ($FORM{cat} > 0)?$FORM{cat}:0;
	$end =   $start + $FORM{'lpp'} -1;
#	$end = ($FORM{'total'}-1) if ($end > $FORM{'total'});
	if ($FORM{class} eq 'active') {$status='active';}
	else {$status='pending';}
	@db=&DefineAdDB;
	$db=join(', ',@db);
	unless ($FORM{total}>0){
		$sth=runSQL("SELECT count(*) FROM ads WHERE cat=$FORM{cat} AND status=\'$FORM{class}\'");
        $FORM{total} = $sth->fetchrow();
	}
        $sth=runSQL("SELECT $db FROM ads WHERE cat=$FORM{cat} AND status=\'$FORM{class}\'
                 ORDER BY date_create DESC LIMIT $start, $FORM{lpp}");

	$i=$start;
    while (@ad=$sth->fetchrow()){
        for (my $i=0; $i <@db; $i++){$AD{$db[$i]}=$ad[$i]};
		$count=$i+1;
		$view=    qq|<a href="$CONFIG{ad_url}&action=view&cat=$AD{cat}&id=$AD{id}&file=$count&total=$FORM{total}" target="mojo">$TXT{view}</a>|;
		$approve= qq|<a href="$CONFIG{admin_url}?type=ad&class=pending&action=approve&cat=$FORM{cat}&id=$AD{id}">$TXT{approve}</a>|;
		$deny=    qq|<a href="$CONFIG{admin_url}?type=ad&class=pending&action=deny&cat=$FORM{cat}&id=$AD{id}">$TXT{deny}</a>|;
		$delete=  qq|<a href="$CONFIG{admin_url}?type=ad&class=active&action=delete&cat=$FORM{cat}&id=$AD{id}">$TXT{delete}</a>|;
		if($AD{status} eq "pending"){		$action = qq|$view \| $approve \| $deny |;	}
		elsif($FORM{class} eq "active"){	$action = qq|$view \| $delete|;	}
		elsif($FORM{class} eq "expire"){	$action = qq|$delete|;	}
		$html .=qq|<tr><td>$count</td>
			<td>$AD{title}</td>
			<td><a href="$CONFIG{admin_url}?type=member&action=profile&username=$AD{username}">$AD{username}</a></td>
			<td>$action</td></tr>|;
		$i++;
	}
	&PrintAdBuild($html, $message);
}
############################################################
sub AdApprove{
	my($line, %AD, %MEM, $message);
	&CheckAdminPermission("ad", "approve");
    %AD = &RetrieveAdDB($FORM{id});
    unless ($AD{id}){
        $CONFIG{message} = "No such ad's id exists: $FORM{id}"; return;
	}
	$AD{date_end} = $CONFIG{systemtime} + $CONFIG{ad_length} * 24 * 60 * 60;
	$AD{status} = "active";
	&UpdateAdDB(\%AD);
	
    $FORM{'sent_from'} = $ADMIN{username};
    $FORM{'sent_to'} = $AD{username};
    $FORM{'date_sent'} = $CONFIG{systemtime};
	$FORM{'subject'} = $SUBJECT{ad_approved};
	$FORM{'message'} = &OneLine(&ConvertFromHTML(&FileRead($EMAIL{ad_approved})));
    &AddMailDB(\%FORM);
#	%MEM = &RetrieveMemberDB($AD{username});
#	&SendMail($CONFIG{myname}, $CONFIG{myemail}, $MEM{email}, $SUBJECT{ad_approved}, &ParseEmailTemplate($FORM{'message'}, \%MEM));
    $CONFIG{message} = "You have successfully approved ad ID $FORM{id}";
}
############################################################
sub AdDelete{
	my($line, $ad, @ads, %AD, $email_message, %MEM);
	&CheckAdminPermission("ad", "delete");
    %AD = &RetrieveAdDB($FORM{id});
    unless ($AD{id}){
        $CONFIG{message} = "No such ad's id exists: $FORM{id}"; return;
	}
    &DeleteAdDB($AD{id});
	$email_message = &FileRead($EMAIL{ad_deleted});
	
    $FORM{'sent_from'} = $ADMIN{username};
    $FORM{'sent_to'} = $AD{username};
    $FORM{'date_sent'} = $CONFIG{systemtime};
	$FORM{'subject'} = $SUBJECT{ad_deleted};
	$FORM{'message'} = &OneLine(&ConvertFromHTML($email_message));
    &AddMailDB(\%FORM);
###Update the member ads
	%MEM = &RetrieveMemberDB($AD{username});
	$MEM{ad_used}--;
	&UpdateMemberDB(\%MEM);
#	&SendMail($CONFIG{myname}, $CONFIG{myemail}, $MEM{email}, $SUBJECT{ad_deleted}, &ParseEmailTemplate($email_message, \%MEM));
	$CONFIG{message} = $mj{success};
}
############################################################
sub AdDeny{
	&CheckAdminPermission("ad", "deny");
    %AD = &RetrieveAdDB($FORM{id});
    unless ($AD{id}){
        $CONFIG{message} = "No such ad's id exists: $FORM{id}"; return;
	}
	$AD{status} = "deny";
	&UpdateAdDB(\%AD);
	
	$email_message = &FileRead($EMAIL{ad_denied});
	
    $FORM{'sent_from'} = $ADMIN{username};
    $FORM{'sent_to'} = $AD{username};
    $FORM{'date_sent'} = $CONFIG{systemtime};
	$FORM{'subject'} = $SUBJECT{ad_denied};
	$FORM{'message'} = &OneLine(&ConvertFromHTML($email_message));
    &AddMailDB(\%FORM);

#	%MEM = &RetrieveMemberDB($AD{username});
#	&SendMail($CONFIG{myname}, $CONFIG{myemail}, $MEM{email}, $SUBJECT{ad_denied}, &ParseEmailTemplate($email_message, \%MEM));
	$CONFIG{message} = $mj{success};
}
############################################################
sub PrintAdBuild{
	my ($html, $mesasge) = @_;
    my $page_link = &BuildPageLink;
	$message = $CONFIG{message} unless  $message;
	&PrintMojoHeader;
	print qq|
<table width=95%" border="0" cellspacing="0" cellpadding="0" align=center>
  <tr> 
    <td height="24"> 
      <div align="center"><font size="4"><b>Ads</b></font></div>
		</td>
  </tr>
  <tr> 
    <td height="2"> 
      <div align="center"><font color="#FF0000"><b>$message</b></font></div>
    </td>
  </tr>
  <tr> 
    <td height="37"> 
      <table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#DDDDDD">
        <tr> 
          <td colspan="4"><b>$page_link</b><br>
            <br>
          </td>
        </tr>
        <tr bgcolor="#EBEBEB"> 
          <td width="5%"><b><font color="#000000">Number</font></b></td>
          <td width="50%"> 
            <div align="center"><font color="#000000"><b>Title</b></font></div>
          </td>
          <td width="15%"><b><font color="#000000">Posted By</font></b></td>
          <td width="30%"><b><font color="#000000">Action</font></b></td>
        </tr>
        $html 
        <tr> 
          <td colspan="4"><br>
            $page_link</td>
        </tr>
      </table>
      
    </td>
  </tr>
</table>
	|;
	&PrintMojoFooter;
}
############################################################
1;
