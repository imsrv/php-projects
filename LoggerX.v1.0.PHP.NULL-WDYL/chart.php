<? 

class Chart {

	var $numbers, $summa = 0, $imageURL, $percents = array(), $maxnumber = 1;

		function setData($numbers) {
		$this -> numbers = $numbers;
	}

	function getMaxValue() {
		$numbers = array_values($this -> numbers);
		rsort($numbers);
		$this -> maxnumber = $numbers[0];
		return $numbers[0];
	}

	function getSumma() {
		$summa = 0;
		reset($this -> numbers);
		while(list($key,$value) = each($this -> numbers)) {
			$summa += $value;	
		}
		return $summa;
	}

	function percents($decimals = 2) {
		$sum = $this -> getSumma();
		reset($this -> numbers);
		while (list($key,$value) = each($this -> numbers)) {
			 $percent = round((100 * $value) / $sum,$decimals);
			 array_push($this -> percents,$percent);
		}
		return $this -> percents;
	}

}

# class Pie Chart

class PieChart extends Chart {

	var $height = 1000, $width = 1500, $colors = array("88aaee","88ddff","55dd55","ffff66","ffaa00"), $radius = 50, $bgcolor = "eeeeee";

	function setColors($colors) {
		$this -> colors = $colors;
	}
	function getColors() {
		return $this->colors;
	}

	function cutData($limit = 5) {
		arsort($this -> percents);
		arsort($this -> numbers);
		$percents = $this -> percents;
		$notother = 0;
		$index = 0;
		reset($percents);
		do {
			$index ++;
			$notother += current($percents);
		} while (next($percents) > $limit);
		$other = round(100 - $notother,2);
		if (round($other)) {
			array_splice($this -> percents,$index);
			array_push($this -> percents,$other);
			$others = array('others' => $other);
			array_splice($this -> numbers,$index);
			$this -> numbers = array_merge($this -> numbers,$others);
		} else {
			array_splice($this -> percents,$index);
		}
	}

	function createPost($numbers,$colors) {
		$str = '';
		reset($numbers);
		for ($i = 0;$i < count($numbers);$i++) {
			$str .= "&n$i=".current($numbers);
			next($numbers);
		}
		reset($colors);
		for ($i = 0;$i < count($colors);$i++) {
			$str .= "&c$i=".current($colors);
			next($colors);
		}
		return $str;
	}

	function drawChart($showlegend) {
		$percents = $this -> percents;
		//arsort($percents);
		if ($showlegend) {
			//arsort($this -> numbers);
			$strings = array_keys($this -> numbers);
			echo "<table bgcolor=".$this -> bgcolor.">";
			echo "<tr><td>";
		}
		$colors -> $this -> colors;
		echo "<img width=200 height=150 src=\"image.php?bgc=".$this -> bgcolor.$this -> createPost($percents,$this -> colors)."\">";
		if ($showlegend) {
			echo "</td>";
			echo "<td valign=top class=\"Table\" ><br><b>";
			reset($percents);
			reset($strings);
			do {
				echo current($percents)."% ".current($strings)."<br>";
				next($strings);
			} while (next($percents));
			echo "</b></td></tr>";
			echo "</table>";
		}
	}

}

# class Vertical Chart

class VChart extends Chart {

	var $tablestyle, $barheight = 150, $barwidth = 22;

	function drawBar($number) {
		$percent = $number / $this -> getMaxValue();
		$barheight = $this -> barheight * $percent;
		$barwidth = $this -> barwidth;
		echo "<img src=\"".$this -> imageURL."bar1top.gif\" height=5 width=$barwidth><br>";
		echo "<img src=\"".$this -> imageURL."bar1.gif\" height=$barheight width=$barwidth><br>";
		echo "<img src=\"".$this -> imageURL."bar1bottom.gif\" height=5 width=$barwidth>";
	}	

