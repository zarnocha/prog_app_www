<?php
    $nrIndeksu = '162686';
    $nrGrupy = '3';
    echo 'Artur Żarnoch ' .$nrIndeksu. ' grupa ' .$nrGrupy. '<br /><br />';
?>

<!-- Podpunkt a) -->
<?php
    include 'zmienne.php';
    echo "Zmienne z pliku \'zmienne.php\':<br />$kierunek, $specjalizacja, $rok rok<br />";
?>

<?php
    $plik = require_once('zmienne.php');
    echo '<br /> require_once(\'zmienne.php\'): ' . $plik;
?>

<!-- Podpunkt b) -->
<?php
    echo '<br /><br />Warunki if, else, elseif, switch:<br />';
    echo "Wiek: $wiek<br />";
    // $wiek = 20;
    if ($wiek < 18) {
        echo 'Jesteś niepełnoletni';
    }
    elseif ($wiek > 18 and $wiek < 21) {
        echo 'W Polsce jesteś pełnoletni, ale nie w USA.';
    }
    else {
        echo 'Jesteś pełnoletni.';
    }
?>