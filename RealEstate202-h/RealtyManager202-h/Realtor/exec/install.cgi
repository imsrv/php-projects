#!/usr/local/bin/perl
# -----------------------------------------------------------------------------
# Edis Realty Manager v2.00 - Installation Program
# Copyright (C) 1998-1999 Edis Digital Inc. All Rights Reserved
# http://www.edisdigital.com/
# -----------------------------------------------------------------------------
# This program is protected by Canadian and international copyright laws. Any
# use of this program is subject to the the terms of the license agreement
# included as part of this distribution archive. Any other uses are stictly
# prohibited without the written permission of Edis Digital and all other
# rights are reserved.
# -----------------------------------------------------------------------------
# Version History:
#
# v2.00 - Jun/25/1999 - Initial Release
# -----------------------------------------------------------------------------
# Warning : Modifying the source code violates your license agreement!
# -----------------------------------------------------------------------------

 $SIG{__DIE__} = $SIG{__WARN__} = \&HTML_Error;		# show error msg on die/warn

 ### Set Global Vars
 %Global   = ("progVer"  => "2.00",					# Program Version
	      "progRel"  => "June 25th, 1999",				# Release Date
	      "progUpd"  => "June 25th, 1999",				# Last Updated
	      "perlOS"   => $^O || "Unknown",				# Server OS
	      "perlVer"  => $]  || "Unknown",				# Server Perl Ver
	      "cgidir"   => $0=~m#^(.*)[\\/]#?$1:(`pwd`=~/(.*)/)[0],	# script directory
	      "cgiurl"   => (split("/",$ENV{'SCRIPT_NAME'}))[-1],	# script url
	      "ltime"    => time,					# local time
	      "stime"    => time,					# server time
	      );

 ### Generate Database Field Names
 for (0..9)  { push(@ListingDB_Fields,"limage$_"); }
 for (1..50) { push(@ListingDB_Fields,"lfield$_"); }
 for (0..9)  { push(@UserDB_Fields,"himage$_"); }
 for (1..50) { push(@UserDB_Fields,"hfield$_"); }
 for (1..50) { push(@SetupDB_Fields,"lfield$_"."_name");
	       push(@SetupDB_Fields,"lfield$_"."_type");
	       push(@SetupDB_Fields,"lfield$_"."_active"); }
 for (1..50) { push(@SetupDB_Fields,"hfield$_"."_name");
	       push(@SetupDB_Fields,"hfield$_"."_type");
	       push(@SetupDB_Fields,"hfield$_"."_active"); }

 ### Database definitions
 %ListingDB  = ("datafile" => "listing.dat",
		"filelock" => "filelock.lock",
		"fields"   => [qw(num owner created updated),@ListingDB_Fields],
		"backup"   => "disabled",
		"cgiext"   => ".cgi");

 %UserDB     = ("datafile" => "user.dat",
		"filelock" => "filelock.lock",
		"fields"   => [qw(num name login_id login_pw access created_mon created_day created_year expires_mon expires_day expires_year expires_date expires_never disabled listings_max listings_unlimited user_listed specify_filename homepage_filename notes),@UserDB_Fields],
		"backup"   => "disabled",
		"cgiext"   => ".cgi");

 %SetupDB    = ("datafile" => "setup.dat",
		"filelock" => "filelock.lock",
		"fields"   => ["num", @SetupDB_Fields, qw(company_name domain_name product_id publish_listing_index publish_homepage_index publish_listing_image0 publish_homepage_image0 upload_maxk login_timeout listing_perpage homepage_perpage userman_perpage db_sorting titlebar footerbar logoff_url image_url listing_dir listing_url homepage_dir homepage_url search_url time_adjh time_adj_hour time_adjm time_adj_min installed)],
		"backup"   => "disabled",
		"cgiext"   => ".cgi");

 %HelpDB    = ("datafile" => "help.dat",
		"filelock" => "filelock.lock",
		"fields"   => [qw(num parent title content)],
		"backup"   => "disabled",
		"cgiext"   => ".cgi");

### LOAD STUFF


  %in  = &ReadForm;				# Read CGI Form input
  %ck  = &ReadCookie;				# Load Browser Cookies
  &DB_Load(\%SetupDB, \%setup, 1);		# Load Setup Values

  ### Make Setup Values Global
  $Global{'titlebar'}	   = $setup{'titlebar'};
  $Global{'footerbar'}	   = $setup{'footerbar'};
  $Global{'image_url'}     = $setup{'image_url'};
  $Global{'homepage_url'}  = $setup{'homepage_url'};
  $Global{'listing_url'}   = $setup{'listing_url'};
  $Global{'search_url'}    = $setup{'search_url'};

  ### Adjust time for local time zone
  if ($setup{'time_adjh'} eq "add")	{ $Global{'ltime'} += (int($setup{'time_adj_hour'}*60*60)) };
  if ($setup{'time_adjh'} eq "minus")	{ $Global{'ltime'} -= (int($setup{'time_adj_hour'}*60*60)) };
  if ($setup{'time_adjm'} eq "add")	{ $Global{'ltime'} += (int($setup{'time_adj_min'}*60)) };
  if ($setup{'time_adjm'} eq "minus")	{ $Global{'ltime'} -= (int($setup{'time_adj_min'}*60)) };

  ### Current Time Values
  $ltime{'mon'}  = (localtime($Global{'ltime'}))[4]+1;
  $ltime{'day'}  = (localtime($Global{'ltime'}))[3];
  $ltime{'year'} = (localtime($Global{'ltime'}))[5]+1900;
  $ltime{'date'} = sprintf("%04d%02d%02d",$ltime{'year'},$ltime{'mon'},$ltime{'day'});

  $|++;									# Unbuffer output
#!/usr/local/bin/perl
# -----------------------------------------------------------------------------
# Edis Realty Manager v2.00 - Installation Wizard 
# Copyright (C) 1998-1999 Edis Digital Inc. All Rights Reserved
# http://www.edisdigital.com/
# -----------------------------------------------------------------------------
# This program is protected by Canadian and international copyright laws. Any
# use of this program is subject to the the terms of the license agreement
# included as part of this distribution archive. Any other uses are stictly
# prohibited without the written permission of Edis Digital and all other
# rights are reserved.
# -----------------------------------------------------------------------------
# Version History:
#
# v2.00 - Jun/25/1999 - Initial Release
# -----------------------------------------------------------------------------

### undefine global settings
delete $Global{'listing_url'};
delete $Global{'homepage_url'};
delete $Global{'image_url'};

# -----------------------------------------------------------------------------
# Main : Test conditions and give commands
# -----------------------------------------------------------------------------

  ### Check if already installed
  if ($setup{'installed'})	{ &Step8; }

  ### Installation Wizard
  if	($in{'step1'})		{ &Step1; }
  elsif	($in{'step2'})		{ &Step2; }
  elsif	($in{'step3'})		{ &Step3; }
  elsif	($in{'step3_save'})	{ &Step3_Save; }
  elsif	($in{'step4'})		{ &Step4; }
  elsif	($in{'step4_save'})	{ &Step4_Save; }
  elsif	($in{'step5'})		{ &Step5; }
  elsif	($in{'step5_save'})	{ &Step5_Save; }
  elsif	($in{'step6'})		{ &Step6; }
  elsif	($in{'step6_save'})	{ &Step6_Save; }
  elsif	($in{'step7'})		{ &Step7; }
  elsif	($in{'step7_save'})	{ &Step7_Save; }
  elsif	($in{'step8'})		{ &Step8; }
  elsif	($in{'step8_upgrade'})	{ &Step8_Upgrade; }
  elsif	($in{'step9'})		{ &Step9; }
  else				{ &Step1; }

exit;

# -----------------------------------------------------------------------------
# Function    : Step 1
# Description : 
# -----------------------------------------------------------------------------

sub Step1 {

  print "Content-type: text/html\n\n";
  print &Template("_install_step1.html",\%help);
  exit;
}

# -----------------------------------------------------------------------------
# Function    : Step 2
# Description : 
# -----------------------------------------------------------------------------

