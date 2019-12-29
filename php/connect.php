<?php

//connect.php
//MYSQL DB Details
define('MYSQL_USER', 'apply');
define('MYSQL_PASSWORD', 'P@$$word');
define('MYSQL_HOST', 'localhost:3308');
define('MYSQL_DATABASE', 'applyist');

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