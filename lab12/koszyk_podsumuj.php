<?php

    function PodsumowanieKoszyka_plik() {
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

?>