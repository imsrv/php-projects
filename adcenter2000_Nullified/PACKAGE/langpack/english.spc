if ($totalbanner>1){$i=0;$spots=qq~<form action="$cgi/adcstat.pl" method=post><table><tr><td><input type=hidden name=name value=$data{name}><input type=hidden name=password value=$data{password}><input type=hidden name=method value=$data{method}><input type=hidden name=lang value=$data{lang}><select name=spot>~;while($i<$totalbanner){$spots.=qq~<option $selected{$i} value="$i">$i ($banwidth[$i] x $banheight[$i])</option>~;$i++;}$spots.=qq~</select></td><td><input type=image border=0 src="$adcenter/images/$data{lang}/getcode.gif"></td></tr></table></form>\n~;}