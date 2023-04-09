#!/usr/bin/perl
####################################
##  AutoPost Professional v2.1.1  ##
###############################################################
##  accounts.cgi                                             ##
##  ------------                                             ##
##  This script controls the member's accounts.              ##
###############################################################

###############################################################
##                   DO NOT EDIT THIS FILE                   ##
###############################################################

package acts;

use GDBM_File;
use strict;

print "Content-type: text/html\n\n";

eval {
  require "functions.cgi";
};

if( $@ ) {
  print "<b>Script Error:</b> $@";
  exit -1;
}

my($frm, %tmpl, %mem, %bans);

if($ENV{'REQUEST_METHOD'} eq "GET") {
  if($ENV{'QUERY_STRING'}) {
    *function = $ENV{'QUERY_STRING'};
    
    eval {
      &function();
    };
   
    if($@) {
      print "<b>Script Error:</b> $@";
    }  
  }
  else {
    display_add();
  }
}
elsif($ENV{'REQUEST_METHOD'} eq "POST") {
  my($call);

  $frm = fnct::parse(1);
  
  $call = lc( $frm->{'submit'} );
  $call =~ s/ /_/g;
  
  *function = $call;
  
  fnct::derror(1010, "No Function Selected") unless( $call );
  
  eval {
    &function();
  };
   
  if($@) {
    print "<b>Script Error:</b> $@";
  }   
}

exit;

sub login {
  $tmpl{'USERNAME_FIELD'} = qq|<input type="text" name="un" size="12">|;
  $tmpl{'PASSWORD_FIELD'} = qq|<input type="password" name="pw" size="12">|;
  $tmpl{'EDIT_RADIO'}     = qq|<input type="radio" name="choice" value="edit">|;
  $tmpl{'STATS_RADIO'}    = qq|<input type="radio" name="choice" value="stat">|;
  $tmpl{'LINK_RADIO'}     = qq|<input type="radio" name="choice" value="link">|;
  $tmpl{'SUBMIT_BUTTON'}  = qq|<input type="submit" name="submit" value="Log In">|;
  
  fnct::parsetmpl("_account_login.htmlt", \%tmpl);
}

sub remind {
  $tmpl{'EMAIL_FIELD'}    = qq|<input type="text" name="em" size="30">|;
  $tmpl{'SUBMIT_BUTTON'}  = qq|<input type="submit" name="submit" value="Remind Me">|;
  
  fnct::parsetmpl("_account_remind.htmlt", \%tmpl);
}

sub display_add {
  $tmpl{'EM_FIELD'} = qq|<input type="text" name="em_rq" size="30">|;
  $tmpl{'ST_FIELD'} = qq|<input type="text" name="st_rq" size="40" maxlength="$VAR::MT">|;
  $tmpl{'SU_FIELD'} = qq|<input type="text" name="su_rq" size="50" value="http://">|;  
  $tmpl{'SD_FIELD'} = qq|<input type="text" name="sd_rq" size="50" maxlength="$VAR::MD">|;
  $tmpl{'BU_FIELD'} = qq|<input type="text" name="bu" size="50">|;
  $tmpl{'CT_FIELD'} = get_cat_select(undef);
  $tmpl{'UN_FIELD'} = qq|<input type="text" name="un_rq" size="12" maxlength="8">|;
  $tmpl{'PW_FIELD'} = qq|<input type="password" name="pw_rq" size="12" maxlength="8">|;
  $tmpl{'VP_FIELD'} = qq|<input type="password" name="vp_rq" size="12" maxlength="8">|;
  $tmpl{'SUBMIT'}   = qq|<input type="submit" name="submit" value="Add Account">|;
  
  fnct::parsetmpl("_account_add.htmlt", \%tmpl);
}

