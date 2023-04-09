#include <stdio.h>	/* For printf stuff */
#include <string.h>	/* For strdup */
#include <pwd.h>	/* For getpwnam and passwd struct */
#include <sys/types.h>

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
/*		printf( "Username: %s\n", thePasswd->pw_name );
		printf( "Password: %s\n", thePasswd->pw_passwd );
		printf( "UID: %d\n", thePasswd->pw_uid );
		printf( "GID: %d\n", thePasswd->pw_gid );
		printf( "Gecos: %s\n", thePasswd->pw_gecos );
		printf( "Home: %s\n", thePasswd->pw_dir );
		printf( "Shell: %s\n", thePasswd->pw_shell );
*/
		return 0;
	}
}
