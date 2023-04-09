#
# $Id: Makefile,v 1.3 2000/08/18 06:57:42 fluffy Exp $
#

GETSHCRYPT_LDFLAGS	= -lcrypt
PROGS	= getshcrypt getpwinfo getuidinfo

all: $(PROGS)

getshcrypt: getshcrypt.o
	$(CC) $(LDFLAGS) $(GETSHCRYPT_LDFLAGS) -o $@ $^

getpwinfo: getpwinfo.o
	$(CC) $(LDFLAGS) -o $@ $^

getuidinfo: getuidinfo.o
	$(CC) $(LDFLAGS) -o $@ $^

include ../Make.common
