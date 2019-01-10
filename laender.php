<html>
<?php
session_start();
include ("config.php");
include ("style.css");
//Übersicht der Länderregierungen
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
//Hier Text für die Mitte
if ($_SESSION["id"] > 0){
$werte = array ();
$befehl = "SELECT * FROM  laender";
$absenden = mysql_query($befehl);
?>
Die Länder werden derzeit wie folgt reagiert:<p>
<?php
while ($row = mysql_fetch_object($absenden)){
	$befehl2 = "SELECT * FROM spieler WHERE id = '$row->regierung1' LIMIT 1";
	$absenden2 = mysql_query($befehl2);
	$row2 = mysql_fetch_object($absenden2);
	echo "$row->landname wird regiert von $row2->parteiname ";
	if ($row->regierung2 != 0){
		$befehl2 = "SELECT * FROM  spieler WHERE id = '$row->regierung2' LIMIT 1";
		$absenden2 = mysql_query($befehl2);
		$row2 = mysql_fetch_object($absenden2);
		echo ", $row2->parteiname";
	}
	if ($row->regierung3 != 0){
		$befehl2 = "SELECT * FROM  spieler WHERE id = '$row->regierung3' LIMIT 1";
		$absenden2 = mysql_query($befehl2);
		$row2 = mysql_fetch_object($absenden2);
		echo ", $row2->parteiname";
	}
	echo " und hat $row->sitzbundrat Sitze im Bundesrat.<p>";
	
	$werte["$row->landname"] = $row->sitzbundrat;
}
$sitzebundrat = mysql_result(mysql_query("SELECT SUM(sitzbundrat) FROM laender"), 0);
echo "Es sind $sitzebundrat Sitze im Bundesrat<p>";
// Kreisdiagramm erstellen
echo "<h2> Sitzverteilung im Bundesrat:<p></h2>";
$breite = 400;
$hoehe = 400;
$radius = 200;
$start_x = ($breite/3)*2;
$start_y = $hoehe/2;
 
$rand_oben = 20;
$rand_links = 20;
$punktbreite = 10;
$abstand = 10;
$schriftgroesse = 10;
 
$diagramm = imagecreatetruecolor($breite, $hoehe);
 
$schwarz = imagecolorallocate($diagramm, 0, 0, 0);
$weiss = imagecolorallocate($diagramm, 255, 255, 255);
 
    $color1 = imagecolorallocate($diagramm, 255, 69, 0);
    $color2 = imagecolorallocate($diagramm, 255, 215, 0);
    $color3 = imagecolorallocate($diagramm, 0, 191, 255);
    $color4 = imagecolorallocate($diagramm, 154, 205, 50);
 
imagefill($diagramm, 0, 0, $weiss);
 
$i = 0;
$winkel = 0;
arsort($werte);
$gesamt = array_sum($werte);
    foreach($werte as $key => $value)
    {
    $i++;
    $start = $winkel;
    $winkel = $start + $value*360/$gesamt;
     
    $color = "color".$i;
     
    imagefilledarc($diagramm, $start_x, $start_y, $radius, $radius, $start, $winkel, $$color, IMG_ARC_PIE);
     
    $unterkante = $rand_oben+$punktbreite+($i-1)*($punktbreite+$abstand);
    imagefilledrectangle($diagramm, $rand_links, $rand_oben+($i-1)*($punktbreite+$abstand), $rand_links+$punktbreite, $unterkante, $$color);
    imagettftext($diagramm, $schriftgroesse, 0, $rand_links+$punktbreite+5, $unterkante-$punktbreite/2+$schriftgroesse/2, $schwarz, "seb.ttf", $key.", $value Sitze, ".round($value*100/$gesamt, 0)." %");
    }
imagepng($diagramm, "bundesrat.png");
//Kreisdiagramm ende
echo "<img src='bundesrat.png' alt='Sitzverteilung im Bundesrat' />";
}else{
echo '<meta http-equiv="refresh" content="2; URL=login.php">';
}
?>
</div>
<div id ="footer">


</div>

</body>

</html>