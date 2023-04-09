#!/usr/bin/perl
####################################
##  AutoRank Professional v2.1.1  ##
##########################################################
##  setup.cgi                                           ##
##  ---------                                           ##
##  This file controls the setup of the script          ##
##########################################################

package setup;

use strict;
use GDBM_File;

print "Content-type: text/html\n\n";

eval {
  require "functions.cgi";
  require "$fnct::sd_dir/errors.dat";
  require "$fnct::sd_dir/def.html";
};

if( $@ ) {
  print "<b>Script Error:</b> $@";
  exit -1;
}

my($frm, %tmpl, %data, %mem);

if($ENV{'REQUEST_METHOD'} eq "GET") {
  init();
  display();
}
elsif($ENV{'REQUEST_METHOD'} eq "POST") {
  my($call);
  
  $frm = fnct::parse(1);
  
  fnct::derror(1000, "Invalid Password") unless fnct::pisv( $frm->{'password'} );
  
  $call = lc( $frm->{'submit'} );
  $call =~ s/ /_/g;

  *function = $call;
  
  eval {
    &function();
  };
   
  print "<b>Script Error:</b> $@" if($@);
}

exit;

sub display {
  $tmpl{'HTML_DIR'}     = $VAR::HD;
  $tmpl{'CGI_URL'}      = $VAR::CU;
  $tmpl{'FORWARD_URL'}  = $VAR::FU;
  $tmpl{'EMAIL_SERVER'} = $VAR::ES;
  $tmpl{'EMAIL'}        = $VAR::EM;
  $tmpl{'CATS'}         = $VAR::CT;
  $tmpl{'SPLIT'}        = $VAR::SA;
  $tmpl{'BREAK'}        = $VAR::BA;
  $tmpl{'PAGES'}        = $VAR::PL;
  $tmpl{'FONTS'}        = $VAR::FS;
  $tmpl{'TOTAL'}        = $VAR::SL;
  $tmpl{'MIN'}          = $VAR::MH;
  $tmpl{'BANNERS'}      = $VAR::BN;
  $tmpl{'MAX_TIT'}      = $VAR::MT;
  $tmpl{'MAX_DESC'}     = $VAR::MD;
  $tmpl{'RERANK'}       = $VAR::RR;
  $tmpl{'RESET'}        = $VAR::RS;
  $tmpl{'NEW_ICON'}     = $VAR::NI;
  $tmpl{'NEW_SHOW'}     = $VAR::NS;
  $tmpl{'HEIGHT'}       = $VAR::BH;
  $tmpl{'WIDTH'}        = $VAR::BW;
  $tmpl{'HTML_URL'}     = $VAR::HU;
  $tmpl{'TZOFF'}        = $VAR::TZ;
  $tmpl{'ADM_CHK'}      = getcb("OPT_ADM", $OPT::ADM);
  $tmpl{'SOM_CHK'}      = getcb("OPT_SOM", $OPT::SOM);
  $tmpl{'CHT_CHK'}      = getcb("OPT_CHT", $OPT::CHT);
  $tmpl{'RANDOM_CHK'}   = getcb("OPT_RND", $OPT::RND);
  $tmpl{'SMTP_CHK'}     = getcb("OPT_STP", $OPT::STP);
  $tmpl{'ERRORS_CHK'}   = getcb("OPT_ERR", $OPT::ERR);
  $tmpl{'OUT_CHK'}      = getcb("OPT_OUT", $OPT::OUT);
  $tmpl{'DOUBLE_CHK'}   = getcb("OPT_DBL", $OPT::DBL);
  $tmpl{'REV_CHK'}      = getcb("OPT_REV", $OPT::REV);
  $tmpl{'EMAIL_CHK'}    = getcb("OPT_EML", $OPT::EML);
  $tmpl{'CRON_CHK'}     = getcb("OPT_CRN", $OPT::CRN);
  $tmpl{'NEW_CHK'}      = getcb("OPT_NEW", $OPT::NEW);
  
  fnct::parsetmpl("_admin_setup.htmlt", \%tmpl);
}

