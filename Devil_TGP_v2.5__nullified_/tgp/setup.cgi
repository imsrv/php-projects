#!/usr/bin/perl
# Program Name         : TGPDevil TGP System                    
# Program Version      : 2.5
# Program Author       : Dot Matrix Web Services                
# Home Page            : http://www.tgpdevil.com                
# Supplied by          : CyKuH                                  
# Nullified By         : CyKuH                                  
require "config.pl";
use DBI;
use CGI::Carp qw(fatalsToBrowser);
print "Content-type: text/html\n\n";


print "<html>\n";
print "\n";
print "<head>\n";
print "<meta http-equiv=\"Content-Language\" content=\"en-us\">\n";
print "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=windows-1251\">\n";
print "<title>MySQL Database Setup</title>\n";
print "</head>\n";
print "\n";
print "<body>\n";
print "<p align=\"center\"><font face=\"Verdana\">Nullified by CyKuH\n";
print "\n";
print "<p align=\"center\"><font face=\"Verdana\"><b>Please wait, setup is attempting to\n";
print "create tables in your MySQL database.</b></font><!--CyKuH--></p>\n";
print "\n";
print "<p align=\"center\"><font face=\"Verdana\"><b>If you don't see a green box below\n";
print "within a few seconds, verify that you have set your MySQL username, password and\n";
print "DB name correctly in config.pl!</b></font></p>\n";






$dbh = DBI->connect("dbi:mysql:$database:$dbhost:$dbport","$user","$pass") || die("Can not connect to mySQL database!\n");
########## Create Tables ################
my($query) = "CREATE TABLE DMtgpads (
   webcate varchar(100) NOT NULL,
   adcode longtext NOT NULL
);";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;

my($query) = "CREATE TABLE DMtgpdead (
  deadurl varchar(255) NOT NULL default '',
  idnum varchar(20) NOT NULL default ''
);";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;

my($query) = "CREATE TABLE DMtgpblind (
   linkname varchar(25) NOT NULL,
   linkurl varchar(125) NOT NULL,
   linkdesc varchar(254) NOT NULL,
   numpics varchar(254) NOT NULL
);";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;

        my($query) = "CREATE TABLE DMtgpcategories (
   catname varchar(100) NOT NULL,
   catdesc varchar(254) NOT NULL
);";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;

   my($query) = "CREATE TABLE DMtgpgalleries (
   webname varchar(40) DEFAULT '0' NOT NULL,
   webemail varchar(40) DEFAULT '0' NOT NULL,
   weburl varchar(125) DEFAULT '0' NOT NULL,
   webcate varchar(100) DEFAULT '0' NOT NULL,
   webpics int(3) DEFAULT '0' NOT NULL,
   webdesc varchar(200) DEFAULT '0' NOT NULL,
   webdate varchar(14) NOT NULL,
   datecode int(10) DEFAULT '0' NOT NULL,
   approval char(2) DEFAULT '0' NOT NULL,
   idnum int(15) DEFAULT '0' NOT NULL,
   webip varchar(15) DEFAULT '0.0.0.0' NOT NULL,
   uniqueid varchar(8) DEFAULT '00000000' NOT NULL,
   vermail char(1) DEFAULT '1' NOT NULL,
   stamp varchar(14) NOT NULL,
   rate smallint(2) NOT NULL default '5',
   aff tinyint(1) NOT NULL default '0',
   PRIMARY KEY (idnum),
   KEY webdesc (webdesc)
);";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;

        my($query) = "CREATE TABLE DMtgppolice (
   idnum int(10) DEFAULT '0' NOT NULL,
   posturl varchar(254) NOT NULL,
   reports int(4) DEFAULT '0' NOT NULL,
   ipaddy varchar(15) NOT NULL
);";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;

                my($query) = "CREATE TABLE DMtgptemps (
   tagname varchar(45) NOT NULL,
   category varchar(100) NOT NULL,
   startat varchar(10) NOT NULL,
   endat varchar(10) NOT NULL
);";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
        
my($query) = "CREATE TABLE DMtgppartners (
affname varchar(50) NOT NULL default '', 
email varchar(254) NOT NULL default '', 
passw varchar(25) NOT NULL default '', 
ppd char(1) NOT NULL default '', 
app char(1) NOT NULL default '', 
drate int(2) NOT NULL default '0', 
KEY affname (affname)
);";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;

my($query) = "CREATE TABLE DMtgppposts (
affname varchar(50) NOT NULL default '', 
url varchar(254) NOT NULL default '', 
date date NOT NULL default '0000-00-00' 
);";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
        
