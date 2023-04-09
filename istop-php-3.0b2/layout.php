<?
	
class layout{
        VAR $code;

        function layout($file=NULL){
                if(isset($file) and is_file($file))
                        $this->code=join('',file($file));
        }

         function replace($id,$ar){
                if(count($ar)>0){
                        while(list($k,$v) = each($ar)){
                                if(isset($k) and isset($v))
                                        $this->code=ereg_replace("\\[$id,$k\\]",$v,$this->code);
                        }
                }
        }

        function replace_once($id,$v){
                $this->code=ereg_replace(quotemeta("($id)"),(string)$v,$this->code);
        }

		function get_code($id){
			$preg="|<code id=\"$id\">(.*?)</code>|s";
			preg_match($preg,$this->code,$ret);
			
			$return=new Layout;
			$return->code=$ret[1];
			return $return;
		}

		function code_replace($id,$code){
			$preg="|<code id=\"$id\">(.*?)</code>|s";
			$this->code=preg_replace($preg,$code,$this->code);
		}

        function var_loop_replace($id,$ar) {
            $tmpval = array();
            preg_match_all("|<replace id=\"$id\">(.*?)</replace>|s", $this->code, $tags);

            foreach ($tags[1] as $tmpcont){
                $tmpval[] = $tmpcont;
            }
                $tmpval=join('',$tmpval);

                foreach($ar as $k=>$v){
                        @$rv.=eregi_replace(quotemeta("[value]"),$v,$tmpval);
                }

                $this->code=preg_replace("|<replace id=\"$id\">(.*?)</replace>|s",$rv, $this->code);
        }

		function remove($id){
                $this->code=preg_replace("|<remove id=\"$id\">(.*?)</remove>|s",'', $this->code);
		}

		function code_remove($id){
                $this->code=preg_replace("|<code id=\"$id\">(.*?)</code>|s",'', $this->code);
		}

        function loop_replace($id,$ar) {
            $tmpval = array();
            preg_match_all("|<replace id=\"$id\">(.*?)</replace>|s", $this->code, $tags);
            foreach ($tags[1] as $tmpcont){
                $tmpval[] = $tmpcont;
            }
                $tmpval=join('',$tmpval);
				$rv='';

                foreach($ar as $arb){
                        $rep=$tmpval;
                        foreach($arb as $k=>$v){
                                $rep=eregi_replace(quotemeta("[$k]"),$v,$rep);
                        }
                        $rv.=$rep;
                }

                $this->code=preg_replace("|<replace id=\"$id\">(.*?)</replace>|s",$rv, $this->code);
        }

        function replace_none(){
                $this->code=ereg_replace("\\[([^\\[]*),([^\\[]*)\\]",'',$this->code);
                $this->code=preg_replace("|<replace id=\"(.*?)\">(.*?)</replace>|s",'',$this->code);
        }

        function open($file){
                if(is_file($file)){
                        $objReturn=new layout;
                        $objReturn->code=join('',file($file));
                        return $objReturn;
                }else{
                        $this->erro('Não foi possível abrir arquivo "'.$file.'"');
                }
        }

        function erro($erro){
                echo'<font face="verdana, arial" size="1"><b>Erro no Layout: <font color="#000080">'.$erro.'</font></b></font><br>';
                return;
        }

		function does($objCode=NULL,$dirdef=NULL){
			GLOBAL $objDB;

			$this->replace_none();

			if(is_object($objInfo)){
				$res=$con->query("SELECT FORMAT(creditos,2) FROM cadastros WHERE Id='$_SESSION[Id]' LIMIT 1");
				$this->replace_once('cred',$res->result());
			}

			$this->code=ereg_replace('"'.DIR_IMG.'/','"'.$dirdef.DIR_HTML.DIR_IMG.'/',$this->code);
				
            if(is_object($objCode)){
				$objCode->code=ereg_replace('"'.DIR_IMG.'/','"'.$dirdef.DIR_HTML.DIR_IMG.'/',$objCode->code);
                $objCode->replace_none();
                $this->code=ereg_replace(quotemeta("(code)"),$objCode->code,$this->code);
            }else{
                 $this->code=ereg_replace(quotemeta("(code)"),'',$this->code);
            }

            echo $this->code;
		}

