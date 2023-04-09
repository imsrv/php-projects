##################
##  imgsize.pm  ##
##############################################################
##  Library to find the dimensions of GIF and JPEG images.  ##
##  Adopted from Image::Size library.                       ##
##############################################################

package imgsize;

require 5.002;

use strict;
use Symbol;
use Exporter;
use vars qw(@ISA @EXPORT @EXPORT_OK %EXPORT_TAGS $revision $VERSION $read_in $last_pos);

@ISA         = qw(Exporter);
@EXPORT      = qw(imgsize);
@EXPORT_OK   = qw(imgsize);
%EXPORT_TAGS = ('all' => [@EXPORT_OK]);

$revision    = q$Id: Size.pm,v 1.14 1999/03/10 08:02:47 rjray Exp $;
$VERSION     = "2.901";

my %cache = ();

my $end = (($^O =~ /Win32/i) ? '\015' :
           ($^O =~ /MacOS/i) ? '\r' : '\n');

my %type_map = ( '^GIF8[7,9]a'              => \&gifsize,
                 "^\xFF\xD8"                => \&jpegsize);

my $read_io = sub {
    my $handle = shift;
    my ($length, $offset) = @_;

    if (defined($offset) && ($offset != $last_pos))
    {
        $last_pos = $offset;
        return '' if (! seek($handle, $offset, 0));
    }

    my ($data, $rtn) = ('', 0);
    $rtn = read $handle, $data, $length;
    $data = '' unless ($rtn);
    $last_pos = tell $handle;

    $data;
};

my $read_buf = sub {
    my $buf = shift;
    my ($length, $offset) = @_;

    if (defined($offset) && ($offset != $last_pos))
    {
        $last_pos = $offset;
        return '' if ($last_pos > length($$buf));
    }

    my $data = substr($$buf, $last_pos, $length);
    $last_pos += length($data);

    $data;
};

1;

sub imgsize {
    my $stream = shift;

    my ($handle, $header);
    my ($x, $y, $id);
    my ($save_pos, $need_restore) = (0, 0);

    $header = '';

    if (ref($stream) eq "SCALAR")
    {
        $handle = $stream;
        $read_in = $read_buf;
        $header = substr($$handle, 0, 256);
    }
    elsif (ref $stream)
    {
        $handle = $stream;
        $read_in = $read_io;
        $save_pos = tell $handle;
        $need_restore = 1;

        binmode($handle);
        seek($handle, 0, 0);
        read $handle, $header, 256;
        seek($handle, 0, 0);
    }
    else
    {
        if (-e "$stream" && exists $cache{$stream})
        {
            return (split(/,/, $cache{$stream}));
        }

        $handle = gensym;
        open($handle, "< $stream") or
            return (undef, undef, "Can't open image file $stream: $!");

        binmode($handle);
        read $handle, $header, 256;
        seek($handle, 0, 0);
        $read_in = $read_io;
    }
    $last_pos = 0;

    $id = "Data stream is not a known image file format";
    $x  = undef;
    $y  = undef;

    grep($header =~ /$_/ && (($x, $y, $id) = &{$type_map{$_}}($handle)),
         keys %type_map);

    $cache{$stream} = join(',', $x, $y) unless (ref $stream or (! defined $x));

    seek($handle, $save_pos, 0) if ($need_restore);

    return (wantarray) ? ($x, $y, $id) : ();
}

sub img_eof {
    my $stream = shift;

    return ($last_pos >= length($$stream)) if (ref($stream) eq "SCALAR");

    eof $stream;
}

sub gifsize {
    my $stream = shift;

    my ($cmapsize, $buf, $h, $w, $x, $y, $type);

    my $gif_blockskip = sub {
        my ($skip, $type) = @_;
        my ($lbuf);

        &$read_in($stream, $skip);
        while (1)
        {
            if (&img_eof($stream))
            {
                return (undef, undef,
                        "Invalid/Corrupted GIF (at EOF in GIF $type)");
            }
            $lbuf = &$read_in($stream, 1);
            last if ord($lbuf) == 0;
            &$read_in($stream, ord($lbuf));
        }
    };

    $type = &$read_in($stream, 6);
    if (length($buf = &$read_in($stream, 7)) != 7 )
    {
        return (undef, undef, "Invalid/Corrupted GIF (bad header)");
    }
    ($x) = unpack("x4 C", $buf);
    if ($x & 0x80)
    {
        $cmapsize = 3 * (2**(($x & 0x07) + 1));
        if (! &$read_in($stream, $cmapsize))
        {
            return (undef, undef,
                    "Invalid/Corrupted GIF (global color map too small?)");
        }
    }

  FINDIMAGE:
    while (1)
    {
        if (&img_eof($stream))
        {
            return (undef, undef,
                    "Invalid/Corrupted GIF (at EOF w/o Image Descriptors)");
        }
        $buf = &$read_in($stream, 1);
        ($x) = unpack("C", $buf);
        if ($x == 0x2c)
        {
            if (length($buf = &$read_in($stream, 8)) != 8)
            {
                return (undef, undef,
                        "Invalid/Corrupted GIF (missing image header?)");
            }
            ($x, $w, $y, $h) = unpack("x4 C4", $buf);
            $x += $w * 256;
            $y += $h * 256;
            return ($x, $y, 'GIF');
        }
        if ($x == 0x21)
        {
            $buf = &$read_in($stream, 1);
            ($x) = unpack("C", $buf);
            if ($x == 0xF9)
            {
                &$read_in($stream, 6);
                next FINDIMAGE;
            }
            elsif ($x == 0xFE)
            {
                &$gif_blockskip(0, "Comment");
                next FINDIMAGE;
            }
            elsif ($x == 0x01)
            {
                &$gif_blockskip(13, "text data");
                next FINDIMAGE;
            }
            elsif ($x == 0xFF)
            {
                &$gif_blockskip(12, "application data");
                next FINDIMAGE;
            }
            else
            {
                return (undef, undef,
                        sprintf("Invalid/Corrupted GIF (Unknown " .
                                "extension %#x)", $x));
            }
        }
        else
        { 
            return (undef, undef,
                    sprintf("Invalid/Corrupted GIF (Unknown code %#x)",
                            $x));
        }
    }
}


sub jpegsize {
    my $stream = shift;

    my $MARKER      = "\xFF";

    my $SIZE_FIRST  = 0xC0;
    my $SIZE_LAST   = 0xC3;

    my ($x, $y, $id) = (undef, undef, "could not determine JPEG size");

    my ($marker, $code, $length);
    my $segheader;

    &$read_in($stream, 2);
    while (1)
    {
        $length = 4;
        $segheader = &$read_in($stream, $length);

        ($marker, $code, $length) = unpack("a a n", $segheader);

        if ($marker ne $MARKER)
        {
            $id = "JPEG marker not found";
            last;
        }
        elsif ((ord($code) >= $SIZE_FIRST) && (ord($code) <= $SIZE_LAST))
        {
            $length = 5;
            ($y, $x) = unpack("xnn", &$read_in($stream, $length));
            $id = 'JPG';
            last;
        }
        else
        {
            &$read_in($stream, ($length - 2));
        }
    }

    ($x, $y, $id);
}
