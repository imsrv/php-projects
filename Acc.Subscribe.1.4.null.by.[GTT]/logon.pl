use DBI;

sub login {
  $dbh = DBI->connect("DBI:mysql:mailmanager:localhost", 'root', '') || print "Can't connect: $DBI::errstr\n";
  return $dbh;
}

1;
