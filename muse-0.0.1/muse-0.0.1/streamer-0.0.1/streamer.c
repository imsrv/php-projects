/*
Streamer.c Copyright Toby Jaffey
Thu Jan 20 04:12:00 GMT 2000
Originally this was a hacked version of shout.
Then, I wrote it in perl, the music kept breaking up on pauses
Then, I wrote it in C, the music kept breaking up on pauses
Then, I wrote another one in C using shared memory between two processes.
It worked.
Then, I discovered what happens when you run out of shared memory keys
Then, I ran fsck and pressed 'y' lots.
Shit.
Started again in C, same idea.
Shared memory became unwieldy.
This is a rewrite from scratch using pipes between processes.
I am pissed off.
*/

#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <sys/types.h>
#include <unistd.h>
#include <fcntl.h>
#include <sys/time.h>
#include <sys/mman.h>
#include <sys/stat.h>

#include "signals.h"
#include "comm.h"
#include "sock.h"

extern int skipTrack;

#define MP3		1
#define ZERO		0
#define MAXZEROSEND	10	// max wait for child to find the file
#define LIFT_MUSIC	"./data/mysound.mp3"
#define PIDFILE		"./data/streamer.pid"

int main(int argc, char *argv[])
{
int pid;	// pid of child/parent
int toParent[2];	// double pipe
int toChild[2];
int control_toParent[2];
int count;
char *mp3data, *offset;
int waiting, playing, gotData;
int s;
int rate;
int fd;
struct stat st;
unsigned long int len, left;
struct timeval oldtime, newtime, timepassed;
int source;
char *nothing;
unsigned long int nothingLen;
char buf[1024];
FILE *fp;
int zeroDataSent;
int nothingRate;

if ((fp = fopen(PIDFILE, "w"))==NULL)
	{
	fprintf(stderr, "Can't open pidfile\n");
	perror("fopen:");
	exit(1);
	}
fprintf(fp, "%d\n", getpid());
fclose(fp);

if ((fd = open(LIFT_MUSIC , O_RDONLY, 0)) < 0)
	{
	fprintf(stderr, "Cannot load nothingness\n");
	perror("open:");
	exit(1);
	}
fstat(fd, &st);
if ((nothing = malloc(st.st_size-128))==NULL)
	{
	fprintf(stderr, "Out of mem\n");
	perror("malloc:");
	exit(1);
	}
if ((read(fd, nothing, st.st_size-128))<st.st_size-128)
	{
	fprintf(stderr, "Cannot read file\n");
	perror("read:");
	exit(1);
	}
nothingLen = st.st_size-128;
close(fd);
nothingRate = bitrate_of(nothing, nothingLen);
if (nothingRate == -1)
	{
	fprintf(stderr, "Can't determine bitrate of nothing\n");
	exit(1);
	}

s = connect_to_server("localhost", 8000);
if (login(s, "hackme", "monkey", "name", "genre", "http://epic.world:8000", 1, 128, "description") < 0)
	{
	fprintf(stderr, "Could not login\n");
	exit(1);
	}

if (pipe(control_toParent) < 0 || pipe(toParent) < 0 || pipe(toChild))
	{
	perror("pipe:");
	exit(1);
	}

if ((pid = fork()) < 0)
	{
	perror("fork:");
	exit(1);
	}
if (pid == 0)
	{
	// child process
	init_signal_handler(pid);
	while(1)
		{
		fprintf(stderr, "Child wakes\n");

		fprintf(stderr, "Waiting for request\n");
		wait_for_request(toChild);
		fprintf(stderr, "Been requested\n");

		if ((fp = popen("./playlist.pl next", "r"))==NULL)
			{
			perror("popen:");
			}
		else
		if (fgets(buf, 1024, fp)==NULL)
			{
			perror("fgets:");
			sleep(5);
			}
		else
			{
			pclose(fp);
			buf[strlen(buf)-1] = '\0';
			if ((fd = open(buf , O_RDONLY, 0))<0)
				{
				fprintf(stderr, "Can't open %s\n", buf);
				perror("open:");
				}
			else
				{
				fstat(fd, &st);
				mp3data = mmap(0, st.st_size, PROT_READ, MAP_SHARED, fd, 0);
				close(fd);
				if (mp3data == MAP_FAILED)
					{
					perror("mmap:");
					}
				else
					{
					count = (unsigned long int)st.st_size;
					offset = mp3data;
					left = st.st_size;

					fprintf(stderr, "Piping data over\n");
					start_transmission(control_toParent);
					send_length(control_toParent, st.st_size);
	
					do
						{
						count = write(toParent[1], offset, count);
						offset += count;
						left -= count;
						}
					while(left > 0L);
					fprintf(stderr, "Data piped over\n");
					end_transmission(control_toParent);
					munmap(mp3data, st.st_size);
					}
				}
			}
		}
	}
else
	{
	// parent process
	init_signal_handler(pid);
	sleep(2);
	fprintf(stderr, "Parent wakes\n");
	len = 0;
	gettimeofday(&newtime, NULL);
	playing = 0;
	rate = 128;
	gotData = 0;
	source = ZERO;
	zeroDataSent = 0;
	mp3data = offset = NULL;

	while(1)
		{
		check_control_signals(&waiting, &len, control_toParent);

		if (skipTrack || zeroDataSent > MAXZEROSEND)
			{
			gotData = 0;
			source = ZERO;
			skipTrack = 0;
			zeroDataSent = 0;
			}

		if (!gotData)
			{
			fprintf(stderr, "Ask for data\n");
			request_data(toChild);
			fprintf(stderr, "Asked for data\n");
			gotData = 1;
			}
		if (waiting == 0x02)	// STX
			{
			fprintf(stderr, "Data ready\n");
			if (mp3data!=NULL)
				free(mp3data);
			offset = mp3data = get_mp3_data(toChild, toParent, len);
			fprintf(stderr, "Data got");
			rate = bitrate_of(mp3data, len);
			fprintf(stderr, "\n\nrate = %d\n\n", rate);
			playing = 1;
			source = MP3;
			}
		if (waiting == 0 && playing == 0)
			{
			source = ZERO;
			offset = nothing;
			zeroDataSent = 0;
			}
		if (source == MP3)
			{
			oldtime.tv_sec = newtime.tv_sec;
			oldtime.tv_usec = newtime.tv_usec;
			gettimeofday(&newtime, NULL);
			timepassed.tv_sec = newtime.tv_sec - oldtime.tv_sec;
			timepassed.tv_usec = newtime.tv_usec - oldtime.tv_usec;
			count = ((rate * 125) * timepassed.tv_usec)/1000000L;
			count += ((rate * 125) * timepassed.tv_sec);

			printf("sending mp3 data %d\n", count); fflush(stdout);
			send_stream(s, offset, count);
			if ((offset - mp3data)<len)
				offset+=count;
			else
				{
				gotData = 0;
				source = ZERO;
				offset = nothing;
				zeroDataSent = 0;
				}
			}
		if (source == ZERO)
			{
			zeroDataSent++;
			oldtime.tv_sec = newtime.tv_sec;
			oldtime.tv_usec = newtime.tv_usec;
			gettimeofday(&newtime, NULL);
			timepassed.tv_sec = newtime.tv_sec - oldtime.tv_sec;
			timepassed.tv_usec = newtime.tv_usec - oldtime.tv_usec;
			count = ((nothingRate * 125) * timepassed.tv_usec)/1000000L;
			count += ((nothingRate * 125) * timepassed.tv_sec);

			printf("sending zero data %d\n", count); fflush(stdout);
			if (count >= nothingLen)
				count = nothingLen;
			send_stream(s, offset, count);
			if ((offset - nothing) < nothingLen)
				offset+=count;
			else
				{
				offset = nothing;
				}
			}

		sleep(1);
		}
	}
free(nothing);
return 0;
}


