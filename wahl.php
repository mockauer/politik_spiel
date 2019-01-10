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
$row = mysql_fetch_object($absenden);
$row->money=number_format($row->money, 2, ',', '.');
$row->member=number_format($row->member, 0, ',', '.');
echo "$row->parteiname ($row->parteikurz)<p> $row->money &euro; <p> $row->member Mitglieder";
?>
</div>
<?php
// Hier kann der Text stehen
$bundbev = bevoelkerung();
echo '<form action="" method="post">
    <p>Id des Orts (0 Deutschland, 1 Süd, 2 West, 3 Ost, 4 Nord):<br><input name="name" type="text" ></p>
    <input type="submit" name="start" value="Eintragen" />';
$start = $_POST["start"];
$landid = $_POST["name"];
if ($start){
	if($landid == 0){
	bundwahl($bundbev);
	}elseif($landid > 0){
	landwahl($landid);
	}
	}
?>

</div>
<div id ="footer">


</div>

</body>

</html>