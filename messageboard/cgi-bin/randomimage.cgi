#!/usr/bin/perl

# This script will allow the message board administrator to specify a
# directory to generate random images from.
#
# ScareCrow (C)opyright 2001 Jonathan Bravata.
#
# This file is part of ScareCrow.
#
# ScareCrow is free software; you can redistribute it and/or modify it under
# the terms of the GNU General Public License as published by the Free
# Software Foundation; either version 2 of the License, or (at your option),
# any later version.
#
# ScareCrow is distributed in the hope that it will be useful, but WITHOUT
# ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
# FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for
# more details.
#
# You should have received a copy of the GNU General Public License along
# with ScareCrow; if not, write to the Free Software Foundation, Inc.,
# 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA.
#
# Author: Jonathan Bravata
# Revision: October 2001

require "global.cgi";

# Get the directory or use the default
my $directory = $Pairs{'dir'};
if(!$directory || !-d "$paths{'noncgi_path'}/$directory") { display_image("board.jpg"); }

# Open the directory and read in the possibilities
opendir(DIR,"$paths{'noncgi_path'}/$directory");
while($in = readdir(DIR)) {
  if(!-d "$paths{'noncgi_path'}/$directory/$in") { push @image_options, $in; }
}
closedir(DIR);

# Get a random image
my $num = int(rand $#image_options);

# Display the image
display_image("$paths{'noncgi_path'}/$directory/$image_options[$num]");


# Displays the image that was selected earlier
sub display_image {
  print "Content-type: image/jpeg\n\n";
  
  # Open the image file
  lock_open(IMAGE,"$_[0]","r");
  while(my $in = <IMAGE>) { $image .= $in; }
  close(IMAGE);
  
  # Print it!
  print $image;
}
