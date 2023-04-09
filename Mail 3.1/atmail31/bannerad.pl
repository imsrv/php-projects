#!/usr/bin/perl
open(IMGDB,"bannerad.db");
while(<IMGDB>)  {
push(@imgs, $_);
                }
close(IMGDB);

$rand = rand @imgs;
#foreach $v (@imgs) { print $v; }
#print "Content-Type: image/gif\n\r\n";
#print "Location: /bannerads/$imgs[$rand]\n\n";
print "Location: $imgs[$rand]\n\n";
open(MYIMG,$imgs[$rand]);
#while(<MYIMG>)  { print $_; }
close(MYIMG);

