<!-- Zadanie 1 -->
<?php
    $nrIndeksu = '162686';
    $nrGrupy = '3';
    echo 'Artur Żarnoch ' .$nrIndeksu. ' grupa ' .$nrGrupy. '<br /><br />';
?>

<!-- Zadanie 2; podpunkt a) -->
<?php
    include 'zmienne.php';
    echo "Zmienne z pliku 'zmienne.php':<br />$kierunek, $specjalizacja, $rok rok<br />";

    $plik = require_once('zmienne.php');
    echo '<br /> require_once(\'zmienne.php\'): ' . $plik;
?>


<!-- Zadanie 2; podpunkt b) -->
<?php
    echo '<br /><br />Warunki if, else, elseif, switch:<br />';
    echo "Wiek: $wiek<br />";
    
    // $wiek = 20;
    if ($wiek < 18) {
        echo 'Jesteś osobą niepełnoletnią<br />';
    }
    elseif ($wiek > 18 and $wiek < 21) {
        echo 'W Polsce jesteś osobą pełnoletnią, ale nie w USA.<br />';
    }
    else {
        echo 'Jesteś osobą pełnoletnią.<br />';
    }
    
    switch ($plec) {
        
        case 'mężczyzna':
            echo 'Pan ' .$imie. ' ' .$nazwisko. '<br />';
            break;
            
            case 'kobieta':
                echo 'Pani ' .$imie. ' ' .$nazwisko. '<br />';
                break;
                
        default:
            echo $imie . ' ' .$nazwisko. '<br />';
            break;
            
        }
        ?>

<!-- Zadanie 2; podpunkt c) -->
<?php
    echo '<br />Pętla while() i for():<br />';
    $i = 1;
    while ($i <= 5) {
        if ($i != 5)
            echo $i++ . '... ';
        else echo $i++ . '.';
    }
    
    echo '<br />';

    for ($i = 5; $i > 0; $i--) {
        if ($i != 1)
            echo $i . '... ';
        else echo $i . '.';
        
    }
?>

<!-- Zadanie 2; podpunkt d) - $_GET -->
<?php
    echo '<br /><br />Typy zmiennych $_GET, $_POST, $_SESSION:<br />';
    
    $get_nrIndeksu = $_GET["nrIndeksu"];
    
    if (empty($get_nrIndeksu)) {
        echo 'Kliknij tutaj aby otrzymać przykładowy nr indeksu: ' . "<a href='?nrIndeksu=000000'>przykładowy nr indeksu</a>" . '<br /><br />';
    } 
    else echo 'Twój nr indeksu to: ' . $get_nrIndeksu . '<br /><br />';
    ?>

<!-- Zadanie 2; podpunkt d) - $_POST -->
<form method="POST">
    <input type="text" name="imie_POST" placeholder="Wprowadź imię">
    <input type="submit" value="Potwierdź">
</form>

<?php
    if (!empty($_POST['imie_POST'])) {
        echo 'Twoje imię to: ' . $_POST['imie_POST'];
    }
    ?>

<!-- Zadanie 2; podpunkt d) - $_SESSION -->
<?php session_start();
    
    $_SESSION['iloscWejscNaStrone'] = $_SESSION['iloscWejscNaStrone'] + 1;
    echo 'Liczba Twoich wejść na tę stronę: ' . $_SESSION['iloscWejscNaStrone'];

?>
