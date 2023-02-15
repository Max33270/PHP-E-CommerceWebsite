<?php
function connect_BD() {
    $host     = "localhost";//Ip of database, in this case my host machine    
    $user     = "root";	//Username to use
    $pass     = "";//Password for that user
    $dbname   = "php_exam_db";//Name of the database
    return new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
}

?>