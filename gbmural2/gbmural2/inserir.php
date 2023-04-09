<?

### Proibe HTML
if ($specialchar == 1) {
$de = htmlentities($de);
$email = htmlentities($email);
$icq = htmlentities($icq);
$para = htmlentities($para);
$msg = htmlentities($msg);
}

### Include smiles
include "smilie.php";

###Inserindo dados no DB
if($conexao) {
$sql = "INSERT INTO ".$td[msg]." (id, de, email, icq, para, msg, ip) VALUES ('$id', '$de', '$email', '$icq', '$para', '$msg', '$_SERVER[REMOTE_ADDR]')";

if($de == "" || $msg == "" || $para == ""){
echo "
<script>
alert(\"Não foi possível enviar sua mensagem. \\nVolte e preencha o formulário corretamente!\");
window.location = 'javascript:history.back(-1)';
</script>
";
}
else { $query = mysql_db_query($db[nome], $sql, $conexao);}
if ($query) {
echo("
<script>
alert(\"".$thanks_msg."\");
window.location = '".$link[index]."';
</script>
");
} else {
echo("
<script>
alert(\"".$error_msg." \n <b>ERRO:</b>".mysql_error()."\");
window.location = '".$link[index]."';
</script>
"); }
} else { echo("<b>Erro na tentativa de conexão.</b> ".mysql_error()."\n");}
?>
