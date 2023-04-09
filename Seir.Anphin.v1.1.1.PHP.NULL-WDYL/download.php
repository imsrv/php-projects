<?php

$templates='dlcatlist,dlcatlistrow,downloadlist,downloadlistrow,file,dlinfo,';
$settings='dlcat_columns,download_limit,download_timestamp,guests_can_download,';
$wordbits='invalid_category,download_nofiles,can_download,cant_download,';
include('./lib/config.php');

class downloads {
	var $output = '';
	var $categories = array();
	var $filedata = array();
	var $id = 0;
	var $parentid = 0;
	var $parentcategory = 'Downloads';
	var $files = 0;
	var $offset = 0;
	var $dlcatlist = '';
	var $dlcatlistrow = '';
	var $numcats = 0;
	var $downloadlist = '';
	var $downloadlistrow = '';
	var $file = '';
	var $dlinfo = '';
	var $page = '';
	var $titletext = '';
	var $output = '';


	// constructor, deteremine page, set $page, set templates

	function downloads()
	{
		GLOBAL $dbr,$HTTP_GET_VARS,$header,$footer;

		if (isset($HTTP_GET_VARS['getfile'])) {

			$this->id = intval($HTTP_GET_VARS['getfile']);
			$sql = $dbr->query("SELECT * FROM arc_download WHERE downloadid=".$this->id);
			$this->filedata = $dbr->getarray($sql);

			$this->send_file();
		}

		if (isset($HTTP_GET_VARS['file'])) {

			$this->file = getTemplate('file');

			$this->id = is_numeric($HTTP_GET_VARS['file']) ? $HTTP_GET_VARS['file'] : $HTTP_GET_VARS['file'];
			$sql = $dbr->query("SELECT * FROM arc_download WHERE downloadid=".$this->id);
			$this->filedata = $dbr->getarray($sql);

			$this->output = $this->get_file_info();

			$this->id = $this->filedata['catid'];

			$HTTP_GET_VARS['category'] = $this->id;

		} else {
			$this->id = isset($HTTP_GET_VARS['category']) ? intval($HTTP_GET_VARS['category']) : '0';
		}

		$sql = $dbr->query("SELECT dlcatid,name,description,files,parentid FROM arc_dlcat WHERE dlcatid=".$this->id." OR parentid=".$this->id);

		$this->numcats = 0;
		while ($arr = $dbr->getarray($sql)) {
			if ($arr['dlcatid']==$this->id) {
				$this->parentcategory = stripslashes($arr['name']);
				$this->parentid = $arr['parentid'];
				$this->files = $arr['files'];
			} else {
				$this->categories[$this->numcats]['dlcatid'] = $arr['dlcatid'];
				$this->categories[$this->numcats]['name'] = stripslashes($arr['name']);
				$this->categories[$this->numcats]['description'] = stripslashes($arr['description']);
				$this->categories[$this->numcats]['files'] = number_format($arr['files']);
				$this->numcats++;
			}
		}

		if (isset($HTTP_GET_VARS['category'])) {

			$this->downloadlist = getTemplate('downloadlist');
			$this->downloadlistrow = getTemplate('downloadlistrow');

			$offset = isset($HTTP_GET_VARS['offset']) ? intval($HTTP_GET_VARS['offset']) : '0';

			$this->output .= $this->get_file_list($offset);
		}

		$this->dlcatlist = getTemplate('dlcatlist');
		$this->dlcatlistrow = getTemplate('dlcatlistrow');
		$this->dlcatlist = str_replace('<dlcat_columns>', getSetting('dlcat_columns'), $this->dlcatlist);

		$categories = $this->get_category_list();

		$header = str_replace('<pagemenu>', $categories, $header);
		$footer = str_replace('<pagemenu>', $categories, $footer);

	}

	function get_category_list()
	{
		GLOBAL $tdbgcolor;
		if ($this->id!=0)
			$this->dlcatlist = str_replace('<uponelevel>', '<a href="download.php?category='.$this->parentid.'"><img src="lib/images/uponelevel.gif" border="0" title="Click here to go up one level" /></a>', $this->dlcatlist);
		$this->dlcatlist = str_replace('<id>', $this->parentid, $this->dlcatlist);
		$this->dlcatlist = str_replace('<parentcategory>', $this->parentcategory, $this->dlcatlist);

		$rows = '';
		$cols = getSetting('dlcat_columns');
		$count = 0;
		$width = round(100 / $cols);
		for ($i=0; $i<$this->numcats; $i++) {
			$cell = str_replace('<id>', $this->categories[$i]['dlcatid'], $this->dlcatlistrow);
			$cell = str_replace('<name>', $this->categories[$i]['name'], $cell);
			$cell = str_replace('<description>', $this->categories[$i]['description'], $cell);
			$cell = str_replace('<files>', $this->categories[$i]['files'], $cell);
			$cell = str_replace('<width>', "$width%", $cell);

			if ($count==0) {
				$rows .= "\n<tr>\n";
				$rows .= $cell;
				$count++;
			} else {
				$rows .= $cell;
				$count++;
			}
			if ($count==$cols) {
				$rows .= "\n</tr>\n";
				$count = 0;
			}
		}
		if ($count!=0) {
			while ($count < $cols) {
			$rows .= "<td bgcolor=\"$tdbgcolor\">&nbsp;</td>\n";
				$count++;
		    }
		    $rows .= '</tr>';
		}
		$this->dlcatlist = str_replace('<dlcatlistrows>', $rows, $this->dlcatlist);
		return $this->dlcatlist;
	}

