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
                <div class="strony" style="width: 80%;">
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
                <link rel="stylesheet" href="css/produkty.css">
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
                    <img height='150px' width='150px' src='" . $row['picture'] . "' /> <label class='kreska_przedmiotu'> | </label><label class='kolumna_przedmiotu'>Nazwa: <b>
                    <a id='nazwa_przedmiotu_do_przenoszenia' href='?idp=panel_cms&produkty&details=" . $row['id'] . "'>" . $row["product_name"] . "</a></b></label><label class='kreska_przedmiotu'> | </label><label class='kolumna_przedmiotu'>Cena: <b>" . round($row['net_price'] * $row['vat'], 2) . " zł</b></label><label class='kreska_przedmiotu'> | </label><label class='kolumna_przedmiotu'>Dostępność: <b " . ($row['availability'] == 1 ? ("style='color: rgb(52, 216, 52);'>Jest dostępny") : ("style='color: rgb(255, 20, 60);'>Nie jest dostępny")). "</b></label><label class='kreska_przedmiotu'> | </label>"
                    );

                    echo("
                    <div class='kolumna_przedmiotu'><a href='?idp=panel_cms&produkty&edit=" . $row['id'] . "' id='edytuj'>
                    <b>Edytuj</b></a> <hr style='width:50%;'> <a href='?idp=panel_cms&produkty&del=" . $row['id'] . "' id='usun' onMouseOver=this.style.color='rgb(255,20,60)' onMouseOut=this.style.color='rgb(255,255,255)'>
                    <b>Usuń</b></a>
                    <hr style='width:50%;'> <a href='?idp=panel_cms&produkty&details=" . $row['id'] . "
                    ' id='usun'> <b>Szczegóły</b></a></div></p>
                    ");

                }
                echo ("</div></div>");

            } else {
                echo "Brak wyników";
            }



        }

        function DodajProdukt() {
            require(dirname(__DIR__, 1). '/cfg.php');

            $id = $_GET['add'];

            $query = "SELECT * FROM category_list LIMIT 100";
            $sth = $dbh->prepare($query);
            $sth->setFetchMode(PDO::FETCH_ASSOC);
            $sth->execute();

            echo ("<link rel='stylesheet' href='css/produkty.css'><script src='js/availability.js'></script><div class='strony' style='width:80%;'><p id='dodaj' style='font-size:1.6vw;'><b>Dodawanie</b> produktu</p><div class='logowanie'><form style='display: flex; flex-direction: column; align-items: stretch;' method='post'><label for='product_name' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Nazwa produktu</label>");
            echo ("<input type='text' name='product_name' id='product_name' placeholder='Nazwa produktu' ><label for='product_description' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Opis przedmiotu</label><center>");
            echo("<textarea type='text' name='product_description' id='product_description' placeholder='Opis produktu' style='min-width:10%; max-width:99%;'></textarea></center><label for='expiration_date' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Data wygaśnięcia</label><input type='datetime-local' name='expiration_date' id='expiration_date'><label for='net_price' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Cena netto</label><input type='number' min='0.01' step='0.01' name='net_price' id='net_price' placeholder='Cena netto' ><label for='vat' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>VAT (%)</label><input type='number' min='0' max='100' step='1' name='vat' id='vat' placeholder='VAT (%)' ><label for='quanity' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Ilość</label><input type='number' min='0' step='1' name='quanity' id='quanity' placeholder='Ilość' ><label for='availability' style='padding-bottom:1%; padding-top: 2%; font-size:1.3vw;'>Czy dostępny?</label><input type='checkbox' checked='checked' name='availability' id='availability' style='height: 1vw; width: 1vw; align-self: center;' onclick=\"isProductAvailable();\"><label id='availability_text' for='status' style='color:white;'>Tak</label><label for='category_select' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Kategoria produktu</label><select name='category_select' id='category_select'>");


            while ($row = $sth->fetch()) {
                echo ("<option style='text-align: center;' value='" . $row['id'] . "'>");
                echo ($row['name']);
                echo ("</option>");
            }

            echo ("</select>");

            echo ("<label for='size' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Gabaryty produktu</label><select name='size' id='size'>");

            $gabaryty = ['małe', 'średnie', 'duże'];

            foreach ($gabaryty as &$gabaryt) {
                echo ("<option  style='text-align: center;' value='" . $gabaryt . "'>");
                echo ($gabaryt);
                echo ("</option>");
            }

            echo ("</select><label for='picture' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Dodaj zdjęcie</label><center><input id='input_picture' type='file'></center>");

            echo ("<script src='js/image_to_b64.js'></script>");
            // echo '<p id="b64" style="display:none;"></p>';
            echo("<center><img id='img'></center><input style='display:none;' type='text' id='b64' name='base64_img' /> <div id='przyciski'><button id='przycisk' type='submit' formaction='?idp=panel_cms&podstrony' onMouseOver=\"this.style.fontWeight='bold'\" onMouseOut=\"this.style.fontWeight='normal'\")>Wróć</button><button id='przycisk' type='submit' name='save' onMouseOver=\"this.style.color='rgb(0,165,0)'; this.style.fontWeight='bold'\" onMouseOut=\"this.style.color='rgb(0,0,0)'; this.style.fontWeight='normal'\")>Dodaj</button><br></div></form></div></div>'");



            if ($_SERVER['REQUEST_METHOD'] === 'POST') {    // jeżeli przesyłamy formularz - wykonuje się ta część kodu
                require(dirname(__DIR__, 1). '/cfg.php');
                $product_name = $_POST['product_name'];
                $product_description = $_POST['product_description'];
                $creation_date = date('Y/m/d h:i:s', time());
                $modification_date = date('Y/m/d h:i:s', time());
                $expiration_date = $_POST['expiration_date'];
                $net_price = $_POST['net_price'];
                $vat = $_POST['vat'];
                $vat = 1 + ($vat / 100);
                $quanity = $_POST['quanity'];
                $availability = ($_POST['availability'] == 'on' ? '1' : 0);
                $category_id = $_POST['category_select'];
                $size = $_POST['size'];
                $picture = $_POST['base64_img'];

                $query = "INSERT INTO product_list (product_name, product_description, creation_date, modification_date, expiration_date, net_price, vat, quanity, availability, category_id, size, picture) VALUES (:product_name, :product_description, :creation_date, :modification_date, :expiration_date, :net_price, :vat, :quanity, :availability, :category_id, :size, :picture)";
                $sth = $dbh->prepare($query);
                $sth->bindValue(':product_name', $product_name);
                $sth->bindValue(':product_description', $product_description);
                $sth->bindValue(':creation_date', $creation_date);
                $sth->bindValue(':modification_date', $modification_date);
                $sth->bindValue(':expiration_date', $expiration_date);
                $sth->bindValue(':net_price', $net_price);
                $sth->bindValue(':vat', $vat);
                $sth->bindValue(':quanity', $quanity);
                $sth->bindValue(':availability', $availability);
                $sth->bindValue(':category_id', $category_id);
                $sth->bindValue(':size', $size);
                $sth->bindValue(':picture', $picture);

                // $sth->setFetchMode(PDO::FETCH_ASSOC);
                $sth->execute();

                $_SESSION['success'] = true;
                $_SESSION['action'] = 'add';
                // header('Location: ?idp=panel_cms&produkty');
                echo "<script> window.location.href='?idp=panel_cms&produkty';</script>";
            }
        }

        function EdytujProdukt() {
            require(dirname(__DIR__, 1). '/cfg.php');

            $id = $_GET['edit'];
            $query = "SELECT * FROM product_list WHERE id=:id LIMIT 1";
            $sth = $dbh->prepare($query);
            $sth->bindParam(':id', $id);
            $sth->setFetchMode(PDO::FETCH_ASSOC);
            $sth->execute();
            // $row = $sth->fetchAll();

            $second_query = "SELECT * FROM category_list LIMIT 100";
            $second_sth = $dbh->prepare($second_query);
            $second_sth->setFetchMode(PDO::FETCH_ASSOC);
            $second_sth->execute();

            while ($row = $sth->fetch()) {
                $check = ($row['availability'] == 1 ? true : false);
                echo "<link rel='stylesheet' href='css/produkty.css'><script src='js/availability.js'></script><div class='strony'><p id='dodaj' style='font-size:1.6vw;'><b>Edytowanie</b> produktu</p><div class='logowanie'><form style='display: flex; flex-direction: column; align-items: stretch;' method='post'><label for='product_name' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Nazwa produktu</label>";
                echo "<input type='text' name='product_name' id='product_name' placeholder='Nazwa produktu'  value='" . $row['product_name'] . "'><label for='product_description' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Opis przedmiotu</label>";
                echo "<center><textarea type='text' name='product_description' id='product_description' ";
                echo "placeholder='Opis produktu' style='min-width:10%; ";
                echo "max-width:99%;'>";
                echo $row['product_description']."</textarea></center><label for='expiration_date' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Data wygaśnięcia</label><input type='datetime-local' name='expiration_date' id='expiration_date' value='".$row['expiration_date']."'><label for='net_price' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Cena netto</label>";
                echo "<input type='number' min='0.01' step='0.01' name='net_price' id='net_price' placeholder='Cena netto'  value='" . $row['net_price'] . "'><label for='vat' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>VAT (%)</label><input type='number' min='0' max='100' step='1' name='vat' id='vat' placeholder='VAT (%)'  value='" . ($row['vat'] - 1) * 100 . "'><label for='quanity' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Ilość</label><input type='number' min='0' step='1' name='quanity' id='quanity' placeholder='Ilość'  value='" . $row['quanity'] . "'><label for='availability' style='padding-bottom:1%; padding-top: 2%; font-size:1.3vw;'>Czy dostępny?</label><input type='checkbox' name='availability' id='availability' style='height: 1vw; width: 1vw; align-self: center;' onclick=\"isProductAvailable();\"". ($check ? 'checked' : "") . " ><label id='availability_text' for='status' style='color:white;'>". ($check == 1 ? 'Tak' : "Nie") ."</label><label for='category_select' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Kategoria produktu</label><select name='category_select' id='category_select'>";
             }


            $query = "SELECT * FROM product_list WHERE id=:id LIMIT 1";
            $sth = $dbh->prepare($query);
            $sth->bindParam(':id', $id);
            $sth->setFetchMode(PDO::FETCH_ASSOC);
            $sth->execute();
            $row = $sth->fetchAll();

            while ($second_row = $second_sth->fetch()) {
                echo ("<option style='text-align: center;' " . ($row[0]['category_id'] == $second_row['id'] ? 'selected' : '') . " value='" . $second_row['id'] . "' >");
                echo ($second_row['name']);
                echo ("</option>");
            }

            echo ("</select>");

            echo ("<label for='size' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Gabaryty produktu</label><select name='size' id='size'>");

            $gabaryty = ['małe', 'średnie', 'duże'];

            foreach ($gabaryty as &$gabaryt) {
                echo ("<option  style='text-align: center;' " . ($row[0]['size'] == $gabaryt ? 'selected' : '') . " value='" . $gabaryt . "'>");
                echo ($gabaryt);
                echo ("</option>");
            }

            echo ("</select><label for='picture' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Dodaj zdjęcie</label><center><input id='input_picture' type='file'></center>");

            echo ("<script src='js/image_to_b64.js'></script>");
            if (!(empty($row[0]['picture'])))
            {
                $_POST['old_picture'] = $row[0]['picture'];
                echo("<center><img id='img' style='width: 150px;height: 150px' src=" . $row[0]['picture'] . "></center><input style='display:none;' type='text' id='b64' name='base64_img' /> <div id='przyciski'><button id='przycisk' type='submit' formaction='?idp=panel_cms&produkty' onMouseOver=\"this.style.fontWeight='bold'\" onMouseOut=\"this.style.fontWeight='normal'\">Wróć</button><button id='przycisk' type='submit' name='save' onMouseOver=\"this.style.color='rgb(0,165,0)'; this.style.fontWeight='bold'\" onMouseOut=\"this.style.color='rgb(0,0,0)'; this.style.fontWeight='normal'\">Zapisz</button><br></div></form></div></div>");
            }

            else {
                echo("<center><img id='img'></center><input style='display:none;' type='text' id='b64' name='base64_img' /> <div id='przyciski'><button id='przycisk' type='submit' formaction='?idp=panel_cms&produkty' onMouseOver=\"this.style.fontWeight='bold'\" onMouseOut=\"this.style.fontWeight='normal'\">Wróć</button><button id='przycisk' type='submit' name='save' onMouseOver=\"this.style.color='rgb(0,165,0)'; this.style.fontWeight='bold'\" onMouseOut=\"this.style.color='rgb(0,0,0)'; this.style.fontWeight='normal'\">Zapisz</button><br></div></form></div></div>");
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {    // jeżeli przesyłamy formularz - wykonuje się ta część kodu

                require_once(dirname(__DIR__, 1). '/cfg.php');
                $id = $_GET['edit'];
                $product_name = $_POST['product_name'];
                $product_description = $_POST['product_description'];
                $modification_date = date('Y/m/d h:i:s', time());
                $expiration_date = $_POST['expiration_date'];
                $net_price = $_POST['net_price'];
                $vat = $_POST['vat'];
                $vat = 1 + ($vat / 100);
                $quanity = $_POST['quanity'];

                $availability = (isset($_POST['availability']) ? 1 : 0);

                $category_id = $_POST['category_select'];
                $size = $_POST['size'];
                $picture = $_POST['base64_img'];

                if (empty($picture)) {
                    if (empty($_POST['old_picture'])) {
                        $picture = '';
                    }
                    else {
                        $picture = $_POST['old_picture'];
                    }
                }

                $query = "UPDATE product_list SET product_name=:product_name, product_description=:product_description, modification_date=:modification_date, expiration_date=:expiration_date, net_price=:net_price, vat=:vat, quanity=:quanity, availability=:availability, category_id=:category_id, size=:size, picture=:picture WHERE id=$id LIMIT 1";
                $sth = $dbh->prepare($query);
                $sth->bindValue(':product_name', $product_name);
                $sth->bindValue(':product_description', $product_description);
                $sth->bindValue(':modification_date', $modification_date);
                $sth->bindValue(':expiration_date', $expiration_date);
                $sth->bindValue(':net_price', $net_price);
                $sth->bindValue(':vat', $vat);
                $sth->bindValue(':quanity', $quanity);
                $sth->bindValue(':availability', $availability);
                $sth->bindValue(':category_id', $category_id);
                $sth->bindValue(':size', $size);
                $sth->bindValue(':picture', $picture);
                $sth->execute();

                $_SESSION['success'] = true;
                $_SESSION['action'] = 'edit';

                // header('Location: ?idp=panel_cms&produkty')
                echo "<script> window.location.href='?idp=panel_cms&produkty';</script>";
            }
        }

        function PokazProdukt() {
            require(dirname(__DIR__, 1) . '/cfg.php');
            $id = $_GET['details'];
            $query = "SELECT * FROM product_list WHERE id=:id LIMIT 1";
            $sth = $dbh->prepare($query);
            $sth->bindParam(':id', $id);
            $sth->setFetchMode(PDO::FETCH_ASSOC);
            $sth->execute();

            while ($row = $sth->fetch()) {
                $check = ($row['availability'] == 1 ? true : false);
                echo "<link rel='stylesheet' href='css/produkty.css'><script src='js/availability.js'></script>
                <div class='strony'>
                <p id='dodaj' style='font-size:1.6vw;'><b>Szczegóły</b> produktu</p>
                <div class='logowanie'>
                <form style='display: flex; flex-direction: column; align-items: stretch;' method='post'>
                <label for='product_name' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Nazwa produktu</label>";
                echo "<input readonly type='text' name='product_name' id='product_name' placeholder='Nazwa produktu'  value='" . $row['product_name'] . "'>
                <label for='product_description' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Opis produktu</label>";
                echo "<center><textarea readonly type='text' name='product_description' id='product_description' placeholder='Opis produktu' style='min-width:10%; max-width:99%;'>";
                echo $row['product_description']."</textarea></center>
                <label for='creation_date' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Data utworzenia</label>
                <input readonly type='datetime-local' name='creation_date' id='expiration_date' value='".$row['creation_date']."'>
                <label for='modification_date' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Data ostatniej modyfikacji</label>
                <input readonly type='datetime-local' name='modification_date' id='expiration_date' value='".$row['modification_date']."'>
                <label for='expiration_date' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Data wygaśnięcia</label>
                <input readonly type='datetime-local' name='expiration_date' id='expiration_date' value='".$row['expiration_date']."'>
                <label for='net_price' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Cena netto</label>";
                echo "<input readonly type='number' min='0.01' step='0.01' name='net_price' id='net_price' placeholder='Cena netto'  value='" . $row['net_price'] . "'>
                <label for='vat' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>VAT (%)</label><input readonly type='number' min='0' max='100' step='1' name='vat' id='vat' placeholder='VAT (%)'  value='" . ($row['vat'] - 1) * 100 . "'>
                <label for='quanity' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Ilość</label>
                <input readonly type='number' min='0' step='1' name='quanity' id='quanity' placeholder='Ilość'  value='" . $row['quanity'] . "'><label for='availability' style='padding-bottom:1%; padding-top: 2%; font-size:1.3vw;'>Czy dostępny?</label><input readonly type='checkbox' name='availability' id='availability' style='height: 1vw; width: 1vw; align-self: center;' onclick=\"return false;\"". ($check ? 'checked' : "") . " >
                <label id='availability_text' for='status' style='color:white;'>". ($check == 1 ? 'Tak' : "Nie") ."</label><label for='category_select' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Kategoria produktu</label>
                <input readonly type='text' name='category_select' id='category_select' placeholder='Nazwa produktu' style='width:15vw;' value='" . $row['category_id']
                ;

                $second_query = "SELECT * FROM category_list WHERE id=:category_id LIMIT 100";
                $second_sth = $dbh->prepare($second_query);
                $second_sth->bindParam(":category_id", $row['category_id']);
                $second_sth->setFetchMode(PDO::FETCH_ASSOC);
                $second_sth->execute();
                $second_row = $second_sth->fetchAll();
                echo ' -> ' . $second_row[0]['name']. "'>
                <label for='size' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Gabaryty produktu</label>
                <input readonly type='text' name='category_select' id='category_select' placeholder='Gabaryty produktu' style='width:15vw;' value='" . $row['size'] . "'</input>
                ";

                if (!(empty($row['picture'])))
                {
                    echo("<label for='picture' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Zdjęcie produktu</label>
                          <center><img id='img' style='width: 150px;height: 150px' src=" . $row['picture'] . "></center>
                          <input style='display:none;' type='text' id='b64' name='base64_img' />
                    ");
                }
                echo "
                    <div id='przyciski'>
                    <button id='przycisk' type='submit' formaction='?idp=panel_cms&produkty' onMouseOver=\"this.style.fontWeight='bold'\" onMouseOut=\"this.style.fontWeight='normal'\">Wróć</button>
                    <br></div></form></div></div>
                ";
            }
        }

        function UsunProdukt() {
            require(dirname(__DIR__, 1) . '/cfg.php');
            $id = $_GET['del'];

            $query = "SELECT * FROM product_list WHERE id=:id LIMIT 1";
            $sth = $dbh->prepare($query);
            $sth->bindParam(':id', $id);
            $sth->setFetchMode(PDO::FETCH_ASSOC);
            $sth->execute();

            while ($row = $sth->fetch()) {
                $check = ($row['availability'] == 1 ? true : false);
                echo "<link rel='stylesheet' href='css/produkty.css'><script src='js/availability.js'></script>
                <div class='strony'>
                <p id='dodaj' style='font-size:1.6vw;'><b>Usuwanie</b> przedmiotu</p>
                <div class='logowanie'>
                <form style='display: flex; flex-direction: column; align-items: stretch;' method='post'>
                <label style='padding-bottom:1%; font-size:1.6vw;'>Czy na pewno chcesz usunąć przedmiot poniżej?</label>
                <label for='product_name' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Nazwa produktu</label>";
                echo "<input readonly type='text' name='product_name' id='product_name' placeholder='Nazwa produktu'  value='" . $row['product_name'] . "'>
                <label for='product_description' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Opis produktu</label>";
                echo "<center><textarea readonly type='text' name='product_description' id='product_description' placeholder='Opis produktu' style='min-width:10%; max-width:99%;'>";
                echo $row['product_description']."</textarea></center>
                <label for='creation_date' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Data utworzenia</label>
                <input readonly type='datetime-local' name='creation_date' id='expiration_date' value='".$row['creation_date']."'>
                <label for='modification_date' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Data ostatniej modyfikacji</label>
                <input readonly type='datetime-local' name='modification_date' id='expiration_date' value='".$row['modification_date']."'>
                <label for='expiration_date' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Data wygaśnięcia</label>
                <input readonly type='datetime-local' name='expiration_date' id='expiration_date' value='".$row['expiration_date']."'>
                <label for='net_price' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Cena netto</label>";
                echo "<input readonly type='number' min='0.01' step='0.01' name='net_price' id='net_price' placeholder='Cena netto'  value='" . $row['net_price'] . "'>
                <label for='vat' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>VAT (%)</label><input readonly type='number' min='0' max='100' step='1' name='vat' id='vat' placeholder='VAT (%)'  value='" . ($row['vat'] - 1) * 100 . "'>
                <label for='quanity' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Ilość</label>
                <input readonly type='number' min='0' step='1' name='quanity' id='quanity' placeholder='Ilość'  value='" . $row['quanity'] . "'><label for='availability' style='padding-bottom:1%; padding-top: 2%; font-size:1.3vw;'>Czy dostępny?</label><input readonly type='checkbox' name='availability' id='availability' style='height: 1vw; width: 1vw; align-self: center;' onclick=\"return false;\"". ($check ? 'checked' : "") . " >
                <label id='availability_text' for='status' style='color:white;'>". ($check == 1 ? 'Tak' : "Nie") ."</label><label for='category_select' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Kategoria produktu</label>
                <input readonly type='text' name='category_select' id='category_select' placeholder='Nazwa produktu' style='width:15vw;' value='" . $row['category_id']
                ;

                $second_query = "SELECT * FROM category_list WHERE id=:category_id LIMIT 100";
                $second_sth = $dbh->prepare($second_query);
                $second_sth->bindParam(":category_id", $row['category_id']);
                $second_sth->setFetchMode(PDO::FETCH_ASSOC);
                $second_sth->execute();
                $second_row = $second_sth->fetchAll();
                echo ' -> ' . $second_row[0]['name']. "'>
                <label for='size' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Gabaryty produktu</label>
                <input readonly type='text' name='category_select' id='category_select' placeholder='Gabaryty produktu' style='width:15vw;' value='" . $row['size'] . "'</input>
                ";

                if (!(empty($row['picture'])))
                {
                    echo("
                        <label for='picture' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Zdjęcie produktu</label>
                        <center><img id='img' style='width: 150px;height: 150px' src=" . $row['picture'] . "></center>
                        <input style='display:none;' type='text' id='b64' name='base64_img' />
                    ");
                }
                echo "<div id='przyciski'>
                    <button id='przycisk' type='submit' formaction='?idp=panel_cms&produkty' onMouseOver=\"this.style.fontWeight='bold'\" onMouseOut=\"this.style.fontWeight='normal'\">Wróć</button>
                    <button id='przycisk' name='del_button' type='submit' onMouseOver=\"this.style.color=rgb(255,20,60); this.style.fontWeight=bold\" onclick=\"return confirm('Czy chcesz na pewno usunąć przedmiot?')\" onMouseOut=\"this.style.color='rgb(0,0,0)'; this.style.fontWeight='normal'\">Usuń</button>
                    </div></form></div></div>
                ";

            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $query = "DELETE FROM product_list WHERE id=:id LIMIT 1";
                $sth = $dbh->prepare($query);
                $sth->bindParam(':id', $id);
                $sth->execute();
                $_SESSION['success'] = true;
                $_SESSION['action'] = 'del';
                // header('Location: ?idp=panel_cms&produkty');
                echo "<script> window.location.href='?idp=panel_cms&produkty';</script>";

            }
        }

        if (isset($_GET['add'])) {  // jeżeli chcemy wykonać dodawanie produktu - ustawiona jest zmienna 'add' w linku - wykonuje się ta część kodu
            DodajProdukt();
        }

        if (isset($_GET['edit'])) { // jeżeli chcemy wykonać edycję podstrony - ustawiona jest zmienna 'edit' w linku - wykonuje się ta część kodu
            EdytujProdukt();
        }

        if (isset($_GET['details'])) {
            PokazProdukt();
        }

        if (isset($_GET['del'])) { // jeżeli chcemy usunąć podstronę - ustawiona jest zmienna 'del' w linku - wykonuje się ta część kodu
            UsunProdukt();
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