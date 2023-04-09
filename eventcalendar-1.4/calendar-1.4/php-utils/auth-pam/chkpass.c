/*
 * Portions written by Cristian Gafton <gafton@redhat.com>
 * for the passwd suite (pwdstat.c)
 * Modified for the calendar-1.0 php3 suite of scripts by
 * Bruce Tenison <btenison@dibbs.net>
 */

#include <ctype.h>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>

#include <unistd.h>
#include <sys/types.h>

#include <security/pam_appl.h>
#include <security/pam_misc.h>
#include <pwd.h>

#define MAX_USERNAMESIZE 32
#define MAX_PASSWORDSIZE 8

char *progname  = NULL; /* name of the current program */
char *username	= NULL; /* username we are checking the password for */
char *password	= NULL; /* plaintext password for the above username */

/* a dummy coversation function */
static int dummy_conv(int num_msg,
			const struct pam_message **msg,
			struct pam_response **resp,
			void *appdata_ptr)
{
    int i;
    struct pam_response *response = NULL;

    response = malloc(sizeof(struct pam_response) * num_msg);

    if(response == (struct pam_response *)0)
	return PAM_CONV_ERR;

    for(i = 0; i < num_msg; i++) {
	response[i].resp_retcode = PAM_SUCCESS;

	switch(msg[i]->msg_style) {
	    case PAM_PROMPT_ECHO_ON:
		response[i].resp = username;
		break;

	    case PAM_PROMPT_ECHO_OFF:
		response[i].resp = password;
		break;

	    case PAM_TEXT_INFO:
	    case PAM_ERROR_MSG:
		/* ignore it, but pam still wants a NULL response... */
		response[i].resp = NULL;
		break;

	    default:
		/* Must be an error of some sort... */
		free(response);
		return PAM_CONV_ERR;
	}
    }

    *resp = response;
    return PAM_SUCCESS;
}


/* conversation function & corresponding structure */
static struct pam_conv conv = {
    &dummy_conv,
    NULL
};

int main(int argc, char * const argv[])
{
    int retval;
    pam_handle_t *pamh=NULL;

    progname = basename(argv[0]);
    if (argc != 3) {
/* Error, wrong number of arguments.  Explain it. */
      fprintf(stderr, "Error!  Wrong number of arguments\n");
      fprintf(stderr, "Usage:\n");
      fprintf(stderr, "\t%s <username> <password>\n",progname);
      return(1);
    }

    username = argv[1];
/* test the username for length */
    if (strlen(username) > MAX_USERNAMESIZE) {
      fprintf(stderr, "%s: The username supplied is too long\n",
             progname);
      return(1);
    }

    password = argv[2];
/* test the username for length */
    if (strlen(password) > MAX_PASSWORDSIZE) {
      fprintf(stderr, "%s: The password supplied is too long\n",
             progname);
      return(1);
    }


    retval = pam_start("passwd", username, &conv, &pamh);
    while (retval == PAM_SUCCESS) {      /* use loop to avoid goto... */

	retval = pam_authenticate(pamh, PAM_DISALLOW_NULL_AUTHTOK);
	if (retval != PAM_SUCCESS)
	    break;
	/* all done */
	retval = pam_end(pamh, PAM_SUCCESS);
	if (retval != PAM_SUCCESS)
	    break;
	/* quit gracefully */
	return(0);
    }

    if (retval != PAM_SUCCESS)
	fprintf(stderr, "%s: %s\n", progname, pam_strerror(pamh, retval));

    if (pamh != NULL) {
	(void) pam_end(pamh,PAM_SUCCESS);
	pamh = NULL;
    }

    return(1);
}
