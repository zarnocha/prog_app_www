<?php
session_start();

if (isset($_SESSION['pokaz_niedostepne'])) {
    if ($_SESSION['pokaz_niedostepne']) {
        $_SESSION['pokaz_niedostepne'] = false;
    }
    else {
        $_SESSION['pokaz_niedostepne'] = true;
    }
}
else {
    $_SESSION['pokaz_niedostepne'] = true;
}
    header('Location: http://'. $_SERVER['HTTP_HOST'] . '/lab12/?idp=sklep');
?>