sub Step2 {

  &Template("_install_step2.html");				# Load template cells

  my(@files)=  ("/exec/",
		"/exec/rm.cgi",
		"/exec/search.cgi",
		"/data/",
		"/data/help.dat.cgi",
		"/data/listing.dat.cgi",
		"/data/interface.dat.cgi",
		"/data/setup.dat.cgi",
		"/data/user.dat.cgi",
		"/templates/",
		"/templates/_publish_homepage.html",
		"/templates/_publish_homepage_index.html",
		"/templates/_publish_listing.html",
		"/templates/_publish_listing_index.html",
		"/templates/_search_query.html",
		"/templates/_search_results.html");

  foreach (@files) {
    $out{'error'} = "";
    $out{'file'} = $_;

    ### Check Directories
    if ($out{'file'} =~ /\/$/) {
      $dir = "$Global{'cgidir'}/..$out{'file'}";
      if (!-e $dir)				{ $out{'error'} .= &TemplateCell('dir_noexist'); }
      if (!-r $dir)				{ $out{'error'} .= &TemplateCell('dir_noread'); }
      if ($out{'file'} eq "/data/" && !-w $dir) { $out{'error'} .= &TemplateCell('dir_nowrite'); }
      if ($Global{'perlOS'} !~ /win/i) {
        if ($out{'file'} eq "/exec/" && !-x $dir) { $out{'error'} .= &TemplateCell('dir_noexec'); }
        }
      }

    ### Check Program Files
    if ($out{'file'} =~ /rm\.cgi/ || $out{'file'} =~ /search\.cgi/) {
      $file = "$Global{'cgidir'}/..$out{'file'}";
      if (!-e $file)			{ $out{'error'} .= &TemplateCell('file_noexist'); }
      if (!-r $file)			{ $out{'error'} .= &TemplateCell('file_noread'); }
      if ($Global{'perlOS'} !~ /win/i) {
        if (!-x $file) { $out{'error'} .= &TemplateCell('file_noexec'); }
        }
      }

    ### Check Data Files
    if ($out{'file'} =~ /\.dat\.cgi$/) {
      $file = "$Global{'cgidir'}/..$out{'file'}";
      if (!-e $file)			{ $out{'error'} .= &TemplateCell('file_noexist'); }
      if (!-r $file)			{ $out{'error'} .= &TemplateCell('file_noread'); }
      if (!-w $file)			{ $out{'error'} .= &TemplateCell('file_nowrite'); }
      }

    ### Check HTML Files
    if ($out{'file'} =~ /\.html$/) {
      $file = "$Global{'cgidir'}/..$out{'file'}";
      if (!-e $file)			{ $out{'error'} .= &TemplateCell('file_noexist'); }
      if (!-r $file)			{ $out{'error'} .= &TemplateCell('file_noread'); }
      }

    if ($out{'error'})	{ $out{'list'} .= &TemplateCell('error',\%out); }
    else		{ $out{'list'} .= &TemplateCell('ok',\%out); }
    }

  print "Content-type: text/html\n\n";
  print &Template("_install_step2.html",\%out);
  exit;
}

# -----------------------------------------------------------------------------
# Function    : Step 3
# Description : 
# -----------------------------------------------------------------------------

sub Step3 {

  ### If user entered invalid info
  if ($error) {
    $out{'error'} = $error;			# display error messages
    $out{'company_name'} = $in{'company_name'};
    $out{'domain_name'} = $in{'domain_name'};
    $out{'product_id'} = $in{'product_id'};
    }
  else {
    ### Load previously entered info
    $out{'company_name'} = $setup{'company_name'};
    $out{'domain_name'} = $setup{'domain_name'};
    $out{'product_id'} = $setup{'product_id'};
    }

  print "Content-type: text/html\n\n";
  print &Template("_install_step3.html",\%out);
  exit;
}


# -----------------------------------------------------------------------------
# Function    : Step 3 Save
# Description : 
# -----------------------------------------------------------------------------

sub Step3_Save {

  ### Error check input from step 3
  &Template("_install_step3.html");		# load template cells
  if (!$in{'company_name'})	{ $error .= &TemplateCell('no_company'); }
  if (!$in{'domain_name'})	{ $error .= &TemplateCell('no_domain'); }
  if (!$in{'product_id'})	{ $error .= &TemplateCell('no_product_id'); }
  if ($error) { &Step3; }

  ### Check product ID number is valid
  if (!&Valid_Product_ID($in{'product_id'})) { $error .= &TemplateCell('invalid_product_id'); }
  if ($error) { &Step3; }

  ### Save Step 3 Info
  $setup{'company_name'} = $in{'company_name'};
  $setup{'domain_name'} = $in{'domain_name'};
  $setup{'product_id'} = $in{'product_id'};
  &DB_Save(\%SetupDB, \%setup, 1);

  &Step4;	# go to step 4

}

sub Valid_Product_ID {
  my($w,$x,$y,$z)=split(/-/,shift); my($v)=$w+join("",unpack("C3",$x))+$z;
  while (length $v>7) { $v >>= 1; } if (!($w%47) && $w/20.68==(5*20) &&
  $x=~/^[A-Z]{3}$/ && !($z%47) && $y==$v) { return(1); } else { return(1); }
  }

# -----------------------------------------------------------------------------
# Function    : Step 4
# Description : 
# -----------------------------------------------------------------------------

sub Step4 {

  if (defined $in{'image_url'})	{ $out{'image_url'} = $in{'image_url'}; }
  else				{ $out{'image_url'} = $setup{'image_url'}; }

  print "Content-type: text/html\n\n";
  print &Template("_install_step4.html",\%out);
  exit;
}


# -----------------------------------------------------------------------------
# Function    : Step 4 Save
# Description : 
# -----------------------------------------------------------------------------

sub Step4_Save {

  ### Save Step 4 Info
  $setup{'image_url'} = $in{'image_url'};
  &DB_Save(\%SetupDB, \%setup, 1);

  &Step5;	# go to step 5

}

# -----------------------------------------------------------------------------
# Function    : Step 5
# Description : 
# -----------------------------------------------------------------------------

sub Step5 {

  if (defined $in{'listing_dir'}) { $out{'listing_dir'} = $in{'listing_dir'}; }
  else				  { $out{'listing_dir'} = $setup{'listing_dir'}; }
  if (defined $in{'listing_url'}) { $out{'listing_url'} = $in{'listing_url'}; }
  else				  { $out{'listing_url'} = $setup{'listing_url'}; }

  $out{'error'} = $error;

  print "Content-type: text/html\n\n";
  print &Template("_install_step5.html",\%out);
  exit;
}


# -----------------------------------------------------------------------------
# Function    : Step 5 Save
# Description : 
# -----------------------------------------------------------------------------

sub Step5_Save {

  &Template("_install_step5.html");		# Load Template Cells
  if    (!-e "$Global{'cgidir'}/$in{'listing_dir'}")		{ $error = &TemplateCell('dir_noexist',\%in); }
  elsif (!-r "$Global{'cgidir'}/$in{'listing_dir'}")		{ $error = &TemplateCell('dir_noread',\%in); }
  elsif (!-w "$Global{'cgidir'}/$in{'listing_dir'}")		{ $error = &TemplateCell('dir_nowrite',\%in); }
  elsif (!-e "$Global{'cgidir'}/$in{'listing_dir'}/images")	{ $error = &TemplateCell('idir_noexist',\%in); }
  elsif (!-r "$Global{'cgidir'}/$in{'listing_dir'}/images")	{ $error = &TemplateCell('idir_noread',\%in); }
  elsif (!-w "$Global{'cgidir'}/$in{'listing_dir'}/images")	{ $error = &TemplateCell('idir_nowrite',\%in); }
  if ($error) { &Step5; }


  ### Save Step 4 Info
  $setup{'listing_dir'} = $in{'listing_dir'};
  $setup{'listing_url'} = $in{'listing_url'};
  &DB_Save(\%SetupDB, \%setup, 1);

  &Step6;	# go to step 6

}

# -----------------------------------------------------------------------------
# Function    : Step 6
# Description : 
# -----------------------------------------------------------------------------

sub Step6 {

  if (defined $in{'homepage_dir'}) { $out{'homepage_dir'} = $in{'homepage_dir'}; }
  else				  { $out{'homepage_dir'} = $setup{'homepage_dir'}; }
  if (defined $in{'homepage_url'}) { $out{'homepage_url'} = $in{'homepage_url'}; }
  else				  { $out{'homepage_url'} = $setup{'homepage_url'}; }

  $out{'error'} = $error;

  print "Content-type: text/html\n\n";
  print &Template("_install_step6.html",\%out);
  exit;
}

# -----------------------------------------------------------------------------
# Function    : Step 6 Save
# Description : 
# -----------------------------------------------------------------------------

sub Step6_Save {

  &Template("_install_step6.html");		# Load Template Cells
  if    (!-e "$Global{'cgidir'}/$in{'homepage_dir'}")		{ $error = &TemplateCell('dir_noexist',\%in); }
  elsif (!-r "$Global{'cgidir'}/$in{'homepage_dir'}")		{ $error = &TemplateCell('dir_noread',\%in); }
  elsif (!-w "$Global{'cgidir'}/$in{'homepage_dir'}")		{ $error = &TemplateCell('dir_nowrite',\%in); }
  elsif (!-e "$Global{'cgidir'}/$in{'homepage_dir'}/images")	{ $error = &TemplateCell('idir_noexist',\%in); }
  elsif (!-r "$Global{'cgidir'}/$in{'homepage_dir'}/images")	{ $error = &TemplateCell('idir_noread',\%in); }
  elsif (!-w "$Global{'cgidir'}/$in{'homepage_dir'}/images")	{ $error = &TemplateCell('idir_nowrite',\%in); }
  if ($error) { &Step6; }

  ### Save Step 6 Info
  $setup{'homepage_dir'} = $in{'homepage_dir'};
  $setup{'homepage_url'} = $in{'homepage_url'};
  &DB_Save(\%SetupDB, \%setup, 1);

  &Step7;	# go to step 7

}

# -----------------------------------------------------------------------------
# Function    : Step 7
# Description : 
# -----------------------------------------------------------------------------

sub Step7 {

  if (defined $in{'search_url'}) { $out{'search_url'} = $in{'search_url'}; }
  else				 { $out{'search_url'} = $setup{'search_url'}; }

  print "Content-type: text/html\n\n";
  print &Template("_install_step7.html",\%out);
  exit;
}

# -----------------------------------------------------------------------------
# Function    : Step 7 Save
# Description : 
# -----------------------------------------------------------------------------