	function drawChart() {
		//arsort($this -> numbers);
		$tablestyle = $this -> tablestyle;
		reset($this -> numbers);
		$numbers = $this -> numbers;
		reset ($numbers);
		$strings = array_keys($this -> numbers);
		reset($strings);
		echo "<tr>";
		while (list($key,$value) = each($numbers)) {
			echo "<td class=$tablestyle> $value </td>";
		} 
		echo "</tr>";
		reset($numbers);
		echo "<tr valign=bottom>";
		while (list($key,$value) = each($numbers)) {
			echo "<td align=center bgcolor=white>";
			if ($value != 0) {
				$this -> drawBar($value);
			} else {
				echo " &nbsp; ";
			}
			echo "</td>";
		} 
		echo "</tr>";
		echo "<tr>";
		do {
			echo "<td class=$tablestyle>".current($strings)."</td>";
		} while (next($strings));
		echo "</tr>";
	}

}

# class Horizontal Chart

	class HChart extends Chart {

	var  $tablestyle, $tableheader, $barwidth = 200, $barheight = 20, $limit = 30;

	function drawBar($number) {
		$percent = $number / $this -> getMaxValue();
		$barwidth = round($this -> barwidth * $percent);
		$barheight = $this -> barheight;
		echo "<img src=\"".$this -> imageURL."b1.gif\" height=$barheight width=5>";
		echo "<img src=\"".$this -> imageURL."b2.gif\" height=$barheight width=$barwidth>";
		echo "<img src=\"".$this -> imageURL."b3.gif\" height=$barheight width=5>";
	}	

	function drawChart($headerlist, $showpercents, $shownumeration,$sorted = 1) {
		if ($sorted) {
			arsort($this -> numbers);
		} else {
			krsort($this -> numbers);
		}
		$barwidth = $this -> barwidth + 12;
		reset($this -> numbers);
		$numbers = $this -> numbers;
		reset ($numbers);
		$strings = array_keys($this -> numbers);
		reset($strings);
		if ($showpercents) {
			$this -> percents();
			reset($this -> percents);
		} 
		echo "<tr>";
		if ($shownumeration) {
			echo "<td class=".$this -> tableheader."> N </td>";
		}
		do {
			$header = current($headerlist);
			echo "<td class=".$this -> tableheader.">$header</td>";
		} while (next($headerlist));
		echo "</tr>";
		$i=0;
		while ((list($key,$value) = each($numbers)) && (++$i <= $this -> limit)) {
			echo "<tr>";
			if ($shownumeration) {
				echo "<td bgcolor=White class=\"Table\">". (key($strings) + 1) ."</td>";
			}
			echo "<td bgcolor=White class=\"Table\">".current($strings)." </td>";
			next($strings);
			echo "<td bgcolor=White class=\"Table\" width=$barwidth>";
			if ($value != 0) {
				$this -> drawBar($value); 
			} else {
				echo " &nbsp; ";
			}
			echo "</td>";
			echo "<td align=right bgcolor=White> $value </td>";
			if ($showpercents) {
				list($key,$value) = each($this -> percents);
				echo "<td class=\"Table\"> $value </td>";
			}
			echo "</tr>";
		} 
	}
}

	class SimpleChart extends Chart {

	var  $tablestyle, $tableheader;

	function drawChart($headerlist,$page = 1,$pagesize = 30,$sorted = 1) {
		if ($sorted) {
			arsort($this -> numbers);
		}
		$numbers = $this -> numbers;
		reset ($numbers);
		$strings = array_keys($this -> numbers);
		reset($strings);
		$percents = $this -> percents();
		reset($percents);
		echo "<tr>";
		do {
			$header = current($headerlist);
			echo "<td class=".$this -> tableheader.">$header</td>";
		} while (next($headerlist));
		echo "</tr>";
		$i=0;
		reset($numbers);
		while (list($key,$value) = each($numbers)) {
			if ((++$i <= $page * $pagesize) && ($i >= ($page - 1) * $pagesize)) {
				echo "<tr>";
				echo "<td bgcolor=White class=\"Table\">".current($strings)." </td>";
				list($pkey,$pvalue) = each($percents);
				echo "<td align=right bgcolor=White class=\"Table\"> $pvalue </td>";
				echo "<td align=right bgcolor=White class=\"Table\"> $value </td>";
				echo "</tr>";
			}
			next($strings);
		} 
	}

}

?>