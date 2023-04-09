############################################################
sub GatewayMain{
	&GatewayDisplay;
}
############################################################
sub GatewayLinks{
	my ($gateway_path, $html);
	my ($gateway, $account) = @_;
	$gateway_path = $account?"$CONFIG{account_path}/$account":$CONFIG{account_path};
	if (-f "$CONFIG{script_path}/$gateway.$CONFIG{script_ext}"){
		my $display = (-f "$gateway_path/$gateway.pl")?"<font color='red' size=2>$gateway</font>":"<font size=2><s>$gateway</s></font>";
		$html =qq|&nbsp;<a href="$CONFIG{admin_url}?type=$gateway&account=$account&action=setup">$display</a>&nbsp;|;
	}
	if($gateway eq "ibill" and -f "$CONFIG{script_path}/$gateway.$CONFIG{script_ext}"){
		my $display = (-f "$gateway_path/web900.pl")?"<font color='red' size=2>Web900</font>":"<font size=2><s>Web900</s></font>";
		$html .=qq|&nbsp;<a href="$CONFIG{admin_url}?type=$gateway&account=$account&action=web900">$display</a>&nbsp;|;
	}
	return $html;
}
############################################################
sub GatewayDisplay{
	my($account, $cc, $gateway, @gateways, $html, $style);
	($account, $style) = @_;
	@gateways = &GatewayAvailable;
	foreach $gateway (@gateways){
		$cc = &GatewayLinks($gateway, $account);
		if($style){	$html .= qq|$cc&nbsp;|;	}
		else{			$html .= qq|<li>$cc</li>|;		}
	}
	unless($html){	$html = qq|<font size=2>No credit card module available</font>|;	}
	return $html;
}
############################################################
sub PrintGateway{
	my ($html) = @_;
	&PrintMojoHeader;
	print qq|
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="79"> 
      <table border="0" width="601" cellspacing="1" cellpadding="4" bgcolor="#6394BD" class="bordercolor" align="center">
        <tr> 
          <td class="titlebg" bgcolor="#EBEBEB" height="6"> <font size=2 class="text1" color="#FFFFFF"><b><font size=2 class="text1" color="#FFFFFF"><b><font color="#0000FF">Available 
            gateways to work with</font></b></font></b></font></td>
        </tr>
        <tr> 
          <td class="titlebg" bgcolor="#EEEEEE" height="29"> 
            <div align="center"><b><font color="#FF0000">$message</font></b></div>
          </td>
        </tr>
        <tr> 
          <td class="titlebg" bgcolor="#EEEEEE" height="43" valign="top"> $html 
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
1;