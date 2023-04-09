void disconnect_from_server(int s);
int connect_to_server(char *hostname, int port);
int login(int s, char *password, char *mountpoint, char *name, char *genre, char *url, int public, int bitrate, char *description);
void send_stream(int s, char *data, unsigned long int len);
