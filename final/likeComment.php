<?php
    include("constants/loginCred.php");
    include("styles.php");
    $con = mysqli_connect(HOST_NAME,DB_USERNAME,DB_PASSWORD,DB_NAME) or die("There was a problem connecting to the database: ".  mysqli_connect_error());

    session_start();

    if (isset($_GET["coid"])){
        echo $_GET["coid"];

        $currentUser = $_SESSION['currentUser'];
        $currentdate = "now()";//date("Y-m-d");

        $sqlValues = '"' .  $currentUser['U_id'] . '","' .
                            $_GET["coid"] . '",' .
                            $currentdate  . ',"' . 
                            "1" . '"';
        $sqlInsertSub = "";
        $sqlPresent = "SELECT * FROM likecomment WHERE Co_id =".$_GET["coid"] . " AND `U_id`=" . $currentUser['U_id'] ;
        //echo $sqlPresent;
        if ($con->query($sqlPresent)->num_rows < 1){
              $sqlInsertSub = 'INSERT INTO `likecomment`(`U_id`, `Co_id`, `date`, `voteType`) 
                VALUES (' .$sqlValues . ');';
        } else {
              $sqlInsertSub = 'UPDATE `likecomment` SET `voteType`= 1 WHERE CO_id ='. $_GET["coid"].  ' AND `U_id`=' . $currentUser['U_id'] ;
        }
      
          echo $sqlPresent;
        if ($con->query($sqlInsertSub) == TRUE ){
            echo "Topic Added successfully";
               $currentSubTopic = "SELECT * FROM comment WHERE Co_id =".$_GET['coid'];
                // echo $currentSubTopic;
                $currentSubTopic = $con->query($currentSubTopic);
                $currentSubTopic->data_seek(0);
                $currentSubTopic = $currentSubTopic->fetch_assoc(); 
                header('Location: subtopic.php?sid='.$currentSubTopic["S_id"]);
           
        } else {
            echo "could not insert";
        }
        echo $sqlInsertSub;
    }
?>