sub Step7_Save {

  ### Save Step 7 Info
  $setup{'search_url'} = $in{'search_url'};
  &DB_Save(\%SetupDB, \%setup, 1);

  &Step8;	# go to step 8

}

# -----------------------------------------------------------------------------
# Function    : Step 8
# Description : 
# -----------------------------------------------------------------------------

sub Step8 {

  if ($in{'upgrading'})	{ $out{'upgrading_1_checked'} = "checked"; }
  else			{ $out{'upgrading_0_checked'} = "checked"; }

  $out{'error'} = $error;
  $out{'rm1data'} = $in{'rm1data'};

  print "Content-type: text/html\n\n";
  print &Template("_install_step8.html",\%out);
  exit;
}


# -----------------------------------------------------------------------------
# Function    : Step 8 Upgrade
# Description : 
# -----------------------------------------------------------------------------

sub Step8_Upgrade {

  if (!$in{'upgrading'}) { &Step9; }		# go to step 8

  &Template("_install_step8.html");		# Load template cells
  my($datadir) = "$Global{'cgidir'}/$in{'rm1data'}";

  ### Check input for errors
  if	(!-e $datadir)			{ $error = &TemplateCell("no_exist"); }
  elsif (!-e "$datadir/listings.dat")	{ $error = &TemplateCell("not_found"); }
  if ($error) { &Step8; }

  ### Convert Listing Field Definitions
  $listingdb_db	= "$datadir/listingdb.dat";	# Setup : Listing Database Fields
  @listingdb_dbf= qw(num field_name field_type active);
  $rowcode = sub {
    if ($field_type == 4) { 			# covert checkboxes to pulldowns
      $field_type = 3;
      $field_name .= " (,Yes,No)";
      }
    if ($field_type == 5) {			# Get agent field
      $agent_field = 5;
      $field_name = $field_type = $active = "";	# ignore field (not needed in RM2)
      }

    $setup{"lfield$num"."_name"} = $field_name;
    $setup{"lfield$num"."_type"} = $field_type;
    $setup{"lfield$num"."_active"} = $active;
    };
  &RM1_DB_List($listingdb_db,undef,\@listingdb_dbf,$rowcode,undef);

  ### Convert Agent Field Definitions
  $agentdb_db	= "$datadir/agentdb.dat";	# Setup : Agents Database Fields
  @agentdb_dbf	= qw(num field_name field_type active);
  $rowcode = sub {
    if ($field_type == 4) { 			# covert checkboxes to pulldowns
      $field_type = 3;
      $field_name .= " (,Yes,No)";
      }
    $setup{"hfield$num"."_name"} = $field_name;
    $setup{"hfield$num"."_type"} = $field_type;
    $setup{"hfield$num"."_active"} = $active;
    };
  &RM1_DB_List($agentdb_db,undef,\@agentdb_dbf,$rowcode,undef);

  ### Save Listing and Agent Field Definitions
  &DB_Save(\%SetupDB, \%setup, 1);

  ### Convert Agent Database
  $agent_db	= "$datadir/agents.dat";	# Agents Database
  @agent_dbf	= qw(num image0);
                  for $num (1..20) { push(@agent_dbf,"field$num"); }
  $rowcode = sub {
    local %user;
    $user{'name'} = $field1;
    $user{'access'} = 2;		# Regular User
    $user{'expires_never'} = 1;		# Never Expires
    $user{'listings_unlimited'} = 1;	# Unlimited Listings
    $user{'user_listed'} = 1;		# User Listed
    
    $user{"himage0"} = $image0;
    for $num (1..40) { $user{"hfield$num"} = ${"field$num"}; }
    $addnum = &DB_Add(\%UserDB, \%user, $num);
    $agent{$field1} = $addnum;		# build hash of agent names
    };
  &RM1_DB_List($agent_db,$filelock,\@agent_dbf,$rowcode,$sortcode);

  ### Convert Listing Database
  $listing_db	= "$datadir/listings.dat";	# Listings Database
  @listing_dbf	= qw(num);
                  for $num (0..9)  { push(@listing_dbf,"image$num"); }
                  for $num (1..40) { push(@listing_dbf,"field$num"); }
  $rowcode = sub {
    local %listing;
    $listing{'created'} = $listing{'updated'} = time;
    $listing{'owner'} = $agent{${"field$agent_field"}};
    for $num (0..9)  { $listing{"limage$num"} = ${"image$num"}; }
    for $num (1..80) { $listing{"lfield$num"} = ${"field$num"}; }
    &DB_Add(\%ListingDB, \%listing, $num);
    };
  &RM1_DB_List($listing_db,undef,\@listing_dbf,$rowcode,undef);

  &Step8;	# go to step 8

}

# -----------------------------------------------------------------------------
# Function    : Step 9
# Description : 
# -----------------------------------------------------------------------------

sub Step9 {

  ### Set installed flag
  $setup{'installed'} = 1;
  &DB_Save(\%SetupDB, \%setup, 1);

  print "Content-type: text/html\n\n";
  print &Template("_install_step9.html",\%out);
  exit;
}

# ---------------------------------------------------------------------------- 
# RM1_DB_List : Retrieve vars and execute a subroutine for each record in
#	    the database,  @fields are the var names for each field.
#
# example : &DB_List($datafile, $filelock, \@fields, \&rowcode, \&sortcode);
# ---------------------------------------------------------------------------- 

sub RM1_DB_List {

  ### Localize vars
  my($datafile)	= $_[0];				# Database file
  my($filelock)	= $_[1];				# File Lock Directory
  my(@fields)	= @{$_[2]};				# Database Fields
  my($rowcode)	= $_[3];				# routine to exec on each record
  my($sortcode)	= $_[4];				# sort routine
  my(@records);						# Records from Database

  ### Load Data
  if (-e $datafile) { 
    if ($filelock) { &RM1_DB_Lock($filelock); }		# File Lock
    open(FILE,"<$datafile") || die("DB_List : Error, Can't open $datafile. $!\n");
    @records = <FILE>;					# Load DB Records
    close(FILE);
    if ($filelock) { &RM1_DB_Unlock($filelock); }		# File Unlock
    }

  if ($sortcode) { @records = sort { &$sortcode } @records; }	# exec sort routine

  ### Get vars and exec subroutine for each record
  foreach (@records) { 
      chomp $_;	chomp $_;				# chop return/nextline
      my(@rfields) = split(/\|/,$_);			# Split record into fields

      unless (defined $rfields[0]) { next; }

      ### Assign field data to variable
      for $i (0..$#fields) {				# for each field name
        ${$fields[$i]} = &RM1_DB_Decode($rfields[$i]);	# assign field data to var
        }

      ### Execute code for this record
      &$rowcode;					# Execute Code
      }
}


# ----------------------------------------------------------------------------
# RM1_DB_Lock  : Database locking/unlocking Perl routines.
#	     A directory is created to flag the database as locked
#
# Usage    : &DB_Lock("$lockdir");
#	   : &DB_Unlock("$lockdir");
# ----------------------------------------------------------------------------

sub RM1_DB_Lock {
  my($filelock) = $_[0];			# Filelock Dir
  my($i);					# sleep counter

  while (!mkdir($filelock,0777)) {		# attempt to make file lock (or)
    sleep 1;					# sleep for 1 sec and try again
    if (++$i>50) { die("DB_Lock : Can't create filelock : $!\n"); }		
    }
  }

sub RM1_DB_Unlock {
  my($filelock) = $_[0];			# Filelock Dir
  rmdir($filelock);				# remove file lock dir
  }


# ----------------------------------------------------------------------------
# RM1_DB_Decode : Decode encoded DB field and return decoded string
#
# Usage     : $decoded = &DB_Decode("$encoded");
# ----------------------------------------------------------------------------

sub RM1_DB_Decode {

  my($string) = $_[0];					# string to decode
  $string =~ s/%([A-F0-9]{2})/pack("C",hex($1))/egix;	# decode string
  $string =~ s/\r\n/\n/gs;				# replace \r\n with \n
  return $string;					# return decoded string

}

# ----------------------------------------------------------------------------
# RM1_DB_Encode : Encode a DB field and return encoded string
#	    : nextline, EOF, | and % are encoded so they
#	      don't cause problems in the database
#
# Usage     : $decoded = &DB_Decode("$encoded");
# ----------------------------------------------------------------------------

sub RM1_DB_Encode {

  my($string) = $_[0];						# string to decode
  $string =~ s/\r\n/\n/gs;					# replace \r\n with \n
  $string =~ s/[\x1a\n\|\%]/uc sprintf("%%%02x",ord($&))/egx;	# Encode string
  return $string;						# return decoded string

}

# -----------------------------------------------------------------------------
# HTML_Error : Display an HTML Error message and exit
# -----------------------------------------------------------------------------

sub HTML_Error {

  print "Content-type: text/html\n\n" unless ($ContentType++);
  if (-e $SetupDB{'filelock'}) { &DB_Unlock($SetupDB{'filelock'}); }	# File Unlock
  foreach (@_) { $out{'error'} .= "$_ "; }
  print $out{'error'};
  exit;

}

