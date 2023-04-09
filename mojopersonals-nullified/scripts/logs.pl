############################################################
sub LogUser{
	my(%DB, @string, %LOG, @lines, $match, $username,$sth,$db,@db);
###if members opt for invisible mode then please do not log him
	my $username = $MEMBER{username}?$MEMBER{username}:$ENV{REMOTE_ADDR};
	&LogCleaning;
	@db=&DefineLogDB;
	$db=join(', ',@db);
	$sth=runSQL("SELECT $db FROM logs");
	while (@string=$sth->fetchrow()){
        for (my $i=0; $i <@db; $i++){$DB{$db[$i]}=$string[$i]};
        if($DB{username} eq $username) {
			if ($DB{mode} ne $MEMBER{P_invisible_mode}){
				$DB{mode}=$MEMBER{P_invisible_mode};
				&UpdateLogDB(\%DB);
			}
			$match = 1;
			last;
	   }
        elsif ($MEMBER{username} and ($DB{username} eq $ENV{REMOTE_ADDR})) {
                 $match=1;
                 $DB{username}=$MEMBER{username};
				 $DB{logtime}=&TimeNow();
				 $DB{type}=$FORM{type};
				 $DB{class}=$FORM{class};
				 $DB{action}=$FORM{action};
				 &UpdateLogDB(\%DB);
                 last;
        }
	}
	unless($match){
        %LOG = ("username" => "$username", "logtime"=>&TimeNow(),"ip"=>$ENV{REMOTE_ADDR}, "type"=>$FORM{type}, "class"=>$FORM{class}, "action"=>$FORM{action}, "mode"=>$MEMBER{P_invisible_mode});
		&AddLogDB(\%LOG);
	}
}

sub LogUserOut{
    my($username,$sth);
	$username=$dbh->quote($MEMBER{username});
	$sth=runSQL("DELETE FROM logs WHERE username=$username");
}


############################################################
sub LogCleaning{
	my($time,$sth);
	$time = &TimeNow;
	$sth=runSQL("DELETE FROM logs WHERE logtime + 900 < $time");
}
################################################################
sub Whoisonline{
	my (%DB, $guests, @guests, $html, %MEM, $total, $users, @users, @invisible, %STAT,$sth,
	$db,@db,@string);

	@db=&DefineLogDB;
	$db=join(', ',@db);
	$sth=runSQL("SELECT $db FROM logs");
	while (@string=$sth->fetchrow()){
        for (my $i=0; $i <@db; $i++){$DB{$db[$i]}=$string[$i]};
		if($DB{mode}){	push(@invisible, $DB{username}); next;	}

		%MEM = &isMemberExist($DB{username});
		if($MEM{username}){	push(@users, $DB{username});	}
		else{			push(@guests, $DB{username});	}
	}
	foreach (@users){
		$html .= qq|<a href="$CONFIG{member_url}&action=view&profile=$_">$_</a>,&nbsp;|;
	}
	$html =~ s/(,&nbsp;)+$//g;
	$html = "none" unless $html;
	$STAT{guests} =  @guests;
	$STAT{users}  =  @users;
	$STAT{invisible}=@invisible;
	$total = $STAT{guests} + $STAT{users} + $STAT{invisible};
	
	my $plural = ($total > 1)?"are $total users":"is $total user";
	$MOJO{whoisonline}= qq|There $plural online: |;
	
#	if($STAT{users}){		$MOJO{whoisonline} .= qq|$STAT{users} members,|;		}
#	if($STAT{guests}){	$MOJO{whoisonline} .= qq|$STAT{guests} guests,|;		}
#	if($STAT{invisible}){$MOJO{whoisonline} .= qq|$STAT{invisible} hiddens.|;	}
	
	$MOJO{whoisonline} .= qq|$STAT{users} members, $STAT{guests} guests, and $STAT{invisible} hiddens. <br>Registered users: $html<br>|;
	return $MOJO{whoisonline};
}
############################################################
############################################################
############################################################

1;
