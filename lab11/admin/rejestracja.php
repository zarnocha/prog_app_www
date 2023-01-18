<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL); 
    require(dirname(__DIR__, 1). '/cfg.php');

    // Funkcja FormularzRejestracji() wyświetla formularz rejestracji nowego użytkownika, 
    // który do zmiennych $_POST['register_email'] oraz $_POST['register_pass'] zapisuje e-mail oraz hasło wprowadzone przez użytkownika 
    // do weryfikacji i przesłania do bazy danych. 

    function FormularzRejestracji() {
        $register_form = '
            <link rel="stylesheet" href="css/admin.css">
            <div class="panel">
            <div class="logowanie">
            <form method="post" name="LoginForm" enctype="multipart/form-data">
            <table class="logowanie" style="display:grid">
            <h1 class="heading">Panel rejestracji:</h1>
                <tr>
                <td class="labele"><label for="register_email">Twój e-mail:</label></td><td><input id="register_email" type="text" name="register_email" class="logowanie"></td>
                </tr>
                <tr>
                    <td class="labele"><label for="register_pass">Twoje hasło:</label></td><td><input id="register_pass" type="password" name="register_pass" class="logowanie"></td>
                </tr>
                <tr class="przyciski_logowanie">
                    <td><input type="submit" name="x1_submit" class="logowanie" value="Zarejestruj"></td>
                    <td><button><a class="logowanie" href="?idp=login">Przejdź do panelu logowania</a></button></td>
                </tr>
            </table>
            </form>
            </div>
            </div>
        ';
        
        return $register_form;
    }

    if(isset($_POST['register_email']) || isset($_POST['register_pass'])) {   // jeżeli formularz został wypełniony i zatwierdzony, to dane logowania przypisywane są do zmiennych sesji
        $login = $_POST['register_email'];
        
        $password = $_POST['register_pass'];

        $options = [
            'cost' => 11,
        ];
        
        $password = password_hash($password, PASSWORD_BCRYPT, $options);

        $query = "INSERT INTO accounts (email, password) VALUES (:login, :password)";
        $sth = $dbh->prepare($query);
        $sth->bindValue(':login', $login);
        $sth->bindValue(':password', $password);
        $sth->execute();

        $_SESSION['registered'] = true;
    }

    if (isset($_SESSION['registered']) && $_SESSION['registered'] === true) {
        unset($_SESSION['registered']);
        // header('Location: ?idp=login');
        echo "<script> window.location.href='?idp=login';</script>";
    }
    
?>