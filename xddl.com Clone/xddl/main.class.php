<?php
class ddl extends config {

	var $get = false;
	var $total = 0;

	function init($q) {
		global $page, $type;
		$this->page = $page;
		$this->page*=$this->limit;
		$this->page-=$this->limit;

		for ($i=0; $i<count($this->type); $i++) {
			if ($type == $this->type[$i]) {
				$hvahvor = "type = '".$this->type[$i]."'";
				break;
			} else
				$hvahvor = "type != ''";
		}

		if ($q) {
			$exp = explode(" ",$q);
			for ($i=0; $i<count($exp); $i++) {
				$hvahvor .= " && title LIKE '%$exp[$i]%'";
			}
		}
		$g_total = mysql_query("SELECT COUNT(id) AS TOTAL FROM $this->mysql_tb_dl WHERE $hvahvor");
		$this->total = mysql_result($g_total,0);
		$this->get = mysql_query("SELECT * FROM $this->mysql_tb_dl WHERE $hvahvor ORDER BY id DESC LIMIT $this->page, $this->limit");
	}

	function get($q = "",$types) {
		global $page, $row, $ddl_id, $ddl_name, $ddl_sname, $ddl_surl, $ddl_date, $ddl_views, $ddl_type;
		if (!$page)
			$page = "1";
		$this->init($q);
		echo $hvahvor;
	}
}
?>