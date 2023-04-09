<?php

require_once( "config.php" );
require_once( "db_file.php" );

?>
<html>
<?php

DB_connect();
$query="SELECT id, filename, url FROM LFchat_banners";
$res = @mysql_query($query);

$num = mysql_num_rows( $res );
if( $num == 0 )
	exit();
    
$row = array();

if( $banner_rotation_method != "series" )
{
    $sele = mt_rand( 0, $num - 1 );
    if( isset( $_GET['lastbannerid'] ) && $num > 1 )
        while( $sele == (int)$_GET['lastbannerid'] )
            $sele = mt_rand( 0, $num - 1 );
    
    $i = 0;
    do { $row = mysql_fetch_array( $res ); } while( $i++ != $sele );
}
else
{
    if( !isset( $_GET['lastbannerid'] ) )
    {
        $row = mysql_fetch_array( $res );
    }
    else
    {
        $first = true;
        while( $row0 = mysql_fetch_array( $res ) )
        {
            if( $first )
            {
                $row = $row0;
                $first = false;
            }
            
            if( $row0['id'] == $_GET['lastbannerid'] )
            {
                if( $row0 = mysql_fetch_array( $res ) )
                {
                    $row = $row0;
                }
                break;
            }
        }
    }
}

mysql_query( "UPDATE LFchat_banners SET impressions = impressions + 1 WHERE id = ". $row['id'] );

?>
<script language="JavaScript">
function refresh()
{
	document.location = "<?=$_SERVER['PHP_SELF']?>?lastbannerid=<?=$row['id']?>";
}
setTimeout( "refresh()", <?=$banners_refresh_interval?> );
</script>
<body style="margin: 0px">
<center>
	<a href="banner_opener.php?id=<?=$row['id']?>" onClick="JavaScript:refresh()" target="_blank">
		<img src="<?=$path_to_banners . "/" . $row['filename']?>" border=0/>
	</a>
</center>
</body>
</html>
