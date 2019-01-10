<?php
//Bevölkerung des Bundes errechnen
function bevoelkerung (){
$bundbev = mysql_result(mysql_query("SELECT SUM(ew) FROM laender"), 0);
$bundbev=number_format($bundbev, 0, ',', '.');
return $bundbev;
}
//Beliebtheitswerte ausgeben
function bel($id2){
$sql = "SELECT * FROM spieler WHERE id = '$id2' LIMIT 1";
$result = mysql_query($sql);
if (!$result) {
	die ('Etwas stimmte mit dem Query nicht: '.$db->error);
	}
$row = mysql_fetch_object($result);
echo "<p><table border=1 align=center>
<tr><th>Ihre Umfragewerte:</th></tr>
<tr><td>Deutschland</td><td>$row->bundbel %</td></tr>
<tr><td>Süddeuschland</td><td>$row->land1bel %</td></tr>
<tr><td>Westdeuschland</td><td>$row->land2bel %</td></tr>
<tr><td>Ostdeuschland</td><td>$row->land3bel %</td></tr>
<tr><td>Norddeuschland</td><td>$row->land4bel %</td></tr></table>";
}
//Wahl des Bundestages ausführen. 
function bundwahl($bundbev){
$werte = array ();
$befehl = "SELECT * FROM  spieler";
$absenden = mysql_query($befehl);
$nichtvergeben = 0;
while ($row = mysql_fetch_object($absenden)){
	echo "$bundbev Leute<p>";
	$nichtwaehler = mt_rand(1,5);
	$nichtvergeben = $nichtvergeben + $nichtwaehler;
	echo "$nichtwaehler % Nichtwähler <p>";
	echo "$row->bundbel% Beliebheit<p>";
	$bundbel = $row->bundbel-$nichtwaehler;
	$stimmen = $bundbev/100*$bundbel;
	$stimmen2 = round($stimmen);
	echo "$stimmen2 Stimmen<p>";
	$ergebnis = 100/$bundbev*$stimmen;
	$ergebnis = number_format($ergebnis, 1, '.', '');
	echo "Sie haben $ergebnis % erreicht!<p>";
	if ($ergebnis > 5){
	$werte["$row->parteiname"] = $ergebnis;
		}else{
		echo "Sie die 5% Hürde nicht geschafft!<p>";
			}
	}
	echo "$nichtvergeben % Nichtwähler.";
	$werte["Nichtwaehler"] = $nichtvergeben;
	//Kreisdiagram,
	echo "<h2> Ergebnis der Bundestagswahl:<p></h2>";
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
    imagettftext($diagramm, $schriftgroesse, 0, $rand_links+$punktbreite+5, $unterkante-$punktbreite/2+$schriftgroesse/2, $schwarz, "seb.ttf", $key." hat ".round($value*100/$gesamt, 0)." %");
    }
	imagepng($diagramm, "bundestag.png");
//Kreisdiagramm ende
echo "<img src='bundestag.png' alt='Sitzverteilung im Bundesrat' />";
}
//Funktion für die Landtagswahl
function landwahl ($land){
$werte = array ();
$absenden2 = mysql_query("SELECT * FROM laender WHERE landid = '$land' LIMIT 1");
$row2 = mysql_fetch_object($absenden2);
$ew = $row2->ew;
$befehl = "SELECT * FROM  spieler";
$absenden = mysql_query($befehl);
$nichtvergeben = 0;
while ($row = mysql_fetch_object($absenden)){
	if ($land == 1){
	echo "$ew Leute<p>";
	$nichtwaehler = mt_rand(0,3);
	$nichtvergeben = $nichtvergeben + $nichtwaehler;
	echo "$nichtwaehler % Nichtwähler <p>";
	echo "$row->land1bel% Beliebheit<p>";
	$bundbel = $row->land1bel-$nichtwaehler;
	$stimmen = round($ew/100*$bundbel);
	echo "$stimmen Stimmen<p>";
	$ergebnis = round(100/$ew*$stimmen);
	echo "Sie haben $ergebnis % erreicht!<p>";
	if ($ergebnis > 5){
	$werte["$row->parteiname"] = $ergebnis;
		}else{
		echo "Sie die 5% Hürde nicht geschafft!<p>";
			}

		}elseif ($land == 2){
		echo "$ew Leute<p>";
	$nichtwaehler = mt_rand(0,3);
	$nichtvergeben = $nichtvergeben + $nichtwaehler;
	echo "$nichtwaehler % Nichtwähler <p>";
	echo "$row->land2bel% Beliebheit<p>";
	$bundbel = $row->land2bel-$nichtwaehler;
	$stimmen = round($ew/100*$bundbel);
	echo "$stimmen Stimmen<p>";
	$ergebnis = round(100/$ew*$stimmen);
	echo "Sie haben $ergebnis % erreicht!<p>";
	if ($ergebnis > 5){
	$werte["$row->parteiname"] = $ergebnis;
		}else{
		echo "Sie die 5% Hürde nicht geschafft!<p>";
			}

			}elseif ($land == 3){
			echo "$ew Leute<p>";
	$nichtwaehler = mt_rand(0,3);
	$nichtvergeben = $nichtvergeben + $nichtwaehler;
	echo "$nichtwaehler % Nichtwähler <p>";
	echo "$row->land3bel% Beliebheit<p>";
	$bundbel = $row->land3bel-$nichtwaehler;
	$stimmen = round($ew/100*$bundbel);
	echo "$stimmen Stimmen<p>";
	$ergebnis = round(100/$ew*$stimmen);
	echo "Sie haben $ergebnis % erreicht!<p>";
	if ($ergebnis > 5){
	$werte["$row->parteiname"] = $ergebnis;
		}else{
		echo "Sie die 5% Hürde nicht geschafft!<p>";
			}

				}elseif($land == 4){
				echo "$ew Leute<p>";
	$nichtwaehler = mt_rand(0,3);
	$nichtvergeben = $nichtvergeben + $nichtwaehler;
	echo "$nichtwaehler % Nichtwähler <p>";
	echo "$row->land4bel% Beliebheit<p>";
	$bundbel = $row->land4bel-$nichtwaehler;
	$stimmen = round($ew/100*$bundbel);
	echo "$stimmen Stimmen<p>";
	$ergebnis = round(100/$ew*$stimmen);
	echo "Sie haben $ergebnis % erreicht!<p>";
	if ($ergebnis > 5){
	$werte["$row->parteiname"] = $ergebnis;
		}else{
		echo "Sie die 5% Hürde nicht geschafft!<p>";
			}

				}
	}
	
	echo "$nichtvergeben % Nichtwähler.";
	$werte["Nichtwaehler"] = $nichtvergeben;
				//Kreisdiagram,
	echo "<h2> Ergebnis Landtagswahl Süddeutschland:<p></h2>";
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
    imagettftext($diagramm, $schriftgroesse, 0, $rand_links+$punktbreite+5, $unterkante-$punktbreite/2+$schriftgroesse/2, $schwarz, "seb.ttf", $key." hat ".round($value*100/$gesamt, 0)." %");
    }
	imagepng($diagramm, "landwahl.png");
//Kreisdiagramm ende
echo "<img src='landwahl.png' alt='Sitzverteilung im Landtag' />";
}


?>