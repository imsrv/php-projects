package Template;
# ===============================================================
    use strict;
    use vars qw($VERSION $error @ISA @EXPORT);  # Globals.
    @ISA    = ();                               # Not inhereited.
    @EXPORT = qw();
    $Template::VERSION = '1.0';

sub error {
# ---------------------------------------------------------------
# Handles error messages.
#
    my ($errtype, $e1, $e2) = @_;
    my %errors = (
                    'CANTINIT'    => "Template: Can't init, no root defined, or not a hash ref: '$e1'",
                    'NOTEMPLATE'  => "Template: Can't find template: $e1",
                    'CANTOPEN'    => "Template: Can't open template: $e1. Reason: $e2",
                    'NONAMESPACE' => "Tempalte: You haven't loaded a namespace yet!",
                    'NONAME'      => "Template: No name was defined for this template!",
                    'NOSTRING'    => "Template: No text was defined for template: $e1"
    );
    $Template::error = $errors{$errtype};
    die $Template::error;
}

sub new {
# ---------------------------------------------------------------
# Initilizes a new instance of the template parser.
#
    my $this  = shift;
    my $class = ref($this) || $this;
    my $self  = {};
    bless  $self, $class;   
    
    my $opt   = shift;
    unless ((ref $opt eq 'HASH') and (exists ${$opt}{'ROOT'})) {
        &error ('CANTINIT', $opt);
        return undef;
    }
    $self->{'ROOT'}  = ${$opt}{'ROOT'};
    $self->{'CHECK'} = ${$opt}{'CHECK'};

    return $self;
}

sub load_template {
# ---------------------------------------------------------------
# Loads a template either from a file or from a string.
#
    my $self      = shift;
    my ($name, $text) = @_;

    if (!$self->{'CHECK'} and exists $self->{'templates'}{$name}) { return 1; } 
    if (!defined $text) {
        my $file = $self->{'ROOT'} . "/$name";
        -e $file             or (&error('NOTEMPLATE', $file)     and return undef);
        open (TPL, "<$file") or (&error('CANTOPEN', $file, $!)   and return undef);
        $text = join ("", <TPL>);
        close TPL;
    }
    $self->{'templates'}{$name} = $text;
    return 1;
}

sub load_vars {
# ---------------------------------------------------------------
# Sets the variables (all the search and replaces).
#
    my $self = shift;
    my $vars = shift;

    my ($name, $value);
    while (($name, $value) = each %{$vars}) {     
        $self->{'vars'}{$name} = $value;
    }
    return 1;   
}

sub clear_vars {
# ---------------------------------------------------------------
# Clears the namespace.
#
    my $self = shift;
    $self->{'vars'} = {};
    return 1;
}
    
sub parse {
# ---------------------------------------------------------------
# Parses a template.
#
    my ($self, $template) = @_;
    my $begin    = $self->{'begin'} || quotemeta('<%');
    my $end      = $self->{'end'}   || quotemeta('%>');

    exists $self->{'templates'}{$template} or ($self->load_template($template) or return undef);
    exists $self->{'vars'} or (&error ('NONAMESPACE') and return undef);
    $self->{'parsed'}{$template} = '';

    my $temp = $self->{'templates'}{$template};

# Parse includes, do this first so that the includes can include
# template tags.
    $temp =~ s#$begin\s*include\s*(.+?)\s*$end#
            if (exists $self->{'inc'}{$1}) { $self->{'inc'}{$1}; }
            else {
                if (open (INC, "${$self}{'ROOT'}/$1")) { 
                    $self->{'inc'}{$1} = join ("", <INC> );
                    close INC;
                    $self->{'inc'}{$1};
                }
                else {
                    "Can't find file: ${$self}{'ROOT'}/$1";
                }
            }
        #goe;

# Now go line by line and strip out the unwanted stuff looking for
# if and ifnot tags.
    my @lines = split /\n/, $temp;
    $temp     = ''; my @go = (1,1); my $depth = 1; my $line = '';

	LINE: foreach $line (@lines) {
# Init the previous, variable and more strings.
        my ($prev, $var, $neg, $more, $orig, $full_comp, $comp, $val) = ('', '', '', '', '', '', '', '');
		my $result = 0;

# Check for if tags. 
        $line =~ s/((.*?)$begin\s*if(not)?\s+(.+?)(\s+(<|>|lt|gt|eq|=)\s*(.+?))?$end(.*))/
                    ($orig, $prev, $neg, $var, $full_comp, $comp, $val, $more) = ($1, $2, $3, $4, $5, $6, $7, $8);

# We've found an if tag, let's set the depth to see whether we are in print mode or not.
                    if ($prev !~ m,$begin\s*endif\s*$end,og) {
                        $go[$depth] and ($temp .= $prev);
						if (!$full_comp) {
	                        if ($neg) { ($self->{'vars'}{$var}) ? ($go[++$depth] = 0) : ($go[++$depth] = $go[$depth]) and ""; }
					        else {      ($self->{'vars'}{$var}) ? ($go[++$depth] = $go[$depth]) : ($go[++$depth] = 0) and ""; }
						}
						else {
							$val =~ s,^['"],,; $val =~ s,['"]$,,;
							($comp eq 'eq') and ($result = ($self->{'vars'}{$var} eq $val));
							($comp eq '==') and ($result = ($self->{'vars'}{$var} == $val));
							($comp eq 'lt') and ($result = ($self->{'vars'}{$var} lt $val));
							($comp eq 'gt') and ($result = ($self->{'vars'}{$var} gt $val));
							($comp eq '>')  and ($result = ($self->{'vars'}{$var} > $val));
							($comp eq '<')  and ($result = ($self->{'vars'}{$var} < $val));
							if ($neg) { $result ? ($go[++$depth] = 0) : ($go[++$depth] = $go[$depth]) and ""; }
							else      { $result ? ($go[++$depth] = $go[$depth]) : ($go[++$depth] = 0) and ""; }
						}
					}
                    else {
# Oops, there was an endif tag we missed, set the original line back and keep going.
                        $more = '';    $orig;
                    }
                /oe;
        if ($more) { $line = $more; redo LINE; }

# Check for endif tags.
        $line =~ s/(.*?)$begin\s*endif\s*$end(.*)/
                    ($prev, $more) = ($1, $2);
                    $go[$depth] and ($temp .= $prev);
                    $go[$depth--] = 1;
					"";
                /oe;
        if ($more) { $line = $more; redo LINE; }

# Add the content..
        $go[$depth] and ($temp .= "$line\n");
    }

# Replace the special variables, we allow code ref mapping.
    $temp =~ s/$begin\s*(.+?)\s*$end/
            if (exists $self->{'vars'}{$1}) {
                ref ($self->{'vars'}{$1}) eq 'CODE' ? 
                    &{$self->{'vars'}{$1}}($self->{'vars'}) : $self->{'vars'}{$1};
            }
            else { "Unkown Tag: $1"; }
        /goe;

    $self->{'parsed'}{$template} = $temp;

    return $self->{'parsed'}{$template};
}

sub DESTROY {
# ---------------------------------------------------------------

}

1;