############################################################
sub CategoryMain{
	use vars qw($message);
	if($FORM{action} eq "add"){				&CatAdd;							}
    elsif($FORM{action} eq "edit"){         &CatEdit;                       }
	elsif($FORM{action} eq "delete"){		&CatDelete;						}
	elsif($FORM{action} eq "reorder"){		&CatReorder;					}
    elsif($FORM{action} eq "create_country"){   &CreateCountryDB;           }
	elsif($FORM{action} eq "create_state"){	&CreateStateDB;			}
#    elsif($FORM{action} eq "create_subcategory"){ &CreateSubcategory;         }
	elsif($FORM{action} eq "create_canada_state"){	&CreateStateDB;	}
    &CatDisplay;
}
############################################################
sub RedefineVar{
	&BuildAdminLocation;
	&CatDisplay(@_);
}
############################################################
sub CatAdd{
	my($message);
	
	if($FORM{cancel}){		$message	= $mj{cancel};		}
	elsif($FORM{step} eq "final"){
		&CheckAdminPermission("cat", "add");
#        $message = &CheckCatAddInput;
#        &PrintCatAdd($message) if $message;
        &AddCategoryDB(\%FORM);
		$message = $mj{success};
	}
    else{   &PrintCatAdd;   }
	&RedefineVar($message);
}

