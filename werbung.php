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
// Formular für Werbung
if ($_SESSION["id"] > 0){
?>
<h3>Werbung buchen:<p></h3>
<form action="" method="post">
	<select name="werbeart">
	<option value="1">Flyer</option>
	<option value="2">Plakate</option>
	<option value="3">Wahlgeschenke</option>
	<option value="4">Zeitungsinserate</option>
	<option value="5">Radiowerbung</option>
	<option value="6">Fernsehenwerbung</option>
	</select><p>
	<select name="werbekreis">
	<option value="0">Deutschland</option>
	<option value="1">Süddeutschland</option>
	<option value="2">Westdeutschland</option>
	<option value="3">Ostdeutschland</option>
	<option value="4">Norddeutschland</option>
	</select>
    <p>Anzahl an Wochen:<input name="woche" type="text" ></p>
    <input type="submit" name="start" value="Preisanfrage" /><p>
<?php


//Preis berechnen
//Übergebene Variabeln speichern
$werbeart = $_POST["werbeart"];
$werbekreis = $_POST["werbekreis"];
$werbezeit = $_POST["woche"];
$start = $_POST["start"];
$kauf = $_POST["start2"];
$werbepreis = $_POST["werbepreis"];
//bevölkerung erechnen
$bundbev = bevoelkerung ();

//Prüfen ob Formular gedrückt
if ($start != NULL){

	//Prüfen ob land gemeind ist. 
	if ($werbekreis != 0){
		//Länderdaten einholen
		$befehl = "SELECT * FROM  laender WHERE landid = '$werbekreis' LIMIT 1";
		$absenden = mysql_query($befehl);
		$row = mysql_fetch_object($absenden);
		echo "$row->ew";
		if ($werbeart == 1){
			$werbepreis = $row->ew*0.01*$werbezeit;
			echo "Die Flyeraktion in $row->landname kostet: $werbepreis &euro;";
			echo "<p><form action='' method='post'><input type='hidden' name='werbeart' value='$werbeart'><input type='hidden' name='werbekreis' value='$werbekreis'><input type='hidden' name='werbepreis' value='$werbepreis'><input type='hidden' name='werbezeit' value='$werbezeit'><input type='submit' name='start2' value='Kaufen' /><p>";
			}elseif ($werbeart == 2){
				$werbepreis = $row->ew*0.03*$werbezeit;
				echo "Die Plakatwerbung in $row->landname kostet: $werbepreis &euro;";
				echo "<p><form action='' method='post'><input type='hidden' name='werbeart' value='$werbeart'><input type='hidden' name='werbekreis' value='$werbekreis'><input type='hidden' name='werbepreis' value='$werbepreis'><input type='hidden' name='werbezeit' value='$werbezeit'><input type='submit' name='start2' value='Kaufen' /><p>";
				}elseif ($werbeart == 3){
					$werbepreis = $row->ew*0.06*$werbezeit;
					echo "Die Wahlgeschenke in $row->landname kostet: $werbepreis &euro;";
					echo "<p><form action='' method='post'><input type='hidden' name='werbeart' value='$werbeart'><input type='hidden' name='werbekreis' value='$werbekreis'><input type='hidden' name='werbepreis' value='$werbepreis'><input type='hidden' name='werbezeit' value='$werbezeit'><input type='submit' name='start2' value='Kaufen' /><p>";
					}elseif ($werbeart == 4){
						$werbepreis = $row->ew*0.1*$werbezeit;
						echo "Die Zeitungsinserate in $row->landname kostet: $werbepreis &euro;";
						echo "<p><form action='' method='post'><input type='hidden' name='werbeart' value='$werbeart'><input type='hidden' name='werbekreis' value='$werbekreis'><input type='hidden' name='werbepreis' value='$werbepreis'><input type='hidden' name='werbezeit' value='$werbezeit'><input type='submit' name='start2' value='Kaufen' /><p>";
						}elseif($werbeart == 5){
							$werbepreis = $row->ew*0.5*$werbezeit;
							echo "Die Radiowerbung in $row->landname kostet: $werbepreis &euro;";
							echo "<p><form action='' method='post'><input type='hidden' name='werbeart' value='$werbeart'><input type='hidden' name='werbekreis' value='$werbekreis'><input type='hidden' name='werbepreis' value='$werbepreis'><input type='hidden' name='werbezeit' value='$werbezeit'><input type='submit' name='start2' value='Kaufen' /><p>";
							}elseif($werbeart == 6){
								$werbepreis = $row->ew*$werbezeit;
								echo "Die Fernsehwerbung in $row->landname kostet: $werbepreis &euro;";
								echo "<p><form action='' method='post'><input type='hidden' name='werbeart' value='$werbeart'><input type='hidden' name='werbekreis' value='$werbekreis'><input type='hidden' name='werbepreis' value='$werbepreis'><input type='hidden' name='werbezeit' value='$werbezeit'><input type='submit' name='start2' value='Kaufen' /><p>";
								}
		}elseif($werbekreis == 0){
			if ($werbeart == 1){
			$werbepreis = $bundbev*0.01*$werbezeit;
			echo "Die Flyeraktion in $row->landname kostet: $werbepreis &euro;";
			echo "<p><form action='' method='post'><input type='hidden' name='werbeart' value='$werbeart'><input type='hidden' name='werbekreis' value='$werbekreis'><input type='hidden' name='werbepreis' value='$werbepreis'><input type='hidden' name='werbezeit' value='$werbezeit'><input type='submit' name='start2' value='Kaufen' /><p>";
			}elseif ($werbeart == 2){
				$werbepreis = $bundbev*0.03*$werbezeit;
				echo "Die Plakatwerbung in $row->landname kostet: $werbepreis &euro;";
				echo "<p><form action='' method='post'><input type='hidden' name='werbeart' value='$werbeart'><input type='hidden' name='werbekreis' value='$werbekreis'><input type='hidden' name='werbepreis' value='$werbepreis'><input type='hidden' name='werbezeit' value='$werbezeit'><input type='submit' name='start2' value='Kaufen' /><p>";
				}elseif ($werbeart == 3){
					$werbepreis = $bundbev*0.06*$werbezeit;
					echo "Die Wahlgeschenke in $row->landname kostet: $werbepreis &euro;";
					echo "<p><form action='' method='post'><input type='hidden' name='werbeart' value='$werbeart'><input type='hidden' name='werbekreis' value='$werbekreis'><input type='hidden' name='werbepreis' value='$werbepreis'><input type='hidden' name='werbezeit' value='$werbezeit'><input type='submit' name='start2' value='Kaufen' /><p>";
					}elseif ($werbeart == 4){
						$werbepreis = $bundbev*0.1*$werbezeit;
						echo "Die Zeitungsinserate in $row->landname kostet: $werbepreis &euro;";
						echo "<p><form action='' method='post'><input type='hidden' name='werbeart' value='$werbeart'><input type='hidden' name='werbekreis' value='$werbekreis'><input type='hidden' name='werbepreis' value='$werbepreis'><input type='hidden' name='werbezeit' value='$werbezeit'><input type='submit' name='start2' value='Kaufen' /><p>";
						}elseif($werbeart == 5){
							$werbepreis = $bundbev*0.5*$werbezeit;
							echo "Die Radiowerbung in $row->landname kostet: $werbepreis &euro;";
							echo "<p><form action='' method='post'><input type='hidden' name='werbeart' value='$werbeart'><input type='hidden' name='werbekreis' value='$werbekreis'><input type='hidden' name='werbepreis' value='$werbepreis'><input type='hidden' name='werbezeit' value='$werbezeit'><input type='submit' name='start2' value='Kaufen' /><p>";
							}elseif($werbeart == 6){
								$werbepreis = $bundbev*$werbezeit;
								echo "Die Fernsehwerbung in $row->landname kostet: $werbepreis &euro;";
								echo "<p><form action='' method='post'><input type='hidden' name='werbeart' value='$werbeart'><input type='hidden' name='werbekreis' value='$werbekreis'><input type='hidden' name='werbepreis' value='$werbepreis'><input type='hidden' name='werbezeit' value='$werbezeit'><input type='submit' name='start2' value='Kaufen' /><p>";
								}
			}
	}
		
		
if ($kauf != NULL){
	$werbezeit = $_POST["werbezeit"];
	$befehl = "SELECT * FROM  spieler WHERE id = '$id' LIMIT 1";
	$absenden = mysql_query($befehl);
	$row = mysql_fetch_object($absenden);
	$money = $row->money;
	echo "$money, $werbeart, $werbekreis, $werbepreis<p>";
	if ($money > $werbepreis){
		$eintragen = "INSERT INTO werbung (werbepartei, werbeart, werbekreis, werbezeit) VALUES ('$id','$werbeart', '$werbekreis', '$werbezeit')";
		$eintragung = mysql_query($eintragen);
		$money = $money - $werbepreis;
		echo "<p>$money<p>";
		$aendern =  mysql_query("UPDATE spieler Set money = '$money' WHERE id = '$id' LIMIT 1");
		if($aendern){
		echo "Bezahlt.<p>";
		}else{
		echo "Fehler beim bezahlen!";
		}
		if($eintragung){
			echo "Werbung gekauft";
			}
		}else{
		echo "<p>Sie können sich die Werbung nicht leisten!<p>";
			}
	}
?>
<h3>Gebuchte Werbung<p></h3>
<?php
//Werbeuebersicht hinzufügen
$sql = "SELECT * FROM werbung WHERE werbepartei = '$id' LIMIT 20";
$result = mysql_query($sql);
if (!$result) {
	die ('Etwas stimmte mit dem Query nicht: '.$db->error);
	}
while ($row = mysql_fetch_object($result)) {  
if($row->werbekreis == 0){
	if($row->werbeart == 1){
		echo "<p> Die Flyerwerbung in Deutschland geht noch $row->werbezeit Wochen.<p>";
		}elseif($row->werbeart ==2){
			echo "<p>Die Plakatwerbung in Deutschland geht noch $row->werbezeit Wochen.<p>";
			}elseif($row->werbeart == 3){
				echo "<p> Die Wahlgeschenke verteilung in Deutschland geht noch $row->werbezeit Wochen.<p>";
				}elseif($row->werbeart == 4){
					echo "<p> Die Zeitungsinserate in Deutschland gehen noch $row->werbezeit Wochen.<p>";
					}elseif($row->werbeart == 5){
						echo "<p> Die Radiowerbung in Deutschland geht noch $row->werbezeit Wochen.<p>";
						}elseif($row->werbeart == 6){
							echo "<p> Die Fernsehwerbung in Deutschland geht noch $row->werbezeit Wochen.<p>";
							}
	}elseif ($row->werbekreis == 1){
	if($row->werbeart == 1){
		echo "<p> Die Flyerwerbung in Süddeutschland geht noch $row->werbezeit Wochen.<p>";
		}elseif($row->werbeart ==2){
			echo "<p>Die Plakatwerbung in Süddeutschland geht noch $row->werbezeit Wochen.<p>";
			}elseif($row->werbeart == 3){
				echo "<p> Die Wahlgeschenke verteilung in Süddeutschland geht noch $row->werbezeit Wochen.<p>";
				}elseif($row->werbeart == 4){
					echo "<p> Die Zeitungsinserate in Süddeutschland gehen noch $row->werbezeit Wochen.<p>";
					}elseif($row->werbeart == 5){
						echo "<p> Die Radiowerbung in Süddeutschland geht noch $row->werbezeit Wochen.<p>";
						}elseif($row->werbeart == 6){
							echo "<p> DIe Fernsehwerbung in Süddeutschland geht noch $row->werbezeit Wochen.<p>";
							}
		}elseif ($row->werbekreis == 2){
		if($row->werbeart == 1){
		echo "<p> Die Flyerwerbung in Westdeutschland geht noch $row->werbezeit Wochen.<p>";
		}elseif($row->werbeart ==2){
			echo "<p>Die Plakatwerbung in Westdeutschland geht noch $row->werbezeit Wochen.<p>";
			}elseif($row->werbeart == 3){
				echo "<p> Die Wahlgeschenke verteilung in Westdeutschland geht noch $row->werbezeit Wochen.<p>";
				}elseif($row->werbeart == 4){
					echo "<p> Die Zeitungsinserate in Westdeutschland gehen noch $row->werbezeit Wochen.<p>";
					}elseif($row->werbeart == 5){
						echo "<p> Die Radiowerbung in Westdeutschland geht noch $row->werbezeit Wochen.<p>";
						}elseif($row->werbeart == 6){
							echo "<p> DIe Fernsehwerbung in Westdeutschland geht noch $row->werbezeit Wochen.<p>";
							}
		}elseif ($row->werbekreis == 3){
		if($row->werbeart == 1){
		echo "<p> Die Flyerwerbung in Ostdeutschland geht noch $row->werbezeit Wochen.<p>";
		}elseif($row->werbeart ==2){
			echo "<p>Die Plakatwerbung in Ostdeutschland geht noch $row->werbezeit Wochen.<p>";
			}elseif($row->werbeart == 3){
				echo "<p> Die Wahlgeschenke verteilung in Ostdeutschland geht noch $row->werbezeit Wochen.<p>";
				}elseif($row->werbeart == 4){
					echo "<p> Die Zeitungsinserate in Ostdeutschland gehen noch $row->werbezeit Wochen.<p>";
					}elseif($row->werbeart == 5){
						echo "<p> Die Radiowerbung in Ostdeutschland geht noch $row->werbezeit Wochen.<p>";
						}elseif($row->werbeart == 6){
							echo "<p> DIe Fernsehwerbung in Ostdeutschland geht noch $row->werbezeit Wochen.<p>";
							}
		}elseif ($row->werbekreis == 4){
		if($row->werbeart == 1){
		echo "<p> Die Flyerwerbung in Norddeutschland geht noch $row->werbezeit Wochen.<p>";
		}elseif($row->werbeart ==2){
			echo "<p>Die Plakatwerbung in Norddeutschland geht noch $row->werbezeit Wochen.<p>";
			}elseif($row->werbeart == 3){
				echo "<p> Die Wahlgeschenke verteilung in Norddeutschland geht noch $row->werbezeit Wochen.<p>";
				}elseif($row->werbeart == 4){
					echo "<p> Die Zeitungsinserate in Norddeutschland gehen noch $row->werbezeit Wochen.<p>";
					}elseif($row->werbeart == 5){
						echo "<p> Die Radiowerbung in Norddeutschland geht noch $row->werbezeit Wochen.<p>";
						}elseif($row->werbeart == 6){
							echo "<p> DIe Fernsehwerbung in Norddeutschland geht noch $row->werbezeit Wochen.<p>";
							}
		}

}
}else{
echo '<meta http-equiv="refresh" content="2; URL=login.php">';
}
?>
</div>
<div id ="footer">


</div>

</body>

</html>