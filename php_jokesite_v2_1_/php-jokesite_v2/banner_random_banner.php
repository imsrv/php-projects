<?
$t= array();
$r= array();
$b= array(); 
$banner_files = GetFiles(BANNER_DIR);
for ($i=0;$i<sizeof($banner_files) ;$i++ ) {
    if (eregi("top_banner(.*)\.html",$banner_files[$i], $regs)) {
		$t[] = $regs[1];    
	}
	elseif (eregi("right_banner(.*)\.html",$banner_files[$i], $regs)) {
		$r[] = $regs[1];    
	}
	elseif (eregi("bottom_banner(.*)\.html",$banner_files[$i], $regs)) {
		$b[] = $regs[1];    
	}
}
if (sizeof($t) || sizeof($r) || sizeof($b)) {
    srand((double)microtime()*1000000); // seed the random number generator
	if (sizeof($t)) {
		while ($random_top == 0) {
			$random_top = $t[@rand(0, (sizeof($t)-1))];    		    
		}
	}
	if (sizeof($r)) {
		while ($random_right == 0) {
			$random_right = $r[@rand(0, (sizeof($r)-1))];    		    
		}
    }
	if (sizeof($b)) {
		while ($random_bottom == 0) {
       		$random_bottom = $b[@rand(0, (sizeof($b)-1))];    
		}
	}
}
?>