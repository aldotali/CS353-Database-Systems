<?php
    include("constants/loginCred.php");
    include("styles.php");
    $con = mysqli_connect(HOST_NAME,DB_USERNAME,DB_PASSWORD,DB_NAME) or die("There was a problem connecting to the database: ".  mysqli_connect_error());

    session_start();

    if (isset($_GET["coid"])){
        echo $_GET["coid"];
        $sqlPresent = "SELECT * FROM `comment` WHERE `Co_id` =" .$_GET['coid'] . ";";
        $boolean = $con->query($sqlPresent);
        $rows = $boolean->num_rows;
        if ($boolean){
             echo "nothing";
             $boolean->data_seek(0);
            $currentSubTopic = $boolean->fetch_assoc(); 
             $sid =  $currentSubTopic["S_id"];
            $sqlInsertSub = "DELETE FROM `comment` WHERE `Co_id` =" .$_GET['coid'] . ";";
    
            if ($con->query($sqlInsertSub) == TRUE ){
                echo "Topic Added successfully";
            
                header('Location: subtopic.php?sid='.$sid);
            } else {
                echo "could not delete the comment !";
            }
            //echo $sqlInsertSub;
        }
    }
?>