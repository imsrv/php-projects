#!/usr/bin/perl 
# ==================================================================
# Links SQL - enhanced directory management system
#
#   Website  : http://gossamer-threads.com/
#   Support  : http://gossamer-threads.com/scripts/support/
#   CVS Info : 087,071,086,089,083 
#   Revision : $Id: install.cgi,v 1.105 2002/05/14 20:14:57 alex Exp $
#
# Copyright (c) 2001 Gossamer Threads Inc.  All Rights Reserved.
# Redistribution in part or in whole strictly prohibited. Please
# see LICENSE file for full details.
# ==================================================================

# Automated install script. Please replace the first line with
#           #!/path/to/perl
# if the install doesn't work for you.

{
#--BEGIN Libs

BEGIN { $INC{"GT/AutoLoader.pm"} = "GT/AutoLoader.pm" }
{
# ==================================================================
# Gossamer Threads Module Library - http://gossamer-threads.com/
#
# GT::AutoLoader
# Author: Jason Rhinelander
# $Id: AutoLoader.pm,v 1.7 2002/05/29 18:08:56 jagerman Exp $
#
# Copyright (c) 2002 Gossamer Threads Inc. All Rights Reserved.
# ==================================================================

package GT::AutoLoader;

use vars qw($AUTOLOAD %LOG %PACKAGES);
use strict qw/vars subs/; # no strict 'refs' - we need several soft references here.

sub import {
    shift; # Discard the package, as 'use GT::AutoLoader' calls GT::AutoLoader->import(ARGS)
    my %opts = @_;

    my $pkg = caller;
    ++$PACKAGES{$pkg};

    if ($opts{LOG} and ref $opts{LOG} eq 'CODE') {
        $LOG{$pkg} = delete $opts{LOG}; # Everything that requests a log will get one for all modules
    }

    delete $opts{NAME} if $opts{NAME} and $opts{NAME} eq 'AUTOLOAD'; # Allows "if ($opts{NAME})" later on.

    my $COMPILE;
    *{$pkg . ($opts{NAME} ? "::$opts{NAME}" : '::AUTOLOAD')} = sub {
        if ($opts{NAME} or !$AUTOLOAD) { # If they're using another name, it most likely means they are wrapping the AUTOLOAD, which means we have to check for $AUTOLOAD in their package.
            $AUTOLOAD = ${$pkg . '::AUTOLOAD'};
        }
        my ($func) = $AUTOLOAD =~ /([^:]+)$/; # How odd - we use $GT::AutoLoader::AUTOLOAD, even though this is run in some other package

        if ($COMPILE = \%{$pkg . '::COMPILE'}) {
            if (defined $COMPILE->{$func}) {
                for (keys %LOG) { $LOG{$_}->($pkg, $func, 'COMPILE') }

                _compile($COMPILE, $pkg, $func);

                $AUTOLOAD = '';

                goto &{"$pkg\::$func"};
            }
        }

        if ($opts{NEXT}) {
            my ($pack, $func) = $opts{NEXT} =~ /(?:(.+)::)?([^:]+?)$/;
            $pack ||= $pkg;
            ${$pack . '::AUTOLOAD'} = $AUTOLOAD;
            my $next = "$pack\::$func";
            $AUTOLOAD = '';
            goto &$next;
        }

# It doesn't exist in %COMPILE, which means we have to look through @ISA for another AUTOLOAD to pass this to
        if (my @inh = @{"$pkg\::ISA"}) {
            while (my $inh = shift @inh) {
                my $al = $inh . '::AUTOLOAD';
                if (defined &$al) {
                    $$al = "$pkg\::$func"; # Sets $Other::Package::AUTOLOAD
                    $AUTOLOAD = '';
                    goto &$al;
                }
                elsif (my @isa = @{$inh . '::ISA'}) {
                    unshift @inh, @isa;
                }
            }
        }

        my ($file, $line) = (caller)[1,2];
        $AUTOLOAD = '';
        die "$pkg ($$, GT::AutoLoader): Unknown method '$func' called at $file line $line.\n";
    };

    my $compile = "$pkg\::COMPILE";
    *$compile = \%$compile; # Implements "use vars qw/%COMPILE/" for you

    1;
}

BEGIN {
    if ($^C) {
        eval q{
sub CHECK {
# ------------------------------------------------------------------------------
# In Perl 5.6+ this allows you to do: perl -cMMy::Module -e0 to make sure all
# your %COMPILE subs compile In versions of Perl prior to 5.6, this is simply
# treated as a sub named "CHECK", which is never called. $^C is also 5.6+
# specific - whether or not you are running under "-c"
    compile_all();
}
};
    }
}

sub compile_all {
    my @pkg = @_;
    if (@pkg) {
        @pkg = grep +($PACKAGES{$_} or (warn "$_ is not loaded, does not use GT::AutoLoader, or is not a valid package" and 0)), @pkg;
        @pkg or die "No valid packages passed to compile_all()!";
    }
    else {
        @pkg = keys %PACKAGES;
    }

    for my $pkg (@pkg) {
        my $COMPILE = \%{$pkg . '::COMPILE'} or next;
        for my $func (keys %$COMPILE) {
            _compile($COMPILE, $pkg, $func);
        }
    }

    return 1;
}

sub _compile {
# ------------------------------------------------------------------------------
# Compiles a subroutine from a module's %COMPILE into the module's package.
# die()s if the subroutine cannot compile or still does not exist after
# compiling. Takes three arguments: A reference to the packages %COMPILE hash,
# the package, and the name of the function to load.
#
    my ($COMPILE, $pkg, $func) = @_;

    my $linenum = ($COMPILE->{$func} =~ s/^(\d+)//) ? $1+1 : 0;
    eval "package $pkg;\n#line $linenum$pkg\::$func\n$COMPILE->{$func}";
    if ($@) { die "Unable to load $pkg\::$func: $@" }
    if (not defined &{"$pkg\::$func"}) {
        die "Unable to load $pkg\::$func: Subroutine did not compile correctly (possible bad name).";
    }

    undef $COMPILE->{$func}; # Leave the key in the compile hash so that things can test to see if it was defined in the compile hash
    return;
}

1;



=head1 NAME

GT::AutoLoader - load subroutines on demand

=head1 SYNOPSIS

    package GT::Module;
    use GT::AutoLoader; # You now have an AUTOLOAD subroutine that will check for entries in %COMPILE

or

    package GT::OtherModule;
    use GT::AutoLoader(NAME => '_AUTOLOAD'); # Import AUTOLOAD as _AUTOLOAD, define our own AUTOLOAD
    sub AUTOLOAD {
        ...
        goto &_AUTOLOAD;
    }

then:

    $COMPILE{sub} = __LINE__ . <<'END_OF_SUB';
    sub method_name {
        ...
    }
    END_OF_SUB

=head1 DESCRIPTION

The B<GT::AutoLoader> module works as a way to speed up your code. Currently,
the only thing it does is scan for a %COMPILE hash in your package. If it finds
it, it looks for the subroutine you called, and if found compiles and runs it.

If unable to find a subroutine to compile in %COMPILE, B<GT::AutoLoader> will
scan your inheritance tree (@ISA) for another AUTOLOAD subroutine to pass this
off to. If there isn't any, a fatal error occurs.

To use B<GT::AutoLoader>, in its standard behaviour, simply put:
C<use GT::AutoLoader;> in your module. When you use GT::AutoLoader, two things
will happen. First, an C<AUTOLOAD> subroutine will be imported into your
namespace that will automatically compile your subroutines only when they are
needed, thus speeding up compile time. Secondly, a %COMPILE hash will be defined
in your package, eliminating the need for you to: use vars qw/%COMPILE/;

=head1 USE

You can pass options to GT::AutoLoader to change the behaviour of the module.
Currently, logging is the only option, however more options (perhaps including
a different compiling scheme) will be added at some future point.

Options are specified as import() arguments. For example:

    use GT::AutoLoader(OPTION => "value");

=over 4

=item NAME

If you want to import the autoload subroutine as something other than
'Package::AUTOLOAD', the 'NAME' option should be used. Its value is the name
to import as. For example, to import a GT::AutoLoader AUTOLOAD named _AUTOLOAD
(this is useful when declaring your own AUTOLOAD behaviour, but still using
GT::AutoLoader's behaviour as a fallback), you would do something like:

    use GT::AutoLoader(NAME => '_AUTOLOAD');

=item LOG

Takes a code reference as its value. The code reference will be called three
arguments - the package name, the name of the function, and the autoload method
(Currently only 'COMPILE'). Note that this will be called for ALL autoloaded
subroutines, not just the ones in your package.

WARNING - you cannot put code in your log that relies on autoloaded methods -
you'll end up throwing the program into an infinite loop.

For example, to get a line of debugging after each subroutine is compiled, you
could C<use GT::AutoLoader> like this:

    use GT::AutoLoader(LOG => sub {
        print "Compiled $_[1] in package $_[0]\n"
    });

=item NEXT

Normally, GT::AutoLoader will look for another AUTOLOAD to call in your
package's @ISA inheritance tree. You can alter this behaviour and tell
GT::AutoLoader what to call next using the NEXT option.

For example, if you have a sub _AUTOLOAD { } that you wanted to call if the
method isn't found by GT::AutoLoader, you would use GT::AutoLoader like this:

    use GT::AutoLoader(NEXT => 'Package::Name::_AUTOLOAD');

The _AUTOLOAD function in your package will now be called if GT::AutoLoader
can't load the method on its own. $AUTOLOAD will be set for you in whichever
package the function you provide is in. Note that if you simply want to use an
inherited AUTOLOAD, you B<should not> use this option; GT::AutoLoader will
handle that just fine on its own.

You may omit the package (Package::Name::) if the function is in your current
package.

=back

=head1 compile_all

A function exists in GT::AutoLoader to compile all %COMPILE-subroutines. By
default (without arguments) compile_all() compiles every %COMPILE-subroutine in
every package that has used GT::AutoLoader. You can, however, pass in a list of
packages which compile_all() will check instead of compiling everything. Note
that GT::AutoLoader will only compile %COMPILE-subroutines in packages that
have used GT::AutoLoader, so if you specify package "Foo", but "Foo" hasn't
used GT::AutoLoader, it will be ignored.

You can do something like:

    GT::AutoLoader::compile_all(__PACKAGE__) if $MOD_PERL;

to have a GT::AutoLoader compile every %COMPILE-subroutine in the current
package automatically under mod_perl, or you could add this code to your
mod_perl startup file or test script:

    GT::AutoLoader::compile_all;

Test scripts should definately use compile_all() to ensure that all subroutines
compile correctly!

=head1 REQUIREMENTS

None.

=head1 WARNINGS

Due to the nature of Perl's AUTOLOAD handling, you must take care when using
GT::AutoLoader in a subclass. In short, subclassed methods B<MUST NOT> be put
into the %COMPILE hash.

The problem is that since the subroutine does not exist in the package, Perl,
while decending the inheritance tree, will not see it but will probably see the
parent's method (unless nothing else has called the method, but you should
never count on that), and call it rather than looking for your package's
AUTOLOAD.

This isn't to say that subclasses cannot use AUTOLOAD - just that subclasses
cannot use autoloaded methods (%COMPILE-subroutines) if a method of the same
name exists in the parent class. Autoloaded function calls are not affected.

=head1 MAINTAINER

Jason Rhinelander

=head1 SEE ALSO

L<GT::Base>

=head1 COPYRIGHT

Copyright (c) 2002 Gossamer Threads Inc.  All Rights Reserved.
http://www.gossamer-threads.com/

=head1 VERSION

Revision: $Id: AutoLoader.pm,v 1.7 2002/05/29 18:08:56 jagerman Exp $

=cut

}

BEGIN { $INC{"GT/Base.pm"} = "GT/Base.pm" }
{
# ==================================================================
# Gossamer Threads Module Library - http://gossamer-threads.com/
#
#   GT::Base
#   Author  : Alex Krohn
#   CVS Info : 087,071,086,089,083 
#   $Id: Base.pm,v 1.108 2002/05/31 19:15:16 jagerman Exp $
#
# Copyright (c) 2000 Gossamer Threads Inc.  All Rights Reserved.
# ==================================================================
#
# Description:
#   Base module that handles common functions like initilization, 
#   debugging, etc. Should not be used except as a base class.
#

package GT::Base;
# ===============================================================
    require 5.004;              # We need perl 5.004 for a lot of the OO features.

    use strict qw/vars subs/;   # No refs as we do some funky stuff.
    use vars   qw/$AUTOLOAD $DEBUG $VERSION $ATTRIB_CACHE $MOD_PERL $SPEEDY $PERSIST %ERRORS/;
    use GT::AutoLoader(NEXT => 'GT::Base::_AUTOLOAD');
    
    $DEBUG              = 0;
    $VERSION            = sprintf "%d.%03d", q$Revision: 1.108 $ =~ /(\d+)\.(\d+)/;
    $MOD_PERL           = (exists $ENV{GATEWAY_INTERFACE} and ($ENV{GATEWAY_INTERFACE} =~ /^CGI-Perl/)) ? 1 : 0;
    $SPEEDY             = ($CGI::SpeedyCGI::_i_am_speedy or $CGI::SpeedyCGI::i_am_speedy) ? 1 : 0;
    $PERSIST            = $MOD_PERL || $SPEEDY;
    $ATTRIB_CACHE       = {};
    %ERRORS             = (
        MKDIR     => "Could not make directory (%s). Reason: %s",
        OPENDIR   => "Could not open directory (%s). Reason: %s",
        RMDIR     => "Could not remove directory (%s). Reason: %s",
        CHMOD     => "Could not chmod (%s). Reason: %s",
        UNLINK    => "Could not unlink (%s). Reason: %s",
        READOPEN  => "Could not open (%s) for reading. Reason: %s",
        WRITEOPEN => "Could not open (%s) for writting. Reason: %s",
        OPEN      => "Could not open (%s). Reason: %s",
        BADARGS   => "Wrong argument passed to this subroutine. Usage: %s"
    );

sub import {
# -------------------------------------------------------
# Only exports $MOD_PERL, $SPEEDY, and $PERSIST.
#
    my $pkg = shift;
    my %symbol = map { $_ => 1 } @_;

    my $callpkg = caller;
    *{$callpkg . '::MOD_PERL'} = \$MOD_PERL if $symbol{'$MOD_PERL'} or $symbol{':all'};
    *{$callpkg . '::SPEEDY'}   = \$SPEEDY if $symbol{'$SPEEDY'} or $symbol{':all'};
    *{$callpkg . '::PERSIST'}  = \$PERSIST if $symbol{'$PERSIST'} or $symbol{':all'};
    return;
}

sub new {
# -------------------------------------------------------
# Create a base object and use set or init to initilize anything.
#
    my $this    = shift;
    my $class   = ref $this || $this;

# Create self with our debug value.
    my $self = { _debug => defined ${"$class\:\:DEBUG"}  ? ${"$class\:\:DEBUG"} : $DEBUG };
    bless $self, $class;
    $self->debug ("Created new $class object.") if ($self->{_debug} > 2);

# Set initial attributes, and then run init function or call set.
    $self->reset;
    if ($self->can('init')) {
        $self->init(@_);
    }
    else {
        $self->set(@_) if (@_);
    }
    
    if ( index ($self, 'HASH') != -1 ) {
        $self->{_debug} = $self->{debug} if $self->{debug};
    }
    return $self;
}

sub DESTROY {
# -------------------------------------------------------
# Object is nuked.
#
    (index ($_[0], 'HASH') > -1) or return;
    if ($_[0]->{_debug} and $_[0]->{_debug} > 2) {
        my ($package, $filename, $line) = caller;
        $_[0]->debug ("Destroyed $_[0] in package $package at $filename line $line.");
    }
}

sub _AUTOLOAD {
# -------------------------------------------------------
# We use autoload to provide an accessor/setter for all
# attributes.
#
    my ($self, $param) = @_;
    my ($attrib)       = $AUTOLOAD =~ /::([^:]+)$/;

# If this is a known attribute, return/set it and save the function
# to speed up future calls.
    my $autoload_attrib = 0;
    if (ref $self and (index ($self, 'HASH') != -1) and exists $self->{$attrib} and ! exists $COMPILE{$attrib}) {
        $autoload_attrib = 1;
    }
    else {
# Class method possibly.
        if (! ref $self) {
            my $attribs = $ATTRIB_CACHE->{$self} || _get_attribs($self);
            if (exists $attribs->{$attrib}) {
                $autoload_attrib = 1;
            }
        }
    }
# This is an accessor, create a function for it.
    if ($autoload_attrib) {
        *{$AUTOLOAD} = sub {
                            if (! ref $_[0]) { # Class Method
                                my $attribs = $ATTRIB_CACHE->{$_[0]} || _get_attribs($_[0]);
                                if (@_ > 1) {
                                    $_[0]->debug ("Setting base attribute '$attrib' => '$_[1]'.") if (defined ${$_[0] . '::DEBUG'} and (${$_[0] . '::DEBUG'} > 2));
                                    $ATTRIB_CACHE->{$_[0]}->{$attrib} = $_[1];
                                }
                                return $ATTRIB_CACHE->{$_[0]}->{$attrib};
                            }
                            if (@_ > 1) { # Instance Method
                                $_[0]->debug ("Setting '$attrib' => '$_[1]'.") if (defined $_[0]->{_debug} and ($_[0]->{_debug} > 2));
                                $_[0]->{$attrib} = $_[1];
                            }
                            return $_[0]->{$attrib};
                    };
        goto &$AUTOLOAD;
    }

# Otherwise we have an error, let's help the user out and try to 
# figure out what they were doing.
    _generate_fatal($self, $attrib, $param);
}

sub set {
# -------------------------------------------------------
# Set one or more attributes.
#
    return unless (@_);
    if   ( !ref $_[0]) { class_set(@_); }
    else {
        my $self    = shift;
        my $p       = $self->common_param (@_) or return $self->error ('BADARGS', 'FATAL', "Argument to set must be either hash, hash ref, array, array ref or CGI object.");
        my $attribs = $ATTRIB_CACHE->{ref $self} || _get_attribs (ref $self);
        my $f = 0;
        $attribs->{debug} = 0 unless exists $attribs->{debug};
        foreach my $attrib (keys %$attribs) {
            next unless (exists $p->{$attrib});
            $self->debug ("Setting '$attrib' to '${$p}{$attrib}'.") if ($self->{_debug} > 2);
            $self->{$attrib} = $p->{$attrib};
            $f++;
        }
        return $f;
    }
}

sub common_param {
# -------------------------------------------------------
# Expects to find $self, followed by one or more arguments of
# unknown types. Converts them to hash refs.
#
    shift;
    my $out = {};
    return $out unless (@_ and defined $_[0]);
    CASE: {
        (ref $_[0] eq 'HASH')                and do { $out = shift; last CASE; };
        (UNIVERSAL::can ($_[0], 'get_hash')) and do { $out = $_[0]->get_hash; last CASE; };
        (UNIVERSAL::can ($_[0], 'param'))    and do { foreach ($_[0]->param) { my @vals = $_[0]->param($_); $out->{$_} = (@vals > 1) ? \@vals : $vals[0]; } last CASE; };
        (defined $_[0] and not @_ % 2)       and do { $out = {@_}; last CASE; };
        return;
    }
    return $out;
}

sub reset {
# -------------------------------------------------------
# Resets all attribs in $self.
#
    my $self   = shift;
    my $class  = ref $self;
    my $attrib = $ATTRIB_CACHE->{$class} || _get_attribs ($class);

# Deep copy hash and array refs only.
    while (my ($k, $v) = each %$attrib) {
        if (! ref $v) {
            $self->{$k} = $v;
        }
        elsif (ref $v eq 'HASH') {
            $self->{$k} = {};
            foreach my $k1 (keys %{$attrib->{$k}}) { $self->{$k}->{$k1} = $attrib->{$k}->{$k1}; }
        }
        elsif (ref $v eq 'ARRAY') {
            $self->{$k} = [];
            foreach my $v1 (@{$attrib->{$k}}) { push @{$self->{$k}}, $v1; }
        }
        else { $self->{$k} = $v; }
    }
}

sub _get_attribs {
# -------------------------------------------------------
# Searches through ISA and returns this packages attributes.
#
    my $class   = shift;
    my $attrib  = defined ${"$class\:\:ATTRIBS"} ? ${"$class\:\:ATTRIBS"} : {};
    my @pkg_isa = defined @{"$class\:\:ISA"}     ? @{"$class\:\:ISA"}     : ();

    foreach my $pkg (@pkg_isa) {
        next if ($pkg eq 'Exporter'); # Don't mess with Exporter.
        next if ($pkg eq 'GT::Base');
        my $fattrib = defined ${"$pkg\:\:ATTRIBS"} ? ${"$pkg\:\:ATTRIBS"} : next;
        foreach (keys %{$fattrib}) {
            $attrib->{$_} = $fattrib->{$_} unless exists $attrib->{$_};
        }
    }   
    $ATTRIB_CACHE->{$class} = $attrib;
    return $attrib;
}

$COMPILE{debug} = __LINE__ . <<'END_OF_FUNC';
sub debug {
# -------------------------------------------------------
# Displays a debugging message.
#
    my ($self, $msg) = @_;
    my $pkg = ref $self || $self;

# Add line numbers if asked for.
    if ($msg !~ /\r?\n$/) {
        my ($package, $file, $line) = caller;
        $msg .= " at $file line $line.\n";
    }
# Remove windows linefeeds (breaks unix terminals).
    $msg =~ s/\r//g unless ($^O eq 'MSWin32');
    $msg =~ s/\n(?=[^ ])/\n\t/g;
    print STDERR "$pkg ($$): $msg";
}
END_OF_FUNC

$COMPILE{debug_level} = __LINE__ . <<'END_OF_FUNC';
sub debug_level {
# -------------------------------------------------------
# Set the debug level for either the class or object.
#
    if (ref $_[0]) {
        @_ > 1 and ($_[0]->{_debug} = $_[1]);
        return $_[0]->{_debug};
    }
    else {
        my $pkg   = shift;
        if (@_) {
            my $level = shift;
            ${"$pkg\:\:DEBUG"} = $level; 
        }
        return ${"$pkg\:\:DEBUG"};
    }
}
END_OF_FUNC

$COMPILE{warn} = __LINE__ . <<'END_OF_FUNC';
sub warn  { shift->error(shift, WARN  => @_) }
END_OF_FUNC

$COMPILE{fatal} = __LINE__ . <<'END_OF_FUNC';
sub fatal { shift->error(shift, FATAL => @_) }
END_OF_FUNC

$COMPILE{error} = __LINE__ . <<'END_OF_FUNC';
sub error {
# -------------------------------------------------------
# Error handler.
#
    my $self    = shift;
    my ($msg, $level, @args) = @_;
    my $pkg     = ref $self || $self;
    $level      = defined $level ? $level : 'FATAL';
    my $is_hash = index ($self, 'HASH') != -1;

# Load the ERROR messages.
    $self->set_basic_errors;

# err_pkg stores the package just before the users program for displaying where the error was raised
# think advanced croak.
    my $err_pkg = $pkg;
    if ($is_hash) {
        $err_pkg = defined $self->{_err_pkg} ? $self->{_err_pkg} : $pkg;
    }

# initilize vars to silence -w warnings.
# msg_pkg stores which package error messages are stored, defaults to self, but doesn't have to be.
    ${$pkg . '::ERROR_MESSAGE'} ||= '';
    my $msg_pkg = ${$pkg . "::ERROR_MESSAGE"} ? ${$pkg . "::ERROR_MESSAGE"} : $pkg; 
    my $debug = $is_hash ? $self->{_debug} : ${$pkg . "::DEBUG"};

# cls_err stores the actual error hash (error_code => error_string). Initilize to prevent -w
# warnings.
    ${$msg_pkg . '::ERRORS'}    ||= {};
    ${$pkg     . '::ERRORS'}    ||= {};
    my $cls_err  = ${$msg_pkg . '::ERRORS'};
    my $pkg_err  = ${$pkg     . '::ERRORS'} || $pkg;
    my %messages = %$cls_err;
    foreach (keys %$pkg_err) { $messages{$_} = $pkg_err->{$_}; }

# Return current error if not called with arguments.
    if ($is_hash) {
        $self->{_error} ||= [];
        if (@_ == 0) {
            my @err = @{$self->{_error}} ? @{$self->{_error}} : (${$msg_pkg . "::error"});
            return wantarray ? @err : defined($err[0]) ? $err[0] : undef;
        }
    }
    elsif (@_ == 0) {
        return ${$msg_pkg . '::errcode'};
    }

# Set a subroutine that will clear out the error class vars, and self vars under mod_perl.
    $MOD_PERL and $Apache::ServerStarting != 1 and Apache->request->register_cleanup( sub { $self->_cleanup_obj ($msg_pkg, $is_hash); } );
    $SPEEDY   and CGI::SpeedyCGI->register_cleanup ( sub { $self->_cleanup_obj ($msg_pkg, $is_hash); } );

# store the error code.
    ${$msg_pkg . '::errcode'}   ||= '';
    ${$msg_pkg . '::errcode'}   = $msg;
    ${$msg_pkg . '::errargs'}   ||= '';
    if ($is_hash) {
        $self->{_errcode} = $msg;
        $self->{_errargs} = @args ? [@args] : [];
    }

# format the error message.
    if (keys %messages) {
        if (exists $messages{$msg}) {
            $msg = $messages{$msg};
        }
        $msg = $msg->() if ref $msg eq 'CODE';
        $msg = @args ? sprintf ($msg, map { defined $_ ? $_ : '[undefined]' } @args) : $msg;
        $msg =~ s/(?:\r?\n)|\r/\n/g unless ($^O eq 'MSWin32');
        $msg =~ s/\n(?=[^ ])/\n\t/g;
    }

# set the formatted error to $msg_pkg::error.
    push @{$self->{_error}}, $msg if ($is_hash);

# If we have a fatal error, then we either send it to error_handler if
# the user has a custom handler, or print our message and die.
# initlize error to silence -w warnings.
    ${$msg_pkg . '::error'} ||= '';
    if (uc $level eq 'FATAL') {
        ${$msg_pkg . '::error'} = ref ${$msg_pkg . '::error'} ? _format_err($err_pkg, \$msg) : _format_err($err_pkg, $msg);

        die (_format_err($err_pkg, $msg)) if in_eval();
        if (exists($SIG{__DIE__}) and $SIG{__DIE__}) {
            die _format_err($err_pkg, $msg);
        }
        else {
            print STDERR _format_err($err_pkg, $msg);
            die "\n";
        }
    }
# Otherwise we set the error message, and print it if we are in debug mode.
    elsif (uc $level eq 'WARN') {
        ${$msg_pkg . '::error'} = ref ${$msg_pkg . '::error'} ? \$msg :  $msg;
        my $warning = _format_err($err_pkg, $msg);
        $debug and (
            $SIG{__WARN__}
                ? CORE::warn $warning
                : print STDERR $warning
        );
        $debug > 1 and (
            $SIG{__WARN__}
                ? CORE::warn stack_trace('GT::Base',1)
                : print STDERR stack_trace('GT::Base',1)
        );
    }
    return;
}
END_OF_FUNC

$COMPILE{_cleanup_obj} = __LINE__ . <<'END_OF_FUNC';
sub _cleanup_obj {
# -------------------------------------------------------
# Cleans up the self object under a persitant env.
#
    my ($self, $msg_pkg, $is_hash) = @_;

    ${$msg_pkg . '::errcode'}           = undef; 
    ${$msg_pkg . '::error'}             = undef;
    ${$msg_pkg . '::errargs'}           = undef;
    if ($is_hash) {
        defined $self and $self->{_errcode} = undef;
        defined $self and $self->{_error}   = undef;
        defined $self and $self->{_errargs} = undef;
    }
    return 1;
}
END_OF_FUNC

$COMPILE{errcode} = __LINE__ . <<'END_OF_FUNC';
sub errcode { 
# -------------------------------------------------------
# Returns the last error code generated.
#
    my $self    = shift;
    my $is_hash = index ($self, 'HASH') != -1;
    my $pkg     = ref $self || $self;
    my $msg_pkg = ${$pkg . "::ERROR_MESSAGE"} ? ${$pkg . "::ERROR_MESSAGE"} : $pkg; 
    if (ref $self and $is_hash) {
        return $self->{_errcode};
    }
    else {
        return ${$msg_pkg . '::errcode'};
    }
}
END_OF_FUNC

$COMPILE{errargs} = __LINE__ . <<'END_OF_FUNC';
sub errargs {
# -------------------------------------------------------
# Returns the arguments from the last error. In list 
# context returns an array, in scalar context returns
# an array reference.
#
    my $self    = shift;
    my $is_hash = index ($self, 'HASH') != -1;
    my $pkg     = ref $self || $self;
    my $msg_pkg = ${$pkg . "::ERROR_MESSAGE"} ? ${$pkg . "::ERROR_MESSAGE"} : $pkg;
    my $ret = [];
    if (ref $self and $is_hash) {
        $self->{_errargs} ||= [];
        $ret = $self->{_errargs};
    }
    else {
        ${$msg_pkg . '::errcode'} ||= [];
        $ret = ${$msg_pkg . '::errargs'};
    }
    return wantarray ? @{$ret} : $ret;
}
END_OF_FUNC


$COMPILE{clear_errors} = __LINE__ . <<'END_OF_SUB';
sub clear_errors {
# -------------------------------------------------------
# Clears the error stack
#
    my $self = shift;
    $self->{_error}   = [];
    $self->{_errargs} = [];
    $self->{_errcode} = undef;
    return 1;
}
END_OF_SUB

$COMPILE{set_basic_errors} = __LINE__ . <<'END_OF_FUNC';
sub set_basic_errors {
# -------------------------------------------------------
# Sets basic error messages commonly used.
#
    my $self  = shift;
    my $class = ref $self || $self;
    if (${$class . '::ERROR_MESSAGE'}) {
        $class = ${$class . '::ERROR_MESSAGE'};
    }
    ${$class . '::ERRORS'} ||= {};
    my $err = ${$class . '::ERRORS'};
    for my $key (keys %ERRORS) {
        $err->{$key}   = $ERRORS{$key} unless exists $err->{$key};
    }
}
END_OF_FUNC

$COMPILE{in_eval} = __LINE__ . <<'END_OF_FUNC';
sub in_eval {
# -------------------------------------------------------
# Current perl has a variable for it, old perl, we need to look
# through the stack trace. Ugh.
#       
    my $ineval;
    if ($] >= 5.005 and !($MOD_PERL or $SPEEDY)) { $ineval = defined ($^S) ? $^S : (stack_trace('GT::Base',1) =~ /\(eval\)/); }
    elsif ($MOD_PERL or $SPEEDY) {
        my $stack = stack_trace('GT::Base', 1);
        my $cnt   = $stack =~ s|\(eval\)(?!\s+called at\s+/dev/null)||g;
        $ineval   = ($cnt > 1);
    }
    else {
        my $stack = stack_trace('GT::Base', 1);
        $ineval   = $stack =~ /\(eval\)/;
    }
    return $ineval;
}   
END_OF_FUNC

$COMPILE{class_set} = __LINE__ . <<'END_OF_FUNC';
sub class_set {
# -------------------------------------------------------
# Set the class init attributes.
#
    my $pkg     = shift;
    my $attribs = $ATTRIB_CACHE->{$pkg} || _get_attribs ($pkg);

    if (ref $attribs ne 'HASH') { return; }

# Figure out what we were passed in.
    my $out  = GT::Base->common_param(@_) or return;

# Set the attribs.
    foreach (keys %$out) {
        exists $attribs->{$_} and ($attribs->{$_} = $out->{$_});
    }   
}
END_OF_FUNC

$COMPILE{attrib} = __LINE__ . <<'END_OF_FUNC';
sub attrib {
# -------------------------------------------------------
# Returns a list of attributes.
#
    my $class    = ref $_[0] || $_[0];
    my $attribs  = $ATTRIB_CACHE->{$class} || _get_attribs ($class);
    return wantarray ? %$attribs : $attribs;
}
END_OF_FUNC

$COMPILE{stack_trace} = __LINE__ . <<'END_OF_FUNC';
sub stack_trace {
# -------------------------------------------------------
# If called with arguments, returns stack trace, otherwise
# prints to stdout/stderr depending on whether in cgi or not.
#
    my $pkg = shift || 'Unknown';
    my $raw = shift || 0;
    my $rollback = shift || 3;
    my ($ls, $spc, $fh);
    if ($raw) {
        if (defined $ENV{REQUEST_METHOD}) {
            $ls  = "\n";
            $spc = ' &nbsp; ';
        }
        else {
            $ls  = "\n";
            $spc = ' ';
        }
    }
    elsif (defined $ENV{REQUEST_METHOD}) {
        print STDOUT "Content-type: text/html\n\n";
        $ls = '<br>';
        $spc = '&nbsp;';
        $fh = \*STDOUT;
    }
    else {
        $ls = "\n";
        $spc = ' ';
        $fh = \*STDERR;
    }
    my $out = $raw ? '' : "${ls}STACK TRACE$ls======================================$ls";
    {
        package DB;
        my $i = $rollback;
        local $@;
        while (my ($file, $line, $sub, $args) = (caller($i++))[1,2,3,4]) {
            my @args;
            for (@DB::args) {
                eval { my $a = $_ };     # workaround for a reference that doesn't think it's a reference
                my $print = $@ ? \$_ : $_;
                push @args, defined $print ? $print : '[undef]';
            }
            if (@args) {
                my $args = join ", ", @args;
                $args =~ s/\n\s*\n/\n/g;
                $args =~ s/\n/\n$spc$spc$spc$spc/g;
                $out .= qq!$pkg ($$): $sub called at $file line $line with arguments $ls$spc$spc ($args).$ls!;
            }
            else {
                $out .= qq!$pkg ($$): $sub called at $file line $line with no arguments.$ls!;
            }
        }
    }
    $raw ? return $out : print $fh $out;
}
END_OF_FUNC

$COMPILE{_format_err} = __LINE__ . <<'END_OF_FUNC';
sub _format_err {
# -------------------------------------------------------
# Formats an error message for output.
#
    my ($pkg, $msg) = @_;
    my ($file, $line) = get_file_line ($pkg);
    return "$pkg ($$): $msg at $file line $line.\n";
}
END_OF_FUNC

$COMPILE{get_file_line} = __LINE__ . <<'END_OF_FUNC';
sub get_file_line {
# -------------------------------------------------------
# Find out what line error was generated in.
#
    shift if $_[0] and UNIVERSAL::isa($_[0], __PACKAGE__);
    my $pkg = shift || scalar caller;
    my ($pack, $file, $line, $i, @rest, $last_pkg);
    while (($pack, $file, $line, @rest) = caller ($i++)) {
        if ($pack eq $pkg) {
            $last_pkg = $i;
        }
    }
    ($pack, $file, $line) = caller ($last_pkg++);

    return ($file, $line);
}
END_OF_FUNC

$COMPILE{_generate_fatal} = __LINE__ . <<'END_OF_FUNC';
sub _generate_fatal {
# -------------------------------------------------------------------
# Generates a fatal error caused by misuse of AUTOLOAD.
#
    my ($self, $attrib, $param) = @_;
    my $is_hash = index ($self, 'HASH') != -1;
    my $pkg     = ref $self || $self;

    my @poss;
    my @class = @{$pkg . '::ISA'} || ();
    unshift @class, $pkg;
    foreach (@class) {
        my %stach = %{$_ . '::'};
        foreach my $routine (keys %stach) {
            next if $attrib eq $routine;
            next unless $self;
            next unless (UNIVERSAL::can($self, $routine));
            if (GT::Base->_sndex ($attrib) eq _sndex ($routine)) {
                push @poss, $routine;
            }
        }
    }
# Generate an error message, with possible alternatives and die.
    my $err_pkg = $is_hash ? (defined $self->{_err_pkg} ? $self->{_err_pkg} : $pkg) : $pkg;
    my ($call_pkg, $file, $line) = caller(1);
    my $msg = "    Perhaps you ment to call " . join (", or " => @poss) . ".\n" if (@poss);
    $msg = defined $msg ? $msg : '';
    die "$err_pkg ($$): Unknown method '$attrib' called at $file line $line.\n$msg";
}
END_OF_FUNC

$COMPILE{_sndex} = __LINE__ . <<'END_OF_FUNC';
sub _sndex {
# -------------------------------------------------------
# Do a soundex lookup to suggest alternate methods the person
# might have wanted.
#
    my $self = shift;
    local $_ = shift;
    my $search_sound = uc;
    $search_sound =~ tr/A-Z//cd; 
    if ($search_sound eq '') { $search_sound = 0 } 
    else {
        my $f = substr ($search_sound, 0, 1);
        $search_sound =~ tr/AEHIOUWYBFPVCGJKQSXZDTLMNR/00000000111122222222334556/;
        my $fc = substr ($search_sound, 0, 1);
        $search_sound =~ s/^$fc+//;
        $search_sound =~ tr///cs;
        $search_sound =~ tr/0//d;
        $search_sound = $f . $search_sound . '000';
        $search_sound = substr ($search_sound, 0, 4);
    }
    return $search_sound;
}
END_OF_FUNC

1;



=head1 NAME

GT::Base - Common base module to be inherited by all classes.

=head1 SYNOPSIS

    use GT::Base;
    use vars qw/@ISA $ATTRIBS $ERRORS/
    @ISA     = qw/GT::Base/;
    $ATTRIBS = {
        accessor  => default,
        accessor2 => default,
    };
    $ERRORS = {
        BADARGS => "Invalid argument: %s passed to subroutine: %s",
    };

=head1 DESCRIPTION

GT::Base is a base class that is used to provide common error handling,
debugging, creators and accessor methods.

To use GT::Base, simply make your module inherit from GT::Base. That
will provide the following functionality:

=head2 Debugging

Two new methods are available for debugging:

    $self->debug($msg, [DEBUG_LEVEL]);

This will send a $msg to STDERR if the current debug level is greater
then the debug level passed in (defaults to 1). 

    $self->debug_level(DEBUG_LEVEL);
    Class->debug_level(DEBUG_LEVEL);

You can call debug_level() to set or get the debug level. It can
be set per object by calling it as an object method, or class wide
which will initilize all new objects with that debug level (only if
using the built in creator).

The debugging uses a package variable:

    $Class::DEBUG = 0;

and assumes it exists.

=head2 Error Handling

Your object can now generate errors using the method:

    $self->error(CODE, LEVEL, [args]);

CODE should be a key to a hash of error codes to user readable
error messages. This hash should be stored in $ERRORS which is
defined in your pacakge, or the package named in $ERROR_MESSAGE.

LEVEL should be either 'FATAL' or 'WARN'. If not specified it defaults
to FATAL. If it's a fatal error, the program will print the message
to STDERR and die.

args can be used to format the error message. For instance, you can 
defined commonly used errors like:

    CANTOPEN => "Unable to open file: %s. Reason: %s"

in your $ERRORS hash. Then you can call error like:

    open FILE, "somefile.txt"
        or return $self->error(CANTOPEN => FATAL => "somefile.txt", "$!");

The error handler will format your message using sprintf(), so all 
regular printf formatting strings are allowed.

Since errors are kept within an array, too many errors can pose a
memory problem. To clear the error stack simply call:

    $self->clear_errors();

=head2 Error Trapping

You can specify at run time to trap errors. 

    $self->catch_errors(\&code_ref);

which sets a $SIG{__DIE__} handler. Any fatal errors that occur, will
run your function. The function will not be run if the fatal was thrown
inside of an eval though.

=head2 Stack Trace

You can print out a stack trace at any time by using:

    $self->stack_trace(1);
    Class->stack_trace(1);

If you pass in 1, the stack trace will be returned as a string, otherwise
it will be printed to STDOUT.

=head2 Accessor Methods

Using GT::Base automatically provides accessor methods for all your 
attributes. By specifying:

    $ATTRIBS = {
        attrib => 'default',
        ...
    };

in your package, you can now call:

    my $val = $obj->attrib();
    $obj->attrib($set_val);

to set and retrieve the attributes for that value.

Note: This uses AUTOLOAD, so if you implement AUTOLOAD in your package, 
you must have it fall back to GT::Base::AUTOLOAD if it fails. This
can be done with:

    AUTOLOAD {
        ...
        goto &GT::Base::AUTOLOAD;
    }

which will pass all arguments as well.

=head2 Parameter Parsing

GT::Base also provides a method to parse parameters. In your methods you
can do:

    my $self = shift;
    my $parm = $self->common_param(@_);

This will convert any of a hash reference, hash or CGI object into a hash
reference.

=head1 COPYRIGHT

Copyright (c) 2002 Gossamer Threads Inc.  All Rights Reserved.
http://www.gossamer-threads.com/

=head1 VERSION

Revision: $Id: Base.pm,v 1.108 2002/05/31 19:15:16 jagerman Exp $

=cut

}

BEGIN { $INC{"GT/Dumper.pm"} = "GT/Dumper.pm" }
{
# ==================================================================
# Gossamer Threads Module Library - http://gossamer-threads.com/
#
#   GT::Dumper
#   Author  : Scott Beck 
#   $Id: Dumper.pm,v 1.30 2002/04/05 02:45:13 jagerman Exp $
# 
# Copyright (c) 2001 Gossamer Threads Inc.  All Rights Reserved.
# ==================================================================
#
# Description:
#   Implements a simple data dumper, useful for converting complex
#   data structures to strings.
#

package GT::Dumper;
# ===============================================================
    use strict;
    use vars qw /$DEBUG $ATTRIBS $VERSION @EXPORT @ISA $TAB $EOL/;
    use GT::Base;
    use Exporter;

    $TAB        = '    ';
    $EOL        = "\n";
    $VERSION    = sprintf "%d.%03d", q$Revision: 1.30 $ =~ /(\d+)\.(\d+)/;
    $ATTRIBS    = {
                        var       => undef,
                        data      => undef,
                        sort      => undef,
                        order     => undef,
                        compress  => undef,
                        structure => undef
                  };
    @EXPORT     = qw(Dumper);
    @ISA        = qw(Exporter GT::Base);

sub Dumper {
# -----------------------------------------------------------
#   Dumper acts similar to Dumper in Data::Dumper when called as a 
#   class method. If called as a instance method it assumes you
#   have set the options for the dump and does not change them.
#   It only takes a single argument - the variable to dump.
#
    my $self;
    if (@_ == 1) {
        if (ref $_[0] eq 'GT::Dumper') {
            $self = shift;
        }
        else {
            $self = GT::Dumper->new (
                            var  => '$VAR',
                            data => shift
                        );
        }
    }
    elsif (@_ == 2) {
        if ($_[0] eq 'GT::Dumper') {
            $self = GT::Dumper->new (
                            var  => '$VAR',
                            data => $_[1]
                        );
        }
        else {
            $self = shift;
            $self->{data} = shift;
            $self->{var} ||= '$VAR';
        }
    }
    else {
        die "Bad args to Dumper";
    }
    return $self->dump;
}

sub dump {
# -----------------------------------------------------------
# my $dump = $class->dump (%opts);
# --------------------------------
#   Returns the data structure specified in %opts flatened.
#   %opts is optional if you have created an object with the
#   options.
#
    my $this  = shift;

# See if options were passed in
    my $self;
    if (!ref $this) {
        $self = $this->new (@_);
    }
    elsif (@_ > 0) {
        $self = $this;
        $self->init (@_);
    }
    else {
        $self = $this;
    }
    
    my $level = 0;
    my $ret;
    $ret .= "$self->{var} = " unless defined $self->{var} and $self->{var} eq '';
    $self->_dump_value ($level + 1, $self->{data}, \$ret);
    $ret .= ';'.$EOL unless $self->{structure};

    return $ret ? $ret : 1;
}

sub dump_structure {
    my ($self, $data) = @_;
    return $self->dump(var => '', structure => 1, data => $data);
}

sub _dump_value {
# -----------------------------------------------------------
# Internal method to decide what to dump.
#
    my ($self, $level, $val, $ret, $n) = @_;
    my $was;
    if    (ref $val and $val =~ /=/) {                  $self->_dump_obj    ($level + 1, $val, $ret) }
    elsif (ref $val eq 'HASH') {                        $self->_dump_hash   ($level + 1, $val, $ret) }
    elsif (ref $val eq 'ARRAY') {                       $self->_dump_array  ($level + 1, $val, $ret) }
    elsif (ref $val eq 'SCALAR' or ref $val eq 'REF'
                            or ref $val eq 'LVALUE') {  $self->_dump_scalar ($level + 1, $val, $ret) }
    else  {
        $val = _escape ($val);
        $$ret .= $val;
    }
    return 1;
}

sub _dump_scalar {
# -----------------------------------------------------------
# Dump a scalar reference.
#
    my ($self, $level, $val, $ret, $n) = @_;
    my $v = $$val;
    $$ret .= '\\';
    $self->_dump_value($level + 1, $v, $ret, 1);
    return 1;
}

sub _dump_hash {
# -----------------------------------------------------------
# Internal method to for through a hash and dump it.
#
    my ($self, $level, $hash_ref, $ret) = @_;
    $$ret .= '{';
    my $lines;
    if ($self->{sort}) {
        for (sort { ref ($self->{order}) eq 'CODE' ? $self->{order}->($a, $b, $hash_ref->{$a}, $hash_ref->{$b}) : $a cmp $b } keys %{$hash_ref}) {
            $$ret .= "," if $lines++;
            $$ret .= $EOL.($TAB x ($level / 2)) unless $self->{compress};
            my $key = _escape($_);
            $$ret .= $self->{compress} ? "$key," : "$key => ";
            $self->_dump_value ($level + 1, $hash_ref->{$_}, $ret, 1);
        }
    }
    else {
        for (keys %{$hash_ref}) {
            $$ret .= "," if $lines++;
            $$ret .= $EOL.($TAB x ($level / 2)) unless $self->{compress};
            my $key = _escape($_);
            $$ret .= $self->{compress} ? "$key," : "$key => ";
            $self->_dump_value ($level + 1, $hash_ref->{$_}, $ret, 1);
        }
    }
    $$ret .= $EOL if $lines and not $self->{compress};
    $$ret .= ($lines and not $self->{compress}) ? (($TAB x (($level - 1) / 2)) . "}") : "}";
    return 1;
}

sub _dump_array {
# -----------------------------------------------------------
# Internal method to for through an array and dump it.
#
    my ($self, $level, $array_ref, $ret) = @_;
    $$ret .= "[";
    my $lines;
    for (@{$array_ref}) {
        $$ret .= "," if $lines++;
        $$ret .= $EOL.($TAB x ($level / 2)) unless $self->{compress};
        $self->_dump_value ($level + 1, $_, $ret, 1);
    }
    $$ret .= ($lines and not $self->{compress}) ? $EOL.(($TAB x (($level - 1) / 2)) . "]") : "]";
    return 1;
}

sub _dump_obj {
# -----------------------------------------------------------
# Internal method to dump an object.
#
    my ($self, $level, $obj, $ret) = @_;
    my $class = ref $obj;
    $$ret .= "bless(";
    $$ret .= $EOL.($TAB x ($level / 2)) unless $self->{compress};
    if ($obj =~ /ARRAY\(/)                      { $self->_dump_array ($level + 2, \@{$obj}, $ret) }
    elsif ($obj =~ /HASH\(/)                    { $self->_dump_hash  ($level + 2, \%{$obj}, $ret) }
    elsif ($obj =~ /SCALAR\(/ or $obj =~ /REF\(/ or $obj =~ /LVALUE\(/)
                                                { $self->_dump_value ($level + 2, $$obj, $ret)    }
    $$ret .= ",";
    $$ret .= $EOL.($TAB x ($level / 2)) unless $self->{compress};
    $$ret .= _escape($class);
    $$ret .= $EOL.($TAB x (($level - 1) / 2)) unless $self->{compress};
    $$ret .= ")";
    return 1;
}


sub _escape {
# -----------------------------------------------------------
# Internal method to escape a dumped value.
    my ($val) = @_;
    defined ($val) or return 'undef';
    $val =~ s/('|\\(?=['\\]|$))/\\$1/g;
    return "'$val'";
}

1;



=head1 NAME

GT::Dumper - Implements a simple data dumper.

=head1 SYNOPSIS

    use GT::Dumper;
    print Dumper($complex_var);
    print GT::Dumper->dump ( var => '$MYVAR', data => $complex_var);

=head1 DESCRIPTION

GT::Dumper by default exports a method Dumper() which will
behave similar to Data::Dumper's Dumper(). It differs in that
it will only take a single argument, and the variable dumped
will be $VAR instead of $VAR1. Also, to provide easier control
to change the variable name that gets dumped, you can use:

    GT::Dumper->dump ( var => string, data => yourdata );

and the dump will start with string = instead of $VAR = .

=head1 EXAMPLE

    use GT::Dumper;
    my %foo;
    my @bar = (1, 2, 3);
    $foo{alpha} = \@bar;
    $foo{beta} = 'a string';
    print Dumper(\%foo);

This will print:

    $VAR = {
        'beta' => 'a string',
        'alpha' => [
            '1',
            '2',
            '3',
        ],
    };

You may specify a blank variable name ('') and the variable
and = sign will be omitted from the output.

The "compress" option can be used to eliminate all whitespace.

=head1 COPYRIGHT

Copyright (c) 2001 Gossamer Threads Inc.  All Rights Reserved.
http://www.gossamer-threads.com/

=head1 VERSION

Revision: $Id: Dumper.pm,v 1.30 2002/04/05 02:45:13 jagerman Exp $

=cut

}

BEGIN { $INC{"bases.pm"} = "bases.pm" }
{
# ==================================================================
# Gossamer Threads Module Library - http://gossamer-threads.com/
#
#   bases
#   Author: Scott Beck
#   $Id: bases.pm,v 1.8 2002/04/08 18:00:23 jagerman Exp $
#
# Copyright (c) 2001 Gossamer Threads Inc.  All Rights Reserved.
# ==================================================================

package bases;

use strict 'subs', 'vars';

sub import {
    my $class = shift;
    my $pkg = caller;
    my $hsh = {@_};
    my @indices = map { $_[$_ * 2] } 0 .. $#_ * 0.5;
    foreach my $base (@indices) {
        next if $pkg->isa($base);
        push @{"$pkg\::ISA"}, $base;
        my $args = '';
        if (my $ref = ref $hsh->{$base}) {
            require GT::Dumper;
            if ($ref eq 'ARRAY') {
                $args = '(@{' . GT::Dumper->dump_structure($hsh->{$base}) . '})';
            }
            else {
                $args = '(' . GT::Dumper->dump_structure($hsh->{$base}) . ')';
            }
        }
        elsif (defined $hsh->{$base}) {
            $args = $hsh->{$base} eq '' ? '()' : "qw($hsh->{$base})";
        }
        my $dcl = qq|
            package $pkg;
            use $base $args;
        |;
        eval $dcl;
        die "$@: $dcl" if $@ && $@ !~ /^Can't locate .*? at \(eval /;
        unless (defined %{"$base\::"}) {
            require Carp;
            Carp::croak(
qq|Base class package "$base" is empty.
String:
$dcl
\t(Perhaps you need to 'use' the module which defines that package first.)|
            );
        }
    }
}

1;



=head1 NAME

base - Establish IS-A relationship with base class at compile time.

=head1 SYNOPSIS

    package Baz;
    use bases
        Foo  => ':all',
        Bar  => ''
        Bat  => undef;

=head1 DESCRIPTION

Roughly similar in effect to

    package Baz;
    use Foo qw(:all);
    use Bar();
    use Bat;
    BEGIN { @ISA = qw(Foo Bar Bat) }

This is very similar to C<base> pragma except %FIELDS is not
supported and you are able to pass parameters to import on the
module that is used in this way.

If the value specified is undef, the module being used import method
will be called if it exists. If the value is an empty string, import
will not be called.

When strict 'vars' is in scope I<bases> also let you assign to @ISA
without having to declare @ISA with the 'vars' pragma first.

If any of the base classes are not loaded yet, I<bases> silently
C<use>s them.  Whether to C<use> a base class package is
determined by the absence of a global $VERSION in the base package.
If $VERSION is not detected even after loading it, <base> will
define $VERSION in the base package, setting it to the string
C<-1, set by bases.pm>.

=head1 COPYRIGHT

Copyright (c) 2000 Gossamer Threads Inc.  All Rights Reserved.
http://www.gossamer-threads.com/

=head1 VERSION

Revision: $Id: bases.pm,v 1.8 2002/04/08 18:00:23 jagerman Exp $

=cut


}

BEGIN { $INC{"constants.pm"} = "constants.pm" }
{
# ==================================================================
# Gossamer Threads Module Library - http://gossamer-threads.com/
#
#   constants
#   Author: Jason Rhinelander
#   $Id: constants.pm,v 1.8 2002/04/07 03:35:35 jagerman Exp $
#
# Copyright (c) 2001 Gossamer Threads Inc.  All Rights Reserved.
# ==================================================================
#
# Description:
#   Lightweight version of the standard constant.pm that allows you
#   to declare multiple scalar constants in a single compile-time
#   command. Like constant.pm, these scalar constants are optimized
#   during Perl's compilation stage.
#   Unlike constant.pm, this does not allow you to declare list
#   constants.

package constants;


use strict;
use Carp;
use vars qw($VERSION);

$VERSION = '1.00';

#=======================================================================

# Some of this stuff didn't work in version 5.003, alas.
require 5.003_96;

#=======================================================================
# import() - import symbols into user's namespace
#
# What we actually do is define a function in the caller's namespace
# which returns the value. The function we create will normally
# be inlined as a constant, thereby avoiding further sub calling 
# overhead.
#=======================================================================
sub import {
    my $class = shift;
    @_ or return; # Ignore 'use constant;'
    my %constants = @_;
    my $pkg = caller;
    {
        no strict 'refs';
        for my $name (keys %constants) {
            croak qq{Can't define "$name" as constant} .
                qq{ (name contains invalid characters or is empty)}
                unless $name =~ /^[^\W_0-9]\w*$/;
            my $scalar = $constants{$name};
            *{"${pkg}::$name"} = sub () { $scalar };
        }
    }

}

1;



=head1 NAME

constants - Perl pragma to declare multiple scalar constants at once

=head1 SYNOPSIS

    use constants BUFFER_SIZE   => 4096,
                  ONE_YEAR      => 365.2425 * 24 * 60 * 60,
                  PI            => 4 * atan2 1, 1,
                  DEBUGGING     => 0,
                  ORACLE        => 'oracle@cs.indiana.edu',
                  USERNAME      => scalar getpwuid($<);

    sub deg2rad { PI * $_[0] / 180 }

    print "This line does nothing" unless DEBUGGING;

    # references can be declared constants
    use constants CHASH         => { foo => 42 },
                  CARRAY        => [ 1,2,3,4 ],
                  CPSEUDOHASH   => [ { foo => 1}, 42 ],
                  CCODE         => sub { "bite $_[0]\n" };

    print CHASH->{foo};
    print CARRAY->[$i];
    print CPSEUDOHASH->{foo};
    print CCODE->("me");
    print CHASH->[10];                          # compile-time error

=head1 DESCRIPTION

This will declare a symbol to be a constant with the given scalar
value. This module mimics constant.pm in every way, except that it
allows multiple scalar constants to be created simultaneously. To
create constant list values you should use constant.

See L<constant> for details about how constants work.

=head1 NOTES

The value or values are evaluated in a list context, so you should
override this if needed with C<scalar> as shown above.

=head1 TECHNICAL NOTE

In the current implementation, scalar constants are actually
inlinable subroutines. As of version 5.004 of Perl, the appropriate
scalar constant is inserted directly in place of some subroutine
calls, thereby saving the overhead of a subroutine call. See
L<perlsub/"Constant Functions"> for details about how and when this
happens.

=head1 BUGS

In the current version of Perl, list constants are not inlined
and some symbols may be redefined without generating a warning.

It is not possible to have a subroutine or keyword with the same
name as a constant. This is probably a Good Thing.

Unlike constants in some languages, these cannot be overridden
on the command line or via environment variables.

You can get into trouble if you use constants in a context which
automatically quotes barewords (as is true for any subroutine call).
For example, you can't say C<$hash{CONSTANT}> because C<CONSTANT> will
be interpreted as a string.  Use C<$hash{CONSTANT()}> or
C<$hash{+CONSTANT}> to prevent the bareword quoting mechanism from
kicking in.  Similarly, since the C<=E<gt>> operator quotes a bareword
immediately to its left you have to say C<CONSTANT() =E<gt> 'value'>
instead of C<CONSTANT =E<gt> 'value'>.

=head1 AUTHOR

constant.pm: Tom Phoenix, E<lt>F<rootbeer@teleport.com>E<gt>, with help from
many other folks.

constants.pm: Jason Rhinelander, Gossamer Threads Inc.

=cut

}

BEGIN { $INC{"GT/TempFile.pm"} = "GT/TempFile.pm" }
{
# ==================================================================
# Gossamer Threads Module Library - http://gossamer-threads.com/
#
#   GT::TempFile
#   Author  : Scott Beck
#   $Id: TempFile.pm,v 1.33 2002/04/07 03:35:35 jagerman Exp $
#
# Copyright (c) 2000 Gossamer Threads Inc.  All Rights Reserved.
# ==================================================================
#
# Description:
#   Implements a tempfile.
#

package GT::TempFile;
# ===================================================================

# Pragmas
    use strict;
    use vars   qw/@ISA $ERRORS $VERSION $DEBUG $TMP_DIR @POSS_TMP_DIRS $PREFIX $FH $ATTRIBS %OBJECTS/;
    use bases 'GT::Base' => ':all';

    $VERSION = sprintf "%d.%03d", q$Revision: 1.33 $ =~ /(\d+)\.(\d+)/;

sub find_tmpdir {
# -------------------------------------------------------------------
# Sets the tmpdir.
#
    @POSS_TMP_DIRS = ('/usr/tmp', '/var/tmp', 'c:/temp', '/tmp', '/temp', '/sys$scratch', '/WWW_ROOT', 'c:/windows/temp', 'c:/winnt/temp');
    unshift(@POSS_TMP_DIRS,(eval { (getpwuid($<))[7] }) . '/tmp') unless ($^O =~ /Win|Mac/);
    unshift(@POSS_TMP_DIRS, $ENV{TMPDIR}) if (exists $ENV{TMPDIR});
    unshift(@POSS_TMP_DIRS, $ENV{TEMP})   if (exists $ENV{TEMP});
    unshift(@POSS_TMP_DIRS, $ENV{TMP})    if (exists $ENV{TMP});
    unshift(@POSS_TMP_DIRS, $ENV{windir} . '/temp') if (exists $ENV{windir});
    unshift(@POSS_TMP_DIRS, $ENV{GT_TMPDIR}) if (exists $ENV{GT_TMPDIR});

    foreach my $dir (@POSS_TMP_DIRS) {
        next unless ($dir);
        if (-d $dir and -w _ and -x _) {
            $TMP_DIR = $dir;
            last;
        }
    }
    $TMP_DIR ||= '.';
    return $TMP_DIR;
}

sub init {
# -------------------------------------------------------------------
# Create a new tempfile.
#
    $TMP_DIR ||= find_tmpdir();
    my $self = bless {}, 'GT::TempFile::Tmp';
    $self->reset;

# Backwards compatibility
    if ( @_ == 2 and not ref( $_[1] ) ) {
        ( $self->{tmp_dir} ) = $_[1];
    }
    elsif ( @_ > 1 ) {
        $self->set( @_[1 .. $#_] );
    }

    my $dir      = $self->{tmp_dir} || $TMP_DIR;
    my $count    = substr(time, -4) . int(rand(10000));
    my $filename = '';

# Directory for locking
    my $lock_dir = "$dir/$self->{prefix}GT_TempFile_lock";

# W need to create the directory
    my $safety = 0;
    until ( mkdir( $lock_dir, 0777 ) ) {

# If we wait 10 seconds and still no lock we assume the lockfile is stale
        if ( $safety++ > 10 ) {
            rmdir $lock_dir or $self->fatal( 'RMDIR', $lock_dir, "$!" );
        }
        sleep 1;
    }

# Now lets get our temp file
    for (1 .. 20) {
        $filename = "$dir/$self->{prefix}GTTemp$count";
        last if (! -f $filename);
        $count++;
    }

# If the open fails we need to remove the lockdir
    if ( !open( FH, ">$filename" ) ) {
        rmdir $lock_dir or $self->fatal( 'RMDIR', $lock_dir, "$!" );
        $self->fatal( 'WRITEOPEN', $filename, "$!" );
    }
    close FH;

# All done searching for a temp file, now release the directory lock
    rmdir $lock_dir or $self->fatal( 'RMDIR', $lock_dir, "$!" );
    ($filename =~ /^(.+)$/) and ($filename = $1); # Detaint.

    $self->{filename} = $filename;
    $_[0] = bless \$filename, 'GT::TempFile';
    $OBJECTS{$_[0]} = $self;
    $self->debug("New tmpfile created ($filename).") if ($self->{_debug});
}

sub as_string {
# -------------------------------------------------------------------
# Backwards compatibility
    my ( $self ) = @_;
    return $$self;
}

sub DESTROY {
# -------------------------------------------------------------------
    my $obj = shift;
    my $self = $OBJECTS{$obj};
    $self->debug ("Deleteing $self->{filename}") if ($self->{_debug});

# unlink the file if they wanted it deleted
    if ( $self->{destroy} ) {
        unless ( unlink $self->{filename} ) {
            $self->debug("Unable to remove temp file: $self->{filename} ($!)") if ($self->{_debug});
        }
    }
    delete $OBJECTS{$obj};
}

package GT::TempFile::Tmp;
    use bases 'GT::Base' => '';
    use vars qw/$ATTRIBS $ERRORS $DEBUG/;
    $ATTRIBS = {
        prefix  => '',
        destroy => 1,
        tmp_dir => undef,
    };
    $ERRORS         = { SAFETY => "Safety reached while trying to create lock directory %s, (%s)" };
    $DEBUG          = 0;
1;



=head1 NAME

GT::TempFile - implements a vary simple temp file.

=head1 SYNOPSIS

    my $file = new GT::TempFile;
    open (FILE, "> $$file");
    print FILE "somedata";
    close FILE;

=head1 DESCRIPTION

GT::TempFile implements a very simple temp file system that will remove
itself once the variable goes out of scope.

When you call new, it creates a random file name and looks for a 
tmp directory. What you get back is an object that when dereferenced
is the file name. You can also pass in a temp dir to use:

    my $file = new GT::Tempfile '/path/to/tmpfiles';

Other option you may use are:
    my $file = new GT::TempFile(
        destroy => 1,
        prefix  => '',
        tmp_dir => '/tmp'
    );


When the object is destroyed, it automatically unlinks the temp file 
unless you specify I<destroy> => 0.

I<prefix> will be prepended to the start of all temp files created
and the lock directory that is created. It is used to keep programs
using the tempfile module that do not have the temp files destroyed
from clashing.

I<tmp_dir> is the same as calling new with just one argument, it is
the directory where files will be stored.

TempFile picks a temp directory based on the following:

    1. ENV{GT_TMPDIR}
    2. ~/tmp
    3. ENV{TMPDIR}, ENV{TEMP}, ENV{TMP}
    4. /usr/tmp, /var/tmp, c:/temp, /tmp, /temp, 
       /WWW_ROOT, c:/windows/temp, c:/winnt/temp

=head1 COPYRIGHT

Copyright (c) 2000 Gossamer Threads Inc.  All Rights Reserved.
http://www.gossamer-threads.com/

=head1 VERSION

Revision: $Id: TempFile.pm,v 1.33 2002/04/07 03:35:35 jagerman Exp $

=cut

}

BEGIN { $INC{"GT/Tar.pm"} = "GT/Tar.pm" }
{
# ==================================================================
# Gossamer Threads Module Library - http://gossamer-threads.com/
#
#   GT::Tar
#   Author: Scott Beck
#   $Id: Tar.pm,v 1.46 2002/04/07 03:35:35 jagerman Exp $
#
# Copyright (c) 2002 Gossamer Threads Inc.  All Rights Reserved.
# ==================================================================
#
# Description: A general purpose taring and untaring module.
#

package GT::Tar;
# ==================================================================
# Pragmas
    use vars qw/$DEBUG $ERRORS $FAKE_GETPWUID $HAVE_GZIP $FAKE_GETGRGID $FH/;
    use strict;

# System modules
    use Fcntl;

# Contants
    use constant BLOCK    => 4096;
    use constant FILE     => 0;
    use constant HARDLINK => 1;
    use constant SYMLINK  => 2;
    use constant CHARDEV  => 3;
    use constant BLOCKDEV => 4;
    use constant DIR      => 5;
    use constant FIFO     => 6;
    use constant SOCKET   => 8;
    use constant UNKNOWN  => 9;

# Internal modules
    use GT::Base;

# Globals
    $DEBUG = 0;
    @GT::Tar::ISA = qw{GT::Base};

    $ERRORS = {
        OPEN        => "Could not open %s. Reason: %s",
        READ        => "There was an error reading from %s. Expected to read %s bytes, but only got %s.",
        BINMODE     => "Could not binmode %s. Reason: %s",
        BADARGS     => "Bad arguments passed to %s. Reason: %s",
        CHECKSUM    => "Checksum Error parsing tar file. Most likely this is a corrupt tar.\nHeader: %s\nChecksum: %s\nFile: %s\n",
        NOBODY      => "File '%s' does not have a body!",
        CANTFIND    => "Unable to find a file named: '%s' in tar archive.",
        CHMOD       => "Could not chmod %s, Reason: %s",
        DIRFILE     => "'%s' exists and is a file. Cannot create directory",
        MKDIR       => "Could not mkdir %s, Reason: %s",
        RENAME      => "Unable to rename temp file: '%s' to tar file '%s'. Reason: %s",
        NOGZIP      => "Compress::Zlib module is required to work with .tar.gz files."
    };

    $FAKE_GETPWUID = "unknown" if ($^O eq 'MSWin32');
    $FAKE_GETGRGID = "unknown" if ($^O eq 'MSWin32');
    $HAVE_GZIP     = eval { local $SIG{__DIE__}; require Compress::Zlib; 1; } ? 1 : 0;
    $FH            = 0;

sub new {
# ------------------------------------------------------------------------------
# GT::Tar->new('/path/to/new/tar.tar');
# --------------------------------------
#   Constructor for GT::Tar. Call this method to create a new archive.
#   To do anything with an existing archive call GT::Tar->open.
#
    my $this  = shift;
    my $class = ref $this || $this;
    my $self  = bless {}, $class;

    my $opt = {};
    if (@_ == 1) { $opt->{io} = shift }
    else {
        $opt = $self->common_param(@_);
    }

    $self->{_debug} = exists $opt->{debug} ? $opt->{debug} : $DEBUG;
    $opt->{io} or return $self->error("BADARGS", "FATAL", "new()", "No output archive passed in");

    $opt->{io} =~ /^(.+)$/;
    my $file = $1;

# If it's a gz file, store the name in gz_file, and work off a temp file.
    if ($file =~ /\.t?gz$/) {
        $HAVE_GZIP or return $self->error('NOGZIP', 'WARN');
        require GT::TempFile;
        my $tmpfile = new GT::TempFile;
        $self->{file}     = $$tmpfile;     # Filename of ungzipped tar file.
        $self->{gz_file}  = $file;         # Filename of gzipped file.
        $self->{tmp_file} = $tmpfile;      # Don't unlink it till the object is destroyed.
    }
    else {
        $self->{file} = $file;
    }
    $self->{io} = _gen_fh();
    sysopen $self->{io}, $self->{file}, O_CREAT|O_TRUNC|O_RDWR or return $self->error("OPEN", "FATAL", $self->{file}, "($!)");
    binmode $self->{io} or return $self->error("BINMODE", "FATAL", $self->{file}, "($!)");
    select((select($self->{io}), $| = 1)[0]);

    $self->{parsed}    = 0;
    $self->{new_tar}   = 1;
    return $self;
}

sub open {
# ------------------------------------------------------------------------------
# GT::Tar->open('/path/to/tar.tar');
# -----------------------------------
#   Opens the tar specified by the first argument for reading and calls
#   $obj->parse to parse the contents.
#   Returns a new GT::Tar object.
#
    my $this  = shift;
    my $class = ref $this || $this;
    my $self  = bless {}, $class;

    my $opt = {};
    if (@_ == 1) { $opt->{io} = shift }
    else {
        $opt = $self->common_param(@_);
    }

    $self->{_debug} = exists $opt->{debug} ? $opt->{debug} : $DEBUG;
    $opt->{io} or return $self->error("BADARGS", "FATAL", "open()", "No input archive passed in");

    $opt->{io} =~ /^(.+)$/;
    my $file = $1;

# If it's a gz file, uncompress it to a temp file and work off that.
    if ($file =~ /\.t?gz$/) {
        $HAVE_GZIP or return $self->error('NOGZIP', 'WARN');
        require GT::TempFile;
        my $tmpfile = new GT::TempFile;
        $self->debug("Decompressing gz file to temp file: $$tmpfile") if ($self->{_debug});
        open(FH, "> $$tmpfile") or return $self->error('OPEN', 'WARN', $$tmpfile, "$!");
        binmode FH;
        my $gz = Compress::Zlib::gzopen($file, 'rb') or return $self->error('OPEN', 'WARN', $file, $Compress::Zlib::gzerrno);
        my $line;
        while ($gz->gzreadline($line)) {
            print FH $line;
        }
        close FH;

        $gz->gzclose;
        $self->{file}      = $$tmpfile;     # Filename of open ungzipped tar file.
        $self->{gz_file}   = $file;         # Filename of original gzipped file.
        $self->{tmp_file}  = $tmpfile;      # Don't unlink it till the object is destroyed.
    }
    else {
        $self->{file} = $file;
    }
    $self->{io} = _gen_fh();
    $self->debug("Opening $file") if ($self->{_debug});
    sysopen $self->{io}, $self->{file}, O_RDONLY or return $self->error("OPEN", "WARN", $self->{file}, "($!)");
    binmode $self->{io} or return $self->error("BINMODE", "WARN", "($!)");
    select((select($self->{io}), $| = 1)[0]);

    my $parts = $self->parse;
    defined $parts or return;
    $self->{new_tar} = 0;
    return $self;
}

sub close_tar {
# ------------------------------------------------------------------------------
# Closes the tar file.
#
    my $self = shift;
    $self->{parsed} = 0;
    close $self->{io} if ($self->{io} and fileno($self->{io}));
}
sub DESTROY { my $self = shift; $self->close_tar; }

sub parse {
# ------------------------------------------------------------------------------
# Modified from code in Archive::Tar
# Untar a file, specified by first argument to directories, specified in third
# argument, and set the path to perl, specified in second argument, to all .pl
# and .cgi files
#
    my $self = shift;
    $self->{parts} = [];
    my ($head, $msg);
    my $tar = $self->{io}
        or return $self->error("BADARGS", "FATAL", "parse", "An IO must be defined to parse");

    seek($tar, 0, 0);
    read($tar, $head, 512);

    READLOOP: while (length($head) == 512) {
# End of archive
        last READLOOP if $head eq "\0" x 512;

# Apparently this should really be two blocks of 512 zeroes, but GNU tar
# sometimes gets it wrong. See comment in the source code (tar.c) to GNU cpio.

        my $file = GT::Tar::Parts->format_read($head);

        $self->debug("Looking at $file->{name}") if ($self->{_debug});

        substr($head, 148, 8) = "        ";
        if (unpack("%16C*", $head) != $file->{chksum}) {
            return $self->error('CHECKSUM', 'WARN', $head, $file->{chksum}, $file->{name});
        }

        if ($file->{type} == FILE) {
# Find the start and the end positions in the tar file for the body of the tar
# part
            my $start = tell $tar;
            seek($tar,  $file->{size}, 1);
            $file->body([$tar, $start]);

# Seek off trailing garbage.
            my $block = $file->{size} & 0x01ff ? ($file->{size} & ~0x01ff) + 512 : $file->{size};
            my $to_read = $block - $file->{size};
            if ($to_read) { seek($tar, $to_read, 1) }
        }

# Guard against tarfiles with garbage at the end
        last READLOOP if $file->{name} eq '';

        push(@{$self->{parts}}, $file);

    }
    continue { read($tar, $head, 512) }
    $self->{parsed} = 1;
    seek($tar, 0, 0);
    return wantarray ? @{$self->{parts}} : $self->{parts};
}

sub untar {
# -----------------------------------------------------------------------------
# $obj->untar(\&code);
# ---------------------
#   Untars tar file specified in $obj->open and runs callback for each entry in
#   the tar file. Passed a parts object to that callback.
#
# $obj->untar;
# ------------
#   Same a above but no callback.
#
# GT::Tar->untar('/path/to/tar.tar', \&code);
# --------------------------------------------
#   Untars file specified by the first argument and runs callback in second
#   argument.
#
# GT::Tar->untar('/path/to/tar.tar');
# ------------------------------------
#   Untars tar file specified by first argument.
#
    my $self = (ref $_[0] eq __PACKAGE__) ? shift : shift()->open( shift() );

    my $callback = pop;
    if ($callback) {
        (ref $callback eq 'CODE')
            or return $self->error("BADARGS", "FATAL", "untar", "Callback that was passed in was not a code ref");
    }

    if (!$self->{parsed}) {
        $self->debug("Parsing tar file") if ($self->{_debug});
        $self->parse or return;
    }
    else {
        $self->debug("Already parsed") if ($self->{_debug});
    }

    for (@{$self->{parts}}) {
        if ($callback) {
            $callback->($_);
        }
        else {
            $_->write;
        }
    }
    return $self;
}

sub tar {
# ------------------------------------------------------------------------------
# $obj->tar;
# ----------
#   Creates tar file that was specified in $obj->new with files that were added
#   using $obj->add.
#
# GT::Tar->tar('/path/to/tar.tar', @files);
# ------------------------------------------
#   Creates tar file specified by the first argument with the files specified
#   by the remaining arguments.
#
    my $self;
    if (ref $_[0] eq __PACKAGE__) {
        $self = shift;
    }
    else {
        my $class = shift;
        $self  = $class->new( io => shift );
        $self->add(@_) if (@_);
    }
    $self->write;
}

sub write {
# ------------------------------------------------------------------------------
# $obj->write;
# ------------
#   Creates all the files that are internally in the parts objects.  You add
#   files to parts by calling $obj->add -or- by calling $obj->open on an
#   existing tar file. This is similar to untar.
#
    my $self = shift;
    my ($out, $rename, $filename);

# Working off an existing tar file.
    if (! $self->{new_tar}) {
        if (@_) {
            $filename = shift;

# If we have a new .tar.gz file, we need to write it to a tmp .tar first.
            if ($filename =~ /\.t?gz$/) {
                $HAVE_GZIP or return $self->error('NOGZIP', 'WARN');
                $self->{gz_file} = $filename;
                undef $filename;
            }
        }
        if (! $filename) {
            require GT::TempFile;
            my $tmp = new GT::TempFile;
            $filename = $$tmp;
            $rename   = $self->{file};
        }
        $out = _gen_fh();
        sysopen $out, $filename, O_CREAT|O_TRUNC|O_RDWR or return $self->error("OPEN", "WARN", $filename, "($!)");
        binmode $out or return $self->error('BINMODE', 'FATAL', $filename, "($!)");
    }
# Working off a new tar file.
    else {
        $out = $self->{io};
        seek($out, 0, 0);
    }

# Unbuffer output
    select((select($out), $| = 1)[0]);
    foreach my $entry (@{$self->{parts}}) {
        my $head = $entry->format_write;
        print $out $head;
        my $save = tell $out;
        if ($entry->type == FILE) {
            my $bh;
            my $body = $entry->body or return $self->error('NOBODY', 'WARN', $entry->name);
            my $ref  = ref $body;
            if ($ref eq 'GLOB' and fileno $body) {
                my $fh = $body;
                my $pos  = tell $fh;
                binmode $fh;
                while (read $fh, $_, BLOCK) {
                    print $out $_;
                }
                seek($fh, $pos, 0);
            }
            elsif ($ref eq 'ARRAY') {
                my ($reads, $rem, $data, $pos);
                my ($fh, $start) = @{$body};
                $pos = tell $fh;
                seek($fh, $start, 0);
                binmode $fh;
                $reads = int($entry->{size} / BLOCK);
                $rem   = $entry->{size} % BLOCK;
                for (1 .. $reads) {
                    my $read = read($fh, $data, BLOCK);
                    ($read == BLOCK)
                        or return $self->error("READ", "WARN", join(',' => @{$body}), BLOCK, $read);
                    print $out $data;
                }
                if ($rem) {
                    my $read = read($fh, $data, $rem);
                    ($read == $rem)
                        or return $self->error("READ", "WARN", join(',' => @{$body}), $rem, $read);
                    print $out $data;
                }
                seek($fh, $pos, 0);
            }
            elsif ($ref eq 'SCALAR') {
                CORE::open F, ${$body} or return $self->error('READOPEN', 'WARN', ${$body}, "($!)");
                binmode F;
                while (read F, $_, BLOCK) {
                    print $out $_;
                }
                close F;
            }
            else {
                print $out $body;
            }
            my $size = $entry->{size} & 511;
            if ($size) {
                print $out ("\0" x (512 - $size));
            }
            $entry->body( [ $out, $save ] );
        }
    }
    print $out ("\0" x 1024);

# Copy the temp file over to the original file (can't rename across filesystems).
    if ($rename and !$self->{gz_file}) {
        seek($out, 0, 0);
        $self->{io} = _gen_fh();
        sysopen($self->{io}, $rename, O_CREAT|O_TRUNC|O_RDWR) or return $self->error("OPEN", "WARN", $rename, "($!)");
        binmode $self->{io};
        while (read($out, my $buffer, BLOCK)) {
            print {$self->{io}} $buffer;
        }
        seek($self->{io}, 0, 0);

# Need to set the parts to the new file handle.
        foreach my $entry (@{$self->{parts}}) {
            if ($entry->type == FILE) {
                $entry->{body}->[0] = $self->{io};
            }
        }
        close $out;
        $out = $self->{io};
        $self->{file} = $rename;
        unlink $filename or return $self->error('UNLINK', 'WARN', $filename, "($!)");
    }

# Recompress if it was a .gz file.
    if ($self->{gz_file}) {
        $HAVE_GZIP or return $self->error('NOGZIP', 'WARN');
        seek($out, 0, 0);
        my $gz = Compress::Zlib::gzopen($self->{gz_file}, 'wb') or return $self->error('OPEN', 'WARN', $self->{gz_file}, $Compress::Zlib::gzerrno);
        while (read($out, my $buffer, BLOCK)) {
            $gz->gzwrite($buffer);
        }
        $gz->gzclose();
        seek($out, 0, 0);
    }
    return 1;
}

sub extract {
# ------------------------------------------------------------------------------
# $obj->extract(@list);
# ----------------------
# $obj->extract(\@list);
# -----------------------
#   Extracts only the files specified in @list from the working tar file. No
#   files are extracted if none are in memory.
#
    my $self  = shift;
    my %files = map { $_ => 1 } ref($_[0]) eq 'ARRAY' ? @{$_[0]} : @_;
    my $num = '0E0';
    foreach my $entry (@{$self->{parts}}) {
        next unless (exists $files{$entry->{name}});
        $entry->write;
        $num++;
    }
    return $num;
}

sub add_file {
# ------------------------------------------------------------------------------
# $obj->add_file(@list);
# ------------------
# $obj->add_file(\@list);
# -------------------
#   Adds the files specified in @list to the in-memory archive.
#
    my $self  = shift;
    my @files = ref $_[0] eq 'ARRAY' ? @{$_[0]} : @_;

    while (my $file = shift @files or @files) {
        next if not defined $file;
        my ($mode, $nlnk, $uid, $gid, $rdev, $size, $mtime, $type, $linkname);

        $self->debug("Looking at $file") if ($self->{_debug});
        if (($mode, $nlnk, $uid, $gid, $rdev, $size, $mtime) = (lstat $file)[2 .. 7, 9]) {
            $linkname = "";
            $type = filetype($file);

            $linkname = readlink $file if ($type == SYMLINK);
            if ($type == DIR) {
                my $dir = _gen_fh();
                opendir $dir, $file or return $self->error("OPEN", "WARN", "Can't add directory '$file'", "($!)");
                push(@files, map { $file . '/' . $_ } grep !/^\.\.?$/, readdir $dir);
                closedir $dir;
            }

            my $part = GT::Tar::Parts->new(
                {
                    name     => $file,
                    mode     => $mode,
                    uid      => $uid,
                    gid      => $gid,
                    size     => $size,
                    mtime    => ($mtime | 0),
                    chksum   => "      ",
                    magic    => "ustar",
                    version  => "",
                    type     => $type,
                    linkname => $linkname,
                    devmajor => 0, # We don't handle this yet
                    devminor => 0, # We don't handle this yet
                    uname    => ($FAKE_GETPWUID || scalar getpwuid($uid)),
                    gname    => ($FAKE_GETGRGID || scalar getgrgid($gid)),
                    prefix   => "",
                }
            );
            if ($type == FILE) {
                $self->debug("Adding $file to as body") if ($self->{_debug});
                $part->body(\$file);
            }
            push(@{$self->{parts}}, $part);

        }
        else {
            $self->debug("Could not stat file '$file'");
        }
    }
    return wantarray ? @{$self->{parts}} : $self->{parts};
}

sub remove_file {
# -------------------------------------------------------------------
# Takes a string and removes the file from the tar.
#
    my ($self, $filename) = @_;
    return unless (defined $filename);
    @{$self->{parts}} = grep { $_->{name} ne $filename } @{$self->{parts}};
}

sub get_file {
# -------------------------------------------------------------------
# Returns the file object of a given file name.
#
    my ($self, $filename) = @_;
    return unless (defined $filename);
    my @files = grep { $_->{name} eq $filename } @{$self->{parts}};
    if (! @files) {
        return $self->error('CANTFIND', 'WARN', $filename);
    }
    return wantarray ? @files : shift @files;
}

sub add_data {
# -------------------------------------------------------------------
# $obj->add_newfile( { ... } );
# ------------------------------
#   Adds a file from a hash ref of part attributes.
#
    my $self = shift;
    my $part = @_ > 1 ? {@_} : shift;
    ref $part eq 'HASH' or return $self->error('BADARGS', 'FATAL', "Usage: \$obj->add_newfile( part options )");

    defined $part->{name} or return $self->error('BADARGS', 'FATAL', "You must supply a file name.");
    defined $part->{body} or return $self->error('BADARGS', 'FATAL', "You must supply a body for the file.");

    if (ref $part->{body}) {
        if (fileno $part->{body}) {
            local $/;
            my $fh = $part->{body};
            $part->{body} = <$fh>;
        }
        else {
            return $self->error('BADARGS', 'FATAL', "You must supply either a scalar or a file handle to body");
        }
    }
    my $file = GT::Tar::Parts->new({
        name     => $part->{name},
        mode     => defined $part->{mode}  ? $part->{mode} : 0666 & (0777 - umask),
        uid      => defined $part->{uid}   ? $part->{uid}  : $>,
        gid      => defined $part->{gid}   ? $part->{gid}  : (split(/ /,$)))[0],
        size     => length $part->{body},
        mtime    => defined $part->{mtime} ? $part->{mtime} : time,
        chksum   => "      ",
        magic    => "ustar",
        version  => "00",
        type     => FILE,
        linkname => '',
        devmajor => 0, # We don't handle this yet
        devminor => 0, # We don't handle this yet
        uname    => ($FAKE_GETPWUID || scalar getpwuid(defined $part->{uid} ? int($part->{uid}) : $>)),
        gname    => ($FAKE_GETGRGID || scalar getgrgid(defined $part->{gid} ? int($part->{gid}) : (split(/ /,$)))[0])),
        prefix   => ""
    });
    $file->body($part->{body});
    push(@{$self->{parts}}, $file);
    return $file;
}

sub files {
# ------------------------------------------------------------------------------
# my @files = $obj->files;
# ------------------------
#   Returns a list of the part objects that are in the in-memory archive.
#   Returns an array ref in scalar context.
#
    my @parts = defined $_[0]->{parts} ? @{$_[0]->{parts}} : ();
    return wantarray ? @parts : \@parts;
}

sub filetype {
# ------------------------------------------------------------------------------
# Internal method. filetype -- Determine the type value for a given file
#
    my $file = shift;

    return SYMLINK  if (-l $file);  # Symlink
    return FILE     if (-f _);      # Plain file
    return DIR      if (-d _);      # Directory
    return FIFO     if (-p _);      # Named pipe
    return SOCKET   if (-S _);      # Socket
    return BLOCKDEV if (-b _);      # Block special
    return CHARDEV  if (-c _);      # Character special
    return UNKNOWN; # Something else (like what?)
}

sub _gen_fh {
# -------------------------------------------------------------------
# Return a file handle symbol.
#
    no strict 'refs';
    return *{"FH" . $FH++};
}

package GT::Tar::Parts;
# ==================================================================
# Pragmas
    use vars qw/$DEBUG $ERRORS $ATTRIBS $ERROR_MESSAGE/;
    use strict;

# System modules
    use Fcntl;

# Globals
    $DEBUG = 0;
    @GT::Tar::Parts::ISA = qw{GT::Base};
    $ATTRIBS = {
         name      => '',
         mode      => '',
         uid       => '',
         gid       => '',
         size      => '',
         mtime     => '',
         chksum    => "      ",
         type      => '',
         linkname  => '',
         magic     => "ustar",
         version   => "00",
         uname     => 'unknown',
         gname     => 'unknown',
         devmajor  => 0, # We don't handle this yet
         devminor  => 0, # We don't handle this yet
         prefix    => "",
         body      => undef,
         set_owner => 1,
         set_perms => 1,
         set_time  => 1,
    };
    $ERROR_MESSAGE = 'GT::Tar';

sub format_read {
# ------------------------------------------------------------------------------
# my $obj = GT::Tar::Parts->format_read($heading);
# -------------------------------------------------
#   Unpacks the string that is passed in. The string need to be a valid header
#   from a single entry in a tar file. Return a new object for the Tar part.
#   You will need to set the body yourself after calling this.
#
    my $head_tainted = pop;
    my ($head) = $head_tainted =~ /(.+)/;
    my $tar_unpack_header = 'A100 A8 A8 A8 A12 A12 A8 A1 A100 A6 A2 A32 A32 A8 A8 A155';
    my $file = {};
    (
        $file->{name},     $file->{mode},
        $file->{uid},      $file->{gid},
        $file->{size},     $file->{mtime},
        $file->{chksum},   $file->{type},
        $file->{linkname}, $file->{magic},
        $file->{version},  $file->{uname},
        $file->{gname},    $file->{devmajor},
        $file->{devminor}, $file->{prefix}
    ) = unpack($tar_unpack_header, $head);

    $file->{uid}      = oct $file->{uid};
    $file->{gid}      = oct $file->{gid};
    $file->{mode}     = oct $file->{mode};
    $file->{size}     = oct $file->{size};
    $file->{mtime}    = oct $file->{mtime};
    $file->{chksum}   = oct $file->{chksum};
    $file->{devmajor} = oct $file->{devmajor};
    $file->{devminor} = oct $file->{devminor};
    $file->{name}     = $file->{prefix} . "/" . $file->{name} if $file->{prefix};
    $file->{prefix}   = "";

    $file->{type} = GT::Tar::DIR
        if $file->{name} =~ m|/$| and $file->{type} == GT::Tar::FILE;
    return GT::Tar::Parts->new($file);
}

sub format_write {
# ------------------------------------------------------------------------------
# $obj->format_write;
# -------------------
#   Formats the current objects header for writting to a tar file.
#   Returns the formatted string.
#
    my $self = shift;
    my ($tmp, $file, $prefix, $pos);

    $file = $self->{name};
    if (length($file) > 99) {
        $pos = index $file, "/", (length($file) - 100);
        next if $pos == -1;  # Filename longer than 100 chars!

        $prefix = substr $file, 0, $pos;
        $file   = substr $file, $pos+1;
        substr($prefix, 0, -155) = "" if length($prefix) > 154;
    }
    else {
        $prefix = "";
    }
    if ($self->{type} == GT::Tar::DIR and $file !~ m,/$,) {
        $file .= '/';
    }
    $tmp = pack(
        'a100 a8 a8 a8 a12 a12 A8 a1 a100 a5 a3 a32 a32 a8 a8 a155 x12',
        $file,
        sprintf("%07o",$self->{mode}),
        sprintf("%07o",$self->{uid}),
        sprintf("%07o",$self->{gid}),
        sprintf("%011o", $self->{type} == GT::Tar::DIR ? 0 : $self->{size}),
        sprintf("%011o",$self->{mtime}),
        "",        #checksum field - space padded by pack("A8")
        $self->{type},
        $self->{linkname},
        $self->{magic},
        $self->{version} || '  ',
        $self->{uname},
        $self->{gname},
        '', # sprintf("%6o ",$self->{devmajor}),
        '', # sprintf("%6o ",$self->{devminor}),
        $prefix
    );
    substr($tmp, 148, 7) = sprintf("%06o\0", unpack("%16C*", $tmp));
    return $tmp;
}

sub body {
# ------------------------------------------------------------------------------
# my $path = $obj->body;
# ----------------------
# $obj->body(\'/path/to/body');
# $obj->body("My body text.");
# -----------------------------
#   Sets or gets the path to the body of this tar part. If a scalar ref is
#   passed in it is considered a path to a file otherwize it is considered a
#   string to write to the body when write is called.
#
    my ($self, $io) = @_;
    !$io and return $self->{body};
    $self->{body} = $io;
    my $ref = ref $io;
    if ($ref eq 'GLOB' and fileno $io) {
        $self->{size} = (lstat(${$self->{body}}))[7];
    }
    elsif ($ref eq 'SCALAR') {
        $self->{size} = -s ${$self->{body}};
    }
    elsif (not $ref) {
        $self->{size} = length $self->{body};
    }

    return $self->{body};
}

sub body_as_string {
# ------------------------------------------------------------------------------
# my $data = $obj->body_as_string;
# --------------------------------
#   Returns the body of the file as a string.
#
    my $self = shift;
    my $data = '';
    my $ref  = ref $self->{body};
    if ($ref eq 'GLOB' and fileno $self->{body}) {
        my $fh = $self->{body};
        my $pos = tell $fh;
        seek($fh, 0, 0);
        binmode $fh;
        local $/;
        $data = <$fh>;
        seek($fh, $pos, 0);
    }
    elsif ($ref eq 'ARRAY') {
        my ($fh, $start) = @{$self->{body}};
        my $pos = tell $fh;
        binmode $fh;
        seek($fh, $start, 0);
        read($fh, $data, $self->{size});
        seek($fh, $pos, 0);
    }
    elsif ($ref eq 'SCALAR') {
        my $fh = _gen_fh();
        open $fh, ${$self->{body}} or return $self->error('READOPEN', 'WARN', ${$self->{body}}, "($!)");
        binmode $fh;
        read($fh, $data, -s $fh);
        close $fh;
    }
    else {
        $data = $self->{body};
    }
    return $data;
}

sub write {
# ------------------------------------------------------------------------------
# $obj->write;
# ------------
#   Writes this part to disk using the path that is in $obj->body. This function
#   will recursivlty make the directories needed to create the structure of this
#   part.
#
    my $self = shift;

# For the moment, we assume that all paths in tarfiles are given according to
# Unix standards, which they *are*, according to the tar format spec!
    $self->_write_dir or return;
    if ($self->{type} == GT::Tar::FILE) {
        my $out = GT::Tar::_gen_fh();
        $self->{name} =~ /^(.+)$/;
        my $name = $1;
        open $out, ">$self->{name}" or return $self->error("OPEN", "WARN", $self->{name}, "($!)");
        binmode $out or return $self->error("BINMODE", "WARN", "($!)");
        my $ref  = ref $self->{body};
        if ($ref eq 'GLOB' and fileno $self->{body}) {
            my $fh = $self->{body};
            my $pos = tell $fh;
            binmode $fh;
            while (read $fh, $_, GT::Tar::BLOCK) {
                print $out $_;
            }
            seek($fh, $pos, 0);
        }
        elsif ($ref eq 'ARRAY') {
            my ($reads, $rem, $data, $pos);
            my ($fh, $start) = @{$self->{body}};
            $pos = tell $fh;
            seek($fh, $start, 0);
            binmode $fh;
            $reads = int($self->{size} / GT::Tar::BLOCK);
            $rem   = $self->{size} % GT::Tar::BLOCK;
            for (1 .. $reads) {
                my $read = read($fh, $data, GT::Tar::BLOCK);
                ($read == GT::Tar::BLOCK)
                    or return $self->error("READ", "WARN", join(',' => @{$self->{body}}), GT::Tar::BLOCK, $read);
                print $out $data;
            }
            if ($rem) {
                my $read = read($fh, $data, $rem);
                ($read == $rem)
                    or return $self->error("READ", "WARN", join(',' => @{$self->{body}}), $rem, $read);
                print $out $data;
            }
            seek($fh, $pos, 0);
        }
        elsif ($ref eq 'SCALAR') {
            my $fh = GT::Tar::_gen_sym();
            open $fh, ${$self->{body}} or return $self->error('READOPEN', 'WARN', ${$self->{body}}, "($!)");
            binmode $fh;
            while (read $fh, $_, GT::Tar::BLOCK) {
                print $out $_;
            }
            close $fh;
        }
        else {
            print $out $self->{body};
        }
        close $out;
        $self->debug("Created $self->{name} size $self->{size}") if ($self->{_debug});
    }
    $self->_file_sets;

    return 1;
}

sub _recurse_mkdir {
# ---------------------------------------------------------------------
# Internal method to recursivly make a directory.
#
    my ($self) = @_;
    my $dir    = $self->{name};
    my @path   = split m|/|, $dir;
    ($dir      =~ m,/$,) or pop(@path);
    my $go     = '';
    foreach my $path (@path) {
        next if $path =~ /^\s*$/;
        $go .= $path;
        $go .= '/' unless $go =~ m,/$,;
        ($go = '/' . $go) if ($dir =~ m,^/, and $go !~ m,^/,);
        (my $next = $go) =~ s,/$,,;
        ((-e $next) and (not -d $next)) and return $self->error("DIRFILE", "FATAL", $self->{name});
        unless (-d $next) {
            mkdir($next, 0777) or return $self->error("MKDIR", "WARN", $next, "($!)");
            $self->debug("mkdir $next") if ($DEBUG);
        }
    }
    return 1;
}

sub _write_dir {
# ------------------------------------------------------------------------------
# Internal method used to create a directory for a file, or just create a
# directory if this is a directory part and the directory does not exist.
    my $self = shift;

    if ($self->{type} == GT::Tar::DIR) {
        ((-e $self->{name}) and (not -d $self->{name}))
            and return $self->error("DIRFILE", "FATAL", $self->{name});
        unless (-d $self->{name}) {
            $self->_recurse_mkdir or return;
        }
    }
    else {
        $self->_recurse_mkdir or return;
    }
    return 1;
}

sub _file_sets {
# ------------------------------------------------------------------------------
# Internal method to set the file or directory permissions and or onership of
# this part.
#
    my $self = shift;

# Set the file creation time.
    if ($self->{set_time}) {
        utime time, $self->{mtime}, $self->{name};
    }

# Set the file owner.
    if ($self->{set_owner}) {
        $self->debug("chown ($self->{uid},$self->{gid}) $self->{name}") if ($self->{_debug});
        chown($self->{uid}, $self->{gid}, $self->{name})
            if ($> == 0 and $^O ne "MacOS" and $^O ne "MSWin32");
    }

# Set the permissions (done last in case it makes file readonly)
    if ($self->{set_perms}) {
        my ($mode) = sprintf("%lo", $self->{mode}) =~ /(\d{3})$/;
        $self->debug("chmod $mode, $self->{name}") if ($self->{_debug});
        chmod $self->{mode}, $self->{name} or return $self->error("CHMOD", "WARN", $self->{name}, "($!)");
    }

    return 1;
}

1;



=head1 NAME

GT::Tar - Perl module to manipulate tar files.

=head1 SYNOPSIS

    use GT::Tar;
    my $tar = GT::Tar->open('foo.tar');
    $tar->add_file( '/path/to/file' );
    $tar->write;

=head1 DESCRIPTION

GT::Tar provides an OO intefrace to a tar file. It allows you to create or edit
tar files, and if you have Compress::Zlib installed, it allows you to work with
.tar.gz files as well!

=head2 Creating a tar file

To create a tar file, you simply call:

    my $tar = new GT::Tar;

and then to save it:

    $tar->write('filename.tar');

will save the tar file and any files you have added.

=head2 Opening an existing tar file

To open a tar file you call:

    my $tar = GT::Tar->open('/path/to/file.tar')
        or die "Can't open: $GT::Tar::error";

Note: the tar object keeps an open filehandle to the file, so if you are on
windows, you may not be able to manipulate it until you call $tar->close_tar, or
the tar object goes out of scope.

=head2 Untarring a tar file

To untar a tar file, you can simply call:

    $tar->untar( \&code_ref );

or as a class method

    GT::Tar->untar('/path/to/tar.tar', \&code_ref );

The code ref is optional. If provided, you will get passed in the a
GT::Tar::Part object before the file is extracted. This lets you change the
path, or alter any attributes of the file before it is saved to disk.

=head2 Adding files to a tar file

To add a file:

    $tar->add_file( '/path/to/file' );

Note, if you add a directory, the tar module will recurse and add all files in
that directory.

To add a file that isn't saved:

    $tar->add_data( name => 'Filename', body => 'File body' );

You can pass in either a scalar for the body, or an opened file handle.

=head2 Getting a list of files in a tar

To get a list of files in a tar:

    my $files = $tar->files;

This returns an array ref of GT::Tar::Part objects. See below for how to access
information from a part.

Note: if you change a part, it will update the tar file if you save it.

=head2 Getting an individual file from a tar

If you know the name of the file you want:

    my $file = $tar->get_file('Filename');

will return a single GT::Tar::Part object.

=head2 Removing a file from a tar

To remove a file, you need to know the name of it:

    $tar->remove_file('Filename');
    $tar->write;

and you need to save it before the change will take affect.

=head2 GT::Tar::Part

Each file is a separate part object. The part object has the following
attributes:

    name    file name
    mode    file permissions
    uid     user id
    gid     group id
    size    file size
    mtime   last modified time
    type    file type
    body    file body

You can access or set any of these attributes by just using the attribute name
as the method (as it inherits from L<GT::Base>).

You can also call:

    $file->write;

and the file will be created with the given attributes. Basically untar just
foreach's through each of the objects and calls write() on it.

=head1 EXAMPLES

To create a new tar and add two directories to it, and save it in
'/tmp/foo.tar';

    my $tar = new GT::Tar;
    $tar->add_file( '/home/httpd/html' );
    $tar->add_file( '/home/backup' );
    $tar->write('/tmp/foo.tar');

To open an existing tar file and save all the .pl files in /home/alex.

    my $tar = GT::Tar->open('files.tar');
    my $files = $tar->files;
    foreach my $file (@$files) {
        my $name = $file->name;
        if ($name =~ m,([^/]*\.pl$),) {
            $file->name( "/home/alex/$1" );
            $file->write;
        }
    }

=head1 COPYRIGHT

Copyright (c) 2002 Gossamer Threads Inc.  All Rights Reserved.
http://www.gossamer-threads.com/

=head1 VERSION

Revision: $Id: Tar.pm,v 1.46 2002/04/07 03:35:35 jagerman Exp $

=cut


}

BEGIN { $INC{"GT/CGI.pm"} = "GT/CGI.pm" }
{
# ==================================================================
# Gossamer Threads Module Library - http://gossamer-threads.com/
#
#   GT::CGI
#   Author  : Aki Mimoto
#   $Id: CGI.pm,v 1.106 2002/06/04 22:39:12 jagerman Exp $
# 
# Copyright (c) 2002 Gossamer Threads Inc.  All Rights Reserved.
# ==================================================================
#
# Description:
#   Implements CGI.pm's CGI functionality, but faster.
#

package GT::CGI;
# ===============================================================
use strict;
use GT::Base(':all'); # Imports $MOD_PERL, $SPEEDY and $PERSIST
use vars qw/@ISA $DEBUG $VERSION $ATTRIBS $ERRORS $PRINTED_HEAD
            $FORM_PARSED %PARAMS %COOKIES @EXPORT_OK %EXPORT_TAGS/;
use GT::AutoLoader;
require Exporter;

@ISA     = qw/GT::Base/;
$DEBUG   = 0;
$VERSION = sprintf "%d.%03d", q$Revision: 1.106 $ =~ /(\d+)\.(\d+)/;
$ATTRIBS = {
    nph  => 0,
    p    => ''
};
$ERRORS  = {
    INVALIDCOOKIE => "Invalid cookie passed to header: %s",
    INVALIDDATE   => "Date '%s' is not a valid date format.",
};
use constants CRLF => "\015\012";
$PRINTED_HEAD = 0;
$FORM_PARSED  = 0;
%PARAMS       = ();
%COOKIES      = ();
@EXPORT_OK    = qw/escape unescape html_escape html_unescape/;
%EXPORT_TAGS  = (
    escape => [qw/escape unescape html_escape html_unescape/]
);

# Pre load our compiled if under mod_perl/speedy.
if ($PERSIST) {
    require GT::CGI::Cookie;
    require GT::CGI::MultiPart;
    require GT::CGI::Fh;
}

sub load_data {
#--------------------------------------------------------------------------------
# Loads the form information into PARAMS. Data comes from either
# a multipart form, a GET Request, a POST request, or as arguments from command 
# line.
#
    my $self = shift;
    %PARAMS  = ();
    %COOKIES = ();

# Load form data.
    my $method         = defined $ENV{REQUEST_METHOD}   ? uc $ENV{REQUEST_METHOD} : '';
    my $content_length = defined $ENV{'CONTENT_LENGTH'} ? $ENV{'CONTENT_LENGTH'} : 0;

    if ($method eq 'GET') {
        $self->parse_str(defined $ENV{QUERY_STRING} ? $ENV{QUERY_STRING} : '');
    }
    elsif ($method eq 'POST') {
        if ($content_length) {
            if ($ENV{CONTENT_TYPE} and $ENV{CONTENT_TYPE} =~ /^multipart/) {
                require GT::CGI::MultiPart;
                GT::CGI::MultiPart->parse($self);
            }
            else {
                read(STDIN, my $data, $content_length, 0);
                $data =~ s/\r?\n/&/g;
                $self->parse_str($data);
            }
        }
    }
    else {
        my $data = join "&", @ARGV;
        $self->parse_str($data);
    }

# Load cookies.
    if (defined $ENV{HTTP_COOKIE}) {
        for (split /;\s*/, $ENV{HTTP_COOKIE}) {
            /(.*)=(.*)/ or next;
            my ($key, $val) = (unescape($1), unescape($2));
            $val = [split '&', $val];
            $self->{cookies}->{$key} = $val;
        }
    }
    else {
        %{$self->{cookies}} = ();
    }

# If we are under mod_perl we let mod_perl know that it should call reset_param
# when a request is finished.
    $MOD_PERL and require Apache and $Apache::ServerStarting != 1 and Apache->request->register_cleanup(\&reset_env);
    $SPEEDY   and require CGI::SpeedyCGI and CGI::SpeedyCGI->new->register_cleanup (\&reset_env );

# Parse form buttons, allowing you to pass in name="foo=bar;a=b;c=d" as a name
# tag in the form.
    for (keys %{$self->{params}}) {
        if (index($_, '=') >= 0) {
            next if substr($_, -2) eq '.y';
            (my $key = $_) =~ s/\.x$//;
            $self->parse_str($key);
        }
    }

# Save the data for caching
    while (my ($k, $v) = each %{$self->{params}}) {
        push @{$PARAMS{$k}}, @$v;
    }
    while (my ($k, $v) = each %{$self->{cookies}}) {
        push @{$COOKIES{$k}}, @$v;
    }
    $FORM_PARSED = 1;
}

sub class_new {
# --------------------------------------------------------------------------------
# Creates an object to be used for all class methods, this affects the global
# cookies and params.
#
    my $self = bless {} => shift;
    $self->load_data unless ($FORM_PARSED);
    
    $self->{cookies} = \%COOKIES;
    $self->{params}  = \%PARAMS;
    for (keys %{$ATTRIBS}) { $self->{$_} = $ATTRIBS->{$_} }

    return $self;
}

sub reset_env {
# --------------------------------------------------------------------------------
# Reset the global environment.
#
    %PARAMS         = ();
    %COOKIES        = ();
    $PRINTED_HEAD   = 0; 
    $FORM_PARSED    = 0;
    1;
}

sub init {
#--------------------------------------------------------------------------------
# Called from GT::Base when a new object is created.
#
    my $self = shift;

# If we are passed a single argument, then we load our data from
# the input.
    if (@_ == 1) {
        my $p = $_[0];
        if (ref $p eq 'GT::CGI') {
            $p = $p->query_string;
        }
        $self->parse_str($p ? "&$p" : "");
        if (defined $ENV{HTTP_COOKIE}) {
            for (split /;\s*/, $ENV{HTTP_COOKIE}) {
                /(.*)=(.*)/ or next;
                my ($key, $val) = (unescape($1), unescape($2));
                $val = [split '&', $val];
                $self->{cookies}->{$key} = $val;
            }
        }
        $FORM_PARSED = 1;
    }
    else {
        $self->set(@_) if @_;

# If we have the form parsed, then we need to copy the data into self.
        if ($FORM_PARSED) {
            while (my ($k, $v) = each %PARAMS) {
                push @{$self->{params}->{$k}}, @$v;
            }
            while (my ($k, $v) = each %COOKIES) {
                push @{$self->{cookies}->{$k}}, @$v;
            }
        }
    }
    return $self;
}

$COMPILE{get_hash} = __LINE__ . <<'END_OF_SUB';
sub get_hash {
#-------------------------------------------------------------------------------
# Returns the parameters as a HASH, with multiple values becoming an array
# reference.
#
    my $self = shift;
    $self = $self->class_new unless ref $self;
    $FORM_PARSED or $self->load_data();
    my $join = defined $_[0] ? $_[0] : 0;

    keys %{$self->{params}} or return {};

# Construct hash ref and return it
    my $opts = {};
    foreach (keys %{$self->{params}}) { 
        my @vals = @{$self->{params}->{$_}};
        $opts->{$_} = @vals > 1 ? \@vals : $vals[0];
    }
    return $opts;
}
END_OF_SUB

$COMPILE{delete} = __LINE__ . <<'END_OF_SUB';
sub delete {
#--------------------------------------------------------------------------------
# Remove an element from the parameters.
#
    my ($self, $param) = @_;
    $self = $self->class_new unless ref $self;
    $FORM_PARSED or $self->load_data();
    exists $self->{params}->{$param} and return wantarray ? @{delete $self->{params}->{$param}} : (@{delete $self->{params}->{$param}})[0];
    return;
}
END_OF_SUB

$COMPILE{cookie} = __LINE__ . <<'END_OF_SUB';
sub cookie {
#--------------------------------------------------------------------------------
# Creates a new cookie for the user, implemented just like CGI.pm.
#
    my $self = shift; # Not used, don't care if it's self/class.;
    $self = $self->class_new unless ref $self;
    $FORM_PARSED or $self->load_data();
    my %data = ( @_ ) if ( @_ and @_ % 2 == 0 );
    if (@_ == 0) {    # Return keys.
        return keys %{$self->{cookies}};
    }
    elsif (@_ == 1) { # Return value of param passed in.
        my $param = shift;
        return unless (defined ($param) and $self->{cookies}->{$param});
        return wantarray ? @{$self->{cookies}->{$param}} : $self->{cookies}->{$param}->[0];
    }
    elsif (@_ == 2) {
        require GT::CGI::Cookie;
        return GT::CGI::Cookie->new(-name => $_[0], -value => $_[1]);
    }
    elsif (defined $data{'-value'}) {
        require GT::CGI::Cookie;
        return GT::CGI::Cookie->new(%data);
    }
    else {                  # Set parameter.
        my ($param, $value) = @_;
        $self->{cookies}->{$param} = (ref $value eq 'ARRAY' ? $value : [$value]);
    }
}
END_OF_SUB

$COMPILE{set} = __LINE__ . <<'END_OF_SUB';
sub set {
#--------------------------------------------------------------------------------
# Let's you set a key/val parameter.
#
    my $self    = shift;
    $self = $self->class_new unless ref $self;
    $FORM_PARSED or $self->load_data();
    my $params  = $self->common_param(@_);

    foreach my $key (keys %$params) {
        $self->{params}->{$key} = $params->{$key};
    }
    return {%{$self->{params}}};
}
END_OF_SUB

sub param {
#--------------------------------------------------------------------------------
# Mimick CGI's param function for get/set.
#
    my $self = shift; # Not used, don't care if it's self/class.;
    $self = $self->class_new unless ref $self;
    $FORM_PARSED or $self->load_data();
    if (@_ == 0) {    # Return keys.
        return keys %{$self->{params}};
    }
    elsif (@_ == 1) { # Return value of param passed in.
        my $param = shift;
        return unless (defined ($param) and $self->{params}->{$param});
        return wantarray ? @{$self->{params}->{$param}} : $self->{params}->{$param}->[0];
    }
    else {            # Set parameter.
        my ($param, $value) = @_;
        $self->{params}->{$param} = [ref $value eq 'ARRAY' ? @$value : $value];
    }
}

sub header {
#--------------------------------------------------------------------------------
# Mimick the header function.
#
    my $self = shift;
    $self = $self->class_new unless ref $self;
    my %p = (ref($_[0]) eq 'HASH') ? %{$_[0]} : ( @_ % 2 ) ? () : @_; 
    my @headers;

# Don't print headers twice unless -force'd.
    return '' if not delete $p{-force} and $PRINTED_HEAD;

# Start by adding NPH headers if requested.
    if ($self->{nph} || $p{-nph}) {
        if ($p{-url}) {
            push @headers, "HTTP/1.0 302 Moved";
        }
        else {
            my $protocol = $ENV{SERVER_PROTOCOL} || 'HTTP/1.0';
            push @headers, "$protocol 200 OK" unless ($MOD_PERL);
        }
    }
    delete $p{-nph};

# If requested, add a "Pragma: no-cache" if requested
    if ($p{'no-cache'} or $p{'-no-cache'}) {
        delete @p{qw/no-cache -no-cache/};
        require GT::Date;
        push @headers,
            "Expires: Tue, 25 Jan 2000 12:00:00 GMT",
            "Last-Modified: " . GT::Date::date_get_gm(time, "%ddd%, %dd% %mmm% %yyyy% %HH%:%MM%:%ss% GMT"),
            "Cache-Control: no-cache",
            "Pragma: no-cache";
    }

# Add any cookies, we accept either an array of cookies
# or a single cookie.
    my $add_date = 0;
    my $cookies  = 0;
    my $container = delete($p{-cookie}) || '';
    require GT::CGI::Cookie if $container;
    if (ref $container and UNIVERSAL::isa($container, 'GT::CGI::Cookie')) {
        my $c = $container->cookie_header;
        push @headers, $c;
        $add_date = 1;
        $cookies++;
    }
    elsif (ref $container eq 'ARRAY') {
        foreach my $cookie (@$container) {
            next unless (defined $cookie and (ref $cookie eq 'GT::CGI::Cookie'));
            push @headers, $cookie->cookie_header;
            $add_date = 1;
            $cookies++;
        }
    }
    elsif ($container) {
        $self->error('INVALIDCOOKIE', 'WARN', $container);
    }

# Print expiry if requested.
    if (defined(my $expires = delete $p{-expires})) {
        require GT::CGI::Cookie;
        my $date = GT::CGI::Cookie::_format_date(' ', $expires);
        unless ($date) {
            $self->error('INVALIDDATE', 'WARN', $expires);
        }
        else {
            push @headers, "Expires: $date";
            $add_date = 1;
        }
    }

# Add a Date header if we printed an expires tag or a cookie tag.
    if ($add_date) {
        require GT::CGI::Cookie;
        my $now = GT::CGI::Cookie::_format_date (' ');
        push @headers, "Date: $now";
    }

# Add Redirect Header.
    my $iis_redirect;
    if (my $url = delete $p{-url}) {
        if ($cookies and $ENV{SERVER_SOFTWARE} =~ /IIS/i) {
            $iis_redirect = $url;
        }
        else {
            push @headers, "Location: $url";
        }
    }

# Add the Content-type header.
    my $type = @_ == 1 && !ref($_[0]) ? $_[0] : delete($p{-type}) || 'text/html';
    push @headers, "Content-type: $type";

# Add any custom headers.
    foreach my $key (keys %p) {
        $key =~ /^\s*-?(.+)/;
        push @headers, escape(ucfirst $1) . ": " . (ref $p{$key} eq 'SCALAR' ? ${$p{$key}} : escape($p{$key}));
    }
    $PRINTED_HEAD = 1;

    my $headers = join(CRLF, @headers) . CRLF . CRLF;

# Fun hack for IIS
    if ($iis_redirect) {
        $iis_redirect =~ y/;/&/; # You can't have semicolons in a meta http-equiv tag.
        return $headers . <<END_OF_HTML;
<html><head><title>Document Moved</title><meta http-equiv="refresh" content="0;URL=$iis_redirect"></head>
<body><noscript><h1>Object Moved</h1>This document may be found <a HREF="$iis_redirect">here</a></noscript></body></html>
END_OF_HTML
    }
    return $headers;
}

$COMPILE{redirect} = __LINE__ . <<'END_OF_SUB';
sub redirect {
#-------------------------------------------------------------------------------
# Print a redirect header.
#
    my $self = shift;
    $self = $self->class_new unless ref $self;
    
    my (@headers, $url);
    if (@_ == 0) {
        return $self->header({ -url => $self->self_url });
    }
    elsif (@_ == 1) {
        return $self->header({ -url => shift });
    }
    else {
        my $opts = ref $_[0] eq 'HASH' ? shift : {@_};
        $opts->{'-url'} ||= $opts->{'-URL'} || $self->self_url;
        return $self->header($opts);
    }
}
END_OF_SUB

sub unescape {
#-------------------------------------------------------------------------------
# returns the url decoded string of the passed argument. Optionally takes an
# array reference of multiple strings to decode. The values of the array are
# modified directly, so you shouldn't need the return (which is the same array
# reference).
#
    my $todecode = pop;
    return unless defined $todecode;
    for my $str (ref $todecode eq 'ARRAY' ? @$todecode : $todecode) {
        $str =~ tr/+/ /; # pluses become spaces
        $str =~ s/%([0-9a-fA-F]{2})/chr(hex($1))/ge;
    }
    $todecode;
}

$COMPILE{escape} = __LINE__ . <<'END_OF_SUB';
sub escape {
#--------------------------------------------------------------------------------
# return the url encoded string of the passed argument
#
    my $toencode = pop;
    return unless defined $toencode;
    $toencode =~ s/([^\w.-])/sprintf("%%%02X",ord($1))/eg;
    return $toencode;
}
END_OF_SUB

$COMPILE{html_escape} = __LINE__ . <<'END_OF_SUB';
sub html_escape {
#--------------------------------------------------------------------------------
# Return the string html_escaped.
#
    my $toencode = pop;
    return unless defined $toencode;
    if (ref($toencode) eq 'SCALAR') {
        $$toencode =~ s/&/&amp;/g;
        $$toencode =~ s/</&lt;/g;
        $$toencode =~ s/>/&gt;/g;
        $$toencode =~ s/"/&quot;/g;
    }
    else {
        $toencode =~ s/&/&amp;/g;
        $toencode =~ s/</&lt;/g;
        $toencode =~ s/>/&gt;/g;
        $toencode =~ s/"/&quot;/g;
    }
    return $toencode;
}
END_OF_SUB

$COMPILE{html_unescape} = __LINE__ . <<'END_OF_SUB';
sub html_unescape {
#--------------------------------------------------------------------------------
# Return the string html unescaped.
#
    my $todecode = pop;
    return unless defined $todecode;
    if (ref ($todecode) eq 'SCALAR') {
        $$todecode =~ s/&lt;/</g;
        $$todecode =~ s/&gt;/>/g;
        $$todecode =~ s/&quot;/"/g;
        $$todecode =~ s/&amp;/&/g;
    }
    else {
        $todecode =~ s/&lt;/</g;
        $todecode =~ s/&gt;/>/g;
        $todecode =~ s/&quot;/"/g;
        $todecode =~ s/&amp;/&/g;
    }
    return $todecode;
}
END_OF_SUB

$COMPILE{self_url} = __LINE__ . <<'END_OF_SUB';
sub self_url {
# -------------------------------------------------------------------
# Return full URL with query options as CGI.pm
#
    return $_[0]->url ( query_string => 1, absolute => 1 );
}
END_OF_SUB

$COMPILE{url} = __LINE__ . <<'END_OF_SUB';
sub url {
# -------------------------------------------------------------------
# Return the current url. Can be called as GT::CGI->url() or $cgi->url().
#
    my $self = shift;
    $self = $self->class_new unless ref $self;
    $FORM_PARSED or $self->load_data();
    my $opts = $self->common_param(@_);

    my $absolute        = exists $opts->{absolute} ? $opts->{absolute} : 0;
    my $query_string    = exists $opts->{query_string} ? $opts->{query_string} : 1;
    my $path_info       = exists $opts->{path_info}    ? $opts->{path_info} : 0;
    my $remove_empty    = exists $opts->{remove_empty} ? $opts->{remove_empty} : 0;
    if ($opts->{relative}) {
        $absolute = 0;
    }

    my $url = '';
    my $script = $ENV{SCRIPT_NAME} || $0;
    my ($path, $prog) = $script =~ m,^(.+?)[/\\]?([^/\\]*)$,;

    if ($absolute) {
        my ($protocol, $version) = split ('/', $ENV{SERVER_PROTOCOL} || 'HTTP/1.0');
        $url = lc $protocol . "://";

        my $host = $ENV{HTTP_HOST} || $ENV{SERVER_NAME} || '';
        $url .= $host;

        $path =~ s,^[/\\]*|[/\\]*$,,g;
        $url .= "/$path/";      
    }
    $prog =~ s,^[/\\]*|[/\\]*$,,g;
    $url .= $prog;
    
    if ($path_info and $ENV{PATH_INFO}) {
        if (defined $ENV{SERVER_SOFTWARE} && ($ENV{SERVER_SOFTWARE} =~ /IIS/)) {
            $ENV{PATH_INFO} =~ s,$ENV{SCRIPT_NAME},,;
        }
        $url .= $ENV{PATH_INFO};
    }
    if ($query_string) {
        my $qs = $self->query_string( remove_empty => $remove_empty );
        if ($qs) {
            $url .= "?" . $qs;
        }
    }
    return $url;
}
END_OF_SUB

$COMPILE{query_string} = __LINE__ . <<'END_OF_SUB';
sub query_string {
# -------------------------------------------------------------------
# Returns the query string url escaped.
#
    my $self = shift;
    $self = $self->class_new unless ref $self;
    $FORM_PARSED or $self->load_data();
    my $opts = $self->common_param(@_);
    my $qs = '';
    foreach my $key (keys %{$self->{params}}) {
        my $esc_key = escape($key);
        foreach my $val (@{$self->{params}->{$key}}) {
            next if ($opts->{remove_empty} and ($val eq ''));
            $qs .= $esc_key . "=" . escape($val) . ";";
        }
    }
    $qs and chop $qs;
    $qs ? return $qs : return '';
}
END_OF_SUB

sub parse_str {
#--------------------------------------------------------------------------------
# parses a query string and add it to the parameter list
#
    my $self = shift;
    my @input;
    for (split /[;&]/, shift) {
        my ($key, $val) = /([^=]+)=(.*)/ or next;

# Need to remove cr's on windows.
        if ($^O eq 'MSWin32') {
            $key =~ s/%0D%0A/%0A/gi; # \x0d = \r, \x0a = \n
            $val =~ s/%0D%0A/%0A/gi;
        }
        push @input, $key, $val;
    }
    unescape(\@input);
    while (@input) {
        unshift @{$self->{params}->{shift @input}}, shift @input;
    }
}

1;



=head1 NAME

GT::CGI - a lightweight replacement for CGI.pm

=head1 SYNOPSIS

    use GT::CGI;
    my $in = new GT::CGI;
    foreach my $param ($in->param) {
        print "VALUE: $param => ", $in->param($param), "\n";
    }

    use GT::CGI qw/-no_parse_buttons/;

=head1 DESCRIPTION

GT::CGI is a lightweight replacement for CGI.pm. It implements most of the
functionality of CGI.pm, with the main difference being that GT::CGI does not
provide a function-based interface (with the exception of the escape/unescape
functions, which can be called as either function or method), nor does it
provide the HTML functionality provided by CGI.pm.

The primary motivation for this is to provide a CGI module that can be shipped
with Gossamer products, not having to depend on a recent version of CGI.pm
being installed on remote servers. The secondary motivation is to provide a
module that loads and runs faster, thus speeding up Gossamer products.

Credit and thanks goes to the author of CGI.pm. A lot of the code (especially
file upload) was taken from CGI.pm.

=head2 param - Accessing form input.

Can be called as either a class method or object method. When called with no
arguments a list of keys is returned.

When called with a single argument in scalar context the first (and possibly
only) value is returned. When called in list context an array of values is
returned.

When called with two arguments, it sets the key-value pair.

=head2 header() - Printing HTTP headers

Can be called as a class method or object method. When called with no
arguments, simply returns the HTTP header.

Other options include:

=over 4

=item -force => 1

Force printing of header even if it has already been displayed.

=item -type => 'text/plain'

Set the type of the header to something other then text/html.

=item -cookie => $cookie

Display any cookies. You can pass in a single GT::CGI::Cookie object, or an
array of them.

=item -nph => 1

Display full headers for nph scripts.

=back

If called with a single argument, sets the Content-Type.

=head2 redirect - Redirecting to new URL.

Returns a Location: header to redirect a user. 

=head2 cookie - Set/Get HTTP Cookies.

Sets or gets a cookie. To retrieve a cookie:

    my $cookie = $cgi->cookie ('key');
    my $cookie = $cgi->cookie (-name => 'key');

or to retrieve a hash of all cookies:

    my $cookies = $cgi->cookie;

To set a cookie:

    $c = $cgi->cookie (-name => 'foo', -value => 'bar')

You can also specify -expires for when the cookie should expire, -path for
which path the cookie valid, -domain for which domain the cookie is valid, and
-secure if the cookie is only valid for secure sites.

You would then set the cookie by passing it to the header function:

    print $in->header ( -cookie => $c );

=head2 url - Retrieve the current URL.

Returns the current URL of the script. It defaults to display just the script
name and query string.

Options include:

=over 4

=item absolute => 1

Return the full URL: http://domain/path/to/script.cgi

=item relative => 1

Return only the script name: script.cgi

=item query_string => 1

Return the query string as well: script.cgi?a=b

=item path_info => 1

Returns the path info as well: script.cgi/foobar

=item remove_empty => 0

Removes empty query= from the query string.

=back

=head2 get_hash - Return all form input as hash.

This returns the current parameters as a hash. Any values that have the same
key will be returned as an array reference of the multiple values.

=head2 escape - URL escape a string.

Returns the passed in value URL escaped. Can be called as class method or
object method.

=head2 unescape - URL unescape a string.

Returns the passed in value URL un-escaped. Can be called as class method or
object method. Optionally can take an array reference of strings instead of a
string. If called in this method, the values of the array reference will be
directly altered.

=head2 html_escape - HTML escape a string

Returns the passed in value HTML escaped. Translates &, <, > and " to their
html equivalants.

=head2 html_unescape - HTML unescapes a string

Returns the passed in value HTML unescaped.

=head1 DEPENDENCIES

Note: GT::CGI depends on L<GT::Base> and L<GT::AutoLoader>, and if you are
performing file uploads, GT::CGI::MultiPart, GT::CGI::Fh, and L<GT::TempFile>.
The ability to set cookies requires GT::CGI::Cookie.

=head1 COPYRIGHT

Copyright (c) 2002 Gossamer Threads Inc.  All Rights Reserved.
http://www.gossamer-threads.com/

=head1 VERSION

Revision: $Id: CGI.pm,v 1.106 2002/06/04 22:39:12 jagerman Exp $

=cut

}

BEGIN { $INC{"GT/CGI/Cookie.pm"} = "GT/CGI/Cookie.pm" }
{
# ==================================================================
# Gossamer Threads Module Library - http://gossamer-threads.com/
#
#   GT::CGI::Cookie
#   $Id: Cookie.pm,v 1.1 2002/05/22 00:58:47 jagerman Exp $
# 
# Copyright (c) 2000 Gossamer Threads Inc.  All Rights Reserved.
# ==================================================================
#
# Description:
#   Handles cookie creation and formatting.
#

package GT::CGI::Cookie;
#================================================================================

use strict;
use GT::CGI;
use GT::Base;
use vars qw/@ISA $ATTRIBS @MON @WDAY/;

@ISA = qw/GT::Base/;

$ATTRIBS = {
    -name    => '',
    -value   => '',
    -expires => '',
    -path    => '',
    -domain  => '',
    -secure  => ''
};
@MON  = qw/Jan Feb Mar Apr May Jun Jul Aug Sep Oct Nov Dec/;
@WDAY = qw/Sun Mon Tue Wed Thu Fri Sat/;

sub cookie_header {
#--------------------------------------------------------------------------------
# Returns a cookie header.
#
    my $self    = shift;

# make sure we have a name to use..,
    $self->{'-name'} or return;

    my $name    = GT::CGI::escape($self->{'-name'});
    my $value   = GT::CGI::escape($self->{'-value'});

# build the header that creats the cookie
    my $header  = "Set-Cookie: $name=$value";

    $self->{'-expires'} and $header .= "; expires=" . _format_date ('-', $self->{'-expires'});
    $self->{'-path'}    and $header .= "; path=$self->{-path}";
    $self->{'-domain'}  and $header .= "; domain=$self->{-domain}";
    $self->{'-secure'}  and $header .= "; secure";

    return "$header";
}

sub _format_date {
# -------------------------------------------------------------------
# Return a string in http_gmt format, but accepts one in unknown format.
#   Wed, 23 Aug 2000 21:20:14 GMT
#
    my ($sep, $datestr) = @_;
    my $unix_time = defined $datestr ? _expire_calc($datestr) : time();

    my ($sec,$min,$hour,$mday,$mon,$year,$wday,$yday,$isdst) = gmtime ($unix_time);
    $year = $year + 1900;

    my $date = sprintf("%s, %02d$sep%s$sep%04d %02d:%02d:%02d GMT",
                    $WDAY[$wday],$mday,$MON[$mon],$year,$hour,$min,$sec);
    return $date;
}

sub _expire_calc {
# -------------------------------------------------------------------
# Calculates when a date based on +- times. See CGI.pm for more info.
#
    my $time = shift;
    my %mult = qw/s 1 m 60 h 3600 d 86400 M 2592000 y 31536000/;
    my $offset;

    if (! $time or (lc $time eq 'now')) {
        $offset = 0;
    }
    elsif ($time =~ /^\d+/) {
        return $time;
    }
    elsif ($time=~/^([+-]?(?:\d+|\d*\.\d*))([smhdMy]?)/) {
        $offset = ($mult{$2} || 1)*$1;
    }
    else {
        return $time;
    }
    return time() + $offset;
}

1;

}

BEGIN { $INC{"GT/MD5.pm"} = "GT/MD5.pm" }
{
# ==================================================================
# Gossamer Threads Module Library - http://gossamer-threads.com/
#
#   GT::MD5
#   Author: Scott Beck (see pod for details)
#   $Id: MD5.pm,v 1.17 2002/04/07 03:35:35 jagerman Exp $
#
# Copyright (c) 2000 Gossamer Threads Inc.  All Rights Reserved.
# See bottom for addition Copyrights.
# ==================================================================
#
# Description: This is an implementation of the MD5 algorithm in perl.
#

package GT::MD5; 
# ==================================================================
use strict;
use vars qw($VERSION @ISA @EXPORTER @EXPORT_OK $DATA);

@EXPORT_OK = qw(md5 md5_hex md5_base64);

@ISA = qw(Exporter);
$VERSION = sprintf "%d.%03d", q$Revision: 1.17 $ =~ /(\d+)\.(\d+)/;

$DATA = <<'END_OF_MODULE';
use integer;

# I-Vektor
sub A() { 0x67_45_23_01 }
sub B() { 0xef_cd_ab_89 }
sub C() { 0x98_ba_dc_fe }
sub D() { 0x10_32_54_76 }

# for internal use
sub MAX() { 0xFFFFFFFF }

@GT::MD5::DATA = split "\n", q|
FF,$a,$b,$c,$d,$_[4],7,0xd76aa478,/* 1 */
FF,$d,$a,$b,$c,$_[5],12,0xe8c7b756,/* 2 */
FF,$c,$d,$a,$b,$_[6],17,0x242070db,/* 3 */
FF,$b,$c,$d,$a,$_[7],22,0xc1bdceee,/* 4 */
FF,$a,$b,$c,$d,$_[8],7,0xf57c0faf,/* 5 */
FF,$d,$a,$b,$c,$_[9],12,0x4787c62a,/* 6 */
FF,$c,$d,$a,$b,$_[10],17,0xa8304613,/* 7 */
FF,$b,$c,$d,$a,$_[11],22,0xfd469501,/* 8 */
FF,$a,$b,$c,$d,$_[12],7,0x698098d8,/* 9 */
FF,$d,$a,$b,$c,$_[13],12,0x8b44f7af,/* 10 */
FF,$c,$d,$a,$b,$_[14],17,0xffff5bb1,/* 11 */
FF,$b,$c,$d,$a,$_[15],22,0x895cd7be,/* 12 */
FF,$a,$b,$c,$d,$_[16],7,0x6b901122,/* 13 */
FF,$d,$a,$b,$c,$_[17],12,0xfd987193,/* 14 */
FF,$c,$d,$a,$b,$_[18],17,0xa679438e,/* 15 */
FF,$b,$c,$d,$a,$_[19],22,0x49b40821,/* 16 */ 
GG,$a,$b,$c,$d,$_[5],5,0xf61e2562,/* 17 */
GG,$d,$a,$b,$c,$_[10],9,0xc040b340,/* 18 */
GG,$c,$d,$a,$b,$_[15],14,0x265e5a51,/* 19 */
GG,$b,$c,$d,$a,$_[4],20,0xe9b6c7aa,/* 20 */
GG,$a,$b,$c,$d,$_[9],5,0xd62f105d,/* 21 */
GG,$d,$a,$b,$c,$_[14],9,0x2441453,/* 22 */
GG,$c,$d,$a,$b,$_[19],14,0xd8a1e681,/* 23 */
GG,$b,$c,$d,$a,$_[8],20,0xe7d3fbc8,/* 24 */
GG,$a,$b,$c,$d,$_[13],5,0x21e1cde6,/* 25 */
GG,$d,$a,$b,$c,$_[18],9,0xc33707d6,/* 26 */
GG,$c,$d,$a,$b,$_[7],14,0xf4d50d87,/* 27 */
GG,$b,$c,$d,$a,$_[12],20,0x455a14ed,/* 28 */
GG,$a,$b,$c,$d,$_[17],5,0xa9e3e905,/* 29 */
GG,$d,$a,$b,$c,$_[6],9,0xfcefa3f8,/* 30 */
GG,$c,$d,$a,$b,$_[11],14,0x676f02d9,/* 31 */
GG,$b,$c,$d,$a,$_[16],20,0x8d2a4c8a,/* 32 */
HH,$a,$b,$c,$d,$_[9],4,0xfffa3942,/* 33 */
HH,$d,$a,$b,$c,$_[12],11,0x8771f681,/* 34 */
HH,$c,$d,$a,$b,$_[15],16,0x6d9d6122,/* 35 */
HH,$b,$c,$d,$a,$_[18],23,0xfde5380c,/* 36 */
HH,$a,$b,$c,$d,$_[5],4,0xa4beea44,/* 37 */
HH,$d,$a,$b,$c,$_[8],11,0x4bdecfa9,/* 38 */
HH,$c,$d,$a,$b,$_[11],16,0xf6bb4b60,/* 39 */
HH,$b,$c,$d,$a,$_[14],23,0xbebfbc70,/* 40 */
HH,$a,$b,$c,$d,$_[17],4,0x289b7ec6,/* 41 */
HH,$d,$a,$b,$c,$_[4],11,0xeaa127fa,/* 42 */
HH,$c,$d,$a,$b,$_[7],16,0xd4ef3085,/* 43 */
HH,$b,$c,$d,$a,$_[10],23,0x4881d05,/* 44 */
HH,$a,$b,$c,$d,$_[13],4,0xd9d4d039,/* 45 */
HH,$d,$a,$b,$c,$_[16],11,0xe6db99e5,/* 46 */
HH,$c,$d,$a,$b,$_[19],16,0x1fa27cf8,/* 47 */
HH,$b,$c,$d,$a,$_[6],23,0xc4ac5665,/* 48 */
II,$a,$b,$c,$d,$_[4],6,0xf4292244,/* 49 */
II,$d,$a,$b,$c,$_[11],10,0x432aff97,/* 50 */
II,$c,$d,$a,$b,$_[18],15,0xab9423a7,/* 51 */
II,$b,$c,$d,$a,$_[9],21,0xfc93a039,/* 52 */
II,$a,$b,$c,$d,$_[16],6,0x655b59c3,/* 53 */
II,$d,$a,$b,$c,$_[7],10,0x8f0ccc92,/* 54 */
II,$c,$d,$a,$b,$_[14],15,0xffeff47d,/* 55 */
II,$b,$c,$d,$a,$_[5],21,0x85845dd1,/* 56 */
II,$a,$b,$c,$d,$_[12],6,0x6fa87e4f,/* 57 */
II,$d,$a,$b,$c,$_[19],10,0xfe2ce6e0,/* 58 */
II,$c,$d,$a,$b,$_[10],15,0xa3014314,/* 59 */
II,$b,$c,$d,$a,$_[17],21,0x4e0811a1,/* 60 */
II,$a,$b,$c,$d,$_[8],6,0xf7537e82,/* 61 */
II,$d,$a,$b,$c,$_[15],10,0xbd3af235,/* 62 */
II,$c,$d,$a,$b,$_[6],15,0x2ad7d2bb,/* 63 */
II,$b,$c,$d,$a,$_[13],21,0xeb86d391,/* 64 */|;


# padd a message to a multiple of 64
sub padding($) {
    my $l = length (my $msg = shift() . chr(128));    
    $msg .= "\0" x (($l%64<=56?56:120)-$l%64);
    $l = ($l-1)*8;
    $msg .= pack 'VV', $l & MAX , ($l >> 16 >> 16);
}


sub rotate_left($$) {
	#$_[0] << $_[1] | $_[0] >> (32 - $_[1]);
	#my $right = $_[0] >> (32 - $_[1]);
	#my $rmask = (1 << $_[1]) - 1;
	($_[0] << $_[1]) | (( $_[0] >> (32 - $_[1])  )  & ((1 << $_[1]) - 1));
	#$_[0] << $_[1] | (($_[0]>> (32 - $_[1])) & (1 << (32 - $_[1])) - 1);
}

sub gen_code {
  # Discard upper 32 bits on 64 bit archs.
  my $MSK = ((1 << 16) << 16) ? ' & ' . MAX : '';
#	FF => "X0=rotate_left(((X1&X2)|(~X1&X3))+X0+X4+X6$MSK,X5)+X1$MSK;",
#	GG => "X0=rotate_left(((X1&X3)|(X2&(~X3)))+X0+X4+X6$MSK,X5)+X1$MSK;",
  my %f = (
	FF => "X0=rotate_left((X3^(X1&(X2^X3)))+X0+X4+X6$MSK,X5)+X1$MSK;",
	GG => "X0=rotate_left((X2^(X3&(X1^X2)))+X0+X4+X6$MSK,X5)+X1$MSK;",
	HH => "X0=rotate_left((X1^X2^X3)+X0+X4+X6$MSK,X5)+X1$MSK;",
	II => "X0=rotate_left((X2^(X1|(~X3)))+X0+X4+X6$MSK,X5)+X1$MSK;",
  );
  #unless ( (1 << 16) << 16) { %f = %{$CODES{'32bit'}} }
  #else { %f = %{$CODES{'64bit'}} }

  my %s = (  # shift lengths
	S11 => 7, S12 => 12, S13 => 17, S14 => 22, S21 => 5, S22 => 9, S23 => 14,
	S24 => 20, S31 => 4, S32 => 11, S33 => 16, S34 => 23, S41 => 6, S42 => 10,
	S43 => 15, S44 => 21
  );

  my $insert = "";
#  while(<DATA>) {
  for (@GT::MD5::DATA) {
#	chomp;
	next unless /^[FGHI]/;
	my ($func,@x) = split /,/;
	my $c = $f{$func};
	$c =~ s/X(\d)/$x[$1]/g;
	$c =~ s/(S\d{2})/$s{$1}/;
        $c =~ s/^(.*)=rotate_left\((.*),(.*)\)\+(.*)$//;

	#my $rotate = "(($2 << $3) || (($2 >> (32 - $3)) & (1 << $2) - 1)))"; 
	$c = "\$r = $2;
        $1 = ((\$r << $3) | ((\$r >> (32 - $3))  & ((1 << $3) - 1))) + $4";
	$insert .= "\t$c\n";
  }
  
  my $dump = '
  sub round {
	my ($a,$b,$c,$d) = @_[0 .. 3];
	my $r;

	' . $insert . '
	$_[0]+$a' . $MSK . ', $_[1]+$b ' . $MSK . 
        ', $_[2]+$c' . $MSK . ', $_[3]+$d' . $MSK . ';
  }';
  eval $dump;
  #print "$dump\n";
  #exit 0;
}

gen_code();


# object part of this module
sub new {
	my $class = shift;
	bless {}, ref($class) || $class;
}

sub reset {
	my $self = shift;
	delete $self->{data};
	$self
}

sub add(@) {
	my $self = shift;
	$self->{data} .= join'', @_;
	$self
}

sub addfile {
  	my ($self,$fh) = @_;
	if (!ref($fh) && ref(\$fh) ne "GLOB") {
	    require Symbol;
	    $fh = Symbol::qualify($fh, scalar caller);
	}
	$self->{data} .= do{local$/;<$fh>};
	$self
}

sub digest {
	md5(shift->{data})
}

sub hexdigest {
	md5_hex(shift->{data})
}

sub b64digest {
	md5_base64(shift->{data})
}

sub md5 {
	my $message = padding(join'',@_);
	my ($a,$b,$c,$d) = (A,B,C,D);
	my $i;
	for $i (0 .. (length $message)/64-1) {
		my @X = unpack 'V16', substr $message,$i*64,64;	
		($a,$b,$c,$d) = round($a,$b,$c,$d,@X);
	}
	pack 'V4',$a,$b,$c,$d;
}


sub md5_hex {
  unpack 'H*', &md5;
}

sub md5_base64 {
  encode_base64(&md5);
}


sub encode_base64 ($) {
    my $res;
    while ($_[0] =~ /(.{1,45})/gs) {
	$res .= substr pack('u', $1), 1;
	chop $res;
    }
    $res =~ tr|` -_|AA-Za-z0-9+/|;#`
    chop $res;chop $res;
    $res;
}
END_OF_MODULE

# Load either Digest::MD5 or GT::MD5 functions.
eval {
    local $SIG{__DIE__};
    require Digest::MD5;
    foreach (@EXPORT_OK) { delete $GT::MD5::{$_}; } # Do not remove.
    import Digest::MD5 (@EXPORT_OK);
    *GT::MD5::md5_hex = sub { &Digest::MD5::md5_hex };
    *GT::MD5::md5 = sub { &Digest::MD5::md5 };
    *GT::MD5::md5_base64 = sub { &Digest::MD5::md5_base64 };
    @ISA = 'Digest::MD5';
    1;
}
or do {
    local $@;
    eval $DATA;
    $@ and die "GT::MD5 => can't compile: $@";
};

require Exporter;
import Exporter;

1;



=head1 NAME

GT::MD5 - Perl implementation of Ron Rivests MD5 Algorithm.

=head1 DISCLAIMER

Majority of this module's code is borrowed from Digest::Perl::MD5 (Version 1.5).
This is B<not> an interface (like C<Digest::MD5>) but a Perl implementation of MD5.
It is written in perl only and because of this it is slow but it works without C-Code.
You should use C<Digest::MD5> instead of this module if it is available.
This module is only usefull for

=over 4

=item

computers where you cannot install C<Digest::MD5> (e.g. lack of a C-Compiler)

=item

encrypting only small amounts of data (less than one million bytes). I use it to
hash passwords.

=item

educational purposes

=back

=head1 SYNOPSIS

 # Functional style
 use Digest::MD5  qw(md5 md5_hex md5_base64);

 $hash = md5 $data;
 $hash = md5_hex $data;
 $hash = md5_base64 $data;
    

 # OO style
 use Digest::MD5;

 $ctx = Digest::MD5->new;

 $ctx->add($data);
 $ctx->addfile(*FILE);

 $digest = $ctx->digest;
 $digest = $ctx->hexdigest;
 $digest = $ctx->b64digest;

=head1 DESCRIPTION

This modules has the same interface as the much faster C<Digest::MD5>. So you can
easily exchange them, e.g.

	BEGIN {
	  eval {
	    require Digest::MD5;
	    import Digest::MD5 'md5_hex'
	  };
	  if ($@) { # ups, no Digest::MD5
	    require Digest::Perl::MD5;
	    import Digest::Perl::MD5 'md5_hex'
	  }		
	}

If the C<Digest::MD5> module is available it is used and if not you take
C<Digest::Perl::MD5>.

You can also install the Perl part of Digest::MD5 together with Digest::Perl::MD5
and use Digest::MD5 as normal, it falls back to Digest::Perl::MD5 if it
cannot load its object files.

For a detailed Documentation see the C<Digest::MD5> module.

=head1 EXAMPLES

The simplest way to use this library is to import the md5_hex()
function (or one of its cousins):

    use Digest::Perl::MD5 'md5_hex';
    print 'Digest is ', md5_hex('foobarbaz'), "\n";

The above example would print out the message

    Digest is 6df23dc03f9b54cc38a0fc1483df6e21

provided that the implementation is working correctly.  The same
checksum can also be calculated in OO style:

    use Digest::MD5;
    
    $md5 = Digest::MD5->new;
    $md5->add('foo', 'bar');
    $md5->add('baz');
    $digest = $md5->hexdigest;
    
    print "Digest is $digest\n";

=head1 LIMITATIONS

This implementation of the MD5 algorithm has some limitations:

=over 4

=item

It's slow, very slow. I've done my very best but Digest::MD5 is still about 135 times faster.
You can only encrypt Data up to one million bytes in an acceptable time. But it's very usefull
for encrypting small amounts of data like passwords.

=item

You can only encrypt up to 2^32 bits = 512 MB on 32bit archs. You should use C<Digest::MD5>
for those amounts of data.

=item

C<Digest::Perl::MD5> loads all data to encrypt into memory. This is a todo.

=back

=head1 SEE ALSO

L<Digest::MD5>

L<md5sum(1)>

RFC 1321

=head1 COPYRIGHT

This library is free software; you can redistribute it and/or
modify it under the same terms as Perl itself.

 Copyright 2000 Christian Lackas, Imperia Software Solutions
 Copyright 1998-1999 Gisle Aas.
 Copyright 1995-1996 Neil Winton.
 Copyright 1991-1992 RSA Data Security, Inc.

The MD5 algorithm is defined in RFC 1321. The basic C code
implementing the algorithm is derived from that in the RFC and is
covered by the following copyright:

=over 4

=item

Copyright (C) 1991-2, RSA Data Security, Inc. Created 1991. All
rights reserved.

License to copy and use this software is granted provided that it
is identified as the "RSA Data Security, Inc. MD5 Message-Digest
Algorithm" in all material mentioning or referencing this software
or this function.

License is also granted to make and use derivative works provided
that such works are identified as "derived from the RSA Data
Security, Inc. MD5 Message-Digest Algorithm" in all material
mentioning or referencing the derived work.

RSA Data Security, Inc. makes no representations concerning either
the merchantability of this software or the suitability of this
software for any particular purpose. It is provided "as is"
without express or implied warranty of any kind.

These notices must be retained in any copies of any part of this
documentation and/or software.

=back

This copyright does not prohibit distribution of any version of Perl
containing this extension under the terms of the GNU or Artistic
licenses.

=head1 AUTHORS

The original MD5 interface was written by Neil Winton
(C<N.Winton@axion.bt.co.uk>).

C<Digest::MD5> was made by Gisle Aas <gisle@aas.no> (I took his Interface
and part of the documentation)

Thanks to Guido Flohr for his 'use integer'-hint.

This release was made by Christian Lackas <delta@clackas.de>.

=cut

}

BEGIN { $INC{"GT/Installer.pm"} = "GT/Installer.pm" }
{
# ==================================================================
# Gossamer Threads Module Library - http://gossamer-threads.com/
#
#   GT::Installer
#   Author  : Scott Beck
#   $Id: Installer.pm,v 1.73 2002/05/31 22:33:32 alex Exp $
#
# Copyright (c) 2000 Gossamer Threads Inc.  All Rights Reserved.
# ==================================================================
#
# Description:
#   Handle GT product installs.
#

package GT::Installer; 
# ===============================================================

    use strict qw/vars refs/;
    use vars qw/
        @ISA
        $ERRORS
        $ATTRIBS
        $USE_LIB_SPACES
        $REMOVE_INSTALL
    /;

    $ATTRIBS = {
        install_to           => {},
        lite                 => 0,
        product              => undef,
        version              => undef,
        checksums            => undef,
        tar_checksum         => undef,
        untar_callback       => undef,
        load_defaults        => undef,
        load_config          => undef,
        save_config          => undef,
        prompts              => [],
        config               => {},
        defaults             => {},
        upgrade              => [],
        use_lib              => 'Admin Path',
        use_init             => undef,
        install_exit_message => undef,
        upgrade_exit_message => undef,
        checksum_regex       => '\.(?:pm|pl|cgi|html?)$',
        fixup_regex          => '\.(?:cgi|pl)$',
        initial_message      => [],
        welcome_format       => 'plain',
        header_format        => 'professional',
        perl_flags           => ''
    };

    $ERRORS = {
        REQUIRED   => "%s can not be left blank.",
        PATH       => "The path (%s) does not exist on this system",
        PATHWRITE  => "Unable to write to directory (%s). Reason: (%s)",
        PATHCREATE => "Unable to create directory (%s). Reason: (%s)",
        URLFMT     => "(%s) does not look like a URL",
        FTPFMT     => "(%s) does not look like and FTP URL",
        EMAILFMT   => "(%s) does not look like an email",
        SENDMAIL   => "The path (%s) does not exist on your system or is not executable",
        SMTP       => "(%s) is not a valid smtp server address",
        PERL      => "The path to perl you specified (%s) %s",
        DIREXISTS => "%s is not a directory but exists, unable to make a directory of that name",
    };
    $USE_LIB_SPACES = " " x 4;
    $REMOVE_INSTALL = 0;

    @ISA    = qw(GT::Base);
    import GT::MD5 qw/md5_hex/;

    sub CHECK_BYTES () { 10240 }

sub init {
    my $self = shift;

    for (keys %{$ERRORS}) {
        if (exists $GT::Installer::LANG{"ERR_$_"}) {
            $ERRORS->{$_} = $GT::Installer::LANG{"ERR_$_"};
        }
    }
    for (keys %{$GT::Tar::ERRORS}) {
        if (exists $GT::Installer::LANG{"TAR_$_"}) {
            $GT::Tar::ERRORS->{$_} = $GT::Installer::LANG{"TAR_$_"};
        }
    }

    $self->set(@_);
    $self->{is_cgi} = exists($ENV{REQUEST_METHOD});
    if ($self->{is_cgi}) {
        $self->{in} = new GT::CGI;
        if ($self->{in}->param('lite')) {
            $self->{lite} = 1;
        }
    }
    else {
        if (@ARGV and ($ARGV[0] eq '--lite')) {
            $self->{lite} = 1;
        }
    }
    return $self;
}

#################################################################
#                      User Prompt sets                         #
#################################################################
sub add_config {
# ---------------------------------------------------------------
# path, url, email
#
    my $self = shift;
    my $opts = $self->common_param(@_);
    $opts->{type}              or $self->error('BADARGS', 'FATAL', 'You must specify the type of prompt');

    if ($opts->{type} eq 'reg_number') {
        $opts->{message} ||= lang('enter_reg');
        defined($opts->{required}) or $opts->{required} = 0;
        $opts->{key}     ||= $opts->{message};
    }
    elsif ($opts->{type} eq 'email_support') {
        $opts->{message} ||= lang('enter_sendmail');
        $opts->{key}     ||= $opts->{message};
    }
    elsif ($opts->{type} eq 'perl_path') {
        $opts->{message} ||= lang('enter_perl');
        $opts->{key}     ||= $opts->{message};
    }
    elsif ($opts->{type} eq 'create_dirs') {
        $opts->{message} ||= lang('create_dirs');
        $opts->{key}     ||= $opts->{message};
    }
    defined($opts->{required}) or $opts->{required} = 1;
    $opts->{message} ||= $opts->{key};
    defined($opts->{key}) or $self->error('BADARGS', 'FATAL', 'You must specify what get\'s set');

    push @{$self->{prompts}}, $opts;
    return 1;
}

sub add_config_message {
# ---------------------------------------------------------------
# Add a configuration message.
#
    my ($self, $text, $format) = @_;
    defined($text) or $self->error('BADARGS', 'FATAL', 'You must specify the text for the message');
    $format ||= 'none';
    push @{$self->{prompts}}, {
        type    => 'message',
        message => $text,
        format  => $format,
    };
    return 1;
}

sub add_upgrade {
# ---------------------------------------------------------------
# Add an upgrade segment
#
    my $self = shift;
    my $opts = $self->common_param(@_);
    if (!$opts->{skip}) {
        $opts->{message} or $self->error('BADARGS', 'FATAL', 'You must specify the message to display');
        $opts->{format} ||= 'none';
        if (!defined($opts->{directory_list}) and !defined($opts->{file_list})) {
            $self->error('BADARGS', 'FATAL', 'You must specify one of file_list or directory_list');
        }
    }

    push @{$self->{upgrade}}, $opts;
    return 1;
}

sub initial_message {
# ---------------------------------------------------------------
# Add an upgrade message.
#
    my ($self, $text, $format) = @_;
    defined($text) or $self->error('BADARGS', 'FATAL', 'You must specify the text for the message');
    $format ||= 'none';
    $self->{initial_message}->[0] = $text;
    $self->{initial_message}->[1] = $format;
    return 1;
}

sub add_upgrade_message {
# ---------------------------------------------------------------
# Add an upgrade message.
#
    my ($self, $text, $format) = @_;
    defined($text) or $self->error('BADARGS', 'FATAL', 'You must specify the text for the message');
    $format ||= 'none';
    push @{$self->{upgrade}}, { 
        type    => 'message',
        message => $text,
        format  => $format,
    };
    return 1;
}

sub install_to {
# ---------------------------------------------------------------
# Map regexs to path for installation.
#
    my $self = shift;
    my $opts = $self->common_param(@_) or return $self->{install_to};
    $self->{install_to} = $opts;
}

sub perform {
# ---------------------------------------------------------------
# Where it all begins. Should be called at the end of the main
# configuration routine.
#
    my ($self) = @_;

    $REMOVE_INSTALL = 0;

# Make sure we are in our current directory.
    my $pwd = $self->find_cgi;
    chdir ($pwd) if ($pwd);

# Set our sig handler to trap fatals, the 1 tells the sig handler
# not to exit.
    $SIG{__DIE__} = sub { $self->disp_error(shift, 1); };

# Check perl version > 5.004_04
    my $ver = eval "require 5.00404; 1;";
    if (! $ver) {
        $self->disp_error(lang('install_version', "$["));
    }

# First we check to see that the tar file macthes the checksum if
# there is a checksum
    if ($self->{tar_checksum}) {
        unless ($self->{lite}) {
            my $checksum = $self->get_checksum('./install.dat');
            if ($self->{tar_checksum} ne $checksum) {
                $self->disp_error(lang('install_currupted'));
            }
        }
    }
    if ($self->{is_cgi}) {
        $self->cgi_sequence;
    }
    else {
        $self->telnet_sequence;
        $REMOVE_INSTALL = 1;
    }
# Remove the files.
    if ($REMOVE_INSTALL) {
        unlink("install.dat");
        unlink("install.cgi");
    }
}

sub get_checksum {
# ---------------------------------------------------------------
# Given a path to the install.dat tar file returns a checksum
# of the first x bytes, where x is the constant CHECK_BYTES
#
    my ($self, $path) = @_;

    open FH, $path or $self->error('READOPEN', 'FATAL', $path, "$!");
    binmode FH;
    read(FH, my $buff, CHECK_BYTES);
    close FH;
    return md5_hex($buff);
}

sub disp_error {
# ---------------------------------------------------------------
# Displays the message passed in based on telnet or cgi and exits
#
    my ($self, $msg, $no_exit) = @_;
    if ($self->{is_cgi}) {
        print $self->{in}->header;
        $self->cgi_error($msg);
    }
    else {
        $self->telnet_error($msg);
    }
    exit unless ($no_exit);
}

sub cgi_sequence {
# ---------------------------------------------------------------
# Called internally if we are ran as a CGI.
#
    my ($self) = @_;

    print $self->{in}->header;
    if ($self->{in}->param('upgrade_choice')) {
        if ($self->{in}->param('upgrade_choice') eq 'Yes') {
            $self->{in}->param('install_dir') or return $self->cgi_first_screen(lang('admin_path_error'));
            $self->{config}->{GT_ADMIN_PATH} = $self->{in}->param('install_dir');
            $self->{upgrading} = 1;
            $self->{load_config}->($self) or return $self->cgi_first_screen($GT::Installer::error);
            $self->cgi_upgrade_first_screen;
        }
        else {
            $self->{installing} = 1;
            $self->{load_defaults}->($self);
            $self->cgi_install_first_screen;
        }
    }
    elsif ($self->{in}->param('upgrade_second')) {
        $self->{upgrading} = 1;
        $self->{config}->{GT_ADMIN_PATH} = $self->{in}->param('install_dir');
        $self->{load_config}->($self) or return $self->cgi_upgrade_first_screen($GT::Installer::error);
        $self->cgi_upgrade_second_screen;
    }
    elsif ($self->{in}->param('install')) {
        $self->{installing} = 1;
        $self->{load_defaults}->($self);
        $self->cgi_install_second_screen;
    }
    else {
        $self->cgi_first_screen;
    }
}

sub telnet_sequence {
# -------------------------------------------------------------------
# Initial telnet prompt
#
    my ($self) = @_;

    eval {
        local $SIG{__DIE__};
        require Term::ReadLine;
        $self->{term} = Term::ReadLine->new('');
        $self->{term}->ornaments("aa,bb,cc,dd");
        *STDOUT = $self->out;
    };
    local $: = "\n ";
    $self->print(lang('intro', $self->{product}), $self->{header_format});
    $self->print(lang('welcome', $self->{product}, $self->{product}), $self->{welcome_format});

    $self->print(@{$self->{initial_message}}) if @{$self->{initial_message}};
    my $res = $self->telnet_prompt(lang('is_upgrade'), "No", ['^Y(?:es)?$', '^No?$']);
    if (lc($res) =~ /^y/) {
        $self->load_cache;
        $self->{config}->{GT_ADMIN_PATH} = $self->telnet_prompt(lang('enter_admin_path'), $self->{defaults}->{GT_ADMIN_PATH} );
        $self->save_cache;
        $self->{upgrading} = 1;
        if ($self->{load_config}) {
            $self->{load_config}->($self) or return $self->disp_error ($GT::Installer::error);
        }
        $self->telnet_upgrade;
    }
    else {
        $self->{installing} = 1;
        if ($self->{load_defaults}) {
            $self->{load_defaults}->($self) or return $self->disp_error ($GT::Installer::error);
        }
        $self->telnet_install;
    }
}

sub install {
# -------------------------------------------------------------------
# Install the program.
#
    my ($self) = @_;

    $self->{tar} = $self->_get_tar();
    my $files = $self->{tar}->files;

    $self->{untar_callback}->($self) if $self->{untar_callback};
    my %checksums;
    foreach my $file (@{$files}) {
        my $name = $file->name;
        my $mode = substr (sprintf ("%lo", $file->mode), -3);
        my $type = $file->type;
        my $body = $file->body_as_string if $type == GT::Tar::FILE;
        foreach my $regex (keys %{$self->{install_to}}) {
            if ($name =~ /$regex/) {
                my $filename = $1;
                $file->name($self->{config}->{$self->{install_to}->{$regex}} . '/' . $filename);
                $self->_fixup_body($file, \$body) if ($filename =~ /(?:mod_perl\.pm|\.cgi|\.pl)$/ and $type == GT::Tar::FILE);
                last;
            }
        }

# Get a checksum if the it is a file and it matches
# the files we need to checksum.
        if ($type == GT::Tar::FILE) {
            if ($name =~ /$self->{checksum_regex}/) {
                $checksums{$name} = md5_hex($body) unless ($self->{lite});
            }
        }
# Don't chown the file.
        $file->set_owner(0);

# Untar the file
        print lang('unarchiving'), " ($mode) ", $file->name, "\n" if $type == GT::Tar::FILE;
        $file->write or print $GT::Tar::error;
    }
    unless ($self->{lite}) {
        if ($self->{checksums}) {
            for (keys %{$self->{config}}) { $self->{checksums} =~ s/<%\Q$_\E%>/$self->{config}->{$_}/g }
            $self->recurse_mkdir($self->{checksum});
            my $fh = \do{ local *FH; *FH };
            if (open $fh, ">$self->{checksums}") {
                print {$fh} GT::Dumper->dump_structure (\%checksums);
            }
            else {
                $self->print(lang('err_writeopen', $self->{checksums}, $!), 'none');
            }
        }
    }
    if ($self->{save_config}) {
        $self->{save_config}->($self) or return $self->disp_error ($GT::Installer::error);
    }
    return 1;
}

sub _fixup_body {
# -------------------------------------------------------------------
# Called internally to set the path to perl and the use lib line.
#
    my ($self, $file, $body) = @_;
    if ($self->{config}->{"Path to Perl"}) {
        if ($self->{perl_flags}) {
            $$body =~ s/^#![^\n\r]+\r?\n/#!$self->{config}->{"Path to Perl"} $self->{perl_flags}\n/;
        }
        else {
            $$body =~ s/^#![^\n\r]+\r?\n/#!$self->{config}->{"Path to Perl"}\n/;
        }
    }
    if ($self->{use_lib}) {
        for (keys %{$self->{config}}) { $self->{use_lib} =~ s/<%\Q$_\E%>/$self->{config}->{$_}/g }
        my $lib = $self->{use_lib};
        if (! ($$body =~ s/^\s*use\s*lib.+/${USE_LIB_SPACES}use lib '$lib';/m)) {
            $$body =~ s/(\s*use )/\n${USE_LIB_SPACES}use lib '$lib';\n$1/;
        }
    }
    if ($self->{use_init}) {
        my ($find, $replace) = @{$self->{use_init}};
        for (keys %{$self->{config}}) { $replace =~ s/<%\Q$_\E%>/$self->{config}->{$_}/g }
        $find  = $find . '::init';
        $$body =~ s/$find\(([^\)]*)\)/$find('$replace')/g;
    }
    $file->body($$body);
}

sub upgrade {
# -------------------------------------------------------------------
# Performs an upgrade.
#
    my ($self) = @_;

    $self->{tar} = $self->_get_tar();
    my $files = $self->{tar}->files;

    $self->{untar_callback}->($self) if $self->{untar_callback};
    my ($old_checksums, $new_checksums);

# Find the checksum file
    if ($self->{checksums}) {
        for (keys %{$self->{config}}) { $self->{checksums} =~ s/<%\Q$_\E%>/$self->{config}->{$_}/g }
    }
    if (-e $self->{checksums}) {
        $old_checksums = do $self->{checksums};
    }
    FILE: foreach my $file (@{$files}) {
        my $name = $file->name;
        my $mode = substr (sprintf ("%lo", $file->mode), -3);
        my $type = $file->type;
        my $filename;
        foreach my $regex (keys %{$self->{install_to}}) {
            if ($name =~ /$regex/) {
                $filename = $1;
                $file->name($self->{config}->{$self->{install_to}->{$regex}} . '/' . $filename);
                last;
            }
        }

# Get a checksum if the it is a file and it matches
# the files we need to checksum. We need a checksum
# file for this as well.
        my $path = $file->name;
        CHECK: foreach my $rec (@{$self->{upgrade}}) {
            if ($rec->{skip} and ref($rec->{skip}) eq 'ARRAY' and @{$rec->{skip}}) {
                for (@{$rec->{skip}}) {
                    if ($name =~ /$_/) {
                        if (-e $path) {
                            print lang('skipping_file', $path);                        
                            next FILE;
                        }
                    }
                }
            }
            elsif ($rec->{skip} and !ref($rec->{skip})) {
                if ($name =~ /$rec->{skip}/) {
                    if (-e $path) {
                        print lang('skipping_file', $path);
                        next FILE;
                    }
                }
            }
        }
        if ($type == GT::Tar::FILE) {
            my $body = $file->body_as_string;
            $self->_fixup_body($file, \$body) if ($filename =~ /$self->{fixup_regex}/);
            
            unless ($self->{lite}) {
                if ($filename and $filename =~ /$self->{checksum_regex}/) {
                    if ($old_checksums and $old_checksums->{$name}) {
                        $self->_check_upgrade_files($old_checksums->{$name}, $path);
                    }
                    $new_checksums->{$name} = md5_hex($body);
                }
            }
        }

# Untar the file
        print lang('unarchiving'), " ($mode) $path\n" if $type == GT::Tar::FILE;
        $file->write or print $GT::Tar::error;
        $file->body('');
    }
    if (! $self->{lite} and $self->{checksums}) {
        for (keys %{$self->{config}}) { $self->{checksums} =~ s/<%\Q$_\E%>/$self->{config}->{$_}/g }
        $self->recurse_mkdir($self->{checksums});
        my $fh = \do{ local *FH; *FH };
        if (open $fh, ">$self->{checksums}") {
            print {$fh} GT::Dumper->dump(var => '', data => $new_checksums);
        }
        else {
            $self->print(lang('err_writeopen', $self->{checksums}, $!), 'none');
        }
    }
    if ($self->{save_config}) {
        $self->{save_config}->($self) or return $self->disp_error ($GT::Installer::error);
    }
    return 1;
}

sub _check_upgrade_files {
# -------------------------------------------------------------------
# Called internally to see what we should do with a file that matched
# an upgrade regex or path.
#
    my ($self, $checksum1, $path) = @_;
    my $fh = \do{ local *FH; *FH };
    open($fh, "< $path") or return;
    read($fh, my $buff, -s $fh);
    my $checksum2 = md5_hex($buff);
    if ($checksum1 ne $checksum2) {
        print lang('backing_up_file', $path); 
        my $backup = "$path.bak";
        if (-e $backup) {
            my $i = 0;
            $backup = "$path$i.bak";
            until (!-e "$path$i.bak") {
                $i++;
                $backup = "$path$i.bak";
            }
        }
        rename($path, $backup) or print lang('err_rename', $path, $backup, $!);
    }
}

sub _get_tar {
# -------------------------------------------------------------------
# Does all error checking on tar open and returns the tar file 
# object.
#
    my ($self) = @_;
    $GT::Tar::error ||= ''; #silence -w
    my $tar = GT::Tar->open ('install.dat');
    if (!$tar) {
        if ($GT::Tar::errcode eq 'CHECKSUM') {
            $self->print(lang('install_currupted'), 'none');
        }
        elsif ($GT::Tar::errcode eq 'OPEN') {
            $self->print(lang('err_opentar', $GT::Tar::error), 'none');
        }
        else {
            $self->print(lang('err_opentar_unknown', $GT::Tar::error), 'none');
        }
        exit;
    }
    return $tar;
}

sub format_validate {
# ---------------------------------------------------------------
# Formats and validates a specific kind of input. Takes the name
# of the field as the first argument and the value entered as the
# second argument. Returns false if valudation fails, returns the 
# formated return otherwise. If a last true argument is specified
# this method will return undef if path types does not pass -e
#
#
    my ($self, $set) = @_;
    $set ||= '';
    my $path_test;

    if ($self->{config}->{create_dirs}) {
        $path_test = 1;
    }
    
# First we need to look the record up for this set.
    my $rec;
    for (@{$self->{prompts}}) {
        next unless (ref($_) eq 'HASH');
        next unless ($_->{key});
        if ($set eq $_->{key}) {
            $rec = $_;
            last;
        }
    }
    (my $value = $self->{config}->{$rec->{key}}) =~ s/\r?\n//g;

# No value specified
    if (!$value) {
        if ($rec->{required}) {
            return $self->error('REQUIRED', 'WARN', $rec->{key});
        }
        $value = '';
    }

# Path type
    elsif ($rec->{type} eq 'path') {
        $value =~ s,/$,,;
        if ($path_test and !-e $value) {
            return $self->error('PATH', 'WARN', $value);
        }
        else {
            $self->recurse_mkdir("$value/") or return;
            if (! -e "$value/") {
                return $self->error('PATHCREATE', 'WARN', $value, "$!");
            }
            open (TEST, "> $value/tmp.txt") or return $self->error('PATHWRITE', 'WARN', $value, "$!");
            close TEST;
            unlink "$value/tmp.txt";
        }
    }

# URL type
    elsif ($rec->{type} eq 'url') {
        if ($value !~ m,^https?://.+,) {
            return $self->error('URLFMT', 'WARN', $value);
        }
        $value =~ s,/$,,;
    }

# FTP type
    elsif ($rec->{type} eq 'ftp') {
        if ($value !~ m,^ftp://.+,) {
            return $self->error('FTPFMT', 'WARN', $value);
        }
        $value =~ s,/$,,;
    }

# email type
    elsif ($rec->{type} eq 'email') {
        if ($value !~ /.+\@.+\..+/) {
            return $self->error('EMAILFMT', 'WARN', $value);
        }
    }

# Reg num type
    elsif ($rec->{type} eq 'reg_number') {
    # FIXME: What to test here
    }
    elsif ($rec->{type} eq 'email_support') {

# Check the SMTP/Sendmail settings.
        if ($value =~ m,^/,) {
            if (! -x $value) {
                return $self->error('SENDMAIL', 'WARN', $value);
            }
            $self->{config}->{email_support} = 'sendmail';
        }
        # FIXME: Should I try and open a socket to this or atleast resolve the hostname?
        elsif ($value !~ /^[A-Za-z0-9\.\-]+$/) {
            return $self->error('SMTP', 'WARN', $value);
        }
        else {
            $self->{config}->{email_support} = 'smtp';
        }
    }

# Path to perl set
    elsif ($rec->{type} eq 'perl_path') {
        if (! -e $value) {
            return $self->error('PERL', 'WARN', $value, 'does not exist');
        }
        elsif (! -x _) {
            return $self->error('PERL', 'WARN', $value, 'is not executable');
        }
    }
    $self->{config}->{$rec->{key}} = $value;
    return 1;
}

#################################################################
#                 Upgrade/Install Telnet Prompts                #
#################################################################
sub telnet_upgrade {
# -------------------------------------------------------------------
# Performs a telnet upgrade.
#
    my ($self) = @_;
    PROMPTS: foreach my $rec (@{$self->{upgrade}}) {
        next if $rec->{skip};
        if ($rec->{type} eq 'message') {
            $self->print($rec->{message}, $rec->{format});
        }
        else {
            $self->print($rec->{message}, $rec->{format});
            $rec->{answer} = $self->telnet_prompt("Overwrite/Skip/Backup", 'Backup', ['^O(?:verwrite)?$', '^S(?:kip)?$', '^B(?:ackup)?$']);
        }
        if ($rec->{telnet_callback} and ref($rec->{telnet_callback}) eq 'CODE') {
            $rec->{telnet_callback}->($self) or redo PROMPTS;
        }
    }
    $self->print(lang('we_have_it'), 'none');
    foreach my $rec (@{$self->{upgrade}}) {
        next if $rec->{type} eq 'message';
        next if not defined $self->{config}->{$rec->{key}} or not length $self->{config}->{$rec->{key}};
        local ($a, $b) = ($rec->{key},   $self->{config}->{$rec->{key}});
        local $~ = "FORMAT_VARS";
        write;
    }
    $self->telnet_prompt(lang('enter_starts'));

    $self->print(lang('now_unarchiving', $self->{product}), 'none');

# Do the upgrade
    $self->upgrade;
    $self->print(lang('upgrade_done', $self->{product}, $self->{version}), 'none');
    my $print;
    my $msg = $self->{upgrade_exit_message};
    if (ref $msg eq 'CODE') {
        $print = $msg->($self);
    }
    else {
        $print = $msg;
    }
    for (keys %{$self->{config}}) { $print =~ s/<%\Q$_\E%>/$self->{config}->{$_}/g }
    $self->print($print, 'none') if $print;
    $self->print("Gossamer Threads Inc.\n\n", 'none');
}

sub telnet_install {
# -------------------------------------------------------------------
# Performs a telnet install
#
    my ($self) = @_;

    local $_;
    PROMPTS: foreach my $rec (@{$self->{prompts}}) {
        if ($rec->{type} eq 'message') {
            $self->print($rec->{message}, $rec->{format});
        }
        elsif ($rec->{type} eq 'create_dirs') {
            $self->{config}->{create_dirs} = ($self->telnet_prompt(lang('is_upgrade'), "No", ['^Y(?:es)?$', '^No?$']) =~ /^y/);
        }
        else {
            $self->load_cache;
            $self->telnet_prompt($rec->{message}, $self->{defaults}->{$rec->{key}}, $rec);
            $self->save_cache;
        }
        if ($rec->{telnet_callback} and ref($rec->{telnet_callback}) eq 'CODE') {
            $rec->{telnet_callback}->($self) or redo PROMPTS;
        }
    }
    $self->print(lang('we_have_it'), 'none');
    foreach my $rec (@{$self->{prompts}}) {
        next if $rec->{type} eq 'message';
        next if not defined $self->{config}->{$rec->{key}} or not length $self->{config}->{$rec->{key}};
        ($a, $b) = ($rec->{key},   $self->{config}->{$rec->{key}});
        local $~ = "FORMAT_VARS";
        write;
    }
    $self->telnet_prompt(lang('enter_starts'));
    $self->print(lang('now_unarchiving', $self->{product}), 'none');

# Do the install
    $self->install;
    $self->print(lang('install_done', $self->{product}), 'none');
    my $print;
    my $msg = $self->{install_exit_message};
    if (ref $msg eq 'CODE') {
        $print = $msg->($self);
    }
    else {
        $print = $msg;
    }
    for (keys %{$self->{config}}) { $print =~ s/<%\Q$_\E%>/$self->{config}->{$_}/g }
    $self->print($print, 'none') if defined $print;
    $self->print("\nGossamer Threads Inc.\n\n", 'none');
}

sub telnet_prompt {
# -------------------------------------------------------------------
# Prompts the user.
#
    my ($self, $question, $default, $rec) = @_;
    $question =~ s/<[^>]+>//g;
    my ($response, $out);

    while (1) {
        if (defined($default)) {
            $out = "$question [$default]: ";
        }
        else {
            $out = "$question: ";
        }
        $response = $self->getline($out);
        $response =~ s/\r?\n//;
        $response =~ s/^\s*//;
        $response =~ s/\s*$//;
        if ($default and ($response =~ /^\s*$/)) {
            $self->{term} and $self->{term}->addhistory($default);
            $response = $default;
        }
        if ($response eq 'exit' or $response eq 'quit' or $response eq '\q') {
            exit;
        }

        if (!defined($default) and !defined($response)) {
            print "\n$question: ";
            next;
        }
        if ($rec and ref($rec) eq 'HASH') {
            $self->{config}->{$rec->{key}} = $response;
            if (!$self->format_validate($rec->{key})) {
                $self->print("\n$GT::Installer::error\n", 'none');
                next;
            }
            else {
                last;
            }
        }
        elsif ($rec and ref($rec) eq 'ARRAY') {
            my $match;
            for (@{$rec}) {
                if ($response =~ /$_/i) {
                    $match = 1;
                    last;
                }
            }
            if (!$match) {
                $self->print(lang('invalid_responce', $response), 'none');
                next;
            }
        }
        last;
    }
    return $response;
}

sub telnet_error {
    my ($self, $msg) = @_;
    $self->print(lang('telnet_err', $msg), 'none');
}

sub print {
# -------------------------------------------------------------------
# print wrapper for telnet install.
#
    my ($self, $msg, $format) = @_;
    $format ||= 'none';
    if ($self->{is_cgi})   { return print $msg; }
    $msg =~ s/<[^>]+>//g;
    if ($format eq 'none') { return print $msg; }
    $msg = $self->linewrap(62, \$msg);
    local $_ = $msg;
    local $~ = $format;
    return write;
}

sub out {
# -------------------------------------------------------------------
# See what our output filehandle is if we are ran from telnet. It
# seems that some term functions need to have output sent to a 
# specific handle.
#
    my ($self) = @_;
    return $self->{term} ? ($self->{term}->OUT || *STDOUT) : *STDOUT;
}

sub getline {
# -------------------------------------------------------------------
# Getline function for telnet installes.
#
    my ($self, $msg) = @_;
    my $ret;
    if ($self->{term}) {
        $ret = $self->{term}->readline($msg || '');
    }
    else {
        $ret = <STDIN>;
    }
    return $ret;
}

sub save_cache {
# -------------------------------------------------------------------
# Saves the config cache for telnet installs.
#
    my ($self) = @_;

    my $defaults = do 'config.cache';
    $defaults ||= {};
    foreach my $key (keys %{$self->{config}}) {
        $defaults->{$key} = $self->{config}->{$key} || $self->{defaults}->{$key} || undef;
    }
    my $data = GT::Dumper->dump ( data => $defaults, var => '' );
    open (CFG, ">config.cache") or return;
    print CFG $data;
    close CFG;

    return 1;
}

sub load_cache {
# -------------------------------------------------------------------
# Loads the config cache for telnet installes.
#
    my ($self) = @_;

    my $defaults = do 'config.cache';
    return unless $defaults;
    for my $key (keys %{$defaults}) {
        $self->{defaults}->{$key} = $defaults->{$key};
    }
    return 1;
}

#################################################################
#                             Formats                           #
#################################################################
# -------------------------------------------------------------------
# Format used to print final output of all vars right before unter
# happens in telnet.
#
format FORMAT_VARS = 
  @>>>>>>>>>>>>>>>>>>>>>>>>> : @<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
                         $a,   $b
.

# -------------------------------------------------------------------
# Pretty scroll to put messages in in telnet.
#
format scroll1 =
 _________________________________________________________________
/\                                                                \
\_|                                                                |
  | @<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< |~~
    munch($_)
  |  ______________________________________________________________|_
  \_/_______________________________________________________________/

.

# -------------------------------------------------------------------
# Pretty scroll to put messages in in telnet.
#
format scroll2 =
@<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
" __^__                                                                __^__"
@<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
"( ___ )--------------------------------------------------------------( ___ )"
 | / | @<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< | \ |~~
       munch($_)
 |___|                                                                |___|
(_____)--------------------------------------------------------------(_____)

.

# -------------------------------------------------------------------
# More professional format for message output in telnet.
#
format professional =
@<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
"#================================================================#"
| @<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< |~~
   munch($_)
@<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
"#================================================================#"
.

# -------------------------------------------------------------------
# Empty format mainly to wrape text properly
#
format plain =

@<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<~~
munch($_)

.

# -------------------------------------------------------------------
# Empty format mainly to wrape text properly
#
format plain_nolines =
@<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<~~
munch($_)
.

sub munch {
# -------------------------------------------------------------------
# Used to eat lines for proper formatting in the format fields 
# above.
#
    return '' unless length($_[0]) and defined($_[0]);
    my $idx = index($_[0], "\n");
    if ($idx == -1) {
        my $cp = $_[0];
        $_[0] = '';
        return $cp;
    }
    elsif ($idx == 0) {
        substr($_[0], 0, 1) = '';
        return ' ';
    }
    my $ret = substr($_[0], 0, $idx + 1);
    substr($_[0], 0, $idx + 1) = '';
    return $ret;
}

#################################################################
#                   Upgrade/Install HTML Prompts                #
#################################################################
sub cgi_first_screen {
# -------------------------------------------------------------------
# Initial screen displayed for cgi install/upgrade
#
    my ($self, $msg) = @_;
    $msg ||= '';
    my $path = $self->{in}->param('install_dir') || '';
    my $msg_formatted = $msg ? qq~<p><font face="Tahoma,Arial,Helvetica" size="2" color=red>$msg</font>~ : '';
    my $message = <<END_OF_MSG if @{$self->{initial_message}};
    <tr>
      <td colspan="2"><font face="Tahoma,Arial,Helvetica" size="2">
        $self->{initial_message}->[0]
    </tr>
END_OF_MSG
    $message ||= '';
    my $template = 'first_screen';
    simple_parse($template, {
        product => $self->{product},
        path    => $path,
        version => $self->{version},
        error   => $msg_formatted,
        message => $message,
        lite    => $self->{lite}
    });
    print $template;
}

sub simple_parse {
    my $t = uc $_[0];
    $_[0] = $GT::Installer::LANG{$t};
    $_[0] =~ s/<%\s*(.*?)\s*%>/
        my $tag = $1;
        if (exists $_[1]->{$tag}) {
            $_[1]->{$tag};
        }
        else {
            '';
        }
    /seg;
}

sub cgi_upgrade_first_screen {
# -------------------------------------------------------------------
# Initial screen for cgi upgrade
#
    my ($self, $msg) = @_;
    $msg ||= '';
    my $msg_formatted = $msg ? qq~<p><font face="Tahoma,Arial,Helvetica" size="2" color=red>$msg</font>~ : '';

# Make the form based on self->{upgrade}
    my $upgrade_form = '';
    my @rows = @{$self->{upgrade}};
    my $i = 0;
    foreach my $row (@rows) {
        next if $row->{skip};
        if ($row->{type} and $row->{type} eq 'message') {
            $upgrade_form .= <<END_OF_HTML;
    <tr>
      <td colspan="2"><font face="Tahoma,Arial,Helvetica" size="2">
         $row->{message}
      </font></td>
    </tr>
END_OF_HTML
        }
        else {
            my ($overwrite, $backup, $skip) = (lang('overwrite'), lang('backup'), lang('skip'));
            $upgrade_form .= <<END_OF_HTML;
    <tr>
      <td><font face="Tahoma,Arial,Helvetica" size="2">
        $row->{message}
      </font></td>
      <td><font face="Tahoma,Arial,Helvetica" size="2">
        <select name="$i"><option value="o">$overwrite</option><option value="b" selected>$backup</option><option value="s">$skip</option></select>
      </font></td>
    </tr>
END_OF_HTML
            $i++;
        }
    }
    my $template = 'upgrade_first_screen';
    simple_parse($template, {
        product       => $self->{product},
        version       => $self->{version},
        error         => $msg_formatted,
        upgrade_form  => $upgrade_form,
        GT_ADMIN_PATH => $self->{config}->{GT_ADMIN_PATH},
        lite          => $self->{lite}
    });
    print $template
}

sub cgi_upgrade_second_screen {
# -------------------------------------------------------------------
# Third screen for cgi upgrade.
# Sets the user overwrite/skip/backup options and performs the 
# upgrade.
#
    my ($self) = @_;


    my $template = 'upgrade_second_screen_first';
    simple_parse($template, {
        version => $self->{version},
        product => $self->{product}
    });
    print $template;

# Do the upgrade, This method prints as it goes
    my $i = 0;
    foreach my $rec (@{$self->{upgrade}}) {
        next if $rec->{skip};
        next if ($rec->{type} and $rec->{type} eq 'message');
        if ($self->{in}->param($i)) {
            $rec->{answer} = $self->{in}->param($i);
        }
        else {
            $rec->{answer} = 'b';
        }
        $i++;
    }
    $self->upgrade;
    my $msg;
    if (-e 'install.cgi') {
        $msg = lang('install_warning');
    }
    else {
        $msg = lang('install_removed');
    }

# Anything left in the upgrade array should be a message
    my $msg2 = $self->{upgrade_exit_message};
    my $print;
    if (ref $msg2 eq 'CODE') {
        $print = $msg2->($self);
    }
    else {
        $print = $msg2;
    }
    for (keys %{$self->{config}}) { $print =~ s/<%\Q$_\E%>/$self->{config}->{$_}/g }
    $template = 'upgrade_second_screen_second';
    simple_parse($template, {
        install_message => $msg,
        message         => $print,
        version         => $self->{version},
        product         => $self->{product},
        lite            => $self->{lite},
    });
    print $template;
    print "<!-- GTINST: done -->";
    $REMOVE_INSTALL = 1;
}

sub cgi_install_first_screen {
# -------------------------------------------------------------------
# Initial screen for cgi install
# Prompts for programmer defined config options.
#
    my ($self, $msg) = @_;
    $msg ||= '';
    my $msg_formatted = $msg ? qq~<p><font face="Tahoma,Arial,Helvetica" size="2" color=red>$msg</font>~ : '';

    my @rows = @{$self->{prompts}};
    my $rows = '';
    for my $row (@rows) {
         $rows .= $self->_html_field($row);
    }
    my $template = 'install_first_screen';
    simple_parse($template, {
        version => $self->{version},
        product => $self->{product},
        error   => $msg_formatted,
        form    => $rows,
        lite    => $self->{lite}
    });
    print $template;
    if ($msg) {
        my $raw = $msg;
        $raw =~ s,^\s*<li>,,;
        $raw =~ s/<li>/,/g;
        $raw =~ s/<.*?>//g;
        print "<!-- GTERR: [$raw] -->";
    }
}

sub cgi_install_second_screen {
# -------------------------------------------------------------------
# Second screen for cgi install.
# Validates form input and performs the install.
#
    my ($self) = @_;
    
    my @errors;
    foreach my $rec (@{$self->{prompts}}) {
        next if ($rec->{type} and $rec->{type} eq 'message');
        if ($rec->{type} eq 'create_dirs') {
            $self->{config}->{create_dirs} = defined $self->{in}->param('create_dirs');
            next;
        }
        $self->{config}->{$rec->{key}} = $self->{in}->param($rec->{key});
        if (!$self->format_validate($rec->{key})) {
            push @errors, $GT::Installer::error;
        }
    }
    @errors and return $self->cgi_install_first_screen('<ul><li>' . join("<li></li>", @errors) . '</li></ul>');

# Print the header.
    my $template = 'install_second_screen_first';
    simple_parse($template, {
        version => $self->{version},
        product => $self->{product},
        lite    => $self->{lite},
    });
    print $template;


# Do the upgrade, This method prints as it goes
    $self->install;

    my $msg;
    if (-e 'install.cgi') {
        $msg = lang('install_warning');
    }
    else {
        $msg = lang('install_removed');
    }
    my $msg2 = $self->{install_exit_message};
    my $print;
    if (ref $msg eq 'CODE') {
        $print = $msg2->($self);
    }
    else {
        $print = $msg2;
    }
    for (keys %{$self->{config}}) { $print =~ s/<%\Q$_\E%>/$self->{config}->{$_}/g }
    $template = 'install_second_screen_second';
    simple_parse($template, {
        install_message => $msg,
        message         => $print,
        version         => $self->{version},
        product         => $self->{product},
        lite            => $self->{lite}
    });
    print $template;
    print "<!-- GTINST: done -->";

    $REMOVE_INSTALL = 1;
}

sub cgi_error {
    my ($self, $msg) = @_;
    $msg ||= '';
    my $msg_formatted = $msg ? qq~<p><font face="Tahoma,Arial,Helvetica" size="2" color=red>$msg</font>~ : '';
    my $template = 'cgi_error_screen';
    simple_parse($template, {
        error   => $msg_formatted,
        version => $self->{version},
        product => $self->{product},
        lite    => $self->{lite}
    });
    print $template;
    if ($msg) {
        my $raw = $msg;
        $raw =~ s,^\s*<li>,,;
        $raw =~ s/<li>/,/g;
        $raw =~ s/<.*?>//g;
        print "<!-- GTERR: [$raw] -->";
    }
}

sub _html_field {
# -------------------------------------------------------------------
# Prints the proper html form widget based on the record type.
#
    my ($self, $rec) = @_;

    my $value = $self->{in}->param($rec->{key}) || $self->{config}->{$rec->{key}} || $self->{defaults}->{$rec->{key}};

    if ($rec->{type} eq 'path' or $rec->{type} eq 'url') {
        return <<END_OF_HTML;
      <tr>
      <td valign="top" align="left" width="150"><font face="Tahoma,Arial,Helvetica" size="2"><br>
        $rec->{message}:</font></td>
      <td valign="top" align="left" width="300"><font face="Tahoma,Arial,Helvetica" size="2"><br>
        <input name="$rec->{key}" value="$value" size="40"></font></td>
      </tr>
END_OF_HTML
    }
    elsif ($rec->{type} eq 'email_support') {
        return <<END_OF_HTML;
      <td valign="top" align="left" width="150"><font face="Tahoma,Arial,Helvetica" size="2"><br>
        $rec->{message}:</font></td>
      <td valign="top" align="left" width="300"><font face="Tahoma,Arial,Helvetica" size="2"><br>
        <input name="$rec->{key}" value="$value" size="40"></font></td>
      </tr>
END_OF_HTML
    }
    elsif ($rec->{type} eq 'email') {
        return <<END_OF_HTML;
      <td valign="top" align="left" width="150"><font face="Tahoma,Arial,Helvetica" size="2"><br>
        $rec->{message}:</font></td>
      <td valign="top" align="left" width="300"><font face="Tahoma,Arial,Helvetica" size="2"><br>
        <input name="$rec->{key}" value="$value" size="30"></font></td>
      </tr>
END_OF_HTML
    }
    elsif ($rec->{type} eq 'perl_path') {
        return <<END_OF_HTML;
      <tr>
      <td valign="top" align="left" width="150"><font face="Tahoma,Arial,Helvetica" size="2"><br>
        $rec->{message}:</font></td>
      <td valign="top" align="left" width="300"><font face="Tahoma,Arial,Helvetica" size="2"><br>
        <input name="$rec->{key}" value="$value" size="40"></font></td>
      </tr>
END_OF_HTML
    }
    elsif ($rec->{type} eq 'create_dirs') {
        if ($value) { $value = ' checked' }
        return <<END_OF_HTML;
      <tr>
      <td valign="top" align="left" width="150"><font face="Tahoma,Arial,Helvetica" size="2"><br>
        $rec->{message}:</font></td>
      <td valign="top" align="left" width="300"><font face="Tahoma,Arial,Helvetica" size="2"><br>
        <input name="create_dirs" value="1" type="checkbox"$value></font></td>
      </tr>
END_OF_HTML
    }
    elsif ($rec->{type} eq 'reg_number') {
        return <<END_OF_HTML;
      <tr>
      <td valign="top" align="left" width="150"><font face="Tahoma,Arial,Helvetica" size="2"><br>
        $rec->{message}:</font></td>
      <td valign="top" align="left" width="300"><font face="Tahoma,Arial,Helvetica" size="2"><br>
        <input name="$rec->{key}" value="$value" size="40"></font></td>
      </tr>
END_OF_HTML
    }
    elsif ($rec->{type} eq 'message') {
        return <<END_OF_HTML;
        <tr>
          <td colspan="2"><font face="Tahoma,Arial,Helvetica" size="2"><br>$rec->{message}</font></td>
        </tr>
END_OF_HTML
    }
    elsif ($rec->{type} eq 'password') {
        return <<END_OF_HTML;
      <tr>
      <td valign="top" align="left" width="150"><font face="Tahoma,Arial,Helvetica" size="2"><br>
        $rec->{message}:</font></td>
      <td valign="top" align="left" width="300"><font face="Tahoma,Arial,Helvetica" size="2"><br>
        <input name="$rec->{key}" value="$value" type="password" size="40"></font></td>
      </tr>
END_OF_HTML
    }
    elsif ($rec->{type} eq 'text') {
        return <<END_OF_HTML;
      <tr>
      <td valign="top" align="left" width="150"><font face="Tahoma,Arial,Helvetica" size="2"><br>
        $rec->{message}:</font></td>
      <td valign="top" align="left" width="300"><font face="Tahoma,Arial,Helvetica" size="2"><br>
        <input name="$rec->{key}" value="$value" type="text" size="40"></font></td>
      </tr>

END_OF_HTML
    }
    else {
        $self->error('TYPE', 'FATAL', $rec->{type});
    }
}

#################################################################
#                        Utility Functions                      #
#################################################################
sub find_perl {
# ---------------------------------------------------------------
# Returns path to perl.
#
    my @poss_perls = qw!
                         /usr/local/bin/perl5 /usr/bin/perl5 /bin/perl5
                         /usr/local/bin/perl /usr/bin/perl /bin/perl /perl/bin/perl.exe
                         c:/perl/bin/perl.exe d:/perl/bin/perl.exe
                    !;
    foreach my $perl_path (@poss_perls) {
        (-x $perl_path and ! (-d _)) and return $perl_path;
    }
    return '';
}

sub find_sendmail {
# ---------------------------------------------------------------
# Try and figure out where sendmail is located.
#
    -x '/usr/sbin/sendmail' and return '/usr/sbin/sendmail';
    -x '/usr/lib/sendmail'  and return '/usr/lib/sendmail';
    -x '/bin/sendmail'      and return '/bin/sendmail';
    return '';
}

sub find_cgi {
# ---------------------------------------------------------------
# Try and figure out the program path.
#
    eval {
        local $SIG{__DIE__};
        require FindBin;
        import FindBin;
    };
    if ($@ or (! defined $FindBin::Bin) or ($FindBin::Bin eq '')) {
        if ($0 =~ m,(.*)/[^/]+$,) {
            return $1;
        }
        return;
    }
    else {
        my $path = $FindBin::Bin;
        $path =~ s,/$,,;
        $path = $path;
        return $path;
    }
}

sub recurse_mkdir {
# ---------------------------------------------------------------
# Makes a directoy recursivly.
#
    my ($self, $dir) = @_;
    my @path = split m|/|, $dir;
    unless ($dir =~ m,/$,) { my $file = pop (@path) }
    my $go = '';
    my $msg;
    foreach my $path (@path) {
        next if $path =~ /^\s*$/;
        $go .= $path;
        $go .= '/' unless $go =~ m,/$,;
        ($go = '/' . $go) if ($dir =~ m,^/, and $go !~ m,^/,);
        (my $next = $go) =~ s,/$,,;
        if ((-e $next) and (not -d $next)) { return $self->error('DIREXISTS', 'WARN', $next) }
        unless (-d $next) {
            mkdir $next, 0777 or return $self->error('MKDIR', 'WARN', $next, "$!");
            chmod 0755, $next;
            $msg .= "Made directory $next\n";
        }
    }
    return $msg ? $msg : 1;
}


sub merge_hash {
# -----------------------------------------------------------
# $class->merge_hash($hash1, $hash2, (overwrite keys));
# ----------------------------------------------
# Merges two data structures together. The first argument is the data structure
# to merge into. $data1 is changed based on $data2. Nothing is returned. Only
# hashes are tested.
#
    my ($self, $to, $from)  = @_;

    for (keys %$from) {
# If the value is a hash and it exists in the structure we are comparing it with recurse.
        if (ref($from->{$_}) eq 'HASH') {
            if (exists $to->{$_} and ref $to->{$_} eq 'HASH') {
                $self->merge_hash($to->{$_}, $from->{$_});
            }
            else {
                $to->{$_} = $from->{$_}; # If $from contains a hash, and $to contains a non-hash, not updating may break the code.
            }
        }
        elsif (not exists $to->{$_}) {
            $to->{$_} = $from->{$_};
        }
    }
    return 1;
}

sub linewrap {
# --------------------------------------------------------------------
# $self->linewrap($length, \$string);
# -----------------------------------
#   Takes $string and wraps it on length. This method tries to wrap on
#   white spaces. If there can be no white space found before the 
#   beginning of the line it wraps it on exactly $length. 
#   URL's are not wrapped.
#
    my $self   = shift;
    my $i      = shift;
    my $string = shift;
    my @t      = split /\n/, $$string;
    my $r      = ' ' x length $$string; $r = '';
    
    while (@t) {
        my $length = length $t[0];
        if (($length <= $i) or ($t[0] =~ /^\s*$/)) {
            $r .= shift(@t) . "\n";
        }
        elsif ($length > 50000) { # Line is too long.
            my $line = shift @t;
            while ($line) {
                $r .= substr($line, 0, $i) . "\n";
                substr($line, 0, $i) = '';
            }
        }
        else {
            $r .= _unexpand($i, (shift(@t) || ''));
        }
    }
    return $r;
}
sub _unexpand {
# --------------------------------------------------------------------
# _unexpand($length, $string);
# ----------------------------
#   Internal method called by linewrap() to wrape a line.
#
    my ($i, $e);
    $i = $e = shift;
    my $r;
    while (@_) {
        defined($_[0]) or last;
        if ($_[0] =~ /^(.{$i})\s(.+)$/) {
            shift() and $r .= $1 . "\n";
            $i = $e;
            if (defined($2) and length($2) <= $e) { $r .= $2 ."\n" }
            else { unshift(@_, $2) }
        }
        elsif ($i-- == 0) {
            $i = $e;
            shift() =~ /^(.{$i})(.+)$/ and $r .= $1 . "\n";
            if (defined($2) and length($2) <= $e) { $r .= $2 }
            else { unshift(@_, $2) }
        }
    }
    return defined($r) ? $r : '';
}

sub lang {
    my ($lang, @args) = @_;
    $lang = uc $lang;
    my $val = exists $GT::Installer::LANG{$lang} ? sprintf($GT::Installer::LANG{$lang}, @args) : $lang;
    return $val;
}

1;



=head1 NAME

GT::Installer - Performs initial installs for GTI products

=head1 SYNOPSIS

    main();

    sub main {
        my $format = 'scroll1';
        my $installer = GT::Installer->new(
            product        => 'Gossamer Mail',
            version        => '2.0.0 beta 1',
            load_defaults  => \&load_defaults,
            load_config    => \&load_config,
            save_config    => \&save_config,
            checksums      => "<%Data Path%>/admin/checksums",
            welcome_format => $format
        );

        $installer->add_config_message(q|
    This should be the system path and url (start with http://) 
    to the directory where your admin files are. No trailing 
    slash please.|, $format);

        $installer->add_config(
            type     => 'path',
            key      => "Admin Path",
            message  => 'Admin Path',
        );
    }
    # Regex to path keys. These regexs have to capture
    # the file in $1
        $installer->install_to(
            '^admin/(.*)$'  => 'Admin Path',
            '^user/(.*)$'   => 'User Path',
            '^batch/(.*)$'  => 'Batch Path',
            '^data/(.*)$'   => 'Data Path',
            '^images/(.*)$' => 'Images Path',
        );
        
        $installer->add_upgrade(
            message         => 'Program Files. e.g. .pm, .pl and .cgi files',
            file_list       => '\.(?:pl|cgi|pm)$'
        );
        $installer->add_upgrade(skip => 'ConfigData\.pm$');
        $installer->perform;
    }


=head1 DESCRIPTION

GT::Installer is an installer class for all Gossamer Threads
products. It will handle both a command line interface and a 
CGI inteface.

All intallation directives are specified at the start and are
called for each CGI request if being ran in CGI mode.

=head2 Creating a new GT::Installer object

There are several options when creating a new GT::Installer 
object. All options are in the form of key value pairs. The
options can be passed in as a flattened hash or as a hash 
reference.

There are two options that must be specified. These are 
I<product> and I<version>. All other options are optional.


There are two ways to get a GT::SQL object. First, you can simply
provide the path to the def file directory where GT::SQL stores all
it's information:

    $db = new GT::SQL '/path/to/def';

or you can pass in a hash or hash ref and specify options:

    $db = new GT::SQL {
                        def_path => '/path/to/def',
                        cache    => 1,
                        debug    => 1,
                        subclass => 1
                    );

You must specify def_path. Setting cache => 1, will result in
all table or relation objects to be cached which can improve 
performance. 

Setting subclass => 0 or subclass => 1 will enable or disable
the ability to subclass any of the objects GT::SQL creates. The
default behaviour is 1.

GT::SQL has advanced debugging, and setting it to 1 should be
adequate for most operations. 

=over 4

=item product

Specifies the name of the product. This name is used in the 
welcome message and in various parts of the dialogue.

    product => 'Gossamer Mail'

=item version

This is the version of the product. It is used on the startup
screen to tell the user what version we are installing or
upgrading to.

    version => '2.0.0 beta 1'

=item load_defaults

This is a code reference that is called when installing. It
is used to defaults for prompts you have set up. The only
argument to this code reference if the installer object
which has method to assist in setting up defaults for the
different configuration options that you would specify.

If you return false from this code reference the error is
expected to be in GT::Installer::error. GT::Installer inherets
from GT::Base so you can just call the I<error> method on the
object and return it to achieve this.

    load_defaults => \&load_defaults

=item load_config

This is another code reference. It is called when the user
specifies that they are doing an upgrade. The argument to
this callback is the installer object. The path to the admin
directory of the last install is a key in the installer object
I<admin_path>. In this code reference you will need to correlate
all the config option keys to the values in your config file.
See the example included in this pod for a possible why to
do this.

    load_config => \&load_config

If you return false from this code reference the error is
expected to be in GT::Installer::error. GT::Installer inherets
from GT::Base so you can just call the I<error> method on the
object and return it to achieve this.

=item save_config

This is a code reference that is called after an install or 
upgrade. It gives you the opertunity to save any user input into
there new/old config file.

    save_config => \&save_config

=item checksums

This should be set to the full system path to the checksum file.
If this is not set checksums will not be used, which makes
the upgrade questions usless and all files will be overridden.
There is no possible way you can know the full path to this file
at the point you set it. You can specify tags in this path
that will get replaced with what the user entered. The tags
are similar to L<GT::Template> tags in that they start with 
I<&lt;%> and end with I<%&gt;>. No other L<GT::Template> tags conventions
are used.

    checksums => "<%Data Path%>/admin/checksums"

=item welcome_format

This is the welcome format. There are named formats that are 
used in GT::Installer for most command line output. This
is the one that is used for the initial message. This is not
used in CGI mode.

There are currently 4 formats (more to come :)). There are:

=over 8

=item scroll1

     _________________________________________________________________
    /\                                                                \
    \_|                                                                |
      |                                                                |
      | This is the scroll1 format                                     |
      |  ______________________________________________________________|_
      \_/_______________________________________________________________/

=item scroll2

     __^__                                                                __^__
    ( ___ )--------------------------------------------------------------( ___ )
     | / |                                                                | \ |
     | / | This is the scroll2 format                                     | \ |
     |___|                                                                |___|
    (_____)--------------------------------------------------------------(_____)

=item professional

     #================================================================#
     =                                                                =
     =  This is the professional format                               =
     #================================================================#

=item none

This format just performs line wraps. Has no outline :(

=back

=back

=head2 add_config - Adding configuration options.

There are 3 methods for adding user prompts. When I say user promts I 
mean that in the telnet sence, in CGI mode it is just a table row.

This is the method you will be calling for every install option the
user should specify. This method takes it's arguments as key value
pair. The arguments can either be in the form of a flatened hash or
a hash reference.

    $installer->add_config(
        type            => 'url',
        key             => "Admin URL",
        message         => 'Admin URL',
        telnet_callback => \&telnet_callback,
    );

Each key in the hash defines an attribute of the user prompt.

=over 4

=item type

The type attribute should be one of the built in input types. There is
currently no way to specify your own type. If this becomes a problem
it will be added. The built in types are as follows.

    url           - User specifies a URL.
    ftp           - User specifies an FTP URL.
    path          - User specifies a Path to something on the system.
    message       - This is the same as calling the add_config_message 
                    method.
    create_dirs   - This is a yes/no answer on weather the user wants the
                    directories for this install created.
    email         - User specifies and email address. This is commonly 
                    used to prompt for the admin email address.
    reg_number    - User specifies the registration number they recieved
                    from us when they paid for the product.
    email_support - Specify either the path to sendmail or the hostname
                    of an smtp server. What is specified with be in the 
                    config hash as email_support. The key default for
                    this option is Mailer.
    perl_path     - Specify the path to perl on this system.

=item key

Each item the user enters is stored in a hash in the installer object.
This hash is called I<config>. This specifies the key used in that hash
to store this user option. 

This key is also used at the end of the telnet install to display
the options the user has specified for the install.

You will be accessing these keys in your configuration callbacks to
either set defaults or save the user specified options in your config 
file. See the complete example below to see how this is used.

=item message

This is the message the user is pompted with in telnet. From the with
this appears on the left of the form the user fills out.

This will default to the value of the I<key> if not specified

=item telnet_callback

This is a code reference that, if specified, will be ran after the user
enteres the information. You can use this to tweek the other option
defaults. If this method returns false the user will be reprompted for
the information. So you can effectivly use this to validate command
line input.

=back

=head2 add_config_message - Add a configuration message.

This is a method to add a configuration message. This message is 
displayed to the user in telnet in the order you specify it. No prompt
is performed for these messages.

This is a shortcut function that is the same as specifing:

    $installer->add_config(
        type    => 'message',
        message => 'This message is displayed to the user',
        format  => 'none'
    );

The arguments to this function are (message, format). Message is what 
is displayed, format is the format used. See above for a list of 
formats.

    $installer->add_config_message(q|My configuration message.|, 'professional');

=head2 install_exit_message - Add an exit message for installs.

This is the message that is displayed after the installation is 
complete. This message uses the same convention for tags as the
I<checksum> option for the constructor method. Any keys that are set 
during the install will be available as tags here. The second argument
to this method is an optional format (used in telnet see above).

    $installer->install_exit_message(q|
    To run the setup, point your browser to: 
    <a href="<%Admin URL%>/admin.cgi"><%Admin URL%>/admin.cgi</a>
    |, 'scroll2');

=head2 install_to - Specify where to untar files to.

The way this options is specified is a bit strange and my be rewritten.
It takes it arguments as a hash of regular expressions to keys. The
keys are the keys you specified with add_config(). The regexs are matched
against the relative path in the tar file. Anything captured in $1 is
appended to the value the user entered for that regexs key. For example
is you specify a key I<Admin Path> such as

    $installer->add_config(
        type  => 'path',
        key   => 'Admin Path'
    );

You could then use the key like:

    $installer->install_to(
        '^admin/(.*)' => 'Admin Path'
    );

This would replace admin/ in the relative path in the tar file with what
the user entered for the Admin Path prompt.

=head2 use_lib - Set the use lib path for addition to all .pl and .cgi files.

The argument to this should be a I<key> specified with add_config(). The
path the user entered for that config is added to all .cgi and .pl files
in a I<use lib ''> statement. Followig the example above:

    $installer->use_lib('Admin Path');

All .cgi and .pl file in the install will now have

    use lib '/home/bline/projects/library';

added to them assuming the path the user entered for that config option was
I</home/bline/projects/library'>.

You can set $GT::Installer::USE_LIB_SPACES to something other than the default
4 spaces to alter the number of spaces that will be put before the "use lib".
Please be careful - if you set this to something other than whitespace you are
asking for trouble or being an 1337 h4xx0r.


=head2 add_upgrade - Adding upgrade options.

This is a method for grouping files and or directories under user prompted
upgrade options. This is I<NOT> designed to be a complete upgrade system. It
handled basic checksuming, overwrites and backup. This should probably not 
be used for a major upgrade.

more to come...

=head1 COPYRIGHT

Copyright (c) 2000 Gossamer Threads Inc.  All Rights Reserved.
http://www.gossamer-threads.com/

=head1 VERSION

Revision: $Id: Installer.pm,v 1.73 2002/05/31 22:33:32 alex Exp $

=cut

}

BEGIN { $INC{"GT/File/Tools.pm"} = "GT/File/Tools.pm" }
{
# ==================================================================
# Gossamer Threads Module Library - http://gossamer-threads.com/
#
#   GT::File::Tools
#   Author : Scott Beck
#   $Id: Tools.pm,v 1.38 2002/05/24 18:31:32 alex Exp $
#
# Copyright (c) 2000 Gossamer Threads Inc.  All Rights Reserved.
# ==================================================================
#
# Description: Basic file tools
#

package GT::File::Tools;
# ==================================================================

use strict;
use vars qw/
    $VERSION
    @EXPORT_OK
    %EXPORT_TAGS
    $MAX_DEPTH
    $GLOBBING
    $ERRORS
    $MAX_READ
    $DEBUG
    $NO_CHDIR
/;

use bases 'GT::Base' => '';

use Cwd;
use Exporter;
use GT::AutoLoader;
$VERSION = sprintf "%d.%03d", q$Revision: 1.38 $ =~ /(\d+)\.(\d+)/;

# Exporter variables
@EXPORT_OK = qw/
    copy
    move
    del
    deldir
    find
    rmkdir
    parsefile
    filename
    dirname
    expand 
/;
%EXPORT_TAGS = ( all => \@EXPORT_OK );
*import = \&Exporter::import;

# Options
$MAX_DEPTH = 1000;
$GLOBBING = 0;
$NO_CHDIR = 0;
$MAX_READ = 1024 * 64;
$DEBUG = 0;
$ERRORS = {
    UNLINK    => "Could not unlink %s; Reason: %s",
    RMDIR     => "Could not rmdir %s; Reason: %s",
    MOVE      => "Could not move %s to %s; Reason: %s",
    RENAME    => "Could not rename %s to %s; Reason: %s",
    SYMLINK   => "Could not symlink %s to %s; Reason: %s",
    NOTAFILE  => "File to copy, move, or del (%s) is not a regular file",
    NOTADIR   => "Path passed to find (%s) is not a directory",
    TOODEEP   => "Recursive find surpassed max depth. Last path was %s",
    RECURSIVE => "Circular symlinks detected",
    OPENDIR   => "Could not open directory %s; Reason: %s",
    READOPEN  => "Could not open %s for reading; Reason: %s",
    WRITEOPEN => "Could not open %s for writing; Reason: %s"
};

$COMPILE{move} = __LINE__ . <<'END_OF_SUB';
sub move {
# ----------------------------------------------------------------------------
    my $class = 'GT::File::Tools';

    $class->fatal( BADARGS => "No arguments passed to move()" )
        unless @_;

    my $opts = pop if ref $_[$#_] eq 'HASH';
    $opts = {} unless defined $opts;

    my $to = pop;
    $class->fatal( BADARGS => "No place to move files to specified for move()" )
        unless defined $to;

    my $globbing = delete $opts->{globbing};
    $globbing = $GLOBBING unless defined $globbing;

    my @files = @_;
    @files = expand( @files ) if $globbing;

    $class->fatal( BADARGS => "No files to move" )
        unless @files;

    my $error_handler = delete $opts->{error_handler};
    $error_handler = sub { $class->warn( @_ ); 1 }
        unless defined $error_handler;

    $class->fatal(
        BADARGS => "error_handler option must be a code reference"
    ) unless ref $error_handler eq 'CODE';

    my $max_depth = delete $opts->{max_depth};
    $max_depth = $MAX_DEPTH unless defined $max_depth;

    $class->fatal(
        BADARGS => "Unknown option " . ( join ", ", keys %$opts )
    ) if keys %$opts;

    my %seen;
    for my $from_file ( @files ) {
        my $to_file = $to;
        if ( !-d $to and $seen{$to}++ ) {
            $class->fatal(
                BADARGS => "Trying to move multiple files into one file"
            );
        }
        if ( -d $from_file ) {
            $class->debug( "movedir $from_file, $to_file" ) if $DEBUG > 1;
            movedir(
                $from_file, $to_file,
                {
                    error_handler   => $error_handler,
                    max_depth       => $max_depth
                }
            ) or return;
            next;
        }
        if ( -d $to_file ) {
            $to_file = $to . '/' . filename( $from_file );
        }
        if ( -l $from_file ) {
            my ( $link ) = _fix_symlink( $from_file );
            if ( !symlink $link, $to_file ) {
                $error_handler->( SYMLINK => $from_file, $to_file, "$!" )
                    or return;
            }
            if ( !unlink $from_file ) {
                $error_handler->( UNLINK => $from_file, "$!" )
                    or return;
            }
            next;
        }
        my ( $to_size_before, $to_mtime_before ) = ( stat( $to_file ) )[7, 9];
        my $from_size = -s $from_file;
        $class->debug( "rename $from_file, $to_file" ) if $DEBUG > 1;
        next if rename $from_file, $to_file;
        my $err = "$!";
        my $errno = 0+$!;

# Under NFS rename can work but still return an error, check for that
        my ( $to_size_after, $to_mtime_after ) = ( stat( $to_file ) )[7, 9];
        if ( defined $from_size and -e $from_file ) {
            if (
                defined $to_mtime_before and
                ( 
                    $to_size_before != $to_size_after or
                    $to_mtime_before != $to_mtime_after
                ) and
                $to_size_after == $from_size
            )
            {
                $class->debug( "rename over NFS worked" ) if $DEBUG > 1;
                next;
            }
        }

        $class->debug( "copy $from_file, $to_file" ) if $DEBUG > 1;
        next if copy( $from_file, $to_file,
            {
                preserve_all    => 1,
                max_depth       => $max_depth,
                error_handler   => $error_handler
            }
        ) and unlink $from_file;

# Remove if a particial copy happened
        if (
            !defined( $to_mtime_before )        or
            $to_mtime_before != $to_mtime_after or
            $to_size_before != $to_size_after
        )
        {
            unlink $to_file;
        }
        $error_handler->( RENAME => $from_file, $to_file, $err, $errno )
            or return;
    }
    return 1;
}
END_OF_SUB

$COMPILE{movedir} = __LINE__ . <<'END_OF_SUB';
sub movedir {
# ----------------------------------------------------------------------------
    my ( $from, $to, $opts ) = @_;
    my $class = 'GT::File::Tools';

    my $error_handler = delete $opts->{error_handler};
    $error_handler = sub { $class->warn( @_ ); 1 }
        unless defined $error_handler;

    $class->fatal(
        BADARGS => "error_handler option must be a code reference"
    ) unless ref $error_handler eq 'CODE';

    my $max_depth = delete $opts->{max_depth};
    $max_depth = $MAX_DEPTH unless defined $max_depth;

    $class->fatal(
        BADARGS => "Unknown option " . ( join ", ", keys %$opts )
    ) if keys %$opts;

    $from .= '/' unless $from =~ m,/\Z,;
    $to .= '/' unless $to =~ m,/\Z,;

# To move a directory inside an already existing directory
    $to .= filename( $from ) if -d $to;

# Try the easy way out first
    return 1 if rename $from, $to;

    my $cwd;
    if ( ( parsefile( $from ) )[2] ) {
        $cwd = getcwd;
        $from = "$cwd/$from";
    }
    if ( ( parsefile( $to ) )[2] ) {
        $cwd ||= getcwd;
        $to = "$cwd/$to";
    }

    return find(
        $from,
        sub {
            my ( $path ) = @_;
            if ( -l $path ) {
                $path .= '/' if ( -d _ and $path !~ m,/\Z, );
                my ( $link, $relative ) = _fix_symlink( $path );
                ( my $new_path = $path ) =~ s!\A\Q$from!$to!;
                $class->debug( "link $link, $new_path" ) if $DEBUG > 1;
                unless (-l $new_path) {
                    symlink $link, $new_path
                        or $error_handler->( SYMLINK =>  $link, $new_path, "$!" )
                        or return;
                }
                _preserve( $path, $new_path,
                    set_owner => 1,
                    set_time  => 1
                );
                unlink $path
                    or $error_handler->( UNLINK =>  $path, "$!" )
                    or return;
                return 1;
            }
            elsif ( -d $path ) {
                $path .= '/' unless $path =~ m,/\Z,;
                ( my $new_path = $path ) =~ s!\A\Q$from!$to!;
                $class->debug( "mkdir $new_path" ) if $DEBUG > 1;
                unless (-d $new_path) {
                    mkdir $new_path, 0777
                        or $error_handler->( MKDIR =>  $new_path, "$!" )
                        or return;
                }
                _preserve( $path, $new_path,
                    set_perms => 1,
                    set_owner => 1,
                    set_time  => 1
                );
                rmdir $path
                    or $error_handler->( RMDIR => $path, "$!" )
                    or return;
            }
            elsif ( -f _ ) {
                ( my $new_path = $path ) =~ s!\A\Q$from!$to!;
                $class->debug( "move $path, $new_path" ) if $DEBUG > 1;
                move( $path, $new_path,
                    {
                        error_handler   => $error_handler,
                        max_depth       => $max_depth,
                    }
                )   or $error_handler->( MOVE => $path, $new_path, "$!" )
                    or return;
            }
            else {
                $error_handler->( NOTAFILE => $path ) or return;
            }
            return 1;
        },
        {
            dirs_first      => 1,
            error_handler   => $error_handler,
            max_depth       => $max_depth,
        }
    );
}
END_OF_SUB

$COMPILE{del} = __LINE__ . <<'END_OF_SUB';
sub del {
# ----------------------------------------------------------------------------
    my $class = 'GT::File::Tools';
    my $opts = pop if ref $_[$#_] eq 'HASH';
    $opts = {} unless defined $opts;

    my $error_handler = delete $opts->{error_handler};
    $error_handler = sub { $class->warn( @_ ); 1 } unless $error_handler;

    $class->fatal(
        BADARGS => "error_handler option must be a code reference"
    ) unless ref $error_handler eq 'CODE';

    my $globbing = delete $opts->{globbing};
    $globbing = $GLOBBING unless defined $globbing;

    my @files = @_;
    @files = expand( @files ) if $globbing;

    $class->fatal( BADARGS => "No directories to delete" )
        unless @files;

    $class->fatal(
        BADARGS => "Unknown option " . ( join ", ", keys %$opts )
    ) if keys %$opts;

    for my $path ( @files ) {
        if ( -l $path ) {
            $class->debug( "unlink $path" ) if $DEBUG > 1;
            unlink $path
                or $error_handler->( UNLINK => $path, "$!" )
                or return;
        }
        elsif ( -d $path ) {
            $error_handler->( NOTAFILE => $path )
                or return;
        }
        else {
            unlink $path
                or $error_handler->( UNLINK => $path, "$!" )
                or return;
        }
    }
    return 1;
}
END_OF_SUB

$COMPILE{deldir} = __LINE__ . <<'END_OF_SUB';
sub deldir {
# ----------------------------------------------------------------------------
    my $class = 'GT::File::Tools';
    my $opts = pop if ref $_[$#_] eq 'HASH';
    $opts = {} unless defined $opts;

    my $error_handler = delete $opts->{error_handler};
    $error_handler = sub { $class->warn( @_ ); 1 } unless $error_handler;

    $class->fatal(
        BADARGS => "error_handler option must be a code reference"
    ) unless ref $error_handler eq 'CODE';

    my $globbing = delete $opts->{globbing};
    $globbing = $GLOBBING unless defined $globbing;

    my @dirs = @_;
    @dirs = expand( @dirs ) if $globbing;

    $class->fatal( BADARGS => "No directories to delete" )
        unless @dirs;

    my $max_depth = delete $opts->{max_depth};
    $max_depth = $MAX_DEPTH unless defined $max_depth;

    $class->fatal(
        BADARGS => "Unknown option " . ( join ", ", keys %$opts )
    ) if keys %$opts;

    for my $dir ( @dirs ) {
        $class->fatal( BADARGS => "$dir is not a directory" )
            if -e $dir and !-d _;
        next if !-e _ and !-l $dir;


        $dir .= '/' unless $dir =~ m,/\Z,;

# Try the easy way out first
        next if rmdir $dir;

        find(
            $dir,
            sub {
                my ( $path ) = @_;
                if ( -l $path ) {
                    $class->debug( "unlink $path" ) if $DEBUG > 1;
                    unlink $path
                        or $error_handler->( UNLINK => $path, "$!" )
                        or return;
                }
                elsif ( -d $path ) {
                    $class->debug( "rmdir $path" ) if $DEBUG > 1;
                    rmdir $path
                        or $error_handler->( RMDIR => $path, "$!" )
                        or return;
                }
                else {
                    $class->debug( "unlink $path" ) if $DEBUG > 1;
                    unlink $path
                        or $error_handler->( UNLINK => $path, "$!" )
                        or return;
                }
                return 1;
            },
            {
                dirs_first      => 0,
                error_handler   => $error_handler,
                max_depth       => $max_depth,
            }
        );
    }
    return 1;
}
END_OF_SUB

$COMPILE{copy} = __LINE__ . <<'END_OF_SUB';
sub copy {
# ----------------------------------------------------------------------------
    my $class = 'GT::File::Tools';

    $class->fatal( BADARGS => "No arguments passed to move()" )
        unless @_;

    my $opts = pop if ref $_[$#_] eq 'HASH';
    $opts = {} unless defined $opts;
    my $to = pop;
    $class->fatal( BADARGS => "No place to move files to specified for move()" )
        unless defined $to;

    my $globbing = delete $opts->{globbing};
    $globbing = $GLOBBING unless defined $globbing;

    my @files = @_;
    @files = expand( @files ) if $globbing;

    $class->fatal( BADARGS => "No files to move" )
        unless @files;

    my $error_handler = delete $opts->{error_handler};
    $error_handler = sub { $class->warn( @_ ); 1 }
        unless defined $error_handler;

    $class->fatal(
        BADARGS => "error_handler option must be a code reference"
    ) unless ref $error_handler eq 'CODE';

    my %preserve_opts = (set_perms => 1);
    if ( delete $opts->{preserve_all} ) {
        @preserve_opts{qw/set_perms set_owner set_time/} = ( 1, 1 ,1 );
    }
    else {
        $preserve_opts{set_perms} = delete $opts->{set_perms} if defined $opts->{set_perms};
        @preserve_opts{qw/set_owner set_time/} =
        (
            delete $opts->{set_owner},
            delete $opts->{set_time}
        );
    }

    my $max_depth = delete $opts->{max_depth};
    $max_depth = $MAX_DEPTH unless defined $max_depth;

    $class->fatal(
        BADARGS => "Unknown option " . ( join ", ", keys %$opts )
    ) if keys %$opts;

    my %seen;
    for my $from_file ( @files ) {
        my $to_file = $to;
        if ( !-d $to_file and $seen{$to_file}++ ) {
            $class->fatal(
                BADARGS => "Trying to copy multiple files into one file $from_file => $to"
            );
        }
        if ( -d $from_file ) {
            $class->debug( "copydir $from_file, $to_file" ) if $DEBUG > 1;
            copydir( $from_file, $to_file, {
                error_handler   => $error_handler,
                max_depth       => $max_depth,
                %preserve_opts
            });
            next;
        }
        if ( -d $to_file ) {
            $to_file = $to . '/' . filename( $from_file );
        }
        if ( -l $from_file ) {
            my ( $link ) = _fix_symlink( $from_file );
            if ( !symlink $link, $to_file ) {
                $error_handler->( SYMLINK => $from_file, $to_file, "$!" )
                    or return;
            }
            next;
        }

        local( *FROM, *TO );
        $class->debug( "open $from_file" ) if $DEBUG > 1;
        unless ( open FROM, "< $from_file" ) {
            $error_handler->( READOPEN => $from_file, "$!" ) or return;
            next;
        }
        $class->debug( "open $to_file" ) if $DEBUG > 1;
        unless ( open TO, "> $to_file" ) {
            $error_handler->( WRITEOPEN => $to_file, "$!" ) or return;
            next;
        }
        binmode FROM or $class->fatal( BINMODE => "$!" );
        binmode TO or $class->fatal( BINMODE => "$!" );
        my $size = -s FROM;
        $size = $MAX_READ if $size > $MAX_READ;

        while () {
            my ( $ret, $buf );
            $ret = sysread FROM, $buf, $size;
            $class->fatal( READ => "$!" )
                unless defined $ret;
            last unless $ret;
            $ret = syswrite TO, $buf, length $buf;
            $class->fatal( WRITE => "$!" )
                unless defined $ret;
        }

        close FROM;
        close TO;

# Set permissions, mtime, and owner
        _preserve( $from_file, $to_file, %preserve_opts );

    }
    return 1;
}
END_OF_SUB

$COMPILE{copydir} = __LINE__ . <<'END_OF_SUB';
sub copydir {
# ----------------------------------------------------------------------------
    my ( $from, $to, $opts ) = @_;
    my $class = 'GT::File::Tools';

    $class->fatal( BADARGS => "No from directory specified" )
        unless defined $from;
    $class->fatal( BADARGS => "From file specified must be a directory" )
        unless -d $from;
    $class->fatal( BADARGS => "No to directory specified" )
        unless defined $from;
    my $error_handler = delete $opts->{error_handler};

    $error_handler = sub { $class->warn( @_ ); 1 }
        unless defined $error_handler;

    $class->fatal(
        BADARGS => "error_handler option must be a code reference"
    ) unless ref $error_handler eq 'CODE';

    my %preserve_opts = (set_perms => 1);
    if ( delete $opts->{preserve_all} ) {
        @preserve_opts{qw/set_perms set_owner set_time/} = ( 1, 1 ,1 );
    }
    else {
        $preserve_opts{set_perms} = delete $opts->{set_perms} if defined $opts->{set_perms};
        @preserve_opts{qw/set_owner set_time/} =
        (
            delete $opts->{set_owner},
            delete $opts->{set_time}
        );
    }

    my $max_depth = delete $opts->{max_depth};
    $max_depth = $MAX_DEPTH unless defined $max_depth;

    $class->fatal(
        BADARGS => "Unknown option " . ( join ", ", keys %$opts )
    ) if keys %$opts;

    $from .= '/' unless $from =~ m,/\Z,;
    $to .= '/' unless $to =~ m,/\Z,;

# To move a directory inside an already existing directory
    $to .= filename( $from ) if -d $to;

    my $cwd;
    if ( ( parsefile( $from ) )[2] ) {
        $cwd = getcwd;
        $from = "$cwd/$from";
    }
    if ( ( parsefile( $to ) )[2] ) {
        $cwd ||= getcwd;
        $to = "$cwd/$to";
    }

    return find(
        $from,
        sub {
            my ( $path ) = @_;
            if ( -l $path ) {
                $path .= '/' if ( -d _ and $path !~ m,/\Z, );
                my ( $link, $relative ) = _fix_symlink( $path );
                ( my $new_path = $path ) =~ s!\A\Q$from!$to!;
                $class->debug( "link $link, $new_path" ) if $DEBUG > 1;
                unless (-l $new_path) {
                    symlink $link, $new_path
                        or $error_handler->( SYMLINK =>  $link, $new_path, "$!" )
                        or return;
                }
                _preserve( $path, $new_path, %preserve_opts );
                return 1;
            }
            elsif ( -d $path ) {
                $path .= '/' unless $path =~ m,/\Z,;
                ( my $new_path = $path ) =~ s!\A\Q$from!$to!;
                $class->debug( "mkdir $new_path" ) if $DEBUG > 1;
                unless (-d $new_path) {
                    mkdir $new_path, 0777
                        or $error_handler->( MKDIR =>  $new_path, "$!" )
                        or return;
                }
                _preserve( $path, $new_path, %preserve_opts );
            }
            elsif ( -f $path ) {
                ( my $new_path = $path ) =~ s!\A\Q$from!$to!;
                $class->debug( "copy $path, $new_path" ) if $DEBUG > 1;
                copy( $path, $new_path,
                    {
                        %preserve_opts,
                        error_handler   => $error_handler,
                        max_depth       => $max_depth,
                    }
                )
                    or $error_handler->( MOVE => $path, $new_path, "$GT::File::Tools::error" )
                    or return;
# copy() will handle setting permission and such
            }
            else {
                $error_handler->( NOTAFILE => $path )
                    or return;
            }
            return 1;
        }, 
        {
            dirs_first      => 1,
            error_handler   => $error_handler,
            max_depth       => $max_depth,
        }
    );
}
END_OF_SUB

$COMPILE{filename} = __LINE__ . <<'END_OF_SUB';
sub filename {
# ----------------------------------------------------------------------------
    return ( parsefile( $_[0] ) )[1];
}
END_OF_SUB

$COMPILE{dirname} = __LINE__ . <<'END_OF_SUB';
sub dirname {
# ----------------------------------------------------------------------------
    return ( parsefile( $_[0] ) )[0];
}
END_OF_SUB

$COMPILE{parsefile} = __LINE__ . <<'END_OF_SUB';
sub parsefile {
# ----------------------------------------------------------------------------
    my ( $in ) = @_;
    my ( @path, @normal, $relative, $win32 );
    if ( $^O eq 'MSWin32' ) {
        $win32 = $1 if $in =~ s/\A(\w:)//;
        @path = split m|[/\\]|, $in;
        $relative = 1 unless $in =~ m,\A[/\\],;
    }
    else {
        @path = split m|/|, $in;
        $relative = 1 unless $in =~ m,\A/,;
    }
    my $start = 0;
    for ( @path ) {
        if ( $_ eq '.' or !length ) { next }
        elsif ( $_ eq '..' ) { $start-- }
        else { $start++ }

        if ( !$relative and $start < 0 and $_ eq '..' ) { next }
        elsif ( $start < 0 and $_ eq '..' ) { push @normal, ".." }
        elsif ( $start >= 0 and $_ eq '..' ) { pop @normal }
        else { push @normal, $_ }
    }
    my $file = pop @normal;
    my $new_path = join "/", @normal;
    $new_path = $relative ? "./$new_path" : "/$new_path";
    $new_path = "$win32$new_path" if $win32;

    return ( $new_path, $file, $relative );
}
END_OF_SUB


$COMPILE{rmkdir} = __LINE__ . <<'END_OF_SUB';
sub rmkdir {
    my ($full_path, $perms) = @_;
    my ($path, $target, $is_relative) = parsefile($full_path);
    GT::File::Tools->fatal(BADARGS => 'You can not pass a relative path to rmkdir')
        if $is_relative;
    my @tomake = (split(m|/|, $path), $target);
    my $cwd = getcwd;
    my $err = sub {
        my $bang = 0+$!;
        chdir $cwd;
        $! = $bang;
        return;
    };
    chdir '/' or return $err->();
    for (@tomake) {
        next unless length;
        if (!-d $_) {
            mkdir $_, 0777 or return $err->();
            if (defined $perms) {
                chmod $perms, $_ or return $err->();
            }
        }
        chdir $_ or return $err->();
    }
    chdir $cwd or return $err->();
    return 1;
}
END_OF_SUB

$COMPILE{find} = __LINE__ . <<'END_OF_SUB';
sub find {
# ----------------------------------------------------------------------------
    my $class = 'GT::File::Tools';

    $class->fatal( BADARGS => "No arguments passed to find()" )
        unless @_;

    my $opts = pop if ref $_[$#_] eq 'HASH';
    $opts = {} unless defined $opts;
    my $callback = pop;

    $class->fatal(
        BADARGS => "Argument after files list must be a code reference"
    ) unless ref $callback eq 'CODE';

    my $globbing = delete $opts->{globbing};
    $globbing = $GLOBBING unless defined $globbing;

    my @files = @_;
    @files = expand( @files ) if $globbing;

    $class->fatal( BADARGS => "No files to find" )
        unless @files;

    my $error_handler = delete $opts->{error_handler};
    $error_handler = sub { $class->warn( @_ ); 1 }
        unless defined $error_handler;

    $class->fatal(
        BADARGS => "error_handler option must be a code reference"
    ) unless ref $error_handler eq 'CODE';

    my $no_chdir = delete $opts->{no_chdir};
    $no_chdir = $NO_CHDIR unless defined $no_chdir;

    my $dirs_first = delete $opts->{dirs_first};
    $dirs_first = 1 unless defined $dirs_first;

    my $files_only = delete $opts->{files_only};
    $files_only = 0 unless defined $files_only;

    my $dirs_only = delete $opts->{dirs_only};
    $dirs_only = 0 unless defined $dirs_only;

    my $max_depth = delete $opts->{max_depth};
    $max_depth = $MAX_DEPTH unless defined $max_depth;

    $class->fatal(
        BADARGS => "You may only specify one of files_only or dirs_only"
    ) if $files_only and $dirs_only;

    $class->fatal(
        BADARGS => "Unknown option " . ( join ", ", keys %$opts )
    ) if keys %$opts;

    for my $path ( @files ) {
        next unless -e $path;

        unless ( -d _ ) {
            $error_handler->( NOTADIR => $path ) or return;
            next;
        }

        my $relative = ( parsefile( $path ) )[2];
        my $cwd;
        if ( !$no_chdir or $relative ) {
            $cwd = getcwd;
        }
        if ( $relative ) {
            $path = "$cwd/$path";
        }
        $class->debug( "find $path" ) if $DEBUG > 1;
        eval {
            _find( $path, $callback, {
                error_handler   => $error_handler,
                dirs_first      => $dirs_first,
                files_only      => $files_only,
                max_depth       => $max_depth,
                no_chdir        => $no_chdir,
                dirs_only       => $dirs_only
            }) or do {
                chdir $cwd;
                return;
            };
        };
        chdir $cwd unless $no_chdir;
        die "$@\n" if $@;
    }
    return 1;
}
END_OF_SUB

$COMPILE{_find} = __LINE__ . <<'END_OF_SUB';
sub _find {
# ----------------------------------------------------------------------------
# This is so we can initialize from variable and cleanup in the main find
# function.
#
    my ( $path, $callback, $opts ) = @_;
    my $error_handler = $opts->{error_handler};
    local *DIR;
    if ( $opts->{dirs_first} and !$opts->{files_only} ) {
        $callback->( $path ) or return;
    }
    my $refs = 0;
    my $depth = 0;
    my $opened;
    if ( $opts->{no_chdir} ) {
        $opened = opendir DIR, $path;
    }
    else {
        if ( chdir $path ) {
            $opened = opendir DIR, ".";
        }
        else {
            $error_handler->( CHDIR => $path )
                or return;
        }
    }
    if ( $opened ) {
        my @files =
            map { s,/\Z,,; $opts->{no_chdir} ? "$path/$_" : $_ }
            grep { $_ ne '.' and $_ ne '..' } readdir DIR;
        closedir DIR;
        for ( my $i = 0; $i < @files; $i++ ) {
            my $file = $files[$i];
            if ( ref $file ) {
                if ( !$opts->{dirs_first} and !$opts->{files_only} ) {
                    $callback->( $$file ) or return;
                }
                $depth-- if $opts->{max_depth};
                unless ( $opts->{no_chdir} ) {
                    chdir "..";
                    substr( $path, rindex($path, "/") ) = ""
                        unless $opts->{no_chdir};
                }
                next;
            }

            if ( $opts->{max_depth} and $depth > $opts->{max_depth} ) {
                GT::File::Tools->fatal( 'TOODEEP' );
            }
            my $is_sym = -l $file;
            my $is_dir = -d $file;
            if ( $opts->{dirs_only} ) {
                next unless $is_dir;
            }
            if ($is_sym) {
                $callback->(  $opts->{no_chdir} ? $file : "$path/$file" ) or return;
            }
            elsif ( $is_dir ) {
                next unless -e _;
                local *DIR;
                $depth++;
                my @new_files;
                if ( $opts->{no_chdir} ) {
                    if ( opendir DIR, $file ) {
                        @new_files =
                            map { s,/\Z,,; $opts->{no_chdir} ? "$file/$_" : $_ }
                            grep { $_ ne '.' and $_ ne '..' } readdir DIR;
                        closedir DIR;
                    }
                    else {
                        $error_handler->( OPENDIR => $file ) or return;
                    }
                }
                else {
                    my $opened;
                    if ( chdir $file ) {
                        $opened = opendir DIR, ".";
                    }
                    else {
                        $error_handler->( CHDIR => $file )
                            or return;
                    }
                    if ( $opened ) {
                        @new_files = map { s,/\Z,,; $_ } grep { $_ ne '.' and $_ ne '..' } readdir DIR;
                        closedir DIR;
                    }
                    else {
                        $error_handler->( OPENDIR => $file ) or return;
                    }
                    $path .= '/' . $file;
                }
                if ( $opts->{dirs_first} and !$opts->{files_only} ) {
                    $callback->( $opts->{no_chdir} ? $file : $path ) or return;
                }
                splice @files, $i + 1, 0, @new_files, ( $opts->{no_chdir} ? \$file : \$path );
            }
            else {
                next unless -e _;
                $callback->( $opts->{no_chdir} ? $file : "$path/$file" ) or return;
            }
        }
    }
    else {
        $error_handler->( OPENDIR => $path ) or return;
    }
    if ( !$opts->{dirs_first} and !$opts->{files_only} ) {
        $callback->( $path ) or return;
    }
    return 1;
}
END_OF_SUB

$COMPILE{_fix_symlink} = __LINE__ . <<'END_OF_SUB';
sub _fix_symlink {
# ----------------------------------------------------------------------------
# Tries to get the full path to what a symlink is pointing to. Returns the
# path (full or relative) and a value that is true if the path is relative and
# false otherwise.
#
    my ( $path ) = @_;
    my $link = readlink $path;
    my ( $relative1, $relative2 );
    ( undef, undef, $relative1 ) = parsefile( $link );
    ( undef, undef, $relative2 ) = parsefile( $path );
    if ( $relative1 and !$relative2 ) {
        $relative1 = 0;
        $link = dirname( $path ) . '/' . $link;
    }
    return ( $link, $relative1 );
}
END_OF_SUB

$COMPILE{_preserve} = __LINE__ . <<'END_OF_SUB';
sub _preserve {
# ----------------------------------------------------------------------------
# Set permissions, owner, mtime given file from, file to, and options:
#       set_time
#       set_owner
#       set_perms
#
    my ( $from, $to, %opts ) = @_;
    my $class = 'GT::File::Tools';

    my ( $mode, $uid, $gid, $mtime );
    if ( $opts{set_time} or $opts{set_owner} or $opts{set_perms} ) {
        ( $mode, $uid, $gid, $mtime ) = (stat($from))[2, 4, 5, 9];
    }
    if ( $opts{set_time} ) {
        utime time, $mtime, $to;
    }

    if ( $opts{set_owner} ) {
        chown $uid, $gid, $to
            if ( $> == 0 and $^O ne "MaxOS" and $^O ne "MSWin32" );
    }

    if ( $opts{set_perms} and !-l $to ) {
        chmod $mode, $to or return $class->warn( 'CHMOD', $to, "$!" );
    }
}
END_OF_SUB

$COMPILE{expand} = __LINE__ . <<'END_OF_SUB';
sub expand {
# ----------------------------------------------------------------------------
# Implement globbing for files. Perl's glob function has issues.
#
    my $class = 'GT::File::Tools';
    my ( @files ) = @_;
    my (@ret, $cwd);
    for ( @files ) {
        my ( $dirname, $filename, $relative ) = parsefile( $_ );
        if ($relative) {
            $cwd ||= getcwd;
            ($dirname, $filename) = parsefile( "$cwd/$_" );
        }
        if (
            index( $filename, '*' ) == -1 and
            index( $filename, '?' ) == -1
        )
        {
            push @ret, "$dirname/$filename";
            next;
        }
        $filename = quotemeta $filename;
        $filename =~ s[(^|\G|[^\\])((?:\\{4})*)\\(\\\\)?(\\(?!\\)|[?*])]{
            $1 . ('\\' x (length($2) / 2)) . ($3 ? "\\$4" : $4 eq '*' ? '.*' : $4 eq '?' ? '.' : '\\')
        }eg;
        local *DIR;
        opendir DIR, $dirname
            or $class->fatal( OPENDIR => $dirname, "$!" );
        push @ret, map "$dirname/$_", grep  { /\A$filename\Z/ and $_ ne '.' and $_ ne '..' } readdir DIR;
        closedir DIR;
    }
    return @ret;
}
END_OF_SUB

1;



=head1 NAME

GT::File::Tools - Export tools for dealing with files

=head1 SYNOPSIS

    use GT::File::Tools qw/:all/;
    
    # Find all files in a users home directory.
    find "/home/user", sub { print shift };
    
    # Rename a file1 to file2.
    move "file1", "file2";

    # Remove a list of files.
    del @files;

    # Remove a users home directory
    deldir "/home/foo";

    # Copy a file
    copy "file1", "file2";

    # Recursively copy a directory.
    copy "/home/user", "/home/user.bak";

    # Recursively make a directory.
    rmkdir "/home/user/www/cgi-bin", 0755;

    # Parse a filename into directory, file and is_relative components
    my ($dir, $file, $is_rel) = parsefile("/home/foo/file.txt");

    # Get the file portion of a filename
    my $file = filename("/home/foo/file.txt");

    # Get the directory portion of a filename.
    my $dir = dirname("/home/foo/file.txt");

    # Use shell like expansion to get a list of absolute files.
    my @src = expand("*.c", "*.h");

=head1 DESCRIPTION

GT::File::Tools is designed to export requested functions into your namespace.
These function perform various file operations.

=head1 FUNCTIONS

GT::File::Tools exports functions to your namespace. Here is a list of the
functions you can request to be exported.

=head2 find

C<find> takes three parameters: directory to search in, callback to run for
each file and/or directory found, and a hash ref of options. B<Note>: this is
the opposite order of File::Find's find() function! The following options
can be passed set:

=over 4

=item globbing

Expand filenames in the same way as the unix shell:

    find("/home/a*", sub { print shift; }, { globbing => 1 });

would fine all home directories starting with the letter a. This option is 
off by default.

=item error_handler

A code ref that is run whenever find encounters an error. If the callback 
returns 0, find will stop immediately, otherwise find will continue 
searching (default).

=item no_chdir

By default, find will chdir into the directories it is searching as
this results in a dramatic performance improvement. Upon completion, find
will chdir back to the original directory. This behavior is on by default.

=item dirs_first

This option controls the order find traverses. It defaults on, and means 
find will go down directories first before looking at files. This is 
essential for recursively deleting a directory.

=item files_only

This option tells find to run the callback only for each file found
and not for each directory. Off by default.

=item dirs_only

This option tells find to run the callback only for each directory found
and not for each file. Off by default.

=item max_depth

Defaults to 1000, this option controls how deep a directory structure find
will traverse. Meant mainly as a safety, and should not need to be adjusted.

=back

=head2 move

C<move> has the same syntax as the system mv command:

    move 'file', 'file2';
    move 'file1', 'file2', 'dir';
    move 'file1', 'file2', 'dir3', 'dir';
    move '*.c', 'dir', { globbing => 1 };

The only difference is the last argument can be a hash ref of options. The 
following options are allowed:

=over 4

=item globbing 

=item error_handler

=item max_depth

=back

=head2 del

C<del> has the same syntax as the rm system command, but it can not remove
directories. Use C<deldir> below to recursively remove files.

    del 'file1';
    del '*.c', { globbing => 1 };
    del 'a', 'b', 'c';

It takes a list of files or directories to delete, and an optional hash ref 
of options. The following options are allowed:

=over 4

=item error_handler

=item globbing

=back

=head2 deldir

C<deldir> is similiar to C<del>, but allows recursive deletes of directories:

    deldir 'file1';
    deldir 'dir11', 'dir2', 'dir3';
    deldir '/home/a*', { globbing => 1 };

It takes a list of files and/or directories to remove, and an optional hash ref
of options. The following options are allowed:

=over 4

=item error_handler

=item globbing

=item max_depth

=back

=head2 copy

C<copy> is similiar to the system cp command:

    copy 'file1', 'file2';
    copy 'file1', 'file2', 'file3', 'dir1';
    copy '*.c', '/usr/local/src', { globbing => 1 };
    copy 

It copies a source file to a destination file or directory. You can also 
specify multiple source files, and copy them into a single directory. The 
last argument should be a hash ref of options:

=over 4

=item set_perms

This option will preserve permissions. i.e.: if the original file is set 755,
the copy will also be set 755. It defaults on.

=item set_owner

This option will preserver file ownership. Note: you must be root to be able
to change ownerhsip of a file. This defaults off.

=item set_time

This option will preserve file modification time.

=item preserve_all

This option sets set_perms, set_owner and set_time on.

=item error_handler

=item globbing

=item max_depth

=back

=head2 rmkdir

C<rmkdir> recursively makes a directory. It takes the same arguments as 
perl's mkdir():

    rmkdir("/home/alex/create/these/dirs", 0755) or die "Can't rmkdir: $!";

=head2 parsefile

This function takes any type of filename (relative, fullpath, etc) and 
returns the inputs directory, file, and whether it is a relative path or
not. For example:

    my ($directory, $file, $is_relative) = parsefile("../foo/bar.txt");

=head2 dirname

Returns the directory portion of a filename.

=head2 filename

Returns the file portion of a filename.

=head2 expand

Uses shell like expansion to expand a list of filenames to full paths. For 
example:

    my @source   = expand("*.c", "*.h");
    my @homedirs = expand("/home/*");

If you pass in relative paths, expand always returns absolute paths of 
expanded files. B<Note>: this does not actually go to the shell.

=head1 SEE ALSO

This module depends on perl's Cwd module for getting the current working
directory. It also uses GT::AutoLoader to load on demand functions.

=head1 MAINTAINER

Scott Beck

=head1 COPYRIGHT

Copyright (c) 2002 Gossamer Threads Inc.  All Rights Reserved.
http://www.gossamer-threads.com/

=head1 VERSION

Revision: $Id: Tools.pm,v 1.38 2002/05/24 18:31:32 alex Exp $

=cut


}




%GT::Installer::LANG = (
    ERR_REQUIRED   => "%s can not be left blank.",
    ERR_PATH       => "The path (%s) does not exist on this system",
    ERR_PATHWRITE  => "Unable to write to directory (%s). Reason: (%s)",
    ERR_PATHCREATE => "Unable to create directory (%s). Reason: (%s)",
    ERR_URLFMT     => "(%s) does not look like a URL",
    ERR_FTPFMT     => "(%s) does not look like and FTP URL",
    ERR_EMAILFMT   => "(%s) does not look like an email",
    ERR_SENDMAIL   => "The path (%s) does not exist on your system or is not executable",
    ERR_SMTP       => "(%s) is not a valid smtp server address",
    ERR_PERL      => "The path to perl you specified (%s) %s",
    ERR_DIREXISTS => "%s is not a directory but exists, unable to make a directory of that name",
    ERR_WRITEOPEN      => "Could not open %s for writting; Reason: %s",
    ERR_READOPEN      => "Could not open %s for reading; Reason: %s",
    ERR_RENAME => "Could not rename %s to %s; Reason: %s",
    ENTER_REG => 'Please enter your registration number',
    REG_NUM => 'Registration Number',
    ENTER_SENDMAIL => 'Please enter either a path to sendmail, or a SMTP server to use for sending mail',
    MAILER => 'Mailer',
    ENTER_PERL => 'Please enter the path to perl 5',
    PATH_PERL => 'Path to Perl',
    CREATE_DIRS => 'Create Directories',
    INSTALL_CURRUPTED => '
install.dat appears to be corrupted. Please make sure you transfer 
the file in BINARY mode when using FTP. Otherwise you may have a 
corrupted file, and you should try downloading a new file from 
Gossamer Threads.

If you need assistance, please visit: 
    http://gossamer-threads.com/scripts/support/
',
   INSTALL_VERSION => '
This program requires perl version 5.004_04 or greater to run. Your
system is only running version %s. Try changing the path to perl in
install.cgi to a newer version, or contact your ISP for help.
',
   ADMIN_PATH_ERROR => "You must specify the path to the previous install's admin area",
   INTRO => '
%s Quick Install http://gossamer-threads.com
Copyright (c) 2001 Gossamer Threads Inc. All Rights Reserved
Redistribution in part or in whole strictly prohibited.

Please see LICENSE file for full details.
',
    WELCOME => '
Welcome to the %s auto install. This program will
unarchive the %s program, and create all the 
files neccessary, and set all permissions properly.

To begin, please enter the following information. Type exit or
quit at any time to abort.
',
    IS_UPGRADE => "Is this an upgrade of an existing installation",
    ENTER_ADMIN_PATH => "\nPlease enter path to current admin",
    UNARCHIVING => 'Unarchiving',
    TAR_OPEN        => "Could not open %s. Reason: %s",
    TAR_READ        => "There was an error reading from %s. Expected to read %s bytes, but only got %s.",
    TAR_BINMODE     => "Could not binmode %s. Reason: %s",
    TAR_BADARGS     => "Bad arguments passed to %s. Reason: %s",
    TAR_CHECKSUM    => "Checksum Error parsing tar file. Most likely this is a corrupt tar.\nHeader: %s\nChecksum: %s\nFile: %s\n",
    TAR_NOBODY      => "File '%s' does not have a body!",
    TAR_CANTFIND    => "Unable to find a file named: '%s' in tar archive.",
    TAR_CHMOD       => "Could not chmod %s, Reason: %s",
    TAR_DIRFILE     => "'%s' exists and is a file. Cannot create directory",
    TAR_MKDIR       => "Could not mkdir %s, Reason: %s",
    TAR_RENAME      => "Unable to rename temp file: '%s' to tar file '%s'. Reason: %s",
    TAR_NOGZIP      => "Compress::Zlib module is required to work with .tar.gz files.",
    SKIPPING_FILE => "Skipping %s\n",
    OVERWRITTING_FILE => "Overwritting %s\n",
    SKIPPING_MATCHED => "Skipping %s in matched directory\n",
    BACKING_UP_FILE => "Backing up %s\n",
    ERR_OPENTAR => '
Unable to open the install.dat file! Please make sure the
file exists, and the permissions are set properly so the
program can read the file.

The error message was: 
    %s

If you need assistance, please visit: 
    http://gossamer-threads.com/scripts/support/
',
    ERR_OPENTAR_UNKNOWN => '
Unknown error opening tar file:
    %s

If you need assistance, please visit:
http://gossamer-threads.com/scripts/support/
',
    WE_HAVE_IT => "\nWe have everything we need to proceed.\n\n",
    ENTER_STARTS => "\nPress ENTER to install, or CTRL-C to abort",
    NOW_UNARCHIVING => '

We are now unarchiving %s and will be extracting
all the files shortly. Please be patient ...
',
    UPGRADE_DONE => '

Congratulations! Your copy of %s has now been 
updated to version %s. The install files have 
been removed.

If you need to re-run the install, please unarchive the 
original file again.
',
    INSTALL_DONE => '

%s is now unarchived. The install files have been 
removed. If you need to re-run the install, please unarchive 
the original file again.

NOTE: Please do not leave your original .tar.gz file in your
web directory!

',
    TELNET_ERR => 'Error: %s',
    FIRST_SCREEN => '
<html>
    <head>
    <title>Welcome to <%product%> <%version%></title>
    </head>
    <body bgcolor="#FFFFFF">
    <form action="install.cgi" method="POST">
    <input type="hidden" name="lite" value="<%lite%>">
    <table border="1" cellpadding="0" cellspacing="0" width="500">
    <tr><td bgcolor="#DDDDDD">
        <p align="center"><font face="Tahoma,Arial,Helvetica" size="2">&nbsp;</font><font face="Tahoma,Arial,Helvetica" size="3"><b><%product%>
        Install</b></font>
        </p>
      </td>
    </tr>
    <tr>
      <td>
      <blockquote>
      <p><br>
      <font face="Tahoma,Arial,Helvetica" size="2">Welcome to <%product%>. This program will unarchive <%product%>, and set all the file permissions
      and path to perl properly. 
        
      <%error%>

      <br>&nbsp;

  <table border="0">
    <%message%>
    <tr>
      <td colspan="2"><font face="Tahoma,Arial,Helvetica" size="2">
        Please select if this is a new install or an upgrade to an exiting version.
    </tr>
    <tr>
      <td width="150"><font face="Tahoma,Arial,Helvetica" size="2"><b>New Install</b></font></td>
      <td width="300"><font face="Tahoma,Arial,Helvetica" size="2"><input type="radio" name="upgrade_choice" value="No" checked></font></td>
    </tr>
    <tr>
      <td width="150"><font face="Tahoma,Arial,Helvetica" size="2"><b>Upgrade Existing Installation</b></font></td>
      <td width="300"><font face="Tahoma,Arial,Helvetica" size="2"><input type="radio" name="upgrade_choice" value="Yes"></font></td>
    </tr>
    <tr>
      <td width="450" colspan=2><font face="Tahoma,Arial,Helvetica" size="2">Path to Existing Installation admin area:</font></td>
    </tr>
    <tr>
      <td width="450" colspan=2><font face="Tahoma,Arial,Helvetica" size="2"><input type="text" name="install_dir" size=40 value="<%install_dir%>"></font></td>
    </tr>
  </table>
<p align="center"><center><font face="Tahoma,Arial,Helvetica" size="2">&nbsp; <input type="submit" value="Next &gt;&gt;"></center>
</font><br>&nbsp;
</td></tr></table>
</form>
<p><font face="Tahoma,Arial,Helvetica" size="2"><p><font face="Tahoma,Arial,Helvetica" size="2"><b>Copyright 2001 <a href="http://gossamer-threads.com/">Gossamer
Threads Inc.</a></b>&nbsp;</font></p>
</body>
</html>
',
    UPGRADE_FIRST_SCREEN => '
<html>
    <head>
    <title>Welcome to <%product%> <%version%></title>
    </head>
    <body bgcolor="#FFFFFF">
    <form action="install.cgi" method="POST">
    <input type="hidden" name="lite" value="<%lite%>">
    <input type=hidden name="upgrade_second" value="1">
    <input type=hidden name="install_dir" value="<%GT_ADMIN_PATH%>">
    <table border="1" cellpadding="0" cellspacing="0" width="500">
    <tr><td bgcolor="#DDDDDD">
        <p align="center"><font face="Tahoma,Arial,Helvetica" size="2">&nbsp;</font><font face="Tahoma,Arial,Helvetica" size="3"><b><%product%>
        Install</b></font>
        </p>
      </td>
    </tr>
    <tr>
      <td>
      <blockquote>
      <p><br>
      <font face="Tahoma,Arial,Helvetica" size="2">Welcome to <%product%>. This program will unarchive <%product%>, and set all the file permissions
      and path to perl properly. You need to know the following information before continuing. Sensible defaults have been chosen, but please double check
      that they are correct.

      <%error%>
      <br>&nbsp;

  <table border="0">
    <%upgrade_form%>
  </table>
<p align="center"><center><font face="Tahoma,Arial,Helvetica" size="2">&nbsp; <input type="submit" value="Next &gt;&gt;"></center>
</font><br>&nbsp;
</td></tr></table>
</form>
<p><font face="Tahoma,Arial,Helvetica" size="2"><p><font face="Tahoma,Arial,Helvetica" size="2"><b>Copyright 2001 <a href="http://gossamer-threads.com/">Gossamer
Threads Inc.</a></b>&nbsp;</font></p>
</body>
</html>
',
    UPGRADE_SECOND_SCREEN_FIRST => '
<html>
    <head>
    <title>Welcome to <%product%></title>
    </head>
    <body bgcolor="#FFFFFF">

    <table border="1" cellpadding="0" cellspacing="0" width="500">
    <tr><td bgcolor="#DDDDDD">
        <p align="center"><font face="Tahoma,Arial,Helvetica" size="2">&nbsp;</font><font face="Tahoma,Arial,Helvetica" size="3"><b><%product%>
        Install</b></font>
        </p>
      </td>
    </tr>
    <tr>
      <td>
      <blockquote>
      <p><br>
      <font face="Tahoma,Arial,Helvetica" size="2">
      We are now going to unarchive the script, please be patient and do not hit stop.
      </font></p>
      </blockquote>
      </td>
    </tr></table>
<blockquote>
<pre>
',
    UPGRADE_SECOND_SCREEN_SECOND => '
</pre>
</blockquote>

<table border="1" cellpadding="0" cellspacing="0" width="500"><tr><td>
<blockquote>
<p><font face="Tahoma,Arial,Helvetica" size="2"><br><%product%> is now unarchived.

<%install_message%>

<p>Please do not leave your original .tar.gz file in your web directory!

<p>If you have any problems, please visit our <a href="http://gossamer-threads.com/perl/forum/">support forum</a>.
<%message%>
    <br>&nbsp;
    </td></tr></table>

<p><font face="Tahoma,Arial,Helvetica" size="2"><p><font face="Tahoma,Arial,Helvetica" size="2"><b>Copyright 2001 <a href="http://gossamer-threads.com/">Gossamer
Threads Inc.</a></b>&nbsp;</font></p>
</body>
</html>
',
    INSTALL_WARNING => '<p><b>WARNING:</b> Please remove the install.cgi and install.dat file from this directory. It is a security risk to leave those files here.',
    INSTALL_REMOVED => '<p>The install files have been removed. If you need to re-run the install, please unarchive the
                    original file again.',

    OVERWRITE => 'Overwrite',
    BACKUP => 'Backup',
    SKIP => 'Skip',
    INSTALL_FIRST_SCREEN => '
<html>
    <head>
    <title>Welcome to <%product%> <%version%></title>
    </head>
    <body bgcolor="#FFFFFF">
    <form action="install.cgi" method="POST">
    <input type="hidden" name="lite" value="<%lite%>">
    <input type=hidden name="install" value="1">
    <table border="1" cellpadding="0" cellspacing="0" width="500">
    <tr><td bgcolor="#DDDDDD">
        <p align="center"><font face="Tahoma,Arial,Helvetica" size="2">&nbsp;</font><font face="Tahoma,Arial,Helvetica" size="3"><b><%product%>
        Install</b></font>
        </p>
      </td>
    </tr>
    <tr>
      <td>
      <blockquote>
      <p><br>
      <font face="Tahoma,Arial,Helvetica" size="2">Welcome to <%product%>. This program will unarchive <%product%>, and set all the file permissions
      and path to perl properly. You need to know the following information before continuing. Sensible defaults have been chosen, but please double check
      that they are correct.

      <%error%>
      <br>

  <table border="0">
    <%form%>
  </table>
<p align="center"><center><font face="Tahoma,Arial,Helvetica" size="2">&nbsp; <input type="submit" value="Next &gt;&gt;"></center>
</font><br>&nbsp;
</td></tr></table>
</form>
<p><font face="Tahoma,Arial,Helvetica" size="2"><p><font face="Tahoma,Arial,Helvetica" size="2"><b>Copyright 2001 <a href="http://gossamer-threads.com/">Gossamer
Threads Inc.</a></b>&nbsp;</font></p>
</body>
</html>
',
    INSTALL_SECOND_SCREEN_FIRST => '
<html>
    <head>
    <title>Welcome to <%product%></title>
    </head>
    <body bgcolor="#FFFFFF">

    <table border="1" cellpadding="0" cellspacing="0" width="500">
    <tr><td bgcolor="#DDDDDD">
        <p align="center"><font face="Tahoma,Arial,Helvetica" size="2">&nbsp;</font><font face="Tahoma,Arial,Helvetica" size="3"><b><%product%>
        Install</b></font>
        </p>
      </td>
    </tr>
    <tr>
      <td>
      <blockquote>
      <p><br>
      <font face="Tahoma,Arial,Helvetica" size="2">
      We are now going to unarchive the script, please be patient and do not hit stop.
      </font></p>
      </blockquote>
      </td>
    </tr></table>
<blockquote>
<pre>
',
    INSTALL_SECOND_SCREEN_SECOND => '
</pre>
</blockquote>

<table border="1" cellpadding="0" cellspacing="0" width="500"><tr><td>
<blockquote>
<p><font face="Tahoma,Arial,Helvetica" size="2"><br><%product%> is now unarchived.

<%install_message%>

<p>Please do not leave your original .tar.gz file in your web directory!

<p>If you have any problems, please visit our <a href="http://gossamer-threads.com/perl/forum/">support forum</a>.
<%message%>
<br>&nbsp;
</td></tr></table>
<p><font face="Tahoma,Arial,Helvetica" size="2"><p><font face="Tahoma,Arial,Helvetica" size="2"><b>Copyright 2001 <a href="http://gossamer-threads.com/">Gossamer
Threads Inc.</a></b>&nbsp;</font></p>
</body>
</html>
',
    CGI_ERROR_SCREEN => '
<html>
    <head>
    <title>Error</title>
    </head>
    <body bgcolor="#FFFFFF">
    <table border="1" cellpadding="0" cellspacing="0" width="500">
    <tr><td bgcolor="#DDDDDD">
        <p align="center"><font face="Tahoma,Arial,Helvetica" size="2">&nbsp;</font><font face="Tahoma,Arial,Helvetica" size="3"><b>Error</b></font>
        </p>
      </td>
    </tr>
    <tr>
      <td>
      <blockquote>
      <p><br>
      <font face="Tahoma,Arial,Helvetica" size="2">An error occured:

      <%error%>
      <br>
      </blockquote>
</td></tr></table>
<p><font face="Tahoma,Arial,Helvetica" size="2"><p><font face="Tahoma,Arial,Helvetica" size="2"><b>Copyright 2001 <a href="http://gossamer-threads.com/">Gossamer
Threads Inc.</a></b>&nbsp;</font></p>
</body>
</html>
',
    INVALID_RESPONCE => "\nInvalid Responce (%s)\n",
);



%INST::LANG = (
    prompt1 => q|You have selected to perform a fresh install. Please answer the following questions, you can hit enter to accept the default value showin in brackets.|,
    prompt2 => q|Please enter the system path (directory on your server) where Links SQL should store its cgi files. No trailing slash please.|,
    prompt3 => q|Please enter the URL to the directory you just entered. No trailing slash please.|,
    prompt4 => q|Please enter the system path (directory on your server) where Links SQL should generate its html pages. This should NOT be inside cgi-bin. No trailing slashes please.|,
    prompt5 => q|Please enter the URL to the directory you just entered. No trailing slash please.|,
    prompt6 => q|Please enter your Links SQL registration number. If you don't have it handy, you can enter it in later from the Setup->Misc options.|,
    prompt7 => q|Please enter the admin email address. This address will be used in all email correspondance.|,
    prompt8 => q|Please enter either the path to sendmail, or the SMTP server to use when sending email.|,
    prompt9 => q|Please enter the path to perl. The default should be ok if you are not sure.|,
    prompt10 => q|Links SQL has been successfully installed. To finish the setup, please visit:

<a href="<%CGI URL%>/admin/admin.cgi"><%CGI URL%>/admin/admin.cgi</a>

|,
    prompt11 => q|<b>Warning:</b> The upgrade will overwrite any existing templates that are not in a local directory! Links SQL now separates system templates vs. custom templates. You place any custom templates in admin/templates/default/local directory, and system templates in admin/templates/default. See the UPGRADE file for more information.<br><br><b>You must manually backup any templates in admin/templates/default or they will be overwritten!</b>|,
    error1 => q|\nWarning: You do not have a checksum file, so backups will not be able to be performed.\n|,
    error2 => q|Could not load your Links SQL Config file at: %s. Perhaps you entered the path wrong, or permissions are not set properly?|,
    error3 => q|Could not load your config file: |,
    error4 => q|Unable to save your config file. Reason: |,
    error5 => q|Invalid upgrade path. Couldn't upgrade from |,    
);


#--END Libs
}

use strict;
use vars qw/%VERSION_TREE/;

# This has to be updated every release so that an upgrade can "walk" the tree
# to find any upgrade code.
%VERSION_TREE = (
    '200' => '201',
    '201' => '202',
    '202' => '203',
    '203' => '204',
    '204' => '205',
    '205' => '210',
    '210' => '211',
);

main();

sub main {
# ---------------------------------------------------------------
# This is the main code loop. It is ran for every request in CGI 
# mode. All configuration is set up by this function.
#
    my $welcome_format = 'professional';
    my $format         = 'plain';
    my $i = GT::Installer->new(
        product        => 'Links SQL',
        version        => '2.1.1',
        tar_checksum => '8ffea5e7678cbd0a301f212b9c065439',
        load_defaults  => \&load_defaults,
        load_config    => \&load_config,
        save_config    => \&save_config,
        checksums      => "<%CGI Path%>/admin/checksums.dat",
    );

# Display New Install Message
    $i->add_config_message($INST::LANG{prompt1}, $format);

# User CGI directory.
    $i->add_config_message($INST::LANG{prompt2}, $format);
    $i->add_config(
        type            => 'path',
        key             => "CGI Path",
        message         => 'CGI Path',
    );
    $i->add_config_message($INST::LANG{prompt3}, $format);
    $i->add_config(
        type            => 'url',
        key             => "CGI URL",
        message         => 'CGI URL',
        telnet_callback => \&telnet_callback
    );

# Build directory.
    $i->add_config_message($INST::LANG{prompt4}, $format);
    $i->add_config(
        type            => 'path',
        key             => "Build Path",
        message         => 'Build Path',
    );
    $i->add_config_message($INST::LANG{prompt5}, $format);
    $i->add_config(
        type            => 'url',
        key             => "Build URL",
        message         => 'Build URL',
    );

# Registration Number.
    $i->add_config_message($INST::LANG{prompt6}, $format);
    $i->add_config(
        type            => 'reg_number',
        message         => 'Registration Number'
    );

# Email Address
    $i->add_config_message($INST::LANG{prompt7}, $format);
    $i->add_config(
        type            => 'email',
        key             => "Admin Email",
        message         => 'Admin Email',
    );

# Email Server
    $i->add_config_message($INST::LANG{prompt8}, $format);
    $i->add_config(
        type            => 'email_support', 
        message         => 'SMTP/Sendmail',
        key             => 'SMTP/Sendmail'
    );

# Path to perl
    $i->add_config_message($INST::LANG{prompt9}, $format);
    $i->add_config(
        type            => 'perl_path',
        message         => 'Path to Perl'
    );

# The exit message upon a successfull install.
    $i->install_exit_message($INST::LANG{prompt10}, $format);
    $i->upgrade_exit_message($INST::LANG{prompt10}, $format);

# Regex to determine what gets put where.
    $i->install_to(
        '^cgi/(.*)$'    => 'CGI Path',
        '^html/(.*)$'   => 'Build Path'
    );

# Get to specify what the use lib line should point to
    $i->use_lib('<%CGI Path%>/admin');
    $i->use_init(['Links', '<%CGI Path%>/admin']);

# Upgrade prompts.
    $i->add_upgrade_message($INST::LANG{prompt11}, $format);
    $i->add_upgrade(skip => ['ConfigData\.pm$', 'plugin\.cfg', '\.htaccess', '\.htpasswd', 'html/images/default/.*']);
    $i->perform;
}

sub load_defaults {
# ---------------------------------------------------------------
    my ($i) = @_;
    if ($i->{is_cgi}) {
        my $url = $i->{in}->url ( absolute => 1, query_string => 0 );
        my $index = rindex($url, '/');
        my $u = substr($url, 0, $index);
        $i->{defaults}->{"CGI URL"}      ||= $u;
        $i->{defaults}->{"Build URL"}    ||= $u . '/pages';
    }
    my $path = GT::Installer->find_cgi;
    $i->{defaults}->{"CGI Path"}     ||= $path;
    $i->{defaults}->{"Build Path"}   ||= $path . '/pages';
    $i->{defaults}->{"SMTP/Sendmail"}||= GT::Installer->find_sendmail();
    $i->{defaults}->{"Admin Email"}  ||= $ENV{SERVER_ADMIN};
    $i->{defaults}->{"Path to Perl"} ||= GT::Installer->find_perl();

    return 1;
}

sub load_config {
# ---------------------------------------------------------------
    my ($i) = @_;
    my $path = $i->{config}->{GT_ADMIN_PATH} . '/Links/ConfigData.pm';
    -e $path or return $i->disp_error(sprintf ($INST::LANG{error2}, $path));
    local($@, $!);
    my $cfg = do $path;
    if ($@ || $!) {
        return $i->disp_error($INST::LANG{error3} . $@ || $!);
    }
    my ($cgi_path) = $cfg->{admin_root_path} =~ m,(.*)/[^/]+$,;
    $i->{config}->{"CGI Path"}      = $cgi_path;
    $i->{config}->{"CGI URL"}       = $cfg->{db_cgi_url};
    $i->{config}->{"Build Path"}    = $cfg->{build_root_path};
    $i->{config}->{"Build URL"}     = $cfg->{build_root_url};
    $i->{config}->{"SMTP/Sendmail"} = $cfg->{db_mail_path} || $cfg->{db_smtp_server};
    $i->{config}->{"Admin Email"}   = $cfg->{db_admin_email} || '';         
    $i->{config}->{"Path to Perl"}  = $cfg->{path_to_perl};

    $i->{config}->{"Registration Number"} = $cfg->{reg_number};
    return 1;
}

sub save_config {
# ---------------------------------------------------------------
    my $i = shift;

    my $path = $i->{config}->{'CGI Path'} . '/admin/Links/ConfigData.pm';
    if ($i->{installing}) {

# Rewrite the config file
        my $cfg = {};
        $cfg->{admin_root_path}     = $i->{config}->{'CGI Path'} . '/admin';
        $cfg->{admin_root_url}      = $i->{config}->{'CGI URL'}  . '/admin';
        $cfg->{db_cgi_url}          = $i->{config}->{'CGI URL'};
        $cfg->{build_root_path}     = $i->{config}->{'Build Path'};
        $cfg->{build_root_url}      = $i->{config}->{'Build URL'};
        $cfg->{db_admin_email}      = $i->{config}->{'Admin Email'};
        $cfg->{path_to_perl}        = $i->{config}->{'Path to Perl'};
        $cfg->{reg_number}          = $i->{config}->{'Registration Number'};
        $cfg->{debug_level}         = '0',
        $cfg->{db_mail_path}        = ($i->{config}->{email_support} eq 'sendmail') ? $i->{config}->{'SMTP/Sendmail'} : '';
        $cfg->{db_smtp_server}      = ($i->{config}->{email_support} eq 'sendmail') ? '' : $i->{config}->{'SMTP/Sendmail'};
        $cfg->{version}             = $i->{version};
        my $fh = \do{ local *FH; *FH };
        open $fh, ">$path" or return $i->disp_error($INST::LANG{error3} . $!);
        print {$fh} GT::Dumper->dump(var => '', data => $cfg);
        close $fh;
    }

# We are doing an upgrade so we need to merge the new hash
    else {
        my $path = "$i->{config}->{'CGI Path'}/admin/Links/ConfigData.pm";
        $GT::Tar::error ||= ''; # -w warnings
        my $tar_part = $i->{tar}->get_file($path) or return $i->disp_error("Unable to find config file in install.dat!");

        local($!, $@);
        my $cfg = eval $tar_part->body_as_string;
        ($@ || $!) and return $i->disp_error("Unable to load config file ConfigFile from install.dat. Reason: $! $@");
        my $old_cfg = do $path;
        ($@ || $!) and return $i->disp_error("Unable to load original config file '$path'. Reason: $! $@");
        $i->merge_hash($old_cfg, $cfg);
        my $fh = \do{ local *FH; *FH };

# Update the version.
        my $old_ver = $old_cfg->{version};
        my $new_ver = $i->{version};

# Remove -beta, or -de, or -demo.
        $new_ver =~ s/-.+$//;
        $old_ver =~ s/-.+$//;

# Convert to all numbers.
        $old_ver =~ s/\D+//g;
        $new_ver =~ s/\D+//g;

# Run any upgrade scripts
        my $safety = 0;
        while (my $next_ver = $VERSION_TREE{$old_ver}) { # Walk the version upgrade tree
            my $func = "upg_${old_ver}_${next_ver}";
            if (defined &$func) {
                no strict 'refs';
                $func->($i, $old_cfg) or return;
            }
            if ($safety++ > 100) {
                return $i->error ($INST::LANG{error5} . "$old_ver => $next_ver", 'FATAL');
            }
            $old_ver = $next_ver;
        }

# Update the version and save the config file.
        $old_cfg->{version} = $i->{version};

# Save the config file.
        open $fh, ">$path" or return $i->disp_error("Unable to open config file: '$path'. Reason: $!");
        print {$fh} GT::Dumper->dump(var => '', data => $old_cfg);
        close $fh;
    }

# Need to update the path in page.php
    my $file = $i->{config}->{'CGI Path'} . '/page.php';
    if (-e $file and -w _) {
        open (FH, "< $file") or return $i->disp_error ("Unable to open page.php script: '$file'. Reason: $!");
        read (FH, my $data, -s FH);
        close FH;
        $data =~ s,\$admin_root_path = '[^']+',\$admin_root_path = '$i->{config}->{'CGI Path'}/admin',;
        
        open (FH, "> $file") or return $i->disp_error ("Unable to open page.php script: '$file'. Reason: $!");
        print FH $data;
        close FH;
    }    
    return 1;
}

sub upg_205_210 {
# ---------------------------------------------------------------
# Upgrade from 2.0.5 to 2.1.0
#
    my ($i, $old_cfg) = @_;
    $i->print ("\nUpgrading Links SQL from 2.0.5 to 2.1.0 ... \n");
    $i->print ("\tAdding the Review table ... \n");

# Add the review table.
    unshift @INC, $old_cfg->{admin_root_path};
    require GT::SQL;
    require GT::Config;
    my $l  = GT::Config->load ( $old_cfg->{admin_root_path} . '/templates/admin/language.txt' );
    my $DB = GT::SQL->new ( $old_cfg->{admin_root_path} . '/defs' );

    my $c = $DB->creator('Reviews');
    $c->cols ( 
            ReviewID            =>  { pos => 1, type => 'INT', not_null => 1, unsigned => 1, form_display => $l->{'prompt_ReviewID'} },
            Review_LinkID       =>  { pos => 2, type => 'INT', not_null => 1, unsigned => 1, regex => '^\d+$', form_display => $l->{'prompt_Review_LinkID'} },
            Review_Owner        =>  { pos => 3, type => 'CHAR', size => 50, not_null => 1, form_display => $l->{'prompt_Review_Owner'} },
            Review_Rating       =>  { pos => 4, type => 'SMALLINT', unsigned => 1, not_null => 1, default => 0, regex => '^\d+$', form_display => $l->{'prompt_Review_Rating'} },
            Review_Date         =>  { pos => 5, type => 'DATE', not_null => 1, form_display => $l->{'prompt_Review_Date'} },
            Review_Subject      =>  { pos => 6, type => 'CHAR', size => 100, not_null => 1, form_display => $l->{'prompt_Review_Subject'} }, 
            Review_Contents     =>  { pos => 7, type => 'TEXT', not_null => 1, form_display => $l->{'prompt_Review_Contents'} },
            Review_ByLine       =>  { pos => 8, type => 'CHAR', size => 50, form_display => $l->{'prompt_Review_ByLine'} },
            Review_WasHelpful   =>  { pos => 9, type => 'INT', unsigned => 1, regex => '^\d+$', form_display => $l->{'prompt_Review_WasHelpful'} },
            Review_WasNotHelpful=>  { pos => 10, type => 'INT', unsigned => 1, regex => '^\d+$', form_display => $l->{'prompt_Review_WasNotHelpful'} },
            Review_Validated    =>  { pos => 11, type => 'ENUM', values => ['No', 'Yes'], not_null => 1, default => 'No', form_display => $l->{'prompt_Review_Validated'} },
            Review_GuestName    =>  { pos => 12, type => 'CHAR', size => 75, form_display => $l->{'prompt_Review_GuestName'} },
            Review_GuestEmail   =>  { pos => 13, type => 'CHAR', size => 75, regex => '^(?:(?:.+\@.+\..+)|\s*)$', form_display => $l->{'prompt_Review_GuestEmail'} },
        );
    $c->pk('ReviewID');
    $c->ai('ReviewID');
    $c->index ({ rownerndx => ['Review_Owner'], rdatendx => ['Review_Date'], rlinkndx => ['Review_LinkID'] });
    $c->fk ({ Links => { Review_LinkID => 'ID' }, Users => { Review_Owner => 'Username' }});
    if   ($c->create) { $i->print ("\tOk!.\n\n"); }
    else { 
        $GT::SQL::errcode eq 'TBLEXISTS' ? $i->print ("\tFailed: Unable to create table, table already exists!\n\n") : $i->print ("\tFailed: Unable to create table: $GT::SQL::error\n\n"); 
        $c->set_defaults();
        $c->save_schema();
    }

# Alter click track table.
    my $e   = $DB->editor ('ClickTrack');
    $i->print ("\tAdding ReviewID column to ClickTrack table ... \n");
    my $res = $e->add_col ('ReviewID', { type => 'INT', not_null => 1, default => 0});
    if ($res) {
        $i->print ("\tOk!\n");
    }
    else {
        $i->print ("\tFailed: Unable to add review column to click track table!\n");
    }

# Set default review options.
    $old_cfg->{user_review_required}    ||= 1;
    $old_cfg->{reviews_per_page}        ||= 5;
    $old_cfg->{review_sort_by}          ||= 'Review_Date';
    $old_cfg->{review_convert_br_tags}  ||= 1;
    $old_cfg->{review_days_old}         ||= 7;

# Set page.php url.
    $old_cfg->{db_php_url}              ||= $old_cfg->{db_cgi_url};

    $i->print ("Links SQL has been upgraded from 2.0.5 => 2.1.0\n\n");
}

sub upg_203_204 {
# ---------------------------------------------------------------
# Upgrade from 2.0.3 to 2.0.4.
#
    my ($i, $old_cfg) = @_;

    $i->print ("\nUpgrading Links SQL from 2.0.3 to 2.0.4 ... \n", 'none');

# Alter the Links table if upgrading.
    unshift @INC, $old_cfg->{admin_root_path};
    require GT::SQL;
    my $db = GT::SQL->new ( $old_cfg->{admin_root_path} . '/defs' );
    my $t  = $db->table ('Links');
    $i->print ("\nChecking if we need to update any columns: \n", 'none');
    if (! exists $t->cols->{Contact_Name}) {
        $i->print ("\tAdding Contact_Name column ... \n", 'none');
        my $e = $db->editor ('Links');
        my $ret = $e->add_col ('Contact_Name', { type => 'CHAR', size => 255 } );
        $i->print ($ret ? "\tOk!\n" : "Could not add Contact_Name column. Reason: $GT::SQL::error\n", 'none');
    }
    if (! exists $t->cols->{Contact_Email}) {
        $i->print ("\tAdding Contact_Email column ... \n", 'none');
        my $e = $db->editor ('Links');
        my $ret = $e->add_col ('Contact_Email', { type => 'CHAR', size => 255 } );
        $i->print ($ret ? "\tOk!\n" : "Could not add Contact_Email column. Reason: $GT::SQL::error\n", 'none');
    }

# Alter the Category table if upgrading.
    my $c = $db->table ('Category');
    if (! exists $c->cols->{'Category_Template'}) {
        $i->print ("\tAdding Category_Template column ... \n", 'none');
        my $e = $db->editor ('Category');
        my $ret = $e->add_col ('Category_Template', { type => 'CHAR', size => 40 } );
        $i->print ($ret ? "\tOk!\n" : "Could not add Category_Template column. Reason: $GT::SQL::error\n", 'none');
    }

# Double check the MailingIndex table.
    my $m = $db->table ('MailingIndex');
    if (! exists $m->cols->{messageformat}) {
        $i->print ("\tAdding messageformat column to MailingIndex table ... \n", 'none');
        my $e = $db->editor ('MailingIndex');
        my $ret = $e->add_col ('messageformat', { type => 'ENUM', values => [qw[text html]], not_null => 1, default => 'text' });
        $i->print ($ret ? "\tOk!\n" : "Could not add messageformat column. Reason: $GT::SQL::error\n", 'none');
    }
    $i->print ("Links SQL has been successfully upgraded from 2.0.3 to 2.0.4.\n", 'none');
}

sub telnet_callback {
# ---------------------------------------------------------------
# This is called if we are in telnet mode after the admin URL
# is set. It is used to tweek the paths and urls for the rest
# of the install.
#
    my $index;
    my $cfg = $_[0]->{config};
    my $def = $_[0]->{defaults};

# Tweek paths
    $def->{"Build Path"}   = $cfg->{'CGI Path'} . '/pages';

# Tweek urls
    $def->{"Build URL"}    = $cfg->{'CGI URL'} . '/pages';

    return 1;
}
