#!/usr/bin/perl

#############################################################
#										#
# Leave this in please or i will be offended			#
# This script was made for 	#
#										#
# The script was fully planned and made by occy (G.Ockwell) #
# 										#
#############################################################
#					#					#
# Version 1.0			# Created By Grant Ockwell	#
# Made 30/8/99			# occy@caboolture.net.au	#
# Last Modified 30/8/99		# 	#
#					#					#
#############################################################
#          ALSO http://elitescripts.hypermart.net           #
#############################################################

#############################################################
# Variabals - You may edit these to suit your needs 		#
#############################################################
$your_site = "lithwarez";
# just a bit of what your site has. just put

$stollen = "http://www.lithwarez.com";
#the URL to where the page with the msg for when a link is stolen.

$path_to_data = "/usr/home/lithw/public_html/ddl";
# This is the path to all the data files such as que.txt and count.count etc.

#############################################################
# End of Variabals - You can go on if you want			#
#############################################################

$inid = $ENV{'QUERY_STRING'};
$site = $ENV{'HTTP_REFERER'};

if ($site !~ /$your_site/) {
print "Location: $stollen\n\n";
exit;
}

open(DATA,"$path_to_data/files.txt");
flock DATA, 2;
@data=<DATA>;
close(DATA);

foreach $line (@data) {
($filename,$fileurl,$sitename,$siteurl,$email,$date,$id) = split(/::/, $line);
if ($id == $inid){
print "Location: $fileurl\n\n";
exit;
}
}

print "content-type:text/html\n\n";
print "Error";

