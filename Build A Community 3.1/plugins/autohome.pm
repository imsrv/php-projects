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
	sub MYPHOTO {
		undef $OUT;
		&myphoto;
		return $OUT;
	}

	sub MYCUSTOM1 {
		require "./my/custom.pm";
		undef $OUT;
		&mycustom1;
		return $OUT;
	}

	sub MYCUSTOM2 {
		require "./my/custom.pm";
		undef $OUT;
		&mycustom2;
		return $OUT;
	}

	sub MYCUSTOM3 {
		require "./my/custom.pm";
		undef $OUT;
		&mycustom3;
		return $OUT;
	}

	sub MYCUSTOM4 {
		require "./my/custom.pm";
		undef $OUT;
		&mycustom4;
		return $OUT;
	}

	sub MYCUSTOM5 {
		require "./my/custom.pm";
		undef $OUT;
		&mycustom5;
		return $OUT;
	}

	sub MYFORUMS {
		require "./my/cforums.pm";
		undef $OUT;
		&myforums;
		return $OUT;
	}

	sub MYADDRESSBOOK {
		undef $OUT;
		&myaddresses;
         	return $OUT;
	}

	sub MYNEWS {
		undef $OUT;
		&my_news;
		return $OUT;
	}
	sub MYTHREADS {
		require "./my/gossamerthreads.pm";
		undef $OUT;
		&my_gossamerthreads;
         	return $OUT;
	}
	sub MYHYPERSEEK {
		require "./my/hyperseek.pm";
		undef $OUT;
		&my_hyperseek;
         	return $OUT;
	}

	sub MYTODO {
		undef $OUT;
		&mytodo;
		return $OUT;
	}

	sub MYHOROSCOPE {
		require "./my/horoscope.pm";
		undef $OUT;
		&myhoroscope;
         	return $OUT;
	}

	sub MYCLOSED {
		undef $OUT;
		&closed;
		return $OUT;
	}

	sub MYLINKS {
		undef $OUT;
		&my_links;
         	return $OUT;
	}

	sub MYOFTHEDAY {
		undef $OUT;
		&my_oftheday;
		return $OUT;
	}

1;
