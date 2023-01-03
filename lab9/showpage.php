<?php

    function pokazPodstrone($alias) {
        include 'cfg.php';

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