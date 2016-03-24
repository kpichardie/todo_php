<?
function connect()
{
global $dbname;
global $dbuser;
global $dbpass;
global $connectDB;
global $host;
$connect = false;
$connect = @mysql_connect($host, $dbuser, $dbpass) or $msgerr = "Impossible de se connecter";
if($connect!="")
{
$connect = @mysql_select_db($dbname) or $msgerr = "Impossible de sélectionner la base";
}
if($connect == "")
{
$connectDB = false;
}
else
{
$connectDB = true;
}
return $connectDB;
}
?>
