#!/usr/bin/perl
#############################################################
#############################################################
##        Aaron's All Engine Expired Domain Finder         ##
##                This is a Commercial Script              ##
##        Modification, Distribution or Resale without     ##
##        Prior written permission is in Violation of      ##
##        the copyrights and International Intellectual    ##
##        Property Laws.  Violators will be prosecuted!    ##
##        http://www.aaronscgi.com - aaron@aaronscgi.com   ##
#############################################################
#############################################################
#                                                           #
#             THE ONLY CHANGE THAT NEED BE MADE IS          #
#             THE PATH TO PERL AT THE TOP OF THIS           #
#             PAGE IF NEEDED.                               #
#                                                           #
#############################################################
#                                                           #
#            DO NOT EDIT ANYTHING BELOW THIS LINE           #
#                                                           #
#############################################################

use lib "lib/";
use POWER::iCGI;
use POWER::lib;
use POWER::MetaSearch;
use POWER::NB::IO;
use Data::Dumper;
require 'CheckDNS.pl';
require 'CheckWHOIS.pl';

$POWER::Multi::GET::Max_Traffic = 10240000;
$POWER::Multi::GET::Max_URL = 200;
required("Search.pl");
CGI::import_names();
local %Q = map {$_=>${"Q::$_"}} keys %Q::;


local %ERR;
#$HEADER{-Charset} = "koi8-r";
$HEADER{-Pragma}  = "no-cache";
$HEADER{-Expires} = "access";
show( $ENV{PATH_TRANSLATED} );