	function get_file_list($offset=0, $filesperpage=0)
	{
		GLOBAL $dbr;

		if ($filesperpage!=0)
			$limit = $filesperpage;
		else
			$limit = is_numeric(getSetting('download_limit')) ? getSetting('download_limit') : $filesperpage;
		$temp = '';

		$fileid = isset($this->filedata['downloadid']) ? $this->filedata['downloadid'] : '0';

		$sql = $dbr->query("SELECT downloadid,name,downloads,date_added,filesize FROM arc_download WHERE catid=".$this->id." ORDER BY name LIMIT $offset,$limit");

		if ($dbr->numrows($sql)>0) {
			while ($filedata = $dbr->getarray($sql)) {
				if ($filedata['downloadid']!=$fileid) {
					$row = str_replace('<id>', $filedata['downloadid'], $this->downloadlistrow);
					$row = str_replace('<name>', stripslashes($filedata['name']), $row);
					$row = str_replace('<filesize>', $filedata['filesize'], $row);
					$row = str_replace('<downloads>', number_format($filedata['downloads']), $row);
					$row = str_replace('<date_added>', formdate($filedata['date_added'], getSetting('download_timestamp')), $row);
					$row = altbgcolor($row);
					$temp .= $row;
				}
			}

			$this->downloadlist = str_replace('<downloadlistrows>', $temp, $this->downloadlist);
			$this->downloadlist = str_replace('<pagelinks>', pagelinks($limit,$this->files,$offset,'File'), $this->downloadlist);
			return $this->downloadlist;
		} else {
			return '';
		}
	}

	function get_file_info()
	{
		GLOBAL $dbr,$loggedin;

		if (isset($this->filedata['downloadid'])) {
			$this->file = str_replace('<id>', $this->filedata['downloadid'], $this->file);
			$this->file = str_replace('<filesize>', $this->filedata['filesize'], $this->file);
			$this->file = str_replace('<name>', stripslashes($this->filedata['name']), $this->file);
			$this->file = str_replace('<description>', stripslashes(nl2br($this->filedata['description'])), $this->file);
			$this->file = str_replace('<downloads>', number_format($this->filedata['downloads']), $this->file);
			$this->file = str_replace('<date_added>', formdate($this->filedata['date_added'], getSetting('download_timestamp')), $this->file);
			if (getSetting('guests_can_download')==1 || $loggedin==1)
				$txt = '<a href="download.php?getfile='.$this->filedata['downloadid'].'">'.getwordbit('can_download').'</a>';
			else
				$txt = getwordbit('cant_download');

			$this->file = str_replace('<downloadfile>', $txt, $this->file);
		} else {
			$this->file = '';
		}
		return $this->file;
	}

	function send_file()
	{
		GLOBAL $dbr,$SERVER_NAME,$loggedin;
		if (isset($this->filedata['downloadid'])) {
			$refr=getenv("HTTP_REFERER");
			list($remove,$stuff)=split('//',$refr,2);
			list($referer,$stuff)=split('/',$stuff,2);
			if ($referer==$SERVER_NAME && (getSetting('guests_can_download') || $loggedin==1)) {
				$this->filedata['downloads']++;
				$dbr->query('UPDATE arc_download SET downloads='.$this->filedata['downloads'].' WHERE downloadid='.$this->id);
				header("Location: ".$this->filedata['filepath']);
			} else {
				return getwordbit('cant_download');
			}
		}
	}
}

/*
create table arc_dlcat (
 dlcatid int(10) unsigned not null auto_increment,
 name varchar(250) not null,
 description mediumtext not null,
 parentid int(10) unsigned not null default '0',
 files smallint(5) unsigned not null default '0',
 primary key (dlcatid)
)

create table arc_download (
 downloadid int(10) unsigned not null auto_increment,
 name varchar(250) not null,
 filepath varchar(250) not null,
 filesize varchar (50) not null,
 description mediumtext not null,
 catid int(10) unsigned not null default '0',
 downloads int(10) unsigned not null default '0',
 date_added int(11) unsigned not null default '0',
 primary key (downloadid)
)
*/

$dlobj = new downloads;

doHeader($sitename);
echo $dlobj->output;
footer();

?>