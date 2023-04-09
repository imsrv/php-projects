#include <signal.h>
#include <stdio.h>

#include "signals.h"

int skipTrack = 0;

void parent_signal_handler(int sig)
{
//signal(sig, parent_signal_handler);
psignal(sig, "Parent");
skipTrack = 1;
}

void child_signal_handler(int sig)
{
//signal(sig, child_signal_handler);
psignal(sig, "Child");
}

void init_signal_handler(int pid)
{
if (pid==0)
	{
	if (signal(SIGUSR1, child_signal_handler)==SIG_ERR)
		{
		fprintf(stderr, "Cannot set child signal handler\n");
		exit(1);
		}
	}
else
	{
	if (signal(SIGUSR1, parent_signal_handler)==SIG_ERR)
		{
		fprintf(stderr, "Cannot set child signal handler\n");
		exit(1);
		}
	}
}

