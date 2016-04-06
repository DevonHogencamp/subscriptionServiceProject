<?php
    try {
        $dbh = new PDO('mysql:host=localhost; dbname=EDMMusic', 'root', 'root');
    }

    catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
?>
