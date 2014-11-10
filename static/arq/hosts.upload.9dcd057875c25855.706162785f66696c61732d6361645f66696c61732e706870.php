<?php require_once('Connections/admanager.php'); ?>
<?php 
ob_start();
include('_header.php');
include('_functions.php');
$c=0;
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

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
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
$textarea=nl2br($_POST["ramais_virtuais"]);
$textarea=explode('<br />',$textarea);
$count_textarea=count($textarea);

$count=0;
$c=0;

do{
	$ramal_virtual=ltrim($textarea[$count]);
	$ramal_virtual=str_replace(' ', '', $ramal_virtual);
	
	if ( $ramal_virtual != '' )
	{
		mysql_select_db($database_admanager, $admanager);
		$query_verifica_ramaisvirtuais = "SELECT ramal_virtual.ramal_virtual FROM ramal_virtual WHERE ramal_virtual='".$ramal_virtual."'";
		$verifica_ramaisvirtuais = mysql_query($query_verifica_ramaisvirtuais, $admanager) or die(mysql_error());
		$row_verifica_ramaisvirtuais = mysql_fetch_assoc($verifica_ramaisvirtuais);
		$totalRows_verifica_ramaisvirtuais = mysql_num_rows($verifica_ramaisvirtuais);
		
		if ( $row_verifica_ramaisvirtuais['ramal_virtual'] == '' )
		{ 
			$c=$c+1;
			$rv[$c]=$ramal_virtual; 
		}
	}
	
	$count=$count+1;
}while($count < $count_textarea );

if ( $c == 0 )
	{
		 $insertSQL = sprintf("INSERT INTO filas (nome, parametros, ramais_virtuais) VALUES (%s, %s, %s)",
							   GetSQLValueString($_POST['nome'], "text"),
							   GetSQLValueString($_POST['parametros'], "text"),
							   GetSQLValueString($_POST['ramais_virtuais'], "text"));
		
		  mysql_select_db($database_admanager, $admanager);
		  $Result1 = mysql_query($insertSQL, $admanager) or die(mysql_error()); 
		  
		  /////////// Gera log de acoes do ADManager
		$ip=$_SERVER['REMOTE_ADDR'];
	  	$datahora=mktime();
		$parametro=$_POST['nome'];
		$parametro1='';
	  	$usuario=$_SESSION['MM_Username'];
	  
	  	echo gera_log('17', $parametro, $parametro1, $usuario, $ip, $datahora);
	    ///////////
	}	
	
	//// Gera arquivo de filas /etc/asterisk/queues.conf					   
	echo gera_filas(); 
}
 ?>
<?php //include("_functions.php"); ?>
<script language="JavaScript">
function camposvazios()
{
	if(document.form1.nome.value=="") {
		window.alert("Preencha o campo: Nome da fila")
		return false;
	}
	
	if(document.form1.parametros.value=="") {
		window.alert("Preencha o campo: Par‚metros")
		return false;
	}
	
	if(document.form1.ramais_virtuais.value=="") {
		//window.alert("Preencha o campo: Ramais Virtuais")
		//return false;
	}

}	

function naopermiteacentos() {

var re = document.form1.nome.value;
if(re.match(['[!#$%®&*+¥`^~;?‚¬Í Ù‘·¡È…ÌÕÛ”˙⁄„√Á«?,{}"<> ]'])) {
alert("Acentos, caracteres especiais e espaÁos n„o s„o aceitos !");
document.form1.nome.value='';
return false;
} else {
return true;
}

}
</script>


<?php //include('_header.php');?>
<style type="text/css">
<!--
.style1 {	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
}
-->
</style>
 