sub display_edit {
  dbmopen(%mem, "$fnct::sd_dir/members", 0666) || fnct::serror("members", "adm::edit_account()", $!, $frm);
  my @md = split(/\|/, $mem{$frm->{'un'}});
  dbmclose(%mem);
  
  fnct::derror(1014, "This Account Is Locked") unless( int($md[14]) );
  fnct::derror(1015, "This Account Is Suspended") unless( int($md[13]) );
  
  my $pass = unpack('u', $md[12]);
  
  $tmpl{'EM_FIELD'} =  qq|<input type="text" name="em_rq" size="30" value="$md[10]">|;
  $tmpl{'ST_FIELD'} =  qq|<input type="text" name="st_rq" size="50" value="$md[5]">|;
  $tmpl{'SU_FIELD'} =  qq|<input type="text" name="su_rq" size="50" value="$md[8]">|;
  $tmpl{'SD_FIELD'} =  qq|<input type="text" name="sd_rq" size="50" value="$md[6]">|;
  $tmpl{'BU_FIELD'} =  qq|<input type="text" name="bu" size="50" value="$md[9]">|;
  $tmpl{'CT_FIELD'} =  get_cat_select($md[7]);
  $tmpl{'PW_FIELD'} =  qq|<input type="text" name="np_rq" size="12" maxlength="8" value="$pass">|;
  $tmpl{'SUBMIT'}   =  qq|<input type="hidden" name="un" value="$frm->{'un'}">|;
  $tmpl{'SUBMIT'}   .= qq|<input type="hidden" name="pw" value="$frm->{'pw'}">|;
  $tmpl{'SUBMIT'}   .= qq|<input type="submit" name="submit" value="Update Account">|;
  
  fnct::parsetmpl("_account_edit.htmlt", \%tmpl);
}

sub display_stats {
  dbmopen(%mem, "$fnct::sd_dir/members", 0666) || fnct::serror("members", "acts::edit_account()", $!, $frm);
  my @md = split(/\|/, $mem{$frm->{'un'}});
  dbmclose(%mem);
  
  $tmpl{'HITS_IN'}  = $md[0];
  $tmpl{'HITS_OUT'} = $md[1];
  $tmpl{'PREVRANK'} = $md[4];
  $tmpl{'PREVIN'}   = $md[3];
  
  if( -e "$fnct::md_dir/$frm->{'un'}.sts" ) {
    open(STATS, "$fnct::md_dir/$frm->{'un'}.sts") || fnct::serror("$frm->{'un'}.sts", "acts::display_stats()", $!, $frm);
    my $line;
    while( $line = <STATS> ) {
      $tmpl{'STATS'} .= $line;
    }
    close(STATS);
  }
  
  fnct::parsetmpl("_account_stats.htmlt", \%tmpl);
}

sub display_farm {
  $tmpl{'URL'} = $VAR::CU . "/rankem.cgi?action=in&id=" . $frm->{'un'};
  
  fnct::parsetmpl("_account_farm.htmlt", \%tmpl);
}

##################################################
sub update_account {
  checkpass();
  verifyup();
  
  dbmopen(%mem, "$fnct::sd_dir/members", 0666) || fnct::serror("members", "acts::update_account()", $!, $frm);
  my @md = split(/\|/, $mem{$frm->{'un'}});
  
  my $cp = crypt($frm->{'np_rq'}, 'aa');
  my $up = pack('u', $frm->{'np_rq'});
  chomp( $up );
  $frm->{'pw'} = $frm->{'np_rq'};
  
  $mem{$frm->{'un'}} =  "$md[0]|$md[1]|$md[2]|$md[3]|$md[4]|$frm->{'st_rq'}|$frm->{'sd_rq'}|$frm->{'ct'}|$frm->{'su_rq'}";
  $mem{$frm->{'un'}} .= "|$frm->{'bu'}|$frm->{'em_rq'}|$cp|$up|$md[13]|$md[14]|$md[15]|$md[16]|$md[17]";
  
  dbmclose(%mem);
  
  fnct::parsetmpl("_account_updated.htmlt", undef)
}

sub log_in {
  checkpass();
  if( $frm->{'choice'} eq "edit" ) { 
    display_edit();
  } elsif( $frm->{'choice'} eq "stat" ) { 
    display_stats();
  } elsif( $frm->{'choice'} eq "link" ) {
    display_farm();
  } else {
    fnct::derror(1010, "No Function Selected");
  }
}

