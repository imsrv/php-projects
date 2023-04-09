#!/usr/bin/perl
#  catalog-all.pl
#    catalog all repositories by counting all that are in the database
#    and looping, for Photoseek
#
#  code : jeff b (jeff@univrel.pr.uconn.edu)
#  lic  : GPL, v2

# ///////////////////////////////////////////////////////////////////
#                Set your database variables here
# ///////////////////////////////////////////////////////////////////

$ADMIN_USER="admin";
$ADMIN_PASS="password";
$DB_NAME="photoseek";
$PHOTOSEEK_URL="http://localhost/photoseek";
$LOG_FILE="/var/log/photoseek.log";


# ///////////////////////////////////////////////////////////////////
#                   don't modify the code below
# ///////////////////////////////////////////////////////////////////

$COUNT=`mysql -p"$ADMIN_PASS" -E -e "SELECT COUNT(*) FROM $DB_NAME.repositories" | grep "COUNT" | awk -F: '{ print \$2 }'`;

for ($this_count=1;$this_count<=$COUNT;$this_count++) {
  exec ("catalog.sh $this_count");
} # end of loop
