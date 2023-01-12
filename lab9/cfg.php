<?php

    // plik konfiguracyjny zawierający zmienne odpowiadające za połączenie z bazą danych.
    
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $baza = 'moja_strona';
    global $link;
    $link = mysqli_connect($dbhost, $dbuser, $dbpass);
    if (!$link) echo '<b>Przerwane połączenie.</b>';
    if (!mysqli_select_db($link, $baza)) echo 'Nie wybrano bazy.';
    
    $login = 'admin';
    $pass = 'admin';
    
?>