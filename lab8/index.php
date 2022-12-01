<!-- version: 1.6 -->

<?php
	include 'showpage.php';
	error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
	$strona = pokazPodstrone($_GET['idp']);
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
		echo $strona;
		$nr_indeksu = "162686";
		$nrGrupy = "3";
		echo "</br></br><div class='tytul_h3' style='max-width:100%'>Autor: Artur Żarnoch, nr indeksu: " .$nr_indeksu. ', grupa: ' .$nrGrupy. '</div><br /><br />';
	?>

</body>

<script src="js/powiekszanie_obrazu_klikniecie.js" type="text/javascript"></script>
<script src="js/zwiekszenie_obrazu_klikniecie.js" type="text/javascript"></script>
<script src="js/powiekszanie_obrazu_najechanie.js" type="text/javascript"></script>

</html>
