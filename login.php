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
$row->member=number_format($row->member, 2, ',', '.');
echo "$row->parteiname ($row->parteikurz)<p> $row->money &euro; <p> $row->member Mitglieder";
?>
</div>
<?php
echo '<form action="" method="post">
	<p>Loginid:<br><input name="name" type="text" ></p>
    <p>Passwort:<br><input name="pass" type="password" ></p>
    <input type="submit" name="start" value="Eintragen" />';
$start = $_POST["start"];
$name = $_POST["name"];
$pass = $_POST["pass"];
$_SESSION['id'] = 0;
if ($start){
	$pass = md5($pass);
	$befehl = "SELECT * FROM  spieler WHERE id = '$name' LIMIT 1";
	$absenden = mysql_query($befehl);
	$row = mysql_fetch_object($absenden);
	if ( $pass == $row->pass){
		echo "Login Erfolgreich!";
		$_SESSION["id"] = $name;
		echo '<meta http-equiv="refresh" content="2; URL=index.php">';
		}else{
		echo "Fehler!";
		}
	}
?>

</div>
<div id ="footer">


</div>

</body>

</html>