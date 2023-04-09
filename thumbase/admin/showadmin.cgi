#!/usr/bin/perl

open(D,"admin.htm");
@lines=<D>;
close(D);

print "Content-type: text/html\n\n";
print @lines;