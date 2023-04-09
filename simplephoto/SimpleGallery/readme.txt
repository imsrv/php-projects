
 Simple Gallery
 script  author: Doni Ronquillo
 install author: CodeMunkyX
 by: http://free-php.net

 # Version Info

 -- v1.1
 ---- Changed session management to not depend on register_globals
 ---- Changed code to not depend on register_globals being set
 ---- Made script more efficient

 -- v1.0
 ---- Initial Creation

 # Requirements

 -- PHP 4 (http://www.php.net)
 -- MySQL (http://www.mysql.com)
 -- ImageMagick (http://www.imagemagick.com/)

 # Installation

 -- Open "inc/config.php" and modify the settings to your liking
 -- Do Not Run the "install.php" script before doing the above
 -- The directory you specify for "$base_dir" should be chmod to 777 (full permissions)
 -- When you are sure your settings are correct, run the "install.php" file
 -- You will be asked to create your admin username and password on the install.php page
 -- After completing the install, REMOVE "install.php" (running this again will remove any data from your Simple Gallery tables)
 -- Run "login.php" to login as the admin username and password you setup so that you may start using Simple Gallery


 # How to Use Image Gallery

 -- When you login you can start adding categories / subcategories as well as uploading images for your gallery.
 -- To display the gallery on your page just run "gallery.php" those who are not logged in will just see the normal
    image gallery the way you see it.

 # TROUBLE SHOOTING

 -- If your images aren't getting created it probably means you either do not have ImageMagick
    installed or your specified path to the convert utility is wrong
 -- Make sure your Image Gallery $base_dir is chmod 777
 -- Make sure your settings are correct in config.php
 -- Make sure all paths are correct in each file use full paths if necessary.
 -- If you are still having problems please visit our free support forums ...
    http://www.free-php.net/forum/index.php