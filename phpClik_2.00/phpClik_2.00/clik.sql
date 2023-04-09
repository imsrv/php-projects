   CREATE TABLE clik (
          id BIGINT NOT NULL AUTO_INCREMENT,
          url char(255),
          time date,
	  host char(40),
          ip char(20),
          ref char(255),
          agent char(50),
          os char(50),
          PRIMARY KEY (id)
	);


