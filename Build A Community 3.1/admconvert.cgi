#!/usr/bin/perl


##############################################################################
# PROGRAM : BuildACommunity.com Perl Module                                  #
# VERSION : 3.1                                                              #
#                                                                            #
# NOTES   :                                                                  #
##############################################################################
# All source code, images, programs, files included in this distribution     #
# Copyright (c) 1999 -> 2017                                                 #
#           Eric L. Pickup, Ecreations, BuildACommunity                      #
#           All Rights Reserved.                                             #
##############################################################################
#                                                                            #
#    ------ DO NOT MODIFY ANYTHING BELOW THIS POINT !!! -------              #
#                                                                            #
##############################################################################

  use File::Copy;
  use DB_File;

  require("common.pm"); 
  require $GPath{'admaster.pm'}; 
$accountsdb = "$GPath{'admaster_data'}/accounts.db";
$groupsdb = "$GPath{'admaster_data'}/groups.db";
$lastdb = "$GPath{'admaster_data'}/rotation.db";
$clickdb = "$GPath{'admaster_data'}/clicks.db";
$tot_imp = "$GPath{'admaster_data'}/acctimp.db";
$tot_clk = "$GPath{'admaster_data'}/acctclicks.db";
$showndb =    "$GPath{'admaster_data'}/exshown.db";
$creditsdb =  "$GPath{'admaster_data'}/excredits.db";
  &parse_FORM;

  $commandline = @ARGV[0];
  if ($commandline) { &Go_Upgrade; &Go_Convert if($DB_File); }
  else {
     $action = $FORM{'action'};

     if($action eq "Upgrade") { &Go_Upgrade; }
     elsif($action eq "Convert") { &Go_Convert; }
     else { &Form; }
  }
  exit 0;



sub Form {

   if($upgraded) {
      $form_title = "Convert your data to Binary Format ...";
      if($DB_File) {
         $form_content = <<DONECONTENT;
        <FONT COLOR="blue">DB_File is present on this server</FONT> you may proceed with the optional
        conversion to the Binary Database format.  This will take up some extra disk space, but the speed
        benifets are nothing short of eye popping....<BR><BR>
        <CENTER><INPUT NAME="action" TYPE="submit" VALUE="Convert"></CENTER>
DONECONTENT
      }
      else { 
         $form_content =<<DONEBAD 
        <FONT COLOR="red">DB_File not present on this server</FONT><BR><BR>
        You are finished with the data conversion from Ad-Master 2.x to Ad-Master 3.0<BR>
        You should now go to your admin.cgi, login, and make sure that all of the new
        settings are properly filled in.  This should only take a few minutes, and then
        you can test your banners from the users side...
DONEBAD
      }
   }

   else {
      $form_title = "Upgrade your data to the new Ad-Master 3 Format";
      $form_content = <<DONECONTENT;
        The first step in the upgrade process is to convert your existing bannermaster accounts
        to the new database format...<BR><BR>
        <FONT COLOR="red"><B>Make sure you backup your data directory before you begin !!!</B></FONT><BR><BR>
        <CENTER><INPUT NAME="action" TYPE="submit" VALUE="Upgrade"></CENTER>
DONECONTENT
   }

   print "Content-Type: text/html\n\n" if(! $content);
   print <<DONEFORM;
       <center>
       <form ENCTYPE=\"application/x-www-form-urlencoded\"  NAME="rply_form" METHOD="POST" ACTION="admconvert.cgi" ENCTYPE="x-www-form-urlencoded">
        <TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=600>
          <TR><TD BGCOLOR="black">
            <TABLE WIDTH="100%" BORDER="0" CELLSPACING="2" CELLPADDING="2">
              <tr bgcolor="black">
                <td width="100%" colspan="2" valign="MIDDLE">
                  <font face="tahoma,verdana,arial,helvetica" size="+1" color="ivory">
                      $form_title
                  </font>
                </td>
              </tr>
              <tr bgcolor="#FFFFFF">
                <td width="100%" colspan="2" valign="MIDDLE">
                   <font color="black" FACE="tahoma,verdana,arial,helvetica" SIZE="-1">
                   $form_content
              </font>
           </td>
        </tr>
     </table>
   </td>   
 </tr>
</table>
DONEFORM
   exit  0;

}

