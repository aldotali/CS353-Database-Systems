<?php
    include("constants/loginCred.php");
    include("styles.php");
    $con = mysqli_connect(HOST_NAME,DB_USERNAME,DB_PASSWORD,DB_NAME) or die("There was a problem connecting to the database: ".  mysqli_connect_error());

    session_start();

    if (isset($_GET["coid"])){
        //echo $_GET["coid"];

        $currentUser = $_SESSION['currentUser'];
        $currentdate = date("Y-m-d H:i:s");
        $cuid= $currentUser['U_id'];
        $ccoid = $_GET["coid"];


        $sqlValues = '"' .  $currentUser['U_id'] . '","' .
                            $_GET["coid"] . '",' .
                            $currentdate ;

        $sqlIsPresent = "SELECT * FROM reportcomment WHERE Co_id ='$ccoid'";
        echo $con->query($sqlIsPresent)->num_rows . "\n";
        if ($con->query($sqlIsPresent)->num_rows < 1){
            echo "eee";
             $sqlInsertSub = "INSERT INTO reportcomment (U_id, Co_id, date) 
            VALUES ('$cuid', '$ccoid', '$currentdate');";
            if ($con->query($sqlInsertSub) == TRUE ){
                echo "Topic Added successfully";
                 $currentSubTopic = "SELECT * FROM comment WHERE Co_id =".$_GET['coid'];
                // echo $currentSubTopic;
                $currentSubTopic = $con->query($currentSubTopic);
                $currentSubTopic->data_seek(0);
                $currentSubTopic = $currentSubTopic->fetch_assoc(); 
                header('Location: subtopic.php?sid='.$currentSubTopic["S_id"]);
            // header('Location: regular_homePG.php');
                //header('Location: regular_homePG.php');
            } else {
                echo "could not report :/";
                echo $con->error;

            }
        }
        $currentSubTopic = "SELECT * FROM comment WHERE Co_id =".$_GET['coid'];
        // echo $currentSubTopic;
        $currentSubTopic = $con->query($currentSubTopic);
        $currentSubTopic->data_seek(0);
        $currentSubTopic = $currentSubTopic->fetch_assoc(); 
        header('Location: subtopic.php?sid='.$currentSubTopic["S_id"]);
        // header('Location: subtopic.php?sid='.$_SESSION["returnFromAddComment"]);
        //echo $sqlInsertSub;
    }
?>