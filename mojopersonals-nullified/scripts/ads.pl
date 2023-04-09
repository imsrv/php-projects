############################################################
sub AdMain{
	if($FORM{'action'} eq "view"){			&AdView;		}
	&MemberValidateSession;
	   if($FORM{class} eq "postedads"){		&AdPosted;		}
	elsif($FORM{class} eq "savedads"){		&AdSaved;		}
	
	elsif($FORM{'action'} eq "delete"){		&AdDelete;		}
	elsif($FORM{'action'} eq "faq"){			&AdFaq;			}   
	elsif($FORM{'action'} eq "recount"){	&AdRecount;		}
	elsif($FORM{'action'} eq "reply"){		&AdReply;		}
	elsif($FORM{'action'} eq "save"){		&AdSaved;		}
	elsif($FORM{'action'} eq "view"){		&AdView;			}
	elsif($FORM{'action'} eq "view_image"){&AdImage;		}
	
	elsif($FORM{'action'} eq "edit"){		require "adpost.pl";	&AdPost;			}
	elsif($FORM{'action'} eq "post"){		require "adpost.pl"; &AdPost;			}
	
	&AdCenter;
}
############################################################
sub AdCenter{	&AdPosted(@_);}
############################################################
sub AdDelete{
	my (%AD, $adid, $cat, $line,$media, @media, $string, $sth,
	@cats,$cats);
	if($FORM{'cancel'}){		&AdCenter($mj{cancel});	}
	elsif($FORM{'step'} eq "final"){
            &DeleteAdDB($FORM{id});
			$MEMBER{ad_used}--;
		    &UpdateMemberDB(\%MEMBER);
		    &SendMail($CONFIG{myname}, $CONFIG{myemail}, $MEMBER{email}, $SUBJECT{ad_deleted}, &ParseEmailTemplate($EMAIL{ad_deleted}, \%MEMBER));
	}
	else{	&PrintAdDelete;	}
	&AdCenter($mj{success});
}
############################################################
sub AdFaq{
	&PrintTemplate("$CONFIG{template_path}/faq.html");
}
############################################################
sub AdImage{
	my(%AD, %PHOTO, $template);
	$template = &ParseCommonCodes($TEMPLATE{image});
    %AD = &RetrieveAdDB($FORM{id});
	%PHOTO = &RetrievePhotoDB("$CONFIG{photo_path}/$AD{username}/$AD{image}");
	if($PHOTO{fullsize}){	$template =~ s/\[FULLSIZE\]/$PHOTO{fullsize}/iges;	}
	else{							$template =~ s/\[FULLSIZE\]/This ad does not have any image./i;	}
	foreach (keys %PHOTO){	$template =~ s/\[$_\]/$PHOTO{$_}/ig;	}
	&PrintTemplate($template);
}
############################################################
sub AdPosted{
    my(%AD, $ad, @ad,$cat, $expire, $id, $line,$message, $status,$sth,
    $string, $title, @db, $username);
	$message = shift;
#    @ads = split(/\|/, $MEMBER{ads});
    @db=&DefineAdDB;
    $db=join(', ',@db);
    $username=$dbh->quote($MEMBER{username});
    $sth=runSQL("SELECT $db FROM ads WHERE username=$username AND status NOT LIKE \'incomplete\%\'");
    while (@ad=$sth->fetchrow()){
        for (my $i=0; $i <@db; $i++){$AD{$db[$i]}=$ad[$i]};
        if ($AD{title} ne ''){
              $AD{title} = substr($AD{title}, 0, 60)."...";
        }
        else {
              $AD{title} = "No Title Entered";
        }
		if($AD{status} eq "active"){	
			$expire = int(($AD{date_end} - &TimeNow)/(24*60*60) +1);
			$expire = ", Expired in $expire days";
			$status = "Posted ";
#            $string .= "$ad|";
            $title = qq|<a href="$CONFIG{ad_url}&action=view&cat=$AD{cat}&country=$AD{country}&state=$AD{state}&id=$AD{id}">$AD{title}</a>|;
            $action = qq|<a href="$CONFIG{ad_url}&action=edit&cat=$AD{cat}&country=$AD{country}&state=$AD{state}&id=$AD{id}">Edit</a> \| <a href="$CONFIG{ad_url}&action=delete&cat=$AD{cat}&id=$AD{id}">Delete</a>|;
		}
		elsif($AD{status} eq "pending"){
#			$action = qq|<a href="$CONFIG{ad_url}&action=edit&cat=$AD{cat}&adid=$AD{adid}>Edit</a> \| <a href="$CONFIG{ad_url}&action=delete&cat=$AD{cat}&adid=$AD{adid}">Delete</a>|;
			$status = "<font color=red>Under review</font>";
			$expire="";
#            $string .= "$ad|";
            $action = qq|<a href="$CONFIG{ad_url}&action=delete&cat=$AD{cat}&id=$AD{id}">Delete</a>|;
			$title = qq|$AD{title}|;
##deny ad
		}
		elsif($AD{status} eq "deny"){
			$status = "<font color=red>Denied</font>";
			$expire="";
#            $string .= "$ad|";
			$title = qq|$AD{title}|;
            $action = qq|<a href="$CONFIG{ad_url}&action=edit&cat=$AD{cat}&country=$AD{country}&state=$AD{state}&id=$AD{id}">Edit</a> \| <a href="$CONFIG{ad_url}&action=delete&cat=$AD{cat}&id=$AD{id}">Delete</a>|;
##incomplete ad
		}
		elsif($AD{status} eq "incomplete"){
			$status = "<font color=red>Incompleted</font>";
			$expire="";
#            $string .= "$ad|";
			$title = qq|$AD{title}|;
            $action = qq|<a href="$CONFIG{ad_url}&action=edit&cat=$AD{cat}&id=$AD{id}">Edit</a> \| <a href="$CONFIG{ad_url}&action=delete&cat=$AD{cat}&id=$AD{id}">Delete</a>|;
		}
		elsif($AD{status} eq "expire"){
            &DeleteAdDB($AD{id});
		}
		else{			next;		}	
		
		$AD{view}  = 0 unless $AD{view};
		$AD{reply} = 0 unless $AD{reply};
		$html .= qq|<tr><td>&nbsp;</td>
				<td>&nbsp;$title<br>&nbsp;$status $expire</td>
				<td>&nbsp;$action</td>
				<td>&nbsp;$AD{view}</td>
				<td>&nbsp;$AD{reply}</td></tr>|;
	}
###Self correcting
#	if($string ne $MEMBER{ads}){
#		$MEMBER{ads} = $string;
#		&SaveMemberProfile($member_file, \%MEMBER);
#	}
	unless ($html){
		$MEMBER{ad_allowed} = $CONFIG{ad_allowed} unless ($MEMBER{ad_allowed});
		$html =qq|<tr><td colspan=5 align=center><br><br><font color=red>You have not posted any ad yet. You can post up to $MEMBER{ad_allowed} ads at a time.</font><br><br></td></tr>|;
	}
	&PrintAdPosted($html, $message);
}
############################################################
sub AdRecount{
    my(@ads, $count, $ext, @ext, @images, $username,$sth);
    $username=$dbh->quote($MEMBER{username});
    $sth=runSQL("SELECT COUNT(*) FROM ads WHERE username=$username
                 AND status<>'expire' AND (status NOT LIKE \'incomplete\%\')");
    ($MEMBER{ad_used}) = $sth->fetchrow();
	$MEMBER{ad_allowed} = $CONFIG{ad_allowed} unless ($MEMBER{ad_allowed});
	&UpdateMemberDB(\%MEMBER);
	&AdCenter($mj{success});
}
############################################################
sub AdReply{
	my(%AD,%ACTION);
	if($FORM{step} eq "final"){
		%AD = &RetrieveAdDB($FORM{id});
		$AD{reply}++;
		&UpdateAdDB(\%AD);
		$FORM{date_sent}= $CONFIG{systemtime};
		$FORM{sent_from}= $MEMBER{username};
		$FORM{sent_to}=   $AD{username};
		$FORM{adid}=$FORM{id};
		delete $FORM{id};
		&AddMailDB(\%FORM);
		$FORM{id}=$FORM{adid};
		$ACTION{ad_id}=$FORM{id};
		$ACTION{username}=$MEMBER{username};
		$ACTION{type}='r';
		&AddActionDB(\%ACTION);
		if($MEMBER{P_notify_ads_reply}){
			&SendMail($CONFIG{myname}, $CONFIG{myemail},$MEMBER{'email'}, $SUBJECT{ad_replied}, &ParseEmailTemplate($EMAIL{ad_replied}, \%MEMBER));
		}
		require "mailbox.pl";
        &MyMailbox("$mj{email30}: Ad ID # $FORM{id}");
	}
	else{	&PrintAdReply;	}
}
############################################################
sub AdSaved{
	my(%AD, $ad, @ads, $html, $message, $string,$username,$total,$ad_id,
	%ACTION,$sth);
	if($FORM{action} eq "delete"){
		 $username=$dbh->quote($MEMBER{username});
		 $sth=runSQL("DELETE FROM admemactions WHERE ad_id=$FORM{id} AND
					  type=\'s\' AND username=$username");
		 $sth=runSQL("UPDATE ads SET save=save-1 WHERE id=$FORM{id}");
		 $message.=$mj{success};
	}
	elsif($FORM{action} eq "save"){
        $ad = &RetrieveAdDB($FORM{id});
		$username=$dbh->quote($MEMBER{username});
		$sth=runSQL("SELECT ad_id FROM admemactions WHERE
					 type=\'s\' AND username=$username");
		$total=$sth->rows();
		@tokens = split(/\|/, $MEMBER{sads});
		if($total>9){
			$message .= qq|You can save only 10 ads at a time|; 
		}
		else{
		    while (($ad_id)=$sth->fetchrow()){
			    if ($ad_id==$FORM{id}) {
                    $message .= qq|You've already saved this ad ID # $FORM{id}|;
					$ad=0;
					last;
			    }
		    }
		}
		if($ad){
			$ACTION{ad_id}=$FORM{id};
			$ACTION{username}=$MEMBER{username};
			$ACTION{type}='s';
			&AddActionDB(\%ACTION);
			%AD = %$ad;
			$AD{save}++;
			&UpdateAdDB(\%AD);
		}
#		else{
#            $message .= qq|The ad ID you entered does not exist in our database: <font color=red><b>$FORM{id}</b></font>|;
#		}
	}
    $username=$dbh->quote($MEMBER{username});
    $sth=runSQL("SELECT ad_id FROM admemactions WHERE
	             type=\'s\' AND username=$username ORDER BY date");
#	$total=$sth->rows();
	$html='';
#	my $i; $i=0;
	while ($ad_id=$sth->fetchrow()){
#		$i++;
		$ad = &RetrieveAdDB($ad_id);
		%AD = %$ad;
		$AD{title} = substr($AD{title}, 0, 60)."...";
        $html.= qq|<tr><td><a href="$CONFIG{ad_url}&action=view&cat=$AD{cat}&id=$AD{id}">$i $AD{title}</a></td>
            <td><a href="$CONFIG{ad_url}&class=savedads&action=delete&cat=$AD{cat}&id=$AD{id}">Delete</a></td></tr>|; 
	}
	unless($html){
		$html =qq|<tr><td colspan=2 align="center"><br><br><font color=red>No saved ads available.</font><br><br></td></tr>|;
	}
	&PrintAdSaved($html, $message);
}
############################################################
sub AdView{
	my(%AD,%ACTION);
    %AD = &RetrieveAdDB($FORM{id});
    unless($AD{id}){  &PrintError("No such Ad", "The ad ID you entered does not exist in our database: <font color=red><b>$FORM{id}</b></font>");   }

    if ($MEMBER{username} && ($AD{username} ne $MEMBER{username})) {
		$AD{view}++;
	    $FORM{fast_parse} = 1;
	    &UpdateAdDB(\%AD);
		$ACTION{ad_id}=$AD{id};
		$ACTION{username}=$MEMBER{username};
		$ACTION{type}='v';
		&AddActionDB(\%ACTION);
	}
	$template = &FileRead($TEMPLATE{ad});
	$MOJO{ads} = &ParseAdTemplate($template, \%AD);
    &BuildNextPrevFiles() if ($ENV{HTTP_REFERER} !~ /$CONFIG{search_url}/);
    &PrintTemplate($TEMPLATE{ad_full});
}
############################################################
sub PrintAdCenter{
	my($fill, $template, $html);
	$html = shift;
	$fill = "<p>&nbsp;</p>" x 5 if( length($html) < 500);
	$template = &ParseUserURL(&ParseCommonCodes($TEMPLATE{adcenter}));
	$template =~ s/\[TEMPLATE_MENU\]/&BuildAdMenu($FORM{step})/e;
	$template =~ s/\[TEMPLATE_TITLE\]/&BuildAdTitle()/e;
	$template =~ s/\[TEMPLATE_SUBTITLE\]/&BuildAdSubtitle()/e;
	$template =~ s/\[TEMPLATE_CONTENT\]/$html$fill/;
	&PrintHeader;
	print $template;
	&PrintFooter;	
}
############################################################
sub PrintAdDelete{		&PrintAdCenter(&BuildAdDelete(@_));			}
sub PrintAdPosted{		&PrintAdCenter(&BuildAdPosted(@_));			}
sub PrintAdSaved{			&PrintAdCenter(&BuildAdSaved(@_));			}
sub BuildAdStat{			&PrintAdCenter(&BuildAdStat(@_));			}
sub PrintAdReply{			&PrintAdCenter(&BuildAdReply(@_));			}

############################################################
sub BuildAdCatMenu{
    my(@cats, %CAT, $id, $name, %TEMP, $cat, $cat_id, $subcats,
    $html, $trace, $desc, $step, $checked, @cats,$sth);
#    if ($CAT{countries}) {$CAT{name}.="\/$FORM{country}";}
#    if ($CAT{states}) {$CAT{name}.="\/$FORM{state}";}
    $step=@_[0];
    if ($FORM{cat}>0) {%CAT = &RetrieveCategoryDB($FORM{cat});}
    if ($FORM{parent}>0) {$id=$FORM{parent};}
    else {$id=$CAT{parent};}
    if ($step>0){
         while ($id>0) {
            $cat = &RetrieveCategoryDB($id);
            %TEMP = %$cat;
            $CAT{name}="$TEMP{name}\/".$CAT{name};
#            if (($step==1) and ($FORM{action} eq 'post')) {
#            push(@cats, $CAT{id});
            $id=$TEMP{parent};
         }
         $cats=join('/',@cats);
         return qq|<b>$CAT{name}</b><input type="hidden" name="cat" value=$FORM{cat}>|;
    }
    $trace='';
    while ($id>0) {
         $cat = &RetrieveCategoryDB($id);
         %TEMP = %$cat;
         $trace=qq|<a href="$CONFIG{ad_url}&action=post&step=0&parent=$TEMP{parent}">$TEMP{name}</a>&gt;|.$trace;
         $id=$TEMP{parent};
    }
    $FORM{parent}=(($CAT{parent}>0)?$CAT{parent}: 0) unless ($FORM{parent}>0);
    $html='';

    if ($FORM{parent}>0) {$html.=qq|<tr> <td colspan=2><div align=left>Section $trace</div></td></tr>|;}
    $sth=runSQL("SELECT id, name, subcats, description FROM
                 category WHERE parent=$FORM{parent} ORDER BY number");
#    $FORM{cat}=($FORM{cat}>0)?$FORM{cat}:'0';
    if (not ($FORM{cat}>0)){
          ($id,$name,$subcats,$desc)=$sth->fetchrow();
           if ($desc ne '') {$desc="\($desc\)";}
           if ($subcats>0) {$subcats=qq|<a href="$CONFIG{ad_url}&action=post&step=0&parent=$id"> $subcats subcategories</a>|;}
           else {$subcats="\&nbsp\;";}
           $html.=qq|<tr><td><input type=radio name=\'cat\' value=\'$id\' checked></td><td>$name $desc</td><td>$subcats</td></tr>|;
    }
    while (($id,$name,$subcats,$desc)=$sth->fetchrow()){
           if ($desc ne '') {$desc="\($desc\)";}
           if ($subcats>0) {$subcats=qq|<a href="$CONFIG{ad_url}&action=post&step=0&parent=$id"> $subcats subcategories</a>|;}
           else {$subcats="\&nbsp\;";}
           $checked=($id==$FORM{cat})?"checked":"";
           $html.=qq|<tr><td><input type=radio name=\'cat\' value=\'$id\' $checked></td><td>$name $desc</td><td>$subcats</td></tr>|;
    }
    return $html;
}
############################################################
sub BuildAdDelete{
	my($message) = @_;
	$message = $CONFIG{message} unless $message;
	return qq|
		<table border=0 cellpadding=1 cellspacing=0 width=100%>
  <tr> 
    <td align=center height="95"> <font face=arial><b>Are you sure you want to 
      delete this personal ad?</b></font><br>
      <font color="#FF0000"><b>$message </b></font><br>
      <form name="mojo" method="post" action="$CONFIG{ad_url}">
        <input type="hidden" name="type" value="ad">
        <input type="hidden" name="action" value="delete">
        <input type="hidden" name="step" value="final">
		   <input type="hidden" name="cat" value="$FORM{cat}">
          <input type="hidden" name="id" value="$FORM{id}">
        <br>
        <table width="500" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="246"> 
              <div align="center"> 
                <input type="submit" name="Submit" value=" Yes, Delete My Ad" style="background-color: #EBEBEB; font-family: Arial">
              </div>
            </td>
            <td width="24">&nbsp;</td>
            <td width="230"> 
              <input type="submit" name="cancel" value=" No, I've Changed My Mind " style="background-color: #EBEBEB; font-family: Arial">
            </td>
          </tr>
        </table>
      </form>
    </td>
  </tr>
</table>
	|;
}
############################################################
sub BuildAdError{
	return qq|$_[0]|;
}
############################################################
sub BuildAdGallery{
	require "gallery.pl";
	$FORM{username} = $MEMBER{username};
	return &BuildGalleryImages("$CONFIG{photo_path}/$MEMBER{username}", "radio", 4);
}
############################################################
sub BuildAdHiddenFields{
	my($step, $cat);
	($step) = @_;
    $cat = ($step == 0)?qq|<input type="hidden" name="oldcat" value="$FORM{cat}">|:qq|<input type="hidden" name="cat" value="$FORM{cat}">|;
    $FORM{action} = "edit" unless ($step <= 1);
    return qq|
      <input type="hidden" name="type" value="ad">
      <input type="hidden" name="action" value="$FORM{action}">
		$cat
      <input type="hidden" name="id" value="$FORM{id}">
      <input type="hidden" name="status" value="$FORM{status}">
      <input type="hidden" name="step" value="$step">
	|;
}
############################################################
sub BuildAdMenu{
	my($step, $step1, $step2, $step3, $step4, $steps, $preview);
	($step) = @_;
	if($FORM{action} eq "post" or $FORM{action} eq "edit"){
		if($FORM{action} eq "edit"){
            $step0 = ($step != 0)?qq|<font face=arial size="-1"><a href="$CONFIG{ad_url}&action=edit&step=0&cat=$FORM{cat}&status=$FORM{status}&id=$FORM{id}&inside=1">Choose Ad section</a></font>|:qq|<font face=arial size="-1">Choose Ad section</font>|;
            $step1 = ($step != 1)?qq|<font face=arial size="-1"><a href="$CONFIG{ad_url}&action=edit&step=1&cat=$FORM{cat}&status=$FORM{status}&id=$FORM{id}">Enter Basic Information</a></font>|:qq|<font face=arial size="-1">Enter Basic Information</font>|;
            $step2 = ($step != 2)?qq|<font face=arial size="-1"><a href="$CONFIG{ad_url}&action=edit&step=2&cat=$FORM{cat}&status=$FORM{status}&id=$FORM{id}">Enter Ad Description</a></font>|:qq|<font face=arial size="-1">Enter Ad Description</font>|;
            $step3 = ($step != 3)?qq|<font face=arial size="-1"><a href="$CONFIG{ad_url}&action=edit&step=3&cat=$FORM{cat}&status=$FORM{status}&id=$FORM{id}">Enter Detailed Information</a></font>|:qq|<font face=arial size="-1">Enter Detailed Information</font>|;
            $step4 = ($step != 4)?qq|<font face=arial size="-1"><a href="$CONFIG{ad_url}&action=edit&step=4&cat=$FORM{cat}&status=$FORM{status}&id=$FORM{id}">Upload Photo</a></font>|:qq|<font face=arial size="-1">Upload Photo</font>|;
            $step5 = ($step != 5)?qq|<font face=arial size="-1"><a href="$CONFIG{ad_url}&action=edit&step=5&cat=$FORM{cat}&status=$FORM{status}&id=$FORM{id}">Preview and Post Ad</a></font>|:qq|<font face=arial size="-1">Preview and Post Ad</font>|;
        }
        else{   
            $step0 = ($step >= 2)?qq|<font face=arial size="-1"><a href="$CONFIG{ad_url}&action=edit&step=0&cat=$FORM{cat}&status=$FORM{status}&id=$FORM{id}&inside=1">Choose Ad Section</a></font>|:qq|<font face=arial size="-1">Choose Ad Section</font>|;
            $step1 = ($step >= 2)?qq|<font face=arial size="-1"><a href="$CONFIG{ad_url}&action=edit&step=1&cat=$FORM{cat}&status=$FORM{status}&id=$FORM{id}">Enter Basic Information</a></font>|:qq|<font face=arial size="-1">Enter Basic Information</font>|;
            $step2 = ($step >= 3)?qq|<font face=arial size="-1"><a href="$CONFIG{ad_url}&action=edit&step=2&cat=$FORM{cat}&status=$FORM{status}&id=$FORM{id}">Enter Ad Description</a></font>|:qq|<font face=arial size="-1">Enter Ad Description</font>|;
            $step3 = (($step >= 2) and ($step != 3))?qq|<font face=arial size="-1"><a href="$CONFIG{ad_url}&action=edit&step=3&cat=$FORM{cat}&status=$FORM{status}&id=$FORM{id}">Enter Detailed Information</a></font>|:qq|<font face=arial size="-1">Enter Detailed Information</font>|;
            $step4 = (($step >= 2) and ($step != 4))?qq|<font face=arial size="-1"><a href="$CONFIG{ad_url}&action=edit&step=4&cat=$FORM{cat}&status=$FORM{status}&id=$FORM{id}">Upload Photo</a></font>|:qq|<font face=arial size="-1">Upload Photo</font>|;
            $step5 = (($step >= 2) and ($step != 5))?qq|<font face=arial size="-1"><a href="$CONFIG{ad_url}&action=edit&step=5&cat=$FORM{cat}&status=$FORM{status}&id=$FORM{id}">Preview and Post Ad</a></font>|:qq|<font face=arial size="-1">Preview and Post Ad</font>|;
		}
        $step=$step+1;
        return qq|
		<table border=0 cellpadding=3 cellspacing=0 width="150">
        <tr bgcolor="#cc99cc"><td><font face=arial color=white>&nbsp;<b> Step $step of 6</b></font></td></tr>
        <tr><td>$step0</td></tr>
  		<tr><td>$step1</td></tr>
  		<tr><td>$step2</td></tr>
  		<tr><td>$step3</td> </tr>
  		<tr><td>$step4</td></tr>
  		<tr><td>$step5</td></tr>
		</table>
		|;
	}
	else{
		return qq|
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
  		<tr><td><a href="$CONFIG{ad_url}">Ad main</a><br>
      <a href="$CONFIG{ad_url}&action=post">Post New Ad</a><br>
      <a href="$CONFIG{ad_url}&class=postedads">Posted Ads</a><br>
      <a href="$CONFIG{ad_url}&class=savedads">Saved Ads</a><br>
      <a href="$CONFIG{ad_url}&action=recount">Recount Ads</a><br>
      <a href="$CONFIG{search_url}&action=searchoptions">Search Ads</a><br>
      <a href="$CONFIG{ad_url}&action=faq#ads"> FAQs</a></td>
  		</tr>
		<tr><td>
      <hr width="100%" size="0">
    </td></tr>
	<tr><td><a href="$CONFIG{gallery_url}">Gallery</a></td></tr>
	<tr><td><a href="$CONFIG{mail_url}">Mailbox</a></td></tr>
		<tr><td><a href="$CONFIG{member_url}&action=profile">Profile</a></td></tr>
		</table>
		|;
	}
}
############################################################
sub BuildAdPosted{
	my($html, $message) = @_;
	$message = $CONFIG{message} unless $message;
	return qq|
	
<table border=1 cellpadding=0 cellspacing=0 width="90%" bordercolor="#EBEBEB" align="center">
  <tr bgcolor="#EBEBEB"> 
    <td colspan="5"> 
      <div align="center"><b><font color="#FF0000">$message</font></b></div>
    </td>
  </tr>
  <tr bgcolor="#EBEBEB"> 
    <td>&nbsp;</td>
    <td><font face=arial size="-1"><b>Ad Title</b></font></td>
    <td><font face=arial size="-1"><b>Options</b></font></td>
    <td><b>Views</b></td>
    <td><b>Replies</b></td>
  </tr>
  $html 
</table>
	|;
}
############################################################
sub BuildAdReply{
	my(%AD, %HTML);
	my($html, $message) = @_;
	$message = $CONFIG{message} if $CONFIG{message};
	$HTML{rules} = "<li>HTML code is not allowed</li>";
	%AD = &RetrieveAdDB($FORM{id});
	return qq|
<table border=0 cellpadding=3 cellspacing=0 width="100%">
  <tr> 
    <td valign=top height="390"> 
      <form method=post action="$CONFIG{ad_url}" name="mojo">
        <div align="center">
          <input type=hidden name="type" value="ad">
          <input type=hidden name="action" value="reply">
			 <input type=hidden name="cat" value="$FORM{cat}">
             <input type=hidden name="id" value="$FORM{id}">
          <input type=hidden name="step" value="final">
          <b><font color="#FF0000"> $message </font></b></div>
        <table border=0 cellpadding=1 cellspacing=1 width="100%">
       <!--   <tr> 
            <td align=right width="13%"><b><font size="2">Reply to</font><font size="2">:&nbsp;</font></b></td>
            <td width="87%"> 
              $AD{title}</td>
          </tr>-->
          <tr> 
            <td align=right width="13%"><b><font size="2">Subject:&nbsp;</font></b></td>
            <td width="87%"> 
              <input type=text name=subject value="Re: $AD{title}" size=60 maxlength=150>
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
sub BuildAdSaved{
	my($html, $message) = @_;
	$message = $CONFIG{message} if $CONFIG{message};
	return qq|

<table border=1 cellpadding=3 cellspacing=1 width="90%" bordercolor="#EBEBEB" align="center">
  <tr bgcolor="#EBEBEB"> 
    <td colspan="2"> 
      <div align="center"><b><font color="#FF0000">$message</font></b></div>
    </td>
  </tr>
  <tr bgcolor="#EBEBEB"> 
    <td><font face=arial size="-1"><b>Ad Title</b></font></td>
    <td align=center><font face=arial size="-1"><b>Options</b></font></td>
  </tr>
  $html 
</table>
	|;
}
############################################################
sub BuildAdSubtitle{
	my $title;
	if($FORM{action} eq "post"){			return "Post new ad";	}
	elsif($FORM{action} eq "edit"){		return "Edit ad";			}
	elsif($FORM{action} eq "delete"){	return "Delete ad";		}
	elsif($FORM{action} eq "recount"){	return "Recount ads";	}
	elsif($FORM{action} eq "reply"){		return "Reply ad";		}
	elsif($FORM{error}){						return "There is an error!";}

	elsif($FORM{class} eq "postedads"){	return "My posted ads";}
	elsif($FORM{class} eq "savedads"){	return "My saved ads";}
	return "";
}
############################################################
sub BuildAdTitle{			return "Ad center";						}
############################################################
1;
