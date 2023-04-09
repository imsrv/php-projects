void start_transmission(int *fd);
void end_transmission(int *fd);
void wait_for_request(int *fd);
void check_control_signals(int *waiting, unsigned long int *len, int *control);
void send_bitrate(int *fd, int rate);
void request_data(int *fd);
void send_length(int *fd, unsigned long int len);
char *get_mp3_data(int *toChild, int *toParent, unsigned long int len);

int bitrate_of(unsigned char *buff, unsigned long int len);

typedef struct mp3_headerSt
{
  int lay;
  int version;
  int error_protection;
  int bitrate_index;
  int sampling_frequency;
  int padding;
  int extension;
  int mode;
  int mode_ext;
  int copyright;
  int original;
  int emphasis;
  int stereo;
} mp3_header_t;


