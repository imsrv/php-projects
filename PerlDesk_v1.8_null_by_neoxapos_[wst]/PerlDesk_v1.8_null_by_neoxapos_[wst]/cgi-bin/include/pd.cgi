 sub get_vars 
  {
     my %global;
     my $statement = 'SELECT * FROM perlDesk_settings'; 
     my $sth       = $dbh->prepare($statement) or die print "Couldn't prepare statement: $DBI::errstr; stopped";
        $sth->execute() or die print "Couldn't execute statement: $DBI::errstr; stopped";
          while(my $ref = $sth->fetchrow_hashref()) 
           {
                  my $setting       = $ref->{'setting'};
                  $global{$setting} = $ref->{'value'};
           }  
       $sth->finish;
 
      $epre  = $global{'epre'};
      return %global;
  }

 sub die_nice 
  {
     my $error = "@_";
     print "Content-type: text/html\n\n";
      print qq|
                <html><head><title>Error</title></head><body bgcolor="#FFFFFF"><p>&nbsp;</p><table width="400" border="0" cellspacing="1" cellpadding="0" align="center">
                <tr bgcolor="#666666"><td colspan="3"><table width="100%" border="0" cellspacing="1" cellpadding="0"><tr bgcolor="#E0E6ED"><td><table width="100%" border="0" cellspacing="1" cellpadding="4">
                <tr><td rowspan="2" width="21%"><div align="center"><img src="$global{'imgbase'}/error.gif"></div>
                </td><td width="79%" height="2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>ERROR </b></font></td></tr><tr><td width="79%" height="33"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">$error</font></td>
                </tr></table></td></tr></table></td></tr></table></body></html>
              |;
     exit; 
 }


1;