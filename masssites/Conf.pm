package Conf;
#########################################################
#                Configuration Library                  #
#########################################################
#                                                       #
# These scripts are copywrite by Adult Designz PTY.     #
# any attempt to modify or use this code without proper #
# authorization as well as distributing it in any way   #
# will be considered an infringement of our copywrite   #
# and legal action will be pursued to the fullest       #
# extent possible.                                      #
#                                                       #
# This script was created by:                           #
#                                                       #
# Adult Designz Web Specialties PTY.                    #
# http://www.adultdesignz.com                           #
#                                                       #
# This and many other fine scripts are available at     #
# the above website or by emailing the author at        #
# apex@zyx.net or lisaryan@logicworld.com.au            #
#                                                       #
# Please Read the install.txt that came with this       #
# package for proper installation instructions.         #
#                                                       #
#                                                       #
# This script set may utilize cgi-lib.pl written by     #
# Steven E. Brenner and several perl modules created    #
# by one of our coders Bernhard van Staveren.           #
#########################################################
##############################################################################
# Nothing in this script needs to be touched at all. The chances of you      #
# messing up this script if you do edit this is great.             .         #
##############################################################################
##############################################################################
# Nothing in this script needs to be touched at all. The chances of you      #
# messing up this script if you do edit this is great.             .         #
##############################################################################
##############################################################################
# Nothing in this script needs to be touched at all. The chances of you      #
# messing up this script if you do edit this is great.             .         #
##############################################################################
##############################################################################
# Nothing in this script needs to be touched at all. The chances of you      #
# messing up this script if you do edit this is great.             .         #
##############################################################################
##############################################################################
# Nothing in this script needs to be touched at all. The chances of you      #
# messing up this script if you do edit this is great.             .         #
##############################################################################
##############################################################################
# Nothing in this script needs to be touched at all. The chances of you      #
# messing up this script if you do edit this is great.             .         #
##############################################################################
##############################################################################
# Nothing in this script needs to be touched at all. The chances of you      #
# messing up this script if you do edit this is great.             .         #
##############################################################################
##############################################################################
# Nothing in this script needs to be touched at all. The chances of you      #
# messing up this script if you do edit this is great.             .         #
##############################################################################
##############################################################################
# Nothing in this script needs to be touched at all. The chances of you      #
# messing up this script if you do edit this is great.             .         #
##############################################################################

sub TIEHASH {
  $class=shift;
  $file=shift;
  $self={};
  open(IN, $file);
  while(chomp($line=<IN>)) {
    $line=~s/^\s+//;
    next if $line=~/^#/;
    ($key,$val)=split('=',$line,2);
    $self->{$key}=$val;
  }
  bless $self, $class;
}

sub STORE    { 
  my ($self,$key,$val) = @_;
  $self->{$key} = $val; 
  open(CONF, ">" . $file) or warn "Unable to open $file for writing: $!\n";
  print CONF map { "$_=$self->{$_}\n" } keys %{$self};
  close(CONF);
}

sub FETCH    { $_[0]->{$_[1]} }
sub FIRSTKEY { my $a = scalar keys %{$_[0]}; each %{$_[0]} }
sub NEXTKEY  { each %{$_[0]} }
sub EXISTS   { exists $_[0]->{$_[1]} }
sub DELETE   { delete $_[0]->{$_[1]} }
sub CLEAR    { %{$_[0]} = () }

1;
