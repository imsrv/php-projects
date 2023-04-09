<?
class mail{
	VAR $list, $de, $assunto, $unique, $list, $type, $mensagem;
	
	function de($from){
		$this->de=$from;
	}

	function assunto($assunto){
		$this->assunto=$assunto;
	}

	function setmail($mail){
		$this->unique=$mail;
	}

	function sql_list($sql){

		if(func_num_args()>1)
			$con=func_get_arg(1);

		$q=mysql_query($sql,$con) or die(mysql_error());
		
		$s=0;
		while( $ls=mysql_fetch_row($q) ){
			$this->list[$s]=$ls[0];
			$s++;
		}
		
	}

	function settype($type){
		$this->type=$type;
	}
	
	function send(){
		$header = "From: ".$this->de." \n";

		if($this->type='html'){
			$header .= "Content-Type: text/html; charset=pt-br\n";
			$header .= "X-Mailer: PHP4 Script Language\n";
			$header .= "X-Accept-Language: en\n";
			$header .= "MIME-Version: 1.0\n";
			$header .= "Content-Transfer-Encoding: 7bit\n";
		}

		if(count($this->list)>0){
			foreach($this->list as $ms)
				mail ($ms, $this->assunto, $this->mensagem, $header);
		}else{
			mail ($this->unique, $this->assunto, $this->mensagem, $header);
		}
	}

}

?>