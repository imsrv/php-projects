<?
echo '<a href="index.php?page=home" />Home</a><br />';
echo '<a href="index.php?page=reg" />Register</a><br />';
if (isset($_SESSION['valid_user']))
{
echo '<a href="index.php?page=e-post" />Inbox</a><br />';
echo '<a href="index.php?page=users" />User search</a><br />';
echo '<a href="index.php?page=friends" />Friend list</a><br />';
echo '<a href="index.php?page=pref" />Preferences</a><br />';
}
?>