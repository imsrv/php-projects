#########################################################################################
# Chatologica GlobalSubmit - submit-lib.pl
# All rights reserved (c) 2000; http://www.chatologica.com/
#########################################################################################
use strict;
use vars qw(
	%profile
	$make_submit_data_code
	%PROFILES
	$timeout
	$full_header
);



sub submit					# submitting
{ 
    my @modules = sort keys %PROFILES;		# sorted by name list of modules
    my($m,$i) = ();
    my ($url, $content, $err, $header, $bytes, $content1, $err1, $header1, $bytes1) = ();
    $i = 0;					# current module index
    my($response_code, $error_tag, $redirect_tag) = ();
    my($form_begin, $form_end, $enctype) = ();
    splice(@modules,10);
    foreach $m (@modules) {			# loop through all modules
	$i ++;
	($url, $content, $err, $header, $bytes, $content1, $err1, $header1, $bytes1) 
	= &HTTP2($PROFILES{$m}{'remote_path'}, $PROFILES{$m}{'host'}, $PROFILES{$m}{'port'},
	$PROFILES{$m}{'method'}, $timeout, &variables_encode($PROFILES{$m}{'vars'}),'',1);
	if($err =~ /timeout/i) {	# TIMEOUT: try again with longer timeout(+10 seconds)
	    ($url, $content, $err, $header, $bytes, $content1, $err1, $header1, $bytes1) 
	    = &HTTP2($PROFILES{$m}{'remote_path'}, $PROFILES{$m}{'host'}, $PROFILES{$m}{'port'},
	    $PROFILES{$m}{'method'}, $timeout+10, &variables_encode($PROFILES{$m}{'vars'}),'',1);
	};
	($response_code, $error_tag) = (); 	# init        
	$redirect_tag = '';
	if($url) {				# we detected URL REDIRECTION
	    $redirect_tag = <<"endofhtml";
	&nbsp; &nbsp; Redirected to some URL: <FONT COLOR="#ff0000">handling redirections is available only in the registered version.</FONT>
endofhtml
	};
	($response_code, $error_tag) = (); # init	
	($form_begin, $form_end) = ();	# begin and end part of a cgi form html code
	if($err) {			# Some error detected
	    if($err =~ /timeout/i) {
		$err = &form_code($m);	# the form html code(fields only)
		$url = &make_URL($PROFILES{$m}{'remote_path'},
			$PROFILES{$m}{'host'},
			$PROFILES{$m}{'port'}
    		);
		$enctype = '';
		if($PROFILES{$m}{'multipart'}) {
	    	    $enctype = " ENCTYPE='multipart/form-data'";
		};
		$form_begin = "<FORM NAME=\"form$i\" ACTION=\"$url\" METHOD=\"$PROFILES{$m}{'method'}\"$enctype>";
		$form_end = "</FORM>";
		$err = "Timeout. Try direct $err";
	    } else {
		$err .= "<BR>";
	    };
	    $error_tag = "&nbsp; &nbsp; <FONT COLOR=\"#ff0000\"><B>Error: </B></FONT>$err\n";
	} else {
	    if($header =~ m/(\d\d\d\s.*)$/m) {
	    	$response_code = "&nbsp; Response: <B>$1</B>\n";
	    };
	};
	print <<"endofhtml";
$form_begin
<TABLE BORDER CELLPADDING="2" WIDTH="80%" ALIGN="Center" BGCOLOR="#dddddd">
    <TR>
      <TD><B>$i. </B><A HREF="$PROFILES{$m}{'site_URL'}">$m</A> &nbsp;<SMALL>[ <A HREF=\"$PROFILES{$m}{'addurl_page'}\">AddURL page</A> ]</SMALL> $response_code<BR>$error_tag$redirect_tag
      </TD>
    </TR>
  </TABLE>
$form_end
endofhtml
    };    
};



sub form_code		# making a hidden cgi submit form ( fields only; used by &submit() )
{
    my($mod) = @_;		# $mod is the module name
    my(%data, $var, $code, $var_enc, $val_enc) = ();
    %data = %{$PROFILES{$mod}{'vars'}};
    $code = '';
    foreach $var (keys %data) {			# adding hidden form fields	
	$var_enc = &safe_quotes($var);		# take care about " signs
	$val_enc = &safe_quotes($data{$var});
	$code .= "<INPUT TYPE=hidden NAME=\"$var_enc\" VALUE=\"$val_enc\">";
    };
    return <<"endofhtml";  
    <INPUT TYPE=submit VALUE="Submit">
    $code
endofhtml
};



sub load_modules	# loading all add-on modules and preparing submit data
{
    my(%in) = @_;
    my($m, %vars) = ();
    if(!$in{'dir'}) {
	$in{'dir'} = 'modules';			# default directory with modules
    };
    my @modules = &dir($in{'dir'});		# read directory
    foreach $m (@modules) {			# loop through the module files
	(%profile,				# init module data
	$make_submit_data_code) = ();					
	eval{require "$in{'dir'}/$m";};		# load this module
	if($@) {
	    &DieMsg("error during compilation of module $m:<BR> $@",$full_header);
	};
    	if(!$make_submit_data_code) {
	    &DieMsg("\$make_submit_data_code is not defined for module $m\n",$full_header);
    	};
    	if(!%profile) {
	    &DieMsg("%profile is not defined for module $m\n",$full_header);
    	};
	eval{			# executing the subroutine part of this module
	    $profile{'vars'} = &{$make_submit_data_code}(%in);
	};
	if($@) {
	    &DieMsg("Error in subroutine part of module $m: $@",$full_header);
    	};
	$PROFILES{$profile{'site_name'}} = {%profile};		# hash with all submission data
    };    
};



sub prepare_input_data		# adjust the input data to a better style
{
    my($in) = @_;		# receive %in by address and adjust values
    my ($i, $keywords, @keys, %unique) = ();	# making list of all keywords
    $keywords = $$in{'keywords'};		# add keywords from predefined list
    push @keys, split(/\0/,$keywords);
    $$in{'keywords'} = join(' ', @keys);
    $$in{'more_keywords'} =~ s/\r\n/\n/g;	# removing new lines
    $$in{'more_keywords'} =~ s/\n/ /g;
    $$in{'description'} =~ s/\r\n/\n/g;
    $$in{'description'} =~ s/\n/ /g;
    $keywords = $$in{'more_keywords'};		# adding the additional keywords
    $keywords =~ s/,/ /g;			# remove commas
    $keywords =~ s/\s+/ /g;			# shorten the white spaces
    $keywords =~ s/^\s+(\S)/$1/;
    $keywords =~ s/(\S)\s+$/$1/;
    push @keys, split(/ /,$keywords);		# add keywords additionally defined
    foreach $i (@keys) {
	$unique{lc $i} = '';			# make it in lower case and add as a hash key
    };
    @keys = keys %unique;			# this is a list of unique keywords only
    $$in{'all_keywords'} = \@keys; 		# remember a reference to the keywords list
    $$in{'all_keywords_as_string'} = join(' ', @keys);   
    $$in{'all_keywords_as_string_with_commas'} = join(',', @keys); 
    # The IP address of this host. Example: 126.22.12.77
    # Some engines as HotBot needs it.
    $$in{'ip'} = join (".", unpack("C4", inet_aton($ENV{'HTTP_HOST'})));
    $$in{'url'} =~ s{/$}{};
};



# If we have a list of keywords we can rate a number of options and select
# the best one with highest rating. $options is ref. to either %hash or @list
# $defailt is either default hash key or default list element
sub get_best_match
{
    my($options, $default, @keys) = @_;	# @keys - list of prefered keywords
    my(@list, %rates, $opt, $key) = (); # $default value to pass
    if(ref($options) eq 'HASH') {	# $options - reference to %hash with key/value options
	@list = keys %$options;		# make list of keys only - the more verpose part
    } else {
	@list = @$options;		# or to @list with options values
    };
    foreach $opt (@list) {		# rate all of possible options to pass
	foreach $key (@keys) {
	    if($opt =~ m/$key/i) {
		$rates{$opt} ++;	# keyword match - increase the rating number
	    };
	};
    };
    my $max_rate = 0;			
    foreach $key (keys %rates) {	# finding the top rated option
	if($rates{$key} >= $max_rate) {
	    $max_rate = $rates{$key};
	    $opt = $key;		# remember the top rated option
	};
    };
    if(!$max_rate) {			# there is no matches - set a default option
	$opt = $default;
    };
    if(ref($options) eq 'HASH') {	# return the value which we have to pass
	return $$options{$opt};
    } else {
	return $opt;
    };
};



sub safe_quotes			# encode " sings as &quot; in html
{
    my($str) = @_;
    $str =~ s/\"/&quot;/g;
    return $str;
};



sub variables_encode		# URL-encode the variables/values being passed out to net
{
    my($variables) = @_;		# hash of variable/value pairs
    my($var, @pairs) = ();
    foreach $var (keys %$variables) {
       push @pairs, (&URLencode($var) . "=" . &URLencode($$variables{$var}));
    };
    return join('&',@pairs);
};



1; # this library must return TRUE

