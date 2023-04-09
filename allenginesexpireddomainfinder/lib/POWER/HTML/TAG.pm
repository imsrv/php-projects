#!/usr/bin/perl -w
# Author: Alex Efros <powerman@consultant.com>
# Desc -- Best and faster than HTML::Parser
# Idea -- Make tag identification approximate to IE, Netscape.
#
package POWER::HTML::TAG;
use Exporter ();
use strict;
use vars qw( $VERSION %R @ISA @EXPORT @EXPORT_OK );

@ISA 	   = qw(Exporter);
@EXPORT    = ();
@EXPORT_OK = qw( &get_title &strip &parse &get_links );
$VERSION   = "1.992";

my %R=();	# the HEART of this module - regexp's used by various functions
$R{param_name}		= qr/ (?: [^\"\'\`\s=>]	| 
				    \"[^\"]*\"		| 
				    \'[^\']*\'		|
				    \`[^\`]*\`
				) [^\s=>]* /x;
$R{param_value}		= qr/ (?: [^\"\'\`\s>]	| 
				    \"[^\"]*\"		| 
				    \'[^\']*\'		|
				    \`[^\`]*\`
				) [^\s>]* /x;
$R{param} 		= qr/ \s+ ($R{param_name}) =? ($R{param_value})? /xo;
$R{param_} 		= qr/ \s+  $R{param_name}  =?  $R{param_value}?  /xo;
$R{endtag} 		= qr/ $R{param_}* \s* /xo;
$R{bigtag_full}		= qr/ (APPLET) $R{endtag}> (.*?) <\/APPLET $R{endtag} |
	    		      (OBJECT) $R{endtag}> (.*?) <\/OBJECT $R{endtag} |
			      (SCRIPT) $R{endtag}> (.*?) <\/SCRIPT $R{endtag} |
			      (STYLE)  $R{endtag}> (.*?) <\/STYLE  $R{endtag} |
	    		      (TITLE)  $R{endtag}> (.*?) <\/TITLE  $R{endtag} /xsi;
$R{bigtag_full_}	= qr/	APPLET $R{endtag}> .*? <\/APPLET $R{endtag}  |
	    			OBJECT $R{endtag}> .*? <\/OBJECT $R{endtag}  |
				S (?:
	    			    CRIPT $R{endtag}> .*? <\/SCRIPT $R{endtag} |
				    TYLE  $R{endtag}> .*? <\/STYLE  $R{endtag}
				  ) 				|
	    			TITLE  $R{endtag}> .*? <\/TITLE  $R{endtag} /xsi;
$R{starttag} 		= qr/ [!\/]? \w+ /x;
$R{closetag} 		= qr/ \/     \w+ /x;
$R{comment1} 		= qr/ !-- (.*?) (?<=--) /xs;
$R{comment1short}	= qr/ !-- (.*?)         /xs;
$R{comment2} 		= qr/ \?  (.*?) (?<=\?) /xs;
$R{comment1_} 		= qr/ !--  .*?  (?<=--) /xs;
$R{comment1short_}	= qr/ !--  .*?          /xs;
$R{comment2_} 		= qr/ \?   .*?  (?<=\?) /xs;

# return title of html
sub get_title { 
    my $H = $_[0];
    ### comments? fake comments in tag params?
    $H =~ / < TITLE $R{endtag} > (.*?) < \/TITLE $R{endtag} > /ixso;
    return $1;
}
# return only TEXT without any tags (and without title)
sub strip {
    my $H = $_[0];
    $H=~s/ < (?:
	    $R{closetag}	|
	    $R{bigtag_full_}	|
	    $R{starttag}	|
	    $R{starttag} $R{endtag}	|
	    $R{comment1_}	|
	    $R{comment1short_}	|
	    $R{comment2_}	
	     ) > //gxo;
    return $H;
}
# you need to redefine these function to make it work
sub parse_text {}	# $_[0] = found text between tags
sub parse_comment {}	# $_[0] = found comment text
sub parse_tag {}	# $_[0] = tag in upper case, 
			# $_[1] = tag content for tags like TITLE, SCRIPT, etc.
			# $_[2] = reference to hash with attributes, where hash
			# keys are attribute in upper case and hash value is 
			# value of attribute:
			# %attr=%{$_[2]}; $attr{HREF} eq "http://www.ru/".
			# value leaved as is, with quotation marks if any.
			# $_[3] = full tag as is in plain text
# parse all html and execute parse_text, parse_comment, parse_tag functions
sub parse {
    my $H = $_[0];
    ELEM: while (1) {
	$H=~/\G</gc	and do {
	    $H=~/\G($R{closetag})>/gco	and parse_tag(uc($1),
		    undef, undef, "<$1>"), next ELEM;
	    $H=~/\G($R{bigtag_full})>/gco	and parse_tag(uc($2.$4.$6.$8.$10),
		    $3.$5.$7.$9.$11, undef, "<$1>"), next ELEM;
	    $H=~/\G($R{starttag})>/gco		and parse_tag(uc($1),
		    undef, undef, "<$1>"), next ELEM;
	    $H=~/\G($R{starttag})($R{endtag})>/gco	and do {
		    my ($plain, $tag, $par, %param) = ("<$1$2>", uc($1), $2);
		    $param{uc($1)}=$2 while $par=~/\G$R{param}/go;
		    parse_tag($tag, undef, \%param, $plain);
		}, next ELEM;
	    $H=~/\G$R{comment1}>/gco		and parse_comment($1), next ELEM;
	    $H=~/\G$R{comment1short}>/gco	and parse_comment($1), next ELEM;
	    $H=~/\G$R{comment2}>/gco		and parse_comment($1), next ELEM;
	    parse_text("<");
	    }, next;
	$H=~/\G([^<]+)/gc and parse_text($1), next;
	last;
    }
}
# you need to redefine this function to make it work
sub parse_url {}	# $_[0] = url from <A HREF=, <AREA HREF=, <FRAME SRC=
# parse all html and execute parse_url function
sub get_links { 
    my $H = $_[0];
    $H=~s{<$R{bigtag_full_}>}{}gso; ### bigtag stripping conflict with comments
    while (1) {
	$H=~/\G([^<]+)/gc;
	$H=~/\G<$R{starttag}>/gco 	and next;
	$H=~/\G<($R{starttag})/gco 	and do {
		my $tag=uc($1);
		if ($tag eq "A" or $tag eq "AREA") {
		    uc($1) eq "HREF" and parse_url($2) while $H=~/\G$R{param}/gco;
		    $H=~/\G\s*>/gc;
		} elsif ($tag eq "FRAME") {
		    uc($1) eq "SRC" and parse_url($2) while $H=~/\G$R{param}/gco;
		    $H=~/\G\s*>/gc;
		} else { $H=~/\G$R{endtag}>/gco }
    	    }, next;
        $H=~/\G$R{comment1}>/gco 	and next;
        $H=~/\G$R{comment1short}>/gco 	and next;
        $H=~/\G$R{comment2}>/gco 	and next;
        $H=~/\G</gc 			and next;
	last;
    }
}

1;