sub remind_me {
  dbmopen(%mem, "$fnct::sd_dir/members", 0666) || fnct::serror("members", "act::remind_me()", $!, $frm);
  
  my($found, $user) = (0, 0);
  for( keys %mem ) {
    my @md = split(/\|/, $mem{$_});
    
    if( $md[10] eq $frm->{'em'} &&  $_ !~ /_REV$/ ) {
      $found = 1;
      $user  = $_;
      
      my $pass = unpack('u', $md[12]);
      
      my %etmpl;
      $etmpl{'PASS'}   = $pass;
      $etmpl{'USER'}   = $user;
      $etmpl{'EMAIL'}  = $frm->{'em'};
      $etmpl{'LINK'}   = $VAR::CU . "/rankem.cgi?action=in&id=" . $user;
      $etmpl{'EDIT'}   = $VAR::CU . "/accounts.cgi?login";
      $etmpl{'FROM'}   = $VAR::EM;
      
      fnct::prep_email("_email_remind.etmpl", \%etmpl);
      last;
    }
  }
  
  fnct::derror(1013, "E-mail Address Not Found") unless($found);
  
  $tmpl{'EMAIL'}    = $frm->{'em'};
  $tmpl{'USERNAME'} = $user;
  
  fnct::parsetmpl("_account_reminded.htmlt", \%tmpl);
}

sub add_account {
  verifyin();
  
  if( $OPT::EML && !$OPT::REV ) {
    my %etmpl;
    $etmpl{'EMAIL'}     = $frm->{'em_rq'};
    $etmpl{'FROM'}      = $VAR::EM;
    $etmpl{'USER'}      = $frm->{'un_rq'};
    $etmpl{'PASS'}      = $frm->{'pw_rq'};
    $etmpl{'SEND_URL'}  = $VAR::CU . "/rankem.cgi?action=in&id=" . $frm->{'un_rq'};
    $etmpl{'LOGIN_URL'} = $VAR::CU . "/accounts.cgi?login";
    $etmpl{'MAIN_PAGE'} = $VAR::FU;

    fnct::prep_email("_email_added.etmpl", \%etmpl); 
  }
  
  if( $OPT::ADM ) {
    my %etmpl;
    $etmpl{'TO'}    = $VAR::EM;
    $etmpl{'FROM'}  = $VAR::EM;
    $etmpl{'EMAIL'} = $frm->{'em_rq'};
    $etmpl{'USER'}  = $frm->{'un_rq'};
    $etmpl{'TITLE'} = $frm->{'st_rq'};
    $etmpl{'DESC'}  = $frm->{'sd_rq'};
    $etmpl{'URL'}   = $frm->{'su_rq'};
    $etmpl{'ADMIN'} = $VAR::CU . "/admin.cgi";   

    fnct::prep_email("_email_admin.etmpl", \%etmpl); 
  }
  
  my $key = $frm->{'un_rq'};
  $key .= "_REV" if( $OPT::REV );
  
  my $cp = crypt($frm->{'pw_rq'}, 'aa');
  my $up = pack('u', $frm->{'pw_rq'});
  chomp($up);
  
  dbmopen(%mem, "$fnct::sd_dir/members", 0666) || fnct::serror("members", "fnct::add_account()", $!, $frm);
  $mem{$key} =  "0|0|0|0|0|$frm->{'st_rq'}|$frm->{'sd_rq'}|$frm->{'ct'}|$frm->{'su_rq'}|$frm->{'bu'}";
  $mem{$key} .= "|$frm->{'em_rq'}|$cp|$up|1|1|none|0.0.0.0|" . time;
  dbmclose(%mem);

  $tmpl{'TRACK_URL'}   = $VAR::CU . "/rankem.cgi?action=in&id=" . $frm->{'un_rq'};
  $tmpl{'E-MAIL'}      = $frm->{'em_rq'};
  $tmpl{'SITE_TITLE'}  = $frm->{'st_rq'};
  $tmpl{'SITE_URL'}    = $frm->{'su_rq'};
  $tmpl{'SITE_DESC'}   = $frm->{'sd_rq'};
  $tmpl{'BANNER_URL'}  = $frm->{'bu'};
  $tmpl{'USERNAME'}    = $frm->{'un_rq'};
  $tmpl{'PASSWORD'}    = $frm->{'pw_rq'};
  $tmpl{'LOGIN_URL'}   = $VAR::CU . "/accounts.cgi?login";
  
  fnct::parsetmpl("_account_added.htmlt", \%tmpl);
}

