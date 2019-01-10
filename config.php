<?php
//error_reporting(E_ALL);
$verbindung = mysql_connect("localhost", "root" , "localhost")
or die("Verbindung zur Datenbank konnte nicht hergestellt werden");
mysql_select_db("mcsebbi") or die ("Datenbank konnte nicht ausgewählt werden");
$id = $_SESSION["id"];
$sitzelandtag = 180;
$sitzebundestag = 598;
?>