        function make($objCode=NULL,$dirdef=NULL){
				GLOBAL $objDB, $objInfo;

				$arDados=$objDB->getRow("SELECT SUM(Votos), COUNT(*)  FROM cadastros");
				$arTopHits=$objDB->getRow("SELECT Id, cadSnome, MAX(Cliques) FROM cadastros GROUP BY Cliques ORDER BY Cliques DESC LIMIT 1");
				$arLastCad=$objDB->getRow("SELECT Id, cadSnome FROM cadastros ORDER BY Id DESC LIMIT 1");
				$arTopHoje=$objDB->getRow("SELECT log.Id, cadSnome, COUNT(*) FROM log, cadastros WHERE log.Id=cadastros.Id GROUP BY log.Id ORDER BY 3 DESC LIMIT 1");
				$VotosHoje=$objDB->getOne("SELECT COUNT(*) FROM log");

				$arTopHits[1]=htmlspecialchars($arTopHits[1]);
				$arLastCad[1]=htmlspecialchars($arLastCad[1]);
				$arTopHoje[1]=htmlspecialchars($arTopHoje[1]);

				$this->replace(0,$arDados);
				$this->replace(1,$arTopHits);
				$this->replace(2,$arLastCad);
				$this->replace(3,$arTopHoje);
				$this->replace_once('vhj',$VotosHoje);

				$arCats=$objDB->getAll('SELECT * FROM categorias');
				$this->loop_replace(0,$arCats);

				$rBan=$objDB->query('SELECT * FROM banners ORDER BY RAND() LIMIT 1');
				$rBan->fetchInto($aBan,DB_FETCHMODE_ASSOC);
				$rBan->free();
				$objDB->query("UPDATE banners SET banEx=banEx+1 WHERE Id='$aBan[Id]'");

				if(ereg("\.swf$",$aBan['banImg'])){
					$code='<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#3,0,0,0" width="'.$aBan['banW'].'" height="'.$aBan['banH'].'"><param name="SRC" value="'.$aBan['banImg'].'"><embed src="'.$aBan['banImg'].'" pluginspage="http://www.macromedia.com/shockwave/download/" type="application/x-shockwave-flash" width="'.$aBan['banW'].'" height="'.$aBan['banH'].'"></object>';
				}else{
					$code='<a target="_blank" href="banclique.php?id='.$aBan['Id'].'">';
					if($aBan['banW']>0 and $aBan['banH']>0){
						$code.='<img border="0" width="'.$aBan['banW'].'" height="'.$aBan['banH'].'" src="'.$aBan['banImg'].'">';
					}else{
						$code.='<img border="0" src="'.$aBan['banImg'].'">';
					}
					$code.='</a>';
				}

				$this->replace_once('banner',$code);
                $this->replace_none();

				if(is_object($objInfo)){
					$res=$con->query("SELECT FORMAT(creditos,2) FROM cadastros WHERE Id='$_SESSION[Id]' LIMIT 1");
					$this->replace_once('cred',$res->result());
				}

				$this->code=ereg_replace('"'.DIR_IMG.'/','"'.$dirdef.DIR_HTML.DIR_IMG.'/',$this->code);
				
                if(is_object($objCode)){
						$objCode->code=ereg_replace('"'.DIR_IMG.'/','"'.$dirdef.DIR_HTML.DIR_IMG.'/',$objCode->code);
                        $objCode->replace_none();
                        $this->code=ereg_replace(quotemeta("(code)"),$objCode->code,$this->code);
                }else{
                        $this->code=ereg_replace(quotemeta("(code)"),'',$this->code);
                }

                echo $this->code;
        }

}

?>