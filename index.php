<html>
<?php
session_start();
include ("config.php");
include ("style.css");
include ("function.php");
?>

<body>
<div id="title">
Der Polit Simulator

</div>
<div id="haupt">
<div id="menue">
<?php
// Hier die Datei mit den Links (untereinander Includen).
include ("menue.php");
?>
</div>
<div id=infobox>
Ihre Partei:<p>
<?php
//Übersicht an der Infobox rechts ausgeben
$befehl = "SELECT * FROM  spieler WHERE id = '$id' LIMIT 1";
$absenden = mysql_query($befehl);
$row = mysql_fetch_object($absenden);#
$row->money=number_format($row->money, 2, ',', '.');
$row->member=number_format($row->member, 0, ',', '.');
echo "$row->parteiname ($row->parteikurz)<p> $row->money &euro; <p> $row->member Mitglieder";
?>

</div>
<?php
if ($_SESSION["id"] > 0){
// Hier kann der Text stehen
$bundbev = bevoelkerung();
bundwahl($bundbev);
}else{
echo '<meta http-equiv="refresh" content="2; URL=login.php">';
}
?>

</div>
<div id ="footer">


</div>

</body>

</html>