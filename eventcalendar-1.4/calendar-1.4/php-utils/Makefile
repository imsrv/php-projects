#
# $Id: Makefile,v 1.4 2000/09/18 02:15:40 fluffy Exp $
#

DIRS	= auth-pam auth-shadow auth-nis

all: FORCE
	for i in $(DIRS); do \
		cd $$i; make; cd ..; done

install: $(DIRS)
	for i in $(DIRS); do \
		cd $$i; make install; cd ..; done	

auth-% : FORCE
	cd $@; make; cd ..

%/install: FORCE
	cd $(@D); make install; cd ..

clean:
	for i in $(DIRS); do \
		cd $$i; make clean; cd ..; done

FORCE:
