#-------------------------------------------------------------------------------
# $Id: CgiWrap.pm,v 1.1 1999/09/29 15:44:23 madcat Exp $
#-------------------------------------------------------------------------------
#
# ChangeLog
# ---------
#
# $Log: CgiWrap.pm,v $
# Revision 1.1  1999/09/29 15:44:23  madcat
# Initial revision
#
# Revision 1.1  1999/02/24 23:46:40  madcat
# Initial revision
#
#
#-------------------------------------------------------------------------------
# CgiWrap.pm
#
# Wrapper around the CGI module.
# (c) 1999 GhostField, All Rights Reserved
#
#-------------------------------------------------------------------------------
package CgiWrap;
require 5.000;

require Exporter;
@ISA=qw(Exporter);
@EXPORT=qw(add_global del_global get_globals get_value %globals);
@EXPORT_OK=qw(%globals);

sub	add_global {
	my ($global)=@_;

	$global=~tr/A-Z/a-z/;
	$globals{$global}="";
}

sub	del_global {
	my ($global)=@_;
	
	if(defined($globals{$global})) {
		delete($globals{$global});
	}
}

sub	get_globals {
	my ($query)=@_;
	my $key;
	
	foreach $key (keys(%globals)) {
		if($key eq "self") {
			$globals{$key}=$query->url;
		} else {
			$globals{$key}=$query->param($key);
		}
	}
}

sub	get_value {
	my ($query,$ident)=@_;
	my $value;

	foreach $key (keys(%globals)) {
		if($key eq $ident) {
			return $globals{$key};
		} 
	}
	$value=$query->param($ident);
	return $value;
}
  
1;
