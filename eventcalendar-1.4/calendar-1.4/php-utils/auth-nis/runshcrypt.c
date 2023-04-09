/*
	This file will just make a execve call to getshcrypt.pl
	The "env" path will need to be set so that getshcrypt.pl
	can find all the programs it needs to run (basically yppasswd
	and grep).
	you'll also have to adjust the line that executes execve 
	and give it the correct path to your executable
	this will need to be setuid, as it needs to read /etc/shadow
*/

#include <stdlib.h>
#include <unistd.h>
#include <stdio.h>

int main(int argc, char* argv[]) {
	char* env[] = { "PATH=/usr/bin",NULL };
	char* myinput[2];
	myinput[2]=argv[0]; // this sets the name the perl script will be run with
	if (argc>1) { myinput[1]=argv[1]; } 
	else { myinput[1]=NULL; }

	if ( setuid(0) ) {
		perror("Cannot set uid");
		return EXIT_FAILURE;
	}

	execve("/usr/local/php3/getshcrypt.pl", myinput, env);
	perror("execve failed to execute");
	return EXIT_FAILURE;

}
