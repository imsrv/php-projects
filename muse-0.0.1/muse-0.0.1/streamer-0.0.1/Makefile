CC = gcc -Wall -O6 -g

SRCS = signals.c streamer.c comm.c sock.c mpeg.c
OBJS = $(SRCS:.c=.o)
LIBS = -lefence

all: streamer

.c.o:
	$(CC) -c $*.c -o $*.o

streamer: $(OBJS)
	$(CC) $(LIBS) $(OBJS)  -o $@

clean: 
	rm -f *~ *.o streamer