############################################################
sub CatEdit{
    my($message);
    
    if($FORM{cancel}){      $message = $mj{cancel};     }
    elsif($FORM{step} eq "final"){
        &CheckAdminPermission("cat", "edit");
        $message = &CheckCatEditInput;
        &PrintCatEdit($message) if $message;
        &UpdateCategoryDB(\%FORM);
        $message = $mj{success};    
    }
    else{   &PrintCatEdit;  }
    &RedefineVar($message);
}
############################################################
sub CatDelete{
    my($message,@selectedid);
	
	if($FORM{cancel}){		$message = $mj{cancel};		}
	elsif($FORM{step} eq "final"){
		&CheckAdminPermission("cat", "delete");
        @selectedid = $Cgi->param('cat');
        &DeleteCategoryDB(\@selectedid);
		$message = $mj{success};	
	}
    else{
        @selectedid = $Cgi->param('cat');
        &PrintCatDelete("",\@selectedid);
    }
    &RedefineVar($message);
}
############################################################
sub CatReorder{
    my($cat1, $cat2,$message,$sth,%CAT,$order,$i,$number2);
    &CheckAdminPermission("cat", "reorder");
    $cat1=$FORM{cat};
    %CAT=&RetrieveCategoryDB($cat1);
    $i=($FORM{gain}>0) ? $FORM{gain} : -$FORM{gain};
    $i=$i-1;
    if ($FORM{gain}>0) {$order="number>$CAT{number} ORDER BY number ASC";}
    else {$order="number<$CAT{number} ORDER BY number DESC";}
    $sth=runSQL("SELECT id, number FROM category WHERE parent=$CAT{parent}
                 AND $order LIMIT $i, 1");
   ($cat2,$number2)=$sth->fetchrow();
   $sth=runSQL("UPDATE category SET number=$CAT{number} WHERE
                id=$cat2");
   $sth=runSQL("UPDATE category SET number=$number2
                WHERE id=$cat1");
    $FORM{parent}=$CAT{parent};
    $message = $mj{success};
    &CatDisplay($message);
}
############################################################
sub CatDisplay{
#    my( $ads, $country, $active, $pending, $cat, @cats, $html, $ID,
#    $line, @lines, $ptr, $path, $state, $subcats, @temp);
#    @cats = &Subdirectories($CONFIG{category_path});
    my( @db, $db, @cat_data, $rows, $active, $pending, $states,
        $state, $subcats, $where, $actions,$sth,$sth1,$status,$number,%ADS,
       $count,$total,$prev,$nex);
    @db= &DefineCategoryDB;
    $db=join(', ',@db);
    $FORM{parent}=($FORM{parent}>0) ? $FORM{parent} : 0;
    $sth=runSQL("SELECT $db FROM category WHERE parent=$FORM{parent} ORDER BY number");
    $total=$sth->rows();
    $count=1;
    while (@cat_data=$sth->fetchrow()){
        for (my $i=0; $i <@db; $i++){$CAT{$db[$i]}=$cat_data[$i]};
        if($CAT{ricon}){ $CAT{icon_url} = qq|<img src="$CAT{ricon}" border=0 align="right">|;}
        elsif($CAT{icon}){ $CAT{icon_url} = qq|<img src="$CONFIG{image_url}/$CAT{icon}" border=0 align="right">|;}
        $ID = $CAT{id};
#        $subcats = $CAT{subcats};
        if ($CAT{subcats}>0) { $ads = qq|<a href="$CONFIG{admin_url}?type=cat&parent=$ID">$CAT{subcats} subcategories</a><br>|;        }
		else{ $ads='';}
        $sth1=runSQL("SELECT status, COUNT(*) FROM ads WHERE
                     cat=$CAT{id} GROUP BY status");
        while (($status,$number)=$sth1->fetchrow()){
                   $ADS{$status}=$number;
		}
		$ADS{active}=0 unless $ADS{active};
        $ADS{pending}=0 unless $ADS{pending};
        $ads.= qq|<a href="$CONFIG{admin_url}?type=ad&cat=$ID&class=active">$TXT{active} </a> ($ADS{active})\| <a href="$CONFIG{admin_url}?type=ad&cat=$ID&class=pending">$TXT{pending}</a> ($ADS{pending})|;
		undef %ADS;
##options to create the states		

        $actions= qq|Create: <a href="$CONFIG{admin_url}?type=cat&action=add&parent=$ID"><font size=2>New subcategory</font></a>|;
        if ($CAT{countries}>0 or $CAT{states}>0){ $country ="";}
        else{   $country = qq|<a href="$CONFIG{admin_url}?type=cat&action=create_country&cat=$ID"><font size=2>Countries</font></a>|;    }
        $states=$CAT{states};
        if ((($CAT{states}>0) or ($CAT{countries}>0)) and not ($CAT{states}==0 and $CAT{name} =~ /united\s*states/i)) {$state=''}
        else {$state = qq|<a href="$CONFIG{admin_url}?type=cat&action=create_state&cat=$ID"><font size=2>US states</font></a>|;} 
#		if ($ID =~ /canada$/i or not $FORM{cat}){ 	$state2 = qq|<a href="$CONFIG{admin_url}?type=cat&action=create_canada_state&cat=$ID"><font size=2>Canada states</font></a>|;	}
#		else{								$state2 ="";	}
		if($country or $state or $state2){
            $actions.= qq| $country $state $state2|;}

        if ($count != 1) {$prev=qq|<a href="$CONFIG{admin_url}?type=cat&cat=$ID&action=reorder&gain=-1"><font size=2>move up</font></a>|;}
        else {$prev=qq|<font size=2>move up</font>|;}
        if ($count != $total) {$next=qq|<a href="$CONFIG{admin_url}?type=cat&cat=$ID&action=reorder&gain=1"><font size=2>move down</font></a>|;}
        else {$next=qq|<font size=2>move down</font>|;}
        $count++;

        $html.=qq|<tr><td><input type=checkbox name='cat' value="$ID"></td>
		     <td><div>$CAT{icon_url}</div>
            <b>$CAT{name}</b><br>$CAT{description}</td>
			<td>$ads</td>
            <td><a href="$CONFIG{admin_url}?type=cat&action=edit&cat=$ID&parent=$CAT{parent}">$TXT{edit}</a>
                <a href="$CONFIG{admin_url}?type=cat&action=delete&cat=$ID&parent=$CAT{parent}">$TXT{delete}</a>
                <br> $actions
                 </td>
            <td>$prev<br>$next
              </td>
			</tr>|;
		 undef %CAT;
    }
	$html = qq|<tr><td colspan=3 align=center>$mj{cat40}| unless $html;
	&PrintCatDisplay($html, $message);			
}

############################################################
sub CreateCountryDB{
    my($country, @countries, $field, %FIELD, @lines, $name,%CAT);
    &CheckAdminPermission("cat", "add");
    
   $CAT{parent}=$FORM{cat};
    $CAT{date_create}=  &TimeNow;
    $CAT{date_end}=     &TimeNow + 10* 365 * 24 * 60 *60;
    $CAT{icon} = $CAT{ricon}="";
    $CAT{post} = qq|1|;
	$CAT{countries}='1';
    $CAT{states}='0';
    @lines = &FileRead($CONFIG{ad_fields});
    foreach (@lines){
        %FIELD = &RetrieveFieldDB($_);
        next unless $FIELD{ID} eq "country";
        @countries = split(/\;\s*/, $FIELD{choices});
        foreach $name (@countries){
#            ($country = $name) =~ s/\s+/_/g;
            $CAT{name} = $name;
            &AddCategoryDB(\%CAT);
        }
        last;
    }
    undef %CAT;
    $CAT{id}=$FORM{cat};
    $CAT{countries}='1';
    $CAT{states}='1';
    &UpdateCategoryDB(\%CAT);
    $FORM{parent}=$FORM{cat};
}
###############################################################
sub CreateStateDB{
	my(%CAT, $field, %FIELD, $location, @lines, $name,  $state, %STATE, @state);
	&CheckAdminPermission("cat", "add");

   $CAT{parent}=$FORM{cat};
	$CAT{date_create}=  &TimeNow;
	$CAT{date_end}=     &TimeNow + 10* 365 * 24 * 60 *60;
	$CAT{icon} = $CAT{ricon}="";
	$CAT{post} = qq|1|;
	$CAT{countries}='1';
	$CAT{states}='1';
    @lines = &FileRead($CONFIG{ad_fields});
	foreach (@lines){
		%FIELD = &RetrieveFieldDB($_);
		if($FORM{action} eq "create_canada_state"){	next unless $FIELD{ID} eq "state3";	}
		else{	next unless $FIELD{ID} eq "state";	}
		@state = split(/\;\s*/, $FIELD{choices});
		foreach $name (@state){
			next unless $name =~ /^[\w\s\.]+$/;
			($state = $name) =~ s/\s+/_/g;
			$state = lc($state);
			$CAT{name} = $name;
            &AddCategoryDB(\%CAT);
		}
		last;
    }
    undef %CAT;
    $CAT{id}=$FORM{cat};
    $CAT{countries}='1';
    $CAT{states}='1';
    &UpdateCategoryDB(\%CAT);
    $FORM{parent}=$FORM{cat};
}
###############################################################





################################################################
sub CheckCatEditInput{
	my $message="";
#    $message .="<li>$mj{cat4}</li>" unless ($FORM{ID} =~ /^[0-9A-Za-z\-\_\/]+$/);
	$message .="<li>$mj{cat7}</li>" unless $FORM{name};
#	$message .="<li>Please enter a description for your category</li>" unless $FORM{'description'};
#	$message .="<li>Category description contains database characters </li>" if ($FORM{'description'}=~ /\|/g);
	if($FORM{no_icon}){	$FORM{icon} = $FORM{r_icon} = "";	}
	return $message;
}
############################################################
sub PrintCatDisplay{
	my(%HTML, $message);
	($html, $message) = @_;
	 $FORM{parent}=$FORM{parent}?$FORM{parent}:0;
    $add_link = qq|<a href="$CONFIG{admin_url}?type=cat&parent=$FORM{parent}&action=add">$mj{cat30}</a>|;
	&PrintMojoHeader;
	print qq|
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="56">
  <tr> 
    <td height="70"> <br>
        <form action="$CONFIG{admin_url}">
          <input type="hidden" name="type" value="cat">
          <input type="hidden" name="parent" value=$FORM{parent}>
          <input type="hidden" name="action" value="delete">
        <table border="0" width="601" cellspacing="1" cellpadding="4" bgcolor="#6394BD" class="bordercolor" align="center">
          <tr> 
            <td class="titlebg" bgcolor="#EBEBEB" height="6"> &nbsp;<font size=2 class="text1" color="#FFFFFF"><b><font color="#0000FF">$mj{cat}</font></b></font></td>
          </tr>
          <tr> 
            <td class="titlebg" bgcolor="#EEEEEE" height="29"> 
              <div align="center"><b><font color="#FF0000">$message</font></b></div>
            </td>
          </tr>
          <tr> 
            <td class="titlebg" bgcolor="#EEEEEE" height="51" valign="top">
              <table width="100%" border="0" cellspacing="0" cellpadding="2">
                <tr> 
                  <td>&nbsp;</td>
                  <td><b><font face="Tahoma" color="#000000">Category 
                    Name</font></b></td>
                  <td width="30%"><b><font face="Tahoma" color="#000000">Ads</font></b></td>
                  <td width="24%"><b><font face="Tahoma" color="#000000">Actions</font></b></td>
                  <td width="13%">&nbsp;</td>
                </tr>
                $html 
              </table>
            </td>
          </tr>
          <tr> 
            <td bgcolor="#EBEBEB" height="2"> 
              <div align="center"><input type="submit" value="Delete checked categories"> $add_link </div>
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
############################################################
sub PrintCatAdd{		&PrintCatMiddle(@_);		}
############################################################
sub PrintCatEdit{       &PrintCatMiddle(@_);        }
############################################################
sub PrintCatDelete{
    my($cat, %CAT, $message, $ptr,$deleted,@deleted);
    ($message,$deleted) = @_;
    @deleted=@$deleted;
    $deleted=join('',map(qq|<input type="hidden" name="cat" value="$_">|,@deleted));
#    %CAT = &RetrieveCategoryDB($CONFIG{category_db});
#    foreach (keys %CAT){    $FORM{$_} = $CAT{$_} unless $FORM{$_};  }
	&PrintMojoHeader;
	print qq|
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="119"> <br>
      <form name="mojo" method="post" action="$CONFIG{admin_url}">
        <input type="hidden" name="type" value="cat">
        <input type="hidden" name="parent" value="$FORM{parent}">
         $deleted
<!--        <input type="hidden" name="ID" value="$FORM{ID}"> -->
        <input type="hidden" name="action" value="delete">
        <input type="hidden" name="step" value="final">
        <table border="0" width="601" cellspacing="1" cellpadding="4" bgcolor="#6394BD" class="bordercolor" align="center">

         <tr> 
            <td class="titlebg" bgcolor="#EBEBEB" height="6"> &nbsp;<font size=2 class="text1" color="#FFFFFF"><b><font color="#0000FF">$mj{cat36}: 
              </font></b><font face="Tahoma" color="#000000">$FORM{name}</font><font color="#000000"> 
              </font></font></td>
          </tr>
          <tr> 
            <td class="titlebg" bgcolor="#EEEEEE" height="29"> 
              <div align="center"><b><font color="#FF0000">$mj{cat37}<br>
                </font></b></div>
            </td>
          </tr>
          <tr> 
            <td class="titlebg" bgcolor="#EEEEEE" height="49" valign="top"> 
              <div align="center"> 
                <input type="submit" name="submit" value="$TXT{delete}">
                <input type="submit" name="cancel" value="$TXT{cancel}">
              </div>
            </td>
          </tr>
          <tr> 
            <td bgcolor="#EBEBEB" height="2"> 
              <div align="center"></div>
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
############################################################
sub PrintCatReorder{
	my(@dirs, $message);
	($message) = @_;
	$message = $mj{cat18} unless $message;
	if (-f $CONFIG{category_order}){		$FORM{cats} = &FileRead($CONFIG{category_order});	}
	unless($FORM{cats}){
		@dirs= &Subdirectories($CONFIG{category_path}, 1);
	 	$FORM{cats} = join("\n", @dirs);
	}
	&PrintMojoHeader;
	print qq|
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="119"> <br>
      <form name="mojo" method="post" action="$CONFIG{admin_url}">
        <input type="hidden" name="type" value="cat">
		  <input type="hidden" name="cat" value="$FORM{cat}">
        <input type="hidden" name="action" value="reorder">
        <input type="hidden" name="step" value="final">
        <table border="0" width="601" cellspacing="1" cellpadding="4" bgcolor="#6394BD" class="bordercolor" align="center">

         <tr> 
            <td class="titlebg" bgcolor="#EBEBEB" height="6"> &nbsp;<font size=2 class="text1" color="#FFFFFF"><b><font color="#0000FF">$mj{cat117}</font></b><font color="#000000"> 
              </font></font></td>
          </tr>
          <tr> 
            <td class="titlebg" bgcolor="#EEEEEE" height="6"> 
              <div align="center"><b><font color="#FF0000">$message</font></b></div>
            </td>
          </tr>
          <tr> 
            <td class="titlebg" bgcolor="#EEEEEE" height="49" valign="top"> 
              <div align="center">
                <textarea name="cats" cols="35" rows="15" wrap="VIRTUAL">$FORM{cats}</textarea>
                <br>
                <input type="submit" name="submit" value="$TXT{update}">
                <input type="submit" name="cancel" value="$TXT{cancel}">
              </div>
            </td>
          </tr>
          <tr> 
            <td bgcolor="#EBEBEB" height="2"> 
              <div align="center"></div>
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
############################################################
sub PrintCatMiddle{
    my(%CAT, @db, %HTML, @label1, %LABEL1, $message, $title);
	($message) = @_;
	@label1=("1", "0");
	%LABEL1=("1"=>"Yes", "0"=>"No");
	if($FORM{action} eq "add"){
		$hidden =  qq|<input type="hidden" name="action" value="add">|;
#        $HTML{ID}= qq|<input type="text" name="ID" size="20" maxlength="30" value="$FORM{ID}">|;
		$title = $mj{cat30};
	}
    else{
        %CAT = &RetrieveCategoryDB($FORM{cat});
        foreach (keys %CAT) { $FORM{$_} = $CAT{$_} unless defined $FORM{$_};  }
        $hidden =qq|<input type="hidden" name="id" value="$FORM{cat}">
      				<input type="hidden" name="action" value="edit">|;
		$HTML{ID}= qq|$FORM{ID}|;
		$title = $mj{cat33};
	}
	
	$FORM{icon} = &LastDirectory($FORM{icon});
	$FORM{icon} = "blank.gif" unless $FORM{icon};
	$HTML{icon} = &BuildImageSelection("$CONFIG{image_url}", $FORM{icon});
	$HTML{post} = $Cgi->popup_menu("post", \@label1, $CAT{post}, \%LABEL1);
	if($CAT{icon} or $CAT{ricon}){	$HTML{no_icon} = $Cgi->checkbox("no_icon", "", "yes", "Do not use icon");	}
	else{		$HTML{no_icon} = $Cgi->checkbox("no_icon", "checked", "yes", "Do not use icon");	}
	($parent_cat = $FORM{cat}) =~ s/\/*&LastDirectory($FORM{cat})//e;
	
	&PrintMojoHeader;
	print qq|

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="182"> <br>
      <form name="mojo" method="post" action="$CONFIG{admin_url}">
       <input type="hidden" name="type" value="cat">
		 <input type="hidden" name="cat" value="$FORM{cat}">
         <input type="hidden" name="parent" value="$FORM{parent}">
      $hidden
      <input type="hidden" name="step" value="final">
<table border="0" width="601" cellspacing="1" cellpadding="4" bgcolor="#6394BD" class="bordercolor" align="center">

         <tr> 
            <td class="titlebg" bgcolor="#EBEBEB" height="6"> &nbsp;<font size=2 class="text1" color="#FFFFFF"><b><font color="#0000FF">$title</font></b></font></td>
          </tr>
          <tr> 
            <td class="titlebg" bgcolor="#EEEEEE" height="29"> 
              <div align="center"><b><font color="#FF0000">$message</font></b></div>
            </td>
          </tr>
          <tr> 
            <td class="titlebg" bgcolor="#EEEEEE" height="51" valign="top"> 
              <table width="100%" border="0" cellspacing="0" cellpadding="2" align="center">
<!--                <tr> 
                  <td valign="top"><b>$mj{cat1}</b></td>
                  <td> $HTML{id}<br>$mj{cat2}</td>
                </tr>  -->
                <tr> 
                  <td valign="top"><b>$mj{cat5}</b></td>
                  <td> 
                    <input type="text" name="name" size="30" maxlength="100" value="$FORM{name}">
                    <br>
                    $mj{cat6}</td>
                </tr>
                <tr> 
                  <td valign="top"><b>$mj{cat10}</b></td>
                  <td> 
                    <textarea name="description" cols="40" rows="3" wrap="VIRTUAL">$FORM{description}</textarea>
                    <br>
                    $mj{cat11}</td>
                </tr>
                <tr> 
                  <td height="39" valign="top"><b>$mj{cat15}</b></td>
                  <td height="39"> $HTML{icon}<br>
                    $HTML{no_icon}<br>
                    $mj{cat16}<br>
                    <input type="text" name="ricon" size="50" maxlength="100" value="$FORM{ricon}">
                  </td>
                </tr>
                <tr> 
                  <td height="39" colspan="2"> 
                    <div align="center"> 
                      <input type="submit" name="Submit" value="$TXT{submit}">
                      <input type="reset" name="reset" value="$TXT{reset}">
                    </div>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr> 
            <td bgcolor="#EBEBEB" height="2"> 
              <div align="center"></div>
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
############################################################
1;
