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
                <link rel="stylesheet" href="css/admin.css">
                <div class="strony">
                <label style="padding-top:2%; padding-bottom:1%; font-size:1.6vw;"><b>' . $akcja . 
                '</b> podstrony powiodło się!</label>
                </div>
            ');
            $_SESSION['success'] = false;   // po wyświetleniu komunikatu o pomyślnym ukończeniu akcji nie chcemy wyświetlać jej ponownie
            unset($akcja);  // zabezpieczenie, aby przypadkiem nie wyświetlił się komunikat gdy nie wykonano żadnej akcji
        }
        
        // Funkcja ListaPodstron() zwraca listę zawierającą podstrony pobrane z bazy danych. Pobiera ona konfigurację połączenia z pliku cfg.php, 
        // następnie wykonuje kwerendę do bazy aby dostać z powrotem podstrony do zmiennej $result.
        // Kolejno za pomocą polecenia echo wyświetlam div'a z podstronami.
        
        function ListaPodstron() {
            require(dirname(__DIR__, 1). '/cfg.php');   // wymagany jest plik konfiguracyjny łączący z bazą danych

            $query = "SELECT * FROM page_list LIMIT 100";
            $sth = $dbh->prepare($query);
            $sth->setFetchMode(PDO::FETCH_ASSOC);
            $sth->execute();
    
            echo('
                <link rel="stylesheet" href="css/admin.css">
                <div class="strony">
                <a href="?idp=panel_cms" id="dodaj" style="font-size:1.6vw; margin-bottom:10%;">Powróć do panelu CMS</a><br/><br/>
                <a href="?idp=panel_cms&podstrony&add" id="dodaj" style="font-size:1.6vw; margin-bottom:10%;">Dodaj podstronę</a><br/><br/>
                <hr style="width:30vw;"><br/>
                ');
           
            if ($sth->rowCount() > 0) {
                while ($row = $sth->fetch()) {
                    
                    echo("<p>
                    id: <b>" . $row["id"] . 
                    "</b><label class='kreska'> | </label> tytuł: <b>" . $row["page_title"] . 
                    "</b><label class='kreska'> | </label> status: <b>" . $row['status'] . 
                    "</b><label class='kreska'> | </label> <a href='?idp=panel_cms&podstrony&edit=" . $row['id'] . "
                    ' id='edytuj'> <b>Edytuj</b></a>" . "<label class='kreska'> | </label> <a href='?idp=panel_cms&podstrony&del=" . $row['id'] . "
                    ' id='usun' onMouseOver=this.style.color='rgb(255,20,60)' onMouseOut=this.style.color='rgb(255,255,255)'> <b>Usuń</b></a><br><br></p>"
                    );
                }
                echo ("</div>");
            
            } else {
                echo "Brak wyników";
            }

        }


        if (isset($_GET['add'])) {  // jeżeli chcemy wykonać dodawanie podstrony - ustawiona jest zmienna 'add' w linku - wykonuje się ta część kodu
            
            require(dirname(__DIR__, 1). '/cfg.php');

            $id = $_GET['add'];
            // To echo wygląda w ten sposób, ponieważ nie działało przekierowywanie przez header('Location:')
            echo("
                <link rel='stylesheet' href='css/admin.css'><script src='js/checkbox.js'></script><div class='strony'><div class='logowanie'><form style='display: flex; flex-direction: column; align-items: stretch;' method='post'><label for='page_title' style='padding-bottom:1%; font-size:1.3vw;'>Status strony</label><input type='checkbox' checked='checked' name='status' id='status' style='height: 1vw; width: 1vw; align-self: center;' onclick=\"isCheckboxChecked()\"><label id='status_label' for='status' style='color:white;'>Aktywna </label><label for='page_title' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Tytuł strony</label><input type='text' name='page_title' id='page_title' placeholder='Tytuł strony'><label for='page_content' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Kod strony</label><center><textarea type='text' name='page_content' id='page_content' placeholder='Treść strony (HTML)' style='min-width:10%; max-width:99%;'></textarea></center><label for='alias' style='padding-top:2%; padding-bottom:1%; font-size:1.3vw;'>Alias</label><input type='text' name='alias' id='alias' placeholder='Alias strony'><div id='przyciski_logowanie'><button id='edit_button' type='submit' formaction='?idp=panel_cms&podstrony' style='margin-top:4%;' onMouseOver=\"this.style.fontWeight='bold'\" onMouseOut=\"this.style.fontWeight\'normal\'\")>Wróć</button><button id='edit_button' type='submit' name='save' style='margin-top:2%;' onMouseOver=\"this.style.color='rgb(0,165,0)'; this.style.fontWeight='bold'\" onMouseOut=\"this.style.color='rgb(0,0,0)'; this.style.fontWeight='normal'\")>Dodaj</button><br></div></form></div></div>'");

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {    // jeżeli przesyłamy formularz - wykonuje się ta część kodu

                require(dirname(__DIR__, 1). '/cfg.php'); 

                $page_title = $_POST['page_title'];
                $page_content = $_POST['page_content'];
                $alias = $_POST['alias'];

                $status = 0;
                    if (isset($_POST['status'])) {
                        $status = 1;
                    }
                    else {
                        $status = 0;
                    }

                $query = "INSERT INTO page_list (page_title, page_content, status, alias) VALUES (:page_title, :page_content, :status, :alias)";
                $sth = $dbh->prepare($query);
                $sth->bindParam(':page_title', $page_title);
                $sth->bindParam(':page_content', $page_content);
                $sth->bindParam(':status', $status);
                $sth->bindParam(':alias', $alias);
                $sth->setFetchMode(PDO::FETCH_ASSOC);
                $sth->execute();

                $_SESSION['success'] = true;
                $_SESSION['action'] = 'add';
                header('Location: ?idp=panel_cms&podstrony');
            }

        }

        if (isset($_GET['edit'])) { // jeżeli chcemy wykonać edycję podstrony - ustawiona jest zmienna 'edit' w linku - wykonuje się ta część kodu
            
            require(dirname(__DIR__, 1). '/cfg.php');
            
            $id = $_GET['edit'];
            $query = "SELECT * FROM page_list WHERE id=:id LIMIT 1";
            $sth = $dbh->prepare($query);
            $sth->bindParam(':id', $id);
            $sth->setFetchMode(PDO::FETCH_ASSOC);
            $sth->execute();

            while ($row = $sth->fetch()) {
                
                $check = true;
                if ($row['status'] == 0) {
                    $check = false;
                }

                echo("
                    <script src='js/checkbox.js'></script>
                    <div class='strony'>
                    <form style='display: flex; flex-direction: column; align-items: stretch;' method='post'>
                    <label for='page_title' style='padding-bottom:1%; font-size:1.3vw;'>Status strony</label>
                ");

                if ($check) {
                    echo("<input type='checkbox' checked name='status' id='status' style='height: 1vw; width: 1vw; align-self: center;' onclick='isCheckboxChecked()'><label id='status_label' for='status' style='color:white;'>Aktywna</label>");
                }
                else {
                    echo("<input type='checkbox' name='status' id='status' onclick='isCheckboxChecked()' style='height: 1vw; width: 1vw; align-self: center;'><label id='status_label' for='status' style='color:white;'>Nieaktywna </label>");
                }
                
                $page_content = $row['page_content'];
                $page_content = htmlspecialchars($page_content);    // sprawia to, że kod ze znacznikami HTML nie wykonują się
                 
                echo ('
                    <link rel="stylesheet" href="css/admin.css">
                    <label for="id" style="padding-top:2%; padding-bottom:1%; font-size:1.3vw;">ID</label>
                    <input type="number" name="id" id="id" disabled value="' . $row['id'] . 
                    '">
                    <label for="page_title" style="padding-top:2%; padding-bottom:1%; font-size:1.3vw;">Tytuł strony</label>
                    <input type="text" name="page_title" id="page_title" placeholder="Tytuł" value="' . $row['page_title'] . 
                    '">
                    <label for="page_content" style="padding-top:2%; padding-bottom:1%; font-size:1.3vw;">Kod strony</label>
                    <center><textarea type="text" name="page_content" id="page_content" placeholder="Treść" style="min-width:10%; max-width:99%;">' . $page_content . 
                    '</textarea></center>
                    <label for="alias" style="padding-top:2%; padding-bottom:1%; font-size:1.3vw;">Alias</label>
                    <input type="text" name="alias" id="alias" placeholder="Alias" value=' . $row['alias'] . '><div id="przyciski_logowanie"><button id="edit_button" type="submit" formaction="?idp=panel_cms&podstrony" style="margin-top:4%;" onMouseOver="this.style.fontWeight=\'bold\'" onMouseOut="this.style.fontWeight=\'normal\'")>Wróć</button><button id="edit_button" type="submit" name="save" style="margin-top:2%;" onMouseOver="this.style.color=\'rgb(0,165,0)\'; this.style.fontWeight=\'bold\'" onMouseOut="this.style.color=\'rgb(0,0,0)\'; this.style.fontWeight=\'normal\'">Zapisz</button></form></div></div>');

            }
                
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {    // jeżeli przesyłamy formularz - wykonuje się ta część kodu
               
                require_once(dirname(__DIR__, 1). '/cfg.php');

                $page_title = $_POST['page_title'];
                $page_content = $_POST['page_content'];
                $alias = $_POST['alias'];
                    
                $status = 0;

                if (isset($_POST['status'])) {
                    $status = 1;
                }
                else {
                    $status = 0;
                }


                $query = "UPDATE page_list SET page_title=:page_title, page_content=:page_content, status=:status, alias=:alias WHERE id=$id LIMIT 1";
                $sth = $dbh->prepare($query);
                $sth->bindParam(':page_title', $page_title);
                $sth->bindParam(':page_content', $page_content);
                $sth->bindParam(':status', $status);
                $sth->bindParam(':alias', $alias);
                $sth->execute();
                    
                $_SESSION['success'] = true;
                $_SESSION['action'] = 'edit';

                header('Location: ?idp=panel_cms');
            }
        }

    if (isset($_GET['del'])) { // jeżeli chcemy usunąć podstronę - ustawiona jest zmienna 'del' w linku - wykonuje się ta część kodu
        require(dirname(__DIR__, 1) . '/cfg.php');
        $id = $_GET['del'];
        // mysqli_query($link, "DELETE FROM page_list WHERE id=:id LIMIT 1");
        // $sth = $dbh->prepare($query);
        // $sth->bindParam(':id', $id);
        // $sth->execute();

        $query = "SELECT * FROM page_list WHERE id=:id LIMIT 1";
        $sth = $dbh->prepare($query);
        $sth->bindParam(':id', $id);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();

        while ($row = $sth->fetch()) {
            echo ('
                <link rel="stylesheet" href="css/admin.css">
                <div class="strony">
                <div class="logowanie">
                <form style="display: flex; flex-direction: column; align-items: stretch;" method="post">
                <label style="padding-bottom:1%; font-size:1.6vw;">Czy na pewno chcesz usunąć podstronę poniżej?</label>
                <label for="page_content" style="padding-top:2%; padding-bottom:1%; font-size:1.3vw;">Tytuł strony</label>
                <input type="text" name="page_title" id="page_title" readonly value=' . $row['page_title'] . '>
                <label for="page_content" style="padding-top:2%; padding-bottom:1%; font-size:1.3vw;">Kod podstrony</label>
                <center><textarea type="text" name="page_content" id="page_content" readonly style="min-width:10%; max-width:99%;" value=' . $row['page_content'] .  '></textarea></center>
                <label for="alias" style="padding-top:2%; padding-bottom:1%; font-size:1.3vw;">Alias</label>
                <input type="text" name="alias" id="alias" readonly value=' . $row['alias'] . '>
                <div id="przyciski_logowanie">
                <button id="edit_button" type="submit" formaction="?idp=panel_cms&podstrony" style="margin-top:4%;" onMouseOver="this.style.fontWeight=\'bold\'" onMouseOut="this.style.fontWeight=\'normal\'">Wróć</button>
                <button id="edit_button" name="del_button" type="submit" style="margin-top:4%;" onMouseOver="this.style.color=\'rgb(255,20,60)\'; this.style.fontWeight=\'bold\'" onclick="return confirm(\'Czy chcesz na pewno usunąć kategorię?\')" onMouseOut="this.style.color=\'rgb(0,0,0)\'; this.style.fontWeight=\'normal\'">Usuń</button></br>
                </div>
                </form>
                </div>
                </div>
            ');
            
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $query = "DELETE FROM page_list WHERE id=:id LIMIT 1";
            $sth = $dbh->prepare($query);
            $sth->bindParam(':id', $id);
            $sth->execute();
            $_SESSION['success'] = true;
            $_SESSION['action'] = 'del';
            header('Location: ?idp=panel_cms');
            
        }
    }


    if (!(isset($_GET['add']) || isset($_GET['edit']) || isset($_GET['del'])))  // podstrony wyświetlą się tylko jeżeli nie będziemy w podstronie "edytującej" daną podstronę. 
        ListaPodstron();    // wyświetlanie podstron funkcją
    
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
