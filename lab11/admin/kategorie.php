<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    if (isset($_SESSION['auth']) && $_SESSION['auth'] === true) {   // weryfikacja, czy użytkownik jest zalogowany, aby mieć dostęp do CMS
        if ($_SESSION['success'] === true) {    // wyświetlanie komunikatu, jeżeli dana akcja zakończyła się sukcesem

            if ($_SESSION['action'] == 'add')
                $akcja = 'Dodawanie';
            elseif ($_SESSION['action'] == 'edit')
                $akcja = 'Edytowanie';
            elseif ($_SESSION['action'] == 'del')
                $akcja = 'Usuwanie';

            echo('
                <link rel="stylesheet" href="css/kategorie.css">
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

            echo ('
                <link rel="stylesheet" href="css/kategorie.css">
                <div class="strony">
                <a href="?idp=panel_cms" id="dodaj" style="font-size:1.6vw; margin-bottom:10%;">Powróć do panelu CMS</a><br/><br/>
                <a href="?idp=panel_cms&kategorie&add" id="dodaj" style="font-size:1.6vw; margin-bottom:10%;">Dodaj kategorię</a><br/><br/>
                <div style="display: flex; justify-content: space-evenly;">
                <a href="?idp=panel_cms&kategorie&expand=');
                
                $rozwin_query = "SELECT id FROM category_list WHERE master=0 LIMIT 100";    // pobieranie wszystkich kategorii głównych do rozwinięcia ich podstron
                $rozwin_sth = $dbh->prepare($rozwin_query);
                $rozwin_sth->execute();
                $result = $rozwin_sth->fetchAll(PDO::FETCH_COLUMN, 0);
                $result = implode(',', $result);    // zamiana tablicy w string, aby dodać do linku do $_GET['expand']

            echo ($result . '" id="dodaj" style="font-size:1.6vw;">Rozwiń wszystkie</a>
                <a href="?idp=panel_cms&kategorie" id="dodaj" style="font-size:1.6vw;">Zwiń wszystkie</a>
                </div>
                <hr style="width:40vw;">
                <div style="display: flex;flex-direction: column;justify-content: center;align-content: center;flex-wrap: wrap;">
                ');

            if ($sth->rowCount() > 0) { // jeżeli istnieją kategorie główne
                while ($row = $sth->fetch()) {  // iteracja zmienną $row po kat. głównych
                    echo("
                    
                    <p style='display:flex;align-items:center;align-content: center;justify-content: space-around; width:60%;'>
                    id:<b>" . $row["id"] . 
                    "</b><label class='kreska'> | </label> Nazwa kategorii: <b>" . $row["name"]
                    );

                    echo("
                    </b><label class='kreska'> | </label> <a href='?idp=panel_cms&kategorie&edit=" . $row['id'] . "
                    ' id='edytuj'> <b>Edytuj</b></a> <label class='kreska'> | </label> <a href='?idp=panel_cms&kategorie&del=" . $row['id'] . "
                    ' id='usun' onMouseOver=this.style.color='rgb(255,20,60)' onMouseOut=this.style.color='rgb(255,255,255)'> <b>Usuń</b></a>
                    <label class='kreska'> | </label>
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

                            $query = "SELECT * FROM category_list WHERE master=:id_master LIMIT 100";   // pobieranie podkategorii z bazy danych na podstawie aktualnej kat. głównej
                            $second_sth = $dbh->prepare($query);
                            $master = strval($row['id']);
                            
                            $second_sth->bindParam(":id_master", $master);
                            $second_sth->setFetchMode(PDO::FETCH_ASSOC);
                            $second_sth->execute();

                            if ($second_sth->rowCount() > 0) { // jeżeli istnieją podkategorie
                                echo ("<p><b>Podkategorie:</b></p>");
                                while ($second_row = $second_sth->fetch()) {    // iteracja po podkategoriach zm. $second_row
                                    echo ('<div style="display: flex; justify-content: center;">');
                                    echo ('<p style="display:flex; margin:0; justify-content:space-evenly; align-items:center; margin-bottom:2%; width:70%;">');
                                    echo ('
                                       id: <b>' . $second_row["id"] . '</b><label class="kreska"> | </label>  Nazwa: <b>' . $second_row["name"] . ' </b>
                                       <label class="kreska"> | </label> <a href="?idp=panel_cms&kategorie&edit=' . $second_row['id'] . 
                                        '" id="edytuj"> <b>Edytuj</b></a> <label class="kreska"> | </label> <a href="?idp=panel_cms&kategorie&del=' . $second_row['id'] .
                                        '" id="usun" onMouseOver=this.style.color=\'rgb(255,20,60)\' onMouseOut=this.style.color=\'rgb(255,255,255)\'> <b>Usuń</b></a></p></div>
                                        
                                    ');
                                }
                                echo('<hr style="border:0; border-top:0.1px solid #eee; width:30vw;">');
                            }
                            else {  // jeżeli nie istnieja podkategorie
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

                }
                echo ("</div></div>");
            
            } else {
                echo "Brak wyników";
            }


            
        }
    
        if (isset($_GET['add'])) {  // jeżeli chcemy wykonać dodawanie kategorii - ustawiona jest zmienna 'add' w linku - wykonuje się ta część kodu
            require(dirname(__DIR__, 1). '/cfg.php');
    
            $id = $_GET['add'];
            // To echo wygląda w ten sposób, ponieważ nie działało przekierowywanie przez header('Location:')
            echo("
                <link rel='stylesheet' href='css/kategorie.css'><script src='js/checkbox.js'></script><div class='strony'><p id='dodaj' style='font-size:1.6vw;'>Dodawanie kategorii</p><div class='logowanie'><form style='display: flex; flex-direction: column; align-items: stretch;' method='post'><label for='category_name' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Nazwa kategorii</label><input type='text' name='category_name' id='category_name' placeholder='Nazwa kategorii' required=required><label for='master' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Kategoria-matka</label><input type='text' name='master' id='master' placeholder='Zostaw puste, jeżeli to kategoria główna'><div id='przyciski'><button id='przycisk' type='submit' formaction='?idp=panel_cms&podstrony' onMouseOver=\"this.style.fontWeight='bold'\" onMouseOut=\"this.style.fontWeight='normal'\")>Wróć</button><button id='przycisk' type='submit' name='save' onMouseOver=\"this.style.color='rgb(0,165,0)'; this.style.fontWeight='bold'\" onMouseOut=\"this.style.color='rgb(0,0,0)'; this.style.fontWeight='normal'\")>Dodaj</button><br></div></form></div></div>'");
    
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {    // jeżeli przesyłamy formularz - wykonuje się ta część kodu
    
                require(dirname(__DIR__, 1). '/cfg.php'); 
    
                $category_name = $_POST['category_name'];
                $master = $_POST['master'];

                if (empty($master))
                    $master = 0;

                $query = "INSERT INTO category_list (master, name) VALUES (:master, :category_name)";
                $sth = $dbh->prepare($query);
                $sth->bindParam(':master', $master);
                $sth->bindParam(':category_name', $category_name, PDO::PARAM_STR);
                $sth->setFetchMode(PDO::FETCH_ASSOC);
                $sth->execute();
    
                $_SESSION['success'] = true;
                $_SESSION['action'] = 'add';
                header('Location: ?idp=panel_cms&kategorie');
            }
        }
    
        if (isset($_GET['edit'])) { // jeżeli chcemy wykonać edycję podstrony - ustawiona jest zmienna 'edit' w linku - wykonuje się ta część kodu
            
            require(dirname(__DIR__, 1). '/cfg.php');
            
            $id = $_GET['edit'];
            $query = "SELECT * FROM category_list WHERE id=:id LIMIT 1";
            $sth = $dbh->prepare($query);
            $sth->bindParam(':id', $id);
            $sth->setFetchMode(PDO::FETCH_ASSOC);
            $sth->execute();

            while ($row = $sth->fetch()) {

                echo("
                    <div class='strony'>
                    <p id='dodaj' style='font-size:1.6vw;'><b>Edytowanie</b> kategorii</p>
                    <form style='display: flex; flex-direction: column; align-items: stretch;' method='post'>
                ");
                
                echo ('
                    <link rel="stylesheet" href="css/kategorie.css">
                    <label for="id" style="padding-top:2%; padding-bottom:1%; font-size:1.3vw;">ID</label>
                    <input type="number" name="id" id="id" disabled value="' . $row['id'] . 
                    '">
                    <label for="category_name" style="padding-top:2%; padding-bottom:1%; font-size:1.3vw;">Tytuł strony</label>
                    <input type="text" name="category_name" id="category_name" placeholder="Nazwa kategorii" value="' . $row['name'] . 
                    '">
                    <label for="master" style="padding-top:2%; padding-bottom:1%; font-size:1.3vw;">Kategoria-matka</label>
                    <input type="number" min=0 name="master" id="master" placeholder="Kategoria-matka" value=' . (($row['master'] == 0) ? '' : $row['master']) . '><div id="przyciski"><button id="przycisk" type="submit" formaction="?idp=panel_cms&kategorie" onMouseOver="this.style.fontWeight=\'bold\'" onMouseOut="this.style.fontWeight=\'normal\'")>Wróć</button><button id="przycisk" type="submit" name="save" onMouseOver="this.style.color=\'rgb(0,165,0)\'; this.style.fontWeight=\'bold\'" onMouseOut="this.style.color=\'rgb(0,0,0)\'; this.style.fontWeight=\'normal\'">Zapisz</button></form></div></div>');

            }
                
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {    // jeżeli przesyłamy formularz - wykonuje się ta część kodu
               
                require_once(dirname(__DIR__, 1). '/cfg.php');
                
                $id = $_GET['edit'];
                $category_name = $_POST['category_name'];
                $master = $_POST['master'];

                if (empty($master))
                    $master = 0;

                $query = "UPDATE category_list SET master=:master, name=:category_name WHERE id=$id LIMIT 1";
                $sth = $dbh->prepare($query);
                $sth->bindParam(':master', $master);
                $sth->bindParam(':category_name', $category_name, PDO::PARAM_STR);
                $sth->execute();
                    
                $_SESSION['success'] = true;
                $_SESSION['action'] = 'edit';

                header('Location: ?idp=panel_cms&kategorie');
            }
        }
        
        if (isset($_GET['del'])) { // jeżeli chcemy usunąć podstronę - ustawiona jest zmienna 'del' w linku - wykonuje się ta część kodu
            require(dirname(__DIR__, 1) . '/cfg.php');
            $id = $_GET['del'];
    
            $query = "SELECT * FROM category_list WHERE id=:id LIMIT 1";
            $sth = $dbh->prepare($query);
            $sth->bindParam(':id', $id);
            $sth->setFetchMode(PDO::FETCH_ASSOC);
            $sth->execute();
    
            while ($row = $sth->fetch()) {
                echo ('
                    <link rel="stylesheet" href="css/kategorie.css">
                    <div class="strony">
                    <p id="dodaj" style="font-size:1.6vw;"><b>Usuwanie</b> kategorii</p>
                    <div class="logowanie">
                    <form style="display: flex; flex-direction: column; align-items: stretch;" method="post">
                    <label style="padding-bottom:1%; font-size:1.6vw;">Czy na pewno chcesz usunąć kategorię poniżej?</label>
                    <label for="id" font-size:1.3vw;">ID</label>
                    <input type="number" name="id" id="id" disabled value="' . $row['id'] . '"</input>
                    <label for="page_content" style="padding-top:2%; padding-bottom:1%; font-size:1.3vw;">Tytuł strony</label>
                    <input type="text" name="category_name" id="category_name" readonly value=' . $row['name'] . '>
                    <label for="master" style="padding-top:2%; padding-bottom:1%; font-size:1.3vw;">Kategoria-matka:</label>
                    <input type="text" name="master" id="master" readonly value=' . $row['master'] . '>
                    <div id="przyciski">
                    <button id="przycisk" type="submit" formaction="?idp=panel_cms&kategorie" onMouseOver="this.style.fontWeight=\'bold\'" onMouseOut="this.style.fontWeight=\'normal\'">Wróć</button>
                    <button id="przycisk" name="del_button" type="submit" onMouseOver="this.style.color=\'rgb(255,20,60)\'; this.style.fontWeight=\'bold\'" onclick="return confirm(\'Czy chcesz na pewno usunąć kategorię?\')" onMouseOut="this.style.color=\'rgb(0,0,0)\'; this.style.fontWeight=\'normal\'">Usuń</button></br>
                    </div>
                    </form>
                    </div>
                    </div>
                ');
                
            }
    
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
                $query = "DELETE FROM category_list WHERE id=:id LIMIT 1"; 
                $sth = $dbh->prepare($query);
                $sth->bindParam(':id', $id);
                $sth->execute();
                $_SESSION['success'] = true;
                $_SESSION['action'] = 'del';
                header('Location: ?idp=panel_cms&kategorie');
                
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