sub verifyin {
  for ( keys %{ $frm } ) {
    $frm->{$_} =~ s/"|\|//g;
    fnct::derror(1001, "Required Field Left Blank") if(/_rq$/ && $frm->{$_} eq "");
  }

  checkbans();
    
  dbmopen(%mem, "$fnct::sd_dir/members", 0666) || fnct::serror("members", "acts::verify_data()", $!, $frm);
  
  if( defined $mem{$frm->{'un_rq'}} ) {
    dbmclose(%mem);
    fnct::derror(1005, "Username Taken");
  }
  
  dbmclose(%mem);
  
  
  fnct::derror(1019, "Description Too Large") if( length($frm->{'sd_rq'}) > $VAR::MD );
  fnct::derror(1020, "Title Too Large") if( length($frm->{'st_rq'}) > $VAR::MT ); 
  fnct::derror(1016, "Invalid Site URL") unless( $frm->{'su_rq'} =~ /^http:\/\// );
  fnct::derror(1003, "Username Too Short") if(length($frm->{'un_rq'}) < 5);
  fnct::derror(1002, "Invalid Character In Username") if($frm->{'un_rq'} !~ m/^[a-zA-Z0-9]*$/gi);  
  fnct::derror(1003, "Password Too Short") if(length($frm->{'pw_rq'}) < 5);
  fnct::derror(1004, "Passwords Don't Match") if($frm->{'pw_rq'} ne $frm->{'vp_rq'});
}

sub verifyup {
  for ( keys %{ $frm } ) {
    $frm->{$_} =~ s/"|\|//g;
    fnct::derror(1001, "Required Field Left Blank") if(/_rq$/ && $frm->{$_} eq "");
  }

  checkbans();
  
  fnct::derror(1019, "Description Too Large") if( length($frm->{'sd_rq'}) > $VAR::MD );
  fnct::derror(1020, "Title Too Large") if( length($frm->{'st_rq'}) > $VAR::MT ); 
  fnct::derror(1016, "Invalid Site URL") unless( $frm->{'su_rq'} =~ /^http:\/\// );
  fnct::derror(1003, "Password Too Short") if(length($frm->{'np_rq'}) < 5);
}

sub checkbans {
  dbmopen(%bans, "$fnct::sd_dir/bans", 0666) || fnct::serror("bans", "acts::checkbans()", $!, $frm);
  
  for( keys %bans ) {
    
    if( $_ =~ /^url_/ ) {
      fnct::derror(1006, "Banned Domain") if($frm->{'su_rq'} =~ m/$bans{$_}/gi);
    }
    elsif( $_ =~ /^word_/ ) {
      fnct::derror(1006, "Banned Word") if($frm->{'st_rq'} =~ m/$bans{$_}/gi);
      fnct::derror(1006, "Banned Word") if($frm->{'sd_rq'} =~ m/$bans{$_}/gi);
    } 
    else {
      fnct::derror(1006, "Banned E-Mail") if($frm->{'em_rq'} =~ m/$bans{$_}/gi);
    }
  }
  
  dbmclose(%bans);
}

sub get_cat_select {
  my $in = shift;
  my $html = qq|<select name="ct">|;
  
  $html .= qq|<option value="$in">$in</option>| if( defined $in );
  
  for( split( /,/, $VAR::CT ) ) {
    $html .= qq|<option value="$_">$_</option>|;
  }
  $html .= "</select>";
  $html;
}

sub pisv {
  my($ep, $vp, $cep) = @_;
  
  $cep = crypt($ep, 'aa');

  return $cep eq $vp;
}

sub checkpass  {
  fnct::derror(1018, "Invalid Username") if( $frm->{'un'} =~ /_REV$/ );

  dbmopen(%mem, "$fnct::sd_dir/members", 0666) || FNCT("members", "acts::checkpass()", $!, $frm);
  
  if(!defined $mem{$frm->{'un'}} ) {
    dbmclose(%mem);
    fnct::derror(1018, "Invalid Username");
  }
  
  my $pass = (split(/\|/, $mem{$frm->{'un'}}))[11];
  
  dbmclose(%mem);
  
  fnct::derror(1000, "Invalid Password") unless( pisv($frm->{'pw'}, $pass) );
}
