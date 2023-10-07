<!-- version: 1.11 -->

<?php
	mb_internal_encoding('UTF-8');
	mb_http_output('UTF-8');
	ini_set('display_errors', 1);
	include 'showpage.php';
	session_start();

	error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

	include('nawigacja.php');
	$nawigacjaQuery = nawigacjaQuery();

	if ($_GET['idp'] == 'kontakt') {	// jeżeli w zmiennej idp będzie "kontakt", to wyświetlamy podstronę "kontakt" z pliku contact.php
		require('contact.php');
		session_start();
		$strona = PokazKontakt();
	}

	elseif ($_GET['idp'] == 'login') {	// jeżeli w zmiennej idp będzie "login", to wyświetlamy formularz logowania z pliku login.php
		require_once('admin/login.php');
		$strona = FormularzLogowania();
	}

	elseif ($_GET['idp'] == 'register') {	// jeżeli w zmiennej idp będzie "register", to wyświetlamy formularz rejestracji z pliku rejestracja.php
		if (!($_SESSION['logged'])) {	// formularz zostanie wyświetlony niezalogowanemu użytkownikowi
			require('admin/rejestracja.php');
			$strona = FormularzRejestracji();
		}
		else {	// jeżeli użytkownik jest zalogowany, to nie będzie miał dostępu do rejestracji
			// header("Location: ?idp=");
			echo "<script> window.location.href='?idp=';</script>";
		}
	}

	elseif ($_GET['idp'] == 'panel_cms') {	// jeśli w zmiennej idp będzie "panel_cms" to na razie nie wykonujemy żadnego działania
		;
	}

	elseif ($_GET['idp'] == 'przypomnij_haslo') {	// jeżeli w zmiennej idp będzie "przypomnij_haslo" to używany jest plik contact.php a wyświetlaną stroną zostaje informacja o przypomnieniu hasła
		require('contact.php');
		$strona = PokazPrzypomnijHaslo();
	}

	elseif ($_GET['idp'] == 'wyloguj') {	// jeżeli w zmiennej idp będzie "wyloguj" to używana jest funkcja Wyloguj() z pliku login.php, użytkownik zostaje wylogowany a nastepnie wyświetlana jest strona główna.
		require('admin/login.php');
		Wyloguj();

	}

	elseif ($_GET['idp'] == 'sklep') {	// jeśli w zmiennej idp będzie "sklep" to na razie nie wykonujemy żadnego działania
		;
	}

	else {	// w kazdym innym przypadku (jeżeli dana podstrona nie może być znaleziona w bazie) wyświetlona będzie strona główna
		$strona = pokazPodstrone($_GET['idp']);
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
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Raleway:wght@100;200;300;400;500;600;700;800;900&display=swap"
		rel="stylesheet">
	<style>
		@import url('https://fonts.googleapis.com/css2?family=Raleway:wght@100;200;300;400;500;600;700;800;900&display=swap');
	</style>

	<script src="js/timedate.js"></script>
	<script src="js/kolorujtlo.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

</head>

<body onload="startclock()">
	<div class="top">
		<div class="zaloguj_sie">
			<?php
				require(__DIR__. '/cfg.php');

				if (isset($_SESSION['login']) && isset($_SESSION['password'])) {	// jeżeli są ustawione login i hasło
					if ($_SESSION['logged'] === true) {	// jeżeli jest zalogowany

						if (isset($_GET['koszyk'])) {
							$czyZalogowany = '<a href="?idp=sklep">Sklep</a></br>';
						}

						elseif ($_GET['idp'] == 'sklep' && !(isset($_GET['koszyk'])) && !(isset($_GET['details']))) {
							if (isset($_SESSION['laczna_ilosc'])) {
								$czyZalogowany = '<a href="?idp=sklep&koszyk">Koszyk: '. $_SESSION['laczna_ilosc'] . ' szt. ('. $_SESSION['laczna_cena_brutto'] . ' zł)</a></br>';
							}
							else {
								$czyZalogowany = '<a href="?idp=sklep&koszyk">Koszyk</a></br>';
							}
						}

						else {
							if (isset($_SESSION['laczna_ilosc'])) {
								$czyZalogowany = '<a href="?idp=sklep">Sklep</a></br><a href="?idp=sklep&koszyk">Koszyk: '. $_SESSION['laczna_ilosc'] . ' szt. ('. $_SESSION['laczna_cena_brutto'] . ' zł)</a></br>';
							}
							else {
								$czyZalogowany = '<a href="?idp=sklep">Sklep</a></br><a href="?idp=sklep&koszyk">Koszyk</a></br>';
							}
						}

						// $czyZalogowany = '<a href="?idp=sklep">Sklep</a></br><a href="?idp=sklep&koszyk">Koszyk</a></br>';

						if ($_SESSION['auth'] === true) {
							if ($_GET['idp'] == 'panel_cms') {	// jeżeli jesteśmy w panelu cms
								$czyZalogowany = $czyZalogowany . '<a onMouseOver=this.style.color="rgb(255,20,60)" onMouseOut=this.style.color="rgb(255,255,255)" href="?idp=wyloguj" >Wyloguj się';	// to wyświetlamy tylko przycisk od wylogowywania się
							}
							else
								$czyZalogowany = $czyZalogowany . '<a href="?idp=panel_cms">Panel CMS</a></br><a onMouseOver=this.style.color="rgb(255,20,60)" onMouseOut=this.style.color="rgb(255,255,255)" href="?idp=wyloguj">Wyloguj się';	// jeżeli jesteśmy poza panelem CMS - dodajemy do niego przycisk
						}
						else {
							$czyZalogowany =  $czyZalogowany . '<a onMouseOver=this.style.color="rgb(255,20,60)" onMouseOut=this.style.color="rgb(255,255,255)" href="?idp=wyloguj" >Wyloguj się';	// wyświetlamy tylko przycisk od wylogowywania się
						}
					}

				}
				else
					$czyZalogowany = '<a href="?idp=login">Zaloguj się'; // jeżeli użytkownik nie jest zalogowany to dajemu mu możliwość zalogowania się przez przekierowanie do podstrony z formularzem logowania
				echo ($czyZalogowany . '</a>');
			?>
		</div>
	</div>

	<div class="logo">
		<h1 class="naglowek">Piłka n<img src="img/football.png" alt="o" id="football_o">żna</h1>
		<h2 class="dopisek" onclick="openVothcom()">to moje hobby</h2>
	</div>

	<div class="czas">
		<div id="zegarek" onclick="change_time_type()"></div>
		<div id="data" onclick="change_date_type()"></div>
	</div>

	<div class="tab_holder">
		<!-- <a href="?idp=" class="tab"> <b>Strona główna</b> </a>
		<a href="?idp=stroje" class="tab"> <b>Stroje piłkarskie</b> </a>
		<a href="?idp=obuwie" class="tab"> <b>Obuwie piłkarskie (korki)</b> </a>
		<a href="?idp=rekawice" class="tab"> <b>Rękawice bramkarskie</b> </a>
		<a href="?idp=pilki" class="tab"> <b>Piłki</b> </a>
		<a href="?idp=filmy" class="tab"> <b>Filmy</b> </a>
		<a href="?idp=kontakt" class="tab"> <b>Kontakt</b> </a> -->
		<?php foreach ($nawigacjaQuery as $row) : ?>
      
            <a href="?idp=<?php echo $row['alias']; ?>" class="tab">
                <b><?php echo $row['page_title']; ?></b>
            </a>
     
    	<?php endforeach; ?>


	</div>


	<?php

		if ($_GET['idp'] == 'panel_cms') {
			require_once('admin/panel_cms.php');
		}

		elseif ($_GET['idp'] == 'sklep') {
			require_once('sklep.php');
		}

		else
			echo htmlspecialchars_decode($strona);

		$nr_indeksu = "162686";
		$nrGrupy = "3";
		echo "</br></br><div class='tytul_h3' style='max-width:100%'>Autor: Artur Żarnoch, nr indeksu: " .$nr_indeksu. ', grupa: ' .$nrGrupy. '</div><br /><br />';
	?>

</body>

<script src="js/powiekszanie_obrazu_klikniecie.js" type="text/javascript"></script>
<script src="js/zwiekszenie_obrazu_klikniecie.js" type="text/javascript"></script>
<script src="js/powiekszanie_obrazu_najechanie.js" type="text/javascript"></script>

</html>
