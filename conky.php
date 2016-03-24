<?
require './connect.php';
require './config.php';
connect();


echo "-------------------- Todo --------------------\n";

$req = mysql_query('SELECT titre,id,level FROM '.$table.' WHERE fait != 1 ORDER BY level DESC, titre ASC');

while ($res = mysql_fetch_object($req))
{
		if ( $res->level == "3" ) { $level="HIG"; }
		else if ( $res->level == "2" ) { $level="MED"; }
		else { $level="LOW"; }

     echo "$level  -  $res->titre\n";
}
