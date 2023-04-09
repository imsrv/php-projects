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
	sub GALLERYLOCATION {
		return $LOCATION;
	}

	sub DIRECTORIES {
		return $DIRECTORIES;
	}

	sub IMAGES {
		return $IMAGES;
	}

	sub GALERYRATEIT {
		return "$CONFIG{'CGI_DIR'}\/$CONFIG{'GALLERY_script_name'}?action=top";
     	}

	sub GALERYSIZE {
		return "$CONFIG{'CGI_DIR'}\/$CONFIG{'GALLERY_script_name'}?action=size";
     	}

	sub GALERYDATE {
		return "$CONFIG{'CGI_DIR'}\/$CONFIG{'GALLERY_script_name'}?action=date";
	}

	sub GALERYHITS {
		return "$CONFIG{'CGI_DIR'}\/$CONFIG{'GALLERY_script_name'}?action=hits";
	}

1;
