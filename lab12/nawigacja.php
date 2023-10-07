<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    function nawigacjaQuery() {
        require 'cfg.php';

        $query = "SELECT page_title, alias FROM page_list";
        $sth = $dbh->prepare($query);
        // $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        $row = $sth->fetchAll();

        // var_dump($row);
        return $row;
    }

?>