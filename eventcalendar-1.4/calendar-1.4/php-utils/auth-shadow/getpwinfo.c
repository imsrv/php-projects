#include <stdio.h>	/* For printf stuff */

#include <pwd.h>	/* For getpwnam and passwd struct */
#include <sys/types.h>

#include <string.h>	/* For string stuff */

int main( int argc, char **argv ) {
	if ( argc != 2 ) {
		fprintf( stderr, "Error: Usage: %s username\n", argv[0] );
		return -1;
	} else {
		struct passwd *thePasswd;
		char *username = strdup( argv[1] );

#ifdef DEBUG
		printf( "Username: %s\n", username );
#endif

		if ( (thePasswd = getpwnam( username )) == NULL ) {
			fprintf( stderr, "Error: getpwnam() returned NULL\n" );
			return -2;
		}

		printf( "%s:%s:%d:%d:%s:%s:%s\n", thePasswd->pw_name,
			thePasswd->pw_passwd, thePasswd->pw_uid,
			thePasswd->pw_gid, thePasswd->pw_gecos,
			thePasswd->pw_dir, thePasswd->pw_shell );

		return 0;
	}
}
