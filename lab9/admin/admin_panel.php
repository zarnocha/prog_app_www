<?php
    error_reporting(E_ALL);
    ini_set('display_errors','On');

    if ($_SESSION['auth'] === True) {   // weryfikacja, czy użytkownik jest zalogowany, aby mieć dostęp do CMS

        // Funkcja ListaPodstron() zwraca listę zawierającą podstrony pobrane z bazy danych. Pobiera ona konfigurację połączenia z pliku cfg.php, 
        // następnie wykonuje kwerendę do bazy aby dostać z powrotem podstrony do zmiennej $result.
        // Kolejno za pomocą polecenia echo wyświetlam div'a z podstronami.

        function ListaPodstron() {
            require(dirname(__DIR__, 1). '/cfg.php');   // wymagany jest plik konfiguracyjny łączący z bazą danych
            $sql = "SELECT * FROM page_list LIMIT 100";
            $result = $link->query($sql);
    
            echo('<link rel="stylesheet" href="css/admin.css">
                    <div class="strony">');
            echo("<a href='?idp=admin_panel&add' id='dodaj' style='font-size:1.3vw; margin-bottom:10%;'>Dodaj stronę</a><br/><br/>");
           
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    
                    echo "id: " . $row["id"] . "<label class='kreska'> | </label> tytuł: " . $row["page_title"] . "<label class='kreska'> | </label> status: " . $row['status'] . "<label class='kreska'> | </label> <a href='?idp=admin_panel&edit=" . $row['id'] . "' id='edytuj'> <b>Edytuj</b></a>" . "<label class='kreska'> | </label> <a href='?idp=admin_panel&del=" . $row['id'] . "' id='usun'" . "onclick='return confirm('Usunąć?')>" . " <b>Usuń</b></a><br><br>";
                
                }   // TODO: REMOVING ONCLICK RETURN CONFIRM
                echo ("</div>");
            
            } else {
                    echo "Brak wyników";
            }

        }


        if (isset($_GET['add'])) {  // jeżeli chcemy wykonać dodawanie podstrony - ustawiona jest zmienna 'add' w linku - wykonuje się ta część kodu
            
            require(dirname(__DIR__, 1). '/cfg.php');

            $id = $_GET['add'];
            
            echo('<link rel="stylesheet" href="css/admin.css">');
            echo('<div class="strony">');
            echo('<div class="logowanie">
                 <form style="display: flex; flex-direction: column; align-items: stretch;" method="post">');

            echo("<input type='checkbox' checked='checked' name='status' id='status' style='height: 1vw; width: 1vw; align-self: center;'><label for='status' style='color:white;'>Aktywna </label>");

            echo ('<label for="page_title" style="padding-top:2%; padding-bottom:1%; font-size:1.3vw;">Tytuł strony</label>');
            echo("<input type='text' name='page_title' id='page_title' placeholder='Tytuł'>");
 
            echo ('<label for="page_content" style="padding-top:2%; padding-bottom:1%; font-size:1.3vw;">Kod strony</label>');
            echo("<textarea type='text' name='page_content' id='page_content' placeholder='Treść'></textarea>");
                 
            echo ('<label for="alias" style="padding-top:2%; padding-bottom:1%; font-size:1.3vw;">Alias</label>');
            echo("<input type='text' name='alias' id='alias' placeholder='Alias'>");
 
            echo('<button id="edit_button" onclick="refresh_diva()" type="submit" name="save" style="margin-top:2%;")>Dodaj</button><br>');
            echo("</form>
                <hr style='width:30vw;'><br/>
                </div>
                </div>");

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {    // jeżeli przesyłamy formularz - wykonuje się ta część kodu

                require(dirname(__DIR__, 1). '/cfg.php'); 
                $page_title = $_POST['page_title'];
                $page_content = $_POST['page_content'];
                // $page_content = htmlspecialchars($page_content);

                $status = 0;
                    if (isset($_POST['status'])) {
                        $status = 1;
                    }
                    else {
                        $status = 0;
                    }

                $alias = $_POST['alias'];
                mysqli_query($link, "INSERT INTO page_list (page_title, page_content, status, alias) VALUES ( '$page_title', '$page_content', '$status', '$alias');");
                $_SESSION['success'] = 1;
                header('Location: ?idp=admin_panel');

            }

        }

        if (isset($_GET['edit'])) { // jeżeli chcemy wykonać edycję podstrony - ustawiona jest zmienna 'edit' w linku - wykonuje się ta część kodu
            
            require(dirname(__DIR__, 1). '/cfg.php');
            
            $id = $_GET['edit'];
            $record = mysqli_query($link, "SELECT * FROM page_list WHERE id=$id LIMIT 1");
                        
            foreach ($record as $row) {
                
                $check = true;
                if ($row['status'] == 0) {
                    $check = false;
                }

                echo("<div class='strony'>
                        <form style='display: flex; flex-direction: column; align-items: stretch;' method='post'>
                ");

                if ($check) {
                    echo("<input type='checkbox' checked name='status' id='status' style='height: 1vw; width: 1vw; align-self: center;' ><label for='status' style='color:white;'>Aktywna </label>");
                }

                else {
                    echo("<input type='checkbox' name='status' id='status' style='height: 1vw; width: 1vw; align-self: center;''><label for='status' style='color:white;'>Aktywna </label>");
                }
                
                $page_content = $row['page_content'];
                $page_content = htmlspecialchars($page_content);

                echo ('<label for="id" style="padding-top:2%; padding-bottom:1%; font-size:1.3vw;">ID</label>');
                echo("<input type='number' name='id' id='id' disabled value=" . $row['id'] . ">");

                echo ('<label for="page_title" style="padding-top:2%; padding-bottom:1%; font-size:1.3vw;">Tytuł strony</label>');
                echo("<input type='text' name='page_title' id='page_title' placeholder='Tytuł' value=" . $row['page_title'] . ">");

                echo ('<label for="page_content" style="padding-top:2%; padding-bottom:1%; font-size:1.3vw;">Kod strony</label>');
                echo("<textarea type='text' name='page_content' id='page_content' placeholder='Treść'>" . $page_content . "</textarea>");
                
                echo ('<label for="alias" style="padding-top:2%; padding-bottom:1%; font-size:1.3vw;">Alias</label>');
                echo("<input type='text' name='alias' id='alias' placeholder='Alias' value=" . $row['alias'] . ">");
                
                echo("<button id='edit_button' type='submit' name='save' style='margin-top:2%;'>Zapisz</button><br>");
                echo("</form>
                <hr style='width:30vw;'><br/>
                </div>");
            }
                
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {    // jeżeli przesyłamy formularz - wykonuje się ta część kodu
                    
                    require_once(dirname(__DIR__, 1). '/cfg.php'); 
                    $page_title = $_POST['page_title'];
                    $page_content = $_POST['page_content'];
                    
                    $status = 0;

                    if (isset($_POST['status'])) {
                        $status = 1;
                    }
                    else {
                        $status = 0;
                    }

                    $alias = $_POST['alias'];

                    mysqli_query($link, "UPDATE page_list SET page_title='$page_title', page_content='$page_content', status='$status', alias='$alias' WHERE id=$id LIMIT 1");
                    $_SESSION['success'] = 1;
                    header('Location: ?idp=admin_panel');
                }
        }

        if (isset($_GET['del'])) {  // jeżeli chcemy usunąć podstronę - ustawiona jest zmienna 'del' w linku - wykonuje się ta część kodu
            require(dirname(__DIR__, 1). '/cfg.php');
            $id = $_GET['del'];
            mysqli_query($link, "DELETE FROM page_list WHERE id=$id LIMIT 1");
            $_SESSION['success'] = 1;
            header('Location: ?idp=admin_panel');
        }
    }

    else {  // wykonuje się, gdy osoba nie ma dostępu do panelu CMS
        echo('
            <link rel="stylesheet" href="css/admin.css">
            <div class="logowanie">
                <h1 class="brak_autoryzacji">Nie uzyskano autoryzacji!</h1>
                <button><a class="logowanie" href="?idp=admin">Przejdź do panelu logowania</a></button>
            </div>
        ');
    }

    ListaPodstron();    // wyświetlanie podstron funkcją
?>