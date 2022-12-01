<?php

    require_once '../cfg.php';
    session_start();
    function FormularzLogowania() {
        $wynik = '
        <div class="logowanie">
        <h1 class="heading">Panel CMS:</h1>
        <div class="logowanie">
        <form method="post" name="LoginForm" enctype="multipart/form-data" action="'.$_SERVER['REQUEST_URI'].'">
            <table class="logowanie">
                <tr><td class="log4_t">E-mail:</td><td><input type="text" name="login_email" class="logowanie" /></td></tr>
                <tr><td class="log4_t">Hasło:</td><td><input type="password" name="login_pass" class="logowanie" /></td></tr>
                <tr><td>&nbsp;</td><td><input type="submit" name="x1_submit" class="logowanie" value="Zaloguj" /></td></tr>
            </table>
        </form>
        </div>
        </div>
        ';

        if(isset($_POST['login_email']) || isset($_POST['login_pass'])) {
            $_SESSION['login'] = $_POST['login_email'];
            $_SESSION['password'] = $_POST['login_pass'];
        }

        return $wynik;
    }

    echo FormularzLogowania();

    if(isset($_SESSION['login'])) {
        if($_SESSION['login'] === $login && $_SESSION['password'] === $pass) {
            $_SESSION['auth'] = True;
            echo($_SESSION['auth']);
            header('Location: ./admin_panel.php');
        }
    }

    if(isset($_SESSION['login'])) {
        if (!($_SESSION['login'] === $login && $_SESSION['password'] === $pass)) {
            echo('Podano błędne dane logowania');
        }
    }

?>