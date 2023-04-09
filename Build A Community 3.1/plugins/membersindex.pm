sub MI_BACKGOUND {
	return $CWMI{'background'};
}

sub MI_BGCOLOR {
	return $CWMI{'bgcolor'};
}

sub MI_TEXT {
	return $CWMI{'textcolor'};
}

sub MI_LINKC {
	return $CWMI{'linkc'};
}

sub MI_VLINK {
	return $CWMI{'vlinkc'};
}

sub MI_TITLE {
	return $CWMI{'title'};
}

sub MI_LINKS {
	my $LINKS_LINE = undef;
	$CWMI{'Link_Url_1'} = &complete_url($CWMI{'Link_Url_1'});
	$CWMI{'Link_Url_2'} = &complete_url($CWMI{'Link_Url_2'});
	$CWMI{'Link_Url_3'} = &complete_url($CWMI{'Link_Url_3'});
	$CWMI{'Link_Url_4'} = &complete_url($CWMI{'Link_Url_4'});
	$CWMI{'Link_Url_5'} = &complete_url($CWMI{'Link_Url_5'});
	$CWMI{'Link_Url_6'} = &complete_url($CWMI{'Link_Url_6'});
	$CWMI{'Link_Url_7'} = &complete_url($CWMI{'Link_Url_7'});
	$CWMI{'Link_Url_8'} = &complete_url($CWMI{'Link_Url_8'});
	$CWMI{'Link_Url_9'} = &complete_url($CWMI{'Link_Url_9'});
	$CWMI{'Link_Url_10'} = &complete_url($CWMI{'Link_Url_10'});

	if ($CWMI{'Link_Text_1'} ne "") {$LINKS_LINE .= "<A HREF=\"$CWMI{'Link_Url_1'}\">$CWMI{'Link_Text_1'}</A> ";}
	if ($CWMI{'Link_Text_2'} ne "") {$LINKS_LINE .= " | <A HREF=\"$CWMI{'Link_Url_2'}\">$CWMI{'Link_Text_2'}</A> ";}
	if ($CWMI{'Link_Text_3'} ne "") {$LINKS_LINE .= " | <A HREF=\"$CWMI{'Link_Url_3'}\">$CWMI{'Link_Text_3'}</A> ";}
	if ($CWMI{'Link_Text_4'} ne "") {$LINKS_LINE .= " | <A HREF=\"$CWMI{'Link_Url_4'}\">$CWMI{'Link_Text_4'}</A> ";}
	if ($CWMI{'Link_Text_5'} ne "") {$LINKS_LINE .= " | <A HREF=\"$CWMI{'Link_Url_5'}\">$CWMI{'Link_Text_5'}</A> ";}
	if ($CWMI{'Link_Text_6'} ne "") {$LINKS_LINE .= " | <A HREF=\"$CWMI{'Link_Url_6'}\">$CWMI{'Link_Text_6'}</A> ";}
	if ($CWMI{'Link_Text_7'} ne "") {$LINKS_LINE .= " | <A HREF=\"$CWMI{'Link_Url_7'}\">$CWMI{'Link_Text_7'}</A> ";}
	if ($CWMI{'Link_Text_8'} ne "") {$LINKS_LINE .= " | <A HREF=\"$CWMI{'Link_Url_8'}\">$CWMI{'Link_Text_8'}</A> ";}
	if ($CWMI{'Link_Text_9'} ne "") {$LINKS_LINE .= " | <A HREF=\"$CWMI{'Link_Url_9'}\">$CWMI{'Link_Text_9'}</A> ";}
	if ($CWMI{'Link_Text_10'} ne "") {$LINKS_LINE .= " | <A HREF=\"$CWMI{'Link_Url_10'}\">$CWMI{'Link_Text_10'}</A>";}

	return $LINKS_LINE;
}




1;