sub Go_Upgrade {

  print "Content-Type: text/html\n\n";

  if(! -d "$GPath{'admaster_data'}") {
     print "Working ...<BR><BR>\n";
     open(LOG,">>convert.log");
   
        &bm_Convert_Ascii;
        print ".";
   
     close(LOG);
  }

  ### Now, let's see if they can be advanced or not.
   eval {
       require DB_File;
   };
   if ($@) { $DB_File = 0; }
   else { $DB_File = 1; }

   $upgraded = 1;
   $content = 1;

   &Form if(! $commandline);

}

sub Go_Convert {

  require("$GPath{'adm_dbm.pm'}");

  print "Content-Type: text/html\n\n";

  print "Working ...<BR><BR>\n";
  open(LOG,">>convert.log");

     &bm_Convert_DBM;
     print ".";
     &bm_Verify;
     print ".";
chmod($accountsdb, 0777);
chmod($groupsdb, 0777);
chmod($lastdb, 0777);
chmod($clickdb, 0777);
chmod($tot_imp, 0777);
chmod($tot_clk, 0777);
chmod($showndb, 0777);
chmod($creditsdb, 0777);

  print "Finished.  Log file can be <a href=\"convert.log\">viewed here</a>\n";

  exit 0;

}


sub bm_Convert_Ascii {

  print LOG "Upgrading to Ad-Master Version 3 ASCII Format\n";
  print LOG "------------------------------------------------\n\n";

  # (1) Create the new directories needed

  system("mkdir $GPath{'admaster_data'}");
     if (-d "$GPath{'admaster_data'}") { print LOG "Ad-Master Directory Created\n"; }
     else { print LOG "Ad-Master Directory NOT Created\n"; }

  system("mkdir $GPath{'admaster_data'}/accounts");
     if (-d "$GPath{'admaster_data'}") { print LOG "Ad-Master Accounts Directory Created\n"; }
     else { print LOG "Ad-Master Accounts Directory NOT Created\n"; }

  system("mkdir $GPath{'admaster_data'}/exchange");
     if (-d "$GPath{'admaster_data'}") { print LOG "Ad-Master Exchange Directory Created\n"; }
     else { print LOG "Ad-Master Exchange Directory NOT Created\n"; }

  system("mkdir $GPath{'admaster_data'}/groups");
     if (-d "$GPath{'admaster_data'}") { print LOG "Ad-Master Groups Directory Created\n"; }
     else { print LOG "Ad-Master Groups Directory NOT Created\n"; }

  system("mkdir $GPath{'admaster_data'}/logs");
     if (-d "$GPath{'admaster_data'}") { print LOG "Ad-Master Logs Directory Created\n"; }
     else { print LOG "Ad-Master Logs Directory NOT Created\n"; }

  system("mkdir $GPath{'admaster_data'}/pending");
     if (-d "$GPath{'admaster_data'}") { print LOG "Ad-Master Pending Directory Created\n"; }
     else { print LOG "Ad-Master Pending Directory NOT Created\n"; }

  system("mkdir $GPath{'admaster_data'}/rotation");
     if (-d "$GPath{'admaster_data'}") { print LOG "Ad-Master Pending Rotation Directory Created\n"; }
     else { print LOG "Ad-Master Pending Rotation Directory NOT Created\n"; }



  # (2) Copy the account files and their logs
    open(ACCTS, "$data_dir/groups/accounts.list");
       foreach $account (<ACCTS>) {
          $account =~ s/\cM//g;
          $account =~ s/\n//g;
          $account =~ s/\r//g;

          copy("$data_dir/accounts/$account/$account.dat", "$GPath{'admaster_data'}/accounts/");
             if (-e "$GPath{'admaster_data'}/accounts/$account.dat") { print LOG "Account file ($account.dat) Moved\n"; }
             else { print LOG "Account file ($account.dat) NOT Moved\n"; }

          print " ... <BR>";

          opendir(ALOGS,"$data_dir/accounts/$account/logs");
              while ($file = readdir(ALOGS)) {
                   if ($file ne "." && $file ne "..") {
                      copy ("$data_dir/accounts/$account/logs/$file","$GPath{'admaster_data'}/logs/$account.$file");
                         if (-e "$GPath{'admaster_data'}/logs/$account.$file") { print LOG "Log file ($account.$file) Moved\n"; }
                         else { print LOG "Log file ($account.$file) NOT Moved\n"; }
                   }

                   print "-";
              }
          closedir(ALOGS);
       }
    close(ACCTS);


  # (3) Copy the group files
  system("cp -rp $data_dir/groups/* $GPath{'admaster_data'}/groups");
  opendir(GRPS,"$GPath{'admaster_data'}/groups/");
      while ($file = readdir(GRPS)) {
          if ($file =~ /.*\.grp/) {
              $newgroup = "";
              open(GRP1,"$GPath{'admaster_data'}/groups/$file");
                 foreach $grp (<GRP1>) {
                    $grp =~ s/\cM//g;
                    $grp =~ s/\n//g;
                    $grp =~ s/\r//g;
                    $newgroup .= "$grp|";
                 }
              close(GRP1);
              open(GRP2,">$GPath{'admaster_data'}/groups/$file");
                 print GRP2 $newgroup;
              close(GRP2);
              if (-e "$GPath{'admaster_data'}/groups/$file") { print LOG "Group file ($file) Re-Created\n"; }
              else { print LOG "Group file ($file) NOT Re-Created\n"; }
          } 
      }
  closedir(GRPS);

  # (4) Reset the permissions
  system("chmod -R 777 $GPath{'admaster_data'}");
    print LOG "Permissions on new bannermaster data directory are set to -R 777\n";

  # (5) Remove the old directories / Remove
  system ("rm -rf $data_dir/accounts");
     if (-d "$data_dir/accounts") { print LOG "Old Ad-Master Accounts Directory Could not be removed\n"; }
     else { print LOG "Old Ad-Master Accounts Directory Removed\n"; }

  system ("rm -rf $data_dir/groups");
     if (-d "$data_dir/groups") { print LOG "Old Ad-Master Groups Directory Could not be removed\n"; }
     else { print LOG "Old Ad-Master Groups Directory Removed\n"; }


  print LOG "\n\nAd-Master Finished\n";

}

