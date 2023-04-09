CREATE TABLE noticias (
id int(5) NOT NULL auto_increment,
fonte char(30) NOT NULL ,
endfonte char(30) NOT NULL ,
email char(80) ,
data date NOT NULL,
hora time NOT NULL ,
titulo char(100) NOT NULL ,
subtitulo text NOT NULL ,
texto text NOT NULL ,
atualiza text NOT NULL ,
ver char(3) DEFAULT 'on' ,
PRIMARY KEY (id),
UNIQUE id (id)
);