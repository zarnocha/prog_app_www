<?php
    function OutdatedProducts() {
        require(dirname(__DIR__, 1). '/cfg.php');

        $current_date = date('Y/m/d h:i:s', time());

        $query = "SELECT * FROM product_list WHERE expiration_date < :current_date LIMIT 100";
        $sth = $dbh->prepare($query);
        $sth->bindValue(':current_date', $current_date);
        $sth->execute();
        $result = $sth->fetchAll();

        foreach($result as &$row) {
            $second_query = "UPDATE product_list SET availability=:availability WHERE id=:id LIMIT 100";
            $second_sth = $dbh->prepare($second_query);

            $second_sth->bindValue(':availability', '0');
            $id = $row['id'];
            $second_sth->bindValue(':id', $id);
            $second_sth->execute();
        }
    }

    function OutOfProducts() {
        require(dirname(__DIR__, 1). '/cfg.php');
        $query = "SELECT * FROM product_list WHERE quanity < 1 LIMIT 100";
        $sth = $dbh->prepare($query);
        $sth->execute();
        $result = $sth->fetchAll();

        foreach($result as &$row) {
            $second_query = "UPDATE product_list SET availability=:availability WHERE id=:id LIMIT 100";
            $second_sth = $dbh->prepare($second_query);
            $second_sth->bindValue(':availability', '0');
            $id = $row['id'];
            $second_sth->bindValue(':id', $id);
            $second_sth->execute();
        }
    }

    function ProductIsFine() {
        require(dirname(__DIR__, 1). '/cfg.php');

        $current_date = date('Y/m/d h:i:s', time());

        $query = "SELECT * FROM product_list WHERE expiration_date > :current_date AND quanity > 0 AND availability = 0  LIMIT 100";
        $sth = $dbh->prepare($query);
        $sth->bindValue(':current_date', $current_date);
        $sth->execute();
        $result = $sth->fetchAll();

        foreach($result as &$row) {
            $second_query = "UPDATE product_list SET availability=:availability WHERE id=:id LIMIT 100";
            $second_sth = $dbh->prepare($second_query);

            $second_sth->bindValue(':availability', '1');
            $id = $row['id'];
            $second_sth->bindValue(':id', $id);
            $second_sth->execute();
        }
    }
?>