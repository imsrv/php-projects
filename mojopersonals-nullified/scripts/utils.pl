############################################################
sub BackupAdDB{}
sub BackupHTaccess{			&FileCopy($CONFIG{password_file}, "$CONFIG{password_file}.bak");								}
sub BackupActiveMember{		&DirectoryCopy($CONFIG{member_path}, $CONFIG{backup_path}, $CONFIG{member_ext});	}
sub BackupExpireMember{		&DirectoryCopy($CONFIG{member_path}, $CONFIG{backup_path}, $CONFIG{expire_ext});	}
sub BackupPendingMember{	&DirectoryCopy($CONFIG{member_path}, $CONFIG{backup_path}, $CONFIG{pending_ext});	}
sub BackupSuspendMember{	&DirectoryCopy($CONFIG{member_path}, $CONFIG{backup_path}, $CONFIG{suspend_ext});	}
sub BackupMemberDB{			&DirectoryCopy($CONFIG{member_path}, $CONFIG{backup_path}, [$CONFIG{member_ext},$CONFIG{expire_ext},$CONFIG{pending_ext},$CONFIG{suspend_ext}]);}
sub BackupAdminDB{			&FileCopy($CONFIG{admin_db}, "$CONFIG{backup_path}/admin_db.db");		}
sub BackupGroupDB{			&FileCopy($CONFIG{group_db}, "$CONFIG{backup_path}/groups_db.db");	}
############################################################
sub CleanExpiredAds{
    my ($sth,@actions,$actions,$id);
    $sth=runSQL("SELECT ama.id FROM admemactions AS ama, ads WHERE
                 ama.ad_id=ads.id AND ads.status=\'expire\'");
    while (($id)=$sth->fetchrow()){push @actions,$id;}

    $sth=runSQL("DELETE FROM ads WHERE status=\'expire\'");
    $actions=join(" OR ",map("ad_id=$_",@actions));
    if ($actions ne '') {
        $sth=runSQL("DELETE FROM admemactions WHERE $actions");
    }
}
############################################################
sub CleanExpiredMembers{
#    my ($username,$sth);
#    $sth=runSQL("SELECT username FROM member WHERE status=\'expire\'");
#    while (($username)=$sth->fetchrow()){
#        &DeleteMemberDB($username);
#    }
}

############################################################
sub ExpireMembers{
    my(%ACCOUNT, $aee,$advanced_expire_template,$code,
    $expired_template,%MEMBER, $template,$timenow,$sth,$db,@db,
    @member);
	$aee = $CONFIG{systemtime} + ($CONFIG{advanced_expire_email} * 24 * 60 * 60);
	$expired_template = &FileRead($EMAIL{expired});
	$advanced_expire_template = &FileRead($EMAIL{remind});
	@db=&DefineMemberDB;
	$db=join(', ',@db);
    $sth=runSQL("SELECT $db FROM member");
	while (@member=$sth->fetchrow()){
        for (my $i=0; $i <@db; $i++){$MEMBER{$db[$i]}=$member[$i]};
#Delete old
		if (($MEMBER{status} eq 'pending') or ($MEMBER{status} eq 'expire')){
			 if($MEMBER{'date_end'}+$CONFIG{member_length} <= $CONFIG{systemtime}){
				 $DELETED{$MEMBER{username}}=1;
				 &DeleteMemberDB($MEMBER{username});
		         &SendMail($CONFIG{myname}, $CONFIG{myemail}, $MEMBER{'email'}, $SUBJECT{deleted}, &ParseEmailTemplate($EMAIL{deleted},\%MEMBER)) if (-f $EMAIL{deleted});
			 }
		}
        elsif ($MEMBER{status} eq 'active'){
			  if ($MEMBER{'account_end'}<=$CONFIG{systemtime}){
					if ($MEMBER{gateway} eq 'ibill' and (-d "$CONFIG{account_path}/$MEMBER{account}/account.pl")) {
					    %ACCOUNT=&RetrieveAccountDB("$CONFIG{account_path}/$MEMBER{account}/account.pl");
						if ($ACCOUNT{recurring_period} ne 'unlimited') {
							$MEMBER{account_end}=$MEMBER{account_end}+$ACCOUNT{recurring_length};
							&UpdateMemberDB(\%MEMBER);
						}
					}
					else{
				   		%ACCOUNT=&RetrieveAccountDB("$CONFIG{account_path}/$CONFIG{default_account}/account.pl");
				   		if ($ACCOUNT{recurring_amount}==0) {
				   			    $MEMBER{account}=$CONFIG{default_account};
#				   				$MEMBER{account_start}=$CONFIG{systemtime};
#		                        $MEMBER{account_end}=($ACCOUNT{recurring_period} eq 'unlimited') ? 2**32-2 : $CONFIG{systemtime}+$ACCOUNT{recurring_length};
				   				$oldaccount='';
				   				&GetFreeAccount;
				   		}
				   		else {
				   			    $MEMBER{status} = "expire";
        		   			    $EXPIRE{$MEMBER{username}}= 1;
				   		}
		                &UpdateMemberDB(\%MEMBER);
				   		if($CONFIG{expire_email}){
				   		    &SendMail($CONFIG{myname}, $CONFIG{myemail}, $MEMBER{'email'}, $SUBJECT{expired}, &ParseEmailTemplate($expired_template, \%MEMBER));
				        }
					}
			  }
			  elsif ($CONFIG{advanced_expire_email} and ($MEMBER{gateway} eq "clickbank") and ($MEMBER{'account_end'} <= $aee) and (not $MEMBER{aee})){
					$MEMBER{aee}='1';
		            &UpdateMemberDB(\%MEMBER);
					&SendMail($CONFIG{myname}, $CONFIG{myemail}, $MEMBER{'email'}, $SUBJECT{remind},&ParseEmailTemplate($advanced_expire_template, \%MEMBER));
			        $ABOUT2EXPIRE{$MEMBER{username}} = &FormatTime($MEMBER{'account_end'},"mo;\.;d;\.;y");
		      }
		}
	}
}
############################################################
sub ExpireAds{
    my(@ads, $code, $line, @files, $ad, %AD, $member, %MEMBER,
    $member_file, $time,$db,@db,@ad);
	my $template = &FileRead($EMAIL{ad_expired});
	@db=&DefineAdDB;
	$db=join(', ',@db);
    $sth=runSQL("SELECT $db FROM ads WHERE status='active'");
    while (@ad=$sth->fetchrow()){
        for (my $i=0; $i <@db; $i++){$AD{$db[$i]}=$ad[$i]};
		if($AD{date_end} <= $CONFIG{systemtime}){
			$AD{status} = "expire";
			&UpdateAdDB(\%AD);
			$code = &SendMail($CONFIG{myname}, $CONFIG{myemail}, $MEMBER{email}, $SUBJECT{ad_expired}, &ParseEmailTemplate($template, \%MEMBER));
            $ADEXPIRE{$AD{id}} = $AD{username};
		}
	}
	return wantarray?@ads:\@ads;
}
###################################################################
sub ExportMembers{
    my(@content, @fields, @member, $string,$sth,$where,@where);
    my($account, $status, $fields, $separator) = @_;
    @fields = @$fields;
     if($account and ($account ne "all")){ push(@where,"account=\'$account\'");}
     if($status and (lc($status) ne "all")){ push(@where,"status=\'$status\'");}
     $where=join(" AND ",@where);
     if ($where ne '') {$where="WHERE ".$where;}
     $fields=join(', ',@fields);
     $sth=runSQL("SELECT $fields FROM member $where");
     while (@member=$sth->fetchrow()){
        $string=join($separator,@member)."\n";
        push @content, $string;
     }
    return wantarray?@content:\@content;
}
############################################################
sub RepairAdDB{
    my(%AD, @content, $dir, @dirs, $file, @files, $parent); 
    @dirs = &RecursiveSubdirectories($CONFIG{data_path});
    foreach $dir (@dirs){
        @files = &DirectoryFiles($dir, [ads]);
        @content = ();
        foreach $file (@files){
            %AD = &RetrieveAdDB($file);
            next unless ($AD{status} eq "active");
            push(@content, &DefineAdString(\%AD));
        }
        &FileWrite("$dir/ads.db", \@content);
    }
}

############################################################
sub RepairTables{
	my($sth,@tables,$tables,@result,@bad);
	@tables=('member','mails','preferences','admemactions','category','ads','logs');
	$tables=join(', ',@tables);
	$sth=runSQL("REPAIR TABLE $tables");
	while (@result=$sth->fetchrow()){
		if (($result[2] eq 'status') and (lc($result[3]) ne 'ok')){push @bad,$result[0];}
	}
	if ($bad[0]) {
		$tables=join(', ',@bad);
		 return "MySQL table(s) $tables can\'t be repaired. Other tables were repaired successfully.";
	}
	else { return "All MySQL tables were repaired successfully.";}
}

############################################################
sub RepairHTaccess{
    my(@content, @member, %MEM, $password,$db,@db,$sth);
	@db=&DefineMemberDB;
	$db=join(', ',@db);
    $sth=runSQL("SELECT $db FROM member");
	while (@member=$sth->fetchrow()){
        for (my $i=0; $i <@db; $i++){$MEM{$db[$i]}=$member[$i]};
		push(@content, "$MEM{'username'}:".crypt($MEM{'password'}, $CONFIG{seed}));
	}
	&FileWrite($ACCOUNT{password_file}, \@content) if (-f $ACCOUNT{password_file});
}
############################################################
sub RepairMemberDB{
	my(@content, @members, %MEM, @password);
	@members = &DirectoryFiles($CONFIG{member_path});
	foreach (@members){
		%MEM = &RetrieveMemberDB($_);
		next unless $MEM{username};
		push(@content, &DefineMemberString(\%MEM));
		if($MEM{status} eq "active"){	push(@password, "$MEM{'username'}:".crypt($MEM{'password'}, $CONFIG{seed}));	}
	}
	&FileWrite($CONFIG{member_db}, \@content);
	&FileWrite($ACCOUNT{password_file}, \@password) if (-f $ACCOUNT{password_file});
	chmod(0777, $ACCOUNT{password_file});
	chmod(0777, $CONFIG{member_db});
}
############################################################
1;
