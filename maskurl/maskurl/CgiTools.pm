#-------------------------------------------------------------------------------
# $Id: CgiTools.pm,v 1.1 1999/09/29 15:44:23 madcat Exp $
#-------------------------------------------------------------------------------
#
# ChangeLog
# ---------
#
# $Log: CgiTools.pm,v $
# Revision 1.1  1999/09/29 15:44:23  madcat
# Initial revision
#
# Revision 1.1  1999/05/12 02:32:49  madcat
# Initial revision
#
# Revision 1.1  1999/02/24 23:46:20  madcat
# Initial revision
#
#
#-------------------------------------------------------------------------------
# CgiTools.pm
#
# A perl module to make life easier for those who write CGI scripts.
# (c) 1999 GhostField, All Rights Reserved
#
#-------------------------------------------------------------------------------
package CgiTools;
require 5.000;

require Exporter;
@ISA=qw(Exporter);
@EXPORT=qw(unsethook sethook dumpfile dumphtml cgi_print redirect content);
@EXPORT_OK=qw();

$print_hook=undef;

sub cgi_print {
	my ($line)=@_;
	my $handler;

	if($print_hook eq undef) {
		print($line);
	} else {
		&$print_hook($line);
	}
}

sub dumpfile {
	my($filename)=@_;
	my @in;
	my $line;

	open(IN,$filename) || return 0;
	chomp(@in=<IN>);
	close(IN);
  
	foreach $line(@in) {
		&cgi_print($line."\n");
	}
	return 1;
}

sub dumphtml {
	my($filename)=@_;
  
	print("Content-Type: text/html\n\n");
	return &dumpfile($filename);
}

sub sethook {
	my($hook)=@_;
  
	$print_hook=$hook;
}

sub unsethook {
	$print_hook=undef;
}

sub	redirect {
	my ($redirurl)=@_;	
	
	print("Location: $redirurl\n\n");
	exit(0);
}

sub	content {
	my ($subcontent)=@_;
	
	print("Content-Type: text/$subcontent\n\n");
	exit(0);
}
  
1;
