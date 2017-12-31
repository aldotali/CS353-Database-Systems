<?php
    include("constants/loginCred.php");
    include("styles.php");
    $con = mysqli_connect(HOST_NAME,DB_USERNAME,DB_PASSWORD,DB_NAME) or die("There was a problem connecting to the database: ".  mysqli_connect_error());

    session_start();
    

    $id = -1;
    if (isset($_GET['uid'])) {
        $id = $_GET['uid'];
    }else{
        $id = $_SESSION["currentUser"]['U_id'];
    }

    
    $userToshow = $con->query("SELECT * FROM user WHERE U_id = $id");
    $userToshow->data_seek(0);
    $singleUser = $userToshow->fetch_assoc();

    outputUserProfileHeader($singleUser);
    outputUserProfile($singleUser,$con);
?>