<div align="center" id="conteudo">
  <br />  
  <p class="style9" style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold"><img src="img/ico_setaverde_menu.gif" width="16" height="16" /> Filas<br />
  </p>
  <?php 
  if ( $c > 0 )
  { ?>
  <table width="329" border="0">
    <tr>
      <td bgcolor="#FFFFCC"><div align="center" style="font-size: 11px; font-family: Verdana, Arial, Helvetica, sans-serif; font-weight: bold">Ramal(is) virtual(is) n&atilde;o existe(m):<br />
      </div></td>
    </tr>
    <tr>
      <td width="323" bgcolor="#FFFFCC"><div align="center" style="font-size: 11px; font-family: Verdana, Arial, Helvetica, sans-serif">
          <p>
            <?php 
		  $count=1;
		  do{
		  
		  	echo $rv[$count].'<br />';
			
		  	$count=$count+1;
		  }while($count <= $c );?>
            <br />
            <span style="font-size: 11px; font-family: Verdana, Arial, Helvetica, sans-serif; color: #FF0000">( favor corrigir!</span><span style="color: #FF0000"> )</span></p>
      </div></td>
    </tr>
  </table>
  <?php
  }else
  	{
		$_POST['ramais_virtuais']='';
		$_POST['nome']='';
	}
  ?>
<br />
  <br />
  <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1" onSubmit="return camposvazios()">
    <table width="550" align="center">
      <tr valign="baseline">
        <td align="right" valign="middle" nowrap="nowrap">&nbsp;</td>
        <td><div align="right"><a href="pabx_filas.php"><img src="img/voltar.gif" alt="" width="17" height="10" border="0" /> <span class="style1">Lista de filas</span></a></div></td>
      </tr>
      <tr valign="baseline">
        <td width="125" align="right" valign="middle" nowrap="nowrap" bgcolor="#B8E081"><div align="left" style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; color: #FFFFFF">Nome da fila:</div></td>
        <td width="413" bgcolor="#E6E6E6"><input name="nome" type="text" value="<?php 
		  if ( isset($_POST['nome']) )
		  { echo $_POST['nome']; }
		  ?>" size="32" maxlength="25" onkeyup="return naopermiteacentos()"/>
        <br />
        <span style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; color: #FF0000">(Sem espa&ccedil;os ou caracteres especiais)</span></td>
      </tr>
    </table>
    <table width="550" align="center">
      <tr valign="baseline">
        <td align="right" valign="middle" nowrap="nowrap" bgcolor="#B8E081"><div align="center"><span style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; color: #FFFFFF">Par&acirc;metros:</span></div></td>
        <td bgcolor="#B8E081"><div align="center"><span style="font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; color: #FFFFFF">Ramais virtuais:</span></div></td>
      </tr>
      <tr valign="baseline">
        <td align="right" valign="top" nowrap="nowrap" bgcolor="#E6E6E6"><div align="center">
          <textarea name="parametros" cols="29" rows="10">;announce-frequency=90
;announce-holdtime=no
leavewhenempty=yes
eventwhencalled=yes
strategy=ringall
wrapuptime=0
ringinuse=no
joinempty=yes
retry=1
timeoutrestart=no
music=default
timeout=15
maxlen=20</textarea>
        </div></td>
        <td valign="top" bgcolor="#E6E6E6"><div align="center">
          <textarea name="ramais_virtuais" cols="29" rows="10"><?php 
		  if ( isset($_POST['ramais_virtuais']) )
		  { echo $_POST['ramais_virtuais']; }
		  ?></textarea>
          <br />
        <span style="font-size: 10px; font-family: Verdana, Arial, Helvetica, sans-serif; color: #FF0000">(Cadastrar um ramal por linha !)</span></div></td>
      </tr>

      <tr valign="baseline">
        <td nowrap="nowrap" align="right">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
    <input type="submit" value="Cadastrar" />
    <input type="hidden" name="MM_insert" value="form1" />
  </form>
  <p>&nbsp;</p>
  <?php include('_baixo.php');?>
</div>
<script type="text/javascript">
<!--
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
//-->
</script>
</body>
</html>
