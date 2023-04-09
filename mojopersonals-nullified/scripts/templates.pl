############################################################
sub ErrorTemplate{
	my($message) = shift;
	if($message){
		return qq|
		<table border=0 cellpadding=1 cellspacing=0 width="400"100%"">
  		<tr><td height=8></td></tr>
  		<tr><td bgcolor="CC0000" align=center height="24"> 
      	<table border=0 cellpadding=10 cellspacing=0 width="100%">
        	<tr bgcolor="#ffffcc"><td height="9" width="6%">&nbsp;</td>
          <td height="9" width="94%"><b>Please correct these errors:</b><br><font face="Tahoma" size="2" color="#FF0000">$message</color></td></tr>
      	</table>
		</table>
		|;
	} else{ return "";	}
}
############################################################
sub NotifyEmailTemplate{
	my $mem = shift;
	my %MEMBER = %$mem;
	$CONFIG{html} = "on";
	return qq|
	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr> 
      <td colspan="2">Hello $MEMBER{fname} $MEMBER{lname}</td>
    </tr>
    <tr> 
      <td width="3%">&nbsp;</td>
      <td width="97%">
        <p>You have new mail at $CONFIG{site_title}<br>
          To view your mail, click on the link below:<br>
          <a href="$CONFIG{mail_url}&username=$MEMBER{username}&password=$MEMBER{password}">$CONFIG{program_url}</a> </p>
        <p>Thank you<br>
          $CONFIG{myname}<br>
          P.S To disable new mail notifications, please click on this link: <a href="$CONFIG{mail_url}&username=$MEMBER{username}&password=$MEMBER{password}&action=notify">Disable 
          new mail notifications</a></p>
      </td>
    </tr>
    <tr> 
      <td width="3%">&nbsp;</td>
      <td width="97%">&nbsp;</td>
    </tr>
  </table>
	|;
}
sub NewAdTemplate{
	my ($ad) = @_; my %AD = %$ad; my $action = $AD{updated}?"updated an":"posted a new";
	return qq|<p><a href="$CONFIG{admin_url}?type=member&action=detail&username=$MEMBER{username}">$MEMBER{username}</a> has just $action <a href="$CONFIG{ad_url}&action=view&adid=$FORM{adid}">ad.</a></p>
<p>If  you have turned on the "manually ad approval" feature then you can <a href="$CONFIG{admin_url}?type=ad&cat=$AD{cat}&class=pending">approve</a> this ad in the admin area (after you have logged on).</p>
	|;
}
############################################################

1;