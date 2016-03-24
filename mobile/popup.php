<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<style type="text/css">
    .text1 {font-family: Arial, Helvetica, sans-serif;font-size: 28px;color: White;text-align : left;}
    .text2 {font-family: Arial, Helvetica, sans-serif;font-size: 28px;color: Silver;text-align : left;}
    .titre1 {font-family: Arial, Helvetica, sans-serif;font-size: 38px;font-weight: bold;color: #FFFFFF;}
    .titre2 {font-family: Arial, Helvetica, sans-serif;font-size: 32px;font-weight: bold;color: #cccccc;}
    input, select, textarea
    {
      font-family: Verdana, Arial, Helvetica, sans-serif;
      font-size: 35px;
      border: 1px solid #0F277B;
      text-align: left;
      scroll:auto;
    }
</style>
<!-- <body bgcolor="#525A73"> -->
<body bgcolor="#000000">

<?

require '../config.php';
require '../connect.php';
connect();

if ( $_POST['info'] ) {
    $info = str_replace("\n","<br>", htmlentities( $_POST['info'], ENT_QUOTES ));
    $level = htmlentities( $_POST['level'], ENT_QUOTES );
    if (!empty($info)){
        mysql_query("UPDATE `".$table."` SET `describ` = '".$info."' WHERE `id` =".$_GET['id']."");
    }
    mysql_query("UPDATE `".$table."` SET `level` = '".$level."' WHERE `id` =".$_GET['id']."");
}

if( $_GET['mode'] == "voir")
{
    $req = mysql_query('SELECT * FROM '.$table.' WHERE id = '.$_GET['id'].'');
    $res = mysql_fetch_object($req);
    ?>
    <table width="970px" height="100%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr align="left">
            <td height="32px" colspan="2" valign="top">
                <div class='titre1'>
                    <img src="../img/cube_rouge_small.gif" width="32" height="20">
                    &nbsp;&nbsp;
                    <u><?=$res->titre; ?><br></u>
                <div/> 
                &nbsp;
            </td> 
        </tr>
        <tr align="left" height="20px" >
            <td valign="top" class='titre2' width="120px" >
                date : 
            </td>
            <td valign="top" >
                <? echo "<div class='text1'>".$res->date."<br><div/>"; ?>
                &nbsp;
            </td>
        </tr>
        <tr align="left" height="20px" >
            <td valign="top" class='titre2'>
                Level : 
            </td>
            <td valign="top">
    			<?  
    			if ( $res->level == "3" ) { $image="../img/level_3.gif"; }
    			else if ( $res->level == "2" ) { $image="../img/level_2.gif"; }
    			else { $image="../img/level_1.gif"; }
    			echo '<img height="32px" src="'.$image.'" border=0>'; ?>&nbsp;
    		</td>
        </tr>
        <tr align="left">
            <td valign="top" class='titre2'>
                Info : 
            </td>
            <? if($res->describ == '') { $info = 'Pas d\'information'; } else { $info = $res->describ; } ?>
            <td valign="top">
                <? echo "<div class='text1'>".$info."<br><div/>"; ?>&nbsp;
            </td>
        </tr>
        <tr align="left" height="20px" >
            <td >&nbsp;</td>
            <td valign="bottom">
                <div align="right">
                    <? echo '<a class=\'titre2\' href="popup.php?mode=des&id='.$_GET['id'].'">modifier/ajouter</a>'; ?>
                </div>
            </td>
        </tr>
    </table>
    <?
}


if( $_GET['mode'] == "des")
{
   $req = mysql_query('SELECT * FROM '.$table.' WHERE id = '.$_GET['id'].'');
   $res = mysql_fetch_object($req);
   $info = str_replace("<br>","\n",$res->describ );
    ?>
    <form name="infoform" action="popup.php?mode=voir&id=<?=$_GET['id']; ?>" method="post">
    <table width="970" height="100%" border="1" align="center" cellpadding="0" cellspacing="0">
        <tr align="left">
            <td height="32" colspan="2" valign="top">
                <? echo "<div class='titre1'>".'<img src="../img/cube_rouge_small.gif" width="18" height="20">&nbsp;&nbsp;<u>'.$res->titre.'<br></u><div/>'; ?>&nbsp;
            </td>
        </tr>
        <tr align="left">
            <td width="120px" height="20" valign="top" class='titre1' >date : </td>
            <td  height="20" valign="top"><? echo "<div class='titre2'>".$res->date."<br><div/>"; ?>&nbsp;</td>
        </tr>
        <tr align="left">
            <td height="20" valign="top" class='titre1'>level : </td>
            <td height="20" valign="top">
			    <select size="1" name="level">
			    	<option <? if ( $res->level == "1" ) { echo " selected "; } ?> value="1">Low</option>
			    	<option <? if ( $res->level == "2" ) { echo " selected "; } ?> value="2">Med</option>
			    	<option <? if ( $res->level == "3" ) { echo " selected "; } ?> value="3">High</option>
			    </select>
			    &nbsp;
            </td>
        </tr>
        <tr align="left">
            <td valign="top" class='titre1'>Info : </td>
            <td valign="top">
                <? if($res->describ == '') { $info = 'Pas d\'information'; } else { $info = $info; } ?>
                <textarea name="info" rows=16 cols=37 wrap="off"><? echo $info; ?></textarea>
            </td>
        </tr>
        <tr align="left">
            <td height="100%">&nbsp;</td>
            <td height="100%" valign="bottom">
                <div align="right">
                    <input type="submit" value="ok">
                </div>
            </td>
        </tr>
	</table>
    </form>
<? } ?>


