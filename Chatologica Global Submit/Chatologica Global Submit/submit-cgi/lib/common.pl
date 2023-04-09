#########################################################################################
# Chatologica common.pl library - some frequently used procedures
# All rights reserved (c) 2000; http://www.chatologica.com/
#########################################################################################
#
#     USAGE & EXAMPLES:
#	
#	%record = &StrArr($String, @fields_order);	# parse a DB record to a hash
#	%record = &StrArr('Bob|student|28','name','job','age');
#	$record{'job'} is 'student'
#
#	$record = &ArrStr(\%Array,\@fields_order);	# the reverse of &StrArr
#	$string = &ArrStr(\%record,\@fields_order);
#	$string will be 'Bob|student|28' if we refer to the above example
#
#	@file_list = &dir($directory_name);		# list only non-hidden files
#	@file_list = &dir('.');				# list the current directory
#
#	$HTML_text = &to_HTML($plain_text);		# translate to HTML
#	$HTML_text = &to_HTML('my <plain> text & example');
#	$HTML_text will be 'my &lt;plain&gt; text &amp; example'
#
#	$URLencoded_string = &URLencode($string_to_encode);	# URL-encoding
#	$URLencoded_string = &URLencode('$%^');
#	$URLencoded_string will be '%24%25%5E';
#	
#	$plain_text = &HTML_to_text($HTML_code);	# remove html tags from a text
#
#	&DieMsg('print this and exit');	
#										
#########################################################################################

use strict;			# use strict pragma

sub StrArr			# parse a DataBase record - string (delimiter is |) to 
{				# an associative array with keys in @keys
    my($Str, @keys) = @_;	# @keys gives us the fileds order in the record
    my($i, @values, %Arr) = ();
    chomp($Str);				# remove new line symbols at the end
    @values = split(/\|/,$Str);			# parse the DB record
    foreach $i (0..$#keys) {
        $Arr{$keys[$i]} = $values[$i];
    };
    return %Arr;		# associative array is ready
};



sub ArrStr			# produce a DataBase record - string (delimiter is |)
				# from an hash %$Arr and ordering as in @$order
{				# It is the reverse of &StrArr
    my($Arr, $order) = @_;
    my($Str, $key, $val) = ();
    my @db_list = ();
    foreach $key (@$order) {
      	chomp $$Arr{$key};		# remove new line if any
      	$val = $$Arr{$key};
      	$val =~ s/\|/:/g;		# | is prohibited - translate it to :
      	push @db_list, $val;
    };
    return join('|',@db_list);		# DB record is ready
};



sub dir 				# return a list of non-hidden files in the directory
{
    my($d) = @_;			# path to the directory
    my(@files, @non_hidden, $f) = ();
    opendir(D,"$d");
    @files = readdir(D);		# read the directory
    chomp @files;			# remove new lines if any
    closedir D;
    foreach $f (@files){
      	if($f !~ m/^\./) {		# file is not hidden
            push @non_hidden, $f;
      	};
    };
    return @non_hidden;
};
  


sub to_HTML				# convert a plain text to HTML, encoding the 
{ 					# &, < and > symbols
    my($str) = @_;
    $str =~ s/\&/\&amp;/g;
    $str =~ s/</\&lt;/g;
    $str =~ s/>/\&gt;/g;
    $str =~ s/\"/&quot;/g;
    return $str				# return encoded string
};



sub URLencode				# URL encoding of illegal characters
{
    my($s) = @_;			# string to encode
    my($str, $c, $c1, $c2, $char) = ();
    my @h = ('A'..'F');			# hex numbers
    while ($s =~ m/(.)/g) {
	$char = $1;
	if($char !~ /([\w\. ])/ ) { 	# encode only non-word symbols
	    $c = ord $char;
	    $c1 = $c % 16; 		# making first hex digit
	    if($c1 > 9) {
		$c1 = $h[$c1 - 10];
    	    };
            $c2 = int ($c / 16);      	# making the second hex digit
    	    if($c2 > 9) {
		$c2 = $h[$c2 - 10];
    	    };
	    $char = "%$c2$c1";		# this is the hex code of the symbol
	};
	$str .= $char;
    };
    $str =~ s/ /+/g;			# encode white spaces with + signs
    return $str;        		# return URL-encoded string    			
};



sub HTML_to_text			# turn a html code to plain text
{					
    my($str) = @_;			# the html code
    $str =~ s/<p>|<br>|<dt>|<dd>/ /sg;	# translate line terminators to spaces
    $str =~ s/<.+?>//sg;		# remove HTML tags
    $str =~ s/[\n\r]/ /sg;		# remove new lines
    $str =~ s/&nbsp;/ /sg;		# translate white spaces
    $str =~ s/&amp;/&/sg;		# translate & signs
    $str =~ s/&quot;/\"/sg;		# translate " signs
    $str =~ s/&lt;/</sg;                # translate < signs
    $str =~ s/&gt;/>/sg;                # translate > signs
    $str =~ s/\s+/ /sg;                 # shrink white spaces
    $str =~ s/^\s+(\S)/$1/;             # remove beginning white spaces
    return $str;			# return plain text
};



sub DieMsg 				# prints a custom message as a web page and exit
{
    my($message, $full_header) = @_;
    if($full_header) {
	print "$ENV{'SERVER_PROTOCOL'} 200 OK\015\012";
    	print "Server: $ENV{'SERVER_SOFTWARE'} + cgi script from Chatologica: http://www.chatologica.com/\015\012";
    };
    open(F,'<templates/message.htm');	# read template file
    my @txt = <F>;
    close F;
    eval("print <<\"endofhtml\";\nContent-type: text/html\n\n@txt\nendofhtml\n");
    exit;
};



1; # this library must return TRUE