sub bm_Convert_DBM {

  print LOG "Upgrading to Ad-Master Version 3 (DBM Format)\n";
  print LOG "------------------------------------------------\n\n";

  # (1) Convert the account .dat files
     tie (%acct, "DB_File", $accountsdb) || &diehtml($!);
     opendir(ACCTS,"$GPath{'admaster_data'}/accounts/");
        while ($account = readdir(ACCTS)) {
          if ($account =~ /.*\.dat/) {
             $account =~ s/\.dat//g;
             open(ACCT,"$GPath{'admaster_data'}/accounts/$account.dat");
              foreach $LINE(<ACCT>) { 
                 $acct{$account} = $LINE;
                 last; 
              }
             close(ACCT);      
             print LOG "Added $account: $acct{$account}\n";
          }

        }
     closedir(FILES);

     untie %acct;

  # (2) Convert the groups
     tie %groups, "DB_File", $groupsdb;
     open(GRPS,"$GPath{'admaster_data'}/groups/groups.list");
       foreach $group(<GRPS>) {
          chomp $group;
          $newgroup = "";
          open(GRP1,"$GPath{'admaster_data'}/groups/$group.grp");
              foreach $grp (<GRP1>) {
                 $grp =~ s/\cM//g;
                 $grp =~ s/\n//g;
                 $grp =~ s/\r//g;
                 $newgroup .= "|$grp";
              }
          close(GRP1);
          $groups{$group} = $newgroup;
      }
     close(GRPS);

     $newgroup = "";
     open(GRP2,"$GPath{'admaster_data'}/groups/default.grp");
         foreach $grp (<GRP2>) {
            $grp =~ s/\cM//g;
            $grp =~ s/\n//g;
            $grp =~ s/\r//g;
            $newgroup .= "|$grp";
         }
     close(GRP2);
     $groups{"default"} = $newgroup;

     $newgroup = "";
     open(GRP3,"$GPath{'admaster_data'}/groups/exchange.grp");
         foreach $grp (<GRP3>) {
            $grp =~ s/\cM//g;
            $grp =~ s/\n//g;
            $grp =~ s/\r//g;
            $newgroup .= "|$grp";
         }
     close(GRP3);
     $groups{"exchange"} = $newgroup;

     untie %groups;

  print LOG "\n\nAd-Master DBM Conversion Finished\n";

}


sub bm_Verify {

    print LOG ">>>>>>>>>> BANNERMASTER DATA VERIFICATION <<<<<<<<<<<\n\n";   
    print LOG "\n\nAccounts...\n";
    print LOG "---------------------------------\n";
    tie %acct, "DB_File", $accountsdb;
      foreach $key(keys %acct) { print LOG "$key ... $acct{$key}\n"; }
    untie %acct;

    print LOG "\n\nGroups...\n";
    print LOG "---------------------------------\n";
    tie %groups, "DB_File", $groupsdb;
      foreach $key(keys %groups) { print LOG "$key ... $groups{$key}\n"; }
    untie %groups;

}
