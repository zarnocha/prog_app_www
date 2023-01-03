<?php
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

    require('PHPMailer/Exception.php');
    require('PHPMailer/PHPMailer.php');
    require('PHPMailer/SMTP.php');

    function PokazKontakt() {
        return ('
        <script src="js/kolorujtlo.js"></script>
        <link rel="stylesheet" href="css/form.css">
        <form name="formularz_kontaktowy" class="formularz_kontaktowy" action="contact.php" method="post">
            <label class="label_kontakt" for="input_email" >E-mail:</label><input id="input_email" type="email" name="email" value="" required="required"> <br>
            <label class="label_kontakt" for="input_imie_i_nazwisko" >Imię i nazwisko:</label><input id="input_imie_i_nazwisko" type="text" name="name" value="" required="required" pattern="(\p{L}+\s)(\p{L}+)"> <br>
            <label class="label_kontakt" for="input_temat" >Temat:</label><input id="input_temat" type="text" name="subject" value="" required="required" pattern="[\p{L}]{,1}"> <br>
            <label class="label_kontakt" for="input_wiadomosc" >Treść:</label><textarea id="input_wiadomosc" type="text" name="message" value="" required="required" pattern="[A-Za-z0-9]{1,}"></textarea><br>
            <div class="przyciski">
                <span id="przycisk_span_lewy">
                    <label class="przycisk_label_kontakt" for="przycisk_wyslij">Prześlij wiadomość:</label>
                    <button id="przycisk_wyslij" name="send" type="submit">Prześlij</button>
                </span>

                <span id="przycisk_span_prawy">
                    <label class="przycisk_label_kontakt" for="przycisk_wyczysc">Wyczyść pola:</label>
                    <button id="przycisk_wyczysc" name="wyczysc" type="button" onclick="wyczysc_inputy(formularz_kontaktowy)">Wyczyść</button>
                </span>
		    </div>
        </form>
        ');
    }
    

    function WyslijMailKontakt($nadawca, $nazwa_nadawcy, $odbiorca, $temat, $tresc) {
        $mail = new PHPMailer(true);
        $mail->isSMTP();

        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 465;
        $mail->SMTPSecure = 'ssl';
        $mail->SMTPAuth = true;

        $mail->Username = 'progappwwwmailer@gmail.com';
        $mail->Password = 'uatjsfqariuoqmex';
        $mail->CharSet = 'UTF-8';

        $mail->setLanguage('pl', 'PHPMailer/language/directory/');

        $mail->setFrom($nadawca, $nazwa_nadawcy);
        $mail->addAddress($odbiorca);
        $mail->addReplyTo($nadawca);
        $mail->isHTML(true);

        $mail->Subject = $temat;
        $mail->Body = $tresc;

        $mail->send();
    }

    if (isset($_POST["send"])) {
        WyslijMailKontakt($_POST["email"], $_POST["name"], 'progappwwwmailer@gmail.com', $_POST["subject"], $_POST["message"]);
        header('Location: ./index.php?idp=kontakt');
    }

    function PrzypomnijHaslo() {
        WyslijMailKontakt('progappwwwmailer@gmail.com', 'Przypomnienie hasla', 'progappwwwmailer@gmail.com', 'Przypomnienie hasla', '<center>Oto Twoje dane:<br/>Login: admin<br/>Haslo: admin');
    }

    function PokazPrzypomnijHaslo(){
        if (($_GET['idp'] == 'przypomnij_haslo')) {
            
            PrzypomnijHaslo();

            return ('
                <link rel="stylesheet" href="css/form.css">
                <div class="przypomnienie_hasla">
                    <h1 class="h1_przypomnienie">Na Twój adres e-mail zostały wysłane dane.</h1>
                    <div class="przyciski" style="display: flex; flex-direction: column; justify-content: center; text-align: center; width: fit-content;">
                        <button id="przycisk" style="width: 100%; margin: auto; margin-bottom: 10%;"><a href="?idp=admin">Powróć do logowania</a></button>
                        <button id="przycisk" style="width: 100%; margin: auto; "><a href="?idp=">Powróć na stronę główną</a></button>
                    </div>
                </div>
            ');
            
        }
    }
?>