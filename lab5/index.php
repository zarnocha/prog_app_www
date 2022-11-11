<?php
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
 $tablica_podstron = ['' => 'html/glowna.html', 'pilki' => 'html/pilki.html', 'rekawice' => 'html/rekawice.html', 'stroje' => 'html/stroje.html', 'obuwie' => 'html/obuwie.html', 'kontakt' => 'html/kontakt.html', 'filmy' => 'html/filmy.html'];
 
 if($_GET['idp'] == '') $strona = 'html/glowna.html';
 if($_GET['idp'] == 'pilki') $strona = 'html/pilki.html';
 if($_GET['idp'] == 'rekawice') $strona = 'html/rekawice.html';
 if($_GET['idp'] == 'stroje') $strona = 'html/stroje.html';
 if($_GET['idp'] == 'obuwie') $strona = 'html/obuwie.html';
 if($_GET['idp'] == 'kontakt') $strona = 'html/kontakt.html';
 if($_GET['idp'] == 'filmy') $strona = 'html/filmy.html';
 
// Wymyśliłem takie zabezpieczenie, że jeżeli dana podstrona nie będzie istniała, to zostanie wyświetlony tylko szablon strony głównej. 
// Na początku chciałem ustalić, że jeżeli dana podstrona nie istnieje, to wyświetlę stronę główną. 
// Doszło do mnie jednak, że jeżeli to zrobię, to przy braku pliku strony głównej wszystko się posypie.

 foreach ($tablica_podstron as $nazwa => $podstrona) {
	if (!file_exists($podstrona)) {
		if ($_GET['idp'] == $nazwa) $strona= '';
	}
 } 
 
?>

<!DOCTYPE html>

<html lang="pl">

<head>
	<meta charset="UTF-8">
	<meta name="Author" content="Artur Żarnoch">
	<title>Piłka nożna moim hobby</title>
	<link rel="stylesheet" href="css/style.css">
	<link rel="icon" href="img/football_logo.png" type="image/png">
	<!-- Dodawanie czcionki z Google Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@1,300&display=swap" rel="stylesheet">

	<script src="js/timedate.js"></script>
	<script src="js/kolorujtlo.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

</head>

<body onload="startclock()">
	<div class="logo" onclick="openVothcom()">
		<h1 class="naglowek">Piłka n<img src="img/football.png" alt="o" id="football_o">żna</h1>
		<h2 class="dopisek">to moje hobby</h2>
	</div>

	<div class="czas">
		<div id="zegarek" onclick="change_time_type()"></div>
		<div id="data" onclick="change_date_type()"></div>
	</div>

	<div class="tab_holder">
		<a href="?idp=" class="tab"> <b>Strona główna</b> </a>
		<a href="?idp=stroje" class="tab"> <b>Stroje piłkarskie</b> </a>
		<a href="?idp=obuwie" class="tab"> <b>Obuwie piłkarskie (korki)</b> </a>
		<a href="?idp=rekawice" class="tab"> <b>Rękawice bramkarskie</b> </a>
		<a href="?idp=pilki" class="tab"> <b>Piłki</b> </a>
		<a href="?idp=filmy" class="tab"> <b>Filmy</b> </a>
		<a href="?idp=kontakt" class="tab"> <b>Kontakt</b> </a>
	</div>


	<?php
		include($strona);
		$nr_indeksu = "162686";
		$nrGrupy = "3";
		echo "</br></br><div class='tytul_h3' style='max-width:100%'>Autor: Artur Żarnoch, nr indeksu: " .$nr_indeksu. ', grupa: ' .$nrGrupy. '</div><br /><br />';
	?>

</body>
<script src="js/powiekszanie_obrazu_klikniecie.js" type="text/javascript"></script>
<script src="js/zwiekszenie_obrazu_klikniecie.js" type="text/javascript"></script>
<script src="js/powiekszanie_obrazu_najechanie.js" type="text/javascript"></script>

</html>