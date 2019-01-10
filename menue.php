<?php
if ($_SESSION["id"] > 0){
echo "
 <a href='index.php'>Startseite</a><p>
 <a href='laender.php'>Länder</a><p>
 <a href='werbung.php'>Werbung</a><p>
 <a href='partei.php'>Die Partei</a><p>
 <a href='parlament.php'>Der Bundestag</a><p>
 ";
}
?>