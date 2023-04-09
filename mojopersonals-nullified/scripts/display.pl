############################################################
sub BuildAccounts{
	my($dir, @dirs, $html);
	@dirs = &Subdirectories($CONFIG{account_path});
	foreach $dir (@dirs){
		%ACCOUNT = &RetrieveAccountDB("$dir/account.pl");
		next unless ($ACCOUNT{ID});
		$html ="";
		if(-f "$dir/ibill.pl"){
			require "$dir/ibill.pl";
			$html =  qq|<li><a href="$ibill_cc?ACCOUNT=$ibill_account&REQTYPE=$ibill_reqtype&HELLOPAGE=$ibill_hellopage&LANGUAGE=$ibill_language&REF1=$MEMBER{username}&REF2=$MEMBER{password}&REF3=$ACCOUNT{ID}">iBill Credit Card</a></li>|;
			$html .= qq|<li><a href="$ibill_check?ACCOUNT=$ibill_account&REQTYPE=$ibill_reqtype&HELLOPAGE=$ibill_hellopage&LANGUAGE=$ibill_language&REF1=$MEMBER{username}&REF2=$MEMBER{password}&REF3=$ACCOUNT{ID}">iBill Checks</a></li>|;
		}
		if(-f "$dir/ibill900.pl"){
			require "$dir/ibill900.pl";
			$html = qq|<a href="">iBill Web900</a>&nbsp;|;
		}
		if(-f "$dir/paypal.pl"){
			require "$dir/paypal.pl";
			$html = qq|<a href="">Paypal</a>&nbsp;|;
		}
		if(-f "$dir/2checkout.pl"){
			require "$dir/2checkout.pl";
			$html = qq|<a href="">2checkout</a>&nbsp;|;
		}
		$MOJO{accounts} .= qq|<li>$ACCOUNT{description}</li><ul>$html</ul>|;
	}
}
############################################################
sub BuildAccountMenu{
	my(%ACCT, @acct, %DB, $default, $def_label, $dir, @dirs);
    ($default, $def_label) = @_;
	@dirs = &Subdirectories($CONFIG{account_path});
	foreach $dir(@dirs){
		%DB = &RetrieveAccountDB("$dir/account.pl");
		next unless ($DB{ID} and ($DB{ID} ne 'guest'));
		push(@acct, $DB{ID});
		if ($DB{ID} eq $CONFIG{default_account}) {$ACCT{$DB{ID}} = $DB{name}."\ (default)";}
		else {$ACCT{$DB{ID}} = $DB{name};}
	}
	if ($default){
		$FORM{account} = $default unless $FORM{account};
    }
	if($def_label){
		push(@acct, $default);
		$ACCT{$default} = $def_label;
	}
	$FORM{account} = $CONFIG{default_account} unless defined $FORM{account};
	$MOJO{account} = $Cgi->popup_menu("account", \@acct, $FORM{account}, \%ACCT);
	return $MOJO{account};
}
############################################################
sub BuildGalleryCount{
	my($ad, $found, $cat, %CAT, $dirs, $end, $item, $line, @lines);
	
	if($FORM{total} <= 0){
		return "";
	}
	elsif($FORM{total}){
		$start = ($FORM{offset} + 1);
		$end = ($FORM{offset}+ $FORM{lpp} < $FORM{total})? $FORM{offset}+ $FORM{lpp}:$FORM{total};
		$item = ($FORM{total} >1)? "files": "file";
        if($FORM{id} or $FORM{filename}){
			$MOJO{count} = qq|Displaying file $FORM{file} of $FORM{total}|;
		}
		else{
            $MOJO{count} = qq|$FORM{total} $item found. Displaying from $start to $end in $FORM{lpp} $item per page|;
		}
	}
	else{
		@lines = &RecursiveDirectoryFiles($CONFIG{data_path});
		@dirs = &RecursiveSubdirectories($CONFIG{data_path});
		$ad = @lines - @dirs; $ad = 0 if $ad <0;
		$MOJO{count} = qq|$ad available classifieds|;
	}	
	return $MOJO{count};
}
############################################################
sub BuildLocation {
   my ($cat, %CAT, $trace,$link);
  if ($FORM{type} eq 'search' && ($FORM{action} eq 'searchoptions')){
		 $link="$CONFIG{search_url}&action=searchoptions";
   }
   else {
		 $link="$CONFIG{program_url}";
   }
   $MOJO{location} = qq|<A HREF="$link">Top</A>|;
    $trace='';
    $cat=$FORM{cat};
    while ($cat>0){
        %CAT=&RetrieveCategoryDB($cat);
        $trace=qq| &gt; <A HREF="$link&cat=$cat&parent=$CAT{parent}">$CAT{name}</A>|.$trace;
        $cat=$CAT{parent};
    }
    $MOJO{location}.=$trace;
    if($FORM{id} ne ""){       $MOJO{location} .= qq| &gt; View Ad|;  }
	return  $MOJO{location};
}
############################################################
sub BuildMenuBox{
    my(%CAT, $cat, $list, $name, $id, $parent,$sth);
	if($_[0]){	$cat = shift;	}
    else{$cat = 0}
	$MOJO{menu}= qq|
		<script>function go(form){ location= form.cat.value;}</script>
		<form name=menu>
		<table border=0 cellspacing=0 cellpadding=1><tr><td>
		<select name="cat" onChange="go(this.form)">|;
        if($FORM{cat}>0 && $FORM{parent}==0){
			%CAT = &RetrieveCategoryDB($FORM{cat});
			$list .= qq|<br><option value="" selected> - $CAT{name}</option>|;
		}else{
			$list .= qq|<br><option value="" selected> --Select a category--</option>|;
		}
#    $parent=($CAT{parent}>0)?$CAT{parent}:0;
    $sth=runSQL("SELECT id, name FROM category WHERE parent=0
                 ORDER BY number");
    while (($id, $name)=$sth->fetchrow()){
        $list .= qq|\n<option value="$CONFIG{program_url}&cat=$id&offset=0&lpp=$FORM{lpp}"> - $name</option>|;
	} 
	$MOJO{menu} .= qq|$list</select></td></tr></table></form>|;
 	return $MOJO{menu};
}
############################################################
sub BuildNavigation {	return "";	}
############################################################
sub BuildNextPrevCategory{
	my($cat, @cats, %CAT, $compare, $data, $name,  $parent,$sth);
    $parent = ($FORM{parent}>0) ? $FORM{parent} : 0;
   $cat=$FORM{cat};
    $sth=runSQL("SELECT id, name FROM category WHERE parent=$parent
                 AND id<$cat ORDER BY number DESC LIMIT 1");
    $exist=$sth->rows();
    if ($exist) {
        ($id,$name)=$sth->fetchrow();
        $MOJO{prev_cat} =qq|<nobr>BACKWARD</nobr><br><a href="$CONFIG{program_url}&cat=$id&parent=$parent"><nobr>$name</nobr></a>|;
    }
    $sth=runSQL("SELECT id, name FROM category WHERE parent=$parent
                 AND id>$cat ORDER BY number LIMIT 1");
    $exist=$sth->rows();
    if ($exist) {
        ($id,$name)=$sth->fetchrow();
        $MOJO{next_cat} =qq|<nobr>FORWARD</nobr> <br><a href="$CONFIG{program_url}&cat=$id&parent=$parent"><nobr>$name</nobr></a>|;
    }
   return ($MOJO{prev_cat}, $MOJO{next_cat});
}
############################################################
sub BuildNextPrevFiles{
    my($link, $media, %MEDIA, @db, $db, %AD, @ad, $exist, $id,$sth,
    $username, $title,$parent,$order);
     unless ($FORM{id}>0) {$MOJO{prev_file}=$MOJO{next_file}=''; return;}
	 $order=$FORM{order};
	 $order='id' unless $order;
#    if($_[0]){  $line = shift;      @lines = @$line;}
#    else{           @lines = &DirectoryFiles($CONFIG{category_path});   }
#    return unless $FORM{adid};
#    
#    $FORM{total} = @lines - 1;
	$parent=($FORM{parent}>0)?$FORM{parent}:0;
	if($FORM{action} =~ /search|new|popular/){
		$link= "$CONFIG{search_url}&action=$FORM{action}&keywords=$FORM{keywords}&case=$FORM{case}&bool=$FORM{bool}";   #?
	}else{
        $link = qq|$CONFIG{program_url}&type=ad&action=view&cat=$FORM{cat}&parent=$parent|;
	}
#    @db=&DefineAdDB;
#    $db=join(', ',@db);
#    $username=$dbh->quote($MEMBER{username});
    $sth=runSQL("SELECT id, title FROM ads WHERE cat=$FORM{cat} AND
                 $order>$FORM{$order} AND status=\'active\' ORDER BY $order LIMIT 1");
    $exist=$sth->rows();
    if ($exist) {
        ($id, $title)=$sth->fetchrow();
        $MOJO{prev_file} =qq|Previous <br><a href="$link&id=$id">$title</a>|;
    }
    $sth=runSQL("SELECT id, title FROM ads WHERE cat=$FORM{cat} AND
                 $order<$FORM{$order} AND status=\'active\' ORDER BY $order DESC LIMIT 1");
    $exist=$sth->rows();
    if ($exist) {
        ($id, $title)=$sth->fetchrow();
        $MOJO{next_file} =qq|Next <br><a href="$link&id=$id">$title</a>|;
    }
   return ($MOJO{prev_file}, $MOJO{next_file});
}
############################################################
sub BuildPageLinks{
	my($files, $link, $line, @lines, $offset, $next_pages, $next_page, $prev_pages, $prev_page, 
		$pages, $searchlink, $total, $this_page,$parent);
		
	if ($FORM{id} or $FORM{total} <= 0){	return "";	}

	$this_page= int(($FORM{offset} / $FORM{lpp}) + 1);
	$offset = $FORM{offset};
	$parent=($FORM{parent}>0)?$FORM{parent}:0;
	if($FORM{action} =~ /search|new|popular/ ){ 	$link = &BuildSearchURL;	}
	else{		$link = qq|$CONFIG{program_url}&cat=$FORM{cat}&parent=$parent|;	}
##Build previous pages
	$count =1;
	for(my $i=0; $i < $offset; $i += $FORM{lpp}){
		$prev_pages .= qq|<br>| if ($count % 15 == 0);
		$prev_pages .= qq|&nbsp;<a href ="$link&offset=$i">$count</a>|;
		$count++;
	}
###skip the current number
	$count++;
	$offset += $FORM{lpp};
##ad next pages		
	for(my $i=$offset; $i < $FORM{total}; $i += $FORM{lpp}){
		$next_pages .= qq|<br>| if ($count % 15 == 0);
		$next_pages .= qq|&nbsp;<a href ="$link&offset=$i">$count</a>|;
		$count++;
	}
###For individual pages
	$next_page = $FORM{offset} + $FORM{lpp};
	if($next_page < $FORM{total}){	$next_page = qq|&nbsp;<a href ="$link&offset=$next_page">[Next \>\>]</a>|;	}
	else{										$next_page = qq||;		}
	$prev_page = $FORM{offset} - $FORM{lpp};
	if($prev_page >= 0){	$prev_page = qq|&nbsp;<a href ="$link&offset=$prev_page">[\<\< Prev]</a>|;	}
	else{						$prev_page = qq||;		}	
	
	$MOJO{page_link} = "$prev_page $prev_pages [$this_page] $next_pages $next_page";
	return $MOJO{page_link};
}
############################################################
sub BuildPageTitle{
	return $CONFIG{site_title};
}
############################################################
sub BuildSearchBox{
    my($cat, %CAT, @cats, $line, @lines, $list, $name, $parent, $menu);
    if($_[0]){  $cat = shift;}
    elsif ($FORM{cat}>0) {$cat=$FORM{cat};}
	else {$cat=0;}

	$MOJO{searchbox} .= qq|
		<form method="GET" action="$CONFIG{search_url}" name="search">
		<input type=hidden name="action" value="search">
		<input type=hidden name="offset" value="0">
		<table border=0 cellspacing=0 cellpadding=1><tr><td>
		<input type=text size=20 maxlength=35 name="keywords" value="$FORM{keywords}"></td>
        <td>|;

    $FORM{cat}=$cat;
    $menu=&BuildSearchCatMenu;
    $MOJO{searchbox}  .= qq|$menu</td>
	<td><input type=image src="$IMG{search}" border=0></td>
    <td><font size=-1><a href="$CONFIG{search_url}&action=searchoptions&cat=$cat">Advanced search</a></font></td></tr></table></form>
	|;
	return $MOJO{searchbox} ;
}
############################################################
sub BuildSearchCatMenu{
    my($cat, %CAT, @cats, $list, $name, $parent, $menu,$sth);
    $menu= qq|<select name=cat>|;
#	$MOJO{searchbox}  .= qq|<option value="all">- All Categories </option>|;
#    $CAT{parent}=0 unless $CAT{parent};
#    $parent=($FORM{parent}>0)?$FORM{parent}:0;
    $cat=($FORM{cat}>0)?$FORM{cat}:0;
   if ($cat>0) {
		%CAT = &RetrieveCategoryDB($cat);
        $menu.= qq|<option value="$cat" selected>$CAT{name}</option>|;
   }
   else {$menu.= qq|<option value="0" selected>ALL</option>|;}

    $sth=runSQL("SELECT id, name FROM category WHERE parent=$cat ORDER BY number");

    while (($id, $name)=$sth->fetchrow()){
        $menu.= qq|\n<option value="$id"> - $name</option> |;
	}  
    $menu.= qq| $list</select>|;
    return $menu;
}
############################################################
sub BuildSearchURL{
	my($db, @db, $URL);
    @db = &DefineAdDB;
    push @db, "adid";
	$URL = qq|$CONFIG{search_url}&action=$FORM{action}&minage=$FORM{minage}&maxage=$FORM{maxage}&photo=$FORM{photo}&keywords=$FORM{keywords}|;
    foreach $db(@db){
		$URL .= qq|&$db=$FORM{$db}|;
	}
	return $URL;
}
############################################################
sub BuildTitle{
	my($cat, %CAT);
    %CAT = &RetrieveCategoryDB($FORM{cat});
	if($CAT{name}){	$cat = $CAT{name};	}
	else{			      $cat= &FormatDisplay(&LastDirectory($FORM{cat}));	}

	if($FORM{action} eq "search"){		$MOJO{title} = qq|Search results|;	}
	elsif($FORM{action} eq "new"){		$MOJO{title} = qq|New ads for the last $FORM{daysnew} days|;	}
	elsif($FORM{action} eq "popular"){	$MOJO{title} = qq|Popular Ads|;					}
	elsif($FORM{action} eq "post"){		$MOJO{title} = qq|Post New Ad|;					}
	elsif($FORM{action} eq "reply"){		$MOJO{title} = qq|Relpy to an ad|;				}
	elsif($FORM{action} eq "save"){		$MOJO{title} = qq|Save an Ad|;						}
	elsif($FORM{cat} and $FORM{filename}){	$MOJO{title} = qq|$cat ($FORM{filename})|;	}
    elsif($FORM{cat} and $FORM{id}){      $MOJO{title} = qq|$cat ($FORM{id})|;              }
	elsif($FORM{cat}){						$MOJO{title} = qq|$cat|;								}

	elsif($FORM{type} eq "mailbox"){		$MOJO{title} = qq|$MEMBER{username} Mailbox|;				}
	elsif($FORM{type} eq "personal"){
		if($FORM{class} eq "myads"){ 		$MOJO{title} = qq|$MEMBER{username}\'s Posted Ads|;		}
		elsif($FORM{class} eq "savedads"){$MOJO{title} = qq|$MEMBER{username}\'s Saved Ads|;		}	
		else{										$MOJO{title} = qq|"$MEMBER{username}\'s Personal Home|;}
	}
	else{							$MOJO{title} = qq|Categories|;		}
	return $MOJO{title};
}
############################################################
sub BuildUserOptions{
	my($name, $logio, $popular,$upgr);
	if($MEMBER{'username'}){
		$name = $MEMBER{'username'};
		$logio = qq|<a href="$CONFIG{member_url}&action=logout">Logout</a>|;
	}
	else{
		$name = qq|Guest (<a href="$CONFIG{member_url}&action=register"><font size=2>register</font></a>)|;
		$logio= qq|<a href="$CONFIG{member_url}&action=login">Login</a>|;
	}
#	if($FORM{cat}){	$popular = qq|<a href="$CONFIG{search_url}&action=popular&cat=$FORM{cat}">Popular</a> - |;	}

	$upgr=($CONFIG{paysite})?qq|- <a href="$CONFIG{member_url}&action=upgrade"> Account upgrade </a>|:"";
	return qq|
<table border=0 cellpadding=4 cellspacing=0 width=100%>
  <tr> 
    <td valign=top width="161" align=left><font face=arial size=-1><b> Hello, 
      $name</b></font></td>
    <td align=right valign=top> <a href="$CONFIG{program_url}&action=browse"><font face="arial" size="-1">Browse</font></a> 
      - <a href="$CONFIG{search_url}&action=searchoptions"><font face="arial" size="-1">Search</font></a> - <a href="$CONFIG{search_url}&action=new&cat=$FORM{cat}"><font face=arial size=-1>New</font></a> 
      - $popular<a href="$CONFIG{member_url}&action=panel"><font face=arial size=-1>User 
      Control Panel</font></a> &nbsp;$upgr- <font face="arial" size="-1">$logio</font> </td>
  </tr>
</table>
  |;
}
############################################################


############################################################
#              How  Categories display depends on this
############################################################
sub BuildSubcategories{
    my($half, $html, $html_category, $name, $template, $cat, @db,
    $db, @cat_data, %CAT, $exist, $noempty,$sth);
	$template = &FileRead($TEMPLATE{cat1});
#    $subs = ($CONFIG{data_path} eq $CONFIG{category_path})?0:1;
    $cat=($FORM{cat}>0)?$FORM{cat}:0;

    $noempty=' AND ads>0' unless ((($MEMBER{username} && $MEMBER{P_show_empty_subs}) or (not $MEMBER{username}))&& $CONFIG{show_empty_subs});
	@db=&DefineCategoryDB;
    $db=join(', ',@db);
    $sth=runSQL("SELECT $db FROM category WHERE parent=$cat $noempty
                 ORDER BY number");
    $exist=$sth->rows();
    return unless $exist;
    while (@cat_data=$sth->fetchrow()){
          for (my $i=0; $i <@db; $i++){$CAT{$db[$i]}=$cat_data[$i]};
        $CAT{new}= ($CAT{date_create}>(&TimeNow-$CONFIG{daysnew}*3600*24))?qq|<img src="$IMG{new}" border=0 alt="$TXT{new}">|:'';
        if($CAT{ricon}){  $CAT{icon_url} = qq|<img src="$CAT{ricon}" border=0 align="right">|;                  }
        elsif($CAT{icon}){$CAT{icon_url} = qq|<img src="$CONFIG{image_url}/$CAT{icon}" border=0 align="right">|;    }
        $CAT{link} = qq|$CONFIG{program_url}&cat=$CAT{id}&parent=$CAT{parent}|;
        $html[$count++] = &ParseCatTemplate($template, \%CAT);
        undef %CAT;
    }
    $half= int (($#html + 2 ) / $CONFIG{catlayout}) if $CONFIG{catlayout};
    for(my $i=0; $i< @html; $i++){
    if ($i eq $half and $TABLE{cat_cols}){  $html_category .= qq|</td><td valign="top">|;       }
        $html_category .=qq|$html[$i]|;
   }
	if($html_category){
		$MOJO{cats} =qq|<table width="$TABLE{cat_width}" border="$TABLE{cat_border}" cellspacing="$TABLE{cat_cellspacing}" cellpadding="$TABLE{cat_cellpadding}" bgcolor="$TABLE{cat_bgcolor}" bordercolor="$TABLE{cat_bordercolor}"><tr><td>|;
		$MOJO{cats} .=qq|$html_category</td></tr></table>|;
	}
#	$MOJO{cats} .= "<br><br>@dirs<br>[@html]";
}
############################################################
sub BuildCategoryAds{
    my(@db,$db, $template,$start,$end, @ad, %AD, $num,$sth);
    @db=&DefineAdDB;
    $db=join(', ',@db);
    $template = $TEMPLATE{ad1};
	$template = &FileRead($template) if (-f $template);
    unless ($FORM{total}>0){
        $sth=runSQL("SELECT COUNT(*) FROM ads WHERE cat=$FORM{cat} AND
                     status=\'active\'");
        $FORM{total} = $sth->fetchrow();
    }
	$start = ($FORM{offset}> 0)? $FORM{offset}: 0;
	$end = ($start + $FORM{lpp} > $FORM{total})? $FORM{total}:$start + $FORM{lpp};
    $sth=runSQL("SELECT $db FROM ads WHERE cat=$FORM{cat} AND
                 status=\'active\' ORDER BY date_create DESC LIMIT $start, $FORM{lpp}");

    $num=$start;
    while (@ad=$sth->fetchrow()){
        for (my $i=0; $i <@db; $i++){$AD{$db[$i]}=$ad[$i]};
        $FORM{file} = $num+1;
        %P = &RetrievePhotoDB("$CONFIG{photo_path}/$AD{username}/$AD{image}", "$CONFIG{ad_url}&action=view_image&cat=$AD{cat}&id=$AD{id}&image=1");
        $AD{image_url}= $P{images_url};
        $AD{thumbnail}= $P{thumbnail};
        $AD{date_create}=&FormatTime($AD{date_create});
        $MOJO{ads} .= &ParseAdTemplate($template, \%AD);
        $num++;
	}
	unless($MOJO{ads} or $MOJO{cats}){
		$MOJO{ads} =qq|<h2>No Matches Found</h2>
      <BLOCKQUOTE>
  			We're sorry, but it appears that there were no ads in the database
  			that matched your search criteria.  Please go back and try again.
  		</BLOCKQUOTE>|;	
	}
}

############################################################
1;
