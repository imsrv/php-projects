#!/usr/bin/perl

open(D,"frame.htm");
@lines=<D>;
close(D);

print "Content-type: text/html\n\n";
print @lines;