<?php
    include("constants/loginCred.php");
    include("styles.php");
    $con = mysqli_connect(HOST_NAME,DB_USERNAME,DB_PASSWORD,DB_NAME) or die("There was a problem connecting to the database: ".  mysqli_connect_error());

    session_start();

    if (isset($_GET["uid"])){
        echo $_GET["uid"];
        $currentdate = 'now()';//(date("Y-m-d");
        $sqlValues = '"' . $_SESSION["currentUser"]["U_id"] . '","' .
                        $_GET["uid"] . '",' .
                        $currentdate  ;
    
        $sqlInsertSub = "INSERT INTO `follow`(`following_id`, `followed_id`, `date`)
                     VALUES (".$sqlValues.")" ;
        $checker =  'SELECT * FROM follow WHERE following_id = '. $_SESSION["currentUser"]["U_id"] . ' AND
                            followed_id=' . $_GET["uid"];
                            $noRows = $con->query($checker);
        if ($noRows->num_rows < 1){
            if ($con->query($sqlInsertSub) == TRUE ){
           // echo "Topic Added successfully";
           //echo $checker . $sqlInsertSub;
            header('Location: user_profile.php?uid='.$_GET["uid"]);
            } else {
            echo "could not insert";
            }
            echo $sqlInsertSub;
        }
                            
    } //else {
         header('Location: user_profile.php?uid='.$_GET["uid"]);
    //}
?>