%define name      photoseek
%define version   0.3
%define packaging 0.20000913mdk
%define psroot    /home/httpd/photoseek

Summary: web-based media management system, written in PHP
Name: %{name}
Version: %{version}
Release: %{packaging}
Copyright: GPL
Group: Graphics
URL: http://%{name}.sourceforge.net/
Source: http://download.sourceforge.net/%{name}/%{name}-%{version}.tar.bz2
BuildRoot: %{_tmppath}/%{name}-buildroot
Prefix: %{_prefix}
Buildarch: noarch
Requires: apache >= 1.3.9, php, phpwebtools >= 0.1

%description
Photoseek is a web-based media management package written in PHP which allows
automagic cataloging, editing, searching and downloading of images via their
internal IPTC tags (such as the ones used in Adobe Photoshop (tm)).

%changelog

* Wed Sep 13 2000 rufus t firefly <rufus.t.firefly@linux-mandrake.com>
  - v0.3-0.20000913mdk

* Fri Sep 08 2000 rufus t firefly <rufus.t.firefly@linux-mandrake.com>
  - v0.3-0.20000908mdk

* Wed May 10 2000 rufus t firefly <rufus.t.firefly@linux-mandrake.com>
  - v0.2.2
  - initial packaging

%prep
%setup -n %{name}

%build
# no build required

%install
rm -rf $RPM_BUILD_ROOT
mkdir -p $RPM_BUILD_ROOT%{prefix}/bin/
mkdir -p $RPM_BUILD_ROOT%{psroot}/img-tree/
install -m 755 -o 0 -g 0 {catalog-all.pl,catalog.sh} \
  $RPM_BUILD_ROOT%{prefix}/bin/
install -m 644 -o 0 -g 0 *.{php,inc,gif}             \
  $RPM_BUILD_ROOT%{psroot}
install -m 644 -o 0 -g 0 img-tree/*.gif              \
  $RPM_BUILD_ROOT%{psroot}/img-tree/

%post
# install Apache hooks
echo -n " * Adding hooks to Apache ... "
echo "Alias /photoseek %{psroot}" >> /etc/httpd/conf/httpd.conf
echo    "[done]"
/usr/sbin/apachectl restart

# AUTODETECTING ROUTINES
cd $RPM_BUILD_ROOT%{psroot}
CONVERT_EXEC=`which convert`
if [ -f $CONVERT_EXEC ]; then
	echo -n " * Found 'convert' in $CONVERT_EXEC ... "
	perl -pi -e "s|/usr/X11R6/bin/convert|$CONVERT_EXEC||g;" config.inc
	echo    "[done]"
fi

for FIND_THIS in {djpeg,pnmscale,cjpeg}; do
	FIND_EXEC=`which $FIND_THIS`
	if [ -f $FIND_EXEC ]; then
		echo -n " * Found '$FIND_THIS' in $FIND_EXEC ... "
		perl -pi -e "s|/usr/bin/$FIND_THIS|$FIND_EXEC||g;" config.inc
		echo    "[done]"
	else
		echo    " * '$FIND_THIS' not found... possible error"
	fi
done

# ***********************
#  check for zip support   
# ***********************
ZIP_EXEC=`which zip`
if [ -f $ZIP_EXEC ]; then
	echo -n " * Found 'zip' in $ZIP_EXEC ... "
	perl -pi -e "s|/usr/bin/zip|$ZIP_EXEC||g;" config.inc
	echo    "[done]"
else
	echo -n " * No 'zip' found, removing support ... " 
	perl -pi -e "s|ZIP_ENABLED, true|ZIP_ENABLED, false||g;" config.inc
	echo    "[done]"
fi

# **************************
#  check for binhex support
# **************************
BINHEX_EXEC=`which binhex`
if [ -f $BINHEX_EXEC ]; then
	echo -n " * Found 'binhex' in $BINHEX_EXEC ... "
	perl -pi -e "s|/usr/bin/binhex|$BINHEX_EXEC||g;" config.inc
	echo    "[done]"
else
	echo -n " * No 'binhex' found, removing support ... " 
	perl -pi -e "s|BINHEX_ENABLED, true|BINHEX_ENABLED, false||g;" \
	  config.inc
	echo    "[done]"
fi

%postun
# remove apache hooks
echo -n " * Removing hooks from Apache ... "
perl -pi -e "s|^Alias /photoseek %{psroot}|||g;" /etc/httpd/conf/httpd.conf
echo    "[done]"
/usr/sbin/apachectl restart

%clean
rm -rf $RPM_BUILD_ROOT

%files
%defattr (-,root,root)
%doc AUTHORS CHANGELOG INSTALL LICENSE MAGIC_FIX README README-EPS
%doc PhotoSeek.db.mysql PhotoSeek.db.pgsql
%{prefix}/bin/*
%dir %{psroot}
%{psroot}/*.gif
%{psroot}/*.inc
%{psroot}/*.php
%dir %{psroot}/img-tree/
%{psroot}/img-tree/*.gif
