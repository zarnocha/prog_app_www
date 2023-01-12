<?php

    // funkcja jako argument przyjmuje alias, który jest wyszukiwany w bazie danych
    // jeżeli argument jest pusty, to pokazywana jest strona główna.
    // jeżeli strony nie da się znaleźć w bazie danych, bądź jej status == 0: pokazywany jest napis "Nie znaleziono strony".

    function pokazPodstrone($alias) {   
        require 'cfg.php';

        if (empty($alias)) 
            $alias = 'glowna';

        $alias_clear = htmlspecialchars($alias);
        $query = "SELECT * FROM page_list WHERE alias='$alias_clear' LIMIT 1";
        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_array($result);
        
        if(empty($row['alias']) or ($row['status'] == 0))  
            $web = '<div class="czas"><center>[nie_znaleziono_strony]</center></div>';

        else 
            $web = $row['page_content'];

        return $web;
    }

?>