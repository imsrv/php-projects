<?
###########################################
#       Sistema Criado e Desenvolvido     #
#          Igor Carvalho de Escobar       #
#                LK Design©               #
#  http://igorescobar.webtutoriais.com.br #
#      Suporte em:                        #
#      http://forum.webtutoriais.com.br   #
#      Por favor, Mantenham os Créditos   #
###########################################
?>
<?
function conexao($host_db,$usuario_db,$senha_db,$BancoDeDados)
{
     mysql_connect ("$host_db", "$usuario_db", "$senha_db") or die ('I cannot connect to the database because: ' . mysql_error());
     mysql_select_db ("$BancoDeDados") or die("Não foi possivel completa a conexao com o banco de dados $BancoDeDados");
}
function add_views()
{
     $noticia_id = $_GET['n_id'];
     $sql = @mysql_query("UPDATE lkn_noticias SET views=views+1 WHERE id='$noticia_id';");
}
function removenews($noticia_id)
{
     $noticia_id = $_GET['n_id'];
     $tab = $_GET['tab'];
     $sql = mysql_query("DELETE FROM $tab WHERE id='$noticia_id'") or die (mysql_error());
     echo "<script>window.alert(\"Noticia Deletada com sucesso !\");</script>";
}
function update_news($noticia_id,$tab)
{
     $noticia    = $_POST['noticia'];
     $titulo = $_POST['titulo'];
     $area = $_POST['area'];
         if($tab=="lkn_coments")
     {
      $sql = mysql_query("UPDATE lkn_coments SET comentario='$noticia', nome='$titulo' WHERE id='$noticia_id'") or die (mysql_error());
     } else {
     $sql = mysql_query("UPDATE lkn_noticias SET noticia='$noticia', titulo='$titulo', area='$area' WHERE id='$noticia_id'") or die (mysql_error());
     }
     echo "<script>window.alert(\"Noticia/Comentario Deditada com sucesso !\");</script>";
}
function update_template()
{

      $template = $_POST['template'];

	          $sql2 = mysql_query("UPDATE lkn_templates SET template='$template'") or die(mysql_error());
	          if($sql2)
              {
                 echo "<script>window.alert(\"Template Atualizada com sucesso\");</script>";
                 echo "<meta http-equiv='refresh' content='0;URL=index.php'>";
              }
}
function bbcode($var,$area) // em relacao no painel ou na web
{
           // bbcodes de texto
           $var = preg_replace("(\[Tgrande\])","<font face=verdana size=3>", $var);
           $var = preg_replace("(\[/Tgrande\])","</font>", $var);
           $var = preg_replace("(\[Tmedio\])","<font face=verdana size=2>", $var);
           $var = preg_replace("(\[/Tmedio\])","</font>", $var);
           $var = preg_replace("(\[Tpequeno\])","<font face=verdana size=1>", $var);
           $var = preg_replace("(\[LEFT\])","<div align=left><font face=verdana size=1>", $var);
           $var = preg_replace("(\[/LEFT\])","</div>", $var);
           $var = preg_replace("(\[RIGHT\])","<div align=right><font face=verdana size=1>", $var);
           $var = preg_replace("(\[/RIGHT\])","</div>", $var);
           $var = preg_replace("(\[CENTER\])","<div align=center><font face=verdana size=1>", $var);
           $var = preg_replace("(\[/CENTER\])","</center>", $var);
           $var = preg_replace("(\[/Tpequeno\])","</font>", $var);

             $sql2 = mysql_query("SELECT url_admin FROM lkn_configs LIMIT 1");
              while ($dados = mysql_fetch_array($sql2))
              {
                $url_admin = $dados['url_admin'];

                }
                $urlpath2= explode("/",$url_admin);
                $size = count($urlpath2)-2;
                
            if($area==1){
            $dir = "smyles";
            } else {
            $dir = "$urlpath2[$size]/smyles";
            }

            $dh = opendir($dir);
            $sql = mysql_query("SELECT * FROM lkn_configs");
            


        if($area==0)//fora  0
        {
              $urlpath="";
              $barra="/";
              $urlpath2= explode("/",$url_admin);
              $size = count($urlpath2)-2;
        }
         else //dentro 1
        {
             $urlpath = "http://".getenv("SERVER_NAME")."/";
             $urlpath2 = explode("/",$url_admin);
             $size = count($urlpath2)-2;
             $barra="/";
         }
            while (false !== ($filename = readdir($dh)))
            {
                  $bbcode = explode("." , $filename);

	              if (substr($filename,-4) == ".jpg" || substr($filename,-4) == ".gif" || substr($filename,-4) == ".png" || substr($filename,-5) == ".jpeg" || substr($filename,-4) == ".bmp" && strstr($var,"[$bbcode[0]]"))
                  {
                     $var = str_replace("[$bbcode[0]]", "<img src='".$urlpath."/".$urlpath2[$size]."".$barra."smyles/$filename'>",$var);
                  }

            }

           // fim dos smyles
           // formatacoes de urç , email , cor , fort etc.
           $tagArray['img'] = array('open'=>'<img src="','close'=>'">');
           $tagArray['b'] = array('open'=>'<b>','close'=>'</b>');
           $tagArray['i'] = array('open'=>'<i>','close'=>'</i>');
           $tagArray['u'] = array('open'=>'<u>','close'=>'</u>');
           $tagArray['url'] = array('open'=>'<a href="','close'=>'">\\1</a>');
           $tagArray['MAIL'] = array('open'=>'<a href="mailto:','close'=>'">\\1</a>');
           $tagArray['url=(.*)'] = array('open'=>'<a href="','close'=>'">\\2</a>');
           $tagArray['MAIL=(.*)'] = array('open'=>'<a href="mailto:','close'=>'">\\2</a>');
           $tagArray['color=(.*)'] = array('open'=>'<font color="','close'=>'">\\2</font>');
           $tagArray['size=(.*)'] = array('open'=>'<font size="','close'=>'">\\2</font>');
           $tagArray['font=(.*)'] = array('open'=>'<font face="','close'=>'">\\2</font>');

            $sTagArray['br'] = array('tag'=>'<br>');
            $sTagArray['hr'] = array('tag'=>'<hr>');

    foreach($tagArray as $tagName=>$replace){
         $tagEnd=preg_replace('/\W/Ui','',$tagName);
         $var = preg_replace("|\[$tagName\](.*)\[/$tagEnd\]|Ui","$replace[open]\\1$replace[close]",$var);
    }
    foreach($sTagArray as $tagName=>$replace){
         $var= preg_replace("|\[$tagName\]|Ui","$replace[tag]",$var);
    }
    return $var;
}
function add_news($titulo,$noticia,$data,$hora,$autor)
{
     if(empty($_POST['titulo']) || empty($_POST['noticia']))
     {
        echo "<script>window.alert(\"Todos os campos são Obrigatórios\");</script>";
        
     }
     elseif(isset($erro))
     {
     echo "<script>window.alert(\"Não foi possivel Adicionar a noticia.\");</script>";
     }
      else
      {
      $dia     = $_POST['dia'];
      $mes     = $_POST['mes'];
      $ano     = $_POST['ano'];
      $horas   = $_POST['hora'];
      $minuto  = $_POST['minuto'];
      $segundo = $_POST['segundo'];
      $area = $_POST['area'];
      
      $concordo = $_POST['concordo'];
      
      $dia_marc = "$dia/$mes/$ano";
      $hora_marc= "$horas:$minuto:$segundo";
      
      $sql = mysql_query("INSERT INTO lkn_noticias (titulo,noticia,data,hora,autor,data_op,hora_op,hora_marcada,area) VALUES ('$titulo','$noticia','$data','$hora','$autor','$dia_mar','$hora_marc','$concordo','$area')");
      echo "<script>window.alert(\"Noticia adicionada com sucesso\");</script>";
      echo "<meta http-equiv='refresh' content='0;URL=index.php'>";
     }
}
function mostra_news($area,$noticias_por_pagina,$desej_coment,$tp,$tipo_paginacao,$xy,$palavrao)
{
echo "
<head>
<STYLE TYPE=\"text/css\">
<!-- a:link {color:#000000;text-decoration:none}
a:active {color:none;text-decoration:none}
a:visited {color:#000000;text-decoration:none}
a:hover {color:#CCCCCC;text-decoration:none} -->
</STYLE>
</head>


";
     $data_now = date("d/m/Y",time());
     $hora_now = strftime("%H:%M:%S");
     $query ="SELECT * FROM lkn_configs,lkn_noticias  WHERE ( hora_marcada='1' AND data_op<='$data_now' AND hora_op <='$hora_now' AND area='$area') OR ( hora_marcada='0' AND data_op!='$data_now' AND hora_op !='$hora_now' AND area='$area') ORDER BY id DESC";
     $sql = mysql_query("$query") or die (mysql_error());


     $lpp = $noticias_por_pagina;
     
     $total = @mysql_num_rows($sql);
     if($total == "0")
     {
      echo "no momento não há noticias cadastradas";
     }
     $paginas = ceil($total / $lpp);
     $pagina = $_GET['pagina'];
     if(!isset($pagina))
	{
		$pagina = 0;
	}

    $inicio = $pagina * $lpp;

    $sql = @mysql_query("$query LIMIT $inicio, $lpp");
     while ($dados = @mysql_fetch_array($sql))
     {
           $id = $dados['id'];
           $titulo  = $dados['titulo'];
           $noticia = $dados['noticia'];
           $data = $dados['data'];
           $hora = $dados['hora'];
           $url_admin = $dados['url_admin'];
           $porporcoes = explode("x", $xy);
           $t = mysql_query("SELECT * FROM lkn_templates WHERE template_name='$tp'");
           while ($d = mysql_fetch_array($t))
           {
            $template = $d['template'];
           }

           $views = $dados['views'];
           
           $noticia= nl2br($noticia);
           $noticia = bbcode($noticia,0);
           $data2 = $data;
           $data2 = substr($data,0,5);
           $resumo = substr($noticia,0,150);
           $ponto="";
           if(strlen($noticia)>150)
           {
             $ponto="...";
           }
           $template = str_replace("[#TO_FRIEND#]","<a href=\"#\" onClick=\"window.open('".$url_admin."tofriend.php?n_id=$id&u=$palavrao','Janela','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=400,height=220'); return false;\"><img src=".$url_admin."images/bt_recomende.gif alt=\"Recomende está noticia a um amigo\" border=0></a>", $template);
           $template = str_replace("[#VIEWS#]","Views: $views", $template);
           $template = str_replace("[#TITULO#]","$titulo", $template);
           $template = str_replace("[#RESUMO_N#]","$resumo$ponto  <a href=\"#\" onClick=\"window.open('".$url_admin."headline.php?n_id=$id&u=$palavrao','Janela','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=$porporcoes[0],height=$porporcoes[1]'); return false;\"><u>Leia Mais</u></a> ", $template);
           $template = str_replace("[#NOTICIA#]","$noticia", $template);
           $template = str_replace("[#D#]","$data", $template);
           $template = str_replace("[#H#]","$hora", $template);
           $template = str_replace("[#D2#]","<b>[ $data2 ]</b>", $template);
           $template = str_replace("[#HeadLine_BLANK#]","<a href=\"#\" onClick=\"window.open('".$url_admin."headline.php?n_id=$id&u=$palavrao','Janela','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=$porporcoes[0],height=$porporcoes[1]'); return false;\">$titulo</a>", $template);


           if($desej_coment==0)
           {
               $s = mysql_query("SELECT * FROM lkn_coments WHERE noticia_id='$id'");
               $numero = @mysql_num_rows($s);


               $nComentarios = "<font face=verdana size=1><a href=\"#\" onClick=\"window.open('".$url_admin."coments.php?n_id=$id&u=$palavrao','LinkinNews2','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=$porporcoes[0],height=$porporcoes[1]'); return false;\">$numero Comentarios</a></font>";
               $template = str_replace("[#R_COMENTARIOS#]","$nComentarios", $template);
           }else{
             $template = str_replace("[#R_COMENTARIOS#]","", $template);
             }

           echo "$template";
     }
if($tipo_paginacao==1)
{
     echo "<font face=verdana size=1>";
     if($pagina > 0)
     {
       $menos = $pagina - 1;
       $url = "$PHP_SELF?pagina=$menos";
       echo "<a href=\"$url\">Anterior</a>"; // Vai para a página anterior
     }
     for($i=0;$i<$paginas;$i++)
     {
          // Gera um loop com o link para as páginas
          if($pagina==$i){
          echo " | $i ";
          } else {
          $url = "$PHP_SELF?pagina=$i";
          echo " | <a href=\"$url\">$i</a>";
          }

     }
     if($pagina < ($paginas - 1))
     {
          $mais = $pagina + 1;
          $url = "$PHP_SELF?pagina=$mais";
          echo " | <a href=\"$url\">Próxima</a>";
     }
     echo "</font>";
     return;
}

if($tipo_paginacao==2)
{
         echo "<font face=verdana size=1>";
     if($pagina > 0)
     {
       $menos = $pagina - 1;
       $url = "$PHP_SELF?pagina=$menos";
       echo "<a href=\"$url\">Anterior</a>"; // Vai para a página anterior
     }
     for($i=0;$i<$paginas;$i++)
     {
          // Gera um loop com o link para as páginas
          if($pagina==$i){
          echo " <b>[ $i ]</b>";
          } else {
          $url = "$PHP_SELF?pagina=$i";
          echo " | <a href=\"$url\">$i</a>";
          }
     }
     if($pagina < ($paginas - 1))
     {
          $mais = $pagina + 1;
          $url = "$PHP_SELF?pagina=$mais";
          echo " | <a href=\"$url\">Próxima</a>";
     }
     echo "</font>";
     return;

}
if($tipo_paginacao==3)
{
     echo "<font face=verdana size=1>";
     
     if($pagina > 0)
     {
       $menos = $pagina - 1;
       $url = "$PHP_SELF?pagina=$menos";
       echo "<a href=\"$url\">Anterior</a>"; // Vai para a página anterior
     }
     if($pagina < ($paginas - 1))
     {
          $mais = $pagina + 1;
          $url = "$PHP_SELF?pagina=$mais";
          echo " | <a href=\"$url\">Próxima</a>";
     }
     echo "</font>";
     return;
}
if($tipo_paginacao==4)
{
     echo "<font face=verdana size=1>";
        if($pagina > 0)
     {
       $url = "$PHP_SELF?pagina=0";
       echo "<a href=\"$url\"><< </a>"; // Vai para a página anterior
     }
     if($pagina > 0)
     {
       $menos = $pagina - 1;
       $url = "$PHP_SELF?pagina=$menos";
       echo "<a href=\"$url\">< </a>"; // Vai para a página anterior
     }

     echo "<b>[ $pagina ]</b>";
     if($pagina < ($paginas - 1))
     {
          $mais = $pagina + 1;
          $url = "$PHP_SELF?pagina=$mais";
          echo "<a href=\"$url\"> ></a>";
     }
      if($pagina < ($paginas - 1))
     {     $paginas = $paginas -1;
          $url = "$PHP_SELF?pagina=$paginas";
          echo "<a href=\"$url\"> >></a>";
     }
     echo "</font>";
     return;
}
}
function mostra_config($n)
{
     if($n==1)
     {
              $sql2 = mysql_query("SELECT noti_por_pagina FROM lkn_configs LIMIT 1");
              while ($dados = mysql_fetch_array($sql2))
              {
                $npaginas = $dados['noti_por_pagina'];
                echo "$npaginas";

              }

     }
     if($n==2)
     {
              $sql2 = mysql_query("SELECT desej_coment FROM lkn_configs LIMIT 1");
              while ($dados = mysql_fetch_array($sql2))
              {
                $comentar = $dados['desej_coment'];
              }
              return $comentar;
     }
          if($n==3)
     {
              $sql2 = mysql_query("SELECT url_admin FROM lkn_configs LIMIT 1");
              while ($dados = mysql_fetch_array($sql2))
              {
                $url_admin = $dados['url_admin'];
                echo "$url_admin";
                return $url_admin;
              }
     }
               if($n==4)
     {
              $sql2 = mysql_query("SELECT type_paginacao FROM lkn_configs LIMIT 1");
              while ($dados = mysql_fetch_array($sql2))
              {
                $type_paginacao = $dados['type_paginacao'];
              }
               return $type_paginacao;
     }
     
       if($n==5)
     {
              $sql2 = mysql_query("SELECT window_xy FROM lkn_configs LIMIT 1");
              while ($dados = mysql_fetch_array($sql2))
              {
                $xy = $dados['window_xy'];
              }

              return $xy;
     }
     



}
function update_configs($n)
{
    $url_admin = $_POST['url_admin'];
    $sql = mysql_query("UPDATE lkn_configs SET url_admin='$url_admin'");
    $ponteiro = "filtro.txt";
    $ponteiro2 = "ips.txt";
    
    @chmod($ponteiro, "0666");
    @chmod($ponteiro2, "0666");
    
    $fp = @fopen($ponteiro, "w");
    
    $palavras = $_POST['palavras'];

    
    fputs($fp, "$palavras");
    
    @fclose($fp);
    
    $fp = @fopen($ponteiro2, "w");

    $ips = $_POST['ips'];

    fputs($fp, "$ips");

    @fclose($fp);
    
     echo "<script>window.alert(\"Configuracoes atualizadas com sucesso\");</script>";
     echo "<meta http-equiv='refresh' content='0;URL=index.php'>";
}
function close_con()
{
     mysql_close();
}

function tabelas()
{
         $tabela[0] = "lkn_admin";
         $tabela[1] = "lkn_coments";
         $tabela[2] = "lkn_configs";
         $tabela[3] = "lkn_noticias";
         $tabela[4] = "lkn_zonas";
         $tabela[5] = "lkn_templates";
         return $tabela;
}
function backup_table($num)
{
         if($num==0) // total
         {
         $tabela = tabelas();
         
                     $path = "C:/Arquivos de programas/Apache/Apache/htdocs/LinkinNews2.0/backup";
                     for($i=0; $i<=count($tabela)-1; $i++)
                     {

                         $sql = mysql_query("BACKUP TABLE $tabela[$i] TO '$path'") or die (mysql_error());

                     }
                     echo "<script>window.alert(\"O Backup total das tabelas foi efetuado com sucesso e estão na pasta 'Backup' do sistema LinkinNews2.0\");</script>";
                     echo "<meta http-equiv='refresh' content='0;URL=index.php'>";
         }
         if($num==1)
         { // tabela indenpendente
              $tabela = $_POST['tabela'];
              
              $path = "C:/Arquivos de programas/Apache/Apache/htdocs/LinkinNews2.0/backup";

              $sql = mysql_query("BACKUP TABLE $tabela TO '$path'") or die (mysql_error());
              echo "<script>window.alert(\"O Backup total daa tabela $tabela foi efetuado com sucesso e esta na pasta 'Backup' do sistema LinkinNews2.0\");</script>";
              echo "<meta http-equiv='refresh' content='0;URL=index.php'>";
         }
         return;
         
}
function restore_table($tab)
{

         if($tab==0)// restauracao independente
         {
              $tabelas = $_POST['tabela2'];

              $tabela = tabelas();

              $path = "C:/Arquivos de programas/Apache/Apache/htdocs/LinkinNews2.0/backup";

              $sql = mysql_query("RESTORE TABLE $tabela[$tabelas] FROM '$path'") or die (mysql_error());
              echo "<script>window.alert(\"A Restauração da tabela '$tabela[$tabelas]' foi efetuado com sucesso e esta na pasta 'Backup' do sistema LinkinNews2.0\");</script>";
              echo "<meta http-equiv='refresh' content='0;URL=index.php'>";

         }
         if($tab=="1") // restauracao total
         {
                     $tabela = tabelas();

                     $path = "C:/Arquivos de programas/Apache/Apache/htdocs/LinkinNews2.0/backup";
                     for($i=0; $i<=count($tabela)-1; $i++)
                     {

                         $sql = mysql_query("RESTORE TABLE $tabela[$i] FROM '$path'") or die (mysql_error());

                     }
                     echo "<script>window.alert(\"A Restauração total das tabelas foi efetuado com sucesso e estão na pasta 'Backup' do sistema LinkinNews2.0\");</script>";
                     echo "<meta http-equiv='refresh' content='0;URL=index.php'>";
                     return;
         }
  return;
}
function geraform($num)
{
   for($i=1;$i<=$num;$i++)
   {
       echo "<font face=verdana size=1> <b>Arquivo $i:</b><input type='file' name='arquivo$i' class='botoes'><BR>";
   }
   echo "<input type='Submit' class='botoes' value='Enviar Arquivos' name='Submit'>";
}
function upload($num)
{
     echo "<BR><font face=verdana size=2 color=red><b>Status do Upload</b></font>";

          set_time_limit(0);

     $caminho_dos_arquivos = "Minhas Imagens";
     chmod($caminho_dos_arquivos, "0666");

     for($i=1; $i<=$num; $i++)
     {
               $id_arquivo = "arquivo".$i;
               $nome_arquivo    = $_FILES[$id_arquivo]["name"];
               $arqv_temporario = $_FILES[$id_arquivo]["tmp_name"];

               if(move_uploaded_file($arqv_temporario, "$caminho_dos_arquivos/$nome_arquivo"))
               {
                  echo "<BR>O Arquivo <b>$nome_arquivo</b> foi concluido com sucesso";
               }
               else
               {
                  echo "<BR>Erro no arquivo <b>$nome_arquivo</b>";
               }

     }
}
function dec($var)
{
 $var = base64_decode($var);
}
function Creat_zone($z)
{
         $sql = mysql_query("INSERT INTO lkn_zonas (area) VALUES ('$z')");
         if($sql)
         {
          echo "<script>window.alert(\"A zona '$z' Foi criada com sucesso, Aguarde...\");</script>";
          echo "<meta http-equiv='refresh' content='0;URL=index.php'>";
         }
}
function filtro($var)
{
         $f = "filtro.txt";
         $p = file($f);
         $array = array();
         $var = strtolower($var);
         for($i=0;$i<=count($p)-1;$i++)
         {
           $array[$i]=$p[$i];
         }
         for($i=0;$i<=count($array)-1;$i++)
         {
           $array[$i] =  preg_replace("(\r|\n)","",$array[$i]);

           $var = str_replace($array[$i], "<font color=red>****</font>",$var);
         }
         $var = ucfirst($var);

         return $var;


}
function verify_zone()
{
$v = mysql_query("SELECT * FROM lkn_zonas LIMIT 1");
$v2 = mysql_query("SELECT * FROM lkn_templates LIMIT 1");

if(mysql_num_rows($v)==0)
{
     echo "<script>window.alert(\"Antes de postar qualquer noticia Você deve Criar uma AREA\");</script>";
$erro = 1;

}
if(mysql_num_rows($v2)==0)
{
     echo "<script>window.alert(\"Antes de postar qualquer noticia Você deve Criar um Template\");</script>";
$erro = 1;

}
return $erro;
}
function block($ip)
{

}
function to_friend($email,$noticia_id)
{
	$sql = mysql_query("SELECT * FROM lkn_noticias WHERE id='$noticia_id'") or die(mysql_error());

	while ($dados = mysql_fetch_array($sql))
	{

           $titulo  = $dados['titulo'];
           $noticia = $dados['noticia'];
           $data = $dados['data'];
           $hora = $dados['hora'];
           
	}

    $noticia = bbcode($noticia,1);
	$noticia = nl2br($noticia);
	$noticia = stripcslashes($noticia);

	$emaildest = $_POST['email'];
	$nomedest = $_POST['nome'];

	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	$headers .= "From: $nome<$email>";
	$assunto = "$titulo";

	mail("$emaildest","$assunto","
	<font face=verdana size=2>Olá <b>$nomedest</b><br>
	Pediram para que você lê-se a seguinte noticia:<BR><BR>

	<b>$titulo</b><BR>
	$noticia</font>","$headers");
 echo "<script>window.alert(\"A noticia '$titulo' Foi Recomendada com sucesso.\");</script>";
echo "<script>window.close();</script>";
}


?>
