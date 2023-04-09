############################################################
sub MemberMain{
	   if($FORM{action} =~ /add|register/){						&MemberAdd;			}
	elsif($FORM{action} eq "approve"  or $FORM{approve}){		&MemberApprove;	}	
	elsif($FORM{action} eq "credit"   or $FORM{credit}){		&MemberCredit;		}	
	elsif($FORM{action} eq "delete"   or $FORM{delete}){		&MemberDelete;		}
	elsif($FORM{action} eq "deny"     or $FORM{deny}){			&MemberDeny;		}
	elsif($FORM{action} =~ /detail|profile/){		&MemberDetail;		}
	elsif($FORM{action} =~ /edit|update/){			&MemberEdit;		}
	elsif($FORM{action} eq "expire"   or $FORM{expire}){		&MemberExpire;		}
	elsif($FORM{action} eq "suspend"  or $FORM{unexpire}){	&MemberSuspend;	}	
	elsif($FORM{action} eq "search"   or $FORM{search}){		&MemberSearch;		}	
	elsif($FORM{action} eq "unexpire" or $FORM{unexpire}){	&MemberUnexpire;	}
	elsif($FORM{action} eq "unsuspend"  or $FORM{unexpire}){	&MemberUnsuspend;	}
		
	elsif($FORM{class} eq "search"){  	&MemberSearch;			}
	&BuildMemberPages(&MemberDisplayWhere());
}
############################################################
sub MemberAdd{
	my($message);
	&CheckAdminPermission("member", "add");
	if($FORM{'cancel'}){ 	$CONFIG{message} = $mj{'cancel'}; }
	elsif($FORM{'step'} eq "final"){
		$message = &CheckMemberRegisterInput;
		&PrintMemberAdd($message) if $message;

		$FORM{date_create}=	$FORM{'date_end'}  = time;
#		$FORM{date_end}= 		&GiveMeTime($FORM{date_end});
		$FORM{status} = "active";
		&AddMemberDB(\%FORM);
		$CONFIG{message} = $mj{success};
		&SendMail($CONFIG{myname}, $CONFIG{myemail}, $FORM{email}, $SUBJECT{registered}, &ParseEmailTemplate($EMAIL{registered},\%FORM)) if (-f $EMAIL{registered});
	}
	else{		&PrintMemberAdd($message);	}
	$FORM{class} = "active";
}
############################################################
sub MemberApprove{
	my($message);
	&CheckAdminPermission("member", "approve");
	if($FORM{'cancel'}){ 	$CONFIG{message} = $mj{'cancel'}; }
	else{
		%MEMBER = &RetrieveMemberDB($FORM{username});
		if($MEMBER{status} ne "pending"){	$CONFIG{message} = "$mj{failure}. This member is not a pending member";	return;	}
		$MEMBER{status} = "active";
#		$MEMBER{'date_end'} = &GiveMeTime($MEMBER{'date_end'});
		&UpdateMemberDB(\%MEMBER);
		$CONFIG{message} = $mj{success};
		&SendMail($CONFIG{myname}, $CONFIG{myemail}, $MEMBER{'email'}, $SUBJECT{approved}, &ParseEmailTemplate($EMAIL{approved},\%MEMBER)) if (-f $EMAIL{approved});
	}
	$FORM{class} = "pending";
}
###################################################################
sub MemberDelete{
	my($message);
	&CheckAdminPermission("member", "delete");
	if($FORM{'cancel'}){		$CONFIG{message} =$mj{'cancel'}; }
	else{
		%MEMBER = &RetrieveMemberDB($FORM{username});
		if(not $MEMBER{username}){	$CONFIG{message} = "$mj{failure}. The username you've entered does not exist in the database";	return;	}
		&DeleteMemberDB($FORM{username});
		&SendMail($CONFIG{myname}, $CONFIG{myemail}, $MEMBER{'email'}, $SUBJECT{deleted}, &ParseEmailTemplate($EMAIL{deleted},\%MEMBER)) if (-f $EMAIL{deleted});
		$CONFIG{message} = $mj{success};
	}
}
###################################################################
sub MemberDeny{
	my($message);
	&CheckAdminPermission("member", "deny");
    if($FORM{'cancel'}){ $CONFIG{message} =$mj{'cancel'}; }
	else{
		%MEMBER = &RetrieveMemberDB($FORM{username});
        if($MEMBER{status} ne "pending"){$CONFIG{message} = "$mj{failure}. This member is not a pending member"; return; }
		&DeleteMemberDB($FORM{username});
		&SendMail($CONFIG{myname}, $CONFIG{myemail}, $MEMBER{'email'}, $SUBJECT{denied}, &ParseEmailTemplate($EMAIL{denied}, \%MEMBER)) if (-f $EMAIL{denied});
		$CONFIG{message} = $mj{success};
	}
	$FORM{class} = "pending";
}
###################################################################
sub MemberDetail{
	my($message);
	&CheckAdminPermission("member", "detail");
	%MEMBER = &RetrieveMemberDB($FORM{username});
	if(not $MEMBER{username}){	$CONFIG{message} = "$mj{failure}. The username you've entered does not exist in the database";	return;	}
	&PrintMemberDetail(@_);
}
###################################################################
sub MemberEdit{
	my($message,$oldaccount,%ACCOUNT);
	&CheckAdminPermission("member", "edit");
	%MEMBER = &RetrieveMemberDB($FORM{username});
	if($FORM{'cancel'}){		$CONFIG{message} =$mj{'cancel'}; }
	elsif($FORM{'step'} eq "final"){
		$oldaccount=$MEMBER{account};
		foreach (keys %MEMBER){		$MEMBER{$_} = $FORM{$_} if defined $FORM{$_};	}
# $MEMBER{account} is already set
		if ($FORM{add_amount}) {
			if ($FORM{more}) {
			   if ($MEMBER{account_end} != 2**32-2){
			        if ($FORM{add_amount} eq 'unlimited') {
		              	$MEMBER{account_end}=2**32-2;
		            }
			        else{
			         	$MEMBER{account_end} += ($FORM{add_amount} * $FORM{add_period} * 24 * 60 *60) - ($FORM{remove_amount} * $FORM{remove_period} * 24 * 60 *60);
			        }
			   }
			}
			else {
			    $MEMBER{account_start}=$CONFIG{systemtime};
		        if ($FORM{add_amount} eq 'unlimited') {
		       	    $MEMBER{account_end}=2**32-2;
		        }
				else{
					$MEMBER{account_end} = $CONFIG{systemtime}+$FORM{add_amount} * $FORM{add_period} * 24 * 60 *60;
				}
			}
			if ($MEMBER{account_end}>$CONGIG{systemtime}) {$MEMBER{status}='active';}
		}
		$MEMBER{ad_allowed} += $FORM{add_ad_credit} - $FORM{delete_ad_credit};
		$MEMBER{media_allowed} += $FORM{add_media_credit}- $FORM{delete_media_credit};
		if ($oldaccount ne $MEMBER{account}) {
			%ACCOUNT=&RetrieveAccountDB($MEMBER{account});
			$MEMBER{ad_allowed}=$ACCOUNT{ad_allowed};
			$MEMBER{media_allowed}=$ACCOUNT{media_allowed};
			$MEMBER{mailbox_size}=$ACCOUNT{mailbox_size};
		}
#		if($FORM{add_premium}){
#			$MEMBER{account_start} = &TimeNow unless $MEMBER{'premium_start'};
#			$MEMBER{account_end} = ($MEMBER{'premium_end'} < &TimeNow)?&TimeNow+$FORM{add_premium}* 24 * 60 *60:$MEMBER{'premium_end'}+$FORM{add_premium}* 24 * 60 *60;
#		}
		&UpdateMemberDB(\%MEMBER);
		$CONFIG{message} = $mj{success};
	}
	else{			&PrintMemberEdit(@_);	}
	&MemberDetail;
}
###################################################################
sub MemberExpire{
	my($message);
	&CheckAdminPermission("member", "expire");
	if($FORM{'cancel'}){	$CONFIG{message} =$mj{'cancel'}; }
	else{
		%MEMBER = &RetrieveMemberDB($FORM{username});
#		$MEMBER{date_end} = $CONFIG{systemtime};
		$MEMBER{status} = "expire";
		&UpdateMemberDB(\%MEMBER);
		&SendMail($CONFIG{myname}, $CONFIG{myemail}, $MEMBER{'email'}, $SUBJECT{expired}, &ParseEmailTemplate($EMAIL{expired}, \%MEMBER)) if (-f $EMAIL{expired});
		$CONFIG{message} = $mj{success};
	}
	$FORM{class} = "active";
}
###################################################################
sub MemberSuspend{
	my($message);
	&CheckAdminPermission("member", "suspend");
	if($FORM{'cancel'}){		$CONFIG{message} =$mj{'cancel'}; }
	else{
		%MEMBER = &RetrieveMemberDB($FORM{username});
		$MEMBER{status} = "suspend";
		&UpdateMemberDB(\%MEMBER);
		&SendMail($CONFIG{myname}, $CONFIG{myemail}, $MEMBER{'email'}, $SUBJECT{suspended}, &ParseEmailTemplate($EMAIL{suspended}, \%MEMBER)) if (-f $EMAIL{suspended});
		$CONFIG{message} = "$mj{success}";
	}
	$FORM{class} = "suspend";
}
###################################################################
sub MemberUnexpire{
	my($message);
	&CheckAdminPermission("member", "unexpire");
	if($FORM{'cancel'}){	$CONFIG{message} =$mj{'cancel'}; }
	else{
		%MEMBER = &RetrieveMemberDB($FORM{username});
		if($MEMBER{status} ne "expire"){	$CONFIG{message} = "$mj{failure}. The username you've entered does not have an expired status";	return;	}
#		$MEMBER{'date_end'} = &GiveMeTime($MEMBER{'date_end'});
		$MEMBER{status} = "active";
		&UpdateMemberDB(\%MEMBER);
		&SendMail($CONFIG{myname}, $CONFIG{myemail}, $MEMBER{'email'}, $SUBJECT{unexpired}, &ParseEmailTemplate($EMAIL{unexpired}, \%MEMBER)) if (-f $EMAIL{unexpired});
		$CONFIG{message} = $mj{success};
	}
	$FORM{class} = "expire";
}
###################################################################
sub MemberUnsuspend{
	my($message);
	&CheckAdminPermission("member", "unsuspend");
	if($FORM{'cancel'}){		$CONFIG{message} =$mj{'cancel'}; }
	else{
		%MEMBER = &RetrieveMemberDB($FORM{username});
		if($MEMBER{status} ne "suspend"){	$CONFIG{message} = "$mj{failure}. The username you've entered does not have a suspended status";	return;	}
		$MEMBER{status} = "active";
		&UpdateMemberDB(\%MEMBER);
		&SendMail($CONFIG{myname}, $CONFIG{myemail}, $MEMBER{'email'}, $SUBJECT{unsuspended}, &ParseEmailTemplate($EMAIL{unsuspended}, \%MEMBER)) if (-f $EMAIL{unsuspended});
		$CONFIG{message} = "$mj{success}";
	}
	$FORM{class} = "suspend";
}

