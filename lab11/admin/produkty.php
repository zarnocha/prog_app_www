<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    date_default_timezone_set("Europe/Warsaw");
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
                '</b> produktu powiodło się!</label>
                </div>
            ');
            $_SESSION['success'] = false;   // po wyświetleniu komunikatu o pomyślnym ukończeniu akcji nie chcemy wyświetlać jej ponownie
            unset($akcja);  // zabezpieczenie, aby przypadkiem nie wyświetlił się komunikat gdy nie wykonano żadnej akcji
        }
    
        // Funkcja ListaProduktów() zwraca listę zawierającą produkty pobrane z bazy danych. Pobiera ona konfigurację połączenia z pliku cfg.php, 
        // następnie wykonuje kwerendę do bazy aby dostać z powrotem produkty do zmiennej $result.
        // Kolejno za pomocą polecenia echo wyświetlam div'a z produktami.
        
        function ListaProduktów() {
            require(dirname(__DIR__, 1). '/cfg.php');   // wymagany jest plik konfiguracyjny łączący z bazą danych

            $query = "SELECT * FROM product_list LIMIT 100";
            $sth = $dbh->prepare($query);
            $sth->setFetchMode(PDO::FETCH_ASSOC);
            $sth->execute();

            echo ('
                <link rel="stylesheet" href="css/kategorie.css">
                <div class="strony" style="width:80%;">
                <a href="?idp=panel_cms" id="dodaj" style="font-size:1.6vw; margin-bottom:10%;">Powróć do panelu CMS</a><br/><br/>
                <a href="?idp=panel_cms&produkty&add" id="dodaj" style="font-size:1.6vw; margin-bottom:10%;">Dodaj produkt</a><br/><br/>
                <hr style="width:40vw;">
                <div style="display: flex;flex-direction: row;justify-content: center;align-content: center;flex-wrap: wrap;">
                ');

            if ($sth->rowCount() > 0) { // jeżeli istnieją produkty
                while ($row = $sth->fetch()) {  // iteracja zmienną $row po produktach
                    echo("
                    
                    <p style='display:flex;align-items:center;align-content: center;justify-content: space-around; width:80%;'>
                    <img height='150px' width='150px' src=data:image/png;base64," . $row['picture'] . " /> <label class='kreska_przedmiotu'> | </label><label class='kolumna_przedmiotu'>Nazwa: <b><a href='?idp=panel_cms&produkty&details=" . $row['id'] . "'>" . $row["product_name"] . "</a></b></label><label class='kreska_przedmiotu'> | </label><label class='kolumna_przedmiotu'>Cena: <b>" . round($row['net_price'] * $row['vat'], 2) . "</b></label><label class='kreska_przedmiotu'> | </label><label class='kolumna_przedmiotu'>Dostępność: <b " . ($row['availability'] == 1 ? ("style='color: rgb(52, 216, 52);'>Jest dostępny") : ("style='color: rgb(255, 20, 60);'>Nie jest dostępny")). "</b></label><label class='kreska_przedmiotu'> | </label>"
                    );

                    echo("
                    <div class='kolumna_przedmiotu'><a href='?idp=panel_cms&produkty&edit=" . $row['id'] . "
                    ' id='edytuj'> <b>Edytuj</b></a> <hr style='width:50%;'> <a href='?idp=panel_cms&produkty&del=" . $row['id'] . "
                    ' id='usun' onMouseOver=this.style.color='rgb(255,20,60)' onMouseOut=this.style.color='rgb(255,255,255)'> <b>Usuń</b></a>
                    <hr style='width:50%;'> <a href='?idp=panel_cms&produkty&details=" . $row['id'] . "
                    ' id='usun'> <b>Szczegóły</b></a></div></p>
                    ");

                }
                echo ("</div></div>");
            
            } else {
                echo "Brak wyników";
            }


            
        }
    
        if (isset($_GET['add'])) {  // jeżeli chcemy wykonać dodawanie produktu - ustawiona jest zmienna 'add' w linku - wykonuje się ta część kodu
            require(dirname(__DIR__, 1). '/cfg.php');
            
            $id = $_GET['add'];

            $query = "SELECT * FROM category_list LIMIT 100";
            $sth = $dbh->prepare($query);
            $sth->setFetchMode(PDO::FETCH_ASSOC);
            $sth->execute();

            // To echo wygląda w ten sposób, ponieważ nie działało przekierowywanie przez header('Location:')
            echo ("<link rel='stylesheet' href='css/produkty.css'><script src='js/availability.js'></script><div class='strony'><p id='dodaj' style='font-size:1.6vw;'>Dodawanie produktu</p><div class='logowanie'><form style='display: flex; flex-direction: column; align-items: stretch;' method='post'><label for='product_name' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Nazwa produktu</label>");
            echo ("<input type='text' name='product_name' id='product_name' placeholder='Nazwa produktu' required=required><label for='product_description' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Kod strony</label><center>");
            echo("<textarea type='text' name='product_description' id='product_description' placeholder='Opis produktu' style='min-width:10%; max-width:99%;'></textarea></center><label for='expiration_date' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Data wygaśnięcia</label><input type='datetime-local' name='expiration_date' id='expiration_date'><label for='net_price' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Cena netto</label><input type='number' min='0.01' step='0.01' name='net_price' id='net_price' placeholder='Cena netto' required=required><label for='vat' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>VAT (%)</label><input type='number' min='0' max='100' step='1' name='vat' id='vat' placeholder='VAT (%)' required=required><label for='quanity' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Ilość</label><input type='number' min='0' step='1' name='quanity' id='quanity' placeholder='Ilość' required=required><label for='availability' style='padding-bottom:1%; padding-top: 2%; font-size:1.3vw;'>Czy dostępny?</label><input type='checkbox' checked='checked' name='availability' id='availability' style='height: 1vw; width: 1vw; align-self: center;' onclick=\"isProductAvailable();\"><label id='availability_text' for='status' style='color:white;'>Tak</label><label for='category_select' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Kategoria produktu</label><select id='category_select'>");

            
            while ($row = $sth->fetch()) {
                echo ("<option style='text-align: center;' value='" . $row['id'] . "'>");
                echo ($row['name']);
                echo ("</option>");
            }

            echo ("</select>");

            echo ("<label for='category_select' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Gabaryty produktu</label><select id='category_select'>");

            $gabaryty = ['małe', 'średnie', 'duże'];

            foreach ($gabaryty as &$gabaryt) {
                echo ("<option style='text-align: center;' value='" . $gabaryt . "'>");
                echo ($gabaryt);
                echo ("</option>");
            }

            echo ("</select><label for='picture' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Dodaj zdjęcie</label><center><input id='input_picture' type='file'></center>");

            echo ("<script src='js/image_to_b64.js'></script>");
            // echo '<p id="b64" style="display:none;"></p>';
            echo("<center><img id='img'></center><input style='display:none;' type='text' id='b64' name='base64_img' /> <div id='przyciski'><button id='przycisk' type='submit' formaction='?idp=panel_cms&podstrony' onMouseOver=\"this.style.fontWeight='bold'\" onMouseOut=\"this.style.fontWeight='normal'\")>Wróć</button><button id='przycisk' type='submit' name='save' onMouseOver=\"this.style.color='rgb(0,165,0)'; this.style.fontWeight='bold'\" onMouseOut=\"this.style.color='rgb(0,0,0)'; this.style.fontWeight='normal'\")>Dodaj</button><br></div></form></div></div>'");

        

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {    // jeżeli przesyłamy formularz - wykonuje się ta część kodu
                require(dirname(__DIR__, 1). '/cfg.php');
                $

                // $query = "INSERT INTO category_list (master, name) VALUES (:master, :category_name)";
                // $sth = $dbh->prepare($query);
                // $sth->bindParam(':master', $master);
                // $sth->bindParam(':category_name', $category_name, PDO::PARAM_STR);
                // $sth->setFetchMode(PDO::FETCH_ASSOC);
                // $sth->execute();
    
                // $_SESSION['success'] = true;
                // $_SESSION['action'] = 'add';
                header('Location: ?idp=panel_cms&produkty');
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
                    <p id='dodaj' style='font-size:1.6vw;'><b>Edytowanie</b> produktu</p>
                    <form style='display: flex; flex-direction: column; align-items: stretch;' method='post'>
                ");
                
                echo ('
                    <link rel="stylesheet" href="css/kategorie.css">
                    <label for="id" style="padding-top:2%; padding-bottom:1%; font-size:1.3vw;">ID</label>
                    <input type="number" name="id" id="id" disabled value="' . $row['id'] . 
                    '">
                    <label for="category_name" style="padding-top:2%; padding-bottom:1%; font-size:1.3vw;">Tytuł strony</label>
                    <input type="text" name="category_name" id="category_name" placeholder="Nazwa produktu" value="' . $row['name'] . 
                    '">
                    <label for="master" style="padding-top:2%; padding-bottom:1%; font-size:1.3vw;">Kategoria-matka</label>
                    <input type="number" min=0 name="master" id="master" placeholder="Kategoria-matka" value=' . (($row['master'] == 0) ? '' : $row['master']) . '><div id="przyciski"><button id="przycisk" type="submit" formaction="?idp=panel_cms&produkty" onMouseOver="this.style.fontWeight=\'bold\'" onMouseOut="this.style.fontWeight=\'normal\'")>Wróć</button><button id="przycisk" type="submit" name="save" onMouseOver="this.style.color=\'rgb(0,165,0)\'; this.style.fontWeight=\'bold\'" onMouseOut="this.style.color=\'rgb(0,0,0)\'; this.style.fontWeight=\'normal\'">Zapisz</button></form></div></div>');

            }
                
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {    // jeżeli przesyłamy formularz - wykonuje się ta część kodu
               
                require_once(dirname(__DIR__, 1). '/cfg.php');

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

                header('Location: ?idp=panel_cms&produkty');
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
                    <p id="dodaj" style="font-size:1.6vw;"><b>Usuwanie</b> przedmiotu</p>
                    <div class="logowanie">
                    <form style="display: flex; flex-direction: column; align-items: stretch;" method="post">
                    <label style="padding-bottom:1%; font-size:1.6vw;">Czy na pewno chcesz usunąć przedmiot poniżej?</label>
                    <label for="id" font-size:1.3vw;">ID</label>
                    <input type="number" name="id" id="id" disabled value="' . $row['id'] . '"</input>
                    <label for="page_content" style="padding-top:2%; padding-bottom:1%; font-size:1.3vw;">Tytuł strony</label>
                    <input type="text" name="category_name" id="category_name" readonly value=' . $row['name'] . '>
                    <label for="master" style="padding-top:2%; padding-bottom:1%; font-size:1.3vw;">Kategoria-matka:</label>
                    <input type="text" name="master" id="master" readonly value=' . $row['master'] . '>
                    <div id="przyciski">
                    <button id="przycisk" type="submit" formaction="?idp=panel_cms&produkty" onMouseOver="this.style.fontWeight=\'bold\'" onMouseOut="this.style.fontWeight=\'normal\'">Wróć</button>
                    <button id="przycisk" name="del_button" type="submit" onMouseOver="this.style.color=\'rgb(255,20,60)\'; this.style.fontWeight=\'bold\'" onclick="return confirm(\'Czy chcesz na pewno usunąć przedmiot?\')" onMouseOut="this.style.color=\'rgb(0,0,0)\'; this.style.fontWeight=\'normal\'">Usuń</button></br>
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
                header('Location: ?idp=panel_cms&produkty');
                
            }
        }
    
        if (!(isset($_GET['add']) || isset($_GET['edit']) || isset($_GET['del']) || isset($_GET['details'])))  // produkty wyświetlą się tylko jeżeli nie będziemy w podstronie "edytującej" dany przedmiot. 
            ListaProduktów();    // wyświetlanie produktów funkcją
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