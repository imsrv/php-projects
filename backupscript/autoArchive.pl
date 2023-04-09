#####################################################################################
#
# autoArchive.pl
# A Perl script to backup, and eMail the resulting archive, a MySQL database.
# Copyright (C) 2003  C. Duncan Hudson
#                     http://www.dunc-it.com
#                     info@dunc-it.com
#
# This program is free software; you can redistribute it and/or
# modify it under the terms of the GNU General Public License
# as published by the Free Software Foundation; either version 2
# of the License, or (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# 
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
#
#####################################################################################
#!/usr/bin/perl -w
use DBI;
use Mail::Sender;

$space = ' ';

#### Read the backup directives
open(CONF, "<$ARGV[0]") || die "\nCan't open CONF file.\nPlease specify the full name and path of the .autoArchive.conf file.\n";
while ($line = <CONF>){
      if ($line =~ /^(\S+)\s+=\s+'(\S+)';/){
         my ($var, $value) = (substr($1,1,length($1)), $2); 
         $$var = $value;               
         }
      }
close(CONF); 

#### Build list of DBs
if ($all_dbs eq 'yes'){
   @selected_dbs = get_dbs();
   }

#### Loop through DBs in list
while ($selected_dbs[$db_loop]){
      #### Build list of tables for this DB
      if ($all_tables eq 'yes'){
         @selected_tables = get_tables();}
      archive_data();
      $db_loop++;
      }

#### Get all the DB names
sub get_dbs{
    $dbh = logon();
    $sth = $dbh->prepare("show databases") 
        or die "Can't create SQL statement\n$DBI::errstr";
    $rc  = $sth->execute 
        or die "Can't execute SHOW DATABASEs\n$DBI::errstr";

    while ($db_name = $sth->fetchrow_array) {
          $dbs [$db_count++] = $db_name;
          }
    logoff();
    return @dbs;
    }

#### Get all the table names
sub get_tables{
    $table_count = 0;
    $db_in       = $selected_dbs[$db_loop];
    $dbh         = logon();

    $sth = $dbh->prepare("Show Tables")    
        or die "Can't create SQL statement: $DBI::errstr";
    $rc  = $sth->execute 
        or die "Can't SHOW tables in $db_in's database: $DBI::errstr";   

    while ($table_name = $sth->fetchrow_array){
          $tables [$table_count++] = $table_name . ' ';
          }
    logoff();
    return @tables;
    }

 #### DBI Logon process
 sub logon{
     $dbh = DBI->connect("DBI:mysql:$db_in:$db_host:$db_port", $user, $password)
          or die "Can't logon to database:\n$DBI::errstr";
     }

 #### DBI Logoff process
 sub logoff{
     return $dbh->disconnect;
     }

 #### Backup the database
 sub archive_data{
     $time_in = time();
     if ($user ne ''){
        $logon = '--user=' . $user;}
     if ($password ne ''){
        $logon = $logon . ' --password=' . $password;}

     $month     = substr($time = localtime, 4, 3);
     if (($day  = substr($time, 8, 2)) < 10){
        $day    = '0' . substr($day, 1, 1);}
     $year      = substr($time, 20, 4);
     $date      = $month . $date_seperator . $day . $date_seperator . $year;
     $dump_file = $dump_directory . $selected_dbs[$db_loop] . '.' . $date . '.' . $dump_extension;   

     $dump_command = $dump_path .$dump_prog   . $space . 
                     $dump_parms              . $space .
                     $logon                   . $space .
                     $selected_dbs[$db_loop]  . $space .
                     '>'                      . $space .
                     $dump_file;

     $gzip_command = $gzip_path . $gzip_prog  . $space .
                     $gzip_parms              . $space .
                     $dump_file;

     $OS_return .= `$dump_command`;
     $OS_return .= `$gzip_command`;

     $time_out = time();
     mail_archive();
     }

 #### Email the backup files
 sub mail_archive{
     if ($smtp_auth eq 'yes'){
        pop_authentication();}

     $time_taken       = elapsed_time();
     $email_subject    = $selected_dbs[$db_loop] . ' DB Backup - ' . $date;
     $email_attachment = $dump_file . $gzip_extension;
     $message_body     = 'Note:  The database backup took: ' . $time_taken . ' to complete.';
     print "$smtp, $email_from, $email_to, $email_subject\n$message_body\n$email_attachment\n";
     $sender = new Mail::Sender 
                       {smtp    => $smtp,   
                        from    => $email_from};
     $sender->MailFile({to      => "$email_to",
                        subject => "$email_subject",
                        msg     => "$message_body",
                        file    => $email_attachment})
           or die "Backup file EMailing Failed.\n$Mail::Sender::Error\n";
     }

 ### Note execution time
 sub elapsed_time{
     $timediff = $time_out - $time_in;
     $hours    = int ($timediff / 3600);
     $minutes  = int ($timediff / 60);
     $seconds  = $timediff - ($hours * 3600) - ($hours * 60);     
     return $hours . ' hrs ' . $minutes . ' mins ' . $seconds . ' secs ';
     }

 ### POP3 Logon
 sub pop_authentication{
     use Mail::POP3Client;
     $pop = new Mail::POP3Client(USER     => $pop_user,
                                 PASSWORD => $pop_pwd,
                                 HOST     => $pop,
                                 DEBUG    => 99)
         or die "POP3 Authentication Failed.\n$Mail::POP3Client::Error\n";
     $pop->Close();
     }
