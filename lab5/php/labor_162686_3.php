<style>
    body {font-size: 30px;}
    input {font-size: 30px; text-align: center;}
    #kreskowana {border: 2px dashed grey; width: 15%; margin-left: 0;}
</style>

<!-- Zadanie 1 -->
<?php
    $imieNazwisko = 'Artur Żarnoch';
    $nrIndeksu = '162686';
    $nrGrupy = '3';
    echo '<b>● Używanie zmiennych:</b><br /><br />' . 
         '<i>$imieNazwisko</i>: ' . $imieNazwisko . '<br />' .
         '<i>$nrIndeksu</i>: ' . $nrIndeksu . '<br />' .
         '<i>$nrGrupy</i>: ' . $nrGrupy;

    echo '<br /><br /><br />';
?>


<hr>
<!-- Zadanie 2; podpunkt a) -->
<?php
    echo "<b>● Użycie polecenia include '<i>zmienne.php</i>' wraz z require_once('<i>zmienne.php</i>')</b><br /><br />";
    include 'zmienne.php';
    
    echo "Zmienne z pliku '<i>zmienne.php</i>':
         <br /><i>\$kierunek</i>: $kierunek, 
         <br /><i>\$specjalizacja</i>: $specjalizacja, 
         <br /><i>\$rok</i>: $rok rok<br />";

    $plik = require_once('zmienne.php');
    echo "<br />Użycie require_once('<i>zmienne.php</i>'): " . $plik . '<br /><br /><br />';
    // Jako, że plik zmienne.php zaimportowaliśmy poleceniem include, to require_once go ponownie nie zaimportuje. Jeżeli jednak by ten plik nie istniał, to wystąpi 'fatal error' i program przestaje działać. Require_once zwraca 1 (true), jeśli dany plik został zaimportowany.
?>


<hr>
<!-- Zadanie 2; podpunkt b) -->
<?php
    echo '<b>● Warunki if, else, elseif, switch:</b><br /><br />';
    echo "Zmienna <i>\$wiek</i> (od której zależy działanie warunku if) zdefiniowana jest w pliku <i>zmienne.php</i>, ale równie dobrze można ją edytować tutaj, przykład w 50/51 linijce.<br />
         Jest ona po to, aby swobodnie modyfikować jej wartość w kodzie i sprawdzać działanie warunku.<br />
         To samo odwołuje się do zmiennej <i>\$plec</i> w przypadku użycia switcha (przykłady zmiany w liniach 68/69).<br /><br />
         <i>\$wiek</i>: $wiek<br />
         <i>\$plec</i>: $plec<br />";
?>
<hr id="kreskowana">
<?php  
    // $wiek = 17;
    // $wiek = 20;
    
    echo '<br />Użycie warunku if/ else/ elseif:<br /><br />';
    if ($wiek < 18) {
        echo '> spełniony warunek <i>if ($wiek < 18)</i>:<br />';
        echo 'Jesteś osobą niepełnoletnią<br />';
    }
    elseif ($wiek >= 18 and $wiek < 21) {
        echo '> spełniony warunek <i>elseif ($wiek >= 18 and $wiek < 21)</i>:<br />';
        echo 'W Polsce jesteś osobą pełnoletnią, ale nie w USA.<br />';
    }
    else {
        echo '> spełniony warunek <i>else</i>: <br />';
        echo 'Jesteś osobą pełnoletnią.<br />';
    }
    

    // $plec = 'kobieta';
    // $plec = 'error';

    echo '<br />Użycie switcha:<br />';
    switch ($plec) {
        case 'mężczyzna':
            echo "> <i>case 'mężczyzna'</i>:<br />";
            echo 'Pan ' .$imie. ' ' .$nazwisko. '<br />';
            break;
            
        case 'kobieta':
            echo "> <i>case 'kobieta'</i>:<br />";
            echo 'Pani ' .$imie. ' ' .$nazwisko. '<br />';
            break;
            
        default:
            echo "> <i>default case</i>:<br />";
            echo $imie . ' ' .$nazwisko. '<br />';
            break;      
    }

    echo '<br /><br />';
?>


<hr>
<!-- Zadanie 2; podpunkt c) -->
<?php
    echo '<b>● Pętla while() i for():</b><br />';
    
    echo '<br />Pętla <i>while ($i <= 5)</i>:<br />';
    $i = 1;
    while ($i <= 5) {
        if ($i != 5)
            echo $i++ . '... ';
        else echo $i++ . '.';
    }
    
    echo '<br /><br />Pętla <i>for ($i = 5; $i > 0; $i--)</i>:<br />';
    for ($i = 5; $i > 0; $i--) {
        if ($i != 1)
            echo $i . '... ';
        else echo $i . '.';   
    }

    echo '<br /><br /><br />';
?>


<hr>
<!-- Zadanie 2; podpunkt d) - $_GET -->
<?php
    echo '<b>●Typy zmiennych $_GET, $_POST, $_SESSION:</b><br /><br />';
    
    echo 'Zmienna <i>$_GET</i><br /><br />';
    $get_nrIndeksu = $_GET["nrIndeksu"];
    
    if (empty($get_nrIndeksu)) {
        echo "Wprowadź swój nr indeksu dopisując na końcu adresu strony zaraz po .php '?nrIndeksu=123456',<br />"; 
        echo 'bądź kliknij tutaj aby otrzymać przykładowy nr indeksu: ' . "<a href='?nrIndeksu=123456'>przykładowy nr indeksu</a>" . '<br /><br />';
    } 
    else echo 'Twój nr indeksu to: ' . $get_nrIndeksu . ' (Wiemy to ze zmiennej <i>$_GET["nrIndeksu"]</i>)<br /><br />';
?>

<hr id="kreskowana">

<!-- Zadanie 2; podpunkt d) - $_POST -->
<?php
    echo '<br />Zmienna <i>$_POST</i><br /><br />';

    if (empty($_POST['imie_POST'])) {
        ?>
            <form method="POST">
            <input type="text" name="imie_POST" placeholder="Wprowadź imię">
            <input type="submit" value="Potwierdź">
            </form>
        <?php
    }
    else {
        echo 'Twoje imię to: ' . $_POST['imie_POST'] . ' (Wiemy to ze zmiennej <i>$_POST["imie_POST"]</i>)<br /><br />';
    }
    echo("<br />");
?>

<hr id="kreskowana">

<!-- Zadanie 2; podpunkt d) - $_SESSION -->
<?php session_start();
    echo '<br />Zmienna <i>$_SESSION</i><br /><br />';
    $_SESSION['liczbaWejscNaStrone'] = $_SESSION['liczbaWejscNaStrone'] + 1;
    echo 'Liczba Twoich wejść na tę stronę w trakcie jednej sesji: ' . $_SESSION['liczbaWejscNaStrone'] . ' (Wiemy to ze zmiennej <i>$_SESSION["liczbaWejscNaStrone"]</i>)<br />';

    echo '<br /><br />';
?>


<hr>