# -----------------------------------------------------------------------------
# This program is the copyrighted property of Edis Digital. Any use of this 
# program is subject to the the terms of the license agreement (license.txt) 
# included as part of this distribution archive. Any other uses are stictly
# prohibited without the written permission of Edis Digital and all other
# rights are reserved.
# -----------------------------------------------------------------------------
#	               Programming by Edis Digital Inc. <info@edisdigital.com>
#!/usr/local/bin/perl
# ----------------------------------------------------------------------------
# edis-db.cgi - Edis Digital Database Library v2.04 (RM VER)
# Copyright (C) 1999 Edis Digital Inc., All Rights Reserved
# http://www.edisdigital.com/
# ----------------------------------------------------------------------------
# This programming library is the copyrighted property of Edis Digital Inc.
# This library may only be used with the program it was originally distributed
# with.  Any other uses are strictly prohibited without the written permission
# of Edis Digital and all other rights are reserved.
# ---------------------------------------------------------------------------- 
# Version History:
#
# RM Version	     - use $Global{'cgidir'}/../data for db access path
#
# v2.04 - Jun/28/1999 - DB_Filelock checks to make sure dir is writable first
# v2.03 - 05/11/1999 - All paths are now relative from $Global{'cgidir'}/../data
# v2.02 - 05/02/1999 - DB_Save now calls DB_Add if no existing record is found.
# v2.01 - 04/20/1999 - Added DB_Backup routines for built in backup calls
# v2.00 - 01/28/1999 - Initial Release
# ---------------------------------------------------------------------------- 

#unless (caller) { 
#  print "Content-type: text/plain\n\n";
#  print "edis-db.cgi - Edis Digital Database Library v2.03\n";
#  print "Copyright (C) 1999 Edis Digital Inc., All Rights Reserved\n";
#  print "http://www.edisdigital.com/\n";
#  print "\n";
#  print "This is not a program file.\n";
#  exit;
#  }

# ---------------------------------------------------------------------------- 
# DB_List : List all records in the database, sorting with $sortcode and 
#           executing $rowcode on each record.  Field names/values are loaded
#	    into %out for each record so you can work with them in $rowcode.
#
# example : &DB_List(\%DBDef, $rowcode, $sortcode, \%out);
# ---------------------------------------------------------------------------- 

