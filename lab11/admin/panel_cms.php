<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

if (isset($_SESSION['auth']) && $_SESSION['auth'] === true) {

    if (isset($_GET['podstrony'])) {
        require_once('admin/podstrony.php');
    } 

    elseif (isset($_GET['kategorie'])) {
        require_once('admin/kategorie.php');
    } 

    else {
        echo ('
                <link rel="stylesheet" href="css/panel_cms.css">
                <div class="tlo" style="display: flex; justify-content: center;flex-direction: column">

                    <div class="wybor" onclick="location.href=\'?idp=panel_cms&podstrony\'";>
                    <a class="opcja" href="?idp=panel_cms&podstrony" >Edytuj podstrony</a>
                    </div>

                    <div class="wybor" onclick="location.href=\'?idp=panel_cms&kategorie\'">
                    <a href="?idp=panel_cms&kategorie" class="opcja">Edytuj kategorie</a><br/><br/>
                    </div>
                
                </div>

            ');
        }
    }

    else {  // wykonuje się, gdy osoba nie ma dostępu do panelu CMS
        echo('
            <link rel="stylesheet" href="css/admin.css">
            <div class="logowanie">
                <h1 class="brak_autoryzacji">Nie uzyskano autoryzacji!</h1>
                <button><a class="logowanie" href="?idp=login">Przejdź do panelu logowania</a></button>
            </div>
        ');
    }
    
?>