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
	sub TEXT {
		my $file = $_[0];

		$file =~ s/\W//g;
		my $fn = $GPath{'template_data'} . "/inserts/" . $file;

		open(FILE, $fn) || return ("Can't open file $fn: $!");
		my $AD = undef;
		foreach my $entry (<FILE>) {
			$AD .= $entry;	
		}
   		close(FILE);  
		return $AD;
	}

	sub PAGEVIEWS {
		my $fn = $_[0];
		my $day= &US_Date;
		$fn =~ s/\W//g;
		$day =~ s/\///g;
		$fn=$fn || "default";
		$fn = $fn . $day . "txt";
		my $lock = $fn;
		$fn= "$GPath{'counter_data'}/$fn";
		&lock($lock);
		open (FILE, $fn);
		my @t = <FILE>;
	   	close(FILE);  
		open (FILE, ">$fn")|| return ("Can't open file $fn: $!");
		print FILE ++$t[0];
   		close(FILE);
		&unlock($lock);
 		return $t[0];
	}

	sub DATE {
		return &Long_Date(time);
	}

	sub SHORTDATE {
		return &Short_Date(time);
	}

	sub USDATE {
		return &US_Date(time);
	}

	sub REFERER {
		return $ENV{'HTTP_REFERER'};
	}

	sub BANNER {
		$GUrl{'adm_click.cgi'} = "$CONFIG{'CGI_DIR'}/adm_click.cgi";
		$GUrl{'adm.cgi'} = "$CONFIG{'CGI_DIR'}/adm.cgi";
		$GUrl{'adms.cgi'} = "$CONFIG{'CGI_DIR'}/adms.cgi";
		$GUrl{'adm_report.cgi'} = "$CONFIG{'CGI_DIR'}/report.cgi";

		my $BANNER = undef;
		my $BM = undef;
		my $grp = $_[0];
		if (-e "$GPath{'admaster.pm'}") {
			require "$GPath{'admaster.pm'}";
			$BM = "T";
		}
		elsif (-e "IWeb/admaster.pm") {
			require "IWeb/admaster.pm";
			$BM = "T";
		}

		if ($BM eq "T") {
			$grp =~ s/\W//g;

			if ($GENERATED eq "T") {
				$BANNER = "<!--#include virtual=\"$GUrl{'adm.cgi'}\"-->\n";
			}
			else {
				if ($grp ne "") {
					$BANNER = &Group_Banner($grp);
				}
				else {
					$BANNER = &Group_Banner($GROUP);
				}
			}
		}

		return $BANNER;
	}

	sub BODY {
		if ($_[0] eq "run") {
			&Body;
			return $OUT;
		}
		else {
			return $BODY;
		}
	}

	sub CONTROL_PANEL {
		my $template = new Text::Template (DELIMITERS => [$open_deliminator, $close_deliminator], TYPE => FILE,  SOURCE => "$GPath{'source_templates'}/cforum/controlpanel.tmplt");
		my $cp = $template->fill_in;
#		$LOWLEVELTEMPLATE = "$GPath{'source_templates'}/cforum/controlpanel.tmplt";
		return $cp;
	}

	sub _VIEWCARDS {
		return "$$GUrl{'viewcard.cgi'}";
	}

	sub _BUTTONDIR {
		return $CONFIG{'button_dir'};
	}

	sub _REGISTER {
		return "$GUrl{'register.cgi'}";
	}

	sub _WEBPAGEEDITOR {
		return "$GUrl{'community.cgi'}";
	}

	sub _WEBPAGE {
		return $IUSER{'url'};
	}

	sub _PROFILE {
		return "$GUrl{'profile.cgi'}";
	}

	sub _POSTCARDS {
		return "$GUrl{'postcards.cgi'}";
	}

	sub _AUTOGALLERY {
		return "$GUrl{'photogallery.cgi'}";
	}

	sub _CONTACTINFORMATION {
		return "$GUrl{'profile.cgi'}?go=direct&action=Change+Contact+Information";
	}

	sub _MYHOME {
		return "$GUrl{'myhome.cgi'}";
	}

	sub _MYREMINDERS {
		return "$GUrl{'myreminder.cgi'}?action=view";
	}
1;
