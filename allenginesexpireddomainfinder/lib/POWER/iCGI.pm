#!/usr/bin/perl
# Author: Alex Efros <powerman@consultant.com>
# Desc -- Process template wroten in "iCGI" style - break usual CGI to 2 
#	  pieces of code: "logic" and "interface".
# Idea -- take "interface" code from HTML-template, process it in 
#	  eperl-style and output it.
#
package POWER::iCGI;
use CGI;
use POWER::lib;
use strict;
use vars qw( $VERSION %HEADER %COOKIE $path $__ );
$VERSION	= "2.22";
sub import {
    no strict;
    *{"${\scalar caller}::$_"} = \&{$_} for qw(required show redirect_to parse);
    *{"${\scalar caller}::$_"} = \%{$_} for qw(HEADER COOKIE);
}
# print all parameters and exit
sub _print {
    # under mod_perl $SIG{__DIE__} executed after _print by unknown reason
    undef $SIG{__DIE__} if $SIG{__DIE__} == \&_die;
    $|=1;
    print @_;
    # for mod_perl: clean global variables
    (%HEADER, %COOKIE) = ();
    exit()
}
# print informative die message to browser (with file name and stack trace)
sub _die {
    my $msg = CGI::header("text/plain")."iCGI ERROR ($path): $_[0]\n\n";
    my $i; $msg .= join("\n",(caller $i)[3,6],"---\n") while (caller ++$i)[3];
    _print($msg);
}
# return all file content as scalar
sub _cat {
    local *F;
    open(F, "< $_[0]") or die "open `$_[0]': $!\n";
    local $/=undef;
    return <F>;
}
# just like CGI::redirect but with %COOKIE and %HEADER support
sub redirect_to { 
	_print(CGI::redirect(-uri=>$_[0], -cookie=>[values %COOKIE], %HEADER));
}
# process and execute iCGI-style HTML template
sub show {
    local $SIG{__DIE__} = \&_die unless $SIG{__DIE__};
	local $__;
    my $e    = "package ${\scalar caller}; no strict; local (\$^W) = 0 ;\n\n";
    $_[0]=~m!^/! ? ($path=$_[0]) : ($path =~ s![^/]*$!$_[0]!);
    local $_ = _cat($path);
    while ( 1 ) {
        /\G<!--&(.*?)-->/gcs	   && do { $e.="\n$1\n;\n" }
     ||	/\G@~(.*?)~@/gcs	   && do { $e.="\$${\__PACKAGE__}::__ .= POWER::lib::Enc(do { $1; }) ;" }
     ||	/\G#~(.*?)~#/gcs	   && do { $e.="\$${\__PACKAGE__}::__ .= do { $1; } ;" }
     || /\G\^~(.*?)~\^/gcs         && do { $e.="\$${\__PACKAGE__}::__ .= POWER::lib::EncUri(do { $1; }) ;" }
     ||	/\G(.+?)(?=<!--&|@~|#~|\^~|$)/gcs && do { $e.="\$${\__PACKAGE__}::__ .= \"\Q$1\E\";" }
     || last;
    }
    # use $__ as accumulator for calculated HTML result
    eval $e; die if $@;
#    undef $__; eval $e; die if $@;
    _print(CGI::header(-cookie => [values %COOKIE], %HEADER), $__);
}
sub parse {
    local $SIG{__DIE__} = \&_die unless $SIG{__DIE__};
	local $__;
    my $e    = "package ${\scalar caller}; no strict; local (\$^W) = 0 ;\n\n";
    local $_ = _cat($_[0]);
    while ( 1 ) {
        /\G<!--&(.*?)-->/gcs	   && do { $e.="\n$1\n;\n" }
     ||	/\G@~(.*?)~@/gcs	   && do { $e.="\$${\__PACKAGE__}::__ .= POWER::lib::Enc(do { $1; }) ;" }
     ||	/\G#~(.*?)~#/gcs	   && do { $e.="\$${\__PACKAGE__}::__ .= do { $1; } ;" }
     || /\G\^~(.*?)~\^/gcs         && do { $e.="\$${\__PACKAGE__}::__ .= POWER::lib::EncUri(do { $1; }) ;" }
     ||	/\G(.+?)(?=<!--&|@~|#~|\^~|$)/gcs && do { $e.="\$${\__PACKAGE__}::__ .= \"\Q$1\E\";" }
     || last;
    }
    # use $__ as accumulator for calculated HTML result
    #undef $__; 
	eval $e; die if $@;
    return $__;
}
# for mod_perl: reload require'd modules if these modules changed
my %inc; # closure :-)
sub required {
    local $SIG{__DIE__} = \&_die unless $SIG{__DIE__};
    my $e="package ${\scalar caller}; no strict; local (\$^W) = 0 ;\n\n";
    for (@_) {
	next if $inc{$_} == (stat)[9];
	local $path; # change $path only for processing current file
	m!^/! ? ($path=$_) : ($path=~s![^/]*$!$_!);
	eval $e . _cat($path); die if $@;
	$inc{$_} = (stat)[9];
    }
}
1;
