##
#
# $Author: madcat $
# $Revision: 1.1 $
# $Log: ActionHandler.pm,v $
# Revision 1.1  1999/09/29 15:44:23  madcat
# Initial revision
#
# Revision 1.1  1999/07/14 01:23:41  madcat
# Initial revision
#
##
package ActionHandler;

require 5.000;
require Exporter;

@ISA=qw(Exporter);
@EXPORT=qw(add_action action_handler);
@EXPORT_OK=qw();

## Private variables

%handlers=();

## Public Subs

sub	add_action {
	$handlers{$_[0]}=$_[1] if $_[1];
	
}

sub	action_handler {
	my $handler=$handlers{$_[0]} || $handlers{"default"};
	
	$handler->(@_);
}

1;
