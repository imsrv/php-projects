<?
#########################################################
# Simple Gallery                                        #
#########################################################
#                                                       #
# Created by: Doni Ronquillo                            #
#                                                       #
# This script and all included functions, images,       #
# and documentation are copyright 2003                  #
# free-php.net (http://free-php.net) unless             #
# otherwise stated in the module.                       #
#                                                       #
# Any copying, distribution, modification with          #
# intent to distribute as new code will result          #
# in immediate loss of your rights to use this          #
# program as well as possible legal action.             #
#                                                       #
#########################################################

   session_start();
   unset($_SESSION['username']);
   unset($_SESSION['password']);
   session_destroy();;
 ?>

<TABLE BORDER=0 width=98% align=center><TR><TD>
<BR>
<B>You have reached this page for one of several reasons:</B><BR>
&nbsp; • you have entered a bad username/password combination<BR>
&nbsp; • you have tried to access this url without first logging in<BR>

<BR>Please <A HREF="login.php">click here</A> to login.
</TABLE>