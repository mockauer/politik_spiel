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
if ($_SESSION["id"] > 0){
$werte = array ();
$befehl = "SELECT * FROM  spieler";
$absenden = mysql_query($befehl);
// Hier kann der Text stehen
echo "Besetzung des Bundestages:<p>";
while ($row = mysql_fetch_object($absenden)){
	$anteil = round(100/$sitzebundestag*$row->sitzebundestag);
	echo "$row->parteiname hat $row->sitzebundestag Sitze und somit $anteil %...<p>";
	$werte["$row->parteiname"] = $row->sitzebundestag;
}
echo "...von $sitzebundestag Sitzen im Bundestag.<p>";
// Kreisdiagramm erstellen
echo "<h2> Sitzverteilung im Bundestag:<p></h2>";
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
 
    $r = 244;
    $g = 145;
    $b = 0;
    $farbabstufung = 90;
 
imagefill($diagramm, 0, 0, $weiss);
 
$i = 0;
$winkel = 0;
arsort($werte);
$gesamt = array_sum($werte);
foreach($werte as $key => $value){
	$i++;
	$start = $winkel;
	$winkel = $start + $value*360/$gesamt;
 
	$color = imagecolorallocate($diagramm, $r+($i-1)*$farbabstufung, $g+($i-1)*$farbabstufung, $b+($i-1)*$farbabstufung);
 
	imagefilledarc($diagramm, $start_x, $start_y, $radius, $radius, $start, $winkel, $color, IMG_ARC_PIE);
 
	$unterkante = $rand_oben+$punktbreite+($i-1)*($punktbreite+$abstand);
	imagefilledrectangle($diagramm, $rand_links, $rand_oben+($i-1)*($punktbreite+$abstand), $rand_links+$punktbreite, $unterkante, $color);
    imagettftext($diagramm, $schriftgroesse, 0, $rand_links+$punktbreite+5, $unterkante-$punktbreite/2+$schriftgroesse/2, $schwarz, "seb.ttf", $key.", $value Sitze, ".round($value*100/$gesamt, 0)." %");
    }
	imagepng($diagramm, "bundestag.png");
//Kreisdiagramm ende
echo "<img src='bundestag.png' alt='Sitzverteilung im Bundesrat' />";
}else{
echo '<meta http-equiv="refresh" content="2; URL=login.php">';
}
?>

</div>
<div id ="footer">


</div>

</body>

</html>