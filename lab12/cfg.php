<?php

    // plik konfiguracyjny zawierający zmienne odpowiadające za połączenie z bazą danych.
    
    // łączenie z bazą danych przez rozszerzenie PDO, która skutecznie uniemożliwia ataki typu SQL Injection
    try{
        $dbh = new PDO('mysql:host=localhost;dbname=my_site;charset=utf8mb4', 'root', '');
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      }

    catch(PDOException $e) {    // jeżeli wystąpi błąd przy łączeniu z bazą - stosowny komunikat zostanie zapisany do pliku tekstowego i strona się nie załaduje - wyświetlony zostanie komunikat z linijki 17
        error_log('PDOException - ' . $e->getMessage(), 0);
        http_response_code(500);
        die('
            <center><label style="font-size:3vw;">Problem w łączeniu z bazą danych.</label></center>
        ');
    }

?>