<?php
    $hostDB = "db";  
    $nameDB = "futbol_db";
    $user = "samu";
    $pwDB = 'Udenar12345@';

    $hostPDO = "mysql:host=$hostDB; dbname=$nameDB";
    $myPDO = new PDO($hostPDO, $user, $pwDB);
?>