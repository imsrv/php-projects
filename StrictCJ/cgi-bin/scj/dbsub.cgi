##########################################
## Create a connection to the database. ##
##########################################
sub DB_Connect{ ### DONT TOUCH THIS LINE #
##########################################
# EDIT VARIABLES BELOW                   #
##########################################
# the same as dbconnect.inc.php          
  my $db_name = "your_database_name";             
  my $host = "localhost";                 
  my $user = "your_user_name";                    
  my $pw  = "your_password";                    
##########################################
# DO NOT EDIT BELOW THIS                 #
##########################################
  use DBI;
  my $DSN = "DBI:mysql:database=$db_name;host=$host";
  my $dbh = DBI->connect($DSN,$user,$pw)
   or die "Cannot connect: $DBI::errstr\n";
  return($dbh);
}

##########################################
## Executes the SQL command and then    ##
## returns to the calling area of the   ##
## program.                             ##
##########################################
sub Do_SQL{
  my($dbh,$SQL) = @_;	
  my($sth);
  eval{
    $sth = $dbh->prepare($SQL);
  }; # End of eval
 # Check for errors.
  if($@){
    $dbh->disconnect;
    print "Content-type: text/html\n\n";
    print "An ERROR occurred! $@\n";
    exit;
  } else {
   $sth->execute;
  }
  return ($sth);
}
1;