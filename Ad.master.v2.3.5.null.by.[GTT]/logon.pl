use DBI;
sub login {
  $dbh = DBI->connect("DBI:mysql:add:localhost", 'root', '') || print "Can't connect: $DBI::errstr
";
  return $dbh;
}
1;
