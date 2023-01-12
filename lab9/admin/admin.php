<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
    require(dirname(__DIR__, 1). '/cfg.php');
    session_start();

    // Funkcja FormularzLogowania() wyświetla formularz logowania do panelu CMS, 
    // który do zmiennych $_POST['login_email'] oraz $_POST['login_pass'] zapisuje e-mail oraz hasło wprowadzone przez użytkownika 
    // do weryfikacji i przekierowania dalej. 

    function FormularzLogowania() {
        $login_form = '
            <link rel="stylesheet" href="css/admin.css">
            <div class="panel">
            <div class="logowanie">
            <form method="post" name="LoginForm" enctype="multipart/form-data" action="admin/admin.php">
            <table class="logowanie" style="display:grid">
            <h1 class="heading">Panel CMS:</h1>
                <tr><td class="labele"><label for="login_email">E-mail:</label></td><td><input id="login_email" type="text" name="login_email" class="logowanie" /></td></tr>
                <tr><td class="labele"><label for="login_pass">Hasło:</label></td><td><input id="login_pass" type="password" name="login_pass" class="logowanie" /></td></tr>
                <tr class="przyciski_logowanie"><td><input type="submit" name="x1_submit" class="logowanie" value="Zaloguj"></td>
                <td><input type="submit" name="przywroc_haslo" formaction="?idp=przypomnij_haslo" class="logowanie" value="Przypomnij hasło" /></td></tr></table></div></div>
            </form>
        ';
        
        return $login_form;
    }

    if(isset($_POST['login_email']) || isset($_POST['login_pass'])) {   // jeżeli formularz został wypełniony i zatwierdzony, to dane logowania przypisywane są do zmiennych sesji
        $_SESSION['login'] = $_POST['login_email'];
        $_SESSION['password'] = $_POST['login_pass'];
    }

    if(isset($_SESSION['login'])) { // jeżeli jest przypisana zmienna sesji 'login' i zgadza się ona wraz z hasłem z danymi logowania => zmienna weryfikacyjna sesji jest ustawiona na True, 
                                    // co oznacza, że użytkownik jest zalogowany.
        if($_SESSION['login'] === $login && $_SESSION['password'] === $pass) {
            $_SESSION['auth'] = True;
            header('Location: http://'. $_SERVER['HTTP_HOST'] . '/'. basename(dirname(__DIR__)) . '?idp=admin_panel');  // przeniesienie użytkownika z panelu logowania do admin panelu
        }
    }

    if(isset($_SESSION['login'])) {
        if (!($_SESSION['login'] === $login && $_SESSION['password'] === $pass)) {  // jeżeli login bądź hasło jest nieprawidłowe - wykonujemy ten kod (zmienna sesji 'auth' ustawiana jest na False - użytkownik niezalogowany).
            unset($_SESSION['login']);
            unset($_SESSION['password']);
            $_SESSION['auth'] = False;
            header('Location: http://'. $_SERVER['HTTP_HOST'] . '/'. basename(dirname(__DIR__)) . '/?idp=admin_panel');
        }
    }


?>