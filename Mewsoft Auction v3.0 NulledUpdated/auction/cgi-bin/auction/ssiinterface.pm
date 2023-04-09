#!/usr/bin/perl
#!/usr/local/bin/perl
#!/usr/local/bin/perl5
#!C:\perl\bin\perl.exe -w 
=Copyright Infomation
==========================================================
                                                   Mewsoft 

    Program Name    : Mewsoft Auction Software
    Program Version : 3.0
    Program Author  : Elsheshtawy, Ahmed Amin.
    Home Page       : http://www.mewsoft.com
    Nullified By    : TNO (T)he (N)ameless (O)ne

 Copyrights © 2000-2001 Mewsoft. All rights reserved.
==========================================================
 This software license prohibits selling, giving away, or otherwise distributing 
 the source code for any of the scripts contained in this SOFTWARE PRODUCT,
 either in full or any subpart thereof. Nor may you use this source code, in full or 
 any subpart thereof, to create derivative works or as part of another program 
 that you either sell, give away, or otherwise distribute via any method. You must
 not (a) reverse assemble, reverse compile, decode the Software or attempt to 
 ascertain the source code by any means, to create derivative works by modifying 
 the source code to include as part of another program that you either sell, give
 away, or otherwise distribute via any method, or modify the source code in a way
 that the Software looks and performs other functions that it was not designed to; 
 (b) remove, change or bypass any copyright or Software protection statements 
 embedded in the Software; or (c) provide bureau services or use the Software in
 or for any other company or other legal entity. For more details please read the
 full software license agreement file distributed with this software.
==========================================================
              ___                         ___    ___    ____  _______
  |\      /| |     \        /\         / |      /   \  |         |
  | \    / | |      \      /  \       /  |     |     | |         |
  |  \  /  | |-|     \    /    \     /   |___  |     | |-|       |
  |   \/   | |        \  /      \   /        | |     | |         |
  |        | |___      \/        \/       ___|  \___/  |         |

==========================================================
                                 Do not modify anything below this line
==========================================================
=cut
#==========================================================
package Auction;
#==========================================================
sub Do_SSI_Classes{
my ($Out)=@_;
my ($Sub, $Class, $Classes, $Parameters);

		while (	$Out =~ /(<!--)(CLASS::SSI_Exec)(.*)(-->)/ || 
					$Out =~ m/(<!--)(CLASS::SSI_Include)(.*)(-->)/ ||
					$Out =~ m/(<!--)(CLASS::SSI_URL)(.*)(-->)/ ||
					$Out =~ m/(<!--)(CLASS::SSI_Clip_URL)(.*)(-->)/  ){

						$Class = $1 . $2 . $3 . $4;
						$Sub = $2;
						$Parameters = $3;
						$Sub =~ s/^CLASS\:\://;

						$Parameters =~ s/^\s*\(//g;
						$Parameters =~ s/\)\s*$//g;
						$Output = &$Sub($Parameters);
						$Classes = quotemeta($Class);
						$Out =~ s/$Classes/$Output/;
		}

		return $Out;
}
#==========================================================
sub SSI_Exec {
my ($Program) = @_;
my($Out, $Cur_dir, $Base_Dir);

	use Cwd;
	$Cur_dir = cwd;
	$Base_Dir =~ s|/[^/]*$||;
	chdir($Base_Dir) if ($Base_Dir);
	$Out = `$Program`;
	$Out =~ s|Content-type: text/html||is;
	chdir($Cur_dir);
	return $Out;

}
#==========================================================
sub SSI_Include {
my ($File_To_Inculde, $Line_Break_Method) = @_;
my($Out, @Lines);

	open(IN, $File_To_Inculde);
	@Lines = <IN>;
	close IN;
	if (!$Line_Break_Method) {
		$Out=join("", @Lines);
	}
	else{
		$Out=join("<br>", @Lines);
	}

	return $Out;
}
#==========================================================
sub SSI_URL {
my ($url) = @_;
my($ua, @url_refs);
my($p, $res, $base, $html);

#print "Content-type: text/html\n\n";
#print "[[$url]] <br>";return;

	eval "use LWP::UserAgent";
   if ($@) {return "Module LWP::UserAgent Not Found";}
	eval "use HTML::LinkExtor";
   if ($@) {return "Module HTML::LinkExtor Not Found";}
	eval "use URI::URL";
   if ($@) {return "Module URI::URL Not Found";}
   
	$ua = new LWP::UserAgent;
	$ua->agent('Mozilla/3.0 (compatible)');
	@url_refs = ();
	$p = HTML::LinkExtor->new(\&Call_Back);
	$res = $ua->request(HTTP::Request->new(GET => $url));
	$base = $res->base;
	$html = $res->content;
	$p->parse($html);
	@url_refs = map { [$_->[0], $_->[1], url($_->[1], $base)->abs] } @url_refs;

	foreach my $ref (@url_refs){
		my $attr = $ref->[0];
	 	my $val = $ref->[1];
		my $full_val = $ref->[2];
		$html =~ s|$attr\s*=\s*"?$val"?|$attr="$full_val"|igs;
	}

	return $html;
}
#==========================================================
sub SSI_Clip_URL{
my ($Input_Line) = @_;
my ($url, $start, $end);

	eval "use LWP::UserAgent";
   if ($@) {return "Module LWP::UserAgent Not Found";}
	eval "use HTML::LinkExtor";
   if ($@) {return "Module HTML::LinkExtor Not Found";}
	eval "use URI::URL";
   if ($@) {return "Module URI::URL Not Found";}

	($url, $start, $end)= split (/\s*\,\s*/, $Input_Line);
	my $ua = new LWP::UserAgent;
	$ua->agent('Mozilla/3.0 (compatible)');
	@url_refs = ();
	my $p = HTML::LinkExtor->new(\&Call_Back);
	my $res = $ua->request(HTTP::Request->new(GET => $url));
	my $base = $res->base;
	my $html = $res->content;
	$p->parse($html);
	@url_refs = map { [$_->[0], $_->[1], url($_->[1], $base)->abs] } @url_refs;
	if($html =~ m#($start.*$end)#s){
		$html = $1;	
	}
	for my $ref (@url_refs){
		my $attr = $ref->[0];
		my $val = $ref->[1];
		my $full_val = $ref->[2];
		$html =~ s#$attr\s*=\s*"?$val"?#$attr="$full_val"#igs;
	}
	return $html;

}
#==========================================================
sub Call_Back {
my($tag, %attr) = @_;

	while (my ($key,$value) = each %attr) {
		next if $key eq 'usemap';
		push(@url_refs, [$key, $value]);
	}

}
#==========================================================
1;