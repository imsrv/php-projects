#   Program Name	: AutoGallery Pro
#   Website		: http://www.jmbsoft.com
#   Version		: 2.0.0b
#   Supplier By  	: Sliding
#   Nullified By	: CyKuH
package Parallel;
use POSIX ":sys_wait_h";
use strict;
use vars qw($VERSION);
$VERSION='0.7';

sub new { my ($c,$processes)=@_;
  my $h={
    max_proc   => $processes,
    processes  => {},
    in_child   => 0,
  };
  return bless($h,ref($c)||$c);
};

sub start { my ($s,$identification)=@_;
  die "Cannot start another process while you are in the child process"
    if $s->{in_child};
  while ( ( keys %{ $s->{processes} } ) >=$s->{max_proc}) {
    $s->on_wait;
    $s->wait_one_child;
  };
  $s->wait_children;
  if ($s->{max_proc}) {
    my $pid=fork();
    die "Cannot fork: $!" if !defined $pid;
    if ($pid) {
      $s->{processes}->{$pid}=$identification;
      $s->on_start($pid,$identification);
    } else {
      $s->{in_child}=1 if !$pid;
    }
    return $pid;
  } else {
    $s->{processes}->{$$}=$identification;
    $s->on_start($$,$identification);
    return 0; # Simulating the child which returns 0
  }
}

# finish changed by CAH to accept child's passed in exit code
sub finish { my ($s, $x)=@_;
  if ( $s->{in_child} ) {
    exit $x || 0;
  }
  return 0;
}

sub wait_children { my ($s)=@_;
  return if !keys %{$s->{processes}};
  my $kid;
  do {
    $kid = $s->wait_one_child(&WNOHANG);
  } while $kid > 0;
};

*wait_childs=*wait_children; # compatibility

sub wait_one_child ($;$) { my ($s,$par)=@_;
  my $kid = waitpid(-1,$par||=0);
  if ($kid>0) {
    $s->on_finish($kid, $? >> 8 ,$s->{processes}->{$kid});
    delete $s->{processes}->{$kid};
  }
  $kid;
};

sub wait_all_children { my ($s)=@_;
  $s->wait_one_child while keys %{ $s->{processes} };
}

*wait_all_childs=*wait_all_children; # compatibility;

sub run_on_finish { my ($s,$code,$pid)=@_;
  $s->{on_finish}->{$pid || 0}=$code;
}

sub on_finish { my ($s,$pid,@par)=@_;
  my $code=$s->{on_finish}->{$pid} || $s->{on_finish}->{0} or return 0;
  $code->($pid,@par); 
};

sub run_on_wait { my ($s,$code)=@_;
  $s->{on_wait}=$code;
}

sub on_wait { my ($s)=@_;
  $s->{on_wait}->() if ref($s->{on_wait}) eq 'CODE';
};

sub run_on_start { my ($s,$code)=@_;
  $s->{on_start}=$code;
}

sub on_start { my ($s,@par)=@_;
  $s->{on_start}->(@par) if ref($s->{on_start}) eq 'CODE';
};

sub set_max_procs { my ($s, $mp)=@_;
	$s->{max_proc} = $mp;
}

1;
