<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<script language="Javascript">
function ouvreFenetre(page, largeur, hauteur) {
  window.open(page, "", "scrollbars=yes,menubar=no,toolbar=no,resizable=no,width=800,height=600,width=800,height=600,top=250,left=430");
}
</script>


<?

require './config.php';
require './connect.php';
connect();


if ($_GET['mode'] == 'add')
{
if( $_GET['titre']!="" ) {
   mysql_query('INSERT INTO '.$table.' SET date=CONCAT(CURDATE(),\' \',CURTIME()), titre="'.htmlentities( $_GET['titre'], ENT_QUOTES ).'", level="'.htmlentities( $_GET['level'], ENT_QUOTES ).'", fait=0' ) or die(mysql_error());
   echo '<meta http-equiv="refresh" content="0;url=./" />';
}
}
if ($_GET['mode'] == 'valid')
{
mysql_query('UPDATE '.$table.' SET fait=1 WHERE id='.$_GET['id'] ) or die(mysql_error());
echo '<meta http-equiv="refresh" content="0;url=./" />';
}
if ($_GET['mode'] == 'unvalid')
{
mysql_query('UPDATE '.$table.' SET fait=0 WHERE id='.$_GET['id'] ) or die(mysql_error());
echo '<meta http-equiv="refresh" content="0;url=./" />';
}

if ($_GET['mode'] == 'del')
{
mysql_query("DELETE FROM ".$table." WHERE id=".$_GET['id']." LIMIT 1;") or die(mysql_error());
echo '<meta http-equiv="refresh" content="0;url=?mode=histo" />';
die();
}
?>
<html>
<head>
<title><? echo $title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!--
<meta http-equiv="refresh" content="30;">
-->
<style type="text/css">
<!--
.text1 {font-family: Arial, Helvetica, sans-serif;font-size: 12px;color: White;text-align : left;}
.text2 {font-family: Arial, Helvetica, sans-serif;font-size: 12px;color: Silver;text-align : left;}
.titre1 {font-family: Arial, Helvetica, sans-serif;font-size: 12px;font-weight: bold;color: #FFFFFF;}
.titre2 {font-family: Arial, Helvetica, sans-serif;font-size: 12px;font-weight: bold;color: #cccccc;}
input
{
  font-family: Verdana, Arial, Helvetica, sans-serif;
  font-size: 12px;
  border: 1px solid #0F277B;
}

body {
        #background-image: url(img/fond2.jpg);
        background-color: #525A73;
        background-attachment:fixed
}
-->
</style>
<base target="_self"/>
</head>


<table width="" height="100%" border="0" cellspacing="0" cellpadding="0" align="left">
<tr>
<td align="center" valign="top">

<table width="100%" border="0" cellspacing="2" cellpadding="0" align="center">

<table width="100%" border="0" cellspacing="4" cellpadding="0" align="center">
<tr>
<td><img src="img/cube_rouge_small.gif" width="18" height="20"></td>
<td width="100%" nowrap class="titre1"><? if ($_GET['mode'] != 'histo' ) { echo '&nbsp;A faire&nbsp;:';} else { echo '&nbsp;Deja fait&nbsp;:'; } ?></td>
</tr>
</table>
<table width="600px" border="0" cellspacing="2" cellpadding="0" align="center">
<?
if ($_GET['mode'] != 'histo' ) {
$req = mysql_query('SELECT titre,id,level FROM '.$table.' WHERE fait != 1 ORDER BY level DESC, titre ASC');

while ($res = mysql_fetch_object($req))
{
		if ( $res->level == "3" ) { $image="img/level_3.gif"; }
		else if ( $res->level == "2" ) { $image="img/level_2.gif"; }
		else { $image="img/level_1.gif"; }

     echo '<tr><td nowrap class="text1">&nbsp;&nbsp;&nbsp;&nbsp</td>';
     echo '<td bgcolor="#44495a"  class="text1">';
     echo '<img src="'.$image.'" border=0></a>&nbsp;&nbsp;<b>&gt;</b>&nbsp;&nbsp;';
     echo $res->titre;
     echo '</td><td align="right" width="60px">&nbsp;&nbsp;<a href="javascript:ouvreFenetre(\'popup.php?mode=voir&id='.$res->id.'\', 300, 100)"><img src="img/index.gif" align="absbottom" border=0></a>';
     echo '&nbsp;<a href="index.php?mode=valid&id='.$res->id.'"><img src="img/valid.gif" align="absbottom" border=0></a></td></tr>';
}
}                                //
else {
$req = mysql_query('SELECT titre,id,level FROM '.$table.' WHERE fait = 1 ORDER BY level DESC, titre ASC LIMIT 20');

while ($res = mysql_fetch_object($req))
{
		if ( $res->level == "3" ) { $image="img/level_3.gif"; }
		else if ( $res->level == "2" ) { $image="img/level_2.gif"; }
		else { $image="img/level_1.gif"; }
?>
     <tr>
        <td nowrap class="text1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        <td class="text1">
            <img src="<?=$image; ?>" border=0></a>&nbsp;&nbsp;<b>&gt;</b>&nbsp;&nbsp;
            <?=$res->titre; ?>
        </td>
        <td align="right" width="90px">
            &nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:ouvreFenetre('popup.php?mode=voir&id=<?=$res->id; ?>', 300, 100)"><img src="img/index.gif" align="absbottom" border=0></a>
            &nbsp;<a href="index.php?mode=del&id=<?=$res->id; ?>"><img src="img/del.png" align="absbottom" border=0></a>
            &nbsp;<a href="index.php?mode=unvalid&id=<?=$res->id; ?>"><img src="img/refresh.png" align="absbottom" border=0></a>
        </td>
</tr>
<?
}
}

?>
</table>
</td>
</tr>
<tr>
<td  valign="bottom">
<br>

<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">

<form action="index.php" method="GET">
<tr class = "titre2" >
<span class="titre1">historique :</span> <? if( $_GET['mode'] == histo) { echo '<a class = "titre2" href="index.php?mode=liste">off</a>';} else { echo '<a class = "titre2" href="index.php?mode=histo">on</a>'; } ?>
<td class="text1">
	<select size="1" name="level">
		<option selected value="1">Low</option>
		<option value="2">Med</option>
		<option value="3">High</option>
	</select>
	<input type="hidden" name="mode" value="add">
	<input name="titre" type="text" value="" size="24">&nbsp;&nbsp;<input type="submit" value="Ajouter">

</td>
</tr>
</form>
</table>
</td>
</tr>

</body>
</html>
