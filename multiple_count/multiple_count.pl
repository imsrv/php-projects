#!/usr/bin/perl
######################################
#           Multiple Count           #
######################################
#  Last Update: August 19 2001       #
#  Created by RealityWebs            #
#    ( http://www.realitywebs.com )  #
#  Contact: support@realitywebs.com  #
#  Copyright 2000-2001.              #
######################################

$log='/home/mydirectory/logs/multiple_count.log';

###################################
#            Stop Here            #
###################################
$path=$ENV{'DOCUMENT_URI'}||$ENV{'REQUEST_URI'}; print "Content-Type: text/html\n\n";
if(open(CNT,"+< $log")) { flock(CNT,2); @count=<CNT>; for($el=0;$el<=$#count;$el++) {
($ct,$rec,undef)=split(/\|/,$count[$el]); if($found=($path eq $rec)) {
$count[$el]=join('|',++$ct,$rec,"\n"); last; } }
push(@count,join('|',$ct='1',$path,"\n")) unless $found; seek(CNT,0,0); truncate(CNT,0);
print CNT sort{($b=~/(\d+)/)[0]<=>($a=~/(\d+)/)[0]} @count; flock(CNT,8); close(CNT); print $ct; }
else { $date=localtime(); print 'SCRIPT ERROR'; die "[$date] [error] $!: $log - Script: $0\n"; }