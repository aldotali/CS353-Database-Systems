<?php
    define('HOST_NAME','localhost');   
    define('DB_USERNAME','root');
    define('DB_PASSWORD','');
    define('DB_NAME','forum');

    $con = mysqli_connect(HOST_NAME,DB_USERNAME,DB_PASSWORD,DB_NAME) or die("There was a problem connecting to the database: ".  mysqli_connect_error());
?>
