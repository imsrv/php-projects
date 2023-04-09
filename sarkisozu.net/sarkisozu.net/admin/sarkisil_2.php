<?php require_once('../Connections/lyrics.php'); ?>
<?php
//initialize the session
session_start();

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  session_unregister('MM_Username');
  session_unregister('MM_UserGroup');
	
  $logoutGoTo = "../index.php";
  if ($logoutGoTo) {
mysql_query("UPDATE cache SET yonetici=0", $lyrics);
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
session_start();
$MM_authorizedUsers = "10";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

if ((isset($_GET['id'])) && ($_GET['id'] != "")) {
  $deleteSQL = sprintf("DELETE FROM sarki WHERE id=%s",
                       GetSQLValueString($_GET['id'], "int"));

  mysql_select_db($database_lyrics, $lyrics);
  $Result1 = mysql_query($deleteSQL, $lyrics) or die(mysql_error());

  $deleteGoTo = "sarkisil_ok.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

$maxRows_soneklenen = 10;
$pageNum_soneklenen = 0;
if (isset($_GET['pageNum_soneklenen'])) {
  $pageNum_soneklenen = $_GET['pageNum_soneklenen'];
}
$startRow_soneklenen = $pageNum_soneklenen * $maxRows_soneklenen;

mysql_select_db($database_lyrics, $lyrics);
$query_soneklenen = "SELECT id, sanatci, sarki FROM sarki ORDER BY id DESC";
$query_limit_soneklenen = sprintf("%s LIMIT %d, %d", $query_soneklenen, $startRow_soneklenen, $maxRows_soneklenen);
$soneklenen = mysql_query($query_limit_soneklenen, $lyrics) or die(mysql_error());
$row_soneklenen = mysql_fetch_assoc($soneklenen);

if (isset($_GET['totalRows_soneklenen'])) {
  $totalRows_soneklenen = $_GET['totalRows_soneklenen'];
} else {
  $all_soneklenen = mysql_query($query_soneklenen);
  $totalRows_soneklenen = mysql_num_rows($all_soneklenen);
}
$totalPages_soneklenen = ceil($totalRows_soneklenen/$maxRows_soneklenen)-1;

mysql_select_db($database_lyrics, $lyrics);
$query_eklenen = "SELECT * FROM eklenenler";
$eklenen = mysql_query($query_eklenen, $lyrics) or die(mysql_error());
$row_eklenen = mysql_fetch_assoc($eklenen);
$totalRows_eklenen = mysql_num_rows($eklenen);

mysql_select_db($database_lyrics, $lyrics);
$query_istenen = "SELECT * FROM istekler";
$istenen = mysql_query($query_istenen, $lyrics) or die(mysql_error());
$row_istenen = mysql_fetch_assoc($istenen);
$totalRows_istenen = mysql_num_rows($istenen);
?>
<?php include "ortak.php"; ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9">
<title>þarkýsözü.net - admin paneli</title>
<?php include "css.php"; ?>
<script>
function submitonce(theform){
//if IE 4+ or NS 6+
if (document.all||document.getElementById){
//screen thru every element in the form, and hunt down "submit" and "reset"
for (i=0;i<theform.length;i++){
var tempobj=theform.elements[i]
if(tempobj.type.toLowerCase()=="submit")
//disable em
tempobj.disabled=true
}
}
}
</script>
</head>

<body><br><br>
<table height="520">
  <tr>
    <td colspan="3" height="70" style="border-bottom:1px solid black;"><img src="../images/header.jpg" alt="sarkisozu.net"></td>
  </tr>
  <tr>
    <td width="18%" rowspan="2" style="border-right:1px solid black; border-top:1px solid black; border-bottom:1px solid black;"><center>
        <b>Menü</b>
      </center>
        <br><?php include "adminmenu.php"; ?><a href="<?php echo $logoutAction ?>">Sistemden Çýk</a></td>
    <td width="60%" rowspan="2"><a href="../index.php">Anasayfa</a> | <a href="yonet.php">Admin Paneli</a><br>
        <br>
        <center>
          <b>Admin Paneli</b>
        </center><br>
      <center>Admin paneline hoþgeldiniz.</center></td>
    <td width="22%" style="border-left:1px solid black; border-bottom:1px solid black; border-top:1px solid black;" height="90"><center>
        <b>Þarký Ara</b>
        <form name="ara" action="../arama.php">
          <input type="text" name="sarki" value="þarký adý" onFocus="this.value='';">
          <br>
          <input type="submit" value="ara!">
        </form>
    </center></td>
  </tr>
  <tr>
    <td style="border-left:1px solid black; border-top:1px solid black; border-bottom:1px solid black;"><center>
        <b>Son Eklenenler</b><br>
        <br>
        <?php if ($totalRows_soneklenen > 0) { // Show if recordset not empty ?>
        <?php do { ?>
        <a href="../sarkici.php?sanatci=<?php echo $row_soneklenen['sanatci']; ?>"><?php echo $row_soneklenen['sanatci']; ?></a> - <a href="../sarki.php?id=<?php echo $row_soneklenen['id']; ?>"><?php echo $row_soneklenen['sarki']; ?></a><br>
        <?php } while ($row_soneklenen = mysql_fetch_assoc($soneklenen)); ?>
        <?php } // Show if recordset not empty ?>
        <?php if ($totalRows_soneklenen == 0) { // Show if recordset empty ?>
        sitede hiç þarký sözü yok!!
        <?php } // Show if recordset empty ?>
    </center></td>
  </tr>
  <tr>
    <td colspan="3" height="5" style="border-top:1px solid black;"><b>sarkisozu.net admin paneli - powered by <a href="http://www.gencdizayn.net" target="_blank">gençdizayn</a></b></td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($soneklenen);

mysql_free_result($eklenen);

mysql_free_result($istenen);
?>
