CREATE TABLE snipe_gallery_cat (
   id int(11) NOT NULL auto_increment,
   cat_parent int(11),
   name varchar(200),
   description blob,
   date date DEFAULT '0000-00-00',
   PRIMARY KEY (id)
);

CREATE TABLE snipe_gallery_data (
   id int(11) NOT NULL auto_increment,
   filename varchar(200),
   date date DEFAULT '0000-00-00',
   title varchar(255),
   details blob,
   author varchar(100),
   location varchar(255),
   cat_id int(11),
   keywords varchar(250),
   publish char(1),
   PRIMARY KEY (id)
);

INSERT INTO snipe_gallery_cat (id, cat_parent, name, description, date) VALUES ( '1', '0', 'Sample Gallery 1', 'This is your top level catgeory.  Photos cannot be added to a top level category (gallery).  They are meant as containers for the albums.  To create an album, go to ADD NEW CATEGORY and create a new category, using this category as the parent.  ', '2001-06-25');
INSERT INTO snipe_gallery_cat (id, cat_parent, name, description, date) VALUES ( '2', '1', 'Sample Album', 'Albums are the categories that actually contain photos.  Click into ths category to add photos to this album.', '2001-07-01');

