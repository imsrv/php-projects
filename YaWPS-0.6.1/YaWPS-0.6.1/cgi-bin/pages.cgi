#!/usr/bin/perl -Tw
$| = 1;
# =====================================================================
# YaWPS - Yet another Web Portal System 
#
# Copyright (C) 2001 by Adrian Heiszler (d3m1g0d@users.sourceforge.net)
#
# This program is free software; you can redistribute it and/or 
# modify it under the terms of the GNU General Public License 
# as published by the Free Software Foundation; either version 2 
# of the License, or (at your option) any later version. 
#
# This program is distributed in the hope that it will be useful, 
# but WITHOUT ANY WARRANTY; without even the implied warranty of 
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the 
# GNU General Public License for more details. 
# 
# You should have received a copy of the GNU General Public License 
# along with this program; if not, write to the 
# Free Software Foundation, Inc.,
# 59 Temple Place - Suite 330, 
# Boston, MA  02111-1307, USA. 
#
#
# $Id: pages.cgi,v 1.8 2002/12/15 11:34:22 d3m1g0d Exp $
# =====================================================================

# Load necessary modules.
use strict;
use lib '.';
use yawps;

# Create a new CGI object.
my $query = new CGI;

# Get user profile.
my %user_data = authenticate();

# Get the input.
my $id = $query->param('id');

# Get page headline.
sysopen(FH, "$cfg{pagesdir}/pages.dat", O_RDONLY) or user_error("$err{1} $cfg{pagesdir}/pages.dat. ($!)", $user_data{theme});
chomp(my @cats = <FH>);
close(FH);

my $headline;
foreach my $i (@cats)
{
	my ($name, $value) = split(/\|/, $i);
	if ($name == $id) { $headline = $value; }
}

# Get page content.
sysopen(FH, "$cfg{pagesdir}/$id.txt", O_RDONLY) or user_error("$err{1} $cfg{pagesdir}/$id.txt. ($!)", $user_data{theme});
chomp(my @page_content = <FH>);
close(FH);

print_header();
print_html($user_data{theme}, $headline);

# Print content.
@page_content = do_ubbc(@page_content);
print @page_content;

print_html($user_data{theme}, $headline, 1);
