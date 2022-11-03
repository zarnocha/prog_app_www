<?php
    $nrIndeksu = '162686';
    $nrGrupy = '3';
    echo 'Artur Żarnoch ' .$nrIndeksu. ' grupa ' .$nrGrupy. '<br /><br />';
?>

<?php
    include 'zmienne.php';
    echo "Zmienne z pliku \'zmienne.php\':<br />$kierunek, $specjalizacja, $rok rok<br />";
?>

<?php
    $plik = require_once('zmienne.php');
    echo '<br /> require_once(\'zmienne.php\'): ' . $plik;
?>