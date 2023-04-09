#include <stdio.h>
#include <sys/types.h>
#include <sys/socket.h>
#include <netinet/in.h>
#include <netdb.h>
#include <string.h>
#include <unistd.h>

#include "sock.h"

int connect_to_server(char *hostname, int port)
{
int s;
struct hostent *hp;
struct sockaddr_in name;
int len;

if ((hp = gethostbyname(hostname)) == NULL)
	{
	fprintf(stderr, "Can't resolve hostname: %s\n", hostname);
	perror("gethostbyname:");
	return -1;
	}

if ((s = socket (AF_INET, SOCK_STREAM, 6)) < 0)
	{
	fprintf(stderr, "Can't create socket\n");
	perror("socket:");
	return -1;
	}

memset(&name, 0, sizeof (struct sockaddr_in));
name.sin_family = AF_INET;
name.sin_port = htons(port);
memcpy(&name.sin_addr, hp->h_addr_list[0], hp->h_length);
len = sizeof (struct sockaddr_in);

if (connect (s, (struct sockaddr *) &name, len) < 0)
	{
	fprintf(stderr, "Can't connect to: %s\n", hostname);
	perror("connect:");
	return -1;
	}
return s;
}

void disconnect_from_server(int s)
{
close(s);
}


int login(int s, char *password, char *mountpoint, char *name, char *genre, char *url, int public, int bitrate, char *description)
{
char buf[1024];
int readbytes = 0, readb = 0;

snprintf(buf, 1024, "SOURCE %s ", password);
send(s, buf, strlen(buf), 0);
snprintf(buf, 1024, "/%s\n\n", mountpoint);
send(s, buf, strlen(buf), 0);
snprintf (buf, 1024, "x-audiocast-name:%s\n", name);
send(s, buf, strlen(buf), 0);
snprintf (buf, 1024, "x-audiocast-genre:%s\n", genre);
send(s, buf, strlen(buf), 0);
snprintf (buf, 1024, "x-audiocast-url:%s\n", url);
send(s, buf, strlen(buf), 0);
snprintf (buf, 1024, "x-audiocast-public:%d\n", public);
send(s, buf, strlen(buf), 0);
snprintf (buf, 1024, "x-audiocast-bitrate:%d\n", bitrate);
send(s, buf, strlen(buf), 0);
snprintf (buf, 1024, "x-audiocast-description:%s\n\n", description);
send(s, buf, strlen(buf), 0);

do
	{
	readb = recv (s, &buf[readbytes], 100, 0);
	if (readb < 0)
		{
		fprintf(stderr, "Error in read, exiting\n");
		perror ("read:");
		exit(1);
		}
	if (readb > 0)
	readbytes += readb;
	}
while (readb <= 0);

return 0;
}

void send_stream(int s, char *data, unsigned long int len)
{
send(s, data, len, 0);
}
