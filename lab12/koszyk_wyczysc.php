<?php

    session_start();
    require('sklep.php');
    UsunKoszyk();
    header('Location: http://'. $_SERVER['HTTP_HOST'] . '/lab12/?idp=sklep&koszyk');

?>