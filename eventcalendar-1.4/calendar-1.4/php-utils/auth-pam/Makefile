#
# $Id: Makefile,v 1.3 2000/08/18 06:57:15 fluffy Exp $
#

CHKPASS_LDFLAGS	= -ldl -lpam -lpam_misc -lpwdb -lnsl
PROGS	= chkpass getpwinfo getuidinfo

all: $(PROGS)

chkpass: chkpass.o
	$(CC) $(LDFLAGS) $(CHKPASS_LDFLAGS) -o $@ $^

getpwinfo: getpwinfo.o
	$(CC) $(LDFLAGS) -o $@ $^

getuidinfo: getuidinfo.o
	$(CC) $(LDFLAGS) -o $@ $^

include ../Make.common
