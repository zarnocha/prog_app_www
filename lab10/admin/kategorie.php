<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    if (isset($_SESSION['auth']) && $_SESSION['auth'] === true) {
        if ($_SESSION['success'] === true) {    // wyświetlanie komunikatu, jeżeli dana akcja zakończyła się sukcesem

            if ($_SESSION['action'] == 'add')
                $akcja = 'Dodawanie';
            elseif ($_SESSION['action'] == 'edit')
                $akcja = 'Edytowanie';
            elseif ($_SESSION['action'] == 'del')
                $akcja = 'Usuwanie';

            echo('
                <link rel="stylesheet" href="css/admin.css">
                <div class="strony">
                <label style="padding-top:2%; padding-bottom:1%; font-size:1.6vw;"><b>' . $akcja . 
                '</b> kategorii powiodło się!</label>
                </div>
            ');
            $_SESSION['success'] = false;   // po wyświetleniu komunikatu o pomyślnym ukończeniu akcji nie chcemy wyświetlać jej ponownie
            unset($akcja);  // zabezpieczenie, aby przypadkiem nie wyświetlił się komunikat gdy nie wykonano żadnej akcji
        }
    
        // Funkcja ListaKategorii() zwraca listę zawierającą kategorie pobrane z bazy danych. Pobiera ona konfigurację połączenia z pliku cfg.php, 
        // następnie wykonuje kwerendę do bazy aby dostać z powrotem kategorie do zmiennej $result.
        // Kolejno za pomocą polecenia echo wyświetlam div'a z kategoriami.
        
        function ListaKategorii() {
            require(dirname(__DIR__, 1). '/cfg.php');   // wymagany jest plik konfiguracyjny łączący z bazą danych

            $query = "SELECT * FROM category_list WHERE master=0 LIMIT 100";
            $sth = $dbh->prepare($query);
            $sth->setFetchMode(PDO::FETCH_ASSOC);
            $sth->execute();
    
            echo('
                <link rel="stylesheet" href="css/admin.css">
                <div class="strony">
                <a href="?idp=panel_cms" id="dodaj" style="font-size:1.6vw; margin-bottom:10%;">Powróć do panelu CMS</a><br/><br/>
                <a href="?idp=panel_cms&kategorie&add" id="dodaj" style="font-size:1.6vw; margin-bottom:10%;">Dodaj kategorię</a><br/><br/>
                <hr style="width:30vw;"><br/>
                ');
           
            if ($sth->rowCount() > 0) {
                while ($row = $sth->fetch()) {
                    echo("
                    id: <b>" . $row["id"] . 
                    "</b><label class='kreska'> | </label> Nazwa kategorii: <b>" . $row["name"] . 
                    "</b><label class='kreska'> | </label> Kategoria matka: <b>" . $row['master'] . 
                    "</b><label class='kreska'> | </label>"
                    );

                    echo("
                    </b><label class='kreska'> | </label> <a href='?idp=panel_cms&kategorie&edit=" . $row['id'] . "
                    ' id='edytuj'> <b>Edytuj</b></a> <label class='kreska'> | </label> <a href='?idp=panel_cms&kategorie&del=" . $row['id'] . "
                    ' id='usun' onMouseOver=this.style.color='rgb(255,20,60)' onMouseOut=this.style.color='rgb(255,255,255)' onclick='return confirm('Usunąć?')> <b>Usuń</b></a>
                    ");

                    if (!(isset($_GET['expand']))) {    // jeżeli żadna kategoria nie jest rozwinięta
                        echo("
                            <a href='?idp=panel_cms&kategorie&expand=" . $row['id'] . "
                            ' id='edytuj'> <b>Rozwiń</b></a>"
                        );
                    }
                    else {  // jeżeli jakaś kategoria jest rozwinięta

                        if (in_array($row['id'], explode(",", $_GET['expand']))) {  // jeżeli dany wiersz jest rozwinięty

                            if (count(explode(",", $_GET['expand'])) == 1) { // jeżeli rozwinięta jest tylko jedna kategoria
                                echo ("
                                        <a href='?idp=panel_cms&kategorie' id='edytuj'> <b>Zwiń</b></a>"
                                );
                            }

                            else {  // jeżeli otwartych jest więcej niż 1 kategoria
                                $opened_categories = explode(",", $_GET['expand']);
                                $closing_category_index = (array_search($row['id'], $opened_categories));
                                unset($opened_categories[$closing_category_index]);
                                $opened_categories = array_filter($opened_categories);
                                $opened_categories = implode(',', $opened_categories);
                                echo ("
                                    <a href='?idp=panel_cms&kategorie&expand=". $opened_categories ."' id='edytuj'> <b>Zwiń</b></a>"
                                );
                            }

                            $query = "SELECT * FROM category_list WHERE master=:id_master LIMIT 100";
                            $second_sth = $dbh->prepare($query);
                            $master = strval($row['id']);
                            
                            $second_sth->bindParam(":id_master", $master);
                            $second_sth->setFetchMode(PDO::FETCH_ASSOC);
                            $second_sth->execute();

                            if ($second_sth->rowCount() > 0) { // jeżeli istnieją podkategorie
                                while ($second_row = $second_sth->fetch()) {
                                    echo ('
                                       </br>id: <b>' . $second_row["id"] . '</b><label class="kreska"> | </label>  Nazwa: <b>' . $second_row["name"] . ' </b></br>
                                    ');
                                }
                            }
                            else {
                                echo ('
                                        </br><p style="color:rgb(255,100,100);"><b>Brak podkategorii do wyświetlenia.</p></b></br>
                                    ');
                            }
                        }
                        else {  // jeżeli dany wiersz jest nierozwinięty
                            echo ("
                                    <a href='?idp=panel_cms&kategorie&expand=" . $_GET['expand'] . "," . $row['id'] . "' id='edytuj'> <b>Rozwiń</b></a>"
                            );
                        }
                    }
                    echo("

                    ");
                }
                echo ("</div>");
            
            } else {
                echo "Brak wyników";
            }

        }
    
    
    
    
    
    
        if (!(isset($_GET['add']) || isset($_GET['edit']) || isset($_GET['del'])))  // kategorie wyświetlą się tylko jeżeli nie będziemy w podstronie "edytującej" daną kategorię. 
        ListaKategorii();    // wyświetlanie kategorii funkcją
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