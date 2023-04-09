<?
include("config_file.php");
include (DIR_SERVER_ADMIN."admin_setting.php");
include (DIR_SERVER_ADMIN."admin_header.php");
$t=array();
$r=array();
$b=array();
if ($add) {
	$banner_files = GetFiles(BANNER_DIR);
	for ($i=0;$i<sizeof($banner_files) ;$i++ ) {
		if (eregi("top_banner(.*)\.html",$banner_files[$i], $regs)) {
			$t[] = $regs[1];    
		}
	    elseif (eregi("bottom_banner(.*)\.html",$banner_files[$i], $regs)) {
			$b[] = $regs[1];    
		}
	    elseif (eregi("right_banner(.*)\.html",$banner_files[$i], $regs)) {
			$r[] = $regs[1];    
		}
	}
	if ($HTTP_POST_VARS['filetype'] == "top_banner") {
        $i=1;
        while (in_array($i, $t)) {
            $i++;
        }
        $banner_text=fopen(BANNER_DIR."top_banner".$i.".html","w");
		$banner = "topsel";
	}
    elseif ($HTTP_POST_VARS['filetype'] == "right_banner") {
        $i=1;
        while (in_array($i, $r)) {
            $i++;
        }
        $banner_text=fopen(BANNER_DIR."right_banner".$i.".html","w");	    
		$banner = "rightsel";
	}
    elseif ($HTTP_POST_VARS['filetype'] == "bottom_banner") {
        $i=1;
        while (in_array($i, $b)) {
            $i++;
        }
		$banner_text=fopen(BANNER_DIR."bottom_banner".$i.".html","w");	    
		$banner = "bottomsel";
	}
    fclose($banner_text);
	refresh("banner_add_banner.php?banner=".$banner);
}
if ($send) {
if ($HTTP_POST_VARS['filetosave']) {
    $banner_text=fopen(BANNER_DIR."".$HTTP_POST_VARS['filetype'].$HTTP_POST_VARS['filetosave'].".html","w");
	fwrite($banner_text,stripslashes($HTTP_POST_VARS[$HTTP_POST_VARS['filetype'].$HTTP_POST_VARS['filetosave']]));	    
	fclose($banner_text);
	if ($HTTP_POST_VARS['filetype'] == "top_banner") {
		$banner = "topsel";
	}
	elseif ($HTTP_POST_VARS['filetype'] == "right_banner") {
		$banner = "rightsel";
	}
	elseif ($HTTP_POST_VARS['filetype'] == "bottom_banner") {
		$banner = "bottomsel";
	}
	refresh("banner_add_banner.php?banner=".$banner);
}
}
if ($del) {
if ($HTTP_POST_VARS['filetosave']) {
    @unlink(BANNER_DIR."".$HTTP_POST_VARS['filetype'].$HTTP_POST_VARS['filetosave'].".html");
	if ($HTTP_POST_VARS['filetype'] == "top_banner") {
		$banner = "topsel";
	}
	elseif ($HTTP_POST_VARS['filetype'] == "right_banner") {
		$banner = "rightsel";
	}
	elseif ($HTTP_POST_VARS['filetype'] == "bottom_banner") {
		$banner = "bottomsel";
	}
	refresh("banner_add_banner.php?banner=".$banner);
}
}
include (DIR_SERVER_ADMIN.'admin_footer.php');
?>