sub init {
  unless( -e "$fnct::sd_dir/admin.epf" ) {
    open(ADMPASS, ">$fnct::sd_dir/admin.epf") || fnct::serror("admin.epf", "setup::init()", $!, $frm);
    print ADMPASS crypt('admin', 'aa');
    close(ADMPASS);
  }
}

sub save_this_data {
  verify();
  save();
  
  $tmpl{'SD_DIR'} = dirtest($fnct::sd_dir);
  $tmpl{'MD_DIR'} = dirtest($fnct::md_dir);
  $tmpl{'MH_DIR'} = dirtest($frm->{'VAR_HD'});
  $tmpl{'ADMIN'}  = $frm->{'VAR_CU'} . "/admin.cgi";
  
  fnct::parsetmpl("_admin_verify.htmlt", \%tmpl);
}

sub verify {
  my $count = 0;
  for (keys %{ $frm }) {
    $frm->{$_} =~ s/"//g;
    $count++ if( $frm->{$_} eq "" );
  }
  
  fnct::derror(1017, "Page List/List Splits Error") if( split(/,/, $frm->{'VAR_PL'}) != split(/,/, $frm->{'VAR_SA'}) + 1 );
  
  inwarn("$count Fields Were Left Blank") if( $count );
}

sub save {
  open(VARS, ">$fnct::sd_dir/vars.dat") || fnct::serror("vars.dat", "setup::save()", $!, $frm);
  
  print VARS "package VAR;\n";
  
  for( sort grep { /^VAR_/ } keys %{ $frm } ) {
    my $key = $_;
    $key =~ s/^VAR_//;
    $frm->{$_} =~ s/'//;
    $frm->{$_} =~ s/\/$//;
    print VARS "\$VAR::$key = '$frm->{$_}';\n";
  }
 
  print VARS "package OPT;\n";

  for( sort grep { /^OPT_/ } keys %{ $frm } ) {
    my $key = $_;
    $key =~ s/^OPT_//;
    print VARS "\$OPT::$key = '$frm->{$_}';\n";
  }
  
  print VARS "1;";
  close(VARS);
  
  chmod(0666, "$fnct::sd_dir/vars.dat") || fnct::serror("vars.dat", "setup::save()", $!, $frm);
  
  open(DEF, "$fnct::sd_dir/def.html") || fnct::serror("def.html", "setup::save()", $!, $frm);
  my @def = <DEF>;
  close(DEF);
  
  for( split( /,/, $frm->{'VAR_PL'} ) ) {
    unless( -e "$fnct::sd_dir/$_" ) {
      
      open(FILE, ">$fnct::sd_dir/$_") || fnct::serror($_, "setup::save()", $!, $frm);
      
      for( @def ) {
        print FILE;
      }
      
      close(FILE);
      
    }
  }
  
  require "$fnct::sd_dir/def.html";
  
  dbmopen(%data, "$fnct::sd_dir/info", 0666) || fnct::serror("info", "setup::save()", $!, $frm);
  $data{'fields'} = pack('u', $HTML::CGI) if( !defined $data{'fields'} );
  dbmclose(%data);
    
  chmod(0666, "$fnct::sd_dir/info");
  
  dbmopen(%mem, "$fnct::sd_dir/members", 0666) || fnct::serror("members", "setup::save()", $!, $frm);
  dbmclose(%mem);
  chmod(0666, "$fnct::sd_dir/members");
}

sub getcb {
  my($item, $value) = @_;
  return qq|<input type="checkbox" name="$item" value="1" checked>| if($value);
  return qq|<input type="checkbox" name="$item" value="1">|;
}

sub dirtest {
  my $dir = shift;
  
  open(FILE, ">$dir/test.file") || return "<font color='red'>Failed!</font><br>Could Not Create File<br>$!";
  print FILE "TEST PASSED!";
  close(FILE);
  
  unlink("$dir/test.file") || return "<font color='red'>Failed!</font><br>Could Not Remove File<br>$!";
  
  return "<font color='blue'>Passed</font>";
}

sub inwarn {
  my $msg = shift;
  
  print qq|<center><font face="Verdana,Arial" size="2">Warning: $msg<br>Make sure the fields you have |;
  print qq|left blank are not required fields.</font></center><p>|;
}