my($query) = "CREATE TABLE DMtgpredirects ( 
tgpbase varchar(255) NOT NULL default '', 
you varchar(255) NOT NULL default '' 
);";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;


############## Populate Tables ###############################
############# Populate Categories ############################

my($query) = "INSERT INTO DMtgpcategories VALUES ( 'Brunettes', 'Brunettes');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgpcategories VALUES ( 'Blondes', 'Blondes');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgpcategories VALUES ( 'Amateurs', 'Amateurs');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgpcategories VALUES ( 'Asians', 'Asians');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgpcategories VALUES ( 'Anal Sex', 'Anal');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgpcategories VALUES ( 'Oral Sex', 'Oral');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgpcategories VALUES ( 'Cumshots', 'Cumshots');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgpcategories VALUES ( 'Dicks/Shemales', 'DicksandShemales');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgpcategories VALUES ( 'Fetish/Bondage/Watersports', 'FetishBondageWatersports');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgpcategories VALUES ( 'Babes', 'Babes');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgpcategories VALUES ( 'Groups', 'Groups');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgpcategories VALUES ( 'Hardcore', 'Hardcore');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgpcategories VALUES ( 'Interracial', 'Interracial');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgpcategories VALUES ( 'Cheerleaders/Uniforms', 'CheerleadersUniforms');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgpcategories VALUES ( 'Legal Teens', 'Teens');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgpcategories VALUES ( 'Lesbians', 'Lesbians');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgpcategories VALUES ( 'Voyeur/Exhibitionists/Upskirts', 'VoyeurExhibitionistsUpskirts');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgpcategories VALUES ( 'Fat Women (BBW)', 'Fat');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgpcategories VALUES ( 'Redheads', 'Redheads');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgpcategories VALUES ( 'Celebrities', 'Celebrities');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgpcategories VALUES ( 'Older Women', 'Older');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgpcategories VALUES ( 'Sex Toys', 'Toys');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgpcategories VALUES ( 'Pregnant', 'Pregnant');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgpcategories VALUES ( 'Blondes', 'Blondes');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgpcategories VALUES ( 'Videos/MPEGs/AVIs', 'Video');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgpcategories VALUES ( 'Gays', 'Gays');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;

######## Populate Templates #####################################


my($query) = "INSERT INTO DMtgptemps VALUES ( 'ARCHSET', 'Universal', '31', '1000');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgptemps VALUES ( 'AMA1', 'Amateurs', '0', '15');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgptemps VALUES ( 'AMA2', 'Amateurs', '16', '15');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgptemps VALUES ( 'ANA1', 'Anal Sex', '0', '15');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgptemps VALUES ( 'ANA2', 'Anal Sex', '16', '15');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgptemps VALUES ( 'ASI1', 'Asians', '0', '15');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgptemps VALUES ( 'ASI2', 'Asians', '16', '15');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgptemps VALUES ( 'ASS1', 'Asses/Pussy Shots', '0', '15');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgptemps VALUES ( 'ASS2', 'Asses/Pussy Shots', '16', '15');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgptemps VALUES ( 'BAB1', 'Babes', '0', '15');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgptemps VALUES ( 'BAB2', 'Babes', '16', '15');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgptemps VALUES ( 'BLO1', 'Blondes', '0', '15');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgptemps VALUES ( 'BLO2', 'Blondes', '16', '15');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgptemps VALUES ( 'BRU1', 'Brunettes', '0', '15');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgptemps VALUES ( 'BRU2', 'Brunettes', '16', '15');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgptemps VALUES ( 'CEL1', 'Celebrities', '0', '15');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgptemps VALUES ( 'CEL2', 'Celebrities', '16', '15');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgptemps VALUES ( 'CHE1', 'Cheerleaders/Uniforms', '0', '15');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgptemps VALUES ( 'CHE2', 'Cheerleaders/Uniforms', '16', '15');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgptemps VALUES ( 'CUM1', 'Cumshots', '0', '15');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgptemps VALUES ( 'CUM2', 'Cumshots', '16', '15');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgptemps VALUES ( 'DIC1', 'Dicks/Shemales', '0', '15');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgptemps VALUES ( 'DIC2', 'Dicks/Shemales', '16', '15');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgptemps VALUES ( 'FAT1', 'Fat Women (BBW)', '0', '15');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgptemps VALUES ( 'FAT2', 'Fat Women (BBW)', '16', '15');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgptemps VALUES ( 'FET1', 'Fetish/Bondage/Watersports', '0', '15');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgptemps VALUES ( 'FET2', 'Fetish/Bondage/Watersports', '16', '15');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgptemps VALUES ( 'GAY1', 'Gays', '0', '15');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgptemps VALUES ( 'GAY2', 'Gays', '16', '15');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgptemps VALUES ( 'GRO1', 'Groups', '0', '15');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgptemps VALUES ( 'GRO2', 'Groups', '16', '15');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgptemps VALUES ( 'HAR1', 'Hardcore', '0', '15');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgptemps VALUES ( 'HAR2', 'Hardcore', '16', '15');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgptemps VALUES ( 'INT1', 'Interracial', '0', '15');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgptemps VALUES ( 'INT2', 'Interracial', '16', '15');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgptemps VALUES ( 'LEG1', 'Legal Teens', '0', '15');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgptemps VALUES ( 'LEG2', 'Legal Teens', '16', '15');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgptemps VALUES ( 'LES1', 'Lesbians', '0', '15');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgptemps VALUES ( 'LES2', 'Lesbians', '16', '15');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgptemps VALUES ( 'OLD1', 'Older Women', '0', '15');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgptemps VALUES ( 'OLD2', 'Older Women', '16', '15');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgptemps VALUES ( 'ORA1', 'Oral Sex', '0', '15');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgptemps VALUES ( 'ORA2', 'Oral Sex', '16', '15');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgptemps VALUES ( 'PRE1', 'Pregnant', '0', '15');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgptemps VALUES ( 'PRE2', 'Pregnant', '16', '15');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgptemps VALUES ( 'RED1', 'Redheads', '0', '15');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgptemps VALUES ( 'RED2', 'Redheads', '16', '15');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgptemps VALUES ( 'SEX1', 'Sex Toys', '0', '15');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgptemps VALUES ( 'SEX2', 'Sex Toys', '16', '15');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgptemps VALUES ( 'VID1', 'Videos/MPEGs/AVIs', '0', '15');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgptemps VALUES ( 'VID2', 'Videos/MPEGs/AVIs', '16', '15');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgptemps VALUES ( 'VOY1', 'Voyeur/Exhibitionists/Upskirts', '0', '15');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgptemps VALUES ( 'VOY2', 'Voyeur/Exhibitionists/Upskirts', '16', '15');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgptemps VALUES ( 'ARC1', 'Universal', '31', '500');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgptemps VALUES ( 'ARC2', 'Universal', '531', '500');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;


