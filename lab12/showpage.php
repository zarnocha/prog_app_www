<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Funkcja jako argument przyjmuje alias, który jest wyszukiwany w bazie danych
    // jeżeli argument jest pusty, to pokazywana jest strona główna.
    // jeżeli strony nie da się znaleźć w bazie danych, bądź jej status == 0: pokazywany jest napis "Nie znaleziono strony".

    function pokazPodstrone($alias) {
        require 'cfg.php';

        if (empty($alias))
            $alias = 'glowna';

        $alias_clear = htmlspecialchars($alias);

        $query = "SELECT * FROM page_list WHERE alias = :alias LIMIT 1";
        $sth = $dbh->prepare($query);
        $sth->bindParam(':alias', $alias_clear);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        $row = $sth->fetch();

        if(empty($row['alias']) or ($row['status'] == 0))
            $page = '<div class="czas"><center>[nie_znaleziono_strony]</center></div>';

        else
            $page = $row['page_content'];

        return $page;
    }

?>