#include <stdio.h>
#include <unistd.h>
#include <sys/time.h>
#include <sys/types.h>
#include <stdlib.h>
#include "comm.h"

void start_transmission(int *fd)
{
char c;
c = 0x02;	// send STX to parent
write(fd[1], &c, 1);
}

void end_transmission(int *fd)
{
char c;
c = 0x03;	// send ETX to parent
write(fd[1], &c, 1);
}

void send_length(int *fd, unsigned long int len)
{
unsigned long int l = len;
write(fd[1], &l, sizeof(unsigned long int));
}

void request_data(int *fd)
{
char c;
c = 0x06;	// send ACK to child
write(fd[1], &c, 1);
}

void wait_for_request(int *fd)
{
char c;
read(fd[0], &c, 1);
if (c == 0x03)	// ACK
	return;
else
	{
	if (c==EOF)
		{
		fprintf(stderr, "Child received EOF\n");
		exit(1);
		}
	}
}

void check_control_signals(int *waiting, unsigned long int *len, int *control)
{
// non-block and look for control signals
fd_set rfds;
struct timeval tv;
int flags;
char c;

*waiting = 0;

//fprintf(stderr, "Checking for control sigs\n");

tv.tv_sec = 0;
tv.tv_usec = 1000;
FD_ZERO(&rfds);
FD_SET(control[0], &rfds);
flags = select(control[0]+1, &rfds, NULL, NULL, &tv);
if (flags)
	{
//	fprintf(stderr, "Parent: Control\n");
	if (read(control[0], &c, 1) > 0)
		{
		switch(c)
			{
			case 0x03:
			//fprintf(stderr, "Control: ETX\n");
			(*waiting) = 0x03;
			break;
			case 0x02:
			//fprintf(stderr, "Control: STX\n");
			(*waiting) = 0x02;
			fprintf(stderr, "Reading length\n");
			read(control[0], len, sizeof(unsigned long int));
			fprintf(stderr, "Length read\n");
			break;
			}
		}
	}
//fprintf(stderr, "Finished checking for control signals\n");
}


char *get_mp3_data(int *toChild, int *toParent, unsigned long int len)
{
char *mp3data, *offset;
unsigned long int left;
int count;


if ((mp3data = malloc(len))==NULL)
	{
	fprintf(stderr, "Out of mem\n");
	exit(1);
	}

offset = mp3data;
count = 4096;
left = len;
do
	{
	//fprintf(stderr, "Parent reading: %d\n", (int)left);
	if ((count=read(toParent[0], offset, count))<0)
		{
		perror("read:");
		exit(1);
		}
	offset += count;
	left -= count;
	}
while(left > 0L);
fprintf(stderr, "get_mp3_data: %d\n", count);
return mp3data;
}

