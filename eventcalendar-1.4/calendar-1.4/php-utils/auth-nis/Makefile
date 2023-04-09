#
# $Id: Makefile,v 1.3 2000/08/18 06:57:12 fluffy Exp $
#

PROGS	= runshcrypt getpwinfo.pl getshcrypt.pl
	
all: $(PROGS)

runshcrypt: runshcrypt.o
	$(CC) $(LDFLAGS) -o $@ $^

%.pl: %.pl.src
	cp $^ $@

include ../Make.common
