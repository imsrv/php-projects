package Template;

use strict;



sub new {
  my ($class, $filename, @in) = @_;
  my $self = {};
  bless $self, $class;

  if ($filename) {
    my (@a, $a);
    open FILE, "<$filename" or print "$! $filename";
    @a = <FILE>;
    close FILE;
    $a = join '', @a;
    $self->{code} = $a;
    $self->{code} =~ s/#image_dir#/$main::vars_path_to_images/gm;
  } else {
    $self->{code} = '';
  }
  my $i;
  for ($i = 0; $i<@in; $i+=2) {
    my $t = new Template($in[$i+1]);
    $self->replace($in[$i], $t->{code});
  }
  return $self;

}


sub print {
  my ($self, %keys) = @_;
  my ($t, @f, $f, $f1);

  my $main_t;
  if ($main::user_type eq 'superuser') {
    $main_t = new Template('tmpl/main.html');
  } else {
    $main_t = new Template('tmpl/main2.html');
  }
  $main_t->replace('content', $self->{code});
  
  $t = $main_t->{code};
  $_ = $main_t->{code};
  @f = m/#(FORM_.*?)\#/gms;
  for $f (@f) {
    if ($f =~ /FORM_(.*?)$/) {
      $f1 = $1;
      $t =~ s/\#FORM_$f1\#/$keys{$f1}/gms;
    }
  }
  $self->{code} = $t;

  
  print $self->{code};
  

}

sub print_self {
  my ($self, %keys) = @_;
  my ($t, @f, $f, $f1);

  
  $t = $self->{code};
  $_ = $self->{code};
  @f = m/#(FORM_.*?)\#/gms;
  for $f (@f) {
    if ($f =~ /FORM_(.*?)$/) {
      $f1 = $1;
      $t =~ s/\#FORM_$f1\#/$keys{$f1}/gms;
    }
  }
  $self->{code} = $t;

  
  print $self->{code};
  

}

sub get_area {
  my ($self, $area_desc) = @_;

  my $t = $self->{code};

  if ($t =~ /<\!--\[$area_desc\]-->(.*?)<\!--\[$area_desc\]-->/ms) {
    return $1;
  }
  return '';
}

sub clear_area {
  my ($self, $area_desc) = @_;
  my $t = $self->{code};
  $t =~ s/<\!--\[$area_desc\]-->(.*?)<\!--\[$area_desc\]-->//ms;
  $self->{code} = $t;
}

sub clear_areas {
  my ($self, @area_desc) = @_;
  my $area;
  for $area (@area_desc) {
    $self->clear_area($area);
  }
}

sub make_for {
  my ($self, $sth) = @_;
  my $t = $self->{code};

  my $i = 0;
  my @fields;

  my $return = '';

  my %rplc;
  $_ = $t;
  my (@ar) = m/\#\?(.*?)\#/igms;
  for $a (@ar) {
    $rplc{$a} = [];
    my @b = split /:/, $a;
    $rplc{$a} =  \@b;
  }

  my $count = 0;
  my $row;
  while ($row = $sth->fetchrow_hashref) {
    $t = $self->{code};
    if ($i == 0) {
      @fields = keys %$row;
      $i++;
    }
    for my $f (@fields) {
      $t =~ s/\#$f\#/$row->{$f}/igms;
    }
    for my $f (keys %rplc) {
      $a = $rplc{$f};
      my $arr_size = @$a;
      my $ind = $count < $arr_size ? $count : $count % $arr_size;
      $t =~ s/\#\?$f\#/$rplc{$f}->[$ind]/igms;
    }
    $return .= $t;
    $count ++;
    
  }
  $self->{code} = $return;

}

sub replace {
  my ($self, $what, $to) = @_;

  $self->{code} =~ s/\#$what\#/$to/gms;

}

sub replace_hash {
  my ($self, %hash) = @_;
  my $i;

  for $i (keys %hash) {
    $self->{code} =~ s/\#$i\#/$hash{$i}/gms;
  }

}

sub make_for_array {
  my ($self, $what, $optselarea, @rplc) = @_;
  my $return = '';
  my $t;
  my $tmpl;
  my $i;

  
  $_ = $optselarea;
  my (@ar) = m/\#\?(.*?)\#/igms;
  my %rplc;
  for $a (@ar) {
    $rplc{$a} = [];
    my @b = split /:/, $a;
    $rplc{$a} =  \@b;
  }

  my $count = 0;

  for $t (@rplc) {
    $tmpl = $optselarea;
    for $i (keys %$t) {
      $tmpl =~ s/\#$i\#/$t->{$i}/gms;
    }

    for my $f (keys %rplc) {
      $a = $rplc{$f};
      my $arr_size = @$a;
      my $ind = $count < $arr_size ? $count : $count % $arr_size;
      $tmpl =~ s/\#\?$f\#/$rplc{$f}->[$ind]/igms;
    }
    $count ++;

    $return .= $tmpl;
  }
  $self->replace($what, $return);


}

sub text_replace {
  my ($txt, $what, $to) = @_;
  $txt =~ s/\#$what\#/$to/igms;
  return $txt;

}

sub replace_tags {
  my ($self) = @_;
  $self->{code} =~ s/</&lt;/igms;
  $self->{code} =~ s/>/&gt;/igms;

}

sub text_replace_tags {
  my ($self, $a) = @_;
  $a =~ s/</&lt;/igms;
  $a =~ s/>/&gt;/igms;
  return $a;
}

1;