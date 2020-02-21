<?php

//connect.php
//MYSQL DB Details
define('MYSQL_USER', 'appylistadmin');
define('MYSQL_PASSWORD', '!@PAintman12');
define('MYSQL_HOST', 'mysql.applyist.nateboland.com');
define('MYSQL_DATABASE', 'appylist_apply');

//PDO Options
$pdoOptions = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false) ;

//Make Connection to MYSQL
try {
    $pdo = new PDO(
        "mysql:host=" . MYSQL_HOST . ";dbname=" . MYSQL_DATABASE,
        MYSQL_USER,
        MYSQL_PASSWORD,
        $pdoOptions
    );
}
catch (PDOException $e) { print $e->getMessage();

}

?>