my($query) = "CREATE TABLE DMtgpdeclines (
  decname varchar(35) NOT NULL default '',
  decvalue text NOT NULL
);";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;


my($query) = "INSERT INTO DMtgpdeclines VALUES ('Broken Recip', 'We require a working recip. link. Yours does not seem to be working or doesn&#39;t exist.');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgpdeclines VALUES ('Sponsor Content', 'Overuse of sponsor content or content that we receive often.');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgpdeclines VALUES ('Broken Pics', 'Some of your pics/videos seemed to be broken.');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgpdeclines VALUES ('Popups', 'Popups on your page. We do not list ANY galleries with popups.');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgpdeclines VALUES ('Too many ads.', 'Too many advertisements.');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;my($query) = "INSERT INTO DMtgpdeclines VALUES ('Poor quality', 'Either your gallery design or the content was of very poor quality.');";
my($query) = "INSERT INTO DMtgpdeclines VALUES ('Unspecified', 'No specific reason given.');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;
my($query) = "INSERT INTO DMtgpdeclines VALUES ('404', 'Your page returned a 404 (Page not found) error.');";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;

my($query) = "CREATE TABLE DMtgpfilter (
  fname varchar(255) NOT NULL default '',
  ffilter varchar(255) NOT NULL default '',
  freason varchar(255) NOT NULL default ''
);";
        my($sth) = $dbh->prepare($query);
        $sth->execute() or die "Unable to execute query: ".$sth->errstr;
        $sth->finish;



print "<div align=\"center\">\n";
print "  <center>\n";
print "  <table border=\"0\" cellspacing=\"0\" width=\"65%\" cellpadding=\"0\" bgcolor=\"#00FF00\">\n";
print "    <tr>\n";
print "      <td width=\"100%\">\n";
print "        <p align=\"center\"><font face=\"Verdana\"><b>Tables were created!</b></font></p>\n";
print "        <p align=\"center\"><b><i><font face=\"Verdana\" size=\"4\">You will not need\n";
print "        setup.cgi again!<!--CyKuH--></font></i></b><font face=\"Verdana\"><b><br>\n";
print "        Make sure to either reset permissions on it so it may not be executed\n";
print "        again or delete it from your server!</b></font></td>\n";
print "    </tr>\n";
print "  </table>\n";
print "  </center>\n";
print "</div>\n";

print "</body>\n";
print "\n";
print "</html>\n";