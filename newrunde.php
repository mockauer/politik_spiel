<?php
// Rundenberechnungen
include ("config.php");
//Zeit holen
$befehl = "SELECT * FROM  zeit LIMIT 1";
$absenden = mysql_query($befehl);
$row = mysql_fetch_object($absenden);
$zeit = $row->woche;
//Zeit hochsetzen und eintragen
$zeit ++;
echo "$zeit";
mysql_query("UPDATE zeit Set woche = '$zeit' ");
//Zeit geändert
$sql = "SELECT * FROM spieler";
$result = mysql_query($sql);
if (!$result) {
	die ('Etwas stimmte mit dem Query nicht: '.$db->error);
	}
while ($row = mysql_fetch_object($result)) {  
// Hier Rechnungen aufstellen. 
//Variabeln speichern
$money = $row->money;
$bundbel = $row->bundbel;
$member = $row->member;
$id2 = $row->id;
//echo "id oben: $id2 <p>";

//Werbedaten holen !!!!!!!!!!!!!!!HIER Beginnt die Berechnung der Werbung!!!!!!!!!!!!
$befehl = "SELECT * FROM  werbung WHERE werbepartei = '$id2'";
$absenden = mysql_query($befehl);
while ($row2 = mysql_fetch_object($absenden)){
//Prüfen ob bund oder land
if ($row2->werbekreis == 0){
	echo "Deutschland: <p>";
	$werbewirkung = mt_rand(10, 20)/10;
	$werbewirkung = $werbewirkung * $row2->werbeart;
	echo "Werbewirkung ist $werbewirkung"; 
	$verteil = mysql_query("SELECT COUNT(id) FROM spieler");
	$menge = mysql_fetch_row($verteil);
	$menge = $menge[0];
	//Aktuelle Partei abziehen
	$menge --;
	echo " id = $id2 <p>";
	echo " $menge anzahl von anderen.<p>";
	$abnahme = round($werbewirkung / $menge);
	echo "$abnahme Betrag der Abnahme für den einzelnen.<p>";
	//Schleife damit die anderen abgezogen bekommen
	$sql3 = "SELECT * FROM spieler WHERE id NOT = '$id2'";
	$result3 = mysql_query($sql3);
	if (!$result3) {
	die ('Etwas stimmte mit dem Query nicht: '.$db->error);
	}
	while ($row3 = mysql_fetch_object($result3)) { 
	$bundbel2 = $row3->bundbel - $abnahme;
	echo " Altebeliebtheit des anderen: $row3->bundbel<p>";
	echo "Neue beliebtheit des anderen: $bundbel2<p>";
	$test = mysql_query("UPDATE spieler Set bundbel = bundbel - $abnahme WHERE id NOT = '$id2' AND bundbel > 0");
	if(!$test){
		echo "Fehler bei einspeisung! $db->error<p>";
		}
	}//Den anderen Abgezogen
		echo "Alte Beliebtheit: $bundbel, dazu: $werbewirkung <p>";
		$bundbel = round($bundbel + $werbewirkung);
		//Gutschrift
		echo "Gutschrift: $bundbel <p>";
		mysql_query("UPDATE spieler Set bundbel = bundbel + $werbewirkung WHERE id = '$id2' AND bundbel < 100 LIMIT 1");
		$belbund = mysql_result(mysql_query("SELECT SUM(bundbel) FROM spieler"), 0);
		if ($belbund < 100){
			$fehlt = 100 - $belbund;
			mysql_query("UPDATE spieler Set bundbel = bundbel + $fehlt WHERE id = '$id2' AND bundbel < 100 LIMIT 1");
			}
	
	//Hier beginnt Landtteil
	}elseif($row2->werbekreis > 0){
	//Süddeutschland
		if ($row2->werbekreis == 1){
		echo "Süddeutschland: <p>";
			$werbewirkung = mt_rand(10, 20)/10;
	$werbewirkung = $werbewirkung * $row2->werbeart;
	echo "Werbewirkung ist $werbewirkung"; 
	$verteil = mysql_query("SELECT COUNT(id) FROM spieler");
	$menge = mysql_fetch_row($verteil);
	$menge = $menge[0];
	//Aktuelle Partei abziehen
	$menge --;
	echo " id = $id2 <p>";
	echo " $menge anzahl von anderen.<p>";
	$abnahme = round($werbewirkung / $menge);
	echo "$abnahme Betrag der Abnahme für den einzelnen.<p>";
	//Schleife damit die anderen abgezogen bekommen
	$sql3 = "SELECT * FROM spieler WHERE id NOT = '$id2'";
	$result3 = mysql_query($sql3);
	if (!$result3) {
	die ('Etwas stimmte mit dem Query nicht: '.$db->error);
	}
	while ($row3 = mysql_fetch_object($result3)) { 
	$bundbel2 = $row3->land1bel - $abnahme;
	echo " Altebeliebtheit des anderen: $row3->land1bel<p>";
	echo "Neue beliebtheit des anderen: $bundbel2<p>";
	$test = mysql_query("UPDATE spieler Set land1bel = land1bel - $abnahme WHERE id NOT = '$id2' AND land1bel > 0");
	if(!$test){
		echo "Fehler bei einspeisung! $db->error<p>";
		}
	}//Den anderen Abgezogen
		echo "Alte Beliebtheit: $row->land1bel, dazu: $werbewirkung <p>";
		$bundbel = round($row->land1bel + $werbewirkung);
		//Gutschrift
		echo "Gutschrift: $bundbel <p>";
		mysql_query("UPDATE spieler Set land1bel = land1bel + $werbewirkung WHERE id = '$id2' AND land1bel < 100 LIMIT 1");
		$belbund = mysql_result(mysql_query("SELECT SUM(land1bel) FROM spieler"), 0);
		if ($belbund < 100){
			$fehlt = 100 - $belbund;
			mysql_query("UPDATE spieler Set land1bel = land1bel + $fehlt WHERE id = '$id2' AND land1bel < 100 LIMIT 1");
			}
			}
			//Westdeutschland
			echo "Westdeutschland: <p>";
					if ($row2->werbekreis == 2){
			$werbewirkung = mt_rand(10, 20)/10;
	$werbewirkung = $werbewirkung * $row2->werbeart;
	echo "Werbewirkung ist $werbewirkung"; 
	$verteil = mysql_query("SELECT COUNT(id) FROM spieler");
	$menge = mysql_fetch_row($verteil);
	$menge = $menge[0];
	//Aktuelle Partei abziehen
	$menge --;
	echo " id = $id2 <p>";
	echo " $menge anzahl von anderen.<p>";
	$abnahme = round($werbewirkung / $menge);
	echo "$abnahme Betrag der Abnahme für den einzelnen.<p>";
	//Schleife damit die anderen abgezogen bekommen
	$sql3 = "SELECT * FROM spieler WHERE id NOT = '$id2'";
	$result3 = mysql_query($sql3);
	if (!$result3) {
	die ('Etwas stimmte mit dem Query nicht: '.$db->error);
	}
	while ($row3 = mysql_fetch_object($result3)) { 
	$bundbel2 = $row3->land2bel - $abnahme;
	echo " Altebeliebtheit des anderen: $row3->land2bel<p>";
	echo "Neue beliebtheit des anderen: $bundbel2<p>";
	$test = mysql_query("UPDATE spieler Set land2bel = land2bel - $abnahme WHERE id NOT = '$id2' AND land2bel > 0");
	if(!$test){
		echo "Fehler bei einspeisung! $db->error<p>";
		}
	}//Den anderen Abgezogen
		echo "Alte Beliebtheit: $row->land2bel, dazu: $werbewirkung <p>";
		$bundbel = round($row->land2bel + $werbewirkung);
		//Gutschrift
		echo "Gutschrift: $bundbel <p>";
		mysql_query("UPDATE spieler Set land2bel = land2bel + $werbewirkung WHERE id = '$id2' AND land2bel < 100 LIMIT 1");
		$belbund = mysql_result(mysql_query("SELECT SUM(land2bel) FROM spieler"), 0);
		if ($belbund < 100){
			$fehlt = 100 - $belbund;
			mysql_query("UPDATE spieler Set land2bel = land2bel + $fehlt WHERE id = '$id2' AND land2bel < 100 LIMIT 1");
			}
			}
		//Ostdeutschland
				if ($row2->werbekreis == 3){
				echo "Ostdeutschland: <p>";
			$werbewirkung = mt_rand(10, 20)/10;
	$werbewirkung = $werbewirkung * $row2->werbeart;
	echo "Werbewirkung ist $werbewirkung"; 
	$verteil = mysql_query("SELECT COUNT(id) FROM spieler");
	$menge = mysql_fetch_row($verteil);
	$menge = $menge[0];
	//Aktuelle Partei abziehen
	$menge --;
	echo " id = $id2 <p>";
	echo " $menge anzahl von anderen.<p>";
	$abnahme = round($werbewirkung / $menge);
	echo "$abnahme Betrag der Abnahme für den einzelnen.<p>";
	//Schleife damit die anderen abgezogen bekommen
	$sql3 = "SELECT * FROM spieler WHERE id NOT = '$id2'";
	$result3 = mysql_query($sql3);
	if (!$result3) {
	die ('Etwas stimmte mit dem Query nicht: '.$db->error);
	}
	while ($row3 = mysql_fetch_object($result3)) { 
	$bundbel2 = $row3->land3bel - $abnahme;
	echo " Altebeliebtheit des anderen: $row3->land3bel<p>";
	echo "Neue beliebtheit des anderen: $bundbel2<p>";
	$test = mysql_query("UPDATE spieler Set land3bel = land3bel - $abnahme WHERE id NOT = '$id2' AND land3bel > 0");
	if(!$test){
		echo "Fehler bei einspeisung! $db->error<p>";
		}
	}//Den anderen Abgezogen
		echo "Alte Beliebtheit: $row->land3bel, dazu: $werbewirkung <p>";
		$bundbel = round($row->land3bel + $werbewirkung);
		//Gutschrift
		echo "Gutschrift: $bundbel <p>";
		mysql_query("UPDATE spieler Set land3bel = land3bel + $werbewirkung WHERE id = '$id2' AND land3bel < 100 LIMIT 1");
		$belbund = mysql_result(mysql_query("SELECT SUM(land3bel) FROM spieler"), 0);
		if ($belbund < 100){
			$fehlt = 100 - $belbund;
			mysql_query("UPDATE spieler Set land3bel = land3bel + $fehlt WHERE id = '$id2' AND land3bel < 100 LIMIT 1");
			}
			}
		//Nordeutschland
				if ($row2->werbekreis == 4){
				echo "Norddeutschland: <p>";
			$werbewirkung = mt_rand(10, 20)/10;
	$werbewirkung = $werbewirkung * $row2->werbeart;
	echo "Werbewirkung ist $werbewirkung"; 
	$verteil = mysql_query("SELECT COUNT(id) FROM spieler");
	$menge = mysql_fetch_row($verteil);
	$menge = $menge[0];
	//Aktuelle Partei abziehen
	$menge --;
	echo " id = $id2 <p>";
	echo " $menge anzahl von anderen.<p>";
	$abnahme = round($werbewirkung / $menge);
	echo "$abnahme Betrag der Abnahme für den einzelnen.<p>";
	//Schleife damit die anderen abgezogen bekommen
	$sql3 = "SELECT * FROM spieler WHERE id NOT = '$id2'";
	$result3 = mysql_query($sql3);
	if (!$result3) {
	die ('Etwas stimmte mit dem Query nicht: '.$db->error);
	}
	while ($row3 = mysql_fetch_object($result3)) { 
	$bundbel2 = $row3->land4bel - $abnahme;
	echo " Altebeliebtheit des anderen: $row3->land4bel<p>";
	echo "Neue beliebtheit des anderen: $bundbel2<p>";
	$test = mysql_query("UPDATE spieler Set land4bel = land4bel - $abnahme WHERE id NOT = '$id2' AND land4bel > 0");
	if(!$test){
		echo "Fehler bei einspeisung! $db->error<p>";
		}
	}//Den anderen Abgezogen
		echo "Alte Beliebtheit: $row->land4bel, dazu: $werbewirkung <p>";
		$bundbel = round($row->land4bel + $werbewirkung);
		//Gutschrift
		echo "Gutschrift: $bundbel <p>";
		mysql_query("UPDATE spieler Set land4bel = land4bel + $werbewirkung WHERE id = '$id2' AND land4bel < 100 LIMIT 1");
		$belbund = mysql_result(mysql_query("SELECT SUM(land4bel) FROM spieler"), 0);
		if ($belbund < 100){
			$fehlt = 100 - $belbund;
			mysql_query("UPDATE spieler Set land4bel = land4bel + $fehlt WHERE id = '$id2' AND land4bel < 100 LIMIT 1");
			}
			}
	$sql = "SELECT * FROM werbung";
	$result = mysql_query($sql);
	if (!$result) {
	die ('Etwas stimmte mit dem Query nicht: '.$db->error);
	}
	while ($row = mysql_fetch_object($result)) { 
		mysql_query("UPDATE werbung Set werbezeit = werbezeit - 1");
		$sql2 = "SELECT * FROM werbung";
		$result2 = mysql_query($sql2);
		while ($row2 = mysql_fetch_object($result2)) { 
		mysql_query("DELETE FROM werbung WHERE werbezeit = 0 OR werbezeit < 0 ");
		}}
}//!!!!!!!!!!!!!!!!!!!!!!!!!Hier ist die Werbeberechnung zuende!!!!!!!!!!!!!!!!!!!!!!!
//Parteigeld neu berechnen
$moneyold = $money;
$beitrag = round($member*60/52);
$money = $money + $beitrag;
mysql_query("UPDATE spieler Set money = money + $beitrag WHERE id = '$id2' LIMIT 1");
//Parteigeld berechnet!
}}
?>