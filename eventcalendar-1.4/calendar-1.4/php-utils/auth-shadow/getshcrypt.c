#include <stdio.h>	/* For printf stuff */

#include <pwd.h>	/* For getpwnam and passwd struct */
#include <sys/types.h>

#include <shadow.h>	/* For getspnam and spwd struct */

#include <string.h>	/* For string stuff */

#include <unistd.h>

int main( int argc, char **argv ) {
	if ( argc != 2 ) {
		fprintf( stderr, "Error: Usage: %s username\n", argv[0] );
		return -1;
	} else {
		struct spwd *theShadow;
		char *username = strdup( argv[1] );

#ifdef DEBUG
		printf( "Username: %s\n", username );
#endif

		if ( (theShadow = getspnam( username )) == NULL ) {
			fprintf( stderr, "Error: getspnam() returned NULL\n" );
			return -2;
		}

#ifdef DEBUG
		printf( "Shadow Username: %s\n", theShadow->sp_namp );
		printf( "Shadow Password: %s\n", theShadow->sp_pwdp );
#endif

		printf( "%s\n", theShadow->sp_pwdp );
		return 0;		

	}
}
