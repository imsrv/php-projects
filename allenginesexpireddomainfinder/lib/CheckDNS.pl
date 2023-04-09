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

use Socket; socket(SOCK,AF_INET,SOCK_DGRAM,getprotobyname('udp'));
use Fcntl qw(F_SETFL O_NONBLOCK); fcntl(SOCK,F_SETFL,O_NONBLOCK);

sub resolv_conf {
    local *CONF; my @NS;
    open CONF, "/etc/resolv.conf" or return;
    /^\s*nameserver\s+(\d+\.\d+\.\d+\.\d+)\s*$/ && push @NS, $1 while <CONF>;
    return @NS ? @NS : ("127.0.0.1");
}
sub cut {
    my @res = unpack $_[1], $_[0]; 
    substr $_[0], 0, length(pack $_[1], @res), "";
    return @res==1 ? $res[0] : @res;
}
sub cutLFS {
	my (@res, $l);
	push @res, cut($_[0], "a".cut($_[0], $_[1]));# while $_[0];
	return @res;
}
sub cutname {
    my (@n,$off,$len);
    push @n, cutLFS($_[0],'C') while ord($_[0]) and (ord($_[0]) & 192) != 192;
    $off = ord($_[0]) ? 0x3fff & cut($_[0],"n") : cut($_[0],"C");
    while ($off and $len = unpack "x$off C", $_[1]) {
        $off = 0x3fff & unpack("x$off n", $_[1]), next if ($len & 192) == 192;
        push @n, unpack "x$off x a$len", $_[1];
        $off += 1 + $len;
    }
    return lc(join ".", @n);
}
sub CheckIP {
	my %Res=GetIP(@_);
	return grep {!$Res{$_}} keys %Res; 
}

sub GetIP {
	my @D = @_; 
	local %Q; my %Res;
	my (@to, %seendomain, $pkt, $buf, $checkall, $n,$i, $st_time);

	push @to,scalar(sockaddr_in(53,pack("C4",split/\./,$_))) for resolv_conf();

    for (@D) {
		my $time = time();
        next if $seendomain{$_}++;
        $Q{$_} = {timeout=>$time+50, resend=>$time+7};
        $pkt=pack("nnnnnna*nn",0,0x0100,1,0,0,0,
            join("",map{chr(length).$_}split/\./,$_)."\00",1,1);
	    send(SOCK,$pkt,0,$to[($i+=1)%=@to]);
	}
	while (keys %Q) {
		my $time = time();
		select undef,undef,undef,0.0001 if 0==(($n++)%10);
        %Res=(%Res,_ans($buf)) if defined recv(SOCK,$buf,10240,0);
		next unless $time - $st_time > 1;
		$st_time = $time;
		delete $Q{$_} for grep {$Q{$_}{timeout}<=$time} keys %Q;
		for (grep {$Q{$_}{resend}<=$time} keys %Q) {
			$Q{$_}{resend} = $time + 7;
			$pkt=pack("nnnnnna*nn",0,0x0100,1,0,0,0,
				join("",map{chr(length).$_}split/\./,$_)."\00",1,1);
			send(SOCK,$pkt,0,$to[($i+=1)%=@to]);
			%Res=(%Res,_ans($buf)) if defined recv(SOCK,$buf,10240,0);
			select undef,undef,undef,0.0001 if 0==(($n++)%10);
		}
	}
	return %Res;
}
sub _ans {
    my $buf = my $pkt = $_[0];
    my ($id,$flags,$qd,$an) = cut($buf, "nnnnnn");
    my ($q,$t) = (cutname($buf, $pkt), cut($buf, "nn"));
    return unless exists $Q{$q} and $t == 1 and $qd == 1;
    delete $Q{$q}; $delete++;
    return ($q,undef) if ($flags & 0x000f) == 3;    # NXDOMAIN
    return ($q,undef) if $flags & 0x000f;           # other Server Errors
    my @an; @an = (cutname($buf, $pkt), cut($buf, "nnN"), cutLFS($buf,"n")),
        $an[1]==$t and last or @an=() for 1..$an;
    return ($q,"") if not @an;                      # NO DATA
    return ($q, join(".", unpack "C4", $an[4]));    # IP addr
}
1;
