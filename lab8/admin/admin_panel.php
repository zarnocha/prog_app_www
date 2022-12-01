<?php

    session_start();
    require_once('../cfg.php');
    if ($_SESSION['auth'] === True) {
        function ListaPodstron() {
            include("../cfg.php");
            $sql = "SELECT * FROM page_list LIMIT 100";
            $result = $link->query($sql);
            
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "id: " . $row["id"] . " - tytuł: " . $row["page_title"] . " - status: " . $row['status'] . "<a href='?edit=" . $row['id'] . "' class='edit_btn'> Edytuj</a>" . "<a href='?del=" . $row['id'] . "' class='del_btn'> Usuń</a><br><br>";
                }

                echo("<a href='?add=0'class='add_btn'>Dodaj stronę</a><br/>");
            
            } else {
                    echo "Brak wyników";
            }

            $link->close();
        }

        ListaPodstron();

        if (isset($_GET['add'])) {
            include("../cfg.php");
            $id = $_GET['add'];
            $update = true;
            echo("<form method='post'>");
            echo("<input type='checkbox' checked='checked' name='status' id='status'> Aktywna ");
            echo("<input type='number' name='id' id='id' disabled placeholder='id'>");
            echo("<input type='text' name='page_title' id='page_title' placeholder='Tytuł'>");
            echo("<textarea type='text' name='page_content' id='page_content' placeholder='Treść'>" . $row['page_content'] . "</textarea>");
            echo("<input type='text' name='alias' id='alias' placeholder='Alias'>");
            echo("<button class='btn' type='submit' name='save' >Dodaj</button><br>");
            echo("</form>");

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
                mysqli_query($link, "INSERT INTO page_list (page_title, page_content, status, alias) VALUES ( '$page_title', '$page_content', '$status', '$alias');");
                header('Location: ./admin_panel.php');
            }
        }

        if (isset($_GET['edit'])) {
            include("../cfg.php");
            $id = $_GET['edit'];
            $update = true;
            $record = mysqli_query($link, "SELECT * FROM page_list WHERE id=$id LIMIT 1");
                        
            foreach ($record as $row) {
                $check = true;
                if ($row['status'] == 0) {
                    $check = false;
                }
                echo("<form method='post'>");
                if ($check) {
                    echo("<input type='checkbox' checked name='status' id='status'> Aktywna ");
                }
                else {
                    echo("<input type='checkbox' name='status' id='status'> Aktywna ");

                }

                echo("<input type='number' name='id' id='id' disabled value=" . $row['id'] . "> ");
                echo("<input type='text' name='page_title' id='page_title' placeholder='Tytuł' value=" . $row['page_title'] . ">");
                echo("<textarea type='text' name='page_content' id='page_content' placeholder='Treść'>" . $row['page_content'] . "</textarea>");
                echo("<input type='text' name='alias' id='alias' placeholder='Alias' value=" . $row['alias'] . ">");
                echo("<button class='btn' type='submit' name='save'>Zapisz</button><br>");
                echo("</form>");

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
                    echo($status);
                    mysqli_query($link, "UPDATE page_list SET page_title='$page_title', page_content='$page_content', status='$status', alias='$alias' WHERE id=$id LIMIT 1");
                    header('Location: ./admin_panel.php');
                }
            }
        }

        if (isset($_GET['del'])) {
            include("../cfg.php");
            $id = $_GET['del'];
            mysqli_query($link, "DELETE FROM page_list WHERE id=$id LIMIT 1");
            header('Location: ./admin_panel.php');
        }
                    
        echo('<br/><button><a href="./logout.php">Wyloguj się</a></button>');
        
    }

    else {
        echo('<h1>Nie uzyskano autoryzacji</h1>');
        echo('<button><a href="./admin.php">Przejdź do panelu logowania</a></button>');
    }

?>