#-------------------------------------------------------------------------------
# $Id: Configuration.pm,v 1.1 1999/09/29 15:44:24 madcat Exp $
#-------------------------------------------------------------------------------
#
# ChangeLog
# ---------
#
# $Log: Configuration.pm,v $
# Revision 1.1  1999/09/29 15:44:24  madcat
# Initial revision
#
# Revision 1.1  1999/02/24 23:46:45  madcat
# Initial revision
#
#
#-------------------------------------------------------------------------------
# Configuration.pm
#
# Configuration file read/write routines
# (c) 1999 GhostField, All Rights Reserved
#
#-------------------------------------------------------------------------------
package Configuration;
require 5.000;

require Exporter;
@ISA=qw(Exporter);
@EXPORT=qw(load_config save_config %config);
@EXPORT_OK=qw(%config);

## PUBLIC GLOBAL VARS
#
undef(%config);

## PUBLIC ROUTINES
#
sub	load_config {
	my($file)=@_;	
	my $path;
	my @config;
	my $line;
	my $ident;
	my $val;

	$path=$0;
	$path=~/(.*)\//;
	$path=$1;

	open(CONFIG,"${path}/$file") || return 0;
	chomp(@config=<CONFIG>);
	close(CONFIG);
	foreach $line (@config) {
		if(($line!~/^\#/) && ($line ne undef)) {
			($ident,$val)=split("=",$line);
			# clean it up
			$ident=~s/^\s+//g;
			$val=~s/^\s+//g;
			$ident=~tr/A-Z/a-z/;
			$config{$ident}=$val;
		}
	}
	return 1;
}

sub	save_config {
	my ($file)=@_;
	my $path;
	my $ident;
	
	$path=$0;
	$path=~/(.*)\//;
	$path=$1;

	open(CONFIG,">${path}/$file") || return 0;
	foreach $ident (keys(%config)) {
		print(CONFIG $ident."=".$config{$ident}."\n");
	}
	close(CONFIG);
	return 1;
}

1;
