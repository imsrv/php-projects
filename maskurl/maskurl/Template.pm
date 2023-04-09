#-------------------------------------------------------------------------------
# $Id: Template.pm,v 1.1 1999/09/29 15:44:24 madcat Exp $
#-------------------------------------------------------------------------------
#
# ChangeLog
# ---------
#
# $Log: Template.pm,v $
# Revision 1.1  1999/09/29 15:44:24  madcat
# Initial revision
#
# Revision 1.1  1999/08/06 18:47:39  madcat
# Initial revision
#
# Revision 2.0  1999/05/06 05:44:05  madcat
# *	Total Rewrite
#
#-------------------------------------------------------------------------------
# Template.pm version 2.0
#
# A perl module to use templates for HTML output. This module can only be used
# in combination with CgiTools.pm
# (c) 1999 GhostField, All Rights Reserved
#
#-------------------------------------------------------------------------------
package Template;
require 5.000;

require Exporter;
@ISA=qw(Exporter);
@EXPORT=qw(tline add_handler template_print_hook template_init);
@EXPORT_OK=qw();

%handlers=(
		"url"		=>	\&tmpl_handle_url
	  );

%tmplconfig=(
		"selfurl"	=>	""
	    );
		
## PUBLIC
sub	tline {
	my ($replword, $replline, $replwith)=@_;
	
	$replline=~s/\%$replword\%/$replwith/gi;
	return $replline;
}

sub	add_handler {
	my ($word, $ref)=@_;
	
	$Template::handlers{$word}=$ref;
}

sub	dump_handlers {
	my @list;
	my $key;
	
	foreach $key (keys(%handlers)) {
		push(@list, "TEMPLATE_HANDLER $key with REF ".$handlers{$key});
	}
	return @list;
}

sub	template_print_hook {
	my ($line)=@_;
	my $word;
	my $handler;

	foreach $word (keys(%Template::handlers)) {
		if($line=~/\%$word\%/gi) {
			$handler=$Template::handlers{$word};
			$line=&$handler($word, $line);
		}
	}
	print($line);
}

sub	template_init {
	my ($cgiquery)=@_;
	
	$tmplconfig{"selfurl"}=$cgiquery->url;
}
	
## PRIVATE
sub	tmpl_handle_url {
	my ($word, $line)=@_;
	
	return &tline($word, $line, $tmplconfig{"selfurl"});
}
	
1;