############################################################
sub MemberSearch{
    my($where, @where, $member,$keywords);
	$FORM{class} = "search";
	if($FORM{step} eq "final"or $FORM{keywords}){
         if($FORM{account} and ($FORM{account} ne "all")){
              push @where, "account=\'$FORM{account}\'";
         }
         if ($FORM{keywords} ne ''){
            $keywords=$dbh->quote($FORM{keywords});
            $keywords=~s/^["'](.*)["']$/$1/;
            push @where, "$FORM{search4} LIKE \'\%$keywords\%\'";
		}
        $where=join(" AND ",@where);
        if ($where ne '') {$where="WHERE $where";}
        &BuildMemberPages($where);
	}
	else{	&PrintMemberSearch;	}
}
###################################################################
sub MemberDisplayWhere{
	my ($where);
#	@members = &FileRead($CONFIG{member_db});
#	foreach $member (@members){
#		%MEMBER = &RetrieveMemberString($member);
   $where='';
   if($FORM{account} and ($FORM{account} ne "all")){
   		$where.="WHERE account=\'$FORM{account}\'";
   }
   if($FORM{class}){
   	     if ($where ne '') {$where.=" AND status=\'$FORM{class}\'";}
		 else {$where.="WHERE status=\'$FORM{class}\'";}
   }
   return $where;
}
############################################################
sub MemberActions{
	my($html, $link);
	($link) = @_;
	$html = qq|<a href="mailto:$MEMBER{email}"><font size=2>$TXT{'email'}</font></a>&nbsp;
				  <a href="$link&action=detail&username=$MEMBER{'username'}&class=$MEMBER{status}&offset=$FORM{offset}"><font size=2>$TXT{'detail'}</font></a>&nbsp;
				  <a href="$link&action=delete&username=$MEMBER{'username'}&class=$MEMBER{status}&offset=$FORM{offset}"><font size=2>$TXT{'delete'}</font></a>&nbsp;
				  <a href="$link&action=edit&username=$MEMBER{'username'}&class=$MEMBER{status}&offset=$FORM{offset}"><font size=2>$TXT{'edit'}</font></a>&nbsp;|;
#				  <a href="$CONFIG{admin_url}?type=log&action=userlog&username=$MEMBER{'username'}"><font size=2>Log File</font></a>&nbsp;
#				 |;
	if($MEMBER{status} =~ /active/i){
		$html .= qq|<a href="$link&action=expire&username=$MEMBER{'username'}&class=expire&offset=$FORM{offset}"><font size=2>$TXT{'expire'}</font></a>&nbsp;
					<a href="$link&action=suspend&username=$MEMBER{'username'}&class=suspend&offset=$FORM{offset}"><font size=2>$TXT{'suspend'}</font></a>&nbsp;|;
	}
	elsif($MEMBER{status} =~ /pending/i){
		$html .= qq|<a href="$link&action=approve&username=$MEMBER{'username'}&class=pending&offset=$FORM{offset}"><font size=2>$TXT{'approve'}</font></a>&nbsp;
					<a href="$link&action=deny&username=$MEMBER{'username'}&class=pending&offset=$FORM{offset}"><font size=2>$TXT{'deny'}</font></a>&nbsp;
				|;
	}
	elsif($MEMBER{status} =~ /expire/i){
		$html .= qq|<a href="$link&action=unexpire&username=$MEMBER{'username'}&class=expire&offset=$FORM{offset}"><font size=2>$TXT{'unexpire'}</font></a>&nbsp;
				|;
	}
	elsif($MEMBER{status} =~ /suspend/i){
		$html .= qq|<a href="$link&action=unsuspend&username=$MEMBER{'username'}&class=suspend&offset=$FORM{offset}"><font size=2>$TXT{'unsuspend'}&nbsp;</font></a>&nbsp;
				|;
	}
	return $html;
}
############################################################
sub BuildMemberPages{
	my ($actions, $count, $html, $link, @member, $message,$start,
	$where,	$order,$db,@db,%MEMBER,$sth,$mpp);
	$where=@_[0];
#    ($member) = @_;
#    @members = @$member;
#	if($FORM{sort} eq "username"){	@members = sort { my %DB1 = &RetrieveMemberString($a); my %DB2 = &RetrieveMemberString($b); $DB1{username} cmp $DB2{username}} 	@members;	}
#	elsif($FORM{sort} eq "fname"){	@members = sort { my %DB1 = &RetrieveMemberString($a); my %DB2 = &RetrieveMemberString($b); $DB1{fname} cmp $DB2{fname}} 			@members;	}
#	elsif($FORM{sort} eq "lname"){	@members = sort { my %DB1 = &RetrieveMemberString($a); my %DB2 = &RetrieveMemberString($b); $DB1{lname} cmp $DB2{lname}}			@members;	}
#	elsif($FORM{sort} eq "date_create"){@members = sort { my %DB1 = &RetrieveMemberString($a); my %DB2 = &RetrieveMemberString($b); $DB2{date_create} <=> $DB1{date_create}} 		@members;	}
#	elsif($FORM{sort} eq "date_end"){	@members = sort { my %DB1 = &RetrieveMemberString($a); my %DB2 = &RetrieveMemberString($b); $DB2{date_end} <=> $DB1{date_end}} @members;	}
#	elsif($FORM{sort} eq "account"){	@members = sort { my %DB1 = &RetrieveMemberString($a); my %DB2 = &RetrieveMemberString($b); $DB1{account} cmp $DB2{account}} @members;	}
#	else{	@members = sort { $a cmp $b} @members;	}
	$order=($FORM{sort} ne '')?$FORM{sort}:'username';
	@db=&DefineMemberDB;
	$db=join(', ',@db);
	unless ($FORM{total}>0){
		    $sth=runSQL("SELECT count(*) FROM member $where");
	        $FORM{total} = $sth->fetchrow();
	}
	$start = ($FORM{'offset'} > 0)?$FORM{'offset'}:0;
	$mpp=($CONFIG{mpp}>0)?$CONFIG{mpp}:30;
    $sth=runSQL("SELECT $db FROM member $where ORDER BY $order LIMIT $start,
	             $mpp");
	$count = $start;
    $link = "$CONFIG{admin_url}?account=$FORM{'account'}&type=member&class=$FORM{class}";
	while (@member=$sth->fetchrow()){
        for (my $i=0; $i <@db; $i++){$MEMBER{$db[$i]}=$member[$i]};
		$count++;
		$MEMBER{date_registered}=  &FormatTime($MEMBER{date_create});
		if ($MEMBER{account_end}==2**32-2) {$MEMBER{date_expired}='unlimited'}
		else {$MEMBER{date_expired}=     &FormatTime($MEMBER{account_end});}
#		$action = &MemberActions($link);
		$html .= qq|<tr><td bgcolor="#EBEBEB">$count&nbsp;</td>
            <td>&nbsp;&nbsp;<a href="$link&action=detail&username=$MEMBER{username}">$MEMBER{'username'}</a></td>
			<td>$MEMBER{'fname'} $MEMBER{'lname'}&nbsp;</td>
			<td>$MEMBER{date_registered}</td>
			<td>$MEMBER{date_expired}</td>
			</tr>|;
	}
	unless($html){	$html = qq|<tr><td colspan=5><br><br><div align=center><b>Your search returns no results</b></div></br><br></td></tr>|;	}
	&PrintMemberDisplay($html);
}
############################################################
sub BuildMemberTitle{
	if($FORM{class} eq "active"){			return "Active members";			}
	elsif($FORM{'class'} eq "expire"){ 	return "Expired members";			}
	elsif($FORM{'class'} eq "pending"){ return "Pending members";			}
	elsif($FORM{'class'} eq "suspend"){ return "Suspended members";		}
	elsif($FORM{'class'} eq "search"){  return "Search results";			}
	return "Members";
}
############################################################
sub CheckMemberAddInput{
	my $message = &CheckMemberEditInput;
	%MEMBER = &isMemberExist($FORM{username});
	$message .= qq|<li>$mj{mem4}</li>| if $MEMBER{username};
	return $message;
}
##################################################################################
sub CheckMemberEditInput{
	my($message);
	$message .=qq|<li>$mj{mem1}</li>| unless $FORM{username};
	$message .=qq|<li>$mj{mem11}</li>| unless $FORM{password};
	$message .=qq|<li>$mj{mem21}</li>| unless $FORM{email};
	return $message;
}
############################################################
sub PrintMemberDisplay{
	my($html, $message, $pagelink, $title, $this_url);
	($html) = @_;
	$message = $CONFIG{message} if $CONFIG{message};
	$pagelink = &BuildPageLink;
	$title = &BuildMemberTitle;
	$this_url = "$CONFIG{admin_url}?type=member&class=$FORM{class}&offset=$FORM{offset}&keywords=$FORM{keywords}&search4=$FORM{search4}&lpp=$FORM{lpp}&step=$FORM{step}";
	
	&PrintMojoHeader;
	print qq|
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="93">
  <tr>
    <td height="168">       
      <table width="100%" border="1" cellspacing="0" cellpadding="3" bordercolor="#CCCCCC">   
        <tr>  
          <td colspan="5" height="5"> 
            <div align="center"><b><font size="5">$title</font></b></div>
          </td>
        </tr>
        <tr>   
          <td colspan="5"> 
            <div align="center"><font color=red size=3><b><font color="#FF0000">$message</font></b></font></div>
          </td>
        </tr>
        <tr> 
          <td colspan="5">$pagelink</td>
        </tr>
        <tr> 
          <td colspan="5">
            <table width="90%" border="0" cellspacing="0" cellpadding="0" align="center">
              <tr bgcolor="#EBEBEB"> 
                <td width="3%"><b>&nbsp;</b></td>
                <td width="22%"><b><a href="$this_url&sort=username">Username</a></b></td>
                <td width="32%"><b><a href="$this_url&sort=fname">First name</a> <a href="$this_url&sort=lname">Last name</a></b></td>
                <td width="28%"><b><a href="$this_url&sort=date_create">Date registered</a></b></td>
                <td width="15%"><b><a href="$this_url&sort=date_end">Account expiry date</a></b></td>
  
              </tr>
				$html 
            </table>
          </td>
        </tr>
        <tr>
          <td colspan="5">$pagelink</td>
        </tr>
      </table>
    </td>
  </tr>
</table>
  |;
  &PrintMojoFooter;
}
###########################################################################
sub PrintMemberAdd{
	$CONFIG{program_url} = $CONFIG{admin_url};
	&PrintMemberRegister(@_);
}
###########################################################################
sub PrintMemberDetail{
	my($action, $field, %FIELD, $html, $line, @lines, $message);
	($message) = @_;
	$message = $CONFIG{message} if $CONFIG{message};
	@lines  = &FileRead($CONFIG{member_fields});
	foreach $line(@lines){
		%FIELD = &RetrieveFieldDB($line);
		next unless $FIELD{ID};
		next if($FIELD{ID} =~ /username|password|fname|lname|email|position|date_registered|date_expired/);
		next unless ($FIELD{active});
		$html .=qq|<tr> 
          <td><b><font size="2">$FIELD{name}&nbsp;</font></b></td>
          <td><b><font size="2">$MEMBER{$FIELD{ID}}&nbsp;</font></b></td>
        </tr>
		  |;
	}
	%ACCOUNT = &RetrieveAccountDB($MEMBER{account});
    $action = &MemberActions("$CONFIG{admin_url}?type=member&class=$FORM{class}");
	&PrintMojoHeader;
	print qq|
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="175" valign="top"> <br>
      <table border="0" cellpadding="4" cellspacing="1" class="bordercolor" align="center" width="75%" bordercolor="#EEEEEE">
        <tr> 
          <td class="titlebg" colspan="2" height="9" bgcolor="#EBEBEB"> 
            <div align="center"><font size=2 class="text1" color="#FFFFFF"><b><font color="#0000FF"><a href="$CONFIG{admin_url}?type=member&action=edit&username=$MEMBER{username}">$MEMBER{username}</a></font></b></font></div>
          </td>
        </tr>
        <tr>
          <td class="titlebg" colspan="2" height="2">
            <div align="center"><font size=2 class="text1" color="#0000FF"><b>$action</b></font></div>
          </td>
        </tr>
        <tr> 
          <td valign="top" class="windowbg" width="76%"> 
            <table border=1 cellspacing="0" cellpadding="2" width="100%" bordercolor="#EBEBEB">
              <tr> 
                <td width="34%"><font size=2><b>Name: </b></font></td>
                <td width="66%"><font size="2">$MEMBER{fname} $MEMBER{lname} </font></td>
              </tr>
              <tr> 
                <td width="34%"><font size=2><b>Email</b></font></td>
                <td width="66%"><font size="2"><a href="mailto:$MEMBER{email}">$MEMBER{email}</a></font></td>
              </tr>
              <tr> 
                <td width="34%"><font size=2><b>Position: </b></font></td>
                <td width="66%"><font size="2">$MEMBER{position}</font></td>
              </tr>
              <tr> 
                <td width="34%" height="1"><font size=2><b>Date Registered: </b></font></td>
                <td width="66%" height="1"><font size=2><b>$MEMBER{date_registered}</b></font></td>
              </tr>
              <tr> 
                <td width="34%" height="1"><font size=2><b>Account expiry date: </b></font></td>
                <td width="66%" height="1"><font size=2><b>$MEMBER{date_expired}</b></font></td>
              </tr>
				  <tr> 
                <td width="34%" height="1"><font size=2><b>Ads Credit: </b></font></td>
                <td width="66%" height="1"><font size=2><b>$MEMBER{ad_allowed}</b></font></td>
              </tr>
				  <tr> 
                <td width="34%" height="1"><font size=2><b>Media Credit: </b></font></td>
                <td width="66%" height="1"><font size=2><b>$MEMBER{media_allowed}</b></font></td>
              </tr>
				  <tr> 
                <td width="34%" height="1"><font size=2><b>Account: </b></font></td>
                <td width="66%" height="1"><font size=2><b>$ACCOUNT{name}</b></font></td>
              </tr>
              <tr> 
                <td colspan="2"> 
                  <hr size="1" width="100%" class="hr">
                </td>
              </tr>
              $html
            </table>
          </td>
          <td class="windowbg" valign="middle" align="center" width="24%"> <br>
            <br>
          </td>
        </tr>
		   
        <tr> 
          <td class="titlebg" colspan="2" height="20" bgcolor="#EBEBEB"> 
            <div align="center"><font size=2 class="text1" color="#0000FF"><b>$action</b></font></div>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
	|;
	&PrintMojoFooter;
}
###########################################################################
sub PrintMemberEdit{
	my($html, @label, %LABEL, $message);
	($message) = @_;
	$message = $CONFIG{message} if $CONFIG{message};
	@label = ('1', '7', '30', '365');
	%LABEL = ('1'=>days,'7'=>weeks,'30'=>months,'365'=>years);
	$html = &BuildMemberField(\%MEMBER);
	$HTML{add_amount}=   $Cgi->popup_menu("add_amount", [ "","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","unlimited"], $FORM{add_amount});
	$HTML{add_period}=   $Cgi->popup_menu("add_period", \@label, $FORM{add_period}, \%LABEL);
	$HTML{ad_allowed}=   $Cgi->textfield("ad_allowed", $MEMBER{ad_allowed}, 3, 5);
	$HTML{media_allowed}= $Cgi->textfield("media_allowed", $MEMBER{media_allowed}, 3,5);
	$HTML{account}=      &BuildAccountMenu($MEMBER{account},"");
	$HTML{more}= $Cgi->popup_menu("more",["more",""],"");
#	$HTML{account} = &BuildAccountMenu;
		&PrintMojoHeader;
		print qq|
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="376"> 
      <form name="mojo" method="post" action="$CONFIG{admin_url}">
        <input type="hidden" name="type" value="member">
        <input type="hidden" name="class" value="$class">
        <input type="hidden" name="username" value="$FORM{username}">
		  <input type="hidden" name="action" value="edit">
        <input type="hidden" name="step" value="final">
        <table width="601" border="1" cellspacing="0" cellpadding="2" bordercolor="#EEEEEE" align="center">
          <tr> 
            <td colspan="2" height="2" bgcolor="#EBEBEB"> 
              <div align="center"> 
                <b><font face="Geneva, Arial, Helvetica, san-serif">$MEMBER{username}</font></b>
              </div>
            </td>
          </tr>
          <tr>
            <td colspan="2" height="11">
              <div align="center"><font color="#FF0000" size="1"><b><font face="Tahoma" size="2">$message</font></b></font></div>
            </td>
          </tr>
          <tr> 
            <td width="154"><b>$TXT{username}</b></td>
            <td width="433"><b><font face="Geneva, Arial, Helvetica, san-serif">$MEMBER{username}</font></b></td>
          </tr>
          <tr> 
            <td width="154"><b>Registration date</b></td>
            <td width="433"><b><font face="Geneva, Arial, Helvetica, san-serif">$MEMBER{date_registered} 
              </font></b></td>
          </tr>
          <tr> 
            <td width="154"><b>Account expiry date</b></td>
            <td width="433"><b><font face="Geneva, Arial, Helvetica, san-serif">$MEMBER{date_expired}</font></b></td>
          </tr>
          <tr> 
            <td width="154"><b>$TXT{password}</b></td>
            <td width="433"> <font face="Geneva, Arial, Helvetica, san-serif"><b> 
              <input type="password" name="password" size="20" maxlength="40" value="$MEMBER{password}">
              </b></font></td>
          </tr>
          <tr> 
            <td width="154"><b>$TXT{email}</b></td>
            <td width="433"> <font face="Geneva, Arial, Helvetica, san-serif"><b> 
              <input type="text" name="email" size="20" maxlength="40" value="$MEMBER{email}">
              </b></font></td>
          </tr>
          <tr> 
            <td width="154"><b>$TXT{fname}</b></td>
            <td width="433"><b><font face="Geneva, Arial, Helvetica, san-serif"><b>
              <input type="text" name="fname" size="20" maxlength="40" value="$MEMBER{fname}">
              </b></font></b></td>
          </tr>
          <tr> 
            <td width="154"><b>$TXT{lname}</b></td>
            <td width="433"><b><font face="Geneva, Arial, Helvetica, san-serif"><b>
              <input type="text" name="lname" size="20" maxlength="40" value="$MEMBER{lname}">
              </b></font></b></td>
          </tr>
         <tr> 
                <td colspan="2"> 
                  <hr size="1" width="100%" class="hr">
                </td>
              </tr>
			 $html
			 <tr> 
                <td colspan="2"> 
                  <hr size="1" width="100%" class="hr">
                </td>
              </tr>
          <tr>
            <td width="154"><b>Ads Credit</b></td>
            <td width="433">$HTML{ad_allowed}</td>
          </tr>
          <tr>
            <td width="154"><b>Media Credit</b></td>
            <td width="433">$HTML{media_allowed}</td>
          </tr>
          <tr>
            <td width="154"><b>Account</b></td>
            <td width="433">$HTML{account}</td>
          </tr>
          <tr> 
            <td width="154"><b>Credit User for </b></td>
            <td width="433"> <font face="Geneva, Arial, Helvetica, san-serif"><b> 
              $HTML{add_amount} $HTML{more} $HTML{add_period}</b></font></td>
          </tr>
          <tr> 
            <td colspan="2"> 
              <div align="center"><b><font face="Tahoma"></font></b><b><font face="Geneva, Arial, Helvetica, san-serif"></font></b><b><font face="Tahoma"></font></b><b><font face="Geneva, Arial, Helvetica, san-serif"></font></b><b><font face="Tahoma"></font></b><b><font face="Geneva, Arial, Helvetica, san-serif"> 
                <input type="submit" name="Submit" value="Submit">
                </font></b></div>
            </td>
          </tr>
        </table>
        <div align="center"></div>
      </form>
    </td>
  </tr>
</table>
|;
	&PrintMojoFooter;
}
############################################################
sub PrintMemberSearch{
	my $message = $CONFIG{message}?$CONFIG{message}:"Please enter your search term";
    my %LABELS=('username'=>'username','fname'=>'first name','lname'=>'last name','email'=>'email');
    $HTML{search4} = $Cgi->popup_menu("search4",[keys %LABELS], $FORM{username},\%LABELS);
#	$HTML{account} = &BuildAccountMenu("all", "All Accounts");
	&PrintMojoHeader;
	print qq|
<table width="600" border="0" cellspacing="0" cellpadding="0" align="center" height="193">
  <tr bordercolor="#CCCCCC"> 
    <td height="140"> 
      <div align="center">
        <center>
          <form action="$admin_url">
 				 <input type=hidden name=type value=member>
            <input type=hidden name=class value=search>
            <input type=hidden name=step value=final>
            <table width=500 border="1" cellpadding="2" cellspacing="0" bordercolor="#DDDDDD" align="center">
              <tr bgcolor="#EBEBEB"> 
                <td height="20" colspan="2"> 
                  <div align="center"> <font size="5"><b>$TXT{'search'}</b></font> 
                  </div>
                </td>
              </tr>
              <tr> 
                <td colspan="2"> 
                  <div align="center"><b><font color="#FF0000">$message</font></b></div>
                </td>
              </tr>
              <tr> 
                <td><b> Search terms</b></td>
                <td><b> 
                  <input type=text size=30 name="keywords">
                  </b></td>
              </tr>
              <tr> 
                <td><b>In</b></td>
                <td> <b> 
                 $HTML{search4}</b></td>
              </tr>
             
              <tr> 
                <td colspan="2"> 
                  <div align="center"><b> 
                    <input type=submit name=search value=" Go ">
                    </b></div>
                </td>
              </tr>
            </table>
            <b> <br>
            </b> 
          </form>
        </center>
      </div>
    </td>
  </tr>
</table>
|;
&PrintMojoFooter;
}
############################################################
1;
