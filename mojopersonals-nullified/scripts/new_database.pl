use DBI;
use File::Path;

sub ConnectDatabase{
    $dsn="DBI:mysql:$CONFIG{mysql_database}:$CONFIG{mysql_hostname}";
    $dbh=DBI->connect($dsn,$CONFIG{mysql_username},$CONFIG{mysql_password});
#$dsn="DBI:mysql:dev_personals:localhost";
#$dbh=DBI->connect($dsn,'personals','mojosql');
    if (!$dbh){die "Unable to connect user $CONFIG{mysql_username} to base $CONFIG{mysql_database} on host
    $CONFIG{mysql_hostname}.";}
}


sub runSQL($)
{
  $tempquery=$dbh->prepare(@_[0]);
  if (!$tempquery) {"SQL error: ",$dbh->errstr; die "@_[0]\nSQL Error:
",$dbh->errstr,"\n";}
  if (!$tempquery->execute){"SQL error: ",$tempquery->errstr; die
"@_[0]\nSQL Error: ",($tempquery->errstr),"\n";}
  return $tempquery;
}


sub DbInit{
       my $sth;
       $sth=runSQL("CREATE TABLE ads(
                    date_create INT UNSIGNED NOT NULL,
                    date_end INT UNSIGNED NOT NULL,
                    username VARCHAR(20) NOT NULL,
                    cat INT NOT NULL,
                    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    status VARCHAR(20) NOT NULL,
                    city TEXT NOT NULL DEFAULT \'\',
                    state TEXT NOT NULL DEFAULT \'\',
                    state2 TEXT NOT NULL DEFAULT \'\',
					state3 TEXT NOT NULL DEFAULT \'\',
                    country TEXT NOT NULL DEFAULT \'\',
                    zip TEXT NOT NULL DEFAULT \'\',
                    gender TEXT,
                    bdm TEXT,
                    bdd TEXT,
                    bdy TEXT,
                    age TEXT,
                    eye TEXT,
                    hair TEXT,
                    body TEXT,
                    height1 TEXT,
                    height2 TEXT,
                    weight TEXT,
                    ethnic TEXT,
                    education TEXT,
                    employment TEXT,
                    profession TEXT,
                    income TEXT,
                    marital TEXT,
                    religion TEXT,
                    smoke TEXT,
                    drink TEXT,
                    kid1 TEXT,
                    kid2 TEXT,
                    relationship TEXT,
                    interests TEXT,
                    groups TEXT,
	                horoscopes TEXT,
					political TEXT,
					rel_services TEXT,
					business_url TEXT,
	                favorite_url TEXT,
					favorite_url2 TEXT,
					aim TEXT,
					yim TEXT,
					icq TEXT,
					msn TEXT,
                   title TEXT NOT NULL DEFAULT \'\',
                   description TEXT NOT NULL DEFAULT \'\',
                   dd TEXT, fs TEXT, fd TEXT, pet TEXT, bot TEXT,
                   known TEXT, toy TEXT, esc TEXT,
                   image VARCHAR(255),
                   image2 VARCHAR(255),
                   image3 VARCHAR(255),
                   image4 VARCHAR(255),
                   image5 VARCHAR(255),
                   visibility TEXT,
                   priority TEXT,
                   template TEXT,   
                   view INT UNSIGNED DEFAULT 0,
                   reply INT UNSIGNED DEFAULT 0,
                   save INT UNSIGNED DEFAULT 0,
                   updated INT UNSIGNED
                   );");
    $sth=runSQL("CREATE TABLE member(
#                    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    date_create INT UNSIGNED,
                    date_end INT UNSIGNED,   #when status became inactive
                    status VARCHAR(10),
                    position VARCHAR(10),
                    username VARCHAR(20) NOT NULL PRIMARY KEY,
                    password VARCHAR(20),
                    email TEXT,
                    fname TEXT,
                    lname TEXT,
                    address TEXT,
                    address2 TEXT,
                    city TEXT,
                    state TEXT,
                    province TEXT,
                    country TEXT,
                    zip TEXT,
                    phone TEXT,
                    fax TEXT,
                    website TEXT,
                    aim TEXT,
                    yim TEXT,
                    icq TEXT,
                    msn TEXT,
                    gender TEXT,
                    mojo TEXT,
                    ip_address VARCHAR(15),
                    fail_login TEXT,
                    success_login INT UNSIGNED,
                    last_login INT UNSIGNED,
                    last_url VARCHAR(255),
                    last_updated INT UNSIGNED,
                    ad_allowed INT UNSIGNED,
                    ad_used INT UNSIGNED,
                    media_allowed INT UNSIGNED,
                    media_used INT UNSIGNED,
					mailbox_size INT UNSIGNED NOT NULL,
					buddies TEXT,     #?
                    html_mail TEXT,   #?
                    email_notify TEXT,
                    maillist TEXT,
                    account VARCHAR(255),
                    account_start INT UNSIGNED,
                    account_end INT UNSIGNED,
					aee VARCHAR(1),  #advanced expiry email sent
					pincode VARCHAR(255) NOT NULL,
                    subscription_id VARCHAR(255) NOT NULL,
                    transaction_id VARCHAR(255) NOT NULL,
                    recurring TEXT,
                    signature TEXT,###
                    custom1 TEXT,
                    custom2 TEXT,
                    custom3 TEXT,
                    custom4 TEXT,
                    custom5 TEXT);");

    $sth=runSQL("CREATE TABLE mails(
                    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    cat INT NOT NULL DEFAULT 0,
                    adid INT UNSIGNED,
                    sent_from VARCHAR(20),
                    sent_to VARCHAR(20),
                    date_sent INT UNSIGNED,
                    new VARCHAR(2),
                    subject VARCHAR(255),
                    message TEXT,
                    folder_from VARCHAR(10) NOT NULL DEFAULT \'outbox\',
                    folder_to VARCHAR(10) NOT NULL DEFAULT \'inbox\'
                    )");
    $sth=runSQL("CREATE TABLE category(
                    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    name VARCHAR(255) NOT NULL,
                    date_create INT UNSIGNED NOT NULL,
                    date_end INT UNSIGNED NOT NULL,
                    icon VARCHAR(255),
                    ricon VARCHAR(255),
                    description TEXT,
                    ads INT UNSIGNED NOT NULL DEFAULT 0,
                    number INT UNSIGNED NOT NULL, ####
                    account TEXT,   #?
                    countries VARCHAR(1) NOT NULL,
                    states VARCHAR(1) NOT NULL,
                    parent INT UNSIGNED NOT NULL DEFAULT 0,   ###
                    subcats INT UNSIGNED NOT NULL DEFAULT 0   ###
                    )");
    $sth=runSQL("CREATE TABLE admemactions(
                    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    ad_id INT UNSIGNED NOT NULL,
                    username VARCHAR(20) NOT NULL,
                    date INT UNSIGNED NOT NULL,
                    type VARCHAR(1) NOT NULL
                    )");
# 's' saved to hotlist, 'r' replied, 'v' viewed

    $sth=runSQL("CREATE TABLE preferences(
                    username VARCHAR(20) NOT NULL,
                    P_invisible_mode VARCHAR(1) DEFAULT '0',
                    P_autologin VARCHAR(1) DEFAULT '0',
                    P_hide_email VARCHAR(1) DEFAULT '0',
                    P_disable_pm VARCHAR(1) DEFAULT '0',
                    P_hide_profile VARCHAR(1) DEFAULT '0',
                    P_hide_gallery VARCHAR(1) DEFAULT '0',
                    custom1 VARCHAR(1) DEFAULT '0',
                    custom2 VARCHAR(1) DEFAULT '0',
                    custom3 VARCHAR(1) DEFAULT '0',
                    custom4 VARCHAR(1) DEFAULT '0',
#                    11-15 notification
                    P_notify_profile_update VARCHAR(1) DEFAULT '0',
                    P_notify_ads_expired VARCHAR(1) DEFAULT '0',
                    P_notify_ads_reply VARCHAR(1) DEFAULT '0',
                    P_notify_pm VARCHAR(1) DEFAULT '0',
                    custom5 VARCHAR(1) DEFAULT '0',
#                   16-20 misc
                    P_email_type VARCHAR(1) DEFAULT '0',
                    P_show_empty_subs VARCHAR(1) DEFAULT '1',
                    P_ads_view VARCHAR(1) DEFAULT '0',
                    P_lpp VARCHAR(1) DEFAULT '0'
                    )");

     $sth=runSQL("CREATE TABLE logs(
                    username VARCHAR(20),
                    logtime INT UNSIGNED NOT NULL,
                    ip VARCHAR(15),
                    type VARCHAR(50),
                    class VARCHAR(50),
                    action VARCHAR(50),
                    mode VARCHAR(1)
                    )");
}


############################################################
###					ACTIONS DATABASE
############################################################
sub AddActionDB{
    my (@content,  %DB, $id, %QDB,$sth);
	($db) = @_;
	%DB = %$db;
   $DB{date}=&TimeNow unless ($DB{date});
	$DB{username}=$dbh->quote($DB{username});
	$sth=runSQL("INSERT INTO admemactions SET ad_id=$DB{ad_id},
	             username=$DB{username}, date=$DB{date}, type=\'$DB{type}\'");
    return wantarray?%DB:\%DB;
}

############################################################
###					ADS DATABASE
############################################################


sub DefineAdDB{
	my(@db) = (
    "id",
##mandotory
    "date_create","date_end","username","cat","status",
## first page
	"city","state","country","zip","gender","bdm","bdd","bdy","age",
	"eye","hair","body", "height1","height2","weight","ethnic","education", "employment",
	"profession","income","marital","religion", "smoke","drink","kid1","kid2",
###
	"horoscopes","political","rel_services","state2","state3","business_url",
	"favorite_url","favorite_url2","aim","yim","icq","msn",
#checkboxes
	"relationship","interests","groups",
#page 2
	"title","description",
##Third page, a survey like
	"dd","fs","fd","pet","bot","known","toy","esc",
##fourth page
	"image","image2","image3","image4","image5",
###options
	"visibility","priority","template",
###relevant info gather as we go on
	"view","reply","save",
###this value tells me if the ad is updated or new	
	"updated");
	return wantarray?@db:\@db;
}

############################################################
sub RearrangeParam{
	my(%INDEX, $order, @order, @param, %PARAM, @result);
	($order, @param) = @_;
   return () unless @param;
	return @param unless (ref($param[0]) eq 'HASH');
	
	%PARAM = %{$param[0]};
	foreach (@$order){
		$order = lc($_);
		$PARAM{$order} =~ s/\s+$//g;
		if(defined $PARAM{$order}){	push(@result, $PARAM{$order});	}
		elsif(defined $PARAM{$_}){	push(@result, $PARAM{$_});	}
	}
	return @result;
}






###########################################################
sub AddAdDB{
    my(@content, $db, @db, %DB, $id, %QDB,$sth);
	($db) = @_;
	%DB = %$db;

#	$DB{view} = $DB{reply} = $DB{save} = 0;
	$DB{date_create} = &TimeNow unless $DB{date_create};
	$DB{date_end} = $DB{date_create} + ($CONFIG{ad_length} * 24 *60 *60) unless $DB{date_end};
    @db = &DefineAdDB;
    shift @db;
    foreach $item(@db){
           if (defined $DB{$item}){
                $QDB{$item}=$dbh->quote($DB{"$item"});
                push(@content, "$item=".$QDB{$item});
           }
    };
	if ($DB{id}) {push @content,"id=$DB{id}"};
	$set=join(', ',@content);
    $sth=runSQL("INSERT INTO ads SET $set");
    if (not $DB{id}) {
		$sth=runSQL("SELECT MAX(id) FROM ads WHERE username=$QDB{username}");
        ($id)=$sth->fetchrow();
        $DB{id}=$id;
	}
    return wantarray?%DB:\%DB;
}

############################################################
# \% = RetrieveAdDB($adid [$cat] [$status] |$filename |\%AD);
sub RetrieveAdDB{
    my($adid, $db, @db, %DB, $cat, %P,$exist,$sth);
    $adid=@_[0];
    @db=&DefineAdDB;
    $db=join(', ',@db);
    $sth=runSQL("SELECT $db FROM ads WHERE id=$adid");
	$exist=$sth->rows();
	return 0 unless ($exist);
	@ad_data=$sth->fetchrow();
    for (my $i=0; $i <@db; $i++){$DB{$db[$i]}=$ad_data[$i]};
    return %DB if $FORM{fast_parse};
    
    %P = &RetrievePhotoDB("$CONFIG{photo_path}/$DB{username}/$DB{image}", "$CONFIG{ad_url}&action=view_image&cat=$DB{cat}&id=$DB{id}&image=1");
    $DB{image_url}= $P{images_url};
    $DB{thumbnail}= $P{thumbnail};
    $DB{date_posted}= &FormatTime($DB{date_create});
    $DB{date_expired}= &FormatTime($DB{date_end});
#   &PrintDebug(\%DB); print "<br>----------<br>";
    return wantarray?%DB:\%DB;
}

############################################################
sub UpdateAdDB{                                      
    my(@content, $db, @db, %DB, %TEMP, $set, @content,$sth,
    $oldstatus,@cats,$cats,$oldcat);
	($db) = @_;
	%DB = %$db;
	
    %TEMP = RetrieveAdDB("$DB{id}");
    $oldstatus=$TEMP{status};
    $oldcat=$TEMP{cat};
    @db = &DefineAdDB;
    shift @db;
    foreach (keys %TEMP){   $DB{$_} = $TEMP{$_} unless defined $DB{$_}; }

    if ($DB{status} ne $oldstatus){
        if ($oldstatus eq 'active'){
             @cats=&GetParentCatsList($oldcat);
             @cats=map("id=$_",@cats);
             $cats=join(' OR ',@cats);
             $sth=runSQL("UPDATE category SET ads=ads-1 WHERE $cats");
        }
        elsif ($DB{status} eq 'active'){
             @cats=&GetParentCatsList($DB{cat});
             @cats=map("id=$_",@cats);
             $cats=join(' OR ',@cats);
             $sth=runSQL("UPDATE category SET ads=ads+1 WHERE $cats");
        }
    }

    foreach $item(@db){
           $DB{$item}=$dbh->quote($DB{"$item"});
           push(@content, "$item=".$DB{$item});
    };
    $set=join(', ',@content);
    $sth=runSQL("UPDATE ads SET $set WHERE id=$DB{id}");

	return wantarray?%DB:\%DB;
}
#######################################################################
sub DeleteAdDB{
    my ($sth,%AD,$ad,@cats,$cats);
    $ad=&RetrieveAdDB(@_[0]);
    %AD=%$ad;
    $sth=runSQL("DELETE FROM ads WHERE id=$AD{id}");
    if ($AD{status} eq 'active'){
        @cats=&GetParentCatsList($AD{cat});
        @cats=map("id=$_",@cats);
        $cats=join(' OR ',@cats);
        $sth=runSQL("UPDATE category SET ads=ads-1 WHERE $cats");
    }
    $sth=runSQL("DELETE FROM admemactions WHERE ad_id=$AD{id}");
}

############################################################
sub CopyAd{
	my($id, @db,$db,$newid, $sth,%DB,$set,@content);
 	$id=@_[0];
	$db=&RetrieveAdDB($id);
	%DB=%$db;
	delete $DB{id};

	$DB{status}="incomplete\|$id";
	@db=&DefineAdDB;
	shift @db;
	foreach (@db){
           $DB{$_}=$dbh->quote($DB{$_});
           push(@content, "$_=".$DB{$_});
    };

	$set=join(', ',@content);
	$sth=runSQL("INSERT INTO ads SET $set");
	$sth=runSQL("SELECT MAX(id) FROM ads WHERE status=\'incomplete\|$id\'");
	($newid)=$sth->fetchrow();
	return $newid;
}




##############################################################
# Categories database
############################################################
sub DefineCategoryDB{
    my @db=("id","name","date_create","date_end","icon","ricon",
    "description","ads","number","account","countries","states","parent",
    "subcats");
	return wantarray?@db:\@db;
}


############################################################
#param --- category id
sub RetrieveCategoryDB{
    my($ad, %DB, $db, @db, @cat_data, $parent, $catname, $id,$sth);
    $id=@_[0];
    return wantarray?%DB:\%DB unless ($id>0);
    @db=&DefineCategoryDB;
    shift @db;
    $db=join(', ',@db);
    $sth=runSQL("SELECT $db FROM category WHERE id=$id");
    @cat_data=$sth->fetchrow();
    for (my $i=0; $i <@db; $i++){$DB{$db[$i]}=$cat_data[$i]};

    if($DB{ricon}){     $DB{icon_url} = qq|<img src="$DB{ricon}" border=0 align="right">|;                  }
	elsif($DB{icon}){		$DB{icon_url} = qq|<img src="$CONFIG{image_url}/$DB{icon}" border=0 align="right">|;	}
	return wantarray?%DB:\%DB;
}

############################################################
sub AddCategoryDB{
	my(@content, $db, @db,%DB,$sth,%QDB,$id);
    ($db) = @_;
	%DB = %$db;
	$DB{description} =~ s/\n/<br>/ig;
	$DB{date_create}=  &TimeNow unless $DB{date_create};
	$DB{date_end}=     &TimeNow + 10* 365 * 24 * 60 *60 unless $DB{date_end};
    $DB{countries}=0 unless $DB{countries};
    $DB{states}=0 unless $DB{states};
    if ($DB{parent}>0) {
         $sth=runSQL("UPDATE category SET subcats=subcats+1
                      WHERE id=$DB{parent}");
    }
    $DB{parent}=($DB{parent}>0)?$DB{parent}:0;
	if (not $DB{number}) {
	   $sth=runSQL("SELECT MAX(number) FROM category WHERE
                    parent=$DB{parent}");
       ($DB{number})=$sth->fetchrow();
       $DB{number}++;
	}
    @db = &DefineCategoryDB;
    shift @db;
    foreach $item(@db){
		   if ($DB{$item}){
		   $QDB{$item}=$dbh->quote($DB{"$item"});
		   push(@content, "$item=".$QDB{$item});}
    };
    $set=join(', ',@content);
    $sth=runSQL("INSERT INTO category SET $set");
    $sth=runSQL("SELECT MAX(id) FROM category WHERE name=$QDB{name}");
    ($id)=$sth->fetchrow();
     $DB{id}=$id;
    return wantarray?%DB:\%DB;
}

############################################################
sub UpdateCategoryDB{
	my(@content, $db, @db,%DB, $file, $parent,$sth);
    ($db) = @_;
	%DB = %$db;
	@db = &DefineCategoryDB;
	$DB{description} =~ s/\n/<br>/ig;
#    $DB{date_create}=  &TimeNow unless $DB{date_create};
#    $DB{date_end}=     &TimeNow + 10* 365 * 24 * 60 *60 unless $DB{date_end};
    shift @db;
    foreach $item(@db){
           if ($DB{$item}) {
		   	    $DB{$item}=$dbh->quote($DB{$item});
                push(@content, "$item=".$DB{$item});
		   }
	};
    $set=join(', ',@content);
    $sth=runSQL("UPDATE category SET $set WHERE id=$DB{id}");
    return wantarray?%DB:\%DB;
}

############################################################################
sub GetSubcatsList($){
     my($cat,@cat,$exist, $where, @cats, @all_subcats, $id,$sth);
     $cat=@_[0];
     @cats=@$cat;
     $exist=1;
#     @cats=@cat;
     @all_subcats=();
     while ($exist){
        @cats=map("parent=$_",@cats);
        $where=join(' OR ',@cats);
        $sth=runSQL("SELECT id FROM category WHERE $where");
        $exist=$sth->rows();
        @cats=();
        while (($id)=$sth->fetchrow()){
            push @cats, $id;
        }
        push @all_subcats, @cats;
     }
     return @all_subcats;
}
#############################################################
sub  GetParentCatsList($$){
	my(%CAT,@parents,$sth);
	$cat=@_[0];
	while ($cat>0){
		unshift @parents, $cat;
		%CAT=&RetrieveCategoryDB($cat);
		$cat=$CAT{parent};
	}
	return @parents;
}

############################################################
sub DeleteCategoryDB{
    my($id,$sth,@subcats,%CAT,$subcats,@cats,$cats,$total_ads,
    @parents,$parents);
    $cats=@_[0];
    @cats=@$cats;
    $id=@cats[0];
    %CAT=&RetrieveCategoryDB($id);
    $cats=join(" OR ",map("id=$_",@cats));
    $sth=runSQL("SELECT SUM(ads) FROM category WHERE $cats");
    $total_ads=$sth->fetchrow();

	if ($CAT{parent}>0){
           $sth=runSQL("UPDATE category SET subcats=subcats-$#cats-1
                        WHERE id=$CAT{parent}");
    }

    @parents=&GetParentCatsList($CAT{parent});
    $parents=join(" OR ",map("id=$_",@parents));
    if ($parents ne ''){
         $sth=runSQL("UPDATE category SET ads=ads-$total_ads WHERE
                      $parents");
    }
    @subcats=&GetSubcatsList(\@cats);
    push @subcats, @cats;
    $subcats=join(" OR ",map("id=$_",@subcats));
    $sth=runSQL("DELETE FROM category WHERE $subcats");
    $subcats=join(" OR ",map("cat=$_",@subcats));
#    $sth=runSQL("UPDATE category SET parent=$CAT{parent} WHERE parent=$id");
    $sth=runSQL("DELETE FROM ads WHERE $subcats");
    return 1;
}




#}
############################################################
#								MEMBER DATABASE
############################################################
sub DefineMemberDB{
	my(@db) =(
    'date_create','date_end','status','position','username','password',
	'email','fname','lname','address','address2','city','state','province','country','zip',
	'phone','fax','website','aim','yim','icq','msn','gender','mojo',
	'ip_address','fail_login','success_login','last_login','last_url','last_updated',
    'ad_allowed','ad_used','media_allowed','media_used','mailbox_size',
#    'ads','sads','rads',
    'buddies', 'html_mail', 'email_notify', 'maillist', #?
	'account', 'account_start', 'account_end','aee', 'pincode', 'subscription_id', 'transaction_id', 'recurring',
    'signature', ###
	'custom1','custom2','custom3','custom4','custom5');
	return wantarray?@db:\@db;
}

sub AddMemberDB{
    my(@content, $db, %DB, @db, %MAIL, , %TEMP, $set,$sth);
	($db) = @_;
	%DB = %$db;
###
	%TEMP = &RetrieveAccountDB("$CONFIG{account_path}/$DB{account}/account.pl");	
	$DB{ad_allowed}   = $TEMP{ad_allowed} unless $DB{ad_allowed};
	$DB{ad_used} = 0;
	$DB{media_allowed}= $TEMP{media_allowed} unless $DB{media_allowed};
	$DB{media_used}   = 0;
	$DB{mailbox_size}=$TEMP{mailbox_size} unless $DB{mailbox_size};
	$DB{date_create}  = &TimeNow;
	if ($DB{status} eq 'pending') {$DB{date_end}=$CONFIG{systemtime};}
###
    $sth=runSQL("INSERT INTO preferences SET username=\'$DB{username}\'");
###
	&CreateGallery($DB{username});
    $MAIL{sent_from}=   "admin";
    $MAIL{sent_to}=     $DB{username};
	$MAIL{subject}=$SUBJECT{welcome};
	my $message = &ParseEmailTemplate($EMAIL{welcome}, \%DB);
    $MAIL{message}=$message;
    $MAIL{date_sent}=   &TimeNow;
    $MAIL{new}=    1;
    $MAIL{folder_to}="inbox";
    $MAIL{folder_from}="";
    $MAIL{cat}=0;
    &AddMailDB(\%MAIL);
###
    @db = &DefineMemberDB;
    foreach $item(@db){
		   if (defined $DB{$item}){
		     $DB{$item}=$dbh->quote($DB{$item});
             push(@content, "$item=".$DB{$item});
		   }
    };
    $set=join(', ',@content);
    $sth=runSQL("INSERT INTO member SET $set");

###
}
############################################################
sub RetrieveMemberDB{
    my($db, @db, @lines, @mem_data, %DB,$no_format, @tokens, $username,$sth);
    $username = @_[0];
    @db=&DefineMemberDB;
    $db=join(', ',@db);
    $sth=runSQL("SELECT $db FROM member WHERE username=\'$username\'");
    $exist=$sth->rows();
    if ($exist == 0) {return \%DB;}
    @mem_data=$sth->fetchrow();
    for (my $i=0; $i <@db; $i++){$DB{$db[$i]}=$mem_data[$i]};

	return \%DB if $FORM{fast_parse};
	
	$DB{date_registered}=  &FormatTime($DB{date_create});
	if ($DB{account_end}==2**32-2) {$DB{date_expired}='unlimited'}
	else {$DB{date_expired}=     &FormatTime($DB{account_end});}
	$DB{date_updated}=     &FormatTime($DB{last_updated});
	$DB{date_last_login}=  &FormatTime($DB{last_login});
	return wantarray?%DB:\%DB;
}
###########################################################
sub UpdateMemberDB{
    my(@content, $db, %DB, @db, $set, %TEMP,$sth);
	$db = @_[0];
	%DB = %$db;
	%TEMP = &RetrieveMemberDB($DB{username});
# fix status change
	if (($TEMP{status} eq 'active') and (($DB{status} eq 'pending') or ($DB{status} eq 'expire'))){
		  $DB{date_end}=$CONFIG{systemtime};
	}


	@db = &DefineMemberDB;
    foreach $item(@db){
           if (defined $DB{$item}) {
		   	    $DB{$item}=$dbh->quote($DB{"$item"});
                push(@content, "$item=".$DB{$item});
		   }
    };
    $set=join(', ',@content);
    $sth=runSQL("UPDATE member SET $set WHERE username=$DB{username}");


###
	return wantarray?%DB:\%DB;
}

############################################################
sub DeleteMemberDB{
    my($id,@ads,$mem, %MEM, $username,$sth,%MAILS,$toorfrom);
    $mem = &RetrieveMemberDB(@_);
	%MEM =%$mem;

    rmtree("$CONFIG{photo_path}/$MEM{username}", 0,0);

    $MEM{username}=$dbh->quote($MEM{username});
    $sth=runSQL("SELECT id FROM ads WHERE username=$MEM{username}");
    while (($id)=$sth->fetchrow()) {push @ads,$id;}
    foreach (@ads){ &DeleteAdDB($_);}

    $sth=runSQL("UPDATE mails SET folder_to=\'\' WHERE
                 sent_to=$MEM{username}");
    $sth=runSQL("UPDATE mails SET folder_from=\'\' WHERE
                 sent_from=$MEM{username}");
    $sth=runSQL("DELETE FROM mails WHERE folder_to=\'\' AND
                 folder_from=\'\'");

    $sth=runSQL("DELETE FROM member WHERE username=$MEM{username}");
    $sth=runSQL("DELETE FROM preferences WHERE username=$MEM{username}");


}
############################################################
sub isMemberExist{
    my %MEM=&RetrieveMemberDB(@_[0]) ;
    return $MEM{username} ? %MEM : '0';
}
###########################################################
sub isEmailExist{
    my($email, $rows, $username,$sth);
    $email = shift;
    $email=$dbh->quote($email);
    $sth=runSQL("SELECT username FROM member WHERE email=$email");
    $rows=$sth->rows();
    if ($rows == 0) {return 0;}
    else {$username=$sth->fetchrow(); return $username;}
}


############################################################
#								MAIL DATABASES
############################################################
sub DefineMailDB{
    my @db=('id', 'cat','adid','sent_from','sent_to', 'date_sent',
    'new','subject','message','folder_from','folder_to');
#    "ID","cat","adid","from","to","time","new","subject","message");
	return wantarray?@db:\@db;
}

############################################################
sub AddMailDB{
    my($def, @def, %MAIL, $filename, $db, $not_notify, $mem, %MEM,
    $set, @content,$sth);
    ($db, $not_notify) = @_;
    %MAIL = %$db;
#    $FORM{message} = &OneLine(&ConvertFromForm($FORM{message}));
    @def = &DefineMailDB;
    shift @def;
    foreach $item(@def){
           if (defined $MAIL{"$item"}) {
                 $MAIL{$item}=$dbh->quote($MAIL{"$item"});
                 push(@content, "$item=".$MAIL{$item});
           }
    };
	if (defined $MAIL{id}) {push @content,"id=$MAIL{id}";}
	$set=join(', ',@content);
    $sth=runSQL("INSERT INTO mails SET $set");
    return if $not_notify;
###Check for email notification
    my %PREF = &RetrievePreferenceDB($MAIL{sent_to});
    if($PREF{P_notify_pm} eq '1'){
        %MEM=&RetrieveMemberDB($DB{"sent_to"});
        &SendMail($CONFIG{myname}, $CONFIG{myemail}, $MEM{email}, "You've got mail", &NotifyEmailTemplate(\%MEM), 1);
	}
###
}

############################################################
sub RetrieveMailDB{
    my($db, @db, %DB, $exist,$sth);
    $id = shift;
    @db = &DefineMailDB;
    $db=join(', ',@db);
    $sth=runSQL("SELECT $db FROM mails WHERE id=$id");
    $exist=$sth->rows();
    if ($exist>0) {
          @mail_data=$sth->fetchrow();
          for (my $i=0; $i <@db; $i++){$DB{$db[$i]}=$mail_data[$i]};
          $DB{date_sent} = &FormatTime($DB{date_sent});
    }
	return wantarray?%DB:\%DB;
}
############################################################
sub UpdateMailDB{
    my($def, @def, %MAIL, $db, $mem, %MEM,
    $set, @content,$sth);
    ($db) = @_;
    %MAIL = %$db;
#    $DB{id} = &NextMailID unless $DB{ID};
#    $FORM{message} = &OneLine(&ConvertFromForm($FORM{message}));
    @def = &DefineMailDB;
    shift @def;
    splice(@def,4,1);
    foreach $item(@def){
           $MAIL{$item}=$dbh->quote($MAIL{"$item"});
           push(@content, "$item=".$MAIL{$item});
    };
    $set=join(', ',@content);
    $sth=runSQL("UPDATE mails SET $set WHERE id=$MAIL{id}");
}



############################################################
#										PREFERENCES
############################################################
sub DefinePreferenceDB{
	return (
#1-10 privacy and cookies
"P_invisible_mode",
"P_autologin",
"P_hide_email",
"P_disable_pm",
"P_hide_profile",
"P_hide_gallery",
"custom1","custom2","custom3","custom4",
#11-15 notification
"P_notify_profile_update",
"P_notify_ads_expired",
"P_notify_ads_reply",
"P_notify_pm",
"custom5",
#16-20 misc
"P_email_type",
"P_show_empty_subs",
"P_ads_view",
"P_lpp");
}
############################################################
sub UpdatePreferenceDB{
	my(@content, $db, @db,%DB, $username,$sth);
	($username, $db) = @_;
	%DB = %$db;
	@db = &DefinePreferenceDB;
    foreach $item(@db){
           if (defined $DB{$item}) {
		   	   $DB{$item}=$dbh->quote($DB{"$item"});
               push(@content, "$item=".$DB{$item});
		   }
    };
    $set=join(', ',@content);
    $username=$dbh->quote($username);
    $sth=runSQL("UPDATE preferences SET $set WHERE
                 username=$username");
}
############################################################
sub RetrievePreferenceDB{
	my(%DB, @db, @lines, $username,$sth);
    ($username) = @_;
    @db=&DefinePreferenceDB;
    $db=join(', ',@db);
    $username=$dbh->quote($username);
    $sth=runSQL("SELECT $db FROM preferences WHERE username=$username");
    @pref_data=$sth->fetchrow();
    for (my $i=0; $i <@db; $i++){$DB{$db[$i]}=$pref_data[$i]};
    return wantarray?%DB:\%DB;
}


############################################################
#								LOG DATABASE
############################################################
sub DefineLogDB{
	my(@db)=("username","logtime","ip","type","class","action", "mode");
	return wantarray?@db:\@db;
}
############################################################
sub AddLogDB{
	my(@db, %DB, @content,$db,@db);
	($db, $ret) = @_;
	%DB = %$db;
	@db = &DefineLogDB;
	foreach $item(@db){
           if (defined $DB{"$item"}) {
                 $DB{$item}=$dbh->quote($DB{"$item"});
                 push(@content, "$item=".$DB{$item});
           }
    };
    $set=join(', ',@content);
    $sth=runSQL("INSERT INTO logs SET $set");
	return \%DB if $ret;
}
############################################################
#sub RetrieveLogDB{
#	my(%DB, @db, $dir, $ext, @lines, $name, $photo);
#	$string = shift;
#	@lines = split(/\|/, $string);
#	@db = &DefineLogDB;
#	for(my $i=0; $i< @db; $i++){		$DB{$db[$i]} = $lines[$i];	}
#	return wantarray?%DB:\%DB;
#}

############################################################
sub UpdateLogDB{
	my(@content, $db, @db,%DB, $sth);
	($db) = @_;
	%DB = %$db;
	@db = &DefineLogDB;
    foreach $item(@db){
           if (defined $DB{$item}) {
		   	   $DB{$item}=$dbh->quote($DB{$item});
               push(@content, "$item=".$DB{$item});
		   }
    };
    $set=join(', ',@content);
    $sth=runSQL("UPDATE logs SET $set WHERE ip=$DB{ip}");
}













1;
