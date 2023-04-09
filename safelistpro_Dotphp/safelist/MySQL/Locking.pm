#########################################################
#               File Locking Routines                   #
#########################################################
#                                                       #
# This script was created by:                           #
#                                                       #
# PerlCoders Web Specialties PTY.                       #
# http://www.perlcoders.com                             #
#                                                       #
# This script and all included modules, lists or        #
# images, documentation are copyright only to           #
# PerlCoders PTY (http://perlcoders.com) unless         #
# otherwise stated in the module.                       #
#                                                       #
# Purchasers are granted rights to use this script      #
# on one site. extra site licenses can be purchased     #
# at http://perlcoders.com                              #
#                                                       #
# Any copying, distribution, modification with          #
# intent to distribute as new code will result          #
# in immediate loss of your rights to use this          #
# program as well as possible legal action.             #
#                                                       #
# This and many other fine scripts are available at     #
# the above website or by emailing the authors at       #
# staff@perlcoders.com or info@perlcoders.com           #
#                                                       #
#########################################################

use Fcntl ':flock';

# call with &LockDB(filehandle);
sub LockDB {
	$filehandle=shift;
	flock($filehandle,2);
	seek($filehandle, 0, 2);
}
# call with &UnlockDB(filehandle);
sub UnlockDB {
	$filehandle=shift;
	flock($filehandle,8);
}

1; # dont touch this at all

        
        