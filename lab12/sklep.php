<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include('admin/aktualizacja_produktow.php');  // przy wejściu na sklep produkty aktualizują się
    OutdatedProducts();
    OutOfProducts();
    ProductIsFine();

    if (isset($_SESSION['zlozone_zamowienie']) && $_SESSION['zlozone_zamowienie']) {
        echo ('
            <center><p id="zlozone_zamowienie">Zamówienie zostało złożone <b style="color:rgb(0,255,0);">pomyślnie!</b></p></center>
        ');
        unset($_SESSION['zlozone_zamowienie']);
    }

    function ZlozZamowienie() {
        require(__DIR__. '/cfg.php');

        $query = "SELECT * FROM product_list WHERE availability=1 LIMIT 100";
        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();


        if ($sth->rowCount() > 0) { // jeżeli istnieją produkty
            while ($row = $sth->fetch()) {
                if (isset($_SESSION[$row['id'] . "_0"])) {
                    $second_query = "UPDATE product_list SET quanity=:quanity WHERE id=:id LIMIT 100";
                    $second_sth = $dbh->prepare($second_query);
                    $second_sth->bindValue(':id', $_SESSION[$row['id'] . "_0"]);
                    $second_sth->bindValue(':quanity', $row['quanity'] - $_SESSION[$row['id'] . "_2"]);
                    $second_sth->execute();
                }
            }
        }
        UsunKoszyk();
        $_SESSION['zlozone_zamowienie'] = true;
        unset($_SERVER['REQUEST_METHOD']);
    }

    function PodsumowanieKoszyka() {
        require(__DIR__. '/cfg.php');
        $query = "SELECT * FROM product_list WHERE availability=1 LIMIT 100";
        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();

        $array['laczna_ilosc'] = 0;
        $array['laczna_cena_brutto'] = 0;

        if ($sth->rowCount() > 0) { // jeżeli istnieją produkty
            while ($row = $sth->fetch()) {
                if (isset($_SESSION[$row['id'] . "_0"])) {
                    $array['laczna_ilosc'] += $_SESSION[$row['id'] . "_2"];
                    $array['laczna_cena_brutto'] += $_SESSION[$row['id'] . "_4"];
                }
            }
        }

        $_SESSION['laczna_ilosc'] = $array['laczna_ilosc'];
        $_SESSION['laczna_cena_brutto'] = $array['laczna_cena_brutto'];

    }

    function CenaBrutto($netto, $vat) {
        return "" . round(($netto * $vat), 2);
    }

    function GetProdukt($id) {
        require(__DIR__. '/cfg.php');
        $query = "SELECT * FROM product_list WHERE id=:id LIMIT 100";
        $sth = $dbh->prepare($query);
        $sth->bindValue(':id', $id);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();

        $product = $sth->fetchAll();

        return $product[0];
    }

    function UsunKoszyk() {
        require(__DIR__. '/cfg.php');
        $query = "SELECT * FROM product_list WHERE availability=1 LIMIT 100";
        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();

        if ($sth->rowCount() > 0) {
            while ($row = $sth->fetch()) {
                $id = $row['id'];
                for ($i = 0; $i < 6; $i++) {
                    if (isset($_SESSION[$id . "_" . $i])) {
                        unset($_SESSION[$id . "_" . $i]);
                        $_SESSION['laczna_ilosc'] = 0;
                        $_SESSION['laczna_cena_brutto'] = 0;
                    }
                }
            }
        }
        unset($_SERVER['REQUEST_METHOD']);
    }

    function DodajDoKoszyka() {

        $id = $_POST['id_przedmiotu'];
        $ilosc_dodawana = $_POST['quanity'];
        $product = GetProdukt($id);

        if (!(isset($_SESSION[$id . "_0"])) && ($ilosc_dodawana > $product['quanity'] || $product['availability'] == '0')) {
            echo "<div id='alert'><h1 id='alert_informacja'>Nie można dodać przedmiotu </h1><h1 id='alert_przedmiot'>" . $product['product_name'] . " x" . $ilosc_dodawana .  "</h1><h1 id='alert_informacja'> do koszyka</h1></div>";
        }

        elseif (isset($_SESSION[$id . "_0"])) { // jeżeli przedmiot jest już w koszyku
            if ($ilosc_dodawana > $product['quanity'] || $ilosc_dodawana + $_SESSION[$id . "_2"] > $product['quanity'] || $product['availability'] == '0') { // jeżeli przedmiotu nie da się dodać do koszyka
                echo "<div id='alert'><h1 id='alert_informacja'>Nie można dodać przedmiotu </h1><h1 id='alert_przedmiot'>" . $product['product_name'] . " x" . $ilosc_dodawana .  "</h1><h1 id='alert_informacja'> do koszyka</h1></div>";

            }
            else {
                $nowa_ilosc = $_SESSION[$id . "_2"] + $ilosc_dodawana;
                $_SESSION[$id . "_2"] = $nowa_ilosc;
                $nowa_cena_calkowita = $_SESSION[$id . "_4"] + ($_SESSION[$id . "_3"] * $ilosc_dodawana);
                $_SESSION[$id . "_4"] = $nowa_cena_calkowita;
            }
        }

        else {  // jeżeli przedmiotu nie ma w koszyku i można go dodać
            $prod[$id][0] = $id;
            $prod[$id][1] = $product['product_name'];
            $prod[$id][2] = $ilosc_dodawana;
            $prod[$id][3] = CenaBrutto($product['net_price'], $product['vat']);
            $prod[$id][4] = "" . round(CenaBrutto($product['net_price'], $product['vat']) * $ilosc_dodawana, 2);
            $prod[$id][5] = "" . round($product['vat'], 2);

            for ($i = 0; $i < 6; $i++) {
                $_SESSION[$id . "_" . $i] = $prod[$id][$i];
            }

        }
        PodsumowanieKoszyka();
        unset($_SERVER['REQUEST_METHOD']);
        header('Refresh: 0');
    }

    function UsunZKoszyka() {
        $id = $_POST['id_przedmiotu'];
        $ilosc_odejmowana = $_POST['quanity'];
        $product = GetProdukt($id);

        if (!(isset($_SESSION[$id . "_0"]))) {  // jeżeli usuwamy z koszyka przedmiot, którego nie ma w koszyku
            echo "<div id='alert'><h1 id='alert_informacja'>Nie można usunąć przedmiotu </h1><h1 id='alert_przedmiot'>" . $product['product_name']  .  "</h1><h1 id='alert_informacja'> z koszyka!</h1></div>";
        }

        else {  // jeżeli usuwamy przedmiot z koszyka

            if ($ilosc_odejmowana >= $_SESSION[$id . "_2"]) {    // jeżeli usuwamy więcej przedmiotów niż jest w koszyku, to całkowicie usuwamy przedmiot z koszyka (zabezpieczenie)
                for ($i = 0; $i < 6; $i++) {
                    unset($_SESSION[$id . "_" . $i]);
                }
            }
            else {
                $_SESSION[$id . "_2"] = $_SESSION[$id . "_2"] - $ilosc_odejmowana;
                $_SESSION[$id . "_4"] = $_SESSION[$id . "_4"] - ($_SESSION[$id . "_3"] * $ilosc_odejmowana);
            }
        }
        PodsumowanieKoszyka();
        unset($_SERVER['REQUEST_METHOD']);
        header('Refresh: 0');
    }

    function PokazProduktZeSklepu () {
        require(__DIR__. '/cfg.php');
        $id = $_GET['details'];
        $query = "SELECT * FROM product_list WHERE id=:id LIMIT 1";
        $sth = $dbh->prepare($query);
        $sth->bindParam(':id', $id);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        while ($row = $sth->fetch()) {
            $check = ($row['availability'] == 1 ? true : false);
            echo ("
                <link rel='stylesheet' href='css/sklep.css'><script src='js/availability.js'></script>
                <div class='strony' style='width:90%;'>
                <div id='alert' style='justify-content:space-evenly;'>
                    <a href='?idp=sklep' id='dodaj' style='font-size:2vw;'>Powróć do sklepu</a>
                    <a href='?idp=sklep&koszyk' id='dodaj' style='font-size:2vw;'>Przejdź do koszyka</a>
                </div>
                <p id='dodaj' style='font-size:1.6vw;'><b>Szczegóły</b> produktu</p>
                <div class='tlo'>
                <div style='display: flex; flex-direction: column; align-items: stretch;'>

                <div class='wiersz'>
                    <div style='margin-right: 2%;'>
                    <label for='product_name' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Nazwa produktu</label><br/>
                    <textarea readonly type='text' name='product_name' id='product_name' placeholder='Nazwa produktu'>" . $row['product_name'] . "</textarea>
                    </div>
                    <div style='margin-left: 2%;'>
                    <label for='product_description' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Opis produktu</label>
                    <center><textarea readonly type='text' name='product_description' id='product_description' placeholder='Opis produktu' style='min-width:10%; max-width:99%;'>" . $row['product_description']."</textarea></center>
                    </div>
                </div>

                <div class='wiersz' style='align-items: center;'>
                    <label for='expiration_date' style='font-size:1.3vw;'>Data wygaśnięcia</label><br/>
                    <input readonly style='margin: 0; color:\"linen\";' type='datetime-local' name='expiration_date' id='expiration_date' value='".$row['expiration_date']."'>
                </div>

                <div class='wiersz'>
                    <div style='margin-right: 5%;'>
                        <label for='net_price' style='padding-top:5%; padding-bottom:1%; font-size:1.3vw;'>Cena netto</label><br/>
                        <textarea readonly style='padding: 0;' type='number' min='0.01' step='0.01' name='net_price' id='net_price' placeholder='Cena netto'>" . $row['net_price'] . " zł</textarea>
                    </div>
                    <div >
                        <label for='vat' style='padding-top:5%; padding-bottom:1%; font-size:1.3vw;'>VAT (%)</label><br/>
                        <textarea readonly style='padding: 0;' type='number' min='0' max='100' step='1' name='vat' id='vat' placeholder='VAT (%)'>" . ($row['vat'] - 1) * 100 . "%</textarea>
                    </div>
                    <div style='margin-left: 5%;'>
                        <label for='net_price' style='padding-top:5%; padding-bottom:1%; font-size:1.3vw;'>Cena brutto</label><br/>
                        <textarea readonly style='padding: 0;' type='number' min='0.01' step='0.01' name='net_price' id='net_price' placeholder='Cena brutto'>" . CenaBrutto($row['net_price'], $row['vat']) . " zł</textarea>
                    </div>
                </div>

                <div class='wiersz'>
                    <div style='margin-right: 2%;'>
                        <label for='category_select' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Kategoria produktu</label><br/>
                        <textarea readonly type='text' name='category_select' id='category_select' placeholder='Nazwa produktu' style='width:15vw;'>" . $row['category_id']
            );

            $second_query = "SELECT * FROM category_list WHERE id=:category_id LIMIT 100";
            $second_sth = $dbh->prepare($second_query);
            $second_sth->bindParam(":category_id", $row['category_id']);
            $second_sth->setFetchMode(PDO::FETCH_ASSOC);
            $second_sth->execute();
            $second_row = $second_sth->fetchAll();

            echo (  ' -> ' . $second_row[0]['name']. "</textarea></div>
                    <div style='margin-left: 2%;'>
                        <label for='size' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Gabaryty produktu</label><br/>
                        <textarea readonly type='text' name='category_select' id='category_select' placeholder='Gabaryty produktu'>" . $row['size'] . "</textarea>
                    </div>
                </div>
            ");
            if (!(empty($row['picture'])))
            {
                echo("
                    <label for='picture' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Zdjęcie produktu</label>
                    <center><img id='img' style='width: 150px;height: 150px' src=" . $row['picture'] . "></center>
                    <input style='display:none;' type='text' id='b64' name='base64_img' />
                ");
            }

            echo ("
                <hr style='width:50%;'>
                <div class='wiersz'>
                <div style='margin-right: 0%;'>
                    <label for='quanity' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Dostępna ilość:</label><br/>
                    <textarea readonly type='number' name='quanity' id='quanity' placeholder='Ilość'>" . $row['quanity'] . "</textarea>
                </div>
                <div style='display:flex; flex-direction: column; flex-wrap: wrap; align-items: center; margin-left: 7%;'>
                    <label for='availability' style='padding-bottom:1%; padding-top: 2%; font-size:1.3vw;'>Czy dostępny?</label>
                    <input readonly type='checkbox' name='availability' id='availability' style='height: 1vw; width: 1vw; align-self: center;' onclick=\"return false;\"". ($check ? 'checked' : "") . " >
                    <label id='availability_text' for='status' style='color:white;'>". ($check == 1 ? 'Tak' : "Nie") ."</label>
                    </div>
                </div>" .

                ((isset($_SESSION[$id . "_0"])) ?
                    "<div class='wiersz'>
                        <div>
                            <label for='quanity' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Ile masz w koszyku?</label><br/>
                            <textarea readonly type='number' name='quanity' id='quanity' placeholder='Ilość' style='margin-top:7%;'>" . $_SESSION[$id . "_2"] . "</textarea>
                        </div>
                    </div>"

                : "")

                .
                "<p id='dodaj' style='font-size:1.6vw;'><b>Dodaj</b> do koszyka</p>
                <form method='POST' style='background-color: rgba(136, 135, 135, 0.5); display: flex; justify-content: center; margin-top: 1%'>
                    <button id='dodaj_do_koszyka_plus' name='dodaj_do_koszyka' style='margin: 0; font-size: 1.5vw;' type='submit'>+</button>
                    <input type='number' min='1' step='1' value='1' name='quanity' id='quanity' style='margin: 0; width: 5vw;' placeholder='Ilość'>
                    <input style='display:none; ' type='text' name='id_przedmiotu' value=" . $row['id'] .  ">
                    <button id='usun_z_koszyka' name='usun_z_koszyka' style='margin: 0; font-size: 3vw;' type='submit id='dodaj_do_koszyka'>-</button>
                </form>
            ");

            echo ("
                <div id='przyciski'>
                <button id='przycisk' type='button' onclick=\"location.href='?idp=sklep'\" onMouseOver=\"this.style.fontWeight='bold'\" onMouseOut=\"this.style.fontWeight='normal'\">Wróć</button>
                <br></div></form></div></div>
            ");
        }
    }

    function WyswietlKoszyk() {
        require(__DIR__. '/cfg.php');
        $query = "SELECT * FROM product_list WHERE availability=1 LIMIT 100";
        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();

        echo '
                <link rel="stylesheet" href="css/sklep.css">
                <div class="strony" style="width:80%;">
                <p style="font-size:3vw;"><b>Koszyk</b></p>
                <hr style="width:40vw;">
                <div id="alert" style="justify-content:space-evenly;">
                    <a href="?idp=sklep" id="dodaj" style="font-size:1.6vw; margin-top:2%; margin-bottom:2%;">Wróc do sklepu</a>
                    <a href="koszyk_wyczysc.php" onclick="return confirm(\'Czy chcesz na pewno wszystkie przedmioty z koszyka?\')" id="usun_wszystko" style="font-size:1.6vw; margin-top:2%; margin-bottom:2%;">Usuń wszystko</a>
                </div>
                <hr style="width:40vw;">
                <div style="display: flex;flex-direction: row;justify-content: center;align-content: center;flex-wrap: wrap;">
            ';

        if ($sth->rowCount() > 0) { // jeżeli istnieją produkty
            while ($row = $sth->fetch()) {
                if (isset($_SESSION[$row['id'] . "_0"])) {
                    echo ("
                            <div style='display:flex;align-items:center;align-content: center;justify-content: space-around; width:80%; margin-top: 2%; margin-bottom: 2%;'>
                            <img height='150px' width='150px' src='" . $row['picture'] . "' /> <label class='kreska_przedmiotu'> | </label>
                            <label class='kolumna_przedmiotu'>Nazwa: <b>
                            <a id='nazwa_przedmiotu_do_przenoszenia' href='?idp=sklep&details=" . $row['id'] . "'>" . $row["product_name"] . "</a></b></label>
                            <label class='kreska_przedmiotu'> | </label><label class='kolumna_przedmiotu'>Cena za szt.:<b>" . $_SESSION[$row['id'] . "_3"] . " zł</b></label>
                            <label class='kreska_przedmiotu'> | </label><label class='kolumna_przedmiotu'>VAT produktu:<b>" . ($_SESSION[$row['id'] . "_5"] - 1) * 100 . " %</b></label>
                            <label class='kreska_przedmiotu'> | </label><label class='kolumna_przedmiotu'>Łączna suma:<b>" . $_SESSION[$row['id'] . "_4"] . " zł</b></label>
                            <label class='kreska_przedmiotu'> | </label><label class='kolumna_przedmiotu'>Ilość szt. w sklepie: <b>" . $row['quanity']. " </b></label>
                            <label class='kreska_przedmiotu'> | </label><label class='kolumna_przedmiotu'>Ilość szt. w koszyku: <b>" . $_SESSION[$row['id'] . "_2"]. " </b></label>
                            <label class='kreska_przedmiotu'> | </label><label class='kolumna_przedmiotu'>Czy można jeszcze dodać?: <b " . ($_SESSION[$row['id']. "_2"] < $row['quanity'] ? ("style='color: rgb(52, 216, 52);'>Tak") : ("style='color: rgb(255, 20, 60);'>Nie")) . "</b></label>
                            <label class='kreska_przedmiotu'> | </label>
                            <div class='kolumna_przedmiotu'>
                            <form method='POST' style='background-color: rgba(136, 135, 135, 0.5);'>
                                <button id='dodaj_do_koszyka' name='dodaj_do_koszyka' style='font-size: 1.5vw;'' type='submit'" . $row['id'] . "' id='dodaj_do_koszyka'>+</button>
                                <input type='number' min='1' step='1' value='1' name='quanity' id='quanity' placeholder='Ilość'>
                                <input style='display:none;' type='text' name='id_przedmiotu' value=" . $row['id'] .  ">
                                <button id='usun_z_koszyka' name='usun_z_koszyka' style='font-size: 1.5vw;' type='submit' id='dodaj_do_koszyka'>-</button>
                            </form>
                            <a href='?idp=sklep&details=" . $row['id'] . "
                            ' id='usun'> <b>Szczegóły</b></a>
                            </div>
                            </div>
                    ");
                }
            }
            PodsumowanieKoszyka();
            echo ("
                </div>

                <hr style='width:90%;'><br/>
                <label id='dodaj' style='font-size: 2vw;'>
                Łącznie <b>". $_SESSION['laczna_ilosc'] .
                "</b> przedmiotów w koszyku.</label>
                <br/>
                <label id='dodaj' style='font-size: 2vw;'>
                Łączna suma: <b>". $_SESSION['laczna_cena_brutto'] .
                "</b> zł.</label>

                <form method='POST'>
                    <button id='zamow' name='zamow' type='submit' id='zamow'>Złóż zamówienie</button>
                </form>

                </div>
            ");
        }
        else {
            echo "Brak wyników";
        }

    }

    function ListaProduktów()
    {
        require(__DIR__. '/cfg.php'); // wymagany jest plik konfiguracyjny łączący z bazą danych

        $niedostepne = 'Pokaż niedostępne przedmioty';
        $query = "SELECT * FROM product_list WHERE availability=1 LIMIT 100";

        if (isset($_SESSION['pokaz_niedostepne'])) {
            if ($_SESSION['pokaz_niedostepne']) {
                $query = "SELECT * FROM product_list LIMIT 100";
                $niedostepne = 'Ukryj niedostępne przedmioty';
            }
        }

        $sth = $dbh->prepare($query);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();

        echo '
                <link rel="stylesheet" href="css/sklep.css">
                <div class="strony" style="width:80%;">
                <div id="alert" style="justify-content:space-evenly;">
                <a href="?idp=sklep&koszyk" id="dodaj" style="font-size:1.6vw; margin-bottom:2%;">Przejdź do koszyka</a>
                <a href="koszyk_redirect.php" id="dodaj" style="font-size:1.6vw; margin-bottom:2%;">' . $niedostepne . '</a>
                </div>
                <hr style="width:40vw;">
                <div style="display: flex;flex-direction: row;justify-content: center;align-content: center;flex-wrap: wrap;">

            ';

        if ($sth->rowCount() > 0) { // jeżeli istnieją produkty
            while ($row = $sth->fetch()) { // iteracja zmienną $row po produktach
                echo ("
                        <div style='display:flex;align-items:center;align-content: center;justify-content: space-around; width:80%; margin-top: 2%; margin-bottom: 2%;'>
                        <img height='150px' width='150px' src='" . $row['picture'] . "' /> <label class='kreska_przedmiotu'> | </label>
                        <label class='kolumna_przedmiotu'>Nazwa: <b>
                        <a id='nazwa_przedmiotu_do_przenoszenia' href='?idp=sklep&details=" . $row['id'] . "'>" . $row["product_name"] . "</a></b></label>
                        <label class='kreska_przedmiotu'> | </label><label class='kolumna_przedmiotu'>Cena: <b>" . round($row['net_price'] * $row['vat'], 2) . " zł</b></label>
                        <label class='kreska_przedmiotu'> | </label><label class='kolumna_przedmiotu'>Ilość szt.: <b>" . $row['quanity']. " </b></label>
                        <label class='kreska_przedmiotu'> | </label><label class='kolumna_przedmiotu'>Dostępność: <b " . ($row['availability'] == 1 ? ("style='color: rgb(52, 216, 52);'>Jest dostępny") : ("style='color: rgb(255, 20, 60);'>Nie jest dostępny")) . "</b></label>
                        " .
                        ((isset($_SESSION[$row['id']. "_0"])) ? "<label class='kreska_przedmiotu'> | </label><label class='kolumna_przedmiotu'>Czy można jeszcze dodać?: <b " . ($_SESSION[$row['id']. "_2"] < $row['quanity'] ? ("style='color: rgb(52, 216, 52);'>Tak") : ("style='color: rgb(255, 20, 60);'>Nie")) . "</b></label>" : '')

                        . "
                        <label class='kreska_przedmiotu'> | </label>
                        <div class='kolumna_przedmiotu'>
                        <form method='POST'>
                        <button id='dodaj_do_koszyka' name='dodaj_do_koszyka' type='submit'" . $row['id'] . "' id='dodaj_do_koszyka'>Dodaj do koszyka</button>
                        <hr style='width:50%;'>
                        <input type='number' min='1' step='1' value='1' name='quanity' id='quanity' placeholder='Ilość'>
                        <input style='display:none;' type='text' name='id_przedmiotu' value=" . $row['id'] .  ">
                        </form>
                        <hr style='width:50%;'>
                        <a href='?idp=sklep&details=" . $row['id'] . "
                        ' id='dodaj_do_koszyka'> <b>Szczegóły</b></a>
                        </div>
                        </div>
                    ");
            }
            echo ("</div></div>");

        } else {
            echo "Brak wyników";
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (isset($_POST['dodaj_do_koszyka'])) {
            DodajDoKoszyka();
        }
        elseif (isset($_POST['usun_z_koszyka']))
        {
            UsunZKoszyka();
        }
        elseif (isset($_POST['zamow'])) {
            ZlozZamowienie();
            echo "<script> window.location.href='?idp=sklep';</script>";
        }
    }

    if ($_GET['idp'] == 'sklep' && !(isset($_GET['koszyk'])) && !(isset($_GET['details']))) {
        ListaProduktów();
    }
    elseif (isset($_GET['koszyk'])) {
        WyswietlKoszyk();
    }
    elseif (isset($_GET['details'])) {
        PokazProduktZeSklepu();
    }

?>