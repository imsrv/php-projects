##############################################################################
# PROGRAM : BuildACommunity.com Perl Module                                  #
# VERSION : 3.1                                                              #
#                                                                            #
# NOTES   :                                                                  #
##############################################################################
# All source code, images, programs, files included in this distribution     #
# Copyright (c) 1999 -> 2017                                                 #
#           Eric L. Pickup, Ecreations, BuildACommunity                      #
#           All Rights Reserved.                                             #
##############################################################################
#                                                                            #
#    ------ DO NOT MODIFY ANYTHING BELOW THIS POINT !!! -------              #
#                                                                            #
##############################################################################

# Cache of files seen, and mapping of patterns to the sizing routine
my %cache = ();

# Try to catch the variants of eol-indicators for the sake of PPM family
my $end = (($^O =~ /Win32/i) ? '\015' :
           ($^O =~ /MacOS/i) ? '\r' : '\n');
my %type_map = ( '^GIF8[7,9]a'              => \&gifsize,
                 "^\xFF\xD8"                => \&jpegsize,
                 "^\x89PNG\x0d\x0a\x1a\x0a" => \&pngsize,
                 "^P[1-6]$end"              => \&ppmsize);

#
# These are lexically-scoped anonymous subroutines for reading the three
# types of input streams. When the input to imgsize() is typed, then the
# lexical "read_in" is assigned one of these, thus allowing the individual
# routines to operate on these streams abstractly.
#

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

sub imgsize
{
    my $stream = shift;

    my ($handle, $header);
    my ($x, $y, $id);
    # These only used if $stream is an existant open FH
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
        #
        # I no longer require $stream to be in the IO::* space. So I'm assuming
        # you don't hose yourself by passing a ref that can't do fileops. If
        # you do, you fix it.
        #
        $handle = $stream;
        $read_in = $read_io;
        $save_pos = tell $handle;
        $need_restore = 1;

        #
        # First alteration (didn't wait long, did I?) to the existant handle:
        #
        # assist dain-bramaged operating systems -- SWD
        # SWD: I'm a bit uncomfortable with changing the mode on a file
        # that something else "owns" ... the change is global, and there
        # is no way to reverse it.
        # But image files ought to be handled as binary anyway.
        #
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

        #first try to open the stream
        $handle = gensym;
        open($handle, "< $stream") or
            return (undef, undef, "Can't open image file $stream: $!");

        # assist dain-bramaged operating systems -- SWD
        binmode($handle);
        read $handle, $header, 256;
        seek($handle, 0, 0);
        $read_in = $read_io;
    }
    $last_pos = 0;

    #
    # Oh pessimism... set the values of $x and $y to the error condition. If
    # the grep() below matches the data to one of the known types, then the
    # called subroutine will override these...
    #
    $id = "Data stream is not a known image file format";
    $x  = undef;
    $y  = undef;

    grep($header =~ /$_/ && (($x, $y, $id) = &{$type_map{$_}}($handle)),
         keys %type_map);

    #
    # Added as an afterthought: I'm probably not the only one who uses the
    # same shaded-sphere image for several items on a bulleted list:
    #
    $cache{$stream} = join(',', $x, $y) unless (ref $stream or (! defined $x));

    #
    # If we were passed an existant file handle, we need to restore the
    # old filepos:
    #
    seek($handle, $save_pos, 0) if ($need_restore);

    # results:
    return (wantarray) ? ($x, $y, $id) : ();
}

sub html_imgsize
{
    my @args = imgsize(@_);

    return ((defined $args[0]) ?
            sprintf("WIDTH=%d HEIGHT=%d", @args) :
            undef);
}

sub attr_imgsize
{
    my @args = imgsize(@_);

    return ((defined $args[0]) ?
            (('-WIDTH', '-HEIGHT', imgsize(@_))[0, 2, 1, 3]) :
            undef);
}

# This used only in gifsize:
sub img_eof
{
    my $stream = shift;

    return ($last_pos >= length($$stream)) if (ref($stream) eq "SCALAR");

    eof $stream;
}



###########################################################################
# Subroutine gets the size of the specified GIF
###########################################################################
sub gifsize
{
    my $stream = shift;

    my ($cmapsize, $buf, $h, $w, $x, $y, $type);

    my $gif_blockskip = sub {
        my ($skip, $type) = @_;
        my ($lbuf);

        &$read_in($stream, $skip);        # Skip header (if any)
        while (1)
        {
            if (&img_eof($stream))
            {
                return (undef, undef,
                        "Invalid/Corrupted GIF (at EOF in GIF $type)");
            }
            $lbuf = &$read_in($stream, 1);        # Block size
            last if ord($lbuf) == 0;     # Block terminator
            &$read_in($stream, ord($lbuf));  # Skip data
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
            # Image Descriptor (GIF87a, GIF89a 20.c.i)
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
            # Extension Introducer (GIF89a 23.c.i, could also be in GIF87a)
            $buf = &$read_in($stream, 1);
            ($x) = unpack("C", $buf);
            if ($x == 0xF9)
            {
                # Graphic Control Extension (GIF89a 23.c.ii)
                &$read_in($stream, 6);    # Skip it
                next FINDIMAGE;       # Look again for Image Descriptor
            }
            elsif ($x == 0xFE)
            {
                # Comment Extension (GIF89a 24.c.ii)
                &$gif_blockskip(0, "Comment");
                next FINDIMAGE;       # Look again for Image Descriptor
            }
            elsif ($x == 0x01)
            {
                # Plain Text Label (GIF89a 25.c.ii)
                &$gif_blockskip(13, "text data");
                next FINDIMAGE;       # Look again for Image Descriptor
            }
            elsif ($x == 0xFF)
            {
                # Application Extension Label (GIF89a 26.c.ii)
                &$gif_blockskip(12, "application data");
                next FINDIMAGE;       # Look again for Image Descriptor
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




# jpegsize: gets the width and height (in pixels) of a jpeg file
# Andrew Tong, werdna@ugcs.caltech.edu           February 14, 1995
# modified slightly by alex@ed.ac.uk
# and further still by rjray@uswest.com
# optimization and general re-write from tmetro@vl.com
sub jpegsize
{
    my $stream = shift;

    my $MARKER      = "\xFF";       # Section marker.

    my $SIZE_FIRST  = 0xC0;         # Range of segment identifier codes
    my $SIZE_LAST   = 0xC3;         #  that hold size info.

    my ($x, $y, $id) = (undef, undef, "could not determine JPEG size");

    my ($marker, $code, $length);
    my $segheader;

    # Dummy read to skip header ID
    &$read_in($stream, 2);
    while (1)
    {
        $length = 4;
        $segheader = &$read_in($stream, $length);

        # Extract the segment header.
        ($marker, $code, $length) = unpack("a a n", $segheader);

        # Verify that it's a valid segment.
        if ($marker ne $MARKER)
        {
            # Was it there?
            $id = "JPEG marker not found";
            last;
        }
        elsif ((ord($code) >= $SIZE_FIRST) && (ord($code) <= $SIZE_LAST))
        {
            # Segments that contain size info
            $length = 5;
            ($y, $x) = unpack("xnn", &$read_in($stream, $length));
            $id = 'JPG';
            last;
        }
        else
        {
            # Dummy read to skip over data
            &$read_in($stream, ($length - 2));
        }
    }

    ($x, $y, $id);
}