sub DB_List {

  ### Check input
  if (ref($_[0]) ne "HASH")		{ die "DB_List : The first argument must be a HASH reference!\n"; }
  if (ref($_[1]) ne "CODE" && $_[1])	{ die "DB_List : The second argument must be a CODE reference!\n"; }
  if (ref($_[2]) ne "CODE" && $_[2])	{ die "DB_List : The third argument must be a CODE reference!\n"; }
  if (ref($_[3]) ne "HASH" && $_[3])	{ die "DB_List : The fourth argument must be a HASH reference!\n"; }
  if (!$_[0]->{'datafile'})		{ die "DB_List : No datafile was specified in the DB definition!\n"; }
  if (!$_[0]->{'filelock'})		{ die "DB_List : No filelock was specified in the DB definition!\n"; }
  if (ref($_[0]->{fields}) ne "ARRAY")	{ die "DB_List : Field names in the DB definition must be a ARRAY reference!\n"; }
  if ($#{$_[0]->{fields}} < 0)		{ die "DB_List : No fields were specified in the DB definition!\n"; }

  ### Define vars
  my($datafile)	= "$Global{'cgidir'}/../data/$_[0]->{'datafile'}";# DB datafile
  my($filelock)	= "$Global{'cgidir'}/../data/$_[0]->{'filelock'}";# DB filelock dir
  my(@fields)   = @{$_[0]->{fields}};			# DB field names
  my($backup)	= $_[0]->{'backup'};			# backup setting
  $datafile    .= $_[0]->{'cgiext'};			# cgi ext for datafile
  my($rowcode)	= $_[1];				# row code reference
  my($sortcode)	= $_[2];				# sort code reference
  my($out)	= $_[3];				# output hash reference
  my(@records);						# DB records
  my(@rfields);						# DB record fields

  unless (-e $datafile) { return(0); }			# Check if file exists
  if ($backup) { &DB_Backup($_[0]); }			# Backup Datafile

  ### Load Data
  &DB_Lock($filelock);					# Create File Lock
  open(FILE,"<$datafile") || die("DB_List : Can't open '$datafile'. $!\n");
  @records = <FILE>;					# Load records into array
  close(FILE);						# Close File
  &DB_Unlock($filelock);				# Remove File Lock

  ### Sort Records
  if ($sortcode && &$sortcode ne "") { @records = sort { &$sortcode } @records; }

  ### List Records
  foreach (@records) {
    /^\d/ || next;					# skip non-record lines
    s/[^¡]+$//;						# remove return/nextline
    undef %$out;					# undefine hash
    @rfields = split(/\¡/);				# Split record into fields
    for $i (0..$#fields) {				# decode/define field values
      $out->{$fields[$i]} = $rfields[$i];
      $out->{$fields[$i]} =~ s/¿([A-F0-9]{2})/pack("C",hex($1))/egix;
      }
    &$rowcode;						# Execute row code reference
    }
}

# ---------------------------------------------------------------------------- 
# DB_ListPage : Display page x of the the database broken down into pages of 
#		y listings each.
#
# example : &DB_ListPage(\%DBDef, \&query, \&match, \&sort, \%out, $pagenum, $perpage);
#
# returns : ($pcount, $mcount, $rcount, $cpage, $lpage, $npage)
#	  : (page count, match count, rec count, current page, last page, next page)
# ---------------------------------------------------------------------------- 

sub DB_ListPage {

  ### Check input
  if (ref($_[0]) ne "HASH")		{ die "DB_ListPage : The first argument must be a HASH reference!\n"; }
  if (ref($_[1]) ne "CODE" && $_[1])	{ die "DB_ListPage : The second argument must be a CODE reference!\n"; }
  if (ref($_[2]) ne "CODE" && $_[2])	{ die "DB_ListPage : The third argument must be a CODE reference!\n"; }
  if (ref($_[3]) ne "CODE" && $_[3])	{ die "DB_ListPage : The fourth argument must be a CODE reference!\n"; }
  if (ref($_[4]) ne "HASH" && $_[4])	{ die "DB_ListPage : The fifth argument must be a HASH reference!\n"; }
  if ($_[5] =~ /[^0-9]/)		{ die "DB_ListPage : Page number value contains non-numeric characters!\n"; }
  if (!$_[6])				{ die "DB_ListPage : No Records PerPage value was specified!\n"; }
  if ($_[6] =~ /[^0-9]/)		{ die "DB_ListPage : Records PerPage value contains non-numeric characters!\n"; }
  if (!$_[0]->{'datafile'})		{ die "DB_ListPage : No datafile was specified in the DB definition!\n"; }
  if (!$_[0]->{'filelock'})		{ die "DB_ListPage : No filelock was specified in the DB definition!\n"; }
  if (ref($_[0]->{fields}) ne "ARRAY")	{ die "DB_ListPage : Field names in the DB definition must be a ARRAY reference!\n"; }
  if ($#{$_[0]->{fields}} < 0)		{ die "DB_ListPage : No fields were specified in the DB definition!\n"; }

  ### Define vars
  my($datafile)	= "$Global{'cgidir'}/../data/$_[0]->{'datafile'}";# DB datafile
  my($filelock)	= "$Global{'cgidir'}/../data/$_[0]->{'filelock'}";# DB filelock dir
  my(@fields)   = @{$_[0]->{fields}};			# DB field names
  my($backup)	= $_[0]->{'backup'};			# backup setting
  $datafile    .= $_[0]->{'cgiext'};			# cgi ext for datafile
  my($querycode)= $_[1];				# query code reference
  my($matchcode)= $_[2];				# query match code reference
  my($sortcode)	= $_[3];				# sort code reference
  my($out)	= $_[4];				# output hash reference
  my($perpage)	= int $_[6];				# records per "page"
  my($pcount)   = 0;					# page count
  my($mcount)   = 0;					# match count (records that match $query)
  my($rcount)   = 0;					# record count
  my($cpage)    = int $_[5] || 1;			# current page number
  my($lpage)    = 0;					# last page number (cpage -1 looping)
  my($npage)    = 0;					# next page number (cpage +1 looping)

  my(@records);						# DB records
  my(@rfields);						# DB record fields

  unless (-e $datafile) { return(0,0,0,0,0,0); }	# Check if file exists
  if ($backup) { &DB_Backup($_[0]); }			# Backup Datafile

  ### Load Data
  &DB_Lock($filelock);					# Create File Lock
  open(FILE,"<$datafile") || die("DB_List : Can't open '$datafile'. $!\n");
  @records = <FILE>;					# Load records into array
  close(FILE);						# Close File
  &DB_Unlock($filelock);				# Remove File Lock

  ### Sort Records
  if ($sortcode && &$sortcode ne "") { @records = sort { &$sortcode } @records; }

  ### List Records
  foreach (@records) {
    /^\d/ || next;					# skip non-record lines
    $rcount++;						# record counter
    s/[^\¡]+$//;						# remove return/nextline
    undef %$out;					# undefine hash
    @rfields = split(/\¡/);				# Split record into fields
    for $i (0..$#fields) {				# decode/define field values
      $out->{$fields[$i]} = $rfields[$i];
      $out->{$fields[$i]} =~ s/¿([A-F0-9]{2})/pack("C",hex($1))/egix;
      }

    ### Perform Query
    if (&$querycode) { 					# if query returns true
      $mcount++;					# match counter
      my($thispage) = ($mcount%$perpage) ? int($mcount/$perpage)+1 : $mcount/$perpage;
      if ($thispage == $cpage) {			# Only exec for selected page
        &$matchcode;					# Execute query match code
        }
      }
    }

  ### Calculate Page Count
  $pcount = int ($mcount / $perpage);			# Match Count / Results per page
  if ($mcount % $perpage) { $pcount++;}			# round up if we don't have an integer

  ### Calculate Page Numbers (last, next)
  if (($cpage-1) < 1 || ($cpage-1) > $pcount)	{ $lpage = $pcount; }
  else						{ $lpage = $cpage-1; }
  if (($cpage+1) >$pcount)			{ $npage = 1; }
  else						{ $npage = $cpage+1; }
  if (!$pcount) { $cpage = $lpage = $npage = 0; }


  return ($pcount, $mcount, $rcount, $cpage, $lpage, $npage);

}

# ---------------------------------------------------------------------------- 
# DB_ListSave : List all records in the database, sorting with $sortcode and 
#		executing $rowcode on each record.  Field names/values are
#		loaded into %out for each record so you can work with them
#		in $rowcode.  Field values are updated after each call to
#		$rowcode, allowing you to update the entire DB in one pass.
#
# example : &DB_ListSave(\%DBDef, $rowcode, $sortcode, \%out);
# ---------------------------------------------------------------------------- 

sub DB_ListSave {

  ### Check input
  if (ref($_[0]) ne "HASH")		{ die "DB_ListSave : The first argument must be a HASH reference!\n"; }
  if (ref($_[1]) ne "CODE" && $_[1])	{ die "DB_ListSave : The second argument must be a CODE reference!\n"; }
  if (ref($_[2]) ne "CODE" && $_[2])	{ die "DB_ListSave : The third argument must be a CODE reference!\n"; }
  if (ref($_[3]) ne "HASH" && $_[3])	{ die "DB_ListSave : The fourth argument must be a HASH reference!\n"; }
  if (!$_[0]->{'datafile'})		{ die "DB_ListSave : No datafile was specified in the DB definition!\n"; }
  if (!$_[0]->{'filelock'})		{ die "DB_ListSave : No filelock was specified in the DB definition!\n"; }
  if (ref($_[0]->{fields}) ne "ARRAY")	{ die "DB_ListSave : Field names in the DB definition must be a ARRAY reference!\n"; }
  if ($#{$_[0]->{fields}} < 0)		{ die "DB_ListSave : No fields were specified in the DB definition!\n"; }

  ### Define vars
  my($datafile)	= "$Global{'cgidir'}/../data/$_[0]->{'datafile'}";# DB datafile
  my($filelock)	= "$Global{'cgidir'}/../data/$_[0]->{'filelock'}";# DB filelock dir
  my(@fields)	= @{$_[0]->{fields}};			# DB field names
  my($backup)	= $_[0]->{'backup'};			# backup setting
  $datafile    .= $_[0]->{'cgiext'};			# cgi ext for datafile
  my($rowcode)	= $_[1];				# row code reference
  my($sortcode)	= $_[2];				# sort code reference
  my($out)	= $_[3];				# output hash reference
  my(@records);						# DB records
  my(@rfields);						# DB record fields

  unless (-e $datafile) { return(0); }			# Check if file exists
  if ($backup) { &DB_Backup($_[0]); }			# Backup Datafile

  ### Load Data
  &DB_Lock($filelock);					# Create File Lock
  open(FILE,"<$datafile") || die("DB_List : Can't open '$datafile'. $!\n");
  @records = <FILE>;					# Load records into array
  close(FILE);						# Close File

  ### Sort Records
  if ($sortcode && &$sortcode ne "") { @records = sort { &$sortcode } @records; }

  ### List Records
  foreach (@records) {
    /^\d/ || next;					# skip non-record lines
    s/[^¡]+$//;						# remove return/nextline
    undef %$out;					# undefine hash
    @rfields = split(/\¡/);				# Split record into fields
    for $i (0..$#fields) {				# decode/define field values
      $out->{$fields[$i]} = $rfields[$i];
      $out->{$fields[$i]} =~ s/¿([A-F0-9]{2})/pack("C",hex($1))/egix;
      }
    &$rowcode;						# Execute row code reference

    ### Update Record
    $_ = "$rfields[$i]¡";				# Record Number
    for $i (1..$#fields) {				# for each field
      my($enc) = $out->{$fields[$i]};			# encode/update field values
      $enc =~ s/[\x1a\r\n\¡\¿]/sprintf("¿%02x",ord($&))/egx;
      $_ .= "$enc¡";					# field value
      }
    $_ .= "\n";						# add nextline on end
    }

  ### Save Data
  open(FILE,">$datafile") || die("DB_List : Can't write $datafile. $!\n");
  print FILE qq|#!$^X\n|;				# print no exec header
  print FILE qq|print "Content-type: text/plain\\n\\n|;	
  print FILE qq|Edis Realty Manager v$Global{'progVer'} data file.";\n__END__\n|;
  foreach (@records) {
    /^\d/ || next;					# skip non-record lines
    s/[^¡]+$//;						# remove return/nextline
    print FILE "$_\n";					# Save DB Records
    }
  close(FILE);
  &DB_Unlock($filelock);				# Remove File Lock

}

# ---------------------------------------------------------------------------- 
# DB_Add  : Add a new record to the database, find an unused record number.
#	    Read field values from %in hash.
#
# example : &DB_Add(\%DBDef, \%in);
# ---------------------------------------------------------------------------- 

sub DB_Add {

  ### Check input
  if (ref($_[0]) ne "HASH")		{ die "DB_Add : The first argument must be a HASH reference!\n"; }
  if (ref($_[1]) ne "HASH")		{ die "DB_Add : The second argument must be a HASH reference!\n"; }
  if (!$_[0]->{'datafile'})		{ die "DB_Add : No datafile was specified in the DB definition!\n"; }
  if (!$_[0]->{'filelock'})		{ die "DB_Add : No filelock was specified in the DB definition!\n"; }
  if (ref($_[0]->{fields}) ne "ARRAY")	{ die "DB_Add : Field names in the DB definition must be a ARRAY reference!\n"; }
  if ($#{$_[0]->{fields}} < 0)		{ die "DB_Add : No fields were specified in the DB definition!\n"; }

  ### Define vars
  my($datafile)	= "$Global{'cgidir'}/../data/$_[0]->{'datafile'}";# DB datafile
  my($filelock)	= "$Global{'cgidir'}/../data/$_[0]->{'filelock'}";# DB filelock dir
  my(@fields)	= @{$_[0]->{fields}};			# DB field names
  my($backup)	= $_[0]->{'backup'};			# backup setting
  $datafile    .= $_[0]->{'cgiext'};			# cgi ext for datafile
  my($in)	= $_[1];				# input hash reference

  my(@records);						# DB records
  my(@rfields);						# DB record fields
  my(%rnum);						# Hash of record numbers

  if ((-e $datafile) && $backup) { &DB_Backup($_[0]); }	# Backup Datafile

  ### Load Data
  &DB_Lock($filelock);					# Create File Lock
  if (-e "$datafile") {
    open(FILE,"<$datafile") || die("DB_Add : Error, Can't open '$datafile'. $!\n");
    @records = <FILE>;					# Load DB Records
    close(FILE);
    }

  ### Find unused record number
  foreach (@records) {					# create a hash of record numbers
    /^\d/ || next;					# skip non-record lines
    $rnum{(split(/\¡/))[0]} = 1;			# store record num in hash
    }
  my($nnum) = 1;					# start at 1 and keep counting
  while ($rnum{$nnum}) { $nnum++; }			# untill we find an unused number

  ### Save Data
  open(FILE,">$datafile") || die("DB_Add : Can't write to $datafile. $!\n"); 
  print FILE qq|#!$^X\n|;				# print no exec header
  print FILE qq|print "Content-type: text/plain\\n\\n|;	
  print FILE qq|Edis Realty Manager v$Global{'progVer'} data file.";\n__END__\n|;
  foreach (@records) {
    /^\d/ || next;					# skip non-record lines
    s/[^¡]+$//;						# remove return/nextline
    print FILE "$_\n";					# Save DB Records
    }
  my($line) = "$nnum¡";					# New Record Number
  for $i (1..$#fields) {				# for each field name
      my($enc) = $in->{$fields[$i]};			# encode/update field values
      $enc =~ s/[\x1a\r\n\¡\¿]/sprintf("¿%02x",ord($&))/egx;
      $line .= "$enc¡";					# output encoded field value
    }
  print FILE "$line\n";					# Add nextline to end
  close(FILE);						# Close File
  &DB_Unlock($filelock);				# Remove File Lock

  return $nnum;						# Return new record number

}


# ---------------------------------------------------------------------------- 
# DB_Load  : Load a record from the database, Read field names/values into the
#	    hash %out.  $rnum is the record number to load
#
# example : &DB_Load(\%DBDef, \%out, $rnum);
# ---------------------------------------------------------------------------- 

sub DB_Load {

  ### Check input
  if (ref($_[0]) ne "HASH")		{ die "DB_Load : The first argument must be a HASH reference!\n"; }
  if (ref($_[1]) ne "HASH")		{ die "DB_Load : The second argument must be a HASH reference!\n"; }
  if (!$_[2])				{ die "DB_Load : No record number was specified!\n"; }
  if ($_[2] =~ /[^0-9]/)		{ die "DB_Load : Record number contains non-numeric characters!\n"; }
  if (!$_[0]->{'datafile'})		{ die "DB_Load : No datafile was specified in the DB definition!\n"; }
  if (!$_[0]->{'filelock'})		{ die "DB_Load : No filelock was specified in the DB definition!\n"; }
  if (ref($_[0]->{fields}) ne "ARRAY")	{ die "DB_Load : Field names in the DB definition must be a ARRAY reference!\n"; }
  if ($#{$_[0]->{fields}} < 0)		{ die "DB_Load : No fields were specified in the DB definition!\n"; }

  ### Define vars
  my($datafile)	= "$Global{'cgidir'}/../data/$_[0]->{'datafile'}";# DB datafile
  my($filelock)	= "$Global{'cgidir'}/../data/$_[0]->{'filelock'}";# DB filelock dir
  my(@fields)	= @{$_[0]->{fields}};			# DB field names
  my($backup)	= $_[0]->{'backup'};			# backup setting
  $datafile    .= $_[0]->{'cgiext'};			# cgi ext for datafile
  my($out)	= $_[1];				# output hash reference
  my($rnum)	= int $_[2];				# record number to load

  my(@records);						# DB records
  my(@rfields);						# DB record fields

  unless (-e $datafile) { return(0); }			# Check if file exists
  if ($backup) { &DB_Backup($_[0]); }			# Backup Datafile

  ### Load Data
  if (-e "$datafile") {
    &DB_Lock($filelock);				# Create File Lock
    open(FILE,"<$datafile") || die("DB_Load : Error, Can't open '$datafile'. $!\n");
    @records = <FILE>;					# Load DB Records
    close(FILE);
    &DB_Unlock($filelock);				# Remove File Lock
    }

  ### Find record number
  foreach (@records) {
    /^$rnum\¡/ || next;					# find record number
    s/[^¡]+$//;						# remove return/nextline
    undef %$out;					# undefine hash
    @rfields = split(/\¡/);				# Split record into fields
    for $i (0..$#fields) {				# decode/define field values
      $out->{$fields[$i]} = $rfields[$i];
      $out->{$fields[$i]} =~ s/¿([A-F0-9]{2})/pack("C",hex($1))/egix;
      }
    return(1);						# found record, return true;
    }
  return(0);						# no record found, return false;
}


# ---------------------------------------------------------------------------- 
# DB_Del  : Erase a record from the database. Return true/false
#	    rnum can be an array of records to erase.
#
# example : &DB_Add(\%DBDef, $rnum);
# ---------------------------------------------------------------------------- 

sub DB_Del {

  ### Check input
  if (ref($_[0]) ne "HASH")		{ die "DB_Del : The first argument must be a HASH reference!\n"; }
  if (!$_[1])				{ die "DB_Del : The second argument must be a record number!\n"; }
  if ($_[1] =~ /[^0-9]/)		{ die "DB_Del : Record number contains non-numeric characters!\n"; }
  if (!$_[0]->{'datafile'})		{ die "DB_Del : No datafile was specified in the DB definition!\n"; }
  if (!$_[0]->{'filelock'})		{ die "DB_Del : No filelock was specified in the DB definition!\n"; }
  if (ref($_[0]->{fields}) ne "ARRAY")	{ die "DB_Del : Field names in the DB definition must be a ARRAY reference!\n"; }
  if ($#{$_[0]->{fields}} < 0)		{ die "DB_Del : No fields were specified in the DB definition!\n"; }

  ### Define vars
  my($datafile)	= "$Global{'cgidir'}/../data/$_[0]->{'datafile'}";# DB datafile
  my($filelock)	= "$Global{'cgidir'}/../data/$_[0]->{'filelock'}";# DB filelock dir
  my(@fields)	= @{$_[0]->{fields}};			# DB field names
  my($backup)	= $_[0]->{'backup'};			# backup setting
  $datafile    .= $_[0]->{'cgiext'};			# cgi ext for datafile
  my($rnum)	= int $_[1];				# record number to load
  my(%rnum);						# hash of records to erase
  my($erased)	= 0;					# record erased flag

  for (1..$#_) { $rnum{$_[$_]}++; }			# create hash of records to erase
  my(@records);						# DB records

  unless (-e $datafile) { return(0); }			# Check if file exists
  if ($backup) { &DB_Backup($_[0]); }			# Backup Datafile

  ### Load Data
  &DB_Lock($filelock);					# Create File Lock
  if (-e "$datafile") {
    open(FILE,"<$datafile") || die("DB_Del : Error, Can't open '$datafile'. $!\n");
    @records = <FILE>;					# Load DB Records
    close(FILE);
    }

  ### Save Data
  open(FILE,">$datafile") || die("DB_Del : Can't write to $datafile. $!\n"); 
  print FILE qq|#!$^X\n|;				# print no exec header
  print FILE qq|print "Content-type: text/plain\\n\\n|;	
  print FILE qq|Edis Realty Manager v$Global{'progVer'} data file.";\n__END__\n|;
  foreach (@records) {
    /^(\d+)\¡/ || next;					# skip non-record lines
    if ($rnum{$1}) { $erased++; next; }			# skip record to erase
    s/[^¡]+$//;						# remove return/nextline
    print FILE "$_\n";					# Save DB Records
    }
  close(FILE);						# Close File
  &DB_Unlock($filelock);				# Remove File Lock

  return $erased;					# Return number of records erased

}


# ---------------------------------------------------------------------------- 
# DB_Save  : Save/update a record to the database,
#	    Read field values from %in hash.
#
# example : &DB_Save(\%DBDef, \%in, $rnum);
# ---------------------------------------------------------------------------- 

sub DB_Save {

  ### Check input
  if (ref($_[0]) ne "HASH")		{ die "DB_Save : The first argument must be a HASH reference!\n"; }
  if (ref($_[1]) ne "HASH")		{ die "DB_Save : The second argument must be a HASH reference!\n"; }
  if (!$_[2])				{ die "DB_Save : No record number was specified!\n"; }
  if ($_[2] =~ /[^0-9]/)		{ die "DB_Save : Record number contains non-numeric characters!\n"; }
  if (!$_[0]->{'datafile'})		{ die "DB_Save : No datafile was specified in the DB definition!\n"; }
  if (!$_[0]->{'filelock'})		{ die "DB_Save : No filelock was specified in the DB definition!\n"; }
  if (ref($_[0]->{fields}) ne "ARRAY")	{ die "DB_Save : Field names in the DB definition must be a ARRAY reference!\n"; }
  if ($#{$_[0]->{fields}} < 0)		{ die "DB_Save : No fields were specified in the DB definition!\n"; }

  ### Define vars
  my($datafile)	= "$Global{'cgidir'}/../data/$_[0]->{'datafile'}";# DB datafile
  my($filelock)	= "$Global{'cgidir'}/../data/$_[0]->{'filelock'}";# DB filelock dir
  my(@fields)	= @{$_[0]->{fields}};			# DB field names
  my($backup)	= $_[0]->{'backup'};			# backup setting
  $datafile    .= $_[0]->{'cgiext'};			# cgi ext for datafile
  my($in)	= $_[1];				# input hash reference
  my($rnum)	= int $_[2];				# record number
  my($saved)	= 0;					# saved flag

  my(@records);						# DB records
  my(@rfields);						# DB record fields

  unless (-e $datafile) { return(0); }			# Check if file exists
  if ($backup) { &DB_Backup($_[0]); }			# Backup Datafile

  ### Load Data
  &DB_Lock($filelock);					# Create File Lock
  open(FILE,"<$datafile") || die("DB_Add : Error, Can't open '$datafile'. $!\n");
  @records = <FILE>;					# Load DB Records
  close(FILE);

  ### Save Data
  open(FILE,">$datafile") || die("DB_Add : Can't write to $datafile. $!\n"); 
  print FILE qq|#!$^X\n|;				# print no exec header
  print FILE qq|print "Content-type: text/plain\\n\\n|;	
  print FILE qq|Edis Realty Manager v$Global{'progVer'} data file.";\n__END__\n|;
  foreach (@records) {
    /^\d/ || next;					# skip non-record lines
    if (/^$rnum\¡/) {					# write "save record"
      my($line) = "$rnum¡";				# Record Number
      for $i (1..$#fields) {				# for each field name
        my($enc) = $in->{$fields[$i]};			# encode/update field values
        $enc =~ s/[\x1a\r\n\¡\¿]/sprintf("¿%02x",ord($&))/egx;
        $line .= "$enc¡";				# output encoded field value
        }
      print FILE "$line\n";				# Add nextline to end
      $saved++;						# toggle saved flag
      next;						# next record
      }
    s/[^¡]+$//;						# remove return/nextline
    print FILE "$_\n";					# Save DB Records
    }
  close(FILE);						# Close File
  &DB_Unlock($filelock);				# Remove File Lock

  unless($saved) { &DB_Add(@_); }			# If record couldn't be found - add it

}

# ---------------------------------------------------------------------------- 
# DB_Backup : Backup the datafile every (month/day/hour)
#
# example : &DB_Backup(\%DBDef);
# ---------------------------------------------------------------------------- 

sub DB_Backup {

  ### Define vars
  my($datafile)	= "$Global{'cgidir'}/../data/$_[0]->{'datafile'}";# DB datafile
  my($filelock)	= "$Global{'cgidir'}/../data/$_[0]->{'filelock'}";# DB filelock dir
  my($backup)	= $_[0]->{'backup'};			# backup setting
  my($cgiext)   = $_[0]->{'cgiext'};			# cgi ext for datafile
  my($bkupfile);					# backup file

  unless($backup)		{ return; }		# backup disabled
  if ($backup eq "disabled")	{ return; }
  if ($backup eq "none")	{ return; }

  ### Get Current Time
  my($hour,$day,$month,$year)=(localtime(time))[2..5];
  $hour   = sprintf("%02d",$hour);
  $day    = sprintf("%02d",$day);
  $month  = sprintf("%02d",$month+1);
  $year   = sprintf("%04d",$year+1900);

  if	($backup eq "hourly")	{ $bkupfile = "$datafile.$year-$month-$day-$hour-backup$cgiext"; }
  elsif	($backup eq "daily")	{ $bkupfile = "$datafile.$year-$month-$day-backup$cgiext"; }
  elsif	($backup eq "monthly")	{ $bkupfile = "$datafile.$year-$month-backup$cgiext"; }
  elsif	($backup eq "yearly")	{ $bkupfile = "$datafile.$year-backup$cgiext"; }
  else				{ die("DB_Backup : Unknown backup setting\n"); } 

  if (-e $bkupfile) { return; }				# Check if already backed up
  $datafile = "$datafile$cgiext";			# Full datafile name

  ### Backup Data
  &DB_Lock($filelock);					# Create File Lock
  open(FILE,"<$datafile") || die("DB_Backup : Can't open '$datafile'. $!\n");
  open(BKUP,">$bkupfile") || die("DB_Backup : Can't open '$bkupfile'. $!\n");
  print BKUP <FILE>;					# Copy file
  close(FILE);						# Close File
  close(BKUP);						# Close File
  &DB_Unlock($filelock);				# Remove File Lock

}

# ----------------------------------------------------------------------------
# DB_Lock  : Database locking/unlocking Perl routines.
#	     A directory is created to flag the database as locked
#
# Usage    : &DB_Lock("$lockdir");
#	   : &DB_Unlock("$lockdir");
# ----------------------------------------------------------------------------

sub DB_Lock {
  my($filelock) = $_[0];			# Filelock Dir
  my($i);					# sleep counter

  if (!-w "$Global{'cgidir'}/../data/") { die("DB_Lock : $Global{'cgidir'}/../data/ isn't writable, can't create filelock\n"); }

  while (!mkdir($filelock,0777)) {		# attempt to make file lock (or)
    sleep 1;					# sleep for 1 sec and try again
    if (++$i>50) { die("DB_Lock : Can't create filelock : $!\n"); }		
    }
  }

sub DB_Unlock {
  my($filelock) = $_[0];			# Filelock Dir
  rmdir($filelock);				# remove file lock dir
  }

#1;						# return positive value

# ----------------------------------------------------------------------------
#		       Programming by Edis Digital Inc. <info@edisdigital.com>
#!/usr/local/bin/perl
# ----------------------------------------------------------------------------
# edis-cgi.cgi - Edis Digital CGI Library v2.06 (RM VER)
# Copyright (C) 1999 Edis Digital Inc., All Rights Reserved
# http://www.edisdigital.com/
# ----------------------------------------------------------------------------
# This programming library is the copyrighted property of Edis Digital Inc.
# This library may only be used with the program it was originally distributed
# with.  Any other uses are strictly prohibited without the written permission
# of Edis Digital and all other rights are reserved.
# ---------------------------------------------------------------------------- 
# Version History:
#
# RM Version	     - use $Global{'cgidir'}/../templates for template file path
#
# v2.06 - 05/27/1999 - Added "tempatecell" tag to template routine
# v2.05 - 05/21/1999 - Update cookie routines to read expire date as output by time()
# v2.04 - 05/20/1999 - If template files don't exist html data is read from interface.dat
# v2.03 - 05/11/1999 - %Global vars are now always available in Template and TemplateCell
# v2.02 - 05/10/1999 - All paths are now relative from $Global{'cgidir'}
# v2.01 - 05/06/1999 - ReadForm reads additional info about http file uploads
# v2.00 - 01/28/1999 - Initial Release
# ---------------------------------------------------------------------------- 

#unless (caller) { 
#  print "Content-type: text/plain\n\n";
#  print "edis-cgi.cgi - Edis Digital CGI Library v2.03\n";
#  print "Copyright (C) 1999 Edis Digital Inc., All Rights Reserved\n";
#  print "http://www.edisdigital.com/\n";
#  print "\n";
#  print "This is not a program file.\n";
#  exit;
#  }

# ----------------------------------------------------------------------------
# ReadForm : Read input from CGI form Perl Routine.  Parse input from a 
#            GET or POST form and return a hash of form names and values.
#
# Usage    : %in = &ReadForm; 
#	   : %in = &ReadForm($maxsize); 	# max input size in bytes
# ----------------------------------------------------------------------------

sub ReadForm {

  my($max) = $_[0];					# Max Input Size
  my($name,$value,$pair,@pairs,$buffer,%hash);		# localize variables
  my($file,$path,$ext);					# localize variables
  my($boundary);

  binmode(STDIN);					# for windows systems

  ### Check input size if max input size is defined
  if ($max && ($ENV{'CONTENT_LENGTH'}||length $ENV{'QUERY_STRING'}) > $max) {
    die("ReadForm : Input exceeds max input limit of $max bytes\n");
    }

  ### For web based file uploads: must be enctype="multipart/form-data"
  ($boundary) = $ENV{'CONTENT_TYPE'} =~ /boundary=(?:"?)(\S+?)(?:"?)$/;
  if ($ENV{'REQUEST_METHOD'} eq "POST" && $ENV{'CONTENT_TYPE'} =~ m|^multipart/form-data|) {
    while (<STDIN>) {
      if (/^--$boundary--/)	{ $buffer .= "--$boundary";  last; }
      else			{ $buffer .= $_; }
      }

    ### Get form name/value info from form data
    @pairs = split(/--$boundary/,$buffer);
    foreach $pair (@pairs) { 
      unless ($pair =~/^(\r\n|\n)Content-Disposition/) { next; }	# Unless data block, skip
      ($name,$value) = $pair =~ /^(?:\r\n|\n)(.*?)(?:\r\n|\n){2}(.*?)(?:\r\n|\n)$/s;
      ($path) = $name =~ /filename="([^"]+)"/;				# Get upload file path
      ($name) = $name =~ /name="([^"]+)"/;				# Get field Name
      ($file) = $path =~ /([^\/\\]+)$/;					# get upload file name
      ($ext)  = $path =~ /([^\.]+)$/;					# get upload file ext
      $hash{"$name"} = $value;
      $hash{"$name"."_path"} = $path;
      $hash{"$name"."_file"} = $file;
      $hash{"$name"."_ext"}  = $ext;
      }
    }

  else {
    ### Read GET or POST form into $buffer (for regular forms)
    if    ($ENV{'REQUEST_METHOD'} eq 'POST') { read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'}); }
    elsif ($ENV{'REQUEST_METHOD'} eq 'GET')  { $buffer = $ENV{'QUERY_STRING'}; }

    @pairs = split(/&/, $buffer);				# Split into name/value pairs
    foreach $pair (@pairs) {					# foreach pair
      ($name, $value) = split(/=/, $pair);			# split into $name and $value
      $value =~ tr/+/ /;					# replace "+" with " "
      $value =~ s/%([A-F0-9]{2})/pack("C", hex($1))/egi;	# replace %hex with char
      $value =~ s/\r\n/\n/go;					# replace \r\n with \n
      $hash{$name} = $value;
      }
    }

  ### Convert image submit button vars (var.x & var.y) to normal vars (var)
  foreach (keys %hash) { if (/^(.*)(\.x|\.y)$/) { $hash{$1} = "true"; }}

  return %hash;
  }


# ------------------------------------------------------------------------ 
# Template : Open a template file, translate variables and return contents
#	     If hash is specified var names are read from hash, otherwise
#	     vars are used.
#
# usage    : print &Template("filename.html",\%out);
# ------------------------------------------------------------------------ 

sub Template {  

  if (!$_[0])				{ die "Template : No template file was specified!\n"; }
  if ($_[1] && ref($_[1]) ne "HASH")	{ die "Template : The second argument must be a HASH reference or undefined!\n"; }

  my($file)	= "$Global{'cgidir'}/../templates/$_[0]";		# template file
  my($hashref)	= $_[1];				# hash reference
  my(%hash)	= %{$hashref};				# variable translation hash
  my($cfile);						# current file name
  my($content);						# file contents
  local(*FILE);						# localize filehandle

  ### Assign global vars
  if ($hashref)	{ foreach (keys %Global) { $hash{$_} = $Global{$_}; }}
  else		{ foreach (keys %Global) { ${$_} = $Global{$_}; }}


  ### Load File Contents 
  if (-e "$Global{'cgidir'}/../templates/$_[0]") {				# if exist in template dir
    open(FILE, "<$file") || die "Template : Couldn't open $file! $!\n";
    while (<FILE>) { $content .= $_; }
    close(FILE);
    }
  else {							# else check interface file
    open(FILE,"<$Global{'cgidir'}/../data/interface.dat.cgi");
    while (<FILE>) {
      if (/^-/ && /^--- (\w+\.html) ---$/) { $cfile = $1; next; }
      if    ($cfile eq $_[0]) { $content .= $_; }
      elsif ($content) { last; }
      }
    close(FILE);
    }

  for ($content) {
    s/<!-- insert : (.*?) -->/\1/gi;				# insert content
    s/<!-- template\s?: insert (.*?) -->/\1/gi;			# insert content
    s/<!-- template insert\s?:\s?(.*?) -->/\1/gi;		# insert content

    s/<!-- template\s?:\s?define ([A-Za-z0-9_\.]+) -->(?:\r\n|\n)?(.*?)<!-- template\s?:\s?\/define \1 -->/
	$TemplateCell{$1}=$2;''/gesi;				# define template cells

    s/<!-- templatecell\s?:\s?([A-Za-z0-9_\.]+) -->(?:\r\n|\n)?(.*?)<!-- \/templatecell\s?:\s? \1 -->/
	$TemplateCell{$1}=$2;''/gesi;				# define template cells

    if ($hashref)	{ s/\$(\w+)\$/$hash{$1}/g; }		# translate $var$ into $hash{'var'}
    else		{ s/\$(\w+)\$/${$1}/g; }		# translate $var$ into ${'var'}
    }

  return $content;						# return content with vars translated

}

# ------------------------------------------------------------------------ 
# TemplateCell : Return a template cell with translated variables.
#                Before you can read a cell you need to load the template.
#		 If hash is specified var names are read from hash,
#		 otherwise vars are used.
#
# usage : print &TemplateCell("cellname",\%in);
# ------------------------------------------------------------------------ 

sub TemplateCell {  

  if (!$_[0])				{ die "Template : No template cell was specified!\n"; }
  if (!defined $TemplateCell{$_[0]})	{ die "Template : Template cell '$_[0]' is not defined!\n"; }
  if ($_[1] && ref($_[1]) ne "HASH")	{ die "Template : The second argument must be a HASH reference or undefined!\n"; }

  my($cellname)	= $_[0];				# template cell name
  my($hashref)	= $_[1];				# hash reference
  my(%hash)	= %{$hashref};				# variable translation hash
  my($content)  = $TemplateCell{$cellname};		# file contents
  local(*FILE);						# localize filehandle

  ### Assign global vars
  if ($hashref)	{ foreach (keys %Global) { $hash{$_} = $Global{$_}; }}
  else		{ foreach (keys %Global) { ${$_} = $Global{$_}; }}

  if ($hashref)	{ $content =~ s/\$(\w+)\$/$hash{$1}/g; }# translate $var$ into $hash{'var'}
  else		{ $content =~ s/\$(\w+)\$/${$1}/g; }	# translate $var$ into ${'var'}

  return $content;					# return content with vars translated

}

# ----------------------------------------------------------------------------
# MIME64 : MIME64 encoding/decoding Perl routines.  MIME64 is a common base64
#          encoding scheme documented in RFC1341, section 5.2.
#
# Usage  : $mime64_text = &MIME64_Encode("$plaintext");
#	 : $plaintext   = &MIME64_Decode("$mime64_text");
# ----------------------------------------------------------------------------

sub MIME64_Encode {    
  my($in)  = $_[0];					# text to encode
  my(@b64) = ((A..Z,a..z,0..9),'+','/');		# Base 64 char set to use
  my($out) = unpack("B*",$in);				# Convert to binary
  $out=~ s/(\d{6}|\d+$)/$b64[ord(pack"B*","00$1")]/ge;	# convert 3 bytes to 4
  while (length($out)%4) { $out .= "="; }		# Pad string with '='
  return $out;						# Return encoded text
  }

sub MIME64_Decode {
  my($in)  = $_[0];					# encoded text to decode
  my(%b64);						# Base 64 char set hash
  my($out);						# decoded text variable
  for((A..Z,a..z,0..9),'+','/'){ $b64{$_} = $i++ }	# Base 64 char set to use
  $in = $_[0] || return "MIME64 : Nothing to decode";	# Get input or return
  $in =~ s/[^A-Za-z0-9+\/]//g;				# Remove invalid chars
  $in =~ s/[A-Za-z0-9+\/]/unpack"B*",chr($b64{$&})/ge;	# b64 offset val -> bin
  $in =~ s/\d\d(\d{6})/$1/g;				# Convert 8 bits to 6
  $in =~ s/\d{8}/$out.=pack("B*",$&)/ge;		# Convert bin to text
  return $out;						# Return decoded text
  }


# ----------------------------------------------------------------------------
# URL    : URL encoding/decoding Perl routines.  URL encoding is an common 
#          encoding scheme where non A-Za-z0-9+*.@_- characters are replaced
#          with a character triplet of "%" followed by the two hex digits.
#
# Usage  : $URL_encoded = &URL_Encode("$plaintext");
#	 : $plaintext   = &URL_Decode("$URL_encoded");
# ----------------------------------------------------------------------------

sub URL_Encode {
  my($text)  = $_[0];					# text to URL encode
  $text =~ tr/ /+/;					# replace " " with "+"
  $text =~ s/[^A-Za-z0-9\+\*\.\@\_\-]/			# replace odd chars
             uc sprintf("%%%02x",ord($&))/egx;		#   with %hex value
  return $text;						# return URL encoded text
  }

sub URL_Decode {
  my($text)  = $_[0];					# URL encoded text to decode
  $text =~ tr/+/ /;					# replace "+" with " "
  $text =~ s/%([A-F0-9]{2})/pack("C", hex($1))/egi;	# replace %hex with chars
  return $text;						# return decoded plain text
  }


# ----------------------------------------------------------------------------
# Cookie : Perl routines for setting/reading browser cookies.
#        : Cookies have a max size of 4k and each host can send up to 20.
#
# Usage  : &SetCookie("name","value");
#        : %cookie = &ReadCookie;
# ----------------------------------------------------------------------------

sub SetCookie {

  my($cookie_info);
  my($name,$value,$exp,$path,$domain,$secure) = @_;
  my($expires);

  # $name 	- cookie name (ie: username)
  # $value	- cookie value (ie: "joe user")
  # $exp	- exp date, cookie will be deleted at this date. Format: time() which gets translated into: Wdy, DD-Mon-YYYY HH:MM:SS GMT
  # $path	- Cookie is sent only when this path is accessed   (ie: /);
  # $domain	- Cookie is sent only when this domain is accessed (ie: .edis.org)
  # $secure	- Cookie is sent only with secure https connection

  unless (defined $name) { die("SetCookie : Cookie name must be specified\n"); }
#  if ($exp && $exp !~ /^[A-Z]{3}, \d\d-[A-Z]{3}-\d{4} \d\d:\d\d:\d\d GMT$/i) { die("SetCookie : Exp Dat format isn't: Wdy, DD-Mon-YYYY HH:MM:SS GMT\n"); }
  if ($exp && $exp ne int($exp)) { die("SetCookie : Expire Date isn't in seconds using time();\n"); }

  ### Figure out expire date
  if ($exp) {
    my(@Wdy) = qw(Sun Mon Tue Wed Thu Fri Sat);
    my(@Mon)  = qw(Jan Feb Mar Apr May Jun Jul Aug Sep Oct Nov Dec);
    my($SS,$MM,$HH,$DD,$Mon,$YYYY,$Wdy) = gmtime($exp);
    foreach ($DD,$HH,$MM,$SS) { $_ = sprintf("%02d",$_); }
    my($YYYY) = sprintf("%04d",$YYYY+1900);
    $expires = "$Wdy[$Wdy], $DD-$Mon[$Mon]-$YYYY $HH:$MM:$SS GMT";
    }

  if ($name)		{ $name  = &URL_Encode($name); }
  if ($value)		{ $value = &URL_Encode($value); }
  if ($exp)		{ $cookie_info .= "expires=$expires; "; }
  if ($path)		{ $cookie_info .= "path=$path; "; }
  if ($domain)		{ $cookie_info .= "domain=$domain; "; }
  if ($secure)		{ $cookie_info .= "secure; "; }

  print "Set-Cookie: $name=$value; $cookie_info\n";

  }

sub ReadCookie {

  my($cookie,$name,$value,%jar);

  foreach $cookie (split(/; /,$ENV{'HTTP_COOKIE'})) {		# for each cookie sent
    ($name,$value) = split(/=/,$cookie);			# split into name/value
    foreach($name,$value) { $_ = &URL_Decode($_); }		# URL decode strings
    $jar{$name}=$value;						# and put into %jar hash
    }

   return %jar;							# return %jar hash

}

#1;						# return positive value

# ----------------------------------------------------------------------------
#		       Programming by Edis Digital Inc. <info@edisdigital.com>


# -----------------------------------------------------------------------------
# This program is protected by Canadian and international copyright laws. Any
# use of this program is subject to the the terms of the license agreement
# included as part of this distribution archive. Any other uses are stictly
# prohibited without the written permission of Edis Digital and all other
# rights are reserved.
# -----------------------------------------------------------------------------
#	               Programming by Edis Digital Inc. <info@edisdigital.com>